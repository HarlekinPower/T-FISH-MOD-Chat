<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@sedesign.de
# WWW: http://www.sedesign.de
#
# File: RoomAllowed.class.php modified by T-FISH
# WWW: https://et-chat.de
#
# Class RoomAllowed, check permissions for any user in any room
########################################################################################################################*/

class RoomAllowed extends EtChatConfig
{

	/**
	* Status for each user to use requested room
	* @var int
	*/
	public $room_status=0;
	
	/**
	* Constructor
	* Function zur Prüfung der Rechte der User im Raum
	* Return as $room_status: 1=allowed; 0=not_allowed; 2=password required
	*
	* @param int $room_id  from etchat_rooms.etchat_id_room
	* @param int $room_priv  from etchat_rooms.etchat_room_goup 
	* @return void
	*/
	public function __construct ($room_priv, $room_id){
	
		// call parent Constructor from class EtChatConfig
		parent::__construct();
		
		$room_allowed=0;
		if ($room_priv==4 && ($_SESSION['etchat_'.$this->_prefix.'user_priv']=="admin" || $_SESSION['etchat_'.$this->_prefix.'user_priv']=="mod" || $_SESSION['etchat_'.$this->_prefix.'user_priv']=="user")) $room_allowed=1;
		if ($room_priv==1 && ($_SESSION['etchat_'.$this->_prefix.'user_priv']=="admin" || $_SESSION['etchat_'.$this->_prefix.'user_priv']=="mod")) $room_allowed=1;
		if ($room_priv==2 && $_SESSION['etchat_'.$this->_prefix.'user_priv']=="admin") $room_allowed=1;
		if ($room_priv==0) $room_allowed=1;

		if ($room_priv==3 && $_SESSION['etchat_'.$this->_prefix.'user_priv']!="admin") $room_allowed=2;
		if ($room_priv==3 && $_SESSION['etchat_'.$this->_prefix.'user_priv']=="admin") $room_allowed=1;

		if (isset($_SESSION['etchat_'.$this->_prefix.'roompw_array']) && is_array($_SESSION['etchat_'.$this->_prefix.'roompw_array']) && $room_priv==3 && in_array($room_id, $_SESSION['etchat_'.$this->_prefix.'roompw_array']))$room_allowed=1;

		// Set the permission to the $this->room_status
		$this->room_status = $room_allowed;
	}
}