<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@sedesign.de
# WWW: http://www.sedesign.de
#
# File: RoomEntrance.class.php modified by T-FISH
# WWW: https://et-chat.de
#
# Class RoomEntrance, makes all needed things, like messages on user entrance
########################################################################################################################*/

class RoomEntrance extends EtChatConfig
{
	/**
	* DB-Connection Obj
	* @var ConnectDB
	*/
	private $dbObj;

	/**
	* AAFParser Obj with the needed lang tag from XML lang-file
	* @var AAFParser
	*/
	private $_lang;
	
	/**
	* Constructor
	*
	* @param  ConnectDB $dbObj, Obj with the db connection handler
	* @param  AAFParser $lang, Obj with the needed lang tag from XML lang-file
	* @uses ConnectDB::sqlGet()
	* @return void
	*/
	public function __construct ($dbObj, $lang){ 
		
		// call parent Constructor from class EtChatConfig
		parent::__construct();
		
		$this->dbObj=$dbObj;
		$this->_lang=$lang;
		
		// get the room entrance message 
		$room_message=$this->dbObj->sqlGet("SELECT etchat_room_message FROM {$this->_prefix}etchat_rooms where etchat_id_room = 1");
		
		// if invisible mode on entrance
		if (!empty($_POST['status_invisible']) && ($_SESSION['etchat_'.$this->_prefix.'user_priv']=='admin' || $_SESSION['etchat_'.$this->_prefix.'user_priv']=='mod')) 
			$_SESSION['etchat_'.$this->_prefix.'invisible_on_enter'] = true;
		else 
			$_SESSION['etchat_'.$this->_prefix.'invisible_on_enter'] = false;
		
		// if no room message, just make a user entrance message
		if (empty($room_message[0][0])) $this->withoutRoomMessage();
		// else make make room entrance message first and then a user entrance message
		else $this->withRoomMessage($room_message[0][0]);
		
		// this is a very important value. Its a counter for all incomming messages that will be shown in the user chat-window. It is needed 
		// by chat.js for making a unique and continuous id for every gotten dataset.
		$_SESSION['etchat_'.$this->_prefix.'last_id'] = 0;
	}
	
	/**
	* WithoutRoomMessage
	*
	* @return void
	*/
	private function withoutRoomMessage(){	

		$an = (!empty($_POST['status_invisible']) && ($_SESSION['etchat_'.$this->_prefix.'user_priv']=='admin' || $_SESSION['etchat_'.$this->_prefix.'user_priv']=='mod')) ? $_SESSION['etchat_'.$this->_prefix.'user_id'] : 0;
		
		// the first message id that have been shown for the user. This var will be worked up in reloader
		$sysMessObj = new SysMessage($this->dbObj, "<b>".$_SESSION['etchat_'.$this->_prefix.'username']."</b> ".$this->_lang->eintritt[0]->tagData, 0, $an );
		$_SESSION['etchat_'.$this->_prefix.'my_first_mess_id'] = $sysMessObj->lastInsertedId;
	}
	
	/**
	* WithoutRoomMessage
	*
	* @param string $room_message, message on room entrance
	* @return void
	*/
	private function withRoomMessage($room_message){	
	
		$an = (!empty($_POST['status_invisible']) && ($_SESSION['etchat_'.$this->_prefix.'user_priv']=='admin' || $_SESSION['etchat_'.$this->_prefix.'user_priv']=='mod')) ? $_SESSION['etchat_'.$this->_prefix.'user_id'] : 0;
		
		// word wrap in WIN
		$room_message_insert = str_replace("\r\n","<br />",$room_message);
		// word wrap in LIN, Uniux, MacOS
		$room_message_insert = str_replace("\n","<br />",$room_message_insert);

		// the first message id that have been shown for the user. This var will be worked up in reloader

		$sysMessObj = new SysMessage($this->dbObj, "<br /><div style=\"margin: 4px;\">".$room_message_insert."</div>", 1, $_SESSION['etchat_'.$this->_prefix.'user_id']);	
		$_SESSION['etchat_'.$this->_prefix.'my_first_mess_id'] = $sysMessObj->lastInsertedId;		
		new SysMessage($this->dbObj, "<b>".$_SESSION['etchat_'.$this->_prefix.'username']."</b> ".$this->_lang->eintritt[0]->tagData, 0, $an );
		
	}
}