<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="bg-page-404 <?php echo $class; ?>">
		<?php echo $content_top; ?>
		<div class="col-sm-7 text-center">
				<div style="margin: 30px 0 50px"><img src="image/catalog/404/404-img-text.png" alt=""></div>
				<h1><?php echo $heading_title; ?></h1>
				<p><?php echo $text_error; ?></p>
				<a href="<?php echo $continue; ?>" class="btn btn-primary" title="<?php echo $button_continue; ?>"><?php echo $button_continue; ?></a>
			</div>
		
			<div class="col-sm-5">
				 <img src="image/catalog/404/404-image.png" alt="">
			</div>
		<?php echo $content_bottom; ?> </div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>
