<?php
// ************************************************************************************//
// * xUCP Free
// ************************************************************************************//
// * Author: DerStr1k3r
// ************************************************************************************//
// * Version: 5.0
// *
// * Copyright (c) 2024 DerStr1k3r. All rights reserved.
// ************************************************************************************//
// * License Typ: GNU GPLv3
// ************************************************************************************//
if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
    setCookie("PHPSESSID", "", 0x7fffffff,  "/");
    session_destroy();
    die( header( 'location: /vendor/frontend/404/index', true, 0 ) );
}
// ************************************************************************************//
// * MySQL Database Connection
// ************************************************************************************//
$db_host="localhost";
$db_port="3306";
$db_user="your_username";
$db_password="your_password";
$db_name="your_dbname";

$db_charset = 'utf8mb4';
// ************************************************************************************//
// * MySQL Account Data Connect
// ************************************************************************************//
$options = [
    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    \PDO::ATTR_EMULATE_PREPARES   => false,
];
$dsn = "mysql:host=$db_host;dbname=$db_name;charset=$db_charset;port=$db_port";
try {
     $db = new \PDO($dsn, $db_user, $db_password, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}