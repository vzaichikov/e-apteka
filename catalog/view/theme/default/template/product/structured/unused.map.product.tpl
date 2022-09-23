					

						
						<li>
							<a href="#tab-avaliable-in-drugstores" data-toggle="tab"><?php echo $text_avaliable_in_drugstores; ?>
								<!-- <svg class="product-tabs__nav-icon">
									<use xlink:href="catalog/view/theme/default/img/sprite/symbol/sprite.svg#edit"></use>
								</svg> -->
							</a>
						</li>

					<div class="tab-pane" id="tab-avaliable-in-drugstores">

						<div class="alert alert-info text-center"><i class="fa fa-info-circle"></i> Будь-ласка, перед візитом уточнюйте режим роботи аптеки за контактами, вказаними на сайті</div>

						<div class="avaliable-in-drugstores">
							<div class="col-md-12">
								<br>
								<h2 id="trigger-show-maps" class="product-stock-map__title"><?php echo $text_wherebuy; ?> <?php echo $heading_title; ?></h2>
							</div>						
							
							<div class="product__stock-map product-stock-map" <?php if (!$disable_map) { ?> style="height: 494px;"<?php } ?>>
								<style type="text/css">
									.text-danger1{color: #a94442 !important;}
								</style>
								
								<div id="stock-table-wrapper" class="col-md-4 col-sm-12 col-xs-12 col-no-right-padding product-stock-map__table-wrapper scrolly" style="height:100%">
									<table id="stock-table" class="table table-condensed table-bordered table-responsive product-stock-map__table">
										<?php $i=0; foreach ($stocks as $stock) { ?>
											<tr <?php if ($stock['geocode']) { ?>class="location_has_geocode" data-i="<?php echo $i; ?>"<?php } ?>>
												<td>
													<b class="product-stock-map__name"><?php echo $stock['address']; ?></b><br />
													<span class="product-stock-map__time"><i class="fa fa-clock-o <? echo $stock['faclass']; ?>"></i> <i><?php echo $stock['open']; ?></i></span>
												</td>

												<td style="white-space: nowrap;" class="<?php echo $stock['tdclass']; ?>">
													<b><?php echo $stock['stock']; ?> шт.</b>
												</td>

												<td style="white-space: nowrap;" class="<?php echo $stock['tdclass']; ?>">
													<b><?php echo $stock['price']; ?></b>
													<?php if ($is_preorder) { ?>
														<br /><span class="small"><?php echo mb_strtolower($text_preorder); ?></span>
													<?php } ?>
												</td>
											</tr>
										<?php $i++; } ?>
									</table>
								</div>
								
								<?php if (!$disable_map) { ?>
									
									<div class="col-md-8 col-sm-12 col-xs-12 col-no-left-padding" style="height:100%;position: relative;">
										<div id="stock-map" style="height:100%;position: relative;"></div>
									</div>
									
									
									<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" async defer crossorigin=""/>
									<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" async></script>

									<script>
										!function(t){var i=t(window);t.fn.visible=function(t,e,o){if(!(this.length<1)){var r=this.length>1?this.eq(0):this,n=r.get(0),f=i.width(),h=i.height(),o=o?o:"both",l=e===!0?n.offsetWidth*n.offsetHeight:!0;if("function"==typeof n.getBoundingClientRect){var g=n.getBoundingClientRect(),u=g.top>=0&&g.top<h,s=g.bottom>0&&g.bottom<=h,c=g.left>=0&&g.left<f,a=g.right>0&&g.right<=f,v=t?u||s:u&&s,b=t?c||a:c&&a;if("both"===o)return l&&v&&b;if("vertical"===o)return l&&v;if("horizontal"===o)return l&&b}else{var d=i.scrollTop(),p=d+h,w=i.scrollLeft(),m=w+f,y=r.offset(),z=y.top,B=z+r.height(),C=y.left,R=C+r.width(),j=t===!0?B:z,q=t===!0?z:B,H=t===!0?R:C,L=t===!0?C:R;if("both"===o)return!!l&&p>=q&&j>=d&&m>=L&&H>=w;if("vertical"===o)return!!l&&p>=q&&j>=d;if("horizontal"===o)return!!l&&m>=L&&H>=w}}}}(jQuery);
										;(function(f){"use strict";"function"===typeof define&&define.amd?define(["jquery"],f):"undefined"!==typeof module&&module.exports?module.exports=f(require("jquery")):f(jQuery)})(function($){"use strict";function n(a){return!a.nodeName||-1!==$.inArray(a.nodeName.toLowerCase(),["iframe","#document","html","body"])}function h(a){return $.isFunction(a)||$.isPlainObject(a)?a:{top:a,left:a}}var p=$.scrollTo=function(a,d,b){return $(window).scrollTo(a,d,b)};p.defaults={axis:"xy",duration:0,limit:!0};$.fn.scrollTo=function(a,d,b){"object"=== typeof d&&(b=d,d=0);"function"===typeof b&&(b={onAfter:b});"max"===a&&(a=9E9);b=$.extend({},p.defaults,b);d=d||b.duration;var u=b.queue&&1<b.axis.length;u&&(d/=2);b.offset=h(b.offset);b.over=h(b.over);return this.each(function(){function k(a){var k=$.extend({},b,{queue:!0,duration:d,complete:a&&function(){a.call(q,e,b)}});r.animate(f,k)}if(null!==a){var l=n(this),q=l?this.contentWindow||window:this,r=$(q),e=a,f={},t;switch(typeof e){case "number":case "string":if(/^([+-]=?)?\d+(\.\d+)?(px|%)?$/.test(e)){e= h(e);break}e=l?$(e):$(e,q);case "object":if(e.length===0)return;if(e.is||e.style)t=(e=$(e)).offset()}var v=$.isFunction(b.offset)&&b.offset(q,e)||b.offset;$.each(b.axis.split(""),function(a,c){var d="x"===c?"Left":"Top",m=d.toLowerCase(),g="scroll"+d,h=r[g](),n=p.max(q,c);t?(f[g]=t[m]+(l?0:h-r.offset()[m]),b.margin&&(f[g]-=parseInt(e.css("margin"+d),10)||0,f[g]-=parseInt(e.css("border"+d+"Width"),10)||0),f[g]+=v[m]||0,b.over[m]&&(f[g]+=e["x"===c?"width":"height"]()*b.over[m])):(d=e[m],f[g]=d.slice&& "%"===d.slice(-1)?parseFloat(d)/100*n:d);b.limit&&/^\d+$/.test(f[g])&&(f[g]=0>=f[g]?0:Math.min(f[g],n));!a&&1<b.axis.length&&(h===f[g]?f={}:u&&(k(b.onAfterFirst),f={}))});k(b.onAfter)}})};p.max=function(a,d){var b="x"===d?"Width":"Height",h="scroll"+b;if(!n(a))return a[h]-$(a)[b.toLowerCase()]();var b="client"+b,k=a.ownerDocument||a.document,l=k.documentElement,k=k.body;return Math.max(l[h],k[h])-Math.min(l[b],k[b])};$.Tween.propHooks.scrollLeft=$.Tween.propHooks.scrollTop={get:function(a){return $(a.elem)[a.prop]()}, set:function(a){var d=this.get(a);if(a.options.interrupt&&a._last&&a._last!==d)return $(a.elem).stop();var b=Math.round(a.now);d!==b&&($(a.elem)[a.prop](b),a._last=this.get(a))}};return p});
									</script>
									<script>
										var markers = new Array();
										var	windows = new Array();										
										var markers = new Array();
										
										function mapInitProductPage() {
											var map = new L.map('stock-map').setView([<?php echo $geocode;?>], 12);
											L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
												zIndex : 1,
												attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
											}).addTo(map);
											
											<? unset($stock); $i=0; foreach ($stocks as $stock) { ?>
												<? if ($stock['geocode']) { ?>
													var icon<?php echo $i; ?> = new L.Icon({
														iconUrl: '<? echo $stock['icon']; ?>',
														shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
														iconSize: [25, 41],
														iconAnchor: [12, 41],
														popupAnchor: [1, -34],
														shadowSize: [41, 41]
													});
													
													markers[<? echo $i; ?>] = L.marker([<?php echo $stock['geocode'];?>], {icon:icon<?php echo $i; ?>}).addTo(map).bindPopup('<h4><? echo $stock['name']; ?></a></h4><h4><? echo $stock['price']; ?></h4><h4><span style="color: rgb(255, 0, 0);"></span></h4><p></p><p>Телефон цілодобової довідки та резервування: </p><h4> <span><strong>(044) 520-03-33</strong></span></h4>');
												<? } ?>
											<? $i++; } ?>
											
											$('tr.location_has_geocode').click(function(){
												var it = parseInt($(this).attr('data-i'));
												markers[it].openPopup();
											});
										}
										
										$(document).ready(function(){
											var shown = false;
											$('.nav-pills a[href="#tab-avaliable-in-drugstores"]').on('shown.bs.tab', function(){
												if ($('#trigger-show-maps').visible() && !shown){
													mapInitProductPage();
													shown = true;
												}
											});											
										});
									</script>
									
								<?php } ?>
								
							</div>
						</div>
					</div>