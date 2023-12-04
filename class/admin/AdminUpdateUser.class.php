<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@sedesign.de
# WWW: http://www.sedesign.de
#
# File: AdminUpdateUser.class.php modified by T-FISH
# WWW: https://et-chat.de
#
# Class AdminUpdateUser - Admin area
########################################################################################################################*/

class AdminUpdateUser extends DbConectionMaker
{

	/**
	* Constructor
	*
	* @uses ConnectDB::sqlSet()	
	* @uses ConnectDB::sqlGet()
	* @uses ConnectDB::close()	
	* @return void
	*/
	public function __construct (){ 
		
		// call parent Constructor from class DbConectionMaker
		parent::__construct(); 

		session_start();

		header('Cache-Control: no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0');
		// Sets charset and content-type for index.php
		header('content-type: text/html; charset=utf-8');
		
		// create new LangXml Object
		$langObj = new LangXml();
		$lang=$langObj->getLang()->admin[0]->admin_user[0];
		
		
		if ($_SESSION['etchat_'.$this->_prefix.'user_priv']=="admin" && !empty($_POST['id'])){
			
		$pass = (!empty($_POST['pw'])) ? "etchat_userpw = '".md5($_POST['pw'])."'," : "";

        if ($_POST['priv']=="mod"){
			// Test if there any Admins in the DB now
			$res = $this->dbObj->sqlGet("select count(etchat_user_id) FROM {$this->_prefix}etchat_user where etchat_user_id <> ".(int)$_POST['id']." AND etchat_userprivilegien = 'admin'");
			if ($res[0][0]==0){
				echo "Not possible. There will be no administrators in chat.<br><br><a href=\"./?AdminUserIndex\">back</a>";
				return false;
            }
        }
        
		// Checks if this user exists and is an admin
        $res_dop = $this->dbObj->sqlGet("select count(etchat_user_id) FROM {$this->_prefix}etchat_user where etchat_username = '".htmlspecialchars($_POST['user'], ENT_QUOTES, "UTF-8")."' and etchat_userprivilegien <> 'gast' and etchat_user_id<>".(int)$_POST['id']);
        if ($res_dop[0][0]>0){
            echo "Not possible, because a user with this name exists.<br><br><a href=\"./?AdminUserIndex\">back</a>";
            return false;
        }
		$this->dbObj->sqlSet("UPDATE {$this->_prefix}etchat_user SET ".$pass." etchat_username = '".htmlspecialchars($_POST['user'], ENT_QUOTES, "UTF-8")."', etchat_userprivilegien  = '".htmlspecialchars($_POST['priv'], ENT_QUOTES, "UTF-8")."' WHERE etchat_user_id=".(int)$_POST['id']);

		$this->dbObj->close();
		header("Location: ./?AdminUserIndex");
			
		}else{
			echo $lang->error[0]->tagData;
			return false;
		}
	}
}