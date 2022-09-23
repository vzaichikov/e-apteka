<?php echo $header; ?>
<style>
	#map-canvas {
	border: 5px solid #f3f3f3;
	min-height: 700px;
	}
	#locations {
	border: 5px solid #f3f3f3;
	min-height: 700px;
	padding:5px;
	}
	.location-container{
	padding:8px;
	margin-bottom:5px;
	}
	.location-container > h4{
	font-weight:400;
	font-size:16px;
	margin-bottom:3px;
	}
</style>



<div class="container contacts">
	<ul class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
			<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
		<?php } ?>
	</ul>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA0oPhfk5ubDAHto7UPx2RlginHQ-79XTQ"></script>
<?php if ($geocode) { ?>
	<script>
		function mapInitContactPage() {
			var myLatlng = new google.maps.LatLng(<?php echo $geocode;?>);
			var markers = new Array(),
			windows = new Array();
			
			<?php if ($locations) { ?>			
				<? $i = 1; ?>
				<?php foreach ($locations as $location) { ?>
					var myLatlng<? echo $i; ?> = new google.maps.LatLng(<?php echo $location['geocode']; ?>);				
					<? $i++; ?>
				<?php } ?>
			<?php } ?>
			
			var mapOptions = {
				zoom: 11.5,
				zoomControl: true,
				scaleControl: true,
				scrollwheel: true,
				disableDoubleClickZoom: true,
				center: myLatlng
			}
			var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
			var infowindow = new google.maps.InfoWindow({
				maxWidth: 400
			});			
			
			<?php if ($locations) { ?>			
				<? $i = 1; ?>
				<? unset($location); ?>
				<?php foreach ($locations as $location) { ?>
					windows[<? echo $i; ?>] = "<div><img src='<? echo $location['image']; ?>'></div>"
					+ "<div>"
					+ "<h3><? echo $location['name']; ?></a></h3>"
					+ "<h4><? echo $location['open']; ?></h4>"			
					<? if ($location['telephone']) { ?>+ "<p></p><h5><i class='fa fa-phone'></i> <? echo $location['telephone']; ?></h5>" <? } ?>
					<? if ($location['fax']) { ?>+ "<p></p><h5><i class='fa fa-phone'></i> <? echo $location['fax']; ?></h5>" <? } ?>
					<? if ($location['information_id']) { ?>+ "<p></p><p style='text-align:right;'><a href='<? echo $location['information_href']; ?>' title='<? echo $location['name']; ?>'><? echo $text_readmore; ?></a></p>" <? } ?>
					+ "</div>";
					
					
					markers[<? echo $i; ?>] = new google.maps.Marker({
						position: myLatlng<? echo $i; ?>,
						map: map,
						title: '<?php echo $location['name']; ?>',
						icon : '<? echo $location['icon']; ?>'
					});
					<? $i++; ?>
				<?php } ?>
			<?php } ?>
			
			for (var k in markers) google.maps.event.addListener(markers[k], 'click', function(e) {
				var i = false;
				for (var k in markers)
				if (markers[k] == this) i = k;
				infowindow.setContent(windows[i]);
				infowindow.open(map, markers[i]);
			});
			
			$('div.location_has_geocode').mouseenter(function(){
				var it = parseInt($(this).attr('data-i'));
				
				infowindow.setContent(windows[it]);
				infowindow.open(map, markers[it]);
			});
		} 
		google.maps.event.addDomListener(window, 'load', mapInitContactPage);  
	</script>
	<div id="map-canvas" class="col-sm-9"></div>
	<div id="locations" class="col-sm-3">
		<? unset($location); ?>
		<? $i = 1; ?>
		<? foreach ($locations as $location) { ?>
			<div class="col-sm-12">
				<div class="row location-container <? echo $location['tdclass']; ?> <? if ($location['geocode']) { ?>location_has_geocode<? } ?>" data-i="<? echo $i; ?>">
					<h4>
						<? echo $location['name']; ?>
					</h4>			
					<span class="small"><i class="fa fa-clock-o <? echo $location['faclass']; ?>"></i> <i style="color:#555;"><? echo $location['open_text']; ?></i></span>
				</div>
			</div>
			<? $i++; ?>
		<? } ?>	
	</div>
	<?php } else { ?>
	<div id="map-canvas" class="hidden"><img src="<?php echo $image; ?>" alt="<?php echo $store; ?>" title="<?php echo $store; ?>" /></div>
<?php } ?>	

<div class="container contacts">
	<div class="main">
		
		<div class="row"><?php echo $column_left; ?>
			<?php if ($column_left && $column_right) { ?>
				<?php $class = 'col-sm-6'; ?>
				<?php } elseif ($column_left || $column_right) { ?>
				<?php $class = 'col-sm-9'; ?>
				<?php } else { ?>
				<?php $class = 'col-sm-12'; ?>
			<?php } ?>
			<div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
				
				<div class="info-contact row">
					<div class="col-sm-4 col-xs-12 info-store">
						<div class="name-store"><h3><?php echo $store; ?></h3></div>
						<?php if ($comment) { ?>
							<div class="comment">
							<?php echo $comment; ?></div>
						<?php } ?>
						<address>
							<div class="address clearfix form-group"><div class="pull-left"><i class="fa fa-home"></i></div><div class="text"><?php echo $address; ?></div></div>
							<div class="form-group"><div class="pull-left"><i class="fa fa-phone"></i></div><div class="text"><?php echo $telephone; ?></div></div>
							<?php if ($fax) { ?>
								<div class="form-group"><div class="pull-left"><i class="fa fa-fax"></i></div><div class="text"><?php echo $fax; ?></div></div>
							<?php } ?>
							<?php if ($open) { ?>
								<div class="form-group"><div class="pull-left"><i class="fa fa-clock-o"></i></div><div class="text"><?php echo $text_open; ?> <?php echo $open; ?></div>  </div>
							<?php } ?>						
						</address>
						
					</div>
					<div class="col-lg-8 col-sm-8 col-xs-12 contact-form">
						<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
							<fieldset>
							<legend><?php echo $text_contact; ?></h2></legend>
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
								<div class="col-sm-10">
									<input type="text" name="name" value="<?php echo $name; ?>" id="input-name" class="form-control" />
									<?php if ($error_name) { ?>
										<div class="text-danger"><?php echo $error_name; ?></div>
									<?php } ?>
								</div>
							</div>
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
								<div class="col-sm-10">
									<input type="text" name="email" value="<?php echo $email; ?>" id="input-email" class="form-control" />
									<?php if ($error_email) { ?>
										<div class="text-danger"><?php echo $error_email; ?></div>
									<?php } ?>
								</div>
							</div>
							<div class="form-group required">
								<label class="col-sm-2 control-label" for="input-enquiry"><?php echo $entry_enquiry; ?></label>
								<div class="col-sm-10">
									<textarea name="enquiry" rows="10" id="input-enquiry" class="form-control"><?php echo $enquiry; ?></textarea>
									<?php if ($error_enquiry) { ?>
										<div class="text-danger"><?php echo $error_enquiry; ?></div>
									<?php } ?>
								</div>
							</div>
							<?php echo $captcha; ?>
						</fieldset>
						<div class="buttons">
							<div class="pull-right">
								<button class="btn btn-primary" type="submit"><span><?php echo $button_submit; ?></span></button>
							</div>
						</div>
					</form>
				</div>
				
			</div>
		</div>
	<?php echo $content_bottom; ?></div>
<?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>
