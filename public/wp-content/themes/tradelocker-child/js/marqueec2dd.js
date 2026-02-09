jQuery(document).ready(function($) {
    console.log('smarquee');
    $('.infinite-marquee').each(function() {
      var $container   = $(this);
      var $inner       = $container.find('.marquee-inner');
      // Store the original HTML of all items so we can reset when resizing
      var originalHTML = $inner.html();
  
      function initializeMarquee() {
        $inner.removeClass('animate');
        $inner.css('animation', 'none');
        // Reset to the original set of items
        $inner.html(originalHTML);
  
        var containerWidth = $container.width();
        var innerWidth     = $inner.width();
  
        // Keep appending the same set of items until the inner width >= twice the container width
        while ( innerWidth < containerWidth * 2 ) {
          $inner.append( originalHTML );
          innerWidth = $inner.width();
        }
  
        // Once we have a wide enough strip, add the animate class
        $inner.addClass('animate');
  
        // Calculate duration based on total width: larger width = longer animation
        // Adjust divisor (e.g., 100) to speed up or slow down the scroll
        var durationSeconds = innerWidth / 100;
        $inner.css( 'animation-duration', durationSeconds + 's' );
      }
  
      initializeMarquee();
  
      // Reinitialize whenever the window is resized
      $(window).on('resize', function() {
        initializeMarquee();
      });
    });
  });