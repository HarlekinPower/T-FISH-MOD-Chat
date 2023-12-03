<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@s-e-d.de
# WWW: http://www.sedesign.de
#
# File: Insert2Blacklist.class.php modified by T-FISH
# WWW: https://et-chat.de
#
# Insert2Blacklist, insert the user to the Blacklist
########################################################################################################################*/

class Insert2Blacklist extends DbConectionMaker
{
	/**
	* Constructor
	*
	* @uses ConnectDB::sqlGet()	
	* @uses ConnectDB::sqlSet()	
	* @uses ConnectDB::close()	
	* @uses LangXml object creation
	* @uses LangXml::getLang() parser method
	* @uses Blacklist object creation
	* @uses Blacklist::insertUser()
	* @return void
	*/
	public function __construct (){
	
		// call parent Constructor from class DbConectionMaker
		parent::__construct();
		
		session_start();

		header('Cache-Control: no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0');
		
		// create new LangXml Object
		$langObj = new LangXml();
		$lang=$langObj->getLang()->admin[0]->add2blacklist[0];
		
		if($_SESSION['etchat_'.$this->_prefix.'user_priv']=="admin" || $_SESSION['etchat_'.$this->_prefix.'user_priv']=="mod"){
				
			$ip=$this->dbObj->sqlGet("SELECT etchat_onlineip FROM {$this->_prefix}etchat_useronline WHERE etchat_onlineuser_fid = ".(int)$_POST['user_id']);
			
			if (is_array($ip)){	
				if ($_POST['time']>0) {
					// create new Blacklist Object
					$blObj = new Blacklist($this->dbObj);
					$blObj->insertUser((int)$_POST['user_id'],(int)$_POST['time']);
				}else{
					$this->dbObj->sqlSet("INSERT INTO {$this->_prefix}etchat_kick_user (etchat_kicked_user_id, etchat_kicked_user_time) VALUES (".(int)$_POST['user_id'].", ".(date("U")+30).")");
				}
			}else{
				echo $lang->user_away[0]->tagData;
			}
			
			$this->dbObj->close();

		}else{
			echo $lang->session_lost[0]->tagData;
		}
	}
}
