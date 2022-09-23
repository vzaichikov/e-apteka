<?php

class ControllerExtensionModuleSeogenUninstall extends Controller {
    public function index() {
        $this->uninstall();
    }
    private function uninstall() {
        $this->load->model('extension/event');
        $this->model_extension_event->deleteEvent('seogen');
    }

}