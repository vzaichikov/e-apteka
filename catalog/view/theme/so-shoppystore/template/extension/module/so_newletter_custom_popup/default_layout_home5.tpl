<?php
    $width_popup = ((int)$width) ? $width : '50%';
	
    if($image_bg_display){
        $bg = 'background: url(\''.HTTP_SERVER.'image/'.$image.'\')';
    }else{
        $bg = 'background-color: #'.$color_bg.'';
    }
	
	

?>
<div class="module <?php echo $class_suffix; ?>">
    <div class="so-custom-default newsletter" style="width: <?php echo $width_popup; ?>; <?php echo $bg; ?>; ">
		<?php if($disp_title_module) { ?>
			<h3 class="modtitle"><?php echo $head_name; ?></h3>
		<?php } ?>
		
        <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-7 box-nl-l">
                <div class="modcontent">
                    <div class="group-content">
                        <h2>
                        <?php if($title_display)
                            {
                                echo $title;
                            }
                        ?>
                    </h2>
                    <p class="page-heading-sub"><?php echo $newsletter_promo ;?></p>
                    </div>
                    <div class="group-form">
                        <div class="form-group required">
                            <form method="post" id="signup" name="signup" class="form-inline signup">
                            <div class="input-control">
                                <div class="input-box">
                                    <input type="email" placeholder="<?php echo $newsletter_placeholder ; ?>" value="" class="form-control input-lg" id="txtemail" name="txtemail">
                                </div>
                                <div class="subcribe">
                                    <button class="btn btn-default btn-lg btn-send" type="submit" onclick="return subscribe_newsletter();" name="submit">
                                        <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        </div>
                        
                    </div>
                    
                </div> <!--/.modcontent-->
            </div>
            <?php if($pre_text != ''){?>
			<div class="col-lg-3 col-md-4 col-sm-5 box-nl-r">
				<?php echo html_entity_decode($pre_text);?>
			</div>
			<?php }?>
        </div>
		

        </div>
		<?php if($post_text != '')
		{
		?>
			<div class="form-group">
				<?php echo html_entity_decode($post_text);?>
			</div>
		<?php 
		}
		?>
    </div>
<script type="text/javascript">
    function subscribe_newsletter()
    {
        var emailpattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        var email = $('#txtemail').val();
        var d = new Date();
        var createdate = d.getFullYear() + '-' + (d.getMonth()+1) + '-' + d.getDate() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
        var status   = 0;
        var dataString = 'email='+email+'&createdate='+createdate+'&status='+status;
        if(email != "")
        {
            if(!emailpattern.test(email))
            {
                $('.show-error').remove();
                $('.btn-send').after('<span class="show-error" style="color: red;margin-left: 10px"> Invalid Email </span>')
                return false;
            }
            else
            {
                $.ajax({
                    url: 'index.php?route=module/so_newletter_custom_popup/newsletter',
                    type: 'post',
                    data: dataString,
                    dataType: 'json',
                    success: function(json) {
                        $('.show-error').remove();
                        if(json.message == "Subscription Successfull") {
                            $('.btn-send').after('<span class="show-error" style="color: #003bb3;margin-left: 10px"> ' + json.message + '</span>');
                            setTimeout(function () {
                                var this_close = $('.popup-close');
                                this_close.parent().css('display', 'none');
                                this_close.parents().find('.so_newletter_custom_popup_bg').removeClass('popup_bg');
                            }, 3000);

                        }else{
                            $('.btn-send').after('<span class="show-error" style="color: red;margin-left: 10px"> ' + json.message + '</span>');
                        }
                        document.getElementById('signup').reset();
                    }
                });
                return false;
            }
        }
        else
        {
            alert("Email Is Require");
            $(email).focus();
            return false;
        }
    }
</script>
</div>

