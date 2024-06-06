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
// * E-Mail System
// ************************************************************************************//
const SITE_EMAIL = "noreplay@xxx.com";
// ************************************************************************************//
// * Site Login Secure System
// ************************************************************************************//
// SHA-512 Cryptographic Hash Algorithm
const SITE_LOGIN_SECURE_ALGO = "sha512";
// Your keywords
const SITE_LOGIN_SECURE_ALGO_ENCRYPT = "xUCP Pro V5";
