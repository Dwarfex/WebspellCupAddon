<link href="cup.css" rel="stylesheet" type="text/css">
<script language="javascript">wmtt = null; document.onmousemove = updateWMTT; function updateWMTT(e) { x = (document.all) ? window.event.x + document.body.scrollLeft : e.pageX; y = (document.all) ? window.event.y + document.body.scrollTop  : e.pageY; if (wmtt != null) { wmtt.style.left=(x + 20) + "px"; wmtt.style.top=(y + 20) + "px"; } } function showWMTT(id) {	wmtt = document.getElementById(id);	wmtt.style.display = "block" } function hideWMTT() { wmtt.style.display = "none"; }</script>
<script type="text/javascript">
function SelectAll(id)
{
    document.getElementById(id).focus();
    document.getElementById(id).select();
}
</script>
<style>
.show_hide_cs {
	display:none;
}
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js" type="text/javascript"></script>
<script type="text/javascript">

$(document).ready(function(){
        $(".slidingDiv_cs").<?php echo ($_GET['display']=='cup' ? 'show' : 'hide'); ?>();
        $(".show_hide_cs").show();

	$('.show_hide_cs').click(function(){
	$(".slidingDiv_cs").slideToggle();
	});

});

</script>
<div class="tooltip" id="confirmed" align="left"><center><b>* Match Confirmed *</b></center></div>
<div class="tooltip" id="admin_confirmed" align="left"><center><b>* Match Confirmed by Admin*</b></center></div>
<div class="tooltip" id="awaiting" align="left"><center><b>Awaiting<img src="images/cup/period_ani.gif"></b></center></div>
<div class="tooltip" id="protest" align="left"><center><b><blink>* Opened Protest *</blink></b></center></div>
<div class="tooltip" id="participants" align="center"><b>View all cup participants</b></div>
<div class="tooltip" id="brackets" align="center"><b>View the tournament-tree (brackets)</b></div>
<div class="tooltip" id="rules" align="center"><b>View the cup rules</b></div>
<div class="tooltip" id="admins" align="center"><b>View the cup admins</b></div>
<div class="tooltip" id="irc" align="center"><b>Join the IRC Cupchat</b></div>
<div class="tooltip" id="details" align="center"><b>View cup details</b></div>

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
#   Copyright 2005-2009 by webspell.org                                  #
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
#              CUP ADDON V4.1.4C/V4.1.5/V5.X MODIFICATION                #
##########################################################################
*/

include ("config.php");

$bg1=BG_1;
$bg2=BG_2;
$bg3=BG_3;
$bg4=BG_4;

if(isset($_GET['id'])) $id = (int)$_GET['id'];
else $id=$userID;
if(isset($_GET['action'])) $action = $_GET['action'];
else $action = '';

gettimezone();
match_query_type();

/* USER CUP STATS */

    if(isset($_GET['cupID'])) {
       $league = 'cup';
       $ID = $_GET['cupID'];
       $cup_stats = 1;
       $league_name = getcupname($ID);
       $for = "for";
    }   
    elseif(isset($_GET['laddID'])) {
       $league = 'ladder';
       $ID = $_GET['laddID'];
       $cup_stats = 1;
       $league_name = getladname($ID);
       $for = "for";
    }
    elseif(isset($_GET['groupID'])) {
       $league = 'gs';
       $ID = $_GET['groupID'];
       $cup_stats = 1;
	   $league_name = "Group Stages";
	   $for = "for";
    }
    else{
       $league = false;
       $ID = false;
       $cup_stats = 0;
       $league_name = false;
       $for = "";
    }    
    
    if($cup_stats) {
       echo '<hr><center><font color="red"><strong>Showing matches/stats for: '.$league_name.' league.</strong></font> (<a href="?site=profile&id='.$id.'">Player-Home</a>)</center><hr>';
    }

    $totaltotalusermatches = user_cup_points($id,$ID,$team=0,$won=0,$lost=0,$type="",$league);
    $matcheslost = user_cup_points($id,$ID,$team=0,$won=0,$lost=1,$type="confirmed",$league);
    $openmatches = user_cup_points($id,$ID,$team=0,$won=0,$lost=0,$type="open",$league);
    $matcheswon = user_cup_points($id,$ID,$team=0,$won=1,$lost=0,$type="confirmed",$league);
    $confirmedmatches = user_cup_points($id,$ID,$team=0,$won=0,$lost=0,$type="confirmed",$league);
    $pendingmatches = user_cup_points($id,$ID,$team=0,$won=0,$lost=0,$type="pending",$league);
    $matchprotests = user_cup_points($id,$ID,$team=0,$won=0,$lost=0,$type="protest",$league);
    $userwonpoints = user_cup_points($id,$ID,$team=0,$won=1,$lost=0,$type="confirmed_p",$league);
    $userlostpoints = user_cup_points($id,$ID,$team=0,$won=0,$lost=1,$type="confirmed_p",$league);
    $usertotalpoints = user_cup_points($id,$ID,$team=0,$won=0,$lost=0,$type="confirmed_p",$league);
    $userscoreratio = percent(user_cup_points($id,$ID,$team=0,$won=1,$lost=0,$type="confirmed_p",$league), user_cup_points($id,$ID,$team=0,$won=0,$lost=0,$type="confirmed_p",$league), 2);
    
/* GET USER AWARDS */

		getclanawards($id,1);
		$award1 = '';
		$award2 = '';
		$award3 = '';
		if($ar_awards[1]){
			for($i=1; $i<=$ar_awards[1]; $i++)
				$award1.='<a href="?site=brackets&action=tree&cupID='.$ar1_name[$i-1].'"><img src="images/cup/icons/award_gold.png" border="0" alt="Gold" title="'.getcupname($ar1_name[$i-1]).'" /></a>'; 
		}
		if($ar_awards[2]){
			for($i=1; $i<=$ar_awards[2]; $i++)
				$award2.='<a href="?site=brackets&action=tree&cupID='.$ar2_name[$i-1].'"><img src="images/cup/icons/award_silver.png" border="0" alt="'.$_language->module['silver'].'" title="'.getcupname($ar2_name[$i-1]).'" /></a>';
		}
		if($ar_awards[3]){
			for($i=1; $i<=$ar_awards[3]; $i++)
				$award3.='<a href="?site=brackets&action=tree&cupID='.$ar3_name[$i-1].'"><img src="images/cup/icons/award_bronze.png" border="0" alt="Bronze" title="'.getcupname($ar3_name[$i-1]).'" /></a>';
		}		
		$awards=$award1.$award2.$award3;
		
		getclanawards_lad($id,1);
		$award1 = '';
		$award2 = '';
		$award3 = '';
		if($ar_awards[1]){
		   	for($i=1; $i<=$ar_awards[1]; $i++)
			   	$award1.='<a href="?site=standings&ladderID='.$ar1_name[$i-1].'"><img src="images/cup/icons/award_gold.png" border="0" alt="Gold" title="'.getladname($ar1_name[$i-1]).'" /></a>'; 
		}
		if($ar_awards[2]){
		 for($i=1; $i<=$ar_awards[2]; $i++)
				$award2.='<a href="?site=standings&ladderID='.$ar2_name[$i-1].'"><img src="images/cup/icons/award_silver.png" border="0" alt="'.$_language->module['silver'].'" title="'.getladname($ar2_name[$i-1]).'" /></a>';
		}
		if($ar_awards[3]){
		 for($i=1; $i<=$ar_awards[3]; $i++)
			 $award3.='<a href="?site=standings&ladderID='.$ar3_name[$i-1].'"><img src="images/cup/icons/award_bronze.png" border="0" alt="Bronze" title="'.getladname($ar3_name[$i-1]).'" /></a>';
		}		
		$awards_lad=$award1.$award2.$award3;
		
		if(empty($awards) && empty($awards_lad)) {
		         $cups = "<strong>0</strong>";
		}
		else{
		         $cups = $awards.$awards_lad;
		}	
		
/* GET EDIT GAMEACCOUNT */

