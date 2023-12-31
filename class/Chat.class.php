<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@sedesign.de
# WWW: http://www.sedesign.de
#
# File: Chat.class.php modified by T-FISH
# WWW: https://et-chat.de
#
# Class Chat, chat page
########################################################################################################################*/

class Chat extends EtChatConfig
{
	/**
	* LangXml Obj for login page
	* @var LangXml
	*/
	public $lang;

	/**
	* Constructor
	*
	* @uses LangXml object creation
	* @uses LangXml::getLang() parser method
	* @return void
	*/
	public function __construct (){

		// call parent Constructor from class EtChatConfig
		parent::__construct();
		
		// starts session in chat.php
		session_start();

		// Sets charset and content-type for chat.php
		header('content-type: text/html; charset=utf-8');
		
		// Disable Browser Chache
		header('Cache-Control: no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0');
		
		// For user reloader, if this documents is just reloaded "F5", the onlineUserReloader have to send all userdata even although there no changes in the online list.  
		unset($_SESSION['etchat_'.$this->_prefix.'reload_user_anz']);
		
		// if direct requested whithout a login
		if (empty($_SESSION['etchat_'.$this->_prefix.'username'])){
			header('Location: ./');
			return false;
		}
		
		// create new LangXml Object
		$langObj = new LangXml;
		$this->lang=$langObj->getLang()->chat_php[0];

		$_SESSION['etchat_'.$this->_prefix.'random_user_number'] = rand(1,99999999999);
		// initialize chat template
		$this->initTemplate();
	}
	
	/**
	* Initializer for template
	*
	* @return void
	*/
	private function initTemplate(){
		// Include Template
		include_once("styles/".$_SESSION['etchat_'.$this->_prefix.'style']."/chat.tpl.html");
	}
	
}