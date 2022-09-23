	<?php if ( (isset($product_primenenie)  AND count($product_primenenie)) OR (isset($product_tags)  AND count($product_tags)) ){ ?>
						<br>
						<br>
						<div class="row">
							<div class="col-md-12">
								
								<?php if ( (isset($product_primenenie) AND count($product_primenenie))){ ?>
									<div class="product-tags">
										<div class="product-tags__title"><?php echo $title_primenenie; ?></div>
										<div class="product-tags__list">
											<?php
												$text = '';
												foreach ($product_primenenie as $row) {
													$text .= '<a href="'.$row['href'].'" target="_blank">'.$row['primenenie'].'</a>'.', ';
												}
												echo trim($text, ', ');
											?>
										</div>
									</div>
								<?php } ?>
								
								<?php if ( (isset($product_tags)  AND count($product_tags))){ ?>
									<div class="product-tags">
										<div class="product-tags__title"><?php echo $title_tags; ?></div>
										<div class="product-tags__list">
											<?php
												$text = '';
												foreach($product_tags as $row){
													$text .= '<a href="'.$row['href'].'" target="_blank">'.$row['tags'].'</a>'.', ';
												}
												echo trim($text, ', ');
											?>
										</div>
									</div>
								<?php } ?>
								
							</div>
						</div>
					<?php } ?>