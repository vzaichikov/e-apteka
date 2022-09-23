<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<a onclick="$('#form input[name=apply]').val(1); $('#form').submit();" data-toggle="tooltip" title="<?php echo $button_apply; ?>" class="btn btn-success"><i class="fa fa-check"></i></a>
				<button type="submit" form="form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
		<?php if ($success) { ?>
			<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
		<?php } ?>
		<?php if ($error_warning) { ?>
			<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
		<?php } ?>
		<div class="panel panel-default"> 
			<div class="panel-heading"><h3 class="panel-title"><i class="fa fa-pencil"></i> Настройки модуля</h3></div>
			<div class="tab-pane">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" name="setting" id="form">
					<table id="module" class="list">
						<tr>
							<td><?php echo $text_addtocart_logic; ?></td>
							<td>
								<input type="checkbox" name="popupcart[addtocart_logic]" value="1" <?php echo isset($settings['addtocart_logic']) ? 'checked="checked"' : ''; ?> />
								&nbsp; Если не отмечено, то просто будет меняться надпись на кнопке
							</td>
						</tr>
						<tr>
							<td><?php echo $text_click_on_cart; ?></td>
							<td>
								<input type="checkbox" name="popupcart[click_on_cart]" value="1" <?php echo isset($settings['click_on_cart']) ? 'checked="checked"' : ''; ?> />
								&nbsp; Если не отмечено, то просто будет стандартный блок корзины
							</td>
						</tr>
						<tr>
							<td><?php echo $text_related_show; ?></td>
							<td><input type="checkbox" name="popupcart[related_show]" value="1" <?php echo isset($settings['related_show']) ? 'checked="checked"' : ''; ?> /></td>
						</tr>
						<tr>
							<td><?php echo $text_related_heading; ?></td>
							<td>
								<?php foreach ($languages as $language) { ?>
									<div class="input-group">
										<span class="input-group-addon"><img src="<?php echo 'language/'.$language['code'].'/'.$language['code'].'.png'; ?>" title="<?php echo $language['name']; ?>" /></span>
										<input type="text" name="popupcart[related_heading][<?php echo $language['language_id']; ?>]" value="<?php echo isset($settings['related_heading'][$language['language_id']]) ? $settings['related_heading'][$language['language_id']] : $entry_related_heading; ?>" class="form-control" />
									</div>
								<?php } ?>
							</td>
						</tr>
						<tr>
							<td><?php echo $text_related_product; ?></td>
							<td>
								<label><input type="checkbox" name="popupcart[related_product1]" value="1" <?php echo isset($settings['related_product1']) ? 'checked="checked"' : ''; ?> /><span></span><?php echo $text_related_product0; ?></label><br />
								<label><input type="checkbox" name="popupcart[related_product2]" value="1" <?php echo isset($settings['related_product2']) ? 'checked="checked"' : ''; ?> /><span></span><?php echo $text_related_product1; ?></label><br />
							</td>
						</tr>
						<tr>
							<td><?php echo $text_head; ?></td>
							<td>
								<?php foreach ($languages as $language) { ?>
									<div class="input-group">
										<span class="input-group-addon"><img src="<?php echo 'language/'.$language['code'].'/'.$language['code'].'.png'; ?>" title="<?php echo $language['name']; ?>" /></span>
										<input type="text" name="popupcart[module_head][<?php echo $language['language_id']; ?>]" value="<?php echo isset($settings['module_head'][$language['language_id']]) ? $settings['module_head'][$language['language_id']] : $entry_head; ?>" class="form-control" />
									</div>
								<?php } ?>		
							</td>
						</tr>
						<tr>
							<td><?php echo $text_button_name_shopping_show; ?></td>
							<td>
								<label><input type="checkbox" name="popupcart[button_shopping_show]" value="1" <?php echo isset($settings['button_shopping_show']) ? 'checked="checked"' : ''; ?> /><span></span></label>
							</td>
						</tr>
						<tr>
							<td><?php echo $text_button_name_shopping; ?></td>
							<td>
								<?php foreach ($languages as $language) { ?>
									<div class="input-group">
										<span class="input-group-addon"><img src="<?php echo 'language/'.$language['code'].'/'.$language['code'].'.png'; ?>" title="<?php echo $language['name']; ?>" /></span>
										<input type="text" name="popupcart[button_shopping][<?php echo $language['language_id']; ?>]" value="<?php echo isset($settings['button_shopping'][$language['language_id']]) ? $settings['button_shopping'][$language['language_id']] : $entry_button_name_shopping; ?>" class="form-control" />
									</div>
								<?php } ?>		
							</td>
						</tr>
						<tr>
							<td><?php echo $text_button_name_cart_show; ?></td>
							<td>
								<label><input type="checkbox"  name="popupcart[button_cart_show]" value="1" <?php echo isset($settings['button_cart_show']) ? 'checked="checked"' : ''; ?> /><span></span></label>
							</td>
						</tr>
						<tr>
							<td><?php echo $text_button_name_cart; ?></td>
							<td>
								<?php foreach ($languages as $language) { ?>
									<div class="input-group">
										<span class="input-group-addon"><img src="<?php echo 'language/'.$language['code'].'/'.$language['code'].'.png'; ?>" title="<?php echo $language['name']; ?>" /></span>
										<input type="text" name="popupcart[button_cart][<?php echo $language['language_id']; ?>]" value="<?php echo isset($settings['button_cart'][$language['language_id']]) ? $settings['button_cart'][$language['language_id']] : $entry_button_name_cart; ?>" class="form-control" />
									</div>
								<?php } ?>		
							</td>
						</tr>
						<tr>
							<td><?php echo $text_button_name_checkout; ?></td>
							<td>
								<?php foreach ($languages as $language) { ?>
									<div class="input-group">
										<span class="input-group-addon"><img src="<?php echo 'language/'.$language['code'].'/'.$language['code'].'.png'; ?>" title="<?php echo $language['name']; ?>" /></span>	
										<input type="text" name="popupcart[button_checkout][<?php echo $language['language_id']; ?>]" value="<?php echo isset($settings['button_checkout'][$language['language_id']]) ? $settings['button_checkout'][$language['language_id']] : $entry_button_name_checkout; ?>" class="form-control" />
									</div>
								<?php } ?>		
							</td>
						</tr>
						<tr>
							<td><?php echo $text_manufacturer_show; ?></td>
							<td>
								<label><input type="checkbox"  name="popupcart[manufacturer_show]" value="1" <?php echo isset($settings['manufacturer_show']) ? 'checked="checked"' : ''; ?> /><span></span></label>
							</td>
						</tr>
						<tr>
							<td><?php echo $text_button_name_incart_logic; ?></td>
							<td>
								<label><input type="radio" id="logic0" name="popupcart[button_incart_logic]" value="0" <?php echo !isset($settings['button_incart_logic']) || $settings['button_incart_logic'] == 0 ? 'checked="checked"' : ''; ?> /><span></span><?php echo $text_button_name_incart_logic_label0; ?></label><br />
								<label><input type="radio" id="logic1" name="popupcart[button_incart_logic]" value="1" <?php echo isset($settings['button_incart_logic']) && $settings['button_incart_logic'] == 1 ? 'checked="checked"' : ''; ?> /><span></span><?php echo $text_button_name_incart_logic_label1; ?></label>
							</td>
						</tr>
						<tr>
							<td><?php echo $text_button_name_incart; ?></td>
							<td>
								<?php foreach ($languages as $language) { ?>
									<div class="input-group">
										<span class="input-group-addon"><img src="<?php echo 'language/'.$language['code'].'/'.$language['code'].'.png'; ?>" title="<?php echo $language['name']; ?>" /></span>
										<input type="text" name="popupcart[button_incart][<?php echo $language['language_id']; ?>]" value="<?php echo isset($settings['button_incart'][$language['language_id']]) ? $settings['button_incart'][$language['language_id']] : $entry_button_name_incart; ?>" class="form-control" />
									</div>
								<?php } ?>	
							</td>
						</tr>
						<tr>
							<td><?php echo $text_button_name_incart_with_options; ?></td>
							<td>
								<?php foreach ($languages as $language) { ?>
									<div class="input-group">
										<span class="input-group-addon"><img src="<?php echo 'language/'.$language['code'].'/'.$language['code'].'.png'; ?>" title="<?php echo $language['name']; ?>" /></span>
										<input type="text" name="popupcart[button_incart_with_options][<?php echo $language['language_id']; ?>]" value="<?php echo isset($settings['button_incart_with_options'][$language['language_id']]) ? $settings['button_incart_with_options'][$language['language_id']] : $entry_button_name_incart_with_options; ?>" class="form-control" />
									</div>
								<?php } ?>		
							</td>
						</tr>
						<tr>
							<td colspan="2"><div id="copyright"><?php echo $text_copyright; ?></div></td>
						</tr>
					</table>	
					<input type="hidden" name="apply" value="0" />
				</form>
			</div>
		</div>
	</div>
</div>
<style> 
	h1 {display:block !important;}
	#module {width:100%;}
	#module tr:nth-child(even) {background:#f5f5f5;border-top:solid 1px #ddd;border-bottom:solid 1px #ddd;}
	#module tr td:first-child{width:350px; border-right:solid 1px #ddd;}
	#module tr td {padding:10px}
	#module a{cursor:pointer;}
	#copyright {padding:15px;font-size:1.1em;}
	#copyright a {color:#f00;text-decoration:underline}
	.odd {background:#f4f4f4 !important;}
	.scrollbox {border:1px solid #CCCCCC; width: 350px; height: 150px; padding:4px 6px; margin-bottom:10px; background: #FFFFFF; overflow-y: scroll;}
  </style>
<?php echo $footer; ?>