<?php

ini_set("memory_limit","1024M");

function get_token($a) {
    return $a->token;
}

function remove_digits($a)
{
//    return !preg_match('~[0-9]~', $a);
    return  $a;
}

class ControllerExtensionModuleImport extends Controller
{
    //private $arr = [];
    private $arr = [];

    public function uploadImages(){
        $this->load->model('catalog/category');
        $this->load->model('catalog/product');
        $this->load->model('tool/image');
        $qwery = $this->db->query("SELECT product_id, sku, image FROM oc_product  WHERE status = 1");
        $products = $qwery->rows;
        foreach ($products as &$product){
            $info = getimagesize(DIR_IMAGE . $product['image']);
            $bits = isset($info['bits']) ? $info['bits'] : '';
            $mime = isset($info['mime']) ? $info['mime'] : '';
            $product['exist'] = ($product['image'] == '') ? 'no' : 'yes';
            if($product['image'] == ''){
                $product['extension'] = '';
            }else{
                $product['extension'] = $info[3] . ' bits=' . $bits . ' type='.$mime;
            }

        }
        $file = "product_images.csv";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename='.$file);
        $content = "id,extension,exist,\n";

        foreach ($products as $product){
            $content .= $product['sku'] . ',' . $product['extension'] .',' . $product['image'] . ','. $product['exist'] . "\n";
        }
        echo $content;

    }

    private function elasticDeleteAllIdices()
    {
        $url = HTTP_SERVER_ELASTIC . '_all';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        print_r($result.PHP_EOL);
    }

    private function elasticCreateIndicesWithMappings()
    {
        $params = [
            'settings' => [
                'analysis' => [
                    'analyzer' => [
                        'my_analyzer' => [
                            'type' => 'custom',
                            'tokenizer' => 'standard',
                            'char_filter' => ['input_char_filter'],
                            'filter' => ['lowercase', 'russian_morphology', 'english_morphology', 'my_stopwords']

                        ]
                    ],
                    'filter' => [
                        'my_stopwords' => [
                            'type' => 'stop',
                            'stopwords' => 'а,без,более,бы,был,была,были,было,быть,в,вам,вас,весь,во,вот,все,всего,всех,вы,где,да,даже,для,до,его,ее,если,есть,еще,же,за,здесь,и,из,или,им,их,к,как,ко,когда,кто,ли,либо,мне,может,мы,на,надо,наш,не,него,нее,нет,ни,них,но,ну,о,об,однако,он,она,они,оно,от,очень,по,под,при,с,со,так,также,такой,там,те,тем,то,того,тоже,той,только,том,ты,у,уже,хотя,чего,чей,чем,что,чтобы,чье,чья,эта,эти,это,я,a,an,and,are,as,at,be,but,by,for,if,in,into,is,it,no,not,of,on,or,such,that,the,their,then,there,these,they,this,to,was,will,with'
                        ]
                    ],
                    'char_filter' => [
                        'input_char_filter' => [
                            "pattern" => "-",
                            'type' => 'pattern_replace',
                            "replacement" => ""
                        ]
                    ]
                ]
            ],
            'mappings' => [
                'doc' => [
                    'properties' => [
                        'first' => [
                            'type' => 'text',
                            'index' => 'true',
                            'search_analyzer' => 'my_analyzer',
                            'analyzer' => 'my_analyzer'
                        ],
                        'second' => [
                            'type' => 'text',
                            'index' => 'true',
                            'search_analyzer' => 'my_analyzer',
                            'analyzer' => 'my_analyzer'
                        ],
                        'third' => [
                            'type' => 'text',
                            'index' => 'true',
                            'search_analyzer' => 'my_analyzer',
                            'analyzer' => 'my_analyzer'
                        ],
                        'fourth' => [
                            'type' => 'text',
                            'index' => 'true',
                            'search_analyzer' => 'my_analyzer',
                            'analyzer' => 'my_analyzer'
                        ],
                        'fifth' => [
                            'type' => 'text',
                            'index' => 'true',
                            'search_analyzer' => 'my_analyzer',
                            'analyzer' => 'my_analyzer'
                        ],
                        'title' => [
                            'type' => 'text',
                            'index' => 'true',
                            'search_analyzer' => 'my_analyzer',
                            'analyzer' => 'my_analyzer'
                        ],
                        'id' => [
                            'type' => 'text',
                            'index' => 'false'
                        ],
                        'href' => [
                            'type' => 'text',
                            'index' => 'false'
                        ],
                        'tag' => [
                            'type' => 'text',
                            'index' => 'false'
                        ]
                    ]
                ]
            ]
        ];

        $params2 = [
            'settings' => [
                'analysis' => [
                    'analyzer' => [
                        'my_analyzer' => [
                            'type' => 'custom',
                            'tokenizer' => 'standard',
                            'char_filter' => ['input_char_filter'],
                            'filter' => ['lowercase', 'russian_morphology', 'english_morphology', 'my_stopwords']
                        ]
                    ],
                    'filter' => [
                        'my_stopwords' => [
                            'type' => 'stop',
                            'stopwords' => 'а,без,более,бы,был,была,были,было,быть,в,вам,вас,весь,во,вот,все,всего,всех,вы,где,да,даже,для,до,его,ее,если,есть,еще,же,за,здесь,и,из,или,им,их,к,как,ко,когда,кто,ли,либо,мне,может,мы,на,надо,наш,не,него,нее,нет,ни,них,но,ну,о,об,однако,он,она,они,оно,от,очень,по,под,при,с,со,так,также,такой,там,те,тем,то,того,тоже,той,только,том,ты,у,уже,хотя,чего,чей,чем,что,чтобы,чье,чья,эта,эти,это,я,a,an,and,are,as,at,be,but,by,for,if,in,into,is,it,no,not,of,on,or,such,that,the,their,then,there,these,they,this,to,was,will,with'
                        ]
                    ],
                    'char_filter' => [
                        'input_char_filter' => [
                            "pattern" => "-",
                            'type' => 'pattern_replace',
                            "replacement" => ""
                        ]
                    ]
                ]
            ],
            'mappings' => [
                'doc' => [
                    'properties' => [
                        'suggest' => [
                            'type' => 'completion',
                        ],
                        'text' => [
                            'type' => 'text',
                        ],
                        'id' => [
                            'type' => 'text',
                            'index' => 'false'
                        ],
                        'href' => [
                            'type' => 'text',
                            'index' => 'false'
                        ],
                        'title' => [
                            'type' => 'text',
                            'index' => 'true',
                            'search_analyzer' => 'my_analyzer',
                            'analyzer' => 'my_analyzer'
                        ],
                        'tag' => [
                            'type' => 'text',
                            'index' => 'false'
                        ],
                    ]
                ]
            ]
        ];

        $data_string = json_encode($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, HTTP_SERVER_ELASTIC . "goods_search");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        print_r($response.PHP_EOL);

        $data_string = json_encode($params2);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, HTTP_SERVER_ELASTIC . "goods_complete");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        print_r($response.PHP_EOL);

