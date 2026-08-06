function readMore() {
    var $el, $ps, $up, totalHeight;

    $(".sclub-members-items .button").click(function() {

        totalHeight = 0

        $el = $(this);
        $p  = $el.parent();
        $up = $p.parent();
        $ps = $up.find("p:not('.read-more')");
        $up.addClass("active");

        // measure how tall inside should be by adding together heights of all inside paragraphs (except read-more paragraph)
        $ps.each(function() {
            totalHeight += $(this).outerHeight();
        });

        $up
            .css({
                // Set height to prevent instant jumpdown when max height is removed
                "height": $up.height(),
                "max-height": 9999
            })
            .animate({
                "height": totalHeight
            });

        // fade out read-more
        $p.fadeOut();

        // prevent jump-down
        return false;

    });
}

jQuery(document).ready(function ($) {
    $('ul.nav li.dropdown').hover(function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(50).fadeIn(100);
    }, function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(50).fadeOut(100);
    });

    $(".lang-switcher .current-lang").click(function (e) {
        e.preventDefault();
    });

    var to_top_options = {"scroll_offset":"100","icon_opacity":"50","style":"icon","icon_type":"dashicons-arrow-up-alt2","icon_color":"#ffffff","icon_bg_color":"#000000","icon_size":"32","border_radius":"5","image":"https:\/\/slidstvo.webvatra.top\/wp-content\/plugins\/to-top\/admin\/images\/default.png","image_width":"65","image_alt":"","location":"bottom-right","margin_x":"20","margin_y":"20","show_on_admin":"0","enable_autohide":"0","autohide_time":"2","enable_hide_small_device":"0","small_device_max_width":"640","reset":"0"};
    (function($) {
        "use strict";
        $(function() {
            var container = $("#to_top_scrollup").css({
                'opacity': 0
            });
            var data = to_top_options;

            var mouse_over = false;
            var hideEventID = 0;

            var fnHide = function() {
                clearTimeout(hideEventID);
                if (container.is(":visible")) {
                    container.stop().fadeTo(200, 0, function() {
                        container.hide();
                        mouse_over = false;
                    });
                }
            };

            var fnHideEvent = function() {
                if (!mouse_over && data.enable_autohide == 1 ) {
                    clearTimeout(hideEventID);
                    hideEventID = setTimeout(function() {
                        fnHide();
                    }, data.autohide_time * 1000);
                }
            };

            var scrollHandled = false;
            var fnScroll = function() {
                if (scrollHandled)
                    return;

                scrollHandled = true;

                if ($(window).scrollTop() > data.scroll_offset) {
                    container.stop().css("opacity", mouse_over ? 1 : parseFloat(data.icon_opacity/100)).show();

                        fnHideEvent();

                } else {
                    fnHide();
                }

                scrollHandled = false;
            };

            if ("undefined" != typeof to_top_options.enable_hide_small_device && "1" == to_top_options.enable_hide_small_device) {
                if ($(window).width() > to_top_options.small_device_max_width) {
                    $(window).on( "scroll", fnScroll);
                    $(document).on( "scroll", fnScroll);
                }
            }else{
                $(window).on( "scroll", fnScroll);
                $(document).on( "scroll", fnScroll);
            }

            container.on( "hover", function() {
                    clearTimeout(hideEventID);
                    mouse_over = true;
                    $(this).css("opacity", 1);
                }, function() {
                    $(this).css("opacity", parseFloat(data.icon_opacity/100));
                    mouse_over = false;
                    fnHideEvent();
                })
                .on( "click", function() {
                    $("html, body").animate({
                        scrollTop: 0
                    }, 400);
                    return false;
                });
        });
    })(jQuery);
});


$(".navbar-toggler").click(function () {
    $(".main-navigation").slideToggle();
});
$(window).resize(function () {
    if ($(window).width() > 992) {
        $(".main-navigation").removeAttr('style');
    }
});
if ($("#searchform .search-field").val() !== "") {
    $("#searchform").addClass("input-visible");
}

