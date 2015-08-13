<style>
.tooltip1 {
  position: absolute;
  display: none;
  background-color: #FCFCFC;
  color: #000000;
  border: 1px solid #DDDDDD;
  border-left: 4px solid #0E8AEA;
  padding: 4px 10px;
  z-index: 300;
  width: 300px;
}
</style>

<?php include ("../config.php"); ?>

<div class="tooltip1" id="name" align="left">Name this tournament?</div>
<div class="tooltip1" id="game" align="left">This cup will be assigned to what game?</div>
<div class="tooltip1" id="desc" align="left">Add a description, rules are added separately after created.</div>
<div class="tooltip1" id="1on1" align="left">If singles, tick the box. If unticked, users must create their own team. (index.php?site=clans&action=clanadd)</div>
<div class="tooltip1" id="clan" align="left">Only clan members can enter the cup if ticked. Clan members are assigned at (admincenter.php?site=users)</div>
<div class="tooltip1" id="gamb" align="left">Require the participant to have the associated gameaccount prior to entering the cup? (gameaccount selection below)</div>
<div class="tooltip1" id="gamc" align="left">Require the participant to have the associated gameaccount prior to checkin? (gameaccount selection below)</div>
<div class="tooltip1" id="type" align="left">(Only for team cups) What is the size? Type only in this format e.g. 4on4.</div>
<div class="tooltip1" id="rati" align="left"><li>If for example first box is 75% and second box is 100%, only participants with this score ratio or in between can enter. <br><br><li>Ratio is determined by win points divided by total points.</div>
<div class="tooltip1" id="cupt" align="left">(Only for team-cups) If for example you enter in "2" and it is a 5on5 cup, only 3 (5-2) members is required to be in the team prior to entering the cup. If entered "0" and it is a 4on4 cup then the team requires at least 4 members prior to entering the cup.</div>
<div class="tooltip1" id="line" align="left">(Only for team-cups and if "Automatic Checkin" is not selected above)<br><br> If for example you enter in "3" and it is a 4on4 cup, only 1 (4-3) member is required to be in the team lineup prior to checkin. If entered "0" and it is a 4on4 cup then the team requires 4 members in the team lineup prior to checkin.</div>
<div class="tooltip1" id="maxs" align="left">What will be the size of the tournament-tree bracket? Double elimination will drop the loser into the lower-bracket, 2 defeats is knockout. Single-elimination has no lower-bracket, loosing first match is an immediate knockout.</div>
<div class="tooltip1" id="star" align="left">When will the cup start? <br><br><li> To enable Signups, Signup phase must be selected below and the Start/End times must be in the future, passed the current time. <br><br><li>When the current time meets/exceeds the Start time, Signups are no longer accepted and the cup starts.</div>
<div class="tooltip1" id="endi" align="left">When will the tournament end? <br><br><li> The end time automatically adjusts as soon as there are all 3 winners.</div>
<div class="tooltip1" id="chec" align="left">If for example entered "30", participants can only checkin 30 minutes prior to the start time. Checkin guarantees a spot in the cup. <br><br>Entering a cup is before checkin, participants can leave but not after they are checked-in. Infinite amount of signups can register prior to the start of the cup, however only the first 32 (if 32 bracket) to checkin are guaranteed to compete. </div>
<div class="tooltip1" id="stat" align="left">Note: The status will automatically adjust according to the start and end times. <br><br><li>The status will automatically be set to "Started" if the current time meets or exceeds the Start time.<br><br><li>The status will automatically be set to "Closed" if the current time meets or exceeds the End time.<br><br><li>Signup phase can only be set if the Start and End times are in the future, passed the current time. </div>
<div class="tooltip1" id="time" align="left">Individual cups have their own timezone, if non is selected it will choose the default from cupsettings. </div>
<div class="tooltip1" id="gacc" align="left">If Gameaccount validation is enabled above, what gameaccount is required to be added prior to registration?</div>
<div class="tooltip1" id="gsst" align="left">When will the group league start? <br><br><li> To set on Signups, Signup phase must be selected (above) and the Start time must be in the future, passed the current time.</div>
<div class="tooltip1" id="gsen" align="left">When will the group league end? <br><br><li> The end time and start time of the tournament automatically adjusts as soon as all matches are confirmed.</div>
<div class="tooltip1" id="mrou" align="left"><li>If team 1 score + team 2 score does not equal maxrounds, the match report cannot be accepted. <br><br><li>If set to 15 for example, team A with score 9 must mean team B has score 6.</div>
<div class="tooltip1" id="mwee" align="left">Participant will play 3 matches if on All vs. All. Each match separated by how many days?</div>
<div class="tooltip1" id="qual" align="left"><LI><b>Qualify by XP - Single Match</b><br> One match per participant, participants with most points go through.<br><br><LI><b>Qualify by XP - All. vs All</b><br> Every participant against every other participant in the group. Get most points from matches to go through.</div>
<div class="tooltip1" id="dexp" align="left"><LI><b>Win/Loss XP</b><br>All points gained from matches<br><br><LI><b>Win XP Only</b><br>Points gained from won-matches only</div>
<div class="tooltip1" id="rtyp" align="left"><LI><B>Randomized Group Registration</b><BR> At registration, enforce group. <br><br><li><b>Pick Group Registration</b><br>Users can pick what group to register in.</div>
<div class="tooltip1" id="afin" align="left"><LI><b>Open cup registration after group stages finish</b><br>After all group matches are confirmed, set cup start time to <b>+<?php echo $league_begin; ?></b> day(s) ahead, group stage end to now and cup end to <b>+<?php echo $league_end; ?></b> day(s) ahead. (change at config.php) <br><br><li><b>Change according to set start and end times</b> The start and end times won't be changed. <br><br><LI><b>Automatically move qualifiers</b> This option is currently set to <?php if($insert_qualifiers) echo '<b>enabled</b>'; else echo '<b>disabled</b>'; ?>. To <?php if(!$insert_qualifiers) echo 'enabled'; else echo 'disabled'; ?> change $insert_qualifiers at config.php</div>
<div class="tooltip1" id="1pri" align="left">If 1st prize, first prize to 1st winner?</div>
<div class="tooltip1" id="2pri" align="left">If 2nd prize, second prize to 2nd winner?</div>
<div class="tooltip1" id="3pri" align="left">If 3rd prize, third prize to 3rd winner?</div>
<div class="tooltip1" id="gs" align="left"><li>Group stages can be considered as a "pre-league" for a tournament or ladder, if you have for example a 32 size league, by activating group stages, 64 participants will be able to register and 32 out of the 64 competitors will qualify in the tournament or ladder. <br><br><li> Group stages can allow participants to select their own group or you can enforce randomized group registration. <br><br><li>Participants can qualify by going against a single participant or you can select "All vs. All" which will enforce participants to go against every other participant in their group. <br><br><li>After all matches are finished, all participants will receive a LEN "League Eligibility Notification" to confirm their qualifying status. On the groups page, it will also show their status which can be "Qualified", "Unqualified" or FCFS "First-Come-First-Serve". <br><br><li>Qualified are those that earned enough points or won enough matches to pass, unqualified are those that do not and FCFS are those participants that have "JUST" earned enough points or won enough matches, however their points or won matches are equal which means the first to join of the FCFS participants will secure their position in the tournament or ladder. FCFS participants can only join after all qualifiers have joined.</div>
<div class="tooltip1" id="discheck" align="left">If unselected, participants are required to register AND checkin prior to start. If selected, participants are automatically checked instantly after registration.<br><br><li> If selected, all unchecked participants will be checked only in Sign-up phase.<br><br><li> If selected, teams checked are then redirected to their lineup which means it is not enforced. To enforce, unselect this option so the team must select their lineup prior to checkin. <br><br><li>If selected, the team can alter their lineup anytime prior to start time or anytime prior to checkin if unselected.</div>
<div class="tooltip1" id="agents" align="left">Free agents add themselves and teams are able to recruit them to this league.</div>
<div class="tooltip1" id="platform" align="left">Assign this tournament to what platform?</div>

<?php
//configuration
include ("../config.php");

//automated functions

randomize_brackets($_GET['ID']);
tournament_winners($_GET['ID']);
shrink_tree($_GET['ID']);
auto_wildcard();
getcuptimezone();
match_query_type();

//cup addon status

if(!iscupadmin($userID) OR substr(basename($_SERVER[REQUEST_URI]),0,15) != "admincenter.php") die('Access denied.');

