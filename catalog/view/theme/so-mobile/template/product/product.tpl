
<?php 
/******************************************************
 * @package	SO Theme Framework for Opencart 2.0.x
 * @author	http://www.magentech.com
 * @license	GNU General Public License
 * @copyright(C) 2008-2015 Magentech.com. All rights reserved.
*******************************************************/
?>

<?php // Header Blocks =========================================?>
<?php echo $header; ?>


<?php // Content Detail Blocks ========================================= ?>
<div class="container product-detail">
	<div class="row">
  
    <div id="content" class="col-xs-12">
        <div class="product-view product-info">
			<div class="content-product-left ">
				<?php
				if (sizeof($images) == 0) {$firstimg = array('popup' => $popup,'thumb' => $thumb);array_unshift($images, $firstimg);}
				if ($images)  : ?>
					<div class="slider-for" >
						<div class="contentslider--item">
							<img itemprop="image" class="product-image-zoom" src="<?php echo $popup; ?>" data-zoom-image="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
						</div>
						
						<?php 
						
						if ($images) : ?>
							<?php $i=-1; foreach ($images as $image) : $i++ ?>
							<div class="contentslider--item">
								<a data-index="<?php echo $i; ?>" class="thumbnail" title="<?php echo $heading_title; ?>">
									<img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
								</a>
							</div>
							<?php endforeach; ?>
						<?php endif; ?>

					</div>
					<div  class="slider-nav ">
						<?php
						if (sizeof($images) > 0) {
							$firstimg = array('popup' => $popup,'thumb' => $thumb);
							array_unshift($images, $firstimg);
							
						} ?>
						<?php $i=-1; foreach ($images as $image) : $i++ ?>
						<div class="slick-slide">

							<a data-index="<?php echo $i; ?>" class="img thumbnail"  title="<?php echo $heading_title; ?>">
								<img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
							</a>
						</div>
						<?php endforeach; ?>
						
					</div>
				<?php endif; ?>
				<?php //End Bottom Thumbnails previews -------?>
				<div class="box-label">
					<!--New Label-->
					<?php if (!isset($new_status) || ($new_status)) : ?>
					<?php
					$day_range = 10;
					if(isset($days)):
						if ( $days == '') $day = $day_range;
						else $day = $days;
					$day_number_to_range = date( "Y-m-d" ,  strtotime("-$day day")  );
					if ($product_info['date_available'] >= $day_number_to_range) :
					?>
						<span class="label-product label-new"><?php echo (isset($new_text) ? $new_text : 'NEW'); ?></span>
					<?php endif; ?>
					<?php endif; ?>
					<?php endif; ?>
					
					<!--Sale Label-->
					<?php if (isset($sale_status ) && ($sale_status )) :?>
					<?php if ($product_info['special']) : ?>
						<span class="label-product label-sale font-ct">
							<?php  //if($discount_status) 
							echo $discount; ?>    
						</span>
					<?php endif; ?>
					<?php endif; ?>
					<div class="product-stock"><div class="stock"><span><?php echo $text_stock; ?></span> <i class="fa fa-check-square-o"></i> <?php echo $stock; ?></div>	</div>
				</div>
			</div>
			<?php //End Img Gallery Block -------?>

			<?php //Product info Block -------?>
			<div class="content-product-right">
				<div class="content-info">
					<div class="title-product hidden">
						<h1><?php echo $heading_title; ?></h1>
					</div>
					<?php 
						if ($model): ?>
						<div class="model font-ct"><span><?php echo $text_model; ?></span> <span class="font-ct"><?php echo $model; ?></span></div>
						<?php endif; ?>
					 <!-- Review ---->
					 <?php if ($review_status) { ?>
					<div class="box-review">
					   <div class="ratings">
						  <div class="rating-box">
						  <?php for ($i = 1; $i <= 5; $i++) { ?>
						  <?php if ($rating < $i) { ?>
						  <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
						  <?php } else { ?>
						  <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
						  <?php } ?>
						  <?php } ?>
						  </div>
					  </div>
			 
					   <a class="reviews_button hidden" href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;"><?php echo $reviews; ?></a> 
					</div>
					<?php } ?>
					
					
					<?php //Product Description -------?>
					<div class="product-label">
						<?php //Product Price -------?>
						<?php if ($price) : ?>
						<div class="product_page_price price" itemprop="offerDetails" itemscope itemtype="http://data-vocabulary.org/Offer">
							 <?php if (!$special) { ?>
					        <span class="price-new"><span itemprop="price" id="price-old"><?php echo $price; ?></span></span>
					        <?php } else { ?>
					        <span class="price-new"><span itemprop="price" id="price-special"><?php echo $special; ?></span></span> <span class="price-old font-ct" id="price-old"><?php echo $price; ?></span>
					        <?php } ?>
							<?php if ($tax) { ?>
							<div class="price-tax"><span><?php echo $text_tax; ?></span> <?php echo $tax; ?></div>
							<?php } ?>
							
							
						</div>
						<?php endif; ?>
						<?php //End Product Price -------?>	
						<?php if ($discounts) { ?>
							<ul class="list-unstyled	">
								<?php foreach ($discounts as $discount) { ?>
								<li><?php echo $discount['quantity']; ?><?php echo $text_discount; ?><?php echo $discount['price']; ?></li>
								<?php } ?>
							</ul>
							<?php } ?>
					</div>
					<div class="box-link">
						<div class="add-to-links wish_comp">
							<ul class="blank">
								<li class="wishlist">
									<a class="icon"  title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product_id; ?>');"><i class="fa fa-heart-o"></i></a>
								</li>
								<li class="compare">
									<a class="icon"  title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product_id; ?>');"><i class="fa fa-retweet"></i></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				
				<div class="product-box-desc hidden">
					<div class="inner-box-desc">

						<?php if ($manufacturer): ?>
								<div class="brand"><span><?php echo $text_manufacturer; ?></span><a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a></div>
						<?php endif; ?>
						<?php 
						if ($model): ?>
						<div class="model"><span><?php echo $text_model; ?></span> <?php echo $model; ?></div>
						<?php endif; ?>
						<?php if ($reward): ?>
							<div class="reward"><span><?php echo $text_reward; ?></span> <?php echo $reward; ?></div>
						<?php endif; ?>
						<?php if ($points) { ?>
						<div class="reward"><span><?php echo $text_points; ?></span> <?php echo $points; ?></div>
						<?php } ?>
						<div class="stock"><span><?php echo $text_stock; ?></span> <i class="fa fa-check-square-o"></i> <?php echo $stock; ?></div>	
					</div>		
				</div>
				
				<?php // End Product Description -------?>
				
				
			 
				<div id="product">
					<?php if ($options) { ?>
					<div class="options options-mobi clearfix">
						<h3 class="hidden"><?php echo $text_option; ?></h3>
					<?php foreach ($options as $option) { ?>
						<?php if ($option['type'] == 'select') { ?>
						<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
							<label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
							<select name="option[<?php echo $option['product_option_id']; ?>]" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control">
								<option value=""><?php echo $text_select; ?></option>
								<?php foreach ($option['product_option_value'] as $option_value) { ?>
								<option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
									<?php if ($option_value['price']) { ?>
									(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
									<?php } ?>
								</option>
								<?php } ?>
							</select>
						</div>
						<?php } ?>
					
						<?php if ($option['type'] == 'radio') { ?>
						<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
							<label class="control-label"><?php echo $option['name']; ?></label>
							<div id="input-option<?php echo $option['product_option_id']; ?>">
								<?php 
								$radio_type 	= isset($radio_style) && $radio_style ? ' radio-type-button':'';
								foreach ($option['product_option_value'] as $option_value) { 
								$radio_image 	= isset($option_value['image']) ? 'option_image' : '';
								$radio_price  	= isset($radio_style) && $radio_style ? $option_value['price_prefix']. $option_value['price'] : '';
								?>
									<div class="radio <?php echo $radio_image. $radio_type;?>">
										 <label>
											<input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
											<span class="option-content-box" data-title="<?php echo $radio_price;?>" >
												<?php if ($option_value['image']) { ?>
												<img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" /> 
												<?php } ?>
												<span class="option-name"><?php echo $option_value['name']; ?></span>
												<?php if ($option_value['price'] && $radio_style !='1') { ?>
												(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
												<?php } ?>
											  </label>
											</span>
									</div>
									
								<?php } ?>
								<?php if($radio_style) { ?>
								<script type="text/javascript">
									 $(document).ready(function(){
										  $('#input-option<?php echo $option['product_option_id']; ?>').on('click', 'span', function () {
											   $('#input-option<?php echo $option['product_option_id']; ?> span').removeClass("active");
											   $(this).addClass("active");
										  });
									 });
								</script>
								<?php } ?>
							</div>
						</div>
						<?php } ?>
					
						<?php if ($option['type'] == 'checkbox') { ?>
						<div class="box-checkbox form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
							<label class="control-label"><?php echo $option['name']; ?></label>
							<div id="input-option<?php echo $option['product_option_id']; ?>">
								<?php 
								$check_type 	= isset($check_style) && $check_style ? ' radio-type-button':'';
								foreach ($option['product_option_value'] as $option_value) {
								$check_image 	= isset($option_value['image']) ? ' option_image' : '';
								$check_price  	= isset($check_style) && $check_style ? $option_value['price_prefix']. $option_value['price'] : '';
								?>
									<div class="checkbox <?php echo $check_type.$check_image ;?>">
										<label>
											<input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" />
											<span class="option-content-box" data-title="<?php echo $check_price;?>" >
												<?php if ($option_value['image']) { ?>
												<img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" /> 
												<?php } ?>
												<span class="option-name"><?php echo $option_value['name']; ?></span>
												<?php if ($option_value['price'] && $check_style !='1') { ?>
												(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
												<?php } ?>
											</span>
										</label>
									</div>
									<?php } ?>
									
									<?php if($check_style) { ?>
									<script type="text/javascript">
										 $(document).ready(function(){
											  $('#input-option<?php echo $option['product_option_id']; ?>').on('click', 'span', function () {
												   $('#input-option<?php echo $option['product_option_id']; ?> span').removeClass("active");
												   $(this).addClass("active");
											  });
										 });
									</script>
								<?php } ?>
							</div>
						</div>
						
						<?php } ?>
					
					
						<?php if ($option['type'] == 'text') { ?>
						<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
							<label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
							<input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
						</div>
						<?php } ?>
						
						<?php if ($option['type'] == 'textarea') { ?>
						<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
							<label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
							<textarea name="option[<?php echo $option['product_option_id']; ?>]" rows="5" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control"><?php echo $option['value']; ?></textarea>
						</div>
						<?php } ?>
						
						<?php if ($option['type'] == 'file') { ?>
						<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
							<label class="control-label"><?php echo $option['name']; ?></label>
							<button type="button" id="button-upload<?php echo $option['product_option_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default btn-inline"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
							<input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" id="input-option<?php echo $option['product_option_id']; ?>" />
						</div>
						<?php } ?>
					
						<?php if ($option['type'] == 'date') { ?>
						<div class="box-date form-group<?php echo ($option['required'] ? ' required' : ''); ?> ">
							<label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
							<div class="input-group date col-xs-12">
								<input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
								<span class="input-group-btn">
								<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
								</span>
							</div>
						</div>
						<?php } ?>
					
						<?php if ($option['type'] == 'datetime') { ?>
						<div class="box-date form-group<?php echo ($option['required'] ? ' required' : ''); ?> ">
							<label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
							<div class="input-group datetime col-xs-12">
								<input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>"  data-date-format="YYYY-MM-DD" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
								<span class="input-group-btn">
								<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
								</span>
							</div>
						</div>
						<?php } ?>
					
						<?php if ($option['type'] == 'time') { ?>
						<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
							<label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
							<div class="input-group time">
								<input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
								<span class="input-group-btn">
								<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
								</span>
							</div>
						</div>
						<?php } ?>
					
					<?php } ?>
					</div>
					<?php } ?>
					
					<div class="box-cart cart clearfix">
						<?php if ($recurrings) { ?>
						<hr>
						<h3><?php echo $text_payment_recurring ?></h3>
						<div class="form-group required">
							<select name="recurring_id" class="form-control">
								<option value=""><?php echo $text_select; ?></option>
								<?php foreach ($recurrings as $recurring) { ?>
								<option value="<?php echo $recurring['recurring_id'] ?>"><?php echo $recurring['name'] ?></option>
								<?php } ?>
							</select>
							<div class="help-block" id="recurring-description"></div>
						</div>
						<?php } ?>
						
						<!-- QUALYTY -->
						<div class="form-group box-info-product">
						    <div class="option quantity">
							  <div class="input-group quantity-control">
								  <label class="hidden"><?php echo $entry_qty; ?></label>
								  <span class="input-group-addon product_quantity_down fa fa-minus"></span>
								  <input class="form-control font-ct"  type="text" name="quantity" value="<?php echo $minimum; ?>" />
								  <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
								  
								  <span class="input-group-addon product_quantity_up fa fa-plus"></span>
							  </div>
						    </div>
						   <!-- CART -->
						   <div class="cart">
								<input type="button" data-toggle="tooltip" title="<?php echo $button_cart; ?>" value="<?php echo $button_cart; ?>" data-loading-text="<?php echo $text_loading; ?>" id="button-cart" class="btn btn-mega btn-md" />
							</div>
							
							<?php if ($minimum > 1) : ?><p class="minimum" style="clear:both; display:none;"><?php echo $text_minimum; ?></p><?php endif; ?>

						</div>
						
						
					</div>
			
			
				
				
				</div><!-- end box info product -->

            </div>
			<?php //End Product info Block -------?>
			
		</div>

		<?php echo $content_top; ?>
	
		<div class="product-bottom">
			<?php // Tabs Blocks =========================================?>
			<div id="collapseTab" class="producttab ">
				<div class="tabsslider clearfix ">
					<?php //Tabs Left Position -------?>
					<ul class="nav nav-tabs col-xs-12">
						<?php if ($description) : ?>
						<li class="active"><a data-toggle="tab" href="#tab-1"><?php echo $tab_description; ?></a></li>
						<?php endif; ?>

						<?php if ($attribute_groups) : ?>
						<li class="<?php echo (!$description ? 'active' : ''); ?>"><a data-toggle="tab" href="#tab-2"><?php echo $tab_attribute; ?></a></li>
						<?php endif; ?>

						<?php if ($review_status) : ?>
						<li class="<?php echo (!$description && !$attribute_groups ? 'active' : ''); ?>"><a data-toggle="tab" href="#tab-review"><?php echo $tab_review; ?></a></li>
						<?php endif; ?>
						
						<?php if ($tags) : ?>
						<li class="<?php echo (!$description && !$attribute_groups && !$review_status ? 'active' : ''); ?>"><a data-toggle="tab" href="#tab-4"><?php echo (!empty($soconfig_lang[$lang]["tags_tab_title"]) ? $soconfig_lang[$lang]["tags_tab_title"] : 'TAGS'); ?></a></li>
						<?php endif; ?>

						
					</ul>
					
					
					<div class="tab-content <?php if ($tabs_position == 1){ echo "col-lg-9 col-sm-8"; }?> col-xs-12">
						<?php if ($description) : ?>
						<div id="tab-1" class="tab-pane fade active in">
							<?php echo $description; ?>
						</div>
						<?php endif; ?>
						
						<?php if ($attribute_groups) : ?>
						<div id="tab-2" class="<?php echo (!$description ? 'tab-pane fade active in' : 'tab-pane fade'); ?>">
							<div class="table-responsive">
								<table class="table">
									<?php foreach ($attribute_groups as $attribute_group) { ?>
									<thead>
									<tr>
										<td colspan="2"><?php echo $attribute_group['name']; ?></td>
									</tr>
									</thead>
									<tbody>
									<?php foreach ($attribute_group['attribute'] as $attribute) { ?>
									<tr>
										<td><?php echo $attribute['name']; ?></td>
										<td><?php echo $attribute['text']; ?></td>
									</tr>
									<?php } ?>
									</tbody>
									<?php } ?>
								</table>
							</div>
							
						</div>
						<?php endif; ?>
						
						<?php if ($review_status) : ?>
						<div id="tab-review" class="<?php echo (!$description && !$attribute_groups ? 'tab-pane fade active in' : 'tab-pane fade'); ?>">
							<form>
								<div id="review"></div>
								<h2 id="review-title"><?php echo $text_write; ?></h2>
								<?php if ($review_guest) { ?>
									<div class="contacts-form">
										<div class="form-group">
											<span class="icon icon-user"></span>
											<input type="text" name="name" class="form-control" value="<?php echo $entry_name; ?>" onblur="if (this.value == '') {this.value = '<?php echo $entry_name; ?>';}" onfocus="if(this.value == '<?php echo $entry_name; ?>') {this.value = '';}">
										</div>
										<div class="form-group">
											<span class="icon icon-bubbles-2"></span>
											<textarea class="form-control" name="text" onblur="if (this.value == '') {this.value = '<?php echo $entry_review; ?>';}" onfocus="if(this.value == '<?php echo $entry_review; ?>') {this.value = '';}"><?php echo $entry_review; ?></textarea>
										</div>
										<div class="form-group">
										<span style="font-size: 11px;"><?php echo $text_note; ?></span>
										<br />
										<br />
										<b><?php echo $entry_rating; ?></b> <span><?php echo $entry_bad; ?></span>&nbsp;
										<input type="radio" name="rating" value="1" />
										&nbsp;
										<input type="radio" name="rating" value="2" />
										&nbsp;
										<input type="radio" name="rating" value="3" />
										&nbsp;
										<input type="radio" name="rating" value="4" />
										&nbsp;
										<input type="radio" name="rating" value="5" />
										&nbsp;<span><?php echo $entry_good; ?></span><br />
										</div>
										<?php echo $captcha; ?>
										<div class="buttons clearfix"><a id="button-review" class="btn btn-info"><?php echo $button_continue; ?></a></div>

									</div>
								<?php } else { ?>
								<?php echo $text_login; ?>
								<?php } ?>
							</form>

						</div>
						<?php endif; ?>
						
						<?php if ($tags) : ?>
						<div id="tab-4" class="<?php echo (!$description && !$attribute_groups && !$review_status ? 'tab-pane fade active in' : 'tab-pane fade'); ?>">
							<?php for ($i = 0; $i < count($tags); $i++) { ?>
							<?php if ($i < (count($tags) - 1)) { ?>
							<a class="btn btn-primary btn-sm" href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
							<?php } else { ?>
							<a class="btn btn-primary btn-sm" href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
							<?php } ?>
							<?php } ?>
						</div>
						<?php endif; ?>

					</div>
				</div>
			</div>
			
				
			<?php if(!empty($products)): ?>
			<div class="module releate-horizontal">
				<h3 class="modtitle"><span><?php echo $text_related; ?></span></h3>
				<div class="releate-products  contentslider" data-rtl="no" data-autoplay="no"  data-autoheight="no" data-delay="4" data-speed="0.6" data-margin="10"  data-items_column1="1" data-items_column2="1"  data-items_column3="2" data-items_column4="2" data-arrows="yes" data-pagination="no" data-lazyload="yes" data-loop="no" data-hoverpause="yes">
					<!-- Products list -->
					<?php foreach ($products as $product) : ?>
					<div class="item-element clearfix">
						<div class="image">
							<a  href="<?php echo $product['href']; ?>">
								<img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" />
							</a>
						</div> 
						<div class="caption text-center">
							<h4><a class="preview-image font-ct" href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
							<div class="ratings hidden">
								  <div class="rating-box">
								  <?php for ($i = 1; $i <= 5; $i++) { ?>
								  <?php if ($product['rating'] < $i) { ?>
								  <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
								  <?php } else { ?>
								  <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
								  <?php } ?>
								  <?php } ?>
								  </div>
							</div>
							<?php if (!isset($product_catalog_mode) || $product_catalog_mode != 1) : ?>
							<div class="price font-ct">
								   <?php if ($product['price']) : ?>
									  <?php if (!$product['special']) { ?>
										 <span class="price-new"><?php echo $product['price']; ?></span>
									  <?php } else { ?>
										<span class="price-new"><?php echo $product['special']; ?></span>
										 <span class="price-old"><?php echo $product['price']; ?></span>
										 
									  <?php } ?>
								   <?php endif; ?>
							</div>
							<?php endif; ?>
						</div>
					</div>
						    
				 <?php endforeach; ?>
				</div>
				
			</div>
			<?php endif; ?>
		</div>
    </div>
	
	
	</div>
</div>



<script type="text/javascript"><!--
$('select[name=\'recurring_id\'], input[name="quantity"]').change(function(){
	$.ajax({
		url: 'index.php?route=product/product/getRecurringDescription',
		type: 'post',
		data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
		dataType: 'json',
		beforeSend: function() {
			$('#recurring-description').html('');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			
			if (json['success']) {
				$('#recurring-description').html(json['success']);
			}
		}
	});
});
//--></script> 

<script type="text/javascript"><!--
$('#button-cart').on('click', function() {
	$.ajax({
	url: 'index.php?route=extension/soconfig/cart/add',
		type: 'post',
		data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-cart').button('loading');
		},
		complete: function() {
			$('#button-cart').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');
			
			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						var element = $('#input-option' + i.replace('_', '-'));

						if (element.parent().hasClass('input-group')) {
							element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						} else {
							element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						}
					}
				}

				if (json['error']['recurring']) {
					$('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
				}

				// Highlight any found errors
				$('.text-danger').parent().addClass('has-error');
			}
			
			if (json['success']) {
				 addProductNotice(json['title'], json['thumb'], json['success'], 'success');
				// Need to set timeout otherwise it wont update the total
				setTimeout(function () {
					$('#cart  .total-shopping-cart').html(json['total'] );
					$('.text-danger').remove();
				}, 100);
				$('#cart > ul').load('index.php?route=common/cart/info ul li');
			}
		},
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
	});
});

