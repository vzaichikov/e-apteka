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
			
        <button type="submit" form="form-information" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-information" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>
            <li><a href="#tab-design" data-toggle="tab"><?php echo $tab_design; ?></a></li>
<li><a href="#tab-faq" data-toggle="tab"><?php echo $tab_faq; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <ul class="nav nav-tabs" id="language">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              <div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-title<?php echo $language['language_id']; ?>"><?php echo $entry_title; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="information_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['title'] : ''; ?>" placeholder="<?php echo $entry_title; ?>" id="input-title<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_title[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_title[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
                    <div class="col-sm-10">
                      <textarea name="information_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>" class="form-control summernote"><?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['description'] : ''; ?></textarea>
                      <?php if (isset($error_description[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_description[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="information_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_meta_title[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
                    <div class="col-sm-10">
                      <textarea name="information_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
                    <div class="col-sm-10">
                      <textarea name="information_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>
            <div class="tab-pane" id="tab-data">
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="height: 150px; overflow: auto;">
                    <div class="checkbox">
                      <label>
                        <?php if (in_array(0, $information_store)) { ?>
                        <input type="checkbox" name="information_store[]" value="0" checked="checked" />
                        <?php echo $text_default; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="information_store[]" value="0" />
                        <?php echo $text_default; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php foreach ($stores as $store) { ?>
                    <div class="checkbox">
                      <label>
                        <?php if (in_array($store['store_id'], $information_store)) { ?>
                        <input type="checkbox" name="information_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                        <?php echo $store['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="information_store[]" value="<?php echo $store['store_id']; ?>" />
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
                <label class="col-sm-2 control-label" for="input-bottom"><span data-toggle="tooltip" title="<?php echo $help_bottom; ?>"><?php echo $entry_bottom; ?></span></label>
                <div class="col-sm-10">
                  <div class="checkbox">
                    <label>
                      <?php if ($bottom) { ?>
                      <input type="checkbox" name="bottom" value="1" checked="checked" id="input-bottom" />
                      <?php } else { ?>
                      <input type="checkbox" name="bottom" value="1" id="input-bottom" />
                      <?php } ?>
                      &nbsp; </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="status" id="input-status" class="form-control">
                    <?php if ($status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-design">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left"><?php echo $entry_store; ?></td>
                      <td class="text-left"><?php echo $entry_layout; ?></td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-left"><?php echo $text_default; ?></td>
                      <td class="text-left"><select name="information_layout[0]" class="form-control">
                          <option value=""></option>
                          <?php foreach ($layouts as $layout) { ?>
                          <?php if (isset($information_layout[0]) && $information_layout[0] == $layout['layout_id']) { ?>
                          <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                    </tr>
                    <?php foreach ($stores as $store) { ?>
                    <tr>
                      <td class="text-left"><?php echo $store['name']; ?></td>
                      <td class="text-left"><select name="information_layout[<?php echo $store['store_id']; ?>]" class="form-control">
                          <option value=""></option>
                          <?php foreach ($layouts as $layout) { ?>
                          <?php if (isset($information_layout[$store['store_id']]) && $information_layout[$store['store_id']] == $layout['layout_id']) { ?>
                          <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>

				<div class="tab-pane" id="tab-faq">
				<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo $faq_name; ?></label>
				<div class="col-sm-10">
				<?php foreach($languages as $language) { ?>
                    <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" style="display:inline-block;"/></span><input type="text" name="information_description[<?php echo $language['language_id']; ?>][faq_name]" value="<?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['faq_name'] : ''; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" style="width:50%;display:inline-block;"/></div><br />
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
				<?php foreach ($information_faq as $information_faq) { ?>
                    <tr id="faq-row<?php echo $faq_row; ?>">
					<td class="text-center">
					<?php foreach($languages as $language) { ?>
						<div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" style="display:inline-block;"/></span><input type="text" name="information_faq[<?php echo $faq_row; ?>][question][<?php echo $language['language_id']; ?>]" value="<?php if (isset($information_faq['question'][$language['language_id']])) echo $information_faq['question'][$language['language_id']]; ?>" class="form-control" style="display:inline-block;width:80%;" /></div><br />
					<?php } ?>
					</td>
					<td class="text-center">
					<?php foreach($languages as $language) { ?>
						<div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" style="display:inline-block;"/></span><textarea rows="3" name="information_faq[<?php echo $faq_row; ?>][faq][<?php echo $language['language_id']; ?>]" class="form-control" style="display:inline-block;width:80%;"><?php if (isset($information_faq['faq'][$language['language_id']])) echo $information_faq['faq'][$language['language_id']]; ?></textarea></div><br />
					<?php } ?> 
					</td>
					<td class="text-center"><input type="text" name="information_faq[<?php echo $faq_row; ?>][icon]" value="<?php echo $information_faq['icon']; ?>" class="form-control" /></td>
					<td class="text-center"><input type="text" name="information_faq[<?php echo $faq_row; ?>][sort_order]" value="<?php echo $information_faq['sort_order']; ?>" class="form-control" /></td>
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
				</div>
			
          </div>
        </form>
      </div>
    </div>
  </div>
  
  
  <script type="text/javascript" src="view/javascript/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
      
		  function elFinderBrowser (callback, value, meta) {
		  try {
			  var fm = $('<div/>').dialogelfinder({
				  url : 'index.php?route=common/elfinder/connector&token=' + getURLVar('token'),
				  lang : 'ru',
				  width : 900,
				  height: 400,
				  destroyOnClose : true,
			  getFileCallback : function(file, fm) {
					var info = file.name + ' (' + fm.formatSize(file.size) + ')';
					callback(file.url, {alt: info});
			  },
			  commandsOptions : {
				  getfile : {
					  oncomplete : 'close',
					  multiple : false,
					  folders : false
				  }
			  }
				}).dialogelfinder('instance');
		  } catch (err) {
			$('#filePickerError').modal('show');
          $.ajax({
								url: 'index.php?route=common/filemanager&token=' + getURLVar('token'),
								dataType: 'html',
								beforeSend: function() {
									$('#button-image i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
									$('#button-image').prop('disabled', true);
								},
								complete: function() {
									$('#button-image i').replaceWith('<i class="fa fa-upload"></i>');
									$('#button-image').prop('disabled', false);
								},
								success: function(html) {
									$('body').append('<div id="modal-image" class="modal">' + html + '</div>');
									
									$('#modal-image').modal('show');
									
									$('#modal-image').delegate('a.thumbnail', 'click', function(e) {
										e.preventDefault();
										
										//$(element).summernote('insertImage', $(this).attr('href'));
										callback($(this).attr('href'));							
										$('#modal-image').modal('hide');
									});
								}
							});
		  }
		  return false;
		}
          tinymce.init({
            selector: '.summernote',
            skin: 'bootstrap',
            language: 'ru',
            height:300,
            image_title: true,
            automatic_uploads: true,
            file_picker_types: 'image',
           file_picker_callback : elFinderBrowser,
            
                
            plugins: [
              'advlist autolink link image code lists charmap print preview hr anchor pagebreak spellchecker',
              'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
              'save table contextmenu directionality emoticons template paste textcolor colorpicker'
            ],
            toolbar: 'bold italic sizeselect fontselect fontsizeselect | hr alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | insertfile undo redo | forecolor backcolor emoticons | code',
            fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
          });
   
    </script>
  <style>
    #modal-image{
      z-index: 99999;
    }
  </style>
  <!--script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
  <link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
  <script type="text/javascript" src="view/javascript/summernote/opencart.js"></script-->  
  <script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script></div>

				<script type="text/javascript"><!--
				var faq_row = <?php echo $faq_row; ?>;
				function addFaq() {
				html  = '<tr id="faq-row' + faq_row + '">';
				html += '  <td class="text-center">';
				<?php foreach($languages as $language) { ?>
					html += '<div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" style="display:inline-block;"/></span><input type="text" name="information_faq[' + faq_row + '][question][<?php echo $language['language_id']; ?>]" value="" class="form-control" style="display:inline-block;width:80%;" /></div><br />';
				<?php } ?>
				html += '</td>';
				html += '  <td class="text-center">';
				<?php foreach($languages as $language) { ?>
					html += '<div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" style="display:inline-block;"/></span><textarea rows="3" name="information_faq[' + faq_row + '][faq][<?php echo $language['language_id']; ?>]" value="" class="form-control" style="display:inline-block;width:80%;"></textarea></div><br />';
				<?php } ?>
				html += '</td>';
				html += '  <td class="text-center" style="width:10%"><input type="text" name="information_faq[' + faq_row + '][icon]" value=""  class="form-control" /></td>';
				html += '  <td class="text-center" style="width:10%"><input type="text" name="information_faq[' + faq_row + '][sort_order]" value=""  class="form-control" /></td>';
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
$.ajax({type:"post",data:$("form").serialize(),url:"index.php?route=catalog/information/qsave&token=<?php echo $token; ?>&information_id=<?php echo $pidqs; ?>",dataType:"json",beforeSend:function(){$("#qsave").prop("disabled",!0)},complete:function(){$("#qsave").prop("disabled",!1)},success:function(e){if($(".alert").remove(),$(".text-danger").remove(),$(".form-group").removeClass("has-error"),e.error){if(html='<div class="alert alert-danger">',html+=" "+e.error.warning+' <button type="button" class="close" data-dismiss="alert">&times;</button></br>',e.error.keyword&&($("#input-keyword").after('<div class="text-danger">'+e.error.keyword+"</div>"),html+='</br><i class="fa fa-exclamation-circle"></i> '+e.error.keyword),e.error.title){var r="";for(i in e.error.title){var t=$("#input-title"+i);$(t).parent().hasClass("input-group")?($(t).parent().after('<div class="text-danger">'+e.error.title[i]+"</div>"),r='</br><i class="fa fa-exclamation-circle"></i> '+e.error.title[i]):($(t).after('<div class="text-danger">'+e.error.title[i]+"</div>"),r='</br><i class="fa fa-exclamation-circle"></i> '+e.error.title[i])}html+=r}if(e.error.meta_title){var r="";for(i in e.error.meta_title){var t=$("#input-meta-title"+i);$(t).parent().hasClass("input-group")?($(t).parent().after('<div class="text-danger">'+e.error.meta_title[i]+"</div>"),r='</br><i class="fa fa-exclamation-circle"></i> '+e.error.meta_title[i]):($(t).after('<div class="text-danger">'+e.error.meta_title[i]+"</div>"),r='</br><i class="fa fa-exclamation-circle"></i> '+e.error.meta_title[i])}html+=r}$(".text-danger").parentsUntil(".form-group").parent().addClass("has-error"),html+=" </div>",$("#content > .container-fluid").prepend(html)}e.success&&$("#content > .container-fluid").prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> '+e.success+'  <button type="button" class="close" data-dismiss="alert">&times;</button></div>')},error:function(e,r,t){alert(t+"\r\n"+e.statusText+"\r\n"+e.responseText)}})});
//quicksave end
//--></script>
			
<?php echo $footer; ?>