<?php if ($options || $show_price) { ?>
<div class="ocf-offcanvas ocfilter-mobile hidden-sm hidden-md hidden-lg hidden-xlg">
  <div class="ocfilter-mobile-handle">
    <button type="button" class="btn btn-primary" data-toggle="offcanvas"><i class="fa fa-filter"></i></button>
  </div>
  <div class="ocf-offcanvas-body"></div>
</div>

<!-- <h3 class="modtitle"><?php echo $heading_title; ?></h3> -->
<div class="ocfilter" id="ocfilter">
  
  <div class="hidden" id="ocfilter-button">
    <button class="btn btn-primary disabled" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Загрузка.."></button>
  </div>
  <div class="list-group">
    <?php include 'selected_filter.tpl'; ?>

    <?php include 'filter_price.tpl'; ?>

    <?php include 'filter_list.tpl'; ?>
  </div>
</div>
<script type="text/javascript"><!--
$(function() {
  $('body').append($('.ocfilter-mobile').remove().get(0).outerHTML);

	var options = {
    mobile: $('.ocfilter-mobile').is(':visible'),
    php: {
      searchButton : <?php echo $search_button; ?>,
      showPrice    : <?php echo $show_price; ?>,
	    showCounter  : <?php echo $show_counter; ?>,
			manualPrice  : <?php echo $manual_price; ?>,
      link         : '<?php echo $link; ?>',
	    path         : '<?php echo $path; ?>',
	    params       : '<?php echo $params; ?>',
	    index        : '<?php echo $index; ?>'
	  },
    text: {
	    show_all: '<?php echo $text_show_all; ?>',
	    hide    : '<?php echo $text_hide; ?>',
	    load    : '<?php echo $text_load; ?>',
			any     : '<?php echo $text_any; ?>',
	    select  : '<?php echo $button_select; ?>'
	  }
	};

  if (options.mobile) {
    $('.ocf-offcanvas-body').html($('#ocfilter').remove().get(0).outerHTML);
  }

  $('[data-toggle="offcanvas"]').on('click', function(e) {
    $(this).toggleClass('active');
    $('body').toggleClass('modal-open');
    $('.ocfilter-mobile').toggleClass('active');
  });

  setTimeout(function() {
    $('#ocfilter').ocfilter(options);
  }, 1);
});
//--></script>
<?php } ?>