        $data_string = json_encode($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, HTTP_SERVER_ELASTIC . "description_search");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        print_r($response.PHP_EOL);

        $data_string = json_encode($params2);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, HTTP_SERVER_ELASTIC . "description_complete");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        print_r($response.PHP_EOL);
    }

    private function elasticAnalyzeItem($h1)
    {

        $params = [
            'analyzer' => 'my_analyzer',
            'text' => (string)$h1,
        ];
        $data_string = json_encode($params);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, HTTP_SERVER_ELASTIC . "goods_complete/_analyze");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }

    private function elasticAnalyzeItem2($description)
    {

        $params = [
            'analyzer' => 'my_analyzer',
            'text' => (string)$description,
        ];
        $data_string = json_encode($params);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, HTTP_SERVER_ELASTIC . "description_complete/_analyze");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }

    private function elasticAddSearchItem($h1, $id,  $tag, $tokens)
    {

        $t = array_values(array_filter(array_map('get_token',$tokens->tokens), 'remove_digits'));
        $params = [
            'first' => '',
            'second' => '',
            'third' => '',
            'fourth' => '',
            'fifth' => '',
            'title' => (string)$h1,
            'id' => (string)$id,
            'tag' => $tag,
        ];

        $len = count($t);
        if ($len > 0) {
            $params['first'] = $t[0];
        }
        if ($len > 1) {
            $params['second'] = $t[1];
        }
        if ($len > 2) {
            $params['third'] = $t[2];
        }
        if ($len > 3) {
            $params['fourth'] = $t[3];
        }
        if ($len > 4) {
            $params['fifth'] = $t[4];
        }

        $data_string = json_encode($params);


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, HTTP_SERVER_ELASTIC . "goods_search/doc");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        if (empty($response)) {
            echo 'fail generate cache 7' . PHP_EOL . $id . " " . $tag . PHP_EOL . $tokens . PHP_EOL;
//            die;
        } else {
            print_r($response.PHP_EOL);
        }
    }
    private function elasticAddSearchItem2($long_text, $id, $tokens)
    {

        $t = array_values(array_filter(array_map('get_token',$tokens->tokens), 'remove_digits'));

        $params = [
            'first' => '',
            'second' => '',
            'third' => '',
            'fourth' => '',
            'fifth' => '',
            'title' => (string)$long_text,
            'id' => (string)$id,
        ];

        $len = count($t);
        if ($len > 0) {
            $params['first'] = $t[0];
        }
        if ($len > 1) {
            $params['second'] = $t[1];
        }
        if ($len > 2) {
            $params['third'] = $t[2];
        }
        if ($len > 3) {
            $params['fourth'] = $t[3];
        }
        if ($len > 4) {
            $params['fifth'] = $t[4];
        }

        $data_string = json_encode($params);


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, HTTP_SERVER_ELASTIC . "description_search/doc");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);

        curl_close($ch);
        if (empty($response)) {
            echo 'fail generate cache 1' . PHP_EOL;
//            die;
        } else {
            print_r($response.PHP_EOL);
        }
    }

    private function elasticAddCompleteItem($h1, $id, $href, $tag, $tokens)
    {
        $len = count($tokens->tokens);

//        for($i = 0; $i < $len; ++$i) {
////
//        $t = $tokens->tokens[$i];
//        $ph = str_replace('"', '', mb_strtolower(mb_substr((string)$h1, 0, $t->end_offset)));
        $origin_title = str_replace('"', '', mb_strtolower($h1));

        $ph = str_replace('-', '', $origin_title);
        $ex_param = [
            'size' => 0,
            'terminate_after' => 1,
            'query' => [
                'match_phrase' => [
                    'text' => $ph
                ]
            ]
        ];

        $data_string = json_encode($ex_param);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, HTTP_SERVER_ELASTIC . "goods_complete/_search");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        if (empty($response)) {
            echo 'fail generate cache 10' . PHP_EOL;
//            die;
        } else {
            $res = json_decode($response, true);
            if(!empty($res) && $res['hits']['total'] == 0) {

//                    $weight = 50 - $i;
                $weight = 50 ;
                if ($tag == 'category') $weight += 100;
                $suggest = [
                    'input' => $ph,
                    'weight' => $weight
                ];

                $params = [
                    'suggest' => $suggest,
                    'text' => $ph,
                    'id' => $id,
                    'origin_title' => $origin_title,
                    'href' => $href,
                    'tag' => $tag,
                ];

                // for ($j = 0; $j <= $i; ++$j) {
                //     $suggest = [
                //         'input' => mb_strtolower($arr->tokens[$j]->token),
                //         'weight' => 5000 - $i*100 - $j - $i
                //     ];
                //     array_push($params['suggest'], $suggest);
                // }

                $data_string = json_encode($params);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, HTTP_SERVER_ELASTIC . "goods_complete/doc");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $response = curl_exec($ch);
                curl_close($ch);
                if (empty($response)) {

                    echo 'fail generate cache 11' . PHP_EOL;
//                    die;
                } else {
                    print_r($response.PHP_EOL);
                }
            }
        }
