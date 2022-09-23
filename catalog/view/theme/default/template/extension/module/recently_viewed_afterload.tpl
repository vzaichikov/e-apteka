<script>
var initSwiperForViewed = function(){
	let navPrev = $("#viewer-swiper-container").closest(".wrap-slider").find(".slider__arrow--prev");let navNext=$("#viewer-swiper-container").closest(".wrap-slider").find(".slider__arrow--next");
	var swiperViewed = new Swiper("#viewer-swiper-container", {loop:false,slidesPerView:6,centeredSlides:false,spaceBetween:10,navigation:{nextEl:navNext,prevEl:navPrev,},simulateTouch:false,lazy:true,breakpoints:{320:{slidesPerView:1,},450:{slidesPerView:1,},556:{slidesPerView:2,},992:{slidesPerView:3,},1300:{slidesPerView:4,},},});

}
</script>
<div class="ajax-module-reloadable" data-modpath="extension/module/recently_viewed/viewed" data-x="<?php echo $limit; ?>" data-afterload="initSwiperForViewed"></div>