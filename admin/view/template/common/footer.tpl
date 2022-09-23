<footer id="footer">
	<?php echo $text_ea_version; ?>, 
<?php echo $text_version; ?></footer>
</div>

<?php if ($is_logged) { ?>
	<script type="text/javascript">
		$(document).ready(function() {				
			setInterval(function() { $.ajax({ url: document.location.href + '&nolog=1' }); }, 10000);   			
		});
	</script>
	
	<? if ($pbx_extension) { ?>
		<style>
			.click2call{padding:2px;display:inline-block;font-family: FontAwesome;font-size:20px;color:#1f4962;cursor:pointer;}
			.click2call:before{content:"\f098"}
			.fixed-header {
			position: fixed!important;
			top:0; left:0;
			width: calc(100% - 60px);
			opacity:0.8;
			}
		</style>		
		<script>
			$(document).ready(function(){											
				$(document).on('click', '.click2call', function(){
					var phone = $(this).attr('data-phone');
					swal.fire({ title: "Позвонить?", text: "На номер: "+phone, icon: "warning", showCancelButton: true,  confirmButtonColor: "#F96E64",  confirmButtonText: "Позвонить сейчас!", cancelButtonText: "Отмена",  closeOnConfirm: true }).then((result) => {
						if (result.value) {
							$.ajax({
								url : 'index.php?route=eapteka/extcall/originateCallAjax&token=<?php echo $token ?>',
								type : 'POST',
								dataType : 'html',
								data : {
									'phone' : phone
								},
								error: function(e){
									console.log(e)
								},
								success: function(e){
									swal.fire({title:'Вызов начался!', text:"Приятного общения:)", icon:"success"});
								}							
							});						
						}
					});					
				});
			});
		</script>
		<? } else { ?>
		<style>.click2call{display:none;}</style>
	<? } ?>
	
<?php } ?>

</body>
</html>
