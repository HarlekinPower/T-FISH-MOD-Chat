<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@sedesign.de
# WWW: http://www.sedesign.de
#
# File: Zusatztool_Anbindung_an_Fremduserverwaltung.php modified by T-FISH
# WWW: https://et-chat.de
########################################################################################################################*/
session_start();
//*****************************************************************************
// Für die Realisierung der Anbindung des Chats an Ihr Userverwaltungssystem aus einem
// Forum, CMS, usw. müssen Sie lediglich die unten stehenden Sessionvariablen
// in Ihrem System mit dem Usernamen belegen und den User mit einem
// Link auf diese File führen. Beachten Sie dass dabei der Username ohne Passwort übertragen wird. 
// Sie dürfen also in Chat keine Passwörter für Admins und Mods anlegen. Für einen  Chatbenutzer ist die
// Übergabe des Usernamen über die Sessionvar. $_SESSION['etchat_username'] aus Ihrem
// System ausreichend.

$username = $_SESSION['etchat_username'];
$gender = $_SESSION['etchat_gender']; //[optional] 'f' or 'm' system default 'n' if unset

// Die Admins und Mods sollen ohne PW im Chat angelegt werden!
// Die class/Index.class.php soll gelöscht werden, damit niemand unbefugt als Afmin rein kann!

// WICHTIG! 
// In der config.php sollte die Option der Namereservierungen ausgeschaltet sein, wenn die Anbindung
// an eine Benutzerverwaltung verwendet wird.
// >>>>>>>>>>>>>>>>>>> $allow_nick_registration = false; <<<<<<<<<<<<<<<<<<<<


//---------------------------------------------------------------------------
// oder als GET oder POST Übergabe, jedoch unsicher und sollte kodiert werden
// $username = $_REQUEST['etchat_username'];
// $gender = $_REQUEST['etchat_gender'];
//---------------------------------------------------------------------------

// Weiterleitung nach dem Logout(die Session bleibt bestehen,
// da sonst der User aus Ihrem System rausfliegt.)

// WICHTIG!!!  '...db1_...'  sollte dem Tabellenprefix in der config.php ($prefix) entsprechen!!!

$_SESSION['etchat_db1_logout_url']="http://www.Ihre_Webseite.de/aus_dem_chat_ausgeloggt.html";

##############################################################
# DO NOT EDIT BELOW ###############################################
##############################################################

spl_autoload_register(function ($class_name) {
    require_once ('class/'.$class_name.'.class.php');      
});

// initialise
new CheckUserName(true, $username, $gender);

?>