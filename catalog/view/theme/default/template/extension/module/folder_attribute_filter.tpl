<div class="filter" id="filter">
<div id="filter-mob" class="filter-mob">
<div class="filter__close"></div>
<form method=GET action="<?php echo $action; ?>" class="filter__form">
  <div class="widget-title"><?php echo $heading_title; ?></div>
  <div class="filter__list">


    <div class="filter-group">
    <?php if(isset($prices) AND count($prices) > 1){ ?>
      <a class="filter-group__title">Цена</a>
      <div class="filter-group__content filter-group__content--price">
        <div id="filter-group-price" class="js-range-price range-price" data-min="<?php echo $prices['min_price']; ?>" data-max="<?php echo $prices['max_price']; ?>" data-value-min="<?php echo $fprices['min_price']; ?>" data-value-max="<?php echo $fprices['max_price']; ?>" data-step="1" data-units="грн">
          <div class="range-price__input-wrap">
            <input type="text" id="min_price" name="min_price" class="range-price__input range-price__input--min" value="<?php echo $fprices['min_price']; ?>"  />
            <span>-</span>
            <input type="text" id="max_price" name="max_price" class="range-price__input range-price__input--max" value="<?php echo $fprices['max_price']; ?>" />
          </div>

          <div class="ui-slider-handle range-price__handle range-price__handle--min"></div>
          <div class="ui-slider-handle range-price__handle range-price__handle--max"></div>
        </div>
      </div>
      <div class="text-center">
        <button type="submit" id="button-ffilter" class="bbtn filter__btn filter__btn-submit"><?php echo $button_filter; ?></button>
      </div>
    <?php } ?>
    </div>

    <div class="filter-group">
		<?php if(isset($filter_manufactures) AND count($filter_manufactures) > 1){ ?>
				<a class="filter-group__title"><?php echo $manufacture_title; ?></a>
				<div class="filter-group__content scrolly">
          <div class="filter-group__search">
            <input id="manufactures-search" type="text" class="filter-group__search-input" placeholder="Поиск">
            <div class="filter-group__search-btn"><svg class="filter-group__search-btn-icon"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#search"></use></svg></div>
          </div>
					<div id="filter-group-manufacture">
       		<?php foreach ($filter_manufactures as $filter) { ?>
            <?php if(isset($filter['manufacturer_id'])){ ?>
						<div class="filter-item" data-value="<?php echo $filter['name']; ?>">
								<?php if (in_array($filter['manufacturer_id'], $ffilter_manufacturer)) { ?>
								  <label for="filter_manufacturer_<?php echo $filter['manufacturer_id']; ?>" class="check">
                    <input class="checkbox check__input filter_manufacturer_<?php echo $filter['manufacturer_id']; ?>" type="checkbox" id="filter_manufacturer_<?php echo $filter['manufacturer_id']; ?>" name="manufacturer_id[]" value="<?php echo $filter['manufacturer_id']; ?>" checked="checked" />
                    <span class="check__box"></span>
                  </label>
								<?php } else { ?>
                  <label for="filter_manufacturer_<?php echo $filter['manufacturer_id']; ?>" class="check">
								    <input class="checkbox check__input filter_manufacturer_<?php echo $filter['manufacturer_id']; ?>" type="checkbox" id="filter_manufacturer_<?php echo $filter['manufacturer_id']; ?>" name="manufacturer_id[]" value="<?php echo $filter['manufacturer_id']; ?>" />
                    <span class="check__box"></span>
                  </label>
								<?php } ?>
                <label for="filter_manufacturer_<?php echo $filter['manufacturer_id']; ?>" class="check__text"><?php echo $filter['name']; ?></label>

                <?php $filter['count'] = $filter['product_total']; ?>
                <?php if ( isset($filter['count']) && $filter['count'] > 0 ) { ?>
                  <label for="filter_manufacturer_<?php echo $filter['manufacturer_id']; ?>" class="check__count"><?php echo $filter['count']; ?></label>
                <?php } ?>
						</div>
            <?php } ?>
						<?php } ?>
					</div>
				</div>
		<?php } ?>
    </div>




	  <?php foreach ($filter_options as $option_id => $option_info) { ?>
    
        <?php if(isset($option_info['values']) AND count($option_info['values']) > 1){ ?>
          
          <div class="filter-group">
						<a class="filter-group__title"><?php echo $option_info['name']; ?></a>
            <div class="filter-group__content scrolly">
              <div id="filter-option<?php echo $option_info['option_id']; ?>">
								

                <?php foreach ($option_info['value'] as $filter) { ?>
                <div class="filter-item">
                    <?php if (isset($ofilter[$filter_group_id]) AND in_array($filter, $ofilter[$filter_group_id])) { ?>
                    <?php if(!empty($filter)){ ?>
                      <label for="ofilter_<?php echo $filter_group_id.'-'.$filter; ?>" class="check">
                        <input class="checkbox check__input" type="checkbox" id="ofilter_<?php echo $filter_group_id.'-'.$filter; ?>" name="ofilter[<?php echo $filter_group_id; ?>][]" value="<?php echo $filter; ?>" checked="checked" />
                        <span class="check__box"></span>
                      </label>
                    <?php } else { ?>
                      <label for="ofilter_<?php echo $filter_group_id.'-'.$filter; ?>" class="check">
                        <input class="checkbox check__input" type="checkbox" id="ofilter_<?php echo $filter_group_id.'-'.$filter; ?>" name="ofilter[<?php echo $filter_group_id; ?>][]" value="<?php echo $filter; ?>" />
                        <span class="check__box"></span>
                      </label>
                    <?php } ?>
                    <label for="ofilter_<?php echo $filter_group_id.'-'.$filter; ?>" class="check__text"><?php echo $filter; ?></label>
                    <?php } ?>
                </div>
                <?php } ?>

              </div>
            </div>
          </div>
        <?php } ?>
    <?php } ?>





	  <?php foreach ($filter_attribute_groups as $filter_group_id => $filter_group) { ?>
    
        <?php if(isset($filter_attributes[$filter_group_id]) AND count($filter_attributes[$filter_group_id]) > 1){ ?>
           
					 <?php //sort($filter_attributes[$filter_group_id]); ?>
						
            <div class="filter-group">
  						<a class="filter-group__title"><?php echo $filter_group['name']; ?></a>

              <?php if ($filter_group_id == 16) { ?>
              <div class="filter-group__content filter-group__content--2col">
              <?php } else { ?>
              <div class="filter-group__content scrolly">
              <?php } ?>

                <div id="filter-group<?php echo !empty($filter_group['filter_group_id'])?$filter_group['filter_group_id']:''; ?>">

                  <?php foreach ($filter_attributes[$filter_group_id] as $index => $filter) { ?>
                  <?php if(!empty($filter)){ ?>
                  <?php if ($filter_group_id == 16) { ?>
                  <div class="filter-item filter-item--img">
                  <?php } else { ?>
                  <div class="filter-item">
                  <?php } ?>
                      <?php if (isset($ffilter[$filter_group_id]) AND in_array($index, $ffilter[$filter_group_id])) { ?>
                        <label for="ffilter_<?php echo $filter_group_id.'-'.$index; ?>" class="check">
                          <input class="checkbox check__input ffilter_<?php echo $filter_group_id.'-'.md5($index); ?>" type="checkbox" id="ffilter_<?php echo $filter_group_id.'-'.$index; ?>" name="ffilter[<?php echo $filter_group_id; ?>][]" value="<?php echo $index; ?>" checked="checked" />
                          <span class="check__box"></span>
                        </label>
                      <?php } else { ?>
                        <label for="ffilter_<?php echo $filter_group_id.'-'.$index; ?>" class="check">
                          <input class="checkbox check__input ffilter_<?php echo $filter_group_id.'-'.md5($index); ?>" type="checkbox" id="ffilter_<?php echo $filter_group_id.'-'.$index; ?>" name="ffilter[<?php echo $filter_group_id; ?>][]" value="<?php echo $index; ?>" />
                          <span class="check__box"></span>
                        </label>
                      <?php } ?>
                      <label for="ffilter_<?php echo $filter_group_id.'-'.$index; ?>" class="check__text"><?php echo $filter; ?></label>
                  </div>
                  <?php } ?>
                  <?php } ?>

                </div>
              </div>
            </div>
        <?php } ?>
    <?php } ?>



  </div>
  <div class="filter__btn-group text-center">
    <button type="reset" id="button-reset" class="bbtn filter__btn filter__btn-reset">Сбросить</button>
  </div>
