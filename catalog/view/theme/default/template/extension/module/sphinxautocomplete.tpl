<script type="text/javascript">
	var selector = '<?php echo $sphinx_autocomple_selector; ?>';
	var catTitle = '<?php echo $label_categories; ?>';
	var prodTitle = '<?php echo $label_products; ?>';
	var viewAllTitle = '<?php echo $label_view_all; ?>';
	var noResTitle = '<?php echo $text_no_results; ?>';
	
	$(document).ready(function() {

		var timer = null;
		$('#search input').keydown(function(){
	       clearTimeout(timer); 
	       timer = setTimeout(sphinxAutocomplete, 500)
		});

	});

	$(document).mouseup(function (e) {
		
		if (!$('.sphinxsearch').is(e.target) && $('.sphinxsearch').has(e.target).length === 0) {
			$('.sphinxsearch').hide();
			$('#search input').removeClass('no-bottom-borders');
			return false;
		}
		
	});

	function sphinxAutocomplete() {

		if($(selector).val() == '') {
			$('.sphinxsearch').hide();
			$('#search input').removeClass('no-bottom-borders');
			return false;
		}

		$.ajax({
			url: '<?php echo str_replace('&amp;', '&', $autocomplete_url); ?>' + $(selector).val(),
			dataType: 'json',
			success: function(json) {

				var html = '';
				
				//Categories
				if (json.categories.length) {
					html += '<div class="categories"><span>'+catTitle+'</span>';
					var categories = json.categories;
					for (i = 0; i < categories.length; i++) {
						html += '<a href="' + categories[i]['href'] + '">';
							if(categories[i]['image'] != '') {
								html += '<img src="' + categories[i]['image'] + '" />';
							}
							html += categories[i]['name'];
							html += '<br />';
						html += '</a>';
					}
					html += '</div>';
				}
				
				//Products
				if (json.products.length) {
					if (json.categories.length) { html += '<div class="products"><span>'+prodTitle+'</span>'; }
					var products = json.products;
					for (i = 0; i < products.length; i++) {
						html += '<a href="' + products[i]['href'] + '">';
							html += '<img src="' + products[i]['image'] + '" />';
							html += products[i]['name'];
							html += '<br />';
						html += '</a>';
					}
					if (json.categories.length) {  html += '</div>'; }
					html += '<div class="sphinx-viewall"><a id="view-all" href="<?php echo $search_url ?>' + encodeURIComponent($(selector).val()) + '">'+viewAllTitle+'</a></div>';
				} else {
					html = '<div class="sphinx-viewall">'+noResTitle+'</div>';
				}

				$('ul.dropdown-menu, .sphinxsearch').remove();
				$(selector).after('<div class="sphinxsearch">'+ html +'</div>');
				$('.sphinxsearch').show();
				$('#search input').addClass('no-bottom-borders');
			}
		});
			
	}
</script>