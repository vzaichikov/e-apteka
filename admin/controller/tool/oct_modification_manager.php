<?php
/**************************************************************/
/*	@copyright	OCTemplates 2018.							  */
/*	@support	https://octemplates.net/					  */
/*	@license	LICENSE.txt									  */
/**************************************************************/

libxml_use_internal_errors(true);
class ControllerToolOctModificationManager extends Controller {
	public function index() {
    $data = array();

    $this->load->model('tool/oct_modification_manager');

	  $data = array_merge($data, $this->load->language('tool/oct_modification_manager'));

	  $this->document->setTitle($this->language->get('heading_title'));

	  $this->document->addScript('view/javascript/octemplates/codemirror/lib/codemirror.js');
	  $this->document->addScript('view/javascript/octemplates/codemirror/lib/css.js');
    $this->document->addScript('view/javascript/octemplates/codemirror/mode/xml/xml.js');
    $this->document->addStyle('view/javascript/octemplates/codemirror/lib/codemirror.css');
    $this->document->addStyle('view/javascript/octemplates/codemirror/theme/base16-dark.css');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('tool/oct_modification_manager', 'token=' . $this->session->data['token'], true)
		);

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$this->synchronize_modification();

		$data['modification_authors'] = array();

    $filter_data = array(
      'filter_author_group' => true
    );

		$modification_authors = $this->model_tool_oct_modification_manager->getModifications($filter_data);

		if ($modification_authors) {
		  foreach ($modification_authors as $author) {
        $data['modification_authors'][] = $author['author'];
      }
    }

    $data['php_version'] = phpversion();
    $data['curl_status'] = (extension_loaded('curl')) ? $this->language->get('text_enabled') : $this->language->get('text_disabled');
    $data['ioncube_status'] = (extension_loaded('ionCube Loader')) ? ioncube_loader_version() : $this->language->get('text_disabled');

    $data['authors_system'] = $this->get_authors('system');
    $data['authors_archive'] = $this->get_authors('archive');

		$data['token'] = $this->session->data['token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('tool/oct_modification_manager', $data));
	}

	public function get_php_info() {
    ob_start();
    phpinfo();
    $phpInfo = ob_get_clean();

    $phpInfo = preg_replace('/600(px)?/', '100%', $phpInfo);
    $phpInfo = str_replace('75%', '100%', $phpInfo);
    $phpInfo = preg_replace('/<?([\w]|<|\/|>)*(a:|!DOCTYPE|<html|title|body|img)(.+)?\\n?/', '', $phpInfo);

    echo $phpInfo;
  }

	protected function synchronize_modification() {
	  $this->load->model('extension/modification');
	  $this->load->model('tool/oct_modification_manager');

    $filter_data = array(
      'filter_author' => 'Octemplates',
      'filter_author_group' => false
    );

    $modifications = $this->model_tool_oct_modification_manager->getModifications($filter_data);

		if ($modifications) {
		  foreach ($modifications as $modification) {
		    if ($modification['status'] == '1') {
		      $this->model_extension_modification->disableModification($modification['modification_id']);
        }
      }

      $this->refresh_modification();
    }
  }

	public function get_authors($mod_type) {
	  $authors = array();

	  if ($mod_type == 'system') {
      $files = glob(DIR_SYSTEM . '*.ocmod.xml*');
    } elseif ($mod_type == 'archive') {
      $files = glob(DIR_SYSTEM . 'storage/oct_modification_archive/*.ocmod.xml*');
    }

	  $xmls = array();

    if ($files) {
      foreach ($files as $file) {
        $get_xml_file = explode("/", $file);

        if (file_get_contents($file)) {
          $xmls[] = file_get_contents($file);
        }
      }
    }

    if ($xmls) {
      foreach ($xmls as $xml) {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->loadXml($xml);

        $authors[] = ($dom->getElementsByTagName('author')->length > 0) ? $dom->getElementsByTagName('author')->item(0)->nodeValue : '';
      }

      $sort_order = array();

      foreach ($authors as $key => $value) {
        $sort_order[$key] = $value;
      }

      array_multisort($sort_order, SORT_ASC, $authors);
    }

    $result = array_unique($authors);

    return $result;
  }

