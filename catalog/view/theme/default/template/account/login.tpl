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
    @media screen and (max-width: 480px){
        body[class*=account-] #content .form-control{
            height: 50px;
            font-size: 12px;
        }
        .tabs .tabs__caption li {
            font-size: 13px !important;
        }
        body[class*="account-"] #content h2 {
            font-size: 19px;
            font-weight: 700;
        }
    }
    @media screen and (max-width: 360px){
        body[class*="account-"] #content .form-control {
            padding: 0 5px;
        }
    }
    @media screen and (max-width: 350px){
        body[class*="account-"] #content .form-control {
            height: 40px;
            font-size: 10px;
        }
        body[class*="account-"] #content h2 {
            font-size: 16px;
            font-weight: 700;
        }
        .tabs .tabs__caption li {
            font-size: 11px !important;
        }
    }
</style>
<?php if ($tmdaccount_status==1) { ?>
				<link href="catalog/view/theme/default/stylesheet/ele-style.css" rel="stylesheet">
				<link href="catalog/view/theme/default/stylesheet/dashboard.css" rel="stylesheet">
				<div class="container dashboard">
				<?php } else { ?>
				<div class="container">
				<?php } ?>
    <?php if ($success) { ?>
        <div class="alert alert-success">
            <div class="modal-msg__close alert__close">
                <svg class="modal-msg__close-icon">
                    <use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#close"></use>
                </svg>
            </div>
        <?php echo $success; ?></div>
    <?php } ?>
    <?php if ($error_warning) { ?>
        <div class="alert alert-danger">
            <div class="modal-msg__close alert__close">
                <svg class="modal-msg__close-icon">
                    <use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#close"></use>
                </svg>
            </div>
        <?php echo $error_warning; ?></div>
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
            <div class="row">
                <div class="col-sm-6">
                    <div class="well">
                        <h2><?php echo $text_login_modal; ?></h2>
                        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                            <div class="tabs">
                                <div class="tabs__nav">
                                    <ul class="tabs__caption">
                                        <li class="active"><?php echo $text_login_firstfield; ?></li>
                                        <li><?php echo $text_login_secondfield; ?></li>
                                    </ul>
                                </div>
                                <div class="tabs__content active">
                                    <div class="form-group">
                                        <input type="text" name="telephone" value="<?php echo $telephone; ?>" placeholder="<?php echo $text_login_firstfield_telephone; ?>" id="input-email" class="form-control input_mask">
                                    </div>
                                    <div class="form-group">
                                        <div class="login-entry">
                                            <input type="password" name="pin" value="<?php echo $password; ?>" placeholder="<?php echo $text_login_secondfield_pin; ?>" id="input-password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="<?php echo $button_login; ?>" class="bbtn">
                                    </div>
                                </div>
                                <div class="tabs__content">
                                    <div class="form-group">
                                        <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $text_login_firstfield_email; ?>" id="input-email" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <div class="login-entry">
                                            <input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $text_login_secondfield_password; ?>" id="input-password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="<?php echo $button_login; ?>" class="bbtn">
                                    </div>
                                </div>
                            </div>
                            
                            <?php if ($redirect) { ?>
                                <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                            <?php } ?>
                        </form>
                        
                        <div class="form-group">
                            <a href="<?php echo $forgotten; ?>" class="header-account__link"><?php echo $text_forgotten; ?></a>
                            <a href="<?php echo $register; ?>" class="pull-right header-account__link"><?php echo $text_register; ?></a>
                        </div>
                        
                        
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group btn-group-register">
                        <h2 class="popup-header"><?php echo $text_login_as; ?></h2>
                        <div class="col-xs-12 pl-0">      
                            <button type="button" onclick="social_auth.googleplus(this)" data-loading-text="Loading" class="btn btn-primary btn-google">
                                <div class="btn-img" style="padding: 0;margin-right: 13px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" width="46px" height="46px" viewBox="0 0 46 46" version="1.1">
                                        <defs>
                                            <filter x="-50%" y="-50%" width="200%" height="200%" filterUnits="objectBoundingBox" id="filter-1">
                                                <feOffset dx="0" dy="1" in="SourceAlpha" result="shadowOffsetOuter1"/>
                                                <feGaussianBlur stdDeviation="0.5" in="shadowOffsetOuter1" result="shadowBlurOuter1"/>
                                                <feColorMatrix values="0 0 0 0 0   0 0 0 0 0   0 0 0 0 0  0 0 0 0.168 0" in="shadowBlurOuter1" type="matrix" result="shadowMatrixOuter1"/>
                                                <feOffset dx="0" dy="0" in="SourceAlpha" result="shadowOffsetOuter2"/>
                                                <feGaussianBlur stdDeviation="0.5" in="shadowOffsetOuter2" result="shadowBlurOuter2"/>
                                                <feColorMatrix values="0 0 0 0 0   0 0 0 0 0   0 0 0 0 0  0 0 0 0.084 0" in="shadowBlurOuter2" type="matrix" result="shadowMatrixOuter2"/>
                                                <feMerge>
                                                    <feMergeNode in="shadowMatrixOuter1"/>
                                                    <feMergeNode in="shadowMatrixOuter2"/>
                                                    <feMergeNode in="SourceGraphic"/>
                                                </feMerge>
                                            </filter>
                                            <rect id="path-2" x="0" y="0" width="40" height="40" rx="2"/>
                                        </defs>
                                        <g id="Google-Button" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                            <g id="9-PATCH" sketch:type="MSArtboardGroup" transform="translate(-608.000000, -160.000000)"/>
                                            <g id="btn_google_light_normal" sketch:type="MSArtboardGroup" transform="translate(-1.000000, -1.000000)">
                                                
                                                <g id="logo_googleg_48dp" sketch:type="MSLayerGroup" transform="translate(15.000000, 15.000000)">
                                                    <path d="M17.64,9.20454545 C17.64,8.56636364 17.5827273,7.95272727 17.4763636,7.36363636 L9,7.36363636 L9,10.845 L13.8436364,10.845 C13.635,11.97 13.0009091,12.9231818 12.0477273,13.5613636 L12.0477273,15.8195455 L14.9563636,15.8195455 C16.6581818,14.2527273 17.64,11.9454545 17.64,9.20454545 L17.64,9.20454545 Z" id="Shape" fill="#4285F4" sketch:type="MSShapeGroup"/>
                                                    <path d="M9,18 C11.43,18 13.4672727,17.1940909 14.9563636,15.8195455 L12.0477273,13.5613636 C11.2418182,14.1013636 10.2109091,14.4204545 9,14.4204545 C6.65590909,14.4204545 4.67181818,12.8372727 3.96409091,10.71 L0.957272727,10.71 L0.957272727,13.0418182 C2.43818182,15.9831818 5.48181818,18 9,18 L9,18 Z" id="Shape" fill="#34A853" sketch:type="MSShapeGroup"/>
                                                    <path d="M3.96409091,10.71 C3.78409091,10.17 3.68181818,9.59318182 3.68181818,9 C3.68181818,8.40681818 3.78409091,7.83 3.96409091,7.29 L3.96409091,4.95818182 L0.957272727,4.95818182 C0.347727273,6.17318182 0,7.54772727 0,9 C0,10.4522727 0.347727273,11.8268182 0.957272727,13.0418182 L3.96409091,10.71 L3.96409091,10.71 Z" id="Shape" fill="#FBBC05" sketch:type="MSShapeGroup"/>
                                                    <path d="M9,3.57954545 C10.3213636,3.57954545 11.5077273,4.03363636 12.4404545,4.92545455 L15.0218182,2.34409091 C13.4631818,0.891818182 11.4259091,0 9,0 C5.48181818,0 2.43818182,2.01681818 0.957272727,4.95818182 L3.96409091,7.29 C4.67181818,5.16272727 6.65590909,3.57954545 9,3.57954545 L9,3.57954545 Z" id="Shape" fill="#EA4335" sketch:type="MSShapeGroup"/>
                                                    <path d="M0,0 L18,0 L18,18 L0,18 L0,0 Z" id="Shape" sketch:type="MSShapeGroup"/>
                                                </g>
                                                <g id="handles_square" sketch:type="MSLayerGroup"/>
                                            </g>
                                        </g>
                                    </svg>           
                                </div>
                                <span style="color: #000000; opacity: 0.54; font-size: 14px;">Google</span>            
                            </button>
                        </div>
                        
                        <div class="col-xs-12 pr-0 pl-0">
                            <button type="button" onclick="social_auth.facebook(this)" data-loading-text="Loading" class="btn btn-primary btn-facebook">
                                <div class="btn-img"><i class="fa fa-facebook"></i></div> 
                                <span style="color: #000000; opacity: 0.54; font-size: 14px;">Facebook</span>  
                            </button>
                        </div>    
                    </div>
                </div>
            </div>
        <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<style>
			<?php echo $tmdaccount_customcss; ?>
			</style>
<?php echo $footer; ?>