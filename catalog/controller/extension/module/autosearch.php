<?php
########################################################
#    AutoSearch 1.10 for Opencart 2.3.0.x by AlexDW    #
########################################################
class ControllerExtensionModuleAutosearch extends Controller
{

    public function taras(){
        ini_set("memory_limit","512M");
//        $this->db->query("UPDATE " . DB_PREFIX . "product SET sale_quantity = 0");
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product");
        $count = 1;
        foreach ($query->rows as $key => $value){
            echo $count . ' запись' . "\n";
            $this->db->query("UPDATE " . DB_PREFIX . "product SET sale_quantity = sale_quantity + '" . (int)$value['quantity'] . "' WHERE product_id='" . (int)$value['product_id'] . "'");
            $count++;
        }
    }




    public  function orfFilter($keywords, $arrow = 0)
    {
        $str[0] = array('й' => 'q', 'ц' => 'w', 'у' => 'e', 'к' => 'r', 'е' => 't', 'н' => 'y', 'г' => 'u', 'ш' => 'i', 'щ' => 'o', 'з' => 'p', 'х' => '[', 'ъ' => ']', 'ф' => 'a', 'ы' => 's', 'в' => 'd', 'а' => 'f', 'п' => 'g', 'р' => 'h', 'о' => 'j', 'л' => 'k', 'д' => 'l', 'ж' => ';', 'э' => '\'', 'я' => 'z', 'ч' => 'x', 'с' => 'c', 'м' => 'v', 'и' => 'b', 'т' => 'n', 'ь' => 'm', 'б' => ',', 'ю' => '.', 'Й' => 'Q', 'Ц' => 'W', 'У' => 'E', 'К' => 'R', 'Е' => 'T', 'Н' => 'Y', 'Г' => 'U', 'Ш' => 'I', 'Щ' => 'O', 'З' => 'P', 'Х' => '[', 'Ъ' => ']', 'Ф' => 'A', 'Ы' => 'S', 'В' => 'D', 'А' => 'F', 'П' => 'G', 'Р' => 'H', 'О' => 'J', 'Л' => 'K', 'Д' => 'L', 'Ж' => ';', 'Э' => '\'', '?' => 'Z', 'ч' => 'X', 'С' => 'C', 'М' => 'V', 'И' => 'B', 'Т' => 'N', 'Ь' => 'M', 'Б' => ',', 'Ю' => '.');

        $str[1] = array('q' => 'й', 'w' => 'ц', 'e' => 'у', 'r' => 'к', 't' => 'е', 'y' => 'н', 'u' => 'г', 'i' => 'ш', 'o' => 'щ', 'p' => 'з', '[' => 'х', ']' => 'ъ', 'a' => 'ф', 's' => 'ы', 'd' => 'в', 'f' => 'а', 'g' => 'п', 'h' => 'р', 'j' => 'о', 'k' => 'л', 'l' => 'д', ';' => 'ж', '\'' => 'э', 'z' => 'я', 'x' => 'ч', 'c' => 'с', 'v' => 'м', 'b' => 'и', 'n' => 'т', 'm' => 'ь', ',' => 'б', '.' => 'ю', 'Q' => 'Й', 'W' => 'Ц', 'E' => 'У', 'R' => 'К', 'T' => 'Е', 'Y' => 'Н', 'U' => 'Г', 'I' => 'Ш', 'O' => 'Щ', 'P' => 'З', '[' => 'Х', ']' => 'Ъ', 'A' => 'Ф', 'S' => 'Ы', 'D' => 'В', 'F' => 'А', 'G' => 'П', 'H' => 'Р', 'J' => 'О', 'K' => 'Л', 'L' => 'Д', ';' => 'Ж', '\'' => 'Э', 'Z' => '?', 'X' => 'ч', 'C' => 'С', 'V' => 'М', 'B' => 'И', 'N' => 'Т', 'M' => 'Ь', ',' => 'Б', '.' => 'Ю');

        $str[2] = array("'" => "", "`" => "", "а" => "a", "А" => "a", "б" => "b", "Б" => "b", "в" => "v", "В" => "v", "г" => "g", "Г" => "g", "д" => "d", "Д" => "d", "е" => "e", "Е" => "e", "ж" => "zh", "Ж" => "zh", "з" => "z", "З" => "z", "и" => "i", "И" => "i", "й" => "y", "Й" => "y", "к" => "k", "К" => "k", "л" => "l", "Л" => "l", "м" => "m", "М" => "m", "н" => "n", "Н" => "n", "о" => "o", "О" => "o", "п" => "p", "П" => "p", "р" => "r", "Р" => "r", "с" => "s", "С" => "s", "т" => "t", "Т" => "t", "у" => "u", "У" => "u", "ф" => "f", "Ф" => "f", "х" => "h", "Х" => "h", "ц" => "c", "Ц" => "c", "ч" => "ch", "Ч" => "ch", "ш" => "sh", "Ш" => "sh", "щ" => "sch", "Щ" => "sch", "ъ" => "", "Ъ" => "", "ы" => "y", "Ы" => "y", "ь" => "", "Ь" => "", "э" => "e", "Э" => "e", "ю" => "yu", "Ю" => "yu", "я" => "ya", "Я" => "ya", "і" => "i", "І" => "i", "ї" => "yi", "Ї" => "yi", "є" => "e", "Є" => "e");

        $str[3] = array("a" => "а", "b" => "б", "v" => "в", "g" => "г", "d" => "д", "e" => "е", "yo" => "ё", "j" => "ж", "z" => "з", "i" => "и", "i" => "й", "k" => "к", "l" => "л", "m" => "м", "n" => "н", "o" => "о", "p" => "п", "r" => "р", "s" => "с", "t" => "т", "y" => "у", "f" => "ф", "h" => "х", "c" => "ц", "ch" => "ч", "sh" => "ш", "sh" => "щ", "i" => "ы", "e" => "е", "u" => "у", "ya" => "я", "A" => "А", "B" => "Б", "V" => "В", "G" => "Г", "D" => "Д", "E" => "Е", "Yo" => "Ё", "J" => "Ж", "Z" => "З", "I" => "И", "I" => "Й", "K" => "К", "L" => "Л", "M" => "М", "N" => "Н", "O" => "О", "P" => "П", "R" => "Р", "S" => "С", "T" => "Т", "Y" => "Ю", "F" => "Ф", "H" => "Х", "C" => "Ц", "Ch" => "Ч", "Sh" => "Ш", "Sh" => "Щ", "I" => "Ы", "E" => "Е", "U" => "У", "Ya" => "Я", "'" => "ь", "'" => "Ь", "''" => "ъ", "''" => "Ъ", "j" => "ї", "i" => "и", "g" => "ґ", "ye" => "є", "J" => "Ї", "I" => "І", "G" => "Ґ", "YE" => "Є");

        return strtr($keywords, isset($str[$arrow]) ? $str[$arrow] : array_search($str[0], $str[1]));
    }

