<style type="text/css">
    .news_wrap h3{
        margin-bottom: 20px;
    }
    .news_wrap .rows{
        display: flex;
        overflow-x: auto;
        justify-content: space-between;
    }
    .news_wrap .product-layout{
        width: 19%; 
    }
    .news_wrap .product-layout .caption{
        padding: 0 10px;
        min-height: 60px;
        overflow: hidden;
    }
    .news_wrap .product-layout .caption a{
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    @media screen and (max-width: 992px){
        .news_wrap .rows {
            display: flex;
            width: 100%;
            overflow-x: auto;
            gap: 20px;
            margin-bottom: 20px;
            scrollbar-color: #a8a8a8 #ffffff45 !important;
            scrollbar-width: thin;
        }
        .news_wrap .product-layout {
            min-width: 250px;
        }
    }
</style>
<div class="news_wrap container">
    <?php if ($heading_title) { ?>
        <h3 class="text-center"><?php echo $heading_title; ?></h3>
    <?php } ?>
    <?php if ($html) { ?>
        <?php echo $html; ?>
    <?php } ?>
    <div class="rows">
        <?php foreach ($articles as $article) { ?>
            <!-- <div class="product-layout col-lg-3 col-md-3 col-sm-6 col-xs-12"> -->
            <div class="product-layout">
                <div class="product-thumb transition">
                    <?php if ($article['thumb']) { ?>
                        <div class="image"><a href="<?php echo $article['href']; ?>"><img src="<?php echo $article['thumb']; ?>" alt="<?php echo $article['name']; ?>" title="<?php echo $article['name']; ?>" class="img-responsive" /></a></div>
                    <?php } ?>
                    <div class="caption">
                        <h4><a href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a></h4>
                        <?php echo $article['preview']; ?>
                    </div>
                    <?/*
                    <div class="button-group">
                        <button onclick="location.href = ('<?php echo $article['href']; ?>');" data-toggle="tooltip" title="<?php echo $text_more; ?>"><i class="fa fa-share"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_more; ?></span></button>
            		      <?php if ($article['date']) { ?><button type="button" data-toggle="tooltip" title="<?php echo $article['date']; ?>"><i class="fa fa-clock-o"></i></button><?php } ?>
            		      <button type="button" data-toggle="tooltip" title="<?php echo $article['viewed']; ?>"><i class="fa fa-eye"></i></button>
            	   </div>
                   */?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>