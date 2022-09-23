
function getURLVar(key){var value=[];var query=String(document.location).split('?');if(query[1]){var part=query[1].split('&');for(i=0;i<part.length;i++){var data=part[i].split('=');if(data[0]&&data[1]){value[data[0]]=data[1];}}
if(value[key]){return value[key];}else{return'';}}}
$(document).ready(function(){$('.text-danger').each(function(){var element=$(this).parent().parent();if(element.hasClass('form-group')){element.addClass('has-error');}});$('#form-currency .currency-select').on('click',function(e){e.preventDefault();$('#form-currency input[name=\'code\']').val($(this).attr('name'));$('#form-currency').submit();});$('#form-language .language-select').on('click',function(e){e.preventDefault();$('#form-language input[name=\'code\']').val($(this).attr('name'));$('#form-language').submit();});$('#search input[name=\'search\']').parent().find('button').on('click',function(){var url=$('base').attr('href')+'index.php?route=product/search';var value=$('header #search input[name=\'search\']').val();if(value){url+='&search='+encodeURIComponent(value);}
location=url;});$('#search input[name=\'search\']').on('keydown',function(e){if(e.keyCode==13){$('header #search input[name=\'search\']').parent().find('button').trigger('click');}});$('#menu .dropdown-menu').each(function(){var menu=$('#menu').offset();var dropdown=$(this).parent().offset();var i=(dropdown.left+$(this).outerWidth())-(menu.left+$('#menu').outerWidth());if(i>0){$(this).css('margin-left','-'+(i+5)+'px');}});$(document).on('keydown','#collapse-checkout-option input[name=\'email\'], #collapse-checkout-option input[name=\'password\']',function(e){if(e.keyCode==13){$('#collapse-checkout-option #button-login').trigger('click');}});$('[data-toggle=\'tooltip\']').tooltip({container:'body'});$(document).ajaxStop(function(){$('[data-toggle=\'tooltip\']').tooltip({container:'body'});});});var cart={'add':function(product_id,quantity){$.ajax({url:'index.php?route=extension/soconfig/cart/add',type:'post',data:'product_id='+product_id+'&quantity='+(typeof(quantity)!='undefined'?quantity:1),dataType:'json',beforeSend:function(){$('#cart > button').button('loading');},complete:function(){$('#cart > button').button('reset');},success:function(json){if(json['redirect']){location=json['redirect'];}
if(json['success']){addProductNotice(json['title'],json['thumb'],json['success'],'success');setTimeout(function(){$('#cart  .text-shopping-cart ').html(json['total']);},100);$('#cart > ul').load('index.php?route=common/cart/info ul li');}},error:function(xhr,ajaxOptions,thrownError){alert(thrownError+"\r\n"+xhr.statusText+"\r\n"+xhr.responseText);}});},'update':function(key,quantity){$.ajax({url:'index.php?route=checkout/cart/edit',type:'post',data:'key='+key+'&quantity='+(typeof(quantity)!='undefined'?quantity:1),dataType:'json',beforeSend:function(){$('#cart > button').button('loading');},complete:function(){$('#cart > button').button('reset');},success:function(json){setTimeout(function(){$('#cart  .text-shopping-cart').html(json['total']);},100);if(getURLVar('route')=='checkout/cart'||getURLVar('route')=='checkout/checkout'){location='index.php?route=checkout/cart';}else{$('#cart > ul').load('index.php?route=common/cart/info ul li');}},error:function(xhr,ajaxOptions,thrownError){alert(thrownError+"\r\n"+xhr.statusText+"\r\n"+xhr.responseText);}});},'remove':function(key){$.ajax({url:'index.php?route=extension/soconfig/cart/remove',type:'post',data:'key='+key,dataType:'json',beforeSend:function(){$('#cart > button').button('loading');},complete:function(){$('#cart > button').button('reset');},success:function(json){setTimeout(function(){$('#cart  .text-shopping-cart ').html(json['total']);},100);if(getURLVar('route')=='checkout/cart'||getURLVar('route')=='checkout/checkout'){location='index.php?route=checkout/cart';}else{$('#cart > ul').load('index.php?route=common/cart/info ul li');}},error:function(xhr,ajaxOptions,thrownError){alert(thrownError+"\r\n"+xhr.statusText+"\r\n"+xhr.responseText);}});}}
var voucher={'add':function(){},'remove':function(key){$.ajax({url:'index.php?route=checkout/cart/remove',type:'post',data:'key='+key,dataType:'json',beforeSend:function(){$('#cart > button').button('loading');},complete:function(){$('#cart > button').button('reset');},success:function(json){setTimeout(function(){$('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> '+json['total']+'</span>');},100);if(getURLVar('route')=='checkout/cart'||getURLVar('route')=='checkout/checkout'){location='index.php?route=checkout/cart';}else{$('#cart > ul').load('index.php?route=common/cart/info ul li');}},error:function(xhr,ajaxOptions,thrownError){alert(thrownError+"\r\n"+xhr.statusText+"\r\n"+xhr.responseText);}});}}
var wishlist={'add':function(product_id){$.ajax({url:'index.php?route=extension/soconfig/wishlist/add',type:'post',data:'product_id='+product_id,dataType:'json',success:function(json){if(json['redirect']){location=json['redirect'];}
if(json['success']){addProductNotice(json['title'],json['thumb'],json['success'],'success');}
if(json['info']){addProductNotice(json['title'],json['thumb'],json['info'],'warning');}
$('#wishlist-total').html(json['total']);$('#wishlist-total').attr('title',json['total']);},error:function(xhr,ajaxOptions,thrownError){alert(thrownError+"\r\n"+xhr.statusText+"\r\n"+xhr.responseText);}});}}
var compare={'add':function(product_id){$.ajax({url:'index.php?route=extension/soconfig/compare/add',type:'post',data:'product_id='+product_id,dataType:'json',success:function(json){if(json['success']){addProductNotice(json['title'],json['thumb'],json['success'],'success');$('#compare-total').html(json['total']);}},error:function(xhr,ajaxOptions,thrownError){alert(thrownError+"\r\n"+xhr.statusText+"\r\n"+xhr.responseText);}});}}
function addProductNotice(title,thumb,text,type){$.jGrowl.defaults.closer=false;var tpl=thumb+'<h3>'+text+'</h3>';$.jGrowl(tpl,{life:4000,header:title,speed:'slow',theme:type});}
$(document).delegate('.agree','click',function(e){e.preventDefault();$('#modal-agree').remove();var element=this;$.ajax({url:$(element).attr('href'),type:'get',dataType:'html',success:function(data){html='<div id="modal-agree" class="modal">';html+='  <div class="modal-dialog">';html+='    <div class="modal-content">';html+='      <div class="modal-header">';html+='        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';html+='        <h4 class="modal-title">'+$(element).text()+'</h4>';html+='      </div>';html+='      <div class="modal-body">'+data+'</div>';html+='    </div';html+='  </div>';html+='</div>';$('body').append(html);$('#modal-agree').modal('show');}});});(function($){$.fn.autocomplete=function(option){return this.each(function(){this.timer=null;this.items=new Array();$.extend(this,option);$(this).attr('autocomplete','off');$(this).on('focus',function(){this.request();});$(this).on('blur',function(){setTimeout(function(object){object.hide();},200,this);});$(this).on('keydown',function(event){switch(event.keyCode){case 27:this.hide();break;default:this.request();break;}});this.click=function(event){event.preventDefault();value=$(event.target).parent().attr('data-value');if(value&&this.items[value]){this.select(this.items[value]);}}
this.show=function(){var pos=$(this).position();$(this).siblings('ul.dropdown-menu').css({top:pos.top+$(this).outerHeight(),left:pos.left});$(this).siblings('ul.dropdown-menu').show();}
this.hide=function(){$(this).siblings('ul.dropdown-menu').hide();}
this.request=function(){clearTimeout(this.timer);this.timer=setTimeout(function(object){object.source($(object).val(),$.proxy(object.response,object));},200,this);}
this.response=function(json){html='';if(json.length){for(i=0;i<json.length;i++){this.items[json[i]['value']]=json[i];}
for(i=0;i<json.length;i++){if(!json[i]['category']){html+='<li data-value="'+json[i]['value']+'"><a href="#">'+json[i]['label']+'</a></li>';}}
var category=new Array();for(i=0;i<json.length;i++){if(json[i]['category']){if(!category[json[i]['category']]){category[json[i]['category']]=new Array();category[json[i]['category']]['name']=json[i]['category'];category[json[i]['category']]['item']=new Array();}
category[json[i]['category']]['item'].push(json[i]);}}
for(i in category){html+='<li class="dropdown-header">'+category[i]['name']+'</li>';for(j=0;j<category[i]['item'].length;j++){html+='<li data-value="'+category[i]['item'][j]['value']+'"><a href="#">&nbsp;&nbsp;&nbsp;'+category[i]['item'][j]['label']+'</a></li>';}}}
if(html){this.show();}else{this.hide();}
$(this).siblings('ul.dropdown-menu').html(html);}
$(this).after('<ul class="dropdown-menu"></ul>');$(this).siblings('ul.dropdown-menu').delegate('a','click',$.proxy(this.click,this));});}})(window.jQuery);