if(isset($_GET['edit']) && $_GET['edit']=="account" && isset($_GET['gameaccID']) && isset($_GET['type'])) { 
    
    $getvalue = safe_query("SELECT value FROM ".PREFIX."user_gameacc WHERE userID='$id' && gameaccID='".$_GET['gameaccID']."'");
    $dr = mysql_fetch_array($getvalue);
    
      $game.='<option selected value="'.$_GET['gameaccID'].'">'.$_GET['type'].'</option>';
    
	   $editgacc = '
			<form method="post" action="?site=profile">
				<table width="100%" border="0" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'" bgcolor="'.$border.'">
				    <tr>
						<td class="title" colspan="5" align="center" bgcolor="'.$bghead.'">Edit Gameaccount</td>
				    </tr>
					<tr> 
						<td colspan="5" bgcolor="'.$pagebg.'"></td>
					</tr>
					<a name="editgacc"></a>
				    <tr>
						<td bgcolor="'.BG_1.'" style="width:40%;" align="right"> </td>
						<td bgcolor="'.BG_1.'"><select name="type">'.$game.'</select></td>
				    </tr>
					<tr>
						<td bgcolor="'.BG_1.'" style="width:40%;" align="right">Value:</td>
						<td bgcolor="'.BG_1.'"><input name="value" type="text" size="30"  value="'.getinput($dr['value']).'"></td>
				    </tr>
					<tr>
						<td bgcolor="'.BG_1.'"><input type="hidden" name="id" value="'.$id.'"></td>
						<td bgcolor="'.BG_1.'"><input type="submit" name="edit" value="Update"></td>
				    </tr>
				</table>
			</form>'; }	
			
    if(isset($_POST['edit'])) {
      
	  $type = $_POST['type'];
	  $value = $_POST['value'];
	  $id = $_POST['id'];

	  $ergebnis=safe_query("SELECT * FROM ".PREFIX."user_gameacc WHERE userID='$id'");
		$ds=mysql_fetch_array($ergebnis);
		
	  $inlog=safe_query("SELECT * FROM ".PREFIX."user_gameacc WHERE userID='$id' AND gameaccID='$type'");
		$dd=mysql_fetch_array($inlog);
		
	$ergebnis2 = safe_query("SELECT value FROM ".PREFIX."user_gameacc WHERE value = '$value' && type = '".$dd['type']."' && log='0'");
		$num_gameacc = mysql_num_rows($ergebnis2);
		
		//echo "SELECT value FROM ".PREFIX."user_gameacc WHERE value = '$value' && type = '".$dd['type']."'";
		
		if($num_gameacc)  {
		    $error="Already in-use!";
			die('<b>ERROR: '.$error.'</b><br><br><input type="button" class="button" onClick="javascript:history.back()" value="Back">');
		}
		if(!(strlen(trim($value)))) {
		    $error="You have to enter a Value!";
			die('<b>ERROR: '.$error.'</b><br><br><input type="button" class="button" onClick="javascript:history.back()" value="Back">');
		}
			
		
        safe_query("INSERT INTO ".PREFIX."user_gameacc (userID, type, value, log) VALUES ('".$id."', '".$dd['type']."', '".$dd['value']."', '1')");
		safe_query("UPDATE ".PREFIX."user_gameacc SET value='$value' WHERE userID='$id' AND gameaccID='$type'");

		echo'Your Gameaccount has been saved with your previous one in your log. Just wait a few seconds to be redirected!
	    	          <meta http-equiv="refresh" content="3; URL=?site=profile&id='.$id.'&gameacc=changelog#seegameaccounts">';
    }
            
/* GET TEAMS */

$getteams = safe_query("SELECT * FROM ".PREFIX."cup_clan_members WHERE userID='$id'");
if(mysql_num_rows($getteams)) {

$profile_teams = '<table width="100%" cellpadding="'.$cellpadding.'" cellspacing="'.$cellspacing.'" bgcolor="'.$border.'">
                 <td class="title" bgcolor="$bghead" colspan="12">&nbsp; &#8226; Teams</td>    
		  <tr>
		      <td bgcolor="'.$bg2.'"><strong>Team</strong></td>
		      <td bgcolor="'.$bg2.'" align="center"><strong>Members</strong></td>
		      <td bgcolor="'.$bg2.'" align="center"><strong>Rank</strong></td>
		      <td bgcolor="'.$bg2.'" align="center"><strong>Details</strong></td>
		  </tr> 
		    <tr>
		      <td colspan="7" bgcolor="'.$pagebg.'"></td>
		  </tr>';

  $n=1;
    while($dd=mysql_fetch_array($getteams)) {
    
      $n%2 ? $bgcolor=BG_1 : $bgcolor=BG_2;
  
      $clanID = $dd['clanID'];
      $clanname = '<a href="?site=clans&action=show&clanID='.$clanID.'"><b>'.getclanname2($clanID).'</b></a>';
     
      if(!getclanname2($clanID)) $clanname = '<font color="red">(Removed Team)</font>';
    
      $getowner = safe_query("SELECT * FROM ".PREFIX."cup_all_clans WHERE ID='$clanID' AND leader='$id'");
      $ds=mysql_fetch_array($getowner); 

      if($id==$ds['leader'] && $dd['function']=='Leader') { 
              $isowner = 'Owner'; 
      }
      elseif($dd['function']=='leader'){ 
              $isowner = 'Leader'; 
      }
      else{
              $isowner = 'Member';
      }

      $cups_t = (!cupawards($clanID,0) && !ladawards($clanID,0) ? "<img src='images/cup/icons/nok_32.png' width='16' height='16'>" : cupawards($clanID,0).ladawards($clanID,0));
      $cm=mysql_fetch_array(safe_query("SELECT count(*) as members FROM ".PREFIX."cup_clan_members WHERE clanID='$clanID'"));

	  $clanhp = (!empty($ds['clanhp']) && $ds['clanhp']!='http://' ? '<a href="'.$ds['clanhp'].'" target="_blank"><img src="images/profile/hp.gif" width="20" height="20" align="right"></a>' : ''); 
      $cup_ID = isset($_GET['cupID']) ? $_GET['cupID'] : 0;
	  
		if(user_cup_points($ds['ID'],$cup_ID,$team=1,$won=0,$lost=0,$type='',$league)) {
		   $show_matches = '<a href="?site=matches&action=viewmatches&clanID='.$ds['ID'].'"><img border="0" src="images/cup/icons/add_result.gif" align="right"></a>';
		}
		else{
		   $show_matches = false;
		}
	
      $profile_teams.='
              <tr> 
                <td bgcolor="'.$bg1.'">'.getusercountry3($clanID).' '.$clanname.$clanhp.$show_matches.'</td>
                <td bgcolor="'.$bg1.'" align="center">'.$cm['members'].' Active</td>
                <td bgcolor="'.$bg1.'" align="center">'.$isowner.'</td>
                <td bgcolor="'.$bg1.'" align="center"><a href="?site=clans&action=show&clanID='.$clanID.'"><img src="images/icons/foldericons/folder.gif" border="0"></a></td>
              </tr>'; 
	      
		$n++;
    }
   $profile_teams.='</table>';
}
else{ 
      $profile_teams = '';
}
 
/* GET USER CUPS */
		
           $cups_ft = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE clanID='$id' && 1on1='1' && (cupID!='0' || ladID!='0')");
	        if(mysql_num_rows($cups_ft)) {
		
		   $all_cups = '<table width="100%" cellpadding="'.$cellpadding.'" cellspacing="'.$cellspacing.'" bgcolor="'.$border.'">
		                <tr>
						  <td class="title" bgcolor="$bghead" colspan="12">&nbsp; &#8226; Leagues</td>
			            </tr>
						  <tr>
			                <td bgcolor="'.$bg2.'" colspan="2"><strong>League</strong></td>
			                <td bgcolor="'.$bg2.'" colspan="2" align="center"><strong>Matches</strong></td>
			                <td bgcolor="'.$bg2.'" colspan="3" align="center"><strong>Activity</strong></td>
			            </tr>';
		}
		else{
		   $all_cups = '';
		}
		
	         while($ds = mysql_fetch_assoc($cups_ft)) {
		 
		    if($ds['type']=='ladder') {
		        $tit = "Ladder";
		        $cupID = $ds['ladID'];
			    $typee = 'laddID';
			    $type5 = 'ID';
			    $pic = '<img src="images/cup/icons/ladder.png">';			    
		        $mtc_league1 = '<a href="?site=matches&action=viewmatches&'.$typee.'='.$cupID.'">';
			    $mtc_league2 = '<a href="?site=matches&action=viewmatches&'.$typee.'='.$cupID.'&clanID='.$id.'">';			    
			    $league = '<a href="?site=ladders&ID='.$cupID.'">'.getladname($cupID).'</a>';
				$league2 = '<a href="?site=ladders&ID='.$cupID.'"><img src="images/icons/foldericons/folder.gif"> Details</a>';
		    }
		    elseif($ds['type']=='cup') {
		        $tit = "Tournament";
		        $cupID = $ds['cupID'];
			    $typee = 'cupID';
			    $type5 = 'cupID';
			    $pic = '<img src="images/cup/icons/tournament.png">';			    
		        $mtc_league1 = '<a href="?site=matches&action=viewmatches&'.$typee.'='.$cupID.'">';
			    $mtc_league2 = '<a href="?site=matches&action=viewmatches&'.$typee.'='.$cupID.'&clanID='.$id.'">';			    
			    $league = '<a href="?site=cups&action=details&cupID='.$cupID.'">'.getcupname($cupID).'</a>';
				$league2 = '<a href="?site=cups&action=details&cupID='.$cupID.'"><img src="images/icons/foldericons/folder.gif"> Details</a>';
		    }
		    elseif($ds['type']=='gs' && $ds['ladID'] && $ds['cupID']==0) {
		        $tit = "Group";
		        $cupID = $ds['groupID'];
			    $typee = 'groupID';
			    $type5 = 'ID';
			    $pic = '<img src="images/cup/icons/groups.png">';			    
		        $mtc_league1 = '<a href="?site=groups&laddID='.$cupID.'">';
			    $mtc_league2 = '<a href="?site=matches&action=viewmatches&memberID='.$id.'&type=gs">';			    
			    $league = '<a href="?site=ladders&ID='.$cupID.'">'.getladname($cupID).'</a>';
				$league2 = '<a href="?site=ladders&ID='.$cupID.'"><img src="images/icons/foldericons/folder.gif"> Details</a>';
		    }
		    elseif($ds['type']=='gs' && $ds['cupID'] && $ds['ladID']==0) {
		        $tit = "Group";
		        $cupID = $ds['groupID'];
			    $typee = 'groupID';
			    $type5 = 'cupID';
			    $pic = '<img src="images/cup/icons/groups.png">';			    
		        $mtc_league1 = '<a href="?site=groups&cupID='.$cupID.'">';
			    $mtc_league2 = '<a href="?site=matches&action=viewmatches&memberID='.$id.'&type=gs">';			    
			    $league = '<a href="?site=cups&action=details&cupID='.$cupID.'">'.getcupname($cupID).'</a>';
				$league2 = '<a href="?site=cups&action=details&cupID='.$cupID.'"><img src="images/icons/foldericons/folder.gif"> Details</a>';
		    }
		    
		    if($cupID AND $typee AND $pic AND $league AND $league2)		 
	
	        $all_cups .='<tr>
			      <td bgcolor="'.$bg1.'" colspan="2">'.$pic.' '.$league.'</td>
			      <td bgcolor="'.$bg1.'" align="center"><img src="images/cup/icons/add_result.gif" width="16" height="16"> '.$mtc_league1.' '.$tit.' Matches</a></td>
			      <td bgcolor="'.$bg1.'" align="center"><img src="images/cup/icons/add_result.gif" width="16" height="16"> '.$mtc_league2.' User Matches</a></td>
			      <td bgcolor="'.$bg1.'" colspan="3" align="center"><a href="?site=profile&id='.$id.'&'.$typee.'='.$cupID.'&display=cup#stats"><img border="0" src="images/cup/icons/points.png" border="0"> Stats</a> '.$league2.'</td>
			    </tr>';	    
		    }
     	    
			if(mysql_num_rows($cups_ft)) echo '</table>';
	       
/* GET USER PENALTY POINTS */
	
	$userpoints = '';
	$all_points = getuserpenaltypoints($id);	
	$ergebnis2 = safe_query("SELECT * FROM ".PREFIX."cup_warnings WHERE clanID = '$id' && expired='0' && 1on1='1' ORDER BY time DESC");	
	$warn_num = mysql_num_rows($ergebnis2); 
	if($warn_num){
		$userpoints= '
		   <tr>
			  <td class="title" colspan="8">&nbsp; &#8226; Penalty Points ('.$all_points.' Total)</td>
		    </tr>    
		     <tr>
		      <td align="center" bgcolor="'.$bg2.'"><strong>Points</strong></td>
		      <td align="center" bgcolor="'.$bg2.'"><strong>Title</strong></td>
		      <td align="center" bgcolor="'.$bg2.'"><strong>Description</strong></td>
		      <td align="center" bgcolor="'.$bg2.'"><strong>Match Link</strong></td>
		      <td align="center" bgcolor="'.$bg2.'"><strong>Expires</strong></td>
		    </tr> 
			 <tr>
			  <td colspan="8" bgcolor="'.$pagebg.'"></td>
		    </tr>';
	
		$n=1;
		while($dr=mysql_fetch_array($ergebnis2)) {
			$userpoints.= '<a name="points"></a>
					<tr>
						<td align="center" bgcolor="'.$bg1.'">'.$dr['points'].'</td>
						<td align="center" bgcolor="'.$bg1.'">'.$dr['title'].'</td>
						<td align="center" bgcolor="'.$bg1.'">'.$dr['desc'].'</td>
						<td align="center" bgcolor="'.$bg1.'"><a href="'.$dr['matchlink'].'">(URL)</a></td>
						<td align="center" bgcolor="'.$bg1.'">'.date('d.m.Y \a\t H:i', $dr['deltime']).'</td>			
					</tr>
				 ';
			$n++;
		}
	}
	
/* GET USER ACTIVITY GRAPH */

        if($totaltotalusermatches) {
	
	    $ma = '
		    <tr>
		      <td class="title" colspan="8">&nbsp; &#8226; Matches Activity</td>
		    </tr>    
		     <tr>
		      <td align="center" bgcolor="'.$bg1.'" colspan="8"><img id="last_user" src="admin/visitor_statistic_image.php?last=user&amp;id='.$_GET['id'].'&amp;count=30" width="100%" alt="" /></td>
		    </tr>
		   ';
	}	
		
/*
##########################################################################
#      END CUP ADDON V4.1.4C/V4.1.5 MODIFICATION (www.Cupaddon.com)      #
##########################################################################
*/

$_language->read_module('profile');

if(isset($id) and getnickname($id) != '') {
	
	if(isbanned($id)) $banned = '<br /><center><font style="color:red;font-weight:bold;font-size:11px;letter-spacing:1px;">'.$_language->module['is_banned'].'</font></center>';
	else $banned = '';

	//profil: buddys
	if($action == "buddys") {

		eval("\$title_profile = \"".gettemplate("title_profile")."\";");
		echo $title_profile;
		
		if($userID==$id) echo 'Click <a href="?site=buddys"><strong>here</strong></a> to edit your buddy-list.';

    $buddylist="";
    $buddys = safe_query("SELECT buddy FROM ".PREFIX."buddys WHERE userID='".$id."'");
		if(mysql_num_rows($buddys)) {
			$n = 1;
			while($db = mysql_fetch_array($buddys)) {
				$n % 2 ? $bgcolor = BG_1 : $bgcolor = BG_2;
				$flag = '[flag]'.getcountry($db['buddy']).'[/flag]';
				$country = flags($flag);
				$nicknamebuddy = getnickname($db['buddy']);
				$email = "<a href='mailto:".mail_protect(getemail($db['buddy']))."'><img src='images/cup/icons/message.png' border='0' alt='' /></a>";
        
        if(isignored($userID, $db['buddy'])) $buddy = '<a href="buddys.php?action=readd&amp;id='.$db['buddy'].'&amp;userID='.$userID.'"><img src="images/icons/buddy_readd.gif" border="0" alt="'.$_language->module['back_buddylist'].'" /></a>';
				elseif(isbuddy($userID, $db['buddy'])) $buddy = '<a href="buddys.php?action=ignore&amp;id='.$db['buddy'].'&amp;userID='.$userID.'"><img src="images/icons/buddy_ignore.gif" border="0" alt="'.$_language->module['ignore_user'].'" /></a>';
				elseif($userID == $db['buddy']) $buddy = '';
				else $buddy = '<a href="buddys.php?action=add&amp;id='.$db['buddy'].'&amp;userID='.$userID.'"><img src="images/icons/buddy_add.gif" border="0" alt="'.$_language->module['add_buddylist'].'" /></a>';

        if(isonline($db['buddy']) == "offline") $statuspic = '<img src="images/icons/offline.gif" alt="'.$_language->module['offline'].'" />';
				else $statuspic = '<img src="images/icons/online.gif" alt="'.$_language->module['online'].'" />';
        
        $buddylist .= '<tr bgcolor="'.$bgcolor.'">
            <td>
            <table width="100%" cellpadding="'.$cellpadding.'" cellspacing="'.$cellspacing.'">
              <tr>
                <td>'.$country.' <a href="index.php?site=profile&amp;id='.$db['buddy'].'"><b>'.$nicknamebuddy.'</b></a></td>
                <td align="right">'.$email.'&nbsp;&nbsp;'.$buddy.'&nbsp;&nbsp;'.$statuspic.'</td>
              </tr>
            </table>
            </td>
          </tr>';
            
				$n++;
			}
		}
		else $buddylist = '<tr>
        <td colspan="2" bgcolor="'.BG_1.'">'.$_language->module['no_buddys'].'</td>
      </tr>';

		eval("\$profile = \"".gettemplate("profile_buddys")."\";");
		echo $profile;
		
		//galleries

} elseif(isset($_GET['action']) && $_GET['action'] == "galleries") {

eval ("\$title_profile = \"".gettemplate("title_profile")."\";");
echo $title_profile;

$galclass = new Gallery();

$border=BORDER;
$bgcat=BGCAT;

$galleries=safe_query("SELECT * FROM ".PREFIX."gallery WHERE userID='$id'");

echo '<br><table width="100%" border="0" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'" bgcolor="'.$border.'">
	<tr><td class="title" colspan="4">&nbsp;&#8226; Galleries of '.getnickname($id).'</tr>
  <tr bgcolor="'.$bgcat.'">
   <td width="100">&nbsp;</td>
   <td width="100"><b>Date</b></td>
   <td><b>Name</b></td>
   <td width="80"><b>Pictures</b></td>
  </tr>';

if($usergalleries) {
 if(mysql_num_rows($galleries)) {
    $n=1;
	while($ds=mysql_fetch_array($galleries)) {
		$n%2 ? $bg=BG_1 : $bg=BG_2;

    $piccount=mysql_num_rows(safe_query("SELECT * FROM ".PREFIX."gallery_pictures WHERE galleryID='".$ds[galleryID]."'"));
    $commentcount=mysql_num_rows(safe_query("SELECT * FROM ".PREFIX."comments WHERE parentID='".$ds[galleryID]."' AND type='ga'"));


		$gallery[date] = date("d.m.Y",$ds[date]);
		$gallery[title] = cleartext($ds[name]);
	  $gallery[picture] = $galclass->randompic($ds[galleryID]);
		$gallery[galleryID] = $ds[galleryID];
		$gallery[count] = mysql_num_rows(safe_query("SELECT picID FROM `".PREFIX."gallery_pictures` WHERE galleryID='".$ds[galleryID]."'"));

    eval ("\$profile = \"".gettemplate("profile_galleries")."\";");
    echo $profile;

		$n++;
	}
 }
 else echo '<tr>
                   <td colspan="4" bgcolor="'.BG_1.'">no galleries</td>
                 </tr>';
} else echo '<tr>
                   <td colspan="4" bgcolor="'.BG_1.'">User-Galleries disabled.</td>
                 </tr>';

echo '</table>';


	}
	elseif($action == "galleries") {

		//galleries
		eval("\$title_profile = \"".gettemplate("title_profile")."\";");
		echo $title_profile;

		$galclass = new Gallery();

		$border = BORDER;
		$bgcat = BGCAT;
		$pagebg = PAGEBG;

		$galleries = safe_query("SELECT * FROM ".PREFIX."gallery WHERE userID='".$id."'");

		echo '<br /><table width="100%" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'" bgcolor="'.$border.'">
      <tr>
        <td class="title" colspan="4">&nbsp;&#8226; '.$_language->module['galleries'].' '.$_language->module['by'].' '.getnickname($id).'</td>
      </tr>
      <tr><td bgcolor="'.$pagebg.'" colspan="4"></td></tr>
      <tr bgcolor="'.$bgcat.'">
        <td width="100">&nbsp;</td>
        <td width="100"><b>'.$_language->module['date'].'</b></td>
        <td><b>'.$_language->module['name'].'</b></td>
        <td width="80"><b>'.$_language->module['pictures'].'</b></td>
      </tr>';

		if($usergalleries) {
			if(mysql_num_rows($galleries)) {
				$n = 1;
				while($ds = mysql_fetch_array($galleries)) {
					$n % 2 ? $bg = BG_1 : $bg = BG_2;

					$piccount = mysql_num_rows(safe_query("SELECT * FROM ".PREFIX."gallery_pictures WHERE galleryID='".$ds['galleryID']."'"));
					$commentcount = mysql_num_rows(safe_query("SELECT * FROM ".PREFIX."comments WHERE parentID='".$ds['galleryID']."' AND type='ga'"));


					$gallery['date'] = date("d.m.Y",$ds['date']);
					$gallery['title'] = cleartext($ds['name']);
					$gallery['picture'] = $galclass->randompic($ds['galleryID']);
					$gallery['galleryID'] = $ds['galleryID'];
					$gallery['count'] = mysql_num_rows(safe_query("SELECT picID FROM `".PREFIX."gallery_pictures` WHERE galleryID='".$ds['galleryID']."'"));

					eval("\$profile = \"".gettemplate("profile_galleries")."\";");
					echo $profile;

					$n++;
				}
			}
			else echo '<tr>
          <td colspan="4" bgcolor="'.BG_1.'">'.$_language->module['no_galleries'].'</td>
        </tr>';
		}
		else echo '<tr>
        <td colspan="4" bgcolor="'.BG_1.'">'.$_language->module['usergalleries_disabled'].'</td>
      </tr>';

		echo '</table>';

	}
	elseif($action == "lastposts") {

		//profil: last posts

		eval("\$title_profile = \"".gettemplate("title_profile")."\";");
		echo $title_profile;

		$topiclist="";
		$topics=safe_query("SELECT * FROM ".PREFIX."forum_topics WHERE userID='".$id."' AND moveID=0 ORDER BY date DESC");
		if(mysql_num_rows($topics)) {
			$n = 1;
			while($db = mysql_fetch_array($topics)) {
				if($db['readgrps'] != "") {
					$usergrps = explode(";", $db['readgrps']);
					$usergrp = 0;
					foreach($usergrps as $value) {
						if(isinusergrp($value, $userID)) {
							$usergrp = 1;
							break;
						}
					}
					if(!$usergrp and !ismoderator($userID, $db['boardID'])) continue;
				}
				$n % 2 ? $bgcolor = BG_1 : $bgcolor = BG_2;
				$posttime = date("d.m.y H:i", $db['date']);

				$topiclist .= '<tr bgcolor="'.$bgcolor.'">
            <td width="50%">
            <table width="100%" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'">
              <tr>
                <td colspan="3"><div style="overflow:hidden;"><a href="index.php?site=forum_topic&amp;topic='.$db['topicID'].'">'.$posttime.'<br /><b>'.clearfromtags($db['topic']).'</b></a><br /><i>'.$db['views'].' '.$_language->module['views'].' - '.$db['replys'].' '.$_language->module['replys'].'</i></div></td>
              </tr>
            </table>
            </td>
          </tr>';

				if($profilelast == $n) break;
				$n++;
			}
		}
		else $topiclist = '<tr>
        <td colspan="2" bgcolor="'.BG_1.'">'.$_language->module['no_topics'].'</td>
      </tr>';

		$postlist="";
		$posts=safe_query("SELECT ".PREFIX."forum_topics.boardID, ".PREFIX."forum_topics.readgrps, ".PREFIX."forum_topics.topicID, ".PREFIX."forum_topics.topic, ".PREFIX."forum_posts.date, ".PREFIX."forum_posts.message FROM ".PREFIX."forum_posts, ".PREFIX."forum_topics WHERE ".PREFIX."forum_posts.poster='".$id."' AND ".PREFIX."forum_posts.topicID=".PREFIX."forum_topics.topicID ORDER BY date DESC");
		if(mysql_num_rows($posts)) {
			$n = 1;
			while($db = mysql_fetch_array($posts)) {
				if($db['readgrps'] != "") {
					$usergrps = explode(";", $db['readgrps']);
					$usergrp = 0;
					foreach($usergrps as $value) {
						if(isinusergrp($value, $userID)) {
							$usergrp = 1;
							break;
						}
					}
					if(!$usergrp and !ismoderator($userID, $db['boardID'])) continue;
				}

				$n % 2 ? $bgcolor1 = BG_1 : $bgcolor1 = BG_2;
				$n % 2 ? $bgcolor2 = BG_3 : $bgcolor2 = BG_4;
				$posttime = date("d.m.y h:i", $db['date']);
				if(mb_strlen($db['message']) > 100) $message = mb_substr($db['message'], 0, 90 + mb_strpos(mb_substr($db['message'], 90, mb_strlen($db['message'])), " "))."...";
				else $message = $db['message'];
				$postlist.='<tr bgcolor="'.$bgcolor1.'">
            <td>
            <table width="100%" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'">
              <tr>
                <td colspan="3"><a href="index.php?site=forum_topic&amp;topic='.$db['topicID'].'">'.$posttime.' <br /><b>'.$db['topic'].'</b></a></td>
              </tr>
              <tr><td></td></tr>
              <tr>
                <td width="1%">&nbsp;</td>
                <td bgcolor="'.$bgcolor2.'"><div style="width: 250px;overflow:hidden;">'.clearfromtags($message).'</div></td>
                <td width="1%">&nbsp;</td>
              </tr>
            </table>
            </td>
          </tr>';

				if($profilelast == $n) break;
				$n++;
			}
		}
		else $postlist='<tr>
        <td colspan="2" bgcolor="'.BG_1.'">'.$_language->module['no_posts'].'</td>
      </tr>';



		eval("\$profile = \"".gettemplate("profile_lastposts")."\";");
		echo $profile;

	}
	elseif($action == "guestbook") {

		//user guestbook

		if(isset($_POST['save'])) {

			$date = time();
			$ip = getenv('REMOTE_ADDR');
			$run = 0;

			if($userID) {
				$name = getnickname($userID);
				if(getemailhide($userID)) $email='';
        else $email = getemail($userID);
				$url = gethomepage($userID);
				$icq = geticq($userID);
				$run = 1;
			}
			else {
				$name = $_POST['gbname'];
				$email = $_POST['gbemail'];
				$url = $_POST['gburl'];
				$icq = $_POST['icq'];
				$CAPCLASS = new Captcha;
				if($CAPCLASS->check_captcha($_POST['captcha'], $_POST['captcha_hash'])) $run = 1;
			}

			if($run) {

				safe_query("INSERT INTO ".PREFIX."user_gbook (userID, date, name, email, hp, icq, ip, comment)
								values('".$id."', '".$date."', '".$_POST['gbname']."', '".$_POST['gbemail']."', '".$_POST['gburl']."', '".$_POST['icq']."', '".$ip."', '".$_POST['message']."')");

				if($id != $userID) sendmessage($id, $_language->module['new_guestbook_entry'], str_replace('%guestbook_id%', $id, $_language->module['new_guestbook_entry_msg']));
			}
			redirect('index.php?site=profile&amp;id='.$id.'&amp;action=guestbook','',0);
		}
		elseif(isset($_GET['delete'])) {
			if(!isanyadmin($userID) and $id != $userID) die($_language->module['no_access']);

			foreach($_POST['gbID'] as $gbook_id) {
				safe_query("DELETE FROM ".PREFIX."user_gbook WHERE gbID='$gbook_id'");
			}
			redirect('index.php?site=profile&amp;id='.$id.'&amp;action=guestbook','',0);
		}
		else {
			eval("\$title_profile = \"".gettemplate("title_profile")."\";");
			echo $title_profile;

			$bg1 = BG_1;
			$bg2 = BG_2;

			$gesamt = mysql_num_rows(safe_query("SELECT gbID FROM ".PREFIX."user_gbook WHERE userID='".$id."'"));

			if(isset($_GET['page'])) $page = (int)$_GET['page'];
			$type="DESC";
			if(isset($_GET['type'])){
			  if(($_GET['type']=='ASC') || ($_GET['type']=='DESC')) $type=$_GET['type'];
			}

			$pages = 1;
			if(!isset($page)) $page = 1;
			if(!isset($type)) $type = "DESC";

			$max = $maxguestbook;
			$pages = ceil($gesamt/$max);

			if($pages > 1) $page_link = makepagelink("index.php?site=profile&amp;id=".$id."&amp;action=guestbook&amp;type=".$type, $page, $pages);
			else $page_link='';

			if($page == "1") {
				$ergebnis = safe_query("SELECT * FROM ".PREFIX."user_gbook WHERE userID='".$id."' ORDER BY date ".$type." LIMIT 0, ".$max);
				if($type == "DESC") $n = $gesamt;
				else $n = 1;
			}
			else {
				$start = $page * $max - $max;
				$ergebnis = safe_query("SELECT * FROM ".PREFIX."user_gbook WHERE userID='".$id."' ORDER BY date ".$type." LIMIT ".$start.", ".$max);
				if($type == "DESC") $n = $gesamt - ($page - 1) * $max;
				else $n = ($page - 1) * $max + 1;
			}

			if($type=="ASC")
			$sorter='<a href="index.php?site=profile&amp;id='.$id.'&amp;action=guestbook&amp;page='.$page.'&amp;type=DESC">'.$_language->module['sort'].':</a> <img src="images/icons/asc.gif" width="9" height="7" border="0" alt="" />&nbsp;&nbsp;&nbsp;';
			else
			$sorter='<a href="index.php?site=profile&amp;id='.$id.'&amp;action=guestbook&amp;page='.$page.'&amp;type=ASC">'.$_language->module['sort'].':</a> <img src="images/icons/desc.gif" width="9" height="7" border="0" alt="" />&nbsp;&nbsp;&nbsp;';

			echo'<br /><table width="100%" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'">
			  <tr>
			    <td>'.$sorter.' '.$page_link.'</td>
			    <td align="right"><input type="button" onclick="MM_goToURL(\'parent\',\'#addcomment\');return document.MM_returnValue" value="'.$_language->module['new_entry'].'" /></td>
			  </tr>
			</table>';

			echo '<form method="post" name="form" action="index.php?site=profile&amp;id='.$id.'&amp;action=guestbook&amp;delete=true">';
			while ($ds = mysql_fetch_array($ergebnis)) {
				$n % 2 ? $bg1 = BG_1 : $bg1 = BG_2;
				$date = date("d.m.Y - H:i", $ds['date']);

				$sem = '^[a-z0-9_\.-]+@[a-z0-9_-]+\.[a-z0-9_\.-]+$';
				if(eregi($sem, $ds['email'])) $email = '<a href="mailto:'.mail_protect($ds['email']).'"><img src="images/cup/icons/message.png" border="0" alt="'.$_language->module['email'].'" /></a>';
				else $email = '';

				$sem = '^[http://]+[a-z0-9_\.-]+[a-z0-9_-]+$';
				if(eregi($sem, $ds['hp'])) $hp = '<a href="'.$ds['hp'].'" target="_blank"><img src="images/icons/hp.gif" border="0" alt="'.$_language->module['homepage'].'" /></a>';
				else $hp = '';
				
			    $sem = '[0-9]{7,11}';
		        $icq_number = str_replace('-','',$ds[icq]);
		        if(eregi($sem, $icq_number)) $icq = '<a href="http://www.xfire.com/profile/'.$icq_number.'"><img src="http://default.ufo-net.nl~jnolten/new/images/xfire.gif" border="0" alt="xfire"></a>';
		        else $icq="";

				$sem = '[0-9]{6,11}';
				$icq_number = str_replace('-', '', $ds['icq']);
				if(eregi($sem, $icq_number)) $icq = '<a href="http://www.icq.com/people/about_me.php?uin='.$icq_number.'" target="_blank"><img src="http://online.mirabilis.com/scripts/online.dll?icq='.$icq_number.'&amp;img=5" border="0" alt="icq" /></a>';
				else $icq = "";

				$name = strip_tags($ds['name']);
				$message = cleartext($ds['comment']);
				$quotemessage = strip_tags($ds['comment']);
				$quotemessage = str_replace("'", "`", $quotemessage);

				$actions = '';
				$ip = $_language->module['logged'];
				$quote = '<a href="javascript:AddCode(\'[quote='.$name.']'.$quotemessage.'[/quote]\')"><img src="images/icons/quote.gif" border="0" alt="'.$_language->module['quote'].'" /></a>';
				if(isfeedbackadmin($userID) OR $id == $userID) {
					$actions = '<input class="input" type="checkbox" name="gbID[]" value="'.$ds['gbID'].'" />';
					if(isfeedbackadmin($userID)) $ip = $ds['ip'];
				}

				eval("\$profile_guestbook = \"".gettemplate("profile_guestbook")."\";");
				echo $profile_guestbook;

				if($type == "DESC") $n--;
				else $n++;
			}

			if(isfeedbackadmin($userID) || $userID == $id) $submit='<input class="input" type="checkbox" name="ALL" value="ALL" onclick="SelectAll(this.form);" /> '.$_language->module['select_all'].'
											  <input type="submit" value="'.$_language->module['delete_selected'].'" />';
											  else $submit='';
			echo'<table width="100%" border="0" cellspacing="'.$cellspacing.'" cellpadding="0">
			<tr>
	  		<td>'.$page_link.'</td>
	   		<td align="right">'.$submit.'</td>
			</tr>
			</table></form>';

			echo'<a name="addcomment"></a>';
			if($loggedin) {
				$name = getnickname($userID);
				if(getemailhide($userID)) $email='';
        else $email = getemail($userID);
				$url = gethomepage($userID);
				$icq = geticq($userID);
				$_language->read_module('bbcode', true);

				eval ("\$addbbcode = \"".gettemplate("addbbcode")."\";");
				eval("\$profile_guestbook_loggedin = \"".gettemplate("profile_guestbook_loggedin")."\";");
				echo $profile_guestbook_loggedin;
			}
			else {
				$CAPCLASS = new Captcha;
				$captcha = $CAPCLASS->create_captcha();
				$hash = $CAPCLASS->get_hash();
				$CAPCLASS->clear_oldcaptcha();
				$_language->read_module('bbcode', true);

				eval ("\$addbbcode = \"".gettemplate("addbbcode")."\";");
				eval("\$profile_guestbook_notloggedin = \"".gettemplate("profile_guestbook_notloggedin")."\";");
				echo $profile_guestbook_notloggedin;
			}
		}

	}
	else {

		//profil: home

		eval ("\$title_profile = \"".gettemplate("title_profile")."\";");
		echo $title_profile;

		$date = time();
		$ergebnis = safe_query("SELECT * FROM ".PREFIX."user WHERE userID='".$id."'");
		$anz = mysql_num_rows($ergebnis);
		$ds = mysql_fetch_array($ergebnis);

		if($userID != $id && $userID != 0) {
			safe_query("UPDATE ".PREFIX."user SET visits=visits+1 WHERE userID='".$id."'");
			if(mysql_num_rows(safe_query("SELECT visitID FROM ".PREFIX."user_visitors WHERE userID='".$id."' AND visitor='".$userID."'")))
			safe_query("UPDATE ".PREFIX."user_visitors SET date='".$date."' WHERE userID='".$id."' AND visitor='".$userID."'");
			else safe_query("INSERT INTO ".PREFIX."user_visitors (userID, visitor, date) values ('".$id."', '".$userID."', '".$date."')");
		}
		$anzvisits = $ds['visits'];
		if($ds['userpic']) $userpic = '<img src="images/userpics/'.$ds['userpic'].'" alt="" />';
		else $userpic = '<img src="images/userpics/nouserpic.gif" alt="" />';
		$nickname = $ds['nickname'];
		$user = $ds['username'];
		$ds['xfire'];
        if ($ds['xfire'] == '') $xfire = '';
		if(isclanmember($id)) $member = ' <img src="images/icons/member.gif" alt="'.$_language->module['clanmember'].'" />';
		else $member = '';
		$registered = date("d.m.Y - H:i", $ds['registerdate']);
		$lastlogin = date("d.m.Y - H:i", $ds['lastlogin']);
		if($ds['avatar']) $avatar = '<img src="images/avatars/'.$ds['avatar'].'" alt="" />';
		else $avatar = '<img src="images/avatars/noavatar.gif" border="0" alt="" />';
		$status = isonline($ds['userID']);
		if($ds['email_hide']) $email = '';
		else $email = '<a href="mailto:'.mail_protect(cleartext($ds['email'])).'"><img src="images/cup/icons/message.png" border="0" alt="'.$_language->module['email'].'" /> Email</a>';
		$sem = '[0-9]{4,11}';
		if(eregi($sem, $ds['icq'])) $icq = '<a href="http://www.icq.com/people/about_me.php?uin='.sprintf('%d', $ds['icq']).'" target="_blank"><img src="http://online.mirabilis.com/scripts/online.dll?icq='.sprintf('%d', $ds['icq']).'&amp;img=5" border="0" alt="icq" /></a>';
		else $icq='';
		if($loggedin && $ds['userID'] != $userID) {
			$pm = '<a href="index.php?site=messenger&amp;action=touser&amp;touser='.$ds['userID'].'"><img src="images/cup/icons/pm.png" border="0" width="12" height="13" alt="messenger" /> Private Message</a>';
			if(isignored($userID, $ds['userID'])) $buddy = '<a href="buddys.php?action=readd&amp;id='.$ds['userID'].'&amp;userID='.$userID.'"><img src="images/icons/buddy_readd.gif" border="0" alt="'.$_language->module['back_buddylist'].'" /> Back to Buddy-list</a>';
			elseif(isbuddy($userID, $ds['userID'])) $buddy = '<a href="buddys.php?action=delete&id='.$ds['userID'].'&userID='.$userID.'"><img src="images/icons/buddy_delete.gif" border="0" alt="remove buddy" /> Remove Buddy</a>';
			elseif($userID == $ds['userID']) $buddy = '';
			else $buddy = '<a href="buddys.php?action=add&amp;id='.$ds['userID'].'&amp;userID='.$userID.'"><img src="images/icons/buddy_add.gif" border="0" alt="'.$_language->module['add_buddylist'].'" /> Add Buddy</a>';
		}
		else $pm = '' & $buddy = '';

		if($ds['homepage']!='') {
		
		   if(eregi('http://', $ds['homepage'])) $homepage = '<a href="'.htmlspecialchars($ds['homepage']).'" target="_blank" rel="nofollow">'.htmlspecialchars($ds['homepage']).'</a>';
	           else $homepage = '<a href="http://'.htmlspecialchars($ds['homepage']).'" target="_blank" rel="nofollow">http://'.htmlspecialchars($ds['homepage']).'</a>';
		
		   $homepage_temp = '
		   
                    <tr bgcolor="'.$bg1.'"> 
                      <td bgcolor="'.$bg1.'"><img src="images/profile/hp.gif" width="16" height="16" />Homepage:</td>
                      <td bgcolor="'.$bg2.'">'.$homepage.'</td>
                    </tr>';
		
		}
		else $homepage_temp = '';

		$clanhistory = clearfromtags($ds['clanhistory']);
		if($clanhistory == '') $clanhistory = $_language->module['n_a'];
if($ds['skype']) $skype='<a href="skype:'.$ds['skype'].'?userinfo"><img src="http://mystatus.skype.com/smallicon/'.$ds['skype'].'" style="border: none;" width="16" height="16" alt="" align="default" /></a>';
else $skype='';
if($ds['msn']) $msn='<a href="http://members.msn.com/'.$ds['msn'].'">
<img src="http://www.funnyweb.dk:8080/msn/'.$ds['msn'].'/
onurl=www.funnyweb.dk/osi/iconset3/msnonline.gif/
offurl=www.funnyweb.dk/osi/iconset3/msnoffline.gif/
unknownurl=www.funnyweb.dk/osi/iconset3/msnunknown.gif"
align="default" border="0" width="18" height="18"
alt="" /></a>';
else $msn='';
if($ds['aim']) $aim='<a href="aim:goim?screenname='.$ds['aim'].'">
<img src="http://www.funnyweb.dk:8080/aim/'.$ds['aim'].'/
onurl=www.funnyweb.dk/osi/iconset3/aimonline.gif/
offurl=www.funnyweb.dk/osi/iconset3/aimoffline.gif/
unknownurl=www.funnyweb.dk/osi/iconset3/aimunknown.gif"
align="default" border="0" width="18" height="18"
alt="" /></a>';
else $aim='';
if($ds['yahoo']) $yahoo='<a href="ymsgr:sendIM?'.$ds['yahoo'].'">
<img src="http://www.funnyweb.dk:8080/yahoo/'.$ds['yahoo'].'/
onurl=www.funnyweb.dk/osi/iconset3/yahooonline.gif/
offurl=www.funnyweb.dk/osi/iconset3/yahoooffline.gif/
unknownurl=www.funnyweb.dk/osi/iconset3/yahoounknown.gif"
align="default" border="0" width="18" height="18"
alt="" /></a>';
else $yahoo='';
		$clanname = clearfromtags($ds['clanname']);
		if($clanname == '') $clanname = '';
		if($ds['xfirec']) $xfirec='<a href="http://profile.xfire.com/'.$ds['xfire'].'"><img src="http://miniprofile.xfire.com/bg/bg/type/4/'.$ds['xfire'].'.gif" border="0" width="16" height="16" alt="Xfire" /></a>';
		else $xfirec='';
		if($ds['steam']) $steam='<a href="http://steamcommunity.com/id/'.$ds['steam'].'"><img src="images/cup/icons/steam.png" border="0" width="16" height="16" alt="Steam" /></a>';
		else $steam='';
		$clanirc = clearfromtags($ds['clanirc']);
		if($clanirc == '') $clanirc = $_language->module['n_a'];

                $clanesl = empty($ds['clanesl']) ? 'n/a' : $ds['clanesl'];

		if($ds['clanhp'] == '') $clanhp = $_language->module['n_a'];
		else {
			if(eregi('http://', $ds['clanhp'])) $clanhp = '<a href="'.htmlspecialchars($ds['clanhp']).'" target="_blank" rel="nofollow">'.htmlspecialchars($ds['clanhp']).'</a>';
			else $clanhp = '<a href="http://'.htmlspecialchars($ds['clanhp']).'" target="_blank" rel="nofollow">'.htmlspecialchars($ds['clanhp']).'</a>';
		}
		$clantag = clearfromtags($ds['clantag']);
		if($clantag == '') $clantag = '';
		else $clantag = '('.$clantag.') ';
		
//clan temp

if(($clantag !='' AND $clantag !='n/a') OR 
   ($clanname !='' AND $clanname !='n/a') OR 
   ($clanhp !='n/a' AND $clanhp !='') OR 
   ($clanirc !='n/a' AND $clanirc !='') OR 
   ($clanhistory !='n/a' AND $clanhistory !='') OR 
   ($clanesl !='n/a' AND $clanesl !='')) {

   $clan_temp = "
	<tr bgcolor='$bg1'><td height='10' colspan='3'></td></tr>
	  <tr bgcolor='$bg1'>
	  <td valign='top' width='49%'>
	  <table width='100%' cellspacing='$cellspacing' cellpadding='$cellpadding' bgcolor='$border'>
        <tr bgcolor='$bg1'> 
          <td class='title' bgcolor='$bghead' colspan='2'>&nbsp; &#8226; Clan </td>
        </tr>
        <tr bgcolor='$bg1'> 
          <td bgcolor='$pagebg' colspan='2'></td>
        </tr>";
	
    if(($clantag !='' AND $clantag !='n/a') OR ($clanname !='' AND $clanname !='n/a'))
    $clan_temp.= "
        <tr bgcolor='$bg1'> 
          <td width='150'  bgcolor='$bg1'><img src='images/profile/clan.gif' width='16' height='16' /> Clan:</td>
          <td bgcolor='$bg2'>$clantag $clanname</td>
        </tr>";
	
    if($clanhp !='n/a' AND $clanhp !='')	
    $clan_temp.= "
        <tr bgcolor='$bg1'> 
          <td bgcolor='$bg1'><img src='images/profile/hp.gif' width='16' height='16'/>Clanpage:</td>
          <td bgcolor='$bg2'>$clanhp</td>
        </tr>";
	
    if($clanirc !='n/a' AND $clanirc !='')	
    $clan_temp.= "
        <tr bgcolor='$bg1'> 
          <td bgcolor='$bg1'><img src='images/profile/mirc.gif' width='16' height='16' /> Irc-Channel:</td>
          <td bgcolor='$bg2'>$clanirc</td>
        </tr>";
	
    if($clanhistory !='n/a' AND $clanhistory !='')	
    $clan_temp.= "
        <tr bgcolor='$bg1'> 
          <td bgcolor='$bg1'><img src='images/profile/history.gif' width='16' height='16' /> Clan-History:</td>
          <td bgcolor='$bg2'>$clanhistory</td>
        </tr>";
	
    if($clanesl !='n/a' AND $clanesl !='')	
    $clan_temp.= "
        <tr bgcolor='$bg1'> 
          <td bgcolor='$bg1'><img src='images/profile/esl.gif' width='16' height='16' /> Esl-Nick:</td>
          <td bgcolor='$bg2'>$clanesl</td>
        </tr>";
	
    $clan_temp.= "
      </table>
	  <br />";
}
else{
    $clan_temp = "
	<tr bgcolor='$bg1'><td height='10' colspan='3'></td></tr>
	  <tr bgcolor='$bg1'>
	  <td valign='top' width='49%'>";
}

// Start of: Steam-Community v2.1
	if (trim($ds['sc_id']) != "") {
		$tsc_v2B = '<iframe frameborder="0" scrolling="no" style="width: 254px; height: 48px;" src="./steamprofile/sp.php?id='.$ds['sc_id'].'&html=1"></iframe>';
		
	        $steam_temp = "<tr bgcolor='$bg1'><td height='10' colspan='3'></td></tr>
	                         <tr bgcolor='$bg1'>
	                           <td colspan='3'>
                               <table width='100%' cellspacing='$cellspacing' cellpadding='$cellpadding' bgcolor='$border'>
                                 <tr bgcolor='$bg1'> 
                                  <tr>
                                   <td class='title' align='left' bgcolor='$bghead'>&nbsp; &#8226; Steam Community</td>
                                 </tr>
                                 <tr><td bgcolor='$pagebg'></td></tr>
                                  <tr>
                                   <td bgcolor='$bg1' align='left'>$tsc_v2B</td>
                                 </tr>
                               </table>
	                         </td>
	                           </tr>";
		
	} else {
		$steam_temp = "";
	}
// End of: Steam-Community v2.1

		$firstname = clearfromtags($ds['firstname']);
		$lastname = clearfromtags($ds['lastname']);
		
	    if($firstname)
		$show_name = '
        <tr bgcolor="'.$bg1.'"> 
          <td bgcolor="'.$bg3.'"><img src="images/profile/realname.gif" width="16" height="16" /> Real Name:</td>
          <td bgcolor="'.$bg4.'">'.$firstname.' '.$lastname.'</td>
        </tr>';
		
		else $show_name = '';

		$birthday = mb_substr($ds['birthday'], 0, 10);

		$res = mysql_query("SELECT birthday, DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW()) - TO_DAYS(birthday)), '%y') 'age' FROM ".PREFIX."user WHERE userID = '".$id."'");
		$cur = mysql_fetch_array($res);
		$birthday = $birthday." (".$cur['age']." ".$_language->module['years'].")";

		if(!$ds['timezone'] OR $ds['timezone']==1)
		$prof_tz = ''; else $prof_tz = $ds['timezone'];
		if($ds['sex'] == "f") $sex = $_language->module['female'];
		elseif($ds['sex'] == "m") $sex = $_language->module['male'];
		else $sex = $_language->module['unknown'];
		$flag = '[flag]'.$ds['country'].'[/flag]';
		$profilecountry = flags($flag);
		$town = clearfromtags($ds['town']);
		if($town == '') $town = '';
		$storage = clearfromtags($ds['storage']);
		if($storage == '') $storage = $_language->module['n_a'];
		$headset = clearfromtags($ds['headset']);
		if($headset == '') $headset = $_language->module['n_a'];	
		$cpu = clearfromtags($ds['cpu']);
		if($cpu == '') $cpu = $_language->module['n_a'];
		$mainboard = clearfromtags($ds['mainboard']);
		if($mainboard == '') $mainboard = $_language->module['n_a'];
		$ram = clearfromtags($ds['ram']);
		if($ram == '') $ram = $_language->module['n_a'];
		$monitor = clearfromtags($ds['monitor']);
		if($monitor == '') $monitor = $_language->module['n_a'];
		$graphiccard = clearfromtags($ds['graphiccard']);
		if($graphiccard == '') $graphiccard = $_language->module['n_a'];
		$soundcard = clearfromtags($ds['soundcard']);
		if($soundcard == '') $soundcard = $_language->module['n_a'];
		$connection = clearfromtags($ds['verbindung']);
		if($connection == '') $connection = $_language->module['n_a'];
		$keyboard = clearfromtags($ds['keyboard']);
		if($keyboard == '') $keyboard = $_language->module['n_a'];
		$mouse = clearfromtags($ds['mouse']);
		if($mouse == '') $mouse = $_language->module['n_a'];
		
		$mousepad = clearfromtags($ds['mousepad']);
		if($mousepad == '') $mousepad = $_language->module['n_a'];
		
		$storage = clearfromtags($ds['storage']);
		if($storage == '') $storage = $_language->module['n_a'];
		
		$headset = clearfromtags($ds['headset']);
		if($headset == '') $headset = $_language->module['n_a'];
		
	    $fgame=(empty($ds['fgame']) || $ds['fgame']=='n/a' ? 'n/a' : clearfromtags($ds['fgame']));
        $fclan=(empty($ds['fclan']) || $ds['fclan']=='n/a' ? 'n/a' : clearfromtags($ds['fclan']));
        $fmap=(empty($ds['fmap']) || $ds['fmap']=='n/a' ? 'n/a' : clearfromtags($ds['fmap']));
        $fweapon=(empty($ds['fweapon']) || $ds['fweapon']=='n/a' ? 'n/a' : clearfromtags($ds['fweapon']));
        $ffood=(empty($ds['ffood']) || $ds['ffood']=='n/a' ? 'n/a' : clearfromtags($ds['ffood']));
        $fdrink=(empty($ds['fdrink']) || $ds['fdrink']=='n/a' ? 'n/a' : clearfromtags($ds['fdrink']));
        $fmovie=(empty($ds['fmovie']) || $ds['fmovie']=='n/a' ? 'n/a' : clearfromtags($ds['fmovie']));
        $fmusic=(empty($ds['fmusic']) || $ds['fmusic']=='n/a' ? 'n/a' : clearfromtags($ds['fmusic']));
        $fsong=(empty($ds['fsong']) || $ds['fsong']=='n/a' ? 'n/a' : clearfromtags($ds['fsong']));
        $fbook=(empty($ds['fbook']) || $ds['fbook']=='n/a' ? 'n/a' : clearfromtags($ds['fbook']));
        $factor=(empty($ds['factor']) || $ds['factor']=='n/a' ? 'n/a' : clearfromtags($ds['factor']));
        $fcar=(empty($ds['fcar']) || $ds['fcar']=='n/a' ? 'n/a' : clearfromtags($ds['fcar']));
        $fsport=(empty($ds['fsport']) || $ds['fsport']=='n/a' ? 'n/a' : clearfromtags($ds['fsport']));
	
	
$steamid=clearfromtags($ds['steam']);
$esl_name='';
$esl_id='';
$xfire=clearfromtags($ds['xfire']);

//FAV TEMP

if($fgame !='n/a' OR $fclan !='n/a' OR $fmap !='n/a' OR $fweapon !='n/a' OR $ffood !='n/a' OR $fdrink !='n/a' OR $fmovie !='n/a' OR $fmusic !='n/a' OR $fsong !='n/a' OR $fbook !='n/a' OR $factor !='n/a' OR $fcar !='n/a' OR $fsport !='n/a') {
 
  $fav_temp = "
      <table width='100%' cellspacing='$cellspacing' cellpadding='$cellpadding' bgcolor='$border'>
        <tr bgcolor='$bg1'> 
          <td colspan='2' class='title' bgcolor='$bghead'>&nbsp; &#8226; Favorite...</td>
        </tr>
        <tr bgcolor='$bg1'> 
          <td colspan='2' bgcolor='$pagebg'></td>
        </tr>";
	
	if($fgame !='n/a')
	$fav_temp .="
        <tr bgcolor='$bg1'> 
          <td width='150'  bgcolor='$bg1'><img src='images/profile/game.gif' width='16' height='16' /> Game:</td>
          <td bgcolor='$bg2'>$fgame</td>
        </tr>";
	
	if($fclan !='n/a')
	$fav_temp .="
        <tr bgcolor='$bg1'> 
          <td bgcolor='$bg1'><img src='images/profile/clan.gif' width='16' height='16' /> Clan:</td>
          <td bgcolor='$bg2'>$fclan</td>
        </tr>";
	
	if($fmap !='n/a')
	$fav_temp .="
        <tr bgcolor='$bg1'> 
          <td bgcolor='$bg1'><img src='images/profile/map.gif' width='16' height='16' /> Map:</td>
          <td bgcolor='$bg2'>$fmap</td>
        </tr>";
	
	if($fweapon !='n/a')
	$fav_temp .="
        <tr bgcolor='$bg1'> 
          <td bgcolor='$bg1'><img src='images/profile/weapon.gif' width='16' height='16' /> Weapon:</td>
          <td bgcolor='$bg2'>$fweapon</td>
        </tr>";
	
	if($ffood !='n/a')
	$fav_temp .="
        <tr bgcolor='$bg1'> 
          <td bgcolor='$bg1'><img src='images/profile/food.gif' width='16' height='16' /> Food:</td>
          <td bgcolor='$bg2'>$ffood</td>
        </tr>";
	
	if($fdrink !='n/a')
	$fav_temp .="
        <tr bgcolor='$bg1'> 
          <td bgcolor='$bg1'><img src='images/profile/drink.gif' width='16' height='16' /> Drink:</td>
          <td bgcolor='$bg2'>$fdrink</td>
        </tr>";
	
	if($fmovie !='n/a')
	$fav_temp .="
        <tr bgcolor='$bg1'> 
          <td bgcolor='$bg1'><img src='images/profile/movie.gif' width='16' height='16' /> Movie:</td>
          <td bgcolor='$bg2'>$fmovie</td>
        </tr>";
	
	if($fmusic !='n/a')
	$fav_temp .="
        <tr bgcolor='$bg1'> 
          <td bgcolor='$bg1'><img src='images/profile/music.gif' width='16' height='16' /> Music:</td>
          <td bgcolor='$bg2'>$fmusic</td>
        </tr>";
	
	if($fsong !='n/a')
	$fav_temp .="
        <tr bgcolor='$bg1'> 
          <td bgcolor='$bg1'><img src='images/profile/song.gif' width='16' height='16' /> Song:</td>
          <td bgcolor='$bg2'>$fsong</td>
        </tr>";
	
	if($fbook !='n/a')
	$fav_temp .="
        <tr bgcolor='$bg1'> 
          <td bgcolor='$bg1'><img src='images/profile/book.gif' width='16' height='16' /> Book:</td>
          <td bgcolor='$bg2'>$fbook</td>
        </tr>";
	
	if($factor !='n/a')
	$fav_temp .="
        <tr bgcolor='$bg1'> 
          <td bgcolor='$bg1'><img src='images/profile/actor.gif' width='16' height='16' /> Actor / Actress:</td>
          <td bgcolor='$bg2'>$factor</td>
        </tr>";
	
	if($fcar !='n/a')
	$fav_temp .="
        <tr bgcolor='$bg1'> 
          <td bgcolor='$bg1'><img src='images/profile/car.gif' width='16' height='16' /> Car:</td>
          <td bgcolor='$bg2'>$fcar</td>
        </tr>";
	
	if($fsport !='n/a')
	$fav_temp .="
        <tr bgcolor='$bg1'> 
          <td bgcolor='$bg1'><img src='images/profile/sport.gif' width='16' height='16' /> Sport:</td>
          <td bgcolor='$bg2'>$fsport</td>
        </tr>";
	
	$fav_temp .="</table>
	           <br>";
}
else{
	$fav_temp = "";
}

//EQUIP TEMP

if(($cpu !='n/a' AND $cpu !='') OR 
   ($storage !='n/a' AND $storage !='') OR 
   ($headset !='n/a' AND $headset !='') OR 
   ($mainboard !='n/a' AND $mainboard !='') OR 
   ($ram !='n/a' AND $ram !='') OR
   ($monitor !='n/a' AND $monitor !='') OR 
   ($graphiccard !='n/a' AND $graphiccard !='') OR 
   ($soundcard !='n/a' AND $soundcard !='') OR 
   ($storage !='n/a' AND $storage !='') OR 
   ($connection !='n/a' AND $connection !='') OR 
   ($headset !='n/a' AND $headset !='') OR 
   ($keyboard !='n/a' AND $keyboard !='') OR 
   ($mouse !='n/a' AND $mouse !='') OR 
   ($mousepad !='n/a' AND $mousepad !='')) {
   
   $equip_temp = "
      <table width='100%' cellspacing='$cellspacing' cellpadding='$cellpadding' bgcolor='$border'>
        <tr bgcolor='$bg1'> 
          <td colspan='2' class='title' bgcolor='$bghead'>&nbsp; &#8226; Equipment</td>
        </tr>
        <tr bgcolor='$bg1'> 
          <td colspan='2' bgcolor='$pagebg'></td>
        </tr>";
	
	if($cpu !='n/a' && $cpu !='')
	$equip_temp.= "
        <tr bgcolor='$bg1'> 
          <td width='150'  bgcolor='$bg1'><img src='images/profile/cpu.gif' width='16' height='16' /> CPU:</td>
          <td bgcolor='$bg2'>$cpu</td>
        </tr>";
	
	if($mainboard !='n/a' && $mainboard !='')
	$equip_temp.= "
        <tr bgcolor='$bg1'> 
          <td bgcolor='$bg1'><img src='images/profile/mainboard.gif' width='16' height='16' /> Mainboard:</td>
          <td bgcolor='$bg2'>$mainboard</td>
        </tr>";
	
	if($ram !='n/a' && $ram !='')
	$equip_temp.= "
        <tr bgcolor='$bg1'> 
          <td bgcolor='$bg1'><img src='images/profile/ram.gif' width='16' height='16' /> RAM:</td>
          <td bgcolor='$bg2'>$ram</td>
        </tr>";
	
	if($monitor !='n/a' && $monitor !='')
	$equip_temp.= "
        <tr bgcolor='$bg1'> 
          <td bgcolor='$bg1'><img src='images/profile/monitor.gif' width='16' height='16' /> Monitor:</td>
          <td bgcolor='$bg2'>$monitor</td>
        </tr>";
	
	if($graphiccard !='n/a' && $graphiccard !='')
	$equip_temp.= "
        <tr bgcolor='$bg1'> 
          <td bgcolor='$bg1'><img src='images/profile/graphic.gif' width='16' height='16' /> Graphiccard:</td>
          <td bgcolor='$bg2'>$graphiccard</td>
        </tr>";
	
	if($soundcard !='n/a' && $soundcard !='')
	$equip_temp.= "
        <tr bgcolor='$bg1'> 
          <td bgcolor='$bg1'><img src='images/profile/sound.gif' width='16' height='16' /> Soundcard:</td>
          <td bgcolor='$bg2'>$soundcard</td>
        </tr>";
	
	if($storage !='n/a' && $storage !='')
	$equip_temp.= "
        <tr bgcolor='$bg1'> 
          <td bgcolor='$bg1'><img src='images/profile/storage.gif' width='16' height='16' /> Storage:</td>
          <td bgcolor='$bg2'>$storage</td>
        </tr>";
	
	if($connection !='n/a' && $connection !='')
	$equip_temp.= "
        <tr bgcolor='$bg1'> 
          <td bgcolor='$bg1'><img src='images/profile/inet.gif' width='16' height='16' /> I-Connection:</td>
          <td bgcolor='$bg2'>$connection</td>
        </tr>";
	
	if($headset !='n/a' && $headset !='')
	$equip_temp.= "
        <tr bgcolor='$bg1'> 
          <td bgcolor='$bg1'><img src='images/profile/headset.gif' width='16' height='16' /> Headset:</td>
          <td bgcolor='$bg2'>$headset</td>
        </tr>";
	
	if($keyboard !='n/a' && $keyboard !='')
	$equip_temp.= "
        <tr bgcolor='$bg1'> 
          <td bgcolor='$bg1'><img src='images/profile/keyboard.gif' width='16' height='16' /> Keyboard:</td>
          <td bgcolor='$bg2'>$keyboard</td>
        </tr>";
	
	if($mouse !='n/a' && $mouse !='')
	$equip_temp.= "
        <tr bgcolor='$bg1'> 
          <td bgcolor='$bg1'><img src='images/profile/mouse.gif' width='16' height='16' /> Mouse:</td>
          <td bgcolor='$bg2'>$mouse</td>
        </tr>";
	
	if($mousepad !='n/a' && $mousepad !='')
	$equip_temp.= "
        <tr bgcolor='$bg1'> 
          <td bgcolor='$bg1'><img src='images/profile/mousepad.gif' width='16' height='16' /> Mousepad:</td>
          <td bgcolor='$bg2'>$mousepad</td>
        </tr>";
	
	$equip_temp.= "
      </table>
	  <br />";
	  
}
else{
	$equip_temp = "";
}

//EQUIP TEMP

if($xfire != ''){

$xfire = '<a href=http://profile.xfire.com/'.$ds['xfire'].'><img src=http://miniprofile.xfire.com/bg/'.$ds[xfirestyle].'/type/'.$ds[xfiregroesse].'/'.$ds['xfire'].'.png border="0"></a>';
$add = 'Xfire (<a href="xfire:add_friend?user='.$ds['xfire'].'"><img src="images/cup/icons/addresult.gif" width="16" height="16"> Add User</a>)';
   
   $xfire_temp = "
	<tr bgcolor='$bg1'><td height='10' colspan='3'></td></tr>
	  <tr bgcolor='$bg1'>
	  <td colspan='3'>
	  <table width='100%' cellspacing='$cellspacing' cellpadding='$cellpadding' bgcolor='$border'>
        <tr bgcolor='$bg1'> 
          <td class='title' bgcolor='$bghead'>&nbsp; &#8226; $add</td>
        </tr>
        <tr bgcolor='$bg1'> 
          <td bgcolor='$pagebg'></td>
        </tr>
        <tr bgcolor='$bg1'> 
          <td bgcolor='$bg1'>$xfire</td>
        </tr>
      </table>
	  </td>
	  </tr>";
}
else{
   $xfire_temp = '';
}

if($steamid == '' AND !($esl_id == '') AND !($esl_name == '')){
$player = '<a href="http://www.esl-europe.de/de/player/'.$esl_id.'" target="_blank">'.$esl_name.'</a>'; 
} else {
$player = 'n/a';
}
if($esl_id != '' AND $steamid != ''){
$player = '<a href="http://www.esl-europe.de/de/player/'.$esl_id.'" target="_blank">'.$steamid.'';
}


		$anznewsposts = getusernewsposts($ds['userID']);
		$anzforumtopics = getuserforumtopics($ds['userID']);
		$anzforumposts = getuserforumposts($ds['userID']);
		$comments[] = getusercomments($ds['userID'], 'ne');
		$comments[] = getusercomments($ds['userID'], 'cw');
		$comments[] = getusercomments($ds['userID'], 'ar');
		$comments[] = getusercomments($ds['userID'], 'de');

		$pmgot = 0;
		$pmgot = $ds['pmgot'];

		$pmsent = 0;
		$pmsent = $ds['pmsent'];

		if($ds['about']) {
		
		  $about = cleartext($ds['about']);
		
		   $about_temp = '<tr bgcolor="'.$bg1.'"><td height="10" colspan="3"></td></tr>
	                            <tr bgcolor="'.$bg1.'">
	                              <td colspan="3">
                                  
				  <table width="100%" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'" bgcolor="'.$border.'">
                                    <tr bgcolor="'.$bg1.'"> 
                                      <td class="title" bgcolor="'.$bghead.'">&nbsp; &#8226; About</td>
                                    </tr>
                                     <tr bgcolor="'.$bg1.'"> 
                                      <td bgcolor="'.$pagebg.'"></td>
                                    </tr>
                                     <tr bgcolor="'.$bg1.'"> 
                                      <td bgcolor="'.$bg1.'">'.$about.'</td>
                                    </tr>
				  </table>
	                         </td>
	                        </tr>';
		}
                else $about_temp = '';		

		if(isforumadmin($ds['userID'])) {
			$usertype = $_language->module['administrator'];
			$rang = '<img src="images/icons/ranks/admin.gif" alt="" />';
		}
		elseif(isanymoderator($ds['userID'])) {
			$usertype = $_language->module['moderator'];
			$rang = '<img src="images/icons/ranks/moderator.gif" alt="" />';
		}
		else {
			$posts = getuserforumposts($ds['userID']);
			$ergebnis = safe_query("SELECT * FROM ".PREFIX."forum_ranks WHERE ".$posts." >= postmin AND ".$posts." <= postmax");
			$ds = mysql_fetch_array($ergebnis);
			$usertype = $ds['rank'];
			$rang = '<img src="images/icons/ranks/'.$ds['pic'].'" alt="" />';
		}
		
		if(isset($_GET['gameacc']) && $_GET['gameacc'] == 'changelog'){
		
		   $gameacc_tit = "Gameaccounts History";
		
		   $gamelog = '

			 <tr>
			  <td align="center" width="50%" bgcolor="'.$bg2.'" colspan="2"><strong>Type</strong></td>
		          <td align="center" width="50%" bgcolor="'.$bg2.'" colspan="9"><strong>Old Value</strong></td>
		         </tr>'; 
		    
		}else{

		   $gameacc_tit = "Gameaccounts";
		
		}
		
		$gameacclog = safe_query("SELECT * FROM ".PREFIX."user_gameacc WHERE userID='$id' && log='1' ORDER BY type");
		while($dl=mysql_fetch_array($gameacclog)) {
		
		if(mysql_num_rows($gameacclog) && $_GET['gameacc']!='changelog') {
		
		    if($userID==$id) { 
		          $userhas = 'You have'; 
		          $noaccounts = '(<a href="?site=myprofile&action=gameaccounts">Add Gameaccount?</a>)';
		    }
		    else{ 		
		          $userhas = 'This user has'; 
			  $noaccounts = '';
		    }	
		          
	          $ingamelog = '<img src="images/cup/icons/warning.png" width="16" height="16"> '.$userhas.' previous entered gameaccounts of the same type. Click <a href="?site=profile&id='.$id.'&gameacc=changelog#seegameaccounts">here</a> to view.'; 	
		}
		
		$getvalue=safe_query("SELECT type FROM ".PREFIX."gameacc WHERE gameaccID='".$dl[type]."'");
	        $dp = mysql_fetch_array($getvalue);
		
		if(isset($_GET['gameacc']) && $_GET['gameacc']=='changelog'){
		
		   $gamelog.='<tr>
                                <td align="center" bgcolor="'.BG_1.'" colspan="2">'.$dp['type'].'</td>
                                <td align="center" bgcolor="'.BG_1.'" colspan="9">'.$dl['value'].'</td>
                              </tr>';                     
		  }
		}
		
		if(isset($_GET['gameacc']) && $_GET['gameacc']=='changelog') { 
		        $gamelog.='<tr><td class="title" colspan="12">&nbsp; &#8226; Current Gameaccounts</td></tr>';
	        }
		
		if($userID==$id || issuperadmin($userID) || iscupadmin($userID)) { 
		        $usergameacchead = '<td align="center" bgcolor="'.$bg2.'" colspan="2"><strong>Edit</strong></td>';  
		        $deletegacchead = '<td align="center" bgcolor="'.$bg2.'" colspan="2"><strong>Delete</strong></td>'; 
		}

		$game1=safe_query("SELECT * FROM ".PREFIX."user_gameacc WHERE userID='$id' && log='0' ORDER BY type");
		$cs = ($userID==$id ? 2 : 5);
						
if(mysql_num_rows($game1)) {

      $game4 = '<tr>
		  <td class="title" colspan="12">&nbsp; &#8226; '.$gameacc_tit.' '.$addgacc.'</td>
		</tr>
		<tr>
		  <td bgcolor="'.$pagebg.'" colspan="12"><a name="seegameaccounts"></a>'.$ingamelog.' </td>
		</tr>
		'.$gamelog.'
		 <tr>
		  <td align="center" width="50%" bgcolor="'.$bg2.'" colspan="2"><strong>Type</strong></td>
		  <td align="center" width="50%" bgcolor="'.$bg2.'" colspan="'.$cs.'"><strong>Current Value</strong></td>
		  '.$usergameacchead.'
		  '.$deletegacchead.'
		</tr> 
		  <tr>
		    <td colspan="12" bgcolor="'.$pagebg.'"></td>
		</tr>';

    $n=1;
	while($db=mysql_fetch_array($game1)) {
	
		$game3=safe_query("SELECT type FROM ".PREFIX."gameacc WHERE gameaccID='".$db[type]."'");
	    $dp = mysql_fetch_array($game3);
	 
		$n%2 ? $bgcolor=BG_1 : $bgcolor=BG_2;
		
      if($userID==$id || issuperadmin($userID) || iscupadmin($userID)) {
        $usergameacccont = '<td align="center" bgcolor="'.BG_1.'" colspan="2"><a href="?site=profile&id='.$id.'&action=gameaccounts&edit=account&gameaccID='.$db['gameaccID'].'&type='.$dp['type'].'#editgacc"><img border="0" src="images/cup/icons/edit.png"></a></td>'; 
        $deletegacchead  = '<td align="center" bgcolor="'.BG_1.'" colspan="2" ><a href="?site=myprofile&delete=gameaccount&type='.$db['gameaccID'].'&id='.$id.'" onclick="return confirm(\'This action will insert your '.$dp['type'].' gameaccount in your log \');"><img border="0" src="images/cup/error.png" width="16" height="16"></a>'; }
	 
		$game4.='<tr>
		           <td align="center" bgcolor="'.BG_1.'" colspan="2">'.$dp[type].'</td>
		           <td align="center" bgcolor="'.BG_1.'" colspan="'.$cs.'">'.$db[value].'</td>
		           '.$usergameacccont.'
		           '.$deletegacchead.'
		         </tr>';
		$n++;
	}$game4.='';
} 
else $game4='';
                 
		$lastvisits="";
		$visitors = safe_query("SELECT * FROM ".PREFIX."user_visitors WHERE userID='".$id."' ORDER BY date DESC LIMIT 0,10");
		if(mysql_num_rows($visitors)) {
			$n = 1;
			while($dv = mysql_fetch_array($visitors)) {
				$n % 2 ? $bgcolor = BG_1 : $bgcolor = BG_2;
				$flag = '[flag]'.getcountry($dv['visitor']).'[/flag]';
				$country = flags($flag);
				$nicknamevisitor = getnickname($dv['visitor']);
				if(isonline($dv['visitor']) == "offline") $statuspic = '<img src="images/icons/offline.gif" alt="'.$_language->module['offline'].'" />';
				else $statuspic = '<img src="images/icons/online.gif" alt="'.$_language->module['online'].'" />';
				$time = time();
				$visittime = $dv['date'];

				$sec = $time - $visittime;
				$days = $sec / 86400;								// sekunden / (60*60*24)
				$days = mb_substr($days, 0, mb_strpos($days, "."));		// kommastelle

				$sec = $sec - $days * 86400;
				$hours = $sec / 3600;
				$hours = mb_substr($hours, 0, mb_strpos($hours, "."));

				$sec = $sec - $hours * 3600;
				$minutes = $sec / 60;
				$minutes = mb_substr($minutes, 0, mb_strpos($minutes, "."));

				if($time - $visittime < 60) {
					$now = $_language->module['now'];
					$days = "";
					$hours = "";
					$minutes = "";
				}
				else {
					$now = '';
					$days == 0 ? $days = "" : $days = $days.'d';
					$hours == 0 ? $hours = "" : $hours = $hours.'h';
					$minutes == 0 ? $minutes = "" : $minutes = $minutes.'m';
				}

				$lastvisits .= '<tr bgcolor="'.$bgcolor.'">
          <td>
          <table width="100%" cellpadding="'.$cellpadding.'" cellspacing="'.$cellspacing.'">
            <tr>
              <td>'.$country.' <a href="index.php?site=profile&amp;id='.$dv['visitor'].'"><b>'.$nicknamevisitor.'</b></a></td>
              <td align="right"><small>'.$now.$days.$hours.$minutes.' '.$statuspic.'</small></td>
            </tr>
          </table>
          </td>
        </tr>';
        
				$n++;
			}
		}
		else $lastvisits = '<tr>
      <td colspan="3" bgcolor="'.BG_1.'">'.$_language->module['no_visits'].'</td>
    </tr>';
	 
		$bg1 = BG_1;
		$bg2 = BG_2;
		$bg3 = BG_3;
		$bg4 = BG_4;
		

	if($xfire != 'n/a'){
$show_xfire = '<tr>
          <td bgcolor="'.$bg1.'">MSN:</td>
          <td bgcolor="'.$bg2.'">'.$xfire.'</td>
        </tr>';
	}else{
	$xfire ='';
	}

        $user_skill = ratio_level($id,1);
	
	if($game4 || $profile_teams || $all_cups || $userpoints) {
	      $show_tb_st = '<table width="100%" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'" bgcolor="'.$border.'"><a name="seegameaccounts"></a>';
	      $show_tb_ed = '</table>';
	}
	else{
	      $show_tb_st = '';
	      $show_tb_ed = '</table>';
	}
	
	if($all_cups!='' || $totaltotalusermatches!='0')

	$cup_stats_show = '<table width="100%" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'" bgcolor="'.$border.'">
                             <tr bgcolor="'.$bg1.'"><a name="stats"></a>
                               <td colspan="2" class="title">&nbsp; &#8226; Cup Statistics '.$for.' '.$league_name.' <a href="#cs" name="cs" class="show_hide_cs"><img src="images/cup/icons/arrow_up_down.gif" align="right"></a></td>
                             </tr>
                           </table>';
						   
	if($sex)
    $show_gender = '
        <tr bgcolor="'.$bg1.'"> 
          <td width="150" bgcolor="'.$bg1.'"><img src="images/profile/gender.png" width="16" height="16" /> Gender:</td>
          <td bgcolor="'.$bg2.'">'.$sex.'</td>
        </tr>';	
		
	if(!isset($usergallery))
	$usergallery = '';
	
	if(!isset($editgacc))
	$editgacc = '';
	
		eval("\$profile = \"".gettemplate("profile")."\";");
		echo $profile;
	}

}
else redirect('index.php', $_language->module['user_doesnt_exist'],3);
?>