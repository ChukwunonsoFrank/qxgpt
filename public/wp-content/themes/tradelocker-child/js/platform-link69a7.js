document.addEventListener('DOMContentLoaded', function () {
  let platformLinks = document.querySelectorAll('.platform-link')

  platformLinks.forEach(function (el) {
    let link = el.querySelector('.elementor-button-link')
    redirectUser(link)
  })
})

function redirectUser (link) {
  var userAgent = navigator.userAgent || navigator.vendor || window.opera

  // Windows Phone must come first because its UA string includes "Android"
  if (/windows phone/i.test(userAgent)) {
    // Redirect to Web Platform for Windows Phone
    link.href = 'https://live.tradelocker.com/'
  } else if (/android/i.test(userAgent)) {
    // Redirect to Google Play Store for Android devices
    link.href =
      'https://play.google.com/store/apps/details?id=com.tradelocker.mobile'
  } else if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
    // Redirect to App Store for iOS devices
    link.href = 'https://apps.apple.com/uy/app/tradelocker/id6447196449'
  }

  // For Desktop and other devices, redirect to Web Platform
  else {
    link.href = 'https://live.tradelocker.com/'
  }
}