//--></script> 
<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

$('.time').datetimepicker({
	pickDate: false
});

$('button[id^=\'button-upload\']').on('click', function() {
	var node = this;
	
	$('#form-upload').remove();
	
	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');
	
	$('#form-upload input[name=\'file\']').trigger('click');
    if (typeof timer != 'undefined') {
        clearInterval(timer);
    }
	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);
			
			$.ajax({
				url: 'index.php?route=tool/upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(node).button('loading');
				},
				complete: function() {
					$(node).button('reset');
				},
				success: function(json) {
					$('.text-danger').remove();
					
					if (json['error']) {
						$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
					}
					
					if (json['success']) {
						alert(json['success']);
						
						$(node).parent().find('input').attr('value', json['code']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
//--></script> 
<script type="text/javascript"><!--
$('#review').delegate('.pagination a', 'click', function(e) {
  e.preventDefault();
    $('#review').fadeOut('slow');
    $('#review').load(this.href);
    $('#review').fadeIn('slow');
});

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').on('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : ''),
		beforeSend: function() {
			$('#button-review').button('loading');
		},
		complete: function() {
			$('#button-review').button('reset');
		},
		success: function(json) {
			$('.alert-success, .alert-danger').remove();
			
			if (json['error']) {
				$('#review').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}
			
			if (json['success']) {
				$('#review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');
				
				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').prop('checked', false);
			}
		}
	});
});

