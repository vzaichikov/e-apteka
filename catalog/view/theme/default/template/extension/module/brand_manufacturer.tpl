<div class="manufacturer-wall">
<h3><?php echo $heading_title; ?></h3>
<?php if ($type == 1) { ?>
	<div class="row">
        <?php $i=0; foreach ($manufacturers as $manufacturer) { ?>
            <div class="col-sm-3 col-xs-12">
                <div class="manufacturer-wall-item">
                    <a class="manufacturer-wall-image" href="<?php echo $manufacturer['href']; ?>">
                        <img src="<?php echo $manufacturer['thumb']; ?>" alt="<?php echo $manufacturer['name']; ?>" title="<?php echo $manufacturer['name']; ?>" class="img-responsive" />
                    </a>
                    <div class="manufacturer-wall-caption">
                        <a class="manufacturer-wall-name" href="<?php echo $manufacturer['href']; ?>"><?php echo $manufacturer['name']; ?></a>
                    </div> 
                </div>
            </div>
            <?php $i++; 
            if($i % 4 == 0) { ?>
                <div class="clearfix"></div>
            <?php } 
        } ?>
        <div class="clearfix"></div>
    </div>
<?php } elseif ($type == 2) { ?>
	<div class="list-group">
	  <?php foreach ($manufacturers as $manufacturer) { ?>
	  	<a href="<?php echo $manufacturer['href']; ?>" class="list-group-item"><?php echo $manufacturer['name']; ?></a>
	  <?php } ?>
	</div>
<?php } elseif ($type == 3) { ?>
	<div id="slider-manufacturer" class="owl-carousel">
		<?php foreach ($manufacturers as $manufacturer) { ?>
		  <div class="item text-center">
		      <div class="image">
			      <a href="<?php echo $manufacturer['href']; ?>">
			      	<img src="<?php echo $manufacturer['thumb']; ?>" alt="<?php echo $manufacturer['name']; ?>" title="<?php echo $manufacturer['name']; ?>" class="img-responsive" />
			      </a>
		      </div>
		      <div class="manufacturer-wall-caption">
                   <a class="manufacturer-wall-name" href="<?php echo $manufacturer['href']; ?>"><?php echo $manufacturer['name']; ?></a>
              </div> 
		  </div>
		<?php } ?>
	</div>
	<script type="text/javascript"><!--
	$('#slider-manufacturer').owlCarousel({
		items: <?php echo $quantity; ?>,  
	  	itemsDesktop: [1199,<?php echo $quantity; ?>],
	  	itemsDesktopSmall: [979, <?php echo $quantity; ?>],
	  	itemsTablet: [768, <?php echo $quantity; ?>],
	  	itemsTabletSmall: [768, <?php echo $quantity; ?>],
	  	itemsMobile: [479,1],
		autoPlay: <?php echo ($auto_play)?2000:'false'; ?>,
	  	pagination: <?php echo ($show_pagination)?'true':'false'; ?>,
	  	stopOnHover: <?php echo ($pause_on_hover)?'true':'false'; ?>,
	  	navigation: true,
	  	navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>', '<i class="fa fa-chevron-right fa-5x"></i>']
	});
	--></script>
<?php } ?>

<style type="text/css">
    .manufacturer-wall h3{
        text-align: center;
        margin-bottom: 15px;
    }
    .manufacturer-wall-item{
        margin-bottom: 20px;
        text-align: center;
    }
    .manufacturer-wall-image{
        display: inline-block;
    }
    .manufacturer-wall-caption{
        text-align: center;
        margin-top: 10px;
    }
    .manufacturer-wall-name{
        font-size: 18px;
        line-height: 22px;
        text-decoration: none;
    }
    #slider-manufacturer .image img{
    	display: block;
    	margin: 0 auto;
    }
</style>
</div>