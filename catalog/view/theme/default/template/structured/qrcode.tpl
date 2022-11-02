	
	<style>
		#qrcodereader__camera_permission_button, #qrcodereader__camera_resume_button{
			border-color: #00a046;
			background-color: #00a046;
			color: #fff;
			font-weight: 500;
			height: 40px;
			border-radius: 5px;
			border-width: 1px;
			padding: 5px 10px;
		}
		#qrcodereader__dashboard_section_csr button{
			border-color: #00a046;
			background-color: #00a046;
			color: #fff;
			font-weight: 500;
			height: 40px;
			border-radius: 5px;
			border-width: 1px;
			padding: 5px 10px;
			margin-bottom: 3px;
		}
		#qrcodereader__dashboard_section_swaplink{
			display: none!important;
		}
		#qrcodescanner .modal-dialog{
			width: 98%;
			max-width: 800px;
			left: unset;
			top: unset;
			margin: 30px auto;
		}
		#qrcodereader__camera_selection{
			margin-bottom: 3px;
		}
		#qrcodereader-result-product-data{
			padding: 10px 4px;
		}
		#qrcodereader-result-ean{
			font-size: 16px;
		}
		#qrcodescanner .modal-title{padding: 5px;}
	</style>


	<div id="qrcodescanner" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" type="button" onclick="stopScannerAndHide();">×</button>
					<h3 class="modal-title text-center">Сканер</h3>
				</div>
				<div class="modal-body text-center">						
					<div id="qrcodereader" style="width: 100%; height:600px;"></div>
					<div id="qrcodereader-result-ean" class="text-center text-info"></div>
					<div id="qrcodereader-result-product" style="display:none;">
						<div id="qrcodereader-result-product-data" class="text-center"></div>
						<button type="button" id="qrcodereader__camera_resume_button" onclick="restartScanner();">До сканеру</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		function restartScanner(){
			$('#qrcodereader').show();

			if (window.html5QrcodeScanner.getState() === Html5QrcodeScannerState.PAUSED) {
				window.html5QrcodeScanner.resume();
			}

			$('#qrcodereader-result-ean').html('');
			$('#qrcodereader-result-product').hide();
		}

		function stopScannerAndHide(){
			if (window.html5QrcodeScanner.getState() !== Html5QrcodeScannerState.NOT_STARTED) {
				window.html5QrcodeScanner.html5Qrcode.stop();
			}
			$('#qrcodescanner').modal('hide');
		}

		function onScanSuccess(decodedText, decodedResult) {
			console.log(decodedText, decodedResult);
			if (window.html5QrcodeScanner.getState() !== Html5QrcodeScannerState.NOT_STARTED) {
				window.html5QrcodeScanner.pause(true);
				$('#qrcodereader').hide();
				$('#qrcodereader-result-product').show();
			}

			$('#qrcodereader-result-ean').text(decodedText);

			$.ajax({
				url: 'index.php?route=product/search/sku&ean=' + decodedText.trim(),
				type: 'get',
				dataType: 'json',
				beforeSend: function(){
					$('#qrcodereader-result-product-data').removeClass('text-info text-danger');
					$('#qrcodereader-result-product-data').html("<i class='fa fa-spinner fa-spin'></i>");
				},
				success: function(json){

					console.log(json);

					if (json.status == true){
						$('#qrcodereader-result-product-data').removeClass('text-error').addClass('text-info');

						var html = '';
						html += '<img src="' + json.image + '" /><br />';
						html += '<a target="_blank" href="' + json.href + '">' + json.name + ' <i class="fa fa-external-link"></i></a><br />';
						if (json.quantity){
							html += '<span class="text-success"><b>' + json.price + '</b></span><br />';
							html += '<table class="table table-bordered table-responsive table-stocks">';
							for(var k in json.stocks) {
								var loc = json.stocks[k];
								html += '<tr>';
								html += '	<td>';
   								if (parseInt(loc.quantity) > 0){
   									html += '<i class="fa fa-check text-success"></i>';
   								} else {
   									html += '<i class="fa fa-times text-danger"></i>';
   								}
   								html += '	</td>';
   								html += '	<td><small>' + loc.address + '</small></td>';
   								html += '	<td><small>' + loc.quantity + ' шт. </small></td>';
   								html += '</tr>';
							}
							html += '</table>';
						} else {
							html += '<span class="text-danger">немає у наявності</span>';
						}

					} else {
						$('#qrcodereader-result-product-data').removeClass('text-info').addClass('text-danger');
						var html = json.name;
					}

					$('#qrcodereader-result-product-data').html(html);
				},
				error: function(json){
					$('#qrcodereader-result-product-data').removeClass('text-info').addClass('text-danger');
					$('#qrcodereader-result-product-data').text('Помилка при пошуку');
				}
			});


			let scanType = "camera";
			if (html5QrcodeScanner.getState() === Html5QrcodeScannerState.NOT_STARTED) {
				scanType = "file";
			}		
		}

		function onScanFailure(error) {
			//console.warn(`Code scan error = ${error}`);
		}

		function initScanner(){
			var qrboxFunction = function(viewfinderWidth, viewfinderHeight) {        
				var minEdgeSizeThreshold = 250;
				var edgeSizePercentage = 0.8;

				var minEdgeSize = (viewfinderWidth > viewfinderHeight) ?
				viewfinderHeight : viewfinderWidth;
				var qrboxEdgeSize = Math.floor(minEdgeSize * edgeSizePercentage);
				if (qrboxEdgeSize < minEdgeSizeThreshold) {
					if (minEdgeSize < minEdgeSizeThreshold) {
						return {width: minEdgeSize, height: minEdgeSize};
					} else {
						return {
							width: minEdgeSizeThreshold,
							height: minEdgeSizeThreshold
						};
					}
				}
				return {width: qrboxEdgeSize, height: qrboxEdgeSize};
			}



			window.html5QrcodeScanner = new Html5QrcodeScanner(
				"qrcodereader",
				{ fps: 10, 
					qrbox: qrboxFunction, 
					experimentalFeatures: {
						useBarCodeDetectorIfSupported: true,
						rememberLastUsedCamera: true,
						aspectRatio: 1.7777778,
						showTorchButtonIfSupported: true
					}
				},
				false);

			window.html5QrcodeScanner.render(onScanSuccess, onScanFailure);			
			$('#qrcodescanner').modal('show');
		}
	</script>