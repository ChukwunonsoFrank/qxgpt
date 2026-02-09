// Script for the slider elementor widget
;(function () {
  $(document).ready(function () {
    var walkthrough = {
      index: 0,
      direction: 'next',
      nextScreen: function () {
        this.direction = 'next'
        this.index = (this.index + 1) % (this.indexMax() + 1)
        return this.updateScreen()
      },
      prevScreen: function () {
        this.direction = 'prev'
        this.index =
          (this.index - 1 + this.indexMax() + 1) % (this.indexMax() + 1)
        return this.updateScreen()
      },
      updateScreen: function () {
        this.reset()
        this.goTo(this.index)
        return this.setBtns()
      },
      setBtns: function () {
        var $nextBtn = $('.next-screen'),
          $prevBtn = $('.prev-screen')

        // Buttons are always enabled in continuous loop
        $nextBtn.prop('disabled', false)
        $prevBtn.prop('disabled', false)
      },
      goTo: function (index) {
        var $screens = $('.screen')
        var $dots = $('.dot')
        var $parent = $screens.parent()

        // Remove any existing animation classes
        $screens.removeClass(
          'next-enter next-enter-active next-exit next-exit-active prev-enter prev-enter-active prev-exit prev-exit-active'
        )

        // Add the appropriate animation classes based on the direction
        if (this.direction === 'next') {
          $parent.addClass('next')
          $parent.removeClass('prev')
          $screens.eq(index).addClass('next-enter')
          setTimeout(() => {
            $screens.eq(index).addClass('next-enter-active')
          }, 20)

          $screens
            .eq((index - 1 + this.indexMax() + 1) % (this.indexMax() + 1))
            .addClass('next-exit')
          setTimeout(() => {
            $screens
              .eq((index - 1 + this.indexMax() + 1) % (this.indexMax() + 1))
              .addClass('next-exit-active')
          }, 20)
        } else {
          $parent.addClass('prev')
          $parent.removeClass('next')

          $screens.eq(index).addClass('prev-enter')
          setTimeout(() => {
            $screens.eq(index).addClass('prev-enter-active')
          }, 20)

          $screens.eq((index + 1) % (this.indexMax() + 1)).addClass('prev-exit')
          setTimeout(() => {
            $screens
              .eq((index + 1) % (this.indexMax() + 1))
              .addClass('prev-exit-active')
          }, 20)
        }

        $dots.removeClass('active')
        $dots.eq(index).addClass('active')
      },
      reset: function () {
        $('.screen').removeClass('active prev next')
        $('.dot').removeClass('active')
      },
      indexMax: function () {
        return $('.screen').length - 1
      },
      closeModal: function () {
        $('.walkthrough, .shade').removeClass('reveal')
        return setTimeout(() => {
          $('.walkthrough, .shade').removeClass('show')
          this.index = 0
          return this.updateScreen()
        }, 200)
      },
      openModal: function () {
        $('.walkthrough, .shade').addClass('show')
        setTimeout(() => {
          return $('.walkthrough, .shade').addClass('reveal')
        }, 200)
        return this.updateScreen()
      }
    }

    $('.next-screen').click(function () {
      return walkthrough.nextScreen()
    })

    $('.prev-screen').click(function () {
      return walkthrough.prevScreen()
    })

    $('.close').click(function () {
      return walkthrough.closeModal()
    })

    $('.open-walkthrough').click(function () {
      return walkthrough.openModal()
    })

    walkthrough.openModal()

    // Optionally use arrow keys to navigate walkthrough
    return $(document).keydown(function (e) {
      switch (e.which) {
        case 37: // left
          walkthrough.prevScreen()
          break
        case 38: // up
          walkthrough.openModal()
          break
        case 39: // right
          walkthrough.nextScreen()
          break
        case 40: // down
          walkthrough.closeModal()
          break
        default:
          return
      }
      e.preventDefault()
    })
  })
}.call(this))
