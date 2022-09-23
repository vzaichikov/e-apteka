function translit(inputtext){
	
	var space = '-'; 
	var text = inputtext.toLowerCase();
	var transl = { 
		'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'e', 'ж': 'zh', 'з': 'z', 'и': 'i',
		'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't',
		'у': 'u', 'ф': 'f', 'х': 'h', 'ц': 'c', 'ч': 'ch', 'ш': 'sh', 'щ': 'sh', 'ъ': space, 'ы': 'y',
		'ь': space, 'э': 'e', 'ю': 'yu', 'я': 'ya', 'і' : 'i', 'ї' : 'i', 'є' : 'e', 'ґ' : 'g',
		
		' ': space, '_': space, '`': space, '~': space, '!': space, '@': space, '#': space, '$': space,
		'%': space, '^': space, '&': space, '*': space, '(': space, ')': space, '-': space, '\=': space,
		'+': space, '[': space, ']': space, '\\': space, '|': space, '/': space, '.': space, ',': space,
		'{': space, '}': space, '\'': space, '"': space, ';': space, ':': space, '?': space, '<': space,
		'>': space, '№': space					
	 }
	
    var result = '';
	var curent_sim = '';
	
    for(i=0; i < text.length; i++) {
		if(transl[text[i]] != undefined) {			
			if(curent_sim != transl[text[i]] || curent_sim != space){
				result += transl[text[i]];
				curent_sim = transl[text[i]];				
			}					
		}
        else {
			result += text[i];
			curent_sim = text[i];
		}		
    }	
	
	result = TrimStr(result);	
	return result;
    
}
function TrimStr(s) {
	s = s.replace(/^-/, '');
	return s.replace(/-$/, '');
}
