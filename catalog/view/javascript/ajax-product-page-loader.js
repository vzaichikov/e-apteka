var pagination_exist = true; // оставить пагинацию и добавить кнопку
var button_more = true; // наличие кнопки "загрузить ещё"
var top_offset = 100; // высота отступа от верха окна, запускающего arrow_top
var window_height = 0; // высота окна
var product_block_offset = 0; // отступ от верха окна блока, содержащего контейнеры

var product_block = ''; // определяет div, содержащий товары
var pages_count = 0; // счетчик массива ссылок пагинации
var pages = []; // массив для ссылок пагинации
var waiting = false;



function getNextProductPage(pages, pages_count) {
	var $button = $('.load_more');

	console.log('getNextProductPage');
	if (waiting) return;
    if (pages_count >= pages.length) return;
	waiting = true;
	//$(product_block).parent().after('<div id="ajax_loader"><img src="/image/ajax-loader-horizontal.gif" /></div>');
	

	$.ajax({
		url:pages[pages_count], 
		type:"GET", 
		data:'',
		beforeSend : function(){
			$button.css({ "opacity": "0.5" }).addClass('loader');

			$button.html("<img src='/catalog/view/theme/default/img/load_more_white.svg'>");
		},
		complete: function(){	
			$button.text('Показать больше');
			$button.css({ "opacity": "1" }).removeClass('loader');
		},
		success:function (data) {
			$data = $(data);
			$('#ajax_loader').remove();
			if ($data) {
				
				console.log(product_block);
				
			    if ($('.product-category-list--list').length > 0) {
        			
					$data.find('.product-category-list').addClass('product-category-list--list');
				}
				
				if ($data.find('.product-category-list').length > 0)    {
				
					$(product_block).parent().append($data.find('.product-category-list').parent().html());
					if (product_block == '.product-grid') {$('#grid-view').trigger('click')};
				} else {
					$(product_block).parent().append($data.find('.product-grid').parent().html());
					if (product_block == '.product-category-list') {$('#list-view').trigger('click')};
				}
				if (pagination_exist) {
					$('.pagination').html($data.find('.pagination'));
				}
			}
			waiting = false;
		}
	});
	
	if (pages_count+1 >= pages.length) {$('.load_more').hide();};
}

function scroll_to_top() {
    $('html, body').animate({
		scrollTop: 0
	}, 300, function() {
		$('.arrow_top').remove();
	});  
}

function getProductBlock() {
	if ($('.product-category-list').length > 0) {
        product_block = '.product-category-list';
    } else {
        product_block = '.product-grid';
    }
    return product_block;
}

$(document).ready(function(){
	
    window_height = $(window).height();
    product_block = getProductBlock();
	var button_more_block = $('#load_more').html(); //
	var arrow_top = $('#arrow_top'); //
	
	
	if ($(product_block).length > 0) {
        product_block_offset = $(product_block).offset().top;
		var href = $('.pagination').find('li:last a').attr('href');
        $('.pagination').each(function(){
			if (href) {
				TotalPages = href.substring(href.indexOf("page=")+5);
				First_index = $(this).find('li.active span').html();
				i = parseInt(First_index) + 1;
				while (i <= TotalPages) {
					pages.push(href.substring(0,href.indexOf("page=")+5) + i);
					i++;
				}
			}		
        });	
		
		$(window).scroll(function(){
			if (arrow_top) {
				if ($(document).scrollTop() > top_offset) {
					$('#arrow_top').show();
				} else {
					$('#arrow_top').hide();
				} 
			}
		});
		
		
		
		if (button_more && href) {
			$('.pagination').parent().parent().before(button_more_block);
			if (!pagination_exist) {
				$('.pagination').parent().parent().remove();
			} else {
				$('.pagination').parent().parent().find('.col-sm-6.text-right').remove();
			}
			$('.load_more').click( function(event) {
				event.preventDefault();
				getNextProductPage(pages, pages_count);
				pages_count++;
			});
		} else if (href) { 
			$('.pagination').parent().parent().hide();
			$(window).scroll(function(){
				product_block = getProductBlock();
				product_block_height = $(product_block).parent().height();
				if (pages.length > 0) {
					if((product_block_offset+product_block_height-window_height)<($(this).scrollTop())){
						getNextProductPage(pages, pages_count);
						pages_count++;
					}
				}
			});
		}
    }
	
});