    public function elasticSearch($data)
//    public function elasticSearch()
    {
//        $keyword = mb_strtolower(($this->request->get['keyword']), 'UTF-8');
        $keyword = mb_strtolower($data['keyword'], 'UTF-8');

        $keyword = $this->orfFilter($keyword, 1);


        $keywords = explode(' ', $keyword);
        foreach ($keywords as $key => $word){
            if($word == ''){
                unset($keywords[$key]);
            }
        }
        $prefix = 'goods';

        if(count($keywords) > 1 && ($keywords[0] == 'для' || $keywords[0] == 'от' || $keywords[0] == 'при')){
            $prefix = 'description';
            $keyword = $keywords[1];
        }

        $valid_data = [];

            $params = [
                'suggest' => [
                    'complete-suggest' => [
                        'prefix' => $keyword,
                        'completion' => [
                            'analyzer' => 'my_analyzer',
                            'field' => 'suggest',
                            'size' => 1000
                        ]
                    ]
                ]
            ];
            
         $data_string = json_encode($params);
         
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, HTTP_SERVER_ELASTIC . $prefix . "_complete/_search");
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
         curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
         $response = curl_exec($ch);
         curl_close($ch);
         $res = json_decode($response, true);
         
         if(!empty($res)) {
             foreach ($res['suggest']['complete-suggest'] as $hits) {
                 foreach ($hits['options'] as $hit) {
                     $valid_data[$hit['_id']]['tag'] = $hit['_source']['tag'];
                     $valid_data[$hit['_id']]['name'] = $hit['_source']['text'];
                     $valid_data[$hit['_id']]['origin_title'] = $hit['_source']['origin_title'];
                     $valid_data[$hit['_id']]['href'] = $hit['_source']['href'];
                     $valid_data[$hit['_id']]['id'] = $hit['_source']['id'];
                 }
             }
             $this->cache->delete('search_result_' . $this->session->getId());
         }else{
             //echo 'response is empty';
         }

                    
                    


        if($prefix == 'description'){
            unset($keywords[0]);
        }
        
        if($data['description']){
            $prefix = 'description';
        }

