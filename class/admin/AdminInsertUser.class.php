<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@s-e-d.de
# WWW: http://www.sedesign.de
#
# File: AdminInsertUser.class.php modified by T-FISH
# WWW: https://et-chat.de
#
# Class AdminInsertUser - Admin area
########################################################################################################################*/

class AdminInsertUser extends DbConectionMaker
{

	/**
	* Constructor
	*
	* @uses ConnectDB::sqlSet()	
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
		
		
		if ($_SESSION['etchat_'.$this->_prefix.'user_priv']=="admin"){
			
			if (empty($_POST['user'])) {
				echo "Please fill user name field.<br><br><a href=\"./?AdminCreateNewUser\">back</a>";
				return false;
            }

         $_POST['user'] = htmlentities($_POST['user'], ENT_QUOTES, "UTF-8");
         $_POST['priv'] = htmlentities($_POST['priv'], ENT_QUOTES, "UTF-8");
         if (!empty($_POST['pw'])) $_POST['pw'] = "'".md5($_POST['pw'])."'";
		 else $_POST['pw'] = "NULL";

         // Test if the user exists in the DB
         $res = $this->dbObj->sqlGet("select etchat_user_id FROM {$this->_prefix}etchat_user where etchat_username = '".$_POST['user']."'");
         if (is_array($res))
         	$this->dbObj->sqlSet("UPDATE {$this->_prefix}etchat_user SET etchat_userpw = ".$_POST['pw'].", etchat_userprivilegien  = '".$_POST['priv']."' WHERE etchat_user_id=".$res[0][0]);
         else
         	$this->dbObj->sqlSet("INSERT INTO {$this->_prefix}etchat_user(etchat_username,etchat_userpw,etchat_userprivilegien) VALUES ('".$_POST['user']."', ".$_POST['pw'].", '".$_POST['priv']."')");
			
		$this->dbObj->close();
		header("Location: ./?AdminUserIndex");
			
		}else{
			echo $lang->error[0]->tagData;
			return false;
		}
	}
}