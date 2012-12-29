<?php

class AdminTemplate extends Template
{
    
    protected $jsResource = array(
            'jquery.js',
            'tooltip.js',
            'viewer.js',
            'core.js'
    );
    
    protected $templateFiles = array(
            'body',
            'footer',
            'controlbar'
    );
    
    public function renderView()
    {
        $view = Helper::getView();
        require_once ADMIN_FORMS_PATH . $view . '.view.form.php';
    }
    
    public function renderControl()
    {
        $view = Helper::getView();
        require_once ADMIN_CONTROLS_PATH . $view . '.view.control.php';
    }
}