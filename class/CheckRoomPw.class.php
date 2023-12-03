<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@s-e-d.de
# WWW: http://www.sedesign.de
#
# File: CheckRoomPw.class.php modified by T-FISH
# WWW: https://et-chat.de
#
# CheckRoomPw, checks the PW for PW-protected rooms
########################################################################################################################*/

class CheckRoomPw extends DbConectionMaker
{
	/**
	* Constructor
	*
	* @uses ConnectDB::sqlGet()	
	* @return void
	*/
	public function __construct (){
	
		// call parent Constructor from class DbConectionMaker
		parent::__construct();
	
		session_start();
		
		// all documentc requested per AJAX should have this part to turn off the browser and proxy cache for any XHR request
		header('Cache-Control: no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0');
		
		$freigabe=$this->dbObj->sqlGet("SELECT etchat_id_room FROM {$this->_prefix}etchat_rooms WHERE etchat_id_room = ".(int)$_POST['roomid']." AND etchat_room_pw = '".addslashes($_POST['layerpw'])."'");
		
		if (!is_array($freigabe)) echo "wrong";
		else{
			$_SESSION['etchat_'.$this->_prefix.'roompw_array'][]=$freigabe[0][0];
			echo "1";
		}
		
		// close DB connection
		$this->dbObj->close();
	}
}