	public function history_system() {
	  if (isset($this->request->get['filter_author']) && isset($this->request->get['filter_name'])) {
      $data = array();

      $this->load->model('tool/oct_modification_manager');

      $data = array_merge($data, $this->language->load('tool/oct_modification_manager'));
      $page = (isset($this->request->get['page'])) ? $this->request->get['page'] : 1;
      $admin_limit = $this->config->get('config_limit_admin');

      $files = glob(DIR_SYSTEM . '*.ocmod.xml*');

      $xmls = array();

      if ($files) {
        foreach ($files as $file) {
          $get_xml_file = explode("/", $file);

          if (file_get_contents($file)) {
            $xmls[] = array(
              'file' => file_get_contents($file),
              'filename' => array_pop($get_xml_file),
              'date_modified' => date("d-m-Y H:i:s", filemtime($file))
            );
          }
        }
      }

      $data['modifications'] = array();

      if ($xmls) {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;

        foreach ($xmls as $xml) {
          $dom->loadXml($xml['file']);

          $author = ($dom->getElementsByTagName('author')->length > 0) ? $dom->getElementsByTagName('author')->item(0)->nodeValue : '';
          $name = ($dom->getElementsByTagName('name')->length > 0) ? $dom->getElementsByTagName('name')->item(0)->nodeValue : '';

          if (($this->request->get['filter_author'] == $author || $this->request->get['filter_author'] == '-all-') && (!empty($this->request->get['filter_name']) && (stristr($name, $this->request->get['filter_name'])) || $this->request->get['filter_name'] == '')) {
            $code = ($dom->getElementsByTagName('code')->length > 0) ? $dom->getElementsByTagName('code')->item(0)->nodeValue : '';
            $check_modification = $this->model_tool_oct_modification_manager->getTotalModificationByCode($code);

            $data['modifications'][] = array(
              'filename'        => $xml['filename'],
              'name'            => $name,
              'author'          => $author,
              'version'         => ($dom->getElementsByTagName('version')->length > 0) ? $dom->getElementsByTagName('version')->item(0)->nodeValue : '',
              'status_text'     => (!preg_match('/.ocmod.xml_disabled/', $xml['filename'])) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
              'status'          => (!preg_match('/.ocmod.xml_disabled/', $xml['filename'])) ? true : false,
              'doubling'        => ($check_modification > 0) ? $this->language->get('text_exist') : $this->language->get('text_not_exist'),
              'doubling_status' => ($check_modification > 0) ? true : false,
              'link'            => ($dom->getElementsByTagName('link')->length > 0) ? $dom->getElementsByTagName('link')->item(0)->nodeValue : '',
              'date_modified'   => $xml['date_modified']
            );
          }
        }

        $sort_order = array();

				foreach ($data['modifications'] as $key => $value) {
					$sort_order[$key] = $value['name'];
				}

				array_multisort($sort_order, SORT_ASC, $data['modifications']);
      }

      $history_total = count($data['modifications']);

      $data['modifications'] = array_slice($data['modifications'], ($history_total) ? (($page - 1)*$admin_limit) + 0 : 0,((($page - 1)*$admin_limit) > ($history_total - $admin_limit)) ? $history_total : ((($page - 1)*$admin_limit) + $admin_limit));

      $pagination = new Pagination();
      $pagination->total = $history_total;
      $pagination->page = $page;
      $pagination->limit = $admin_limit;
      $pagination->url = $this->url->link('tool/oct_modification_manager/history_system', 'token=' . $this->session->data['token'].'&filter_author='.$this->request->get['filter_author'].'&filter_name='.$this->request->get['filter_name'].'&page={page}', true);

      $data['pagination'] = $pagination->render();

      $data['results'] = sprintf($this->language->get('text_pagination'), ($history_total) ? (($page - 1)*$admin_limit) + 1 : 0, ((($page - 1)*$admin_limit) > ($history_total - $admin_limit)) ? $history_total : ((($page - 1)*$admin_limit) + $admin_limit), $history_total, ceil($history_total/$admin_limit));

      $this->response->setOutput($this->load->view('tool/oct_modification_manager_history_system', $data));
    }
  }

  public function history_installed() {
	  if (isset($this->request->get['filter_author']) && isset($this->request->get['filter_name'])) {
      $data = array();

      $this->load->model('tool/oct_modification_manager');

      $data = array_merge($data, $this->language->load('tool/oct_modification_manager'));
      $page = (isset($this->request->get['page'])) ? $this->request->get['page'] : 1;
      $admin_limit = $this->config->get('config_limit_admin');

      $data['modifications'] = array();

      $filter_data = array(
        'filter_author' => $this->request->get['filter_author'],
        'filter_name' => $this->request->get['filter_name'],
        'filter_author_group' => false,
        'sort'  => 'name',
        'order' => 'ASC',
        'start' => ($page - 1) * $admin_limit,
        'limit' => $admin_limit
      );

      $modification_total = $this->model_tool_oct_modification_manager->getTotalModifications();

      $results = $this->model_tool_oct_modification_manager->getModifications($filter_data);

      foreach ($results as $result) {
        $data['modifications'][] = array(
          'modification_id' => $result['modification_id'],
          'name'            => $result['name'],
          'author'          => $result['author'],
          'version'         => $result['version'],
          'status_text'     => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
          'status'          => ($result['status']) ? true : false,
          'date_added'      => date("d-m-Y H:i:s", strtotime($result['date_added'])),
          'link'            => $result['link']
        );
      }

      $pagination = new Pagination();
      $pagination->total = $modification_total;
      $pagination->page = $page;
      $pagination->limit = $admin_limit;
      $pagination->url = $this->url->link('tool/oct_modification_manager/history_installed', 'token=' . $this->session->data['token'].'&filter_author='.$this->request->get['filter_author'].'&filter_name='.$this->request->get['filter_name'].'&page={page}', true);

      $data['pagination'] = $pagination->render();

      $data['results'] = sprintf($this->language->get('text_pagination'), ($modification_total) ? (($page - 1) * $admin_limit) + 1 : 0, ((($page - 1) * $admin_limit) > ($modification_total - $admin_limit)) ? $modification_total : ((($page - 1) * $admin_limit) + $admin_limit), $modification_total, ceil($modification_total / $admin_limit));

      $this->response->setOutput($this->load->view('tool/oct_modification_manager_history_installed', $data));
    }
  }

