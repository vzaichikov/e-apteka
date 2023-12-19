<?php echo $header; ?>
<style>
	.stock-table-wrapper-mobile{
		display: none;
		padding: 0 5px;
	}
	#selectAddress{
		width: 100%;
		height: 35px;
		margin-bottom: 5px;
		border: 1px solid #cdcdcd;
	    padding: 0 5px;
	}

	.popup-info-row{
		margin-bottom:15px;
	}

	i.fa-big {font-size:24px; color:#0385c1}

	@media screen and (max-width:768px){
		#stock-table-wrapper{
			display: none;
		}
		.stock-table-wrapper-mobile{
			display: block;
		}
	}
</style>
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
	<div class="col-sm-12  content-row">
		<div class="row">
			<h1 class="headline-collection cat-header"><?php echo $text_store; ?></h1>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row product-stock-map"  style="height: 800px;">
		<div class="stock-table-wrapper-mobile">
			<select id="selectAddress">
				<option>Оберіть адресу будь-ласка</option>
			</select>
		</div>
		<div id="stock-table-wrapper" class="col-md-3 col-sm-12 col-xs-12 col-no-right-padding product-stock-map__table-wrapper scrolly" style="height:100%">
			<table id="stock-table" class="table table-condensed table-bordered table-responsive product-stock-map__table">
				<?php $i=0; foreach ($locations as $location) { ?>
					<tr <?php if ($location['geocode']) { ?>class="location_has_geocode" data-i="<?php echo $i; ?>"<?php } ?>>						
						<td>							
							<img src="<?php echo $location['logo']; ?>" height="15px" width="15px"> <b class="product-stock-map__name"><?php echo $location['address']; ?></b>
							<br />
							<span class="product-stock-map__time"><i class="fa fa-clock-o <? echo $location['faclass']; ?>"></i> <i><?php echo $location['open']; ?></i></span>
						</td>
					</tr>
				<?php $i++; } ?>
			</table>
		</div>
		<div class="col-md-9 col-sm-12 col-xs-12 col-no-left-padding" style="height:100%;position: relative;">
			<div id="stock-map" style="height:100%;position: relative;"></div>
		</div>
		
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"	integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
		<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
		<script>    
			var select = document.getElementById("selectAddress"); 
			var options = Array.from(document.querySelectorAll(".location_has_geocode td")); 			
			select.innerHTML = "";
			for(var i = 0; i < options.length; i++) {
				var opt = options[i].textContent;
			    // var data = 7;
				select.innerHTML += "<option value=\"" + i + "\" data-i=\"" + i + "\" class=\"location_has_geocode\">" + opt + "</option>";
			}

			var markers = new Array();
			var windows = new Array();      
			
			function mapInitProductPage() {
				
				
				var map = new L.map('stock-map').setView([50.4652,30.5498], 12);
				L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
					zIndex : 1,
					attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
				}).addTo(map);
				
				function onMapClick(e) {
				}
				
				map.on('click', onMapClick);
				
				<?php $i=0; foreach ($locations as $location) { ?>
					
					var icon<?php echo $i; ?> = new L.Icon({
						iconUrl: '<? echo $location['icon']; ?>',
						shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
						iconSize: [40, 40],
						iconAnchor: [12, 41],
						popupAnchor: [1, -34],
						shadowSize: [41, 41]
					});
					
					
					<?php if ($location['geocode']) { ?>
						var html = '<div class="row popup-info-row">';
						html += '<div class="col-xs-2 text-center"><img src="<?php echo $location['logo']; ?>" height="100%" width="100%" /></div>';
						html += '<div class="col-xs-10"><h3><? echo $location['name']; ?></h3></div>';
						html += '</div>';
						html += '<div class="row popup-info-row">';
						html += '<div class="col-xs-2 text-center"><i class="fa fa-map-marker fa-big"></i></div>';
						html += '<div class="col-xs-10"><h4><? echo $location['address']; ?></h4><a href="<?php echo $location['gmaps_link']; ?>" target="_blank" rel="noindex nofollow">маршрут</a></div>';
						html += '</div>';
						html += '<div class="row popup-info-row">';
						html += '<div class="col-xs-2 text-center"><i class="fa fa-clock-o fa-big"></i></div>';
						html += '<div class="col-xs-10"><h4><? echo $location['open']; ?></h4></div>';
						html += '</div>';
						html += '<div class="row popup-info-row">';
						html += '<div class="col-xs-2 text-center"><i class="fa fa-mobile fa-big"></i></div>';
						html += '<div class="col-xs-10"><h4><a href="tel:<? echo $location['telephone']; ?>"><? echo $location['telephone']; ?></a></h4></div>';
						html += '</div>';
						html += '<div class="row popup-info-row">';
						html += '<div class="col-xs-2 text-center"><i class="fa fa-envelope fa-big"></i></div>';
						html += '<div class="col-xs-10"><h4><a href="tel:<? echo $location['email']; ?>"><? echo $location['email']; ?></a></h4></div>';
						html += '</div>';

						markers[<? echo $i; ?>] = L.marker([<?php echo $location['geocode'];?>], {icon:icon<?php echo $i; ?>}).addTo(map).bindPopup(html);
					<? } ?>
					<? $i++; } ?>
					
					$('tr.location_has_geocode').mouseenter(function(){
						var it = parseInt($(this).attr('data-i'));
						markers[it].openPopup();
					});

					$( "#selectAddress" ).change(function () {
						var str = "";
						$( "#selectAddress option:selected" ).each(function() {
							var it = parseInt($(this).attr('data-i'));
							markers[it].openPopup();
						});
					}).change();

				}
				
				$(document).ready(function(){
					var shown = false;				
					mapInitProductPage();
					shown = true;
				});
			</script>
	</div>
</div>


<?php echo $footer; ?>

