<style>
	.box-price .price{
		padding-right: 7px;
	}
	.autosearch-input{
		position: relative;
	}
	.dropdown_search{
		background: #fff;
		padding: 5px;
		position: absolute;
		z-index: 2;
		margin-top: 10px;
	}
	li.srch__link{
		padding: 5px 0;
	}
	.mouseover{
		background: #dce4f2;
	}
	.mouseover a{
		color: #12336c;
		font-weight: 400;
	}
	.media-body.no-border-bottom{
		border-bottom: 0px;
	}
	.media-body.category{
		font-size:16px;
	}
	.media-body.category img{
		margin-right: 8px;
	}
	.dropdown-menu{
		color: #23a1d1;
	}
	.clear-search{
		position: absolute;
		right: 50px;
		top: 0;
		bottom: 0;
		width: 23px;
		margin: auto;
		cursor: pointer;
		background: #fff;
		display: flex;
		align-items: center;
	}
	.clear-search i{
		font-size: 23px;
		color: #359DCD;
	}

	.clear-search {
		right: 100px;
	}
	@media screen and (max-width:767px) {
		.clear-search {
			right: 80px;
		}
	}
</style>
<div id="cleversearch" class="sosearchpro-wrapper <?php echo $additional_class; ?>">
	<div id="search" class="search__inner">
		<form1 id="main-search-form" action="<?php echo $search_link; ?>">
			<input class="autosearch-input form-control" type="text" value="<?php echo $search; ?>" size="50" autocomplete="off" placeholder="<?php echo $text_search_field ;?>" name="search" id="main-search">		
			<ul class="dropdown-menu"></ul>
			<span class="clear-search" id="search-status" style="display: none;">
				<i class="fa fa-times"></i>
			</span>
			<span class="input-group-btn">
				<button class="button-search btn btn-default btn-lg" name="submit_search1" id="submit_search1"><svg height="34" width="34" class="icon button-search__icon"><use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#search"></use></svg></button>

				<script>
					$('button#submit_search1').on('click',
						function() {
							var e = $("#main-search").val();
							console.log( encodeURIComponent(e));
							if (e.length > 0){
								let srchurl = "<?php echo $search_link; ?>?search=" + encodeURIComponent(e);
								document.location = srchurl;
							}
						});
					</script>
				</span>			
			</div>	
		</form>
	</div>
	<script type="text/javascript">
		(function($) {
			$.fn.SearchAutoComplete = function(option) {
				return this.each(function() {
					this.timer = null;
					that = this;
					this.items = new Array();

					$.extend(this, option);

					$(this).attr('autocomplete', 'off');

					$(this).on('focus', function() {
						this.request();
					});

					$(this).on('blur', function(e) {
						setTimeout(function(object) {
							object.hide();
						}, 200, this);
					});

					$(this).on('keydown', function(event) {
						switch(event.keyCode) {
							case 27:
							this.hide();
							break;
							default:
							this.request();
							break;
						}
					});					

					this.show = function() {
						var pos = $(this).position();

						/*
						if (document.body.clientWidth >= parseInt($('#main-search').width()) * 2){
							$(this).siblings('ul.dropdown-menu').css({
							top: pos.top + $(this).outerHeight(),
							left: '-50%',
							width: '200%'
						});
						} else {
							$(this).siblings('ul.dropdown-menu').css({
							top: pos.top + $(this).outerHeight(),
							left: pos.left
						});							
						}
						*/

						$(this).siblings('ul.dropdown-menu').css({
							top: pos.top + $(this).outerHeight(),
							left: pos.left
						});		

						$(this).siblings('ul.dropdown-menu').show();
					}

					this.hide = function() {
						$(this).siblings('ul.dropdown-menu').hide();		
					}

					this.request = function() {
						clearTimeout(this.timer);

						this.timer = setTimeout(function(object) {
							object.source($(object).val(), $.proxy(object.response, object));
						}, 500, this);
					}

					this.response = function(json) {
						html = '';

						if (json.emptyquery){

							if (json['histories']){

								html += '<li class="media">';
								html += '	<div class="media-body no-border-bottom">';
								html += '	 		<span><b><?php echo $text_my_search_history; ?></b></span>';
								html += '	</div>';
								html += '</li>';

								$.each(json['histories'], function(i, item){
									that.items[item['value']] = item;									

									html += '<li class="media">';
									html += '	<div class="media-body">';
									html += '		<a href="' + item['href'] + '">';								
									html += '	 		<span><i class="fa fa-clock-o"></i> ' +  item['text'] + ' <span style="color:grey">('+ item['date_added'] +')</span></span>';
									html += '		</a>';									
									html += '	</div>';
									html += '	<div class="media-right" style="padding-right:10px;">';
									html += '		<i class="fa fa-times" style="cursor:pointer;" onclick="$.get(\'<?php echo $search_clear_href; ?>&id=' + item['id'] + '\', function(){ $(\'#main-search\').trigger(\'keydown\'); });"></i>';
									html += '	</div>';
									html += '</li>';
								});
							}


							if (json['populars']){

								html += '<li class="media">';
								html += '	<div class="media-body no-border-bottom">';
								html += '	 		<span><b><?php echo $text_popular_histories; ?></b></span>';
								html += '	</div>';
								html += '</li>';

								$.each(json['populars'], function(i, item){
									that.items[item['value']] = item;

									html += '<li class="media">';
									html += '	<div class="media-body">';
									html += '			<a href="' + item['href'] + '">';
									html += '	 			<span><i class="fa fa-search"></i> ' +  item['text'] + ' <span style="color:grey">('+ item['results'] +')</span></span>';
									html += '			</a>';
									html += '	</div>';
									html += '</li>';
								});
							}

						} else if (parseInt(json.total) == 0){
							
							$('form#main-search-form').attr('action', '<?php echo $search_link; ?>');						
							html += '<li class="media">';
							html += '	<div class="media-body category">';
							html += '		<span>😥 <?php echo $text_empty; ?></span>';
							html += '	</div>';
							html += '</li>';

						} else {

							if (json['s']){
								$.each(json['s'], function(i, item){
									that.items[item['value']] = item;

									html += '<li class="media">';
									html += '	<div class="media-body">';
									html += '		<a href="' + item['href'] + '">';
									html += '	 		<span><i class="fa fa-search"></i> ' +  item['name'] + '</span>';
									html += '		</a>';
									html += '	</div>';
									html += '</li>';
								});
							}

							if (json['co']){
								$.each(json['co'], function(i, item){
									that.items[item['value']] = item;

									html += '<li class="media" title="' + item['name'] + '">';					
									html += '	<div class="media-body category">';								
									html += '		<a href="' + item['href'] + '">';
									if (item['image']){
										html += '<img src="'+ item['image'] +'" width="50px" height="50px" />';
									}
									html += '<span>' + item['name'] + '</span>';
									html += '</a>';
									if (item['tip']){
										html += ' 		<br />';
										html += '		<small class="label label-success">' + item['tip'] + '</small>';
									}
									html += '	</div>';
									html += '</li>';
									html += '<li class="clearfix"></li>';
								});
							}

							if (json['c']){
								$.each(json['c'], function(i, item){
									that.items[item['value']] = item;

									html += '<li class="media" title="' + item['name'] + '">';					
									html += '	<div class="media-body category">';		
									html += '		<i class="fa fa-search"></i> ';						
									html += '		<a href="' + item['href'] + '">';
									html += '<span>' + item['name'] + '</span>';
									html += '</a>';
									if (item['tip']){
										html += ' 		<br />';
										html += '		<small class="label label-success">' + item['tip'] + '</small>';
									}
									html += '	</div>';
									html += '</li>';
									html += '<li class="clearfix"></li>';
								});
							}

							if (json['p']){
								$.each(json['p'], function(i, item){
									that.items[item['value']] = item;

									html += '<li class="media" title="' + item['name'] + '" onClick="window.location.href='+'\''+ item['href'] +'\''+'">';					

									html += '<div class="media-body">';
									html += '<a href="' + item['href'] + '"><span>' + item['name'] + '</span></a>';
									if (item['tip']){
										html += '<br />';
										html += '<span class="label label-success">' + item['tip'] + '</span>';
									}
									html += '</div>';
									if(item['price']){
										html += '	<div class="media-right"><div class="box-price">';
										if (item['special']) {
											html += '<span class="price-old" style="text-decoration:line-through;">' + item['price'] + '</span><span class="price-new">' + item['special'] + '</span>';
										} else {

											if (item['count_of_parts'] && item['count_of_parts']!=1 && item['price_of_part']){
												html += '<span class="price price-full"><i>'+ item['text_full_pack'] + '</i>'+ item['price'] +'</span>';
												html += '<span class="price price-part"><i>' + item['text_part_pack'] + '</i>'+ item['price_of_part'] +'</span>';

											} else {
												html += '<span class="price">'+item['price']+'</span>';
											}
										}							
										html += '	</div></div>';
									}
									html += '</li>';
									html += '<li class="clearfix"></li>';
								});
							}
					
							html += '<li class="search__li-btn-show-all"><a href="' + json.full_search_uri +  '"><button class="search__btn-show-all" id="submit_search2" name="submit_search2"><?php echo $search_show_all_results; ?></button></a></li>';						
						}

						if (html) {
							this.show();
						} else {
							this.hide();
						}

						$(this).siblings('ul.dropdown-menu').html(html);																			
				}
			});
}
})(window.jQuery);

