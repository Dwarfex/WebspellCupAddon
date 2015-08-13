<?php
include ("../config.php");
?>

<head>

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
<link href="../cup.css" rel="stylesheet" type="text/css">
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<script language="javascript">wmtt = null; document.onmousemove = updateWMTT; function updateWMTT(e) { x = (document.all) ? window.event.x + document.body.scrollLeft : e.pageX; y = (document.all) ? window.event.y + document.body.scrollTop  : e.pageY; if (wmtt != null) { wmtt.style.left=(x + 20) + "px"; wmtt.style.top=(y + 20) + "px"; } } function showWMTT(id) {	wmtt = document.getElementById(id);	wmtt.style.display = "block" } function hideWMTT() { wmtt.style.display = "none"; }</script>
<script>function checkSel(obj) {
var ind = obj.selectedIndex;
if (ind == 1) { alert('Selecting "Open-Play Only" means all Challenging Configuration options below will be ignored.'); }
} 

function checkmode(obj) {
var ind = obj.selectedIndex;
if (ind == 2) { alert('Selecting "Position Exchange" will only work for - "Rank by: Credibility Only" (below)'); }
} 
</script>


</head>
<div class="tooltip1" id="cupt" align="left">(Only for team-ladders) If for example you enter in "2" and it is a 5on5 ladder, only 3 (5-2) members is required to be in the team prior to entering the ladder. If entered "0" and it is a 4on4 ladder then the team requires at least 4 members prior to entering the ladder.</div>
<div class="tooltip1" id="line" align="left">(Only for team-ladders) If for example you enter in "3" and it is a 4on4 ladder, only 1 (4-3) member is required to be in the team lineup prior to registration. If entered "0" and it is a 4on4 ladder then the team requires 4 members in the team lineup prior to registration.</div>
<div class="tooltip1" id="sign" align="left">Allow signups on both Sign-up phase and when Ladder has started until end.</div>
<div class="tooltip1" id="maxrounds" align="left"><li>If team 1 score + team 2 score does not equal maxrounds, the match report cannot be accepted. <br><br><li>If set to 15 for example, team A with score 9 must mean team B has score 6.</div>
<div class="tooltip1" id="mwee" align="left">Participant will play 3 matches if on All vs. All. Each match separated by how many days?</div>
<div class="tooltip1" id="qualify" align="left"><LI><b>Qualify by XP - Single Match</b><br> One match per participant, participants with most points go through.<br><br><LI><b>Qualify by XP - All. vs All</b><br> Every participant against every other participant in the group. Get most points from matches to go through.<br><br><b>Remember:</b> XP determination - set above.</div>
<div class="tooltip1" id="regtype" align="left"><LI><B>Randomized Group Registration</b><BR> At registration, enforce group. <br><br><li><b>Pick Group Registration</b><br>Users can pick what group to register in.</div>
<div class="tooltip1" id="af" align="left"><LI><b>Open ladder registration after group stages finish</b><br>After all group matches are confirmed, set ladder start time to <b>+<?php echo $league_begin; ?></b> day(s) ahead, group stage end to now and ladder end to <b>+<?php echo $league_end; ?></b> day(s) ahead. (change at config.php) <br><br><li><b>Change according to set start and end times</b> The start and end times won't be changed. <br><br><LI><b>Automatically move qualifiers</b> This option is currently set to <?php if($insert_qualifiers) echo '<b>enabled</b>'; else echo '<b>disabled</b>'; ?>. To <?php if(!$insert_qualifiers) echo 'enabled'; else echo 'disabled'; ?> change $insert_qualifiers at config.php</div>
<div class="tooltip1" id="d_xp" align="left"><LI><b>Win/Loss XP</b><br>All points gained from matches<br><br><LI><b>Win XP Only</b><br>Points gained from won-matches only</div>
<div class="tooltip1" id="ranksys" align="left"><LI> <b>Credibility Only</b> (config.php)<br> Start-Up Credits: <b><?php echo $startupcredit; ?></b><br> Win Credits: <b>+<?php echo $woncredit; ?></b><br> Lost Credits: <b>-<?php echo $lostcredit; ?></b><br> Draw Credits: <b>+<?php echo $drawcredit; ?></b><br> Forfeit-Loss: <b>-<?php echo $forfeitloss; ?></b><br> Forfeit-Award: <b>+<?php echo $forfeitaward; ?></b><br><br><LI> <b>XP Only</b> (points from matches) </div>
<div class="tooltip1" id="platform" align="left">What platform will you assign this ladder to?</div>
<div class="tooltip1" id="mappack" align="left">What mappack will you assign this ladder to?</div>
<div class="tooltip1" id="name" align="left">Name this ladder?</div>
<div class="tooltip1" id="abbrev" align="left">Abbreviation is for example CoD4 instead of Call of Duty 4</div>
<div class="tooltip1" id="game" align="left">What game will you assign this ladder to?</div>
<div class="tooltip1" id="gametype" align="left">Type in a gametype, if not applicable leave blank</div>
<div class="tooltip1" id="maxclan" align="left"><li>There is no limit for signups unless you enable group stages (below), if for example you select 64 for max signups, only 32 out of 64 participants can qualify and register in the ladder. <br><br><li>Without group league, infinite amount of signups allowed until the ladder starts OR ladder ends if "Sign-ups until end?" is selected.</div>
<div class="tooltip1" id="start" align="left">When will the ladder start? <br><br><li> To enable Signups, Signup phase must be selected below and the Start/End times must be in the future, passed the current time. <br><br><li> When the current time meets/exceeds the Start time, Signups are no longer accepted and the ladder starts UNLESS "Sign-ups until end?" is selected.</div>
<div class="tooltip1" id="end" align="left">When will ladder ladder end? <br><br><li> When the current time meets/exceeds the end time, winners are shown and ladder ends.</div>
<div class="tooltip1" id="gs_start" align="left">When will the group league start? <br><br><li> To set on Signups, Signup phase must be selected (above) and the Start time must be in the future, passed the current time.</div>
<div class="tooltip1" id="gs_end" align="left">When will the group league end? <br><br><li> The end time and start time of the ladder automatically adjusts as soon as all matches are confirmed.</div>
<div class="tooltip1" id="ratio" align="left"><li>If for example first box is 75% and second box is 100%, only participants with this score ratio or in between can enter. <br><br><li>Ratio is determined by win points divided by total points.</div>
<div class="tooltip1" id="mode" align="left"><b>#Half-way Up:</b><BR><LI>Win: moves half way up where looser is (above)<LI> Loose:  XX minus credibility<br><br><b>#Position Exchange:</b><BR><LI> Win: Takes looser place (above) <LI> Loss: Takes winner place (below)<br><br><b>#ELO Rating:</b><BR><LI> (find out it works at elo/example.php) <br><br><b>None:</b><BR><LI> Player only is ranked according to "Rank By.." (below)</div>
<div class="tooltip1" id="select_map" align="left">How many maps must the "challenged" user select?</div>
<div class="tooltip1" id="selected_map" align="left">How many maps must the "challenger" finalize? (this will be match rounds)</div>
<div class="tooltip1" id="select_date" align="left">How many dates/times can the "challenged" user select? The challenger must then accept one of those dates/times.</div>
<div class="tooltip1" id="timestart" align="left">This will show dates/times in dropdown from? <br><br><b>Examples:</b><LI> now <LI> 10 September 2000 <LI> +1 day <LI> +1 week <LI> +1 week 2 days 4 hours 2 seconds <LI> next Thursday<br><br>Not always a good idea to set it to "now" as the challenged user may select all dates/times for now and the challenger may not be around.</div>
<div class="tooltip1" id="timeintervals" align="left">Dates/times in dropdown, how far in between? If entering in custom, make sure it is in seconds.<br><br> <b>Example:</b><br><br> If you enter in "900" (seconds) which is 15 minutes, times/dropdowns will be as follow: <br>15:15<br>15:30<br>15:45 etc</div>
<div class="tooltip1" id="timeend" align="left">This will show dates/times in dropdown to?  <br><br><b>Examples:</b><LI> 10 September 2000 <LI> +1 day <LI> +1 week <LI> +1 week 2 days 4 hours 2 seconds <LI>next Thursday</div>
<div class="tooltip1" id="timetorespond" align="left">How long must the challenged user respond within? If entering in custom, make sure it is in seconds.</div>
<div class="tooltip1" id="timetofinalize" align="left">How long must the challenger finalize within? If entering in custom, make sure it is in seconds.</div>
<div class="tooltip1" id="challquant" align="left">How many challenges can be made for each user?</div>
<div class="tooltip1" id="status" align="left">What is the status of the ladder or group stages?</div>
<div class="tooltip1" id="challup" align="left">How many ranks a user can challenge above their rank? </div>
<div class="tooltip1" id="challdown" align="left">How many ranks a user can challenge below their rank?</div>
<div class="tooltip1" id="challallow" align="left"><li><b>Challenging Only</b> Use the automatic integrated challenging system only to initiate and report matches <li><b>Open-Play Only</b> Initiate matches on your own only - e.g. third party software to arrange matches etc. <li><b>Both</b> Use both ways to initiate matches</div>
<div class="tooltip1" id="playdays" align="left">What is the maximum amount of days participants must play and report their match after the match date before they are unable to?</div>
<div class="tooltip1" id="datereport" align="left"><li><b>Yes</b> User must report match on or after the gamedate <li><b>No</b> User can report anytime</div>
<div class="tooltip1" id="inactive_drop" align="left">How many inactive days before credibility is dropped ? E.g. if user has done no activity in 5 days, credibility is deducted. [Repeats]</div>
<div class="tooltip1" id="inactive_drop_credit" align="left">How many credits to be deducted if "Inactive Duration" is enabled above?</div>
<div class="tooltip1" id="inactive_remove" align="left">How many inactive days before user or team is unranked from the ladder?</div>
<div class="tooltip1" id="gs" align="left"><li>Group stages can be considered as a "pre-league" for a tournament or ladder, if you have for example a 32 size league, by activating group stages, 64 participants will be able to register and 32 out of the 64 competitors will qualify in the tournament or ladder. <br><br><li> Group stages can allow participants to select their own group or you can enforce randomized group registration. <br><br><li>Participants can qualify by going against a single participant or you can select "All vs. All" which will enforce participants to go against every other participant in their group. <br><br><li>After all matches are finished, all participants will receive a LEN "League Eligibility Notification" to confirm their qualifying status. On the groups page, it will also show their status which can be "Qualified", "Unqualified" or FCFS "First-Come-First-Serve". <br><br><li>Qualified are those that earned enough points or won enough matches to pass, unqualified are those that do not and FCFS are those participants that have "JUST" earned enough points or won enough matches, however their points or won matches are equal which means the first to join of the FCFS participants will secure their position in the tournament or ladder. FCFS participants can only join after all qualifiers have joined.</div>
<div class="tooltip1" id="desc" align="left">Add a description, rules are added separately after created.</div>
<div class="tooltip1" id="1on1" align="left">If singles, tick the box. If unticked, users must create their own team. (index.php?site=clans&action=clanadd)</div>
<div class="tooltip1" id="clan" align="left">Only clan members can enter the ladder if ticked. Clan members are assigned at (admincenter.php?site=users)</div>
<div class="tooltip1" id="gamb" align="left">Require the participant to have the associated gameaccount prior to entering the ladder? (gameaccount selection below)</div>
<div class="tooltip1" id="type" align="left">(Only for team ladders) What is the size? Type only in this format e.g. 4on4.</div>
<div class="tooltip1" id="gacc" align="left">If Gameaccount validation is enabled above, what gameaccount is required to be added prior to registration?</div>
<div class="tooltip1" id="1pri" align="left">If 1st prize, first prize to 1st winner?</div>
<div class="tooltip1" id="2pri" align="left">If 2nd prize, second prize to 2nd winner?</div>
<div class="tooltip1" id="3pri" align="left">If 3rd prize, third prize to 3rd winner?</div>
<div class="tooltip1" id="time" align="left">Individual ladders have their own timezone, if non is selected it will choose the default from cupsettings. </div>
<div class="tooltip1" id="agents" align="left">Free agents add themselves and teams are able to recruit them to this league.</div>
<div class="tooltip1" id="crerep" align="left">What is the minimum credit participant must have to report a match? Startup credits = <?php echo $startupcredit; ?></div>
<div class="tooltip1" id="crechall" align="left">What is the minimum credit participant must have to open a challenge? Startup credits = <?php echo $startupcredit; ?></div>
<div class="tooltip1" id="elo" align="left">If "ELO Rating" is selected (for  Rank By). Leave field(s) blank to set default value.</div>
<div class="tooltip1" id="elo_default" align="left">When a new player registers, this will be their new default ELO rating</div>
<div class="tooltip1" id="kfa_type" align="left"><b>Fixed:</b> K-Factor will be the same for every calculation. <br><br><b>Variable:</b> K-Factor will be different depending on current ELO rating of player.</div>
<div class="tooltip1" id="kfa_fixed" align="left">If "Fixed" is selected above, this K-Factor will be used in every calculation. (greater the factor, greater the difference in +/- points)</div>
<div class="tooltip1" id="kfa_bel" align="left">Set the K-Factor if player rating is below XX.</div>
<div class="tooltip1" id="kfa_bet" align="left">Set the K-Factor if player rating is in between XX and XX.</div>
<div class="tooltip1" id="kfa_abo" align="left">Set the K-Factor if player rating is above XX.</div>




<?php
//automated functions

getladtimezone();
match_query_type();

if(!iscupadmin($userID) OR substr(basename($_SERVER[REQUEST_URI]),0,15) != "admincenter.php") die('Access denied.');

