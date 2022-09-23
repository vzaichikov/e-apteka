<style>
	h1, h2, h3, h4, h5, h6, p{
	margin-top:8.5px;
	margin-bottom:8.5px;
	}
	.zoom {
    transition: transform .2s;
	}	
	.zoom:hover {
    transform: scale(2.0);
	z-index:999999999999999;
	}
	.mb{
	margin-bottom:10px;
	}
</style>
<? $i = 1; ?>
<div class="row mb">
	<? if (isset($result) && $result) { ?>
		<? foreach ($result as $image) { ?>				
			<div class="col-md-3 text-center">
				<div class="row"><img class="img-thumbnail img-search zoom" id="img-search-<? echo $i; ?>" src="<?php echo $image['media_preview']; ?>" alt="" title="" width="250" height="250" /></div>
				<h4>
					<span class="label label-info"><?php echo $image['domain']; ?></span>
					<label class="control-label">
						<span data-toggle="tooltip" title="<? echo $image['title']; ?>"></span>
					</label>
				</h4>
				<h4>
					<span class="label label-primary"><?php echo $image['width']; ?> x <?php echo $image['height']; ?></span>
					<a href="<?php echo $image['url']; ?>" target="_blank"><i class="fa fa-external-link-square" aria-hidden="true"></i></a>
				</h4>
				<input type="hidden" id="img-search-real-url-<? echo $i; ?>" data-real-url="<?php echo $image['media']; ?>" />
				<button type="button" data-for-idx="<? echo $i; ?>" data-for="img-search-<? echo $i; ?>" class="btn btn-success btn-image-search-use">Использовать</button>
			</div>
			<? if ($i%4 == 0) { ?>						
			</div>
			<div class="row mb">
			<? } ?>
			<? $i++; ?>
		<? } ?>
	<? } else { ?>
		<? if ($explanation) { ?>
			<span class="label label-danger"><? echo $explanation; ?></span>
		<? } ?>
	<? } ?>
</div>
<div class="row small text-center">api v0.9</div>