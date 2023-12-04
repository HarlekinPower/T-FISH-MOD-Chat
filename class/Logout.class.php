<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@sedesign.de
# WWW: http://www.sedesign.de
#
# File: Logout.class.php modified by T-FISH
# WWW: https://et-chat.de
#
# Logout, class to logout any user
########################################################################################################################*/

class Logout extends DbConectionMaker
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
		
		
		// Realy an user action?
		if($_SESSION['etchat_'.$this->_prefix.'random_user_number'] != $_GET['random_user_number'])
			return false;
			
		// create new LangXml Object
		$langObj = new LangXml();
		$lang=$langObj->getLang()->logout_php[0];
		
		if ($_SESSION['etchat_'.$this->_prefix.'userstatus']!="status_invisible")
			if (isset($_SESSION['etchat_'.$this->_prefix.'username']) && !empty($_SESSION['etchat_'.$this->_prefix.'username']))
				new SysMessage($this->dbObj, "<b>".$_SESSION['etchat_'.$this->_prefix.'username']."</b> ".$lang->exit[0]->tagData,0,0);
			
		$this->dbObj->sqlSet("DELETE FROM {$this->_prefix}etchat_useronline WHERE etchat_onlineuser_fid = ".(int)$_SESSION['etchat_'.$this->_prefix.'user_id']);
		
		if(!isset($_SESSION['etchat_'.$this->_prefix.'logout_url'])){
			@session_unset();
			@session_destroy();
			header("Location: ./");
		}
		else header("Location: ".$_SESSION['etchat_'.$this->_prefix.'logout_url']);
	}
}