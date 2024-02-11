$(document).ready(function(){
    let modalMenu = document.querySelector('.hamburger-menu')
    let callModalButton = document.querySelector('.call-modal-menu')
  
    modal = false;
    
    callModalButton.addEventListener('click',function() {
            if(!modal) {
                modalMenu.classList.add('open')
                document.body.style.overflow = 'hidden'
                callModalButton.querySelector('i').innerText = 'close'
                modal = true
                console.log(modal)
            } else {
                modalMenu.classList.remove('open')
                document.body.style.overflow = 'auto'
                callModalButton.querySelector('i').innerText = 'menu'
                modal = false
                console.log(modal)
            }
    })

       

    modalMenu.addEventListener('click', function(e) {
      if(e.target.getAttribute('class') == 'hamburger-menu open') {
        modalMenu.classList.remove('open')
        callModalButton.querySelector('i').innerText = 'menu'
        document.body.style.overflow = 'auto'
    }
    })

    const accordionHeaders = document.querySelectorAll('.accordion-header');
    accordionHeaders.forEach((accordionHeader) => {
   
      accordionHeader.addEventListener('click', (e) => {
        if(window.screen.width < 600) {
        accordionHeader.classList.toggle('active')
  
        const accordionContent = accordionHeader.nextElementSibling;
        if (accordionContent.classList.value == 'accordion-content open') {
          accordionContent.classList.remove('open')
        } else {
          accordionHeaders.forEach((header) => {
            header.classList.remove('active')
            header.nextElementSibling.classList.remove('open')
          });
          accordionHeader.classList.toggle('active')
          accordionContent.classList.add('open')
        }
      }
      });

    });

    //switch
    let switchButtons = document.querySelectorAll('.switch-box_charts button')
    switchButtons.forEach((btn) => {
        btn.addEventListener('click', (e) => {
          switchButtons.forEach((item) => {
            item.classList.remove('active')
          })
          btn.classList.add('active')
        })
    })
    })
    