//        }
    }
    private function elasticAddCompleteItem2($h1, $long_text, $id, $href, $tag)
    {
        $description = str_replace('"', '', mb_strtolower($long_text));
        $origin_title = str_replace('"', '', mb_strtolower($h1));
        $ex_param = [
            'size' => 0,
            'terminate_after' => 1,
            'query' => [
                'match_phrase' => [
                    'text' => $description
                ]
            ]
        ];

        $data_string = json_encode($ex_param);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, HTTP_SERVER_ELASTIC . "description_complete/_search");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        if (empty($response)) {
            echo 'fail generate cache 12' . PHP_EOL;
//            die;
        } else {
            $res = json_decode($response, true);

            if(!empty($res) && $res['hits']['total'] == 0) {

//                    $weight = 50 - $i;
                $weight = 50 ;
                $suggest = [
                    'input' => $description,
                    'weight' => $weight,
                ];

                $params = [
                    'suggest' => $suggest,
                    'text' => $description,
                    'id' => $id,
                    'origin_title' => $origin_title,
                    'href' => $href,
                    'tag' => $tag,
                ];

                $data_string = json_encode($params);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, HTTP_SERVER_ELASTIC . "description_complete/doc");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $response = curl_exec($ch);
                curl_close($ch);
                if (empty($response)) {
                    echo 'fail generate cache 2' . PHP_EOL;
//                    die;
                } else {
                    print_r($response.PHP_EOL);
                }
            }
        }
