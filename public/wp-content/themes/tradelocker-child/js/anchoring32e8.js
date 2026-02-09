jQuery(document).ready(function ($) {
  // Table of Contents Functionalities
  addIdsToHeadings('.posts_single-article h2, .posts_single-article h3')
  enableSmoothScrolling('.posts_headlines-list a')
  enableSmoothScrolling('.glossary_alphabet a')
  enableScrollSpy('.posts_headlines-list', 150)

  document
    .querySelectorAll('.single-news main .features a')
    .forEach(function (link) {
      link.setAttribute('target', '_blank')
    })
})

// Function to add IDs to headings
function addIdsToHeadings (selector) {
  $(selector).each(function (index) {
    // Check if the element has innerHTML and is not just whitespace
    if ($(this).html().trim().length > 0) {
      var id = 'heading-' + index
      $(this).attr('id', id)

      var anchor = $('<a/>', {
        href: '#' + id,
        class: 'heading-anchor'
      })

      $(this).append(anchor)
    }
  })
}

// Function to enable smooth scrolling
function enableSmoothScrolling (selector) {
  $(selector).on('click', function (event) {
    // Prevent the default click action
    event.preventDefault()

    // Get the target element using the href attribute of the clicked link
    var target = $($(this).attr('href'))

    // Check if the target element exists on the page
    if (target.length) {
      // Scroll smoothly to the target element
      $('html, body').animate(
        {
          // Subtract additional pixels for fixed headers or adjustments
          scrollTop: target.offset().top - 50
        },
        {
          duration: 1000, // 1 second
          // Easing function for the animation (default is 'swing')
          easing: 'swing'
        }
      )
    }
  })
}

// Function to enable ScrollSpy functionality
function enableScrollSpy (menuSelector, offset) {
  var menuItems = $(menuSelector).find('a')
  var scrollItems = menuItems.map(function () {
    var item = $($(this).attr('href'))
    if (item.length) {
      return item
    }
  })

  $(window).scroll(function () {
    var fromTop = $(this).scrollTop() + offset

    // Find the currently scrolled-to heading
    var cur = scrollItems.map(function () {
      if ($(this).offset().top < fromTop) return this
    })

    // Get the ID of the current element
    cur = cur[cur.length - 1]
    var id = cur && cur.length ? cur[0].id : ''

    // Set/remove active class
    menuItems
      .removeClass('active')
      .filter("[href='#" + id + "']")
      .addClass('active')
  })
}

function scrollToHash () {
  var hash = window.location.hash
  if (hash) {
    var target = $(hash)
    if (target.length) {
      $('html, body').animate(
        {
          // Subtract additional pixels for fixed headers or adjustments
          scrollTop: target.offset().top - 50
        },
        {
          duration: 1000, // 1 second
          // Easing function for the animation (default is 'swing')
          easing: 'swing'
        }
      )
    }
  }
}
