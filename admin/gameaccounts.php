<?php
/*
 ########################################################################
#                                                                        #
#           Version 4       /                        /   /               #
#          -----------__---/__---__------__----__---/---/-               #
#           | /| /  /___) /   ) (_ `   /   ) /___) /   /                 #
#          _|/_|/__(___ _(___/_(__)___/___/_(___ _/___/___               #
#                       Free Content / Management System                 #
#                                   /                                    #
#                                                                        #
#                                                                        #
#   Copyright 2005-2006 by webspell.org / webspell.info                  #
#                                                                        #
#   visit webSPELL.org, webspell.info to get webSPELL for free           #
#   - Script runs under the GNU GENERAL PUBLIC LICENCE                   #
#   - It's NOT allowed to remove this copyright-tag                      #
#   -- http://www.fsf.org/licensing/licenses/gpl.html                    #
#                                                                        #
#   Code based on WebSPELL Clanpackage (Michael Gruber - webspell.at),   #
#   Far Development by Development Team - webspell.org / webspell.info   #
#                                                                        #
#   visit webspell.org / webspell.info                                   #
#                                                                        #
 ########################################################################
*/

if($_POST['save']) {
  $type = $_POST['type'];

	safe_query("INSERT INTO ".PREFIX."gameacc ( type ) values( '$type' ) ");

}
elseif($_POST['saveedit']) {

	safe_query("UPDATE ".PREFIX."gameacc SET type='".$_POST['type']."' WHERE gameaccID='".$_POST['gameaccID']."'");

	safe_query("UPDATE ".PREFIX."user_gameacc SET type='".$_POST['type']."' WHERE type='".$_POST['old']."'");
}
elseif($_GET['delete']) {
	safe_query("DELETE FROM ".PREFIX."gameacc WHERE gameaccID='".$_GET['gameaccID']."'");
	safe_query("DELETE FROM ".PREFIX."user_gameacc WHERE type='".$_GET['type']."'");
}

echo'<h2>gameaccounts</h2>';
if($_GET['action']=="add") {
    echo'<form method="post" action="admincenter.php?site=gameaccounts" enctype="multipart/form-data">
	     <table cellpadding="4" cellspacing="0">
		 <tr>
		   <td>Name:</td>
		   <td><input type="text" name="type" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
		 </tr>
		 <tr>
		 <tr>
		   <td>&nbsp;</td>
		   <td><input type="submit" name="save" value="add Gameaccount"></td>
		 </tr>
		 </table>
		 </form>';
}
elseif($_GET['action']=="edit") {

  $gameaccID = $_GET['gameaccID'];
  $ergebnis=safe_query("SELECT * FROM ".PREFIX."gameacc WHERE gameaccID='$gameaccID'");
	$ds=mysqli_fetch_array($ergebnis);

	echo'<form method="post" action="admincenter.php?site=gameaccounts">
	     <table cellpadding="4" cellspacing="0">
		 <tr>
		   <td>name:</td>
		   <td><input type="text" name="type" value="'.$ds[type].'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
		 </tr>
		 <tr>
		   <td><input type="hidden" name="gameaccID" value="'.$ds[gameaccID].'"><input type="hidden" name="old" value="'.$ds[type].'"></td>
		   <td><input type="submit" name="saveedit" value="update"></td>
		 </tr>
		 </table>
		 </form>';
}
else {
	echo'<input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=gameaccounts&action=add\');return document.MM_returnValue" value="new Game"><br><br>';

	$ergebnis=safe_query("SELECT * FROM ".PREFIX."gameacc ORDER BY type");
	echo'<table width="100%" cellpadding="4" cellspacing="1" bgcolor="#999999">
   		<tr bgcolor="#CCCCCC">
   		<td class="title" align="center">Name:</td>
 		<td class="title" align="center" colspan="2">Actions:</td>
   		</tr>
		<tr bgcolor="#FFFFFF"><td colspan="3"></td></tr>';

	while($ds=mysqli_fetch_array($ergebnis)) {
    	echo'<tr bgcolor="#FFFFFF">
	       		<td align="center"><b>'.$ds[type].'</b></td>
		   		<td align="center"><input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=gameaccounts&action=edit&gameaccID='.$ds[gameaccID].'\');return document.MM_returnValue" value="edit"></td>
		   		<td align="center"><input type="button" class="button" onClick="MM_confirm(\'really delete this gameaccount?\', \'admincenter.php?site=gameaccounts&delete=true&gameaccID='.$ds[gameaccID].'&type='.$ds[type].'\')" value="delete"></td>
		 	</tr>';
	}
	echo'</table>';
}
?>