</form>
</div>
<script type="text/javascript"><!--
$('#button-ffilter1111').on('click', function() {
	ffilter = [];

	$('input[name^=\'ffilter\']:checked').each(function(element) {
		ffilter.push(this.value);
	});

	location = '<?php echo $action; ?>&ffilter=' + ffilter.join(',');
});

$('.filter-group__title').on('click', function(){
  $(this).toggleClass('is-open').next().toggle('300');
});

$('#button-reset').on('click', function(){
  // var rp = $('#filter-group-price');
  // var min = parseFloat( rp.data('min') );
  // var max = parseFloat( rp.data('max') );

  // rp.slider("values", 0, min);
  // rp.slider("values", 1, max);

  location = '<?php echo $action; ?>';
});


$('#manufactures-search').on('keyup', function(e){
  var str = $(this).val().toLowerCase();
  var list = $('#filter-group-manufacture');

  list.find('.filter-item').each(function(el){
    var name = $(this).data('value').toLowerCase();

    if ( ~name.indexOf(str) ) {
      $(this).show();
    } else {
      $(this).hide();
    }
  });

});







$('#min_price, #max_price').on('change', function(){
  $('form.filter__form').submit();
});

$('form.filter__form').on('change', 'input[type=checkbox]', function(){
  $('form.filter__form').submit();
});





//--></script>

</div>


