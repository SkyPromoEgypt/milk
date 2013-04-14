<?php
// Start Output Buffering
ob_start();

// Set Error Handling
ini_set('display_errors', 1);
error_reporting(E_ALL & ~ E_NOTICE & ~ E_STRICT);

// Shortcuts
define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);
define('HOST_NAME', 'http://' . $_SERVER['HTTP_HOST'] . '/');

// Database Credentials
define('DB_SERVER', 'localhost');
define('DB_NAME', 'milk');
define('DB_USER', 'root');
define('DB_PASS', 'rebo');

// Application Paths
define('APP_PATH', realpath(dirname(__FILE__)) . DS);
define('LIB_PATH', APP_PATH . 'models');
define('THIRD_PARTY_LIBS_PATH', APP_PATH . 'libraries' . DS);
define('TEMPLATE_PATH', APP_PATH . 'template' . DS . 'web' . DS);
define('VIEWS_PATH', APP_PATH . 'views' . DS . 'web' . DS);

// Resources Directories
define('CSS_DIR', 'css');
define('JS_DIR', 'js');

// Thrid Party Libraries Paths
define('GOOGLE_MINIFY_PATH', 'libraries/min');

// Error Levels
define('APP_ERROR', 1);
define('APP_WARNING', 2);
define('APP_INFO', 3);
define('APP_MESSAGE', 4);


// Set PHP paths
set_include_path(get_include_path() . PS . LIB_PATH);

// Autoload Classes
function __autoload ($className)
{
    require_once strtolower($className) . '.class.php';
}

// Open connection to database
$dbh = new PDO('mysql:hostname=' . DB_SERVER . ';dbname=' . DB_NAME, DB_USER, 
        DB_PASS);
$dbh->query('set names utf8');

// Start Application Session
session_start();

// Set the User
$theUser = User::theUser();

// App and Control Panel Access Guard
Observer::appGuard();

// Render the Template
$template = new Template();

// Flush buffer
ob_flush();
