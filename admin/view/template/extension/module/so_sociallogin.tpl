<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  	<div class="page-header">
    	<div class="container-fluid">
      		<div class="pull-right">
        		<button type="submit" form="form-so-sociallogin" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $button_save; ?></button>
        		<a class="btn btn-success" onclick="$('#action').val('save_edit');$('#form-so-sociallogin').submit();" data-toggle="tooltip" title="<?php echo $objlang->get('entry_button_save_and_edit'); ?>" ><i class="fa fa-pencil-square-o"></i> <?php echo $objlang->get('entry_button_save_and_edit')?></a>
				<a class="btn btn-info" onclick="$('#action').val('save_new');$('#form-so-sociallogin').submit();" data-toggle="tooltip" title="<?php echo $objlang->get('entry_button_save_and_new'); ?>" ><i class="fa fa-book"></i>  <?php echo $objlang->get('entry_button_save_and_new')?></a>
        		<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-danger"><i class="fa fa-reply"></i> <?php echo $button_cancel; ?></a>
        	</div>
			<h1><?php echo $heading_title_so; ?></h1>
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
    	<?php if ($success) { ?>
    		<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      			<button type="button" class="close" data-dismiss="alert">&times;</button>
    		</div>
    	<?php } ?>
    	<div class="panel panel-default">
      		<div class="panel-heading">
        		<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      		</div>
      		<div class="panel-body">
	   			<ul class="nav nav-tabs">
            		<li class="active"><a href="#tab-setting" data-toggle="tab"><i class="fa fa-cog fa-fw"></i> <?php echo $tab_setting; ?></a></li>
            		<li><a href="#tab-facbook" data-toggle="tab"><i class="fa fa-facebook"></i> <?php echo $tab_facbook; ?></a></li>
            		<li><a href="#tab-twitter" data-toggle="tab"><i class="fa fa-twitter-square"></i> <?php echo $tab_twitter; ?></a></li>
            		<li><a href="#tab-google" data-toggle="tab"><i class="fa fa-google"></i> <?php echo $tab_google; ?></a></li>
            		<li><a href="#tab-linkedin" data-toggle="tab"><i class="fa fa-linkedin-square"></i> <?php echo $tab_linkedin; ?></a></li>
            		<li><a href="#tab-introductions" data-toggle="tab"><i class="fa fa-graduation-cap"></i> <?php echo $tab_introductions; ?></a></li>
          		</ul>
    			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-so-sociallogin" class="form-horizontal">
    				<input type="hidden" name="action" id="action" value=""/>        
					<div class="tab-content">
						<div class="tab-pane active in" id="tab-setting">			  
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
								<div class="col-sm-10">
				  					<input type="text" name="so_sociallogin[so_sociallogin_name]" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
				  					<?php if ($error_name) { ?>
				  						<div class="text-danger"><?php echo $error_name; ?></div>
				  					<?php } ?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-icon"><?php echo $entry_iconsize; ?></label>
								<div class="col-sm-10">
									<div class="row">
										<div class="col-sm-6">
											<input type="text" name="so_sociallogin[so_sociallogin_width]" value="<?php echo $width; ?>" placeholder="" id="input-width" class="form-control" />
											<?php if ($error_width) { ?>
										  		<div class="text-danger"><?php echo $error_width; ?></div>
										  	<?php } ?>
										</div>
										<div class=" col-sm-6">
											<input type="text" name="so_sociallogin[so_sociallogin_height]" value="<?php echo $height; ?>" placeholder="" id="input-height" class="form-control" />
											<?php if ($error_height) { ?>
										  		<div class="text-danger"><?php echo $error_height; ?></div>
										  	<?php } ?>
										</div>
									</div>
									<div class="help-block">Note: Only use for Button Social is Image</div>
								</div>
							</div>
							<div class="form-group">
					            <label class="col-sm-2 control-label" for="input-button"><?php echo $entry_buttonsocial; ?></label>
								<div class="col-sm-10">
								  	<select name="so_sociallogin[so_sociallogin_button]" id="input-button" class="form-control">
										<option value="icon" <?php echo $button_social == 'icon' ? 'selected="selected"' : ''?>>Icons</option>
										<option value="image" <?php echo $button_social == 'image' ? 'selected="selected"' : ''?>>Image</option>
								  	</select>
								</div>
				            </div>
							<div class="form-group">
					            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
								<div class="col-sm-10">
								  	<select name="so_sociallogin[so_sociallogin_enable]" id="input-status" class="form-control">
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
					            <label class="col-sm-2 control-label" for="input-popuplogin">Use Popup Login</label>
								<div class="col-sm-10">
								  	<select name="so_sociallogin[so_sociallogin_popuplogin]" id="input-popuplogin" class="form-control">
								  		<?php if ($popuplogin) { ?>
											<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
											<option value="0"><?php echo $text_disabled; ?></option>
										<?php } else { ?>
											<option value="1"><?php echo $text_enabled; ?></option>
											<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
										<?php } ?>
								  	</select>
								</div>
				            </div>
				        </div>
						<div class="tab-pane" id="tab-facbook">
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-fbtitle"><?php echo $entry_title; ?></label>
								<div class="col-sm-10">
								  	<input type="text" name="so_sociallogin[so_sociallogin_fbtitle]" value="<?php echo $fbtitle; ?>" placeholder="<?php echo $entry_title; ?>" id="input-fbtitle" class="form-control" />
								</div>
							</div>
							<div class="form-group">
				                <label class="col-sm-2 control-label" for="input-fbimage"><?php echo $entry_image; ?></label>
				                <div class="col-sm-10">
				                  	<a href="" id="thumb-fbimage" data-toggle="image" class="img-thumbnail"><img src="<?php echo $fbthumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
				                  	<input type="hidden" name="so_sociallogin[so_sociallogin_fbimage]" value="<?php echo $fbimage; ?>" id="input-fbimage" />
				                </div>
				            </div>			  
							<div class="form-group">
						        <label class="col-sm-2 control-label" for="input-fbapikey"><?php echo $entry_apikey; ?></label>
								<div class="col-sm-10">
									<input type="text" name="so_sociallogin[so_sociallogin_fbapikey]" id="fb-apikey" value="<?php echo $fbapikey; ?>" class="form-control"/>
								 	<?php if ($error_fbapikey) { ?>
								  		<div class="text-danger"><?php echo $error_fbapikey; ?></div>
								  	<?php } ?>
					         	</div>
							</div>			
						 	<div class="form-group">
							    <label class="col-sm-2 control-label" for="input-fbsecretapi"><?php echo $entry_apisecret; ?></label>
							 	<div class="col-sm-10">
								 	<input type="text" name="so_sociallogin[so_sociallogin_fbsecretapi]" id="fb-apisecret" value="<?php echo $fbsecretapi; ?>" class="form-control"/> 
								 	<?php if ($error_fbsecretapi) { ?>
								  		<div class="text-danger"><?php echo $error_fbsecretapi; ?></div>
								  	<?php } ?>
							 	</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-fbstatus"><?php echo $entry_status; ?></label>
								<div class="col-sm-10">
								  	<select name="so_sociallogin[so_sociallogin_fbstatus]" id="input-fbstatus" class="form-control">
										<?php if ($fbstatus) { ?>
											<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
											<option value="0"><?php echo $text_disabled; ?></option>
										<?php } else { ?>
											<option value="1"><?php echo $text_enabled; ?></option>
											<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
										<?php } ?>
								  	</select>
								</div>
						  	</div>
						</div>			
						<div class="tab-pane" id="tab-twitter">
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-twittertitle"><?php echo $entry_title; ?></label>
								<div class="col-sm-10">
					  				<input type="text" name="so_sociallogin[so_sociallogin_twittertitle]" value="<?php echo $twittertitle; ?>" placeholder="<?php echo $entry_title; ?>" id="input-twittertitle" class="form-control" />
								</div>
							</div>				
							<div class="form-group">
                				<label class="col-sm-2 control-label" for="input-twitimage"><?php echo $entry_image; ?></label>
                				<div class="col-sm-10">
                  					<a href="" id="thumb-twitimage" data-toggle="image" class="img-thumbnail"><img src="<?php echo $twiterthumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                  					<input type="hidden" name="so_sociallogin[so_sociallogin_twitimage]" value="<?php echo $twitimage; ?>" id="input-twitimage" />
                				</div>
							</div>
							<div class="form-group">
		        				<label class="col-sm-2 control-label" for="input-twitapikey"><?php echo $entry_twapikey; ?></label>
								<div class="col-sm-10">
									<input type="text" name="so_sociallogin[so_sociallogin_twitapikey]" id="twit-apikey" value="<?php echo $twitapikey; ?>" class="form-control"/> 
		           					<?php if ($error_twitapikey) { ?>
				  						<div class="text-danger"><?php echo $error_twitapikey; ?></div>
				  					<?php } ?>
		         				</div>
				 			</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-twitsecretapi"><?php echo $entry_twapisecret; ?></label>
					 			<div class="col-sm-10">
					 				<input type="text" name="so_sociallogin[so_sociallogin_twitsecretapi]" id="twit-apisecret" value="<?php echo $twitsecretapi; ?>" class="form-control"/> 
					   				<?php if ($error_twitsecret) { ?>
				  						<div class="text-danger"><?php echo $error_twitsecret; ?></div>
				  					<?php } ?>
					 			</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-twitstatus"><?php echo $entry_status; ?></label>
								<div class="col-sm-10">
					  				<select name="so_sociallogin[so_sociallogin_twitstatus]" id="input-twitstatus" class="form-control">
										<?php if ($twitstatus) { ?>
											<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
											<option value="0"><?php echo $text_disabled; ?></option>
										<?php } else { ?>
											<option value="1"><?php echo $text_enabled; ?></option>
											<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
										<?php } ?>
					  				</select>
								</div>
			  				</div>
						</div>			
						<div class="tab-pane" id="tab-google">
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-googletitle"><?php echo $entry_title; ?></label>
								<div class="col-sm-10">
								  	<input type="text" name="so_sociallogin[so_sociallogin_googletitle]" value="<?php echo $googletitle; ?>" placeholder="<?php echo $entry_title; ?>" id="input-googletitle" class="form-control" />
								</div>
							</div>
							<div class="form-group">
				                <label class="col-sm-2 control-label" for="input-googleimage"><?php echo $entry_image; ?></label>
				                <div class="col-sm-10">
				                  	<a href="" id="thumb-googleimage" data-toggle="image" class="img-thumbnail"><img src="<?php echo $googlethumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
				                  	<input type="hidden" name="so_sociallogin[so_sociallogin_googleimage]" value="<?php echo $googleimage; ?>" id="input-googleimage" />
				                </div>
							</div>
							<div class="form-group">
						        <label class="col-sm-2 control-label" for="input-googleapikey"><?php echo $entry_googleapikey; ?></label>								
								<div class="col-sm-10">
									<input type="text" name="so_sociallogin[so_sociallogin_googleapikey]" id="google-apikey" value="<?php echo $googleapikey; ?>" class="form-control"/>
								 	<?php if ($error_googleapikey) { ?>
								  		<div class="text-danger"><?php echo $error_googleapikey; ?></div>
								  	<?php } ?>
					        	</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-googlesecretapi"><?php echo $entry_googleapisecret; ?></label>
							 	<div class="col-sm-10">
							 		<input type="text" name="so_sociallogin[so_sociallogin_googlesecretapi]" id="google-secret" value="<?php echo $googlesecretapi; ?>" class="form-control"/>
									<?php if ($error_googlesecret) { ?>
							  			<div class="text-danger"><?php echo $error_googlesecret; ?></div>
							  		<?php } ?>
							 	</div>
							</div>			
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-googlestatus"><?php echo $entry_status; ?></label>
								<div class="col-sm-10">
								  	<select name="so_sociallogin[so_sociallogin_googlestatus]" id="input-googlestatus" class="form-control">
										<?php if ($googlestatus) { ?>
											<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
											<option value="0"><?php echo $text_disabled; ?></option>
										<?php } else { ?>
											<option value="1"><?php echo $text_enabled; ?></option>
											<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
										<?php } ?>
								  	</select>
								</div>
							</div>
						</div>			
						<div class="tab-pane" id="tab-linkedin">
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-linkedintitle"><?php echo $entry_title; ?></label>
								<div class="col-sm-10">
								  	<input type="text" name="so_sociallogin[so_sociallogin_linkedintitle]" value="<?php echo $linkedintitle; ?>" placeholder="<?php echo $entry_title; ?>" id="input-linkedintitle" class="form-control" />
								</div>
							</div>
							<div class="form-group">
				                <label class="col-sm-2 control-label" for="input-linkdinimage"><?php echo $entry_image; ?></label>
				                <div class="col-sm-10">
				                  	<a href="" id="thumb-linkdinimage" data-toggle="image" class="img-thumbnail"><img src="<?php echo $linkdinthumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
				                  	<input type="hidden" name="so_sociallogin[so_sociallogin_linkdinimage]" value="<?php echo $linkdinimage; ?>" id="input-linkdinimage" />
				                </div>
							</div> 							
							<div class="form-group">
					        	<label class="col-sm-2 control-label" for="input-linkdinapikey"><?php echo $entry_liapikey; ?></label>
								<div class="col-sm-10">
									<input type="text" name="so_sociallogin[so_sociallogin_linkdinapikey]" id="linkdin-apikey" value="<?php echo $linkdinapikey; ?>" class="form-control"/> 
					         		<?php if ($error_linkdinapikey) { ?>
							  			<div class="text-danger"><?php echo $error_linkdinapikey; ?></div>
							  		<?php } ?>							  	  
					         	</div>
							</div>						
						 	<div class="form-group">
						    	<label class="col-sm-2 control-label" for="input-linkdinsecretapi"><?php echo $entry_liapisecret; ?></label>
							 	<div class="col-sm-10">
							 		<input type="text" name="so_sociallogin[so_sociallogin_linkdinsecretapi]" id="linkdin-apisecret" value="<?php echo $linkdinsecretapi; ?>" class="form-control"/>
									<?php if ($error_linkdinsecret) { ?>
							  			<div class="text-danger"><?php echo $error_linkdinsecret; ?></div>
							  		<?php } ?>				 
							 	</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-linkstatus"><?php echo $entry_status; ?></label>
								<div class="col-sm-10">
								  	<select name="so_sociallogin[so_sociallogin_linkstatus]" id="input-linkstatus" class="form-control">
										<?php if ($linkstatus) { ?>
											<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
											<option value="0"><?php echo $text_disabled; ?></option>
										<?php } else { ?>
											<option value="1"><?php echo $text_enabled; ?></option>
											<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
										<?php } ?>
								  	</select>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="tab-introductions">
							<h1>How to set up social apps?</h1>
							<ul class="nav nav-tabs">
								<li class="active"><a href="#facebook" data-toggle="tab" aria-expanded="false"><i class="fa fa-facebook"></i> Facebook</a></li>
								<li><a href="#twitter" data-toggle="tab" aria-expanded="false"><i class="fa fa-twitter"></i> Twitter</a></li>
								<li><a href="#google" data-toggle="tab" aria-expanded="false"><i class="fa fa-google"></i> Google</a></li>
								<li><a href="#linkedin" data-toggle="tab" aria-expanded="false"><i class="fa fa-linkedin"></i> Linkedin</a></li>
							</ul>
							<div class="tab-content">
								<div id="facebook" class="tab-pane active">
                                    <div class="tab-body">
							            <ol>
							                <li>Visit facebook developers application page <a href="https://developers.facebook.com/apps" target="_blank">https://developers.facebook.com/apps</a></li>
							                <li>Sign in to facebook</li>
							                <li>Click Add a New App</li>
							                <img src="view/image/so_sociallogin/facebook/1.png" class="img-thumbnail img-responsive">
							                <li>Enter information for New App and Click Create App ID button</li>
							                <img src="view/image/so_sociallogin/facebook/2.png" class="img-thumbnail img-responsive">
							                <li>Enter Security Check and click Submit button</li>
							                <img src="view/image/so_sociallogin/facebook/3.png" class="img-thumbnail img-responsive">
							                <li>Click Settings on menu left</li>
							                <img src="view/image/so_sociallogin/facebook/4.png" class="img-thumbnail img-responsive">
							                <li>Fill in the App ID and App Secret in the Social Login settings tab for Facebook</li>
							                <img src="view/image/so_sociallogin/facebook/41.png" class="img-thumbnail img-responsive">
							                <li>Click Add Platform and select Website</li>
							                <img src="view/image/so_sociallogin/facebook/5.png" class="img-thumbnail img-responsive">
							                <li>Enter URLs of your website</li>
							                <img src="view/image/so_sociallogin/facebook/6.png" class="img-thumbnail img-responsive">
							                <li>Click App Review on menu left and change to public for App</li>
							                <img src="view/image/so_sociallogin/facebook/7.png" class="img-thumbnail img-responsive">
							            </ol>
							        </div>
							    </div>
							    <div id="twitter" class="tab-pane">
							    	<div class="tab-body">
							    		<ol>
							    			<li>Visit twitter app page <a href="https://apps.twitter.com/app/new" target="_blank">https://apps.twitter.com/app/new</a></li>
							    			<li>Create a new application by enter information in form</li>
							    			<img src="view/image/so_sociallogin/twitter/1.png" class="img-thumbnail img-responsive">
							    			<li>Click Create your Twitter application button</li>
							    			<li>Go to Key and access tokens and get consumer key and consumer secret.</li>
							    			<img src="view/image/so_sociallogin/twitter/2.png" class="img-thumbnail img-responsive">
							    			<li>Fill in the Twitter Consumer Key and Twitter Consumer Secret in the Social Login settings tab for Twitter</li>
							    			<li>Note: Your account need verified by go to <a href="https://support.twitter.com/articles/20174631" target="_blank">https://support.twitter.com/articles/20174631</a> and follow the instructions</li>
							    		</ol>
							    	</div>
							    </div>
							    <div id="google" class="tab-pane">
							    	<div class="tab-body">
							            <ol>
							                <li>Visit the Google Developers console <a href="https://console.developers.google.com" target="_blank">https://console.developers.google.com</a></li>
							                <li>Sign in by Google account</li>
							                <li>Create a new project by click API Project / Create project</li>
							                <img src="view/image/so_sociallogin/google/1.png" class="img-thumbnail img-responsive">
							                <li>Enter Project name and click CREATE button</li>
							                <img src="view/image/so_sociallogin/google/2.png" class="img-thumbnail img-responsive">
							                <li>Then on the left visit credentials and click button Add Credentials</li>
							                <img src="view/image/so_sociallogin/google/3.png" class="img-thumbnail img-responsive">
							                <li>Click Configure consent screen</li>
							                <img src="view/image/so_sociallogin/google/4.png" class="img-thumbnail img-responsive">
							                <li>Enter information and click Save button</li>
							                <img src="view/image/so_sociallogin/google/5.png" class="img-thumbnail img-responsive">
							                <li>
							                	Now you are ready to create your web app for signup. Select webapp and input the domain name and redirect url (below) <br />
							                	Authorized Javascript origins: You need enter path domain: example: http://domain.com<br />
							                	Authorized redirect URIs: You need enter path: example: http://domain.com/index.php?route=extension/module/so_sociallogin/GoogleLogin (for opencart >=2.2.x) or path http://domain.com/index.php?route=module/so_sociallogin/GoogleLogin (for opencart < 2.2.x)
							                </li>
							                <img src="view/image/so_sociallogin/google/6.png" class="img-thumbnail img-responsive">
							                <li>Please fill in the Redirect URIs with the correct url</li>
							                <li>Google+ requires the apis to be enabled. Click APIs on the left and find Social APPs Google+ APIs</li>
							                <img src="view/image/so_sociallogin/google/7.png" class="img-thumbnail img-responsive">
							                <li>Click ENABLE</li>
							                <img src="view/image/so_sociallogin/google/8.png" class="img-thumbnail img-responsive">
							                <li>Fill in the Client Id and Client Secret in the Social Login settings tab for Google+</li>
							                <img src="view/image/so_sociallogin/google/9.png" class="img-thumbnail img-responsive">
							                <li>Save and wait for several minutes for the Google api to refresh its data then test the login.</li>
							            </ol>
							        </div>
							    </div>
							    <div id="linkedin" class="tab-pane">
							    	<div class="tab-body">
							            <ol>
							    			<li>Visit Linkedin developers page at <a href="http://developer.linkedin.com/" target="_blank">http://developer.linkedin.com/</a></li>
							    			<li>Sign in by click icon on top right</li>
							    			<li>Click My Apps on menu top</li>
							    			<li>Click Create Application button and enter information</li>
							    			<img src="view/image/so_sociallogin/linkedin/1.png" class="img-thumbnail img-responsive">
							    			<li>
							    				Fill in the Client Id and Client Secret in the Social Login settings tab for Linkedin<br />
							    				Authorized Redirect URIs: Enter path: http://domain.com/index.php?route=extension/module/so_sociallogin/LinkedinLogin (for opencart >=2.2.x) or path http://domain.com/index.php?route=module/so_sociallogin/LinkedinLogin (for opencart < 2.2.x)
							    			</li>
							    			<img src="view/image/so_sociallogin/linkedin/2.png" class="img-thumbnail img-responsive">
							    		</ol>
							    	</div>
							    </div>
							    <style type="text/css">
							    	#tab-introductions ol li {
							    		margin: 10px 0;
							    	}
							    </style>
							</div>
						</div>
					</div>
				</div>
    		</form>
      	</div>
	</div>
</div>
<?php echo $footer; ?>