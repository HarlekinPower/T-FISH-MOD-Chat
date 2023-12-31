<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@sedesign.de
# WWW: http://www.sedesign.de
#
# File: ConnectDB.class.php modified by T-FISH
# WWW: https://et-chat.de
#
# Class ConnectDB, database connectivity class based on PDO Extension
########################################################################################################################*/

class ConnectDB extends EtChatConfig{
	
	/**
	* PDO Obj with DB connect
	* @var PDO
	*/
	protected $_connid;
	
	/**
	* last inserted id in the db after any sql-manipulation-statements
	* @var int
	*/
	public $lastId;
	
	/**
	* Constructor,  creates a db connectivity
	*
	* @uses PDO object creation
	* @return void
	*/
	public function __construct (){
	
		// call parent Constructor from class EtChatConfig
		parent::__construct();
	
		try 
		{	
			$this->_connid = new PDO("{$this->_usedDatabase}:host={$this->_sqlhost};dbname=".$this->_database, $this->_sqluser, $this->_sqlpass);
		}
		catch(PDOException $e)
		{
			echo "ERROR: " . $e->getMessage();
			echo "<br /><h3>Bitte editieren Sie die config.php und tragen Sie dort die geforderten Parameter ein. Danach machen Sie weiter mit der Installationsroutine. Mehr dazu finden Sie unter install.txt !</h3>";
		}
	}
	
	/**
	* for making sql-select-queries
	*
	* @param  string $sql 
	* @uses PDO::query()	
	* @uses PDO::errorInfo()
	* @return array, with the datasets
	*/
	public function sqlGet($sql){
	
		// set query
		$erg = $this->_connid->query($sql);
		
		// on error
		$error_code=(int)$this->_connid->errorCode();
		if (!empty($error_code)) {
			$arr = $this->_connid->errorInfo();
			print_r($arr);
			echo $sql;
			if ($arr[1]==1146)
				echo "<br /><h4>Dieser Fehler deutet darauf, dass der ET-Chat nicht ordentlich in die Datenbank installiert wurde.
				Lesen Sie bitte dazu die readme.txt und nutzen Sie die <a href=\"install/\">Installationsroutine</a>.</h4>";
		}
		
		$resultArray = $erg->fetchAll(PDO::FETCH_NUM);
		
		$erg = null;
		
		if (!isset($resultArray) || empty($resultArray)) return 0;
		return $resultArray;
	}
	
	/**
	* for making sql-manipulation-queries
	*
	* @param  string $sql 
	* @uses PDO::exec()
	* @uses PDO::errorInfo()
	* @uses PDO::lastInsertId()
	* @return int, number of manipulated datasets
	*/
	public function sqlSet($sql){
		
		// set query
		$datasets = $this->_connid->exec($sql);
		
		// on error
		$error_code=(int)$this->_connid->errorCode();
		if (!empty($error_code)) {
			$arr = $this->_connid->errorInfo();
			print_r($arr);
			echo $sql;
		}
		
		// get last table ID after manipulation
		$this->lastId = $this->_connid->lastInsertId();
		return $datasets;
	}
	
	/**
	* close db connection
	*
	* @return void
	*/
	public function close(){
		$this->_connid=null;
	}
}