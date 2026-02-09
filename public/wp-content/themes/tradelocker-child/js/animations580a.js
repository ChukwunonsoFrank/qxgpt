$(document).ready(function () {
  function checkAndAnimate (containerSelector, childSelector, delay) {
    var container = $(containerSelector)
    if (!container.length) {
      return
    }
    if (isElementInViewport(container)) {
      container.find(childSelector).each(function (index, element) {
        setTimeout(function () {
          $(element).addClass('animate')
        }, delay * index) // 100ms delay for each child
      })
    }
  }

  function checkAndAnimateSingle (element) {
    if (isElementInViewport(element)) {
      $(element).addClass('animate')
    }
  }

  function getCookie (name) {
    const value = `; ${document.cookie}`
    const parts = value.split(`; ${name}=`)
    if (parts.length === 2) return parts.pop().split(';').shift()
  }

  function animatePath (path) {
    if (path.length) {
      var length = path[0].getTotalLength()
      // Clear any previous transition
      path.css({
        transition: 'none',
        WebkitTransition: 'none'
      })
      // Set up the starting positions
      path.css({
        strokeDasharray: length + ' ' + length,
        strokeDashoffset: length
      })
      // Trigger a layout so styles are calculated & the browser
      path[0].getBoundingClientRect()
      // Define our transition
      path.css({
        transition: 'stroke-dashoffset 3s linear',
        WebkitTransition: 'stroke-dashoffset 3s linear',
        opacity: 1
      })
      // Go!
      path.css('strokeDashoffset', '0')
    }
  }

  function animateMask (maskRect) {
    if (maskRect.length) {
      maskRect.attr('width', '0')
      maskRect[0].getBoundingClientRect()
      maskRect.css({
        transition: 'width 3s cubic-bezier(.32,.35,.63,.83)',
        WebkitTransition: 'width 3s cubic-bezier(.32,.35,.63,.83)'
      })

      maskRect.attr('width', '100%')
    }
  }

  function animateCircleAlongPath (circle, path) {
    if (circle.length) {
      var circleAnimationDuration = 2999 // Duration in milliseconds
      var startTime = null
      var length = path[0].getTotalLength()

      function step (timestamp) {
        if (!startTime) startTime = timestamp
        var elapsed = timestamp - startTime
        var progress = Math.min(elapsed / circleAnimationDuration, 1) // Ensure progress does not exceed 1
        var point = path[0].getPointAtLength(progress * length)

        circle.attr('cx', point.x)
        circle.attr('cy', point.y)
        circle.css({ opacity: 1 })

        if (progress < 1) {
          requestAnimationFrame(step)
        }
      }

      requestAnimationFrame(step)
    }
  }

  function checkAndAnimatePathAndFill (containerSelector, pathElement) {
    var path = $(pathElement)
    var container = $(containerSelector)
    var maskRect = $('#fillMask rect') // Select the mask rectangle directly
    var circle = $('.chart-area circle')

    if (circle.length > 0) {
      if (isElementInViewport(container) && !container.hasClass('animated')) {
        animatePath(path)
        animateMask(maskRect)
        animateCircleAlongPath(circle, path)
        container.addClass('animated')
      }
    }
  }

  function isElementInViewport (el) {
    const rect = el[0].getBoundingClientRect()
    const windowHeight =
      window.innerHeight || document.documentElement.clientHeight

    // Check if the top of the element is within the bottom 40% of the viewport
    const threshold = windowHeight // 60% from the top or 40% from the bottom

    return (
      rect.top <= threshold &&
      rect.bottom >= 0 &&
      rect.left >= 0 &&
      rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    )
  }

  $(window).on('load scroll', function () {
    checkAndAnimate('.roadmap-grid', '.roadmap-feature', 100)
    checkAndAnimate(
      '#auditorium-cards .elementor-widget-wrap.elementor-element-populated',
      '.fadeInUp',
      150
    )
    checkAndAnimate(
      '#bots-cards .elementor-widget-wrap.elementor-element-populated',
      '.fadeInUp',
      150
    )
    $('.tl-strong-testimonials.masonry .testimonial-bubble').each(function () {
      checkAndAnimateSingle($(this))
    })
    checkAndAnimate('.section-difference', '.testimonial-bubble', 400)
    // checkAndAnimate('#code-your-own .title-block', '.title-block_child', 1000)
    checkAndAnimate('.ts-chatbox', '.ts-chat', 800)
    checkAndAnimatePathAndFill('.chart-area', '.chart-area #area path.st0')
  })
})
