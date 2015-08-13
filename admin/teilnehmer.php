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

match_query_type();

//date and timezone

$timezone = safe_query("SELECT timezone FROM ".PREFIX."cup_settings");
$tz = mysqli_fetch_array($timezone); $gmt = $tz['timezone'];
date_default_timezone_set($tz['timezone']);

if(!iscupadmin($userID) OR substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php") die('Access denied.');

if($_POST['delcup']) {
	safe_query("DELETE FROM ".PREFIX."cup_clans WHERE clanID='".$_POST['userID']."' && cupID='".$_POST['cups']."' && 1on1='1'");
}elseif($_POST['checkin']) {
	safe_query("UPDATE ".PREFIX."cup_clans SET checkin='1' WHERE clanID='".$_POST['userID']."' && cupID='".$_POST['cups']."' && 1on1='1'");
}
	
echo'<h2>Cup Participants</h2>';

if($_GET['action']=="edit") {
	$userID = $_GET['userID'];
	$member = '<option value="0">- Please choose Cup -</option>';
	$members=safe_query("SELECT cupID FROM ".PREFIX."cup_clans WHERE 1on1='1' && clanID = '$userID'");
	while($dv=mysqli_fetch_array($members)) {
	
	$cupname = getcupname($dv['cupID']); $cupID = $dv['cupID'];
	
	$fullcup.='
		 <table cellpadding="4" cellspacing="0">
		  <tr> 
		   <td align="center"><input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=teams&cupID='.$cupID.'\');return document.MM_returnValue" value="'.$cupname.'"></td>
		  </tr>
		 </table>
		</form>';
	
		$member.='<option value="'.$dv['cupID'].'">'.getcupname($dv['cupID']).'</option>';
	}
	$member2 = '<option value="0">- Please choose Cup -</option>';
	$members=safe_query("SELECT cupID FROM ".PREFIX."cup_clans WHERE 1on1='1' && clanID = '$userID' && checkin='0'");
	while($dv=mysqli_fetch_array($members)) {
		$member2.='<option value="'.$dv['cupID'].'">'.getcupname($dv['cupID']).'</option>';
	}
	
 echo '<fieldset><legend><b>Quick Management</b></legend>
		<form method="post" name="post" action="admincenter.php?site=teilnehmer">
		 <table cellpadding="4" cellspacing="0">
		  <tr> 
		   <td>Cups:</td>
		   <td><select name="cups">'.$member.'</select></td>
		  </tr>
		  <tr>
		   <td>&nbsp;</td>
		   <td><input name="delcup" type="submit" id="delcup" value="Delete from Cup"><input name="userID" type="hidden" value="'.$userID.'" /></td>
		  </tr>
		 </table>
		</form>
		
		<form method="post" name="post" action="admincenter.php?site=teilnehmer">
		 <table cellpadding="4" cellspacing="0">
		  <tr> 
		   <td>Cups:</td>
		   <td><select name="cups">'.$member2.'</select></td>
		  </tr>
		  <tr>
		   <td>&nbsp;</td>
		   <td><input name="checkin" type="submit" id="checkin" value="Checkin Cup"><input name="userID" type="hidden" value="'.$userID.'" /></td>
		  </tr>
		 </table>
		</form>
	   </fieldset>';
		
	echo '<br><fieldset><legend><b>Full Management</b></legend>'.$fullcup.'</fieldset>';
		
}else{
	$used_users=array();
	$ergebnis = safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE 1on1='1'");
	$anz=mysqli_num_rows($ergebnis);
	if($anz) {
		echo'<form method="post" name="ws_cups" action="admincenter.php?site=teilnehmer"><table width="100%" cellpadding="4" cellspacing="1" bgcolor="#999999">
	       		<tr bgcolor="#CCCCCC">
		     		<td class="title" align="left">Nickname:</td>
			 		<td class="title" align="center" colspan="3">Actions:</td>
		   		</tr>
				<tr bgcolor="#ffffff"><td colspan="3"></td></tr>';
	
		while($ds=mysqli_fetch_array($ergebnis)) {
			if(in_array($ds['clanID'], $used_users))
				continue;
			echo'<tr bgcolor="#FFFFFF">
		       		<td> - '.getnickname($ds['clanID']).'</td>
			   		<td align="center"><input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=teilnehmer&action=edit&userID='.$ds['clanID'].'\');return document.MM_returnValue" value="Cup Management"></td>
			   		<td align="center"><input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=clans&action=addpoints&clanID='.$ds['clanID'].'&type=1\');return document.MM_returnValue" value="Penalty Points"></td>
			 	</tr>';
			$used_users[]=$ds['clanID'];
		}
		echo'</table></form>';
	}else
		echo'No Participants signed up';			
}
?>	
