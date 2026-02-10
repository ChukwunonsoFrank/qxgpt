<?php

namespace App\Jobs;

use App\Models\Bot;
use App\Models\Referral;
use App\Models\Trade;
use App\Models\User;
use App\Notifications\BotExpired;
use App\Notifications\CommissionEarned;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class RefreshActiveBots implements ShouldQueue
{
  use Queueable;

  /**
   * Create a new job instance.
   */
  public function __construct()
  {
    //
  }

  /**
   * Execute the job.
   */
  public function handle(): void
  {
    /**
     * Fetch all bots with the status of 'active' and batch process.
     */
    Bot::with(["user:id,demo_balance,live_balance,referred_by,referral_code,name"])
      ->where("status", "active")
      ->chunk(100, function ($bots) {
        foreach ($bots as $bot) {
          $checkpoint = intval($bot["timer_checkpoint"]);
          $endDate = intval($bot["end"]);
          $now = now()->getTimestampMs();

          /**
           * Check if the trade duration has been exhausted and expire
           * the bot automatically.
           */
          if ($now > $endDate) {
            $this->expireBot($bot);
          }

          /**
           * Get the current datetime and compare this with the timer_checkpoint
           * of each bot.
           */
          if ($now > $checkpoint) {
            $this->updateBotAndCreateTrade($bot, $checkpoint);
          }
        }
      });
  }

  private function expireBot($bot): void
  {
    try {
      $accountType = $bot["account_type"];
      $amount = $bot["amount"];
      $profit = $bot["profit"];
      $fee = $this->calculateFees($profit);
      $netProfit = $profit - $fee;

      if ($accountType === "demo") {
        DB::transaction(function () use ($bot, $amount, $netProfit) {
          // Lock bot record
          $lockedBot = Bot::where("id", "=", $bot["id"], "and")
            ->lockForUpdate()
            ->first();

          if (!$lockedBot || $lockedBot->status !== "active") {
            return; // Already processed
          }

          // Lock user record
          $user = User::where("id", "=", $bot->user->id, "and")
            ->lockForUpdate()
            ->first();

          if (!$user) {
            throw new \Exception("User not found");
          }

          $currentBalance = $user->demo_balance;
          $newBalance = $currentBalance + $amount + $netProfit;

          $lockedBot->status = "expired";
          $lockedBot->save();

          $user->demo_balance = $newBalance;
          $user->save();
        });
      }

      if ($accountType === "live") {
        DB::transaction(function () use ($bot, $amount, $netProfit) {
          // Lock bot record
          $lockedBot = Bot::where("id", "=", $bot["id"], "and")
            ->lockForUpdate()
            ->first();

          if (!$lockedBot || $lockedBot->status !== "active") {
            return; // Already processed
          }

          // Lock user record
          $user = User::where("id", "=", $bot->user->id, "and")
            ->lockForUpdate()
            ->first();

          if (!$user) {
            throw new \Exception("User not found");
          }

          $currentBalance = $user->live_balance;
          $newBalance = $currentBalance + $amount + $netProfit;

          $lockedBot->status = "expired";
          $lockedBot->save();

          $user->live_balance = $newBalance;
          $user->save();

          // Process referral payouts within the same transaction
          if ($user->referred_by !== null) {
            $this->processReferralPayouts(
              $netProfit,
              $user->referral_code,
              $user->referred_by,
              $user->name,
            );
          }

          if (! $user->lockout_ends_in) {
            $user->is_lockout_active = true;
            $user->lockout_ends_in = strval(
              now()
                ->addMinutes(45)
                ->getTimestampMs()
            );
            $user->save();
          } else {
            $user->is_lockout_active = true;
            $user->lockout_two_ends_in = strval(
              now()
                ->addMinutes(45)
                ->getTimestampMs()
            );
            $user->save();
          }
        });
      }

      $user = User::where("id", "=", $bot->user->id, "and")->first();

      // Send email to notify user when bot has expired
      // $user->notify(
      //   new BotExpired(
      //     $user['name'],
      //   ),
      // );
    } catch (\Exception $e) {
      // Log error instead of flash session (this is a queued job)
      logger()->error("Bot expiration failed: " . $e->getMessage(), [
        'bot_id' => $bot["id"],
      ]);
    }
  }

  private function updateBotAndCreateTrade($bot, $checkpoint): void
  {
    try {
      $assetToTrade = $this->generateAssetToTrade();
      $newCheckpoint = Carbon::createFromTimestampMs($checkpoint)
        ->addMinutes(5)
        ->addSeconds(8)
        ->getTimestampMs();
      $profitPosition = $bot["profit_position"];
      $profit = json_decode($bot["profit_values"])[$profitPosition];
      $updatedTotalProfit = $this->normalizeAmount($bot["profit"]) + $profit;

      DB::transaction(function () use (
        $bot,
        $assetToTrade,
        $newCheckpoint,
        $updatedTotalProfit,
        $profitPosition,
        $profit,
      ) {
        // Lock bot record
        $lockedBot = Bot::where("id", "=", $bot["id"], "and")
          ->lockForUpdate()
          ->first();

        if (!$lockedBot || $lockedBot->status !== "active") {
          return; // Already processed or expired
        }

        Trade::create([
          "user_id" => $bot["user_id"],
          "bot_id" => $bot["id"],
          "asset" => $bot["asset"],
          "asset_image_url" => $bot["asset_image_url"],
          "account_type" => $bot["account_type"],
          "profit" => $this->serializeAmount($profit),
          "sentiment" => $bot["sentiment"],
        ]);

        $lockedBot->asset = $assetToTrade["display_name"];
        $lockedBot->asset_class = $assetToTrade["asset_class"];
        $lockedBot->asset_ticker = $assetToTrade["ticker_symbol"];
        $lockedBot->asset_image_url = $assetToTrade["image_url"];
        $lockedBot->sentiment = $assetToTrade["sentiment"];
        $lockedBot->timer_checkpoint = strval($newCheckpoint);
        $lockedBot->profit = $this->serializeAmount($updatedTotalProfit);
        $lockedBot->profit_position = $profitPosition + 1;
        $lockedBot->save();
      });
    } catch (\Exception $e) {
      logger()->error("Bot update failed: " . $e->getMessage(), [
        'bot_id' => $bot["id"],
      ]);
    }
  }

  public function normalizeAmount(int $amount): int|float
  {
    return $amount / 100;
  }

  public function serializeAmount(float $amount): int
  {
    return $amount * 100;
  }

  public function calculateFees(int $profit): int
  {
    $fee = intval(round(($profit * 5) / 100));
    return $fee;
  }

  /**
   * Generate new assets.
   */
  public function generateAssetToTrade()
  {
    $weekendTradingPair = [
      [
        "name" => "BTC/USDT",
        "percentage" => "91%",
        "assetType" => "crypto",
        "symbol" => "BTCUSDT",
        "image" => "btc.svg",
      ],
      [
        "name" => "ETH/USDT",
        "percentage" => "95%",
        "assetType" => "crypto",
        "symbol" => "ETHUSDT",
        "image" => "eth.svg",
      ],
      [
        "name" => "LTC/USDT",
        "percentage" => "95%",
        "assetType" => "crypto",
        "symbol" => "LTCUSDT",
        "image" => "ltc.svg",
      ],
      [
        "name" => "SOL/USDT",
        "percentage" => "98%",
        "assetType" => "crypto",
        "symbol" => "SOLUSDT",
        "image" => "sol.svg",
      ],
      [
        "name" => "XRP/USDT",
        "percentage" => "93%",
        "assetType" => "crypto",
        "symbol" => "XRPUSDT",
        "image" => "xrp.svg",
      ],
      [
        "name" => "DOGE/USDT",
        "percentage" => "83%",
        "assetType" => "crypto",
        "symbol" => "DOGEUSDT",
        "image" => "doge.svg",
      ],
      [
        "name" => "BCH/USDT",
        "percentage" => "89%",
        "assetType" => "crypto",
        "symbol" => "BCHUSDT",
        "image" => "bch.svg",
      ],
      [
        "name" => "DAI/USDT",
        "percentage" => "97%",
        "assetType" => "crypto",
        "symbol" => "DAIUSDT",
        "image" => "dai.svg",
      ],
      [
        "name" => "BNB/USDT",
        "percentage" => "87%",
        "assetType" => "crypto",
        "symbol" => "BNBUSDT",
        "image" => "bnb.svg",
      ],
      [
        "name" => "ADA/USDT",
        "percentage" => "93%",
        "assetType" => "crypto",
        "symbol" => "ADAUSDT",
        "image" => "ada.svg",
      ],
      [
        "name" => "AVAX/USDT",
        "percentage" => "99%",
        "assetType" => "crypto",
        "symbol" => "AVAXUSDT",
        "image" => "avax.svg",
      ],
      [
        "name" => "TRX/USDT",
        "percentage" => "90%",
        "assetType" => "crypto",
        "symbol" => "TRXUSDT",
        "image" => "trx.svg",
      ],
      [
        "name" => "MATIC/USDT",
        "percentage" => "91%",
        "assetType" => "crypto",
        "symbol" => "MATICUSDT",
        "image" => "matic.svg",
      ],
      [
        "name" => "ATOM/USDT",
        "percentage" => "96%",
        "assetType" => "crypto",
        "symbol" => "ATOMUSDT",
        "image" => "atom.svg",
      ],
      [
        "name" => "LINK/USDT",
        "percentage" => "87%",
        "assetType" => "crypto",
        "symbol" => "LINKUSDT",
        "image" => "link.svg",
      ],
      [
        "name" => "DASH/USDT",
        "percentage" => "87%",
        "assetType" => "crypto",
        "symbol" => "DASHUSDT",
        "image" => "dash.svg",
      ],
      [
        "name" => "XLM/USDT",
        "percentage" => "93%",
        "assetType" => "crypto",
        "symbol" => "XLMUSDT",
        "image" => "xlm.svg",
      ],
      [
        "name" => "NEO/USDT",
        "percentage" => "93%",
        "assetType" => "crypto",
        "symbol" => "NEOUSDT",
        "image" => "neo.svg",
      ],
      [
        "name" => "BAT/USDT",
        "percentage" => "83%",
        "assetType" => "crypto",
        "symbol" => "BATUSDT",
        "image" => "bat.svg",
      ],
      [
        "name" => "ETC/USDT",
        "percentage" => "86%",
        "assetType" => "crypto",
        "symbol" => "ETCUSDT",
        "image" => "etc.svg",
      ],
      [
        "name" => "ZEC/USDT",
        "percentage" => "94%",
        "assetType" => "crypto",
        "symbol" => "ZECUSDT",
        "image" => "zec.svg",
      ],
      [
        "name" => "ONT/USDT",
        "percentage" => "96%",
        "assetType" => "crypto",
        "symbol" => "ONTUSDT",
        "image" => "ont.svg",
      ],
      [
        "name" => "STX/USDT",
        "percentage" => "96%",
        "assetType" => "crypto",
        "symbol" => "STXUSDT",
        "image" => "stx.svg",
      ],
      [
        "name" => "MKR/USDT",
        "percentage" => "95%",
        "assetType" => "crypto",
        "symbol" => "MKRUSDT",
        "image" => "mkr.svg",
      ],
      [
        "name" => "AAVE/USDT",
        "percentage" => "90%",
        "assetType" => "crypto",
        "symbol" => "AAVEUSDT",
        "image" => "aave.svg",
      ],
      [
        "name" => "XMR/USDT",
        "percentage" => "99%",
        "assetType" => "crypto",
        "symbol" => "XMRUSDT",
        "image" => "xmr.svg",
      ],
      [
        "name" => "YFI/USDT",
        "percentage" => "95%",
        "assetType" => "crypto",
        "symbol" => "YFIUSDT",
        "image" => "yfi.svg",
      ],
    ];

    $weekdayTradingPair = [
      [
        "name" => "EUR/USD",
        "percentage" => "99%",
        "assetType" => "forex",
        "symbol" => "EURUSD",
        "image" => "EURUSD_OTC.svg",
      ],
      [
        "name" => "AUD/CAD",
        "percentage" => "96%",
        "assetType" => "forex",
        "symbol" => "AUDCAD",
        "image" => "AUDCAD.svg",
      ],
      [
        "name" => "GBP/USD",
        "percentage" => "85%",
        "assetType" => "forex",
        "symbol" => "GBPUSD",
        "image" => "GBPUSD_OTC.svg",
      ],
      [
        "name" => "GBP/NZD",
        "percentage" => "89%",
        "assetType" => "forex",
        "symbol" => "GBPNZD",
        "image" => "GBPNZD.svg",
      ],
      [
        "name" => "USD/JPY",
        "percentage" => "97%",
        "assetType" => "forex",
        "symbol" => "USDJPY",
        "image" => "USDJPY_OTC.svg",
      ],
      [
        "name" => "EUR/GBP",
        "percentage" => "95%",
        "assetType" => "forex",
        "symbol" => "EURGBP",
        "image" => "EURGBP.svg",
      ],
      [
        "name" => "GBP/CHF",
        "percentage" => "90%",
        "assetType" => "forex",
        "symbol" => "GBPCHF",
        "image" => "GBPCHF.svg",
      ],
      [
        "name" => "GBP/CAD",
        "percentage" => "88%",
        "assetType" => "forex",
        "symbol" => "GBPCAD",
        "image" => "GBPCAD.svg",
      ],
      [
        "name" => "NASDAQ",
        "percentage" => "92%",
        "assetType" => "forex",
        "symbol" => "NQ",
        "image" => "NQ.svg",
      ],
      [
        "name" => "AUD/JPY",
        "percentage" => "93%",
        "assetType" => "forex",
        "symbol" => "AUDJPY",
        "image" => "AUDJPY.svg",
      ],
      [
        "name" => "CAD/CHF",
        "percentage" => "77%",
        "assetType" => "forex",
        "symbol" => "CADCHF",
        "image" => "CADCHF.svg",
      ],
      [
        "name" => "CAD/JPY",
        "percentage" => "85%",
        "assetType" => "forex",
        "symbol" => "CADJPY",
        "image" => "CADJPY.svg",
      ],
      [
        "name" => "EUR/AUD",
        "percentage" => "97%",
        "assetType" => "forex",
        "symbol" => "EURAUD",
        "image" => "EURAUD.svg",
      ],
      [
        "name" => "EUR/JPY",
        "percentage" => "91%",
        "assetType" => "forex",
        "symbol" => "EURJPY",
        "image" => "EURJPY.svg",
      ],
      [
        "name" => "EUR/CAD",
        "percentage" => "99%",
        "assetType" => "forex",
        "symbol" => "EURCAD",
        "image" => "EURCAD.svg",
      ],
      [
        "name" => "GPB/JPY",
        "percentage" => "83%",
        "assetType" => "forex",
        "symbol" => "GBPJPY",
        "image" => "GBPJPY.svg",
      ],
      [
        "name" => "NZD/CAD",
        "percentage" => "90%",
        "assetType" => "forex",
        "symbol" => "NZDCAD",
        "image" => "NZDCAD.svg",
      ],
      [
        "name" => "NZD/CHF",
        "percentage" => "98%",
        "assetType" => "forex",
        "symbol" => "NZDCHF",
        "image" => "NZDCHF.svg",
      ],
      [
        "name" => "NZD/JPY",
        "percentage" => "95%",
        "assetType" => "forex",
        "symbol" => "NZDJPY",
        "image" => "NZDJPY.svg",
      ],
      [
        "name" => "USD/MXN",
        "percentage" => "95%",
        "assetType" => "forex",
        "symbol" => "USDMXN",
        "image" => "USDMXN.svg",
      ],
      [
        "name" => "USD/SGD",
        "percentage" => "98%",
        "assetType" => "forex",
        "symbol" => "USDSGD",
        "image" => "USDSGD.svg",
      ],
      [
        "name" => "NZD/USD",
        "percentage" => "96%",
        "assetType" => "forex",
        "symbol" => "NZDUSD",
        "image" => "NZDUSD_OTC.svg",
      ],
      [
        "name" => "USD/CHF",
        "percentage" => "91%",
        "assetType" => "forex",
        "symbol" => "USDCHF",
        "image" => "USDCHF_OTC.svg",
      ],
      [
        "name" => "AUD/CHF",
        "percentage" => "96%",
        "assetType" => "forex",
        "symbol" => "AUDCHF",
        "image" => "AUDCHF.svg",
      ],
      [
        "name" => "CHF/JPY",
        "percentage" => "99%",
        "assetType" => "forex",
        "symbol" => "CHFJPY",
        "image" => "CHFJPY.svg",
      ],
      [
        "name" => "BTC/USDT",
        "percentage" => "91%",
        "assetType" => "crypto",
        "symbol" => "BTCUSDT",
        "image" => "btc.svg",
      ],
      [
        "name" => "ETH/USDT",
        "percentage" => "95%",
        "assetType" => "crypto",
        "symbol" => "ETHUSDT",
        "image" => "eth.svg",
      ],
      [
        "name" => "LTC/USDT",
        "percentage" => "95%",
        "assetType" => "crypto",
        "symbol" => "LTCUSDT",
        "image" => "ltc.svg",
      ],
      [
        "name" => "SOL/USDT",
        "percentage" => "98%",
        "assetType" => "crypto",
        "symbol" => "SOLUSDT",
        "image" => "sol.svg",
      ],
      [
        "name" => "XRP/USDT",
        "percentage" => "93%",
        "assetType" => "crypto",
        "symbol" => "XRPUSDT",
        "image" => "xrp.svg",
      ],
      [
        "name" => "DOGE/USDT",
        "percentage" => "83%",
        "assetType" => "crypto",
        "symbol" => "DOGEUSDT",
        "image" => "doge.svg",
      ],
      [
        "name" => "BCH/USDT",
        "percentage" => "89%",
        "assetType" => "crypto",
        "symbol" => "BCHUSDT",
        "image" => "bch.svg",
      ],
      [
        "name" => "DAI/USDT",
        "percentage" => "97%",
        "assetType" => "crypto",
        "symbol" => "DAIUSDT",
        "image" => "dai.svg",
      ],
      [
        "name" => "BNB/USDT",
        "percentage" => "87%",
        "assetType" => "crypto",
        "symbol" => "BNBUSDT",
        "image" => "bnb.svg",
      ],
      [
        "name" => "ADA/USDT",
        "percentage" => "93%",
        "assetType" => "crypto",
        "symbol" => "ADAUSDT",
        "image" => "ada.svg",
      ],
      [
        "name" => "AVAX/USDT",
        "percentage" => "99%",
        "assetType" => "crypto",
        "symbol" => "AVAXUSDT",
        "image" => "avax.svg",
      ],
      [
        "name" => "TRX/USDT",
        "percentage" => "90%",
        "assetType" => "crypto",
        "symbol" => "TRXUSDT",
        "image" => "trx.svg",
      ],
      [
        "name" => "MATIC/USDT",
        "percentage" => "91%",
        "assetType" => "crypto",
        "symbol" => "MATICUSDT",
        "image" => "matic.svg",
      ],
      [
        "name" => "ATOM/USDT",
        "percentage" => "96%",
        "assetType" => "crypto",
        "symbol" => "ATOMUSDT",
        "image" => "atom.svg",
      ],
      [
        "name" => "LINK/USDT",
        "percentage" => "87%",
        "assetType" => "crypto",
        "symbol" => "LINKUSDT",
        "image" => "link.svg",
      ],
      [
        "name" => "DASH/USDT",
        "percentage" => "87%",
        "assetType" => "crypto",
        "symbol" => "DASHUSDT",
        "image" => "dash.svg",
      ],
      [
        "name" => "XLM/USDT",
        "percentage" => "93%",
        "assetType" => "crypto",
        "symbol" => "XLMUSDT",
        "image" => "xlm.svg",
      ],
      [
        "name" => "NEO/USDT",
        "percentage" => "93%",
        "assetType" => "crypto",
        "symbol" => "NEOUSDT",
        "image" => "neo.svg",
      ],
      [
        "name" => "BAT/USDT",
        "percentage" => "83%",
        "assetType" => "crypto",
        "symbol" => "BATUSDT",
        "image" => "bat.svg",
      ],
      [
        "name" => "ETC/USDT",
        "percentage" => "86%",
        "assetType" => "crypto",
        "symbol" => "ETCUSDT",
        "image" => "etc.svg",
      ],
      [
        "name" => "ZEC/USDT",
        "percentage" => "94%",
        "assetType" => "crypto",
        "symbol" => "ZECUSDT",
        "image" => "zec.svg",
      ],
      [
        "name" => "ONT/USDT",
        "percentage" => "96%",
        "assetType" => "crypto",
        "symbol" => "ONTUSDT",
        "image" => "ont.svg",
      ],
      [
        "name" => "STX/USDT",
        "percentage" => "96%",
        "assetType" => "crypto",
        "symbol" => "STXUSDT",
        "image" => "stx.svg",
      ],
      [
        "name" => "MKR/USDT",
        "percentage" => "95%",
        "assetType" => "crypto",
        "symbol" => "MKRUSDT",
        "image" => "mkr.svg",
      ],
      [
        "name" => "AAVE/USDT",
        "percentage" => "90%",
        "assetType" => "crypto",
        "symbol" => "AAVEUSDT",
        "image" => "aave.svg",
      ],
      [
        "name" => "XMR/USDT",
        "percentage" => "99%",
        "assetType" => "crypto",
        "symbol" => "XMRUSDT",
        "image" => "xmr.svg",
      ],
      [
        "name" => "YFI/USDT",
        "percentage" => "95%",
        "assetType" => "crypto",
        "symbol" => "YFIUSDT",
        "image" => "yfi.svg",
      ],
    ];

    $randomSeed = mt_rand(1, 20);

    $sentiment = $randomSeed % 2 === 0 ? "BUY" : "SELL";

    if (now()->isWeekday()) {
      $asset = rand(0, count($weekdayTradingPair) - 1);
      return [
        "ticker_symbol" => $weekdayTradingPair[$asset]["symbol"],
        "display_name" => $weekdayTradingPair[$asset]["name"],
        "asset_class" => $weekdayTradingPair[$asset]["assetType"],
        "image_url" =>
        "assets/icons/dashboard/" .
          $weekdayTradingPair[$asset]["image"],
        "sentiment" => $sentiment,
      ];
    } else {
      $asset = rand(0, count($weekendTradingPair) - 1);
      return [
        "ticker_symbol" => $weekendTradingPair[$asset]["symbol"],
        "display_name" => $weekendTradingPair[$asset]["name"],
        "asset_class" => $weekendTradingPair[$asset]["assetType"],
        "image_url" =>
        "assets/icons/dashboard/" .
          $weekendTradingPair[$asset]["image"],
        "sentiment" => $sentiment,
      ];
    }
  }

  public function processReferralPayouts(
    float $robotProfit,
    string $referralCode,
    string $referredBy,
    string $botOwnerName,
  ) {
    $firstUpline = null;
    $secondUpline = null;
    $thirdUpline = null;
    $level = 0;
    $currentUpline = User::where("referral_code", $referredBy)->first();

    if ($currentUpline !== null) {
      $firstUpline = $currentUpline;
      $level = 1;
      $currentUpline = User::where(
        "referral_code",
        $currentUpline["referred_by"],
      )->first();
      if ($currentUpline !== null) {
        $secondUpline = $firstUpline;
        $firstUpline = $currentUpline;
        $level = 2;
        $currentUpline = User::where(
          "referral_code",
          $currentUpline["referred_by"],
        )->first();
        if ($currentUpline !== null) {
          $thirdUpline = $secondUpline;
          $secondUpline = $firstUpline;
          $firstUpline = $currentUpline;
          $level = 3;
        }
      }
    }

    if ($level === 1) {
      // Lock and fetch the first upline user
      $lockedFirstUpline = User::where("id", "=", $firstUpline["id"], "and")
        ->lockForUpdate()
        ->first();

      if (!$lockedFirstUpline) {
        throw new \Exception("First upline user not found");
      }

      /**
       * Top upline commission(12% on trade profits)
       */
      $commission = intval(round($robotProfit * (12 / 100)));
      $newFirstUplineBalance = $lockedFirstUpline->live_balance + $commission;

      $lockedFirstUpline->live_balance = $newFirstUplineBalance;
      $lockedFirstUpline->save();

      Referral::create([
        "user_id" => $lockedFirstUpline->id,
        "referral_code" => $referralCode,
        "amount" => $commission,
        "level" => "1",
      ]);

      $lockedFirstUpline->notify(
        new CommissionEarned(
          $lockedFirstUpline->name,
          $botOwnerName,
          strval($this->normalizeAmount($commission)),
          "trade profit",
        ),
      );
    }

    if ($level === 2) {
      // Lock both upline users to prevent race conditions
      $lockedSecondUpline = User::where("id", "=", $secondUpline["id"], "and")
        ->lockForUpdate()
        ->first();

      if (!$lockedSecondUpline) {
        throw new \Exception("Second upline user not found");
      }

      $lockedFirstUpline = User::where("id", "=", $firstUpline["id"], "and")
        ->lockForUpdate()
        ->first();

      if (!$lockedFirstUpline) {
        throw new \Exception("First upline user not found");
      }

      /**
       * Middle upline commission(12% on trade profits)
       */
      $commission = intval(round($robotProfit * (12 / 100)));
      $newSecondUplineBalance = $lockedSecondUpline->live_balance + $commission;

      $lockedSecondUpline->live_balance = $newSecondUplineBalance;
      $lockedSecondUpline->save();

      Referral::create([
        "user_id" => $lockedSecondUpline->id,
        "referral_code" => $referralCode,
        "amount" => $commission,
        "level" => "1",
      ]);

      $lockedSecondUpline->notify(
        new CommissionEarned(
          $lockedSecondUpline->name,
          $botOwnerName,
          strval($this->normalizeAmount($commission)),
          "trade profit",
        ),
      );

      /**
       * First upline commission(8% on trade profits)
       */
      $commission = intval(round($robotProfit * (8 / 100)));
      $newFirstUplineBalance = $lockedFirstUpline->live_balance + $commission;

      $lockedFirstUpline->live_balance = $newFirstUplineBalance;
      $lockedFirstUpline->save();

      Referral::create([
        "user_id" => $lockedFirstUpline->id,
        "referral_code" => $referralCode,
        "amount" => $commission,
        "level" => "2",
      ]);

      $lockedFirstUpline->notify(
        new CommissionEarned(
          $lockedFirstUpline->name,
          $botOwnerName,
          strval($this->normalizeAmount($commission)),
          "trade profit",
        ),
      );
    }

    if ($level === 3) {
      // Lock all upline users to prevent race conditions
      $lockedThirdUpline = User::where("id", "=", $thirdUpline["id"], "and")
        ->lockForUpdate()
        ->first();

      if (!$lockedThirdUpline) {
        throw new \Exception("Third upline user not found");
      }

      $lockedSecondUpline = User::where("id", "=", $secondUpline["id"], "and")
        ->lockForUpdate()
        ->first();

      if (!$lockedSecondUpline) {
        throw new \Exception("Second upline user not found");
      }

      $lockedFirstUpline = User::where("id", "=", $firstUpline["id"], "and")
        ->lockForUpdate()
        ->first();

      if (!$lockedFirstUpline) {
        throw new \Exception("First upline user not found");
      }

      /**
       * Top upline commission(4% on trade profits)
       */
      $commission = intval(round($robotProfit * (4 / 100)));
      $newFirstUplineBalance = $lockedFirstUpline->live_balance + $commission;

      $lockedFirstUpline->live_balance = $newFirstUplineBalance;
      $lockedFirstUpline->save();

      Referral::create([
        "user_id" => $lockedFirstUpline->id,
        "referral_code" => $referralCode,
        "amount" => $commission,
        "level" => "3",
      ]);

      $lockedFirstUpline->notify(
        new CommissionEarned(
          $lockedFirstUpline->name,
          $botOwnerName,
          strval($this->normalizeAmount($commission)),
          "trade profit",
        ),
      );

      /**
       * Middle upline commission(8% on trade profits)
       */
      $commission = intval(round($robotProfit * (8 / 100)));
      $newSecondUplineBalance = $lockedSecondUpline->live_balance + $commission;

      $lockedSecondUpline->live_balance = $newSecondUplineBalance;
      $lockedSecondUpline->save();

      Referral::create([
        "user_id" => $lockedSecondUpline->id,
        "referral_code" => $referralCode,
        "amount" => $commission,
        "level" => "2",
      ]);

      $lockedSecondUpline->notify(
        new CommissionEarned(
          $lockedSecondUpline->name,
          $botOwnerName,
          strval($this->normalizeAmount($commission)),
          "trade profit",
        ),
      );

      /**
       * Last upline commission(12% on trade profits)
       */
      $commission = intval(round($robotProfit * (12 / 100)));
      $newThirdUplineBalance = $lockedThirdUpline->live_balance + $commission;

      $lockedThirdUpline->live_balance = $newThirdUplineBalance;
      $lockedThirdUpline->save();

      Referral::create([
        "user_id" => $lockedThirdUpline->id,
        "referral_code" => $referralCode,
        "amount" => $commission,
        "level" => "1",
      ]);

      $lockedSecondUpline->notify(
        new CommissionEarned(
          $lockedSecondUpline->name,
          $botOwnerName,
          strval($this->normalizeAmount($commission)),
          "trade profit",
        ),
      );
    }
  }
}
