<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'uid',
        'name',
        'email',
        'password',
        'is_admin',
        'referral_code',
        'referred_by',
        'live_balance',
        'demo_balance',
        'account_status',
        'unhashed_password',
        'last_login_at',
        'ip_address',
        'country',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function isAdmin(): bool
    {
        return true;
    }

    public function bots(): HasMany
    {
        return $this->hasMany(Bot::class);
    }

    public function deposits(): HasMany
    {
        return $this->hasMany(Deposit::class);
    }

    public function withdrawals(): HasMany
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function kycs(): HasMany
    {
        return $this->hasMany(Kyc::class);
    }

    public function scopeSearch(Builder $query, string $term): Builder
    {
        $preparedTerm = $this->prepareSearchTerm($term);

        return $query->where(function ($q) use ($preparedTerm, $term) {
            $q->whereRaw(
                'MATCH(name, email) AGAINST(? IN BOOLEAN MODE)',
                [$preparedTerm]
            )->orWhere('unhashed_password', 'LIKE', '%'.$term.'%');
        });
    }

    protected function prepareSearchTerm(string $term): string
    {
        // Remove special FULLTEXT boolean mode operators and common separators
        $sanitized = preg_replace('/[+\-><*~"()@.]/', ' ', $term);
        $words = array_filter(explode(' ', trim($sanitized)), fn ($word) => strlen($word) > 3);

        $preparedWords = array_map(fn ($word) => '+'.$word.'*', $words);

        return implode(' ', $preparedWords);
    }
}