//--></script> 


<script type="text/javascript"><!--
	$(document).ready(function() {
		$('.product-options li.radio').click(function(){
			$(this).addClass(function() {
				if($(this).hasClass("active")) return "";
				return "active";
			});
			$(this).siblings("li").removeClass("active");
			$(this).parent().find('.selected-option').html('<span class="label label-success">'+ $(this).find('img').data('original-title') +'</span>');
		})
		
		if(!$('.slider').hasClass('slick-initialized')) {
            $('.slider-for').slick({
				slidesToShow: 1,
				slidesToScroll: 1,
				fade: true,
				slideMargin: 10,
				arrows: false,
				infinite: true,
				asNavFor: '.slider-nav'
			});
			$('.slider-nav').slick({
			  slidesToShow: 4,
			  slidesToScroll: 1,
			  asNavFor: '.slider-for',
			  slideMargin: 10,
			  dots: false,
			  arrows: false,
			  centerMode: false,
			  focusOnSelect: true,
			
			});
        }
	});

//--></script>


<script type="text/javascript">
var ajax_price = function() {
	$.ajax({
		type: 'POST',
		url: 'index.php?route=extension/soconfig/liveprice/index',
		data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
		dataType: 'json',
			success: function(json) {
			if (json.success) {
				change_price('#price-special', json.new_price.special);
				change_price('#price-tax', json.new_price.tax);
				change_price('#price-old', json.new_price.price);
			}
		}
	});
}

var change_price = function(id, new_price) {
	$(id).html(new_price);
}
$('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\'], .product-info input[type=\'checkbox\'], .product-info select, .product-info textarea, .product-info input[name=\'quantity\']').on('change', function() {
	ajax_price();
});
</script>


<?php // Footer Blocks =========================================?>
<?php echo $footer; ?>