  public function history_archive() {
	  if (isset($this->request->get['filter_author']) && isset($this->request->get['filter_name'])) {
      $data = array();

      $this->load->model('tool/oct_modification_manager');

      $data = array_merge($data, $this->language->load('tool/oct_modification_manager'));
      $page = (isset($this->request->get['page'])) ? $this->request->get['page'] : 1;
      $admin_limit = $this->config->get('config_limit_admin');

      if (!is_dir(DIR_SYSTEM . 'storage/oct_modification_archive')) {
        mkdir(DIR_SYSTEM . 'storage/oct_modification_archive', 0755, true);
      }

      $files = glob(DIR_SYSTEM . 'storage/oct_modification_archive/*.ocmod.xml*');

      $xmls = array();

      if ($files) {
        foreach ($files as $file) {
          $get_xml_file = explode("/", $file);

          if (file_get_contents($file)) {
            $xmls[] = array(
              'file' => file_get_contents($file),
              'filename' => array_pop($get_xml_file),
              'date_modified' => date("d-m-Y H:i:s", filemtime($file))
            );
          }
        }
      }

      $data['modifications'] = array();

      if ($xmls) {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;

        foreach ($xmls as $xml) {
          $dom->loadXml($xml['file']);

          $author = ($dom->getElementsByTagName('author')->length > 0) ? $dom->getElementsByTagName('author')->item(0)->nodeValue : '';
          $name = ($dom->getElementsByTagName('name')->length > 0) ? $dom->getElementsByTagName('name')->item(0)->nodeValue : '';

          if (($this->request->get['filter_author'] == $author || $this->request->get['filter_author'] == '-all-') && (!empty($this->request->get['filter_name']) && (stristr($name, $this->request->get['filter_name'])) || $this->request->get['filter_name'] == '')) {

            $data['modifications'][] = array(
              'filename'        => $xml['filename'],
              'name'            => $name,
              'author'          => $author,
              'version'         => ($dom->getElementsByTagName('version')->length > 0) ? $dom->getElementsByTagName('version')->item(0)->nodeValue : '',
              'link'            => ($dom->getElementsByTagName('link')->length > 0) ? $dom->getElementsByTagName('link')->item(0)->nodeValue : '',
              'date_modified'   => $xml['date_modified']
            );
          }
        }

        $sort_order = array();

				foreach ($data['modifications'] as $key => $value) {
					$sort_order[$key] = $value['name'];
				}

				array_multisort($sort_order, SORT_ASC, $data['modifications']);
      }

      $history_total = count($data['modifications']);

      $data['modifications'] = array_slice($data['modifications'], ($history_total) ? (($page - 1)*$admin_limit) + 0 : 0,((($page - 1)*$admin_limit) > ($history_total - $admin_limit)) ? $history_total : ((($page - 1)*$admin_limit) + $admin_limit));

      $pagination = new Pagination();
      $pagination->total = $history_total;
      $pagination->page = $page;
      $pagination->limit = $admin_limit;
      $pagination->url = $this->url->link('tool/oct_modification_manager/history_archive', 'token=' . $this->session->data['token'].'&filter_author='.$this->request->get['filter_author'].'&filter_name='.$this->request->get['filter_name'].'&page={page}', true);

      $data['pagination'] = $pagination->render();

      $data['results'] = sprintf($this->language->get('text_pagination'), ($history_total) ? (($page - 1)*$admin_limit) + 1 : 0, ((($page - 1)*$admin_limit) > ($history_total - $admin_limit)) ? $history_total : ((($page - 1)*$admin_limit) + $admin_limit), $history_total, ceil($history_total/$admin_limit));

      $this->response->setOutput($this->load->view('tool/oct_modification_manager_history_archive', $data));
    }
  }

