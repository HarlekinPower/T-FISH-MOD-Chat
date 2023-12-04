<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@sedesign.de
# WWW: http://www.sedesign.de
#
# File: AdminPropertyIndex.class.php modified by T-FISH
# WWW: https://et-chat.de
#
# Class PropertyIndex
########################################################################################################################*/

class AdminPropertyIndex extends DbConectionMaker
{

	/**
	* Constructor
	*
	* @uses LangXml object creation
	* @uses LangXml::getLang() parser method
	* @uses ConnectDB::sqlSet()	
	* @uses ConnectDB::sqlGet()	
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
		
		$this->configTabData2Session();
		$this->dbObj->close();
			
		// create new LangXml Object
		$langObj = new LangXml();
		$lang=$langObj->getLang()->admin[0]->admin_prop[0];
		
		
		if ($_SESSION['etchat_'.$this->_prefix.'user_priv']=="admin"){
			
			$handle = opendir("styles/");
			$print_styles = '';
			while($files = readdir($handle))
			{
				if($files != "." && $files != "..")
				{
					if (is_dir("styles/".$files) && $files!="admin_tpl" && $files!="install_tpl") {
                        if ($_SESSION['etchat_'.$this->_prefix.'style']==$files) $print_styles.= "<option value=\"".$files."\" selected>".$files."</option>\n";
                        else $print_styles.= "<option value=\"".$files."\">".$files."</option>\n";
					}
				}		
			}				
			
			$handle = opendir("lang/");
			$print_lang_files = '';
			while($files = readdir($handle))
			{
				if (!is_dir("lang/".$files) && stripos($files, '.xml')!==false && substr($files,0,5)=='lang_') {

					$xml_file = file_get_contents('lang/'.$files);
					$p = new AAFParser($xml_file);
					$p->Parse();
					if ($files == $_SESSION['etchat_'.$this->_prefix.'lang_xml_file']) $print_lang_files.= "<option value=\"".$files."\" selected>".$p->document->tagAttrs['lang']."</option>";
					else $print_lang_files.=  "<option value=\"".$files."\">".$p->document->tagAttrs['lang']."</option>";
				}
			}

			// initialize Template
			include_once("styles/admin_tpl/indexProperty.tpl.html");
			
		}else{
			echo $lang->error[0]->tagData;
			return false;
		}
		
	}
}