//        }
    }
    public function elasticGenerateCache3()
    {
        $this->load->model('setting/setting');
        $this->load->model('catalog/product');

        $start = $this->model_setting_setting->getSetting('fail_product');
        $start = (int)$start['fail_product'];

        if (isset($this->request->post['language'])) {
            $code = $this->model_localisation_language->getLanguage($this->request->post['language']);
            $this->session->data['language'] = $code['code'];
        } else {
            $code['language_id'] = 2;
            $this->session->data['language'] = 'ru-ru';
        }

        $products = $this->model_catalog_product->getProductsForSiteMap2($code['language_id'], $start);

        foreach ($products as $key => $product) {
            $description = $this->clear($product['description']);
            $instruction = $this->clear($product['instruction']);
            $id = $product['product_id'];
            $h1 = $product['name'];
            $href = $this->get_product_url($id);
            if (!empty($description)) {
                $tokens = $this->elasticAnalyzeItem2($description);
                if(!empty($tokens)){
                    $this->elasticAddSearchItem2($description, $id, $tokens);
                    $this->elasticAddCompleteItem2($h1, $description, $id, $href, 'description');
                }else{
                    print_r($product);
                    $data_for_settings = ['fail_product' => $id];
                    $this->model_setting_setting->editSetting('fail_product', $data_for_settings);
                    sleep(30);
                    $this->elasticGenerateCache3();
                    break;
                }
            }
            if (!empty($instruction)) {
                $tokens = $this->elasticAnalyzeItem2($instruction);
                if(!empty($tokens)){
                    $this->elasticAddSearchItem2($instruction, $id, $tokens);
                    $this->elasticAddCompleteItem2($h1, $instruction, $id, $href, 'instruction');
                }else{
                    print_r($product);
                    $data_for_settings = ['fail_product' => $id];
                    $this->model_setting_setting->editSetting('fail_product', $data_for_settings);
                    sleep(30);
                    $this->elasticGenerateCache3();
                    break;
                }
            }
        }
        $data_for_settings = ['fail_product' => 1];
        $this->model_setting_setting->editSetting('fail_product', $data_for_settings);
        echo "done products" . "\n";
    }

    public function clear($string)
    {
        $string = html_entity_decode($string);
        $string = str_replace('&ndash;', '-', $string);
        $string = str_replace('<1', 'меньше 1', $string);
        $string = str_replace('> 1', 'больше 1', $string);
        $string = str_replace('       ', ' ', $string);
        $string = str_replace('      ', ' ', $string);
        $string = str_replace('     ', ' ', $string);
        $string = str_replace('    ', ' ', $string);
        $string = str_replace('   ', ' ', $string);
        $string = str_replace('  ', ' ', $string);
        $string = strip_tags($string);
        $string = str_replace("\r\n"," ", $string);
        $string = str_replace('  ', ' ', $string);
        $string = trim( $string);

        return $string;

    }
    public function elasticGenerateCache2()
    {
        $this->load->model('setting/setting');
        $this->load->model('catalog/product');

        $start = $this->model_setting_setting->getSetting('fail_product');
        $start = (int)$start['fail_product'];

        if($start == 1){
            $this->elasticDeleteAllIdices();
            $this->elasticCreateIndicesWithMappings();
        }

        if (isset($this->request->post['language'])) {
            $code = $this->model_localisation_language->getLanguage($this->request->post['language']);
            $this->session->data['language'] = $code['code'];
        } else {
            $code['language_id'] = 2;
            $this->session->data['language'] = 'ru-ru';
        }

         $products = $this->model_catalog_product->getProductsForSiteMap($code['language_id'], $start);
         foreach ($products as $product) {
             $h1 = $product['name'];
             $id = $product['product_id'];
             if (!empty($h1)) {
                 $tokens = $this->elasticAnalyzeItem($h1);
                 if(!empty($tokens)){
                     $this->elasticAddSearchItem($h1, $id, 'product', $tokens);
                     $href = $this->get_product_url($id);
                     $this->elasticAddCompleteItem($h1, $id, $href,  'product', $tokens);
                 }else{
                     print_r($product);
                     $data_for_settings = ['fail_product' => $id];
                     $this->model_setting_setting->editSetting('fail_product', $data_for_settings);
                     sleep(30);
                     $this->elasticGenerateCache2();
                     break;
                 }
             }
         }
         $data_for_settings = ['fail_product' => 1];
         $this->model_setting_setting->editSetting('fail_product', $data_for_settings);

         echo "done products" . "\n";


        $this->elasticGenerateCache3();
    }

    public function elasticGenerateCache3Category(){
        $this->load->model('catalog/category');
        $categories = $this->model_catalog_category->getCategoriesForElasticGenerateCache();

        foreach ($categories as $category) {
            $h1 = $category['name'];
            echo $h1 . "\n";
            $id = $category['category_id'];
            $href = '';
            if (!empty($h1)) {
                $tokens = $this->elasticAnalyzeItem2($h1);
                if(!empty($tokens)){
                    $this->elasticAddSearchItem2($h1,  $id,$tokens);
                    $this->elasticAddCompleteItem2($h1, $h1, $id, $href, 'category');
                }else{
                    echo '<pre>';
                    print_r($category);
                    echo '</pre>';
                    die;
                }
            }
        }
    }

    public function elasticGenerateCache2Category(){
        $this->load->model('catalog/category');
        $categories = $this->model_catalog_category->getCategoriesForElasticGenerateCache();
        foreach ($categories as $category) {
            $h1 = $category['name'];
            echo $h1 . "\n";
            $id = $category['category_id'];
            $href = '';
            if (!empty($h1)) {
                $tokens = $this->elasticAnalyzeItem($h1);
                if(!empty($tokens)){
                    $this->elasticAddSearchItem($h1, $id, 'category', $tokens);
                    $this->elasticAddCompleteItem($h1, $id, $href, 'category', $tokens);
                }else{
                    echo '<pre>';
                    print_r($category);
                    echo '</pre>';
                    die;
                }
            }
        }
    }

    public function get_product_url($id){
        $this->load->model('catalog/product');
        $cat_id = $this->model_catalog_product->getMainCategory($id);
        $this->arr = [];
        $arr_of_ids = $this->recursive($cat_id['category_id']);
        $parts = array_reverse($arr_of_ids);
        $path = implode('_', $parts);
        $url = $this->url->link('product/product', '&path=' . $path . '&product_id=' . $id);
        $url = str_replace('&amp;', '&', $url);
        return $url;
    }

    private function recursive($id){

        $this->load->model('catalog/category');
        $this->arr[] = $id;
        $cat_info = $this->model_catalog_category->getCategory($id);
        if(!empty($cat_info)){
            if((int)$cat_info['parent_id'] != 0){
                $this->recursive($cat_info['parent_id']);
            }
        }

        return $this->arr;
    }

    public function elasticGenerateCache()
    {
        $url = HTTP_SERVER_ELASTIC . '_all';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        print_r($result);
        require_once('simple_html_dom.php');
        $url_sitemap = $this->load->controller('extension/feed/google_sitemap');
        $content_product = file_get_contents($url_sitemap);

        $site_map_xml = new SimpleXMLElement($content_product);
        foreach ($site_map_xml->url as $loc) {
            $loc_tags[] = $loc;
        }
        $count = 0;
        foreach ($loc_tags as $xml_file) {

            print_r($count . "\n");

            if (is_int(strpos($xml_file->loc, 'category'))) {
                $content_each_xml_file = file_get_html($xml_file->loc);
                if (!is_object($content_each_xml_file)) {
                    file_put_contents('test_log.txt',$xml_file->loc . "\n");
                } else {
                    $h1 = $content_each_xml_file->find('h1[id=xml_search_category_name]', 0)->plaintext;
                    if (!empty($h1)) {
                        $params = [
                            'title' => (string)$h1,
                            'id' => '0',
                            'href' => (string)$xml_file->loc,
                            'tag' => "category",
                        ];
                        $data_string = json_encode($params);
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, HTTP_SERVER_ELASTIC . "elastic/feed");
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        $response = curl_exec($ch);
                        curl_close($ch);
                        if (empty($response)) {
                            echo 'fail generate cache 3' . PHP_EOL;
//                            die;
                        } else {
                            print_r($response);
                        }
                    }
                }
            }
            elseif (is_int(strpos($xml_file->loc, 'manufacturer_id'))) {
                $content_each_xml_file = file_get_html($xml_file->loc);
                if (!is_object($content_each_xml_file)) {
                    file_put_contents('test_log.txt', $xml_file->loc . "\n");
                } else {
                    $h1 = $content_each_xml_file->find('h1[id=xml_search_manufacturer_name]', 0)->plaintext;
                    if (!empty($h1)) {
                        $params = [
                            'title' => (string)$h1,
                            'id' => '0',
                            'href' => (string)$xml_file->loc,
                            'tag' => "manufacturer",
                        ];
                        $data_string = json_encode($params);
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, HTTP_SERVER_ELASTIC . "elastic/feed");
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        $response = curl_exec($ch);
                        curl_close($ch);
                        if (empty($response)) {
                            echo 'fail generate cache 4' . PHP_EOL;
//                            die;
                        } else {
                            print_r($response);
                        }
                    }
                }
            }
            elseif(is_int(strpos($xml_file->loc, 'goods'))) {
                $content_each_xml_file = file_get_html($xml_file->loc);
                if (!is_object($content_each_xml_file)) {
                    file_put_contents('test_log.txt',$xml_file->loc . "\n");
                } else {
                    try{
                        $h1 = $content_each_xml_file->find('h1[id=xml_search_product_name]', 0)->plaintext;
                        $id = $content_each_xml_file->find('div[id=xml_search_product_id]', 0)->plaintext;
                        //Если fopen возвращает логическое значение FALSE, то возникает ошибка.
                        if($h1 === false || $id === false){
                            throw new Exception('Невозможно открыть');
                        }
                    }
                    catch (Exception $ex) {
                        file_put_contents('test_log.txt',$xml_file->loc . "\n");
                    }
                    if (!empty($h1)) {
                        $params = [
                            'title' => (string)$h1,
                            'id' => (string)$id,
                            'href' => (string)$xml_file->loc,
                            'tag' => "product",
                        ];

                        $data_string = json_encode($params);
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, HTTP_SERVER_ELASTIC . "elastic/feed");
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        $response = curl_exec($ch);
                        curl_close($ch);
                        if (empty($response)) {
                            echo 'fail generate cache 5' . PHP_EOL;
//                            die;
                        } else {
                            print_r($response);
                        }
                    }
                }
            }
            $count++;
        }
    }
    public function test()
    {

        $url_sitemap = $this->load->controller('extension/feed/google_sitemap');
        require_once('simple_html_dom.php');
        $content_product = file_get_contents($url_sitemap);
        $site_map_xml = new SimpleXMLElement($content_product);
        foreach ($site_map_xml->url as $loc) {
            $loc_tags[] = $loc;
        }
        $count = 0;
        foreach ($loc_tags as $xml_file) {
            if (is_int(strpos($xml_file->loc, 'manufacturer_id'))) {
                $content_each_xml_file = file_get_html($xml_file->loc);
                if (!is_object($content_each_xml_file)) {
                    file_put_contents('test_log.txt', $xml_file->loc . "\n");
                } else {
                    $h1 = $content_each_xml_file->find('h1[id=xml_search_manufacturer_name]', 0)->plaintext;
                    if (!empty($h1)) {
                        $params = [
                            'title' => (string)$h1,
                            'id' => '0',
                            'href' => (string)$xml_file->loc,
                            'tag' => "manufacturer",
                        ];
                        $data_string = json_encode($params);
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, HTTP_SERVER_ELASTIC . "elastic/feed");
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        $response = curl_exec($ch);
                        curl_close($ch);
                        if (empty($response)) {
                            echo 'fail generate cache 6' . PHP_EOL;
//                            die;
                        } else {
                            print_r($response);
                        }
                    }
                }
            }
        }
    }


    public function createCsv(){
        $this->load->model('catalog/product');
//        $attributes = $this->model_catalog_product->getAllAttributesNAme();
//        $test_atr = [];
//
//        foreach ($attributes as $attribute) {
//            $test_atr[$attribute['attribute_id']] = $attribute['name'];
//        }
//        ksort($test_atr);

        $results = $this->model_catalog_product->getProducts();
        $array_of_products_name = [];


        $count = 0;

        foreach ($results as  $item){
            $qwery = $this->db->query("SELECT * FROM oc_product_to_category  WHERE product_id = '" . (int)$item['product_id'] . "'");
            $cat_id = $qwery->row['category_id'];
            $this->arr = [];
            $arr_of_ids = $this->recursive($cat_id);
            $custom_parts_cpu = [];
            foreach ($arr_of_ids as $arr_id) {
                $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description WHERE category_id = '" . $this->db->escape($arr_id) . "'");
                if (!empty($query->row)) {
                    $custom_parts_cpu[] = $query->row['name'];
                }
            }
            $parts = array_reverse($custom_parts_cpu);
            $path = implode(' --> ', $parts);


            $array_of_products_name[$item['product_id']] = [
                '1' => $item['product_id'],
                '2'=> $item['sku'],
                '3' => $item['name'],
                '4' => $path
            ];


            ksort($array_of_products_name[$item['product_id']]);
            echo $count . "\n";
            $count++;
        }
        $test_atr = [];
        array_unshift($test_atr, 'Категория');
        array_unshift($test_atr, 'Название товара');
        array_unshift($test_atr, 'Старый ID');
        array_unshift($test_atr, 'ID');

        array_unshift($array_of_products_name, $test_atr);
        var_dump($array_of_products_name);

        $fp = fopen('product.csv', 'w');
        foreach ($array_of_products_name as $fields) {
            print_r($fields);
            fputcsv($fp, $fields);
        }
        fclose($fp);
//        $this->generateCsv($array_of_products_name);


    }
    public  function generateCsv($data, $delimiter = ';', $enclosure = '"') {

        $handle = fopen(DIR_SITEMAP . 'products.csv', 'r+');
        foreach ($data as $line) {
            print_r($line);
            fputcsv($handle, $line, $delimiter, $enclosure);
        }
        rewind($handle);
        $contents = '';
        while (!feof($handle)) {
            $contents .= fread($handle, 8192);
        }
        fclose($handle);
        return $contents;
    }

