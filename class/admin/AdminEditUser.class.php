<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@sedesign.de
# WWW: http://www.sedesign.de
#
# File: AdminEditUser.class.php modified by T-FISH
# WWW: https://et-chat.de
#
# Class AdminEditUser - Admin area
########################################################################################################################*/

class AdminEditUser extends DbConectionMaker
{

	/**
	* Constructor
	*
	* @uses LangXml object creation
	* @uses LangXml::getLang() parser method
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
		
		
		if ($_SESSION['etchat_'.$this->_prefix.'user_priv']=="admin"){
			
						
			// Checksum to prevent this: http://www.sedesign.de/sed/forum/forum_entry.php?id=7154
			$_SESSION['etchat_'.$this->_prefix.'CheckSum4RegUserEdit'] = rand(1,999999999);
			
			
			$feld=$this->dbObj->sqlGet("SELECT etchat_user_id, etchat_username, etchat_userpw, etchat_userprivilegien FROM {$this->_prefix}etchat_user WHERE etchat_user_id=".(int)$_GET['id']);
			$this->dbObj->close();
						
			// initialize Template
			$this->initTemplate($lang, $feld);
			
		}else{
			echo $lang->error[0]->tagData;
			return false;
		}	
	}
	
	/**
	* Initializer for template
	*
	* @param Array $feld
	* @param AAFParser $lang, Obj with the needed lang tag from XML lang-file
	* @return void
	*/
	private function initTemplate($lang, $feld){
		// Include Template
		include_once("styles/admin_tpl/editUser.tpl.html");
	}
}