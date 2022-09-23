<?php
/*
 * @ PHP 5.6
 * @ Decoder version : 1.0.0.1
 * @ Release on : 24.03.2018
 * @ Website    : http://EasyToYou.eu
 */

class ControllerExtensionModuleMetaSeoAnyPage extends Controller
{
    private $error = array();
    public function index()
    {
        $this->load->language("extension/module/metaseo_anypage");
        $this->document->setTitle($this->language->get("heading_title"));
        $this->load->model("setting/setting");
        if ($this->request->server["REQUEST_METHOD"] == "POST" && $this->validate()) {
            $this->model_setting_setting->editSetting("metaseo_anypage", $this->request->post);
            $this->session->data["success"] = $this->language->get("text_success");
            $this->response->redirect($this->url->link("extension/module/metaseo_anypage", "token=" . $this->session->data["token"], true));
        }
        if (isset($this->error["warning"])) {
            $data["error_warning"] = $this->error["warning"];
        } else {
            if (isset($this->session->data["error"])) {
                $data["error_warning"] = $this->session->data["error"];
                unset($this->session->data["error"]);
            } else {
                $data["error_warning"] = "";
            }
        }
        $data["breadcrumbs"] = array();
        $data["breadcrumbs"][] = array("text" => $this->language->get("text_home"), "href" => $this->url->link("common/dashboard", "token=" . $this->session->data["token"], true));
        $data["breadcrumbs"][] = array("text" => $this->language->get("text_module"), "href" => $this->url->link("extension/extension", "type=module&token=" . $this->session->data["token"], true));
        $data["breadcrumbs"][] = array("text" => $this->language->get("text_title"), "href" => $this->url->link("extension/module/metaseo_anypage", "token=" . $this->session->data["token"], true));
        if (isset($this->request->post["metaseo_anypage_routes"])) {
            $data["metaseo_anypage_routes"] = $this->request->post["metaseo_anypage_routes"];
        } else {
            $data["metaseo_anypage_routes"] = (array) $this->config->get("metaseo_anypage_routes");
        }
        if (isset($this->request->post["metaseo_anypage_status"])) {
            $data["metaseo_anypage_status"] = $this->request->post["metaseo_anypage_status"];
        } else {
            $data["metaseo_anypage_status"] = $this->config->get("metaseo_anypage_status");
        }
        $data["action"] = $this->url->link("extension/module/metaseo_anypage", "token=" . $this->session->data["token"], true);
        $data["cancel"] = $this->url->link("extension/extension", "type=module&token=" . $this->session->data["token"], true);
        $data["heading_title"] = $this->language->get("heading_title");
        $data["yes"] = $this->language->get("text_yes");
        $data["no"] = $this->language->get("text_no");
        $data["entry_status"] = $this->language->get("entry_status");
        $data["tab_settings"] = $this->language->get("tab_settings");
        $data["tab_help"] = $this->language->get("tab_help");
        $data["button_save"] = $this->language->get("button_save");
        $data["button_cancel"] = $this->language->get("button_cancel");
        $data["text_edit"] = $this->language->get("text_edit");
        $data["text_support"] = $this->language->get("text_support");
        $this->load->model("localisation/language");
        $languages = $this->model_localisation_language->getLanguages();
        foreach ($languages as $key => $language) {
            $data["languages"][$key] = $language;
            $data["languages"][$key]["image"] = "language/" . $language["code"] . "/" . $language["code"] . ".png";
        }
        $data["header"] = $this->load->controller("common/header");
        $data["column_left"] = $this->load->controller("common/column_left");
        $data["footer"] = $this->load->controller("common/footer");
        $this->response->setOutput($this->load->view("extension/module/metaseo_anypage", $data));
    }
    private function validate()
    {
        if (!$this->user->hasPermission("modify", "extension/module/metaseo_anypage")) {
            $this->error["warning"] = $this->language->get("text_error_access");
        }
        if (!$this->error) {
            return true;
        }
        return false;
    }
    public function install()
    {
        $this->load->model("extension/event");
        $events = $this->getEvents();
        foreach ($events as $code => $value) {
            $this->model_extension_event->deleteEvent($code);
            $this->model_extension_event->addEvent($code, $value["trigger"], $value["action"], 1);
        }
    }
    public function uninstall()
    {
        $this->load->model("extension/event");
        $events = $this->getEvents();
        foreach ($events as $code => $value) {
            $this->model_extension_event->deleteEvent($code);
        }
    }
    private function getEvents()
    {
        $events = array("metaSeoAnyPage" => array("trigger" => "catalog/controller/common/header/before", "action" => "extension/module/metaseo_anypage"));
        return $events;
    }
}

?>