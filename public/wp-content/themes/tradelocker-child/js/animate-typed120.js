let codeYourOwn = document.querySelector('#code-your-own')
let macdCode = document.querySelector('#macd-code')
let noCoding = document.querySelector('#no-coding-skills')
let automateStrategy = document.querySelector('#automate-strategy')
let openExtensible = document.querySelector('#open-extensible')
let studioRSI = document.querySelector('#studio-rsi')
let extensible = document.querySelector('#extensible')

if (codeYourOwn) {
  new TypeIt('#code-your-own h1', {
    speed: 60,
    loop: false,
    cursor: false,
    startDelay: 500
  }).go()
  new TypeIt('#code-your-own h4', {
    speed: 30,
    loop: false,
    cursor: false,
    startDelay: 2100
  }).go()
}

// Initialize TypeIt and animate typing
if (studioRSI) {
  const typeitInstance = new TypeIt('#studio-rsi', {
    speed: 1, // Typing speed (ms per character)
    cursor: false, // Show cursor
    waitUntilVisible: true, // Start when visible
    afterStep: function (step, instance) {
      // Re-highlight code after each step
      Prism.highlightElement(document.getElementById('studio-rsi'))
    }
  }).go() // Start animation
}

// Initialize TypeIt and animate typing
if (extensible) {
  const typeitInstance = new TypeIt('#extensible', {
    speed: 1, // Typing speed (ms per character)
    cursor: false, // Show cursor
    waitUntilVisible: true, // Start when visible
    afterStep: function (step, instance) {
      // Re-highlight code after each step
      Prism.highlightElement(document.getElementById('extensible'))
    }
  }).go() // Start animation
}

// if (macdCode) {
//   const typeitInstance = new TypeIt('#macd-code', {
//     speed: 1, // Typing speed (ms per character)
//     cursor: false, // Show cursor
//     waitUntilVisible: true, // Start when visible
//     startDelay: 1000,
//     afterStep: function (step, instance) {
//       // Re-highlight code after each step
//       Prism.highlightElement(document.getElementById('macd-code'))
//     }
//   }).go() // Start animation
// }

if (noCoding) {
  new TypeIt('#no-coding-skills', {
    speed: 1,
    loop: false,
    cursor: false,
    waitUntilVisible: true,
    startDelay: 200
  }).go()
}

if (automateStrategy) {
  new TypeIt('#automate-strategy', {
    speed: 1,
    loop: false,
    cursor: false,
    waitUntilVisible: true,
    startDelay: 200
  }).go()
}

if (openExtensible) {
  new TypeIt('#open-extensible .code-content', {
    speed: 1,
    loop: false,
    cursor: false,
    waitUntilVisible: true,
    startDelay: 0
  }).go()
}
