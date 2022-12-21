<style>
	.row-shipping_address_country_id{display:none!important;}
	.row-shipping_address_novaposhta_city_guid{display:none!important;}
	.row-shipping_address_riverside_availability{display:none!important;}    
    .optWrapper > ul.options > li.opt.disabled {display:none!important;}
    b.drugstore-radio-head{color:#0385c1; font-size:16px;}
    b.drugstore-radio-head.grey{color:#888; font-size:16px;}
    .el-radio-style .text-success{padding-left:10px;}
    .el-radio-style .text-warning{padding-left:10px;}
    
    .loadingspan {float: right; margin-right: 6px; margin-top: -20px;position: relative;z-index: 2;color: red;}
</style>

<div class="simplecheckout-block" id="simplecheckout_shipping_address" <?php echo $hide ? 'data-hide="true"' : '' ?> <?php echo $display_error && $has_error ? 'data-error="true"' : '' ?>>
    <?php if ($display_header) { ?>
        <div class="checkout-heading panel-heading"><i class="fa fa-map-marker"></i> <?php echo $text_checkout_shipping_address ?></div>
    <?php } ?>
    <div class="simplecheckout-block-content">
        <?php foreach ($rows as $row) { ?>
            <?php echo $row ?>
        <?php } ?>
        <?php foreach ($hidden_rows as $row) { ?>
            <?php echo $row ?>
        <?php } ?>
    </div>
</div>

<script>
    function initCityTriggers(){
        
        if ($('input#shipping_address_city').length == 0){
            console.log('pass init City');
            return;
        }
        
        $('input#shipping_address_city').blur();
        $('select#shipping_address_city_select').select2('destroy');
        $('select#shipping_address_city_select').remove();
        
        <?php $cityGuidFieldID = 'shipping_address_novaposhta_city_guid'; ?>
        
        $('input#shipping_address_city').on('click keyup keydown contextmenu', function(ev){
            ev.preventDefault();
        
            $('select#shipping_address_city_select').select2('destroy');
            $('select#shipping_address_city_select').remove();
            $('input#shipping_address_city').prop( "disabled", true );
            
            $('input#shipping_address_city').after('<select id="shipping_address_city_select" lang="ru"></select>');
            
            $('select#shipping_address_city_select').select2({
                language: 'ru',
                ajax: {
                    url: 'index.php?route=eapteka/checkout/suggestCities',
                    dataType: 'json',                        
                    data: function (params) {
                        var query = {
                            query: params.term,
                        }                        
                        return query;
                    }
                },
                templateSelection: function (data, container) {                            
                    $('input#shipping_address_city').val(data.text);
                    $('input#<?php echo $cityGuidFieldID; ?>').val(data.id);
                    $('select#shipping_address_city_select').select2('destroy');
                    $('select#shipping_address_city_select').remove();
                    $('input#shipping_address_city').prop( "disabled", false ).trigger('change');
                    return data.text;
                }
            }).select2('open');
            
            $('select#shipping_address_city_select').on('select2:close', function (e) {
                $('input#shipping_address_city').prop( "disabled", false );
            });
            
            return false;
            
        });
        
        console.log('init City Triggers');
        
    }			                      
</script>

<script>
    function guessCityIDWhenNotSet(){
        var city = $('input#shipping_address_city').val();
        var city_guid = $('input#<?php echo $cityGuidFieldID; ?>').val();
        
        if (city.length > 0 && city_guid.length == 0){
            console.log('trying to guess City ID');
            
            jQuery.ajax({
                url: "index.php?route=eapteka/checkout/guessCitiesIDWhenNOTSET",
                dataType: "json",
                data: {
                    query: city                           
                },
                error:{
					
                },
                success: function( data ) {
                    if (data.city.length > 0){
                        $('input#<?php echo $cityGuidFieldID; ?>').val(data.city);
                        $('input#<?php echo $cityGuidFieldID; ?>').prop('value', data.city);					
                    }
                }
            });
            
            
            } else {
            console.log('all ok, pass guessing City ID');
        }	
    }
</script>

<script>
    $(document).ready(function(){
        initCityTriggers();
        guessCityIDWhenNotSet();
    });
</script>