<?php if (count($languages) > 1) { ?>
<div class="language-list">
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-language">
    <ul class="list-inline hidden-xs">
      <?php foreach ($languages as $language) { ?>
      <?php if ($language['code'] == $code) { ?>
        <li><button class="btn-block language-select is-active" type="button" name="<?php echo $language['code']; ?>" data-url="<?php echo $language['urlcode']; ?>"><?php echo $language['url']; ?></button></li>
      <?php } else { ?>
        <li><button class="btn-block language-select" type="button" name="<?php echo $language['code']; ?>" data-url="<?php echo $language['urlcode']; ?>"><?php echo $language['url']; ?></button></li>
      <?php } ?>
      <?php } ?>
    </ul>

    <div class="visible-xs dropdown">
      <?php foreach ($languages as $language) { ?>
      <?php if ($language['code'] == $code) { ?>
      <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><?php echo $language['url']; ?> <span class="caret"></span></a>  
      <?php } ?>
      <?php } ?>
      <ul class="dropdown-menu dropdown-menu-right language-select-dropdown">
        <?php foreach ($languages as $language) { ?>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-language">
        <input type="hidden" name="code" value="" />
        <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
        <?php if ($language['code'] == $code) { ?>
          <li><button class="btn-block language-select is-active" type="button" name="<?php echo $language['code']; ?>" data-url="<?php echo $language['urlcode']; ?>"><?php echo $language['url']; ?></button></li>
        <?php } else { ?>
          <li><button class="btn-block language-select" type="button" name="<?php echo $language['code']; ?>" data-url="<?php echo $language['urlcode']; ?>"><?php echo $language['url']; ?></button></li>
        <?php } ?>
        <?php } ?>

       
        </form>
      </ul>
    </div>

  </form>
</div>
<script>
  
  $('#form-language .language-select').on('click', function(e) {
		e.preventDefault();
		$('#form-language input[name=\'code\']').val($(this).attr('name'));
		$('#form-language').submit();
	});
  
</script>

<?php if (false) { ?>
<div class="btn-group">
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-language">
  <div class="btn-group">
    <button class="btn-link dropdown-toggle" data-toggle="dropdown">
		<?php foreach ($languages as $language) { ?>
		<?php if ($language['code'] == $code) { ?>
		<img src="catalog/language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>">
		<span class="hidden-xs"><?php echo $language['name']; ?></span> 
		<?php } ?>
		<?php } ?>
		<i class="fa fa-angle-down"></i>
	</button>
	
    <ul class="dropdown-menu">
      <?php foreach ($languages as $language) { ?>
      <li><button class="btn-block language-select" type="button" name="<?php echo $language['code']; ?>"><img src="catalog/language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></button></li>
      <?php } ?>
    </ul>
  </div>
  <input type="hidden" name="code" value="" />
  <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
</form>
</div>
<?php } ?>

<?php } ?>
