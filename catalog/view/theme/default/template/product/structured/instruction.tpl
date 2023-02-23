<?php if ($type == 'inline') { ?>

	<?php if (!empty($reg_instruction_pdf_href)) { ?>
		<div style="padding:5px 0px 35px;">
			<style>
				.btn-download{box-shadow:none;color:#fff;background-color:#1CACDC;border: 1px solid #1CACDC;}
				.btn-download:hover{color:#fff;}
				.btn-download:visited{color:#fff;}
			</style>
			<a class="btn btn-download col-xs-12 col-lg-4 col-md-6" href="<?php echo $reg_instruction_pdf_href;?>" target="_blank" rel="noindex nofollow"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> <?php echo $text_get_instruction; ?></a>
		</div>
	<?php } ?>

	<?php echo $instruction; ?>
<? } ?>


<?php if ($type == 'embed') { ?>	
	<?php if ($extension == 'pdf') { ?>
		<embed src="<?php echo $instruction; ?>" width="100%" height="800px" type='application/pdf' />
	<? } ?>
<?php } ?>