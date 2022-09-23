<?php 
$devices = array('lg' => ' Desktops','md' => ' Desktops','sm' => ' Tablets','xs' => ' Phones',);
$soconfig_pages= array('catalog_column_lg'=>'3','catalog_column_md'=>'3','catalog_column_sm'=>'2',);
$button_grid = "Сетка";
$button_list = "Список";

?>
<?php echo $header; ?>

<div class="container">
	<!-- breadcrumb -->
	<ul class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
		<?php $ListItem_pos = 1; ?>
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<li itemprop="itemListElement" itemscope
		itemtype="https://schema.org/ListItem"><a href="<?php echo $breadcrumb['href']; ?>" itemprop="item"><span itemprop="name"><?php echo $breadcrumb['text']; ?></span></a><meta itemprop="position" content="<?php echo $ListItem_pos++; ?>" /></li>
		<?php } ?>
	</ul> 
	<!-- breadcrumb -->
</div>


<div class="container">
    
    <div class="row">
        <?php echo $column_left; ?>
        <?php if ($column_left && $column_right) { ?>
            <?php $class = 'col-sm-6'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
            <?php $class = 'col-md-9 col-sm-8'; ?>
        <?php } else { ?>
            <?php $class = 'col-sm-12'; ?>
        <?php } ?>
        
        <div id="content" class="<?php echo $class; ?>">
            <?php echo $content_top; ?>
			<?php if ((isset($error_no_database) && $error_no_database == '')) { ?>
            <div class="blog-header">
				<h3><?php echo $heading_title; ?></h3>
				<br>
				<?php echo (isset($description) && !empty($description)) ? $description: ''; ?>
			</div>

            <!-- Filters -->
            <div class="sort-row">
              <div class="btn-group btn-group-sm prod-list-view hidden-xs list-view">
                <button type="button" class="prod-list-view__btn grid active" data-view="grid" data-toggle="tooltip" title="<?php echo $button_grid; ?>">
                  <svg class="icon prod-list-view__icon prod-list-view__icon--grid">
                    <use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#grid-view"></use>
                  </svg>
                </button>
                <button type="button" class="prod-list-view__btn list" data-view="list" data-toggle="tooltip" title="<?php echo $button_list; ?>">
                  <svg class="icon prod-list-view__icon prod-list-view__icon--list">
                    <use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#list-view"></use>
                  </svg>
                </button>
              </div>
              <div class="pagination-wrap"><?php echo $pagination; ?></div>
          	</div>			
			<!-- //end Filters -->

            <div class="blog-listitem">
                <?php if($articles) { ?>
                    <?php foreach($articles as  $id_article => $article) { ?>                            
                    <div class="blog-item">
						<?php if($article['image']) { ?>
						<div class="itemBlogImg left-block">
							<div class="article-image banners ">
								<div>
									<a href="<?php echo $article['href']; ?>" title="<?php echo $article['article_title']; ?>"><img  src="<?php echo $article['image']; ?>" alt="<?php echo $article['article_title']; ?>" /></a>
								</div>
							</div>
						</div>
						<?php } ?>
						<div class="itemBlogContent right-block">
					  		<!-- NAME TITLE-->
							<div class="article-title">
								<h3><a href="<?php echo $article['href']; ?>"><?php echo $article['article_title']; ?></a></h3>
							</div>
							<!-- COMMENT -->
					  		<div class="blog-meta">
					  			<!--<span class="author"><i class="fa fa-user"></i><span></span><?php echo $article['author_name']; ?></span>-->
								<?php if($article['allow_comment']) { ?>
									<span class="comment_count"><i class="fa fa-comment-o"></i><a href="<?php echo $article['comment_href']; ?>#comment-section"><?php echo $article['total_comment']; ?></a></span>
								<?php } ?>												
								<span class="article-date" >
								    <h4 style="font-size:15px;"><i class="fa fa-calendar"></i><?php echo $article['date_added'];?></h4>
								</span>
							</div>
							
						 	<!-- DESCRIP -->
							<p class="article-description information-text-style hidden" >
								 <?php echo $article['description'];?>
							</p>
							<a class="btn btn-default hidden" href="<?php echo $article['href']; ?>"><b><?php echo $button_continue_reading; ?></b><i class="fa fa-angle-right"></i></a>
						 
						</div>
                         
                                                        
                    </div>
                    <?php } ?>
                    
					
                       
                <?php } else { ?>
                    <div class="col-xs-12">
						<h3 class="text-center"><?php echo $text_no_found; ?></h3>
					</div>
                <?php } ?>
            </div> 
			


            <!-- Filters -->
            <div class="sort-row">
              <div class="btn-group btn-group-sm prod-list-view hidden-xs list-view">
                <button type="button" class="prod-list-view__btn grid active" data-view="grid" data-toggle="tooltip" title="<?php echo $button_grid; ?>">
                  <svg class="icon prod-list-view__icon prod-list-view__icon--grid">
                    <use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#grid-view"></use>
                  </svg>
                </button>
                <button type="button" class="prod-list-view__btn list" data-view="list" data-toggle="tooltip" title="<?php echo $button_list; ?>">
                  <svg class="icon prod-list-view__icon prod-list-view__icon--list">
                    <use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#list-view"></use>
                  </svg>
                </button>
              </div>
              <div class="pagination-wrap"><?php echo $pagination; ?></div>
          	</div>			
			<!-- //end Filters -->

			<?php }else{?>
				<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
					<?php echo $error_no_database; ?>
				</div>
			<?php } ?>
			
            <?php echo $content_bottom; ?>
        </div>            
        
        <?php echo $column_right; ?>
    </div>        
</div>


<script type="text/javascript"><!--
function display(view) {
	$('.blog-listitem').removeClass('list grid').addClass(view);
	$('.list-view button').removeClass('active');
	if(view == 'list') {
		$('.blog-listitem .blog-item .article-description').removeClass('hidden')
		$('.list-view .' + view).addClass('active');
		// $.cookie('simple_blog_category', 'list');
		localStorage.setItem('simple_blog_category', 'list');
	}else{
		$('.blog-listitem .blog-item .article-description').addClass('hidden');
		$('.list-view .' + view).addClass('active');
		// $.cookie('simple_blog_category', 'grid');
		localStorage.setItem('simple_blog_category', 'grid');
	}
}


$(document).ready(function () {
	// Check if Cookie exists
	// if($.cookie('simple_blog_category')){
	if(localStorage.getItem('simple_blog_category')){
		// view = $.cookie('simple_blog_category');
		view = localStorage.getItem('simple_blog_category');
	}else{
		view = 'grid';
	}
	if(view) display(view);
	
	// Click Button
	$('.list-view button').each(function() {
		var ua = navigator.userAgent,
		event = (ua.match(/iPad/i)) ? 'touchstart' : 'click';
		$(this).bind(event, function() {
			$(this).addClass(function() {
				if($(this).hasClass('active')) return ''; 
				return 'active';
			});
			$(this).siblings('button').removeClass('active');
			$catalog_mode = $(this).data('view');
			display($catalog_mode);
		});
		
	});
});
//--></script>



<?php echo $footer; ?>
