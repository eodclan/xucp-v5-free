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
global $db;
include_once(dirname(__FILE__) . "/../../../app/system.php");

$user = new xUCP_Themes($db);
$user->xucp_header_none_logged(REGISTER);
$user->xucp_content_none_logged();


if(isset($_REQUEST['xucp_signup']))
{
    $username	= strip_tags($_REQUEST['xucp_username']);
    $email		= strip_tags($_REQUEST['xucp_email']);
    $password	= strip_tags($_REQUEST['xucp_password']);
    
    if (!xUCP_CSRF_Secure::verifyToken($_POST['csrf_token'])) {
        echo "
      <div class='col-lg-12'>
         <div class='card xucp-card'>
            <div class='card-header d-flex justify-content-between flex-wrap'>
               <div class='header-title'>
                  <h4 class='card-title'>
                    <svg width='32' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M14.3955 9.59497L9.60352 14.387' stroke='currentColor' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path>
                        <path d='M14.3971 14.3898L9.60107 9.59277' stroke='currentColor' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path>
                        <path fill-rule='evenodd' clip-rule='evenodd' d='M16.3345 2.75024H7.66549C4.64449 2.75024 2.75049 4.88924 2.75049 7.91624V16.0842C2.75049 19.1112 4.63549 21.2502 7.66549 21.2502H16.3335C19.3645 21.2502 21.2505 19.1112 21.2505 16.0842V7.91624C21.2505 4.88924 19.3645 2.75024 16.3345 2.75024Z' stroke='currentColor' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path>
                    </svg>
                    ".REGISTER."
                  </h4>
                  <hr class='hr-horizontal'>
               </div>
            </div>
            <div class='card-body'>
               <div class='d-flex flex-wrap align-items-center justify-content-between'>
                    <p>".MSG_10."</p>
               </div>
            </div>
         </div>
      </div>";
        die();
    }
    
    $user = new xUCP_User($db);
    if ($user->checkUsernameExists($username)) {
        echo "
      <div class='col-lg-12'>
         <div class='card xucp-card'>
            <div class='card-header d-flex justify-content-between flex-wrap'>
               <div class='header-title'>
                  <h4 class='card-title'>
                    <svg width='32' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M14.3955 9.59497L9.60352 14.387' stroke='currentColor' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path>
                        <path d='M14.3971 14.3898L9.60107 9.59277' stroke='currentColor' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path>
                        <path fill-rule='evenodd' clip-rule='evenodd' d='M16.3345 2.75024H7.66549C4.64449 2.75024 2.75049 4.88924 2.75049 7.91624V16.0842C2.75049 19.1112 4.63549 21.2502 7.66549 21.2502H16.3335C19.3645 21.2502 21.2505 19.1112 21.2505 16.0842V7.91624C21.2505 4.88924 19.3645 2.75024 16.3345 2.75024Z' stroke='currentColor' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path>
                    </svg>
                    ".REGISTER."
                  </h4>
                  <hr class='hr-horizontal'>
               </div>
            </div>
            <div class='card-body'>
               <div class='d-flex flex-wrap align-items-center justify-content-between'>
                    <p>".MSG_16."</p>
               </div>
            </div>
         </div>
      </div>";
    } else {
        $user->register($username, $password, $email);
        // Erstellen einer Instanz der DiscordWebhook-Klasse
        $webhook = new xUCP_Discord(DC_WEBHOOK_URL);
        
        // Festlegen von benutzerdefinierten Werten wie Benutzername, Avatar-URL, Autor und Fußzeile
        $webhook->setUsername(DC_WEBHOOK_NAME);
        $webhook->setAvatarUrl(DC_WEBHOOK_AVATAR);
        $webhook->setAuthor(DC_WEBHOOK_NAME);
        $webhook->setFooter('Powered by xUCP Free v5.0.1875');
        
        // Definieren des Inhalts, den du senden möchtest
        $content = DC_WEBHOOK_INFO_REGISTER_1 . " " . $username . " " . DC_WEBHOOK_INFO_REGISTER_2;
        
        // Senden des Inhalts an Discord
        $response = $webhook->send($content);
        
        // Ausgabe der Antwort von Discord (optional)
        echo $response;
        echo "
      <div class='col-lg-12'>
         <div class='card xucp-card'>
            <div class='card-header d-flex justify-content-between flex-wrap'>
               <div class='header-title'>
                  <h4 class='card-title'>
                    <svg width='32' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M14.3955 9.59497L9.60352 14.387' stroke='currentColor' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path>
                        <path d='M14.3971 14.3898L9.60107 9.59277' stroke='currentColor' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path>
                        <path fill-rule='evenodd' clip-rule='evenodd' d='M16.3345 2.75024H7.66549C4.64449 2.75024 2.75049 4.88924 2.75049 7.91624V16.0842C2.75049 19.1112 4.63549 21.2502 7.66549 21.2502H16.3335C19.3645 21.2502 21.2505 19.1112 21.2505 16.0842V7.91624C21.2505 4.88924 19.3645 2.75024 16.3345 2.75024Z' stroke='currentColor' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path>
                    </svg>
                    ".LOGIN."
                  </h4>
                  <hr class='hr-horizontal'>
               </div>
            </div>
            <div class='card-body'>
               <div class='d-flex flex-wrap align-items-center justify-content-between'>
                    <p>".MSG_9."</p>
               </div>
            </div>
         </div>
      </div>";
    }
    

}
$user = new xUCP_Themes($db);
$user->xucp_footer_none_logged();