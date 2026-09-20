
$('.clickSearch').click(function(){$('.searchPup').fadeToggle('fast')})
$('.clickDrop').click(function(){$('.dropdownCon').slideToggle('fast')})


    $('.faq-content').on('hidden.bs.collapse', toggleIcon);
    $('.faq-content').on('shown.bs.collapse', toggleIcon);


	function toggleIcon(e) {
        $(e.target)
            .prev('.card-header')
            .find(".more-less")
            .toggleClass('fa-plus fa-minus');
    }
    $('.accordianMenu').on('hidden.bs.collapse', toggleIcon);
    $('.accordianMenu').on('shown.bs.collapse', toggleIcon);


$(function() {
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('#back-top').fadeIn();
        } else {
            $('#back-top').fadeOut();
        }
    });
    $('#back-top a').click(function() {
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });
    $('.triBar').click(function() {
        $('body').addClass('showNav');
        return false;
    });
    $('.navOverlay, .hideNav').click(function() {
        $('body').removeClass('showNav');
        return false;
    });


});



addEventListener("load", () => {
    var lastY = scrollY;
    const MAX_SCROLL_DELTA = 5, NAV_HEIGHT = navbarEl.offsetHeight;
    addEventListener("scroll", () => {
       const delta = scrollY - lastY;
       if (Math.abs(delta) > MAX_SCROLL_DELTA) {
           navbarEl.classList.toggle("hiddeNavBar", delta > 0 && scrollY > NAV_HEIGHT);
           lastY = scrollY;
       }
    });
});


$(document).ready(function(){
  $(".mycity").click(function(){
    $("#city").toggle();
  });
});


$(document).ready(function(){
     $('.radioBtn').click(function(){
         
         var target = $(this).data('target-id');
         $('.item-div').hide(); 
         $('.item-div[data-target="'+target+'"]').show();  
     }); 

}); 


//**************owl-slider********************


$(document).ready(function() {
    var owl = $('#loop');
    owl.owlCarousel({
        stagePadding: 0,
        margin: 0,
        nav: true,
        loop: false,
		dots: false,
        autoplay: true,
        autoplayHoverPause: true,
        navText : ["<i class='icon-angleLeft'></i>","<i class='icon-angleRight'></i>"],
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 1
            },

            600: {
                items: 1
            },
            768: {
                items: 1
            },
            980: {
                items: 1
            },
            1152: {
                items: 1
            },
            1240: {
                items:1
            }
        }
    });
});



$(document).ready(function() {
    var owl = $('#loop2');
    owl.owlCarousel({
        stagePadding: 0,
        margin: 0,
        nav: true,
        loop: false,
		dots: false,
        autoplay: true,
        autoplayHoverPause: true,
        navText : ["<i class='icon-angleLeft'></i>","<i class='icon-angleRight'></i>"],
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 1
            },

            600: {
                items: 1
            },
            768: {
                items: 1
            },
            980: {
                items: 1
            },
            1152: {
                items: 1
            },
            1240: {
                items:1
            }
        }
    });
});



$(document).ready(function() {
    var owl = $('#loop3');
    owl.owlCarousel({
        stagePadding: 0,
        margin: 30,
        nav: true,
        loop: false,
		dots: false,
        autoplay: true,
        autoplayHoverPause: true,
        navText : ["<i class='icon-angleLeft'></i>","<i class='icon-angleRight'></i>"],
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 1
            },

            600: {
                items: 1
            },
            768: {
                items: 1
            },
            980: {
                items: 1
            },
            1152: {
                items: 2
            },
            1240: {
                items:2
            }
        }
    });
});

 






 