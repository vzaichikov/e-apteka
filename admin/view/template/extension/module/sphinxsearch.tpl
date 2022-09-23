<?php echo $header; ?>
<link type="text/css" href="view/stylesheet/sphinx.css" rel="stylesheet" media="screen" />
<?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-product" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-product" class="form-horizontal">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#general" role="tab" data-toggle="tab"><?php echo $tab_general; ?></a></li>
				<li><a href="#autocomplete" role="tab" data-toggle="tab"><?php echo $tab_autocomplete; ?></a></li>
				<li><a href="#productOptions" role="tab" data-toggle="tab"><?php echo $tab_productOptions; ?></a></li>
				<li><a href="#categoriesOptions" role="tab" data-toggle="tab"><?php echo $tab_categoriesOptions; ?></a></li>
				<li><a href="#suggestions" role="tab" data-toggle="tab"><?php echo $tab_suggestions; ?></a></li>
				<li><a href="#config" role="tab" data-toggle="tab"><?php echo $tab_config; ?></a></li>
				<li><a href="#rtIndex" class="rtIndexTab hiddenTab" role="tab" data-toggle="tab"><?php echo $tab_rtIndex; ?></a></li>
			</ul>

          <div class="tab-content">
            <div class="tab-pane active" id="general">
              
              <div class="tab-content">
                
                <div class="form-group">
				  	<label class="col-sm-2 control-label"><?php echo $entry_sphinx_status; ?></label>
				    <div class="col-sm-10">
				    	<select class="form-control" name="sphinx_search_module">
				          <?php if (isset($sphinx_search_module)) { ?>
				          <option value="1" <?php if ($sphinx_search_module) echo 'selected="selected"'; ?> ><?php echo $text_enabled; ?></option>
				          <option value="0" <?php if (!$sphinx_search_module) echo 'selected="selected"'; ?> ><?php echo $text_disabled; ?></option>
				          <?php } else { ?>
				          <option value="1"><?php echo $text_enabled; ?></option>
				          <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
				          <?php } ?>
				        </select>
					</div>
				</div>
				
				<div class="form-group">
		          	<label class="col-sm-2 control-label"><?php echo $entry_sphinx_server; ?></label>
		            <div class="col-sm-10">
		            	<input class="form-control" type="text" name="sphinx_search_server" value="<?php echo ($sphinx_search_server) ? $sphinx_search_server : '127.0.0.1'; ?>" />
		        	</div>
		        </div>
		        
		        <div class="form-group">
		          	<label class="col-sm-2 control-label"><?php echo $entry_sphinx_port; ?></label>
		            <div class="col-sm-10">
		            	<input class="form-control" type="text" name="sphinx_search_port" value="<?php echo ($sphinx_search_port) ? $sphinx_search_port : 9312; ?>" />
		        	</div>
		        </div>
		        
	        	<legend><h3><?php echo $entry_sphinx_match_mode_title; ?></h3></legend>
				
				<div class="form-group">
		          	<label class="col-sm-2 control-label"><?php echo $entry_sphinx_match_mode; ?></label>
		            <div class="col-sm-9">
			            <select class="form-control" name="sphinx_match_mode">
		                  <?php foreach ($sphinx_match_modes as $key=>$mode) { ?>
			                  <?php if ($key == $sphinx_match_mode) { ?>
			                  	<option value="<?php echo $key; ?>" selected="selected"><?php echo $mode; ?></option>
			                  <?php } else { ?>
			                  	<option value="<?php echo $key; ?>"><?php echo $mode; ?></option>
			                  <?php } ?>
		                  <?php } ?>
		                </select>
	                </div>
	                <div class="col-sm-1">
	                	<button class="btn btn-primary" id="search-mode">?</button>
	                </div>
		        </div>
		        
		        <p class="alert alert-info search-mode-info"><?php echo $entry_sphinx_match_modes_explanation; ?></p>
		        
	        	<legend><h3><?php echo $entry_sphinx_sort_mode_title; ?></h3></legend>
		        
		        <div class="form-group">
		          	<label class="col-sm-2 control-label"><?php echo $entry_sort_status; ?></label>
		            <div class="col-sm-9">
		            	<select class="form-control" name="sphinx_search_sort">
		                  <?php if (isset($sphinx_search_sort)) { ?>
		                  <option value="1" <?php if ($sphinx_search_sort) echo 'selected="selected"'; ?> ><?php echo $text_enabled; ?></option>
		                  <option value="0" <?php if (!$sphinx_search_sort) echo 'selected="selected"'; ?> ><?php echo $text_disabled; ?></option>
		                  <?php } else { ?>
		                  <option value="1"><?php echo $text_enabled; ?></option>
		                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
		                  <?php } ?>
		                </select>
		        	</div>
		        	<div class="col-sm-1">
	                	<button class="btn btn-primary" id="sort-mode">?</button>
	                </div>
		        </div>
		        
		        <?php foreach ($sphinx_sort_modes as $key=>$arr) { ?>
					<div class="form-group">
						<?php if ($key == $sphinx_sort_mode) { ?>
							<label class="col-sm-2 control-label radio-inline"><input type="radio" name="sphinx_sort_mode" value="<?php echo $key; ?>" checked="checked"> <?php echo $arr['mode'] ?></label>
						<?php } else { ?>
							<label class="col-sm-2 control-label radio-inline"><input type="radio" name="sphinx_sort_mode" value="<?php echo $key; ?>"> <?php echo $arr['mode'] ?></label>
						<?php } ?>
						<?php if(isset($arr['attrs'])) { ?>
							<div class="col-sm-10">
								<select class="form-control" name="sphinx_sort_attr_val[<?php echo $key ?>]"> 
									<?php foreach($arr['attrs'] as $ak => $av) { ?>
										<option value="<?php echo $ak; ?>" <?php if ($sphinx_sort_attr_val[$key] == $ak) echo 'selected="selected"'; ?>><?php echo $av; ?></option>
									<?php } ?> 
								</select>
							</div>
						<?php } else { ?>
							<div class="col-sm-10">
								<?php if($key != 0) { ?>
									<input class="form-control control-label" type="text" name="sphinx_sort_attr_val[<?php echo $key; ?>]" value="<?php echo $sphinx_sort_attr_val[$key] ?>" />
								<?php  } else { ?>
									<input class="form-control control-label" type="hidden" name="sphinx_sort_attr_val[<?php echo $key; ?>]" value="<?php echo $sphinx_sort_attr_val[$key] ?>" />
								<?php } ?>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
				
		        <p class="alert alert-info sort-mode-info"><?php echo $entry_sphinx_sort_modes_explanation; ?></p>
		        
	        	<legend><h3><?php echo $entry_sphinx_ranking_mode_title; ?></h3></legend>
		        
				<div class="form-group">
		          	<label class="col-sm-2 control-label"><?php echo $entry_sphinx_ranking_mode; ?></label>
		            <div class="col-sm-9">
		            	<select class="form-control" name="sphinx_ranking_mode">
		                  <?php foreach ($sphinx_ranking_modes as $key=>$mode) { ?>
			                  <?php if ($key == $sphinx_ranking_mode) { ?>
			                  	<option value="<?php echo $key; ?>" selected="selected"><?php echo $mode; ?></option>
			                  <?php } else { ?>
			                  	<option value="<?php echo $key; ?>"><?php echo $mode; ?></option>
			                  <?php } ?>
		                  <?php } ?>
		                </select>
		        	</div>
		        	<div class="col-sm-1">
	                	<button class="btn btn-primary" id="ranking-mode">?</button>
	                </div>
		        </div>

				<p class="alert alert-info ranking-mode-info"><?php echo $entry_sphinx_ranking_modes_explanation; ?></p>

	        	<legend><h3><?php echo $entry_sphinx_weight_title; ?></h3></legend>

 				<?php foreach($sphinx_sort_attrs as $key => $val) { ?>
					<div class="form-group col-sm-4">
						<label class="col-sm-2 control-label"><?php echo $val; ?></label>
						<div class="col-sm-10">
							<input type="text" name="sphinx_weights[<?php echo $key; ?>]" value="<?php echo (isset($sphinx_weights[$key]) && $sphinx_weights[$key] != '') ? $sphinx_weights[$key] : 1; ?>" class="weights-field form-control" />
						</div>
					</div>
            	<?php } ?>
				
              </div>
            </div>

            <div class="tab-pane" id="autocomplete">
				
				<div class="form-group">
		          	<label class="col-sm-2 control-label"><?php echo $entry_autocomplete_status; ?></label>
		            <div class="col-sm-10">
		            	<select class="form-control" name="sphinx_search_autocomple">
		                  <?php if (isset($sphinx_search_autocomple)) { ?>
		                  <option value="1" <?php if ($sphinx_search_autocomple) echo 'selected="selected"'; ?> ><?php echo $text_enabled; ?></option>
		                  <option value="0" <?php if (!$sphinx_search_autocomple) echo 'selected="selected"'; ?> ><?php echo $text_disabled; ?></option>
		                  <?php } else { ?>
		                  <option value="1"><?php echo $text_enabled; ?></option>
		                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
		                  <?php } ?>
		                </select>
		        	</div>
		        </div>
		        
		        <div class="form-group">
		          	<label class="col-sm-2 control-label"><?php echo $entry_autocomplete_selector; ?></label>
		            <div class="col-sm-10">
		            	<input class="form-control" type="text" name="sphinx_autocomple_selector" value="<?php echo ($sphinx_autocomple_selector) ? $sphinx_autocomple_selector : '#search input' ?>" />
		        	</div>
		        </div>
		        
		        <div class="form-group">
		          	<label class="col-sm-2 control-label"><?php echo $entry_autocomplete_limit; ?></label>
		            <div class="col-sm-10">
		            	<input class="form-control" type="text" name="sphinx_autocomple_limit" value="<?php echo ($sphinx_autocomple_limit) ? $sphinx_autocomple_limit : '' ?>" />
		        	</div>
		        </div>
		        
		        <div class="form-group">
		          	<label class="col-sm-2 control-label"><?php echo $entry_autocomplete_categories; ?></label>
		            <div class="col-sm-10">
		            	<select class="form-control" name="sphinx_search_autocomplete_categories">
		                  <?php if (isset($sphinx_search_autocomplete_categories)) { ?>
		                  <option value="1" <?php if ($sphinx_search_autocomplete_categories) echo 'selected="selected"'; ?> ><?php echo $text_yes; ?></option>
		                  <option value="0" <?php if (!$sphinx_search_autocomplete_categories) echo 'selected="selected"'; ?> ><?php echo $text_no; ?></option>
		                  <?php } else { ?>
		                  <option value="1"><?php echo $text_yes; ?></option>
		                  <option value="0" selected="selected"><?php echo $text_no; ?></option>
		                  <?php } ?>
		                </select>
		        	</div>
		        </div>
				
				<div class="form-group">
		          	<label class="col-sm-2 control-label"><?php echo $entry_sphinx_autocomplete_cat_limit; ?></label>
		            <div class="col-sm-10">
			            <input class="form-control" type="text" name="sphinx_autocomplete_cat_limit" value="<?php echo ($sphinx_autocomplete_cat_limit) ? $sphinx_autocomplete_cat_limit : '' ?>" />
		        	</div>
		        </div>
           
            </div><!-- end of autocomplete -->
            
            
            <div class="tab-pane" id="productOptions">
				
				<div class="form-group">
		          	<label class="col-sm-2 control-label"><?php echo $entry_sphinx_product_status; ?></label>
		            <div class="col-sm-10">
			            <select class="form-control" name="sphinx_search_product_status">
		                  <?php if (isset($sphinx_search_product_status)) { ?>
		                  <option value="1" <?php if ($sphinx_search_product_status) echo 'selected="selected"'; ?> ><?php echo $text_yes; ?></option>
		                  <option value="0" <?php if (!$sphinx_search_product_status) echo 'selected="selected"'; ?> ><?php echo $text_no; ?></option>
		                  <?php } else { ?>
		                  <option value="1"><?php echo $text_yes; ?></option>
		                  <option value="0" selected="selected"><?php echo $text_no; ?></option>
		                  <?php } ?>
		                </select>
		        	</div>
		        </div>
		        
		        <div class="form-group">
		          	<label class="col-sm-2 control-label"><?php echo $entry_sphinx_products_quantity; ?></label>
		            <div class="col-sm-10">
			            <input class="form-control" type="text" name="sphinx_search_products_quantity" value="<?php echo $sphinx_search_products_quantity; ?>" />
		        	</div>
		        </div>
		        
            </div><!-- end of productOptions -->
            
            <div class="tab-pane" id="categoriesOptions">
				<div class="form-group">
		          	<label class="col-sm-2 control-label"><?php echo $entry_sphinx_category_status; ?></label>
		            <div class="col-sm-10">
			            <select class="form-control" name="sphinx_category_status">
		                  <?php if (isset($sphinx_category_status)) { ?>
		                  <option value="1" <?php if ($sphinx_category_status) echo 'selected="selected"'; ?> ><?php echo $text_enabled; ?></option>
		                  <option value="0" <?php if (!$sphinx_category_status) echo 'selected="selected"'; ?> ><?php echo $text_disabled; ?></option>
		                  <?php } else { ?>
		                  <option value="1"><?php echo $text_enabled; ?></option>
		                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
		                  <?php } ?>
		                </select>
		        	</div>
		        </div>
		        
		        <div class="form-group">
		          	<label class="col-sm-2 control-label"><?php echo $entry_sphinx_category_product_status; ?></label>
		            <div class="col-sm-10">
			            <select class="form-control" name="sphinx_category_product_status">
		                  <?php if (isset($sphinx_category_product_status)) { ?>
		                  <option value="1" <?php if ($sphinx_category_product_status) echo 'selected="selected"'; ?> ><?php echo $text_yes; ?></option>
		                  <option value="0" <?php if (!$sphinx_category_product_status) echo 'selected="selected"'; ?> ><?php echo $text_no; ?></option>
		                  <?php } else { ?>
		                  <option value="1"><?php echo $text_yes; ?></option>
		                  <option value="0" selected="selected"><?php echo $text_no; ?></option>
		                  <?php } ?>
		                </select>
		        	</div>
		        </div>
		        
		        <div class="form-group">
		          	<label class="col-sm-2 control-label"><?php echo $entry_sphinx_categories_product_quantity; ?></label>
		            <div class="col-sm-10">
			            <input class="form-control" type="text" name="sphinx_category_product_quantity" value="<?php echo $sphinx_category_product_quantity; ?>" />
		        	</div>
		        </div>
				      
            </div><!-- end of categoriesOptions -->
            
            <div class="tab-pane" id="suggestions">
           		
           		<div class="form-group">
		          	<label class="col-sm-2 control-label"><?php echo $entry_sphinx_suggestion_explanation; ?></label>
		            <div class="col-sm-10">
			            <a onclick="genSuggestions($(this), 0)" class="btn btn-primary"><span><?php echo $entry_sphinx_gen_btn; ?></span></a>
						<img id="loader" src="view/image/loading.gif" style="display: none" />
						<div id="progressBar" class="hide">
							<span class="msg"><?php echo $text_calculating; ?></span>
							<div></div>
						</div>
		        	</div>
		        </div>
		        
				<div class="alert alert-info"><?php echo $entry_sphinx_show_errors_attention; ?></div>
				
            </div><!-- end of suggestions -->
            
            <div class="tab-pane" id="config">
           		
           		<div class="form-group">
		          	<label class="col-sm-2 control-label"><?php echo $entry_sphinx_config_index_type; ?></label>
		            <div class="col-sm-10">
			            <select class="form-control" id="sphinx_config_index_type" name="sphinx_config_index_type">
		                  <?php if (isset($sphinx_config_index_type)) { ?>
		                  <option value="1" <?php if ($sphinx_config_index_type) echo 'selected="selected"'; ?> ><?php echo $text_rt_yes; ?></option>
		                  <option value="0" <?php if (!$sphinx_config_index_type) echo 'selected="selected"'; ?> ><?php echo $text_rt_no; ?></option>
		                  <?php } else { ?>
		                  <option value="1"><?php echo $text_rt_yes; ?></option>
		                  <option value="0" selected="selected"><?php echo $text_rt_no; ?></option>
		                  <?php } ?>
		                </select>
		        	</div>
		        </div>
		        
		        <div class="form-group">
		          	<label class="col-sm-2 control-label"><?php echo $entry_sphinx_config_path_to_indexes; ?></label>
		            <div class="col-sm-10">
			            <input class="form-control" type="text" name="sphinx_config_path_to_indexes" value="<?php echo ($sphinx_config_path_to_indexes) ? $sphinx_config_path_to_indexes : ''; ?>" />
		        	</div>
		        </div>
		        
		        <div class="form-group">
		          	<label class="col-sm-2 control-label"><?php echo $entry_sphinx_config_path_to_log; ?></label>
		            <div class="col-sm-10">
			        	<input class="form-control" type="text" name="sphinx_config_path_to_log" value="<?php echo ($sphinx_config_path_to_log) ? $sphinx_config_path_to_log : ''; ?>" />
		        	</div>
		        </div>
		        
		        <div class="form-group">
		          	<label class="col-sm-2 control-label"><?php echo $entry_sphinx_config_generate_file; ?></label>
		            <div class="col-sm-10">
			        	<a id="genConfig" href="index.php?route=extension/module/sphinxsearch/generateSphinxConfig&token=<?php echo $token; ?>" target="_blank" class="btn btn-primary"><span><?php echo $entry_sphinx_gen_config_btn; ?></span></a>
						<img id="loaderConfig" src="view/image/loading.gif" style="display: none" />
		        	</div>
		        </div>
		        
	          	<div class="alert alert-info"><?php echo $entry_sphinx_config_attention; ?></div>
		        
            </div><!-- end of config -->
            
            <div class="tab-pane" id="rtIndex">
				
				 <div class="form-group">
				 	<div class="col-sm-12">
				 		<a onclick="buildProductsRtIndex($(this), 0)" class="btn btn-primary"><span><?php echo $entry_sphinx_rtIndex_gen_products_btn; ?></span></a>
						<div id="progressBarProducts" class="hide">
							<span class="msgConfig"><?php echo $text_calculating; ?></span>
							<div></div>
						</div>
						<img id="loaderProducts" src="view/image/loading.gif" style="display: none" />
				 	</div>
		        </div>
		        
		        <div class="form-group">
		        	<div class="col-sm-12">
			          	<a onclick="buildCategoriesRtIndex($(this), 0)" class="btn btn-primary"><span><?php echo $entry_sphinx_rtIndex_gen_categories_btn; ?></span></a>
						<div id="progressBarCategories" class="hide">
							<span class="msgConfig"><?php echo $text_calculating; ?></span>
							<div></div>
						</div>
						<img id="loaderCategories" src="view/image/loading.gif" style="display: none" />
					</div>
		        </div>
		        
	        	<div class="alert alert-info"><?php echo $entry_sphinx_rtIndex_attention; ?></div>
           
            </div><!-- end of rtIndex -->
            
          </div>
        </form>
      </div>
    </div>
  </div>
  
</div>
<?php echo $footer; ?>
<script type="text/javascript">

$(document).ready(function(){

	$('.alert-info').hide();
	$('#suggestions .alert-info, #rtIndex .alert-info, #config .alert-info').show();
	$('button').click(function(){
		$('.'+$(this).attr('id')+'-info').toggle();
		return false;
	});
	
	var indexType = $('#sphinx_config_index_type').find(":selected").val();
	
	if(indexType == 1) {
		$('a.rtIndexTab').removeClass('hiddenTab');
		$('#config .attention').html("<?php echo $entry_sphinx_rtIndex_attention; ?>");
	}
	
	$('#sphinx_config_index_type').on('change', function (e) {
		var optionSelected = $("option:selected", this);
	   	var valueSelected = this.value;
	   	
	   	if(valueSelected == 1) {
	   		$('a.rtIndexTab').removeClass('hiddenTab');
	   		$('#config .attention').html("<?php echo $entry_sphinx_rtIndex_attention; ?>");
	   	} else {
	   		$('a.rtIndexTab').addClass('hiddenTab');
	   		$('#config .attention').html("<?php echo $entry_sphinx_config_attention; ?>");
	   	}
			   	
	});
	
	$('#genConfig').click(function(){
		$('#loaderConfig').show();
	
		var confirmVal = confirm('Do you want to save changes first?');
	
		if(confirmVal) {
			//Save data before generating file
			saveAndContinue(true);
		}
	
		location.href = $('#genConfig').attr('href');
		$('#loaderConfig').hide();
		
		return false;
	});
	
});

function saveAndContinue(isConfigFile) {
	
	$.ajax({
		type: 'POST',
		async: false,
		url: 'index.php?route=extension/module/sphinxsearch/save&token=<?php echo $token; ?>',
		data: $('#form-product').serialize(),
		success: function(data) {
			if(isConfigFile) {
				$('#loaderConfig').hide();
				location.href = $('#genConfig').attr('href');
			}
		}
	});
}

function genSuggestions(el, offset) {
	
	var onClickAttr = el.attr('onclick');
	el.attr('onclick','').unbind('click');
	el.addClass('disabled');
	
	$('#progressBar').removeClass('hide').show();
	$('#loader').show();

	//Save before continue
	//saveAndContinue(false);

	$.ajax({
		type:'POST',
		url: 'index.php?route=extension/module/sphinxsearch/generateSuggestions&offset='+offset+'&token=<?php echo $token; ?>',
		dataType: 'json',
		success: function(data) {
			if(data['error'] != '') {
				$('#progressBar').after('<div class="idx-generating-error alert alert-warning">' + data['error'] + '</div>');
				$('#progressBar').hide();
				$('#loader').hide();
				return;
			} 
			
			$('#progressBar .msg').empty();
			
			var percent = Math.floor((data['offset']/data['total']) * 100);
		
			$('#progressBar').find('div').animate({ width: percent + '%' }, 200).html(percent + "%&nbsp;");
			
			if(percent >= 100) {
				$('#progressBar').removeClass('hide').show();
				$('#progressBar').find('div').text('Done');
				$('#loader').hide();
				el.attr('onclick',onClickAttr).bind('click');
				el.removeClass('disabled');
			} else {
				genSuggestions(el, data['offset']);
			}

		}
	});
}

function buildProductsRtIndex(el, offset) {
	
	var onClickAttr = el.attr('onclick');
	el.attr('onclick','').unbind('click');
	el.addClass('disabled');
	
	$('#progressBarProducts').removeClass('hide').show();
	$('#loaderProducts').show();
	$('.prError').remove();

	//Save before continue
	//saveAndContinue(false);

	$.ajax({
		type:'POST',
		url: 'index.php?route=extension/module/sphinxsearch/buildProductsRtIndex&offset='+offset+'&token=<?php echo $token; ?>',
		dataType: 'json',
		success: function(data) {
			
			if(data['error']) {
				$('#progressBarProducts').addClass('hide');
				$('#progressBarProducts').after("<span class='idx-generating-error alert alert-warning'>"+data['error']+"</span>");
				$('#loaderProducts').hide();
				el.attr('onclick',onClickAttr).bind('click');
				el.removeClass('disabled');
				return false;
			}
			
			var percent = Math.floor((data['offset']/data['total']) * 100);
		
			$('#progressBarProducts').find('div').animate({ width: percent + '%' }, 200).html(percent + "%&nbsp;");
			
			if(percent >= 100) {
				$('#progressBarProducts').removeClass('hide').show();
				$('#progressBarProducts').find('div').text('Done');
				$('#loaderProducts').hide();
				el.attr('onclick',onClickAttr).bind('click');
				el.removeClass('disabled');
			} else {
				buildProductsRtIndex(el, data['offset']);
			}
		}
	});

}

function buildCategoriesRtIndex(el, offset) {
	
	var onClickAttr = el.attr('onclick');
	el.attr('onclick','').unbind('click');
	el.addClass('disabled');
	
	$('#progressBarCategories').removeClass('hide').show();
	$('#loaderCategories').show();
	$('.catError').remove();

	//Save before continue
	//saveAndContinue(false);

	$.ajax({
		type:'POST',
		url: 'index.php?route=extension/module/sphinxsearch/buildCategoriesRtIndex&offset='+offset+'&token=<?php echo $token; ?>',
		dataType: 'json',
		success: function(data) {
			
			if(data['error']) {
				$('#progressBarCategories').addClass('hide').show();
				$('#progressBarCategories').after("<span class='idx-generating-error alert alert-warning'>"+data['error']+"</span>");
				$('#loaderCategories').hide();
				el.attr('onclick',onClickAttr).bind('click');
				el.removeClass('disabled');
				return false;
			}
			
			var percent = Math.floor((data['offset']/data['total']) * 100);
		
			$('#progressBarCategories').find('div').animate({ width: percent + '%' }, 200).html(percent + "%&nbsp;");
			
			if(percent >= 100) {
				$('#progressBarCategories').removeClass('hide').show();
				$('#progressBarCategories').find('div').text('Done');
				$('#loaderCategories').hide();
				el.attr('onclick',onClickAttr).bind('click');
				el.removeClass('disabled');
			} else {
				buildCategoriesRtIndex(el, data['offset']);
			}
		}
	});
}
</script>