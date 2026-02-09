function setupSearchFilter (
  searchInputSelector,
  containerSelector,
  targetElementSelector
) {
  const searchInput = document.querySelector(searchInputSelector)
  const container = document.querySelector(containerSelector)
  const filterDemoButton = document.getElementById('filterDemo')

  if (searchInput) {
    let currentFilter = '' // Can be '', 'broker', or 'prop'

    function filterElements () {
      const searchQuery = searchInput.value.toLowerCase()
      const elements = container.querySelectorAll(targetElementSelector)

      elements.forEach(element => {
        const textContent = element.textContent.toLowerCase()
        const matchesSearch = textContent.includes(searchQuery)
        const hasFreeDemo = element.dataset.free_demo === '1'

        // Determine if the element should be shown based on the current filter
        const matchesFilter =
          (currentFilter === 'freeDemo' && hasFreeDemo) ||
          currentFilter === ''

        if (matchesSearch && matchesFilter) {
          element.style.display = '' // Show
        } else {
          element.style.display = 'none' // Hide
        }
      })
    }

    // Attach the keyup event listener to the search input
    searchInput.addEventListener('keydown', function (event) {
      if (event.keyCode === 13) {
        event.preventDefault() // Prevent form submission on Enter
        return false // Return false just as an extra measure
      }
    })
    searchInput.addEventListener('keyup', filterElements)

    // Attach click event listeners to the filter buttons
    filterDemoButton.addEventListener('click', e => {
      currentFilter = currentFilter === 'freeDemo' ? '' : 'freeDemo' // Toggle filter
      filterDemoButton.classList.toggle('active', currentFilter === 'freeDemo')
      filterElements() // Apply filters
    })
  }
}

// Usage
setupSearchFilter('#partners-search', '.partners_archive', '.tl-grey-mask')

function randomizeChildren (containerSelector) {
  let containers = document.querySelectorAll(containerSelector)
  if (containers) {
    containers.forEach(container => {
      let items = Array.from(container.children)

      // Separate featured and non-featured items
      let featuredItems = items.filter(
        item => item.getAttribute('data-featured') === '1'
      )
      let nonFeaturedItems = items.filter(
        item => item.getAttribute('data-featured') !== '1'
      )

      featuredItems.reverse();
      // Append featured items first
      featuredItems.forEach(item => container.appendChild(item))
      

      // Randomize and append non-featured items
      while (nonFeaturedItems.length) {
        container.appendChild(
          nonFeaturedItems.splice(
            Math.floor(Math.random() * nonFeaturedItems.length),
            1
          )[0]
        )
      }
    })
  }
}

randomizeChildren('.partners_archive .posts_archive-template.affiliates')
