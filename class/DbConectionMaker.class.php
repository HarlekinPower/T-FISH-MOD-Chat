<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@s-e-d.de
# WWW: http://www.sedesign.de
#
# File: DbConectionMaker.class.php modified by T-FISH
# WWW: https://et-chat.de
#
# Abstract Class DbConectionMaker, inherite a db-Object
########################################################################################################################*/

abstract class DbConectionMaker extends EtChatConfig
{
	/**
	* Database connection obj for all inherited classes
	* @var ConnectDB
	*/
	protected $dbObj;
	
	/**
	* Constructor
	*
	* @uses ConnectDB object creation
	* @return void
	*/
	protected function __construct (){
	
		// call parent Constructor from class EtChatConfig
		parent::__construct();
				
		if ($this->_usedDatabaseExtension=="pdo") $this->dbObj = new ConnectDB;
		if ($this->_usedDatabaseExtension=="mysqli") $this->dbObj = new ConnectDBMysqli;
		
	}
	
	/**
	* Sets the session vars in the chatsession from the etchat_config table
	* this function has only be run once at the beginning to get all needed params to the user session.
	*
	* @uses ConnectDB::sqlGet()	
	* @return void
	*/
	protected function configTabData2Session (){	
		// gets a array with the params from the etchat_config table
		$feld = $this->dbObj->sqlGet("select etchat_config_reloadsequenz, etchat_config_messages_im_chat, etchat_config_style, etchat_config_loeschen_nach, etchat_config_lang FROM {$this->_prefix}etchat_config where etchat_config_id=1");
		
		// setting all the session vars
		$_SESSION['etchat_'.$this->_prefix.'config_reloadsequenz'] = $feld[0][0];
		$_SESSION['etchat_'.$this->_prefix.'anz_messages_im_chat'] = $feld[0][1];
		$_SESSION['etchat_'.$this->_prefix.'style'] = $feld[0][2];
        $_SESSION['etchat_'.$this->_prefix.'loeschen_nach'] = $feld[0][3];
        $_SESSION['etchat_'.$this->_prefix.'lang_xml_file'] = $feld[0][4];
	}
}