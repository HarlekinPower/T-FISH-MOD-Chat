<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@s-e-d.de
# WWW: http://www.sedesign.de
#
# File: Smileys.class.php modified by T-FISH
# WWW: https://et-chat.de
#
# Class Smileys, generate smiles list from db table
########################################################################################################################*/

class Smileys extends DbConectionMaker
{
	/**
	* Constructor
	*
	* @uses ConnectDB::sqlGet()
	* @uses ConnectDB::close()	
	* @return void
	*/
	public function __construct (){
	
		// call parent Constructor from class DbConectionMaker
		parent::__construct();
		
		// Disable Browser Chache
		header('Cache-Control: no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0');
		
		// get smileys from db
		$smil_array=$this->dbObj->sqlGet("SELECT etchat_smileys_sign, etchat_smileys_img FROM {$this->_prefix}etchat_smileys");

		// create HTML List with smileys
		foreach ($smil_array as $smil)
			echo "<img src=\"".$smil[1]."\" id=\"".$smil[0]."\" style=\"cursor:pointer;\">\n";
		
		// close DB connect
		$this->dbObj->close();
	}
}