<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@sedesign.de
# WWW: http://www.sedesign.de
#
# File: AdminRegUserEdit.class.php modified by T-FISH
# WWW: https://et-chat.de
#
# Class AdminRegUserEdit - Admin area
########################################################################################################################*/

class AdminRegUserEdit extends DbConectionMaker
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
		$lang=$langObj->getLang()->admin[0]->admin_reg_user[0];
		
		if ($_SESSION['etchat_'.$this->_prefix.'user_priv']=="admin"){		
		
			if (isset($_POST['userids'])){
				$ids=explode(',', $_POST['userids']);
			
				foreach($ids as $id)
					$this->dbObj->sqlSet("UPDATE {$this->_prefix}etchat_user SET etchat_userpw = NULL, etchat_userprivilegien = 'gast' WHERE etchat_user_id=".(int)$id);
			
			} else {
			
			
				// Checksum to prevent this: http://www.sedesign.de/sed/forum/forum_entry.php?id=7154
				if($_GET['cs4rue']!=$_SESSION['etchat_'.$this->_prefix.'CheckSum4RegUserEdit'] || !isset($_GET['cs4rue']) || !isset($_SESSION['etchat_'.$this->_prefix.'CheckSum4RegUserEdit'])){
					echo "Dear Admin this User tried to fake you. ;-)";
					$this->dbObj->close();
					return false;
				}
			
			
				if (isset($_GET['mod']))
					$this->dbObj->sqlSet("update {$this->_prefix}etchat_user set etchat_userprivilegien='mod' WHERE etchat_user_id = ".(int)$_GET['id']);
				
				if (isset($_GET['admin']))
					$this->dbObj->sqlSet("update {$this->_prefix}etchat_user set etchat_userprivilegien='admin' WHERE etchat_user_id = ".(int)$_GET['id']);
			}
			$this->dbObj->close();
			header("Location: ./?AdminRegUserIndex");
			
		}else{
			echo $lang->error[0]->tagData;
			return false;
		}
	}
}