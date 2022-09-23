<?php if (isset($settings['status']) && $settings['status'] == 1) {?>
<div id="so-groups" class="<?php echo $position?> so-groups-sticky hidden-xs" style="top: <?php echo $top.'px';?>">
	<?php if ($settings['show_category']) {?>
	<a class="sticky-categories" data-target="popup" data-popup="#popup-categories"><span><?php echo $text_head_categories;?></span><i class="fa fa-align-justify"></i></a>
	<?php }?>
	<?php if ($settings['show_cart']) {?>
	<a class="sticky-mycart" data-target="popup" data-popup="#popup-mycart"><span><?php echo $text_head_cart;?></span><i class="fa fa-shopping-cart"></i></a>
	<?php }?>
	<?php if ($settings['show_account']) {?>
	<a class="sticky-myaccount" data-target="popup" data-popup="#popup-myaccount"><span><?php echo $text_head_account;?></span><i class="fa fa-user"></i></a>
	<?php }?>
	<?php if ($settings['show_search']) {?>
	<a class="sticky-mysearch" data-target="popup" data-popup="#popup-mysearch"><span><?php echo $text_head_search;?></span><i class="fa fa-search"></i></a>
	<?php }?>
	<?php if ($settings['show_recent_product']) {?>
	<a class="sticky-recent" data-target="popup" data-popup="#popup-recent"><span><?php echo $text_head_recent_view;?></span><i class="fa fa-recent"></i></a>
	<?php }?>
	<?php if ($settings['show_backtop']) {?>
	<a class="sticky-backtop" data-target="scroll" data-scroll="html"><span><?php echo $text_head_gotop;?></span><i class="fa fa-angle-double-up"></i></a>
	<?php }?>

	<?php if ($settings['show_category']) {?>
	<div class="popup popup-categories popup-hidden" id="popup-categories">
		<div class="popup-screen">
			<div class="popup-position">
				<div class="popup-container popup-small">
					<div class="popup-header">
						<span><i class="fa fa-align-justify"></i><?php echo $text_all_categories?></span>
						<a class="popup-close" data-target="popup-close" data-popup-close="#popup-categories">&times;</a>
					</div>
					<div class="popup-content">
						<?php if (!empty($categories)) {?>
						<div class="nav-secondary">
							<ul>
								<?php foreach ($categories as $category) {?>
									<?php $childrens = $category['children'];?>
									<li>
										<?php if (!empty($childrens)) {?>
											<span class="nav-action">
												<i class="fa fa-plus more"></i>
												<i class="fa fa-minus less"></i>
											</span>
										<?php }?>
										<a href="<?php echo $category['href']?>"><i class="fa fa-chevron-down nav-arrow"></i><?php echo $category['name']?></a>
										<?php if (!empty($childrens)) {?>
											<ul class="level-2">
												<?php foreach ($childrens as $child) {?>
													<?php $subchildrens = $child['children'];?>
													<li>
														<?php if (!empty($subchildrens)) {?>
															<span class="nav-action">
																<i class="fa fa-plus more"></i>
																<i class="fa fa-minus less"></i>
															</span>
														<?php }?>
														<a href="<?php echo $child['href']?>"><i class="fa fa-chevron-right flip nav-arrow"></i><?php echo $child['name']?></a>
														<?php if (!empty($subchildrens)) {?>
															<ul class="level-3">
																<?php foreach ($subchildrens as $subchild) {?>
																	<li><a href="<?php echo $subchild['href']?>"><?php echo $subchild['name']?></a></li>
																<?php }?>
															</ul>
														<?php }?>
													</li>
												<?php }?>
											</ul>
										<?php }?>
									</li>
								<?php }?>
							</ul>
						</div>
						<?php }?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php }?>

	<?php if ($settings['show_cart']) {?>
	<div class="popup popup-mycart popup-hidden" id="popup-mycart">
		<div class="popup-screen">
			<div class="popup-position">
				<div class="popup-container popup-small">
					<div class="popup-html">
						<div class="popup-header">
							<span><i class="fa fa-shopping-cart"></i><?php echo $text_shopping_cart?></span>
							<a class="popup-close" data-target="popup-close" data-popup-close="#popup-mycart">&times;</a>
						</div>
						<div class="popup-content">
							<div class="cart-header">
								<?php if ($products || $vouchers) { ?>
									<div class="notification gray">
										<p><?php echo $text_items_product?></p>
									</div>
									<table class="table table-striped">
										<?php foreach ($products as $product) { ?>
											<tr>
									  			<td class="text-left first">
									  				<?php if ($product['thumb']) { ?>
									    				<a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-thumbnail" /></a>
									    			<?php } ?>
									    		</td>
									  			<td class="text-left">
									  				<a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
									    			<?php if ($product['option']) { ?>
									    				<?php foreach ($product['option'] as $option) { ?>
									    					<br />
									    					- <small><?php echo $option['name']; ?> <?php echo $option['value']; ?></small>
									    				<?php } ?>
									    			<?php } ?>
									    			<?php if ($product['recurring']) { ?>
									    				<br />
									    				- <small><?php echo $text_recurring; ?> <?php echo $product['recurring']; ?></small>
									    			<?php } ?>
									    		</td>
									  			<td class="text-right">x <?php echo $product['quantity']; ?></td>
									  			<td class="text-right total-price"><?php echo $product['total']; ?></td>
									  			<td class="text-right last"><a href="javascript:;" onclick="cart.remove('<?php echo $product['cart_id']; ?>');" title="<?php echo $button_remove; ?>"><i class="fa fa-trash"></i></a></td>
											</tr>
										<?php } ?>
										<?php foreach ($vouchers as $voucher) { ?>
											<tr>
									  			<td class="text-left first"></td>
									  			<td class="text-left"><?php echo $voucher['description']; ?></td>
									  			<td class="text-right">x&nbsp;1</td>
									  			<td class="text-right"><?php echo $voucher['amount']; ?></td>
									  			<td class="text-right last"><a href="javascript:;" onclick="voucher.remove('<?php echo $voucher['key']; ?>');" title="<?php echo $button_remove; ?>"><i class="fa fa-trash"></i></a></td>
											</tr>
										<?php } ?>
									</table>
									<div class="cart-bottom">
										<table class="table table-striped">
									  		<?php foreach ($totals as $total) { ?>
									  			<tr>
									    			<td class="text-left"><strong><?php echo $total['title']; ?></strong></td>
									    			<td class="text-right"><?php echo $total['text']; ?></td>
									  			</tr>
									  		<?php } ?>
										</table>
										<p class="text-center">
											<a href="<?php echo $cart; ?>" class="btn btn-view-cart"><strong><?php echo $text_cart; ?></strong></a>
											<a href="<?php echo $checkout; ?>" class="btn btn-checkout"><strong><?php echo $text_checkout; ?></strong></a>
										</p>
									</div>
								<?php }else {?>
									<div class="notification gray">
										<i class="fa fa-shopping-cart info-icon"></i>
										<p><?php echo $text_empty?></p>
									</div>
								<?php }?>
							</div>
						</div>			
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php }?>

	<?php if ($settings['show_account']) {?>
	<div class="popup popup-myaccount popup-hidden" id="popup-myaccount">
		<div class="popup-screen">
			<div class="popup-position">
				<div class="popup-container popup-small">
					<div class="popup-html">
						<div class="popup-header">
							<span><i class="fa fa-user"></i><?php echo $text_my_account?></span>
							<a class="popup-close" data-target="popup-close" data-popup-close="#popup-myaccount">&times;</a>
						</div>
						<div class="popup-content">
							<div class="form-content">
								<div class="row space">
									<div class="col col-sm-6 col-xs-12">
										<div class="form-box">
											<form action="<?php echo $action_currency?>" method="post" enctype="multipart/form-data" id="sticky-form-currency">
												<label class="label-top" for="input-language"><span><?php echo $text_currency?></span></label>
												<select name="select-currency" id="input-currency" class="field icon dark arrow">
													<?php foreach ($currencies as $currency) {?>
														<?php if ($currency['symbol_left']) { ?>
															<option value="<?php echo $currency['code']; ?>" <?php if ($code == $currency['code']) echo 'selected="selected"'?>><?php echo $currency['symbol_left']; ?> <?php echo $currency['title']; ?></option>
														<?php }else {?>
															<option value="<?php echo $currency['code']; ?>" <?php if ($code == $currency['code']) echo 'selected="selected"'?>><?php echo $currency['symbol_right']; ?> <?php echo $currency['title']; ?></option>
														<?php }?>
													<?php }?>											
												</select>
												<input type="hidden" name="code" value="">
												<input type="hidden" name="redirect" value="<?php echo $redirect_currency?>">
											</form>
										</div>
									</div>
									<div class="col col-sm-6 col-xs-12">
										<div class="form-box">
											<form action="<?php echo $action_language?>" method="post" enctype="multipart/form-data" id="sticky-form-language">
												<label class="label-top" for="input-language"><span><?php echo $text_language?></span></label>
												<select name="select-language" id="input-language" class="field icon dark arrow">
													<?php foreach ($languages as $language) {?>
														<?php if ($language['code'] == $code) { ?>
															<option value="<?php echo $language['code']?>" selected="selected"><?php echo $language['name']?></option>
														<?php }else{?>
															<option value="<?php echo $language['code']?>"><?php echo $language['name']?></option>
														<?php }?>
													<?php }?>
												</select>
												<input type="hidden" name="code" value="">
												<input type="hidden" name="redirect" value="<?php echo $redirect_language?>">
											</form>
										</div>
									</div>
									<div class="col col-sm-12">
										<div class="form-box">
											<div class="hr show"></div>
										</div>
									</div>
									<div class="col col-sm-4 col-xs-6 txt-center">
										<div class="form-box">
											<a class="account-url" href="<?php echo $link_order?>">
												<span class="ico ico-32 ico-sm"><i class="fa fa-history"></i></span><br>
												<span class="account-txt"><?php echo $text_history?></span>
											</a>
										</div>
									</div>
									<div class="col col-sm-4 col-xs-6 txt-center">
										<div class="form-box">
											<a class="account-url" href="<?php echo $link_cart?>">
												<span class="ico ico-32 ico-sm"><i class="fa fa-shoppingcart"></i></span><br>
												<span class="account-txt"><?php echo $text_shopping_cart?></span>
											</a>
										</div>
									</div>
									<div class="col col-sm-4 col-xs-6 txt-center">
										<div class="form-box">
											<a class="account-url" href="<?php echo $link_register?>">
												<span class="ico ico-32 ico-sm"><i class="fa fa-register"></i></span><br>
												<span class="account-txt"><?php echo $text_register?></span>
											</a>
										</div>
									</div>
									<div class="col col-sm-4 col-xs-6 txt-center">
										<div class="form-box">
											<a class="account-url" href="<?php echo $link_account?>">
												<span class="ico ico-32 ico-sm"><i class="fa fa-account"></i></span><br>
												<span class="account-txt"><?php echo $text_account?></span>
											</a>
										</div>
									</div>
									<div class="col col-sm-4 col-xs-6 txt-center">
										<div class="form-box">
											<a class="account-url" href="<?php echo $link_download?>">
												<span class="ico ico-32 ico-sm"><i class="fa fa-download"></i></span><br>
												<span class="account-txt"><?php echo $text_download?></span>
											</a>
										</div>
									</div>
									<div class="col col-sm-4 col-xs-6 txt-center">
										<div class="form-box">
											<a class="account-url" href="<?php echo $link_login?>">
												<span class="ico ico-32 ico-sm"><i class="fa fa-login"></i></span><br>
												<span class="account-txt"><?php echo $text_login?></span>
											</a>
										</div>
									</div>
								</div>
							</div>
							<div class="clear"></div>
						</div>					
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php }?>

	<?php if ($settings['show_search']) {?>
	<div class="popup popup-mysearch popup-hidden" id="popup-mysearch">
		<div class="popup-screen">
			<div class="popup-position">
				<div class="popup-container popup-small">
					<div class="popup-html">
						<div class="popup-header">
							<span><i class="fa fa-search"></i><?php echo $text_search?></span>
							<a class="popup-close" data-target="popup-close" data-popup-close="#popup-mysearch">&times;</a>
						</div>
						<div class="popup-content">
							<div class="form-content">
								<div class="row space">
									<div class="col">
										<div class="form-box">
											<input type="text" name="search" value="" placeholder="Search" id="input-search" class="field" />
											<i class="fa fa-search sbmsearch"></i>
										</div>
									</div>
									<div class="col">
										<div class="form-box">
											<button type="button" id="button-search" class="btn button-search"><?php echo $text_search?></button>
										</div>
									</div>
								</div>
							</div>
							<div class="clear"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php }?>

	<?php if ($settings['show_recent_product']) {?>
	<div class="popup popup-recent popup-hidden" id="popup-recent">
		<div class="popup-screen">
			<div class="popup-position">
				<div class="popup-container popup-small">
					<div class="popup-html">
						<div class="popup-header">
							<span><i class="fa fa-recent"></i><?php echo $text_recent_products?></span>
							<a class="popup-close" data-target="popup-close" data-popup-close="#popup-recent">&times;</a>
						</div>
						<div class="popup-content">
							<div class="form-content">
								<div class="row space">
									<?php if (!empty($recent_products)) {?>
										<?php foreach ($recent_products as $product) {?>
											<div class="col col-sm-4 col-xs-6">
												<div class="form-box">
													<div class="item">
				                                        <div class="product-thumb transition">
								                        	<div class="image">
								                        		<?php if ($product['product_special']) {?>
																	<span class="bt-sale"><?php echo $product['product_discount'];?></span>
																<?php }?>
																<?php if ($product['product_new']) {?>
																	<span class="bt-new"><?php echo $text_new ?></span>
																<?php }?>
																<a href="<?php echo $product['product_href'];?>">
																	<img src="<?php echo $product['product_image'];?>" alt="<?php echo $product['product_name'];?>" class="img-responsive" >
																</a>
								                         	</div>
									                        <div class="caption">
		                                                        <h4 class="font-ct"><a href="<?php echo $product['product_href'];?>" title="<?php echo $product['product_name'];?>" ><?php echo $product['product_name'];?></a></h4>
		                                                        <?php if ($product['product_price']) { ?>
			                                                        <p class="price">
			                                                        	<?php if (!$product['product_special']) { ?>
										                                	<span class="price-new"><?php echo $product['product_price']; ?></span>
										                                <?php } else { ?>
										                                	<span class="price-new"><?php echo $product['product_special']; ?></span>
										                                	<span class="price-old"><?php echo $product['product_price']; ?></span>
										                                <?php } ?>
										                            </p>
		                                                    	<?php }?>
		                                                    </div>
		                                                    <div class="button-group">
		                                                    	<button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');">
		                                                    		<span class=""><?php echo $button_cart; ?></span>
		                                                    	</button>
		                                                    </div>
			                                            </div>
				                                    </div>
												</div>
											</div>
										<?php }?>
									<?php }else {?>
										<div class="col col-xs-12">Has no content to show !</div>
									<?php }?>
								</div>
							</div>
							<div class="clear"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php }?>
</div>
<?php }?>