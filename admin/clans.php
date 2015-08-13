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
//includes
include("../config.php");
include("../livecontact.php");

//date and timezone

$timezone = safe_query("SELECT timezone FROM ".PREFIX."cup_settings");
$tz = mysql_fetch_array($timezone); $gmt = $tz['timezone'];
date_default_timezone_set($tz['timezone']);

if(!iscupadmin($userID) OR substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php") die('Access denied.');

if($_POST['saveedit']) {
	safe_query("UPDATE ".PREFIX."cup_all_clans SET `name`='".$_POST['name']."', country='".$_POST['flag']."', `short`='".$_POST['short']."', `clantag`='".$_POST['clantag']."', `clanhp`='".$_POST['clanhp']."', clanhp='".$_POST['clanhp']."', clanlogo='".$_POST['clanlogo']."', server='".$_POST['server']."', port='".$_POST['port']."', password='".$_POST['password']."' WHERE ID='".$_POST['clanID']."'");
	redirect('admincenter.php?site=clans&action=edit&clanID='.$_POST['clanID'].'', '<center><div style="margin: 5px; padding: 6px; border: 4px solid #D6B4B4; text-align: center;"><B>Team successfully updated!</b> <img src="../images/cup/success.png"><div></center>', 1);

}elseif(isset($_GET['action']) && $_GET['action'] == 'delmember') {
		safe_query("DELETE FROM ".PREFIX."cup_clan_members WHERE userID = '".$_GET['memberID']."' && clanID = '".$_GET['clanID']."'");	
		redirect('admincenter.php?site=clans&action=edit&clanID='.$_GET['clanID'], '<center><strong>'.getnickname($_GET['memberID']).' successfully removed</strong></center>', 2);	

}elseif(isset($_GET['action']) && $_GET['action'] == 'leadmember') {
		safe_query("UPDATE ".PREFIX."cup_clan_members SET function = 'Leader' WHERE userID = '".$_GET['memberID']."' && clanID = '".$_GET['clanID']."'");	
		redirect('admincenter.php?site=clans&action=edit&clanID='.$_GET['clanID'], '<center><strong>'.getnickname($_GET['memberID']).' successfully granted as leader</strong></center>', 2);		

}elseif(isset($_GET['action']) && $_GET['action'] == 'demotemember') {
		safe_query("UPDATE ".PREFIX."cup_clan_members SET function = 'Member' WHERE userID = '".$_GET['memberID']."' && clanID = '".$_GET['clanID']."'");	
		redirect('admincenter.php?site=clans&action=edit&clanID='.$_GET['clanID'], '<center><strong>'.getnickname($_GET['memberID']).' successfully demoted as member</strong></center>', 2);		

}elseif(isset($_GET['action']) && $_GET['action'] == 'ownmember') {
$clanID = $_GET['clanID'];

    if(islocked($clanID)) echo '<center><b>Note:</b> Team is locked!<br><br></center>';
		safe_query("UPDATE ".PREFIX."cup_all_clans SET leader = '".$_GET['memberID']."' WHERE ID = '".$_GET['clanID']."'");	
		redirect('admincenter.php?site=clans&action=edit&clanID='.$_GET['clanID'], '<center><strong>'.getnickname($_GET['memberID']).' successfully set to founder of the team.</strong></center>', 2);		
	
}elseif(isset($_GET['action']) && $_GET['action'] == 'chat') {
$clanID = $_GET['clanID'];

    if(islocked($clanID)) echo $_language->module['team_locked_cup'];
	elseif(safe_query("SELECT chat FROM ".PREFIX."cup_all_clans WHERE ID='".$_GET['clanID']."'")){
		safe_query("UPDATE ".PREFIX."cup_all_clans SET chat='".$_GET['chataccess']."' WHERE ID = '".$_GET['clanID']."'");	
		redirect('admincenter.php?site=clans&action=edit&clanID='.$_GET['clanID'], '<center><b>Chat accessibility status successfully changed<img src="../images/cup/period1_ani.gif"></center>', 1);		
	}	
	
}elseif(isset($_GET['action']) && $_GET['action'] == 'comments') {
$clanID = $_GET['clanID'];

    if(islocked($clanID)) echo $_language->module['team_locked_cup'];
	elseif(safe_query("SELECT comment FROM ".PREFIX."cup_all_clans WHERE ID='".$_GET['clanID']."'")){
		safe_query("UPDATE ".PREFIX."cup_all_clans SET comment='".$_GET['access']."' WHERE ID = '".$_GET['clanID']."'");	
		redirect('admincenter.php?site=clans&action=edit&clanID='.$_GET['clanID'], '<center><b>Comments accessibility status successfully changed<img src="../images/cup/period1_ani.gif"></center>', 1);		
	}
	
}

elseif($_POST['addpoints']) {
	$day = $_POST['day'];
	$month = $_POST['month'];
	$year = $_POST['year'];
	$hour = $_POST['hour'];
	$min = $_POST['min'];
	$start = @mktime($hour, $min, 0, $month, $day, $year);
	
  if($_GET['type'] == '1') {
	safe_query("INSERT INTO ".PREFIX."cup_warnings ( clanID, adminID, points, title, `desc`, matchlink, time, deltime, 1on1) VALUES ('".$_POST['clanID']."', '".$userID."', '".$_POST['points']."', '".$_POST['title']."', '".$_POST['desc']."', '".$_POST['matchlink']."', '".time()."', '".$start."', '1')");
  }else 
	safe_query("INSERT INTO ".PREFIX."cup_warnings ( clanID, adminID, points, title, `desc`, matchlink, time, deltime, 1on1) VALUES ('".$_POST['clanID']."', '".$userID."', '".$_POST['points']."', '".$_POST['title']."', '".$_POST['desc']."', '".$_POST['matchlink']."', '".time()."', '".$start."', '0')");

}elseif($_POST['editpoints']){ 
	$day = $_POST['day'];
	$month = $_POST['month'];
	$year = $_POST['year'];
	$hour = $_POST['hour'];
	$min = $_POST['min'];
	$start = @mktime($hour, $min, 0, $month, $day, $year);

  if($_GET['type'] == '1') {	
	safe_query("UPDATE ".PREFIX."cup_warnings SET points='".$_POST['points']."', title='".$_POST['title']."', `desc`='".$_POST['desc']."', matchlink='".$_POST['matchlink']."', time='".$_POST['time']."', deltime='".$start."', 1on1='1' WHERE warnID='".$_POST['warnID']."'");
  }else
	safe_query("UPDATE ".PREFIX."cup_warnings SET points='".$_POST['points']."', title='".$_POST['title']."', `desc`='".$_POST['desc']."', matchlink='".$_POST['matchlink']."', time='".$_POST['time']."', deltime='".$start."', 1on1='0' WHERE warnID='".$_POST['warnID']."'"); 
  
}elseif($_POST['clanadd']) {
	safe_query("INSERT INTO ".PREFIX."cup_all_clans (name, short, clantag, clanhp, clanlogo, password, status, leader, reg) VALUES ('".$_POST['name']."', '".$_POST['short']."', '".$_POST['clantag']."', '".$_POST['clanhp']."', '".$_POST['clanlogo']."', '".md5($_POST['pw'])."', '".$_POST['status']."', '".$_POST['leader']."', '".time()."')");
	safe_query("INSERT INTO ".PREFIX."cup_clan_members (clanID, userID, function) VALUES ('".mysql_insert_id()."', '".$_POST['leader']."', 'Leader')");

}
elseif($_GET['delete']) {
	safe_query("DELETE FROM ".PREFIX."cup_all_clans WHERE ID='".$_GET['clanID']."'");
	safe_query("DELETE FROM ".PREFIX."cup_clans WHERE clanID='".$_GET['clanID']."'");
	safe_query("DELETE FROM ".PREFIX."cup_clan_members WHERE clanID='".$_GET['clanID']."'");
}
elseif($_POST['delmember']) {
	safe_query("DELETE FROM ".PREFIX."cup_clan_members WHERE userID='".$_POST['member']."'");
}
elseif($_POST['checkin']) {
	safe_query("UPDATE ".PREFIX."cup_clans SET `checkin`='1' WHERE clanID='".$_POST['clanID']."' && cupID='".$_POST['cups']."'");
}
elseif($_POST['delcup']) {
	safe_query("DELETE FROM ".PREFIX."cup_clans WHERE clanID='".$_POST['clanID']."' && cupID='".$_POST['cups']."'");
}
elseif($_POST['addcup']) {
	safe_query("INSERT INTO ".PREFIX."cup_clans SET clanID='".$_POST['clanID']."', cupID='".$_POST['cups']."'");
}
elseif($_GET['action']=="status") {
  $clanID = $_GET['clanID'];
  $status = $_GET['status'];
  safe_query("UPDATE ".PREFIX."cup_all_clans SET `status`='".$status."' WHERE ID='".$clanID."'");
}
elseif($_GET['action']=="status2") {
  $clanID = $_GET['clanID'];
  $status = $_GET['status'];
  safe_query("UPDATE ".PREFIX."cup_all_clans SET `status`='".$status."' WHERE ID='".$clanID."'");
  redirect('admincenter.php?site=clans&action=edit&clanID='.$clanID.'', '<center><div style="margin: 5px; padding: 6px; border: 4px solid #D6B4B4; text-align: center;"><B>Team status successfully updated!</b> <img src="../images/cup/success.png"><div></center>', 1);
}

echo'<h2>Clans</h2>';

if($_GET['action']=="edit") {
	$clanID = $_GET['clanID'];
	$ergebnis=safe_query("SELECT * FROM ".PREFIX."cup_all_clans WHERE ID='".$clanID."'");
	$ds=mysql_fetch_array($ergebnis);

	echo'
	<form method="post" name="post" action="">
	     <table cellpadding="4" cellspacing="0">
    <tr> 
      <td>Team name:</td>
      <td><input name="name" type="text" class="form_off" id="name" value="'.$ds['name'].'" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" size="40" maxlength="30"></td>
    </tr>
     <tr> 
      <td>Bracket name:</td>
      <td><input name="short" type="text" class="form_off" id="short" value="'.$ds['short'].'" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" size="40"></td>
    </tr>
     <tr> 
      <td>Team-Tag:</td>
      <td><input name="clantag" type="text" class="form_off" id="clantag" value="'.$ds['clantag'].'" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" size="40"></td>
    </tr>
     <tr> 
      <td>Homepage:</td>
      <td><input name="clanhp" type="text" class="form_off" id="clanhp" value="'.$ds['clanhp'].'" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" value="http://" size="40"></td>
    </tr>
     <tr>
      <td>Team logo:</td>
      <td><input name="clanlogo" type="text" class="form_off" id="clanlogo" value="'.$ds['clanlogo'].'" onfocus="this.className=\'form_on\'" onblur="this.className=\'form_off\'" value="http://" size="40" /></td>
    </tr> 
     <tr>
      <td>Server connect:</td>
      <td><input name="server" type="server" onfocus="this.className=\'form_on\'" onblur="this.className=\'form_off\'" value="'.$ds['server'].'" maxlength="22" />:<input name="port" type="port" id="port" onfocus="this.className=\'form_on\'" onblur="this.className=\'form_off\'" value="'.$ds['port'].'" maxlength="6" size="6" /></td>
    </tr>  
     <tr>
      <td>Team Password:</td>
      <td><input name="password" type="text" class="form_off" id="password" onfocus="this.className=\'form_on\'" onblur="this.className=\'form_off\'" value="'.$ds['password'].'" size="40" /></td>
    </tr>';
  
//team chat 
  
		$chat=safe_query("SELECT chat FROM ".PREFIX."cup_all_clans WHERE ID='$clanID'");
		while($dr=mysql_fetch_array($chat)) {
		
		if($dr['chat']==0) { $chatname = 'Team chat is disabled'; }
		if($dr['chat']==1) { $chatname = 'Team chat private only'; }
		if($dr['chat']==2) { $chatname = 'Public team chat'; }
		
			$chat = '<option selected value="'.$dr['chat'].'">-- Select Access --</option>
			         <option value="0">Disable Chat</option>
			         <option value="1">Private Only</option>
			         <option value="2">Public Chat</option>';	         
		}
		
 
		echo '
		  <tr>
		    <td>Chat Access:</td>
		    <td><select name="member" onChange="MM_confirm(\'Confirm?\', \'admincenter.php?site=clans&action=chat&clanID='.$clanID.'&chataccess=\'+this.value)">'.$chat.'</select> '.$chatname.'</td>
		</tr>';
		
//team comments

		$comments=safe_query("SELECT comment FROM ".PREFIX."cup_all_clans WHERE ID='$clanID'");
		while($dr=mysql_fetch_array($comments)) {	
			
		if($dr['comment']==0) { $comment = 'Comments disabled for this team'; }
		if($dr['comment']==1) { $comment = 'Comments only for logged in users'; }
		if($dr['comment']==2) { $comment = 'Comments opened for all'; }
		if($dr['comment']==3) { $comment = 'Comments only for members in team'; }
		
		$commentsaccess = '<option selected value="'.$dr['comment'].'">-- Select Access --</option>
			               <option value="0">Disable Comments</option>
			               <option value="3">Members Only</option>
			               <option value="1">Logged-in Users</option>
			               <option value="2">Users & Guests</option>'; }
		
		echo '
		  <tr>
		    <td>Comments Access:</td>
		    <td><select name="comment" onChange="MM_confirm(\'Confirm?\', \'admincenter.php?site=clans&action=comments&clanID='.$clanID.'&access=\'+this.value)">'.$commentsaccess.'</select> '.$comment.'</td>
		</tr>'; 	
		
//only founder can promote members

		$member2 = '<option value="0">- Choose Member -</option>';
		$members2=safe_query("SELECT userID FROM ".PREFIX."cup_clan_members WHERE clanID = '$clanID' && function!='Leader'");
		while($dr=mysql_fetch_array($members2)) {
			$member2.='<option value="'.$dr['userID'].'">'.getnickname($dr['userID']).'</option>';
		}

		echo '
		  <tr>
		    <td>Promote member:</td>
		    <td><select name="member" onChange="MM_confirm(\'Give leader rights?\', \'admincenter.php?site=clans&action=leadmember&clanID='.$clanID.'&memberID=\'+this.value)">'.$member2.'</select> as leader</td>
		  </tr>';		
		  
//demotion
		  
		$member4 = '<option value="0">- Choose Member -</option>';
		$members4=safe_query("SELECT userID FROM ".PREFIX."cup_clan_members WHERE clanID = '$clanID' && function ='Leader' && userID != '$userID'");
		while($dp=mysql_fetch_array($members4)) {
			$member4.='<option value="'.$dp['userID'].'">'.getnickname($dp['userID']).'</option>';
		}
		  
		echo '
		  <tr>
		    <td>Demote leader:</td>
		    <td><select name="member" onChange="MM_confirm(\'Are you sure you want to demote this leader as member rank?\', \'admincenter.php?site=clans&action=demotemember&clanID='.$clanID.'&memberID=\'+this.value)">'.$member4.'</select> as member</td>
		</tr>';	
		
//ownership

		$member3 = '<option value="0">- Choose Member -</option>';
		$members3=safe_query("SELECT userID FROM ".PREFIX."cup_clan_members WHERE clanID = '$clanID' && function ='Leader' && userID != '$userID'");
		while($dm=mysql_fetch_array($members3)) {
			$member3.='<option value="'.$dm['userID'].'">'.getnickname($dm['userID']).'</option>';
		}
		
		echo '
		  <tr>
		    <td>Grant leader:</td>
		    <td><select name="member" onChange="MM_confirm(\'Grant owner rights to this leader? This will promote full rights of the team only to this user.\', \'admincenter.php?site=clans&action=ownmember&clanID='.$clanID.'&memberID=\'+this.value)">'.$member3.'</select> as owner</td>
		</tr>';
		
//team country

        $flag = '[flag]'.$ds['country'].'[/flag]';
		$country = flags($flag);
		$country = str_replace("<img","<img id='county'",$country);
		$countries = str_replace(" selected=\"selected\"", "", $countries);
		$countries = str_replace('value="'.$ds['country'].'"', 'value="'.$ds['country'].'" selected="selected"', $countries);

		echo '
		  <tr>
			<td>Team-Country:</td>
			<td><select name="flag" onchange="document.getElementById(\'county\').src=\'../images/flags/\'+this.options[this.selectedIndex].value+\'.gif\'">'.$countries.'</select> '.$country.'</td>
		</tr>';
		
//delete member & view team link

		$member = '<option value="0">- Select Member -</option>';
		$members=safe_query("SELECT userID FROM ".PREFIX."cup_clan_members WHERE clanID = '$clanID' AND userID != '$userID'");
		while($dv=mysql_fetch_array($members)) {
			if(mysql_num_rows(safe_query("SELECT ID FROM ".PREFIX."cup_all_clans WHERE leader = '".$dv['userID']."' AND ID = '".$clanID."'"))) continue;
			$member.='<option value="'.$dv['userID'].'">'.getnickname($dv['userID']).'</option>';
		}
		
		echo '
		    <tr>
			  <td>Kick-Member:</td>
			  <td><select name="member" onChange="MM_confirm(\'Are you sure you want to kick this member?\', \'admincenter.php?site=clans&action=delmember&clanID='.$ds['ID'].'&memberID=\'+this.value)">'.$member.'</select></td>
			</tr>
             <tr>
              <td>&nbsp;</td>
              <td><input name="saveedit" type="submit" id="saveedit" value="Edit Team">
              <input name="clanID" type="hidden" value="'.$clanID.'" /></td>
            </tr>
          </form>
			 <tr>
			  <td align="right"><img src="../images/cup/new_message_inv.gif"><br><br></td>
			  <td><a href="../?site=clans&action=show&clanID='.$clanID.'">View Team (front-end)</a><br><br></td>
			</tr>';		
  
    echo'  
	 <tr>
      <td>&nbsp;</td>
      <td> <img border="0" src="../images/cup/icons/bullet.gif"> <a href="?site=clans&action=addcups&clanID='.$clanID.'">Enter into a cup</a></td>
    </tr>
	 <tr>
      <td>&nbsp;</td>
      <td> <img border="0" src="../images/cup/icons/bullet.gif"> <a href="?site=clans&action=addcheckin&clanID='.$clanID.'">Checking into a cup</a></td>
    </tr>
	 <tr>
      <td>&nbsp;</td>
      <td> <img border="0" src="../images/cup/icons/bullet.gif"> <a href="?site=clans&action=addpoints&clanID='.$clanID.'">Register penalty points</a></td>
    </tr>		
	 <tr>
      <td>&nbsp;</td>
      <td> <img border="0" src="../images/cup/icons/bullet.gif"> <a href="?site=clans&action=delmember&clanID='.$clanID.'">Delete member</a></td>
    </tr>
	 <tr>
      <td>&nbsp;</td>
      <td> <img border="0" src="../images/cup/icons/bullet.gif"> <a href="?site=clans&action=delcups&clanID='.$clanID.'">Remove from cups</a></td>
    </tr>
	 <tr>
      <td>&nbsp;</td>
      <td> <img border="0" src="../images/cup/icons/bullet.gif"> <a href="admincenter.php?site=clans&delete=true&clanID='.$clanID.'" onclick="return confirm(\'Important: This will delete ALL team data, including matches etc.\');">Delete Team</a></td>
    </tr>';  

    
if($ds['status']) { echo '
 
	 <tr>
      <td>&nbsp;</td>
      <td> <img border="0" src="../images/cup/icons/bullet.gif"> <a href="admincenter.php?site=clans&action=status2&status=0&clanID='.$clanID.'">Make Inactive</a></td>
    </tr>';   
}else echo '
	 <tr>
      <td>&nbsp;</td>
      <td> <img border="0" src="../images/cup/icons/bullet.gif"> <a href="admincenter.php?site=clans&action=status2&status=1&clanID='.$clanID.'">Make Active</a></td>
    </tr> ';
  echo '</table>';
  
			 //dropdown - add users to cup
			 
			        $members = safe_query("SELECT userID FROM ".PREFIX."cup_clan_members WHERE clanID='".$clanID."'");
			          while($up=mysql_fetch_array($members)) { 
					    $users=safe_query("SELECT userID FROM ".PREFIX."user WHERE userID != '".$up['userID']."'");
                   } 
			   echo '<br><br>
			             <form method="post" action="">
			               <select name="users[]" multiple size="10">';
					         while($dv=mysql_fetch_array($users)) {
					        echo '<option value="'.$dv['userID'].'">('.$dv['userID'].') '.getnickname($dv['userID']).'</option>';
			             }
			             
			   echo'</select>
                      <input type="hidden" name="ID" value="'.$clanID.'">
	               <br><br><input type="submit" name="enterusers" value="Enter Users">
		       </form>';
		       
			 //dropdown - remove users from cup
			 
			        $participants = safe_query("SELECT userID FROM ".PREFIX."cup_clan_members WHERE clanID='".$clanID."'");
			           
			   echo '<br><br><form method="post" action="">
			                   <select name="users[]" multiple size="10">';
			                   
					while($dv=mysql_fetch_array($participants)) {
					echo '<option value="'.$dv['userID'].'">('.$dv['userID'].') '.getnickname($dv['userID']).'</option>';
		          }
			   echo'</select>
                      <input type="hidden" name="ID" value="'.$clanID.'">
	               <br><br><input type="submit" name="removeusers" value="Remove Users">
		       </form>';
		       
		     //end dropdown  
    
}elseif($_GET['action']=="addclan") {
	$userselect = '<option value="0">- Please select user -</option>';
	$user=safe_query("SELECT userID, nickname FROM ".PREFIX."user");
	while($ds=mysql_fetch_array($user)) {
		$userselect .= '<option value="'.$ds['userID'].'">'.$ds['nickname'].'</option>';
	}
	echo '<form method="post" name="post" action="admincenter.php?site=clans">
	     <table cellpadding="4" cellspacing="0">
    <tr> 
      <td>Clanname:</td>
      <td><input name="name" type="text" class="form_off" id="name" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" size="40" maxlength="30"></td>
    </tr>
    <tr> 
      <td>Clanshort:</td>
      <td><input name="short" type="text" class="form_off" id="short" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" size="40"></td>
    </tr>
    <tr> 
      <td>Clan tag:</td>
      <td><input name="clantag" type="text" class="form_off" id="clantag" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" size="40"></td>
    </tr>
    <tr> 
      <td>Homepage:</td>
      <td><input name="clanhp" type="text" class="form_off" id="clanhp" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" value="http://" size="40"></td>
    </tr>
    <tr>
      <td>Clanlogo:</td>
      <td><input name="clanlogo" type="text" class="form_off" id="clanlogo" onfocus="this.className=\'form_on\'" onblur="this.className=\'form_off\'" value="http://" size="40" /></td>
    </tr>
    <tr>
      <td>Join password:</td>
      <td><input name="pw" type="password" class="form_off" id="pw" onfocus="this.className=\'form_on\'" onblur="this.className=\'form_off\'" value="" size="40" /></td>
    </tr>
    <tr>
      <td>Clanleader:</td>
      <td><select name="leader">
	  '.$userselect.'
    </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="checkbox" name="status" value="1"> Unlocking</td>
    </tr>		
    <tr>
      <td>&nbsp;</td>
      <td><input name="clanadd" type="submit" id="clanadd" value="Add">
      <input name="cupID" type="hidden" value="'.$_GET['cupID'].'" /></td>
    </tr>
  </table>
</form>';
}elseif($_GET['action']=="addcheckin") {
	$clanID = $_GET['clanID'];
	$cups = '<option value="0">- Select Cup -</option>';
	$cups_sql=safe_query("SELECT cupID FROM ".PREFIX."cup_clans WHERE 1on1='0' && clanID = '$clanID' && checkin='0'");
	while($dv=mysql_fetch_array($cups_sql)) {
		$cups.='<option value="'.$dv['cupID'].'">'.getcupname($dv['cupID']).'</option>';
	}
		
	echo '<b>If no cup is diplayed this means the team has not entered the cup yet.</b>
<form method="post" name="post" action="admincenter.php?site=clans">
	     <table cellpadding="4" cellspacing="0">
    <tr> 
      <td>Cups:</td>
      <td><select name="cups">
		'.$cups.'
		</select></td>
    </tr>
	    <tr>
      <td>&nbsp;</td>
      <td><input name="checkin" type="submit" id="checkin" value="Cup checkin">
      <input name="clanID" type="hidden" value="'.$clanID.'" /></td>
    </tr>
	  </table>
</form>
';
}elseif($_GET['action']=="delcups") {
	$clanID = $_GET['clanID'];
 	$cups = '<option value="0">- Select Cup -</option>';
	$cups_sql=safe_query("SELECT cupID FROM ".PREFIX."cup_clans WHERE 1on1='0' && clanID = '$clanID'");
	while($dv=mysql_fetch_array($cups_sql)) {
	$cupID = $dv['cupID'];
		$cups.='<option value="'.$dv['cupID'].'">'.getcupname($dv['cupID']).'</option>';
	}
		
	echo '
	<form method="post" name="post" action="admincenter.php?site=teams&cupID='.$cupID.'">
	    <table cellpadding="4" cellspacing="0">
			<tr> 
				<td>Cups:</td>
				<td><select name="cups">'.$cups.'</select></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input name="delcup" type="submit" id="delcup" value="Delete from cup"> <input name="clanID" type="hidden" value="'.$clanID.'" /></td>
			</tr>
		</table>
	</form>';

//2.7
}elseif($_GET['action']=="cup") {
        $cupID = $_GET['cupID'];
	$cups = '<option value="0">- Select Cup -</option>';
	$ergebnis = safe_query("SELECT clanID, checkin FROM ".PREFIX."cup_clans WHERE cupID = '$cupID' ORDER BY ID ASC");
        $cups_sql=safe_query("SELECT clanID FROM ".PREFIX."cup WHERE && clanID = '$clanID' && checkin='0'");
	while($dv=mysql_fetch_array($cups_sql)) {
		$cups.='<option value="'.$dv['cupID'].'">'.getcupname($dv['cupID']).'</option>';
	}
		
	echo '<b>If no cup is diplayed this means the team has not entered the cup yet.</b>
<form method="post" name="post" action="admincenter.php?site=clans">
	     <table cellpadding="4" cellspacing="0">
    <tr> 
      <td>Cups:</td>
      <td><select name="cups">
		'.$cups.'
		</select></td>
    </tr>
	    <tr>
      <td>&nbsp;</td>
      <td><input name="checkin" type="submit" id="checkin" value="Cup checkin">
      <input name="clanID" type="hidden" value="'.$clanID.'" /></td>
    </tr>
	  </table>
</form>
';
}elseif($_GET['action']=="delcups") {
	$clanID = $_GET['clanID'];
 	$cups = '<option value="0">- Select Cup -</option>';
	$cups_sql=safe_query("SELECT cupID FROM ".PREFIX."cup_clans WHERE 1on1='0' && clanID = '$clanID'");
	while($dv=mysql_fetch_array($cups_sql)) {
		$cups.='<option value="'.$dv['cupID'].'">'.getcupname($dv['cupID']).'</option>';
	}
		
	echo '
	<form method="post" name="post" action="admincenter.php?site=clans">
	    <table cellpadding="4" cellspacing="0">
			<tr> 
				<td>Cups:</td>
				<td><select name="cups">'.$cups.'</select></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input name="delcup" type="submit" id="delcup" value="Delete from cup"> <input name="clanID" type="hidden" value="'.$clanID.'" /></td>
			</tr>
		</table>
	</form>';
//END 2.7
}elseif($_GET['action']=="addpoints") {
	$clanID = $_GET['clanID'];
	
              $getpoints = safe_query("SELECT SUM(points) as totalpoints FROM ".PREFIX."cup_warnings WHERE clanID='$clanID' && expired='0'");
             $ds=mysql_fetch_array($getpoints);

	        $block = safe_query("SELECT cupblockage FROM ".PREFIX."cup_settings");	
	         $db = mysql_fetch_array($block);
              $cupblockage = $db['cupblockage']-$ds['totalpoints'];         
              
              if($_GET['type'] == '1') { $user = 'User'; $type = '&type=1'; }else{ $user = 'Team'; $type = ''; }
              
              $expiredpoints = safe_query("SELECT * FROM ".PREFIX."cup_warnings WHERE clanID='$clanID' && expired='1'");
              if(mysql_num_rows($expiredpoints) && !$_GET['history'] == 'show') { $expired = '<br>This '.$user.' has expired penalty points. (<a href="admincenter.php?site=clans&action=addpoints&clanID='.$clanID.'&history=show'.$type.'">view here</a>)'; }
              
              if($ds['totalpoints'] >= $db['cupblockage']) {
                $thepoints = '<div style="margin: 5px; padding: 6px; border: 4px solid #D6B4B4; text-align: center;"> <b>Note: This '.$user.' is blocked</b></div>'; 
                $cupblockage2 = '';
              }else{ 
                $thepoints = 'This '.$user.' needs <font color="red"><b>'.$cupblockage.'</b></font> more point(s) to be blocked';
                $cupblockage2 = $cupblockage;
               }
              if($ds['totalpoints']) {
                $points = ''.$user.' has <font color="red"><b>'.$ds['totalpoints'].'</b></font> current penalty poitns';
              }else{
                $points = ''.$user.' has no penalty points';
              }
              
  if($_GET['type'] == '1') {
  
	echo '
	<fieldset><legend><b>'.getnickname($clanID).'\'s Blockage Information</b></legend>
	  '.$points.'<br>
	  The maximum blockage points is <font color="red"><b>'.$db['cupblockage'].'</b></font> (<a href="admincenter.php?site=cupsettings">change</a>)<br>
	  '.$thepoints.'
	  '.$expired.'
	</fieldset>';
	
	$type = '&type=1';
	$name = getnickname($clanID);
	
  }else{
  
	echo '
	<fieldset><legend><b>'.getclanname($clanID).'\'s Blockage Information</b></legend>
	  '.$points.'<br>
	  The maximum blockage points is <font color="red"><b>'.$db['cupblockage'].'</b></font> (<a href="admincenter.php?site=cupsettings">change</a>)<br>
	  '.$thepoints.'
	  '.$expired.'
	</fieldset>'; 
	
	$type = ''; 
	$name = getclanname($clanID); }
	
	if($_GET['history'] == 'show') { $history = '&history=show'; }else{ $history = ''; }
	
	echo '<br>
	<form method="post" name="post" action="admincenter.php?site=clans&action=addpoints&clanID='.$clanID.''.$type.'&history=show">
	    <table cellpadding="4" cellspacing="0">
		    <tr>
		      <td>Point(s):</td>
		      <td><input name="points" type="text" class="form_off" id="points" onfocus="this.className=\'form_on\'" onblur="this.className=\'form_off\'" style="text-align: center;" size="5" value="'.$cupblockage2.'"/></td>
		     </tr>
			<tr>
		      <td>Title:</td>
		      <td><input name="title" type="text" class="form_off" id="title" onfocus="this.className=\'form_on\'" onblur="this.className=\'form_off\'" size="40" /></td>
		     </tr>
			<tr>
		      <td>Description</td>
		      <td><input name="desc" type="text" class="form_off" id="desc" onfocus="this.className=\'form_on\'" onblur="this.className=\'form_off\'" size="40" /></td>
		     </tr>
			<tr>
		      <td>Match link:</td>
		      <td><input name="matchlink" type="text" class="form_off" id="matchlink" onfocus="this.className=\'form_on\'" onblur="this.className=\'form_off\'" value="http://" size="40" /> (optional)</td>
		     </tr>
			<tr>
		      <td>Remove on:</td>
		      <td><input name="day" type="text" size="2" value="'.date('d').'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">.
		      <input name="month" type="text" size="2" value="'.date('m').'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">. 
              <input name="year" type="text" size="4" value="'.date('Y').'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> (dd.mm.yyyy) at 
		      <input name="hour" type="text" size="2" value="'.date('H').'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">:
              <input name="min" type="text" size="2" value="'.date('i').'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
		     </tr>
			<tr>
		      <td>&nbsp;</td>
			  <td><input name="addpoints" type="submit" id="addcup" value="Add Points"><input name="clanID" type="hidden" value="'.$clanID.'" /></td>
		     </tr>
	    </table>
	</form>';
	
			
			$allusers = safe_query("SELECT userID FROM ".PREFIX."user");
		    while($dp=mysql_fetch_array($allusers)) { 
		    
		    if(iscupadmin($dp['userID']))   
		    $member.='<option value="'.$dp['userID'].'">'.getnickname($dp['userID']).'</option>'; }		    
		        
	      $penaltypoints = safe_query("SELECT * FROM ".PREFIX."cup_warnings WHERE clanID='$clanID' && expired='0'");
	      
	     echo '<br><fieldset><legend><a><b>Current Date/Time</b></a></legend> '.date('d.m.Y').'<br>'.date('H:i').'</fieldset>';
	
		eval ("\$inctemp = \"".gettemplate("blockage_head")."\";");
		echo $inctemp; echo base64_decode(''); 
		  
	 while($dd=mysql_fetch_array($penaltypoints)) {
	  $added = date('d.m.Y \a\t H:i', $dd['time']).'';
	  $deltime = date('d.m.Y \a\t H:i', $dd['deltime']).'';
	  $member.= '<option selected value="'.$dd['adminID.'].'">'.getnickname($dd['adminID']).'</option>';
	
	$day = date('d', $dd[deltime]);
	$month = date('m', $dd[deltime]);
	$year = date('Y', $dd[deltime]);
	$hour = date('H', $dd[deltime]);
	$min = date('i', $dd[deltime]);
	
		eval ("\$inctemp = \"".gettemplate("blockage_content")."\";");
		echo $inctemp; echo base64_decode(''); 
		  		     
	   }		
	    eval ("\$inctemp = \"".gettemplate("footer")."\";");
		echo $inctemp; echo base64_decode('');	   

	 if(isset($_GET['query']) && $_GET['query'] == 'expire'){
		safe_query("UPDATE ".PREFIX."cup_warnings SET expired='1' WHERE warnID='".$_GET['warnID']."'");
		redirect('admincenter.php?site=clans&action=addpoints&clanID='.$_GET['clanID'].''.$type.''.$history, '', 0);
		
	 }elseif(isset($_GET['query']) && $_GET['query'] == 'valid'){
		safe_query("UPDATE ".PREFIX."cup_warnings SET expired='0' WHERE warnID='".$_GET['warnID']."'");
		redirect('admincenter.php?site=clans&action=addpoints&clanID='.$_GET['clanID'].''.$type.''.$history, '', 0);
		
	 }elseif(isset($_GET['query']) && $_GET['query'] == 'delete'){
		safe_query("DELETE FROM ".PREFIX."cup_warnings WHERE warnID='".$_GET['warnID']."'");
		redirect('admincenter.php?site=clans&action=addpoints&clanID='.$_GET['clanID'].''.$type.''.$history, '', 0);
		
     }elseif(isset($_GET['query']) && $_GET['query'] == 'addedby'){
		safe_query("UPDATE ".PREFIX."cup_warnings SET adminID='".$_GET['adminID']."' WHERE warnID='".$_GET['warnID']."'");
        redirect('admincenter.php?site=clans&action=addpoints&clanID='.$_GET['clanID'].''.$type.''.$history, '', 0);
        
     }elseif(isset($_GET['history']) && $_GET['history'] == 'show'){
     
		eval ("\$inctemp = \"".gettemplate("blockage_expired_head")."\";");
		echo $inctemp; echo base64_decode(''); 
	
       $expiredpoints = safe_query("SELECT * FROM ".PREFIX."cup_warnings WHERE clanID='$clanID' && expired='1'");
       while($dd=mysql_fetch_array($expiredpoints)) {
       
	  $added = date('d.m.Y \a\t H:i', $dd['time']).'';
	  $deltime = date('d.m.Y \a\t H:i', $dd['deltime']).'';
	  $member.= '<option selected value="'.$dd['adminID.'].'">'.getnickname($dd['adminID']).'</option>';
	
	$day = date('d', $dd[deltime]);
	$month = date('m', $dd[deltime]);
	$year = date('Y', $dd[deltime]);
	$hour = date('H', $dd[deltime]);
	$min = date('i', $dd[deltime]);
       
		eval ("\$inctemp = \"".gettemplate("blockage_expired_content")."\";");
		echo $inctemp; echo base64_decode(''); 
       
       }
       
	    eval ("\$inctemp = \"".gettemplate("footer")."\";");
		echo $inctemp; echo base64_decode('');
            
   }
		
}elseif($_GET['action']=="addcups") {
	$clanID = $_GET['clanID'];
	$member = '<option value="0">- Please choose cup -</option>';
	$members=safe_query("SELECT ID FROM ".PREFIX."cups WHERE 1on1 = '0'");
	while($dv=mysql_fetch_array($members)) {
		$member.='<option value="'.$dv['ID'].'">'.getcupname($dv['ID']).'</option>';
	}
		
	echo '
	<form method="post" name="post" action="admincenter.php?site=clans">
	    <table cellpadding="4" cellspacing="0">
			<tr> 
				<td>Cups:</td>
				<td><select name="cups">'.$member.'</select></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input name="addcup" type="submit" id="addcup" value="Add in cup"><input name="clanID" type="hidden" value="'.$clanID.'" /></td>
			</tr>
		</table>
	</form>';
}elseif($_GET['action']=="delmember") {
	$clanID = $_GET['clanID'];
	$member = '<option value="0">- Please select a member -</option>';
	$members=safe_query("SELECT userID, function FROM ".PREFIX."cup_clan_members WHERE clanID = '$clanID' && function != 'Leader'");
	while($dv=mysql_fetch_array($members)) {
		$member.='<option value="'.$dv['userID'].'">'.getnickname($dv['userID']).' ( '.$dv['function'].' )</option>';
	}
		
	echo '
	<form method="post" name="post" action="admincenter.php?site=clans">
	    <table cellpadding="4" cellspacing="0">
			<tr> 
				<td>Member:</td>
				<td><select name="member">'.$member.'</select></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input name="delmember" type="submit" id="delmember" value="Delete member"><input name="clanID" type="hidden" value="'.$clanID.'" /></td>
			</tr>
		</table>
	</form>';
}else{
	$search = $_POST['search'] ? $_POST['search'] : $_GET['search'];
	$type = $_GET['type'];
	$sort = $_GET['sort'];
	
	if(!isset($sort)) $sort="ID";
	if(!isset($type)) $type = "ASC";
	
	if($search) 
		$ergebnis = safe_query("SELECT status, ID, name FROM ".PREFIX."cup_all_clans WHERE name LIKE '%$search%' ORDER BY $sort $type");
	else 
		$ergebnis = safe_query("SELECT status, ID, name FROM ".PREFIX."cup_all_clans ORDER BY $sort $type");
	$anz=mysql_num_rows($ergebnis);
	if($anz) {	
		if($type=="ASC")
			$sorter='<a href="admincenter.php?site=clans&sort='.$sort.'&type=DESC&search='.$search.'">Sort:</a> <img src="../images/icons/asc.gif" width="9" height="7" border="0">&nbsp;&nbsp;&nbsp;';
		else
		    $sorter='<a href="admincenter.php?site=clans&sort='.$sort.'&type=ASC&search='.$search.'">Sort:</a> <img src="../images/icons/desc.gif" width="9" height="7" border="0">&nbsp;&nbsp;&nbsp;';
	
		echo '<form method="post" action="admincenter.php?site=clans&sort='.$sort.'&type='.$type.'">'.$sorter.' Teamname: <input type="text" name="search" size="15" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"> <input type="submit" value="Go"></form>';
	   	if($search)
			echo '<p>'.$anz.' Clan(s) found</p>';
		echo'<form method="post" name="ws_cups" action="admincenter.php?site=clans"><table width="100%" cellpadding="4" cellspacing="1" bgcolor="#999999">
	       		<tr bgcolor="#CCCCCC">
		     		<td class="title" align="left"><a class="titlelink" href="admincenter.php?site=clans&sort=name&type='.$type.'&search='.$search.'">Clans:</a></td>
			 		<td class="title" align="center" colspan="3">Actions:</td>
                                        <td class="title" align="center" colspan="2">Penalty Points:</td>
                                        <td class="title" align="center" colspan="3">Cup:</td>
		   		</tr>
				<tr bgcolor="#ffffff"><td colspan="9"></td></tr>';
	
		while($ds=mysql_fetch_array($ergebnis)) {
			if($ds['status'])
				$status = '<input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=clans&action=status&status=0&clanID='.$ds['ID'].'\');return document.MM_returnValue" value="Active">';
			else
				$status = '<input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=clans&action=status&status=1&clanID='.$ds['ID'].'\');return document.MM_returnValue" value="Inactive">';

      	echo'<tr bgcolor="#FFFFFF">
		       		<td> - '.$ds['name'].'</td>
			   		<td align="center">
					'.$status.'</td>
			   		<td align="center"><input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=clans&action=edit&clanID='.$ds['ID'].'\');return document.MM_returnValue" value="Edit"</td>
					<td align="center"><input type="button" class="button" onClick="MM_confirm(\'Really delete this clan? - All team data will be lost!\', \'admincenter.php?site=clans&delete=true&clanID='.$ds['ID'].'\')" value="Delete"></td>
                                        <td align="center"><input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=clans&action=addpoints&clanID='.$ds['ID'].'\')" value="Add"></td>
                                        <td align="center"><input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=clans&action=block&clanID='.$ds['ID'].'\')" value="Block"></td>
                                        <td align="center"><input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=clans&action=addcups&clanID='.$ds['ID'].'\')" value="Enter Cup"></td>
                                        <td align="center"><input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=clans&action=addcheckin&clanID='.$ds['ID'].'\')" value="Checkin Cup"></td>
                                        <td align="center"><input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=clans&action=delcups&clanID='.$ds['ID'].'\')" value="x"></td>
			 	</tr>';
		}
		echo'</table></form>';
	}else
        echo'No clan(s) found';
	echo'<br><br><a href="?site=clans&action=addclan&cupID='.$_GET['cupID'].'">Add clan</a>'; 
			
	$cupID = $_GET['cupID'];
	if($cupID){


		
		//F1skr add
		if(is1on1($cupID)) $participants = 'Players';
		else $participants = 'Teams';
		
		eval ("\$title_cup = \"".gettemplate("title_cup")."\";");
		echo $title_cup;

		if(is1on1($cupID)){
			$bg1=BG_1;
			$bg2=BG_1;
			eval ("\$one_head = \"".gettemplate("1on1_head")."\";");
			echo $one_head;
			$ergebnis = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE cupID = '$cupID' && 1on1='1'");
			while($db=mysql_fetch_array($ergebnis)) {
				$ergebnis2 = safe_query("SELECT * FROM ".PREFIX."user WHERE userID='".$db['clanID']."'");
				$ds=mysql_fetch_array($ergebnis2);
				

				$nickname='href="?site=profile&id='.$ds['userID'].'"><b>'.getnickname($ds['userID']).'</b></a>';
				
				$ergebnis2 = safe_query("SELECT * FROM ".PREFIX."cups WHERE ID = $cupID");		
			    $cup=mysql_fetch_array($ergebnis2);
					
				$gameacc_sql = safe_query("SELECT * FROM ".PREFIX."user_gameacc WHERE type='".$cup['gameaccID']."' AND userID='".$ds['userID']."'");
				
				if(mysql_num_rows($gameacc_sql)){
					$dl=mysql_fetch_array($gameacc_sql);
					$game_acc = $dl[value];
				}else
					$game_acc = '<font color="'.$loosecolor.'">Not entered</a>';
				
				if($db['checkin'])
					$checkin = '<font color="'.$wincolor.'">Accepted</font>';
				else
					$checkin = '<font color="'.$loosecolor.'">Not Accepted</font>';
				
				eval ("\$one_content = \"".gettemplate("1on1_content")."\";");
				echo $one_content;
			}
			eval ("\$one_foot = \"".gettemplate("1on1_foot")."\";");
			echo $one_foot;
		}else{
			echo '<table width="100%" border="0" cellspacing="2" cellpadding="2"><tr>';
			$ergebnis = safe_query("SELECT clanID, checkin FROM ".PREFIX."cup_clans WHERE cupID = '$cupID' ORDER BY ID ASC");		
			$i = 1;
			while($db=mysql_fetch_array($ergebnis)) {
				$ergebnis2 = safe_query("SELECT ID, name, clantag, clanhp, leader, clanlogo, password, server, status FROM ".PREFIX."cup_all_clans WHERE ID = '".$db['clanID']."' ORDER BY name ASC");		
				$ds=mysql_fetch_array($ergebnis2);


				//Variablen
                                $country = 'href="?site=clans&action=show&clanID='.$ds['ID'].'&cupID='.$cupID.'">'.flags('[flag]'.getclancountry($ds['ID']).'[/flag]').'</a>';
				$clanname = 'href="?site=clans&action=show&clanID='.$ds['ID'].'&cupID='.$cupID.'">'.$ds['name'].'</a>';
		                $clantag = $ds[clantag];
		                $server = $ds[server];
		                $password = $ds[password];
		                $clanhp = $ds[clanhp];

                                $members=safe_query("SELECT userID FROM ".PREFIX."cup_clan_members WHERE clanID = '$clanID'");
		                while($dv=mysql_fetch_array($members)) { }
                                $sql_members = safe_query("SELECT * FROM ".PREFIX."cup_clan_members WHERE clanID = '".$db['clanID']."'");	
		                $members = mysql_num_rows($sql_members);


                                $details = 'href="?site=clans&action=show&clanID='.$ds['ID'].'&cupID='.$cupID.'"><img border="0" src="../images/icons/foldericons/folder.gif"></a> href="?site=clans&action=clanjoin&clanID='.$ds['ID'].'"><img border="0" src="../images/cup/icons/go.png" width="16" height="16"></a> href="admincenter.php?site=clans&action=edit&clanID='.$ds['ID'].'"><img border="0" src="../images/cup/icons/manage.gif"></a> href="?site=clans&action=editpwd&clanID='.$ds['ID'].'"><img border="0" src="../images/cup/icons/key.png"></a>';
		                $leader = 'href="?site=profile&id='.$ds[leader].'">'.getnickname($ds[leader]).'</a><a href="?site=profile&id='.$ds[leader].'">'.$email.'</a> $pm.$buddy.$icq.$skype.$xfirec.$steam.$msn.$aim.$yahoo <a href="index.php?site=matches&action=viewmatches&memberID='.$id.'" target="_top"><img border="0" src="images/cup/icons/add_result.gif" width="18" height="18"></a>';
				if($ds['clanlogo'] && $ds['clanlogo'] != 'http://')
					$clanlogo = '<img src="'.$ds['clanlogo'].'" alt="n/a" border="0" height="100" vspace="3" width="100">';
				else
					$clanlogo = '<img src="../images/avatars/noavatar.gif" alt="n/a" border="0" height="100" vspace="5" width="100">';
				
				if($db['checkin'])
					$status = '<img src="../images/icons/online.gif" border="0" alt="" title="Accepted" />';
				else
					$status = '<img src="../images/icons/offline.gif" border="0" alt="" title="Not Accepted"  />';
				if($db['checkin'])
					$status1 = '<font color="#00FF00"><b>Partipating</b> - team entered by admin, goodluck! <img src="../images/smileys/aug.gif"></font>';
				else
					$status1 = '<a style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'unchecked\')" onmouseout="hideWMTT()"><font color="red"><b>Unaccepted</b> - team not checked into this cup yet. (?)</font></a>';
				
				eval ("\$clans = \"".gettemplate("clans")."\";");
				echo $clans;
				if(!($i%4))
					echo '</tr><tr>';
				$i++;
			}
			echo '</tr></table>';
		}  
		echo $inctemp; echo base64_decode('');
	}
}

if($_POST['enterusers']) { 
	$clanID = $_POST['ID'];
	$users = $_POST['users'];
	
	if(is_array($users)) {
		foreach($users as $id) {
	        mysql_query("INSERT INTO ".PREFIX."cup_clan_members (clanID, userID, function) VALUES ('$clanID', '$id', 'Member')");
	        redirect('admincenter.php?site=clans&action=edit&clanID='.$clanID, '<b>Success!</b><br>Redirecting...', 0);
	      }
	    }	
}elseif($_POST['removeusers']) {
	$clanID = $_POST['ID'];
	$users = $_POST['users'];
	
	if(is_array($users)) {
		foreach($users as $id) {
	        safe_query("DELETE FROM ".PREFIX."cup_clan_members WHERE clanID='$clanID' && userID='$id'");
	        redirect('admincenter.php?site=clans&action=edit&clanID='.$clanID, '<b>Success!</b><br>Redirecting...', 0);
	    }
	}
}

?>	