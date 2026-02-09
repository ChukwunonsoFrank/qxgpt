jQuery(document).ready(function ($) {
  $('.projects.grid > div').on('click', function () {
    // Get the data-name attribute value of the clicked project name
    var projectName = $(this).attr('data-name')

    // Remove active class from all projects and project names
    $('.project.grid, .projects.grid > div').removeClass('active')

    // Add the active class to the corresponding project
    $('.project.grid[data-name="' + projectName + '"]').addClass('active')

    // Add the active class to the clicked project name
    $(this).addClass('active')
  })

  $('.site-navigation-toggle').on('click', function () {
    let toggle = $(this).parent().toggleClass('elementor-active')
    let dropdown = $('.site-navigation-drop')
    if (toggle.hasClass('elementor-active')) {
      dropdown.attr('aria-hidden', false)
    } else {
      dropdown.attr('aria-hidden', true)
    }
  })

  $('.site-navigation-drop li').on('click', function () {
    let menuItem = $(this)
    menuItem.toggleClass('elementor-active')
    let menuItems = $(this).find('.sub-menu')
    if (menuItem.hasClass('elementor-active')) {
      menuItems.slideDown(300)
    } else {
      menuItems.slideUp(300)
    }
  })

  $('li.current-page').on('click', function () {
    let toggle = $(this).toggleClass('elementor-active');
    let dropdown = $('.submenu-navigation-drop');
    if (toggle.hasClass('elementor-active')) {
      dropdown.slideDown(300)
      dropdown.attr('aria-hidden', 'false');
    } else {
      dropdown.slideUp(300)
      dropdown.attr('aria-hidden', 'true');
    }
  });
})
