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
      <h1><?php echo $heading_title; ?></h1>
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <td class="text-left" colspan="2"><?php echo $text_return_detail; ?></td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-left" style="width: 50%;"><b><?php echo $text_return_id; ?></b> #<?php echo $return_id; ?><br />
              <b><?php echo $text_date_added; ?></b> <?php echo $date_added; ?></td>
            <td class="text-left" style="width: 50%;"><b><?php echo $text_order_id; ?></b> #<?php echo $order_id; ?><br />
              <b><?php echo $text_date_ordered; ?></b> <?php echo $date_ordered; ?></td>
          </tr>
        </tbody>
      </table>
      <h3><?php echo $text_product; ?></h3>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td class="text-left" style="width: 33.3%;"><?php echo $column_product; ?></td>
              <td class="text-left" style="width: 33.3%;"><?php echo $column_model; ?></td>
              <td class="text-right" style="width: 33.3%;"><?php echo $column_quantity; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-left"><?php echo $product; ?></td>
              <td class="text-left"><?php echo $model; ?></td>
              <td class="text-right"><?php echo $quantity; ?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <h3><?php echo $text_reason; ?></h3>
      <div class="table-responsive">
        <table class="list table table-bordered table-hover">
          <thead>
            <tr>
              <td class="text-left" style="width: 33.3%;"><?php echo $column_reason; ?></td>
              <td class="text-left" style="width: 33.3%;"><?php echo $column_opened; ?></td>
              <td class="text-left" style="width: 33.3%;"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-left"><?php echo $reason; ?></td>
              <td class="text-left"><?php echo $opened; ?></td>
              <td class="text-left"><?php echo $action; ?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <?php if ($comment) { ?>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td class="text-left"><?php echo $text_comment; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-left"><?php echo $comment; ?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <?php } ?>
      <h3><?php echo $text_history; ?></h3>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td class="text-left" style="width: 33.3%;"><?php echo $column_date_added; ?></td>
              <td class="text-left" style="width: 33.3%;"><?php echo $column_status; ?></td>
              <td class="text-left" style="width: 33.3%;"><?php echo $column_comment; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($histories) { ?>
            <?php foreach ($histories as $history) { ?>
            <tr>
              <td class="text-left"><?php echo $history['date_added']; ?></td>
              <td class="text-left"><?php echo $history['status']; ?></td>
              <td class="text-left"><?php echo $history['comment']; ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td colspan="3" class="text-center"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
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
