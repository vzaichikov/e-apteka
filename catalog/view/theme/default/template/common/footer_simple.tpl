</div>  <!-- /.site__content -->
<footer class="site__footer footer">
	
	<div class="container">
		<div class="row">
			<div class="col-xlg-10 col-lg-12 col-xlg-offset-1 smlkuvannia-image">
				<span><i>Самолікування</i> може бути шкідливим</span>
				<p>для вашого <i>здоров'я</i></p>					
			</div>
		</div>
	</div>
	
	<div class="hr"></div>

</div>

<div class="footer__bottom">
	<div class="container">
		<div class="row">
			<div class="col-xlg-5 col-lg-6 col-xlg-offset-1"><?php echo $text_1; ?></div>
			<div class="col-xlg-5 col-lg-6 footer__copy"><?php echo $text_2; ?></div>
		</div>
	</div>
</div>

<div class="modal-msg">
	<div class="modal-msg__close">
		<svg class="modal-msg__close-icon">
			<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#close"></use>
		</svg>
	</div>
	<div class="modal-msg__text"></div>
</div>

</footer>  <!-- /.site__footer -->
</div>  <!-- /.site -->
<div class="main-overlay-popup"></div>
<a id="simple_login_modal" href="javascript:void(0)" class="do-popup-element" data-target="loginModal" style="display:none">модалка</a>



