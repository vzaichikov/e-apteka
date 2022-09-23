<!doctype html>
<html ⚡>
	<head>
		<meta charset="utf-8">
		<title><?php echo $meta_title; ?></title>
		<meta itemprop="description" content="<?php echo str_replace(array('"', "'"), '',$meta_description); ?>">
		<meta itemprop="image" content="<?php echo $thumb; ?>">
		<meta property="og:title" content="<?php echo $meta_title; ?>">
		<meta property="og:type" content="article">
		<meta property="og:image" content="<?php echo $thumb; ?>">
		<meta property="og:url" content="<?php echo $current; ?>">
		<meta property="og:description" content="<?php echo $meta_description; ?>">
		<meta property="og:site_name" content="<?php echo $name; ?>">
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="theme-color" content="<?php echo $amp_product_pro_back_color;?>">
		<meta name="application-name" content="<?php echo $meta_title; ?>">
		<link rel="canonical" href="<?php echo $canonical; ?>" >
		<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
		<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
		<style amp-custom>
			html {overflow-x:hidden}
			body,html{height:auto}
			body {
			margin:0;-webkit-text-size-adjust:100%;-moz-text-size-adjust:100%;-ms-text-size-adjust:100%;text-size-adjust:100%
			}
			body {
			font-family: 'Roboto', Arial;
			}
			a {
			text-decoration:none;
			color: <?php echo $amp_product_pro_link_color; ?>;	
			}
			.h4,h4 {
			font-size: 1.125rem;
			line-height: 1.5rem
			}
			.box1 {
			font-size: 13px;
			line-height: 19px;
			margin-bottom: 15px;
			margin: 8px 0;
			}
			.image-wrapper img {
			display: block;
			width: 1px;
			min-width: 100%;
			margin: auto;
			height: auto;
			min-height: 0;
			}
			.amp-logo {
			width: 228px;
			height: 42px;
			margin: 0 auto;
			top: 2px;
			display: block;
			background-size: contain;
			background-repeat: no-repeat;
			background-position: 50% 50%;   
			}
			.amp-header{
			border-bottom: 1px solid #e0e0e0;
			height: 100%;
			line-height: 45px;
			vertical-align: middle;
			font-style: italic;
			font-size: 13px;
			background-color: <?php echo $amp_product_pro_back_color;?>;
			}
			.breadcrumb {
			list-style:none;
			background: none;
			font-size: 13px;
			padding:5px;
			margin-bottom: 5px;
			}
			.breadcrumb > li{
			display: inline;
			}
			.breadcrumb > li+li:before {
			content: "/\00a0";
			padding: 0 5px;
			color: #ccc;
			}
			.product__price-wrap.product__not-in-stock {
			background-color: #e6e6e6;
			padding: 15px 20px;
			margin-bottom: 5px;
			}
			.product__price{
			font-size: 30px;
			font-weight: 700;
			line-height: 33.53px;
			}
			.price .priceBig{
			margin-top: 0;
			margin-bottom: 15px;
			font-size: 30px;
			font-family: inherit;
			font-weight: 500;
			line-height: 1.1;
			color: inherit;
			}
			.price .price-old{
			color: #e4003a;
			text-decoration: line-through;
			font-size: 16px;
			font-weight: 300;
			display: block;
			margin-bottom: 5px;
			}
			.price .tax,
			.price .points{
			color: #777;
			font-size: 14px;
			font-weight: 300;
			display: block;
			margin-top: 10px;
			}
			.amp_wrapper {
			margin: 0 10px;
			}
			.amp-page_footer {
			text-align: right;
			height: 30px;
			line-height: 30px;
			}
			.amp-page_footer_link {
			display: inline-block;
			vertical-align: middle;
			text-decoration: none;
			font-size: 13px;
			}
			#button-cart {
			display: block;
			text-decoration:none;
			background-color: <?php echo $amp_product_pro_cart_color;?>;
			}
			.btn {
			text-transform: uppercase;
			-webkit-transition: .2s ease-out;
			-moz-transition: .2s ease-out;
			-o-transition: .2s ease-out;
			-ms-transition: .2s ease-out;
			transition: .2s ease-out;
			padding: 12px 1em;
			font-size: 18px;
			text-align: center;
			vertical-align: middle;
			-ms-touch-action: manipulation;
			touch-action: manipulation;
			cursor: pointer;
			background-image: none;
			border: 1px solid transparent;
			white-space: nowrap;
			line-height: 1.42857143;
			color: #fff;
			transition: all .2s;
			border-radius: 4px;
			text-shadow: 0 -1px 0 rgba(0,0,0,.25);
			}
			.clearfix:after {
			content: "";
			display: table;
			clear: both;
			}
			.related-items a{
			width: 48%;
			margin-left: 3px;
			float: left;
			margin-right: 3px;
			height: auto;
			box-shadow: 0 0 0 0 ;
			}
			.related-items amp-img{
			width: 48%;
			margin-left: 3px;
			margin-right: 3px;
			
			}
			.related-products h2{
			text-transform:uppercase;
			text-align: center;
			}
			polygon{
			fill:#EFCE4A;
			}
			.amp-carousel-item amp-img {
			display: block;
			margin-top:3px;
			}
			.amp-carousel-item {
			position: relative;
			margin-left: 3px;
			margin-top: 3px;
			margin-bottom: 3px;
			border-radius: 4px;
			overflow: hidden;
			height:320px;
			box-shadow: 0 0 3px 0 rgba(0,0,0,.4);
			display:inline-block;
			}
			.-amp-slide-item>* {
			height:auto; 
			width:auto;  
			}
			.amp-carousel-button.amp-disabled {
			visibility: visible;
			/* choose our own background styling, red'ish */
			background-color: rgba(255, 0, 0, .5);
			}
			.amp-header #sample-menu {
			position:absolute;
			top:0;
			left: 0;
			font-size: 18px;
			font-weight: 700;
			color: white;
			text-transform: uppercase;
			padding: 13px;
			}
			.icon-bar {
			display: block;
			width: 22px;
			height: 3px;
			background-color: #cccccc;
			border-radius: 1px;
			margin-bottom: 4px;
			}
			.amp-header form {
			padding: 0;
			}
			.amp-header input::-webkit-search-decoration,
			.amp-header input::-webkit-search-cancel-button {
			display: none;
			}
			.amp-header #search {
			position:absolute;
			top:6px; right:8px;
			background-color: <?php echo $amp_product_pro_search_color;?>;
			background-position: center;
			background-repeat: no-repeat;
			background-image: -webkit-image-set(
			url('/image/ic_search_white_1x_web_24dp.png') 1x,
			url('/image/ic_search_white_2x_web_24dp.png') 2x
			);
			border: 0 none;
			height: 32px;
			width: 36px;
			-webkit-appearance: none;
			border-radius: 4px;
			-moz-border-radius: 4px;
			-webkit-border-radius: 4px;
			}
			#drawermenu li, #drawermenu ul{
			list-style: none;
			}
			.ampstart-headerbar-nav .ampstart-nav-item {
			padding-right: 1rem
			}
			
			.ampstart-headerbar-nav .ampstart-nav-item.www-current-page {
			color: #066573
			}
			
			.ampstart-nav-item.www-current-page:after,.www-component-anchor[selected]:after {
			content: "";
			display: block;
			height: 4px;
			background: linear-gradient(90deg,#94103e 0,#db004d)
			}
			.tabButton {
			list-style: none;
			text-align: center;
			cursor: pointer;
			outline: none;
			}
			
			amp-selector [option][selected] {
			outline: #fff;
			}
			.tabButton[selected]+.tabContent {
			display: block;
			}
			.ampstart-headerbar-nav .ampstart-nav-item {
			padding: 0 1.5rem;
			background: 0 0;
			opacity: .8;
			}
			.tabContent {
			line-height: 1.5rem;
			display: none;
			width: 100%;
			order: 1;  
			}
			
			.tabButton[selected]::after {
			content: '';
			display: block;
			height: 4px;
			background: linear-gradient(90deg,#94103e 0,#db004d);
			}
			
			.tabButton[selected]+.tabContent {
			display: block;
			}
			.ampTabContainer {
			display: flex;
			flex-wrap: wrap;
			padding-top: 2em;
			}
		</style>
		<script type="application/ld+json">
			{
				"@context": "http://schema.org/",
				"@type": "Product",
				"name": "<?php echo prepareEcommString($heading_title); ?>",
				"image": "<?php echo $thumb; ?>",
				"description": "<?php echo strip_tags(preg_replace('/<\/font[^>]*>/', '', preg_replace('/<font[^>]*>/', '', $description)));  ?>",
				"brand": {
					"name": "<?php echo prepareEcommString($manufacturer); ?>"
				},
				<?php if ($rating) { ?>
					"aggregateRating": {
						"@type": "AggregateRating",
						"ratingValue": "<?php echo $rating; ?>",
						"reviewCount": "<?php echo preg_replace("/\D/","",$reviews); ?>"
					},
				<?php } ?>
				"offers": {
					"@type": "Offer",
					"priceCurrency": "<?php echo $currency_code; ?>",
					<?php if (!$special) { ?>
						"price": "<?php echo $product_price; ?>",
						<?php } else { ?>
						"price": "<?php echo $product_special; ?>",
					<?php }?>
					"priceValidUntil": "2020-11-05",
					"itemCondition": "http://schema.org/NewCondition",
					"availability": "http://schema.org/InStock",
					"seller": {
						"@type": "Retail",
						"name": "<?php echo $name ?>"
					}
				}
			}
		</script>
		<style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
		<script async src="https://cdn.ampproject.org/v0.js"></script>
		<script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>
		<script async custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-0.1.js"></script>
		<script async custom-element="amp-selector" src="https://cdn.ampproject.org/v0/amp-selector-0.1.js"></script>
		<script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>		
	</head>
	<body>
		<amp-analytics type="gtag" data-credentials="include">
			<script type="application/json">
				{
				"vars" : {
				"gtag_id": "UA-120635150-1",
				"config" : {
				"UA-120635150-1": { "groups": "default" }
				}
				}
				}
			</script>
		</amp-analytics>
		<amp-sidebar id="drawermenu" layout="nodisplay">
			<li>
				<h4 class="category"><a href="/"><?php echo $text_home; ?></a></h4>
			</li>
			<?php foreach ($categories as $category) { ?>
				<?php if ($category['children']) { ?>
					<li>
						<h4 class="category">
							<a href="<?php echo $category['href']; ?>">
								<?php echo $category['name']; ?>
							</a>
						</h4>
						<?php foreach (array_chunk($category['children'], ceil(count($category['children']) / $category['column'])) as $children) { ?>
							<ul class="list-unstyled">
								
								<?php foreach ($children as $child) { ?>
									<li>
										<h4 class="category">
											<a href="<?php echo $child['href']; ?>">
												<?php echo $child['name']; ?>
											</a>
										</h4>
									</li>
								<?php } ?>
							</ul>
						<?php } ?>
					</li>
					<?php } else { ?>
					<li>
						<h4 class="category">
							<a href="<?php echo $category['href']; ?>">
								<?php echo $category['name']; ?>
							</a>
						</h4>
					</li>
				<?php } ?>
			<?php } ?>
		</amp-sidebar>
		<div>
			<div class="amp-header">
				<a id="sample-menu" on="tap:drawermenu.toggle">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a href="<?php echo $home; ?>" class="amp-header_link">
					<amp-img src="<?php echo $logo; ?>" width="<?php echo $amp_product_pro_logo_width; ?>" height="<?php echo $amp_product_pro_logo_height; ?>" alt="an image" class="amp-logo i-amp-element i-amp-layout-fixed i-amp-layout-size-defined i-amp-layout" >
					</amp-img>
				</a>
				<a href="<?php echo $amp_product_pro_search; ?>" id="search"></a>
			</div>
			<div class="amp_wrapper">
				<ol class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
					<?php $i = 0; ?>
					<?php foreach ($breadcrumbs as $key => $breadcrumb) { ?>
						<?php $i++; ?>
						<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
							<a itemprop="item" href="<?php echo $breadcrumb['href']; ?>">
							<span itemprop="name"><?php echo $breadcrumb['text']; ?></span></a>
							<meta itemprop="position" content="<?php echo $i; ?>" />
						</li>
					<?php } ?>
				</ol>
				<h1 itemprop="name">
					<?php echo $heading_title; ?>
				</h1>
				<?php if ($thumb || $images) { ?>
					<?php if (!$images) { ?>
						<amp-img alt="<?php echo $heading_title; ?>" src="<?php echo $thumb; ?>" height="<?php echo $amp_product_pro_image_height; ?>" width=<?php echo $amp_product_pro_image_width; ?> layout="responsive" ></amp-img>
						<?php } else { ?>
						<amp-carousel id="image-carousel" width="<?php echo $amp_product_pro_image_width; ?>" height="<?php echo $amp_product_pro_image_height; ?>" layout="responsive" type="slides" class="show">
							<amp-img alt="<?php echo $heading_title; ?>" src="<?php echo $thumb; ?>" height="<?php echo $amp_product_pro_image_height; ?>" width=<?php echo $amp_product_pro_image_width; ?> layout="responsive" ></amp-img>
							<?php foreach ($images as $image) { ?>
								<amp-img src="<?php echo $image['thumb']; ?>" width="<?php echo $amp_product_pro_image_width; ?>" height="<?php echo $amp_product_pro_image_height; ?>" layout="responsive">
								</amp-img>
							<?php } ?>
						</amp-carousel>
					<?php } ?>
				<?php } ?>
				
				<?php if ($amp_product_pro_enable_rating) { ?>
					<?php if ($rating) { ?>
						<span class="stars">
							
							<?php for ($i = 1; $i <= 5; $i++) { ?>
								<?php if ($rating < $i) { ?>
									
									<?php } else { ?>
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="star-a" x="0px" y="0px" viewBox="0 0 53.867 53.867" width="13px" height="13px" xml:space="preserve">
										<polygon points="26.934,1.318 35.256,18.182 53.867,20.887 40.4,34.013 43.579,52.549 26.934,43.798   10.288,52.549 13.467,34.013 0,20.887 18.611,18.182 "/>
									</svg>
								<?php } ?>
							<?php } ?>	
						</span>
					<?php } ?>
				<?php } ?>
				<div class="amp-product_info box1">
					<?php if ($manufacturer) { ?>
						<br />
						<b><?php echo $text_manufacturer; ?></b>
						<a href="<?php echo $manufacturers; ?>">
							<?php echo $manufacturer; ?>
						</a>
					<?php } ?>
					<br />
					<b><?php echo $text_model; ?></b>
					<?php echo $model; ?>
					<?php if ($reward) { ?>
						<br />
						<b><?php echo $text_reward; ?></b>
						<?php echo $reward; ?>
					<?php } ?>
					<br />
					<b><?php echo $text_stock; ?></b>
					<?php echo $stock; ?>
				</div>
				<?php if ($quantity_stock > 0) { ?>
					<?php if ($price) { ?>
						<div class="price">
							<?php if (!$special) { ?>
								<div class="priceBig">
									<span><?php echo $price; ?></span>
									<?php if ($tax) { ?>
										<span class="tax"><?php echo $text_tax; ?> <?php echo $tax; ?></span>
									<?php } ?>
									<?php if ($points) { ?>
										<span class="points"><?php echo $text_points; ?> <strong><?php echo $points; ?></strong></span>
									<?php } ?>
								</div>
								<?php } else { ?>
								<div class="priceBig">
									<span class="price-old">&nbsp;<?php echo $price; ?>&nbsp;</span>
									<span><?php echo $special; ?></span>
									<?php if ($tax) { ?>
										<span class="tax"><?php echo $text_tax; ?> <?php echo $tax; ?></span>
									<?php } ?>
									<?php if ($points) { ?>
										<span class="points"><?php echo $text_points; ?> <strong><?php echo $points; ?></strong></span>
									<?php } ?>
								</div>
							<?php } ?>
							<?php if ($discounts) { ?>
								<div class="alert-alt alert-info-alt">
									<?php foreach ($discounts as $discount) { ?>
										<div><strong><?php echo $discount['quantity']; ?></strong>
										<?php echo $text_discount; ?><strong><?php echo $discount['price']; ?></strong></div>
									<?php } ?>
								</div>
							<?php } ?>
						</div>
					<?php } ?>
					<a href="<?php echo $amp_cart; ?>" id="button-cart" class="btn btn-block btn-danger btn-large">
						<?php echo $button_cart; ?>
					</a>
					<?php } else { ?>
					<div class="product__price-wrap product__not-in-stock">
						<span class="product__price"><?php echo $text_not_in_stock; ?></span>
					</div>
				<?php } ?>
				<amp-selector role="tablist"
				layout="container"
				class="ampTabContainer ampstart-headerbar-nav">
					<div role="tab"
					class="tabButton h4 ampstart-nav-item"
					selected
					option="a"><?php echo $tab_description; ?></div>
					<div role="tabpanel"
					class="tabContent p1 p"><?php echo preg_replace('/<\/font[^>]*>/', '', preg_replace('/<font[^>]*>/', '', $description));  ?></div>
					<?php if ($attribute_groups) { ?>
						<div role="tab"
						class="tabButton h4 ampstart-nav-item"
						option="b"><?php echo $tab_attribute; ?></div>
						<div role="tabpanel"
						class="tabContent p1 p">
							<table class="table table-bordered">
								<?php foreach ($attribute_groups as $attribute_group) { ?>
									<thead>
										<tr>
											<td colspan="2"><strong><?php echo $attribute_group['name']; ?></strong></td>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($attribute_group['attribute'] as $attribute) { ?>
											<tr>
												<td>
													<?php echo $attribute['name']; ?>
												</td>
												<td>
													<?php echo $attribute['text']; ?>
												</td>
											</tr>
										<?php } ?>
									</tbody>
								<?php } ?>
							</table></div>
					<?php } ?>
					<div role="tab"
					class="tabButton h4 ampstart-nav-item"
					option="c"><?php echo $reviews; ?></div>
					<div role="tabpanel"
					class="tabContent p1 p"><?php if ($reviews_data) { ?>
						<?php foreach ($reviews_data as $review) { ?>
							<div class="review_list">
								<div class="name_date">
									<div class="name"><b><?php echo $review['author']; ?></b></div>
									<div class="rating">
										<?php for ($i = 1; $i <= 5; $i++) { ?>
											<?php if ($review['rating'] < $i) { ?>
												
												<?php } else { ?>
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="star-a" x="0px" y="0px" viewBox="0 0 53.867 53.867" width="13px" height="13px" xml:space="preserve">
													<polygon points="26.934,1.318 35.256,18.182 53.867,20.887 40.4,34.013 43.579,52.549 26.934,43.798   10.288,52.549 13.467,34.013 0,20.887 18.611,18.182 "/>
												</svg>
											<?php } ?>
										<?php } ?>
									</div>
									<div class="date"><?php echo $review['date_added']; ?></div>
								</div>
								<div class="comment">
									<div><?php echo $text_comment; ?></div>
									<?php echo $review['text']; ?>
								</div>
							</div>
						<?php } ?>
						<?php } else { ?>
						<p><?php echo $text_no_reviews; ?></p>
					<?php } ?></div>
				</amp-selector>
				<?php if ($enable_rel_products){ ?>
					<?php if ($products) { ?>
						<div class="related-products">
							<h2>
								<?php echo $text_related; ?>
							</h2>
							<div class="panel-body" id="related-products">
								<?php if ($amp_product_pro_enable_carousel_rel){ ?>
									<amp-carousel controls height="<?= $carousel_rel_conatiner; ?>" layout="fixed-height">
										<?php } else { ?>
										<div class="related-items">
										<?php } ?>
										<?php foreach ($products as $product) { ?>
											<a href="<?php echo $product['href']; ?>" class="amp-carousel-item">
												
												<amp-img alt="<?php echo $product['name']; ?>" 
												src="<?php echo $product['thumb']; ?>" width=<?php echo $carousel_rel_width; ?> height=<?php echo $carousel_rel_height; ?> <?php if (!$amp_product_pro_enable_carousel_rel){ echo 'layout="responsive"';}?>></amp-img> 
												<div class="caption">
													<div class="name"><?php echo $product['name']; ?></div>
													<?php if ($product['price']) { ?>
														<div class="price">
															<?php if (!$product['special']) { ?>
																<?php echo $product['price']; ?>
																<?php } else { ?>
																<span class="price-old">&nbsp;<?php echo $product['price']; ?>&nbsp;</span> <span class="price-new"><?php echo $product['special']; ?></span>
															<?php } ?>
															<?php if ($product['tax']) { ?>
																<br /><span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
															<?php } ?>
														</div>
													<?php } ?>
												</div>
											</a>
										<?php } ?>
										<?php if ($amp_product_pro_enable_carousel_rel){ ?>
										</amp-carousel>
										<?php } else { ?>
									</div>
								<?php } ?>
								
							</div>
						</div>
						<div class="clearfix"></div>
					<?php } ?>
				<?php } ?>
			</div>
			<div class="amp-page_footer">
				<a href="<?php echo $base; ?>" class="amp-page_footer_link">
				<span><?php echo $name ?></span></a>
				<span>© 2017</span>
				
			</div>
		</div>
	</body>
</html>		