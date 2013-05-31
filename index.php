<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'MegaController.php';
require_once 'db/DB.php';
$mc = new MegaController();
$mc->run();
