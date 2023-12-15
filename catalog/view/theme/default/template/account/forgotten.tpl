<?php echo $header; ?>

<?php include(DIR_TEMPLATEINCLUDE . 'structured/breadcrumbs.tpl'); ?>
<style>
    body[class*=account-] #content .bbtn {
    width: 100%;
    font-size: 15px;
    padding: 12px;
    }
    body[class*=account-] #content .form-control{
    height: 60px;
    }
    .form-group a{
    margin-top: 5px;
    display: inline-block;
    }
</style>

<?php if ($tmdaccount_status==1) { ?>
				<link href="catalog/view/theme/default/stylesheet/ele-style.css" rel="stylesheet">
				<link href="catalog/view/theme/default/stylesheet/dashboard.css" rel="stylesheet">
				<div class="container dashboard">
				<?php } else { ?>
				<div class="container">
				<?php } ?>
    <div class="row"><?php echo $column_left; ?>
        <?php if ($column_left && $column_right) { ?>
            <?php $class = 'col-sm-6'; ?>
            <?php } elseif ($column_left || $column_right) { ?>
            <?php $class = 'col-sm-9'; ?>
            <?php } else { ?>
            <?php $class = 'col-sm-12'; ?>
        <?php } ?>
        <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
            <h1><?php echo $heading_title; ?></h1>     
            
            <div class="row">
                <div class="col-sm-12">
                    
                    
                    <?php if ($error_warning) { ?>
                        <div class="alert alert-danger">
                            <div class="modal-msg__close alert__close">
                                <svg class="modal-msg__close-icon">
                                    <use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#close"></use>
                                </svg>
                            </div> <?php echo $error_warning; ?>
                        </div>
                    <?php } ?>
                    
                    <div class="well" style="padding:20px 40px;">                                                
                        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                            <div class="tabs">
                                <div class="tabs__nav">
                                    <ul class="tabs__caption">
                                        <li class="active"><?php echo $tab_phone; ?></li>
                                        <li><?php echo $tab_email; ?></li>
                                    </ul>
                                </div>
                                
                                <div class="tabs__content active">
                                    
                                    <div class="text-info" style="padding:10px 0px 5px;">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $text_if_you_remember_telephone; ?>
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="text" name="telephone" value="<?php echo $telephone; ?>" placeholder="" id="input-telephone" class="input_mask form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="<?php echo $button_continue_phone; ?>" class="bbtn" />
                                    </div>
                                </div>
                                
                                <div class="tabs__content">
                                    
                                    <div class="text-info" style="padding:10px 0px 5px;">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $text_if_you_remember_email; ?>
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $text_login_firstfield_email; ?>" id="input-email" class=" form-control">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="<?php echo $button_continue_email; ?>" class="bbtn">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php echo $content_bottom; ?>
        </div>
    <?php echo $column_right; ?></div>
</div>
<style>
			<?php echo $tmdaccount_customcss; ?>
			</style>
<?php echo $footer; ?>                                            
<script>
    jQuery(document).ready(function($) {
         $("input.input_mask").inputmask("+38 999 999 99 99");
    });
</script>