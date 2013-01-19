<?php

class Template
{

    protected $cssResource = array(
            'reset.css',
            'main.css',
            'viewer.css',
            'form.css'
    );

    protected $jsResource = array(
            'jquery.js',
            'easing.js',
            'banner.js',
            'tooltip.js',
            'viewer.js',
            'sp.js',
            'news.js',
            'core.js'
    );

    protected $templateFiles = array(
            'header',
            'sidebar',
            'body',
            'footer'
    );

    /**
     * The constructor will setup the page by calling the head resources
     * then will call the template files.
     * Please do put the file names in
     * the templateFiles array in the order you want the page to be shown.
     */
    public function __construct ()
    {
        if(preg_match("/ajax/i", $_SERVER['REQUEST_URI'])) {
            Helper::render ();
        } else {
            $this->setupPage();
            $this->callTemplateParts($this->templateFiles);
            $this->setupPageEnd();
        }
    }

    /**
     * The function will call the head of the webpage using HTML5 Document Type
     * then will setup up the rest of the page options like encoding, title,
     * resource
     * base path and calling the css and JavaScript resources.
     *
     * @return void;
     */
    private function setupPage ()
    {
        $output = '<!DOCTYPE html><html lang="en"><head>';
        $output .= $this->setCharacterEncoding();
        $output .= $this->setPageTitle();
        $output .= $this->setBasePath();
        $output .= $this->fixHTML5();
        $output .= $this->registerCustomResources();
        $output .= '</head><body>';
        echo $output;
    }

    private function setupPageEnd ()
    {
        echo '</body></html>';
    }

    private function setPageTitle ()
    {
        return '<title>:. Milk Production Management Systems .:</title>';
    }

    private function setCharacterEncoding ($encode = 'utf-8')
    {
        return '<meta charset="' . $encode . '">';
    }

    private function setBasePath ()
    {
        return '<base href="' . HOST_NAME . '">';
    }

    private function registerResource ($type, Array $files)
    {
        $minifyString = GOOGLE_MINIFY_PATH . '/?b=';
        $minifyString .= ($type == 'css') ? CSS_DIR : JS_DIR;
        $minifyString .= '&amp;f=';
        $minifyString .= join(',', $files);
        $resourceTag = ($type == 'css') ? '<link rel="stylesheet" href="' .
                 $minifyString . '" media="all">' : '<script src="' .
                 $minifyString . '"></script>';
        return $resourceTag;
    }

    private function registerCustomResources ()
    {
        return '<!-- Required Stylesheets -->
				<link rel="stylesheet" type="text/css" href="css/reset.css" media="screen" />
				<link rel="stylesheet" type="text/css" href="css/text.css" media="screen" />
				<link rel="stylesheet" type="text/css" href="css/fonts/ptsans/stylesheet.css" media="screen" />
				<link rel="stylesheet" type="text/css" href="css/fluid.css" media="screen" />
				
				<link rel="stylesheet" type="text/css" href="css/mws.style.css" media="screen" />
				<link rel="stylesheet" type="text/css" href="css/icons/icons.css" media="screen" />
				
				<!-- Demo and Plugin Stylesheets -->
				<link rel="stylesheet" type="text/css" href="css/demo.css" media="screen" />
				
				<link rel="stylesheet" type="text/css" href="plugins/colorpicker/colorpicker.css" media="screen" />
				<link rel="stylesheet" type="text/css" href="plugins/jimgareaselect/css/imgareaselect-default.css" media="screen" />
				<link rel="stylesheet" type="text/css" href="plugins/fullcalendar/fullcalendar.css" media="screen" />
				<link rel="stylesheet" type="text/css" href="plugins/fullcalendar/fullcalendar.print.css" media="print" />
				<link rel="stylesheet" type="text/css" href="plugins/tipsy/tipsy.css" media="screen" />
				<link rel="stylesheet" type="text/css" href="plugins/sourcerer/Sourcerer-1.2.css" media="screen" />
				<link rel="stylesheet" type="text/css" href="plugins/jgrowl/jquery.jgrowl.css" media="screen" />
				<link rel="stylesheet" type="text/css" href="plugins/spinner/spinner.css" media="screen" />
				<link rel="stylesheet" type="text/css" href="css/jui/jquery.ui.css" media="screen" />
				
				<!-- Theme Stylesheet -->
				<link rel="stylesheet" type="text/css" href="css/mws.theme.css" media="screen" />
				
				<!-- JavaScript Plugins -->
				
				<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
				
				<script type="text/javascript" src="plugins/jimgareaselect/jquery.imgareaselect.min.js"></script>
				<script type="text/javascript" src="plugins/jquery.dualListBox-1.3.min.js"></script>
				<script type="text/javascript" src="plugins/jgrowl/jquery.jgrowl.js"></script>
				<script type="text/javascript" src="plugins/jquery.filestyle.js"></script>
				<script type="text/javascript" src="plugins/fullcalendar/fullcalendar.min.js"></script>
				<script type="text/javascript" src="plugins/jquery.dataTables.js"></script>
				<!--[if lt IE 9]>
				<script type="text/javascript" src="plugins/flot/excanvas.min.js"></script>
				<![endif]-->
				<script type="text/javascript" src="plugins/flot/jquery.flot.min.js"></script>
				<script type="text/javascript" src="plugins/flot/jquery.flot.pie.min.js"></script>
				<script type="text/javascript" src="plugins/flot/jquery.flot.stack.min.js"></script>
				<script type="text/javascript" src="plugins/flot/jquery.flot.resize.min.js"></script>
				<script type="text/javascript" src="plugins/colorpicker/colorpicker.js"></script>
				<script type="text/javascript" src="plugins/tipsy/jquery.tipsy.js"></script>
				<script type="text/javascript" src="plugins/sourcerer/Sourcerer-1.2.js"></script>
				<script type="text/javascript" src="plugins/jquery.placeholder.js"></script>
				<script type="text/javascript" src="plugins/jquery.validate.js"></script>
				<script type="text/javascript" src="plugins/jquery.mousewheel.js"></script>
				<script type="text/javascript" src="plugins/spinner/ui.spinner.js"></script>
				<script type="text/javascript" src="js/jquery-ui.js"></script>
				
				<script type="text/javascript" src="js/mws.js"></script>
				<script type="text/javascript" src="js/demo.js"></script>
				<script type="text/javascript" src="js/themer.js"></script>
				
				<script type="text/javascript" src="js/demo.dashboard.js"></script>';
    }

    private function fixHTML5 ()
    {
        return '<!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->';
    }

    private function callTemplateParts (Array $templateFiles)
    {
        foreach ($templateFiles as $file) {
            $path = Helper::urlContains('_administrator') ? ADMIN_TEMPLATE_PATH : TEMPLATE_PATH;
            require_once $path . $file . '.tpl.php';
        }
    }

    public function addClass ($className)
    {
        return $className;
    }

    public function highlight ($view, $add = false)
    {
        $classToAdd = $add ? ' ' . $add : '';
        echo Helper::getView() == $view ? 'class="selected' . $classToAdd . '"' : '';
    }
}