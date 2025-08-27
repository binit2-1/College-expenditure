<?php
// config.php - Configuration file
define('DB_HOST', 'localhost');
define('DB_USER', 'college_user');
define('DB_PASS', 'college_password');
define('DB_NAME', 'college_expense_tracker');

// Application settings
define('APP_NAME', 'College Expenditure Monitoring & UC Generator');
define('APP_VERSION', '1.0.0');

// Paths
define('BASE_PATH', dirname(__FILE__));
define('INCLUDES_PATH', BASE_PATH . '/includes');
define('CSS_PATH', BASE_PATH . '/css');
define('JS_PATH', BASE_PATH . '/js');
?>