if($_POST['save']) { 
	$s_day = $_POST['s_day'];
	$s_month = $_POST['s_month'];
	$s_year = $_POST['s_year'];
	$s_hour = $_POST['s_hour'];
	$s_min = $_POST['s_min'];
	$start = @mktime($s_hour, $s_min, 0, $s_month, $s_day, $s_year);
	$e_day = $_POST['e_day'];
	$e_month = $_POST['e_month'];
	$e_year = $_POST['e_year'];
	$e_hour = $_POST['e_hour'];
	$e_min = $_POST['e_min'];
	$ende = @mktime($e_hour, $e_min, 0, $e_month, $e_day, $e_year);
	$typ=($_POST['onecup'] ? '1on1' : $_POST['typ']);
	
	$gs_s_day = $_POST['gs_s_day'];
	$gs_s_month = $_POST['gs_s_month'];
	$gs_s_year = $_POST['gs_s_year'];
	$gs_s_hour = $_POST['gs_s_hour'];
	$gs_s_min = $_POST['gs_s_min'];
	$gs_start = @mktime($gs_s_hour, $gs_s_min, 0, $gs_s_month, $gs_s_day, $gs_s_year);
	$gs_e_day = $_POST['gs_e_day'];
	$gs_e_month = $_POST['gs_e_month'];
	$gs_e_year = $_POST['gs_e_year'];
	$gs_e_hour = $_POST['gs_e_hour'];
	$gs_e_min = $_POST['gs_e_min'];
	$gs_end = @mktime($gs_e_hour, $gs_e_min, 0, $gs_e_month, $gs_e_day, $gs_e_year);

	
	if(!$_POST['platID']) 
	       $error[] = 'You have not selected a platform. <br> You can manage platforms <a href="admincenter.php?site=platforms" target="_blank">here</a>.';
	
	if(!$_POST['name'])
	       $error[]='You have not entered a name';
		   
	if(!$typ)
	       $error[]='You have not entered size Type';
		   
	if(!$start)
	       $error[]='You have not entered a start time.';
	
	if($_POST['gs_maxrounds'] && !is_odd($_POST['gs_maxrounds'])) 
	       $error[]='Maxrounds must be an odd number so that draws are not supported.';
    
	if($_POST['ratio_low'] > $_POST['ratio_high']) 
	       $error[]='Score ratio low can not be greater than score ratio high.';	   
    
	if(($gs_start) && $start <= $gs_start) 
	       $error[]='Group stage must start before tournament, set tournament start ahead of group-stage start or input zeros for group stage start and end to disable';	   
    
	if(($gs_end) && $start < $gs_end) 
	       $error[]='Group stage must end before tournament starts, set tournament start ahead of group-stage end or input zeros for group stage start and end to disable';
	
	//if($_POST['gs_trans']==1 && $gs_end) 
	//       $error[]='You have set "Open cup registration after group stages finish" which means there can be no group end time, leave this blank.';
	
  	if(count($error)) { 
    	$list = implode('<br />&#8226; ', $error);
    	echo '<div class="errorbox">
      	<b>Errors Occured:</b><br /><br />
      	&#8226; '.$list.'
    	</div>';

	}
	else {

	safe_query("INSERT INTO ".PREFIX."cups ( `name`, `platID`, `game`, `desc`, `typ`, maxclan, start, ende, gs_start, gs_end, gs_maxrounds, gs_staging, gs_regtype, gs_trans, gs_mwe, status, gameaccID, 1on1, checkin, clanmembers, cupgalimit, cupaclimit, gameacclimit, cgameacclimit, ratio_low, ratio_high, gs_dxp, timezone, discheck, agents) values 
	                                       ('".$_POST['name']."', 
										   '".$_POST['platID']."', 
	                                        '".$_POST['game']."', 
	                                        '".$_POST['desc']."', 
	                                        '".$typ."', 
	                                        '".$_POST['maxclan']."', 
	                                        '".$start."', '".$ende."',
	                                        '".$gs_start."', '".$gs_end."',
	                                        '".$_POST['gs_maxrounds']."',
	                                        '".$_POST['gs_staging']."',
	                                        '".$_POST['gs_regtype']."',
	                                        '".$_POST['gs_trans']."',
											'".$_POST['gs_mwe']."',
	                                        '".$_POST['status']."', 
	                                        '".$_POST['gameacc']."', 
	                                        '".$_POST['onecup']."', 
	                                        '".$_POST['checkin']."', 
	                                        '".$_POST['clanmembers']."', 
	                                        '".$_POST['cupgalimit']."', 
	                                        '".$_POST['cupaclimit']."', 
	                                        '".$_POST['gameacclimit']."', 
	                                        '".$_POST['cgameacclimit']."', 
	                                        '".$_POST['ratio_low']."', 
	                                        '".$_POST['ratio_high']."',
	                                        '".$_POST['gs_dxp']."',
						                    '".$_POST['timezone']."',
											'".$_POST['discheck']."',
											'".$_POST['agents']."')");
    $cupID=mysql_insert_id();
	
	safe_query("INSERT INTO ".PREFIX."cup_baum 
					SET
						map1='".$_POST['map1']."',
						map2='".$_POST['map2']."',
						map3='".$_POST['map3']."',
						map4='".$_POST['map4']."',
						map5='".$_POST['map5']."',
						map6='".$_POST['map6']."',
						map7='".$_POST['map7']."',
						map8='".$_POST['map8']."',
						map9='".$_POST['map9']."',
						map10='".$_POST['map10']."',
						map11='".$_POST['map11']."',
						map12='".$_POST['map12']."',
						map13='".$_POST['map13']."',
						map14='".$_POST['map14']."',
						map15='".$_POST['map15']."',
						map16='".$_POST['map16']."',
						map17='".$_POST['map17']."',
						borderbg='$borderbg1',
						bg1='$background1',
						bg2='$background2',
						cupID='".$cupID."'");
	safe_query("INSERT INTO ".PREFIX."cup_rules SET value='', lastedit='', cupID='".$cupID."'");
	redirect("admincenter.php?site=cups","<center><b>Tournament successfully created!</b></center>",2);
   }
}elseif($_POST['saveadmins']) {
	$cupID = $_POST['cupID'];
	$admins = $_POST['admins'];
	
    safe_query("DELETE FROM ".PREFIX."cup_admins WHERE cupID='$cupID'");
	if(is_array($admins)) {
		foreach($admins as $id) {
	        safe_query("INSERT INTO ".PREFIX."cup_admins (cupID, userID) values ('$cupID', '$id') ");
	    }
	}
}elseif($_POST['saverules']) {
	safe_query("UPDATE ".PREFIX."cup_rules SET value='".$_POST['value']."', lastedit='".time()."' WHERE cupID='".$_POST['cupID']."'");
}elseif($_POST['saveedit']) {
	$s_day = $_POST['s_day'];
	$s_month = $_POST['s_month'];
	$s_year = $_POST['s_year'];
	$s_hour = $_POST['s_hour'];
	$s_min = $_POST['s_min'];
    $start = mktime($s_hour, $s_min, 0, $s_month, $s_day, $s_year);
	$e_day = $_POST['e_day'];
	$e_month = $_POST['e_month'];
	$e_year = $_POST['e_year'];
	$e_hour = $_POST['e_hour'];
	$e_min = $_POST['e_min'];
	$ende = mktime($e_hour, $e_min, 0, $e_month, $e_day, $e_year);
	$typ=($_POST['onecup'] ? '1on1' : $_POST['typ']);
	
	$gs_s_day = $_POST['gs_s_day'];
	$gs_s_month = $_POST['gs_s_month'];
	$gs_s_year = $_POST['gs_s_year'];
	$gs_s_hour = $_POST['gs_s_hour'];
	$gs_s_min = $_POST['gs_s_min'];
	$gs_start = @mktime($gs_s_hour, $gs_s_min, 0, $gs_s_month, $gs_s_day, $gs_s_year);
	
	$gs_e_day = $_POST['gs_e_day'];
	$gs_e_month = $_POST['gs_e_month'];
	$gs_e_year = $_POST['gs_e_year'];
	$gs_e_hour = $_POST['gs_e_hour'];
	$gs_e_min = $_POST['gs_e_min'];
	$gs_end = @mktime($gs_e_hour, $gs_e_min, 0, $gs_e_month, $gs_e_day, $gs_e_year);
	
	if(($gs_start) && $start <= $gs_start) 
	       $error[]='Group stage must start before tournament, set tournament start ahead of group-stage start or input zeros for group stage start and end to disable';	   
    
	if(($gs_end) && $start < $gs_end) 
	       $error[]='Group stage must end before tournament starts, set tournament start ahead of group-stage end or input zeros for group stage start and end to disable';
	
	//if($_POST['gs_trans']==1 && $gs_end) 
	//       $error[]='You have set "Open cup registration after group stages finish" which means there can be no group end time, leave this blank.';

	if(!$_POST['platID']) 
	       $error[] = 'You have not selected a platform. <br> You can manage platforms <a href="admincenter.php?site=platforms" target="_blank">here</a>.';
	
	if($_POST['gs_maxrounds'] && !is_odd($_POST['gs_maxrounds'])) 
	       $error[]='Maxrounds must be an odd number so that draws are not supported.';
    
	if($_POST['ratio_low'] > $_POST['ratio_high']) 
           $error[]='Score ratio low can not be greater than score ratio high.';
	
  	if(count($error)) { 
    	$list = implode('<br />&#8226; ', $error);
    	echo '<div class="errorbox">
      	<b>Errors Occured:</b><br /><br />
      	&#8226; '.$list.'
    	</div>';
	}
	else {
	
	safe_query("UPDATE ".PREFIX."cups SET `name`='".$_POST['name']."', 
	                                      `platID`='".$_POST['platID']."',
	                                      `game`='".$_POST['game']."', 
	                                      `desc`='".$_POST['desc']."', 
	                                      `typ`='".$typ."', 
	                                       maxclan='".$_POST['maxclan']."', 
	                                       start='".$start."', ende='".$ende."', 
	                                       gs_start='".$gs_start."', gs_end='".$gs_end."', 
	                                       gs_maxrounds='".$_POST['gs_maxrounds']."',
	                                       gs_staging='".$_POST['gs_staging']."',
	                                       gs_regtype='".$_POST['gs_regtype']."',
	                                       gs_trans='".$_POST['gs_trans']."',
										   gs_mwe='".$_POST['gs_mwe']."',
	                                       checkin='".$_POST['checkin']."', 
	                                       status='".$_POST['status']."',  
	                                       gewinn1='".$_POST['gewinn1']."', 
	                                       gewinn2='".$_POST['gewinn2']."', 
	                                       gewinn3='".$_POST['gewinn3']."', 
	                                       gameaccID='".$_POST['gameacc']."', 
	                                       1on1='".$_POST['onecup']."', 
	                                       clanmembers='".$_POST['clanmembers']."', 
	                                       cupgalimit='".$_POST['cupgalimit']."', 
	                                       cupaclimit='".$_POST['cupaclimit']."', 
	                                       gameacclimit='".$_POST['gameacclimit']."', 
	                                       cgameacclimit='".$_POST['cgameacclimit']."', 
	                                       ratio_low='".$_POST['ratio_low']."', 
	                                       ratio_high='".$_POST['ratio_high']."',
	                                       gs_dxp='".$_POST['gs_dxp']."',
                                           timezone='".$_POST['timezone']."',
 										   discheck='".$_POST['discheck']."',
										   agents='".$_POST['agents']."' WHERE ID='".$_POST['cupID']."'");
										   
					redirect("","<center><font color='red'><b>Tournament successfully edited!</b></font></center>",2);					   
	}                                 	                                                                      
	                                       
}elseif($_GET['delete']) {

$alpha_groups = "cupID='a' || cupID='b' || cupID='c' || cupID='d' || cupID='e' || cupID='f' || cupID='g' || cupID='h'";

	safe_query("DELETE FROM ".PREFIX."cups WHERE ID='".$_GET['ID']."'");
	safe_query("DELETE FROM ".PREFIX."cup_baum WHERE cupID='".$_GET['ID']."'");
	safe_query("DELETE FROM ".PREFIX."cup_clans WHERE cupID='".$_GET['ID']."'");			
	safe_query("DELETE FROM ".PREFIX."cup_matches WHERE cupID='".$_GET['ID']."'");
	safe_query("DELETE FROM ".PREFIX."cup_matches WHERE matchno='".$_GET['ID']."' && ($alpha_groups) && ladID='0'");
	safe_query("DELETE FROM ".PREFIX."cup_tickets WHERE cupID='".$_GET['ID']."'");
	safe_query("DELETE FROM ".PREFIX."cup_clan_lineup WHERE cupID='".$_GET['ID']."'");
	safe_query("DELETE FROM ".PREFIX."cup_clans WHERE groupID='".$_GET['ID']."' && ($alpha_groups) && ladID='0'");
	safe_query("DELETE FROM ".PREFIX."cup_rules WHERE cupID='".$_GET['ID']."'"); 
	safe_query("DELETE FROM ".PREFIX."cup_admins WHERE cupID='".$_GET['ID']."'");
}elseif($_POST['savebaum']) {
	$max=$_POST['max'];
	$i1=1;
	$i2=1;
	
	if($max==8)
		$max=14;
	elseif($max==80)
		$max=8;
	elseif($max==16)
		$max=30;
	elseif($max==160)
		$max=16;
	elseif($max==32)
		$max=62;
	elseif($max==320)
		$max=32;	
	elseif($max==64)
		$max=126;	
	elseif($max==640)
		$max=64;
	
	for ($i = 1; $i <= $max; $i++) {
		$clan1=$_POST['clan'.$i1.''];
		$clan2=$i1+1;
		$clan2=$_POST['clan'.$clan2.''];	
		if(!empty($clan1) || !empty($clan2)){
			if(!mysql_num_rows(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE cupID='".$_POST['cupID']."' && matchno='$i2'")))
				safe_query("INSERT INTO ".PREFIX."cup_matches (cupID, ladID, matchno, date, clan1, clan2, score1, score2, server, hltv, report, comment) VALUES ('".$_POST['cupID']."', '0', '$i2', '".time()."', '$clan1', '$clan2', '', '', '', '', '', '2')");
			else
				safe_query("UPDATE ".PREFIX."cup_matches SET clan1='$clan1', clan2='$clan2' WHERE cupID='".$_POST['cupID']."' && matchno='$i2'");
		}
		$i1=$i1+2;
		$i2++;
		unset($clan1,$clan2);
	}

	safe_query("UPDATE ".PREFIX."cup_baum 
					SET  
						wb_winner='".$_POST['wb_winner']."',
						lb_winner='".$_POST['lb_winner']."',
						third_winner='".$_POST['third_winner']."',
						map1='".$_POST['map1']."',
						map2='".$_POST['map2']."',
						map3='".$_POST['map3']."',
						map4='".$_POST['map4']."',
						map5='".$_POST['map5']."',
						map6='".$_POST['map6']."',
						map7='".$_POST['map7']."',
						map8='".$_POST['map8']."',
						map9='".$_POST['map9']."',
						map10='".$_POST['map10']."',
						map11='".$_POST['map11']."',
						map12='".$_POST['map12']."',
						map13='".$_POST['map13']."',
						map14='".$_POST['map14']."',
						borderbg='".$_POST['borderbg']."',
						bg1='".$_POST['bg1']."',
						bg2='".$_POST['bg2']."'
							WHERE cupID='".$_POST['cupID']."'");

}

$cupID = ($_GET['cupID'] ? $_GET['cupID'] : $_GET['ID']);
echo'<h2>'.getcupname($cupID).'</h2>';

$gamesa=safe_query("SELECT tag, name FROM ".PREFIX."games ORDER BY name");
while($dv=mysql_fetch_array($gamesa)) {
		$games.='<option value="'.$dv['tag'].'">'.$dv['name'].'</option>';
}

	$games=str_replace(' selected', '', $games);
	$games=str_replace('value="'.$_POST['game'].'"', 'value="'.$_POST['game'].'" selected', $games);
	
	$platforms=str_replace(' selected', '', $platforms);
	$platforms=str_replace('value="'.$_POST['platID'].'"', 'value="'.$_POST['platID'].'" selected', $platforms);

if($_GET['action']=="checkmatch") {

   $query = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE cupID='".$_GET['cupID']."' && matchno='".$_GET['match']."'");
   if(mysql_num_rows($query)) $message = "Match couldn't delete, perhaps Wildcard?"; else $message = "Match successfully removed!";
   
   redirect('admincenter.php?site=cups&action=baum&ID='.$_GET['cupID'], $message, 2);
}


if($_GET['action']=="delmatch") {
   safe_query("DELETE FROM ".PREFIX."cup_matches WHERE cupID='".$_GET['cupID']."' && matchno='".$_GET['match']."'");   
   redirect('admincenter.php?site=cups&action=checkmatch&cupID='.$_GET['cupID'].'&match='.$_GET['match'], '...', 0);
}


if($_GET['action']=="add") {
	$ergebnis=safe_query("SELECT * FROM ".PREFIX."gameacc ORDER BY type");
	while($ds=mysql_fetch_array($ergebnis)) {
		$gameaccs.='<option value="'.$ds['gameaccID'].'">'.$ds['type'].'</option>';
	}
	
	$gameaccs=str_replace(' selected', '', $gameaccs);
	$gameaccs=str_replace('value="'.$_POST['gameacc'].'"', 'value="'.$_POST['gameacc'].'" selected', $gameaccs);
	
  $query = safe_query("SELECT * FROM ".PREFIX."cup_platforms");
    $num_platforms = mysql_num_rows($query);
      while($pt = mysql_fetch_array($query)) {
         $platforms.='<option value="'.$pt['ID'].'">'.$pt['name'].' ('.$pt['platform'].')</option>';
     }
	 
  if(!$num_platforms)
      die('You must create at least one platform before you can create ladders.');
	
    //cup	
		
    $lsd = $_POST['s_day'];
    $lsw = $_POST['s_month'];
    $lsy = $_POST['s_year'];
    $lsh = $_POST['s_hour'];
    $lsm = $_POST['s_min'];		
    $led = $_POST['e_day'];
    $lew = $_POST['e_month'];
    $ley = $_POST['e_year'];
    $leh = $_POST['e_hour'];
    $lem = $_POST['e_min'];
    
    //groupstage	
		
    $gsd = $_POST['gs_s_day'];
    $gsw = $_POST['gs_s_month'];
    $gsy = $_POST['gs_s_year'];
    $gsh = $_POST['gs_s_hour'];
    $gsm = $_POST['gs_s_min'];
    $ged = $_POST['gs_e_day'];
    $gew = $_POST['gs_e_month'];
    $gey = $_POST['gs_e_year'];
    $geh = $_POST['gs_e_hour'];
    $gem = $_POST['gs_e_min'];	
    
//timezones

$tz=mysql_fetch_array(safe_query("SELECT timezone FROM ".PREFIX."cup_settings"));

if(!$_POST['timezone']) $sh_timez = $tz['timezone'];
else $sh_timez = $_POST['timezone'];

  $timezones = '

<option selected value="'.$_POST['timezone'].'">Current: '.$sh_timez.'</option>
<option value="Pacific/Midway">(GMT-11:00) Midway Island, Samoa</option>
<option value="America/Adak">(GMT-10:00) Hawaii-Aleutian</option>
<option value="Etc/GMT+10">(GMT-10:00) Hawaii</option>
<option value="Pacific/Marquesas">(GMT-09:30) Marquesas Islands</option>
<option value="Pacific/Gambier">(GMT-09:00) Gambier Islands</option>
<option value="America/Anchorage">(GMT-09:00) Alaska</option>
<option value="America/Ensenada">(GMT-08:00) Tijuana, Baja California</option>
<option value="Etc/GMT+8">(GMT-08:00) Pitcairn Islands</option>
<option value="America/Los_Angeles">(GMT-08:00) Pacific Time (US & Canada)</option>
<option value="America/Denver">(GMT-07:00) Mountain Time (US & Canada)</option>
<option value="America/Chihuahua">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
<option value="America/Dawson_Creek">(GMT-07:00) Arizona</option>
<option value="America/Belize">(GMT-06:00) Saskatchewan, Central America</option>
<option value="America/Cancun">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
<option value="Chile/EasterIsland">(GMT-06:00) Easter Island</option>
<option value="America/Chicago">(GMT-06:00) Central Time (US & Canada)</option>
<option value="America/New_York">(GMT-05:00) Eastern Time (US & Canada)</option>
<option value="America/Havana">(GMT-05:00) Cuba</option>
<option value="America/Bogota">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
<option value="America/Caracas">(GMT-04:30) Caracas</option>
<option value="America/Santiago">(GMT-04:00) Santiago</option>
<option value="America/La_Paz">(GMT-04:00) La Paz</option>
<option value="Atlantic/Stanley">(GMT-04:00) Faukland Islands</option>
<option value="America/Campo_Grande">(GMT-04:00) Brazil</option>
<option value="America/Goose_Bay">(GMT-04:00) Atlantic Time (Goose Bay)</option>
<option value="America/Glace_Bay">(GMT-04:00) Atlantic Time (Canada)</option>
<option value="America/St_Johns">(GMT-03:30) Newfoundland</option>
<option value="America/Araguaina">(GMT-03:00) UTC-3</option>
<option value="America/Montevideo">(GMT-03:00) Montevideo</option>
<option value="America/Miquelon">(GMT-03:00) Miquelon, St. Pierre</option>
<option value="America/Godthab">(GMT-03:00) Greenland</option>
<option value="America/Argentina/Buenos_Aires">(GMT-03:00) Buenos Aires</option>
<option value="America/Sao_Paulo">(GMT-03:00) Brasilia</option>
<option value="America/Noronha">(GMT-02:00) Mid-Atlantic</option>
<option value="Atlantic/Cape_Verde">(GMT-01:00) Cape Verde Is.</option>
<option value="Atlantic/Azores">(GMT-01:00) Azores</option>
<option value="Europe/Belfast">(GMT) Greenwich Mean Time : Belfast</option>
<option value="Europe/Dublin">(GMT) Greenwich Mean Time : Dublin</option>
<option value="Europe/Lisbon">(GMT) Greenwich Mean Time : Lisbon</option>
<option value="Europe/London">(GMT) Greenwich Mean Time : London</option>
<option value="Africa/Abidjan">(GMT) Monrovia, Reykjavik</option>
<option value="Europe/Amsterdam">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
<option value="Europe/Belgrade">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
<option value="Europe/Brussels">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
<option value="Africa/Algiers">(GMT+01:00) West Central Africa</option>
<option value="Africa/Windhoek">(GMT+01:00) Windhoek</option>
<option value="Asia/Beirut">(GMT+02:00) Beirut</option>
<option value="Africa/Cairo">(GMT+02:00) Cairo</option>
<option value="Asia/Gaza">(GMT+02:00) Gaza</option>
<option value="Africa/Blantyre">(GMT+02:00) Harare, Pretoria</option>
<option value="Asia/Jerusalem">(GMT+02:00) Jerusalem</option>
<option value="Europe/Minsk">(GMT+02:00) Minsk</option>
<option value="Asia/Damascus">(GMT+02:00) Syria</option>
<option value="Europe/Moscow">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
<option value="Africa/Addis_Ababa">(GMT+03:00) Nairobi</option>
<option value="Asia/Tehran">(GMT+03:30) Tehran</option>
<option value="Asia/Dubai">(GMT+04:00) Abu Dhabi, Muscat</option>
<option value="Asia/Yerevan">(GMT+04:00) Yerevan</option>
<option value="Asia/Kabul">(GMT+04:30) Kabul</option>
<option value="Asia/Yekaterinburg">(GMT+05:00) Ekaterinburg</option>
<option value="Asia/Tashkent">(GMT+05:00) Tashkent</option>
<option value="Asia/Kolkata">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
<option value="Asia/Katmandu">(GMT+05:45) Kathmandu</option>
<option value="Asia/Dhaka">(GMT+06:00) Astana, Dhaka</option>
<option value="Asia/Novosibirsk">(GMT+06:00) Novosibirsk</option>
<option value="Asia/Rangoon">(GMT+06:30) Yangon (Rangoon)</option>
<option value="Asia/Bangkok">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
<option value="Asia/Krasnoyarsk">(GMT+07:00) Krasnoyarsk</option>
<option value="Asia/Hong_Kong">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
<option value="Asia/Irkutsk">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
<option value="Australia/Perth">(GMT+08:00) Perth</option>
<option value="Australia/Eucla">(GMT+08:45) Eucla</option>
<option value="Asia/Tokyo">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
<option value="Asia/Seoul">(GMT+09:00) Seoul</option>
<option value="Asia/Yakutsk">(GMT+09:00) Yakutsk</option>
<option value="Australia/Adelaide">(GMT+09:30) Adelaide</option>
<option value="Australia/Darwin">(GMT+09:30) Darwin</option>
<option value="Australia/Brisbane">(GMT+10:00) Brisbane</option>
<option value="Australia/Hobart">(GMT+10:00) Hobart</option>
<option value="Asia/Vladivostok">(GMT+10:00) Vladivostok</option>
<option value="Australia/Lord_Howe">(GMT+10:30) Lord Howe Island</option>
<option value="Etc/GMT-11">(GMT+11:00) Solomon Is., New Caledonia</option>
<option value="Asia/Magadan">(GMT+11:00) Magadan</option>
<option value="Pacific/Norfolk">(GMT+11:30) Norfolk Island</option>
<option value="Asia/Anadyr">(GMT+12:00) Anadyr, Kamchatka</option>
<option value="Pacific/Auckland">(GMT+12:00) Auckland, Wellington</option>
<option value="Etc/GMT-12">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
<option value="Pacific/Chatham">(GMT+12:45) Chatham Islands</option>
<option value="Pacific/Tongatapu">(GMT+13:00) Nuku\'alofa</option>
<option value="Pacific/Kiritimati">(GMT+14:00) Kiritimati</option>';

    $tsd = $_POST['s_day'];
    $tsw = $_POST['s_month'];
    $tsy = $_POST['s_year'];
    $tsh = $_POST['s_hour'];
    $tsm = $_POST['s_min'];		

	if($_POST['onecup']){
		$onecup='checked';
		$discup='disabled';
		$typcup='1on1';
	}
	
	if($_POST['clanmembers']) 
		$clanmem='checked';
		
	if($_POST['agents']) 
		$agents='checked';
		
	if($_POST['discheck']) 
		$discheck='checked';
	
	if($_POST['gameacclimit']) 
		$gvalidbackup='checked';
	
	if($_POST['cgameacclimit']) 
		$gvalidcheckin='checked';
		
	$maxsignups='<option value="8">8 (Double-Elimination)</option><option value="80">8 (Single-Elimination)</option><option value="16">16 (Double-Elimination)</option><option value="160">16 (Single-Elimination))</option><option value="32">32 (Double-Elimination)</option><option value="320">32 (Single-Elimination)</option><option value="64">64 (Double-Elimination)</option><option value="640">64 (Single-Elimination)</option>';
	$maxsignups=str_replace(' selected', '', $maxsignups);
	$maxsignups=str_replace('value="'.$_POST['maxclan'].'"', 'value="'.$_POST['maxclan'].'" selected', $maxsignups);
	
	$dd_signup='<option value="1">Signup phase</option><option value="2">Started</option><option value="3">Closed</option>';
	$dd_signup=str_replace(' selected', '', $dd_signup);
	$dd_signup=str_replace('value="'.$_POST['status'].'"', 'value="'.$_POST['status'].'" selected', $dd_signup);
	
	$dd_passing='<option value="0">Win first match</option><option value="2">Qualify by XP - Single Match</option><option value="1">Qualify by XP - All vs. All</option>';
	$dd_passing=str_replace(' selected', '', $dd_passing);
	$dd_passing=str_replace('value="'.$_POST['gs_staging'].'"', 'value="'.$_POST['gs_staging'].'" selected', $dd_passing);
	
	$dd_regtype='<option value="0">Randomized Group Registration</option><option value="1">Pick Group Registration</option>';
	$dd_regtype=str_replace(' selected', '', $dd_regtype);
	$dd_regtype=str_replace('value="'.$_POST['gs_regtype'].'"', 'value="'.$_POST['gs_regtype'].'" selected', $dd_regtype);

	$dd_trans='<option value="1">Open cup registration after group stages finish</option><option value="0">Change according to set start and end times</option>';
	$dd_trans=str_replace(' selected', '', $dd_trans);
	$dd_trans=str_replace('value="'.$_POST['gs_trans'].'"', 'value="'.$_POST['gs_trans'].'" selected', $dd_trans);
	
	$dd_dxp='<option value="1">Win XP Only</option><option value="0">Win/Loss XP</option>';
	$dd_dxp=str_replace(' selected', '', $dd_dxp);
	$dd_dxp=str_replace('value="'.$_POST['gs_dxp'].'"', 'value="'.$_POST['gs_dxp'].'" selected', $dd_dxp);
	
	$platforms=str_replace(' selected', '', $platforms);
	$platforms=str_replace('value="'.$_POST['platID'].'"', 'value="'.$_POST['platID'].'" selected', $platforms);
	
	$p_check = ($_POST['checkin'] ? $_POST['checkin'] : 30);
	
    echo'<form method="post" action="admincenter.php?site=cups&action=add" name="cup">
			<table cellpadding="6" cellspacing="0">
				<tr>
					<td class="title" colspan="2" align="center"><b>Tournament Configuration</b></td>
				</tr>
				<tr>

					<td><a name="name" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'name\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Name:</td>
					<td><input type="text" name="name" value="'.$_POST['name'].'" size="30" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
				</tr>
				<tr>
					<td><a name="platform" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'platform\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Platform:</td>
					<td><select name="platID">'.$platforms.'</select> (<a href="admincenter.php?site=platforms" target="_blank">manage platforms</a>)</td>
				</tr>
				<tr>
					<td><a name="game" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'game\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Game:</td>
					<td><select name="game">'.$games.'</select></td>
				</tr>

				<tr>
					<td><a name="desc" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'desc\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Description:<br>(BBCode activated)</td>
					<td><textarea name="desc" cols="50" rows="8" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'">'.$_POST['desc'].'</textarea></td>
				</tr>
				<tr>
					<td><a name="1on1" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'1on1\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> 1on1:</td>
					<td><input type="checkbox" name="onecup" value="1" '.$onecup.' onClick="if( document.cup.onecup.checked ) { document.cup.typ.value = \'1on1\';document.cup.typ.disabled = true; } else { document.cup.typ.disabled = false;document.cup.typ.value = \'\'; }"></td>
				</tr>	
				<tr>
					<td><a name="clan" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'clan\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Clanmembers Only?:</td>
					<td><input type="checkbox" name="clanmembers" value="1" '.$clanmem.'></td>
				</tr>
				<tr>
					<td><a name="agents" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'agents\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Accept Free-Agents?:</td>
					<td><input type="checkbox" name="agents" value="1" '.$agents.'></td>
				</tr>
				<tr>
					<td><a name="discheck" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'discheck\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Automatic Checkin?:</td>
					<td><input type="checkbox" name="discheck" value="1" '.$discheck.'></td>
				</tr>	
				<tr>
					<td><a name="gamb" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'gamb\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Gameaccount Validation?:</td>
					<td><input type="checkbox" name="gameacclimit" value="1" '.$gvalidbackup.'> (enter)</td>
				</tr>
				<tr>
					<td><a name="gamc" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'gamc\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Gameaccount Validation?:</td>
					<td><input type="checkbox" name="cgameacclimit" value="1" '.$gvalidcheckin.'> (checkin)</td>
				</tr>
				<tr>
					<td><a name="type" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'type\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Type:</td>
					<td><input type="text" name="typ" size="5" value="'.$typcup.'" '.$discup.' class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> XonX</td>
				</tr>
				<tr>
					<td><a name="rati" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'rati\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Ratio:</td>
					<td><input type="text" value="'.$_POST['ratio_low'].'" name="ratio_low" size="3" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">% - <input type="text" value="'.$_POST['ratio_high'].'" name="ratio_high" size="3" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">% Skill comptence level by score ratio (0 for both = disable)</td>
				</tr>
				<tr>
					<td><a name="cupt" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'cupt\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Cup type -</td>
					<td><input value="'.$_POST['cupgalimit'].'" type="text" name="cupgalimit" size="3" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> Member Count (enter)</td>
				</tr>
				<tr>
					<td><a name="line" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'line\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Lineup/Cup type -</td>
					<td><input value="'.$_POST['cupaclimit'].'" type="text" name="cupaclimit" size="3" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> Member Count (checkin)</td>
				</tr>
				<tr>
					<td><a name="maxs" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'maxs\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Max. Signups:</td>

					<td><select name="maxclan">'.$maxsignups.'</select></td>
				</tr>
				<tr>
					<td><a name="star" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'star\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Start:</td>
					<td><input name="s_day" type="text" size="2" value="'.$tsd.'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">.<input name="s_month" type="text" size="2" value="'.$tsw.'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">.<input name="s_year" type="text" size="4" value="'.$tsy.'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> (dd.mm.yyyy) at <input name="s_hour" type="text" size="2" value="'.$tsh.'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">:<input name="s_min" type="text" size="2" value="'.$tsm.'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>

				</tr> 
				<tr>
					<td><a name="chec" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'chec\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Check-In</td>

					<td><input name="checkin" type="text" size="2" value="'.$p_check.'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> min. before start</td>
				</tr>
				<tr>
					<td><a name="stat" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'stat\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Status:</td>
					<td><select name="status">'.$dd_signup.'</select></td>
				</tr>
				<tr>
					<td><a name="time" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'time\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Timezone:</td>
					<td><select name="timezone">'.$timezones.'</select></td>
				</tr>
				<tr>
					<td><a name="gacc" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'gacc\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Gameaccount:</td>
					<td><select name="gameacc">'.$gameaccs.'</select></td>
				</tr>		
	     <tr>
		   <td class="title" style="border-top:1px solid #CCCCCC">&nbsp;</td>
		   <td class="title" style="border-top:1px solid #CCCCCC"><a name="gs" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'gs\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> <b>Groupstage Configuration</b> (ignore to disable)</td>
		 </tr>
				<tr>
					<td><a name="gsst" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'gsst\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Group-Stage Start:</td>
					<td><input name="gs_s_day" type="text" size="2" value="'.$gsd.'" maxlength="2" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">.<input name="gs_s_month" type="text" size="2" value="'.$gsw.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">.<input name="gs_s_year" type="text" size="4" value="'.$gsy.'" maxlength="4" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> (dd.mm.yyyy) at <input name="gs_s_hour" type="text" size="2" value="'.$gsh.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">:<input name="gs_s_min" type="text" size="2" value="'.$gsm.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
				</tr>
				<tr>
					<td><a name="gsen" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'gsen\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Group-Stage End:</td>
					<td><input name="gs_e_day" type="text" size="2" value="'.$ged.'" maxlength="2" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">.<input name="gs_e_month" type="text" size="2" value="'.$gew.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">.<input name="gs_e_year" type="text" size="4" value="'.$gey.'" maxlength="4" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> (dd.mm.yyyy) at <input name="gs_e_hour" type="text" size="2" value="'.$geh.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">:<input name="gs_e_min" type="text" size="2" value="'.$gem.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
				</tr>
				<tr>
					<td><a name="mrou" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'mrou\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Maxrounds:</td>
					<td><input name="gs_maxrounds" type="text" size="4" value="'.$_POST['gs_maxrounds'].'" maxlength="4" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
				</tr>
				<tr>
					<td><a name="mwee" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'mwee\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Match Days:</td>
					<td><input name="gs_mwe" type="text" size="4" value="'.($_POST['gs_mwe']=='' ? '1' : $_POST['gs_mwe']).'" maxlength="4" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
				</tr>
				<tr>
					<td><a name="qual" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'qual\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> How to qualify:</td>
					<td><select name="gs_staging">'.$dd_passing.'</select></td>
				</tr>
				<tr>
					<td><a name="dexp" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'dexp\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Determine XP by?:</td>
					<td><select name="gs_dxp">'.$dd_dxp.'</select></td>
				</tr>
				<tr>
					<td><a name="rtyp" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'rtyp\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Reg. Type:</td>
					<td><select name="gs_regtype">'.$dd_regtype.'</select></td>
				</tr>
				<tr>
					<td><a name="afin" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'afin\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> After-Finish:</td>
					<td><select name="gs_trans">'.$dd_trans.'</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><input type="submit" name="save" value="Create Tournament"></td>
				</tr>
			</table>
		</form><br/><br/><br/><br/>';
}elseif($_GET['action']=="randombaum") {
	$cupID = $_GET['cupID'];
	$max = $_GET['max'];
	if($max==8 || $max==80)
		$max = 8;
	elseif($max==16 || $max==160)
		$max = 16;
	elseif($max==32 || $max==320)
	    $max = 32;
	else
		$max = 64;
	
	
	for($i = 1; $i <= $max; $i++){
		safe_query("DELETE FROM ".PREFIX."cup_matches WHERE cupID='$cupID' && matchno='$i'");
	}
	
	$clans=safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE cupID='$cupID' && checkin='1'");
	while($dv=mysql_fetch_array($clans)) {
		if($n < 1)
			$n=1;
		$clan[$n] = $dv['clanID'];
		$n++;
	}
	$count = count($clan);
	
	while($count < $max){
		$count++;
		$clan[$count] = 2147483647; 
	}
	
	shuffle($clan);	
	
	$i2=0;
	for ($i = 1; $i <= $max; $i++) {
		if($clan[$i2] || $clan[$i2+1])
			safe_query("INSERT INTO ".PREFIX."cup_matches (cupID, ladID, matchno, date, clan1, clan2, score1, score2, server, hltv, report, comment) VALUES ('$cupID', '0', '$i', '".time()."', '".$clan[$i2]."', '".$clan[$i2+1]."', '', '', '', '', '', '2')");
		$i2 += 2;
	}

	redirect('?site=cups&action=baum&ID='.$cupID, 'Brackets successfully changed!', 2);
}
elseif($_GET['action']=="edit") {
	$ID = $_GET['ID'];
	
//title_cup
	
if(is1on1($ID)) $participants = 'Manage Players';
else $participants = 'Manage Teams';
	
echo '

<table width="100%" cellpadding="2" cellspacing="1" bgcolor="'.$border.'">
	<tr>
		<td class="title" bgcolor="'.$bghead.'" width="12%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp; Edit Cup</td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=teams&cupID='.$ID.'">'.$participants.'</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="14%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=cups&action=baum&ID='.$ID.'">Brackets</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="12%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=cups&action=rules&ID='.$ID.'">Rules</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="14%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=cups&action=admins&ID='.$ID.'">Admins</a></td>
        <td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=matches&cupID='.$ID.'">Matches</a></td>		
	</tr>
</table><br><br>';
	
	$ergebnis=safe_query("SELECT * FROM ".PREFIX."cups WHERE ID='".$ID."'");
	$ds=mysql_fetch_array($ergebnis);

	$games=str_replace(' selected', '', $games);
	$games=str_replace('value="'.$ds['game'].'"', 'value="'.$ds['game'].'" selected', $games);
	
  $query = safe_query("SELECT * FROM ".PREFIX."cup_platforms");
    $num_platforms = mysql_num_rows($query);
      while($pt = mysql_fetch_array($query)) {
         $platforms.='<option value="'.$pt['ID'].'">'.$pt['name'].' ('.$pt['platform'].')</option>';
     }
	 
	$platforms=str_replace(' selected', '', $platforms);
	$platforms=str_replace('value="'.$ds['platID'].'"', 'value="'.$ds['platID'].'" selected', $platforms);	
	
	$maxteilnehmer='
	       <option value="8">8 (Double-Elimination)</option>
		   <option value="80">8 (Single-Elimination)</option>
		   <option value="16">16 (Double-Elimination)</option>
		   <option value="160">16 (Single-Elimination)</option>
		   <option value="32">32 (Double-Elimination)</option>
		   <option value="320">32 (Single-Elimination)</option>
		   <option value="64">64 (Double-Elimination)</option>
		   <option value="640">64 (Single-Elimination)</option>';
	
	$maxteilnehmer=str_replace(' selected', '', $maxteilnehmer);
	$maxteilnehmer=str_replace('value="'.$ds['maxclan'].'"', 'value="'.$ds['maxclan'].'" selected', $maxteilnehmer);
	
	$qualify='<option value="0">Win first match</option><option value="2">Qualify by XP - Single Match</option><option value="1">Qualify by XP - All vs. All</option>';
	$qualify=str_replace(' selected', '', $qualify);
	$qualify=str_replace('value="'.$ds['gs_staging'].'"', 'value="'.$ds['gs_staging'].'" selected', $qualify);
	
	$d_xp='<option value="1">Win XP Only</option><option value="0">Win/Loss XP</option>';
	$d_xp=str_replace(' selected', '', $d_xp);
	$d_xp=str_replace('value="'.$ds['gs_dxp'].'"', 'value="'.$ds['gs_dxp'].'" selected', $d_xp);

	$dd_dxp='<option value="1">Win XP Only</option><option value="0">Win/Loss XP</option>';
	$dd_dxp=str_replace(' selected', '', $dd_dxp);
	$dd_dxp=str_replace('value="'.$_POST['d_xp'].'"', 'value="'.$_POST['d_xp'].'" selected', $dd_dxp);
	
	$regtype='<option value="0">Randomized Group Registration</option><option value="1">User selects what group to register in</option>';
	$regtype=str_replace(' selected', '', $regtype);
	$regtype=str_replace('value="'.$ds['gs_regtype'].'"', 'value="'.$ds['gs_regtype'].'" selected', $regtype);
	
	$league_trans='<option value="1">Open cup registration after group stages finish</option><option value="0">Change according to set start and end times</option>';
	$league_trans=str_replace(' selected', '', $league_trans);
	$league_trans=str_replace('value="'.$ds['gs_trans'].'"', 'value="'.$ds['gs_trans'].'" selected', $league_trans);
	
	$status='
	       <option value="1" selected>Signup phase</option>
		   <option value="2">Started</option>

		   <option value="3">Closed</option>';
		   
	$status=str_replace(' selected', '', $status);
	$status=str_replace('value="'.$ds['status'].'"', 'value="'.$ds['status'].'" selected', $status);
	
	$checkin=$ds['checkin'];
	$s_day=date("d", $ds['start']);
	$s_month=date("m", $ds['start']);
	$s_year=date("Y", $ds['start']);
	$s_hour=date("H", $ds['start']);
	$s_min=date("i", $ds['start']);
	
	$e_day=date("d", $ds['ende']);
	$e_month=date("m", $ds['ende']);
	$e_year=date("Y", $ds['ende']);
    $e_hour=date("H", $ds['ende']);
	$e_min=date("i", $ds['ende']);

    if(!$ds['gs_start']) {
	      $gsd = '';
		  $gsw = '';
		  $gsy = '';
	  	  $gsh = '';
		  $gsm = '';
	}
	else{
          $gsd = date('d', $ds['gs_start']);
          $gsw = date('m', $ds['gs_start']);
          $gsy = date('Y', $ds['gs_start']);
          $gsh = date('H', $ds['gs_start']);
          $gsm = date('i', $ds['gs_start']);
	}
		
	if(!$ds['gs_end']) {
	      $ged = '';
		  $gew = '';
		  $gey = '';
	  	  $geh = '';
		  $gem = '';
	}
	else{
          $ged = date('d', $ds['gs_end']);
          $gew = date('m', $ds['gs_end']);
          $gey = date('Y', $ds['gs_end']);
          $geh = date('H', $ds['gs_end']);
          $gem = date('i', $ds['gs_end']);
	}
	
	$ergebnis=safe_query("SELECT gameaccID, type FROM ".PREFIX."gameacc ORDER BY type");
	while($dd=mysql_fetch_array($ergebnis)) {
		$gameaccs.='<option value="'.$dd['gameaccID'].'">'.$dd['type'].'</option>';
	}	
	$gameaccs=str_replace(' selected', '', $gameaccs);
	$gameaccs=str_replace('value="'.$ds['gameaccID'].'"', 'value="'.$ds['gameaccID'].'" selected', $gameaccs);
	
	if($ds['1on1']){
		$onecup='checked';
		$discup='disabled';
	}
	
	if($ds['clanmembers']) {
		$clanmem='checked';
	}
	
	if($ds['agents']) 
		$agents='checked';
	
	if($ds['discheck']) {
		$discheck='checked';
	}
	
	if($ds['gameacclimit']) {
		$gvalidbackup='checked';
	}
	
	if($ds['cgameacclimit']) {
		$gvalidcheckin='checked';
	}
	
//timezones

$tz=mysql_fetch_array(safe_query("SELECT timezone FROM ".PREFIX."cup_settings"));

if(!$ds['timezone']) $sh_timez = $tz['timezone'];
else $sh_timez = $ds['timezone'];

  $timezones = '

<option selected value="'.$ds['timezone'].'">Current: '.$sh_timez.'</option>
<option value="Pacific/Midway">(GMT-11:00) Midway Island, Samoa</option>
<option value="America/Adak">(GMT-10:00) Hawaii-Aleutian</option>
<option value="Etc/GMT+10">(GMT-10:00) Hawaii</option>
<option value="Pacific/Marquesas">(GMT-09:30) Marquesas Islands</option>
<option value="Pacific/Gambier">(GMT-09:00) Gambier Islands</option>
<option value="America/Anchorage">(GMT-09:00) Alaska</option>
<option value="America/Ensenada">(GMT-08:00) Tijuana, Baja California</option>
<option value="Etc/GMT+8">(GMT-08:00) Pitcairn Islands</option>
<option value="America/Los_Angeles">(GMT-08:00) Pacific Time (US & Canada)</option>
<option value="America/Denver">(GMT-07:00) Mountain Time (US & Canada)</option>
<option value="America/Chihuahua">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
<option value="America/Dawson_Creek">(GMT-07:00) Arizona</option>
<option value="America/Belize">(GMT-06:00) Saskatchewan, Central America</option>
<option value="America/Cancun">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
<option value="Chile/EasterIsland">(GMT-06:00) Easter Island</option>
<option value="America/Chicago">(GMT-06:00) Central Time (US & Canada)</option>
<option value="America/New_York">(GMT-05:00) Eastern Time (US & Canada)</option>
<option value="America/Havana">(GMT-05:00) Cuba</option>
<option value="America/Bogota">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
<option value="America/Caracas">(GMT-04:30) Caracas</option>
<option value="America/Santiago">(GMT-04:00) Santiago</option>
<option value="America/La_Paz">(GMT-04:00) La Paz</option>
<option value="Atlantic/Stanley">(GMT-04:00) Faukland Islands</option>
<option value="America/Campo_Grande">(GMT-04:00) Brazil</option>
<option value="America/Goose_Bay">(GMT-04:00) Atlantic Time (Goose Bay)</option>
<option value="America/Glace_Bay">(GMT-04:00) Atlantic Time (Canada)</option>
<option value="America/St_Johns">(GMT-03:30) Newfoundland</option>
<option value="America/Araguaina">(GMT-03:00) UTC-3</option>
<option value="America/Montevideo">(GMT-03:00) Montevideo</option>
<option value="America/Miquelon">(GMT-03:00) Miquelon, St. Pierre</option>
<option value="America/Godthab">(GMT-03:00) Greenland</option>
<option value="America/Argentina/Buenos_Aires">(GMT-03:00) Buenos Aires</option>
<option value="America/Sao_Paulo">(GMT-03:00) Brasilia</option>
<option value="America/Noronha">(GMT-02:00) Mid-Atlantic</option>
<option value="Atlantic/Cape_Verde">(GMT-01:00) Cape Verde Is.</option>
<option value="Atlantic/Azores">(GMT-01:00) Azores</option>
<option value="Europe/Belfast">(GMT) Greenwich Mean Time : Belfast</option>
<option value="Europe/Dublin">(GMT) Greenwich Mean Time : Dublin</option>
<option value="Europe/Lisbon">(GMT) Greenwich Mean Time : Lisbon</option>
<option value="Europe/London">(GMT) Greenwich Mean Time : London</option>
<option value="Africa/Abidjan">(GMT) Monrovia, Reykjavik</option>
<option value="Europe/Amsterdam">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
<option value="Europe/Belgrade">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
<option value="Europe/Brussels">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
<option value="Africa/Algiers">(GMT+01:00) West Central Africa</option>
<option value="Africa/Windhoek">(GMT+01:00) Windhoek</option>
<option value="Asia/Beirut">(GMT+02:00) Beirut</option>
<option value="Africa/Cairo">(GMT+02:00) Cairo</option>
<option value="Asia/Gaza">(GMT+02:00) Gaza</option>
<option value="Africa/Blantyre">(GMT+02:00) Harare, Pretoria</option>
<option value="Asia/Jerusalem">(GMT+02:00) Jerusalem</option>
<option value="Europe/Minsk">(GMT+02:00) Minsk</option>
<option value="Asia/Damascus">(GMT+02:00) Syria</option>
<option value="Europe/Moscow">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
<option value="Africa/Addis_Ababa">(GMT+03:00) Nairobi</option>
<option value="Asia/Tehran">(GMT+03:30) Tehran</option>
<option value="Asia/Dubai">(GMT+04:00) Abu Dhabi, Muscat</option>
<option value="Asia/Yerevan">(GMT+04:00) Yerevan</option>
<option value="Asia/Kabul">(GMT+04:30) Kabul</option>
<option value="Asia/Yekaterinburg">(GMT+05:00) Ekaterinburg</option>
<option value="Asia/Tashkent">(GMT+05:00) Tashkent</option>
<option value="Asia/Kolkata">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
<option value="Asia/Katmandu">(GMT+05:45) Kathmandu</option>
<option value="Asia/Dhaka">(GMT+06:00) Astana, Dhaka</option>
<option value="Asia/Novosibirsk">(GMT+06:00) Novosibirsk</option>
<option value="Asia/Rangoon">(GMT+06:30) Yangon (Rangoon)</option>
<option value="Asia/Bangkok">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
<option value="Asia/Krasnoyarsk">(GMT+07:00) Krasnoyarsk</option>
<option value="Asia/Hong_Kong">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
<option value="Asia/Irkutsk">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
<option value="Australia/Perth">(GMT+08:00) Perth</option>
<option value="Australia/Eucla">(GMT+08:45) Eucla</option>
<option value="Asia/Tokyo">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
<option value="Asia/Seoul">(GMT+09:00) Seoul</option>
<option value="Asia/Yakutsk">(GMT+09:00) Yakutsk</option>
<option value="Australia/Adelaide">(GMT+09:30) Adelaide</option>
<option value="Australia/Darwin">(GMT+09:30) Darwin</option>
<option value="Australia/Brisbane">(GMT+10:00) Brisbane</option>
<option value="Australia/Hobart">(GMT+10:00) Hobart</option>
<option value="Asia/Vladivostok">(GMT+10:00) Vladivostok</option>
<option value="Australia/Lord_Howe">(GMT+10:30) Lord Howe Island</option>
<option value="Etc/GMT-11">(GMT+11:00) Solomon Is., New Caledonia</option>
<option value="Asia/Magadan">(GMT+11:00) Magadan</option>
<option value="Pacific/Norfolk">(GMT+11:30) Norfolk Island</option>
<option value="Asia/Anadyr">(GMT+12:00) Anadyr, Kamchatka</option>
<option value="Pacific/Auckland">(GMT+12:00) Auckland, Wellington</option>
<option value="Etc/GMT-12">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
<option value="Pacific/Chatham">(GMT+12:45) Chatham Islands</option>
<option value="Pacific/Tongatapu">(GMT+13:00) Nuku\'alofa</option>
<option value="Pacific/Kiritimati">(GMT+14:00) Kiritimati</option>';
		
		echo'<form method="post" action="" name="cup">
	     <table cellpadding="6" cellspacing="0">
	     <tr>
			<td class="title" colspan="2" align="center"><b>Tournament Configuration</b></td>
		 </tr>
		 <tr>
		   <td><a name="name" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'name\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Name:</td>
		   <td><input type="text" name="name" size="30" value="'.$ds['name'].'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
		 </tr>
				<tr>
					<td><a name="platform" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'platform\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Platform:</td>
					<td><select name="platID">'.$platforms.'</select> (<a href="admincenter.php?site=platforms" target="_blank">manage platforms</a>)</td>
				</tr>
		 <tr>
		   <td><a name="game" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'game\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Game:</td>
		   <td><select name="game">'.$games.'</select></td>
		 </tr>
		  <tr>
		   <td><a name="desc" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'desc\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Description:<br>(BBCode activated)</td>
		   <td><textarea name="desc" cols="50" rows="8" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'">'.$ds['desc'].'</textarea></td>

		 </tr>
		  <tr>
		   <td><a name="1on1" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'1on1\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> 1on1:</td>
		   <td><input type="checkbox" name="onecup" value="1" '.$onecup.' onClick="if( document.cup.onecup.checked ) { document.cup.typ.value = \'1on1\';document.cup.typ.disabled = true; } else { document.cup.typ.disabled = false;document.cup.typ.value = \'\'; }"></td>
		 </tr>	
		  <tr>
		   <td><a name="clan" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'clan\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Clanmembers Only?:</td>
		   <td><input type="checkbox" name="clanmembers" value="1" '.$clanmem.'></td>
		 </tr>
		  <tr>
			<td><a name="agents" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'agents\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Accept Free-Agents?:</td>
			<td><input type="checkbox" name="agents" value="1" '.$agents.'></td>
		   </tr>
		  <tr>
		   <td><a name="discheck" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'discheck\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Automatic Checkin?:</td>
		   <td><input type="checkbox" name="discheck" value="1" '.$discheck.'></td>
		 </tr>
		  <tr>
			<td><a name="gamb" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'gamb\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Gameaccount Validation?:</td>
			<td><input type="checkbox" name="gameacclimit" value="1" '.$gvalidbackup.'> (enter)</td>
		  </tr>
		   <tr>
			<td><a name="gamc" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'gamc\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Gameaccount Validation?:</td>
			<td><input type="checkbox" name="cgameacclimit" value="1" '.$gvalidcheckin.'> (checkin)</td>
		 </tr>
		  <tr>
		   <td><a name="type" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'type\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Type:</td>
		   <td><input type="text" name="typ" size="5" value="'.$ds['typ'].'" '.$discup.' class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> XonX</td>
		 </tr>	
		  <tr>
		   <td><a name="rati" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'rati\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Ratio:</td>
		   <td><input type="text" name="ratio_low" size="3" value="'.$ds['ratio_low'].'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">% - <input type="text" name="ratio_high" size="3" value="'.$ds['ratio_high'].'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">% Skill comptence level by score ratio (0 for both = disable)</td>
		 </tr>	
		  <tr>
		   <td><a name="cupt" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'cupt\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Cup type -</td>
		   <td><input type="text" name="cupgalimit" size="3" value="'.$ds['cupgalimit'].'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> Member Count (enter)</td>
		 </tr>	
		  <tr>
		   <td><a name="line" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'line\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Lineup/Cup type -</td>
		   <td><input type="text" name="cupaclimit" size="3" value="'.$ds['cupaclimit'].'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> Member Count (checkin)</td>
		 </tr>	
		  <tr>
		   <td><a name="maxs" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'maxs\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Max. Signups:</td>
		   <td><select name="maxclan">
           '.$maxteilnehmer.'
		   </select></td>
		 </tr>
		  <tr>
		   <td><a name="star" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'star\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Start:</td>

		   <td><input name="s_day" type="text" size="2" value="'.$s_day.'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">
        . 
        <input name="s_month" type="text" size="2" value="'.$s_month.'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">
        . 
        <input name="s_year" type="text" size="4" value="'.$s_year.'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> (dd.mm.yyyy) at 
		<input name="s_hour" type="text" size="2" value="'.$s_hour.'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">
        :
        <input name="s_min" type="text" size="2" value="'.$s_min.'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">
        		</td>
		 </tr> 
		  <tr>
			<td><a name="chec" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'chec\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Check-In</td>
		   <td><input name="checkin" type="text" size="2" value="'.$checkin.'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> min. before Start</td>
		 </tr> 
		 <tr>
		   <td><a name="stat" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'stat\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Status:</td>

		   <td><select name="status">
           '.$status.'
		   </select></td>
		 </tr> 
				<tr>
					<td><a name="time" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'time\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Timezone:</td>
					<td><select name="timezone">'.$timezones.'</select></td>
				</tr>
		  <tr>
		   <td><a name="gacc" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'gacc\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Gameaccount:</td>
		   <td><select name="gameacc">
		   '.$gameaccs.'
		   </select></td>
		 </tr>	 
	     <tr>
		   <td class="title" style="border-top:1px solid #CCCCCC">&nbsp;</td>
		   <td class="title" style="border-top:1px solid #CCCCCC"><a name="gs" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'gs\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> <b>Groupstage Configuration</b> (ignore to disable)</td>
		 </tr>
		 
				<tr>
					<td><a name="gsst" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'gsst\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Group-Stage Start:</td>
					<td><input name="gs_s_day" type="text" size="2" value="'.$gsd.'" maxlength="2" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">.<input name="gs_s_month" type="text" size="2" value="'.$gsw.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">.<input name="gs_s_year" type="text" size="4" value="'.$gsy.'" maxlength="4" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> (dd.mm.yyyy) at <input name="gs_s_hour" type="text" size="2" value="'.$gsh.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">:<input name="gs_s_min" type="text" size="2" value="'.$gsm.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> <a name="gs_start" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'gs_start\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a></td>
				</tr>
				<tr>
					<td><a name="gsen" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'gsen\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Group-Stage End:</td>
					<td><input name="gs_e_day" type="text" size="2" value="'.$ged.'" maxlength="2" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">.<input name="gs_e_month" type="text" size="2" value="'.$gew.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">.<input name="gs_e_year" type="text" size="4" value="'.$gey.'" maxlength="4" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> (dd.mm.yyyy) at <input name="gs_e_hour" type="text" size="2" value="'.$geh.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">:<input name="gs_e_min" type="text" size="2" value="'.$gem.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> <a name="gs_end" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'gs_end\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a></td>
				</tr>
				<tr>
					<td><a name="mrou" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'mrou\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Maxrounds:</td>
					<td><input name="gs_maxrounds" type="text" size="4" value="'.$ds['gs_maxrounds'].'" maxlength="4" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
				</tr>
				<tr>
					<td><a name="mwee" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'mwee\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Match Days:</td>
					<td><input name="gs_mwe" type="text" size="4" value="'.$ds['gs_mwe'].'" maxlength="4" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
				</tr>
				<tr>
					<td><a name="qual" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'qual\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> How to qualify:</td>
					<td><select name="gs_staging">'.$qualify.'</select></td>
				</tr>
				<tr>
					<td><a name="dexp" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'dexp\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Determine XP by?:</td>
					<td><select name="gs_dxp">'.$d_xp.'</select></td>
				</tr>
				<tr>
					<td><a name="rtyp" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'rtyp\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Reg. Type:</td>
					<td><select name="gs_regtype">'.$regtype.'</select></td>
				</tr>
				<tr>
					<td><a name="afin" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'afin\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> After-Finish:</td>
					<td><select name="gs_trans">'.$league_trans.'</select></td>
				</tr>
		 <tr>
		   <td style="border-top:1px solid #CCCCCC" class="title">&nbsp;</td>
		   <td style="border-top:1px solid #CCCCCC" class="title"><strong>Prizes</strong></td>
		 </tr>
		 <tr>
		   <td><a name="1pri" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'1pri\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> 1. Place:</td>
		   <td><input type="text" name="gewinn1" size="30" value="'.$ds['gewinn1'].'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
		 </tr> 
		<tr>

		   <td><a name="2pri" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'2pri\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> 2. Place:</td>
		   <td><input type="text" name="gewinn2" size="30" value="'.$ds['gewinn2'].'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
		 </tr> 
		<tr>
		   <td><a name="3pri" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'3pri\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> 3. Place:</td>
		   <td><input type="text" name="gewinn3" size="30" value="'.$ds['gewinn3'].'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
		 </tr> 			 	 
		  <tr>
		   <td><input type="hidden" name="cupID" value="'.$ID.'"></td>

		   <td><input type="submit" name="saveedit" value="update"></td>
		 </tr>
		 </table>
		 </form>';
}elseif($_GET['action']=="admins") {
    $cupID = $_GET['ID'];
    
//title_cup
	
if(is1on1($cupID)) $participants = 'Manage Players';
else $participants = 'Manage Teams';
	
echo '

<table width="100%" cellpadding="2" cellspacing="1" bgcolor="'.$border.'">
	<tr>
		<td class="title" bgcolor="'.$bghead.'" width="12%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=cups&action=edit&ID='.$cupID.'">Edit Cup</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=teams&cupID='.$cupID.'">'.$participants.'</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="14%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=cups&action=baum&ID='.$cupID.'">Brackets</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="12%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=cups&action=rules&ID='.$cupID.'">Rules</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="14%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp; Admins</td>
        <td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=matches&cupID='.$cupID.'">Matches</a></td>		
	</tr>
</table><br><br>';
    
	$admins = safe_query("SELECT * FROM ".PREFIX."user_groups WHERE cup='1' OR super='1'");
	echo'<br>Select admins for cup: <br><b>'.getcupname($cupID).'</b>';
	echo'<form method="post" action="admincenter.php?site=cups">
	       <select name="admins[]" multiple size="10">';
		   
	while($dm=mysql_fetch_array($admins)) {
	    $nick=getnickname($dm['userID']);
	    $isadmin=mysql_num_rows(safe_query("SELECT * FROM ".PREFIX."cup_admins WHERE cupID='$cupID' AND userID='".$dm['userID']."'"));
		if($isadmin) 
			echo'<option value="'.$dm['userID'].'" selected>'.$nick.'</option>';
		else 
			echo'<option value="'.$dm['userID'].'">'.$nick.'</option>';
	}
	echo'</select>

	       <input type="hidden" name="cupID" value="'.$cupID.'">
	       <br><br><input type="submit" name="saveadmins" value="Add Admins">
		 </form>';
}elseif($_GET['action']=="rules") {
	$cupID = $_GET['ID'];
	
//title_cup
	
if(is1on1($cupID)) $participants = 'Manage Players';
else $participants = 'Manage Teams';
	
echo '

<table width="100%" cellpadding="2" cellspacing="1" bgcolor="'.$border.'">
	<tr>
		<td class="title" bgcolor="'.$bghead.'" width="12%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=cups&action=edit&ID='.$cupID.'">Edit Cup</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=teams&cupID='.$cupID.'">'.$participants.'</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="14%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=cups&action=baum&ID='.$cupID.'">Brackets</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="12%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp; Rules</td>
		<td class="title" bgcolor="'.$bghead.'" width="14%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=cups&action=admins&ID='.$cupID.'">Admins</a></td>
        <td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=matches&cupID='.$cupID.'">Matches</a></td>		
	</tr>
</table><br><br>';
	
	$rule=safe_query("SELECT * FROM ".PREFIX."cup_rules WHERE cupID='".$cupID."'");
	$dd=mysql_fetch_array($rule);
	echo '<form method="post" name="post" action="admincenter.php?site=cups">
		     <table cellpadding="4" cellspacing="0">
	    <tr> 
	      <td valign="top">Last Change:</td>
	      <td><input type="text" name="gewinn3" size="30" value="'.($dd['lastedit'] ? date("d.m.Y \- H:i ", $dd['lastedit']) : 'No change yet').'" class="form_on" disabled></td>
	    </tr>

		<tr> 
	      <td valign="top">&nbsp;</td>
	      <td>(BBCode is activated)</td>
	    </tr>
		<tr> 
	      <td valign="top">Rules:</td>
	      <td><textarea name="value" cols="90" rows="50" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'">'.$dd['value'].'</textarea></td>
	    </tr>

	    <tr>
	      <td>&nbsp;</td>
	      <td><input name="saverules" type="submit" id="saverules" value="Save">
	      <input name="cupID" type="hidden" value="'.$cupID.'" /></td>
	    </tr>
	  </table>
	</form>';
}elseif($_GET['action']=="baum") {
	$ID = $_GET['ID'];
	
//title_cup
	
if(is1on1($ID)) $participants = 'Manage Players';
else $participants = 'Manage Teams';

if(isset($_GET['type'])=="protest") 
echo '<h1><LI> Match update successful, <a href="admincenter.php?site=cuptickets">click here</a> to go back to tickets.</h1>';
	
echo '

<table width="100%" cellpadding="2" cellspacing="1" bgcolor="'.$border.'">
	<tr>
		<td class="title" bgcolor="'.$bghead.'" width="12%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=cups&action=edit&ID='.$ID.'">Edit Cup</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=teams&cupID='.$ID.'">'.$participants.'</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="14%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp; Brackets</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="12%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=cups&action=rules&ID='.$ID.'">Rules</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="14%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=cups&action=admins&ID='.$ID.'">Admins</a></td>
        <td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=matches&cupID='.$ID.'">Matches</a></td>		
	</tr>
</table><br><br>';

	$ergebnis1 = safe_query("SELECT maxclan FROM ".PREFIX."cups WHERE ID = '".$ID."'");		
	$dr=mysql_fetch_array($ergebnis1);
	$max=$dr['maxclan'];

	
	$clan_select = '<option value="0"></option><option value="2147483647" style="font-weight: bold; background-color: #c1c1c1;">Wildcard</option>';
	$ergebnis = safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE cupID = '$ID' ORDER BY clanID ASC");		
	while($db=mysql_fetch_array($ergebnis)) {
		$ergebnis2 = safe_query("SELECT ID, name FROM ".PREFIX."cup_all_clans WHERE ID = '".$db['clanID']."' ORDER BY name ASC");		
		$dv=mysql_fetch_array($ergebnis2);

		if(is1on1($ID)){
			$dv['name'] = getnickname($db['clanID']);
			$dv['ID'] = $db['clanID'];
		}else{
			if(strlen($dv['name'])>10) {
				$dv['name'] = substr($dv['name'], 0, 10);
				$dv['name'] .= '..';
			}
		}
		$clan_select .= '<option value="'.$dv['ID'].'">'.$dv['name'].'</option>';
		$clan_select = str_replace(' selected', '', $clan_select);
	}
	$clan=array();
	for ($i=1; $i<260; $i++) {
			$clan[$i] = $clan_select;
	}
	$d = 1;
	for ($i=1; $i<128; $i++) {
		$matches = safe_query("SELECT clan1, clan2 FROM ".PREFIX."cup_matches WHERE cupID='$ID' && matchno='$i'");
		if(!mysql_num_rows($matches))
			$match[$i] = '<a href="javascript:alert(\'You must add both teams to register match.">(Match)</a>'; 
		else{
			while($db = mysql_fetch_array($matches)){
				$d2 = $d+1;
				$clan[$d] = str_replace('value="'.$db['clan1'].'"', 'value="'.$db['clan1'].'" selected', $clan[$d]);
				$clan[$d2] = str_replace('value="'.$db['clan2'].'"', 'value="'.$db['clan2'].'" selected', $clan[$d2]);
				if(!$db['clan1'] || !$db['clan2'])
					$match[$i] = '<a href="javascript:alert(\'Please add both Clans,  then the match will be registered.\')">(Match)</a>'; 
				elseif($db['clan1'] == 2147483647 || $db['clan2'] == 2147483647)
					$match[$i] = '<a href="javascript:alert(\'You cannot change or view a match with a Wildcard.\')">(Match)</a>'; 
				else
					$match[$i] = '<a href="matches.php?action=edit&match='.$i.'&cupID='.$ID.'" onClick="MM_openBrWindow(this.href,\'Edit Match\',\'toolbar=no,status=no,scrollbars=yes,width=800,height=600\');return false">(Match)</a>';
					$match[$i].= '<br><a href="admincenter.php?site=cups&action=delmatch&cupID='.$ID.'&match='.$i.'" onclick="return confirm(\'Are you sure you want to delete this match?\');">DEL <img src="../images/cup/error.png" width="16" height="16"></a>';
			}
		}		
		$d = $d+2;
	}



	$baum = safe_query("SELECT * FROM ".PREFIX."cup_baum WHERE cupID='".$ID."'");
	$db = mysql_fetch_array($baum);
	$clan['wb_winner'] = $clan_select;
	$clan['wb_winner'] = str_replace('value="'.$db['wb_winner'].'"', 'value="'.$db['wb_winner'].'" selected', $clan['wb_winner']);
	$clan['lb_winner'] = $clan_select;
	$clan['lb_winner'] = str_replace('value="'.$db['lb_winner'].'"', 'value="'.$db['lb_winner'].'" selected', $clan['lb_winner']);
	$clan['third_winner'] = $clan_select;
	$clan['third_winner'] = str_replace('value="'.$db['third_winner'].'"', 'value="'.$db['third_winner'].'" selected', $clan['third_winner']);
	
	echo '
	<link rel="stylesheet" href="color_picker/js_color_picker_v2.css" media="screen">

	<script type="text/javascript" src="color_picker/color_functions.js"></script>
	<script type="text/javascript" src="color_picker/js_color_picker_v2.js"></script>
	<form method="post" action="admincenter.php?site=cups&action=baum&ID='.$_GET['ID'].'" name="form_baum" id="form_baum">   
		     <table cellpadding="0" cellspacing="3">
			   <tr>
			     <td align="left">Border-color:</td>
				 <td><input type="text" name="borderbg" value="'.$db['borderbg'].'" id="input_border" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" /></td>
				 <td style="border: 1px solid #333333;" width="20" bgcolor="'.$db['borderbg'].'">&nbsp;</td>

				 <td><a href="#" onclick="showColorPicker(this,document.forms[0].borderbg)">[Colorpicker]</a></td>
			   </tr>
			   <tr>
			     <td align="left">Background1 (Clanname):</td>
				 <td><input type="text" name="bg1" value="'.$db['bg1'].'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
				 <td style="border: 1px solid #333333;" width="20" bgcolor="'.$db['bg1'].'">&nbsp;</td>
				 <td><a href="#" onclick="showColorPicker(this,document.forms[0].bg1)">[Colorpicker]</a></td>

			   </tr> 
			   <tr>
			     <td align="left">Background2 (Result):</td>
				 <td><input type="text" name="bg2" value="'.$db['bg2'].'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
				 <td style="border: 1px solid #000000;" width="20" bgcolor="'.$db['bg2'].'">&nbsp;</td>
				 <td><a href="#" onclick="showColorPicker(this,document.forms[0].bg2)">[Colorpicker]</a></td>
			   </tr>   
			   <tr>
			     <td colspan="4">&nbsp;</td>

			   </tr> 
			   <tr>
			     <td colspan="4" align="left"><b>Info: Only checked-in participants are shown.</b></td>
			   </tr>  			   
			   </table><br />';
		
	eval ("\$inctemp = \"".gettemplate($max)."\";");
	echo $inctemp;
}else{

  $query = safe_query("SELECT ID, platform FROM ".PREFIX."cup_platforms GROUP BY platform");
   if(!mysql_num_rows($query)) echo 'You must create at least one platform before you can create ladders. (<a href="admincenter.php?site=platforms&action=add">add platform</a>)';
   
  else{

	echo'<input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=cups&action=add\');return document.MM_returnValue" value="new Cup"> <input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=gameaccounts\');return document.MM_returnValue" value="Gameaccounts"><br><br>';

	$ergebnis=safe_query("SELECT * FROM ".PREFIX."cups ORDER BY ID DESC");
	$anz=mysql_num_rows($ergebnis);
	if($anz) {
   		echo'<form method="post" name="ws_cups" action="admincenter.php?site=cups"><table width="100%" cellpadding="4" cellspacing="1" bgcolor="#999999">
	       		<tr bgcolor="#CCCCCC">
		     		<td class="title" align="center">Cups:</td>

			 		<td class="title" align="center" colspan="4">Details:</td>
			 		<td class="title" align="center" colspan="3">Actions:</td>					
		   		</tr>
				<tr bgcolor="#ffffff">
				<td colspan="1">
				<td colspan="4">
				<td colspan="3">						
				</td>
				</tr>';
	
		while($ds=mysql_fetch_array($ergebnis)) {
			if(is1on1($ds['ID'])) {
				$cupinfo='(1on1)';
				$participants = 'Players';
			}else{
				$cupinfo= '('.$ds['typ'].')';
				$participants = 'Teams';
			}
			
			if($ds['gs_start'] || $ds['gs_end']) {
			      $gs_true = '<img src="../images/cup/icons/groups.png" align="right">';
			}
			else{
			      $gs_true = '';
			}
			
          	echo'<tr bgcolor="#FFFFFF">

		       		<td><img src="../images/games/'.$ds['game'].'.gif" width="13" height="13" border="0"> '.$gs_true.$ds['ID'].' - <a href="../?site=cups&action=details&cupID='.$ds['ID'].'" target="_blank">'.$ds['name'].'</a> '.$cupinfo.'</td>
		       		<td align="center"><input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=matches&cupID='.$ds['ID'].'&type=gs\');return document.MM_returnValue" value="GS Matches"></td>
			   		<td align="center"><input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=cups&action=baum&ID='.$ds['ID'].'\');return document.MM_returnValue" value="Brackets"></td>
                    <td align="center"><input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=teams&cupID='.$ds['ID'].'\');return document.MM_returnValue" value="'.$participants.'"></td>
			   		<td align="center"><input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=cups&action=admins&ID='.$ds['ID'].'\');return document.MM_returnValue" value="Admins"></td>					
					<td align="center"><input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=cups&action=rules&ID='.$ds['ID'].'\');return document.MM_returnValue" value="Rules"></td>
			   		<td align="center"><input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=cups&action=edit&ID='.$ds['ID'].'\');return document.MM_returnValue" value="Edit"</td>
			   		<td align="center"><input type="button" class="button" onClick="MM_confirm(\'Are you sure you want to delete this cup? This will also delete the tournament-tree, group stages, cup participants, cup matches and cup lineup\', \'admincenter.php?site=cups&delete=true&ID='.$ds[ID].'\')" value="Delete"></td>
			 	</tr>';		 	
		}
		echo'<tr bgcolor="#CCCCCC"></table></form>';
	}
	else echo'no cups available';
	}
  }		
?>	