            foreach ($keywords as $key => $keyword){

                $params = [
                    'query' => [
                        'fuzzy' => [
                            'text' => [
                                'value' => $keyword,
                                'boost' => 2,
                                'prefix_length' => 2
                            ]
                        ]
                    ]
                ];

                $data_string = json_encode($params);
                $ch = curl_init();
//            curl_setopt($ch, CURLOPT_URL, HTTP_SERVER_ELASTIC . $prefix . "_complete/_search?explain=true");
                curl_setopt($ch, CURLOPT_URL, HTTP_SERVER_ELASTIC . $prefix . "_complete/_search");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $response = curl_exec($ch);
                curl_close($ch);
                $res = json_decode($response, true);

                if(!empty($res)) {
                    foreach ($res['hits']['hits'] as $hit) {
                        if(!isset($valid_data[$hit['_id']])){
                            $valid_data[$hit['_id']]['tag'] = $hit['_source']['tag'];
                            $valid_data[$hit['_id']]['name'] = $hit['_source']['text'];
                            $valid_data[$hit['_id']]['origin_title'] = $hit['_source']['origin_title'];
                            $valid_data[$hit['_id']]['href'] = $hit['_source']['href'];
                            $valid_data[$hit['_id']]['id'] = $hit['_source']['id'];
                        }
                    }
                }else{
                    //echo 'response is empty';
                }
            }
            

            












        $search_result = [];
        foreach ($valid_data as $item){
            if($item['tag'] == 'product'){
                $search_result[] = $item['id'];
            }
        }
        //rewrite URL


        $this->load->model('catalog/product');
        $this->load->model('catalog/category');
        foreach ($valid_data as  &$item){
            if($item['tag'] == 'product') {
//               $product_info = $this->model_catalog_product->getProduct($item['id']);
//               $item['href'] = str_replace(HTTP_SERVER, 'goods/' . $product_info['sku'] . '/', $this->url->link('product/product', '&product_id=' . $item['id']));
            }elseif($item['tag'] == 'category'){
//               $temp_cat = explode("path=", $item['href']);
//               $temp_cat = array_reverse(explode("_", $temp_cat[1]));
//               $cat_id = $temp_cat[0];
//               $item['href'] = str_replace(HTTP_SERVER,'catalog/', $this->url->link('product/category', 'path=' . $cat_id));
            }elseif($item['tag'] == 'manufacturer'){
                $temp = explode("manufacturer_id=", $item['href']);
                $manufacturer_id = $temp[1];
                $item['href'] = str_replace(HTTP_SERVER,'catalog/', $this->url->link('product/manufacturer/info', '&manufacturer_id=' . $manufacturer_id));
            }
        }
//        $valid_data = $this->customMultiSort($valid_data, 'name');
//        $this->cache->set('search_result_' . $this->session->getId(), $search_result);


//        echo json_encode($valid_data);
        return $valid_data;
    }
    public function customMultiSort($array,$field) {
        $sortArr = array();
        foreach($array as $key=>$val){
            $sortArr[$key] = $val[$field];
        }

        array_multisort($sortArr,SORT_DESC, SORT_STRING, $array);

        return $array;
    }
    public function elasticSearchOLD()
    {

        $keyword = mb_strtolower(($this->request->get['keyword']), 'UTF-8');
        $keyword =  $part_check = $this->orfFilter($keyword, 1);
        $keyword = mb_strtolower($keyword);



        $keyword = explode(' ', $keyword);
        foreach ($keyword as $key => $word){
            if($word == ''){
                unset($keyword[$key]);
            }
        }
        foreach ($keyword as &$word){
            $word =  $word . "*";
        }
        $keyword = array_values($keyword);
//        $keyword = implode(' ', $keyword);

        foreach ($keyword as $key => $item){
            $params = [
                'query' =>[
                    'wildcard' => [
                        'title' => [
                            'value' => "*" . $item . "*"
                        ]
                    ]
                ]
            ];
            $data_string = json_encode($params);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, HTTP_SERVER_ELASTIC."_search");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);
            $res = json_decode($response, true);
            $valid_data = [];
            if(!empty($res)) {
                foreach ($res['hits']['hits'] as $hit) {

                    $valid_data[$key][$hit['_id']]['tag'] = $hit['_source']['tag'];
                    $valid_data[$key][$hit['_id']]['name'] = $hit['_source']['title'];
                    $valid_data[$key][$hit['_id']]['href'] = $hit['_source']['href'];
                    $valid_data[$key][$hit['_id']]['id'] = $hit['_source']['id'];
                }
            }else{
                //echo 'response is empty';
            }
        }
        $valid_data3 = $this->arraySum($valid_data[0], $valid_data[1]);

        $keyword = mb_strtolower(($this->request->get['keyword']), 'UTF-8');
        $keyword  = $this->orfFilter($keyword, 0);
        $keyword = mb_strtolower($keyword);



        foreach ($keyword as $key => $word){
            if($word == ''){
                unset($keyword[$key]);
            }
        }
        $keyword = explode(' ', $keyword);
        foreach ($keyword as &$word){
            $word =  $word . "*";
        }
        $keyword = array_values($keyword);
