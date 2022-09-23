<?php echo $header; ?>

<div class="container">
  <!-- breadcrumb -->
  <ul class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
    <?php $ListItem_pos = 1; ?>
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li itemprop="itemListElement" itemscope
    itemtype="https://schema.org/ListItem"><a href="<?php echo $breadcrumb['href']; ?>" itemprop="item"><span itemprop="name"><?php echo $breadcrumb['text']; ?></span></a><meta itemprop="position" content="<?php echo $ListItem_pos++; ?>" /></li>
    <?php } ?>
  </ul> 
  <!-- breadcrumb -->
</div>

<div class="container">
  	<?php if ($error_warning) { ?>
  		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		</div>
  	<?php } ?>
  	<div class="row">
  		<?php echo $column_left; ?>
    	<?php if ($column_left && $column_right) { ?>
    		<?php $class = 'col-sm-6'; ?>
    	<?php } elseif ($column_left || $column_right) { ?>
    		<?php $class = 'col-sm-9'; ?>
    	<?php } else { ?>
    		<?php $class = 'col-sm-12'; ?>
    	<?php } ?>
    	<div id="content" class="<?php echo $class; ?>">
    		<?php echo $content_top; ?>
    		<h1><?php echo $heading_title; ?></h1><br>
    		<div class="so-onepagecheckout layout1 <?php if ($is_logged_in) echo 'is_customer'?>">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo $cart; ?>
                    </div>
                </div>

                <div class="row">
        			<div class="col-md-6 col-xs-12">
        				<?php if (!$is_logged_in) { ?>
    	    				<div class="checkout-content login-box">
    	    					<h2 class="secondary-title"><i class="fa fa-user"></i><?php echo $text_checkout_create_account_login; ?></h2>
                                <div class="box-inner">
                                    <?php if ($setting_so_onepagecheckout_layout_setting['so_onepagecheckout_register_checkout'] == 1) {?>
        	    					<div class="radio">
                                        <label class="radio__box-wrap">
            								<input type="radio" id="onepagecheckout-login-box-register" class="radio__input" name="account" value="register" <?php if (@$default_auth === 'register'): ?> checked="checked" <?php endif; ?>><span class="radio__box"></span>
                                        </label><label for="onepagecheckout-login-box-register" class="radio__text"><?php echo $text_register; ?></label>
        							</div>
                                    <?php }?>
        							<?php if ($allow_guest_checkout && $setting_so_onepagecheckout_layout_setting['so_onepagecheckout_guest_checkout'] == 1) { ?>
                                    <div class="radio">
            	                        <label class="radio__box-wrap">
            	                            <input type="radio" id="onepagecheckout-login-box-guest" class="radio__input"  name="account" value="guest" <?php if ($default_auth === 'guest'): ?> checked="checked" <?php endif; ?>><span class="radio__box"></span>
            	                        </label><label for="onepagecheckout-login-box-guest" class="radio__text"><?php echo $text_guest; ?></label>
                                    </div>
        	                        <?php } ?>
                                    <?php if ($setting_so_onepagecheckout_layout_setting['so_onepagecheckout_enable_login'] == 1) {?>
                                    <div class="radio">
            							<label class="radio__box-wrap">
            								<input type="radio" id="onepagecheckout-login-box-login" class="radio__input"  name="account" value="login" <?php if (@$default_auth === 'login'): ?> checked="checked" <?php endif; ?>><span class="radio__box"></span>
                                        </label><label for="onepagecheckout-login-box-login" class="radio__text"><?php echo $text_returning_customer; ?></label>
                                    </div>
                                    <?php }?>
                                </div>
    						</div>
    					<?php }?>

    					<?php if (!$is_logged_in && $setting_so_onepagecheckout_layout_setting['so_onepagecheckout_enable_login'] == 1) {?>
    	                    <div class="checkout-content checkout-login">
    	                        <fieldset>
    	                            <h2 class="secondary-title"><i class="fa fa-unlock"></i><?php echo $text_returning_customer; ?></h2>
                                    <div class="box-inner">
        	                            <div class="form-group">
        	                                <input type="text" name="login_email" value="" placeholder="<?php echo $entry_email; ?>" id="input-login_email" class="form-control" />
        	                            </div>
        	                            <div class="form-group">
        	                                <input type="password" name="login_password" value="" placeholder="<?php echo $entry_password; ?>" id="input-login_password" class="form-control" />
        	                                <a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a>
        	                            </div>
        	                            <div class="form-group">
        	                                <input type="button" value="<?php echo $button_login; ?>" id="button-login" data-loading-text="<?php echo $text_loading; ?>" class="bbtn" />
        	                            </div>
                                    </div>
    	                        </fieldset>
    	                    </div>
                        <?php }?>

                        <?php echo @$register_form; ?>
        			</div>
                    
        			<div class="col-md-6 col-xs-12">
                        <div class="row">
                            <div class="col-md-12">
                                <?php if ($is_logged_in) { ?>
                                    <?php echo $payment_address; ?>
                                    <?php if ($is_shipping_required) { ?>
                                        <?php echo $shipping_address; ?>
                                    <?php }?>
                                <?php }?>
                                <div class="ship-payment">
                                    <?php if ($is_shipping_required) {?>
                                        <?php echo $shipping_methods; ?>
                                    <?php }?>

                                    <?php echo $payment_methods; ?>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <?php if (false) { ?>
                                <div id="coupon_voucher_reward">
                                   <?php echo $coupon_voucher_reward; ?>
                                </div>
                                <?php } ?>


                                
                                <div class="checkout-content confirm-section">
                                    <?php if ($setting_so_onepagecheckout_layout_setting['comment_status']) {?>
                                    <div>
                                        <h2 class="secondary-title"><i class="fa fa-comment"></i><?php echo $text_comments; ?></h2>
                                        <label>
                                            <textarea name="comment" rows="8" class="form-control <?php if ($setting_so_onepagecheckout_layout_setting['require_comment_status']) echo 'requried'?>"><?php echo $comment; ?></textarea>
                                        </label>
                                    </div>
                                    <?php }?>
                                    <?php if ($entry_newsletter && $setting_so_onepagecheckout_layout_setting['show_newsletter']): ?>
                                    <div class="check check-newsletter">
                                        <label class="check__box-wrap">
                                            <input type="checkbox" class="check__input" name="newsletter" value="1" id="newsletter"><span class="check__box"></span>
                                        </label>
                                        <label for="newsletter" class="check__text"><?php echo $entry_newsletter; ?></label>
                                    </div>
                                    <?php endif; ?>

                                    <?php if ($text_privacy && $setting_so_onepagecheckout_layout_setting['show_privacy']): ?>
                                    <div class="check check-privacy">
                                        <label class="check__box-wrap">
                                            <input type="checkbox" id="privacy-1" class="check__input" name="privacy" value="1" /><span class="check__box"></span>
                                        </label>
                                        <label for="privacy-1" class="check__text"><?php echo $text_privacy; ?></label>
                                    </div>
                                    <?php endif; ?>

                                    <?php if ($text_agree && $setting_so_onepagecheckout_layout_setting['show_term']): ?>
                                    <div class="check check-terms">
                                        <label class="check__box-wrap">
                                            <input type="checkbox" id="agree-1" class="check__input" name="agree" value="1" /><span class="check__box"></span>
                                        </label>
                                        <label for="agree-1" class="check__text"><?php echo $text_agree; ?></label>
                                    </div>
                                    <?php endif; ?>
                                    <div class="confirm-order">
                                        <button id="so-checkout-confirm-button" data-loading-text="<?php echo $text_loading?>" class="bbtn confirm-button"><?php echo $text_confirm_order?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
        			</div>
                </div>
    		</div>
    		<?php echo $content_bottom; ?>
    	</div>
    </div>
</div>
<?php echo $footer; ?>