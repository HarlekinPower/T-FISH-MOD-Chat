<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@s-e-d.de
# WWW: http://www.sedesign.de
#
# File: AdminUpdateSmilies.class.php modified by T-FISH
# WWW: https://et-chat.de
#
# Class AdminUpdateSmilies - Admin area
########################################################################################################################*/

class AdminUpdateSmilies extends DbConectionMaker
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
		$lang=$langObj->getLang()->admin[0]->admin_smilies[0];
		
		
		if ($_SESSION['etchat_'.$this->_prefix.'user_priv']=="admin"){
			
			// Test if the sign exists in the DB
			$res = $this->dbObj->sqlGet("select etchat_smileys_id FROM {$this->_prefix}etchat_smileys where etchat_smileys_sign = '".$_POST['smileys_sing']."'");
			if (is_array($res)){
				$this->dbObj->close();
				// Include error Template
				include_once("styles/admin_tpl/errorSmileySignExists.tpl.html");
			}else{
				$this->dbObj->sqlSet("UPDATE {$this->_prefix}etchat_smileys SET etchat_smileys_sign = '".$_POST['smileys_sing']."' WHERE etchat_smileys_id = ".(int)$_POST['id']);
				$this->dbObj->close();
				header("Location: ./?AdminSmiliesIndex");
			}

		}else{
			echo $lang->error[0]->tagData;
			return false;
		}
	}
}