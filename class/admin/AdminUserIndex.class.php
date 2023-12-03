<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@s-e-d.de
# WWW: http://www.sedesign.de
#
# File: AdminUserIndex.class.php modified by T-FISH
# WWW: https://et-chat.de
#
# Class AdminUserIndex - Admin area
########################################################################################################################*/

class AdminUserIndex extends DbConectionMaker
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
			
			$feld=$this->dbObj->sqlGet("SELECT etchat_user_id, etchat_username, etchat_userpw, etchat_userprivilegien FROM {$this->_prefix}etchat_user WHERE etchat_userprivilegien='admin' OR etchat_userprivilegien='mod'");
			$this->dbObj->close();
			
			if (is_array($feld)){
				$print_user_list="<table>";
				foreach($feld as $datasets)
					$print_user_list.="<tr><td>".$datasets[1]."</td><td>(<i>".$datasets[3]."</i>)</td><td>&nbsp;&nbsp;&nbsp;</td><td><a href=\"./?AdminEditUser&id=".$datasets[0]."\">".$lang->edit[0]->tagData."</a></td></tr>";
				$print_user_list.="</table>";
			} else $print_user_list=$lang->noadmins[0]->tagData;
			// initialize Template
			$this->initTemplate($lang, $print_user_list);
			
		}else{
			echo $lang->error[0]->tagData;
			return false;
		}
		
	}
	
	/**
	* Initializer for template
	*
	* @param  String $print_user_list
	* @param  AAFParser $lang, Obj with the needed lang tag from XML lang-file
	* @return void
	*/
	private function initTemplate($lang, $print_user_list){
		// Include Template
		include_once("styles/admin_tpl/indexUser.tpl.html");
	}
}