let gallery = $(".gallery");
if (gallery.length > 0) {
    let galleryQuantity = 0;
    gallery.find("br").remove();
    gallery.each(function () {
        let nav = $("<div>", {"class": "owl-navigation-" + galleryQuantity});
        let owlDots = $("<div>", {"class": "owl-dots-" + galleryQuantity});
        let owlNav = $("<div>", {"class": "owl-nav-" + galleryQuantity});
        nav.append(owlDots);
        nav.append(owlNav);
        nav.insertAfter($(this));
        $(this).owlCarousel({
            items: 1,
            dots: true,
            loop: true,
            nav: true,
            autoplay: false,
            autoHeight: false,
            navContainer: ".owl-nav-" + galleryQuantity,
            dotsContainer: ".owl-dots-" + galleryQuantity,
            navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
            margin: 20
        }).addClass("post-body-carousel");
        galleryQuantity++
    })

}

$('.owl-members').owlCarousel({
    items: 2,
    dots: false,
    loop: true,
    nav: true,
    margin: 20,
    navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
    responsive : {
        // breakpoint from 0 up
        0 : {
            items: 1,
            nav: false,
            navText: [],
            dots: true
        },

        992: {
            items: 2
        }

    }
});


$('.owl-carousel-1').owlCarousel({
    items: 1,
    loop: true,
    dots: false,
    autoplay: true,
    autoplaytimeout: 1500,
});
$('#owl-video-carousel').owlCarousel({
    loop: true,
    autoplay: true,
    responsiveclass: true,
    autoplaytimeout: 1500,
    margin: 30,
    slideBy: 3,
    dots: false,
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 2,
        },
        680: {
            items: 2,
        },
        980: {
            items: 3,
        },
        1170: {
            items: 4,
        },
        1436: {
            items: 5,
        },

    }
});

$('.js-partners-carousel').owlCarousel({
    items: 8,
    slideBy: 4,
    margin: 25,
    loop: false,
    autoplay: true,
    autoplaytimeout: 1500,
    responsiveclass: true,
    dots: false,
    responsive: {
        0: {
            items: 3
        },
        600: {
            items: 4,
        },
        700: {
            items: 4,
        },
        900: {
            items: 4,
        },
        1100: {
            items: 5
        }
    }
});
//$('.js-donator-slider').owlCarousel({
//    items: 4,
//    slideBy: 1,
//    loop: true,
//    autoplay: true,
//    autoplaytimeout: 1500,
//});
/*
var delayPopup = 5000;
var overlay = $('#overlay');
var close = $('.close-modal');
var cookieOptions = {expires: 3, path: '/'};
if ($.cookie('visit') == undefined) {
    setTimeout(function () {
        $.cookie('visit', true, cookieOptions);
        overlay.css('display', 'block'
        )
    }, delayPopup);
    close.click(function () {
        overlay.css('display', 'none');

    });
}
$(document).keydown(function (e) {
    // ESCAPE key pressed
    if (e.keyCode == 27) {
        overlay.css('display', 'none');
        $(".region-calendar-popup").css('display', 'none');
    }
});
*/
var titleHeight = $('.single .post-meta h1').outerHeight(true);
$('.single-post-sidebar').css('margin-top', (titleHeight - 5) + 'px');
$(window).resize(function () {
    if ($(window).width() < 968) {
        $('.single-post-sidebar').css('margin-top', '15px');
    }

});


    if( !$.cookie('visit') ) {
        if (document.querySelector('.form-survey-ask')) {
            document.querySelector('.form-survey-ask').style = 'display:block';
        }
    }


$(".sclub-top a").on("click", function (e) {
    e.preventDefault();
    $('html,body').animate({
        scrollTop: $("#sclub-payment").offset().top
    });
});

// $('#thanks-ticker-first').webTicker({
//     startEmpty: false,
//     height: '72px',
//     hoverpause: false,
//     duplicate: true,
// });
// $('#thanks-ticker-second').webTicker({
//     startEmpty: false,
//     height: '50px',
//     hoverpause: false,
//     duplicate: true,
// });

function ValidateEmail(inputText)
{
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if(inputText.match(mailformat))
    {
        return true;
    }
    else
    {
        return false;
    }
}

