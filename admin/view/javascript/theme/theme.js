$(document).ready(function() {
	
	$('.btn-toggle').click(function() {
		$(this).find('.btn').toggleClass('btn-success active');  
	});
	
	//======= Create Dropdown as Select =======
	
	//======= Create Cookies ======= 
	var store_id ='';
	
	$('.main_tabs_vertical li a').bind('click', function(){
		menuTabs = $(this).attr('href').replace('#', '').replace ('tab-', '');
		storeId = menuTabs.substr(menuTabs.length - 1);
		$.cookie('main_tabs_vertical',menuTabs);
		$.cookie('store_id',storeId);
		
	});
	
	main_tabs = $.cookie('main_tabs_vertical');
	if (main_tabs) changeMainTabs(main_tabs);
	
	
	
	//======= Font Setting======= 
	$(".fonts-change").each( function(){
		var $this = this;
		$(".items-font",$this).hide();  
		$(".font-"+$(".type-fonts:checked",$this).val(), this).show();
	 
		$(".type-fonts", this).change( function(){
			$(".items-font",$this).hide();
			$(".font-"+$(this).val(), $this).show();
		} );
	});
	
	
	
})

function changeMainTabs($menuItem){

	$store_tab = 'tab-store';
	$('#'+$store_tab+' .main_tabs_vertical').find('> li').removeClass('active');
	$('#'+$store_tab+' .main_tabs_vertical > li').each(function() {
		if($(this).find('a').attr('href').indexOf($menuItem)!= -1) $(this).addClass('active');
	});
	$('#'+$store_tab+' .sidebar +.tab-content').find('> .tab-pane').removeClass('active');

	$('#'+$store_tab+' .sidebar +.tab-content > .tab-pane').each(function() {
		$("#tab-" + $menuItem).addClass('active');
		
	});
}


