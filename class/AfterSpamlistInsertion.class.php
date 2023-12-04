<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@sedesign.de
# WWW: http://www.sedesign.de
#
# File: AfterSpamlistInsertion.class.php modified by T-FISH
# WWW: https://et-chat.de
#
# Class AfterSpamlistInsertion, shows the page after the user is inserted into the blacklist bavouse of spam
########################################################################################################################*/

class AfterSpamlistInsertion extends DbConectionMaker
{

	/**
	* Constructor
	*
	* @uses ConnectDB::close()	
	* @uses LangXml object creation
	* @uses LangXml::getLang() parser method
	* @return void
	*/
	public function __construct (){ 
		
		// call parent Constructor from class DbConectionMaker
		parent::__construct(); 

		session_start();

		header('Cache-Control: no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0');
		
		$this->configTabData2Session();
		
		$this->dbObj->close();
		
		// create new LangXml Object
		$langObj = new LangXml();
		$lang=$langObj->getLang()->admin[0]->spam[0];
		
		// initialize template
		$this->initTemplate($lang);
	}
	
	/**
	* Initializer for template
	*
	* @return void
	*/
	private function initTemplate($lang){
		// Include Template
		include_once("styles/".$_SESSION['etchat_'.$this->_prefix.'style']."/spamlisted.tpl.html");
	}
}