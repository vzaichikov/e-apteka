<?php
/*
 * @ PHP 5.6
 * @ Decoder version : 1.0.0.1
 * @ Release on : 24.03.2018
 * @ Website    : http://EasyToYou.eu
 */

class ControllerLoggerLogger extends Controller
{
    private $error = array();
    public function index()
    {

        $this->load->language("logger/logger");
        $this->document->setTitle($this->language->get("heading_title"));
        $this->load->model("logger/admin");
        $this->getList();
    }
    public function clearlog()
    {
        $this->load->language("logger/logger");
        if (!$this->user->hasPermission("modify", "logger/logger")) {
            $this->load->model("logger/admin");
            $this->error["warning"] = $this->language->get("error_permission");
            $this->getList();
        } else {
            $this->document->setTitle($this->language->get("heading_title"));
            $this->load->model("logger/admin");
            $this->model_logger_admin->clearLogs();
            $this->session->data["success"] = $this->language->get("text_success");
            $redirect_url = $this->url->link("logger/logger");
            $redirect_url .= "&token=" . $this->session->data["token"];
            header("Location: " . $redirect_url);
            $this->getList();
        }
    }
    private function getList()
    {
        if (isset($this->request->get["filter_log_date"])) {
            $filter_log_date = $this->request->get["filter_log_date"];
        } else {
            $filter_log_date = NULL;
        }
        if (isset($this->request->get["filter_log_item"])) {
            $filter_log_item = $this->request->get["filter_log_item"];
        } else {
            $filter_log_item = NULL;
        }
        if (isset($this->request->get["filter_log_action"])) {
            $filter_log_action = $this->request->get["filter_log_action"];
        } else {
            $filter_log_action = NULL;
        }
        if (isset($this->request->get["filter_user_name"])) {
            $filter_user_name = $this->request->get["filter_user_name"];
        } else {
            $filter_user_name = NULL;
        }
        if (isset($this->request->get["filter_ip_address"])) {
            $filter_ip_address = $this->request->get["filter_ip_address"];
        } else {
            $filter_ip_address = NULL;
        }
        if (isset($this->request->get["sort"])) {
            $sort = $this->request->get["sort"];
        } else {
            $sort = "log_date";
        }
        if (isset($this->request->get["order"])) {
            $order = $this->request->get["order"];
        } else {
            $order = "DESC";
        }
        if (isset($this->request->get["page"])) {
            $page = $this->request->get["page"];
        } else {
            $page = 1;
        }
        $url = "";
        if (isset($this->request->get["filter_log_date"])) {
            $url .= "&filter_log_date=" . $this->request->get["filter_log_date"];
        }
        if (isset($this->request->get["filter_log_item"])) {
            $url .= "&filter_log_item=" . urlencode(html_entity_decode($this->request->get["filter_log_item"], ENT_QUOTES, "UTF-8"));
        }
        if (isset($this->request->get["filter_log_action"])) {
            $url .= "&filter_log_action=" . urlencode(html_entity_decode($this->request->get["filter_log_action"], ENT_QUOTES, "UTF-8"));
        }
        if (isset($this->request->get["filter_user_name"])) {
            $url .= "&filter_user_name=" . urlencode(html_entity_decode($this->request->get["filter_user_name"], ENT_QUOTES, "UTF-8"));
        }
        if (isset($this->request->get["filter_ip_address"])) {
            $url .= "&filter_ip_address=" . urlencode(html_entity_decode($this->request->get["filter_ip_address"], ENT_QUOTES, "UTF-8"));
        }
        if (isset($this->request->get["sort"])) {
            $url .= "&sort=" . $this->request->get["sort"];
        }
        if (isset($this->request->get["order"])) {
            $url .= "&order=" . $this->request->get["order"];
        }
        if (isset($this->request->get["page"])) {
            $url .= "&page=" . $this->request->get["page"];
        }
        $data = array("filter_log_date" => $filter_log_date, "filter_log_item" => $filter_log_item, "filter_log_action" => $filter_log_action, "filter_user_name" => $filter_user_name, "filter_ip_address" => $filter_ip_address, "sort" => $sort, "order" => $order, "start" => ($page - 1) * $this->config->get("config_limit_admin"), "limit" => $this->config->get("config_limit_admin"));
        $data["breadcrumbs"] = array();
        $data["breadcrumbs"][] = array("text" => $this->language->get("text_home"), "href" => $this->url->link("common/dashboard", "token=" . $this->session->data["token"], "SSL"));
        $data["breadcrumbs"][] = array("text" => $this->language->get("heading_title"), "href" => $this->url->link("logger/logger", "token=" . $this->session->data["token"] . $url, "SSL"));
        $data["clearlogger"] = $this->url->link("logger/logger/clearlog", "token=" . $this->session->data["token"] . $url, "SSL");
        $data["logs"] = array();
        $data["log_items"] = $this->model_logger_admin->getLogItems();
        $data["log_actions"] = $this->model_logger_admin->getLogActions();
        $data["log_users"] = $this->model_logger_admin->getLogUsers();
        $data["entry_log_id"] = $this->language->get("entry_log_id");
        $data["entry_log_date"] = $this->language->get("entry_log_date");
        $data["entry_log_datea"] = "kkk";
        $data["entry_user_name"] = $this->language->get("entry_user_name");
        $data["entry_ip_address"] = $this->language->get("entry_ip_address");
        $data["entry_log_item"] = $this->language->get("entry_log_item");
        $data["entry_log_action"] = $this->language->get("entry_log_action");
        $data["entry_log_data"] = $this->language->get("entry_log_data");
        $data["button_cancel"] = $this->language->get("button_cancel");
        $data["text_confirm"] = $this->language->get("text_confirm");
        $data["button_edit"] = $this->language->get("button_edit");
        $order_total = $this->model_logger_admin->getTotalLogs($data);
        $results = $this->model_logger_admin->getLogs($data);
        foreach ($results as $result) {
            $action = array();
            $action[] = array("text" => $this->language->get("text_view"), "href" => $this->url->link("logger/logger/view", "token=" . $this->session->data["token"] . "&log_id=" . $result["log_id"], "SSL"));
            $data["logs"][] = array("log_date" => $result["log_date"], "log_item" => $result["log_item"], "log_action" => $result["log_action"], "user_name" => $result["user_name"], "user_name" => $result["user_name"], "ip_address" => $result["ip_address"], "action" => $action);
        }
        $data["heading_title"] = $this->language->get("heading_title") . "<br />For only - lowenet.biz";
        $data["text_list"] = $this->language->get("text_list");
        $data["text_no_results"] = $this->language->get("text_no_results");
        $data["text_missing"] = $this->language->get("text_missing");
        $data["column_log_date"] = $this->language->get("column_log_date");
        $data["column_log_item"] = $this->language->get("column_log_item");
        $data["column_log_action"] = $this->language->get("column_log_action");
        $data["column_user_name"] = $this->language->get("column_user_name");
        $data["column_ip_address"] = $this->language->get("column_ip_address");
        $data["column_action"] = $this->language->get("column_action");
        $data["entry_all"] = $this->language->get("entry_all");
        $data["button_clear"] = $this->language->get("button_clear");
        $data["button_filter"] = $this->language->get("button_filter");
        $data["token"] = $this->session->data["token"];
        if (isset($this->error["warning"])) {
            $data["error_warning"] = $this->error["warning"];
        } else {
            $data["error_warning"] = "";
        }
        if (isset($this->session->data["success"])) {
            $data["success"] = $this->session->data["success"];
            unset($this->session->data["success"]);
        } else {
            $data["success"] = "";
        }
        $url = "";
        if (isset($this->request->get["filter_log_date"])) {
            $url .= "&filter_log_date=" . $this->request->get["filter_log_date"];
        }
        if (isset($this->request->get["filter_log_item"])) {
            $url .= "&filter_log_item=" . urlencode(html_entity_decode($this->request->get["filter_log_item"], ENT_QUOTES, "UTF-8"));
        }
        if (isset($this->request->get["filter_log_action"])) {
            $url .= "&filter_log_action=" . urlencode(html_entity_decode($this->request->get["filter_log_action"], ENT_QUOTES, "UTF-8"));
        }
        if (isset($this->request->get["filter_user_name"])) {
            $url .= "&filter_user_name=" . urlencode(html_entity_decode($this->request->get["filter_user_name"], ENT_QUOTES, "UTF-8"));
        }
        if (isset($this->request->get["filter_ip_address"])) {
            $url .= "&filter_ip_address=" . urlencode(html_entity_decode($this->request->get["filter_ip_address"], ENT_QUOTES, "UTF-8"));
        }
        if ($order == "ASC") {
            $url .= "&order=DESC";
        } else {
            $url .= "&order=ASC";
        }
        if (isset($this->request->get["page"])) {
            $url .= "&page=" . $this->request->get["page"];
        }
        $data["sort_log_date"] = $this->url->link("logger/logger", "token=" . $this->session->data["token"] . "&sort=log_date" . $url, "SSL");
        $data["sort_log_item"] = $this->url->link("logger/logger", "token=" . $this->session->data["token"] . "&sort=log_item" . $url, "SSL");
        $data["sort_log_action"] = $this->url->link("logger/logger", "token=" . $this->session->data["token"] . "&sort=log_action" . $url, "SSL");
        $data["sort_user_name"] = $this->url->link("logger/logger", "token=" . $this->session->data["token"] . "&sort=user_name" . $url, "SSL");
        $data["sort_ip_address"] = $this->url->link("logger/logger", "token=" . $this->session->data["token"] . "&sort=ip_address" . $url, "SSL");
        $url = "";
        if (isset($this->request->get["filter_log_date"])) {
            $url .= "&filter_log_date=" . $this->request->get["filter_log_date"];
        }
        if (isset($this->request->get["filter_log_item"])) {
            $url .= "&filter_custofilter_log_itemmer=" . urlencode(html_entity_decode($this->request->get["filter_log_item"], ENT_QUOTES, "UTF-8"));
        }
        if (isset($this->request->get["filter_log_action"])) {
            $url .= "&filter_log_action=" . $this->request->get["filter_log_action"];
        }
        if (isset($this->request->get["filter_user_name"])) {
            $url .= "&filter_user_name=" . $this->request->get["filter_user_name"];
        }
        if (isset($this->request->get["filter_ip_address"])) {
            $url .= "&filter_ip_address=" . $this->request->get["filter_ip_address"];
        }
        if (isset($this->request->get["sort"])) {
            $url .= "&sort=" . $this->request->get["sort"];
        }
        if (isset($this->request->get["order"])) {
            $url .= "&order=" . $this->request->get["order"];
        }
        $pagination = new Pagination();
        $pagination->total = $order_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get("config_limit_admin");
        $pagination->text = $this->language->get("text_pagination");
        $pagination->url = $this->url->link("logger/logger", "token=" . $this->session->data["token"] . $url . "&page={page}", "SSL");
        $data["pagination"] = $pagination->render();
        $data["results"] = sprintf($this->language->get("text_pagination"), $order_total ? ($page - 1) * $this->config->get("config_limit_admin") + 1 : 0, $order_total - $this->config->get("config_limit_admin") < ($page - 1) * $this->config->get("config_limit_admin") ? $order_total : ($page - 1) * $this->config->get("config_limit_admin") + $this->config->get("config_limit_admin"), $order_total, ceil($order_total / $this->config->get("config_limit_admin")));
        $data["filter_log_date"] = $filter_log_date;
        $data["filter_log_item"] = $filter_log_item;
        $data["filter_log_action"] = $filter_log_action;
        $data["filter_user_name"] = $filter_user_name;
        $data["filter_ip_address"] = $filter_ip_address;
        $data["sort"] = $sort;
        $data["order"] = $order;
        $data["header"] = $this->load->controller("common/header");
        $data["column_left"] = $this->load->controller("common/column_left");
        $data["footer"] = $this->load->controller("common/footer");
        $this->response->setOutput($this->load->view("logger/log_list.tpl", $data));
    }
    public function view()
    {
        $this->load->model("logger/admin");
        if (isset($this->request->get["log_id"])) {
            $log_id = $this->request->get["log_id"];
        } else {
            $log_id = 0;
        }
        $log_info = $this->model_logger_admin->getLog($log_id);
        if ($log_info) {
            $this->load->language("logger/logger");
            $this->document->setTitle($this->language->get("heading_title"));
            $data["heading_title"] = $this->language->get("heading_title");
            $data["entry_log_id"] = $this->language->get("entry_log_id");
            $data["entry_log_date"] = $this->language->get("entry_log_date");
            $data["entry_user_name"] = $this->language->get("entry_user_name");
            $data["entry_ip_address"] = $this->language->get("entry_ip_address");
            $data["entry_log_item"] = $this->language->get("entry_log_item");
            $data["entry_log_action"] = $this->language->get("entry_log_action");
            $data["entry_log_data"] = $this->language->get("entry_log_data");
            $data["button_cancel"] = $this->language->get("button_cancel");
            $data["token"] = $this->session->data["token"];
            $url = "";
            $data["breadcrumbs"] = array();
            $data["breadcrumbs"][] = array("text" => $this->language->get("text_home"), "href" => $this->url->link("common/home", "token=" . $this->session->data["token"], "SSL"));
            $data["breadcrumbs"][] = array("text" => $this->language->get("heading_title"), "href" => $this->url->link("logger/logger", "token=" . $this->session->data["token"] . $url, "SSL"));
            $data["cancel"] = $this->url->link("logger/logger", "token=" . $this->session->data["token"] . $url, "SSL");
            $data["log_id"] = $this->request->get["log_id"];
            $data["log_date"] = $log_info["log_date"];
            $data["log_item"] = $log_info["log_item"];
            $data["log_action"] = $log_info["log_action"];
            $data["user_name"] = $log_info["user_name"];
            $data["ip_address"] = $log_info["ip_address"];
            $data["log_data"] = unserialize($log_info["log_data"]);
            $data["header"] = $this->load->controller("common/header");
            $data["column_left"] = $this->load->controller("common/column_left");
            $data["footer"] = $this->load->controller("common/footer");
            $this->response->setOutput($this->load->view("logger/log_view.tpl", $data));
        } else {
            $this->load->language("error/not_found");
            $this->document->setTitle($this->language->get("heading_title"));
            $data["heading_title"] = $this->language->get("heading_title");
            $data["text_not_found"] = $this->language->get("text_not_found");
            $data["breadcrumbs"] = array();
            $data["breadcrumbs"][] = array("text" => $this->language->get("text_home"), "href" => $this->url->link("common/dashboard", "token=" . $this->session->data["token"], "SSL"));
            $data["breadcrumbs"][] = array("text" => $this->language->get("heading_title"), "href" => $this->url->link("error/not_found", "token=" . $this->session->data["token"], "SSL"));
            $data["header"] = $this->load->controller("common/header");
            $data["column_left"] = $this->load->controller("common/column_left");
            $data["footer"] = $this->load->controller("common/footer");
            $this->response->setOutput($this->load->view("error/not_found.tpl", $data));
        }
    }
    public function updatelog()
    {
        $this->load->language("logger/logger");
        $this->load->model("logger/admin");
        if ($_REQUEST["action"] == "Edit") {
            $this->model_logger_admin->logEvent(array("order_id" => $_REQUEST["order_id"]), "Order", "Order updated");
        } else {
            if ($_REQUEST["action"] == "Add") {
                $query = $this->db->query("SELECT * FROM  " . DB_PREFIX . "order ORDER BY order_id DESC LIMIT 0 , 1");
                $order_id = $query->row["order_id"];
                $this->model_logger_admin->logEvent(array("order_id" => $order_id), "Order", "Order Added");
            } else {
                if ($_REQUEST["action"] == "Delete") {
                    $this->model_logger_admin->logEvent(array("order_id" => $_REQUEST["order_id"]), "Order", "Order deleted");
                } else {
                    if ($_REQUEST["action"] == "History") {
                        $this->model_logger_admin->logEvent(array_merge(array("order_id" => $_REQUEST["order_id"]), array("order_status_id" => $_REQUEST["order_status"]), array("Comment" => $_REQUEST["input_comment"]), array("Notify" => $_REQUEST["input_notify"])), "Order", "Order history updated");
                    }
                }
            }
        }
    }
}

?>