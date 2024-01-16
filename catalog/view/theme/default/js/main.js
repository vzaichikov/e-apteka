function LoadCss(url) {
    var link = document.createElement("link");
    link.type = "text/css";
    link.rel = "stylesheet";
    link.href = url;
    document.getElementsByTagName("head")[0].appendChild(link);
}
function LoadScript(url) {
    var script = document.createElement('script');
    script.setAttribute('src', url);
    script.setAttribute('async', false);
    document.head.appendChild(script);
}


$(document).ready(function () {
    "use strict";
    $(".information-text-style table").wrap('<div class="table-responsive"></div>');

    // mob-menu
    $(".header__bottom-nav .header-bottom-nav__link").clone().appendTo("#header__mob-menu_new .mob-menu__list");
    $("#catalog .catalog__list-wrap").clone().appendTo("#catalog_mobile");
    $(".header__middle #cardModal").clone().prop("id", "cardModalMob").appendTo(".cardModal_mob .cardModal_wrap");

    if ($(window).width() <= 768) {
        // $(".header__bottom-nav .header-bottom-nav__link").clone().appendTo("#header__mob-menu_new .mob-menu__list");
        $(".header__social .social__item").clone().appendTo("#header__mob-menu_new .mob-menu__social");
        $(".header__top-inner .header__top-phone-list li").clone().appendTo("#header__mob-menu_new .mob-menu__phone-list");
        $(".header__bottom-links a").clone(true).appendTo("#header__mob-menu_new .mob-menu__list");
        // $("#catalog .catalog__list-wrap").clone().appendTo("#catalog_mobile");
        // $(".header__middle #cardModal").appendTo(".cardModal_mob .cardModal_wrap");
        $("#loginModal").appendTo("#mobile-logged");
        $(".header__col-search #cleversearch").appendTo(".header__mobile .search-wrap");
        $(".js-mob-menu-btn").on("click", function () {
            var menu = $("#header__mob-menu");
            var menuBtn = $(".js-mob-menu-btn");

            // $(".site").bind( 'touchstart, click' , function (e){
            //   if ( $(e.target).closest('#header__mob-menu').length == 0 ) {
            //     menuBtn.removeClass('is-open');
            //     menu.removeClass('is-open');
            //     $(".site").unbind( 'touchstart, click' );
            //   }
            // });

            menuBtn.toggleClass("is-open");
            menu.toggleClass("is-open");
        });
    }

    // каталог товара
    $(".js-catalog-btn").on("click", function (e) {
        $("#catalog").toggleClass("is-open");
    });

    $("#catalog, #catalog_mobile, #mob_catalog").on("click", ".catalog__list-link.has-children", function (e) {
        if ($(e.target).hasClass("catalog__list-link")) return;

        e.preventDefault();
        $(e.target).closest(".catalog__list-item").toggleClass("is-open");
    });

    $("body").on("click", function (e) {
        if ($(e.target).closest(".catalog").length == 0 && $("#catalog").hasClass("is-open")) {
            $("#catalog").removeClass("is-open");
            $("#catalog .catalog__list-item.is-open").removeClass("is-open");
        }
    });

    // fixed header after scroll
    // fixed header after scroll
    var headerAllH = $(".site__header").height();
    // var headerTopH = $('.header__top').height();
    // var headerMiddleH = $('.header__middle').height();
    // var headerBottomH = $('.header__bottom').height();
    // console.log(headerAllH, headerTopH, headerMiddleH);

    $(window).on("resize", function () {
        headerAllH = $(".site__header").height();
    });

    // new mob designer
    $("#list-inline_btn .header__col-search_btn_mob button").on("click", function () {
        $(this).toggleClass("search-open");
        let searh_block = $(this).closest(".header__middle-inner").find(".header__col-search");
        searh_block.toggleClass("mob_search_open");
    });

    $(window).on("scroll", function () {
        if ($(window).scrollTop() > 130) {
            $(".site__content").css({ "margin-top": headerAllH + "px" });
            $(".header").addClass("is-fixed");
        } else {
            $(".site__content").css({ "margin-top": 0 + "px" });
            $(".header").removeClass("is-fixed");
            $("#list-inline_btn .header__col-search_btn_mob button").removeClass("search-open");
            $(".header__col-search").removeClass("mob_search_open");
        }
    });

    // back-to-top button
    // back-to-top button
    var offset = 200;
    var duration = 500;
    $(window).scroll(function () {
        if ($(this).scrollTop() > offset) {
            $(".back-to-top").addClass("is-active");
        } else {
            $(".back-to-top").removeClass("is-active");
        }
    });

    $(".back-to-top").on("click", function (event) {
        event.preventDefault();
        $("html, body").animate(
        {
            scrollTop: 0,
        },
        duration
        );
        return false;
    });

    // маска для телефона
    // маска для телефона
    $(".js-input-phone").mask("+38(099) 999-99-99");

    // Slick slider
    /*
		slick slider documentation:   https://github.com/kenwheeler/slick
		or                            http://kenwheeler.github.io/slick/
       */

    // $('.slider').slick({
    //   // dots: true,
    //   slidesToShow: 5,
    //   slidesToScroll: 1,
    //   centerMode: true,
    //   // autoplay: true,
    //   autoplaySpeed: 2000,
    // });

    $("#action-slider").find(".slider__list").slick({
        dots: false,
        appendArrows: "#action-slider .slider__arrows",
        prevArrow: "#action-slider .slider__arrow--prev",
        nextArrow: "#action-slider .slider__arrow--next",
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: false,
        adaptiveHeight: true,
    });

    function featuredSliderInit(sId) {
        $("#" + sId)
        .find(".featured__content")
        .slick({
            dots: false,
            appendArrows: "#" + sId + " .featured__arrows",
            prevArrow: "#" + sId + " .featured__arrow--prev",
            nextArrow: "#" + sId + " .featured__arrow--next",
            slidesToShow: 2,
            slidesToScroll: 1,
            autoplay: false,
            adaptiveHeight: true,
                // centerPadding: '40px',
                responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 1,
                    },
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                    },
                },
                {
                    breakpoint: 490,
                    settings: {
                        slidesToShow: 1,
                    },
                },
                ],
            });
    }

    $(".js-featured").each(function (idx) {
        var sId = $(this).attr("id");
        if (!sId) {
            sId = "jsf-" + idx;
            $(this).attr("id", sId);
        }

        featuredSliderInit(sId);
    });

    // Слайдер с табами
    var tsList = [];

    // Перебираем все слайдеры нужного типа и инициализируем их
    $(".js-tab-slider").each(function (idx) {
        // присваемаем обертке слайдера ID (если его нету)
        var sId = $(this).attr("id");
        if (!sId) {
            sId = "jst-" + idx;
            $(this).attr("id", sId);
        }

        tabSliderInit(sId);
    });

    // при ресайзе проверяем помещается ли .slider-tab-nav в шапку слайдера
    // если нет - добавляем ему класс .is-scrolled (и таким образом смещаем его ниже)
    $(window).resize(function () {
        $(".js-tab-slider").each(function (idx) {
            var sId = $(this).attr("id");

            tabSliderResize(sId);
        });
    });
    $(window).resize();

    // переключение табов стрелками
    $(".js-tab-slider").on("click", ".slider-tab-nav__arrow", function () {
        var jsSl = $(this).closest(".js-tab-slider");
        var sId = jsSl.attr("id");
        var activeTab = jsSl.find(".slider-tab-nav__item.is-active");
        // var innerWrap = activeTab.closest('.slider-tab-nav__inner');
        var sliderTabNav = activeTab.closest(".slider-tab-nav");

        var newActiveTab = $(this).hasClass("slider-tab-nav__arrow--next") ? activeTab.next() : activeTab.prev();

        if (newActiveTab.length == 0) return;

        // переключаем на новую вкладку
        newActiveTab.click();

        // при необходимости выравниваем заголовки по центру
        tabSlideRender(sId);
    });

    function tabSlideRender(sId) {
        var sliderTabNav = $("#" + sId + " .slider-tab-nav");
        var lastTab = sliderTabNav.children(".slider-tab-nav__item").last();
        var innerWrap = lastTab.closest(".slider-tab-nav__inner");
        var activeTab = innerWrap.find(".slider-tab-nav__item.is-active");

        // определяем нужно ли делать смещение
        var innerWidth = // ширина внутренних блоков
        lastTab.width() +
        parseInt(lastTab.css("marginLeft")) +
            parseInt(lastTab.css("paddingLeft")) + // ширина последнего пунка
            lastTab.position().left; // плюс смещение относительно родителя
            if (innerWidth < innerWrap.width()) {
            // если ширина внутренних блоков меньше внешней обертки -
            // смешения не делаем
            sliderTabNav.css({ left: "inherit" });
            return;
        }

        var l = innerWrap.width() / 2 - activeTab.position().left - activeTab.width() / 2 - parseInt(lastTab.css("marginLeft")) - parseInt(lastTab.css("paddingLeft"));

        if (l < 0) {
            sliderTabNav.css({ left: l + "px" });
        } else {
            sliderTabNav.css({ left: "inherit" });
        }
    }

    function tabSliderResize(sId) {
        var sliderTabNav = $("#" + sId + " .slider-tab-nav");
        var sliderTabNavWrap = $("#" + sId + " .slider-tab-nav__wrap");

        // ширина элементов, которые остануться вверху
        var w1 =
            $("#" + sId + " .slider__icon-wrap").width() + // ширина иконки
            $("#" + sId + " .slider__title").width() + // ширина заголовка
            parseInt($("#" + sId + " .slider__title").css("padding-left")) + // ширина отступа заголовка
            100; // ширина стрелок prev/next

        // суммарная ширина внутренних элементов .slider-tab-nav
        // (блок .slider-tab-nav будет перемещаться ниже если не будет помещаться)
        var lastTab = sliderTabNav.children(".slider-tab-nav__item").last();
        var w2 = // ширина внитренних блоков
        lastTab.width() +
        parseInt(lastTab.css("marginLeft")) +
            parseInt(lastTab.css("paddingLeft")) + // ширина последнего пунка
            lastTab.position().left; // плюс смещение относительно родителя

        // ширина шапки
        var wAll = $("#" + sId + " .slider__header").width();

        if (wAll - w1 - w2 < 0) {
            sliderTabNavWrap.addClass("is-scrolled");
        } else {
            sliderTabNavWrap.removeClass("is-scrolled");
        }

        // при необходимости выравниваем заголовки по центру
        tabSlideRender(sId);
    }

    function tabSliderInit(sId) {
        var nav = $("#" + sId + " .slider__tab-nav");
        var tabContent = $("#" + sId + " .slider__tab-cont");

        nav.on("click", ".slider-tab-nav__item", function (e) {
            // отмечаем активный заготовок
            nav.find(".slider-tab-nav__item").removeClass("is-active");
            $(this).addClass("is-active");

            // отмечаем активный таб
            tabContent.find(".slider__tab").removeClass("is-active");
            tabContent.find("." + $(this).data("tab")).addClass("is-active");

            // отмечаем активные стрелки
            $("#" + sId + " .slider__arrows").removeClass("is-active");
            $("#" + sId + " ." + $(this).data("tab")).addClass("is-active");

            // если на вкладке есть слайдер, то обновляем его
            // var tabSlider = tabContent.find('.' + $(this).data('tab')).find('.slider__list');
            // if ( tabSlider.length > 0 ) {
            //   var sliderId = tabSlider.attr('id');
            //   tsList[sliderId][0].slick.slickGoTo( 1 );
            //   tsList[sliderId][0].slick.slickGoTo( 0 );
            // }
            // $( window ).resize();
        });

        // проходим по всем вкладкам и инициализируем слайдеры
        tabContent.find(".slider__tab").each(function (idx) {
            var slider = $(this).find(".slider__list");

            var sliderId = slider.attr("id");
            if (!sliderId) {
                sliderId = sId + "-" + "t" + idx;
                slider.attr("id", sliderId);
            }

            var varSlidesToShow = 6;
            var varResponsive = [
            {
                breakpoint: 1700,
                settings: {
                    slidesToShow: 4,
                },
            },
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                },
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                },
            },
            {
                breakpoint: 750,
                settings: {
                    slidesToShow: 1,
                },
            },
                // ,{
                //   breakpoint: 550,
                //   settings: {
                //     slidesToShow: 1
                //   }
                // }
                ];
                if ($("#" + sId).hasClass("news")) {
                    varSlidesToShow = 3;
                    varResponsive = [
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2,
                        },
                    },
                    {
                        breakpoint: 550,
                        settings: {
                            slidesToShow: 1,
                        },
                    },
                    ];
                }

                tsList[sliderId] = slider.slick({
                    dots: false,
                    appendArrows: "#" + sId + " .slider__arrows.js-tab-num-" + idx,
                    prevArrow: "#" + sId + " .js-tab-num-" + idx + " .slider__arrow--prev",
                    nextArrow: "#" + sId + " .js-tab-num-" + idx + " .slider__arrow--next",
                    slidesToShow: varSlidesToShow,
                    slidesToScroll: 1,
                    autoplay: false,
                    adaptiveHeight: false,
                    infinite: false,
                    responsive: varResponsive,
                });
            });

        nav.find(".slider-tab-nav__item:first").click();
    }

    // tabs
    // modules/tabs.js

    // accordion
    // modules/accordion.js

    // Magnific popup
    // github:         https://github.com/dimsemenov/Magnific-Popup
    // site:           http://dimsemenov.com/plugins/magnific-popup/
    // documentation:  http://dimsemenov.com/plugins/magnific-popup/documentation.html

    $(".mf-popup").magnificPopup({
        type: "inline",
        preloader: true,
        removalDelay: 100,

        callbacks: {
            beforeOpen: function () {
                this.st.mainClass = this.st.el.attr("data-effect");
            },
        },
    });

    $(".zoom-foto").magnificPopup({
        type: "image",
    });

    // $('.popup-gallery').magnificPopup({
    //   delegate: 'a',
    //   type: 'image',
    //   tLoading: 'Loading image #%curr%...',
    //   mainClass: 'mfp-img-mobile',
    //   gallery: {
    //     enabled: true,
    //     navigateByImgClick: true,
    //     preload: [0,1] // Will preload 0 - before current, and 1 after the current image
    //   },
    //   image: {
    //     tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
    //     titleSrc: function(item) {
    //       return item.el.attr('title');
    //     }
    //   }
    // });

    // jQuery-ui
    var uirHandle = [];
    var uirVal = [];

    $(".js-range").each(function (idx) {
        var uirId = $(this).attr("id");
        if (!uirId) {
            uirId = "uir-" + idx;
            $(this).attr("id", uirId);
        }

        uirHandle[uirId] = $(this).find(".ui-slider-handle span");
        uirVal[uirId] = $(this).find("input");

        var options = {};
        if ($(this).data("min")) options.min = parseFloat($(this).data("min"));

        if ($(this).data("max")) options.max = parseFloat($(this).data("max"));

        if ($(this).data("value")) options.value = parseFloat($(this).data("value"));

        if ($(this).data("step")) options.step = parseFloat($(this).data("step"));

        rangeInit(uirId, options);
    });

    function rangeInit(uirId, options = {}) {
        var opt = {
            create: function () {
                var units = "";
                if ($(this).data("units")) {
                    units = $(this).data("units");
                }
                uirHandle[uirId].html($(this).slider("value") + " " + units);
                uirVal[uirId].val($(this).slider("value"));
            },
            slide: function (event, ui) {
                var units = "";
                if ($(this).data("units")) {
                    units = $(this).data("units");
                }
                uirHandle[uirId].html(ui.value + " " + units);
                uirVal[uirId].val($(this).slider("value"));
            },
            stop: function (event, ui) {
                var units = "";
                if ($(this).data("units")) {
                    units = $(this).data("units");
                }
                uirHandle[uirId].html(ui.value + " " + units);
                uirVal[uirId].val($(this).slider("value"));
            },
            change: function (event, ui) {
                var units = "";
                if ($(this).data("units")) {
                    units = $(this).data("units");
                }
                uirHandle[uirId].html(ui.value + " " + units);
                uirVal[uirId].val($(this).slider("value"));
            },
            range: "min",
        };

        var opt = Object.assign(opt, options);
        $("#" + uirId).slider(opt);
    }

    // range price
    var uirHandlePrice = [];
    var uirValPriceMin = [];
    var uirValPriceMax = [];
    var hsp = [];

    $(".js-range-price").each(function (idx) {
        var uirId = $(this).attr("id");
        if (!uirId) {
            uirId = "uir-" + idx;
            $(this).attr("id", uirId);
        }

        uirHandlePrice[uirId] = $(this).find(".ui-slider-handle");
        uirValPriceMin[uirId] = $(this).find("input.range-price__input--min");
        uirValPriceMax[uirId] = $(this).find("input.range-price__input--max");

        var options = {};
        if ($(this).data("min")) options.min = parseFloat($(this).data("min"));

        if ($(this).data("max")) options.max = parseFloat($(this).data("max"));

        if ($(this).data("value")) options.value = parseFloat($(this).data("value"));

        // if ( $(this).data('values') )
        // options.values = parseFloat ( $(this).data('values') );

        // if ( $(this).data('value-min') && $(this).data('value-max') ) {
            options.values = [parseFloat($(this).data("value-min")), parseFloat($(this).data("value-max"))];
        // }

        if ($(this).data("step")) options.step = parseFloat($(this).data("step"));

        rangePriceInit(uirId, options);
    });

    function rangePriceInit(uirId, options = {}) {
        var opt = {
            create: function () {
                var units = "";
                if ($(this).data("units")) {
                    units = $(this).data("units");
                }

                uirValPriceMin[uirId].val($(this).slider("values", 0));
                uirValPriceMax[uirId].val($(this).slider("values", 1));
            },
            slide: function (event, ui) {
                var units = "";
                if ($(this).data("units")) {
                    units = $(this).data("units");
                }

                uirValPriceMin[uirId].val($(this).slider("values", 0));
                uirValPriceMax[uirId].val($(this).slider("values", 1));
            },
            stop: function (event, ui) {
                uirValPriceMin[uirId].val($(this).slider("values", 0));
                uirValPriceMax[uirId].val($(this).slider("values", 1));
                // $(this).closest('form').submit();
            },
            range: true,
        };

        var opt = Object.assign(opt, options);
        hsp[uirId] = $("#" + uirId).slider(opt);
        // console.log(hsp);
        // hsp[uirId].slider('values',100, 500);
    }

    $(".range-price__input--min").on("change", function () {
        var rp = $(this).closest(".range-price");
        var inputMin = rp.find(".range-price__input--min");
        var inputMax = rp.find(".range-price__input--max");
        var val = parseFloat(inputMin.val());

        if (parseFloat(inputMin.val()) > parseFloat(inputMax.val())) {
            val = parseFloat(inputMax.val());
            inputMin.val(val);
        }

        rp.slider("values", 0, val);
    });

    $(".range-price__input--max").on("change", function () {
        var rp = $(this).closest(".range-price");
        var inputMin = rp.find(".range-price__input--min");
        var inputMax = rp.find(".range-price__input--max");
        var maxValue = parseFloat(rp.data("max"));
        var val = parseFloat(inputMax.val());

        if (parseFloat(inputMax.val()) > maxValue) {
            val = maxValue;
            inputMax.val(val);
        }

        if (parseFloat(inputMin.val()) > parseFloat(inputMax.val())) {
            val = parseFloat(inputMin.val());
            inputMax.val(val);
        }

        rp.slider("values", 1, val);
    });

    // toggle block
    // modules/toggle.js

    // scrolly
    $(window).on("load", function () {
        $(".scrolly").mCustomScrollbar();
    });

    // new_slider
    $(".wrap-slider .swiper-container").each(function () {
        let navPrev = $(this).closest(".wrap-slider").find(".slider__arrow--prev");
        let navNext = $(this).closest(".wrap-slider").find(".slider__arrow--next");

        var swiper = new Swiper(this, {
            loop: false,
            slidesPerView: 6,
            centeredSlides: false,
            spaceBetween: 10,
            navigation: {
                nextEl: navNext,
                prevEl: navPrev,
            },
            simulateTouch: false,
            lazy: true,
            breakpoints: {
                320: {
                    spaceBetween: 5,
                    slidesPerView: 2,
                },
                556: {
                    slidesPerView: 2,
                },
                992: {
                    slidesPerView: 3,
                },
                1300: {
                    slidesPerView: 4,
                },
            },
        });
    });
    $(".do-popup-element").click(function () {
        let $popup = $("#" + $(this).attr("data-target"));
        $popup.show();
        $(".main-overlay-popup").show();
        let scrol = window.scrollY + 50;
        let popap = $(".popup-form").css("top", scrol);
        $("body").css("overflow", "hidden");

        $(".main-overlay-popup, .overlay-popup-close").click(function () {
            $("body").css("overflow", "initial");
            $(".main-overlay-popup").hide();
            $popup.hide();
            if ($(window).width() <= "500") {
                $("body").css("overflow", "initial");
            }
        });
    });

    if ($(window).width() < 768) {
        document.querySelector(".header__mobile #search .autosearch-input").onclick = function () {
            document.body.classList.add("show-mobile-search");
            document.querySelector(".main-overlay-popup").classList.add("js-mobile-search-overlay");

            function addBtn() {
                document
                .querySelector(".header__mobile #search")
                .insertAdjacentHTML(
                    "beforeBegin",
                    "<a href='javascript:void(0)' class='back-search'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 13.76'><path d='M12.75.18a.63.63,0,0,0,0,.9l5.12,5.17H.63a.63.63,0,0,0,0,1.26H17.87l-5.12,5.17a.63.63,0,0,0,.88.9l6.19-6.25a.64.64,0,0,0,0-.89L13.63.19A.62.62,0,0,0,12.75.18Z'/></svg></a>"
                    );

                var elem = document.querySelector(".back-search");

                document.querySelector(".back-search").onclick = function () {
                    document.body.classList.remove("show-mobile-search");
                    document.querySelector(".main-overlay-popup").classList.remove("js-mobile-search-overlay");
                    elem.parentNode.removeChild(elem);
                    document.querySelector(".header__mobile #search .dropdown-menu").style.display = "none";
                };
            }

            if (!document.querySelector(".back-search")) {
                addBtn();
            }
        };

        var loginMobile = document.querySelector("#loginModal");
        if (loginMobile) {
            document.onclick = function () {
                if (loginMobile.style.display === "none") {
                    document.body.classList.remove("show-mobile-login");
                } else {
                    document.body.classList.add("show-mobile-login");
                }
            };
        }

        var cardModal = document.querySelector(".cardModal_mob #cardModalMob");

        if (cardModal) {
            document.onclick = function () {
                if (cardModal.style.display === "none" || cardModal.style.display === "") {
                    document.body.classList.remove("show-mobile-cardModal");
                } else {
                    document.body.classList.add("show-mobile-cardModal");
                }
            };
        }

        var acc = document.getElementsByClassName("footer-info__title");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function () {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
            });
        }
    }

    var x = document.querySelector(".mobile-menu-wrap");
    var mobileMenuBtn = document.querySelectorAll(".mobile-main-menu");
    var mobileMenuClose = document.querySelectorAll(".mobile-main-menu-close");
    var mobileMenuLogin = document.querySelectorAll(".mobile-menu-wrap .head_menu .do-popup-element");

    mobileMenuBtn.forEach(function (elem) {
        elem.addEventListener("click", function () {
            if (x.style.transform === "translate(-100%)") {
                x.style.transform = "translate(0)";
                document.body.classList.add("show-mobile-menu");
            } else {
                x.style.transform = "translate(-100%)";
                document.body.classList.remove("show-mobile-menu");
            }
        });
    });

    function closeMobileMenu() {
        x.style.transform = "translate(-100%)";
        document.body.classList.remove("show-mobile-menu");
        let popup = document.querySelectorAll(".mobile-menu-wrap .popup-form");
        document.querySelector(".main-overlay-popup").style.display = "none";
        for (let i = 0; i < popup.length; i++) {
            popup[i].style.display = "none";
            // console.log(popup[i]);
        }
    }

    document.querySelector(".mobile-menu-wrap").onclick = function (e) {
        if (e.target.closest(".mobile-menu__list, #form-language") == null) {
            closeMobileMenu();
        }
    };

    mobileMenuClose.forEach(function (elem) {
        elem.addEventListener("click", closeMobileMenu);
    });
    // document.querySelector(".mobile-menu-wrap .head_menu .do-popup-element").onclick = closeMobileMenu;

    mobileMenuLogin.forEach(function (elem) {
        if (!elem.dataset.target == "cardModal") {
            elem.addEventListener("click", function () {
                x.style.transform = "translate(-100%)";
                document.body.classList.remove("show-mobile-menu");
            });
        }
    });

    Hammer(x).on("swipeleft", function () {
        closeMobileMenu();
    });

    $("ul.tabs__caption").on("click", "li:not(.active)", function () {
        $(this).addClass("active").siblings().removeClass("active").closest(".tabs").find("div.tabs__content").removeClass("active").eq($(this).index()).addClass("active");
    });

    $("input.input_mask").inputmask("+38 999 999 99 99");

    // Home banner width
    let bannerHome = document.querySelectorAll(".home-banner .swiper-slide img");
    let mainMenu = document.querySelector(".common-home .catalog__list-wrap");
    let mainMenuWidth;

    if (mainMenu) {
        mainMenuWidth = mainMenu.offsetWidth;

        if (bannerHome && mainMenuWidth > 0) {
            bannerHome.forEach((elem) => (elem.style.maxWidth = `calc(100% - ${mainMenuWidth}px)`));
        }
    }


    function bad_vision(e, t) {

        function setCookie(name,value,days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days*24*60*60*1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "")  + expires + "; path=/";
        }
        function getCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for(var i=0;i < ca.length;i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1,c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
            }
            return null;
        }
        function eraseCookie(name) {   
            document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        }

        function n(e, t, n, i) {
            var r = parseInt(a("vision_size")) + t;
            n <= r && r <= i ? ($(".font-size-btns div").removeClass("disabled"), 
                s.each(function () {
                    var e = $(this);
                    e.css("font-size", parseInt(e.css("font-size")) + t)
                }), 
                setCookie("vision_size", parseInt(getCookie("vision_size")) + t),
                parseInt(getCookie("vision_size")) != n && parseInt(getCookie("vision_size")) != i || e.addClass("disabled")) : e.addClass("disabled")
        }
        function o(e, t, n) {
            var i = (n = n || {}).expires;
            if ("number" == typeof i && i) {
                var r = new Date;
                r.setTime(r.getTime() + 1e3 * i),
                i = n.expires = r
            }
            i && i.toUTCString && (n.expires = i.toUTCString());
            var o = e + "=" + (t = encodeURIComponent(t));
            for (var a in n) {
                o += "; " + a;
                var s = n[a];
                !0 !== s && (o += "=" + s)
            }
            document.cookie = o
        }
        function a(e) {
            var t = document.cookie.match(new RegExp("(?:^|; )" + e.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, "\\$1") + "=([^;]*)"));
            return t ? decodeURIComponent(t[1]) : undefined
        }
        var s = $("p, span, a, h5, li");
        "true" == getCookie("vision") ? ($("body, html").addClass("vision"), 
            s.each(function () {
                var e = $(this);
                $(".logo__img.img-responsive").attr("src","/catalog/view/theme/default/img/logo_blue.png")
                e.css("font-size", parseInt(e.css("font-size")) + parseInt(a("vision_size")))
            }), 
            $("#changeVision").text("Стандартна версія")) : (setCookie("vision_size", 0), 
            $("#changeVision").html(e)),
            -2 == parseInt(a("vision_size")) && $("#fontInc").addClass("disabled"),
            3 == parseInt(a("vision_size")) && $("#fontDec").addClass("disabled"),
            $("#changeVision").click(function () {
                "true" == a("vision") ? (setCookie("vision", !1), 
                    $(".logo__img.img-responsive").attr("src","/image/data/Logo_horisontal.png"),
                    $("#changeVision").html(e), 
                    $("#changeVision").text("Версія для людей з порушеннями зору"),
                    $("body, html").removeClass("vision")) : (setCookie("vision", !0), 
                    $("#changeVision").text(t), 
                    $("body, html").addClass("vision"),
                    $("#changeVision").text("Стандартна версія"),
                    $(".logo__img.img-responsive").attr("src","/catalog/view/theme/default/img/logo_blue.png")
                    )
                }),
            $("#fontInc").click(function () {
                n($(this), -1, -2, 3)
            }),
            $("#fontDec").click(function () {
                n($(this), 1, -2, 3)
            })
        }

        function bad_visionHeader(e, t) {
            function n(e, t, n, i) {
                var r = parseInt(a("vision_size")) + t;
                n <= r && r <= i ? ($(".font-size-btns div").removeClass("disabled"), 
                    s.each(function () {
                        var e = $(this);
                        e.css("font-size", parseInt(e.css("font-size")) + t)
                    }), 
                    o("vision_size", parseInt(a("vision_size")) + t),
                    parseInt(a("vision_size")) != n && parseInt(a("vision_size")) != i || e.addClass("disabled")) : e.addClass("disabled")
            }
            function o(e, t, n) {
                var i = (n = n || {}).expires;
                if ("number" == typeof i && i) {
                    var r = new Date;
                    r.setTime(r.getTime() + 1e3 * i),
                    i = n.expires = r
                }
                i && i.toUTCString && (n.expires = i.toUTCString());
                var o = e + "=" + (t = encodeURIComponent(t));
                for (var a in n) {
                    o += "; " + a;
                    var s = n[a];
                    !0 !== s && (o += "=" + s)
                }
                document.cookie = o
            }
            function a(e) {
                var t = document.cookie.match(new RegExp("(?:^|; )" + e.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, "\\$1") + "=([^;]*)"));
                return t ? decodeURIComponent(t[1]) : undefined
            }
            var s = $("p, span, a, h5, li");
            "true" == a("vision") ? ($("body, html").addClass("vision"), 
                s.each(function () {
                    var e = $(this);
                    $(".logo__img.img-responsive").attr("src","/catalog/view/theme/default/img/logo_blue.png")
                    e.css("font-size", parseInt(e.css("font-size")) + parseInt(a("vision_size")))
                }), 
                $("#changeVisionHeader").attr("title","Стандартна версія")) : (o("vision_size", 0), 
                $("#changeVisionHeader").html(e)),
                -2 == parseInt(a("vision_size")) && $("#fontIncHeader").addClass("disabled"),
                3 == parseInt(a("vision_size")) && $("#fontDecHeader").addClass("disabled"),
                $("#changeVisionHeader").click(function () {
                    "true" == a("vision") ? (o("vision", !1), 
                        $(".logo__img.img-responsive").attr("src","/image/data/Logo_horisontal.png"),
                        $("#changeVisionHeader").html(e), 
                        $("#changeVisionHeader").attr("title","Версія для людей з порушеннями зору"),
                        $("body, html").removeClass("vision")) : (o("vision", !0), 
                        $("#changeVisionHeader").text(t), 
                        $("body, html").addClass("vision"),
                        $("#changeVisionHeader").attr("title","Стандартна версія"),
                        $(".logo__img.img-responsive").attr("src","/catalog/view/theme/default/img/logo_blue.png")
                        )
                    }),
                $("#fontIncHeader").click(function () {
                    n($(this), -1, -2, 3)
                }),
                $("#fontDecHeader").click(function () {
                    n($(this), 1, -2, 3)
                })
            }
            bad_visionHeader();
            bad_vision();

        });
