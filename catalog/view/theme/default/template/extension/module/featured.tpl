
<div class="wrap-slider container featured_slider">
    <div class="row">
        <div class="slider-nav col-xs-12 col-sm-12 col-md-3"> 
            <h3 class="title-slider">
                <?php echo $heading_title; ?>          
            </h3>
            <div class="slider-nav-btn">
                <div class="slider__arrow slider__arrow--prev">
                    <svg class="icon">
                    <use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#left-arrow-chevron"></use>
                </svg>
            </div>
            <div class="slider__arrow slider__arrow--next">
                <svg class="icon">
                <use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#right-arrow-chevron"></use>
            </svg>
        </div>
    </div>
</div>
<div class="swiper-container col-xs-12 col-sm-12 col-md-9"> 
    <div class="swiper-wrapper">        
        <?php foreach ($products as $product) { ?>  
            <?php include(DIR_TEMPLATEINCLUDE . 'product/structured/product_single_slider.tpl'); ?>
        <?php } ?>     
    </div>  
</div>
</div>
</div>


