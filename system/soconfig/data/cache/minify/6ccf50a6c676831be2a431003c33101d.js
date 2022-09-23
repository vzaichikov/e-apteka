
$(document).ready(function(){url=window.location.href;params=getParams(url);if(params){var values=Object.keys(params);$.each(values,function(key,value){addValue=params[value];switch(value){case'scheme':$.cookie('customColorScheme',addValue);if(window.localStorage){if(!localStorage.getItem('firstLoad')){localStorage['firstLoad']=true;window.location.reload();}
else
localStorage.removeItem('firstLoad');}
break;case'layoutbox':changeLayoutBox(addValue);break;case'pattern':changePattern(addValue);}});}});function getParams(u){var theURL=u;var params={};var splitURL=theURL.split('?');if(splitURL.length>1){var splitVars=splitURL[1].split('&');for(var i=0;i<splitVars.length;i++){splitPair=splitVars[i].split('=');params[splitPair[0]]=splitPair[1];}
return params;}
return false;}
function changeLayoutBox($mode_class){if($mode_class=='full')$('body').addClass('no-bgbody');else $('body').removeClass('no-bgbody');$('#wrapper').stripClass('wrapper-').addClass('wrapper-'+$mode_class);$.cookie('layoutbox',$mode_class);}
function changePattern($mode_class){$('body').stripClass('pattern').addClass('pattern-'+$mode_class);$(".group-pattern").find('> .img-pattern').removeClass('selected');$(".group-pattern").find("[data-pattern='"+$mode_class+"']").addClass('selected');$.cookie('bgPattern',$mode_class);}
$.fn.stripClass=function(partialMatch,endOrBegin){var x=new RegExp((!endOrBegin?"\\b":"\\S+")+partialMatch+"\\S*",'g');this.attr('class',function(i,c){if(!c)return;return c.replace(x,'').trim();});return this;}