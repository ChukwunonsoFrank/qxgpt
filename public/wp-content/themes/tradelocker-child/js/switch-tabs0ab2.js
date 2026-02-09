function setupTabSwitcher (containerSelector, tabSelector, contentSelector) {
  // Use querySelector to get the specific container
  const container = document.querySelector(containerSelector)

  if (!container) {
    // console.error('Container not found:', containerSelector)
    return
  }

  // Now select tabs and content only within this container
  const tabSelectors = container.querySelectorAll(tabSelector)
  const contentSelectors = container.querySelectorAll(contentSelector)

  tabSelectors.forEach(tab => {
    tab.addEventListener('click', function () {
      // Remove 'active' class from all tabs within the same container
      tabSelectors.forEach(tab => {
        tab.classList.remove('active')
      })

      // Get the data-name attribute of the clicked tab
      const name = this.getAttribute('data-name')

      // Remove 'show' class from all content elements within the container
      contentSelectors.forEach(content => {
        content.classList.remove('show')
      })

      // Find and show the matching content within the container
      const matchingContent = Array.from(contentSelectors).find(
        content => content.getAttribute('data-name') === name
      )
      if (matchingContent) {
        matchingContent.classList.add('show')
        this.classList.add('active')
      }
    })
  })
}

// Usage within jQuery's ready function
jQuery(document).ready(function ($) {
  setupTabSwitcher('#integration', '.tl-tabs .tab', '.tl-content')
  setupTabSwitcher('#marketing', '.tl-tabs .tab', '.tl-content')
  setupTabSwitcher('#guides', '.tl-tabs .tab', '.tl-content')
  setupTabSwitcher('#announcements', '.tl-tabs .tab', '.tl-content')
  setupTabSwitcher('#how-to', '.tl-tabs .tab', '.tl-content')
  setupTabSwitcher('#language-tabs', '.tl-tabs .tab', '.tl-content')
  setupTabSwitcher('#language-tabs-mobile', '.tl-tabs .tab', '.tl-content')
})
