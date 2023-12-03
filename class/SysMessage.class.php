<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@s-e-d.de
# WWW: http://www.sedesign.de
#
# File: SysMessage.class.php modified by T-FISH
# WWW: https://et-chat.de
#
# Class SysMessage, just a method to set sys messages
########################################################################################################################*/

class SysMessage extends EtChatConfig
{
	
	/**
	* DB-Connection Obj
	* @var ConnectDB
	*/
	protected $dbObj;
	
	/**
	* Last ID from an inserted message into db
	* @var int
	*/
	public $lastInsertedId;
	
	/**
	* Constructor
	*
	* @param  ConnectDB $dbObj, Obj with the db connection handler
	* @param  string $message, message text
	* @param  int $room_fid, room id (0= at all rooms)
	* @param  int $privat, user id (0= at all user in this room)
	* @uses ConnectDB::sqlSet()
	* @uses ConnectDB::$lastId
	* @return int, the inserted message dataset id from db
	*/
	public function __construct ($dbObj, $message, $room_fid, $privat){	
		
		// call parent Constructor from class EtChatConfig
		parent::__construct();
		
		$dbObj->sqlSet("INSERT INTO {$this->_prefix}etchat_messages ( etchat_user_fid, etchat_text, etchat_text_css, etchat_timestamp, etchat_fid_room, etchat_privat, etchat_user_ip)
		VALUES ( 1, '".$message."', 'color:#".$_SESSION['etchat_'.$this->_prefix.'syscolor'].";font-weight:normal;font-style:normal;', '".date('U')."', ".$room_fid.", ".$privat.", '".$_SERVER['REMOTE_ADDR']."')");
		
		// unfortunately the PDO::lastInsertId() just works on MySQL and SQLITE, but not on PGSQL
		if (!empty($dbObj->lastId)) $this->lastInsertedId = $dbObj->lastId;
		else {
			$lastID = $dbObj->sqlGet("SELECT max(etchat_id) from {$this->_prefix}etchat_messages");
			$this->lastInsertedId = $lastID[0][0];
		}
	}
}