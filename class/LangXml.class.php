<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@s-e-d.de
# WWW: http://www.sedesign.de
#
# File: LangXml.class.php modified by T-FISH
# WWW: https://et-chat.de
#
# Class LangXml, lang file controller
########################################################################################################################*/

class LangXml extends EtChatConfig
{
	/**
	* AAFParser Obj
	* @var AAFParser
	*/
	public $langXmlDoc;
	
	/**
	* Constructor
	*
	* @param  string $path relative path to language files
	* @param  string $xmlfile 
	* @uses AAFParser object creation
	* @uses AAFParser::Parse() parse the lang file
	* @uses AAFParser::$document root-tag as DOM Obj
	* @return void
	*/
	public function __construct ($path="./lang/", $xmlfile=""){	
		
		// call parent Constructor from class EtChatConfig
		parent::__construct();
		
		// if you want to use an other lang-file then was sets in the actual session
		$xmlfile = (empty($xmlfile)) ? $_SESSION['etchat_'.$this->_prefix.'lang_xml_file'] : $xmlfile;

		//if still empty
		if (empty($xmlfile)) $xmlfile = "lang_en.xml";
		
		// read the whole XML-Lang file
		$xml = @file_get_contents($path.$xmlfile);
		
		// create a AAFParser obj
		$parser = new AAFParser($xml);
		$parser->Parse();
		$this->langXmlDoc = $parser->document;
	}
	
	/**
	* Get language datasets for curent class
	*
	* @return AAFParser
	*/
	public function getLang(){	
		return $this->langXmlDoc;
	}
}