$(document).ready(function() {
	var total = 0;
	var character = 0;

	$('#search input').bind('input', function(){
		if($(this).val().length >= 1){
			$('#search #clear-search').show();
		} else {
			$('#search #clear-search').hide();
		}
	});
	
	if($('#search input').val().length >= 1){
		$('#search #search-status').show();
	} else {
		$('#search #search-status').hide();
	}
	
	$('#search .clear-search').on('click', function(event) {
		$('#main-search').val('');
		$('#search.dropdown-menu').css('display','none');
		$(this).hide();
	});

	$('#cleversearch').find('input[name=\'search\']').SearchAutoComplete({
		delay: 500,
		source: function(request, response) {

			if(request.length >= character){
				$.ajax({ 
					url: '<?php echo $search_href; ?>?query='+encodeURIComponent(request),
					dataType: 'json',
					beforeSend: function(){
						$('#search #search-status').show();
						$(this).siblings('ul.dropdown-menu').html('');
						$('#search #search-status i').removeClass('fa-times fa-spinner fa-spin').addClass('fa-spinner fa-spin');
					},								
					success: function(json) {
						$('#search #search-status').show();
						$('#search #search-status i').removeClass('fa-times fa-spinner fa-spin').addClass('fa-times');
						response(json);						
					}					
				});
			}
		},
	});
});

$('#cleversearch').on('click', function(e){
	var et = e.target;
	var li = $(et).closest('.media');
	var link = li.find('a.media-left').attr('href');
	if ( link ) 
		document.location.href = link;
});

</script>		