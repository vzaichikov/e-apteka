<?php echo $header; ?>

<?php if ($tmdaccount_status==1) { ?>
				<link href="catalog/view/theme/default/stylesheet/ele-style.css" rel="stylesheet">
				<link href="catalog/view/theme/default/stylesheet/dashboard.css" rel="stylesheet">
				<div class="container dashboard">
				<?php } else { ?>
				<div class="container">
				<?php } ?>
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

<?php if ($tmdaccount_status==1) { ?>
				<link href="catalog/view/theme/default/stylesheet/ele-style.css" rel="stylesheet">
				<link href="catalog/view/theme/default/stylesheet/dashboard.css" rel="stylesheet">
				<div class="container dashboard">
				<?php } else { ?>
				<div class="container">
				<?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h2><?php echo $heading_title; ?></h2>
      <?php if ($downloads) { ?>
      <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <td class="text-right"><?php echo $column_order_id; ?></td>
            <td class="text-left"><?php echo $column_name; ?></td>
            <td class="text-left"><?php echo $column_size; ?></td>
            <td class="text-left"><?php echo $column_date_added; ?></td>
            <td></td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($downloads as $download) { ?>
          <tr>
            <td class="text-right"><?php echo $download['order_id']; ?></td>
            <td class="text-left"><?php echo $download['name']; ?></td>
            <td class="text-left"><?php echo $download['size']; ?></td>
            <td class="text-left"><?php echo $download['date_added']; ?></td>
            <td><a href="<?php echo $download['href']; ?>" data-toggle="tooltip" title="<?php echo $button_download; ?>" class="bbtn"><i class="fa fa-cloud-download"></i></a></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      </div>
      <div class="row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><?php echo $results; ?></div>
      </div>
      <?php } else { ?>
      <p><?php echo $text_empty; ?></p>
      <?php } ?>
      <div class="buttons clearfix">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="bbtn"><?php echo $button_continue; ?></a></div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<style>
			<?php echo $tmdaccount_customcss; ?>
			</style>
<?php echo $footer; ?>