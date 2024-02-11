  $(function() {
    $('#myCollapsible').collapse({
        toggle: false
      })
      $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });

    let accordionBtns = document.querySelectorAll('button[data-toggle="collapse"]')
    accordionBtns.forEach((item) => {
    item.addEventListener('click',function(e) {
        accordionBtns.forEach((itemm) => {
            itemm.querySelector('img').setAttribute('src','./images/showmenu.png')
        })
        if(e.target.getAttribute('aria-expanded') == 'true') {
            e.target.querySelector('img').setAttribute('src','./images/showmenu.png')
        } else {
            e.target.querySelector('img').setAttribute('src','./images/hide.png')
        }
    })
    })
     
  })
 