function ValidatePhoneNumber(inputText)
{
    var phoneno = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;
    if(inputText.match(phoneno))
    {
        return true;
    }
    else
    {
        return false;
    }
}
/* active class after click on tab */
$(document).ready(function (e) {
    let paged = 2;
    $('.load-more-btn').attr('data-id', $('.s-stories__tab-link').first().data('id'));

    $('.s-stories-bottom-block').each(function (i, el) {
        $(el).attr('data-index', i)
    });
    $('.s-stories-bottom-block').first().addClass('active')
    $('.s-stories__tab-link').on('click', function (e) {
        e.preventDefault()
        $('.s-stories__tab-link').removeClass('active')
        $(this).addClass('active')
        let $curBtn = $(this);
        let currTermId = $(this).data('id');
        let currIndex = $(this).data('index');
        $('.load-more-btn').attr('data-id', currTermId);
        let data = {
            'terms': currTermId,
            action: 'ajax_filter_stories',
            paged,
        };


        $.ajax({
            url: ajax_links.url,
            type: 'GET',
            data: data,
            beforeSend: function (xhr) {
                $curBtn.addClass('disable')
                $('.s-stories-posts').addClass('load')
            },
            success: function (data) {
                $('.s-stories-posts').html(data)
                $curBtn.removeClass('disable')
                $('.s-stories-posts').removeClass('load')
                paged = 2;
                showBtn()
            }
        });
        $('.s-stories__slogan').each(function (i, e) {
            if(currIndex === i) {
                $(e).addClass('active animate__animated animate__fadeInUp')
            } else {
                $(e).removeClass('active animate__animated animate__fadeInUp')
            }
        })

        // $('.s-stories-bottom-block').each(function (i, el) {
        //     let blockId = $(el).attr('data-index')
        //     if(currIndex === blockId) {
        //         $(e).addClass('active')
        //     } else {
        //         $(e).removeClass('active')
        //     }
        // });
        $('.s-stories-bottom-block').removeClass('active')
        $('.s-stories-bottom-block').eq(currIndex).addClass('active')

        $('.load-more-btn').removeClass('load')


    });
    $('.load-more-btn').on('click', function (e) {
        e.preventDefault()
        let $curBtn = $(this);
        let currTermId = $(this).attr('data-id')
        let postCount = $(this).attr('data-post-count');
        let data = {
            'terms': currTermId,
            action: 'ajax_load_stories',
            paged,
        };


        $.ajax({
            url: ajax_links.url,
            type: 'GET',
            data: data,
            beforeSend: function (xhr) {
                $('.s-stories-posts').addClass('load')
                $curBtn.addClass('load')
            },
            success: function (data) {
                $('.s-stories-posts').append(data[0].html)
                $('.s-stories-posts').removeClass('load')
                $curBtn.removeClass('load')
                paged++;
                if(data[0].foundPosts === 0) {
                    $curBtn.addClass('load')
                }
            }
        });
    });

    function showBtn() {
        if($('.s-stories-posts__post').length < 6) {
            $('.load-more-btn').css({
                'display': 'none'
            });
        } else {
            $('.load-more-btn').css({
                'display': 'flex'
            });
        }
    }
    showBtn()
});

/*Popup*/
$(document).ready(function () {
    $('.button-tell-us').on('click', function () {
        let dataBtn = $(this).data('popup');
        $('.tell-your-story-popup__popup').each(function (i, el) {
            let dataPopup = $(el).data('popup');

            if (dataBtn === dataPopup) {
                $(el).addClass('active');
                $('body').addClass('hide')
            }
            $(this).find('.tell-your-story-popup__close').on('click', function () {
                $(el).removeClass('active');
                $('body').removeClass('hide');
            });
        });
    });
    $(document).on('click', function (e) {
        if ($(e.target).hasClass('active')) {
            $('.tell-your-story-popup__popup').removeClass('active');
            $('body').removeClass('hide')
        } else {

            return;
        }
    });
    $('body').find('.tell-your-story-popup__btn').text = 'asdasd'
    console.log();

});

