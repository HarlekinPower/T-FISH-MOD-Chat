<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@sedesign.de
# WWW: http://www.sedesign.de
#
# File: config.php modified by T-FISH
# WWW: https://et-chat.de
#
# Config DB and Chat parameters
########################################################################################################################*/

/* Database name
Datenbankname*/
$database = "etchat";

/* Hostname database
Datenbank Hostname*/
$sqlhost = "localhost";

/* Username database
Datenbank Username*/
$sqluser = "root";

/* Password database
Datenbank Passwort*/
$sqlpass = "";

/* Prefix with the table names and all session variables
Prefix bei den Tabellennamen und allen Sessionvariablen*/
$prefix = "db1_";

/* Parameter is always needed to generate the right SQL syntaxis and also select the correct DB when connecting via PDO
Parameter wird IMMER benötigt um die richtige SQL-Syntaxis zu erzeugen und auch bei der Anbindung über PDO umd die richtige DB auszuwählen*/
$usedDatabaseType = "mysql";

// ########################################################################################################################
/*Which database connection should be used?
If you are not particularly familiar with the server configuration, you should not change these settings!
 Welche Datenbankanbindung soll benutzt werden?
 Wenn Sie sich mit der Serverkonfiguration nicht besonders gut auskennen, sollen Sie diese Einstellungen nicht verändern!*/

/* PDO is the uniform database connection component in PHP5 for all databases, i.e. MySQL
PDO ist die einheitliche Datenbankanbindungskomponennte in PHP5 für alle Datenbanken, also MySQL*/

$usedDatabaseExtension = "pdo";

/* If you wish or if the PDO is not available, the MySQLI can be used for connection to MySQL.
It is said to be a little more performing.
Nach Wunsch oder wenn die PDO nicht verfügbar ist, kann die MySQLi für die Anbindung an MySQL benutzt werden. 
Es soll angeblich auch etwas performanter sein.*/

//$usedDatabaseExtension = "mysqli";

// ########################################################################################################################
/* Optionally to change the chat parameter
Chatparameter optional zu verändern*/

/* How many old messages does the user see when he enters the chat for the first time.
Wieviele alte Messages sieht der User, wenn er den Chat erstmalig betritt.*/
$messages_shown_on_entrance = 1;

/* How many times can you log into the chat in three minutes.
Wieviele Male darf man sich in drei Muten in den Chat neu einloggen.*/
$limit_logins_in_three_minutes = 5;

/* Allow private messages in chat window.
Privatmessages im Chatfenster erlauben.*/
$allowed_privates_in_chat_win = true;

/* Allow separate private chat windows.
Separate Privatchatfenster erlauben.*/
$allowed_privates_in_separate_win = true;

/* In false, the history / chat history is only visible to admin and mod.
Bei False ist die History / der Chatverlauf nur für Admin und Mod sichtbar.*/
$show_history_all_user = true;

/* How long shouldn't the user write until he flies out of the chat
Time in milliseconds: 1 second = 1000 milliseconds
Wie lange darf der User nichts schreiben bis er aus dem Chat rausfliegt 
Zeitangabe im Millisekunden: 1 Sekunde = 1000 Millisekunden*/
$interval_for_inactivity=1800000;

/* Start setting for Messages sound  [ none | privat | all ]
none = no Sounds
privat = Sounds only for incoming private messages
all = Sounds for all messages in the chat
Starteinstellung beim Messages-Sound [ none | privat | all ]
none = keine Sounds
privat = Sounds nur für eingehende private Nachrichten
all: Sounds für alle Nachrichten im Chat*/
$messages_sound = "all";

// Should the general system messages be displayed at the start?
// Sollen die allgemeinen Systemnachrichten beim Start angezeigt werden?
$show_sys_messages = true;

/* Nickname Registration allow
Niknameregistrierung erlauben*/
$allow_nick_registration = true;
/*IMPORTANT!!! If the connection of the chat to a foreigner management via the additional Zusatztool_Anbindung_an_Fremduserverwaltung.php
is implemented, no chat user may be able to define your own password. Therefore, when using
Additional Zusatztool_Anbindung_an_Fremduserverwaltung.php the $allow_nick_ Registration = false; be switched!*/
/*WICHTIG!!! Wenn die Anbindung des Chats an eine Fremduserverwaltung über die Zusatztool_Anbindung_an_Fremduserverwaltung.php
umgesetzt wird, darf kein Chatbenutzer ein eigenes Passwort festlegen können. Deshalb sollte bei der Verwendung von 
Zusatztool_Anbindung_an_Fremduserverwaltung.php die $allow_nick_registration = false; geschaltet sein!*/

/*If the time display is incorrectly in the chat, comment out the following line
Bei falscher Zeitanzeige im Chat die folgende Zeile auskommentieren*/

//date_default_timezone_set('Europe/Berlin');
// ########################################################################################################################