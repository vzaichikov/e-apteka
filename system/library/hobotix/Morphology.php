<?php
	
	
	namespace hobotix;
	
	
	class Morphology{
		
		public function orfFilter($string){
			/*Кол-во попадений не правильных слов в строке чтобы считать что строка написана в не правильной раскладке*/
			$countErrorWords = 0;
		
			/*счетчик не правильных слов*/
			$countError = 0;
			
			/*При попадении таких слов, считать что выбрана не правильная раскладка клавиатуры*/
			$errorWords = array('b', 'd', 'yt', 'jy', 'yf', 'z', 'xnj', 'c', 'cj', 'njn', ',snm', 'f', 'dtcm', "'nj", 'rfr', 'jyf', 'gj', 'yj', 'jyb', 'r', 'e', 'ns', 'bp', 'pf', 'ds', 'nfr', ';t', 'jn', 'crfpfnm',"'njn", 'rjnjhsq', 'vjxm', 'xtkjdtr', 'j', 'jlby', 'tot', ',s', 'nfrjq', 'njkmrj', 'ct,z', 'cdjt', 'rfrjq', 'rjulf', 'e;t', 'lkz', 'djn', 'rnj', 'lf', 'ujdjhbnm', 'ujl', 'pyfnm', 'vjq', 'lj', 'bkb', 'tckb', 'dhtvz', 'herf', 'ytn', 'cfvsq', 'yb', 'cnfnm', ',jkmijq', 'lf;t', 'lheujq', 'yfi', 'cdjq', 'ye', 'gjl', 'ult', 'ltkj', 'tcnm', 'cfv', 'hfp', 'xnj,s', 'ldf', 'nfv', 'xtv', 'ukfp', ';bpym', 'gthdsq', 'ltym', 'nenf', 'ybxnj', 'gjnjv', 'jxtym', '[jntnm', 'kb', 'ghb', 'ujkjdf', 'yflj', ',tp', 'dbltnm', 'blnb', 'ntgthm', 'nj;t', 'cnjznm', 'lheu', 'ljv', 'ctqxfc', 'vj;yj', 'gjckt', 'ckjdj', 'pltcm', 'levfnm', 'vtcnj', 'cghjcbnm', 'xthtp', 'kbwj', 'njulf', 'dtlm', '[jhjibq', 'rf;lsq', 'yjdsq', ';bnm', 'ljk;ys', 'cvjnhtnm', 'gjxtve', 'gjnjve', 'cnjhjyf', 'ghjcnj', 'yjuf', 'cbltnm', 'gjyznm', 'bvtnm', 'rjytxysq', 'ltkfnm', 'dlheu', 'yfl', 'dpznm', 'ybrnj', 'cltkfnm', 'ldthm', 'gthtl', 'ye;ysq', 'gjybvfnm', 'rfpfnmcz', 'hf,jnf', 'nhb', 'dfi', 'e;', 'ptvkz', 'rjytw', 'ytcrjkmrj', 'xfc', 'ujkjc', 'ujhjl', 'gjcktlybq', 'gjrf', '[jhjij', 'ghbdtn', 'pljhjdj', 'pljhjdf', 'ntcn', 'yjdjq', 'jr', 'tuj', 'rjt', 'kb,j', 'xnjkb', 'ndj.', 'ndjz', 'nen', 'zcyj', 'gjyznyj', 'x`', 'xt');
			
			/*Символы которые нужно исключить из строки*/
			$delChar = array('!' => '', '&' => '', '?' => '', '/' => '');
			
			/*Исключения*/
			$expectWord = array('.ьу'=>'/me');
			
			/*Символы для замены на русские*/
			$arrReplace = array('q'=>'й', 'w'=>'ц', 'e'=>'у', 'r'=>'к', 't'=>'е', 'y'=>'н', 'u'=>'г', 'i'=>'ш', 'o'=>'щ', 'p'=>'з', '['=>'х', ']'=>'ъ', 'a'=>'ф', 's'=>'ы', 'd'=>'в', 'f'=>'а', 'g'=>'п', 'h'=>'р', 'j'=>'о', 'k'=>'л', 'l'=>'д', ';'=>'ж', "'"=>'э', 'z'=>'я', 'x'=>'ч', 'c'=>'с', 'v'=>'м', 'b'=>'и', 'n'=>'т', 'm'=>'ь', ','=>'б', '.'=>'ю', '/'=>'.', '`'=>'ё', 'Q'=>'Й', 'W'=>'Ц', 'E'=>'У', 'R'=>'К', 'T'=>'Е', 'Y'=>'Н', 'U'=>'Г', 'I'=>'Ш', 'O'=>'Щ', 'P'=>'З', '{'=>'Х', '}'=>'Ъ', 'A'=>'Ф', 'S'=>'Ы', 'D'=>'В', 'F'=>'А', 'G'=>'П', 'H'=>'Р', 'J'=>'О', 'K'=>'Л', 'L'=>'Д', ':'=>'Ж', '"'=>'Э', '|'=>'/', 'Z'=>'Я', 'X'=>'Ч', 'C'=>'С', 'V'=>'М', 'B'=>'И', 'N'=>'Т', 'M'=>'Ь', '<'=>'Б', '>'=>'Ю', '?'=>',', '~'=>'Ё', '@'=>'"', '#'=>'№', '$'=>';', '^'=>':', '&'=>'?');
			
			/*Меняем ключ со значением в массиве $arrReplace*/
			$arrReplace2 = array_flip($arrReplace);
			/*Удаляем некоторые символы*/
			unset($arrReplace2['.']);
			unset($arrReplace2[',']);
			unset($arrReplace2[';']);
			unset($arrReplace2['"']);
			unset($arrReplace2['?']);
			unset($arrReplace2['/']);
			
			/*И соединяем массивы в один*/
			$arrReplace = array_merge($arrReplace, $arrReplace2);
			
			/*Переводим в нижний регистр, удаляем пробелы с начала и конца, разбиваем предложение на слова*/
			$string2 = strtr(trim(strtolower($string)), $delChar);
			$arrString = explode(" ", $string2);
			
			/*Проверям есть ли неправильно написаные слова и считаем их кол-во*/
			foreach ($arrString as $val){
				if (array_search($val, $errorWords)){
					$countError++;
				}
			}
			
			return ($countError >= $countErrorWords)?strtr(strtr($string ,$arrReplace),$expectWord):$string;
		}
		
		
	}	