if(isset($_POST['save'])) {
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
	
	$typ=($_POST['onecup'] ? '1on1' : $_POST['typ']);
    $timestart_array = array("now","+1 day","+1 week","+2 weeks","+4 weeks");
    $timeend_array = array("+1 day","+1 week","+2 weeks","+4 weeks","+2 months","+3 months","+6 months","+1 year",);
    $timeintervals_array = array("300","600","900","1800","2700","3600","7200","10800");
    $timetorespond_array = array("900","5400","7200","10800","18000","43200","86400","172800","259200","432000","604800","1209600","2419200","4838400");
    $timetofinalize_array = array("900","5400","7200","10800","18000","43200","86400","172800","259200","432000","604800","1209600","2419200","4838400");
    $challup_array = array("10","20","30","40","50","0");
    $challdown_array = array("No","10","20","30","40","50","0");
    $playdays_array = array("86400","259200","604800","1209600","1814400","0");
    $inactivity_array = array("0","86400","172800","259200","432000","604800","1209600","2419200","4838400");
    $deduct_credits_array = array("0","1","3","5","10");
    $remove_inactive_array = array("0","172800","259200","432000","604800","1209600","2419200","4838400");

    if(in_array($_POST['timestart'], $timestart_array)) $timestart = $_POST['timestart']; else $timestart = $_POST['ttimestart'];
    if(in_array($_POST['timeend'], $timeend_array))  $timeend = $_POST['timeend']; else $timeend = $_POST['ttimeend'];
    if(in_array($_POST['timeintervals'], $timeintervals_array))  $timeintervals = $_POST['timeintervals']; else $timeintervals = $_POST['ttimeintervals']; 
    if(in_array($_POST['timetorespond'], $timetorespond_array))  $timetorespond = $_POST['timetorespond']; else $timetorespond = $_POST['ttimetorespond'];  
    if(in_array($_POST['timetofinalize'], $timetofinalize_array))  $timetofinalize = $_POST['timetofinalize']; else $timetofinalize = $_POST['ttimetofinalize'];
    if(in_array($_POST['challup'], $challup_array)) $challup = $_POST['challup']; else $challup = $_POST['tchallup']; 
    if(in_array($_POST['challdown'], $challdown_array))  $challdown = $_POST['challdown']; else $challdown = $_POST['tchalldown']; 
    if(in_array($_POST['playdays'], $playdays_array))  $playdays = $_POST['playdays']; else $playdays = $_POST['tplaydays'];
    if(in_array($_POST['inactivity'], $inactivity_array)) $inactivity = $_POST['inactivity']; else $inactivity = $_POST['tinactivity']; 
    if(in_array($_POST['deduct_credits'], $deduct_credits_array))  $credit_deduction = $_POST['deduct_credits']; else $credit_deduction = $_POST['tdeduct_credits'];
    if(in_array($_POST['remove_inactive'], $remove_inactive_array))  $idler_remove = $_POST['remove_inactive']; else $idler_remove = $_POST['tremove_inactive'];
	
	$error = array();
	    
    if(empty($_POST['platID'])) $error[] = 'You have not selected a platform. <br> You can manage platforms <a href="admincenter.php?site=platforms" target="_blank">here</a>.';
    if(empty($_POST['typ']) && $_POST['onecup']==0) $error[] = 'You have not entered in a type. e.g. 1on1, 4on4';
    if(empty($_POST['name'])) $error[] = 'You have not entered in a ladder name';
    if(empty($_POST['abbrev'])) $error[] = 'You have not entered in a ladder abbreviation - e.g. CoD instead of Call of Duty';
    if($_POST['ratio_low'] > $_POST['ratio_high']) $error[]='Score ratio low can not be greater than score ratio high';
    if(empty($_POST['timestart'])) $error[] = 'You must enter in a value of Time Start.';
    if(empty($_POST['timeend'])) $error[] = 'You must enter in a value for Time End.';
    if($_POST['selected_map'] > $_POST['select_map']) $error[]='If the challenged user selects <b>'.$_POST['select_map'].'</b> maps, then how can the challenger finalize <b>'.$_POST['selected_map'].'</b> maps?<br> Go back and fix.';
    if($_POST['challquant'] == NULL) $error[]='You have not entered an amount for Challenge Quantity.';
	
    if(($gs_start) && $start <= $gs_start) 
	       $error[]='Group stage must start before tournament, set tournament start ahead of group-stage start or input zeros for group stage start and end to disable';
		   
    if(($gs_end) && $start < $gs_end) 
	       $error[]='Group stage must end before tournament starts, set tournament start ahead of group-stage end or input zeros for group stage start and end to disable';
		   
	//if($_POST['gs_trans']==1 && $gs_end) 
	//       $error[]='You have set "Open cup registration after group stages finish" which means there can be no group end time, leave this blank.';
	
	if($_POST['gs_maxrounds'] && !is_odd($_POST['gs_maxrounds'])) 
	       $error[]='Maxrounds must be an odd number so that draws are not supported.';
		   
    if($_POST['ratio_low'] > $_POST['ratio_high']) 
           $error[]='Score ratio low can not be greater than score ratio high.';
	
  	if(count($error)) { 
    	$list = implode('<br />&#8226; ', $error);
    	$showerror = '<div class="errorbox">
      	<b>Errors Occured:</b><br /><br />
      	&#8226; '.$list.'
    	</div>';
	}
	else {
    
	safe_query("INSERT INTO ".PREFIX."cup_ladders ( `platID`, `mappack`, `gameaccID`, `name`, `abbrev`, `game`, `desc`, gametype, maxclan, 
	                                                 start, end, gs_start, gs_end, ratio_low, ratio_high, type, mode, ranksys, 
	                                                 select_map, selected_map, select_date, timestart, timeintervals, timeend, 
	                                                 timetorespond, timetofinalize, challallow, challquant, inactivity, deduct_credits, 
	                                                 remove_inactive, playdays, ad_report, challup, challdown, status, 1on1, clanmembers, 
	                                                 gameacclimit, cgameacclimit, gs_maxrounds, gs_staging, gs_regtype, gs_trans, gs_mwe, d_xp, timezone, sign, cupgalimit, cupaclimit, agents, crechall, crerep,
													 kfa_type, kfa_fixed, kfa_bel, kfa_bet, kfa_abo, elo_bel, elo_bet1, elo_bet2, elo_abo) values 
	                                                 

													 
	                                       ('".$_POST['platID']."',
	                                        '".$_POST['mappack']."', 
	                                        '".$_POST['gameaccID']."',
	                                        '".$_POST['name']."', 
	                                        '".$_POST['abbrev']."', 
	                                        '".$_POST['game']."', 
	                                        '".$_POST['desc']."', 
	                                        '".$_POST['gametype']."', 
	                                        '".$_POST['maxclan']."', 
	                                        '$start', '$ende',
	                                        '$gs_start', '$gs_end', 
	                                        '".$_POST['ratio_low']."', 
	                                        '".$_POST['ratio_high']."', 
	                                        '".$typ."', 
	                                        '".$_POST['mode']."',  
	                                        '".$_POST['ranksys']."', 
	                                        '".$_POST['select_map']."', 
	                                        '".$_POST['selected_map']."', 
	                                        '".$_POST['select_date']."', 
	                                        '$timestart', 
	                                        '$timeintervals', 
	                                        '$timeend', 
	                                        '$timetorespond', 
	                                        '$timetofinalize', 
	                                        '".$_POST['challallow']."',
	                                        '".$_POST['challquant']."', 	                                        
	                                        '$inactivity',
	                                        '$credit_deduction',
	                                        '$idler_remove',
	                                        '$playdays',
	                                        '".$_POST['ad_report']."',
	                                        '$challup', '$challdown',	                                        
	                                        '".$_POST['status']."', 
	                                        '".$_POST['onecup']."', 
	                                        '".$_POST['clanmembers']."', 
	                                        '".$_POST['gameacclimit']."', 
	                                        '".$_POST['cgameacclimit']."',
	                                        '".$_POST['gs_maxrounds']."',
	                                        '".$_POST['gs_staging']."',
	                                        '".$_POST['gs_regtype']."',
	                                        '".$_POST['gs_trans']."',
											'".$_POST['gs_mwe']."',
	                                        '".$_POST['d_xp']."',
						                    '".$_POST['timezone']."',
											'".$_POST['sign']."',
											'".$_POST['cupgalimit']."',
											'".$_POST['cupaclimit']."',
											'".$_POST['agents']."',
											'".$_POST['crechall']."',
											'".$_POST['crerep']."',
											'".$_POST['kfa_type']."',
											'".$_POST['kfa_fixed']."',
											'".$_POST['kfa_bel']."',
											'".$_POST['kfa_bet']."',
											'".$_POST['kfa_abo']."',
											'".$_POST['elo_bel']."',
											'".$_POST['elo_bet1']."',
											'".$_POST['elo_bet2']."',
											'".$_POST['elo_abo']."')");				
    $laddID=mysql_insert_id();
	safe_query("INSERT INTO ".PREFIX."cup_rules SET value='', lastedit='', ladID='".$laddID."'");
	redirect("admincenter.php?site=ladders","<center><b>Ladder successfully created!</b></center>",2);
   }
   
}elseif($_GET['do']=='save') {



	safe_query("UPDATE ".PREFIX."cup_clans SET credit='".$_POST['credit']."' WHERE ladID='".$_POST['ladID']."' AND clanID='".$_POST['clanID']."'");	

//add or takeaway

if(ladderis1on1($_POST['ladID'])) 
  $ads=mysql_fetch_array(safe_query("SELECT won, draw, lost, streak, xp FROM ".PREFIX."cup_clans WHERE clanID='".$_POST['clanID']."' AND ladID='".$_POST['ladID']."' AND 1on1='1' AND checkin = '1'")); 
else
  $ads=mysql_fetch_array(safe_query("SELECT won, draw, lost, streak, xp FROM ".PREFIX."cup_clans WHERE clanID='".$_POST['clanID']."' AND ladID='".$_POST['ladID']."' AND 1on1='0' AND checkin = '1'"));

    $inc_xp=($_POST['plusminus_xp']=='1' ? $ads['xp']+$_POST['xp'] : $ads['xp']-$_POST['xp']);
    $inc_won=($_POST['plusminus_w']=='1' ? $ads['won']+$_POST['won'] : $ads['won']-$_POST['won']);
    $inc_draw=($_POST['plusminus_d']=='1' ? $ads['draw']+$_POST['draw'] : $ads['draw']-$_POST['draw']);
    $inc_lost=($_POST['plusminus_l']=='1' ? $ads['lost']+$_POST['lost'] : $ads['lost']-$_POST['lost']);
    //$inc_streak=($_POST['plusminus_s']=='1' ? getstreak($teamID,$laddID)+$_POST['streak'] : getstreak($teamID,$laddID)-$_POST['streak']);

	
//update standings
    safe_query("UPDATE ".PREFIX."cup_clans SET won='".$inc_won."', draw='".$inc_draw."', lost='".$inc_lost."', xp='".$inc_xp."' WHERE clanID='".$_POST['clanID']."' && ladID='".$_POST['ladID']."'");

	redirect('admincenter.php?site=ladders&action=standings&ID='.$_GET['ID'],'<div class="successbox"> Data successfully changed!</div>',2);
	
}elseif($_GET['do']=='reset') {

  if(isset($_GET['teamID'])) $teamID = $_GET['teamID'];
  else $teamID = false;
  reset_actual_standings($_GET['ID'],$teamID);
  
  redirect('admincenter.php?site=ladders&action=standings&ID='.$_GET['ID'],'<div class="successbox"> Stats successfully reverted!</div>',2);

}elseif($_POST['saveadmins']) {
	$laddID = $_POST['ladID'];
	$admins = $_POST['admins'];
	
    safe_query("DELETE FROM ".PREFIX."cup_admins WHERE ladID='$laddID'");
	if(is_array($admins)) {
		foreach($admins as $id) {
	        safe_query("INSERT INTO ".PREFIX."cup_admins (ladID, userID) values ('$laddID', '$id') ");
	    }
	}
}elseif($_POST['saverules']) {
	safe_query("UPDATE ".PREFIX."cup_rules SET value='".$_POST['value']."', lastedit='".time()."' WHERE ladID='".$_POST['ladID']."'");
}elseif(isset($_POST['saveedit'])) {
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
	
	$typ=($_POST['onecup'] ? '1on1' : $_POST['typ']);
    $timestart_array = array("now","+1 day","+1 week","+2 weeks","+4 weeks");
    $timeend_array = array("+1 day","+1 week","+2 weeks","+4 weeks","+2 months","+3 months","+6 months","+1 year",);
    $timeintervals_array = array("300","600","900","1800","2700","3600","7200","10800");
    $timetorespond_array = array("900","5400","7200","10800","18000","43200","86400","172800","259200","432000","604800","1209600","2419200","4838400");
    $timetofinalize_array = array("900","5400","7200","10800","18000","43200","86400","172800","259200","432000","604800","1209600","2419200","4838400");
    $challup_array = array("10","20","30","40","50","0");
    $challdown_array = array("No","10","20","30","40","50","0");
    $playdays_array = array("86400","259200","604800","1209600","1814400","0");
    $inactivity_array = array("0","86400","172800","259200","432000","604800","1209600","2419200","4838400");
    $deduct_credits_array = array("0","1","3","5","10");
    $remove_inactive_array = array("0","172800","259200","432000","604800","1209600","2419200","4838400");

    if(in_array($_POST['timestart'], $timestart_array)) $timestart = $_POST['timestart']; else $timestart = $_POST['ttimestart'];
    if(in_array($_POST['timeend'], $timeend_array))  $timeend = $_POST['timeend']; else $timeend = $_POST['ttimeend'];
    if(in_array($_POST['timeintervals'], $timeintervals_array))  $timeintervals = $_POST['timeintervals']; else $timeintervals = $_POST['ttimeintervals']; 
    if(in_array($_POST['timetorespond'], $timetorespond_array))  $timetorespond = $_POST['timetorespond']; else $timetorespond = $_POST['ttimetorespond'];  
    if(in_array($_POST['timetofinalize'], $timetofinalize_array))  $timetofinalize = $_POST['timetofinalize']; else $timetofinalize = $_POST['ttimetofinalize'];
    if(in_array($_POST['challup'], $challup_array)) $challup = $_POST['challup']; else $challup = $_POST['tchallup']; 
    if(in_array($_POST['challdown'], $challdown_array))  $challdown = $_POST['challdown']; else $challdown = $_POST['tchalldown']; 
    if(in_array($_POST['playdays'], $playdays_array))  $playdays = $_POST['playdays']; else $playdays = $_POST['tplaydays'];
    if(in_array($_POST['inactivity'], $inactivity_array)) $inactivity = $_POST['inactivity']; else $inactivity = $_POST['tinactivity']; 
    if(in_array($_POST['deduct_credits'], $deduct_credits_array))  $credit_deduction = $_POST['deduct_credits']; else $credit_deduction = $_POST['tdeduct_credits'];
    if(in_array($_POST['remove_inactive'], $remove_inactive_array))  $idler_remove = $_POST['remove_inactive']; else $idler_remove = $_POST['tremove_inactive'];

	$error = array();
	    
    if(empty($_POST['platID'])) $error[] = 'You have not selected a platform. <br> You can manage platforms <a href="admincenter.php?site=platforms" target="_blank">here</a>.';
    if(empty($_POST['typ']) && $_POST['onecup']==0) $error[] = 'You have not entered in a type. e.g. 1on1, 4on4';
    if(empty($_POST['name'])) $error[] = 'You have not entered in a ladder name';
    if(empty($_POST['abbrev'])) $error[] = 'You have not entered in a ladder abbreviation - e.g. CoD instead of Call of Duty';
    if($_POST['ratio_low'] > $_POST['ratio_high']) $error[]='Score ratio low can not be greater than score ratio high';
    if(empty($_POST['timestart'])) $error[] = 'You must enter in a value of Time Start.';
    if(empty($_POST['timeend'])) $error[] = 'You must enter in a value for Time End.';
    if($_POST['selected_map'] > $_POST['select_map']) $error[]='If the challenged user selects <b>'.$_POST['select_map'].'</b> maps, then how can the challenger finalize <b>'.$_POST['selected_map'].'</b> maps?<br> Go back and fix.';
    if($_POST['challquant'] == NULL) $error[]='You have not entered an amount for Challenge Quantity.';
	
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
    	$showerror = '<div class="errorbox">
      	<b>Errors Occured:</b><br /><br />
      	&#8226; '.$list.'
    	</div>';
	}
	else {
	
	safe_query("UPDATE ".PREFIX."cup_ladders SET `platID`='".$_POST['platID']."', 
	                                             `mappack`='".$_POST['mappack']."', 
	                                             `gameaccID`='".$_POST['gameacc']."', 
	                                             `name`='".$_POST['name']."', 
	                                             `abbrev`='".$_POST['abbrev']."', 
	                                             `game`='".$_POST['game']."', 
	                                             `desc`='".$_POST['desc']."', 
	                                             `gametype`='".$_POST['gametype']."', 
	                                              maxclan='".$_POST['maxclan']."', 
	                                              start='".$start."', end='".$ende."', 
	                                              gs_start='$gs_start', gs_end='$gs_end',  
	                                              ratio_low='".$_POST['ratio_low']."', 
	                                              ratio_high='".$_POST['ratio_high']."', 
	                                              type='".$typ."', 
	                                              mode='".$_POST['mode']."', 
	                                              ranksys='".$_POST['ranksys']."',  
	                                              select_map='".$_POST['select_map']."', 
	                                              selected_map='".$_POST['selected_map']."', 
	                                              select_date='".$_POST['select_date']."', 
	                                              timestart='$timestart', 
	                                              timeintervals='$timeintervals', 
	                                              timeend='$timeend', 
	                                              timetorespond='$timetorespond', 
	                                              timetofinalize='$timetofinalize', 
	                                              challallow='".$_POST['challallow']."',
	                                              challquant='".$_POST['challquant']."',
	                                              inactivity='$inactivity',
	                                              deduct_credits='$credit_deduction',
	                                              remove_inactive='$idler_remove',
	                                              playdays='$playdays',
	                                              ad_report='".$_POST['ad_report']."',
	                                              challup='$challup',
	                                              challdown='$challdown',
	                                              status='".$_POST['status']."', 
	                                              gewinn1='".$_POST['gewinn1']."', 
	                                              gewinn2='".$_POST['gewinn2']."', 
	                                              gewinn3='".$_POST['gewinn3']."',  
	                                              1on1='".$_POST['onecup']."',
	                                              clanmembers='".$_POST['clanmembers']."',
	                                              gameacclimit='".$_POST['gameacclimit']."',
	                                              cgameacclimit='".$_POST['cgameacclimit']."',
	                                              gs_maxrounds='".$_POST['gs_maxrounds']."',
												  gs_mwe='".$_POST['gs_mwe']."',
	                                              gs_staging='".$_POST['gs_staging']."',
	                                              gs_regtype='".$_POST['gs_regtype']."',
	                                              gs_trans='".$_POST['gs_trans']."',
	                                              d_xp='".$_POST['d_xp']."',
   						                          timezone='".$_POST['timezone']."',
												  sign='".$_POST['sign']."',
                                                  cupgalimit='".$_POST['cupgalimit']."',
                                                  cupaclimit='".$_POST['cupaclimit']."',
												  agents='".$_POST['agents']."',
  												  crechall='".$_POST['crechall']."',
												  crerep='".$_POST['crerep']."',
                                                  kfa_type='".$_POST['kfa_type']."',
                                                  kfa_fixed='".$_POST['kfa_fixed']."',
                                                  kfa_bel='".$_POST['kfa_bel']."',
                                                  kfa_bet='".$_POST['kfa_bet']."',
                                                  kfa_abo='".$_POST['kfa_abo']."',
                                                  elo_bel='".$_POST['elo_bel']."',
                                                  elo_bet1='".$_POST['elo_bet1']."',
                                                  elo_bet2='".$_POST['elo_bet2']."',
                                                  elo_abo='".$_POST['elo_abo']."' WHERE ID='".$_POST['ID']."'");  
	redirect("","<center><font color='red'><b>Ladder successfully edited!</b></font></center>",2);
   }
}elseif($_GET['delete']) {

       //delete: lad admins, groupstage participants, lad deductions, group matches, lad tickets, ladder, lad challenges,
       //lad participants, lad matches, lad rules, 

      $alpha_groups = "ladID='a' || ladID='b' || ladID='c' || ladID='d' || ladID='e' || ladID='f' || ladID='g' || ladID='h'";

       safe_query("DELETE FROM ".PREFIX."cup_clans WHERE groupID='".$_GET['ID']."' && ($alpha_groups) && cupID='0'");
       safe_query("DELETE FROM ".PREFIX."cup_deduction WHERE ladID='".$_GET['ID']."'");  
       safe_query("DELETE FROM ".PREFIX."cup_matches WHERE matchno='".$_GET['ID']."' && ($alpha_groups) && cupID='0'");
       safe_query("DELETE FROM ".PREFIX."cup_tickets WHERE ladID='".$_GET['ID']."'");
       safe_query("DELETE FROM ".PREFIX."cup_ladders WHERE ID='".$_GET['ID']."'");
       safe_query("DELETE FROM ".PREFIX."cup_challenges WHERE ladID='".$_GET['ID']."'");
       safe_query("DELETE FROM ".PREFIX."cup_clans WHERE ladID='".$_GET['ID']."'"); 
       safe_query("DELETE FROM ".PREFIX."cup_matches WHERE ladID='".$_GET['ID']."'"); 
       safe_query("DELETE FROM ".PREFIX."cup_rules WHERE ladID='".$_GET['ID']."'"); 
       safe_query("DELETE FROM ".PREFIX."cup_admins WHERE ladID='".$_GET['ID']."'"); 
	   safe_query("DELETE FROM ".PREFIX."cup_clan_lineup WHERE ladID='".$_GET['ID']."'");
	  redirect("admincenter.php?site=ladders","",0);

}

