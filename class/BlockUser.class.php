<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@s-e-d.de
# WWW: http://www.sedesign.de
#
# File: BlockUser.class.php modified by T-FISH
# WWW: https://et-chat.de
#
# BlockUser, for user blocking in the session
########################################################################################################################*/

class BlockUser extends EtChatConfig
{
	/**
	* Constructor
	*
	* @return void
	*/
	public function __construct (){
	
		session_start();
		
		// call parent Constructor from class EtChatConfig
		parent::__construct();
		
		// all documentc requested per AJAX should have this part to turn off the browser and proxy cache for any XHR request
		header('Cache-Control: no-store, no-cache, must-revalidate, pre-check=0, post-check=0, max-age=0');
		
		$_SESSION['etchat_' . $this->_prefix . 'block_priv'] = $_SESSION['etchat_' . $this->_prefix . 'block_priv'] ?? [];
		$_SESSION['etchat_' . $this->_prefix . 'block_all'] = $_SESSION['etchat_' . $this->_prefix . 'block_all'] ?? [];

		// Block all messages
		if (isset($_POST['block_all'])){
			// Der User ist bereits blokiert und wird wieder freigegeben
			// The user is blocked now, so hi will be decontrolled
			if (in_array($_POST['block_all'], $_SESSION['etchat_'.$this->_prefix.'block_all'])){
				$key_from_all = array_search($_POST['block_all'], $_SESSION['etchat_'.$this->_prefix.'block_all']);
				$_SESSION['etchat_'.$this->_prefix.'block_all'][$key_from_all]=99999999999;

				// Falls der User bereits in privat gesperrt ist, wird dieser Schlüssel gelöscht
				// If the user is blocked now by privat option, this key will be deleted
				$key_from_priv = array_search($_POST['block_all'], $_SESSION['etchat_'.$this->_prefix.'block_priv']);
				$_SESSION['etchat_'.$this->_prefix.'block_priv'][$key_from_priv]=99999999999;
			}
			// Der User wird erst blokiert
			// The user will be blocked by first time
			else {
        	    $_SESSION['etchat_'.$this->_prefix.'block_all'][] = $_POST['block_all'];

				// Falls der User bereits in privat gesperrt ist, wird dieser Schlüssel gelöscht
				// If the user is blocked now by privat option, this key will be deleted
				$key_from_priv = array_search($_POST['block_all'], $_SESSION['etchat_'.$this->_prefix.'block_priv']);
				$_SESSION['etchat_'.$this->_prefix.'block_priv'][$key_from_priv]=99999999999;
             }

		}
		// Block private messages
		if (isset($_POST['block_priv'])){
			if (in_array($_POST['block_priv'], $_SESSION['etchat_'.$this->_prefix.'block_priv'])){
				$key_from_priv = array_search($_POST['block_priv'], $_SESSION['etchat_'.$this->_prefix.'block_priv']);
				$_SESSION['etchat_'.$this->_prefix.'block_priv'][$key_from_priv]=99999999999;


				// Falls der User bereits in all gesperrt ist, wird dieser Schlüssel gelöscht
				// If the user is blocked now by "all" option, this key will be deleted
				$key_from_all = array_search($_POST['block_priv'], $_SESSION['etchat_'.$this->_prefix.'block_all']);
				$_SESSION['etchat_'.$this->_prefix.'block_all'][$key_from_all]=99999999999;
			}
			else {
				$_SESSION['etchat_'.$this->_prefix.'block_priv'][] = $_POST['block_priv'];

				// Falls der User bereits in all gesperrt ist, wird dieser Schlüssel gelöscht
				// If the user is blocked now by "all" option, this key will be deleted
				$key_from_all = array_search($_POST['block_priv'], $_SESSION['etchat_'.$this->_prefix.'block_all']);
				$_SESSION['etchat_'.$this->_prefix.'block_all'][$key_from_all]=99999999999;
			}
		}

		// Make output
		if (isset($_POST['show'])){
			if (in_array($_POST['show'], $_SESSION['etchat_'.$this->_prefix.'block_priv'])) echo "priv";
			if (in_array($_POST['show'], $_SESSION['etchat_'.$this->_prefix.'block_all'])) echo "all";
		}
	}
}