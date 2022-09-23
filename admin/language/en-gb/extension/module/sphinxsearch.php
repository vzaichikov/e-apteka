<?php
// Heading
$_['heading_title']       = 'Sphinx Powered Search For OpenCart';

// Text
$_['text_module']         = 'Modules';
$_['text_success']        = 'Success: You have modified module sphinx search!';
$_['text_yes']			  = 'Yes';
$_['text_no']			  = 'No';
$_['text_rt_yes']		  = 'Real Time index (RT)';
$_['text_rt_no']		  = 'Regular index';
$_['text_calculating']	  = 'Please wait...';

//Tabs
$_['tab_general']		 	= 'General';
$_['tab_autocomplete']	  	= 'Autocomplete';
$_['tab_productOptions']  	= 'Products';
$_['tab_categoriesOptions'] = 'Categories'; 
$_['tab_suggestions']	  	= 'Suggestions';
$_['tab_config']		  	= 'Config file';
$_['tab_rtIndex']			= 'RT index';

//General tab
$_['entry_sphinx_status']        = 'Sphinx Search Status:';
$_['entry_sort_status']        = 'Sort status:';
$_['entry_sphinx_server']        = 'Sphinx server:';
$_['entry_sphinx_port']        = 'Sphinx port:';
$_['entry_sphinx_match_mode_title'] = 'Matching mode';
$_['entry_sphinx_sort_mode_title'] = 'Sort mode';
$_['entry_sphinx_ranking_mode_title'] = 'Ranking mode';
$_['entry_sphinx_weight_title'] = 'Sphinx weights';
$_['entry_sphinx_gen_suggestions'] = 'Generate suggestions';
$_['entry_sphinx_match_mode'] = 'Choose sphinx match mode:';
$_['entry_sphinx_sort_info'] = 'Sort mode';
$_['entry_sphinx_attr_expr_info'] = 'Attribute/Expression';
$_['entry_sphinx_ranking_mode'] = 'Choose sphinx ranking mode:';

$_['entry_sphinx_match_modes_explanation']	= '&bull; SPH_MATCH_ALL, matches all query words (default mode)<br />
		&bull; SPH_MATCH_ANY, matches any of the query words<br />
		&bull; SPH_MATCH_PHRASE, matches query as a phrase, requiring perfect match<br />
		&bull; SPH_MATCH_BOOLEAN, matches query as a boolean expression<br />
		&bull; SPH_MATCH_EXTENDED, matches query as an expression in Sphinx internal query language<br />
		&bull; SPH_MATCH_FULLSCAN, matches query, forcibly using the "full scan" mode<br />
		&bull; SPH_MATCH_EXTENDED2, matches query using the second version of the Extended matching mode<br />
		For more information, please visit: <a href="http://sphinxsearch.com/docs/archives/1.10/matching-modes.html" target="_blank">Sphinx documentation</a>
		';
$_['entry_sphinx_sort_modes_explanation']	= '&bull; SPH_SORT_RELEVANCE mode, that sorts by relevance in descending order (best matches first)<br />
		&bull; SPH_SORT_ATTR_DESC mode, that sorts by an attribute in descending order (bigger attribute values first)<br />
		&bull; SPH_SORT_ATTR_ASC mode, that sorts by an attribute in ascending order (smaller attribute values first)<br />
		&bull; SPH_SORT_TIME_SEGMENTS mode, that sorts by time segments (last hour/day/week/month) in descending order, and then by relevance in descending order<br />
		&bull; SPH_SORT_EXTENDED mode, that sorts by SQL-like combination of columns in ASC/DESC order<br />
		&bull; SPH_SORT_EXPR mode, that sorts by an arithmetic expression<br />
		For more information, please visit: <a href="http://sphinxsearch.com/docs/archives/1.10/sorting-modes.html" target="_blank">Sphinx documentation</a>
		';