$gamesa=safe_query("SELECT tag, name FROM ".PREFIX."games ORDER BY name");
while($dv=mysql_fetch_array($gamesa)) {
		$games.='<option value="'.$dv['tag'].'">'.$dv['name'].'</option>';
}

if($_GET['action']=="duplicate") {

    $ladders = '<option selected value="">-- Select Ladder --</option>';
      $ladders_query = safe_query("SELECT ID  FROM ".PREFIX."cup_ladders");
        while($ds=mysql_fetch_array($ladders_query)) {
          $ladders.='<option value="'.$ds['ID'].'">('.$ds['ID'].') '.getladname($ds['ID']).'</option>';
        }
        
    echo '<select name="ID" onChange="MM_confirm(\'Are you sure you want to duplicate this ladder?\', \'admincenter.php?site=ladders&action=duplicate&duplicate=\'+this.value)">'.$ladders.'</select>';
       
  if($_GET['duplicate']) {
  
     $ds=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_ladders WHERE ID='".$_GET['duplicate']."'"));
     
     	safe_query("INSERT INTO ".PREFIX."cup_ladders ( `platID`, `mappack`, `gameaccID`, `name`, `abbrev`, `game`, `desc`, gametype, maxclan, 
	                                                 start, end, gs_start, gs_end, ratio_low, ratio_high, type, mode, ranksys, 
	                                                 select_map, selected_map, select_date, timestart, timeintervals, timeend, 
	                                                 timetorespond, timetofinalize, challallow, challquant, inactivity, deduct_credits, 
	                                                 remove_inactive, playdays, ad_report, challup, challdown, status, 1on1, clanmembers, 
	                                                 gameacclimit, cgameacclimit, gs_maxrounds, gs_mwe, gs_staging, gs_regtype, gs_trans, d_xp, timezone, sign, cupgalimit, cupaclimit, agents, crechall, crerep,
													 kfa_type, kfa_fixed, kfa_bel, kfa_bet, kfa_abo, elo_bel, elo_bet1, elo_bet2, elo_abo) values 
         
	                                       ('".$ds['platID']."',
	                                        '".$ds['mappack']."', 
	                                        '".$ds['gameaccID']."',
	                                        '".$ds['name']."', 
	                                        '".$ds['abbrev']."', 
	                                        '".$ds['game']."', 
	                                        '".$_POST['desc']."', 
	                                        '".$ds['gametype']."', 
	                                        '".$ds['maxclan']."', 
	                                        '".$ds['start']."',
	                                        '".$ds['end']."',
	                                        '".$ds['gs_start']."', 
	                                        '".$ds['gs_end']."',
	                                        '".$ds['ratio_low']."', 
	                                        '".$ds['ratio_high']."', 
	                                        '".$ds['type']."',
	                                        '".$ds['mode']."',  
	                                        '".$ds['ranksys']."', 
	                                        '".$ds['select_map']."', 
	                                        '".$ds['selected_map']."', 
	                                        '".$ds['select_date']."', 
	                                        '".$ds['timestart']."',
	                                        '".$ds['timeintervals']."', 
	                                        '".$ds['timeend']."',
	                                        '".$ds['timetorespond']."',
	                                        '".$ds['timetofinalize']."', 
	                                        '".$ds['challallow']."',
	                                        '".$ds['challquant']."', 	                                        
	                                        '".$ds['inactivity']."',
	                                        '".$ds['deduct_credits']."',
	                                        '".$ds['remove_inactive']."',
	                                        '".$ds['playdays']."',
	                                        '".$ds['ad_report']."',
	                                        '".$ds['challup']."',
	                                        '".$ds['challdown']."',	                                        
	                                        '".$ds['status']."', 
	                                        '".$ds['1on1']."', 
	                                        '".$ds['clanmembers']."', 
	                                        '".$ds['gameacclimit']."', 
	                                        '".$ds['cgameacclimit']."',
	                                        '".$ds['gs_maxrounds']."',
											'".$ds['gs_mwe']."',
	                                        '".$ds['gs_staging']."',
	                                        '".$ds['gs_regtype']."',
	                                        '".$ds['gs_trans']."',
											'".$ds['d_xp']."',
											'".$ds['timezone']."',
											'".$ds['sign']."',
											'".$ds['cupgalimit']."',
											'".$ds['cupaclimit']."',
											'".$ds['agents']."',
											'".$ds['crechall']."',
											'".$sd['crerep']."',
											'".$ds['kfa_type']."',
											'".$ds['kfa_fixed']."',
											'".$ds['kfa_bel']."',
											'".$ds['kfa_bet']."',
											'".$ds['kfa_abo']."',
											'".$ds['elo_bel']."',
											'".$ds['elo_bet1']."',
											'".$ds['elo_bet2']."',
											'".$ds['elo_abo']."')");									
											
    $laddID=mysql_insert_id();
	safe_query("INSERT INTO ".PREFIX."cup_rules SET value='', lastedit='', ladID='".$laddID."'");
	redirect("admincenter.php?site=ladders","<center><b>Ladder successfully duplicated!</b></center>",2);
     
  }   

}elseif($_GET['action']=="add") {

echo'<h2>Ladder</h2>';

	$ergebnis=safe_query("SELECT * FROM ".PREFIX."gameacc ORDER BY type");
	while($ds=mysql_fetch_array($ergebnis)) {
		$gameaccs.='<option value="'.$ds['gameaccID'].'">'.$ds['type'].'</option>';
	}	
	
  $query = safe_query("SELECT * FROM ".PREFIX."cup_platforms");
    $num_platforms = mysql_num_rows($query);
      while($pt = mysql_fetch_array($query)) {
         $platforms.='<option value="'.$pt['ID'].'">'.$pt['name'].' ('.$pt['platform'].')</option>';
     }
     
  $query = safe_query("SELECT * FROM ".PREFIX."cup_maps GROUP BY mappack ORDER BY mappack");
    $num_mappacks = mysql_num_rows($query);
      while($mp=mysql_fetch_array($query)) {
         $mappack.='<option value="'.$mp['mappack'].'">'.$mp['mappack'].'</option>';
	}
     
  if(!$num_platforms)
      die('You must create at least one platform before you can create ladders.');
  if(!$num_mappacks)
      die('You must create at least one mappack before you can create ladders. (<a href="admincenter.php?site=cupmaps&action=create">create mappack</a>)'); 
     
/* SAVE POST */

    $timestart_array = array("now","+1 day","+1 week","+2 weeks","+4 weeks");
    $timeend_array = array("+1 day","+1 week","+2 weeks","+4 weeks","+2 months","+3 months","+6 months","+1 year",);
    $timeintervals_array = array("300","600","900","1800","2700","3600","7200","10800");
    $timetorespond_array = array("900","5400","7200","10800","18000","43200","86400","172800","259200","432000","604800","1209600","2419200","4838400");
    $timetofinalize_array = array("900","5400","7200","10800","18000","43200","86400","172800","259200","432000","604800","1209600","2419200","4838400");
    $challup_array = array("10","20","30","40","50","0");
    $challdown_array = array("No","10","20","30","40","50","0");
    $playdays_array = array("86400","259200","604800","1209600","1814400","0");
    $inactivity_array = array("0","86400","172800","259200","432000","604800","1209600","2419200","4838400");
    $deduct_credits_array = array("0","1","3","5","10");
    $remove_inactive_array = array("0","172800","259200","432000","604800","1209600","2419200","4838400");

    if(in_array($_POST['timestart'], $timestart_array) OR empty($_POST['timestart'])) $ourinput4 = 'display: none'; else $ourinput4 = '';
    if(in_array($_POST['timeend'], $timeend_array) OR empty($_POST['timeend'])) $ourinput5 = 'display: none'; else $ourinput5 = '';
    if(in_array($_POST['timeintervals'], $timeintervals_array) OR empty($_POST['timeintervals']))  $ourinput6 = 'display: none'; else $ourinput6 = '';
    if(in_array($_POST['timetorespond'], $timetorespond_array) OR empty($_POST['timetorespond']))  $ourinput7 = 'display: none'; else $ourinput7 = '';
    if(in_array($_POST['timetofinalize'], $timetofinalize_array) OR empty($_POST['timetofinalize']))  $ourinput8 = 'display: none'; else $ourinput8 = '';
    if(in_array($_POST['challup'], $challup_array) OR empty($_POST['challup']))  $ourinput9 = 'display: none'; else $ourinput9 = '';
    if(in_array($_POST['challdown'], $challdown_array) OR empty($_POST['challdown']))  $ourinput10 = 'display: none'; else $ourinput10 = '';
    if(in_array($_POST['playdays'], $playdays_array) OR empty($_POST['playdays']))  $ourinput11 = 'display: none'; else $ourinput11 = '';
    if(in_array($_POST['inactivity'], $inactivity_array) OR empty($_POST['inactivity']))  $ourinput12 = 'display: none'; else $ourinput12 = '';
    if(in_array($_POST['deduct_credits'], $deduct_credits_array) OR empty($_POST['deduct_credits']))  $ourinput14 = 'display: none'; else $ourinput14 = '';
    if(in_array($_POST['remove_inactive'], $remove_inactive_array) OR empty($_POST['remove_inactive']))  $ourinput13 = 'display: none'; else $ourinput13 = '';
 
	$gameaccs=str_replace(' selected', '', $gameaccs);
	$gameaccs=str_replace('value="'.$_POST['gameacc'].'"', 'value="'.$_POST['gameacc'].'" selected', $gameaccs);
 
	$games=str_replace(' selected', '', $games);
	$games=str_replace('value="'.$_POST['game'].'"', 'value="'.$_POST['game'].'" selected', $games);
	
	$platforms=str_replace(' selected', '', $platforms);
	$platforms=str_replace('value="'.$_POST['platID'].'"', 'value="'.$_POST['platID'].'" selected', $platforms);
	
	$mappack=str_replace(' selected', '', $mappack);
	$mappack=str_replace('value="'.$_POST['mappack'].'"', 'value="'.$_POST['mappack'].'" selected', $mappack);		
	
	$infsignups='<option value="0">No</option><option value="1">Yes</option>';
	$infsignups=str_replace(' selected', '', $infsignups);
	$infsignups=str_replace('value="'.$_POST['sign'].'"', 'value="'.$_POST['sign'].'" selected', $infsignups);
	
	$maxsignups='<option value="8">16</option><option value="16">32</option><option value="32">64</option><option value="64">128</option>';
	$maxsignups=str_replace(' selected', '', $maxsignups);
	$maxsignups=str_replace('value="'.$_POST['maxclan'].'"', 'value="'.$_POST['maxclan'].'" selected', $maxsignups);
	
	$dd_select_map='<option value="1">1 Map</option><option value="2">2 Maps</option><option value="3">3 Maps</option><option value="4">4 Maps</option><option value="5">5 Maps</option>';
	$dd_select_map=str_replace(' selected', '', $dd_select_map);
	$dd_select_map=str_replace('value="'.$_POST['select_map'].'"', 'value="'.$_POST['select_map'].'" selected', $dd_select_map);
	
	$dd_selected_map='<option value="1">1 Map</option><option value="2">2 Maps</option><option value="3">3 Maps</option><option value="4">4 Maps</option>';
	$dd_selected_map=str_replace(' selected', '', $dd_selected_map);
	$dd_selected_map=str_replace('value="'.$_POST['selected_map'].'"', 'value="'.$_POST['selected_map'].'" selected', $dd_selected_map);
	
	$dd_select_date='<option value="1">1 Date</option><option value="2">2 Dates</option><option value="3">3 Dates</option><option value="4">4 Dates</option><option value="5">5 Dates</option>';
	$dd_select_date=str_replace(' selected', '', $dd_select_date);
	$dd_select_date=str_replace('value="'.$_POST['select_date'].'"', 'value="'.$_POST['select_date'].'" selected', $dd_select_date);
					
	$dd_time_start='<optgroup label="Recommended"><option value="+1 day" >+1 Day</option><optgroup label="OR Select"><option value="now">Now</option><option value="+1 day">+1 Day</option><option value="+1 week">+1 Week</option><option value="+2 weeks">+2 Weeks</option><option value="+4 weeks">+1 Month</option><option value="custom4">Custom Seconds</option>';
	$dd_time_start=str_replace(' selected', '', $dd_time_start);
	$dd_time_start=str_replace('value="'.$_POST['timestart'].'"', 'value="'.$_POST['timestart'].'" selected', $dd_time_start);
   
	$dd_time_end='<optgroup label="Recommended"><option value="+1 week">+1 Week</option><optgroup label="OR Select"><option value="+1 day">+1 Day</option><option value="+1 week">+1 Week</option><option value="+2 weeks">+2 Weeks</option><option value="+4 weeks">+1 Month</option><option value="+2 months">+2 Months</option><option value="+3 months">+3 Months</option><option value="+6 months">+6 Months</option><option value="+1 year">+1 Year</option><option value="custom5">Custom Seconds</option>';
	$dd_time_end=str_replace(' selected', '', $dd_time_end);
	$dd_time_end=str_replace('value="'.$_POST['timeend'].'"', 'value="'.$_POST['timeend'].'" selected', $dd_time_end);
	
	$dd_time_intervals='<optgroup label="Recommended"><option value="900">15 Minutes</option><optgroup label="OR Select"><option value="300">5 Minutes</option><option value="600">10 Minutes</option><option value="900">15 Minutes</option><option value="1800">30 Minutes</option><option value="2700">45 Minutes</option><option value="3600">1 Hour</option><option value="7200">2 Hours</option><option value="10800">3 Hours</option><option value="custom6">Custom Seconds</option>';
	$dd_time_intervals=str_replace(' selected', '', $dd_time_intervals);
	$dd_time_intervals=str_replace('value="'.$_POST['timeintervals'].'"', 'value="'.$_POST['timeintervals'].'" selected', $dd_time_intervals);
	
	$dd_time_respond='<optgroup label="Recommended"><option value="259200">3 Days</option><optgroup label="OR Select"><option value="3600">1 Hour</option><option value="5400">1hr 30 Mins</option><option value="7200">2 Hours</option><option value="10800">3 Hours</option><option value="18000">5 Hours</option><option value="43200">12 Hours</option><option value="86400">1 Day</option><option value="172800">2 Days</option><option value="259200">3 Days</option><option value="432000">5 Days</option><option value="604800">1 Week</option><option value="1209600">2 Weeks</option><option value="2419200">1 Month</option><option value="4838400">2 Months</option><option value="custom7">Custom Seconds</option>';
	$dd_time_respond=str_replace(' selected', '', $dd_time_respond);
	$dd_time_respond=str_replace('value="'.$_POST['timetorespond'].'"', 'value="'.$_POST['timetorespond'].'" selected', $dd_time_respond);
	
	$dd_time_finalize='<optgroup label="Recommended"><option value="259200">3 Days</option><optgroup label="OR Select"><option value="3600">1 Hour</option><option value="5400">1hr 30 Mins</option><option value="7200">2 Hours</option><option value="10800">3 Hours</option><option value="18000">5 Hours</option><option value="43200">12 Hours</option><option value="86400">1 Day</option><option value="172800">2 Days</option><option value="259200">3 Days</option><option value="432000">5 Days</option><option value="604800">1 Week</option><option value="1209600">2 Weeks</option><option value="2419200">1 Month</option><option value="4838400">2 Months</option><option value="custom8">Custom Seconds</option>';
	$dd_time_finalize=str_replace(' selected', '', $dd_time_finalize);
	$dd_time_finalize=str_replace('value="'.$_POST['timetofinalize'].'"', 'value="'.$_POST['timetofinalize'].'" selected', $dd_time_finalize);
	
	$dd_signup='<option value="1">Signup phase</option><option value="2">Started</option><option value="3">Closed</option>';
	$dd_signup=str_replace(' selected', '', $dd_signup);
	$dd_signup=str_replace('value="'.$_POST['status'].'"', 'value="'.$_POST['status'].'" selected', $dd_signup);
	
	$dd_challup='<option value="10">10 Ranks</option><option value="20">20 Ranks</option><option value="30">30 Ranks</option><option value="40">40 Ranks</option><option value="50">50 Ranks</option><option value="custom9">Custom Seconds</option><option value="0">Any Rank</option>';
	$dd_challup=str_replace(' selected', '', $dd_challup);
	$dd_challup=str_replace('value="'.$_POST['challup'].'"', 'value="'.$_POST['challup'].'" selected', $dd_challup);
	
	$dd_challdown='<option value="No">No</option><option value="10">10 Ranks</option><option value="20">20 Ranks</option><option value="30">30 Ranks</option><option value="40">40 Ranks</option><option value="50">50 Ranks</option><option value="custom10">Custom Seconds</option><option value="0">Any Rank</option>';
	$dd_challdown=str_replace(' selected', '', $dd_challdown);
	$dd_challdown=str_replace('value="'.$_POST['challdown'].'"', 'value="'.$_POST['challdown'].'" selected', $dd_challdown);
	
	$dd_challallow='<option value="0">Challenging Only</option><option value="1">Open-Play Only</option><option value="2">Both</option>';
	$dd_challallow=str_replace(' selected', '', $dd_challallow);
	$dd_challallow=str_replace('value="'.$_POST['challallow'].'"', 'value="'.$_POST['challallow'].'" selected', $dd_challallow);
	
	$dd_mode='<option value="1">#Half-Way Up</option><option value="2">#Position Exchange</option><option value="3">#ELO Rating</option><option value="0">None</option>';
	$dd_mode=str_replace(' selected', '', $dd_mode);
	$dd_mode=str_replace('value="'.$_POST['mode'].'"', 'value="'.$_POST['mode'].'" selected', $dd_mode);
	
	$dd_ranksys='<option value="7">ELO Rating</option><option value="1">Credibility Only</option><option value="2">XP Only</option><option value="3">Won Matches</option><option value="4">XP & Credibility</option><option value="5">Won Matches & Credibility</option><option value="6">Streak</option>';
	$dd_ranksys=str_replace(' selected', '', $dd_ranksys);
	$dd_ranksys=str_replace('value="'.$_POST['ranksys'].'"', 'value="'.$_POST['ranksys'].'" selected', $dd_ranksys);
	
	$dd_dxp='<option value="1">Win XP Only</option><option value="0">Win/Loss XP</option>';
	$dd_dxp=str_replace(' selected', '', $dd_dxp);
	$dd_dxp=str_replace('value="'.$_POST['d_xp'].'"', 'value="'.$_POST['d_xp'].'" selected', $dd_dxp);
	
	$dd_date_report='<option value="1">Yes</option><option value="0">No</option>';
	$dd_date_report=str_replace(' selected', '', $dd_date_report);
	$dd_date_report=str_replace('value="'.$_POST['ad_report'].'"', 'value="'.$_POST['ad_report'].'" selected', $dd_date_report);
	
	$dd_playdays='<option value="86400">1 Day</option><option value="259200">3 Days</option><option value="604800">1 Week</option><option value="1209600">2 Weeks</option><option value="1814400">3 Weeks</option><option value="custom11">Custom Seconds</option><option value="0">Any Day</option>';
	$dd_playdays=str_replace(' selected', '', $dd_playdays);
	$dd_playdays=str_replace('value="'.$_POST['playdays'].'"', 'value="'.$_POST['playdays'].'" selected', $dd_playdays);
	
	$dd_droptime='<option value="0">Disable</option><option value="86400">1 Day</option><option value="172800">2 Days</option><option value="259200">3 Days</option><option value="432000">5 Days</option><option value="604800">1 Week</option><option value="1209600">2 Weeks</option><option value="2419200">1 Month</option><option value="4838400">2 Months</option><option value="custom12">Custom Seconds</option>';
	$dd_droptime=str_replace(' selected', '', $dd_droptime);
	$dd_droptime=str_replace('value="'.$_POST['inactivity'].'"', 'value="'.$_POST['inactivity'].'" selected', $dd_droptime);
	
	$dd_remove_inactive='<option value="0">Disable</option><option value="172800">2 Days</option><option value="259200">3 Days</option><option value="432000">5 Days</option><option value="604800">1 Week</option><option value="1209600">2 Weeks</option><option value="2419200">1 Month</option><option value="4838400">2 Months</option><option value="custom13">Custom Seconds</option>';
	$dd_remove_inactive=str_replace(' selected', '', $dd_remove_inactive);
	$dd_remove_inactive=str_replace('value="'.$_POST['remove_inactive'].'"', 'value="'.$_POST['remove_inactive'].'" selected', $dd_remove_inactive);
	
	$dd_dropcredit='<option value="0">Disable</option><option value="1">1 Credit</option><option value="3">3 Credits</option><option value="5">5 Credits</option><option value="10">10 Credits</option><option value="custom14">Custom Credits</option>';
	$dd_dropcredit=str_replace(' selected', '', $dd_dropcredit);
	$dd_dropcredit=str_replace('value="'.$_POST['deduct_credits'].'"', 'value="'.$_POST['deduct_credits'].'" selected', $dd_dropcredit);

	$dd_passing='<option value="0">Win first match</option><option value="2">Qualify by XP - Single Match</option><option value="1">Qualify by XP - All vs. All</option>';
	$dd_passing=str_replace(' selected', '', $dd_passing);
	$dd_passing=str_replace('value="'.$_POST['gs_staging'].'"', 'value="'.$_POST['gs_staging'].'" selected', $dd_passing);
	
	$dd_kfactor='<option value="0">Fixed</option><option value="1">Variable</option>';
	$dd_kfactor=str_replace(' selected', '', $dd_kfactor);
	$dd_kfactor=str_replace('value="'.$_POST['kfa_type'].'"', 'value="'.$_POST['kfa_type'].'" selected', $dd_kfactor);
	
	$dd_regtype='<option value="0">Randomized Group Registration</option><option value="1">Pick Group Registration</option>';
	$dd_regtype=str_replace(' selected', '', $dd_regtype);
	$dd_regtype=str_replace('value="'.$_POST['gs_regtype'].'"', 'value="'.$_POST['gs_regtype'].'" selected', $dd_regtype);

	$dd_trans='<option value="1">Open cup registration after group stages finish</option><option value="0">Change according to set start and end times</option>';
	$dd_trans=str_replace(' selected', '', $dd_trans);
	$dd_trans=str_replace('value="'.$_POST['gs_trans'].'"', 'value="'.$_POST['gs_trans'].'" selected', $dd_trans);

	if($_POST['onecup']){
		$onecup='checked';
		$discup='disabled';
		$typcup='1on1';
	}
	
	if($_POST['clanmembers']) 
		$clanmem='checked';
		
	if($_POST['agents']) 
		$agents='checked';
	
	if($_POST['gameacclimit']) 
		$gvalidbackup='checked';
	
	if($_POST['cgameacclimit']) 
		$gvalidcheckin='checked';
		
    //ladder	
		
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
	
	//elo
	
	$kfactor_fixed = !$_POST['kfa_fixed'] ? $kfactor_fixed : $_POST['kfa_fixed'];
	
	$elo_below_k = !$_POST['kfa_bel'] ? $kfactor_below : $_POST['kfa_bel'];
	$elo_below_e = !$_POST['elo_bel'] ? $elo_below : $_POST['elo_bel'];
	
	$elo_between_k = !$_POST['kfa_bet'] ? $kfactor_between : $_POST['kfa_bet'];
	$elo_between_e1= !$_POST['elo_bet1'] ? $elo_between_start : $_POST['elo_bet1'];
	$elo_between_e2= !$_POST['elo_bet2'] ? $elo_between_end : $_POST['elo_bet2'];
	
	$elo_above_k = !$_POST['kfa_abo'] ? $kfactor_above : $_POST['kfa_abo'];
	$elo_above_e = !$_POST['elo_abo'] ? $elo_above : $_POST['elo_abo'];
	
//if error

  echo $showerror;
  
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
  
    echo '<form method="post" action="admincenter.php?site=ladders&action=add" name="cup">
			<table id="table2" cellpadding="6" cellspacing="0">
				<tr>
					<td></td>
				</tr>
				<tr>
					<td class="title" colspan="2" align="center"><b>Ladder Configuration</b></td>
				</tr>
				<tr>
					<td></td>
				</tr>
				<tr>
					<td><a name="name" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'name\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Name:</td>
					<td><input type="text" name="name" value="'.$_POST['name'].'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
				</tr>
				<tr>
					<td><a name="abbrev" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'abbrev\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Abbreviation:</td>
					<td><input type="text" name="abbrev" size="10" value="'.$_POST['abbrev'].'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
				</tr>	
				<tr>
					<td><a name="platform" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'platform\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Platform:</td>
					<td><select name="platID">'.$platforms.'</select> (<a href="admincenter.php?site=platforms" target="_blank">manage platforms</a>)</td>
				</tr>
               <tr>
                    <td><a name="mappack" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'mappack\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Mappack:</td>
                    <td><select name="mappack">'.$mappack.'</select> (<a href="admincenter.php?site=cupmaps" target="_blank">manage mappacks</a>)</td>
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
					<td><a name="gamb" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'gamb\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Gameaccount Validation?:</td>
					<td><input type="checkbox" name="cgameacclimit" value="1" '.$gvalidcheckin.'></td>
				</tr>
				<tr>
					<td><a name="type" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'type\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Type:</td>
					<td><input type="text" name="typ" size="5" value="'.$typcup.'" '.$discup.' class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> XonX</td>
				</tr>
				<tr>
					<td><a name="line" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'line\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Lineup/Ladder type -</td>
					<td><input value="'.$_POST['cupaclimit'].'" type="text" name="cupaclimit" size="3" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> Member Count (checkin)</td>
				</tr>
				<tr>
					<td><a name="ranksys" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'ranksys\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Rank By?:</td>
					<td><select name="ranksys">'.$dd_ranksys.'</select></td>
				</tr>
				<tr>
					<td><a name="d_xp" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'d_xp\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Determine XP By?:</td>
					<td><select name="d_xp">'.$dd_dxp.'</select></td>
				</tr>
				<tr>
					<td><a name="gametype" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'gametype\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Gametype:</td>
					<td><input type="text" name="gametype" value="'.$_POST['gametype'].'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
				</tr>
				<tr>
					<td><a name="sign" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'sign\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Sign-ups until end?</td>
					<td><select name="sign">'.$infsignups.'</select></td>
				</tr>
				<tr>
					<td><a name="maxclan" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'maxclan\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Max. Signups:</td>
					<td><select name="maxclan">'.$maxsignups.'</select> (only for groups)</td>
				</tr>
				<tr>
					<td><a name="start" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'start\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Ladder Start:</td>
					<td><input name="s_day" type="text" size="2" value="'.$lsd.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">.<input name="s_month" type="text" size="2" value="'.$lsw.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">.<input name="s_year" type="text" size="4" value="'.$lsy.'" maxlength="4" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> (dd.mm.yyyy) at <input name="s_hour" type="text" size="2" value="'.$lsh.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">:<input name="s_min" type="text" size="2" value="'.$lsm.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
				</tr>
				<tr>
					<td><a name="end" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'end\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Ladder End:</td>
					<td><input name="e_day" value="'.$led.'" maxlength="2" type="text" size="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">.<input name="e_month" type="text" size="2" value="'.$lew.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">.<input name="e_year" type="text" size="4" value="'.$ley.'" maxlength="4" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> (dd.mm.yyyy) at <input name="e_hour" type="text" size="2" value="'.$leh.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">:<input name="e_min" type="text" size="2" value="'.$lem.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
				</tr>
				<tr>
					<td><a name="inactive_drop" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'inactive_drop\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Inactive Duration:</td>
					<td><select name="inactivity" id="ourinput12">'.$dd_droptime.'</select><input id="custom12" style="'.$ourinput12.'" value="'.$_POST['tinactivity'].'" type="text" name="tinactivity" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"/></td>
				</tr>
				<tr>
					<td><a name="inactive_drop_credit" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'inactive_drop_credit\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Deduct Credits:</td>
					<td><select name="deduct_credits" id="ourinput14">'.$dd_dropcredit.'</select><input id="custom14" style="'.$ourinput14.'" value="'.$_POST['tdeduct_credits'].'" type="text" name="tdeduct_credits" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"/> <i>(repeats)</i></td>
				</tr>
				<tr>
					<td><a name="inactive_remove" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'inactive_remove\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Remove Inactive:</td>
					<td><select name="remove_inactive" id="ourinput13">'.$dd_remove_inactive.'</select><input id="custom13" style="'.$ourinput13.'"  value="'.$_POST['tremove_inactive'].'" type="text" name="tremove_inactive" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"/></td>
				</tr>
				<tr>
					<td><a name="ratio" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'ratio\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Ratio:</td>
					<td><input type="text" name="ratio_low" value="'.$_POST['ratio_low'].'" size="3" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">% - <input type="text" name="ratio_high" value="'.$_POST['ratio_high'].'" size="3" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">% Skill comptence level by score ratio (0 for both = disable)</td>
				</tr>
				<tr>
					<td><a name="gacc" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'gacc\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Gameaccount:</td>
					<td><select name="gameacc">'.$gameaccs.'</select></td>
				</tr>
				<tr>
					<td><a name="status" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'status\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Status:</td>
					<td><select name="status">'.$dd_signup.'</select></td>
				</tr>
				<tr>
					<td><a name="time" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'time\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Timezone:</td>
					<td><select name="timezone">'.$timezones.'</select></td>
				</tr>
				<tr>
					<td></td>
				</tr>
				<tr>
					<td class="title" colspan="2" align="center"><b>Challenge Configuration</b> (a custom value for time is measured in seconds)</td>
				</tr>
				<tr>
					<td></td>
				</tr>
				<tr>
					<td><a name="challallow" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'challallow\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Allow Challenging?:</td>
					<td><select name="challallow" onChange="checkSel(this);">'.$dd_challallow.'</select></td>
				</tr>
				<tr>
					<td><a name="crechall" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'crechall\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Credits to Challenge?:</td>
					<td><input type="text" value="'.$_POST['crechall'].'" name="crechall" size="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> (0 to disable)</td>
				</tr>
				<tr>
					<td><a name="crerep" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'crerep\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Credits to Report?:</td>
					<td><input type="text" value="'.$_POST['crerep'].'" name="crerep" size="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> (0 to disable)</td>
				</tr>
				<tr>
					<td><a name="select_map" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'select_map\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Select-Map:</td>
					<td><select name="select_map">'.$dd_select_map.'</select></td>
				</tr>
				<tr>
					<td><a name="selected_map" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'selected_map\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Selected-Map:</td>
					<td><select name="selected_map">'.$dd_selected_map.'</select></td>
				</tr>		
				<tr>
					<td><a name="select_date" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'select_date\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Select-Date:</td>
					<td><select name="select_date">'.$dd_select_date.'</select></td>
				</tr>
				<tr>
					<td><a name="timestart" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'timestart\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Time Start:</td>
					<td><select name="timestart" id="ourinput4">'.$dd_time_start.'</select><input id="custom4" style="'.$ourinput4.'" value="'.$_POST['ttimestart'].'" type="text" name="ttimestart" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"/>
				</tr>
				<tr>
					<td><a name="timeend" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'timeend\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Time End:</td>
					<td><select name="timeend" id="ourinput5">'.$dd_time_end.'</select><input id="custom5" style="'.$ourinput5.'" value="'.$_POST['ttimeend'].'" type="text" name="ttimeend" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"/></td>
				</tr>
				<tr>
					<td><a name="timeintervals" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'timeintervals\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Time Intervals:</td>
					<td><select name="timeintervals" id="ourinput6">'.$dd_time_intervals.'</select><input id="custom6" style="'.$ourinput6.'" value="'.$_POST['ttimeintervals'].'" type="text" name="ttimeintervals" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
				</tr>
				<tr>
					<td><a name="timetorespond" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'timetorespond\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Time to Respond:</td>
					<td><select name="timetorespond" id="ourinput7">'.$dd_time_respond.'</select><input id="custom7" style="'.$ourinput7.'" value="'.$_POST['ttimetorespond'].'" type="text" name="ttimetorespond" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
				</tr>
				<tr>
					<td><a name="timetofinalize" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'timetofinalize\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Time to Finalize:</td>
					<td><select name="timetofinalize" id="ourinput8">'.$dd_time_finalize.'</select><input id="custom8" style="'.$ourinput8.'" value="'.$_POST['ttimetofinalize'].'" type="text" name="ttimetofinalize" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
				</tr>
				<tr>
					<td><a name="playdays" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'playdays\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Play Days:</td>
					<td><select name="playdays" id="ourinput11">'.$dd_playdays.'</select><input id="custom11" style="'.$ourinput11.'" value="'.$_POST['tplaydays'].'" type="text" name="tplaydays" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
				</tr>
				<tr>
					<td><a name="datereport" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'datereport\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> After-date Report:</td>
					<td><select name="ad_report">'.$dd_date_report.'</select></td>
				</tr>
				<tr>
					<td><a name="challup" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'challup\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Challenge Up?:</td>
					<td><select name="challup" id="ourinput9">'.$dd_challup.'</select><input id="custom9" style="'.$ourinput9.'" value="'.$_POST['tchallup'].'" type="text" name="tchallup" size="4" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"/></td>
				</tr>
				<tr>
					<td><a name="challdown" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'challdown\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Challenge Down?:</td>
					<td><select name="challdown" id="ourinput10">>'.$dd_challdown.'</select><input id="custom10" style="'.$ourinput10.'" value="'.$_POST['tchalldown'].'" type="text" name="tchalldown" size="4" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"/></td>
				</tr>
				<tr>
					<td><a name="challquantity" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'challquant\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Challenge Quantity:</td>
					<td><input type="text" value="'.$_POST['challquant'].'" name="challquant" size="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
				</tr>
				<tr>
					<td></td>
				</tr>
				<tr>
					<td class="title" colspan="2" align="center"><a name="gs" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'gs\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> <b>Groupstage Configuration</b> (ignore to disable)</td>
				</tr>
				<tr>
					<td></td>
				</tr>
				<tr>
					<td><a name="gs_start" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'gs_start\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Group-Stage Start:</td>
					<td><input name="gs_s_day" type="text" size="2" value="'.$gsd.'" maxlength="2" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">.<input name="gs_s_month" type="text" size="2" value="'.$gsw.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">.<input name="gs_s_year" type="text" size="4" value="'.$gsy.'" maxlength="4" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> (dd.mm.yyyy) at <input name="gs_s_hour" type="text" size="2" value="'.$gsh.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">:<input name="gs_s_min" type="text" size="2" value="'.$gsm.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
				</tr>
				<tr>
					<td><a name="gs_end" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'gs_end\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Group-Stage End:</td>
					<td><input name="gs_e_day" type="text" size="2" value="'.$ged.'" maxlength="2" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">.<input name="gs_e_month" type="text" size="2" value="'.$gew.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">.<input name="gs_e_year" type="text" size="4" value="'.$gey.'" maxlength="4" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> (dd.mm.yyyy) at <input name="gs_e_hour" type="text" size="2" value="'.$geh.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">:<input name="gs_e_min" type="text" size="2" value="'.$gem.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
				</tr>
				<tr>
					<td><a name="maxrounds" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'maxrounds\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Maxrounds:</td>
					<td><input name="gs_maxrounds" type="text" size="4" value="'.$_POST['gs_maxrounds'].'" maxlength="4" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
				</tr>
				<tr>
					<td><a name="mwee" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'mwee\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Match Days:</td>
					<td><input name="gs_mwe" type="text" size="4" value="'.($_POST['gs_mwe']=='' ? '1' : $_POST['gs_mwe']).'" maxlength="4" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
				</tr>
				<tr>
					<td><a name="qualify" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'qualify\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> How to qualify:</td>
					<td><select name="gs_staging">'.$dd_passing.'</select></td>
				</tr>
				<tr>
					<td><a name="regtype" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'regtype\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Reg. Type:</td>
					<td><select name="gs_regtype">'.$dd_regtype.'</select></td>
				</tr>
				<tr>
					<td><a name="af" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'af\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> After-Finish:</td>
					<td><select name="gs_trans">'.$dd_trans.'</select></td>
				</tr>
				
				<tr>
					<td></td>
				</tr>
				<tr>
					<td class="title" colspan="2" align="center"><a name="ELO" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'elo\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> <b>ELO Configuration</b> (if "ELO Rating" is enabled aboves)</td>
				</tr>
				<tr>
					<td></td>
				</tr>
				<tr>
					<td><a name="elo_default" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'elo_default\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Default Rating:</td>
					<td><strong>'.$elo_rating_default.'</strong> (set at config.php)</td>
				</tr>
				<tr>
					<td><a name="kfa_type" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'kfa_type\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> K-Factor: (type)</td>
					<td><select name="kfa_type">'.$dd_kfactor.'</select></td>
				</tr>
				<tr>
				    <td colspan="2"><hr></td>
				</tr>
				<tr>
					<td><a name="kfa_fixed" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'kfa_fixed\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> K-Factor: (fixed)</td>
					<td><input name="kfa_fixed" type="text" size="2" value="'.$kfactor_fixed.'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
				</tr>
				<tr>
				    <td></td>
					<td><strong>-- OR IF VARIABLE --</strong></td>
				</tr>
				<tr>
					<td><a name="kfa_bel" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'kfa_bel\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> K-Factor: (variable)</td>
					<td><input name="kfa_bel" type="text" size="2" value="'.$elo_below_k.'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> if player ELO rating is below <input name="elo_bel" type="text" size="5" value="'.$elo_below_e.'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
				</tr>
				<tr>
					<td><a name="kfa_bet" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'kfa_bet\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> K-Factor: (variable)</td>
					<td><input name="kfa_bet" type="text" size="2" value="'.$elo_between_k.'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> if player ELO rating is in between <input name="elo_bet1" type="text" size="5" value="'.$elo_between_e1.'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> and <input name="elo_bet2" type="text" size="5" value="'.$elo_between_e2.'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
				</tr>
				<tr>
					<td><a name="kfa_abo" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'kfa_abo\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> K-Factor: (variable)</td>
					<td><input name="kfa_abo" type="text" size="2" value="'.$elo_above_k.'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> if player ELO rating is above <input name="elo_abo" type="text" size="5" value="'.$elo_above_e.'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
				</tr>
				<tr>
				    <td colspan="2"><hr></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><input type="submit" name="save" value="Add Ladder"></td>
				</tr>
			</table>
		</form><br/><br/><br/><br/><br/><br/><br/><br/>';
}
elseif($_GET['action']=="edit") {

//title ladder

$ID = $_GET['ID'];
$participants = (ladderis1on1($ID) ? 'Players' : 'Teams');	

echo '

<table width="100%" cellpadding="2" cellspacing="1" bgcolor="'.$border.'">
	<tr>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp; Edit Ladder</td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=teams&laddID='.$ID.'">'.$participants.'</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=ladders&action=standings&ID='.$ID.'">Standings</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=ladders&action=rules&ID='.$ID.'">Rules</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=ladders&action=admins&ID='.$ID.'">Admins</a></td>
        <td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=matches&laddID='.$ID.'">Matches</a></td>		
	</tr>
</table><br><br>'; 

echo'<h2>Edit Ladder (<a href="../?site=ladders&ID='.$_GET['ID'].'" target="_blank">View ladder</a>) </h2>';
 
 
  $ds = mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_ladders WHERE ID='".$_GET['ID']."'"));
  
  $gamesa=safe_query("SELECT tag, name FROM ".PREFIX."games ORDER BY name");
      while($dv=mysql_fetch_array($gamesa)) {
         $games.='<option value="'.$dv['tag'].'">'.$dv['name'].'</option>';
     }
	
  $query = safe_query("SELECT * FROM ".PREFIX."cup_platforms");
    $num_platforms = mysql_num_rows($query);
      while($pt = mysql_fetch_array($query)) {
         $platforms.='<option value="'.$pt['ID'].'">'.$pt['name'].' ('.$pt['platform'].')</option>';
     }
     
  $query = safe_query("SELECT * FROM ".PREFIX."gameacc ORDER BY type");
      while($gs=mysql_fetch_array($query)) {
         $gameaccs.='<option value="'.$gs['gameaccID'].'">'.$gs['type'].'</option>';
	}
	
  $query = safe_query("SELECT * FROM ".PREFIX."cup_maps GROUP BY mappack ORDER BY mappack");
      while($mp=mysql_fetch_array($query)) {
         $mappack.='<option value="'.$mp['mappack'].'">'.$mp['mappack'].'</option>';
	}
	
	if($ds['ranksys']==1) {
	   $ranksys = "Credit(s)";
	}elseif($ds['ranksys']==2) {
	   $ranksys = "XP";
	}elseif($ds['ranksys']==3) {
	   $ranksys = "Wins";
	}elseif($ds['ranksys']==4) {
	   $ranksys = "XP + Credits";
	}elseif($ds['ranksys']==5) {
	   $ranksys = "Wins + Credits";
	}elseif($ds['ranksys']==6) {
	   $ranksys = "Streak";
	}elseif($ds['ranksys']==7) {
	   $ranksys = "ELO";
	}
	
    $timestart_array = array("now","+1 day","+1 week","+2 weeks","+4 weeks");
    $timeend_array = array("+1 day","+1 week","+2 weeks","+4 weeks","+2 months","+3 months","+6 months","+1 year",);
    $timeintervals_array = array("300","600","900","1800","2700","3600","7200","10800");
    $timetorespond_array = array("900","5400","7200","10800","18000","43200","86400","172800","259200","432000","604800","1209600","2419200","4838400");
    $timetofinalize_array = array("900","5400","7200","10800","18000","43200","86400","172800","259200","432000","604800","1209600","2419200","4838400");
    $challup_array = array("10","20","30","40","50","0");
    $challdown_array = array("No","10","20","30","40","50","0");
    $playdays_array = array("86400","259200","604800","1209600","1814400","0");
    $inactivity_array = array("0","86400","172800","259200","432000","604800","1209600","2419200","4838400");
    $deduct_credits_array = array("0","1","3","5","10");
    $remove_inactive_array = array("0","172800","259200","432000","604800","1209600","2419200","4838400");

    if(in_array($ds['timestart'], $timestart_array) OR empty($ds['timestart'])) $ourinput4 = 'display: none'; else $ourinput4 = '';
    if(in_array($ds['timeend'], $timeend_array) OR empty($ds['timeend'])) $ourinput5 = 'display: none'; else $ourinput5 = '';
    if(in_array($ds['timeintervals'], $timeintervals_array) OR empty($ds['timeintervals']))  $ourinput6 = 'display: none'; else $ourinput6 = '';
    if(in_array($ds['timetorespond'], $timetorespond_array) OR empty($ds['timetorespond']))  $ourinput7 = 'display: none'; else $ourinput7 = '';
    if(in_array($ds['timetofinalize'], $timetofinalize_array) OR empty($ds['timetofinalize']))  $ourinput8 = 'display: none'; else $ourinput8 = '';
    if(in_array($ds['challup'], $challup_array) OR empty($ds['challup']))  $ourinput9 = 'display: none'; else $ourinput9 = '';
    if(in_array($ds['challdown'], $challdown_array) OR empty($ds['challdown']))  $ourinput10 = 'display: none'; else $ourinput10 = '';
    if(in_array($ds['playdays'], $playdays_array) OR empty($ds['playdays']))  $ourinput11 = 'display: none'; else $ourinput11 = '';
    if(in_array($ds['inactivity'], $inactivity_array) OR empty($ds['inactivity']))  $ourinput12 = 'display: none'; else $ourinput12 = '';
    if(in_array($ds['deduct_credits'], $deduct_credits_array) OR empty($ds['deduct_credits']))  $ourinput14 = 'display: none'; else $ourinput14 = '';
    if(in_array($ds['remove_inactive'], $remove_inactive_array) OR empty($ds['remove_inactive']))  $ourinput13 = 'display: none'; else $ourinput13 = '';
 
	$games=str_replace(' selected', '', $games);
	$games=str_replace('value="'.$ds['game'].'"', 'value="'.$ds['game'].'" selected', $games);
	
	$mappack=str_replace(' selected', '', $mappack);
	$mappack=str_replace('value="'.$ds['mappack'].'"', 'value="'.$ds['mappack'].'" selected', $mappack);
	
	$platforms=str_replace(' selected', '', $platforms);
	$platforms=str_replace('value="'.$ds['platID'].'"', 'value="'.$ds['platID'].'" selected', $platforms);	
	
	$gameaccs=str_replace(' selected', '', $gameaccs);
	$gameaccs=str_replace('value="'.$ds['gameaccID'].'"', 'value="'.$ds['gameaccID'].'" selected', $gameaccs);
	
	$maxsignups='<option value="8">16</option><option value="16">32</option><option value="32">64</option><option value="64">128</option>';
	$maxsignups=str_replace(' selected', '', $maxsignups);
	$maxsignups=str_replace('value="'.$ds['maxclan'].'"', 'value="'.$ds['maxclan'].'" selected', $maxsignups);
	
	$infsignups='<option value="0">No</option><option value="1">Yes</option>';
	$infsignups=str_replace(' selected', '', $infsignups);
	$infsignups=str_replace('value="'.$ds['sign'].'"', 'value="'.$ds['sign'].'" selected', $infsignups);
	
	$dd_select_map='<option value="1">1 Map</option><option value="2">2 Maps</option><option value="3">3 Maps</option><option value="4">4 Maps</option><option value="5">5 Maps</option>';
	$dd_select_map=str_replace(' selected', '', $dd_select_map);
	$dd_select_map=str_replace('value="'.$ds['select_map'].'"', 'value="'.$ds['select_map'].'" selected', $dd_select_map);
	
	$dd_selected_map='<option value="1">1 Map</option><option value="2">2 Maps</option><option value="3">3 Maps</option><option value="4">4 Maps</option>';
	$dd_selected_map=str_replace(' selected', '', $dd_selected_map);
	$dd_selected_map=str_replace('value="'.$ds['selected_map'].'"', 'value="'.$ds['selected_map'].'" selected', $dd_selected_map);
	
	$dd_select_date='<option value="1">1 Date</option><option value="2">2 Dates</option><option value="3">3 Dates</option><option value="4">4 Dates</option><option value="5">5 Dates</option>';
	$dd_select_date=str_replace(' selected', '', $dd_select_date);
	$dd_select_date=str_replace('value="'.$ds['select_date'].'"', 'value="'.$ds['select_date'].'" selected', $dd_select_date);
	
if(!in_array($ds['timestart'], $timestart_array))
    $dd_time_start = '<option value="'.$ds['timestart'].'" selected>'.$ds['timestart'].'</option><option value="now">Now</option><option value="+1 day">+1 Day</option><option value="+1 week">+1 Week</option><option value="+2 weeks">+2 Weeks</option><option value="+4 weeks">+1 Month</option>';
  else{
  
	$dd_time_start='<option value="now">Now</option><option value="+1 day">+1 Day</option><option value="+1 week">+1 Week</option><option value="+2 weeks">+2 Weeks</option><option value="+4 weeks">+1 Month</option><option value="custom4">Custom Seconds</option>';
	$dd_time_start=str_replace(' selected', '', $dd_time_start);
	$dd_time_start=str_replace('value="'.$ds['timestart'].'"', 'value="'.$ds['timestart'].'" selected', $dd_time_start);
  }
 
	$dd_time_start2='<option value="1">1 Date</option><option value="2">2 Dates</option><option value="3">3 Dates</option><option value="4">4 Dates</option><option value="5">5 Dates</option>';
	$dd_time_start2=str_replace(' selected', '', $dd_time_start2);
	$dd_time_start2=str_replace('value="'.$ds['select_date'].'"', 'value="'.$ds['select_date'].'" selected', $dd_time_start2);
  
   if(!in_array($ds['timeend'], $timeend_array))
    $dd_time_end = '<option value="'.$ds['timeend'].'" selected>'.$ds['timeend'].'</option><option value="+1 day">+1 Day</option><option value="+1 week">+1 Week</option><option value="+2 weeks">+2 Weeks</option><option value="+4 weeks">+1 Month</option><option value="+2 months">+2 Months</option><option value="+3 months">+3 Months</option><option value="+6 months">+6 Months</option><option value="+1 year">+1 Year</option>';
  else{
   
	$dd_time_end='<option value="+1 day">+1 Day</option><option value="+1 week">+1 Week</option><option value="+2 weeks">+2 Weeks</option><option value="+4 weeks">+1 Month</option><option value="+2 months">+2 Months</option><option value="+3 months">+3 Months</option><option value="+6 months">+6 Months</option><option value="+1 year">+1 Year</option><option value="custom5">Custom Seconds</option>';
	$dd_time_end=str_replace(' selected', '', $dd_time_end);
	$dd_time_end=str_replace('value="'.$ds['timeend'].'"', 'value="'.$ds['timeend'].'" selected', $dd_time_end);
  }
    if(!in_array($ds['timeintervals'], $timeintervals_array))
    $dd_time_intervals = '<option value="'.$ds['timeintervals'].'" selected>Appox: '.Sec2Time($ds['timeintervals']).'</option><option value="300">5 Minutes</option><option value="600">10 Minutes</option><option value="900">15 Minutes</option><option value="1800">30 Minutes</option><option value="2700">45 Minutes</option><option value="3600">1 Hour</option><option value="7200">2 Hours</option><option value="10800">3 Hours</option>';
  else{
	
	$dd_time_intervals='<option value="300">5 Minutes</option><option value="600">10 Minutes</option><option value="900">15 Minutes</option><option value="1800">30 Minutes</option><option value="2700">45 Minutes</option><option value="3600">1 Hour</option><option value="7200">2 Hours</option><option value="10800">3 Hours</option><option value="custom6">Custom Seconds</option>';
	$dd_time_intervals=str_replace(' selected', '', $dd_time_intervals);
	$dd_time_intervals=str_replace('value="'.$ds['timeintervals'].'"', 'value="'.$ds['timeintervals'].'" selected', $dd_time_intervals);
  }
    if(!in_array($ds['timetorespond'], $timetorespond_array))
    $dd_time_respond = '<option value="'.$ds['timetorespond'].'" selected>Appox: '.Sec2Time($ds['timetorespond']).'</option><option value="3600">1 Hour</option><option value="5400">1hr 30 Mins</option><option value="7200">2 Hours</option><option value="10800">3 Hours</option><option value="18000">5 Hours</option><option value="43200">12 Hours</option><option value="86400">1 Day</option><option value="172800">2 Days</option><option value="259200">3 Days</option><option value="432000">5 Days</option><option value="604800">1 Week</option><option value="1209600">2 Weeks</option><option value="2419200">1 Month</option><option value="4838400">2 Months</option>';
  else{
	
	$dd_time_respond='<option value="3600">1 Hour</option><option value="5400">1hr 30 Mins</option><option value="7200">2 Hours</option><option value="10800">3 Hours</option><option value="18000">5 Hours</option><option value="43200">12 Hours</option><option value="86400">1 Day</option><option value="172800">2 Days</option><option value="259200">3 Days</option><option value="432000">5 Days</option><option value="604800">1 Week</option><option value="1209600">2 Weeks</option><option value="2419200">1 Month</option><option value="4838400">2 Months</option><option value="custom7">Custom Seconds</option>';
	$dd_time_respond=str_replace(' selected', '', $dd_time_respond);
	$dd_time_respond=str_replace('value="'.$ds['timetorespond'].'"', 'value="'.$ds['timetorespond'].'" selected', $dd_time_respond);
  }
    if(!in_array($ds['timetofinalize'], $timetofinalize_array))
    $dd_time_finalize = '<option value="'.$ds['timetofinalize'].'" selected>Appox: '.Sec2Time($ds['timetofinalize']).'</option><option value="3600">1 Hour</option><option value="5400">1hr 30 Mins</option><option value="7200">2 Hours</option><option value="10800">3 Hours</option><option value="18000">5 Hours</option><option value="43200">12 Hours</option><option value="86400">1 Day</option><option value="172800">2 Days</option><option value="259200">3 Days</option><option value="432000">5 Days</option><option value="604800">1 Week</option><option value="1209600">2 Weeks</option><option value="2419200">1 Month</option><option value="4838400">2 Months</option>';
  else{
	  
	$dd_time_finalize='<option value="3600">1 Hour</option><option value="5400">1hr 30 Mins</option><option value="7200">2 Hours</option><option value="10800">3 Hours</option><option value="18000">5 Hours</option><option value="43200">12 Hours</option><option value="86400">1 Day</option><option value="172800">2 Days</option><option value="259200">3 Days</option><option value="432000">5 Days</option><option value="604800">1 Week</option><option value="1209600">2 Weeks</option><option value="2419200">1 Month</option><option value="4838400">2 Months</option><option value="custom8">Custom Seconds</option>';
	$dd_time_finalize=str_replace(' selected', '', $dd_time_finalize);
	$dd_time_finalize=str_replace('value="'.$ds['timetofinalize'].'"', 'value="'.$ds['timetofinalize'].'" selected', $dd_time_finalize);
  }
	$dd_signup='<option value="1">Signup phase</option><option value="2">Started</option><option value="3">Closed</option>';
	$dd_signup=str_replace(' selected', '', $dd_signup);
	$dd_signup=str_replace('value="'.$ds['status'].'"', 'value="'.$ds['status'].'" selected', $dd_signup);
	
    if(!in_array($ds['challup'], $challup_array))
    $dd_challup = '<option value="'.$ds['challup'].'" selected>'.$ds['challup'].' Ranks</option><option value="10">10 Ranks</option><option value="20">20 Ranks</option><option value="30">30 Ranks</option><option value="40">40 Ranks</option><option value="50">50 Ranks</option><option value="0">Any Rank</option>';
  else{
    
	$dd_challup='<option value="10">10 Ranks</option><option value="20">20 Ranks</option><option value="30">30 Ranks</option><option value="40">40 Ranks</option><option value="50">50 Ranks</option><option value="custom9">Custom Seconds</option><option value="0">Any Rank</option>';
	$dd_challup=str_replace(' selected', '', $dd_challup);
	$dd_challup=str_replace('value="'.$ds['challup'].'"', 'value="'.$ds['challup'].'" selected', $dd_challup);
  }
    if(!in_array($ds['challdown'], $challdown_array))
    $dd_challdown = '<option value="'.$ds['challdown'].'" selected>'.$ds['challdown'].' Ranks</option><option value="No">No</option><option value="10">10 Ranks</option><option value="20">20 Ranks</option><option value="30">30 Ranks</option><option value="40">40 Ranks</option><option value="50">50 Ranks</option><option value="0">Any Rank</option>';
  else{
    
	$dd_challdown='<option value="No">No</option><option value="10">10 Ranks</option><option value="20">20 Ranks</option><option value="30">30 Ranks</option><option value="40">40 Ranks</option><option value="50">50 Ranks</option><option value="custom10">Custom Seconds</option><option value="0">Any Rank</option>';
	$dd_challdown=str_replace(' selected', '', $dd_challdown);
	$dd_challdown=str_replace('value="'.$ds['challdown'].'"', 'value="'.$ds['challdown'].'" selected', $dd_challdown);
  }
	$dd_challallow='<option value="0">Challenging Only</option><option value="1">Open-Play Only</option><option value="2">Both</option>';
	$dd_challallow=str_replace(' selected', '', $dd_challallow);
	$dd_challallow=str_replace('value="'.$ds['challallow'].'"', 'value="'.$ds['challallow'].'" selected', $dd_challallow);
	
	$dd_mode='<option value="1">#Half-Way Up</option><option value="2">#Position Exchange</option><option value="3">#ELO Rating</option><option value="0">None</option>';
	$dd_mode=str_replace(' selected', '', $dd_mode);
	$dd_mode=str_replace('value="'.$ds['mode'].'"', 'value="'.$ds['mode'].'" selected', $dd_mode);
	
	$dd_ranksys='<option value="7">ELO Rating</option><option value="1">Credibility Only</option><option value="2">XP Only</option><option value="3">Won Matches</option><option value="4">XP & Credibility</option><option value="5">Won Matches & Credibility</option><option value="6">Streak</option>';
	$dd_ranksys=str_replace(' selected', '', $dd_ranksys);
	$dd_ranksys=str_replace('value="'.$ds['ranksys'].'"', 'value="'.$ds['ranksys'].'" selected', $dd_ranksys);
	
	$dd_dxp='<option value="1">Win XP Only</option><option value="0">Win/Loss XP</option>';
	$dd_dxp=str_replace(' selected', '', $dd_dxp);
	$dd_dxp=str_replace('value="'.$ds['d_xp'].'"', 'value="'.$ds['d_xp'].'" selected', $dd_dxp);
	
	$dd_date_report='<option value="1">Yes</option><option value="0">No</option>';
	$dd_date_report=str_replace(' selected', '', $dd_date_report);
	$dd_date_report=str_replace('value="'.$ds['ad_report'].'"', 'value="'.$ds['ad_report'].'" selected', $dd_date_report);
	
    if(!in_array($ds['playdays'], $playdays_array))
    $dd_playdays = '<option value="'.$ds['playdays'].'" selected>Appox: '.Sec2Time($ds['playdays']).'</option><option value="86400">1 Day</option><option value="259200">3 Days</option><option value="604800">1 Week</option><option value="1209600">2 Weeks</option><option value="1814400">3 Weeks</option><option value="0">Any Day</option>';
  else{
	
	$dd_playdays='<option value="86400">1 Day</option><option value="259200">3 Days</option><option value="604800">1 Week</option><option value="1209600">2 Weeks</option><option value="1814400">3 Weeks</option><option value="custom11">Custom Seconds</option><option value="0">Any Day</option>';
	$dd_playdays=str_replace(' selected', '', $dd_playdays);
	$dd_playdays=str_replace('value="'.$ds['playdays'].'"', 'value="'.$ds['playdays'].'" selected', $dd_playdays);
  }
    if(!in_array($ds['inactivity'], $inactivity_array))
    $dd_droptime = '<option value="'.$ds['inactivity'].'" selected>Appox: '.Sec2Time($ds['inactivity']).'</option><option value="0">Disable</option><option value="3600">1 Hour</option><option value="5400">1hr 30 Mins</option><option value="7200">2 Hours</option><option value="10800">3 Hours</option><option value="18000">5 Hours</option><option value="43200">12 Hours</option><option value="86400">1 Day</option><option value="172800">2 Days</option><option value="259200">3 Days</option><option value="432000">5 Days</option><option value="604800">1 Week</option><option value="1209600">2 Weeks</option><option value="2419200">1 Month</option><option value="4838400">2 Months</option>';
  else{
  
	$dd_droptime='<option value="0">Disable</option><option value="86400">1 Day</option><option value="172800">2 Days</option><option value="259200">3 Days</option><option value="432000">5 Days</option><option value="604800">1 Week</option><option value="1209600">2 Weeks</option><option value="2419200">1 Month</option><option value="4838400">2 Months</option><option value="custom12">Custom Seconds</option>';
	$dd_droptime=str_replace(' selected', '', $dd_droptime);
	$dd_droptime=str_replace('value="'.$ds['inactivity'].'"', 'value="'.$ds['inactivity'].'" selected', $dd_droptime);
  }
    if(!in_array($ds['remove_inactive'], $remove_inactive_array))
    $dd_remove_inactive = '<option value="'.$ds['remove_inactive'].'" selected>Appox: '.Sec2Time($ds['remove_inactive']).'</option><option value="0">Disable</option><option value="172800">2 Days</option><option value="259200">3 Days</option><option value="432000">5 Days</option><option value="604800">1 Week</option><option value="1209600">2 Weeks</option><option value="2419200">1 Month</option><option value="4838400">2 Months</option>';
  else{
  
	$dd_remove_inactive='<option value="0">Disable</option><option value="172800">2 Days</option><option value="259200">3 Days</option><option value="432000">5 Days</option><option value="604800">1 Week</option><option value="1209600">2 Weeks</option><option value="2419200">1 Month</option><option value="4838400">2 Months</option><option value="custom13">Custom Seconds</option>';
	$dd_remove_inactive=str_replace(' selected', '', $dd_remove_inactive);
	$dd_remove_inactive=str_replace('value="'.$ds['remove_inactive'].'"', 'value="'.$ds['remove_inactive'].'" selected', $dd_remove_inactive);
  }
    if(!in_array($ds['deduct_credits'], $deduct_credits_array))
    $dd_dropcredit = '<option value="'.$ds['deduct_credits'].'" selected>'.$ds['deduct_credits'].' Credits</option><option value="0">Disable</option><option value="1">1 Credit</option><option value="3">3 Credits</option><option value="5">5 Credits</option><option value="10">10 Credits</option>';
  else{
  
	$dd_dropcredit='<option value="0">Disable</option><option value="1">1 Credit</option><option value="3">3 Credits</option><option value="5">5 Credits</option><option value="10">10 Credits</option><option value="custom14">Custom Credits</option>';
	$dd_dropcredit=str_replace(' selected', '', $dd_dropcredit);
	$dd_dropcredit=str_replace('value="'.$ds['deduct_credits'].'"', 'value="'.$ds['deduct_credits'].'" selected', $dd_dropcredit);
  }
  
	$dd_passing='<option value="0">Win first match</option><option value="2">Qualify by XP - Single Match</option><option value="1">Qualify by XP - All vs. All</option>';
	$dd_passing=str_replace(' selected', '', $dd_passing);
	$dd_passing=str_replace('value="'.$ds['gs_staging'].'"', 'value="'.$ds['gs_staging'].'" selected', $dd_passing);
	
	$dd_kfactor='<option value="0">Fixed</option><option value="1">Variable</option>';
	$dd_kfactor=str_replace(' selected', '', $dd_kfactor);
	$dd_kfactor=str_replace('value="'.$ds['kfa_type'].'"', 'value="'.$ds['kfa_type'].'" selected', $dd_kfactor);
	
	$dd_regtype='<option value="0">Randomized Group Registration</option><option value="1">Pick Group Registration</option>';
	$dd_regtype=str_replace(' selected', '', $dd_regtype);
	$dd_regtype=str_replace('value="'.$ds['gs_regtype'].'"', 'value="'.$ds['gs_regtype'].'" selected', $dd_regtype);

	$dd_trans='<option value="1">Open cup registration after group stages finish</option><option value="0">Change according to set start and end times</option>';
	$dd_trans=str_replace(' selected', '', $dd_trans);
	$dd_trans=str_replace('value="'.$ds['gs_trans'].'"', 'value="'.$ds['gs_trans'].'" selected', $dd_trans);
  
	if($ds['1on1']){
		$onecup='checked';
		$discup='disabled';
		$typcup='1on1';
	}
	
	if($ds['clanmembers']) 
		$clanmem='checked';
		
	if($ds['agents']) 
		$agents='checked';
	
	if($ds['gameacclimit']) 
		$gvalidbackup='checked';
	
	if($ds['cgameacclimit']) 
		$gvalidcheckin='checked';
		
    //ladder	
		
    $lsd = date('d', $ds['start']);
    $lsw = date('m', $ds['start']);
    $lsy = date('Y', $ds['start']);
    $lsh = date('H', $ds['start']);
    $lsm = date('i', $ds['start']);		
    $led = date('d', $ds['end']);
    $lew = date('m', $ds['end']);
    $ley = date('Y', $ds['end']);
    $leh = date('H', $ds['end']);
    $lem = date('i', $ds['end']);
    
    //groupstage

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
	
	//elo

	$kfactor_fixed = !$ds['kfa_fixed'] ? $kfactor_fixed : $ds['kfa_fixed'];
	
	$elo_below_k = !$ds['kfa_bel'] ? $kfactor_below : $ds['kfa_bel'];
	$elo_below_e = !$ds['elo_bel'] ? $elo_below : $ds['elo_bel'];
	
	$elo_between_k = !$ds['kfa_bet'] ? $kfactor_between : $ds['kfa_bet'];
	$elo_between_e1= !$ds['elo_bet1'] ? $elo_between_start : $ds['elo_bet1'];
	$elo_between_e2= !$ds['elo_bet2'] ? $elo_between_end : $ds['elo_bet2'];
	
	$elo_above_k = !$ds['kfa_abo'] ? $kfactor_above : $ds['kfa_abo'];
	$elo_above_e = !$ds['elo_abo'] ? $elo_above : $ds['elo_abo'];
	
//if error

  echo $showerror;
  
//

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
  
    echo '<form method="post" action="" name="cup">
			<table id="table2" cellpadding="6" cellspacing="0">
				<tr>
					<td></td>
				</tr>
				<tr>
					<td class="title" colspan="2" align="center"><b>Ladder Configuration</b></td>
				</tr>
				<tr>
					<td></td>
				<tr>
					<td><a name="name" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'name\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Name:</td>
					<td><input type="text" name="name" value="'.$ds['name'].'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
				</tr>
				<tr>
					<td><a name="abbrev" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'abbrev\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Abbreviation:</td>
					<td><input type="text" name="abbrev" size="10" value="'.$ds['abbrev'].'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
				</tr>	
				</tr>
				<tr>
					<td><a name="platform" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'platform\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Platform:</td>
					<td><select name="platID">'.$platforms.'</select> (<a href="admincenter.php?site=platforms" target="_blank">manage platforms</a>)</td>
				</tr>
				<tr>
					<td><a name="mappack" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'mappack\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Mappack:</td>
					<td><select name="mappack">'.$mappack.'</select> (<a href="admincenter.php?site=cupmaps" target="_blank">manage mappacks</a>)</td>
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
					<td><a name="gamb" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'gamb\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Gameaccount Validation?:</td>
					<td><input type="checkbox" name="cgameacclimit" value="1" '.$gvalidcheckin.'></td>
				</tr>
				<tr>
					<td><a name="type" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'type\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Type:</td>
					<td><input type="text" name="typ" size="5" value="'.$ds['type'].'" '.$discup.' class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> XonX</td>
				</tr>	
		        <tr>
		            <td><a name="line" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'line\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Lineup/Ladder type -</td>
		            <td><input type="text" name="cupaclimit" size="3" value="'.$ds['cupaclimit'].'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> Member Count (checkin)</td>
		        </tr>	
				<tr>
					<td><a name="ranksys" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'ranksys\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Rank By?:</td>
					<td><select name="ranksys">'.$dd_ranksys.'</select></td>
				</tr>
				<tr>
					<td><a name="d_xp" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'d_xp\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Determine XP By?:</td>
					<td><select name="d_xp">'.$dd_dxp.'</select></td>
				</tr>
				<tr>
					<td><a name="gametype" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'gametype\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Gametype:</td>
					<td><input type="text" name="gametype" value="'.$ds['gametype'].'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
				</tr>	
				<tr>
					<td><a name="sign" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'sign\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Sign-ups until end?</td>
					<td><select name="sign">'.$infsignups.'</select></td>
				</tr>
				<tr>
					<td><a name="maxclan" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'maxclan\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Max. Signups:</td>
					<td><select name="maxclan">'.$maxsignups.'</select> (only for groups)</td>
				</tr>
				<tr>
					<td><a name="start" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'start\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Ladder Start:</td>
					<td><input name="s_day" type="text" size="2" value="'.$lsd.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">.<input name="s_month" type="text" size="2" value="'.$lsw.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">.<input name="s_year" type="text" size="4" value="'.$lsy.'" maxlength="4" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> (dd.mm.yyyy) at <input name="s_hour" type="text" size="2" value="'.$lsh.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">:<input name="s_min" type="text" size="2" value="'.$lsm.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
				</tr>
				<tr>
					<td><a name="end" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'end\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Ladder End:</td>
					<td><input name="e_day" value="'.$led.'" maxlength="2" type="text" size="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">.<input name="e_month" type="text" size="2" value="'.$lew.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">.<input name="e_year" type="text" size="4" value="'.$ley.'" maxlength="4" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> (dd.mm.yyyy) at <input name="e_hour" type="text" size="2" value="'.$leh.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">:<input name="e_min" type="text" size="2" value="'.$lem.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
				</tr>
				<tr>
					<td><a name="inactive_drop" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'inactive_drop\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Inactive Duration:</td>
					<td><select name="inactivity" id="ourinput12">'.$dd_droptime.'</select><input id="custom12" style="'.$ourinput12.'" value="'.$ds['inactivity'].'" type="text" name="tinactivity" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"/></td>
				</tr>
				<tr>
					<td><a name="inactive_drop_credit" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'inactive_drop_credit\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Deduct Credits:</td>
					<td><select name="deduct_credits" id="ourinput14">'.$dd_dropcredit.'</select><input id="custom14" style="'.$ourinput14.'" value="'.$ds['deduct_credits'].'" type="text" name="tdeduct_credits" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"/> <i>(repeats)</i></td>
				</tr>
				<tr>
					<td><a name="inactive_remove" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'inactive_remove\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Remove Inactive:</td>
					<td><select name="remove_inactive" id="ourinput13">'.$dd_remove_inactive.'</select><input id="custom13" style="'.$ourinput13.'" value="'.$ds['remove_inactive'].'" type="text" name="tremove_inactive" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"/></td>
				</tr>
				<tr>
					<td><a name="ratio" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'ratio\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Ratio:</td>
					<td><input type="text" name="ratio_low" value="'.$ds['ratio_low'].'" size="3" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">% - <input type="text" name="ratio_high" value="'.$ds['ratio_high'].'" size="3" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">% Skill comptence level by score ratio (0 for both = disable)</td>
				</tr>
				<tr>
					<td><a name="gacc" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'gacc\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Gameaccount:</td>
					<td><select name="gameacc">'.$gameaccs.'</select></td>
				</tr>
				<tr>
					<td><a name="status" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'status\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Status:</td>
					<td><select name="status">'.$dd_signup.'</select></td>
				</tr>
				<tr>
					<td><a name="time" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'time\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Timezone:</td>
					<td><select name="timezone">'.$timezones.'</select></td>
				</tr>
				<tr>
					<td></td>
				</tr>
				<tr>
					<td class="title" colspan="2" align="center"><b>Challenge Configuration</b></td>
				</tr>
				<tr>
					<td></td>
				</tr>
				<tr>
					<td><a name="challallow" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'challallow\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Allow Challenging?:</td>
					<td><select name="challallow" onChange="checkSel(this);">'.$dd_challallow.'</select></td>
				</tr>
				<tr>
					<td><a name="crechall" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'crechall\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Credits to Challenge?:</td>
					<td><input type="text" value="'.$ds['crechall'].'" name="crechall" size="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> (0 to disable)</td>
				</tr>
				<tr>
					<td><a name="crerep" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'crerep\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Credits to Report?:</td>
					<td><input type="text" value="'.$ds['crerep'].'" name="crerep" size="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> (0 to disable)</td>
				</tr>
				<tr>
					<td><a name="select_map" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'select_map\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Select-Map:</td>
					<td><select name="select_map">'.$dd_select_map.'</select></td>
				</tr>
				<tr>
					<td><a name="selected_map" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'selected_map\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Selected-Map:</td>
					<td><select name="selected_map">'.$dd_selected_map.'</select></td>
				</tr>		
				<tr>
					<td><a name="select_date" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'select_date\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Select-Date:</td>
					<td><select name="select_date">'.$dd_select_date.'</select></td>
				</tr>
				<tr>
					<td><a name="timestart" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'timestart\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Time Start:</td>
					<td><select name="timestart" id="ourinput4">'.$dd_time_start.'</select><input id="custom4" style="'.$ourinput4.'" value="'.$ds['timestart'].'" type="text" name="ttimestart" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"/></td>
				</tr>
				<tr>
					<td><a name="timeend" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'timeend\')" onmouseout="hideWMTT()"> <img src="../images/cup/icons/faq.png"></a> Time End:</td>
					<td><select name="timeend" id="ourinput5">'.$dd_time_end.'</select><input id="custom5" style="'.$ourinput5.'" value="'.$ds['timeend'].'" type="text" name="ttimeend" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"/></td>
				</tr>
				<tr>
					<td><a name="timeintervals" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'timeintervals\')" onmouseout="hideWMTT()"> <img src="../images/cup/icons/faq.png"></a> Time Intervals:</td>
					<td><select name="timeintervals" id="ourinput6">'.$dd_time_intervals.'</select><input id="custom6" style="'.$ourinput6.'" value="'.$ds['timeintervals'].'" type="text" name="ttimeintervals" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
				</tr>
				<tr>
					<td><a name="timetorespond" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'timetorespond\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Time to Respond:</td>
					<td><select name="timetorespond" id="ourinput7">'.$dd_time_respond.'</select><input id="custom7" style="'.$ourinput7.'" value="'.$ds['timetorespond'].'" type="text" name="ttimetorespond" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
				</tr>
				<tr>
					<td><a name="timetofinalize" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'timetofinalize\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Time to Finalize:</td>
					<td><select name="timetofinalize" id="ourinput8">'.$dd_time_finalize.'</select><input id="custom8" style="'.$ourinput8.'" value="'.$ds['timetofinalize'].'" type="text" name="ttimetofinalize" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
				</tr>
				<tr>
					<td><a name="playdays" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'playdays\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Play Days:</td>
					<td><select name="playdays" id="ourinput11">'.$dd_playdays.'</select><input id="custom11" style="'.$ourinput11.'" type="text" name="tplaydays" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></td>
				</tr>
				<tr>
					<td><a name="datereport" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'datereport\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> After-date Report:</td>
					<td><select name="ad_report">'.$dd_date_report.'</select></td>
				</tr>
				<tr>
					<td><a name="challup" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'challup\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Challenge Up?:</td>
					<td><select name="challup" id="ourinput9">'.$dd_challup.'</select><input id="custom9" style="'.$ourinput9.'" value="'.$ds['challup'].'" type="text" name="tchallup" size="4" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"/></td>
				</tr>
				<tr>
					<td><a name="challdown" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'challdown\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Challenge Down?:</td>
					<td><select name="challdown" id="ourinput10">'.$dd_challdown.'</select><input id="custom10" style="'.$ourinput10.'" value="'.$ds['challdown'].'" type="text" name="tchalldown" size="4" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"/></td>
				</tr>
				<tr>
					<td><a name="challquantity" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'challquant\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Challenge Quantity:</td>
					<td><input type="text" value="'.$ds['challquant'].'" name="challquant" size="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
				</tr>
				<tr>
					<td></td>
				</tr>
				<tr>
					<td class="title" colspan="2" align="center"><a name="gs" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'gs\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> <b>Groupstage Configuration</b> (ignore to disable)</td>
				</tr>
				<tr>
					<td></td>
				</tr>
				<tr>
					<td><a name="gs_start" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'gs_start\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Group-Stage Start:</td>
					<td><input name="gs_s_day" type="text" size="2" value="'.$gsd.'" maxlength="2" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">.<input name="gs_s_month" type="text" size="2" value="'.$gsw.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">.<input name="gs_s_year" type="text" size="4" value="'.$gsy.'" maxlength="4" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> (dd.mm.yyyy) at <input name="gs_s_hour" type="text" size="2" value="'.$gsh.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">:<input name="gs_s_min" type="text" size="2" value="'.$gsm.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
				</tr>
				<tr>
					<td><a name="gs_end" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'gs_end\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Group-Stage End:</td>
					<td><input name="gs_e_day" type="text" size="2" value="'.$ged.'" maxlength="2" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">.<input name="gs_e_month" type="text" size="2" value="'.$gew.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">.<input name="gs_e_year" type="text" size="4" value="'.$gey.'" maxlength="4" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> (dd.mm.yyyy) at <input name="gs_e_hour" type="text" size="2" value="'.$geh.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">:<input name="gs_e_min" type="text" size="2" value="'.$gem.'" maxlength="2" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
				</tr>
				<tr>
					<td><a name="maxrounds" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'maxrounds\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Maxrounds:</td>
					<td><input name="gs_maxrounds" type="text" size="4" value="'.$ds['gs_maxrounds'].'" maxlength="4" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
				</tr>
				<tr>
					<td><a name="mwee" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'mwee\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Match Days:</td>
					<td><input name="gs_mwe" type="text" size="4" value="'.$ds['gs_mwe'].'" maxlength="4" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
				</tr>
				<tr>
					<td><a name="qualify" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'qualify\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> How to qualify:</td>
					<td><select name="gs_staging">'.$dd_passing.'</select></td>
				</tr>
				<tr>
					<td><a name="regtype" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'regtype\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Reg. Type:</td>
					<td><select name="gs_regtype">'.$dd_regtype.'</select></td>
				</tr>
				<tr>
					<td><a name="af" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'af\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> After-Finish:</td>
					<td><select name="gs_trans">'.$dd_trans.'</select></td>
				</tr>
				<tr>
					<td></td>
				</tr>
				<tr>
					<td class="title" colspan="2" align="center"><a name="ELO" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'elo\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> <b>ELO Configuration</b> (if "ELO Rating" is enabled aboves)</td>
				</tr>
				<tr>
					<td></td>
				</tr>
				<tr>
					<td><a name="elo_default" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'elo_default\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> Default Rating:</td>
					<td><strong>'.$elo_rating_default.'</strong> (set at config.php)</td>
				</tr>
				<tr>
					<td><a name="kfa_type" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'kfa_type\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> K-Factor: (type)</td>
					<td><select name="kfa_type">'.$dd_kfactor.'</select></td>
				</tr>
				<tr>
				    <td colspan="2"><hr></td>
				</tr>
				<tr>
					<td><a name="kfa_fixed" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'kfa_fixed\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> K-Factor: (fixed)</td>
					<td><input name="kfa_fixed" type="text" size="2" value="'.$kfactor_fixed.'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
				</tr>
				<tr>
				    <td></td>
					<td><strong>-- OR IF VARIABLE --</strong></td>
				</tr>
				<tr>
					<td><a name="kfa_bel" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'kfa_bel\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> K-Factor: (variable)</td>
					<td><input name="kfa_bel" type="text" size="2" value="'.$elo_below_k.'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> if player ELO rating is below <input name="elo_bel" type="text" size="5" value="'.$elo_below_e.'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
				</tr>
				<tr>
					<td><a name="kfa_bet" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'kfa_bet\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> K-Factor: (variable)</td>
					<td><input name="kfa_bet" type="text" size="2" value="'.$elo_between_k.'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> if player ELO rating is in between <input name="elo_bet1" type="text" size="5" value="'.$elo_between_e1.'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> and <input name="elo_bet2" type="text" size="5" value="'.$elo_between_e2.'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
				</tr>
				<tr>
					<td><a name="kfa_abo" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'kfa_abo\')" onmouseout="hideWMTT()"><img src="../images/cup/icons/faq.png"></a> K-Factor: (variable)</td>
					<td><input name="kfa_abo" type="text" size="2" value="'.$elo_above_k.'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> if player ELO rating is above <input name="elo_abo" type="text" size="5" value="'.$elo_above_e.'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"></td>
				</tr>
				<tr>
				    <td colspan="2"><hr></td>
				</tr>
				<tr>
					<td></td>
				</tr>
				<tr>
					<td class="title" colspan="2" align="center"><b>Awards</b></td>
				</tr>
				<tr>
					<td></td>
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
					<td>&nbsp;</td>
					<td><input type="submit" name="saveedit" value="Edit Ladder"><input type="hidden" name="ID" value="'.$_GET['ID'].'"></td>
				</tr>
			</table>
		</form>';
}elseif($_GET['action']=="admins") {
    
$laddID = $_GET['ID'];
$ID = $laddID;
$participants = (ladderis1on1($ID) ? 'Players' : 'Teams');	

echo '

<table width="100%" cellpadding="2" cellspacing="1" bgcolor="'.$border.'">
	<tr>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=ladders&action=edit&ID='.$ID.'">Edit Ladder</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=teams&laddID='.$ID.'">'.$participants.'</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=ladders&action=standings&ID='.$ID.'">Standings</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=ladders&action=rules&ID='.$ID.'">Rules</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;Admins</a></td>
        <td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=matches&laddID='.$ID.'">Matches</a></td>		
	</tr>
</table><br>';  
    
	$admins = safe_query("SELECT * FROM ".PREFIX."user_groups WHERE cup='1' OR super='1'");
	echo'<br>Select admins for cup: <br><b>'.getladname($laddID).'</b>';
	echo'<form method="post" action="admincenter.php?site=ladders">
	       <select name="admins[]" multiple size="10">';
		   
	while($dm=mysql_fetch_array($admins)) {
	    $nick=getnickname($dm['userID']);
	    $isadmin=mysql_num_rows(safe_query("SELECT * FROM ".PREFIX."cup_admins WHERE ladID='$laddID' AND userID='".$dm['userID']."'"));
		if($isadmin) 
			echo'<option value="'.$dm['userID'].'" selected>'.$nick.'</option>';
		else 
			echo'<option value="'.$dm['userID'].'">'.$nick.'</option>';
	}
	echo'</select>

	       <input type="hidden" name="ladID" value="'.$laddID.'">
	       <br><br><input type="submit" name="saveadmins" value="Add Admins">
		 </form>';
}elseif($_GET['action']=="rules") {

$laddID = $_GET['ID'];
$ID = $laddID;
$participants = (ladderis1on1($ID) ? 'Players' : 'Teams');	

echo '

<table width="100%" cellpadding="2" cellspacing="1" bgcolor="'.$border.'">
	<tr>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=ladders&action=edit&ID='.$ID.'">Edit Ladder</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=teams&laddID='.$ID.'">'.$participants.'</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=ladders&action=standings&ID='.$ID.'">Standings</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;Rules</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=ladders&action=admins&ID='.$ID.'">Admins</a></td>
        <td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=matches&laddID='.$ID.'">Matches</a></td>		
	</tr>
</table><br><br>'; 
	
if(ladderis1on1($laddID)) $participants = 'Manage Players';
else $participants = 'Manage Teams';
	
	
	$rule=safe_query("SELECT * FROM ".PREFIX."cup_rules WHERE ladID='".$laddID."'");
	$dd=mysql_fetch_array($rule);
	echo '<form method="post" name="post" action="admincenter.php?site=ladders">
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
	      <input name="ladID" type="hidden" value="'.$laddID.'" /></td>
	    </tr>
	  </table>
	</form>';
}elseif($_GET['action']=="standings") {

	$ID = $_GET['ID'];
	$laddID = $_GET['ID'];
	
pm_eligibility($laddID); //message group-stage eligibility status
check_standings($laddID); //debugging
punish($laddID); // credit deduction and removing idlers
rankagain($laddID); // rank those unranked with positive credit
qualifiersToLeague($laddID); //automatically insert qualifiers to league
check_winners(); //winners
match_query_type(); //type of matches
getladtimezone(); // timezone
	
	echo '<div class="infobox">You are able to make changes here, you can go back and use the "actual" stats by clicking <a href="admincenter.php?site=ladders&action=standings&do=reset&ID='.$laddID.'">here</a>.</div>';
	
//title ladder
	
$participantstyp = (ladderis1on1($laddID) ? 'Players' : 'Teams');	
	
echo '

<table width="100%" cellpadding="2" cellspacing="1" bgcolor="'.$border.'">
	<tr>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=ladders&action=edit&ID='.$ID.'">Edit Ladder</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=teams&laddID='.$ID.'">'.$participantstyp.'</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp; Standings</td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=ladders&action=rules&ID='.$ID.'">Rules</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=ladders&action=admins&ID='.$ID.'">Admins</a></td>
        <td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=matches&laddID='.$ID.'">Matches</a></td>		
	</tr>
</table><br><br>';

if($_GET['view']=='unranked') {
   $dis_rk_typ = '<input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=ladders&action=standings&ID='.$ID.'&view=ranked\');return document.MM_returnValue" value="View Ranked">';
   $and_display= '&view=unranked';
}else{
   $dis_rk_typ = '<input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=ladders&action=standings&ID='.$ID.'&view=unranked\');return document.MM_returnValue" value="View Unranked">';
   $and_display= '&view=ranked';
}
	
if($_GET['edit']!='true') {
   $edit_false = '<input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=ladders&action=standings&ID='.$ID.$and_display.'&edit=true\');return document.MM_returnValue" value="Open-Edit">';
   $show_reg = '<td class="title" align="center">Reg:</td>';
}else{
   $edit_false = '<input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=ladders&action=standings&ID='.$ID.$and_display.'\');return document.MM_returnValue" value="Close-Edit">';	
   $show_action = '<td class="title" align="center">Action:</td>';
}

$getladders = safe_query("SELECT * FROM ".PREFIX."cup_ladders WHERE ID='$laddID'");
$ld=mysql_fetch_array($getladders); 

 $order_sort = ($_GET['order']=='asc' ? "ASC" : "DESC");
 
 if(isset($_GET['sort'])) {
 
    if($_GET['sort']=='rank') {
	       $rank_by = "ORDER BY rank_now ".$order_sort;
	}
    elseif($_GET['sort']=='player') {
	       $rank_by = "ORDER BY clanID ".$order_sort;
	}
	elseif($_GET['sort']=='points') {
	       $rank_by = "ORDER BY tp ".$order_sort;
	}
	elseif($_GET['sort']=='win') {
	       $rank_by = "ORDER BY won ".$order_sort;
	}
	elseif($_GET['sort']=='draw') {
	       $rank_by = "ORDER BY draw ".$order_sort;
	}
	elseif($_GET['sort']=='loss') {
	       $rank_by = "ORDER BY lost ".$order_sort;
	}
	elseif($_GET['sort']=='streak') {
	       $rank_by = "ORDER BY streak ".$order_sort;
	}
	elseif($_GET['sort']=='elo') {
	       $rank_by = "ORDER BY elo ".$order_sort;
	}
 }
 else{

 switch($ld['ranksys']) 
 {
   case 1: $rank_by = "ORDER BY credit ".$order_sort;
   break;
   case 2: $rank_by = "ORDER BY xp ".$order_sort;
   break;
   case 3: $rank_by = "ORDER BY won ".$order_sort;
   break;
   case 4: $rank_by = "ORDER BY tp ".$order_sort;
   break;
   case 5: $rank_by = "ORDER BY wc ".$order_sort;
   break;
   case 6: $rank_by = "ORDER BY streak ".$order_sort;
   break;
   case 7: $rank_by = "ORDER BY elo ".$order_sort;
   break;
 }
} 
 
   $display_unranked = ($_GET['view']=='unranked' ? "0" : "1");
   $display_user_only= ($_GET['participantID']!=0 ? 'AND clanID='.$_GET['participantID'] : "");
   $display_limit = (!$display_user_only ? $limit_by : '');
   $standings_rank = 1;

   if(ladderis1on1($laddID))  {  
      $participants = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='$laddID' AND 1on1='1' AND checkin = '$display_unranked' $display_user_only $rank_by $display_limit");
   }
   else{
      $participants = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='$laddID' AND 1on1='0' AND checkin = '$display_unranked' $display_user_only $rank_by $display_limit");
   }
   
   if($display_unranked==1)
   $view_rk = "";
   else
   $view_rk = "";
   
   $view_rk = $display_unranked==1 ? "<a href='?site=ladders&action=standings&ID=".$laddID."&view=unranked'>(View Unranked)</a>" : "<a href='?site=ladders&action=standings&ID=".$laddID."'>(View Unranked)</a>";

	if(!mysql_num_rows($participants)) {
	       echo '<div class="warningbox">No participants found '.$view_rk.'</div>';
	}
	else
	{
	
 echo '<a name="standings"></a><h1>&nbsp; &#8226; '.getladname($laddID).' Standings (<a href="?site=cuptools">reset standings</a>) </h1>
  <table width="100%" cellpadding="9" cellspacing="1" bgcolor="#999999">
   <tr bgcolor="#FFFFFF">
    <td colspan="8">'.$edit_false.$dis_rk_typ.'</td>
   </tr>
   <tr>
    <td class="title" align="center">Rank:</td>
    <td class="title" align="center">Name:</td>
    <td class="title" align="center">CR / XP:</td>
    <td class="title" align="center">Won:</td>
    <td class="title" align="center">Draw:</td>
    <td class="title" align="center">Lost:</td>
    '.$show_reg.'
    '.$show_action.'
   </tr>';
	
	}
	
   while($ds=mysql_fetch_array($participants)) { $teamID = $ds['clanID'];
      
   $getmatches = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE ladID='$laddID' AND (clan1='$teamID' || clan2='$teamID')");
    $dm = mysql_fetch_array($getmatches);
    
/* ADMIN MANUAL ADDED STATS */

if(ladderis1on1($laddID)) 
  $ms=mysql_fetch_array(safe_query("SELECT won, draw, lost, streak, xp FROM ".PREFIX."cup_clans WHERE clanID='$teamID' AND ladID='$laddID' AND 1on1='1'")); 
else
  $ms=mysql_fetch_array(safe_query("SELECT won, draw, lost, streak, xp FROM ".PREFIX."cup_clans WHERE clanID='$teamID' AND ladID='$laddID' AND 1on1='0'"));  

    $won_matches = $ms['won'];
    $lost_matches = $ms['lost']; 
    $draw_matches = $ms['draw'];
    $xp_points = $ms['xp'];   
   
    if(empty($xp_points)) $xp = 0;
    else $xp = $xp_points;
    
    if(empty($won_matches)) $won = 0;
    else $won = $won_matches;
    
    if(empty($draw_matches)) $draw = 0;
    else $draw = $draw_matches;
    
    if(empty($lost_matches)) $lost = 0;
    else $lost = $lost_matches;

   if(ladderis1on1($laddID)) { 
   
        if(!getcountry($teamID)) {		
		      $country = '<img src="../images/flags/na.gif" border="0" align="left">';
		}
		else{
		      $country = '<img src="../images/flags/'.getcountry($teamID).'.gif" border="0" align="left">';
		}

        $user = '<a href="?site=profile&id='.$teamID.'">'.getnickname($teamID).'</a>';
   }
   else{
        if(getclancountry($teamID,0)=='na') {		
		      $country = '<img src="../images/flags/na.gif" border="0" align="left">';
		}
		else{
		      $country = '<img src="../images/flags/'.getclancountry($teamID).'.gif" border="0" align="left">';
		}
   
        $user = '<a href="?site=clans&action=show&clanID='.$teamID.'">'.getclanname($teamID).'</a>';
   }
   
   if($_GET['view']=='unranked') {
	         $rank = getrank($teamID,$_GET['ID'],'now',1);
   } else {
	         $rank = getrank($teamID,$_GET['ID'],'now',0);
   } 

if(isset($_GET['edit']) && $_GET['edit']=='true') {

        $returnTime = returnTime($ds['registered']);
        $streak = getstreak($teamID,$laddID);
    
		eval ("\$inctemp = \"".gettemplate("standings_content")."\";");
		echo $inctemp; 

}else

 echo '
   <tr bgcolor="#FFFFFF">
    <td width="5%" align="center">#'.$rank.'</td>
    <td align="center">'.$country.' '.$user.'</td>
    <td align="center">'.$ds['credit'].' / '.$xp.'</td>
    <td align="center">'.$won.'</td>
    <td align="center">'.$draw.'</td>
    <td align="center">'.$lost.'</td>
    <td align="center">'.returnTime($ds['registered']).'</td>
   </tr>'; 

      $standings_rank++;
   }echo '</table>'; 
}else{

  $query = safe_query("SELECT ID, platform FROM ".PREFIX."cup_platforms GROUP BY platform");
   if(!mysql_num_rows($query)) echo 'You must create at least one platform before you can create ladders. (<a href="admincenter.php?site=platforms&action=add">add platform</a>)';
   
  else{

	echo'<input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=ladders&action=add\');return document.MM_returnValue" value="New Ladder"> <input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=ladders&action=duplicate\');return document.MM_returnValue" value="Duplicate Ladder"> <input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=gameaccounts\');return document.MM_returnValue" value="Gameaccounts"><br><br>';

	$ergebnis=safe_query("SELECT * FROM ".PREFIX."cup_ladders ORDER BY ID DESC");
	$anz=mysql_num_rows($ergebnis);
	if($anz) {
   		echo'<form method="post" name="ws_cups" action="admincenter.php?site=ladders"><table width="100%" cellpadding="4" cellspacing="1" bgcolor="#999999">
	       		<tr bgcolor="#CCCCCC">
		     		<td class="title" align="center">Ladder:</td>
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
			if(ladderis1on1($ds['ID'])) {
				$cupinfo='(1on1)';
				$participants = 'Players';
			}else{
				$cupinfo= '('.$ds['type'].')';
				$participants = 'Teams';
			}
			
			if($ds['gs_start'] || $ds['gs_end']) {
			      $gs_true = '<img src="../images/cup/icons/groups.png" align="right">';
			}
			else{
			      $gs_true = '';
			}
			
          	echo'<tr bgcolor="#FFFFFF">

		       		<td><img src="../images/games/'.$ds['game'].'.gif" width="13" height="13" border="0"> '.$gs_true.$ds['ID'].' - <a href="../?site=ladders&ID='.$ds['ID'].'" target="_blank">'.$ds['name'].'</a> '.$cupinfo.'</td>
			   		<td align="center"><input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=ladders&action=standings&ID='.$ds['ID'].'\');return document.MM_returnValue" value="Standings"></td>
			   		<td align="center"><input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=matches&laddID='.$ds['ID'].'\');return document.MM_returnValue" value="Matches"></td>
                    <td align="center"><input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=teams&laddID='.$ds['ID'].'\');return document.MM_returnValue" value="'.$participants.'"></td>
			   		<td align="center"><input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=ladders&action=admins&ID='.$ds['ID'].'\');return document.MM_returnValue" value="Admins"></td>					
					<td align="center"><input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=ladders&action=rules&ID='.$ds['ID'].'\');return document.MM_returnValue" value="Rules"></td>
			   		<td align="center"><input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=ladders&action=edit&ID='.$ds['ID'].'\');return document.MM_returnValue" value="Edit"</td>
			   		<td align="center"><input type="button" class="button" onClick="MM_confirm(\'Are you sure you want to delete this ladder? This will also delete: ladder admins/deductions/tickets/challenges/participants/matches/rules and groupstage participants/matches.\', \'admincenter.php?site=ladders&delete=true&ID='.$ds[ID].'\')" value="Delete"></td>
			 	</tr>';		 	
		}
		echo'<tr bgcolor="#CCCCCC"></table></form>';
	}
	else echo'no cups available';
  }		
}	
?>

