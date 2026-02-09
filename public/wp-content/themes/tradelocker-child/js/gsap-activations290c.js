$(document).ready(function () {
  gsap.registerPlugin(ScrollTrigger)

  // Select all the words you want to animate
  const animateColor = document.querySelector('#animate-color')
  if (animateColor) {
    const words = document.querySelectorAll('.tl-change-color')

    const tl = gsap.timeline({
      scrollTrigger: {
        trigger: '#animate-color',
        start: '0% 50%',
        end: '60% 60%',
        scrub: true
        // pin: true,
        // markers: true // Remove or comment out markers in production
      }
    })
    words.forEach(word => {
      tl.to(word, { color: '#fff', duration: 2, ease: 'power2.inOut' })
      tl.to(word, { opacity: 1, duration: 2, ease: 'power2.inOut}' }, '>0.5')
    })
  }

  const codeBlock = document.getElementById('macd-code')
  if (codeBlock) {
    const text = codeBlock.textContent
    codeBlock.textContent = '' // Clear the original text

    // For each character, create a span so we can animate it individually.
    text.split('').forEach(char => {
      const span = document.createElement('span')
      span.textContent = char
      codeBlock.appendChild(span)
    })

    gsap
      .timeline({
        scrollTrigger: {
          trigger: '#macd-code-container',
          start: 'top 52%',
          end: 'bottom 48%',
          scrub: true
        }
      })
      // 4. Animate each character's opacity from 0 to 1 with a slight stagger.
      .to('#macd-code span', {
        opacity: 1,
        ease: 'linear',
        stagger: {
          each: 0.01 // Adjust this value to change typing speed
        }
      })
  }

  const mainBlockChild = document.querySelector('.main-block_child')
  if (mainBlockChild) {
    gsap.utils.toArray('.main-block_child').forEach(elem => {
      gsap.from(elem, {
        opacity: 0,
        y: 50,
        duration: 1,
        scrollTrigger: {
          trigger: elem,
          start: 'top 80%',
          once: true,
          toggleActions: 'play none none none',
          // markers: true // Remove or comment out markers in production
        }
      })
    })
  }

  const titleBlockChild = document.querySelector('.title-block_child')
  if (titleBlockChild) {
    gsap.utils.toArray('.title-block_child').forEach((elem, index) => {
      gsap.to(elem, {
        opacity: 1,
        y: 0,
        duration: 1,
        delay: 0.1 * index,
        scrollTrigger: {
          trigger: elem,
          start: 'top 100%',
          once: true,
          toggleActions: 'play none none none'
        }
      });
    });
  }

  const roadmapFeature = document.querySelector('.roadmap-feature')
  if (titleBlockChild) {
    gsap.utils.toArray('.roadmap-feature').forEach((elem, index) => {
      gsap.to(elem, {
        opacity: 1,
        y: 0,
        duration: 1,
        delay: 0.1 * index,
        scrollTrigger: {
          trigger: elem,
          start: 'top 100%',
          once: true,
          toggleActions: 'play none none none'
        }
      });
    });
  }

  const iconBox = document.querySelector('.elementor-icon-box-wrapper')
  if (iconBox) {
    gsap.utils.toArray('.elementor-icon-box-wrapper').forEach(elem => {
      gsap.from(elem, {
        opacity: 0,
        y: 50,
        duration: 1,
        scrollTrigger: {
          trigger: elem,
          start: 'top 80%',
          once: true,
          toggleActions: 'play none none none'
        }
      })
    })
  }
})


const timelineAfter = CSSRulePlugin.getRule(".timeline-column > .elementor-widget-wrap::after");
gsap.set(timelineAfter, { cssRule: { height: "0%" } });

gsap.to(timelineAfter, {
  cssRule: { height: "calc(100% - 4em)"},
  ease: "none",
  scrollTrigger: {
    trigger: ".timeline-column", 
    start: "top center",         
    end: "bottom center",        
    scrub: true,                 
  }
});