$_['entry_sphinx_ranking_modes_explanation']	= '&bull; SPH_RANK_PROXIMITY_BM25, the default ranking mode that uses and combines both phrase proximity and BM25 ranking.<br />
		&bull; SPH_RANK_BM25, statistical ranking mode which uses BM25 ranking only (similar to most other full-text engines). This mode is faster but may result in worse quality on queries which contain more than 1 keyword.<br />
		&bull; SPH_RANK_NONE, no ranking mode. This mode is obviously the fastest. A weight of 1 is assigned to all matches. This is sometimes called boolean searching that just matches the documents but does not rank them.<br />
		&bull; SPH_RANK_WORDCOUNT, ranking by the keyword occurrences count. This ranker computes the per-field keyword occurrence counts, then multiplies them by field weights, and sums the resulting values.<br />
		&bull; SPH_RANK_PROXIMITY, returns raw phrase proximity value as a result. This mode is internally used to emulate SPH_MATCH_ALL queries.<br />
		&bull; SPH_RANK_MATCHANY, returns rank as it was computed in SPH_MATCH_ANY mode earlier, and is internally used to emulate SPH_MATCH_ANY queries.<br />
		&bull; SPH_RANK_FIELDMASK, returns a 32-bit mask with N-th bit corresponding to N-th fulltext field, numbering from 0. The bit will only be set when the respective field has any keyword occurrences satisfying the query.<br />
		&bull; SPH_RANK_SPH04, is generally based on the default SPH_RANK_PROXIMITY_BM25 ranker, but additionally boosts the matches when they occur in the very beginning or the very end of a text field. Thus, if a field equals the exact query, SPH04 should rank it higher than a field that contains the exact query but is not equal to it. (For instance, when the query is "Hyde Park", a document entitled "Hyde Park" should be ranked higher than a one entitled "Hyde Park, London" or "The Hyde Park Cafe".)<br />
		&bull; SPH_RANK_EXPR, lets you specify the ranking formula in run time. It exposes a number of internal text factors and lets you define how the final weight should be computed from those factors. You can find more details about its syntax and a reference available factors in a subsection below.<br />
		For more information, please visit: <a href="http://sphinxsearch.com/docs/current.html#ranking-overview" target="_blank">Sphinx documentation</a>
		';
$_['entry_sphinx_suggestion_explanation'] = 'This will generate a table with all keywords from the product\'s name column inside product_description table, build trigrams and freqs.';

//Autocomplete tab
$_['entry_sphinx_autocomplete'] = 'Sphinx autocomplete';
$_['entry_autocomplete_status'] = 'Autocomplete status: ';
$_['entry_autocomplete_selector'] = 'Enter the CSS selector of the search field you want to appear the autocomplete. By default the selector is: #search input';
$_['entry_autocomplete_limit'] = 'Maximum number of products to display';
$_['entry_autocomplete_categories'] = 'Show categories inside autocomplete dropdown list';
$_['entry_sphinx_autocomplete_cat_limit'] = 'Maximum number of categories to display';

//Products tab
$_['entry_sphinx_product_status'] = 'Show products which status is Disabled';
//$_['entry_sphinx_product_stock_status'] = 'Choose which product\'s stock statuses should be included in the results.';
$_['entry_sphinx_products_quantity'] = 'Show products which quantity min values is:';

//Categories tab
$_['entry_sphinx_category_status'] = 'Enable sphinx for categories';
$_['entry_sphinx_category_product_status'] = 'Show products which status is Disabled';
$_['entry_sphinx_categories_product_quantity'] = 'Show products which quantity min values is:'; 

//Suggestions tab
$_['text_gen_suggestions_success'] = 'The suggestion\'s table was regenerated successfully!';
$_['entry_sphinx_gen_btn'] = 'Generate suggestions';
$_['entry_sphinx_show_errors_attention'] = 'In order to see errors from Sphinx module, please set \'Display Errors\' inside System->Settings->Server to \'No\'. If you don\'t want to set it, then all errors will be logged inside error.log file.';

//Config tab
$_['entry_sphinx_config_attention'] = 'Note: If you have used Sphinx with \'RT index\' type, before start using the \'Regular index\' type, make sure you have done the following steps: </br > 1. Generate a new sphinx config file. <br /> 2. Delete all previous indexes from the \'data path\' you have specified in the \'Config file tab\'. <br /> 3. Run indexer to generate the regular indexes!';
$_['entry_sphinx_config_index_type'] = 'Choose index type:';
$_['entry_sphinx_config_path_to_indexes'] = 'Enter the path where the indexes will be stored: <br /> ex. /var/www/sphinx/data';
$_['entry_sphinx_config_path_to_log'] = 'Enter the path where the log will be stored: <br /> ex. /var/www/sphinx/log';
$_['entry_sphinx_config_generate_file'] = 'Generate sphinx config file';
$_['entry_sphinx_gen_config_btn'] = 'Generate';

//Index type tab
$_['entry_sphinx_rtIndex_attention'] = 'Note: If you have used Sphinx with \'Regular index\' type, before start using the \'RT index\' type, make sure you have done the following steps:  </br > 1. Generate a new sphinx config file. <br /> 2. Delete all previous indexes from the \'data path\' you have specified in the \'Config file tab\'! <br /> <br /> In order to see errors from Sphinx module, please set \'Display Errors\' inside System->Settings->Server to \'No\'. If you don\'t want to set it, then all errors will be logged inside error.log file.';
$_['entry_sphinx_rtIndex_gen_products_btn'] = 'Build Products RT index';
$_['entry_sphinx_rtIndex_gen_categories_btn'] = 'Build Categories RT index';


// Error
$_['error_permission']    = 'Warning: You do not have permission to modify module sphinx search!';
?>