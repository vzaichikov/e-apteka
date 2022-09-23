<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <style>
	.barr{
		/*width: 0;*/
		background-color: gray;
		height: 100%;
	}
  </style>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
		<div class="panel-body">
			<div class="form-group">
				<label class="col-sm-12 control-label">Всего продуктов: <?php echo $total_products; ?></label>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Генерим продукты</label>
				<div class="col-sm-10">
				  <?php foreach ($languages as $language) { ?>
				  <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" /></span>
					<span id="products_<?php echo $language['language_id']; ?>" class="form-control" />
						<div class="barr"></div>
					</span>
				  </div>
				  <?php } ?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">Генерим Категории</label>
				<div class="col-sm-10">
				  <?php foreach ($languages as $language) { ?>
				  <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" /></span>
					<span id="category_<?php echo $language['language_id']; ?>" class="form-control" />
						<div class="barr"></div>
					</span>
				  </div>
				  <?php } ?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">Генерим Производители</label>
				<div class="col-sm-10">
				  <?php foreach ($languages as $language) { ?>
				  <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" /></span>
					<span id="manufacturer_<?php echo $language['language_id']; ?>" class="form-control" />
						<div class="barr"></div>
					</span>
				  </div>
				  <?php } ?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">Генерим Информация</label>
				<div class="col-sm-10">
				  <?php foreach ($languages as $language) { ?>
				  <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" /></span>
					<span id="information_<?php echo $language['language_id']; ?>" class="form-control" />
						<div class="barr"></div>
					</span>
				  </div>
				  <?php } ?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">Генерим Индексы</label>
				<div class="col-sm-10">
				  <?php foreach ($languages as $language) { ?>
				  <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" /></span>
					<span id="index_<?php echo $language['language_id']; ?>" class="form-control" />
						<div class="barr"></div>
					</span>
				  </div>
				  <?php } ?>
				</div>
			</div>

		<?php foreach($languages as $lang){ ?>
		
		<?php } ?>

		</div>
    </div>
  </div>
</div>

<script>
	var language_ids = [<?php echo implode(',',$language_ids); ?>];
	var types = ['products','category','manufacturer','information', 'index'];
	var type_id = 0;
	var lang_count = 0;
	//var language_id = language_ids[lang_count];
	var start_position = 0;
	var pages = <?php echo $product_pages; ?>;
	var limit = <?php echo $limit; ?>;
	var wid = 0;

	
	function start_product(){
		
		language_id = language_ids[lang_count];
		
		
				
		$.ajax({
			url: '<?php echo HTTPS_SERVER; ?>../index.php?route=extension/feed/folder_sitemap',
			type: 'post',
			data: 'language_id=' + language_id + '&total_products=<?php echo $total_products; ?>&start_position='+start_position+'&limit='+limit+'&'+types[type_id]+'=true',
			dataType: 'text',
			success: function(json) {
				
				//console.log('language_id=' + language_id + '&total_products=<?php echo $total_products; ?>&start_position='+start_position+'&limit='+limit+'&'+types[type_id]+'=true');
				
				console.log(types[type_id]+' '+start_position);
				console.log(json);				
	
				wid = Math.round((100 / pages) * start_position);
				
				$('#'+types[type_id]+'_'+language_id+' > .barr').css('width', wid+'%');
				$('#'+types[type_id]+'_'+language_id+' > .barr').css('background-color', 'green');
				
				if(start_position < pages){
					setTimeout(function(){
						start_position = start_position + 1;
						start_product();
					}, 500);
				}else if(types.length > type_id && language_ids.length > (lang_count+1)){
					lang_count = lang_count + 1;	
					if(language_ids.length > lang_count){
						setTimeout(function(){
							start_position = 0;
							start_product();
						}, 500);
					}
				}else{
					pages = 1;
					type_id = type_id + 1;
					if(types.length > type_id){
						setTimeout(function(){
							lang_count = 0;
							start_position = 0;
							start_product();
						}, 500);
					}
				}

				
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
	
	$(document).ready(start_product());
</script>


<?php echo $footer; ?>