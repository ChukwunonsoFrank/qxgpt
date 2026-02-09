jQuery(document).ready(function ($) {
  // Loop over every bar whose id starts with "campaign-bar-"
  $("[id^='campaign-bar-']").each(function () {
    var $bar      = $(this);
    var barId     = $bar.attr('id');               // e.g. "campaign-bar-0"
    var cookieKey = barId + "Closed";              // e.g. "campaign-bar-0Closed"
    var $close    = $bar.find(".campaign-close");  // assumes each bar has a close button with class "campaign-close"

    // Only show this bar if its cookie isn't set
    if (Cookies.get(cookieKey) !== "true") {
      $bar.show();
    }

    // Wire up the close button to hide + set cookie
    $close.on("click", function () {
      $bar.slideUp(300);
      Cookies.set(cookieKey, "true", { expires: 7 });
    });
  });
});