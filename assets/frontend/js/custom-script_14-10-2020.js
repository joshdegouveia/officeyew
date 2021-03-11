$('#ofc-item-slider').owlCarousel({
    loop: true,
    margin: 10,
    responsiveClass: true,
    responsive: {
        0: {
            items: 1,
            nav: true,
            dots: false
        },
        768: {
            items: 2,
            nav: true,
            dots: false,
            margin: 20
        },
        1024: {
            items: 4,
            nav: true,
            dots: false,
            loop: false,
            margin: 30
        }
    }
});

if ($('#back-to-top').length) {
    var scrollTrigger = 100, // px
        backToTop = function() {
            var scrollTop = $(window).scrollTop();
            if (scrollTop > scrollTrigger) {
                $('#back-to-top').addClass('show');
            } else {
                $('#back-to-top').removeClass('show');
            }
        };
    backToTop();
    $(window).on('scroll', function() {
        backToTop();
    });
    $('#back-to-top').on('click', function(e) {
        e.preventDefault();
        $('html,body').animate({
            scrollTop: 0
        }, 700);
    });
}


  screen.width
$( document ).ready(function() {
    window.addEventListener("resize", onresize);

    var screen_width = screen.width;   
      
    if(screen_width >= 800){
        $('.left-container li').first().addClass('active');
        $('.main-container .tabcontent').first().css('display', 'block');
        $('.main-container').addClass('web-view');
        $('.main-container a').hide();
        $('.acc_set').removeClass('mobile-view');
    }else{
        $('.acc_set').addClass('mobile-view');
        $('.main-container a').show();
        $('.main-container').removeClass('web-view');

        //accordian
        $(".acc_set > a").on("click", function() {
            if ($(this).hasClass("active")) {
              $(this).removeClass("active");
              $(this)
                .siblings(".acc_content")
                .slideUp(200);
              $(".acc_set > a i")
                .removeClass("fa-minus")
                .addClass("fa-plus");
            } else {
              $(".acc_set > a i")
                .removeClass("fa-minus")
                .addClass("fa-plus");
              $(this)
                .find("i")
                .removeClass("fa-plus")
                .addClass("fa-minus");
              $(".acc_set > a").removeClass("active");
              $(this).addClass("active");
              $(".acc_content").slideUp(200);
              $(this)
                .siblings(".acc_content")
                .slideDown(200);
            }
        });
    }
    console.log( screen.width );

    
});

function onresize(){
    var screen_width = screen.width;   
    console.log( screen.width );
      
    if(screen_width >= 800){
        $('.left-container li').first().addClass('active');
        $('.main-container .tabcontent').first().css('display', 'block');        
        $('.main-container').addClass('web-view');
        $('.main-container a').hide();
        $('.acc_set').removeClass('mobile-view');
        //$('.web-view').css('height', '380px');
    }else{
        //$('.main-container').removeAttr('style');
        //$('.main-container').css('height', 'auto');
        $('.acc_set').addClass('mobile-view');
        $('.main-container a').show();
        $('.main-container').removeClass('web-view');

        //accordian
        $(".acc_set > a").on("click", function() {
            if ($(this).hasClass("active")) {
              $(this).removeClass("active");
              $(this)
                .siblings(".acc_content")
                .slideUp(200);
              $(".acc_set > a i")
                .removeClass("fa-minus")
                .addClass("fa-plus");
            } else {
              $(".acc_set > a i")
                .removeClass("fa-minus")
                .addClass("fa-plus");
              $(this)
                .find("i")
                .removeClass("fa-plus")
                .addClass("fa-minus");
              $(".acc_set > a").removeClass("active");
              $(this).addClass("active");
              $(".acc_content").slideUp(200);
              $(this)
                .siblings(".acc_content")
                .slideDown(200);
            }
        });
    }
}