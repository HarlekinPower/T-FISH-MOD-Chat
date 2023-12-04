/* #######################################################################################################################
# T-FISH-MOD-Chat is based on the ET-Chat V3.0.7 Realease 3 and is therefore also subject to the license from the ET-Chat!
# ET-Chat v3.x.x
# License: CCPL - http://creativecommons.org/licenses/by-nc/2.0/de/
# Autor: Evgeni Tcherkasski <SEDesign />
# E-mail: info@sedesign.de
# WWW: http://www.sedesign.de
#
# File: login.js modified by T-FISH
# WWW: https://et-chat.de
#########################################################################################################################*/


window.onload = function() {

// only needed becouse of a bug in ie8 rc1, there is no BG-image without any div manipilation by js
Element.show('lay_pw');
Element.hide('lay_pw');
//-------------------------------------------

  $("login").onsubmit = function(){

	if (!Element.visible('lay_pw')) $('pw').value='';
	$('submit_button').disabled = true;

    var myAjaxObj= new Ajax.Request(
                 "./?CheckUserName",
                 {
                  onSuccess: function(ajaxResult) {
                 	if (ajaxResult.responseText==1) location.href='./?Chat';
                 	else{
							$('submit_button').disabled = false;
                            if (ajaxResult.responseText=='pw' || ajaxResult.responseText=='pw+invisible') {
                                 	Element.show('lay_pw');
									if (ajaxResult.responseText=='pw+invisible') Element.show('lay_invisible');
                                 	Element.hide('lay_gender');
                                 	$("pw").focus();
                            } else {
                         		if (ajaxResult.responseText=='blacklist') location.href="./?AfterBlacklistInsertion";
                         		else if(!ajaxResult.responseText.empty()) alert(ajaxResult.responseText);
								else {
									$('username').value='';
									$('username').focus();
									}
                         		}
                         }
                 	},
                  postBody: $("login").serialize()
                 }
		);

	return false;
  }
}