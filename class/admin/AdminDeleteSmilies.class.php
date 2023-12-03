<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@s-e-d.de
# WWW: http://www.sedesign.de
#
# File: AdminDeleteSmilies.class.php modified by T-FISH
# WWW: https://et-chat.de
#
# Class AdminDeleteSmilies - Admin area
########################################################################################################################*/

class AdminDeleteSmilies extends DbConectionMaker
{

	/**
	* Constructor
	*	
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
			
			// Checksum to prevent this: http://www.sedesign.de/sed/forum/forum_entry.php?id=7154
			if($_GET['cs4rue']!=$_SESSION['etchat_'.$this->_prefix.'CheckSum4RegUserEdit'] || !isset($_GET['cs4rue']) || !isset($_SESSION['etchat_'.$this->_prefix.'CheckSum4RegUserEdit'])){
				echo "Dear Admin this User tried to fake you. ;-)";
				return false;
			}
			
			$this->dbObj->sqlSet("DELETE FROM {$this->_prefix}etchat_smileys WHERE etchat_smileys_id = ".(int)$_GET['id']);
			unlink("./".$_GET['pic']);
			$this->dbObj->close();
			header("Location: ./?AdminSmiliesIndex");

		}else{
			echo $lang->error[0]->tagData;
			return false;
		}
	}
}