<script>
	function showModalMsg(msg, autoClose = true){
		$('.modal-msg__text').html(msg);
		$('.modal-msg').show(300);
		
		if ( autoClose ) {
			setTimeout(function(){
				$('.modal-msg').hide(300);
			}, 3000);
		}
	}
	
	$('.modal-msg__close').on('click', function(){
		$('.modal-msg').hide(300);		
	});
	
	$('.alert__close').on('click', function(){
		$(this).closest('.alert').remove();
	});
	
	$('.js-universalform').on('submit', function(e) {
		e.preventDefault();
		
		var form = $(this);
		
		$.ajax({
			url: '/index.php?route=account/universalform',
			type: 'post',
			data: $(this).serialize(),
			dataType: 'json',
			beforeSend: function() {},
			complete: function() {},
			success: function(json) {
				if(json['success']){
					form[0].reset();
					showModalMsg('<div class="alert-success">' + json['success'] + '</div>');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	});
	
	
	
	// $('#search input').bind('input', function(){
	// 	if($(this).val().length >= 1){
	// 		$('#search .clear-search').show();
	// 		} else {
	// 		$('#search .clear-search').hide();
	// 	}
	// });
	
	// if($('#search input').val().length >= 1){
	// 	$('#search .clear-search').show();
	// 	} else {
	// 	$('#search .clear-search').hide();
	// }
	
	// $('#search .clear-search').on('click', function(event) {
	// 	$('#search > input').val('');
	// 	$('#search.dropdown-menu').css('display','none');
	// 	$(this).hide();
	// });
	function initPaswordEye(){
		$('input[type=password]').after('<span class="password-toggle" onclick="passwordToggle($(this));"><i class="fa fa-eye"></i></span>');
	}
	
	function passwordToggle(elem){
		let passwdInput = elem.prev('input');
		let eye = elem.children('i');
		
		if (passwdInput.attr('type') === "password") {
			passwdInput.attr('type', 'text');
			eye.removeClass('fa-eye, fa-eye-slash').addClass('fa-eye-slash');
			} else {
			passwdInput.attr('type', 'password');
			eye.removeClass('fa-eye, fa-eye-slash').addClass('fa-eye');
		}
	}
	
	$(document).ready(function() {
		initPaswordEye();
	});


	
</script>



<?php if (!$is_mobile) { ?>
	<script>
		(function(w,d,u){
			var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/60000|0);
			var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
		})(window,document,'https://cdn.bitrix24.ua/b16692179/crm/site_button/loader_2_pd2hv8.js');
	</script>
<?php } ?>

<style>
	
	.imcallask-btn-mini .imcallask-btn-mini-phone.active:before{
	background-image: url("image/error.png");
	color:white ;
	}
	a.imcallask-btn-mini.hidden-xs {
	/*display: block!important;*/
	display: none;
	}
	.footer__bottom{
		padding-top: 20px;
	}	
	.footer__bottom_custom .fa{
	font-size: 45px;
	}
	.footer__bottom_custom{
	position: fixed;
	bottom: 140px;
	right: 65px;
	cursor: pointer;
	z-index: 99999;
	}
	.footer__bottom_custom.active{
	display: block;
	}
	.footer__bottom_custom.disactive{
	display: none;
	}
	
	.custom_call{
	cursor: pointer;
	color: #fcfcff;
	background-color: #6fbddbbf;
	border-radius: 50px;
	width: 50px;
	height: 50px;
	padding: 3px;
	margin: 5px;
	text-align: center;
	}
	.smlkuvannia-image{
	text-align: center;
	}
	.smlkuvannia-image span{
	text-transform: uppercase;
	color: #a2a2a2;
	width: 100%;
	text-align: center;
	font-size: 46px;
	letter-spacing: 8px;
	}
	.smlkuvannia-image i{
	font-style: normal;
	}
	.smlkuvannia-image p{
	text-transform: uppercase;
	color: #a2a2a2;
	font-size: 94px;
	letter-spacing: 6px;
	}
	@media screen and (max-width: 1500px){
	.smlkuvannia-image span {
	font-size: 38px;
	letter-spacing: 7px;
	}
	.smlkuvannia-image p {
	font-size: 76px;
	letter-spacing: 7px;
	}
	
	}
	@media screen and (max-width: 1200px){
	.smlkuvannia-image span {
	font-size: 35px;
	letter-spacing: 3px;
	}
	.smlkuvannia-image p {
	font-size: 60px;
	letter-spacing: 7px;
	}
	}
	@media screen and (max-width: 1000px){
	.smlkuvannia-image span {
	font-size: 26px;
	letter-spacing: 3px;
	}
	.smlkuvannia-image p {
	font-size: 43px;
	letter-spacing: 7px;
	}
	}
	@media screen and (max-width: 767px){
	.smlkuvannia-image span {
	font-size: 20px;
	letter-spacing: 4px;
	}
	.smlkuvannia-image p {
	font-size: 30px;
	letter-spacing: 10px;
	}
	}
	@media screen and (max-width: 650px){
	.smlkuvannia-image span {
	font-size: 15px;
	letter-spacing: 3px;
	}
	.smlkuvannia-image p {
	font-size: 23px;
	letter-spacing: 8px;
	}
	}
	@media screen and (max-width: 500px){
	.smlkuvannia-image span {
	font-size: 20px;
	letter-spacing: 4px;
	margin-bottom: 6px;
	display: block;
	}
	.smlkuvannia-image span i {
	display: block;
	font-size: 33px;
	}
	.smlkuvannia-image p {
	font-size: 38px;
	letter-spacing: 8px;
	line-height: 1.1;
	}
	.smlkuvannia-image p i {
	display: block;			
	font-size: 52px;
	
	}
	}
	@media screen and (max-width: 400px){
	.smlkuvannia-image span {
	font-size: 15px;
	}
	.smlkuvannia-image span i {
	display: block;
	font-size: 24px;
	}
	.smlkuvannia-image p {
	font-size: 27px;
	}
	.smlkuvannia-image p i {
	display: block;			
	font-size: 38px;
	
	}
	}
</style>

<script>
    function bad_visionHeaderSimple(e, t) {
        function n(e, t, n, i) {
                var r = parseInt(a("vision_size")) + t;
                n <= r && r <= i ? ($(".font-size-btns div").removeClass("disabled"), 
                    s.each(function () {
                        var e = $(this);
                        e.css("font-size", parseInt(e.css("font-size")) + t)
                }), 
                    o("vision_size", parseInt(a("vision_size")) + t),
                    parseInt(a("vision_size")) != n && parseInt(a("vision_size")) != i || e.addClass("disabled")) : e.addClass("disabled")
        }
        function o(e, t, n) {
                var i = (n = n || {}).expires;
                if ("number" == typeof i && i) {
                        var r = new Date;
                        r.setTime(r.getTime() + 1e3 * i),
                        i = n.expires = r
                }
                i && i.toUTCString && (n.expires = i.toUTCString());
                var o = e + "=" + (t = encodeURIComponent(t));
                for (var a in n) {
                        o += "; " + a;
                        var s = n[a];
                        !0 !== s && (o += "=" + s)
                }
                document.cookie = o
        }
        function a(e) {
                var t = document.cookie.match(new RegExp("(?:^|; )" + e.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, "\\$1") + "=([^;]*)"));
                return t ? decodeURIComponent(t[1]) : undefined
        }
        var s = $("p, span, a, h5, li");
        "true" == a("vision") ? ($("body, html").addClass("vision"), 
                s.each(function () {
                var e = $(this);
                $(".logo__img.img-responsive").attr("src","/catalog/view/theme/default/img/logo_blue.png")
                e.css("font-size", parseInt(e.css("font-size")) + parseInt(a("vision_size")))
        }), 
        $("#changeVisionHeader_1").attr("title","Стандартна версія")) : (o("vision_size", 0), 
        $("#changeVisionHeader_1").html(e)),
        -2 == parseInt(a("vision_size")) && $("#fontIncHeader").addClass("disabled"),
        3 == parseInt(a("vision_size")) && $("#fontDecHeader").addClass("disabled"),
        $("#changeVisionHeader_1").click(function () {
                "true" == a("vision") ? (o("vision", !1), 
                    $(".logo__img.img-responsive").attr("src","/catalog/view/theme/default/img/logo_blue.png"),
                    $("#changeVisionHeader").html(e), 
                    $("#changeVisionHeader").attr("title","Версія для людей з порушеннями зору"),
                    $("body, html").removeClass("vision")) : (o("vision", !0), 
                    $("#changeVisionHeader").text(t), 
                    $("body, html").addClass("vision"),
                    $("#changeVisionHeader").attr("title","Стандартна версія"),
                    $(".logo__img.img-responsive").attr("src","/catalog/view/theme/default/img/logo_blue.png")
                    )
        }),
        $("#fontIncHeader_1").click(function () {
                n($(this), -1, -2, 3)
        }),
        $("#fontDecHeader_1").click(function () {
                n($(this), 1, -2, 3)
        })
    }
    bad_visionHeaderSimple();
</script>
</body></html>