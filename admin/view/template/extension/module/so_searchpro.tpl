<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
   <div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-featured" data-toggle="tooltip" title="<?php echo $objlang->get('entry_button_save'); ?>" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $objlang->get('entry_button_save')?></button>
				<a class="btn btn-success" onclick="$('#action').val('save_edit');$('#form-featured').submit();" data-toggle="tooltip" title="<?php echo $objlang->get('entry_button_save_and_edit'); ?>" ><i class="fa fa-pencil-square-o"></i> <?php echo $objlang->get('entry_button_save_and_edit')?></a>
				<a class="btn btn-info" onclick="$('#action').val('save_new');$('#form-featured').submit();" data-toggle="tooltip" title="<?php echo $objlang->get('entry_button_save_and_new'); ?>" ><i class="fa fa-book"></i>  <?php echo $objlang->get('entry_button_save_and_new')?></a>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $objlang->get('entry_button_cancel'); ?>" class="btn btn-danger"><i class="fa fa-reply"></i>  <?php echo $objlang->get('entry_button_cancel')?></a>
			</div>
			<h1><?php echo $objlang->get('heading_title_so'); ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
    <div class="container-fluid">
		<?php if (isset($error['warning'])) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error['warning']; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<?php if (isset($success) && !empty($success)) { ?>
		<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_layout; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $objlang->get('text_edit'); ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-featured" class="form-horizontal">
                    <div class="row">
                        <ul class="nav nav-tabs" role="tablist">
                            <li
                            <?php if( $selectedid ==0 ) { ?>class="active" <?php } ?>> <a href="<?php echo $link; ?>">
                                <span class="fa fa-plus"></span> <?php echo $objlang->get('entry_button_add'); ?></a></li>
                            <?php $i=1; foreach( $moduletabs as $key => $module ){ ?>
                            <li role="presentation"
                            <?php if( $module['module_id']==$selectedid ) {?>class="active"<?php } ?>>
                            <a href="<?php echo $link; ?>&module_id=<?php echo $module['module_id']?>"
                               aria-controls="bannermodule-<?php echo $key; ?>">
                                <span class="fa fa-pencil"></span> <?php echo $module['name']?>
                            </a>
                            </li>
                            <?php $i++ ;} ?>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <?php $module_row = 1; ?>
                            <?php foreach ($modules as $module) { ?>
                            <?php if( $selectedid ){ ?>
                            <div class="pull-right">
                                <a href="<?php echo $action;?>&delete=1" class="remove btn btn-danger"><span><i
                                                class="fa fa-remove"></i> <?php echo $objlang->get('entry_button_delete'); ?></span></a>
                            </div>
                            <?php } ?>
                            <div id="tab-module<?php echo $module_row; ?>" class="col-sm-12">
								<div class="tab-pane">
									<ul class="nav nav-tabs" id="so_youtech">
										<li>
											<a href="#so_module_module" data-toggle="tab">
												<?php echo $objlang->get('entry_module') ?>
											</a>
										</li>
										<li>
											<a href="#so_module_base_header" data-toggle="tab">
												<?php echo $objlang->get('entry_base_header') ?>
											</a>
										</li>
										
									</ul>
									<div class="tab-content">
									<?php // -----------------------------------------------------------------------?>
										<div class="tab-pane" id="so_module_module"> <?php //<!--General Option --> ?> 
											
											<div class="form-group"> <?php //<!--name -->?>
												<label class="col-sm-2 control-label" for="input-name"> <b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_name_desc'); ?>"><?php echo $objlang->get('entry_name'); ?> </span></label>

												<div class="col-sm-10">
													<div class="col-sm-5">
														<input type="text" name="name" value="<?php echo $module['name']; ?>" placeholder="<?php echo $objlang->get('entry_name'); ?>" id="input-name" class="form-control"/>
													</div>
												<?php if (isset($error_name)) { ?>
													<div class="text-danger col-sm-12"><?php echo $error_name; ?></div>
												<?php } ?>
												</div>
											</div>
											<div class="form-group"> <?php //<!--Title -->?>
												<input type="hidden" name="action" id="action" value=""/>
												<label class="col-sm-2 control-label" for="input-head_name"><b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_head_name_desc'); ?>"><?php echo $objlang->get('entry_head_name'); ?> </span></label>
												<div class="col-sm-10">
													<div class="col-sm-5">
														<?php
															$i = 0;
															foreach ($languages as $language) { $i++; ?>
														<input type="text" name="module_description[<?php echo $language['language_id']; ?>][head_name]" placeholder="<?php echo $objlang->get('entry_head_name'); ?>" id="input-head-name-<?php echo $language['language_id']; ?>" value="<?php echo isset($module_description[$language['language_id']]['head_name']) ? $module_description[$language['language_id']]['head_name'] : ''; ?>" class="form-control <?php echo ($i>1) ? ' hide ' : ' first-name'; ?>" />
														<?php
																 if($i == 1){ ?>
														<input type="hidden" class="form-control" id="input-head_name" placeholder="<?php echo $objlang->get('entry_head_name'); ?>" value="<?php echo isset($module_description[$language['language_id']]['head_name']) ? $module_description[$language['language_id']]['head_name'] : ''; ?>" name="head_name">
														<?php }
																 ?>
														<?php } ?>
													</div>
													<div class="col-sm-3">
														<select  class="form-control" id="language">
															<?php foreach ($languages as $language) { ?>
															<option value="<?php echo $language['language_id']; ?>">
																<?php echo $language['name']; ?>
															</option>
															<?php } ?>
														</select>
													</div>
													<?php if (isset($error['head_name'])) { ?>
													<div class="text-danger col-sm-12"><?php echo $error['head_name']; ?></div>
													<?php }?>
												</div>
											</div>
											<div class="form-group"> <?php //<!--display_title_module -->?>
												<label class="col-sm-2 control-label" for="input-disp_title_module">
													<?php echo $objlang->get('entry_display_title_module'); ?>
												</label>
												<div class="col-sm-10">
													<div class="col-sm-5">
														<select name="disp_title_module" id="input-disp_title_module" class="form-control">
															<?php if ($module['disp_title_module']) { ?>
															<option value="1" selected="selected"><?php echo $objlang->get('text_yes'); ?></option>
															<option value="0"><?php echo $objlang->get('text_no'); ?></option>
															<?php } else { ?>
															<option value="1"><?php echo $objlang->get('text_yes'); ?></option>
															<option value="0" selected="selected"><?php echo $objlang->get('text_no'); ?></option>
															<?php } ?>
														</select>
													</div>
												</div>
											</div>
								<div class="form-group"> <?php //====Theme Custom Code=====?>
									<label class="col-sm-2 control-label" for="input-open_link">Type Layout</label>
									<div class="col-sm-10">
										<div class="col-sm-5">
											<select name="type_layout" id="input-type_layout" class="form-control">
												<?php
													foreach($type_layout as $option_id => $option_value)
													{
														$selected = ($option_id == $module['type_layout']) ? 'selected' :'';
												?>
														<option value="<?php echo $option_id ?>" <?php echo $selected ?> ><?php echo $option_value ?></option>
												<?php
													}
												?>
											</select>
										</div>
									</div>
								</div>			
								<div class="form-group"> <?php //<!--class -->?>
                                    <label class="col-sm-2 control-label" for="input-class">
										<?php echo $objlang->get('entry_class'); ?>
									</label>
                                    <div class="col-sm-10">
                                        <div class="col-sm-5">
                                            <input type="text" name="class" value="<?php echo $module['class']; ?>" placeholder="<?php echo $objlang->get('entry_class'); ?>" id="input-class" class="form-control"/>
                                            <?php if (isset($error_class)) { ?>
                                            <div class="text-danger"><?php echo $error_class; ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
								
                                <div class="form-group"> <?php //<!--width -->?>
									<label class="col-sm-2 control-label" for="input-width"><b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_width_desc'); ?>"><?php echo $objlang->get('entry_width'); ?> </span></label>
                                    <div class="col-sm-10">
                                        <div class="col-sm-5">
											<input type="text" name="width" value="<?php echo $module['width']; ?>" placeholder="<?php echo $objlang->get('entry_width'); ?>" id="input-width" class="form-control"/>
										<?php if (isset($error['width'])){ ?>
                                            <div class="text-danger"><?php echo $error['width']; ?></div>
										<?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group"> <?php //<!--height -->?>
                                   <label class="col-sm-2 control-label" for="input-height"><b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_height_desc'); ?>"><?php echo $objlang->get('entry_height'); ?> </span></label>
                                    <div class="col-sm-10">
                                        <div class="col-sm-5">
                                            <input type="text" name="height" value="<?php echo $module['height']; ?>" placeholder="<?php echo $objlang->get('entry_height'); ?>" id="input-height" class="form-control"/>
                                            <?php if (isset($error['height'])){ ?>
                                            <div class="text-danger"><?php echo $error['height']; ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group"> <?php //<!--limit -->?>
									<label class="col-sm-2 control-label" for="input-limit"><b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_limit_desc'); ?>"><?php echo $objlang->get('entry_limit'); ?> </span></label>
                                    <div class="col-sm-10">
                                        <div class="col-sm-5">
                                            <input type="text" name="limit" value="<?php echo $module['limit']; ?>"
                                                   placeholder="<?php echo $objlang->get('entry_limit'); ?>" id="input-limit"
                                                   class="form-control"/>
                                            <?php if (isset($error['limit'])){ ?>
                                            <div class="text-danger"><?php echo $error['limit']; ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-group"> <?php //<!--character -->?>
									<label class="col-sm-2 control-label" for="input-character"><b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_character_desc'); ?>"><?php echo $objlang->get('entry_character'); ?> </span></label>
                                    <div class="col-sm-10">
                                        <div class="col-sm-5">
                                            <input type="text" name="character" value="<?php echo $module['character']; ?>" placeholder="<?php echo $objlang->get('entry_character'); ?>" id="input-character" class="form-control"/>
                                            <?php if (isset($error['character'])){ ?>
                                            <div class="text-danger"><?php echo $error['character']; ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group"> <?php //<!--showcategory -->?>
                                    <label class="col-sm-2 control-label" for="input-status">
										<?php echo $objlang->get('entry_showcategory'); ?>
								   </label>
                                    <div class="col-sm-10">
                                        <div class="col-sm-5">
                                            <select name="showcategory" id="input-status" class="form-control">
                                                <?php if ($module['showcategory']) { ?>
                                                <option value="1"
                                                        selected="selected"><?php echo $objlang->get('text_enabled'); ?></option>
                                                <option value="0"><?php echo $objlang->get('text_disabled'); ?></option>
                                                <?php } else { ?>
                                                <option value="1"><?php echo $objlang->get('text_enabled'); ?></option>
                                                <option value="0"
                                                        selected="selected"><?php echo $objlang->get('text_disabled'); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group"> <?php //<!--showimage -->?>
                                    <label class="col-sm-2 control-label" for="input-status">
										<?php echo $objlang->get('entry_showimage'); ?>
									</label>
                                    <div class="col-sm-10">
                                        <div class="col-sm-5">
                                            <select name="showimage" id="input-status" class="form-control">
                                                <?php if ($module['showimage']) { ?>
                                                <option value="1" selected="selected"><?php echo $objlang->get('text_enabled'); ?></option>
                                                <option value="0"><?php echo $objlang->get('text_disabled'); ?></option>
                                                <?php } else { ?>
                                                <option value="1"><?php echo $objlang->get('text_enabled'); ?></option>
                                                <option value="0" selected="selected"><?php echo $objlang->get('text_disabled'); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group"> <?php //<!--showprice -->?>
                                    <label class="col-sm-2 control-label" for="input-status">
										<?php echo $objlang->get('entry_showprice'); ?>
									</label>
                                    <div class="col-sm-10">
                                        <div class="col-sm-5">
                                            <select name="showprice" id="input-status" class="form-control">
                                                <?php if ($module['showprice']) { ?>
                                                <option value="1" selected="selected"><?php echo $objlang->get('text_enabled'); ?></option>
                                                <option value="0"><?php echo $objlang->get('text_disabled'); ?></option>
                                                <?php } else { ?>
                                                <option value="1"><?php echo $objlang->get('text_enabled'); ?></option>
                                                <option value="0" selected="selected"><?php echo $objlang->get('text_disabled'); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group"> <?php //<!--status -->?>
                                    <label class="col-sm-2 control-label"
                                           for="input-status"><?php echo $objlang->get('entry_status'); ?></label>

                                    <div class="col-sm-10">
                                        <div class="col-sm-5">
                                            <select name="status" id="input-status" class="form-control">
                                                <?php if ($module['status']) { ?>
                                                <option value="1"
                                                        selected="selected"><?php echo $objlang->get('text_enabled'); ?></option>
                                                <option value="0"><?php echo $objlang->get('text_disabled'); ?></option>
                                                <?php } else { ?>
                                                <option value="1"><?php echo $objlang->get('text_enabled'); ?></option>
                                                <option value="0"
                                                        selected="selected"><?php echo $objlang->get('text_disabled'); ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
								<div class="form-group"> <!--Show keyword -->
                                    <label class="col-sm-2 control-label" for="input-show_keyword">
                                        <span data-toggle="tooltip"
                                              title="<?php echo $text_show_keyword_desc; ?>"><?php echo $text_show_keyword; ?></span>
                                    </label>

                                    <div class="col-sm-10">
                                        <div class="col-sm-5">
                                            <label class="radio-inline">
                                                <?php if ($show_keyword) { ?>
                                                <input type="radio" name="show_keyword" value="1" checked="checked"/>
                                                <?php echo $text_yes; ?>
                                                <?php } else { ?>
                                                <input type="radio" name="show_keyword" value="1"/>
                                                <?php echo $text_yes; ?>
                                                <?php } ?>
                                            </label>
                                            <label class="radio-inline">
                                                <?php if (!$show_keyword) { ?>
                                                <input type="radio" name="show_keyword" value="0" checked="checked"/>
                                                <?php echo $text_no; ?>
                                                <?php } else { ?>
                                                <input type="radio" name="show_keyword" value="0"/>
                                                <?php echo $text_no; ?>
                                                <?php } ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
								
								
								<div class="form-group"> <!--String keyword -->
                                    <label class="col-sm-2 control-label"><?php echo $text_str_keyword; ?> <b
                                                style="color:#f00">*</b></label>

                                    <div class="col-sm-10">
                                        <div class="col-sm-5">
                                            <?php
						$i = 0;
						foreach ($languages as $language) { $i++; ?>
                                            <input type="text"
                                                   name="module_description[<?php echo $language['language_id']; ?>][str_keyword]"
                                                   placeholder="Keyword"
                                                   id="input-str-keyword-<?php echo $language['language_id']; ?>"
                                                   value="<?php echo isset($module_description[$language['language_id']]['str_keyword']) ? $module_description[$language['language_id']]['str_keyword'] : ''; ?>"
                                                   class="form-control <?php echo ($i>1) ? ' hide ' : ' first-name'; ?>"/>
                                            <?php
							 if($i == 1){ ?>
                                            <input type="hidden" class="form-control"
                                                   placeholder="String Keyword"
                                                   value="<?php echo isset($module_description[$language['language_id']]['str_keyword']) ? $module_description[$language['language_id']]['str_keyword'] : ''; ?>"
                                                   name="str_keyword">
                                            <?php }
							 ?>
                                            <?php } ?>
                                        </div>
                                        <div class="col-sm-2">
                                            <select class="form-control" id="language_keyword">
                                                <?php foreach ($languages as $language) { ?>
                                                <option value="<?php echo $language['language_id']; ?>">
                                                    <?php echo $language['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <?php if ($error_str_keyword) { ?>
                                        <div class="text-danger col-sm-12"><?php echo $error_str_keyword; ?></div>
                                        <?php }else { ?>
                                        <i class="col-sm-12"
                                           style="font-weight:normal; color:#ccc"><?php echo $text_str_keyword_desc ?></i>
                                        <?php } ?>

                                    </div>
                                </div>
								

								<div class="form-group"> <!--limit keyword -->
                                    <label class="col-sm-2 control-label" for="input-limit_keyword">
                                        <span data-toggle="tooltip"
                                              title="<?php echo $text_limit_keyword_desc; ?>"><?php echo $text_limit_keyword; ?></span>
                                    </label>

                                    <div class="col-sm-10">
                                        <div class="col-sm-5">
                                            <input type="text" name="limit_keyword"
                                                   value="<?php echo $limit_keyword; ?>" id="input-limit_keyword"
                                                   class="form-control"/>
                                        </div>
                                        <?php if ($error_limit_keyword) { ?>
                                        <div class="text-danger col-sm-12"><?php echo $error_limit_keyword; ?></div>
                                        <?php }?>
                                    </div>
                                </div>
								
                                <div class="form-group"> <?php //<!--use cache -->?>
                                    <label class="col-sm-2 control-label" for="input-use_cache">
                                        <span data-toggle="tooltip"
                                              title="<?php echo $objlang->get('entry_use_cache_desc'); ?>"><?php echo $objlang->get('entry_use_cache'); ?></span>
                                    </label>

                                    <div class="col-sm-10">
                                        <div class="col-sm-5">
                                            <label class="radio-inline">
                                                <?php if ($module['use_cache']) { ?>
                                                <input type="radio" name="use_cache" value="1" checked="checked"/>
                                                <?php echo $objlang->get('text_yes'); ?>
                                                <?php } else { ?>
                                                <input type="radio" name="use_cache" value="1"/>
                                                <?php echo $objlang->get('text_yes'); ?>
                                                <?php } ?>
                                            </label>
                                            <label class="radio-inline">
                                                <?php if (!$module['use_cache']) { ?>
                                                <input type="radio" name="use_cache" value="0" checked="checked"/>
                                                <?php echo $objlang->get('text_no'); ?>
                                                <?php } else { ?>
                                                <input type="radio" name="use_cache" value="0"/>
                                                <?php echo $objlang->get('text_no'); ?>
                                                <?php } ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="input-cache_time_form"> <?php //<!--cache time -->?>
                                    <label class="col-sm-2 control-label" for="input-cache_time">
                                        <span data-toggle="tooltip"
                                              title="<?php echo $objlang->get('entry_cache_time_desc'); ?>"><?php echo $objlang->get('entry_cache_time'); ?></span>
                                    </label>

                                    <div class="col-sm-10">
                                        <div class="col-sm-5">
                                            <input type="text" name="cache_time"
                                                   value="<?php echo $module['cache_time']; ?>" id="input-cache_time"
                                                   class="form-control"/>
                                        </div>
                                        <?php if (isset($error['cache_time'])) { ?>
                                        <div class="text-danger col-sm-12"><?php echo $error['cache_time']; ?></div>
                                        <?php }?>
                                    </div>
                                </div>
											
										</div>
										
										<div class="tab-pane" id="so_module_base_header"> <?php // <!--Base Option -->?>
										    <?php foreach ($type_header as $header_id => $header_value ) :  $header_id++;?>
											<div class="form-group"> <?php //====Theme Custom Code=====?>
												<label class="col-sm-2 control-label" for="input-open_link">Show Module On <?php echo $header_value ?></label>
												<div class="col-sm-10">
													<div class="col-sm-5">
														<label class="radio-inline">
															<?php if ($module['header_display'.$header_id]) { ?>
															<input type="radio" name="header_display<?php echo $header_id;?>" value="1" checked="checked" />
															<?php echo $objlang->get('text_yes'); ?>
															<?php } else { ?>
															<input type="radio" name="header_display<?php echo $header_id;?>" value="1" />
															<?php echo $objlang->get('text_yes'); ?>
															<?php } ?>
														</label>
														<label class="radio-inline">
															<?php if (!$module['header_display'.$header_id]) { ?>
															<input type="radio" name="header_display<?php echo $header_id;?>" value="0" checked="checked" />
															<?php echo $objlang->get('text_no'); ?>
															<?php } else { ?>
															<input type="radio" name="header_display<?php echo $header_id;?>" value="0" />
															<?php echo $objlang->get('text_no'); ?>
															<?php } ?>
														</label>
													</div>
													
													
												
												</div>
											</div>
											<?php endforeach; ?>
										</div>
									</div>
								</div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

	<script type="text/javascript">
		$('#so_youtech a:first').tab('show');
		$('.first-name').change(function () {
			$('input[name="head_name"]').val($(this).val());
		});
			$('#language_keyword').change(function () {
        var _that = $(this), opt_select = $('option:selected', _that).val(), __input = $('#input-str-keyword-' + opt_select);
        $('[id^="input-str-keyword-"]').addClass('hide');
        __input.removeClass('hide');
    });
		$('#language').change(function () {
			var that = $(this), opt_select = $('option:selected', that).val(), _input = $('#input-head-name-' + opt_select);
			$('[id^="input-head-name-"]').addClass('hide');
			_input.removeClass('hide');
		});
		if ($("input[name='use_cache']:radio:checked").val() == '0') {
			$('#input-cache_time_form').hide();
		} else {
			$('#input-cache_time_form').show();
		}
		$("input[name='use_cache']").change(function () {
			val = $(this).val();
			if (val == 0) {
				$('#input-cache_time_form').hide();
			} else {
				$('#input-cache_time_form').show();
			}
		});
	</script>
	<script type="text/javascript">
        jQuery(document).ready(function ($) {
            var button = '<div class="remove-caching" style="margin-left: 15px"><button type="button" onclick="remove_cache()" title="<?php echo $objlang->get('button_clear_cache'); ?>" class="btn btn-danger"><i class="fa fa-remove"></i> <?php echo $objlang->get('button_clear_cache');?></button></div>';
            var button_min = '<div class="remove-caching" style="margin-left: 7px"><button type="button" onclick="remove_cache()" title="<?php echo $objlang->get('button_clear_cache'); ?>" class="btn btn-danger"><i class="fa fa-remove"></i> </button></div>';
            if($('#column-left').hasClass('active')){
                $('#column-left #stats').after(button);
            }else{
                $('#column-left #stats').after(button_min);
            }
            $('#button-menu').click(function(){
                $('.remove-caching').remove();
                if($(this).parents().find('#column-left').hasClass('active')){
                    $('#column-left #stats').after(button);
                }else{
                    $('#column-left #stats').after(button_min);
                }
            });
        });
        function remove_cache(){
            var success_remove = '<?php echo $success_remove; ?>';
            $.ajax({
                type: 'POST',
                url: '<?php echo $linkremove; ?>',
                data: {	is_ajax_cache_lite: 1},
                success: function () {
                    var html = '<div class="alert alert-success cls-remove-cache"> '+success_remove+' <button type="button" class="close" data-dismiss="alert">&times;</button></div>';
                    if(!($('.page-header .container-fluid .alert-success')).hasClass('cls-remove-cache')){
                        $('.page-header .container-fluid').append(html);
                    }
                },
            });
        }
    </script>
<?php echo $footer; ?>
