<div class="category-wall">
    <h3 class="text-center"><?php echo $heading_title; ?></h3>
    <div class="row">
        <?php foreach ($categories as $category) { ?>
            <div class="col-xs-12 col-md-4 col-sm-6 col-lg-3">
				<a class="img-thumbnail" href="<?php echo $category['href']; ?>">
					<img src="<?php echo $category['image']; ?>" alt="<?php echo $category['name']; ?>" title="<?php echo $category['name']; ?>" class="img-responsive" />
				</a>
				<div>
					<a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
				</div> 
            </div>
		<?php } ?>
        <div class="clearfix"></div>
    </div>
</div>