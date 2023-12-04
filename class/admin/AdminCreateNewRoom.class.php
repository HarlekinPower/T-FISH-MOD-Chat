<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@sedesign.de
# WWW: http://www.sedesign.de
#
# File: AdminCreateNewRoom.class.php modified by T-FISH
# WWW: https://et-chat.de
#
# Class AdminCreateNewRoom
########################################################################################################################*/

class AdminCreateNewRoom extends DbConectionMaker
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
		$lang=$langObj->getLang()->admin[0]->admin_rooms[0];
		
		
		if ($_SESSION['etchat_'.$this->_prefix.'user_priv']=="admin"){
			
			if ($_POST['room_priv']==3) 
				$this->dbObj->sqlSet("INSERT INTO {$this->_prefix}etchat_rooms (etchat_roomname, etchat_room_goup, etchat_room_pw) VALUES ('".$_POST['room']."', ".((int)$_POST['room_priv']).", '".$_POST['roompw']."')");
			else 
				$this->dbObj->sqlSet("INSERT INTO {$this->_prefix}etchat_rooms (etchat_roomname, etchat_room_goup) VALUES ('".$_POST['room']."', ".((int)$_POST['room_priv']).")");
	
			$this->dbObj->close();
			header("Location: ./?AdminRoomsIndex");
			
		}else{
			echo $lang->error[0]->tagData;
			return false;
		}
	}
}