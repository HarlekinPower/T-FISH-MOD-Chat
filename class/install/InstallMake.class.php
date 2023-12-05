<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@sedesign.de
# WWW: http://www.sedesign.de
#
# File: InstallMake.class.php modified by T-FISH
# WWW: https://et-chat.de
#
# Class InstallMake - Install area
########################################################################################################################*/

class InstallMake extends DbConectionMaker
{

	/**
	* Constructor
	*
	* @uses ConnectDB::sqlSet()	
	* @uses ConnectDB::sqlGet()
	* @uses ConnectDB::close()	
	* @return void
	*/
	public function __construct (){ 
		
		// call parent Constructor from class DbConectionMaker
		parent::__construct(); 

		header('Cache-Control: no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0');
		
		if ($this->_usedDatabase == "mysql") $sql_dump="install/mysql_db.sql";

		if (file_exists($sql_dump)){
			$sql=explode("-- limit --", file_get_contents($sql_dump));
			for($a=0; $a<(count($sql)); $a++){
				$zeile=trim($sql[$a]);
				if (!empty( $zeile )) {
					$zeile = str_replace("###prefix###", $this->_prefix, $zeile);
					$this->dbObj->sqlSet($zeile);
				}
			}
			$this->dbObj->close();
			
			include_once("styles/install_tpl/installed.tpl.html");
		}
		else 
			echo "Install directory was not found.";
		
	}
}