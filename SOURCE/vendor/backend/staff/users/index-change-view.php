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
include_once(dirname(__FILE__) . "/../../../../app/system.php");

$user = new xUCP_User($db);
if (!$user->isLoggedIn()) {
    header('Location: /index');
    exit;
}

$user = new xUCP_Themes($db);
$user->xucp_header_logged(STAFF_USER_CAHNEGED);
$user->xucp_content_logged();

$user = new xUCP_Secure($db);
$user->staff_check();

$id = $_GET['id'];
$select_stmt = $db->prepare(query: "SELECT * FROM xucp_accounts WHERE id = ".$id);
$select_stmt->execute();
$row=$select_stmt->fetch(PDO::FETCH_ASSOC);
if($select_stmt->rowCount() > 0){
    if(isset($_REQUEST['xucp_submit']))
    {
        $username = strip_tags($_REQUEST['xucp_username']);
        $email 	= strip_tags($_REQUEST['xucp_email']);
        $whitelisted 	= strip_tags($_REQUEST['xucp_whitelisted']);
        $user_dc_tag 	= strip_tags($_REQUEST['xucp_user_dc_tag']);
        $user_hp 	= strip_tags($_REQUEST['xucp_user_hp']);
        $user_banned 	= strip_tags($_REQUEST['xucp_banned']);
        $user_banned_reason 	= strip_tags($_REQUEST['xucp_banned_reason']);

        if(empty($username)){
            $errorMsg[]=MSG_7;
        }
        else
        {
            try
            {
                if(!isset($errorMsg))
                {
                    $insert_stmt=$db->prepare("UPDATE `xucp_accounts` SET `username` = :xucp_username, `email` = :xucp_email, `whitelisted` = :xucp_whitelisted, `userdiscordtag` = :xucp_user_dc_tag, `userhp` = :xucp_user_hp, `ban` = :xucp_banned, `banReason` = :xucp_banned_reason WHERE `id` = ".$id);

                    if($insert_stmt->execute(array(	':xucp_username'	=>$username,
                        ':xucp_email'	=>$email,
                        ':xucp_whitelisted'	=>$whitelisted,
                        ':xucp_user_dc_tag'	=>$user_dc_tag,
                        ':xucp_user_hp'	=>$user_hp,
                        ':xucp_banned'	=>$user_banned,
                        ':xucp_banned_reason'	=>$user_banned_reason))){

                        $doneMsg=FRAGEDONE;
                        header("refresh:2; /vendor/backend/staff/users/index-control");
                    }
                }
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }
    }
    if(isset($errorMsg))
    {
        foreach($errorMsg as $error)
        {
            echo"
                        <div class='row'>
							<div class='col-xl-12'>
								<div class='card xucp-card'>
									<div class='card-header'>
										<h4 class='card-title'>".STAFF_USER_CAHNEGED.": " .$row['username']. "</h4>
									</div>
									<div class='card-body'>
										".$error."
									</div>
								</div>
							</div>
						</div>";
        }
    }
    if(isset($doneMsg))
    {
        echo"
                        <div class='row'>
							<div class='col-xl-12'>
								<div class='card xucp-card'>
									<div class='card-header'>
										<h4 class='card-title'>".STAFF_USER_CAHNEGED.": " .$row['username']. "</h4>
									</div>
									<div class='card-body'>
										".$doneMsg."
									</div>
								</div>
							</div>
						</div>";
    }
    echo "
              <div class='col-lg-12'>
                <div class='card xucp-card'>
					<div class='card-body'>
						<form class='forms-sample' name='form' method='post' action='/vendor/backend/staff/users/index-change-view?id=".$id."'>
                            <input type='hidden' name='new' value='1' />
                            <div class='form-group'>
								<div class='form-line'>
									<label  class='col-sm-3 col-form-label'>".STAFF_USER_CONTROLUSERID."</label>
									<div class='col-sm-12'>
										" . $row["id"]. "
									</div>
								</div>
                            </div>
                            <div class='form-group'>
								<div class='form-line'>
									<label  class='col-sm-3 col-form-label'>".STAFF_USER_CONTROLUSERNAME."</label>
									<div class='col-sm-12'>
										<input type='text' name='xucp_username' size='50' maxlength='60' class='form-control' value='" . $row["username"]. "' required>
									</div>
								</div>							
                            </div>
                            <div class='form-group'>
								<div class='form-line'>
									<label  class='col-sm-3 col-form-label'>".STAFF_USER_CONTROLEMAIL."</label>
									<div class='col-sm-12'>
										<input type='text' name='xucp_email' size='50' maxlength='60' class='form-control' value='" . $row["email"]. "' required>
									</div>
								</div>							
                            </div>
                            <div class='form-group'>
								<div class='form-line'>
									<label  class='col-sm-3 col-form-label'>".STAFF_BANNED_USER."</label>
									<div class='col-sm-12'>
										<select name='xucp_banned' class='form-control show-tick' value='" . $row["ban"]. "'required>
												<option value=''>-- ".CHANGE_MY_PROFILE_LANGUAGENOTE." --</option>
												<option value='1'>".SITE_CONFIG_CLIENT_YES."</option>
												<option value='0'>".SITE_CONFIG_CLIENT_NO."</option>											
										</select>									
									</div>
								</div>							
                            </div>
                            <div class='form-group'>
								<div class='form-line'>
									<label  class='col-sm-3 col-form-label'>".STAFF_BANNED_USER." ".STAFF_BANNED_USER_NOTE."</label>
									<div class='col-sm-12'>
										<input type='text' name='xucp_banned_reason' size='50' maxlength='60' class='form-control' value='" . $row["banReason"]. "' required>
									</div>
								</div>							
                            </div>
                            <div class='form-group'>
								<div class='form-line'>
									<label  class='col-sm-3 col-form-label'>".PROFILE_PORTFOLIO_DISCORDTAG."</label>
									<div class='col-sm-12'>
										<input type='text' name='xucp_user_dc_tag' size='50' maxlength='60' class='form-control' value='" . $row["userdiscordtag"]. "' required>
									</div>
								</div>							
                            </div>
                            <div class='form-group'>
								<div class='form-line'>
									<label  class='col-sm-3 col-form-label'>".STAFF_USER_CONTROLACCOUNTWHITELIST."</label>
									<div class='col-sm-12'>
										<select name='xucp_whitelisted' class='form-control show-tick' value='" . $row["whitelisted"]. "'required>
												<option value=''>-- ".STAFF_USER_CONTROL_WL_STATUS." --</option>
												<option value='1'>".SITE_CONFIG_CLIENT_YES."</option>
												<option value='0'>".SITE_CONFIG_CLIENT_NO."</option>											
										</select>
									</div>
								</div>							
                            </div>
                            <div class='form-group'>
								<div class='form-line'>
									<label  class='col-sm-3 col-form-label'>".PROFILE_PORTFOLIO_WEBSITE."</label>
									<div class='col-sm-12'>
										<input type='text' name='xucp_user_hp' size='50' maxlength='60' class='form-control' value='" . $row["userhp"]. "' required>
									</div>
								</div>							
                            </div>
                            <div class='form-group'>
								<div class='form-line'>
									<label  class='col-sm-3 col-form-label'>".STAFF_USER_CONTROLOPTION."</label>
									<div class='col-sm-12'>
										<button type='submit' class='btn btn-primary w-100 waves-effect waves-light' name='xucp_submit'>".STAFF_USER_CONTROLSAVE."</button></submit>&nbsp;
									</div>
								</div>							
                            </div>
						</form>
						</div>							
					</div>
				</div>
            </div>";
}
$user = new xUCP_Themes($db);
$user->xucp_footer_logged();