<script>
// time start
document.getElementById('ourinput4').onchange = function() {
  var display = this.selectedIndex == <?php echo (isset($_GET['action']) && $_GET['action']=='edit' ? 5 : 6); ?> ? "inline" : "none";
  document.getElementById('custom4').style.display = display;
}
// time end
document.getElementById('ourinput5').onchange = function() {
  var display = this.selectedIndex == <?php echo (isset($_GET['action']) && $_GET['action']=='edit' ? 8 : 9); ?> ? "inline" : "none";
  document.getElementById('custom5').style.display = display;
}
// time intervals
document.getElementById('ourinput6').onchange = function() {
  var display = this.selectedIndex == <?php echo (isset($_GET['action']) && $_GET['action']=='edit' ? 8 : 9); ?> ? "inline" : "none";
  document.getElementById('custom6').style.display = display;
}
// time to respond
document.getElementById('ourinput7').onchange = function() {
  var display = this.selectedIndex == <?php echo (isset($_GET['action']) && $_GET['action']=='edit' ? 14 : 15); ?> ? "inline" : "none";
  document.getElementById('custom7').style.display = display;
}
// time to finalize
document.getElementById('ourinput8').onchange = function() {
  var display = this.selectedIndex == <?php echo (isset($_GET['action']) && $_GET['action']=='edit' ? 14 : 15); ?> ? "inline" : "none";
  document.getElementById('custom8').style.display = display;
}
// challenge up
document.getElementById('ourinput9').onchange = function() {
  var display = this.selectedIndex == 5 ? "inline" : "none";
  document.getElementById('custom9').style.display = display;
}
// challenge down
document.getElementById('ourinput10').onchange = function() {
  var display = this.selectedIndex == 6 ? "inline" : "none";
  document.getElementById('custom10').style.display = display;
}
// play days
document.getElementById('ourinput11').onchange = function() {
  var display = this.selectedIndex == 5 ? "inline" : "none";
  document.getElementById('custom11').style.display = display;
}
// inactive drop
document.getElementById('ourinput12').onchange = function() {
  var display = this.selectedIndex == 9 ? "inline" : "none";
  document.getElementById('custom12').style.display = display;
}
// remove inactive
document.getElementById('ourinput13').onchange = function() {
  var display = this.selectedIndex == 8 ? "inline" : "none";
  document.getElementById('custom13').style.display = display;
}
// inactive drop credit
document.getElementById('ourinput14').onchange = function() {
  var display = this.selectedIndex == 5 ? "inline" : "none";
  document.getElementById('custom14').style.display = display;
}
</script>
