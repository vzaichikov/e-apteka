<?php echo $header; ?>

<?php
/*CHECK COOKIE LISTINGTYPE*/	
if(isset($_COOKIE["listingType"])) $listingType = $_COOKIE["listingType"];
else $listingType = 'grid';
?>
<div class="container page-category">
	<div class="row">
		<?php echo $column_left; ?>
		<div id="content" class="col-sm-12 page-category">
			<div class="sidebar-overlay "></div>
			<div class="products-category">
				
				<?php if ($thumb): ?>
				<div class="form-group category-info">
					<img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" class="media-object" />
				</div>
				<?php endif; ?>
				
				<?php if($mobile['category_more'] ):?>
					<a class="btn btn-block btn-outlined btn-collapse" role="button" data-toggle="collapse" href="#collapseCategory"> <?php echo $objlang->get('text_morecategory'); ?> </a>
				<?php endif;?>
				
				<div id="collapseCategory" class="product-catalog__mode <?php echo ($mobile['category_more']) ? 'collapse' : ''?>">
					<div class="form-group">
					<?php echo $description; ?>
					</div>
					<?php if ($categories) { ?>
					<div class="refine-search form-group">
						<h3 class="title-category"><?php echo $text_refine; ?></h3>
						<ul class="row refine-search__list">
						<?php foreach ($categories as $category) {
							?>
							<li class="col-xs-6">
								<a href="<?php echo $category['href']; ?>" class="thumbnail"><img src="<?php echo $category['thumb']; ?>" alt="<?php echo $category['name']; ?>" /> </a>
								<a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
							</li>
						<?php } ?>
						</ul>

					</div>
					<?php } ?>
				</div>
				
				
				<!--// Begin Select Category Simple -->
				<?php if ($products) { ?>
				<!-- Filters -->
				<div class="product-filter filters-panel clearfix">
					<div class="col-xs-4 view-mode ">
						<div class="view-mode">
							<div class="list-view">
								<button class="btn btn-default grid <?php if($listingType =='grid') { echo 'active'; } ?>"   title="<?php echo $button_grid; ?>"><i class="fa fa-th-large"></i></button>
								<button class="btn btn-default list <?php if($listingType =='list') { echo 'active'; } ?>"   title="<?php echo $button_list; ?>"><i class="fa fa-bars"></i></button>
							</div>
						</div>
					</div>
					<div class="col-xs-4 ">
						<?php if(!empty($column_left)):?>
						<a class="btn btn-primary open-sidebar" href="javascript:void(0)"><i class="fa fa-filter"></i> Refine </a>
						<?php endif;?>
					</div>
					<div class="short-by-show col-xs-4">
					
						<div class="form-group short-by">
							<i class="fa fa-sort-amount-asc" ></i>
							<select id="input-sort" class="form-control" onchange="location = this.value;">
							  <?php foreach ($sorts as $sorts2) { ?>
							  <?php if ($sorts2['value'] == $sort . '-' . $order) { ?>
							  <option value="<?php echo $sorts2['href']; ?>" selected="selected"><?php echo $sorts2['text']; ?></option>
							  <?php } else { ?>
							  <option value="<?php echo $sorts2['href']; ?>"><?php echo $sorts2['text']; ?></option>
							  <?php } ?>
							  <?php } ?>
							</select>
						</div>

					</div>
					
					<?php echo $content_top; ?>
				
				</div>
				<!-- //end Filters -->
				
				<!--Changed Listings-->
				<?php 
					if (file_exists(DIR_TEMPLATE. 'so-mobile/template/soconfig/listing.php')) include(DIR_TEMPLATE.'so-mobile/template/soconfig/listing.php');
					else echo 'Not found';
				?>
				<!--// End Changed listings-->
				
				<!-- Filters -->
				<div class="product-filter text-center clearfix filters-panel">
					<div class="short-by-show text-center">
						<div class="form-group" style="margin:0px"><?php echo $results; ?></div>
					</div>
					<?php if (!empty($pagination)){?>
						<div class="box-pagination "><?php echo $pagination; ?></div>
					<?php }?>
				</div>
				<!-- //end Filters -->

				<?php } ?>
				
					
				<?php if (!$products) { ?>
					<div class="form-group">
						<h4><?php echo $text_empty; ?></h4>
						<div class="buttons">
							<div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
						</div>
					</div>
				<?php } ?>
				<!--End content-->
			
				<script type="text/javascript"><!--
				 $('.view-mode .list-view button').bind("click", function() {
					if ($(this).is(".active")) {return false;}
					$.cookie('listingType', $(this).is(".grid") ? 'grid' : 'list', { path: '/' });
					location.reload();
				});
				//-->
				</script> 
			
			<?php echo $content_bottom; ?>
			</div>
		</div>
	  
    </div>
</div>
<?php echo $footer; ?>