//    private function recursive($id){
//        $this->load->model('catalog/category');
//        $this->arr[] = $id;
//        $cat_info = $this->model_catalog_category->getCategory($id);
//        if((int)$cat_info['parent_id'] != 0){
//            $this->recursive($cat_info['parent_id']);
//        }
//        return $this->arr;
//    }





    public function rus2translit($string){
        $converter = array(
            'а' => 'a', 'б' => 'b', 'в' => 'v',
            'г' => 'g', 'д' => 'd', 'е' => 'e',
            'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
            'и' => 'i', 'й' => 'y', 'к' => 'k',
            'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
            'ь' => '', 'ы' => 'y', 'ъ' => '',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
            'А' => 'A', 'Б' => 'B', 'В' => 'V',
            'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
            'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
            'И' => 'I', 'Й' => 'Y', 'К' => 'K',
            'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R',
            'С' => 'S', 'Т' => 'T', 'У' => 'U',
            'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
            'Ь' => '', 'Ы' => 'Y', 'Ъ' => '',
            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
        );
        return strtr($string, $converter);
    }
    public function str2url($str)
    {
        // переводим в транслит
        $str = $this->rus2translit($str);
        // в нижний регистр
        $str = strtolower($str);
        // заменям все ненужное нам на "-"
        $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
        // удаляем начальные и конечные '-'
        $str = trim($str, "-");
        return $str;
    }




    public function importFiltersFromSCV(){
        $this->db->query("TRUNCATE TABLE " . DB_PREFIX . "product_attribute_custom");
        $lines = file(DIR_UPLOAD . 'product_filters.csv');
        foreach ($lines as $key => $line) {
            $data = str_getcsv($line, "\n");
            foreach ($data as &$row) {
                $row = mb_convert_encoding($row, "UTF-8", "Windows-1251");
                $row = str_getcsv($row, ";");
            }
            $lines[$key] = $data;
        }
        unset($lines[0]);
        foreach ($lines as $key => $item){
            $lines[$key] = $item[0];
        }
        foreach ($lines as $key => $item){
            if(count($item) == 1){
                unset($lines[$key]);
            }
        }

        $array_of_products = [];
        foreach ($lines as $key => &$item){
            $query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product WHERE sku='" . $item[0] . "'");
            $product_id = $query->row['product_id'];
            unset($item[0]);
            $item = array_values($item);
            $array_of_products[$product_id] = $item;
        }
        print_r("Всего продуктов: " . count($array_of_products));

        foreach ($array_of_products as $key => &$product){

            $attribute_ar = [];

            foreach ($product as $attribute){

                $query = $this->db->query("SELECT attribute_id, name FROM " . DB_PREFIX . "attribute_description WHERE name = '" . $this->db->escape($attribute) . "'");
                if(!empty($query->row)){
                    $attribute_ar[] = $query->row;
                }
            }

            $array_of_products[$key] = $attribute_ar;


        }

        foreach ($array_of_products as $key => $item){
            foreach ($item as $attr){
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute_custom  SET product_id='" . $key . "', attribute_id='" . $attr['attribute_id'] . "', attribute_name='" . $attr['name'] . "'");
            }
        }
        echo 'done';
    }



    public function importProductParametrsToShowinRubricsFromSCV(){
        $this->db->query("TRUNCATE TABLE " . DB_PREFIX . "product_show_rubrics");
        $lines = file(DIR_UPLOAD . 'ProductParametersToShowInRubrics.csv');
        foreach ($lines as $key => $line) {
            $data = str_getcsv($line, "\n");
            foreach ($data as &$row) {
                $row = mb_convert_encoding($row, "UTF-8", "Windows-1251");
                $row = str_getcsv($row, ";");
            }
            $lines[$key] = $data;
        }
        unset($lines[0]);
        foreach ($lines as $key => $item){
            $lines[$key] = $item[0];
        }
        foreach ($lines as $key => $item){
            if(count($item) == 1){
                unset($lines[$key]);
            }
        }

        $array_of_products = [];
        foreach ($lines as $key => &$item){
            $query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product WHERE sku='" . $item[0] . "'");
            $product_id = $query->row['product_id'];
            unset($item[0]);
            $item = array_values($item);
            $array_of_products[$product_id] = $item;
        }
        print_r("Всего продуктов: " . count($array_of_products));

        foreach ($array_of_products as $key => &$product){

            $attribute_ar = [];

            foreach ($product as $attribute){

                $query = $this->db->query("SELECT attribute_id, name FROM " . DB_PREFIX . "attribute_description WHERE name = '" . $this->db->escape($attribute) . "'");
                if(!empty($query->row)){
                    $attribute_ar[] = $query->row;
                }
            }

            $array_of_products[$key] = $attribute_ar;


        }

        foreach ($array_of_products as $key => $item){
            foreach ($item as $attr){
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_show_rubrics  SET product_id='" . $key . "', attribute_id='" . $attr['attribute_id'] . "', attribute_name='" . $attr['name'] . "'");
            }
        }
        echo 'done';
    }


    public function addAttributeFilters(){
        $this->load->model('catalog/product');

        $products = $this->model_catalog_product->getAllProductAttributes();
        foreach ($products as $product){
            $attribute = $this->model_catalog_product->getAttribute($product['attribute_id']);

            $check_filter_group = $this->model_catalog_product->checkFilterGroup($attribute['name']);
            if(empty($check_filter_group)){
                $data['sort_order'] = 0;
                $data['name'] = $attribute['name'];
                $filter_group_id = $this->model_catalog_product->addFilterGroup($data);
            }else{
                $filter_group_id = $check_filter_group['filter_group_id'];
            }

            $check_filter = $this->model_catalog_product->checkFilter($product['text'], $filter_group_id);
            if(empty($check_filter)){
                $data['sort_order'] = 0;
                $data['filter_group_id'] = $filter_group_id;
                $data['name'] = $product['text'];
                $filter_id = $this->model_catalog_product->addFilter($data);
            }else{
                $filter_id = $check_filter['filter_id'];
            }

            $check_product_filter = $this->model_catalog_product->checkProductFilter($product['product_id'], $filter_id);
            if(empty($check_product_filter)){
                $this->model_catalog_product->addProductFilter($product['product_id'], $filter_id);
            }
            $categories = $this->model_catalog_product->getProductCategories($product['product_id']);
            foreach ($categories as $category){
                $this->model_catalog_product->addCategoryFilter($category, $filter_id);
            }
        }
    }
}
