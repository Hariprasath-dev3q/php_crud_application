<?php

namespace App\Libraries;

use Smarty\Smarty as SmartyEngine;

class Smarty extends SmartyEngine
{
    public function __construct()
    {
        parent::__construct();

        // Template directory
        $this->setTemplateDir(APPPATH . 'Views/smarty/');

        // Compile directory (must be writable)
        $this->setCompileDir(WRITEPATH . 'smarty/templates_c/');

        // Cache directory (optional)
        $this->setCacheDir(WRITEPATH . 'smarty/cache/');

        // Config directory (optional)
        $this->setConfigDir(APPPATH . 'Config/smarty/');

        // Recommended settings
        $this->caching = false;
        $this->compile_check = true;
    }
}
