<?php
/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@s-e-d.de
# WWW: http://www.sedesign.de
#
# File: index.php modified by T-FISH
# WWW: https://et-chat.de
########################################################################################################################*/

// Check Server param
if (version_compare(phpversion(), '8.0.0', '<')) echo "<div style=\"color:red\">FEHLER!!!<br><br>PHP Version = ".phpversion()." (sollte jedoch >= 8.0.0 sein!)</div>";
else		
// redirect
header('Location: ../?InstallIndex');