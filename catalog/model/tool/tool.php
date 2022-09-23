<?php
class ModelToolTool extends Model {
	public function clear_tags($str) {
		
		//return $str;
		
		$find = array('<a ','</a>','<tbody','</tbody','<img','<iframe','</iframe','<ol','</ol','<strong','</strong','<td','</td','<tr','</tr','<table','</table', '<p', '<ul', '<li', '<br', '<h1', '<h2', '<h3', '<h4', '</p', '</ul', '</li', '</h1', '</h2', '</h3', '</h4', '<P', '<UL', '<LI', '<BR', '<H1', '<H2', '<H3', '<H4', '</P', '</UL', '</LI', '</H1', '</H2', '</H3', '</H4' );
		$replace = array('!#a ','!#/a#!','!#tbody#!<tbody','!#/tbody#!</tbody','!#img','!#iframe', '!#/iframe#!','!#ol#!<ol','!#/ol#!</ol','!#strong#!<strong','!#/strong#!</strong','!#td#!<td','!#/td#!</td','!#tr#!<tr','!#/tr#!</tr','!#table#!<table','!#/table#!</table', '!#p#!<p', '!#ul#!<ul', '!#li#!<li', '!#br#!<br', '!#h1#!<h1', '!#h2#!<h2', '!#h3#!<h3', '!#h4#!<h4', '!#/p#!</p', '!#/ul#!</ul', '!#/li#!</li', '!#/h1#!</h1', '!#/h2#!</h2', '!#/h3#!</h3', '!#/h4#!</h4','!#p#!<p', '!#ul#!<ul', '!#li#!<li', '!#br#!<br', '!#h1#!<h1', '!#h2#!<h2', '!#h3#!<h3', '!#h4#!<h4', '!#/p#!</p', '!#/ul#!</ul', '!#/li#!</li', '!#/h1#!</h1', '!#/h2#!</h2', '!#/h3#!</h3', '!#/h4#!</h4', );
		$str = str_replace($find, $replace, $str);
	
		$find = array('<1','<2','<3','<4','<5','<6','<7','<8','<9','<0');
		$replace = array('< 1','< 2','< 3','< 4','< 5','< 6','< 7','< 8','< 9','< 0');
		$str = str_replace($find, $replace, $str);
	
		
		foreach($find as $index => $row){
			$find[$index] = strtoupper($row);		
		}
		
		$str = str_replace($find, $replace, $str);
		
		$str = strip_tags($str);
		
		$str = str_replace(array('!#', '#!'), array('<','>'), $str);
		$str = str_replace('!#a ', '<a ', $str);
				
		$find = array('@h2_center@','@/h2_center@','@p_center@','@/p_center@' );
		$replace = array('<h2 style="text-align: center;">', '</h2>','<p style="text-align: center;">','</p>' );
		$str = str_replace($find, $replace, $str);
	
		return $str;
	}
	
	public function clear_tags2($str) {
				
		$find = array('@h2_center@','@/h2_center@','@p_center@','@/p_center@' );
		$replace = array('<h2 style="text-align: center;">', '</h2>','<p style="text-align: center;">','</p>' );
		$str = str_replace($find, $replace, $str);
	
		return $str;
	}
}
