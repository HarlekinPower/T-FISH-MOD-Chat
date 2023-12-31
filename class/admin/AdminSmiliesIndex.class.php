<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@sedesign.de
# WWW: http://www.sedesign.de
#
# File: AdminSmiliesIndex.class.php modified by T-FISH
# WWW: https://et-chat.de
#
# Class AdminSmiliesIndex - Admin area
########################################################################################################################*/

class AdminSmiliesIndex extends DbConectionMaker
{

	/**
	* Constructor
	*
	* @uses LangXml object creation
	* @uses LangXml::getLang() parser method
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
		
		// create new LangXml Object
		$langObj = new LangXml();
		$lang=$langObj->getLang()->admin[0]->admin_smilies[0];
		$print_smil_list = '';
		
		if ($_SESSION['etchat_'.$this->_prefix.'user_priv']=="admin"){
			
						
			// Checksum to prevent this: http://www.sedesign.de/sed/forum/forum_entry.php?id=7154
			$_SESSION['etchat_'.$this->_prefix.'CheckSum4RegUserEdit'] = rand(1,999999999);
			
			
			$feld=$this->dbObj->sqlGet("SELECT * FROM {$this->_prefix}etchat_smileys");
			$this->dbObj->close();
			
			if (is_array($feld)){
			
				$i = 0;
				foreach($feld as $datasets){
					$i++;
	
					if($i % 2 == 0): $bgcolor = 'class="ungerade"'; else: $bgcolor='class="gerade"'; endif;
	
					$print_smil_list.= "<tr ".$bgcolor.">
					<td align='center'><img src='./".$datasets[2]."' border='0'></td>
					<td >
					".$datasets[1]."
					</td>
					<td >
					<a href=\"./?AdminRenameSmilies&id=".$datasets[0]."\">".$lang->rename[0]->tagData."</a>
					</td>
					<td >
					<a href=\"./?AdminDeleteSmilies&id=".$datasets[0]."&pic=".$datasets[2]."&cs4rue=".$_SESSION['etchat_'.$this->_prefix.'CheckSum4RegUserEdit']."\">".$lang->delete[0]->tagData."</a>
					</td></tr>";
				}
			}
			
			// initialize Template
			$this->initTemplate($lang, $print_smil_list);
			
		}else{
			echo $lang->error[0]->tagData;
			return false;
		}
		
	}
	
	/**
	* Initializer for template
	*
	* @param  String $print_smil_list
	* @param  AAFParser $lang, Obj with the needed lang tag from XML lang-file
	* @return void
	*/
	private function initTemplate($lang, $print_smil_list){
		// Include Template
		include_once("styles/admin_tpl/indexSmilies.tpl.html");
	}
}