<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">

<!-- quicksave -->
	  <?php if (isset($pidqs) && $pidqs) { ?>
	  <button id="qsave" style="margin: 0 10px;" data-toggle="tooltip" title="Сохранить и остаться" class="btn btn-warning"><i class="fa fa-save"></i></button>
	  <?php } ?>
<!-- quicksave end -->
			
				<button type="submit" form="form-manufacturer" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-manufacturer" class="form-horizontal">
					<ul class="nav nav-tabs" id="language">
						<?php foreach ($languages as $language) { ?>
							<li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
						<?php } ?>
					</ul>
					<div class="tab-content">
						<?php foreach ($languages as $language) { ?>
							<div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
								<div class="form-group required">
									<label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_name; ?></label>
									<div class="col-sm-10">
										<input type="text" name="manufacturer_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($manufacturer_description[$language['language_id']]) ? $manufacturer_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
										<?php if (isset($error_name[$language['language_id']])) { ?>
											<div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
										<?php } ?>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-alternate_name<?php echo $language['language_id']; ?>">Синонимы, или альтернативные названия</label>
									<div class="col-sm-10">
										<textarea rows="20" name="manufacturer_description[<?php echo $language['language_id']; ?>][alternate_name]" placeholder="<?php echo $entry_description; ?>" id="input-alternate_name<?php echo $language['language_id']; ?>" data-lang="<?php echo $lang; ?>" class="form-control"><?php echo isset($manufacturer_description[$language['language_id']]) ? $manufacturer_description[$language['language_id']]['alternate_name'] : ''; ?></textarea>
										<span class="help"><i class="fa fa-info-circle"></i> каждое с новой строки</span>
									</div>
								</div>
								
								<div class="form-group required">
									<label class="col-sm-2 control-label" for="input-country<?php echo $language['language_id']; ?>">Страна-производитель</label>
									<div class="col-sm-10">
										<input type="text" name="manufacturer_description[<?php echo $language['language_id']; ?>][country]" value="<?php echo isset($manufacturer_description[$language['language_id']]) ? $manufacturer_description[$language['language_id']]['country'] : ''; ?>" placeholder="Страна" id="input-country<?php echo $language['language_id']; ?>" class="form-control" />										
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
									<div class="col-sm-10">
										<textarea name="manufacturer_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>" data-lang="<?php echo $lang; ?>" class="form-control summernote"><?php echo isset($manufacturer_description[$language['language_id']]) ? $manufacturer_description[$language['language_id']]['description'] : ''; ?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
									<div class="col-sm-10">
										<input type="text" name="manufacturer_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($manufacturer_description[$language['language_id']]) ? $manufacturer_description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-meta-h1<?php echo $language['language_id']; ?>"><?php echo $entry_meta_h1; ?></label>
									<div class="col-sm-10">
										<input type="text" name="manufacturer_description[<?php echo $language['language_id']; ?>][meta_h1]" value="<?php echo isset($manufacturer_description[$language['language_id']]) ? $manufacturer_description[$language['language_id']]['meta_h1'] : ''; ?>" placeholder="<?php echo $entry_meta_h1; ?>" id="input-meta-h1<?php echo $language['language_id']; ?>" class="form-control" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
									<div class="col-sm-10">
										<textarea name="manufacturer_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($manufacturer_description[$language['language_id']]) ? $manufacturer_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
									<div class="col-sm-10">
										<textarea name="manufacturer_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($manufacturer_description[$language['language_id']]) ? $manufacturer_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
									</div>
								</div>
							</div>
						<?php } ?>
						
						<div class="form-group">
							<label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>
							<div class="col-sm-10">
								<div class="well well-sm" style="height: 150px; overflow: auto;">
									<div class="checkbox">
										<label>
											<?php if (in_array(0, $manufacturer_store)) { ?>
												<input type="checkbox" name="manufacturer_store[]" value="0" checked="checked" />
												<?php echo $text_default; ?>
												<?php } else { ?>
												<input type="checkbox" name="manufacturer_store[]" value="0" />
												<?php echo $text_default; ?>
											<?php } ?>
										</label>
									</div>
									<?php foreach ($stores as $store) { ?>
										<div class="checkbox">
											<label>
												<?php if (in_array($store['store_id'], $manufacturer_store)) { ?>
													<input type="checkbox" name="manufacturer_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
													<?php echo $store['name']; ?>
													<?php } else { ?>
													<input type="checkbox" name="manufacturer_store[]" value="<?php echo $store['store_id']; ?>" />
													<?php echo $store['name']; ?>
												<?php } ?>
											</label>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-keyword"><span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"><?php echo $entry_keyword; ?></span></label>
							<div class="col-sm-10">
								<input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="<?php echo $entry_keyword; ?>" id="input-keyword" class="form-control" />
								<?php if ($error_keyword) { ?>
									<div class="text-danger"><?php echo $error_keyword; ?></div>
								<?php } ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-image"><?php echo $entry_image; ?></label>
							<div class="col-sm-10"> <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
								<input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
							</div>
						</div>
						
						<div class="form-group required">
							<label class="col-sm-2 control-label" for="input-uuid">UUID</label>
							<div class="col-sm-10">
								<input type="text" name="uuid" value="<?php echo $uuid; ?>" placeholder="5c70276b-6072-11e6-a861-2089848bcb55" id="input-uuid" class="form-control" />									
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
							<div class="col-sm-10">
								<input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
							</div>
						</div>

				<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo $faq_name; ?></label>
				<div class="col-sm-10">
				<?php foreach($languages as $language) { ?>
                    <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" style="display:inline-block;"/></span><input type="text" name="manufacturer_description[<?php echo $language['language_id']; ?>][faq_name]" value="<?php echo isset($manufacturer_description[$language['language_id']]) ? $manufacturer_description[$language['language_id']]['faq_name'] : ''; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" style="width:50%;display:inline-block;"/></div><br />
				<?php } ?>
				</div>
				</div>  
				<div class="table-responsive">
                <table id="faq" class="table table-striped table-bordered table-hover">
				<thead>
				<tr>
				<td class="text-center"><?php echo $column_question; ?></td>
				<td class="text-center"><?php echo $column_faq; ?></td>
				<td class="text-center" style="width:10%"><?php echo $column_icon; ?></td>
				<td class="text-center" style="width:10%"><?php echo $column_sort_order; ?></td>
				<td class="text-center" style="width:10%"></td>
				</tr>
				</thead>
				<tbody>
				<?php $faq_row = 0; ?>
				<?php foreach ($manufacturer_faq as $manufacturer_faq) { ?>
                    <tr id="faq-row<?php echo $faq_row; ?>">
					<td class="text-center">
					<?php foreach($languages as $language) { ?>
						<div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" style="display:inline-block;"/></span><input type="text" name="manufacturer_faq[<?php echo $faq_row; ?>][question][<?php echo $language['language_id']; ?>]" value="<?php if (isset($manufacturer_faq['question'][$language['language_id']])) echo $manufacturer_faq['question'][$language['language_id']]; ?>" class="form-control" style="display:inline-block;width:80%;" /></div><br />
					<?php } ?>
					</td>
					<td class="text-center">
					<?php foreach($languages as $language) { ?>
						<div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" style="display:inline-block;"/></span><textarea rows="3" name="manufacturer_faq[<?php echo $faq_row; ?>][faq][<?php echo $language['language_id']; ?>]" class="form-control" style="display:inline-block;width:80%;"><?php if (isset($manufacturer_faq['faq'][$language['language_id']])) echo $manufacturer_faq['faq'][$language['language_id']]; ?></textarea></div><br />
					<?php } ?> 
					</td>
					<td class="text-center"><input type="text" name="manufacturer_faq[<?php echo $faq_row; ?>][icon]" value="<?php echo $manufacturer_faq['icon']; ?>" class="form-control" /></td>
					<td class="text-center"><input type="text" name="manufacturer_faq[<?php echo $faq_row; ?>][sort_order]" value="<?php echo $manufacturer_faq['sort_order']; ?>" class="form-control" /></td>
					<td class="text-center"><button type="button" onclick="$('#faq-row<?php echo $faq_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                    </tr> 
                    <?php $faq_row++; ?>
				<?php } ?>
				</tbody>
				<tfoot>
				<tr>
				<td colspan="4"></td>
				<td class="text-center"><button type="button" onclick="addFaq();" data-toggle="tooltip" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
				</tr>
				</tfoot>
                </table>
				</div>
			
					</form>
				</div>
			</div>
		</div>
		<script type="text/javascript"><!--
			<?php if ($ckeditor) { ?>
				<?php foreach ($languages as $language) { ?>
					ckeditorInit('input-description<?php echo $language['language_id']; ?>', getURLVar('token'));
				<?php } ?>
			<?php } ?>
		//--></script>
		<script type="text/javascript"><!--
			$('#language a:first').tab('show');
		//--></script></div>
</div>

				<script type="text/javascript"><!--
				var faq_row = <?php echo $faq_row; ?>;
				function addFaq() {
				html  = '<tr id="faq-row' + faq_row + '">';
				html += '  <td class="text-center">';
				<?php foreach($languages as $language) { ?>
					html += '<div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" style="display:inline-block;"/></span><input type="text" name="manufacturer_faq[' + faq_row + '][question][<?php echo $language['language_id']; ?>]" value="" class="form-control" style="display:inline-block;width:80%;" /></div><br />';
				<?php } ?>
				html += '</td>';
				html += '  <td class="text-center">';
				<?php foreach($languages as $language) { ?>
					html += '<div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" style="display:inline-block;"/></span><textarea rows="3" name="manufacturer_faq[' + faq_row + '][faq][<?php echo $language['language_id']; ?>]" value="" class="form-control" style="display:inline-block;width:80%;"></textarea></div><br />';
				<?php } ?>
				html += '</td>';
				html += '  <td class="text-center" style="width:10%"><input type="text" name="manufacturer_faq[' + faq_row + '][icon]" value=""  class="form-control" /></td>';
				html += '  <td class="text-center" style="width:10%"><input type="text" name="manufacturer_faq[' + faq_row + '][sort_order]" value=""  class="form-control" /></td>';
				html += '  <td class="text-center"><button type="button" onclick="$(\'#faq-row' + faq_row + '\').remove();" data-toggle="tooltip" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
				html += '</tr>';
				
				$('#faq tbody').append(html);
				
				faq_row++;
				}
				//--></script>
			

<script type="text/javascript"><!--
//quicksave
$("#qsave").on("click",function(){
for(var zz=$(".note-editor").length,i=0;zz>i;i++){var yy=$(".note-editor").eq(i).parent().children("textarea").attr("id");if("function"==typeof $().code)var content=$("#"+yy).code();else var content=$("#"+yy).summernote("code");$("#"+yy).html(content)}
$.ajax({type:"post",data:$("form").serialize(),url:"index.php?route=catalog/manufacturer/qsave&token=<?php echo $token; ?>&manufacturer_id=<?php echo $pidqs; ?>",dataType:"json",beforeSend:function(){$("#qsave").prop("disabled",!0)},complete:function(){$("#qsave").prop("disabled",!1)},success:function(e){$(".alert").remove(),$(".text-danger").remove(),$(".form-group").removeClass("has-error"),e.error&&(html='<div class="alert alert-danger">',html+=" "+e.error.warning+' <button type="button" class="close" data-dismiss="alert">&times;</button></br>',e.error.keyword&&($("#input-keyword").after('<div class="text-danger">'+e.error.keyword+"</div>"),html+='</br><i class="fa fa-exclamation-circle"></i> '+e.error.keyword),e.error.name&&($("#input-name").after('<div class="text-danger">'+e.error.name+"</div>"),html+='</br><i class="fa fa-exclamation-circle"></i> '+e.error.name),$(".text-danger").parentsUntil(".form-group").parent().addClass("has-error"),html+=" </div>",$("#content > .container-fluid").prepend(html)),e.success&&$("#content > .container-fluid").prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> '+e.success+'  <button type="button" class="close" data-dismiss="alert">&times;</button></div>')},error:function(e,r,t){alert(t+"\r\n"+e.statusText+"\r\n"+e.responseText)}})});
//quicksave end
//--></script>
			
<?php echo $footer; ?>