  public function change_status() {
    $json = array();

    $this->language->load('tool/oct_modification_manager');

    $this->load->model('extension/modification');

    if (!$this->user->hasPermission('modify', 'tool/oct_modification_manager')) {
      $json['error'] = $this->language->get('error_permission');
    } else {
      if (isset($this->request->request['action_type']) && isset($this->request->request['modification']) && isset($this->request->request['mod_type'])) {
        if ($this->request->request['mod_type'] == 'system') {
          if ($this->request->request['action_type'] == 'disable') {
            rename(DIR_SYSTEM.$this->request->request['modification'], DIR_SYSTEM.$this->request->request['modification'].'_disabled');

            $json['success'] = $this->language->get('success_disabled');

            $this->refresh_modification();
          } elseif ($this->request->request['action_type'] == 'enable') {
            $file = str_replace('.ocmod.xml_disabled', '.ocmod.xml', $this->request->request['modification']);
            rename(DIR_SYSTEM.$this->request->request['modification'], DIR_SYSTEM.$file);

            $json['success'] = $this->language->get('success_enabled');

            $this->refresh_modification();
          }
        } elseif($this->request->request['mod_type'] == 'installed') {
          if ($this->request->request['action_type'] == 'disable') {
            $this->model_extension_modification->disableModification($this->request->get['modification']);

            $json['success'] = $this->language->get('success_disabled');

            $this->refresh_modification();
          } elseif ($this->request->request['action_type'] == 'enable') {
            $this->model_extension_modification->enableModification($this->request->get['modification']);

            $json['success'] = $this->language->get('success_enabled');

            $this->refresh_modification();
          }
        }
      }
    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

  public function delete_selected() {
    $json = array();

    $this->language->load('tool/oct_modification_manager');

    $this->load->model('extension/modification');

    if (!$this->user->hasPermission('modify', 'tool/oct_modification_manager')) {
      $json['error'] = $this->language->get('error_permission');
    } else {
      if (isset($this->request->request['modification']) && isset($this->request->request['mod_type'])) {
        if ($this->request->request['mod_type'] == 'system') {
          $file = DIR_SYSTEM.$this->request->request['modification'];

          $this->archive_selected($this->request->request['modification'], 'system');

          if (is_file($file) && file_exists($file)) {
            unlink($file);
          }

          $json['success'] = $this->language->get('success_delete');

          $this->refresh_modification();
        } elseif ($this->request->request['mod_type'] == 'archive') {
          $file = DIR_SYSTEM.'storage/oct_modification_archive/'.$this->request->request['modification'];

          if (is_file($file) && file_exists($file)) {
            unlink($file);
          }

          $json['success'] = $this->language->get('success_delete');

          $this->refresh_modification();
        } elseif($this->request->request['mod_type'] == 'installed') {
          $this->archive_selected($this->request->request['modification'], 'installed');

          $this->model_extension_modification->deleteModification($this->request->request['modification']);

          $json['success'] = $this->language->get('success_delete');

          $this->refresh_modification();
        }
      }
    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

  public function delete_all_selected() {
    $json = array();

    $this->language->load('tool/oct_modification_manager');

    $this->load->model('extension/modification');

    if (!$this->user->hasPermission('modify', 'tool/oct_modification_manager')) {
      $json['error'] = $this->language->get('error_permission');
    } else {
      if (isset($this->request->request['selected']) && isset($this->request->request['mod_type'])) {
        if ($this->request->request['mod_type'] == 'system') {
          foreach ($this->request->request['selected'] as $modification) {
            $file = DIR_SYSTEM.$modification;

            $this->archive_selected($modification, 'system');

            if (is_file($file) && file_exists($file)) {
              unlink($file);
            }
          }

          $json['success'] = $this->language->get('success_delete');

          $this->refresh_modification();
        } elseif ($this->request->request['mod_type'] == 'archive') {
          foreach ($this->request->request['selected'] as $modification) {
            $file = DIR_SYSTEM.'storage/oct_modification_archive/'.$modification;

            if (is_file($file) && file_exists($file)) {
              unlink($file);
            }
          }

          $json['success'] = $this->language->get('success_delete');

          $this->refresh_modification();
        } elseif($this->request->request['mod_type'] == 'installed') {
          foreach ($this->request->request['selected'] as $modification) {
            $this->archive_selected($modification, 'installed');

            $this->model_extension_modification->deleteModification($modification);
          }

          $json['success'] = $this->language->get('success_delete');

          $this->refresh_modification();
        }
      } else {
        $json['error'] = $this->language->get('error_delete_selected');
      }
    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

  public function archive_selected($modification = '', $mod_type = '') {
    $json = array();

    $this->language->load('tool/oct_modification_manager');

    $this->load->model('extension/modification');
    $this->load->model('tool/oct_modification_manager');

    if (!$this->user->hasPermission('modify', 'tool/oct_modification_manager')) {
      $json['error'] = $this->language->get('error_permission');
    } else {
      if (!empty($modification) && !empty($mod_type)) {
        if ($mod_type == 'system') {

          $file = $file_changed = $modification;
          $copy_from = DIR_SYSTEM;
          $copy_to = DIR_SYSTEM . 'storage/oct_modification_archive/';

          $i = 0;

          while(file_exists($copy_to.$file_changed)) {
            $file_changed = ($i++).'_'.$modification;
          }

          copy($copy_from.$file, $copy_to.str_replace('.ocmod.xml_disabled', '.ocmod.xml', $file_changed));

          # можно удалять оригинал после архивирования, для этого раскомментируйте код ниже
          //if (is_file(DIR_SYSTEM.$file) && file_exists(DIR_SYSTEM.$file)) {
          //  unlink(DIR_SYSTEM.$file);
          //}

          $json['success'] = $this->language->get('success_archive');

          $this->refresh_modification();
        } elseif($mod_type == 'installed') {
          $modification_info = $this->model_tool_oct_modification_manager->getModification($modification);

          if ($modification_info) {
            $file_changed = $modification_info['code'].'.ocmod.xml';
            $copy_to = DIR_SYSTEM . 'storage/oct_modification_archive/';

            $i = 0;

            while(file_exists($copy_to.$file_changed)) {
              $file_changed = ($i++).'_'.$modification_info['code'].'.ocmod.xml';
            }

            file_put_contents($copy_to.$file_changed, $modification_info['xml']);

            # можно удалять оригинал после архивирования, для этого раскомментируйте код ниже
            //$this->model_extension_modification->deleteModification($modification);

            $json['success'] = $this->language->get('success_archive');

            $this->refresh_modification();
          }
        }
      } elseif (isset($this->request->request['modification']) && isset($this->request->request['mod_type'])) {
        if ($this->request->request['mod_type'] == 'system') {

          $file = $file_changed = $this->request->request['modification'];
          $copy_from = DIR_SYSTEM;
          $copy_to = DIR_SYSTEM . 'storage/oct_modification_archive/';

          $i = 0;

          while(file_exists($copy_to.$file_changed)) {
            $file_changed = ($i++).'_'.$this->request->request['modification'];
          }

          copy($copy_from.$file, $copy_to.str_replace('.ocmod.xml_disabled', '.ocmod.xml', $file_changed));

          # можно удалять оригинал после архивирования, для этого раскомментируйте код ниже
          //if (is_file(DIR_SYSTEM.$file) && file_exists(DIR_SYSTEM.$file)) {
          //  unlink(DIR_SYSTEM.$file);
          //}

          $json['success'] = $this->language->get('success_archive');

          $this->refresh_modification();
        } elseif($this->request->request['mod_type'] == 'installed') {
          $modification_info = $this->model_tool_oct_modification_manager->getModification($this->request->request['modification']);

          if ($modification_info) {
            $file_changed = $modification_info['code'].'.ocmod.xml';
            $copy_to = DIR_SYSTEM . 'storage/oct_modification_archive/';

            $i = 0;

            while(file_exists($copy_to.$file_changed)) {
              $file_changed = ($i++).'_'.$modification_info['code'].'.ocmod.xml';
            }

            file_put_contents($copy_to.$file_changed, $modification_info['xml']);

            # можно удалять оригинал после архивирования, для этого раскомментируйте код ниже
            //$this->model_extension_modification->deleteModification($this->request->request['modification']);

            $json['success'] = $this->language->get('success_archive');

            $this->refresh_modification();
          }
        }
      }
    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

  public function unarchive_selected() {
    $json = array();

    $this->language->load('tool/oct_modification_manager');

    $this->load->model('extension/modification');
    $this->load->model('tool/oct_modification_manager');

    if (!$this->user->hasPermission('modify', 'tool/oct_modification_manager')) {
      $json['error'] = $this->language->get('error_permission');
    } else {
      if (isset($this->request->request['modification']) && isset($this->request->request['mod_type'])) {
        if ($this->request->request['mod_type'] == 'system') {
          $file = $this->request->request['modification'];
          $copy_from = DIR_SYSTEM . 'storage/oct_modification_archive/';
          $copy_to = DIR_SYSTEM;

          if (file_exists(DIR_SYSTEM.$file)) {
            $json['error'] = $this->language->get('error_modification_exist_system');
          }

          if (!isset($json['error'])) {
            copy($copy_from.$file, $copy_to.$file.'_disabled');

            # можно удалять архивный файл после архивирования, для этого раскомментируйте код ниже
            //if (is_file(DIR_SYSTEM. 'storage/oct_modification_archive/'.$file) && file_exists(DIR_SYSTEM. 'storage/oct_modification_archive/'.$file)) {
            //  unlink(DIR_SYSTEM. 'storage/oct_modification_archive/'.$file);
            //}

            $json['success'] = $this->language->get('success_unarchive');

            $this->refresh_modification();
          }
        } elseif ($this->request->request['mod_type'] == 'installed') {
          $file_code = file_get_contents(DIR_SYSTEM . 'storage/oct_modification_archive/'.$this->request->request['modification']);
          $dom = new DOMDocument('1.0', 'UTF-8');
          $dom->loadXml(html_entity_decode($file_code));

          if ($this->request->request['mod_type'] == 'installed' && $this->model_tool_oct_modification_manager->getTotalModificationByCode(($dom->getElementsByTagName('code')->length > 0) ? $dom->getElementsByTagName('code')->item(0)->nodeValue : '') > 0) {
            $json['error'] = $this->language->get('error_modification_exist_installed');
          }

          if (!isset($json['error'])) {
            $filter_data = array(
              'code'    => ($dom->getElementsByTagName('code')->length > 0) ? $dom->getElementsByTagName('code')->item(0)->nodeValue : '',
              'name'    => ($dom->getElementsByTagName('name')->length > 0) ? $dom->getElementsByTagName('name')->item(0)->nodeValue : '',
              'version' => ($dom->getElementsByTagName('version')->length > 0) ? $dom->getElementsByTagName('version')->item(0)->nodeValue : '',
              'author'  => ($dom->getElementsByTagName('author')->length > 0) ? $dom->getElementsByTagName('author')->item(0)->nodeValue : '',
              'link'    => ($dom->getElementsByTagName('link')->length > 0) ? $dom->getElementsByTagName('link')->item(0)->nodeValue : '',
              'status'  => 0,
              'xml'     => html_entity_decode(htmlentities($file_code))
            );

            $this->model_tool_oct_modification_manager->addModification($filter_data);

            # можно удалять архивный файл после архивирования, для этого раскомментируйте код ниже
            //if (is_file(DIR_SYSTEM. 'storage/oct_modification_archive/'.DIR_SYSTEM . 'storage/oct_modification_archive/'.$this->request->request['modification']) && file_exists(DIR_SYSTEM. 'storage/oct_modification_archive/'.DIR_SYSTEM . 'storage/oct_modification_archive/'.$this->request->request['modification'])) {
            //  unlink(DIR_SYSTEM. 'storage/oct_modification_archive/'.DIR_SYSTEM . 'storage/oct_modification_archive/'.$this->request->request['modification']);
            //}

            $json['success'] = $this->language->get('success_unarchive');

            $this->refresh_modification();
          }
        }
      }
    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

  public function modification_info() {
	  $data = array();

	  $this->load->model('tool/oct_modification_manager');

	  $data = array_merge($data, $this->language->load('tool/oct_modification_manager'));

	  if (isset($this->request->get['modification']) && isset($this->request->get['mod_type'])) {
      $data['modification'] = $this->request->get['modification'];
      $data['mod_type'] = $this->request->get['mod_type'];

      if ($this->request->get['mod_type'] == 'system') {
        $data['xml'] = (is_file(DIR_SYSTEM.$this->request->get['modification'])) ? htmlentities(file_get_contents(DIR_SYSTEM.$this->request->get['modification'])) : $this->language->get('error_failed_load_file');
      } elseif ($this->request->get['mod_type'] == 'archive') {
        $data['xml'] = (is_file( DIR_SYSTEM . 'storage/oct_modification_archive/'.$this->request->get['modification'])) ? htmlentities(file_get_contents( DIR_SYSTEM . 'storage/oct_modification_archive/'.$this->request->get['modification'])) : $this->language->get('error_failed_load_file');
      } elseif ($this->request->get['mod_type'] == 'installed') {
        $modification_info = $this->model_tool_oct_modification_manager->getModification($this->request->get['modification']);

        if ($modification_info) {
          $data['xml'] = htmlentities($modification_info['xml']);
        } else {
          $data['xml'] = '';
        }
      }
    } else {
      $data['modification'] = $data['xml'] = $data['mod_type'] = '';
    }

    $this->response->setOutput($this->load->view('tool/oct_modification_manager_info', $data));
  }

  public function edite_selected() {
    $json = array();

    $this->language->load('tool/oct_modification_manager');

    $this->load->model('tool/oct_modification_manager');

    if (!$this->user->hasPermission('modify', 'tool/oct_modification_manager')) {
      $json['error'] = $this->language->get('error_permission');
    } else {
      if (isset($this->request->post['code']) && isset($this->request->post['modification']) && isset($this->request->post['mod_type'])) {

        if (($this->request->post['mod_type'] == 'system' || $this->request->post['mod_type'] == 'archive') && empty($this->request->post['modification'])) {
          $json['error'] = $this->language->get('error_modification_name');
        }

        if (($this->request->post['mod_type'] == 'system' || $this->request->post['mod_type'] == 'archive' || $this->request->post['mod_type'] == 'installed') && empty($this->request->post['code'])) {
          $json['error'] = $this->language->get('error_modification_code');
        }

        if ($this->request->post['mod_type'] == 'system' && (file_exists(DIR_SYSTEM.$this->request->post['modification'].'.ocmod.xml') || file_exists(DIR_SYSTEM.$this->request->post['modification'].'.ocmod.xml_disabled'))) {
          $json['error'] = $this->language->get('error_modification_exist_system');
        }

        if ($this->request->post['mod_type'] == 'archive' && file_exists(DIR_SYSTEM.'storage/oct_modification_archive/'.$this->request->post['modification'].'.ocmod.xml')) {
          $json['error'] = $this->language->get('error_modification_exist_archive');
        }

        if (($this->request->post['mod_type'] == 'system' || $this->request->post['mod_type'] == 'archive' || $this->request->post['mod_type'] == 'installed') && !empty($this->request->post['code'])) {
          $dom = new DOMDocument('1.0', 'UTF-8');
          $dom->loadXml(html_entity_decode($this->request->post['code']));

          if ($dom->getElementsByTagName('code')->length <= 0 || $dom->getElementsByTagName('name')->length <= 0) {
            $json['error'] = $this->language->get('error_modification_structure');
          }
        }

        if (!isset($json['error'])) {
          if ($this->request->post['mod_type'] == 'system') {
            if (is_file(DIR_SYSTEM.$this->request->post['modification'])) {

              file_put_contents(DIR_SYSTEM.$this->request->post['modification'], html_entity_decode($this->request->post['code']));

              $json['success'] = $this->language->get('success_edite');

              $this->refresh_modification();
            }
          } elseif ($this->request->post['mod_type'] == 'archive') {
            if (is_file(DIR_SYSTEM.'storage/oct_modification_archive/'.$this->request->post['modification'])) {

              file_put_contents(DIR_SYSTEM.'storage/oct_modification_archive/'.$this->request->post['modification'], html_entity_decode($this->request->post['code']));

              $json['success'] = $this->language->get('success_edite');

              $this->refresh_modification();
            }
          } elseif ($this->request->post['mod_type'] == 'installed') {
            $modification_info = $this->model_tool_oct_modification_manager->getModification($this->request->post['modification']);

            if ($modification_info) {
              $dom = new DOMDocument('1.0', 'UTF-8');
              $dom->loadXml(html_entity_decode($this->request->post['code']));

              $filter_data = array(
                'name'    => ($dom->getElementsByTagName('name')->length > 0) ? $dom->getElementsByTagName('name')->item(0)->nodeValue : '',
                'code'    => ($dom->getElementsByTagName('code')->length > 0) ? $dom->getElementsByTagName('code')->item(0)->nodeValue : '',
                'author'  => ($dom->getElementsByTagName('author')->length > 0) ? $dom->getElementsByTagName('author')->item(0)->nodeValue : '',
                'version' => ($dom->getElementsByTagName('version')->length > 0) ? $dom->getElementsByTagName('version')->item(0)->nodeValue : '',
                'link'    => ($dom->getElementsByTagName('link')->length > 0) ? $dom->getElementsByTagName('link')->item(0)->nodeValue : '',
                'xml'     => html_entity_decode($this->request->post['code'])
              );

              $this->model_tool_oct_modification_manager->editModification($this->request->post['modification'], $filter_data);

              $json['success'] = $this->language->get('success_edite');

              $this->refresh_modification();
            }
          }
        }
      }
    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

  public function add_modification_index() {
    $data = array();

	  $this->load->model('tool/oct_modification_manager');

	  $data = array_merge($data, $this->language->load('tool/oct_modification_manager'));

	  $data['token'] = $this->session->data['token'];

    $this->response->setOutput($this->load->view('tool/oct_modification_manager_add', $data));
  }

  public function add_modification_action() {
    $json = array();

    $this->language->load('tool/oct_modification_manager');

    $this->load->model('tool/oct_modification_manager');

    if (!$this->user->hasPermission('modify', 'tool/oct_modification_manager')) {
      $json['error'] = $this->language->get('error_permission');
    } else {
      if (isset($this->request->request['code']) && isset($this->request->request['modification']) && isset($this->request->request['mod_type'])) {

        if (($this->request->request['mod_type'] == 'system' || $this->request->request['mod_type'] == 'archive') && empty($this->request->request['modification'])) {
          $json['error'] = $this->language->get('error_modification_name');
        }

        if (($this->request->request['mod_type'] == 'system' || $this->request->request['mod_type'] == 'archive' || $this->request->request['mod_type'] == 'installed') && empty($this->request->request['code'])) {
          $json['error'] = $this->language->get('error_modification_code');
        }

        if ($this->request->request['mod_type'] == 'system' && (file_exists(DIR_SYSTEM.$this->request->request['modification'].'.ocmod.xml') || file_exists(DIR_SYSTEM.$this->request->request['modification'].'.ocmod.xml_disabled'))) {
          $json['error'] = $this->language->get('error_modification_exist_system');
        }

        if ($this->request->request['mod_type'] == 'archive' && file_exists(DIR_SYSTEM.'storage/oct_modification_archive/'.$this->request->request['modification'].'.ocmod.xml')) {
          $json['error'] = $this->language->get('error_modification_exist_system');
        }

        if (($this->request->request['mod_type'] == 'system' || $this->request->request['mod_type'] == 'archive' || $this->request->request['mod_type'] == 'installed') && !empty($this->request->request['code'])) {
          $dom = new DOMDocument('1.0', 'UTF-8');
          $dom->loadXml(html_entity_decode($this->request->request['code']));

          if ($dom->getElementsByTagName('code')->length <= 0 || $dom->getElementsByTagName('name')->length <= 0) {
            $json['error'] = $this->language->get('error_modification_structure');
          }
        }

        if (!isset($json['error'])) {
          if ($this->request->request['mod_type'] == 'system') {

            file_put_contents(DIR_SYSTEM.$this->request->request['modification'].'.ocmod.xml', html_entity_decode($this->request->request['code']));

            $json['success'] = $this->language->get('success_added_system');

            $this->refresh_modification();
          } elseif ($this->request->request['mod_type'] == 'archive') {

            file_put_contents(DIR_SYSTEM.'storage/oct_modification_archive/'.$this->request->request['modification'].'.ocmod.xml', html_entity_decode($this->request->request['code']));

            $json['success'] = $this->language->get('success_added_system');

            $this->refresh_modification();
          } elseif ($this->request->request['mod_type'] == 'installed') {
            $dom = new DOMDocument('1.0', 'UTF-8');
            $dom->loadXml(html_entity_decode($this->request->request['code']));

            if ($this->request->request['mod_type'] == 'installed' && $this->model_tool_oct_modification_manager->getTotalModificationByCode(($dom->getElementsByTagName('code')->length > 0) ? $dom->getElementsByTagName('code')->item(0)->nodeValue : '') > 0) {
              $error = $this->language->get('error_modification_exist_installed');
            }

            if (!isset($error)) {
              $filter_data = array(
                'code'    => ($dom->getElementsByTagName('code')->length > 0) ? $dom->getElementsByTagName('code')->item(0)->nodeValue : '',
                'name'    => ($dom->getElementsByTagName('name')->length > 0) ? $dom->getElementsByTagName('name')->item(0)->nodeValue : '',
                'version' => ($dom->getElementsByTagName('version')->length > 0) ? $dom->getElementsByTagName('version')->item(0)->nodeValue : '',
                'author'  => ($dom->getElementsByTagName('author')->length > 0) ? $dom->getElementsByTagName('author')->item(0)->nodeValue : '',
                'link'    => ($dom->getElementsByTagName('link')->length > 0) ? $dom->getElementsByTagName('link')->item(0)->nodeValue : '',
                'status'  => 1,
                'xml'     => html_entity_decode($this->request->request['code'])
              );

              $this->model_tool_oct_modification_manager->addModification($filter_data);

              $json['success'] = $this->language->get('success_added_installed');

              $this->refresh_modification();
            }
          }
        }
      }
    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

  public function refresh_mod() {
    $json = array();

    $this->language->load('tool/oct_modification_manager');

    if (!$this->user->hasPermission('modify', 'tool/oct_modification_manager')) {
      $json['error'] = $this->language->get('error_permission');
    } else {
      $this->refresh_modification();
      $json['success'] = $this->language->get('success_refresh');
    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

  public function removeDir($dir) {
    if (is_dir($dir)) {
      $objects = scandir($dir);
      foreach ($objects as $object) {
        if ($object != "." && $object != "..") {
          if (filetype($dir."/".$object) == "dir"){
            $this->removeDir($dir."/".$object);
          } else{
            unlink($dir."/".$object);
          }
        }
      }

      reset($objects);
      rmdir($dir);
    }
  }

  public function refresh_system_cache() {
    $json = array();

    $this->language->load('tool/oct_modification_manager');

    if (!$this->user->hasPermission('modify', 'tool/oct_modification_manager')) {
      $json['error'] = $this->language->get('error_permission');
    } else {
      $files1 = glob(DIR_CACHE.'*');

      $files = array_merge($files1);

      foreach ($files as $file) {
        if (is_dir($file) && is_readable($file)) {
          $this->removeDir($file);
        }

        if (is_file($file) && is_readable($file)) {
          unlink($file);
        }
      }

      $json['success'] = $this->language->get('success_refresh_system_cache');
    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

  public function refresh_image_cache() {
    $json = array();

    $this->language->load('tool/oct_modification_manager');

    if (!$this->user->hasPermission('modify', 'tool/oct_modification_manager')) {
      $json['error'] = $this->language->get('error_permission');
    } else {
			$files1 = glob(DIR_IMAGE . 'cache/*');
			$files2 = glob(DIR_IMAGE . 'cache/catalog');
			$files3 = glob(DIR_IMAGE . 'cache/data');

      $files = array_merge($files1,$files2,$files3);

      foreach ($files as $file) {
        if (is_dir($file) && is_readable($file)) {
          $this->removeDir($file);
        }

        if (is_file($file) && is_readable($file)) {
          unlink($file);
        }
      }

      $json['success'] = $this->language->get('success_refresh_image_cache');
    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

  public function clear_mod() {
    $json = array();

    $this->language->load('tool/oct_modification_manager');

    if (!$this->user->hasPermission('modify', 'tool/oct_modification_manager')) {
      $json['error'] = $this->language->get('error_permission');
    } else {
      $this->clear_modification();
      $json['success'] = $this->language->get('success_clear');
    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

  public function refresh_modification() {
		$this->load->model('extension/modification');

		if ($this->user->hasPermission('modify', 'tool/oct_modification_manager')) {
			$log = array();

			$files = array();

			$path = array(DIR_MODIFICATION . '*');

			while (count($path) != 0) {
				$next = array_shift($path);

				foreach (glob($next) as $file) {
					if (is_dir($file)) {
						$path[] = $file . '/*';
					}

					$files[] = $file;
				}
			}

			rsort($files);

			foreach ($files as $file) {
				if ($file != DIR_MODIFICATION . 'index.html') {
					if (is_file($file)) {
						unlink($file);
					} elseif (is_dir($file)) {
						rmdir($file);
					}
				}
			}

			$xml = array();

			$xml[] = file_get_contents(DIR_SYSTEM . 'modification.xml');

			$files = glob(DIR_SYSTEM . '*.ocmod.xml');

			if ($files) {
				foreach ($files as $file) {
					$xml[] = file_get_contents($file);
				}
			}

			$results = $this->model_extension_modification->getModifications(array('sort'=>'date_added', 'order'=>'ASC'));

			foreach ($results as $result) {
				if ($result['status']) {
					$xml[] = $result['xml'];
				}
			}

			$modification = array();

			foreach ($xml as $xml) {
				if (empty($xml)){
					continue;
				}

				$dom = new DOMDocument('1.0', 'UTF-8');
				$dom->preserveWhiteSpace = false;
				$dom->loadXml($xml);

				$log[] = 'MOD: ' . $dom->getElementsByTagName('name')->item(0)->textContent;

				$recovery = array();

				if (isset($modification)) {
					$recovery = $modification;
				}

				$files = $dom->getElementsByTagName('modification')->item(0)->getElementsByTagName('file');

				foreach ($files as $file) {
					$operations = $file->getElementsByTagName('operation');

					$files = explode('|', $file->getAttribute('path'));

					foreach ($files as $file) {
						$path = '';

						if ((substr($file, 0, 7) == 'catalog')) {
							$path = DIR_CATALOG . substr($file, 8);
						}

						if ((substr($file, 0, 5) == 'admin')) {
							$path = DIR_APPLICATION . substr($file, 6);
						}

						if ((substr($file, 0, 6) == 'system')) {
							$path = DIR_SYSTEM . substr($file, 7);
						}

						if ($path) {
							$files = glob($path, GLOB_BRACE);

							if ($files) {
								foreach ($files as $file) {
									if (substr($file, 0, strlen(DIR_CATALOG)) == DIR_CATALOG) {
										$key = 'catalog/' . substr($file, strlen(DIR_CATALOG));
									}

									if (substr($file, 0, strlen(DIR_APPLICATION)) == DIR_APPLICATION) {
										$key = 'admin/' . substr($file, strlen(DIR_APPLICATION));
									}

									if (substr($file, 0, strlen(DIR_SYSTEM)) == DIR_SYSTEM) {
										$key = 'system/' . substr($file, strlen(DIR_SYSTEM));
									}

									if (!isset($modification[$key])) {
										$content = file_get_contents($file);

										$modification[$key] = preg_replace('~\r?\n~', "\n", $content);
										$original[$key] = preg_replace('~\r?\n~', "\n", $content);

										$log[] = PHP_EOL . 'FILE: ' . $key;
									}

									foreach ($operations as $operation) {
										$error = $operation->getAttribute('error');

										$ignoreif = $operation->getElementsByTagName('ignoreif')->item(0);

										if ($ignoreif) {
											if ($ignoreif->getAttribute('regex') != 'true') {
												if (strpos($modification[$key], $ignoreif->textContent) !== false) {
													continue;
												}
											} else {
												if (preg_match($ignoreif->textContent, $modification[$key])) {
													continue;
												}
											}
										}

										$status = false;

										if ($operation->getElementsByTagName('search')->item(0)->getAttribute('regex') != 'true') {
											$search = $operation->getElementsByTagName('search')->item(0)->textContent;
											$trim = $operation->getElementsByTagName('search')->item(0)->getAttribute('trim');
											$index = $operation->getElementsByTagName('search')->item(0)->getAttribute('index');

											if (!$trim || $trim == 'true') {
												$search = trim($search);
											}

											$add = $operation->getElementsByTagName('add')->item(0)->textContent;
											$trim = $operation->getElementsByTagName('add')->item(0)->getAttribute('trim');
											$position = $operation->getElementsByTagName('add')->item(0)->getAttribute('position');
											$offset = $operation->getElementsByTagName('add')->item(0)->getAttribute('offset');

											if ($offset == '') {
												$offset = 0;
											}

											if ($trim == 'true') {
												$add = trim($add);
											}

											$log[] = 'CODE: ' . $search;

											if ($index !== '') {
												$indexes = explode(',', $index);
											} else {
												$indexes = array();
											}

											$i = 0;

											$lines = explode("\n", $modification[$key]);

											for ($line_id = 0; $line_id < count($lines); $line_id++) {
												$line = $lines[$line_id];

												$match = false;

												if (stripos($line, $search) !== false) {
													if (!$indexes) {
														$match = true;
													} elseif (in_array($i, $indexes)) {
														$match = true;
													}

													$i++;
												}

												if ($match) {
													switch ($position) {
														default:
														case 'replace':
															$new_lines = explode("\n", $add);

															if ($offset < 0) {
																array_splice($lines, $line_id + $offset, abs($offset) + 1, array(str_replace($search, $add, $line)));

																$line_id -= $offset;
															} else {
																array_splice($lines, $line_id, $offset + 1, array(str_replace($search, $add, $line)));
															}

															break;
														case 'before':
															$new_lines = explode("\n", $add);

															array_splice($lines, $line_id - $offset, 0, $new_lines);

															$line_id += count($new_lines);
															break;
														case 'after':
															$new_lines = explode("\n", $add);

															array_splice($lines, ($line_id + 1) + $offset, 0, $new_lines);

															$line_id += count($new_lines);
															break;
													}

													$log[] = 'LINE: ' . $line_id;

													$status = true;
												}
											}

											$modification[$key] = implode("\n", $lines);
										} else {
											$search = trim($operation->getElementsByTagName('search')->item(0)->textContent);
											$limit = $operation->getElementsByTagName('search')->item(0)->getAttribute('limit');
											$replace = trim($operation->getElementsByTagName('add')->item(0)->textContent);

											if (!$limit) {
												$limit = -1;
											}

											$match = array();

											preg_match_all($search, $modification[$key], $match, PREG_OFFSET_CAPTURE);

											if ($limit > 0) {
												$match[0] = array_slice($match[0], 0, $limit);
											}

											if ($match[0]) {
												$log[] = 'REGEX: ' . $search;

												for ($i = 0; $i < count($match[0]); $i++) {
													$log[] = 'LINE: ' . (substr_count(substr($modification[$key], 0, $match[0][$i][1]), "\n") + 1);
												}

												$status = true;
											}

											$modification[$key] = preg_replace($search, $replace, $modification[$key], $limit);
										}

										if (!$status) {
											if ($error == 'abort') {
												$modification = $recovery;

												$log[] = 'NOT FOUND - ABORTING!';
												break 5;
											} elseif ($error == 'skip') {
												$log[] = 'NOT FOUND - OPERATION SKIPPED!';
												continue;
											} else {
												$log[] = 'NOT FOUND - OPERATIONS ABORTED!';
											 	break;
											}
										}
									}
								}
							}
						}
					}
				}

				$log[] = '----------------------------------------------------------------';
			}

			$ocmod = new Log('ocmod.log');
			$ocmod->write(implode("\n", $log));

			foreach ($modification as $key => $value) {
				if ($original[$key] != $value) {
					$path = '';

					$directories = explode('/', dirname($key));

					foreach ($directories as $directory) {
						$path = $path . '/' . $directory;

						if (!is_dir(DIR_MODIFICATION . $path)) {
							@mkdir(DIR_MODIFICATION . $path, 0777);
						}
					}

					$handle = fopen(DIR_MODIFICATION . $key, 'w');

					fwrite($handle, $value);

					fclose($handle);
				}
			}
		}
	}

	public function clear_modification() {
		if ($this->user->hasPermission('modify', 'tool/oct_modification_manager')) {
			$files = array();

			$path = array(DIR_MODIFICATION . '*');

			while (count($path) != 0) {
				$next = array_shift($path);

				foreach (glob($next) as $file) {
					if (is_dir($file)) {
						$path[] = $file . '/*';
					}

					$files[] = $file;
				}
			}

			rsort($files);

			foreach ($files as $file) {
				if ($file != DIR_MODIFICATION . 'index.html') {
					if (is_file($file)) {
						unlink($file);
					} elseif (is_dir($file)) {
						rmdir($file);
					}
				}
			}
		}
	}
}