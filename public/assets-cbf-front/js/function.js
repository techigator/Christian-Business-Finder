new WOW().init();
$("document").ready(function () {
    $("#mobile_code").intlTelInput({
        initialCountry: "fr",
        separateDialCode: true,
        // utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js"
    });
});

function loadGoogleTranslate() {
    new google.translate.TranslateElement("google_element");
}


$(document).ready(function () {
    $(".banSlider").slick({
        dots: true,
        infinite: true,
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 5000,
        cssEase: "ease-in-out",
    });
});

$(document).ready(function () {
    $(".logoSlider").slick({
        dots: false,
        infinite: true,
        slidesToShow: 5,
        slidesToScroll: 1,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 5000,
        speed: 500,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    arrows: false,
                },
            },
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ],
    });
});

$(document).ready(function () {
    $(".testSlider").slick({
        dots: false,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: false,
        autoplay: true,
        centerMode: true,
        centerPadding: '30px',

        responsive: [
            {
                breakpoint: 800,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                },
            },
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ],
    });
});

$(document).ready(function(){
    // Initialize the sliders
    $('.slider-for').slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        asNavFor: '.slider-nav',
        dots: false,
        arrows: false,
    });

    $('.slider-nav').slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        dots: false,
        focusOnSelect: true,
        arrows: false,
    });

    // Add click event to slide images
    $('.slider-for .slick-slide').click(function(){
        var index = $(this).attr('data-slick-index');
        $('.slider-for').slick('slickGoTo', index);
        // Add fade-out effect to the figure containing the image
        $('figure img').addClass('fade-in');
    });
});

$('.tranSlider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    prevArrow: $('.prev'),
    nextArrow: $('.next'),
});

$(document).ready(function () {
    $(".tab-slider--body").hide();
    $(".tab-slider--body:first").show();
});

$(".tab-slider--nav li").click(function () {
    $(".tab-slider--body").hide();
    var activeTab = $(this).attr("rel");
    $("#" + activeTab).fadeIn();
    if ($(this).attr("rel") == "tab2") {
        $('.tab-slider--tabs').addClass('slide');
    } else {
        $('.tab-slider--tabs').removeClass('slide');
    }
    $(".tab-slider--nav li").removeClass("active");
    $(this).addClass("active");
});


let nav = document.querySelector("header");
window.onscroll = function () {
    if (document.documentElement.scrollTop > 20) {
        nav.classList.add("sticky");
    } else {
        nav.classList.remove("sticky");
    }
}


// $("#tabAll").on("click", function () {
//   $("#tabAll").parent().addClass("active");
//   $(".tab-pane").addClass("active in");
//   $('[data-toggle="tab"]').parent().removeClass("active");
// });

$(function () {
    $('.datepicker').datepicker({
        language: "es",
        autoclose: true,
        format: "dd/mm/yyyy"
    });
});


var btn = $('#button');

$(window).scroll(function () {
    if ($(window).scrollTop() > 300) {
        btn.addClass('show');
    } else {
        btn.removeClass('show');
    }
});

btn.on('click', function (e) {
    e.preventDefault();
    $('html, body').animate({scrollTop: 0}, '300');
});

// Fancybox Config
$('[data-fancybox="gallery"]').fancybox({
    buttons: [
        "slideShow",
        "thumbs",
        "zoom",
        "fullScreen",
        "share",
        "close"
    ],
    loop: false,
    protect: true
});


function aos_init() {
    AOS.init({
        duration: 1000,
        easing: "ease-in-out",
        once: true,
        mirror: false
    });
}

window.addEventListener('load', () => {
    aos_init();
});

$(".phoneNumber").intlTelInput({
    initialCountry: "auto",
    separateDialCode: false,
    formatOnDisplay: true,
    nationalMode: false,
    // allowDropdown: false,
    geoIpLookup: function (callback) {
        $.get('https://ipinfo.io', function () {
        }, "jsonp").always(function (resp) {
            var countryCode = (resp && resp.country) ? resp.country : "";
            callback(countryCode);
        });
    },
    utilsScript: "../../build/js/utils.js?1562189064761",
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.0.3/js/utils.js",
    preferredCountries: [],
});

function resetIntlTelInput() {
    if (typeof intlTelInputUtils !== 'undefined') { // utils are lazy loaded, so must check
        var currentText = telInput.intlTelInput("getNumber", intlTelInputUtils.numberFormat.E164);
        if (typeof currentText === 'string') { // sometimes the currentText is an object :)
            telInput.intlTelInput('setNumber', currentText); // will autoformat because of formatOnDisplay=true
        }
    }
}


var allowedValues = ["ar", "en", "fr"];

// Get all elements with the class "mySelect"
var selects = document.getElementsByClassName("goog-te-combo");

// Loop through each select element
for (var j = 0; j < selects.length; j++) {
    var select = selects[j];

    // Loop through options and hide those with values not in allowedValues
    for (var i = 0; i < select.options.length; i++) {
        var option = select.options[i];
        if (!allowedValues.includes(option.value)) {
            option.style.display = "none !important";
        }
    }
}