//        $keyword = implode(' ', $keyword);

        foreach ($keyword as $key => $item){
            $params = [
                'query' =>[
                    'wildcard' => [
                        'title' => [
                            'value' => "*" . $item . "*"
                        ]
                    ]
                ]
            ];
            $data_string = json_encode($params);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, HTTP_SERVER_ELASTIC."_search");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);
            $res = json_decode($response, true);
            $valid_data = [];
            if(!empty($res)) {
                foreach ($res['hits']['hits'] as $hit) {

                    $valid_data[$key][$hit['_id']]['tag'] = $hit['_source']['tag'];
                    $valid_data[$key][$hit['_id']]['name'] = $hit['_source']['title'];
                    $valid_data[$key][$hit['_id']]['href'] = $hit['_source']['href'];
                    $valid_data[$key][$hit['_id']]['id'] = $hit['_source']['id'];
                }
            }else{
                //echo 'response is empty';
            }
        }
        $valid_data4 = $this->arraySum($valid_data[0], $valid_data[1]);

        $valid_data = $this->arraySum($valid_data3, $valid_data4);

        $this->cache->delete('search_result_' . $this->session->getId());

        $search_result = [];
        foreach ($valid_data as $item){
            if($item['tag'] == 'product'){
                $search_result[] = $item['id'];
            }
        }


        //rewrite URL


        $this->load->model('catalog/product');
        $this->load->model('catalog/category');
        foreach ($valid_data as  &$item){
            if($item['tag'] == 'product') {
//               $product_info = $this->model_catalog_product->getProduct($item['id']);
//               $item['href'] = str_replace(HTTP_SERVER, 'goods/' . $product_info['sku'] . '/', $this->url->link('product/product', '&product_id=' . $item['id']));
            }elseif($item['tag'] == 'category'){
//               $temp_cat = explode("path=", $item['href']);
//               $temp_cat = array_reverse(explode("_", $temp_cat[1]));
//               $cat_id = $temp_cat[0];
//               $item['href'] = str_replace(HTTP_SERVER,'catalog/', $this->url->link('product/category', 'path=' . $cat_id));
            }elseif($item['tag'] == 'manufacturer'){
                $temp = explode("manufacturer_id=", $item['href']);
                $manufacturer_id = $temp[1];
                $item['href'] = str_replace(HTTP_SERVER,'catalog/', $this->url->link('product/manufacturer/info', '&manufacturer_id=' . $manufacturer_id));
            }
        }


        $keyword = mb_strtolower(($this->request->get['keyword']), 'UTF-8');
        $params = [
            'query' =>[
                'match_phrase_prefix' => [
                    'title' => $keyword
                ]
            ],
            'size' => 200
        ];

        $data_string = json_encode($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, HTTP_SERVER_ELASTIC."_search");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($response, true);
        $valid_data2 = [];

        if(!empty($res)) {
            foreach ($res['hits']['hits'] as $hit) {
                $valid_data2[$hit['_id']]['tag'] = $hit['_source']['tag'];
                $valid_data2[$hit['_id']]['name'] = $hit['_source']['title'];
                $valid_data2[$hit['_id']]['href'] = $hit['_source']['href'];
                $valid_data2[$hit['_id']]['id'] = $hit['_source']['id'];
            }
        }else{
            //echo 'response is empty';
        }

        foreach ($valid_data2 as  &$item){
            if($item['tag'] == 'manufacturer'){
                $temp = explode("manufacturer_id=", $item['href']);
                $manufacturer_id = $temp[1];
                $item['href'] = str_replace(HTTP_SERVER,'catalog/', $this->url->link('product/manufacturer/info', '&manufacturer_id=' . $manufacturer_id));
            }
        }

        $valid_data = $this->arraySum($valid_data, $valid_data2);

        $this->cache->set('search_result_' . $this->session->getId(), $search_result);

        echo json_encode($valid_data);

    }

    public function arraySum($arr1, $arr2)
    {
        $result = [];

        foreach($arr1 as $val) {
            $result[] = $val;
        }

        foreach($arr2 as $val) {
            $result[] = $val;
        }

        return $result;
    }
}

?>