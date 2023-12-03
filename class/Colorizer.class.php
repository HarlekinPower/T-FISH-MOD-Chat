<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@s-e-d.de
# WWW: http://www.sedesign.de
#
# File: Colorizer.class.php modified by T-FISH
# WWW: https://et-chat.de
#
# Class Colorizer, generate colortable and color slder
########################################################################################################################*/

class Colorizer extends EtChatConfig
{

	/**
	* LangXml Obj for Colorizer
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
		
		// starts session for LangXml Object
		session_start();
		
		// Disable Browser Chache
		header('Cache-Control: no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0');
	
		// create new LangXml Object
		$langObj = new LangXml();
		$this->lang=$langObj->getLang()->farben_fenster_php[0];
	
		// initialize template
		include_once("./styles/colorizer.tpl.html");
	}
}
