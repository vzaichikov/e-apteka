<div class="rows">
	<?php if (!empty($histories) || (!empty($populars))) { ?>
		<div class="left_block left_block__history_block" style="flex-basis:100%">
			
			<?php if (!empty($histories)) { ?>
				<div class="evinent-search-group">
					<?php foreach ($histories as $history) { ?>
						<div class="history_item">
							<a href="<?php echo $history['href']; ?>"><i class="fa fa-history"></i> <?php echo $history['text']; ?><?php if ($history['date_added']) { ?> <span class="search_results_total">(<?php echo $history['date_added']; ?>)</span><?php } ?></a>
							<button class="clear_history_btn" onclick="removeHistory('<?php echo $history['id']?>');"><i class="fa fa-remove"></i></button>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
			
			<?php if (!empty($populars)) { ?>
				<div class="evinent-search-group">
					<?php foreach($populars as $popular) { ?>
						<a href="<?php echo $popular['href']; ?>"><i class="fa fa-search"></i> <?php echo $popular['text']; ?><?php if ($popular['results']) { ?> <span class="search_results_total">(<?php echo $popular['results']; ?>)</span><?php
						} ?></a>
					<?php } ?>
				</div>
			<? } ?>
		</div>
	<?php } ?>
	
	<?php if ($results_count) { ?>
		<?php if($results['c'] || $results['ocfp']  || $results['s']) { ?>
			<div class="left_block <?php if (!$results['p']) { ?>two_column<?php } ?>">
				
				<?php if ($results['s']) { ?>
					<div class="autocomplete_search">
						<?php foreach ($results['s'] as $suggestion) { ?>
							<div>
								<a data-id="<? echo $suggestion['id']; ?>" href="<?php echo $suggestion['href']; ?>">
									<i class="fa fa-search"></i> <?php echo $suggestion['name']; ?>
								</a>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
				
				
				<!-- это блок с подсказками к поиску -->
				<?php if ($results['c']) { ?>
					<div class="item_history">
						<div class="evinent-search-group">
							<?php foreach ($results['c'] as $category) { ?>
								
								<a data-id="<? echo $category['id']; ?>" href="<?php echo $category['href']; ?>">
									<i class="fa fa-bars"></i> <?php echo $category['name']; ?>
								</a>
								
							<?php } ?>
						</div>
					</div>
				<? } ?>
				
				<?php if ($results['ocfp']) { ?>
					<!-- это блок поиска по Коллекции -->
					<div class="evinent-search-group">
						<ul>
							<?php foreach ($results['ocfp'] as $ocfp) { ?>
								<li data-id="<? echo $ocfp['id']; ?>">
									<a href="<?php echo $ocfp['href']; ?>">
										<i class="fa fa-bars"></i><span class="name"><?php echo $ocfp['name']; ?>
										</a>
									</li>
								<?php } ?>
							</ul>
						</div>
					<? } ?>
				</div>
			<?php } ?>
			<?php if ($results['p']) { ?>
				<div class=" <?php if($results['c'] || $results['ocfp']) { ?>right_block<?php } ?>">
					<!-- товары по поиску -->
					<div class="product_list">
						<?php foreach ($results['p'] as $product) { ?>
							<div class="product_item">
								<a href="<?php echo $product['href']; ?>">
									<div class="img">
										<img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>">
									</div>
									<span class="about_product">
										<span class="name"><?php echo $product['name']; ?></span>
										<span class="product_price">
											<?php if ($product['special']) { ?>
												<div class="special_wrap">
													<span class="new"><?php echo $product['special']; ?></span><span class="old"><?php echo $product['price']; ?></span><span class="saved">-<?php echo $product['saving']; ?>%</span>
												</div>
												
												<?php } else { ?>
												<span class="new"><?php echo $product['price']; ?></span>
											<?php } ?>
										</span>
									</span>
								</a>
							</div>
						<? } ?>
					</div>
				</div>
			<?php } ?>
			<?php } else { ?>
			<?php if (empty($histories) && empty($populars)) { ?>
				<div><i class="fa fa-sad-tear"></i> <?php echo $text_retranslate_search_nothing_found; ?></div>
			<?php } ?>
		<? } ?>
	</div>
	
	
	<!--/search-->
