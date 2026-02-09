// Usage example: initialize the accordion for specific elements
$(document).ready(function () {
  initAccordion(
    '#feature-releases',
    '.accordion .title',
    '.accordion .description'
  )
  initAccordion(
    '#directory-posts',
    '.posts_toc-title',
    '.posts_category-list ul'
  )
})

function initAccordion (accordionSelector, headerSelector, contentSelector) {
  // Hide all content initially

  var isFeatureReleases = $(accordionSelector).attr('id') === 'feature-releases'

  // Hide all content except the first one if it's 'feature-releases'
  if (isFeatureReleases) {
    $(accordionSelector).find(contentSelector).not(':first').hide()
  } else {
    $(accordionSelector).find(contentSelector).hide()
  }

  // Set up the click event on the headers
  $(accordionSelector)
    .find(headerSelector)
    .click(function () {
      var content = $(this).next(contentSelector)

      if (content.is(':visible')) {
        // Collapse the content if it is currently visible
        content.slideUp()
      } else {
        // Collapse other open content, then expand the clicked one
        $(accordionSelector).find(contentSelector).slideUp()
        content.slideDown()
      }
    })
}
