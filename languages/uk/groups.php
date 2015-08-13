<?php
/*
##########################################################################
#                                                                        #
#           Version 4       /                        /   /               #
#          -----------__---/__---__------__----__---/---/-               #
#           | /| /  /___) /   ) (_ `   /   ) /___) /   /                 #
#          _|/_|/__(___ _(___/_(__)___/___/_(___ _/___/___               #
#                       Free Content / Management System                 #
#                                   /                                    #
#                                                                        #
#                                                                        #
#   Copyright 2005-2010 by webspell.org                                  #
#                                                                        #
#   visit webSPELL.org, webspell.info to get webSPELL for free           #
#   - Script runs under the GNU GENERAL PUBLIC LICENSE                   #
#   - It's NOT allowed to remove this copyright-tag                      #
#   -- http://www.fsf.org/licensing/licenses/gpl.html                    #
#                                                                        #
#   Code based on WebSPELL Clanpackage (Michael Gruber - webspell.at),   #
#   Far Development by Development Team - webspell.org                   #
#                                                                        #
#   visit webspell.org                                                   #
#                                                                        #
##########################################################################
*/

$style1 = '

<div style="margin: 5px; padding: 6px; border: 4px solid #D6B4B4;">
 <table>
  <tr>
    <td rowspan="3"><img src="images/cup/icons/notification.png"></td>
  </tr>
   <tr>
    <td>';
    
$style2 = ' 
 
    </td>
  </tr>
   <tr>
    <td>';
    
$style3 = '
    
    </td>
  </tr>
 </table>';


$language_array = Array(

/* do not edit above this line */

	'too_much_teams'=>''.$style1.' <b>Sorry, you were too late! '.$style2.' This ladder or tournamemt has already reached the max participants! '.$style3.'</div>',
	'already_participant'=>''.$style1.' You are already a participant in <b>Group',
	'not_loggedin'=>''.$style1.' <b>You must be registered and logged-in!</b> '.$style3.'</div>',
	'invalid_team'=>''.$style1.' <b>Invalid team selected. - (<a href="?site=myteams">my teams</a>)</b>',
	''=>''.$style1.' <b></b>',
	''=>''.$style1.' <b></b>',
	''=>''.$style1.' <b></b>',
	''=>''.$style1.' <b></b>',
	''=>''.$style1.' <b></b>',
	''=>''.$style1.' <b></b>',
	''=>''.$style1.' <b></b>'
);
?>