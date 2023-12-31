<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@sedesign.de
# WWW: http://www.sedesign.de
#
# File: ChangePw.class.php modified by T-FISH
# WWW: https://et-chat.de
#
# ChangePw, sets new Pw
########################################################################################################################*/

class ChangePw extends DbConectionMaker
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
		
		// all documentc requested per AJAX should have this part to turn off the browser and proxy cache for any XHR request
		header('Cache-Control: no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0');
		
		$userprivilegien = $this->dbObj->sqlGet("select etchat_userprivilegien from {$this->_prefix}etchat_user WHERE etchat_user_id = ".(int)$_SESSION['etchat_'.$this->_prefix.'user_id']);
		
		if ($userprivilegien[0][0]=="admin" || $userprivilegien[0][0]=="mod" || $userprivilegien[0][0]=="user"){
			
			if(!empty($_POST['modpw'])){
				$this->dbObj->sqlSet("UPDATE {$this->_prefix}etchat_user SET etchat_userpw = '".md5($_POST['modpw'])."' WHERE etchat_user_id = ".(int)$_SESSION['etchat_'.$this->_prefix.'user_id']);
				echo "1";
			} else 
				echo "Error! You shouldn't be here.";
		}

		else if ($this->_allow_nick_registration && $_SESSION['etchat_'.$this->_prefix.'user_priv']=="gast" && !empty($_POST['user_pw'])){
			
			if (isset($_COOKIE['cookie_etchat_nik_registered'])){
				// create new LangXml Object
				$langObj = new LangXml();
				$lang=$langObj->getLang()->changepw_php[0];
				echo $lang->warning[0]->tagData;
			}
			else{	
				setcookie("cookie_etchat_nik_registered", "1", ["expires"  => time()+(24*3600), "path" => "/", "samesite" => "lax"]);
				//setcookie("cookie_etchat_nik_registered", "1");
				$this->dbObj->sqlSet("UPDATE {$this->_prefix}etchat_user SET etchat_userpw = '".md5($_POST['user_pw'])."', etchat_userprivilegien='user', etchat_reg_timestamp=now(), etchat_reg_ip='".$_SERVER['REMOTE_ADDR']."' WHERE etchat_user_id = ".(int)$_SESSION['etchat_'.$this->_prefix.'user_id']);
				echo "1";
			}
		}
		// close DB connection
		$this->dbObj->close();
	}
}