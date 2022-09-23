<?php if ($collections) { ?>				
	<div class="row">
		<div class="col-md-12">
			<div class="product-category-list collection-list">
				<?php foreach ($collections as $collection) { ?>
					<div class="product-layout">
						<div class="product-layout__image"><a href="<?php echo $collection['href']; ?>">
						<img src="<?php echo $collection['image']; ?>" alt="<?php echo $collection['name']; ?>" title="<?php echo $collection['name']; ?>" class="img-responsive" loading="lazy"></a>
						</div>
						
						<div class="product-layout__caption">
							<h3 class="product-layout__name"><a href="<?php echo $collection['href']; ?>"><?php echo $collection['name']; ?></a></h3>
							
							<div><?php echo $collection['mini_description']; ?></div>
						</div>
					</div>	
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>	