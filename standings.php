<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js" type="text/javascript"></script>
<script type="text/javascript">

$(document).ready(function(){
        $(".slidingDiv_lc").hide();
        $(".show_hide_lc").show();
	
	    $('.show_hide_lc').click(function(){
	    $(".slidingDiv_lc").slideToggle();
	    });
	
        $(".slidingDiv_de").hide();
        $(".show_hide_de").show();
	
	    $('.show_hide_de').click(function(){
	    $(".slidingDiv_de").slideToggle();
	    });
	
        $(".slidingDiv_rm").hide();
        $(".show_hide_rm").show();
	
	    $('.show_hide_rm').click(function(){
	    $(".slidingDiv_rm").slideToggle();
	    });
});

</script>

<script language="javascript" type="text/javascript" src="js/tchat.js"></script>
<link href="css/tchat.css" rel="stylesheet" type="text/css" />
<link href="cup.css" rel="stylesheet" type="text/css">

<style>
#turnierbaum_div {
	width:100%;
	overflow: auto;
}

/* exploder V6 only */
* html #turnierbaum_div {
	overflow-x: scroll;
    overflow-y: visible;
}

/* exploder V7 only */
*+html #turnierbaum_div {
	overflow-x: scroll;
    overflow-y: visible;
}
</style>
<div id="turnierbaum_div">

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/">

<head>
<script language="javascript">wmtt = null; document.onmousemove = updateWMTT; function updateWMTT(e) { x = (document.all) ? window.event.x + document.body.scrollLeft : e.pageX; y = (document.all) ? window.event.y + document.body.scrollTop  : e.pageY; if (wmtt != null) { wmtt.style.left=(x + 20) + "px"; wmtt.style.top=(y + 20) + "px"; } } function showWMTT(id) {	wmtt = document.getElementById(id);	wmtt.style.display = "block" } function hideWMTT() { wmtt.style.display = "none"; }</script>
<?php $lad2=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_ladders WHERE ID='".$_GET['ladderID']."'")); ?>

<div class="tooltip" id="deducted" align="center"><strong><?php echo $lad2['deduct_credits']; ?></strong> credits deducted every <strong><?php echo Sec2Time($lad2['inactivity']); ?></strong> participant is inactive.</div>
<div class="tooltip" id="remaining" align="center">The remaining credits after deduction. Reaching zero credits will result in unranking. To be ranked again you must go against another unranked participant and win the match. <br /><br />Participants inactive for <strong><?php echo Sec2Time($lad2['remove_inactive']); ?></strong> will result in automatic removal from the ladder.</div>
<div class="tooltip" id="unranking" align="center">Reaching zero credits will result in unranking. To be ranked again you must go against another unranked participant and win the match. </div>
<div class="tooltip" id="inactive_removal" align="center">Participants inactive for <strong><?php echo Sec2Time($lad2['remove_inactive']); ?></strong> will result in removal from the ladder.</div>

<?php include ("config.php"); ?>

<style>
	.rPosButton{
		background: <?php echo $custom_bar_bg==1 ? $bar_bg : BG_1; ?>;
		border-radius: 3px;
	 	position:relative;
		float:left;
		border:1px solid <?php echo $custom_bar_bg==1 ? $bar_border : PAGEBG; ?>;
		width:13px;
		cursor:pointer	
	}
	.rPosButton:hover{		
        background: <?php echo $custom_bar_bg==1 ? $bar_hover : BGHEAD; ?>;
		border-radius: 3px;
        background-repeat:repeat-x;
		
	}
	.rPosButton.active{
        background: <?php echo $custom_bar_bg==1 ? $bar_active : BGHEAD; ?>;
		border-radius: 3px;
        background-repeat:repeat-x;

		
	}
</style>

</head>

<body>
<div id="Content">

<?php
$num_per_page = 20;
$start = (isset($_GET['start']) && (int)$_GET['start'] > 0) ? (int)$_GET['start'] : 1;
$viewing_unranked = (isset($_GET['display']) && $_GET['display']=='unranked' ? '&display=unranked' : '');

if(isset($_GET['display']))
$display = $_GET['display'];
else $display = false;

if(isset($_GET['view']))
$views = $_GET['view'];
else $views = false;

// where am i?
if(isset($_GET['participantID']) && $_GET['participantID']) {
   $participantID = $_GET['participantID'];
   $viewing_tm = getname1($participantID,$_GET['ladderID'],0,"ladder",1). " >>";
}
else{
   $participantID = false;
}

if((($start - 1) % $num_per_page) != 0){
	$start = 1;
}

$bars = '';
$rows = '';
$limit_by = 'LIMIT ' . ($start - 1) . ', 20';

$dis_unrank = ((isset($_GET['display']) && $_GET['display']=='unranked') ? "checkin='0'" : "checkin='1'");
$dis_user_only= ($participantID!=0 ? 'AND clanID='.$participantID : "");

$ap=mysqli_fetch_array(safe_query("SELECT count(*) as number FROM ".PREFIX."cup_clans WHERE ladID='".$_GET['ladderID']."' && $dis_unrank $dis_user_only"));

for($i = 1; $i <= $ap['number']; $i += $num_per_page){
    $rows++;
}

for($i = 1; $i <= $ap['number']; $i += $num_per_page){
	$active = ($i == $start) ? ' active' : '';
	$from = $i - 1;
	$to = $i + $num_per_page - 1;
	
	if($i == $start) { 
	   $show_rankings = '&& rank_now >= '.$from.' && rank_now <= '.$to;
	   $page_up = $i + 20;
	}
	else{
	    $show_rankings = '';
	}
	
	$page_down = $start - 20;
	
	if($start===1) {
	   $button_prev = '<img id="myImage" src="images/cup/icons/add.png">';
	}
	else{
	   $button_prev = '<a href="?site=standings&ladderID='.$_GET['ladderID'].'&start='.$page_down.$viewing_unranked.'"><img src="images/cup/icons/add.png"></a>';
	}

	
	echo '<div class="tooltip" id="'.$from.'" align="center"><h2>Show Rankings:</h2><strong>'.$i.' - '.$to.'</strong></div>';
	
	$getladder = safe_query("SELECT * FROM ".PREFIX."cup_ladders WHERE ID='".$_GET['ladderID']."'");
	
    $ld=mysqli_fetch_array($getladder);
    $laddID = $ld['ID'];
 
    switch($ld['ranksys']) 
    {
      case 1: $rank_by = "ORDER BY credit DESC";
      break;
      case 2: $rank_by = "ORDER BY xp DESC";
      break;
      case 3: $rank_by = "ORDER BY won DESC";
      break;
      case 4: $rank_by = "ORDER BY tp DESC";
      break;
      case 5: $rank_by = "ORDER BY wc DESC";
      break;
      case 6: $rank_by = "ORDER BY streak DESC";
      break;
      case 7: $rank_by = "ORDER BY elo DESC";
      break;
    }
	
    $display_unranked = ($_GET['display']=='unranked' ? "0" : "1");
    $display_user_only= ($participantID!=0 ? 'AND clanID='.$participantID : "");
    $display_limit = (!$display_user_only ? $limit_by : '');
   
    if(ladderis1on1($_GET['ladderID']))  {  
       $participants = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='".$_GET['ladderID']."' AND 1on1='1' AND checkin = '$display_unranked' $display_user_only $rank_by $display_limit");
    }
    else{
       $participants = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='".$_GET['ladderID']."' AND 1on1='0' AND checkin = '$display_unranked' $display_user_only $rank_by $display_limit");
    }
   
	
    if(mysqli_num_rows($participants) < 20) {
	      $height = 12.5 * mysqli_num_rows($participants);
	}
	elseif($ap['number'] < 21) {
	      $height = 430;
	}
	else{
	      $height = 740 / $rows;
	}

   
	$to_next = $to-19;
    $onclick = "onclick=\"location.href='?site=standings&ladderID=$_GET[ladderID]&start=$to_next$viewing_unranked';\"";  
    $bars .= "<div name='{$from}' id='{$from}' onmouseover='showWMTT({$from})' onmouseout='hideWMTT()' class='rPosButton{$active}' style='text-decoration:none; cursor:URL; height: {$height}px;' {$onclick}>&nbsp;</div>";
}

   $one_query = (ladderis1on1($_GET['ladderID']) ? "1on1='1'" : "1on1='0'");
 
?>

<!-- TITLE CUP -->

<?php include("title_ladder.php"); ?>

<link href="cup.css" rel="stylesheet" type="text/css">

<style>
#myImage {
    opacity : 0.5;
    filter: alpha(opacity=40); // msie
}
</style>

<script language="javascript">wmtt = null; document.onmousemove = updateWMTT; function updateWMTT(e) { x = (document.all) ? window.event.x + document.body.scrollLeft : e.pageX; y = (document.all) ? window.event.y + document.body.scrollTop  : e.pageY; if (wmtt != null) { wmtt.style.left=(x + 20) + "px"; wmtt.style.top=(y + 20) + "px"; } } function showWMTT(id) {	wmtt = document.getElementById(id);	wmtt.style.display = "block" } function hideWMTT() { wmtt.style.display = "none"; }</script>

<?php
pm_eligibility($_GET['ladderID']); //message group-stage eligibility status
check_standings($_GET['ladderID']); //debugging
punish($_GET['ladderID']); // credit deduction and removing idlers
rankagain($_GET['ladderID']); // rank those unranked with positive credit
qualifiersToLeague($_GET['ladderID']); //automatically insert qualifiers to league
check_winners(); //winners
match_query_type(); //type of matches
getladtimezone(); // timezone
$gmt = getladtimezone(1);

if(mb_substr(basename($_SERVER['REQUEST_URI']),0,9) != "index.php") {
   $view = '<a href="index.php?site=standings&ladderID='.$_GET['ladderID'].'">Contract Standings</a>';
}
else{
   $view = '<a href="popup.php?site=standings&ladderID='.$_GET['ladderID'].'">Expand Standings</a>';
}

$_language->read_module('ladders');
$_language->read_module('cupactions');

$bg1=BG_1;
$bg2=BG_1;
$bg3=BG_1;
$bg4=BG_1;
$cpr=ca_copyr();
if(!$cpr || !ca_copyr()) die();

if(isset($_GET['ladderID']))
$_ladderID = $_GET['ladderID'];
else $_ladderID = false;

if(isset($_GET['laddID'])) 
$_laddID = $_GET['laddID'];
else $_laddID = false;

if(isset($_GET['challID']))
$_challID = $_GET['challID'];
else $_challID = false;

$laddID = mysqli_real_escape_string($_ladderID);
$ladID = mysqli_real_escape_string($_laddID);
$ID = mysqli_real_escape_string($_challID);
$laddname = getladname($ladID);

  if(platform_enabled($laddID)=="true" || platform_enabled($_GET['laddID'])=="true") {

    $ladder_settings = safe_query("SELECT * FROM ".PREFIX."cup_ladders WHERE ID='$laddID' || ID='$ladID'");
    $lad = mysqli_fetch_array($ladder_settings);


$getstatus = safe_query("SELECT * FROM ".PREFIX."cup_challenges WHERE chalID='$ID'");
$ch = mysqli_fetch_array($getstatus); {

if(ladderis1on1($ch['ladID'])) {

    $name1 = getnickname($ch['challenger']);
    $name2 = getnickname($ch['challenged']);
    $s = '';

  $challenger = '<a href="index.php?site=profile&id='.$ch['challenger'].'"><b>'.$name1.'</b></a>';
  $challenged = '<a href="index.php?site=profile&id='.$ch['challenged'].'"><b>'.$name2.'</b></a>';

 }
 else{

    $name1 = getclanname($ch['challenger']);
    $name2 = getclanname($ch['challenged']);
    $s = '';
 
  $challenger = '<a href="index.php?site=clans&action=show&clanID='.$ch['challenger'].'"><b>'.$name1.'</b></a>';
  $challenged = '<a href="index.php?site=clans&action=show&clanID='.$ch['challenged'].'"><b>'.$name2.'</b></a>';

}

  if($ch['forfeit']==$ch['challenger']) {
      $step = '(did not accept with '.$challenged.''.$s.' finalized selections)';
  }
  elseif($ch['forfeit']==$ch['challenged']) {
     $step = '(did not accept '.$challenger.''.$s.' challenge request)';
  }

  if($ch['status']==4 && $ch['forfeit']==$ch['challenger']){
     $status2 = $challenged.' won by forfeit (<b>+'.$forfeitaward.'</b>)<br>(did not finalize in time)';
  }
  elseif($ch['status']==4 && $ch['forfeit']==$ch['challenged']){
     $status2 = $challenger.' won by forfeit (<b>+'.$forfeitaward.'</b>)<br>(did not respond in time)';
  }
  elseif($ch['status']==5 && $ch['forfeit']==$ch['challenger']){
     $status2 = '<font color="#DD0000"><b>Forfeited</b></font> by '.$challenger.' '.$step.'';
  }   
  elseif($ch['status']==5 && $ch['forfeit']==$ch['challenged']){
     $status2 = '<font color="#DD0000"><b>Forfeited</b></font> by '.$challenged.'';
  }   
  elseif($ch['status']==1){
     $status2 = 'Waiting for '.$challenged.''.$s;
  }   
  elseif($ch['status']==2){
     $status2 = 'Waiting for '.$challenger.''.$s;
  }   
  elseif($ch['status']==3) {{
     $status2 = '<img border="0" src="images/cup/icons/add_result.gif"> <a href="index.php?site=cup_matches&match='.$ch['chalID'].'&laddID='.$ch['ladID'].'">Match Details</a><br><img src="images/cup/success.png"> Challenge Complete';
  }
  
 if(ladderis1on1($ch['ladID'])) {

  if($userID==$ch['challenger']) {
     $status4 = '<img border="0" src="images/cup/icons/edit.png"> <a href="index.php?site=matches&action=viewmatches&clanID='.$ch['challenger'].'&laddID='.$ch['ladID'].'&type=1">Match Reporting</a>';
  }
  elseif($userID==$ch['challenged']){
     $status4 = '<img border="0" src="images/cup/icons/edit.png"> <a href="index.php?site=matches&action=viewmatches&clanID='.$ch['challenged'].'&laddID='.$ch['ladID'].'&type=1">Match Reporting</a>';
  }
  
 }
 else{

   $userteams = safe_query("SELECT clanID FROM ".PREFIX."cup_clan_members WHERE userID='$userID'");
   while($ut=mysqli_fetch_array($userteams))
   { 
   
    if($ut['clanID']==$ch['challenger']) {
       $status4 = '<img border="0" src="images/cup/icons/edit.png"> <a href="index.php?site=matches&action=viewmatches&clanID='.$ch['challenger'].'&laddID='.$ch['ladID'].'">Match Reporting</a>';
    }
    elseif($ut['clanID']==$ch['challenged']){
       $status4 = '<img border="0" src="images/cup/icons/edit.png"> <a href="index.php?site=matches&action=viewmatches&clanID='.$ch['challenged'].'&laddID='.$ch['ladID'].'">Match Reporting</a>';
    }
  }
}  
  }
}
	
	$day = date('d');
	$month = date('m');
	$year = date('Y');
	$hour = date('H');
	$min = date('i');
	$date = @mktime($hour, $min, 0, $month, $day, $year);


$laddsettings = safe_query("SELECT * FROM ".PREFIX."cup_ladders WHERE ID='$ladID'");
$ds = mysqli_fetch_array($laddsettings);

$credits1 = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='".$ladID."' AND clanID='".$ch['challenger']."'");
$credits2 = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='".$ladID."' AND clanID='".$ch['challenged']."'");

$cd1 = mysqli_fetch_array($credits1);
$cd2 = mysqli_fetch_array($credits2);

$team1_forfeit_loss = $cd1['credit']-$forfeitloss;
$team2_forfeit_loss = $cd2['credit']-$forfeitloss;
$team1_forfeit_award = $cd1['credit']+$forfeitaward;
$team2_forfeit_award = $cd2['credit']+$forfeitaward;

$t1_totalp_loss = $cd1['credit']+$cd1['xp']-$forfeitloss;
$t2_totalp_loss = $cd2['credit']+$cd2['xp']-$forfeitloss;  
$t1_totalp_award = $cd1['credit']+$cd1['xp']+$forfeitaward;
$t2_totalp_award = $cd2['credit']+$cd2['xp']+$forfeitaward;     

$team1_loss = $cd1['lost']+1;
$team2_loss = $cd2['lost']+1;
$team1_won = $cd1['won']+1;
$team2_won = $cd2['won']+1;
$team1_streak_won = $cd1['streak']+1;
$team2_streak_won = $cd2['streak']+1;

    if(isset($_POST['newchallenge'])) 
    { 
     if($userID==$_POST['challenger'] || isleader($userID,$_POST['challenger'])) 
     {

        safe_query("UPDATE ".PREFIX."cup_clans SET lastact = '".time()."' WHERE clanID='".$_POST['challenger']."' AND ladID='".$_GET['laddID']."'");
        safe_query("INSERT INTO ".PREFIX."cup_challenges (ladID, challenger, challenged, new_date, server, port, serverc, challenger_info, status) VALUES ('".$_GET['laddID']."', '".$_POST['challenger']."', '".$_GET['challenged']."', '$date', '".$_POST['server']."', '".$_POST['port']."', '".$_POST['serverc']."', '".$_POST['info']."', '1')");
      $challID = mysqli_insert_id();
	  
/* EMAIL (1ST STEP)*/

$to_ds1=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."user WHERE userID='".$_POST['challenger']."'"));
$to_ds2=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."user WHERE userID='".$_POST['challenged']."'"));
$c_clan=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_challenges WHERE chalID='$challID'"));
$do=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."settings"));
$dt=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."styles"));

$sender_from = $do['adminemail'];
$challenger_ma = $c_clan['challenger'];
$challenged_ma = $c_clan['challenged'];
$timetorespond = $c_clan['new_date']+$lad['timetorespond'];
$timetofinalize = $c_clan['reply_date']+$lad['timetofinalize'];

// multiple recipients

if(ladderis1on1($_GET['laddID'])) {

$to = array($to_ds1[email], $to_ds2[email]); 
$ni = array($to_ds1[nickname], $to_ds2[nickname]);

}
else{

$query = safe_query("SELECT * FROM ".PREFIX."cup_clan_members WHERE clanID='$challenger_ma'");
  while($to_ds3 = mysqli_fetch_array($query)) {
  
    $to_email1=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."user WHERE userID='".$to_ds3['userID']."'"));
	
	if(isleader($to_ds3['userID'],$challenger_ma)) {
      $to[]=$to_email1['email'];
	  $ni[]=$to_email1['nickname'];
	}
}

$query = safe_query("SELECT * FROM ".PREFIX."cup_clan_members WHERE clanID='$challenged_ma'");
  while($to_ds4 = mysqli_fetch_array($query)) {
  
    $to_email2=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."user WHERE userID='".$to_ds4['userID']."'"));
    
	if(isleader($to_ds4['userID'],$challenged_ma)) {
	  $to[]=$to_email2['email'];
	  $ni[]=$to_email2['nickname'];
    }  
  }
}

// subject
$subject = 'Ladder Challenge Notification (1st Step)';

foreach($ni as $nick) {

$get_userd=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."user WHERE nickname='$nick'"));
$nicks[] = $nick;

// message
$message = '
<html>
<head>
  <title>Ladder Challenge Notification (1st Step)</title>
</head>
<body>
  '.$notify_admin.'
  To '.implode(", ", $nicks).'<br><br>
  A new challenge has been made! You can view or respond to this challenge at: http://'.getinput($do['hpurl']).'/?site=standings&action=viewchallenge&laddID='.$_GET['laddID'].'&challID='.$challID.'<br><br>
  Ladder: <a href="http://'.getinput($do['hpurl']).'/?site=ladders&ID='.$_GET['laddID'].'">'.$laddname.'</a><br>
  Challenger: '.getname2($challenger_ma,$_GET['laddID'],0,"ladder").' <br>
  Challenged: '.getname2($challenged_ma,$_GET['laddID'],0,"ladder").' <br>
  <br>
  <b>WARNING:</b> '.getname2($challenged_ma,$_GET['laddID'],0,"ladder").' must respond before <b>'.date('l M dS Y \@\ g:i a', $timetorespond).'</b>.<br> Otherwise, a forfeit will be awarded to '.getname2($challenger_ma,$_GET['laddID'],0,"ladder").'<br>
  <br>
  Sent From: '.getinput($dt['title']).'  
</body>
</html>';
}

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";



// Additional headers
foreach($to as $email) {
  $headers .= 'To: '.$to[$n] . "\r\n"; }
  $headers .= 'From: '.$dt['title'].' <'.$sender_from.'>' . "\r\n";
  //$headers .= 'Cc: '.$sender_from . "\r\n";

// Mail it
foreach($to as $email) {
  mail($email, $subject, $message, $headers);
}

/* END EMAIL (1ST STEP) */
	  
   	  redirect('?site=standings&action=viewchallenge&laddID='.$ladID.'&challID='.$challID.'', '', 2);

   	 }

    }
    elseif(isset($_POST['challengedforfeits'])) 
    {
      safe_query("UPDATE ".PREFIX."cup_clans SET credit='$team2_forfeit_loss', lastpos='2', tp='$t2_totalp_loss' WHERE clanID='".$ch['challenged']."' && ladID='".$ch['ladID']."'");
      safe_query("UPDATE ".PREFIX."cup_clans SET credit='$team1_forfeit_award', lastpos='1', tp='$t1_totalp_award' WHERE clanID='".$ch['challenger']."' && ladID='".$ch['ladID']."'");
      safe_query("UPDATE ".PREFIX."cup_challenges SET chr_credit='".getcredits($ch['challenger'],$ch['ladID'])."', chd_credit='".getcredits($ch['challenged'],$ch['ladID'])."', status='5', forfeit='".$ch['challenged']."', reply_date='".time()."' WHERE chalID='$ID'");
   	  redirect('?site=standings&action=viewchallenge&laddID='.$ladID.'&challID='.$ID.'', '<b>Forfeit complete</b><br>Redirecting to challenge details...', 2);
    }
    elseif(isset($_POST['challengerforfeits'])) 
    {   	 
      safe_query("UPDATE ".PREFIX."cup_clans SET credit='$team1_forfeit_loss', lastpos='2', tp='$t1_totalp_loss' WHERE clanID='".$ch['challenger']."' && ladID='".$ch['ladID']."'");
      safe_query("UPDATE ".PREFIX."cup_clans SET credit='$team2_forfeit_award', lastpos='1', tp='$t2_totalp_award' WHERE clanID='".$ch['challenged']."' && ladID='".$ch['ladID']."'");
      safe_query("UPDATE ".PREFIX."cup_challenges SET chr_credit='".getcredits($ch['challenger'],$ch['ladID'])."', chd_credit='".getcredits($ch['challenged'],$ch['ladID'])."', status='5', forfeit='".$ch['challenger']."', finalized_date='".time()."' WHERE chalID='$ID'");
   	  redirect('?site=standings&action=viewchallenge&laddID='.$ladID.'&challID='.$ID.'', '<b>Forfeit complete</b><br>Redirecting to challenge details...', 2);
    }
    elseif(isset($_POST['replychallenge'])) 
    {
	
	$error = array();

     if($ds['select_map']==1) 
     {
       if($_POST['map1']==$_POST['map2'] || 
          $_POST['map1']==$_POST['map3'] ||
          $_POST['map1']==$_POST['map4'] || 
          $_POST['map1']==$_POST['map5'])
        $error[]='Map option 1 has been selected multiple times';
        $select_map = "map1='".$_POST['map1']."',";

     }
     elseif($ds['select_map']==2) 
     {
       if($_POST['map1']==$_POST['map2'] || 
          $_POST['map1']==$_POST['map3'] || 
          $_POST['map1']==$_POST['map4'] || 
          $_POST['map1']==$_POST['map5'])
        $error[]='Map option 1 has been selected multiple times';
        
       if($_POST['map2']==$_POST['map1'] || 
          $_POST['map2']==$_POST['map3'] || 
          $_POST['map2']==$_POST['map4'] || 
          $_POST['map2']==$_POST['map5'])
        $error[]='Map option 2 has been selected multiple times';
        
        $select_map = "map1='".$_POST['map1']."', 
                       map2='".$_POST['map2']."',";
                       
     }
     elseif($ds['select_map']==3) 
     {
       if($_POST['map1']==$_POST['map2'] || 
          $_POST['map1']==$_POST['map3'] || 
          $_POST['map1']==$_POST['map4'] || 
          $_POST['map1']==$_POST['map5'])
        $error[]='Map option 1 has been selected multiple times';

       if($_POST['map2']==$_POST['map1'] || 
          $_POST['map2']==$_POST['map3'] || 
          $_POST['map2']==$_POST['map4'] || 
          $_POST['map2']==$_POST['map5'])
        $error[]='Map option 2 has been selected multiple times';

       if($_POST['map3']==$_POST['map2'] || 
          $_POST['map3']==$_POST['map1'] || 
          $_POST['map3']==$_POST['map4'] || 
          $_POST['map3']==$_POST['map5'])
        $error[]='Map option 3 has been selected multiple times';
        
        $select_map = "map1='".$_POST['map1']."', 
                       map2='".$_POST['map2']."', 
                       map3='".$_POST['map3']."',";

                       
     }
     elseif($ds['select_map']==4) 
     {
       if($_POST['map1']==$_POST['map2'] || 
          $_POST['map1']==$_POST['map3'] || 
          $_POST['map1']==$_POST['map4'] || 
          $_POST['map1']==$_POST['map5'])
        $error[]='Map option 1 has been selected multiple times';
        
       if($_POST['map2']==$_POST['map1'] || 
          $_POST['map2']==$_POST['map3'] || 
          $_POST['map2']==$_POST['map4'] || 
          $_POST['map2']==$_POST['map5'])
        $error[]='Map option 2 has been selected multiple times';        

       if($_POST['map3']==$_POST['map2'] || 
          $_POST['map3']==$_POST['map1'] || 
          $_POST['map3']==$_POST['map4'] || 
          $_POST['map3']==$_POST['map5'])
        $error[]='Map option 3 has been selected multiple times';
        
       if($_POST['map4']==$_POST['map2'] || 
          $_POST['map4']==$_POST['map3'] || 
          $_POST['map4']==$_POST['map1'] || 
          $_POST['map4']==$_POST['map5'])
        $error[]='Map option 4 has been selected multiple times';  

        $select_map = "map1='".$_POST['map1']."',
                       map2='".$_POST['map2']."', 
                       map3='".$_POST['map3']."', 
                       map4='".$_POST['map4']."',";
                      
     }
     elseif($ds['select_map']==5) 
     {
       if($_POST['map1']==$_POST['map2'] || 
          $_POST['map1']==$_POST['map3'] || 
          $_POST['map1']==$_POST['map4'] || 
          $_POST['map1']==$_POST['map5'])
        $error[]='Map option 1 has been selected multiple times';

       if($_POST['map2']==$_POST['map1'] || 
          $_POST['map2']==$_POST['map3'] || 
          $_POST['map2']==$_POST['map4'] || 
          $_POST['map2']==$_POST['map5'])
        $error[]='Map option 2 has been selected multiple times';

       if($_POST['map3']==$_POST['map2'] || 
          $_POST['map3']==$_POST['map1'] || 
          $_POST['map3']==$_POST['map4'] || 
          $_POST['map3']==$_POST['map5'])
        $error[]='Map option 3 has been selected multiple times';

       if($_POST['map4']==$_POST['map2'] || 
          $_POST['map4']==$_POST['map3'] || 
          $_POST['map4']==$_POST['map1'] || 
          $_POST['map4']==$_POST['map5'])
        $error[]='Map option 4 has been selected multiple times';
        
       if($_POST['map5']==$_POST['map2'] || 
          $_POST['map5']==$_POST['map3'] || 
          $_POST['map5']==$_POST['map4'] || 
          $_POST['map5']==$_POST['map1'])
        $error[]='Map option 5 has been selected multiple times';

        $select_map = "map1='".$_POST['map1']."', 
                       map2='".$_POST['map2']."', 
                       map3='".$_POST['map3']."', 
                       map4='".$_POST['map4']."', 
                       map5='".$_POST['map5']."',";
     }
     else
        $select_map = '';
        
     if($ds['select_date']==1) 
     {
       if($_POST['date1']==$_POST['date2'] || 
          $_POST['date1']==$_POST['date3'] || 
          $_POST['date1']==$_POST['date4'] || 
          $_POST['date1']==$_POST['date5'])        
        $error[]='Date option 1 has been selected multiple times';
        
        $select_date = "date1='".$_POST['date1']."',";

     }
     elseif($ds['select_date']==2) 
     {
       if($_POST['date1']==$_POST['date2'] || 
          $_POST['date1']==$_POST['date3'] || 
          $_POST['date1']==$_POST['date4'] ||
          $_POST['date1']==$_POST['date5'])
        $error[]='Date option 1 has been selected multiple times';
        
       if($_POST['date2']==$_POST['date1'] || 
          $_POST['date2']==$_POST['date3'] || 
          $_POST['date2']==$_POST['date4'] || 
          $_POST['date2']==$_POST['date5'])
        $error[]='Date option 2 has been selected multiple times';

        $select_date = "date1='".$_POST['date1']."', 
                        date2='".$_POST['date2']."',";

     }
     elseif($ds['select_date']==3) 
     {
       if($_POST['date1']==$_POST['date2'] || 
          $_POST['date1']==$_POST['date3'] || 
          $_POST['date1']==$_POST['date4'] || 
          $_POST['date1']==$_POST['date5'])
        $error[]='Date option 1 has been selected multiple times';

       if($_POST['date2']==$_POST['date1'] || 
          $_POST['date2']==$_POST['date3'] || 
          $_POST['date2']==$_POST['date4'] || 
          $_POST['date2']==$_POST['date5'])
        $error[]='Date option 2 has been selected multiple times';

       if($_POST['date3']==$_POST['date2'] ||
          $_POST['date3']==$_POST['date1'] || 
          $_POST['date3']==$_POST['date4'] || 
          $_POST['date3']==$_POST['date5'])
        $error[]='Date option 3 has been selected multiple times';
        
        $select_date = "date1='".$_POST['date1']."', 
                        date2='".$_POST['date2']."', 
                        date3='".$_POST['date3']."',";                    

     }
     elseif($ds['select_date']==4) 
     {

       if($_POST['date1']==$_POST['date2'] || 
          $_POST['date1']==$_POST['date3'] || 
          $_POST['date1']==$_POST['date4'] || 
          $_POST['date1']==$_POST['date5'])
        $error[]='Date option 1 has been selected multiple times';

       if($_POST['date2']==$_POST['date1'] || 
          $_POST['date2']==$_POST['date3'] || 
          $_POST['date2']==$_POST['date4'] || 
          $_POST['date2']==$_POST['date5'])
        $error[]='Date option 2 has been selected multiple times';

       if($_POST['date3']==$_POST['date2'] || 
          $_POST['date3']==$_POST['date1'] || 
          $_POST['date3']==$_POST['date4'] || 
          $_POST['date3']==$_POST['date5'])
        $error[]='Date option 3 has been selected multiple times';
        
       if($_POST['date4']==$_POST['date2'] || 
          $_POST['date4']==$_POST['date3'] || 
          $_POST['date4']==$_POST['date1'] || 
          $_POST['date4']==$_POST['date5'])
        $error[]='Date option 4 has been selected multiple times';

        $select_date = "date1='".$_POST['date1']."', 
                        date2='".$_POST['date2']."', 
                        date3='".$_POST['date3']."', 
                        date4='".$_POST['date4']."',";
                        
     }
     elseif($ds['select_date']==5) 
     {
       if($_POST['date1']==$_POST['date2'] || 
          $_POST['date1']==$_POST['date3'] || 
          $_POST['date1']==$_POST['date4'] || 
          $_POST['date1']==$_POST['date5'])
        $error[]='Date option 1 has been selected multiple times';
        
       if($_POST['date2']==$_POST['date1'] || 
          $_POST['date2']==$_POST['date3'] || 
          $_POST['date2']==$_POST['date4'] || 
          $_POST['date2']==$_POST['date5'])
        $error[]='Date option 2 has been selected multiple times';

       if($_POST['date3']==$_POST['date2'] || 
          $_POST['date3']==$_POST['date1'] || 
          $_POST['date3']==$_POST['date4'] || 
          $_POST['date3']==$_POST['date5'])
        $error[]='Date option 3 has been selected multiple times';

       if($_POST['date4']==$_POST['date2'] || 
          $_POST['date4']==$_POST['date3'] || 
          $_POST['date4']==$_POST['date1'] || 
          $_POST['date4']==$_POST['date5'])
        $error[]='Date option 4 has been selected multiple times';

       if($_POST['date5']==$_POST['date2'] || 
          $_POST['date5']==$_POST['date3'] || 
          $_POST['date5']==$_POST['date4'] || 
          $_POST['date5']==$_POST['date1'])
        $error[]='Date option 5 has been selected multiple times';
        
        $select_date = "date1='".$_POST['date1']."', 
                        date2='".$_POST['date2']."', 
                        date3='".$_POST['date3']."', 
                        date4='".$_POST['date4']."', 
                        date5='".$_POST['date5']."',";
     }
     else
        $select_date = ',';
        
      if($ch['serverc'] || (!$ch['server'] && !$ch['port'])) {
         $postserver = "server='".$_POST['server']."', port='".$_POST['port']."',"; 
      }
	  
	  if(count($error)) {
	    	$list = implode('<br />&#8226; ', $error);
	    	echo '<div class="errorbox">
	      	<b>Errors Found:</b><br /><br />
	      	&#8226; '.$list.'
	    	</div>';
	}
	else{
               			   
     if((ladderis1on1($_GET['laddID']) && $userID==$ch['challenged']) || (!ladderis1on1($_GET['laddID']) && isleader($userID,$ch['challenged']))) 
     { 
        safe_query("UPDATE ".PREFIX."cup_challenges SET reply_date='$date', $postserver $select_map $select_date challenged_info='".$_POST['info']."', status='2' WHERE chalID='".$_GET['challID']."'");
        safe_query("UPDATE ".PREFIX."cup_clans SET lastact = '".time()."' WHERE clanID='".$ch['challenged']."' AND ladID='".$_GET['laddID']."'");
   
/* EMAIL (2ND STEP) */

$c_clan=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_challenges WHERE chalID='".$_GET['challID']."'"));
$lad=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_ladders WHERE ID='".$c_clan['ladID']."'"));
$to_ds1=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."user WHERE userID='".$c_clan['challenger']."'"));
$to_ds2=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."user WHERE userID='".$c_clan['challenged']."'"));
$do=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."settings"));
$dt=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."styles"));

$sender_from = $do['adminemail'];
$challID = $c_clan['chalID'];
$challenger_ma = $c_clan['challenger'];
$challenged_ma = $c_clan['challenged'];
$timetorespond = $c_clan['new_date']+$lad['timetorespond'];
$timetofinalize = $c_clan['reply_date']+$lad['timetofinalize'];

// multiple recipients

if(ladderis1on1($_GET['laddID'])) {

$to = array($to_ds1[email], $to_ds2[email]); 
$ni = array($to_ds1[nickname], $to_ds2[nickname]);

}
else{

$query = safe_query("SELECT * FROM ".PREFIX."cup_clan_members WHERE clanID='$challenger_ma'");
  while($to_ds3 = mysqli_fetch_array($query)) {
  
    $to_email1=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."user WHERE userID='".$to_ds3['userID']."'"));
	
	if(isleader($to_ds3['userID'],$challenger_ma)) {
      $to[]=$to_email1['email'];
	  $ni[]=$to_email1['nickname'];
	}
}

$query = safe_query("SELECT * FROM ".PREFIX."cup_clan_members WHERE clanID='$challenged_ma'");
  while($to_ds4 = mysqli_fetch_array($query)) {
  
    $to_email2=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."user WHERE userID='".$to_ds4['userID']."'"));
    
	if(isleader($to_ds4['userID'],$challenged_ma)) {
	  $to[]=$to_email2['email'];
	  $ni[]=$to_email2['nickname'];
    }  
  }
}

// subject
$subject = 'Ladder Challenge Notification (2nd Step)';

foreach($ni as $nick) {

$get_userd=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."user WHERE nickname='$nick'"));
$nicks[] = $nick;

// message
$message = '
<html>
<head>
  <title>Ladder Challenge Notification (2nd Step)</title>
</head>
<body>
  '.$notify_admin.'
  To '.implode(", ", $nicks).'<br><br>
  A challenge has been responded to! You can view or finalize this challenge at: http://'.getinput($do['hpurl']).'/?site=standings&action=viewchallenge&laddID='.$_GET['laddID'].'&challID='.$challID.'<br><br>
  Ladder: <a href="http://'.getinput($do['hpurl']).'/?site=ladders&ID='.$_GET['laddID'].'">'.$laddname.'</a><br>
  Challenger: '.getname2($challenger_ma,$_GET['laddID'],0,"ladder").' <br>
  Challenged: '.getname2($challenged_ma,$_GET['laddID'],0,"ladder").' <br>
  <br>
  <b>WARNING:</b> '.getname2($challenger_ma,$_GET['laddID'],0,"ladder").' must finalize before <b>'.date('l M dS Y \@\ g:i a', $timetofinalize).'</b>.<br> Otherwise, a forfeit will be awarded to '.getname2($challenged_ma,$_GET['laddID'],0,"ladder").'<br>
  <br>
  Sent From: '.getinput($dt['title']).'  
</body>
</html>';
}

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";



// Additional headers
foreach($to as $email) {
  $headers .= 'To: '.$to[$n] . "\r\n"; }
  $headers .= 'From: '.$dt['title'].' <'.$sender_from.'>' . "\r\n";
  //$headers .= 'Cc: '.$sender_from . "\r\n";

// Mail it
foreach($to as $email) {
  mail($email, $subject, $message, $headers);
}

/* END EMAIL (2ND STEP)*/
	   
	   redirect('?site=standings&action=viewchallenge&laddID='.$_GET['laddID'].'&challID='.$_GET['challID'], '<div class="errorbox">Challenge response successful <img src="images/cup/success.png"></div>', 2);
   	 }
	}	 
   }
   elseif(isset($_POST['finalizechallenge'])) 
   {     
     if($ds['selected_map']==1) 
     {
       if($_POST['map1_final']==$_POST['map2_final'] || 
          $_POST['map1_final']==$_POST['map3_final'] || 
          $_POST['map1_final']==$_POST['map4_final'] || 
          $_POST['map1_final']==$_POST['map5_final'])
        $error[]='Map option 1 has been selected multiple times';
        
        $selected_map = "map1_final='".$_POST['map1_final']."',";
        
     }
     elseif($ds['selected_map']==2) 
     {
       if($_POST['map1_final']==$_POST['map2_final'] || 
          $_POST['map1_final']==$_POST['map3_final'] || 
          $_POST['map1_final']==$_POST['map4_final'] || 
          $_POST['map1_final']==$_POST['map5_final'])
        $error[]='Map option 1 has been selected multiple times';
        
       if($_POST['map2_final']==$_POST['map1_final'] || 
          $_POST['map2_final']==$_POST['map3_final'] || 
          $_POST['map2_final']==$_POST['map4_final'] || 
          $_POST['map2_final']==$_POST['map5_final'])
        $error[]='Map option 2 has been selected multiple times';

        $selected_map = "map1_final='".$_POST['map1_final']."', 
                         map2_final='".$_POST['map2_final']."',";
        
     }
     elseif($ds['selected_map']==3) 
     { 
       if($_POST['map1_final']==$_POST['map2_final'] || 
          $_POST['map1_final']==$_POST['map3_final'] || 
          $_POST['map1_final']==$_POST['map4_final'] || 
          $_POST['map1_final']==$_POST['map5_final'])
        $error[]='Map option 1 has been selected multiple times';
        
       if($_POST['map2_final']==$_POST['map1_final'] || 
          $_POST['map2_final']==$_POST['map3_final'] || 
          $_POST['map2_final']==$_POST['map4_final'] || 
          $_POST['map2_final']==$_POST['map5_final'])
        $error[]='Map option 2 has been selected multiple times';
        
       if($_POST['map3_final']==$_POST['map2_final'] || 
          $_POST['map3_final']==$_POST['map1_final'] || 
          $_POST['map3_final']==$_POST['map4_final'] || 
          $_POST['map3_final']==$_POST['map5_final'])
        $error[]='Map option 3 has been selected multiple times';

        $selected_map = "map1_final='".$_POST['map1_final']."', 
                         map2_final='".$_POST['map2_final']."', 
                         map3_final='".$_POST['map3_final']."',";
                         
     }
     elseif($ds['selected_map']==4) 
     {
       if($_POST['map1_final']==$_POST['map2_final'] || 
          $_POST['map1_final']==$_POST['map3_final'] || 
          $_POST['map1_final']==$_POST['map4_final'] || 
          $_POST['map1_final']==$_POST['map5_final'])
        $error[]='Map option 1 has been selected multiple times';
        
       if($_POST['map2_final']==$_POST['map1_final'] || 
          $_POST['map2_final']==$_POST['map3_final'] || 
          $_POST['map2_final']==$_POST['map4_final'] ||
          $_POST['map2_final']==$_POST['map5_final'])
        $error[]='Map option 2 has been selected multiple times';
        
       if($_POST['map3_final']==$_POST['map2_final'] || 
          $_POST['map3_final']==$_POST['map1_final'] || 
          $_POST['map3_final']==$_POST['map4_final'] || 
          $_POST['map3_final']==$_POST['map5_final'])
        $error[]='Map option 3 has been selected multiple times';
        
       if($_POST['map4_final']==$_POST['map2_final'] || 
          $_POST['map4_final']==$_POST['map3_final'] || 
          $_POST['map4_final']==$_POST['map1_final'] || 
          $_POST['map4_final']==$_POST['map5_final'])
        $error[]='Map option 4 has been selected multiple times';

        $selected_map = "map1_final='".$_POST['map1_final']."', 
                         map2_final='".$_POST['map2_final']."', 
                         map3_final='".$_POST['map3_final']."', 
                         map4_final='".$_POST['map4_final']."',";
                         
     }
     elseif($ds['selected_map']==5) 
     {
       if($_POST['map1_final']==$_POST['map2_final'] ||
          $_POST['map1_final']==$_POST['map3_final'] || 
          $_POST['map1_final']==$_POST['map4_final'] || 
          $_POST['map1_final']==$_POST['map5_final'])
        $error[]='Map option 1 has been selected multiple times';
        
       if($_POST['map2_final']==$_POST['map1_final'] || 
          $_POST['map2_final']==$_POST['map3_final'] || 
          $_POST['map2_final']==$_POST['map4_final'] || 
          $_POST['map2_final']==$_POST['map5_final'])
        $error[]='Map option 2 has been selected multiple times';
        
       if($_POST['map3_final']==$_POST['map2_final'] || 
          $_POST['map3_final']==$_POST['map1_final'] || 
          $_POST['map3_final']==$_POST['map4_final'] || 
          $_POST['map3_final']==$_POST['map5_final'])
        $error[]='Map option 3 has been selected multiple times';
        
       if($_POST['map4_final']==$_POST['map2_final'] || 
          $_POST['map4_final']==$_POST['map3_final'] || 
          $_POST['map4_final']==$_POST['map1_final'] || 
          $_POST['map4_final']==$_POST['map5_final'])
        $error[]='Map option 4 has been selected multiple times';
        
       if($_POST['map5_final']==$_POST['map2_final'] || 
          $_POST['map5_final']==$_POST['map3_final'] || 
          $_POST['map5_final']==$_POST['map4_final'] || 
          $_POST['map5_final']==$_POST['map1_final'])
        $error[]='Map option 5 has been selected multiple times';
        
        $selected_map = "map1_final='".$_POST['map1_final']."', 
                         map2_final='".$_POST['map2_final']."', 
                         map3_final='".$_POST['map3_final']."', 
                         map4_final='".$_POST['map4_final']."', 
                         map5_final='".$_POST['map5_final']."',";
     }
     else
        $selected_map = '';
		
	  	if(count($error)) {
	    	$list = implode('<br />&#8226; ', $error);
	    	echo '<div class="errorbox">
	      	<b>Errors Found:</b><br /><br />
	      	&#8226; '.$list.'
	    	</div>';
	}
	else{

     if((ladderis1on1($_GET['laddID']) && $userID==$ch['challenger']) || (!ladderis1on1($_GET['laddID']) && isleader($userID,$ch['challenger']))) 
     {
	      
     if(ladderis1on1($_GET['laddID'])) $one = '1'; else $one = '0';
      safe_query("UPDATE ".PREFIX."cup_challenges SET $selected_map game_date='".$_POST['gamedate']."', finalized_date='$date', status='3' WHERE chalID='".$_GET['challID']."'");   
  	  safe_query("INSERT INTO ".PREFIX."cup_matches (cupID, ladID, matchno, date, added_date, clan1, clan2, score1, score2, server, comment, 1on1) VALUES ('0', '".$_GET['laddID']."', '".$_GET['challID']."', '".$_POST['gamedate']."', '".time()."', '".$ch['challenger']."', '".$ch['challenged']."', '0', '0', '".$ch['server']."', '2', '$one')");
  	  safe_query("UPDATE ".PREFIX."cup_clans SET lastact = '".time()."' WHERE clanID='".$ch['challenger']."' AND ladID='".$_GET['laddID']."'");
   	 
/* EMAIL (3RD STEP) */

$c_clan=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_challenges WHERE chalID='".$_GET['challID']."'"));
$lad=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_ladders WHERE ID='".$c_clan['ladID']."'"));
$to_ds1=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."user WHERE userID='".$c_clan['challenger']."'"));
$to_ds2=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."user WHERE userID='".$c_clan['challenged']."'"));
$do=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."settings"));
$dt=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."styles"));

$sender_from = $do['adminemail'];
$challID = $c_clan['chalID'];
$challenger_ma = $c_clan['challenger'];
$challenged_ma = $c_clan['challenged'];
$timetorespond = $c_clan['new_date']+$lad['timetorespond'];
$timetofinalize = $c_clan['reply_date']+$lad['timetofinalize'];

// multiple recipients

if(ladderis1on1($_GET['laddID'])) {

$to = array($to_ds1[email], $to_ds2[email]); 
$ni = array($to_ds1[nickname], $to_ds2[nickname]);
}
else{

$query = safe_query("SELECT * FROM ".PREFIX."cup_clan_members WHERE clanID='$challenger_ma'");
  while($to_ds3 = mysqli_fetch_array($query)) {
  
    $to_email1=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."user WHERE userID='".$to_ds3['userID']."'"));
	
	if(isleader($to_ds3['userID'],$challenger_ma)) {
      $to[]=$to_email1['email'];
	  $ni[]=$to_email1['nickname'];
	}
}

$query = safe_query("SELECT * FROM ".PREFIX."cup_clan_members WHERE clanID='$challenged_ma'");
  while($to_ds4 = mysqli_fetch_array($query)) {
  
    $to_email2=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."user WHERE userID='".$to_ds4['userID']."'"));
    
	if(isleader($to_ds4['userID'],$challenged_ma)) {
	  $to[]=$to_email2['email'];
	  $ni[]=$to_email2['nickname'];
    }  
  }
}

// subject
$subject = 'Ladder Challenge Notification (Match Ready)';

foreach($ni as $nick) {

$get_userd=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."user WHERE nickname='$nick'"));
$nicks[] = $nick;

// message
$message = '
<html>
<head>
  <title>Ladder Challenge Notification (Match Ready)</title>
</head>
<body>
  '.$notify_admin.'
  To '.implode(", ", $nicks).'<br><br>
  A challenge has been finalized! You can this challenge at: http://'.getinput($do['hpurl']).'/?site=standings&action=viewchallenge&laddID='.$_GET['laddID'].'&challID='.$challID.'<br><br>
  Ladder: <a href="http://'.getinput($do['hpurl']).'/?site=ladders&ID='.$_GET['laddID'].'">'.$laddname.'</a><br>
  Challenger: '.getname2($challenger_ma,$_GET['laddID'],0,"ladder").' <br>
  Challenged: '.getname2($challenged_ma,$_GET['laddID'],0,"ladder").' <br>
  <br>
  <b>Match Ready:</b> <a href="http://'.getinput($do['hpurl']).'/?site=cup_matches&match='.$ch['chalID'].'&laddID='.$ch['ladID'].'">Click here</a>
  <br>
  Sent From: '.getinput($dt['title']).'  
</body>
</html>';
}

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";



// Additional headers
foreach($to as $email) {
  $headers .= 'To: '.$to[$n] . "\r\n"; }
  $headers .= 'From: '.$dt['title'].' <'.$sender_from.'>' . "\r\n";
  //$headers .= 'Cc: '.$sender_from . "\r\n";

// Mail it
foreach($to as $email) {
  mail($email, $subject, $message, $headers);
}

/* END EMAIL (3RD STEP)*/	
	 redirect('?site=standings&action=viewchallenge&laddID='.$_GET['laddID'].'&challID='.$_GET['challID'].'', '<div class="errorbox">Challenge successfully finalized <img src="images/cup/success.png"></div>', 2);
    }
   }
 }

/* fight now */

if(isset($_GET['action']) && $_GET['action'] == 'report' && isset($_GET['laddID'])) 
{

 echo '<br />';

 $challenged = $_GET['challenged'];
 
  $ergebnis2 = safe_query("SELECT count(*) as number FROM ".PREFIX."cup_clans WHERE ladID='".$ladID."'");
  $dv=mysqli_fetch_array($ergebnis2);
 
  $partID = (ladderis1on1($ladID) ? $userID : participantID($userID,$ladID));

  $match = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE ladID='$ladID' AND (clan1='$partID' AND clan2='$challenged') || (clan2='$partID' AND clan1='$challenged') ORDER by matchID DESC LIMIT 0,1"); 
  $num_rows = mysqli_num_rows($match); $dm=mysqli_fetch_array($match);
   
 
 if($lad['status']==3) 
    $rep_error = 'The ladder has now ended!';

 if(!$lad['challallow'])
    $rep_error = 'Sorry, only challenges can be initiated on this ladder. (<a href="index.php?site=standings&action=newchallenge&laddID='.$ladID.'">my challenges</a>';

 if($instant_play && $dv['number'] < $lad['maxclan']) 
    $rep_error = 'You must wait for all <b>'.$lad['maxclan'].'</b> participants to register to the ladder first.';

 if(!isladparticipant($userID,$ladID,$checkin=0))
    $rep_error = 'You are not a registered participant!';

 if($lad['crerep'] && getcredits(participantID($userID,$ladID),$ladID) < $lad['crerep']) 
	$rep_error = 'You do not have enough credits to make this report. <br>You need at least <b>'.$lad['crerep'].'</b> and you have <b>'.getcredits(participantID($userID,$ladID),$ladID).'</b> credits.';
	
 if($num_rows && !$dm['confirmscore'])
    $rep_error = 'You currently have an unconfirmed match against '.getname1($challenged,$ladID,$ac=0,$var="ladder",1).'.'; 
       

        $date = '<input name="day" type="text" size="2" value="'.date("d").'" maxlength="2" style="text-align:center">.<input name="month" type="text" size="2" value="'.date("m").'" maxlength="2" style="text-align:center">.<input name="year" type="text" size="4" value="'.date("Y").'" maxlength="4" style="text-align:center"> (dd.mm.yyyy) at <input name="hour" type="text" size="2" value="'.date("H").'" maxlength="2" style="text-align:center">:<input name="min" type="text" size="2" value="'.date("i").'" maxlength="2" style="text-align:center">';
        $gegner = getname1($challenged,$ladID,$ac=0,$var="ladder",1);
        $server = '<input name="server" maxlength="30">';
        $hltv = '<input name="hltv" maxlength="30">';
        $clanID = participantID($userID,$ladID);
        $typename2 = "laddID";
        $cupID = $ladID;
        $matchID = "directmatch";
        $name2 = "&challenged=$challenged";
        $played_d = "Played";
          
    if(!ladderis1on1($ladID)) {  
        $clanID = participantID($userID,$ladID);

    if($challenged==participantID($userID,$ladID)) 
        die('You can not report yourself!');   

//echo template

      if(isladparticipant($userID,$ladID)) {
      
        if($rep_error) {
	       echo "<div class='errorbox'><a href='javascript: history.go(-1);'><img src='images/cup/icons/goback.png' border='0' width='16' height='16'></a> $rep_error</div>";
	}
	else{
      
           if((getcredits($challenged,$ladID) >0 && getcredits(participantID($userID,$ladID),$ladID) >0) || (getcredits($challenged,$ladID) <1 && getcredits(participantID($userID,$ladID),$ladID) <1)) {
      
		eval ("\$inctemp = \"".gettemplate("cupactions_score")."\";");
		echo $inctemp;
		
	   }
	   else{
		echo 'Unranked can only challenge those unranked and ranked can only challenge those ranked.';
	   }
        } 
      }
    }
    else{

     $clanID = "onecup";
   
     if($challenged==$userID) 
        die('You can not report yourself!');
        
      $query = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='$ladID' AND clanID='$userID' AND 1on1='1'");
       if(mysqli_num_rows($query))
       {
       
          if($rep_error) {
	     echo "<font color='red'><strong>$rep_error</strong></font>";
	  }
	  else{

		eval ("\$inctemp = \"".gettemplate("cupactions_score")."\";");
		echo $inctemp; echo base64_decode('');
          }
       }
    }
 }

/* end fight now */

if($loggedin) 
{  

  if(isset($_GET['action']) && $_GET['action'] == 'newchallenge' && isset($_GET['laddID'])) 
  {
    $challenged = $_GET['challenged'];
    

    $ergebnis2 = safe_query("SELECT count(*) as number FROM ".PREFIX."cup_clans WHERE ladID='".$ladID."'");
    $dv=mysqli_fetch_array($ergebnis2);
    
    if($lad['status']==3) {
      $chal_error = 'The ladder has now ended!';
    }
      
    if($lad['challallow']==1) {
      $chal_error = 'Sorry, this ladder does not allow challenging. <br> You must schedule your own matches.'; 
    }
    
    if($instant_play && $dv['number'] < $lad['maxclan']) { 
      $chal_error = 'You must wait for all <b>'.$lad['maxclan'].'</b> participants to register to the ladder first.';
    }
	
	if($lad['crechall'] && getcredits(participantID($userID,$ladID),$ladID) < $lad['crechall']) {
	   $chal_error = 'You do not have enough credits to make this challenge. <br>You need at least <b>'.$lad['crechall'].'</b> and you have <b>'.getcredits(participantID($userID,$ladID),$ladID).'</b> credits.';
	}
 
    if(ladderis1on1($ladID)) {
       $entered = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='$ladID' && clanID='$userID' && 1on1='1'");
       if(!mysqli_num_rows($entered)) $chal_error = 'You are not a participant in this ladder!';
    }
    else{ 
       if(!isladparticipant($userID,$ladID,$checkin=0)){
           $chal_error = 'You are not a participant in this ladder!';
       }
    }

//challenging up/down by credits

  $cd_c=mysqli_fetch_array(safe_query("SELECT credit, xp, tp, wc FROM ".PREFIX."cup_clans WHERE ladID='$ladID' AND clanID='$challenged'"));
  $cr_c=mysqli_fetch_array(safe_query("SELECT credit, xp, tp, wc FROM ".PREFIX."cup_clans WHERE ladID='$ladID' AND clanID='".participantID($userID,$ladID)."'"));
  
  if($lad['ranksys']==1) {
     $rank_type = "credit";
  }   
  elseif($lad['ranksys']==2) {
     $rank_type = "xp";
  }   
  elseif($lad['ranksys']==3) {
     $rank_type = "won";
  }   
  elseif($lad['ranksys']==4) {
     $rank_type = "tp";
  }   
  elseif($lad['ranksys']==5) {
     $rank_type = "wc";
  }   
  elseif($lad['ranksys']==6) {
     $rank_type = "streak";
  }   
  elseif($lad['ranksys']==7) {
     $rank_type = "elo";
  }  
  
  if(getcredits($challenged,$ladID) <= 0)
  $unrking_ch = 1; else $unrking_ch = 0;
  
  if(getcredits(participantID($userID,$ladID),$ladID) <= 0)
  $unrking_pt = 1; else $unrking_pt = 0;
     
    $up_rk_diff   = getrank($challenged,$ladID,$type_rk='now',$unrking_ch)-getrank(participantID($userID,$ladID),$ladID,$type_rk='now',$unrking_pt);
    $down_rk_diff = getrank(participantID($userID,$ladID),$ladID,$type_rk='now',$unrking_pt)-getrank($challenged,$ladID,$type_rk='now',$unrking_ch);

    $only_chall = ($lad['challdown']=='No' ? 'You can not challenge down.' : 'You can only challenge <B>'.$lad['challdown'].'</b> ranks lesser than yours.');
    
    $challdown = ($lad['challdown']==0 ? 2147483647 : $lad['challdown']);
    $challup = ($lad['challup']==0 ? 2147483647 : $lad['challup']);   
    $up_rk_diff_pt = $up_rk_diff-$challdown;
    $down_rk_diff_pt = $down_rk_diff-$challup;
       
    if($_GET['challenged']) 
    {       
      if($lad['challdown']=='No' && getrank(participantID($userID,$ladID),$ladID,$type_rk='now',$unrking_pt) < getrank($challenged,$ladID,$type_rk='now',$unrking_ch)) {
          $chall_error = '<div style="margin: 5px; padding: 6px; border: 4px solid #D6B4B4; text-align: center;"><strong>Challenging down is not allowed on this ladder.</strong></div>';
      }    
      elseif(getrank(participantID($userID,$ladID),$ladID,$type_rk='now',$unrking_pt) > getrank($challenged,$ladID,$type_rk='now',$unrking_ch) && $down_rk_diff > $challup) {
          $chall_error = '<div style="margin: 5px; padding: 6px; border: 4px solid #D6B4B4; text-align: center;">You are ranked <b>'.getrank(participantID($userID,$ladID),$ladID,$type_rk='now',$unrking_pt).'</b> and your opponent is ranked <b>'.getrank($challenged,$ladID,$type_rk='now',$unrking_ch).'</b>. <br> You can only challenge participants <B>'.$lad['challup'].'</b> rank'.($lad['challup'] > 1 ? "s" : "").' higher than yours. Your difference is currently <b>'.$down_rk_diff_pt.'</b> rank'.($down_rk_diff_pt > 1 ? "s" : "").'</div>';     
      }
      elseif(getrank(participantID($userID,$ladID),$ladID,$type_rk='now',$unrking_pt) < getrank($challenged,$ladID,$type_rk='now',$unrking_ch) && $up_rk_diff > $challdown) {
          $chall_error = '<div style="margin: 5px; padding: 6px; border: 4px solid #D6B4B4; text-align: center;"><b>You are ranked <b>'.getrank(participantID($userID,$ladID),$ladID,$type_rk='now',$unrking_pt).'</b> and your opponent is ranked <b>'.getrank($challenged,$ladID,$type_rk='now',$unrking_ch).'</b>. <br> '.$only_chall.' Your difference is currently <b>'.$up_rk_diff_pt.'</b> rank'.($up_rk_diff_pt > 1 ? "s" : "").'</div>';
      } 
    }      

  if(!$challenged) 
  {  

   echo '<br />
       <table width="100%" bgcolor="'.$border.'" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'">
         <tr bgcolor="'.$bghead.'">
           <td colspan="5" class="title" align="center">Your challenges on '.$laddname.'</td>
         </tr>
          <tr bgcolor="'.$bghead.'">
           <td colspan="5" class="title2"><img src="images/cup/icons/addmedia.gif" width="16" height="16"> New Challenge</td>
         </tr>';

   if(ladderis1on1($ladID)) 
   {
 
     $participants = '<option value="0" selected">-- Select User --</option>';
     $players = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='$ladID' AND clanID!='$userID' AND 1on1='1'");

     if(!mysqli_num_rows($players)) {
        echo 'There are currently no active players on this ladder!';      
     }
     else{
	    while($ds=mysqli_fetch_array($players)) {
        $participants.='<option value="'.$ds['clanID'].'">('.$ds['clanID'].') '.getnickname($ds['clanID']).'</option>';      
	 } 
	  
   }
   echo '<tr><td bgcolor="'.$bg1.'" align="center" colspan="5"><select name="challID" onChange="MM_confirm(\'Click ok to proceed to new challenge form.\', \'?site=standings&action=newchallenge&laddID='.$ladID.'&challenged=\'+this.value)">'.$participants.'</select></td></tr>';

 }
 else
 {			              

   $userteams = safe_query("SELECT * FROM ".PREFIX."cup_clan_members WHERE userID='$userID'");
   while($dp=mysqli_fetch_array($userteams))
   {	         

   $teams = '<option value="0" selected">-- Select Team --</option>';
   $getteams = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='$ladID' AND clanID!='".$dp['clanID']."' AND 1on1='0' AND checkin='1'");

   }		 

     if(!mysqli_num_rows($getteams)) {
        echo 'There are currently no active teams on this ladder!';
      
     }
     else{
   
        while($ds=mysqli_fetch_array($getteams))
        { 
        $teams.='<option value="'.$ds['clanID'].'">('.$ds['clanID'].') '.getclanname($ds['clanID']).'</option>';

	 } 
	  
   }echo '<tr><td bgcolor="'.$bg1.'" align="center" colspan="5"><select name="challID" onChange="MM_confirm(\'Click ok to proceed to new challenge form.\', \'?site=standings&action=newchallenge&laddID='.$ladID.'&challenged=\'+this.value)">'.$teams.'</select></td></tr>';  

 }

//my challenges   

  echo '
   
   <tr bgcolor="'.$bghead.'">
    <td colspan="5" class="title2"><img src="images/cup/icons/challenge.gif" width="16" height="16"> Current Challenges</td>
  </tr>
   <tr>
    <td bgcolor="'.$bg2.'" align="center"><strong>No</strong></td>
    <td bgcolor="'.$bg2.'" align="center"><strong>Challenger</strong></td>
    <td bgcolor="'.$bg2.'" align="center"><strong>Challenged</strong></td>
    <td bgcolor="'.$bg2.'" align="center"><strong>Status</strong></td>
    <td bgcolor="'.$bg2.'" align="center"><strong>Details</strong></td>
  </tr>';  

  if(ladderis1on1($ladID)) {  
    $no = 1;
      $userchallenges = safe_query("SELECT * FROM ".PREFIX."cup_challenges WHERE ladID='$ladID' AND (challenger='$userID' || challenged='$userID') ORDER BY chalID DESC");
      
      if(!mysqli_num_rows($userchallenges)) {
          echo '<tr><td bgcolor="'.$pagebg.'" colspan="5"></td></tr>
	        <tr><td bgcolor="'.$bg1.'" colspan="5" align="center">- you have no challenges -</td></tr>';
      }
      
      while($ds=mysqli_fetch_array($userchallenges))
      {

    if($ds['forfeit']==$ds['challenger']) 
       $step = '(did not accept with '.getname1($ds['challenged'],$ladID,$ac=0,$var="ladder",1).''.$s.' finalized selections)';
    elseif($ds['forfeit']==$ds['challenged']) 
       $step = '(did not accept '.getname1($ds['challenger'],$ladID,$ac=0,$var="ladder",1).''.$s.' challenge request)';

    if($ds['status']==4 && $ds['forfeit']==$ds['challenger'])
       $status2 = ''.getname1($ds['challenged'],$ladID,$ac=0,$var="ladder",1).' won by forfeit<br>(did not finalize in time)';
    elseif($ds['status']==4 && $ds['forfeit']==$ds['challenged'])
       $status2 = ''.getname1($ds['challenger'],$ladID,$ac=0,$var="ladder",1).' won by forfeit<br>(did not respond in time)';
    elseif($ds['status']==5 && $ds['forfeit']==$ds['challenger'])
       $status2 = '<font color="#DD0000"><b>Forfeited</b></font> by '.getname1($ds['challenger'],$ladID,$ac=0,$var="ladder",1).' '.$step;
    elseif($ds['status']==5 && $ds['forfeit']==$ds['challenged'])
       $status2 = '<font color="#DD0000"><b>Forfeited</b></font> by '.getname1($ds['challenged'],$ladID,$ac=0,$var="ladder",1).'';
    elseif($ds['status']==1)
       $status2 = 'Waiting for '.getname1($ds['challenged'],$ladID,$ac=0,$var="ladder",1).$s;
    elseif($ds['status']==2)
       $status2 = 'Waiting for '.getname1($ds['challenger'],$ladID,$ac=0,$var="ladder",1).$s;
    elseif($ds['status']==3) 
    {
       $status2 = 'Challenge Complete';
       $status3 = '<a href="index.php?site=cup_matches&match='.$ds['chalID'].'&laddID='.$ds['ladID'].'"><img border="0" src="images/cup/icons/add_result.gif"></a>';
    }

     echo '
   <tr>
    <td bgcolor="'.$bg2.'" align="center">'.$no.'</td>
    <td bgcolor="'.$bg2.'" align="center"><a href="index.php?site=profile&id='.$ds['challenger'].'">'.getnickname($ds['challenger']).'</a></td>
    <td bgcolor="'.$bg2.'" align="center"><a href="index.php?site=profile&id='.$ds['challenged'].'">'.getnickname($ds['challenged']).'</a></td>
    <td bgcolor="'.$bg2.'" align="center">'.$status2.'</td>
    <td bgcolor="'.$bg2.'" align="center">'.$status3.' <a href="index.php?site=standings&action=viewchallenge&laddID='.$ladID.'&challID='.$ds['chalID'].'"><img border="0" src="images/icons/foldericons/folder.gif"></a></td>
  </tr>';
     $no++;
     }
  }
  else
  {

   $userteams = safe_query("SELECT * FROM ".PREFIX."cup_clan_members WHERE userID='$userID'");
   while($dp=mysqli_fetch_array($userteams))
   {
   
    $no = 1;
    
     $teamchallenges = safe_query("SELECT * FROM ".PREFIX."cup_challenges WHERE ladID='$ladID' AND (challenger='".$dp['clanID']."' || challenged='".$dp['clanID']."') ORDER BY chalID DESC"); }
     while($ds=mysqli_fetch_array($teamchallenges))
     { 
     
        if($ds['forfeit']==$ds['challenger']) 
           $step = '(did not accept with '.getname1($ds['challenged'],$ladID,$ac=0,$var="ladder",1).''.$s.' finalized selections)';
        elseif($ds['forfeit']==$ds['challenged']) 
           $step = '(did not accept '.getname1($ds['challenger'],$ladID,$ac=0,$var="ladder",1).''.$s.' challenge request)';

        if($ds['status']==4 && $ds['forfeit']==$ds['challenger'])
           $status2 = ''.getname1($ds['challenged'],$ladID,$ac=0,$var="ladder",1).' won by forfeit<br>(did not finalize in time)';
        elseif($ds['status']==4 && $ds['forfeit']==$ds['challenged'])
           $status2 = ''.getname1($ds['challenger'],$ladID,$ac=0,$var="ladder",1).' won by forfeit<br>(did not respond in time)';
        elseif($ds['status']==5 && $ds['forfeit']==$ds['challenger'])
           $status2 = '<font color="#DD0000"><b>Forfeited</b></font> by '.getname1($ds['challenger'],$ladID,$ac=0,$var="ladder",1).' '.$step.'';
        elseif($ds['status']==5 && $ds['forfeit']==$ds['challenged'])
           $status2 = '<font color="#DD0000"><b>Forfeited</b></font> by '.getname1($ds['challenged'],$ladID,$ac=0,$var="ladder",1).'';
        elseif($ds['status']==1)
           $status2 = 'Waiting for '.getname1($ds['challenged'],$ladID,$ac=0,$var="ladder",1).''.$s;
        elseif($ds['status']==2)
           $status2 = 'Waiting for '.getname1($ds['challenger'],$ladID,$ac=0,$var="ladder",1).''.$s;
        elseif($ds['status']==3) {
           $status2 = 'Challenge Complete';
           $status3 = '<a href="index.php?site=cup_matches&match='.$ds['chalID'].'&laddID='.$ds['ladID'].'"><img border="0" src="images/cup/icons/add_result.gif"></a>';
   }
        
     echo '
   <tr>
    <td bgcolor="'.$bg2.'" align="center">'.$no.'</td>
    <td bgcolor="'.$bg2.'" align="center"><a href="index.php?site=clans&action=show&clanID='.$ds['challenger'].'">'.getclanname($ds['challenger']).'</a></td>
    <td bgcolor="'.$bg2.'" align="center"><a href="index.php?site=clans&action=show&clanID='.$ds['challenged'].'">'.getclanname($ds['challenged']).'</a></td>
    <td bgcolor="'.$bg2.'" align="center">'.$status2.'</td>
    <td bgcolor="'.$bg2.'" align="center">'.$status3.' <a href="index.php?site=standings&action=viewchallenge&laddID='.$ladID.'&challID='.$ds['chalID'].'"><img border="0" src="images/icons/foldericons/folder.gif"></a></td>
  </tr>';  

     $no++; 

     }   

   }
   echo '</table>'; 

 }
 else //NEW CHALLENGE FORM
 {

   if(ladderis1on1($ladID)) 
   {

     $challenger = $userID;
     $opponent = getnickname($challenged);

     $challenges = safe_query("SELECT * FROM ".PREFIX."cup_challenges WHERE ladID='$ladID' && (challenger='$challenger' && challenged='$challenged') || (challenger='$challenged' && challenged='$challenger') ORDER BY chalID DESC");
     $challexists = mysqli_num_rows($challenges);
     $info = mysqli_fetch_array($challenges);

     $match = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE ladID='$ladID' AND (clan1='$challenger' AND clan2='$challenged') || (clan2='$challenger' AND clan1='$challenged') ORDER BY matchno DESC"); 
     $num_rows = mysqli_num_rows($match); $dm = mysqli_fetch_array($match);

     $opponent1 = getnickname($info['challenged']);
     $challenger1 = getnickname($info['challenger']);
      
     if($challenged==$userID) 
     {
        $chall_error2 = '<div style="margin: 5px; padding: 6px; border: 4px solid #D6B4B4; text-align: center;"><b>You can not challenge yourself!</b></div>';
     }   
     elseif($challexists && $info['status']==1)
     {
        $chall_error2 = '<div style="margin: 5px; padding: 6px; border: 4px solid #D6B4B4; text-align: center;"><b>This first-step challenge has been submitted!<br> Waiting for <b>'.$opponent1.'</b> to respond to challenge.</b></div>';
     }   
     elseif($challexists && $info['status']==2)
     {
        $chall_error2 = '<div style="margin: 5px; padding: 6px; border: 4px solid #D6B4B4; text-align: center;"><b>This second-step challenge has been submitted!<br> Waiting for <b>'.$challenger1.'</b> to finalize challenge.</b></div>';
     }   
     elseif($challexists && $dm['confirmscore']==0 && $num_rows)
     {
        $chall_error2 = '<div style="margin: 5px; padding: 6px; border: 4px solid #D6B4B4; text-align: center;"><b>You already have an opened match that has not yet been confirmed.</b></div>';
     }   
 }
 else
 { 

 if(participantID($userID,$ladID)!=$_GET['challenger']) 
 {

   $challenger = participantID($userID,$ladID);
   $opponent = getclanname($challenged);
   
   $challenges = safe_query("SELECT * FROM ".PREFIX."cup_challenges WHERE ladID='$ladID' && (challenger='$challenger' && challenged='$challenged') || (challenger='$challenged' && challenged='$challenger') ORDER BY chalID DESC");
   $challexists = mysqli_num_rows($challenges);
   $info = mysqli_fetch_array($challenges);
   
   $match = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE ladID='$ladID' AND (clan1='$challenger' AND clan2='$challenged') || (clan2='$challenger' AND clan1='$challenged') ORDER BY matchno DESC"); 
   $num_rows = mysqli_num_rows($match); $dm = mysqli_fetch_array($match);

   $opponent1 = getclanname($info['challenged']);
   $challenger1 = getclanname($info['challenger']);

     if($challenged==participantID($userID,$ladID)) 
     {
        $chall_error2 = '<div style="margin: 5px; padding: 6px; border: 4px solid #D6B4B4; text-align: center;"><b>You can not challenge your own team!</b></div>';
     }   
     elseif($challexists && $info['status']==1)
     {
        $chall_error2 = '<div style="margin: 5px; padding: 6px; border: 4px solid #D6B4B4; text-align: center;"><b>This first-step challenge has been submitted!<br> Waiting for <b>'.$opponent1.'</b> to respond to challenge.</b></div>';
     }   
     elseif($challexists && $info['status']==2)
     {
        $chall_error2 = '<div style="margin: 5px; padding: 6px; border: 4px solid #D6B4B4; text-align: center;"><b>This second-step challenge has been submitted!<br> Waiting for <b>'.$challenger1.'</b> to finalize challenge.</b></div>';
     }   
     elseif($challexists && $dm['confirmscore']==0 && $num_rows)
     {
        $chall_error2 = '<div style="margin: 5px; padding: 6px; border: 4px solid #D6B4B4; text-align: center;"><b>You already have an opened match that has not yet been confirmed.</b></div>';
     }
        
    }
    else
        die('<br><br><br>Access denied.');
 }  
    
//challenges quantity

   $challenges = safe_query("SELECT * FROM ".PREFIX."cup_challenges WHERE ladID='$ladID' && challenger='".participantID($userID,$ladID)."'");
   $quant_challenges = mysqli_num_rows($challenges);
   
   if(getcredits($_GET['challenged'],$ladID) <= 0)
   $unrking_ch = 1; else $unrking_ch = 0;
  
   if(getcredits(participantID($userID,$ladID),$ladID) <= 0)
   $unrking_pt = 1; else $unrking_pt = 0;
   
   if($quant_challenges >= $lad['challquant']){
      $chall_error3 = '<div style="margin: 5px; padding: 6px; border: 4px solid #D6B4B4; text-align: center;">Sorry, you have made <b>'.$quant_challenges.'</b>/<b>'.$lad['challquant'].'</b> challenges.</div>';
   }   
   else{
      $chall_info_err = '<div style="margin: 5px; padding: 6px; border: 4px solid #D6B4B4; text-align: center;">You have had <b>'.$quant_challenges.'</b>/<b>'.$lad['challquant'].'</b> challenges so far.<br>
                         Your rank is <b>'.getrank(participantID($userID,$ladID),$ladID,$type_rk='now',$unrking_pt).'</b> and are challenging participant ranked <b>'.getrank($_GET['challenged'],$ladID,$type_rk='now',$unrking_ch).'</b>.</div>';
   }   

   if($chal_error) {
      echo "<div class='errorbox'><a href='javascript: history.go(-1);'><img src='images/cup/icons/goback.png' border='0' width='16' height='16'></a> $chal_error</div>";
   }
   elseif($chall_error) {
      echo $chall_error;
   }
   elseif($chall_error2) {
      echo $chall_error2;
   }
   elseif($chall_error3) {
      echo $chall_error3;
   }
   elseif(!$chall_error && !$chall_error2 && !$chall_error3) {

   $participants = safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE ladID='$ladID'");
   while($pp = mysqli_fetch_array($participants))
   
      if($challenged==$pp['clanID']) {
      
        if((getcredits($_GET['challenged'],$ladID) >0 && getcredits(participantID($userID,$ladID),$ladID) >0) || (getcredits($_GET['challenged'],$ladID) <1 && getcredits(participantID($userID,$ladID),$ladID) <1)) {
   
	   eval ("\$chall_head = \"".gettemplate("new_challenge")."\";");
	   echo $chall_info_err.$chall_head;
	   
	}
	else{
	   echo $chall_info_err.' Unranked can only challenge those unranked and ranked can only challenge those ranked.';
	}
      }
    }
  }
}
elseif(isset($_GET['action']) && $_GET['action'] == 'viewchallenge') 
{

/* CHALLENGE */

  //check if not exists

  $query = safe_query("SELECT chalID FROM ".PREFIX."cup_challenges");
  if(mysqli_num_rows($query)) {

  while($ex=mysqli_fetch_array($query))
  if($ID==$ex['chalID']) {


    $getchallenge = safe_query("SELECT * FROM ".PREFIX."cup_challenges WHERE chalID='$ID' AND ladID='$ladID'");
    $ds = mysqli_fetch_array($getchallenge);

 if(ladderis1on1($ladID)) {
    $challenger = '<a href="index.php?site=profile&id='.$ds['challenger'].'" target="_blank"><b>'.getnickname($ds['challenger']).'</b></a>';
    $challenged = '<a href="index.php?site=profile&id='.$ds['challenged'].'" target="_blank"><b>'.getnickname($ds['challenged']).'</b></a>';
 }
 else{
    $challenger = '<a href="index.php?site=clans&action=show&clanID='.$ds['challenger'].'" target="_blank"><b>'.getclanname($ds['challenger']).'</b></a>';
    $challenged = '<a href="index.php?site=clans&action=show&clanID='.$ds['challenged'].'" target="_blank"><b>'.getclanname($ds['challenged']).'</b></a>';
 }
 
//check if can alter server details

  if($ds['serverc'] || (!$ds['server'] && !$ds['port']) && $ds['status']==1) {
    $serverconn = '<input name="server" maxlength="22" value="'.($ds['server'] ? $ds['server'] : '').'">:<input name="port" maxlength="6" size="6" value="'.($ds['port'] ? $ds['port'] : '').'">';
  }
  elseif(($ds['server'] && $ds['port']) || ($ds['server'])){
    $serverconn = ($ds['server'] ? $ds['server'] : '').':'.($ds['port'] ? $ds['port'] : '');
  }
  else{
    $serverconn = '<i>(unspecified)</i>';
  }

  $comments_challenger = $ds['challenger_info'];  
  
  if($ds['challenger_info'])
  $sh_chr_comms = '
    <tr>
  	  <td bgcolor="'.$bg1.'">Comments:</td>
	  <td bgcolor="'.$bg2.'">'.$comments_challenger.'</td>
    </tr>';
 
  $date = date('d.m.Y \a\t H:i', $ds['new_date']);
  $ago = ', <b>'.returnTime2($ds['new_date']).'</b> ago.';
  $reply_date = date('d.m.Y \a\t H:i', $ds['reply_date']);
  $finalized_date = date('d.m.Y \a\t H:i', $ds['finalized_date']);
  
//ladder settings  

 $laddsettings = safe_query("SELECT * FROM ".PREFIX."cup_ladders WHERE ID='$ladID'");
 $set = mysqli_fetch_array($laddsettings);
 
//timeset

  $start = strtotime($set['timestart']);
  $end = strtotime($set['timeend']);
  
  for ($i = $start; $i <= $end; $i += $set['timeintervals']) {
  	$times.='<option value="'.$i.'">'.date('l M dS Y \@\ g:i a', $i).'</option>';
  }

//ladder maps 

 $getmaps = safe_query("SELECT * FROM ".PREFIX."cup_maps WHERE mappack='".$set['mappack']."'");
   while($mp=mysqli_fetch_array($getmaps)) {
       $maps.='<option value="'.$mp['map'].'">'.$mp['map'].'</option>'; 
   }

//date and map options

  if($set['select_date']==1)
  {
     $select_date = '<select name="date1">'.$times.'</select>';
  }
  elseif($set['select_date']==2) 
  {
     $s = 's';
     $select_date = 'Date/Time Option #1<br>';
     $select_date.= '<select name="date1">'.$times.'</select><br>';
     $select_date.= 'Date/Time Option #2<br>';
     $select_date.= '<select name="date2">'.$times.'</select>';
  }
  elseif($set['select_date']==3) 
  {
     $s = 's';
     $select_date = 'Date/Time Option #1<br>';
     $select_date.= '<select name="date1">'.$times.'</select><br>';
     $select_date.= 'Date/Time Option #2<br>';
     $select_date.= '<select name="date2">'.$times.'</select><br>';
     $select_date.= 'Date/Time Option #3<br>';
     $select_date.= '<select name="date3">'.$times.'</select>';
  }
  elseif($set['select_date']==4) 
  {
     $s = 's';
     $select_date = 'Date/Time Option #1<br>';
     $select_date.= '<select name="date1">'.$times.'</select><br>';
     $select_date.= 'Date/Time Option #2<br>';
     $select_date.= '<select name="date2">'.$times.'</select><br>';
     $select_date.= 'Date/Time Option #3<br>';
     $select_date.= '<select name="date3">'.$times.'</select><br>';
     $select_date.= 'Date/Time Option #4<br>';
     $select_date.= '<select name="date4">'.$times.'</select>';
  }
  elseif($set['select_date']==5) 
  {
     $s = 's';
     $select_date = 'Date/Time Option #1<br>';
     $select_date.= '<select name="date1">'.$times.'</select><br>';
     $select_date.= 'Date/Time Option #2<br>';
     $select_date.= '<select name="date2">'.$times.'</select><br>';
     $select_date.= 'Date/Time Option #3<br>';
     $select_date.= '<select name="date3">'.$times.'</select><br>';
     $select_date.= 'Date/Time Option #4<br>';
     $select_date.= '<select name="date4">'.$times.'</select><br>';
     $select_date.= 'Date/Time Option #5<br>';
     $select_date.= '<select name="date5">'.$times.'</select>';
  }

  if($ds['date1']) 
  {
     $date_option1 = 'Option 1 #<br>';
     $date1 = date('l M dS Y \@\ g:i a', $ds['date1']).'<br>';
     $dateoptions = '<option value="'.$ds['date1'].'">'.date('l M dS Y \@\ g:i a', $ds['date1']).'</option>';
  }
  if($ds['date2']) 
  {
     $date_option2 = 'Option 2 #<br>';
     $date2 = date('l M dS Y \@\ g:i a', $ds['date2']).'<br>';
     $dateoptions.= '<option value="'.$ds['date2'].'">'.date('l M dS Y \@\ g:i a', $ds['date2']).'</option>';
  }
  if($ds['date3']) 
  {
     $date_option3 = 'Option 3 #<br>';
     $date3 = date('l M dS Y \@\ g:i a', $ds['date3']).'<br>';
     $dateoptions.= '<option value="'.$ds['date3'].'">'.date('l M dS Y \@\ g:i a', $ds['date3']).'</option>';
  }
  if($ds['date4']) 
  {
     $date_option4 = 'Option 4 #<br>';
     $date4 = date('l M dS Y \@\ g:i a', $ds['date4']).'<br>';
     $dateoptions.= '<option value="'.$ds['date4'].'">'.date('l M dS Y \@\ g:i a', $ds['date4']).'</option>';
  }
  if($ds['date5']) 
  {
     $date_option5 = 'Option 5 #<br>';
     $date5 = date('l M dS Y \@\ g:i a', $ds['date5']).'<br>';
     $dateoptions.= '<option value="'.$ds['date5'].'">'.date('l M dS Y \@\ g:i a', $ds['date5']).'</option>';
  }
  
   $select_date_final = '<select name="gamedate">'.$dateoptions.'</select>';

   if(!$ds['map1'] && !$ds['map2'] && !$ds['map3'] && !$ds['map4'] && !$ds['map5'])
       $nomaps = 'n/a'; 

   if(!$ds['date1'] && !$ds['date2'] && !$ds['date3'] && !$ds['date4'] && !$ds['date5'])
       $nodates = 'n/a';

  if($ds['map1']) 
  {
      $map_option1 = 'Option 1 #<br>';
      $map1 = $ds['map1'].'<br>';
      $mapoptions = '<option value="'.$ds['map1'].'">'.$ds['map1'].'</option>';
  }
  if($ds['map2']) 
  {
      $map_option2 = 'Option 2 #<br>';
      $map2 = $ds['map2'].'<br>';
      $mapoptions.= '<option value="'.$ds['map2'].'">'.$ds['map2'].'</option>';
  }
  if($ds['map3']) 
  {
      $map_option3 = 'Option 3 #<br>';
      $map3 = $ds['map3'].'<br>';
      $mapoptions.= '<option value="'.$ds['map3'].'">'.$ds['map3'].'</option>';
  }
  if($ds['map4']) {
      $map_option4 = 'Option 4 #<br>';
      $map4 = $ds['map4'].'<br>';
      $mapoptions.= '<option value="'.$ds['map4'].'">'.$ds['map4'].'</option>';
  }
  if($ds['map5']) 
  {
      $map_option5 = 'Option 5 #';
      $map5 = $ds['map5'];
      $mapoptions.= '<option value="'.$ds['map5'].'">'.$ds['map5'].'</option>';
  }   

   if($set['selected_map']==1) 
   {
      $s_f = '';
      $select_map_final = 'Map Option #1<br>';
      $select_map_final.= '<select name="map1_final">'.$mapoptions.'</select>'; 
  }
  elseif($set['selected_map']==2) {
      $s_f = 's';
      $select_map_final = 'Map Option #1<br>';
      $select_map_final.= '<select name="map1_final">'.$mapoptions.'</select><br>';
      $select_map_final.= 'Map Option #2<br>';
      $select_map_final.= '<select name="map2_final">'.$mapoptions.'</select>'; 
  }
  elseif($set['selected_map']==3) {
      $s_f = 's';
      $select_map_final = 'Map Option #1<br>';
      $select_map_final.= '<select name="map1_final">'.$mapoptions.'</select><br>';
      $select_map_final.= 'Map Option #2<br>';
      $select_map_final.= '<select name="map2_final">'.$mapoptions.'</select><br>';
      $select_map_final.= 'Map Option #3<br>';
      $select_map_final.= '<select name="map3_final">'.$mapoptions.'</select>'; 
  }
  elseif($set['selected_map']==4) 
  {
      $s_f = 's';
      $select_map_final = 'Map Option #1<br>';
      $select_map_final.= '<select name="map1_final">'.$mapoptions.'</select><br>';
      $select_map_final.= 'Map Option #2<br>';
      $select_map_final.= '<select name="map2_final">'.$mapoptions.'</select><br>';
      $select_map_final.= 'Map Option #3<br>';
      $select_map_final.= '<select name="map3_final">'.$mapoptions.'</select><br>';
      $select_map_final.= 'Map Option #4<br>';
      $select_map_final.= '<select name="map4_final">'.$mapoptions.'</select>';
  }
  elseif($set['selected_map']==5) 
  {
      $s_f = 's';
      $select_map_final = 'Map Option #1<br>';
      $select_map_final.= '<select name="map1_final">'.$mapoptions.'</select><br>';
      $select_map_final.= 'Map Option #2<br>';
      $select_map_final.= '<select name="map2_final">'.$mapoptions.'</select><br>';
      $select_map_final.= 'Map Option #3<br>';
      $select_map_final.= '<select name="map3_final">'.$mapoptions.'</select><br>';
      $select_map_final.= 'Map Option #4<br>';
      $select_map_final.= '<select name="map4_final">'.$mapoptions.'</select><br>';
      $select_map_final.= 'Map Option #5<br>';
      $select_map_final.= '<select name="map5_final">'.$mapoptions.'</select>';
      
  }

  if($set['select_map']==1) 
  {
      $select_map = '<select name="map1">'.$maps.'</select>';
  }
  elseif($set['select_map']==2) 
  {
      $s = 's';
      $select_map = 'Map Option #1<br>';
      $select_map.= '<select name="map1">'.$maps.'</select><br>';
      $select_map.= 'Map Option #2<br>';
      $select_map.= '<select name="map2">'.$maps.'</select>';
  }
  elseif($set['select_map']==3) 
  {
      $s = 's';
      $select_map = 'Map Option #1<br>';
      $select_map.= '<select name="map1">'.$maps.'</select><br>';
      $select_map.= 'Map Option #2<br>';
      $select_map.= '<select name="map2">'.$maps.'</select><br>';
      $select_map.= 'Map Option #3<br>';
      $select_map.= '<select name="map3">'.$maps.'</select>';
  }
  elseif($set['select_map']==4) 
  {
      $s = 's';
      $select_map = 'Map Option #1<br>';
      $select_map.= '<select name="map1">'.$maps.'</select><br>';
      $select_map.= 'Map Option #2<br>';
      $select_map.= '<select name="map2">'.$maps.'</select><br>';
      $select_map.= 'Map Option #3<br>';
      $select_map.= '<select name="map3">'.$maps.'</select><br>';
      $select_map.= 'Map Option #4<br>';
      $select_map.= '<select name="map4">'.$maps.'</select>';
  }
  elseif($set['select_map']==5) 
  {
      $s = 's';
      $select_map = 'Map Option #1<br>';
      $select_map.= '<select name="map1">'.$maps.'</select><br>';
      $select_map.= 'Map Option #2<br>';
      $select_map.= '<select name="map2">'.$maps.'</select><br>';
      $select_map.= 'Map Option #3<br>';
      $select_map.= '<select name="map3">'.$maps.'</select><br>';
      $select_map.= 'Map Option #4<br>';
      $select_map.= '<select name="map4">'.$maps.'</select><br>';
      $select_map.= 'Map Option #5<br>';
      $select_map.= '<select name="map5">'.$maps.'</select>';
  }

 //2nd step challenge form

 $challenge_reply = ' 
     <tr>
       <td bgcolor="'.$bg1.'" align="center">Select map'.$s.':</td>
       <td bgcolor="'.$bg1.'">'.$select_map.'</td>
     </tr>
	 <tr><td colspan="2" bgcolor="'.$bg1.'"></td></tr>
      <tr>
       <td bgcolor="'.$bg2.'" colspan="2" align="center"><div class="errorbox"><img src="images/cup/icons/contact_info.png"> You must select <font color="red"><b>'.$set['select_map'].'</b></font> '.($s=='s' ? 'different' : '').' map'.$s.' and <font color="red"><b>'.$set['select_date'].'</b></font> '.($s=='s' ? 'different' : '').' date'.$s.'/time'.$s.'.</div></td>
     </tr>
	 <tr><td colspan="2" bgcolor="'.$bg1.'"></td></tr>
      <tr>
       <td bgcolor="'.$bg2.'" align="center">Select date'.$s.'/time'.$s.':</td>
       <td bgcolor="'.$bg2.'">'.$select_date.'</td>
     </tr>
      <tr>
       <td bgcolor="'.$bg1.'" align="center">Your Comments:</td>
       <td bgcolor="'.$bg1.'"><textarea rows="4" name="info" cols="50"></textarea></td>
     </tr>
      <tr bgcolor="'.$bg2.'">
	   <td style="padding:2px 3px 2px 3px;">&nbsp;</td>
	   <td style="padding:2px 3px 2px 3px;">
	    <input name="replychallenge" type="submit" id="replychallenge" value="Accept Challenge">
	    <input name="challengedforfeits" type="submit" id="challengedforfeits" value="Forfeit Challenge" onclick="return confirm(\'WARNING: Forfeiting this challenge will deduct -'.$forfeitloss.' credits and the opponent will be awarded with +'.$forfeitaward.' credits. Match forfeiting also affects your overall ranking on the ladder.\');">
	   </td>
     </tr>';

//final step challenge

 $finalized_reply = '
     <tr>
       <td bgcolor="'.$bg1.'" align="center">Playing map'.$s_f.':</td>
       <td bgcolor="'.$bg1.'">'.$select_map_final.'</td>
     </tr>
	  <tr><td colspan="2" bgcolor="'.$bg1.'"></td></tr>
      <tr>
       <td bgcolor="'.$bg1.'" colspan="2" align="center"><div class="errorbox"><img src="images/cup/icons/contact_info.png"> You must select <font color="red"><b>'.$set['selected_map'].'</b></font> '.($s_f=='s' ? 'different' : '').' map'.$s_f.' and <font color="red"><b>1</b></font> date/time for your match.</div></td>
     </tr>
	  <tr><td colspan="2" bgcolor="'.$bg1.'"></td></tr>
      <tr>
       <td bgcolor="'.$bg2.'" align="center">Select date/time:</td>
       <td bgcolor="'.$bg2.'">'.$select_date_final.'</td>
     </tr>
      <tr bgcolor="'.$bg1.'">
	   <td style="padding:2px 3px 2px 3px;">&nbsp;</td>
	   <td style="padding:2px 3px 2px 3px;">
	    <input name="finalizechallenge" type="submit" id="finalizechallenge" value="Finalize Challenge">
	    <input name="challengerforfeits" type="submit" id="challengerforfeits" value="Forfeit Challenge" onclick="return confirm(\'WARNING: Forfeiting this challenge will deduct -'.$forfeitloss.' credits and the opponent will then be awarded +'.$forfeitaward.' credits. Match forfeiting also affects your overall ranking on the ladder.\');">
	   </td>
     </tr>';
     
  $timetorespond = $ch['new_date']+$lad['timetorespond'];
  $timetofinalize = $ch['reply_date']+$lad['timetofinalize'];
     
     if($ds['status']==1) 
     {
       $warning = '
         <tr>
          <td bgcolor="'.$bg1.'" colspan="2" align="center"><img src="images/cup/icons/warning.png"> '.$challenged.' must respond before <b>'.date('l M dS Y \@\ g:i a', $timetorespond).'</b>.<br> Otherwise, a forfeit will be awarded to '.$challenger.'</td>
        </tr>';   

    }
    if($ds['status']==2) 
    {
       $warning = '
         <tr>
          <td bgcolor="'.$bg1.'" colspan="2" align="center"><img src="images/cup/icons/warning.png"> '.$challenger.' must finalze before <b>'.date('l M dS Y \@\ g:i a', $timetofinalize).'</b>.<br> Otherwise, a forfeit will be awarded to '.$challenged.'</td>
        </tr>';
    }


    $comments_challenged = $ds['challenged_info'];
	
	if($ds['challenged_info'])
	$sh_chd_comm = '
  	 <tr>
  	  <td bgcolor="'.$bg2.'">Comments:</td>
	  <td bgcolor="'.$bg2.'">'.$comments_challenged.'</td>
    </tr>';

    $reply_ago = ', <b>'.returnTime2($ds['reply_date']).'</b> ago.';

//chall info where status is 2 or 3 

  $chall_info = '
    <tr>
      <td bgcolor="'.$bg1.'" rowspan="2">Info:</td>  
      <td bgcolor="'.$bg1.'">'.$challenged.' accepted the challenge by '.$challenger.'</td>
    </tr>
  	 <tr>
  	  <td bgcolor="'.$bg2.'">Responded to this challenge on <b>'.$reply_date.'</b>'.$reply_ago.'</td>
    </tr>
  	 <tr>
    </tr>
     <tr>
      <td bgcolor="'.$bg2.'" align="right"><b>Maps Selected:</b><br>'.$map_option1.' '.$map_option2.' '.$map_option3.' '.$map_option4.' '.$map_option5.' </td>
      <td bgcolor="'.$bg2.'">'.$nomaps.'<br>'.$map1.' '.$map2.' '.$map3.' '.$map4.' '.$map5.'</td>
  	 <tr>
     <tr>
      <td bgcolor="'.$bg1.'" align="right"><b>Dates/Times:</b><br>'.$date_option1.' '.$date_option2.' '.$date_option3.' '.$date_option4.' '.$date_option5.' </td>
      <td bgcolor="'.$bg1.'">'.$nodates.'<br>'.$date1.' '.$date2.' '.$date3.' '.$date4.' '.$date5.' </td>'.$sh_chd_comm;

  if($ds['status']==1) 
  {
     $status = '
       <tr>
         <td bgcolor="'.$bg1.'">Info:</td>
         <td bgcolor="'.$bg1.'">'.$challenged.' has not responded yet.</td>
       </tr>';
   
     if(participantID($userID,$ladID)==$ds['challenged'])
     {
        $reply_form = $challenge_reply;
     }
        
 }
 elseif($ds['status']==2) 
 {

    $status = $chall_info; 

    if(participantID($userID,$ladID)==$ds['challenger']) 
       $finalized_form = $finalized_reply;


 } 
 elseif($ds['status']==4 && !$ds['map1']) 
 {
    $status = '<tr><td bgcolor="'.$bg1.'" colspan="2">'.getname1($ds['challenged'],$ladID,$ac=0,$var="ladder",1).' did not respond to this challenge on time. (<b>-'.$forfeitloss.'</b>)</td></tr>';
 } 
 elseif($ds['status']==5 && !$ds['map1']) 
 {
    $status = '<tr><td bgcolor="'.$bg1.'" colspan="2">'.getname1($ds['challenged'],$ladID,$ac=0,$var="ladder",1).' forfeited. (<b>-'.$forfeitloss.'</b>)</td></tr>';
 } 
 elseif(($ds['status']==4 || $ds['status']==5) && $ds['map1']) 
 {
    $status = $chall_info;
 } 
 elseif($ds['status']==3 && $ds['map1']) 
 {
    $status = $chall_info;
    
  if(!$ds['map1_final'] && !$ds['map2_final'] && !$ds['map3_final'] && !$ds['map4_final'] && !$ds['map5_final']) 
  {
     $na = 'n/a';
  }
  
  if($ds['map1_final']) 
  {
     $map1_final_option = 'Match map #1<br>';
     $map1_final = $ds['map1_final'].'<br>';
  }
  if($ds['map2_final']) 
  {
     $map2_final_option = 'Match map #2<br>';
     $map2_final = $ds['map2_final'].'<br>';
  }
  if($ds['map3_final']) 
  {
     $map3_final_option = 'Match map #3<br>';
     $map3_final = $ds['map3_final'].'<br>';
  }
  if($ds['map4_final']) 
  {
     $map4_final_option = 'Match map #4<br>';
     $map4_final = $ds['map4_final'].'<br>';
  }
  if($ds['map5_final']) 
  {
     $map5_final_option = 'Match map #5<br>';
     $map5_final = $ds['map5_final'].'<br>';
  }
  
  if($ds['game_date']) $playdate = 'on '.date('l M dS Y \@\ g:i a', $ds['game_date']).'';
  $finalized_ago = ', <b>'.returnTime2($ds['finalized_date']).'</b> ago.';
    
  $finalized_status = '
  
  	<tr>
      <td bgcolor="'.$bg1.'" rowspan="2">Info:</td>
	  <td bgcolor="'.$bg1.'">'.$challenger.' vs '.$challenged.' '.$playdate.'</td>
    </tr>
  	 <tr>
  	  <td bgcolor="'.$bg2.'">Finalized this challenge on <b>'.$finalized_date.'</b>'.$finalized_ago.'</td>
    </tr>
    <tr>
  	 <tr>
  	  <td bgcolor="'.$bg1.'" align="right"><b>Playing maps:</b><br>'.$map1_final_option.' '.$map2_final_option.' '.$map3_final_option.' '.$map4_final_option.' '.$map5_final_option.' </td>
  	  <td bgcolor="'.$bg1.'">'.$na.'<br>'.$map1_final.' '.$map2_final.' '.$map3_final.' '.$map4_final.' '.$map5_final.' </td>
    </tr>';   
 } 

  $challenge_status = '
  
  	<tr>
      <td bgcolor="$bg1">Info:</td>
	  <td bgcolor="$bg2">'.$status.'</td>
    </tr>';
    
    echo "<br />";
     
	  eval ("\$viewchallenge = \"".gettemplate("view_challenge")."\";");
	  echo $viewchallenge;

   } 

  }
  else echo 'There are no challenges on any ladders.';

 }

}
else echo '';

//ladder info - front end

  if(isset($_GET['ladderID'])) 
  { 

    $checkedteams = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='$laddID' AND checkin='1'");
    $active_teams = mysqli_num_rows($checkedteams);

    $unranked = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='$laddID' AND checkin='0'");
    $unranked_teams = mysqli_num_rows($unranked);

    $getmatches = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE ladID= '".$laddID."' && cupID='0'");
    $played_matches = mysqli_num_rows($getmatches);

    if(ladderis1on1($laddID)) $participants = 'Players';
    else $participants = 'Teams';

    $dd=mysqli_fetch_array(safe_query("SELECT platID FROM ".PREFIX."cup_ladders WHERE ID='$laddID'"));

    $ergebnis2 = safe_query("SELECT count(*) as number FROM ".PREFIX."cup_clans WHERE ladID='".$laddID."'");
    $dv=mysqli_fetch_array($ergebnis2);

  if(ladderis1on1($laddID)) 
  {
  
		if(isladparticipant($userID,$laddID,$checkin=0) && $dv['number'] < $lad['maxclan']) 
		{
		   $leave_ladder = '<img src="images/cup/error.png" width="16" height="16"> <a href="index.php?site=standings&ladderID='.$laddID.'&leave=true">Leave Ladder</a><br>';
		   
		   if(isset($_GET['leave']) && $_GET['leave']=="true") 
		   {
		      safe_query("DELETE FROM ".PREFIX."cup_clans WHERE clanID='$userID' && ladID='$laddID'");
		      redirect('?site=standings&ladderID='.$laddID, 'Successfully left the ladder.', 2);
		   }
		   
		}
		elseif(isset($_GET['leave']) && $_GET['leave']=="true")
		      echo "Either the ladder is already full or you are not a registered participant.";
 
    $ads=mysqli_fetch_array(safe_query("SELECT xp FROM ".PREFIX."cup_clans WHERE clanID='$userID' AND ladID='$laddID' AND 1on1='1'"));
    $yourXP = $ads['xp']; 
    
    if(isladparticipant($userID,$laddID,$checkin=0))
       $matchreporting = '<img border="0" src="images/cup/icons/edit.png"> <a href="index.php?site=matches&action=viewmatches&clanID='.$userID.'&laddID='.$laddID.'&type=1">Match Reporting</a><br>';

 }
 else
 { 
   
   if(isladparticipant($userID,$laddID,$checkin=0) && $dv['number'] < $lad['maxclan']) 
   $leave_ladder = '<img src="images/cup/error.png" width="16" height="16"> <a href="index.php?site=standings&ladderID='.$laddID.'&leave=true">Leave Ladder</a><br>';
   
    if(isset($_GET['leave']) && $_GET['leave']=="true") 
    {  
		if(isladparticipant($userID,$laddID,$checkin=0) && $dv['number'] < $lad['maxclan']) {
		      safe_query("DELETE FROM ".PREFIX."cup_clans WHERE clanID='".participantID($userID,$laddID)."' && ladID='$laddID'");
		      redirect('?site=standings&ladderID='.$laddID.'', 'Successfully left!', 2);
		}
		else
		{
		      redirect('?site=standings&ladderID='.$laddID.'', 'Either the ladder is already full or you are not leader of the team registered on the ladder.', 2);
	  }
   }

   $ads=mysqli_fetch_array(safe_query("SELECT xp FROM ".PREFIX."cup_clans WHERE clanID='".participantID($userID,$laddID)."' AND ladID='$laddID' AND 1on1='0'"));
   $yourXP = $ads['xp'];  

     if(isladparticipant($userID,$laddID,$checkin=0))
        $matchreporting = '<img border="0" src="images/cup/icons/edit.png"> <a href="index.php?site=matches&action=viewmatches&clanID='.participantID($userID,$laddID).'&laddID='.$laddID.'">Match Reporting</a><br>';
    } 

/* LADDER REGISTRATION */

  if(ladderis1on1($laddID)) 
  {
    if($loggedin && !isladparticipant($userID,$laddID,$checkin=0))
      $reg = '<img src="images/cup/new_message.gif"> <a href="index.php?site=ladders&action=register&laddID='.$laddID.'"><font color="#00FF00"><b>Sign-up Now!</b></font></a>';

  }
  else
  {

    $ergebnis = safe_query("SELECT * FROM ".PREFIX."cup_clan_members WHERE userID = '".$userID."' AND function = 'Leader'");		
      $clan = '<option value="" selected="selected"> - Select Team - </option>';	
        while($dm=mysqli_fetch_array($ergebnis))
      $clan .= '<option name="clanID" value="'.$dm['clanID'].'">'.getclanname($dm['clanID']).'</option>';

   if($loggedin && !isladparticipant($userID,$laddID,$checkin=0))

     $reg = '
        <form action="index.php">
          <input type="hidden" name="site" value="ladders">
          <input type="hidden" name="action" value="register">
          <input type="hidden" name="laddID" value="'.$laddID.'">
          <select name="clanID">'.$clan.'</select><br>
          <input type="submit" value="Sign-up Now!" onclick="return confirm(\'Confirm? \');">
        </form>'; 
   }
		

/* LONGEST STREAK */

   if(ladderis1on1($laddID)) 
   { 
    $participants = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='$laddID' AND 1on1='1' ORDER BY tp DESC");
     }else
    $participants = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='$laddID' AND 1on1='0' ORDER BY tp DESC");

    while($ls=mysqli_fetch_array($participants)) {
       $asdf []= getstreak($ls['clanID'],$laddID) . "." . $ls['clanID'];
   }
   
    if(isset($asdf)) {
        foreach ($asdf as $val) {
            $new_var[] = substr($val, 0, strrpos($val, ".")); 
        }
	}
	
	if(isset($new_var))
    $var_q = $asdf[array_search(max($new_var), $new_var)]; 
	
	if(isset($var_q))
    $longest_streak = (!$var_q ? "n/a" : getname1(substr($var_q, (strrpos($var_q, ".")+1)),$laddID,$ac=0,$var="ladder",1)." (".substr($var_q, 0, strrpos($var_q, ".")).")");
	else $longest_streak = "n/a";

/* HALL OF FAME */

   $team1='';
   $team2='';

   $getmatches = safe_query("SELECT clan1, clan2 FROM ".PREFIX."cup_matches WHERE ladID='$laddID'");
   while($ds=mysqli_fetch_array($getmatches)) { $team1.= ''.$ds['clan1'].','; $team2.= ''.$ds['clan2'].','; }
 
 
if(isset($_GET['view']) && $_GET['view']=='hof') 
 
  echo '
  <fieldset style="float:right; width:45%"><legend><b><a name="halloffame">Hall of Fame</a></b></legend>
     <table width="100%" cellspacing="0" cellpadding="'.$cellpadding.'" bgcolor="">
      <tr>
       <td bgcolor="'.$bg1.'">Most Competitive <img src="images/cup/icons/go.png" align="right"></td>
       <td bgcolor="'.$bg1.'">'.mostcompetitive($laddID).'</td>
      </tr>
      <tr>
       <td bgcolor="'.$bg2.'">Most Active <img src="images/cup/icons/go.png" align="right"></td>
       <td bgcolor="'.$bg2.'">'.mostactive($laddID).'</td>
      </tr>
      <tr>
       <td bgcolor="'.$bg1.'">Most Won <img src="images/cup/icons/go.png" align="right"></td>
       <td bgcolor="'.$bg1.'">'.mostwon($laddID).'</td>
      </tr>
      <tr>
       <td bgcolor="'.$bg2.'">Most Lost <img src="images/cup/icons/go.png" align="right"></td>
       <td bgcolor="'.$bg2.'">'.mostlost($laddID).'</td>
      </tr>
      <tr>
       <td bgcolor="'.$bg1.'">Leading Streak <img src="images/cup/icons/go.png" align="right"></td>
       <td bgcolor="'.$bg1.'">'.$longest_streak.'</td>
      </tr>
      <tr>
       <td bgcolor="'.$bg2.'">Leading XP <img src="images/cup/icons/go.png" align="right"></td>
       <td bgcolor="'.$bg2.'">'.leadingxp($laddID,$team1,$team2).'</td>
      </tr>
      <tr>
       <td bgcolor="'.$bg1.'">Longest Idle <img src="images/cup/icons/go.png" align="right"></td>
       <td bgcolor="'.$bg1.'">'.longestIdle($laddID).'</td>
      </tr>
      <tr>
       <td bgcolor="'.$bg2.'">Last Activity <img src="images/cup/icons/go.png" align="right"></td>
       <td bgcolor="'.$bg2.'">'.lastActivity($laddID).'</td>
      </tr>      
      <tr>
       <td bgcolor="'.$bg1.'">Most Credits <img src="images/cup/icons/go.png" align="right"></td>
       <td bgcolor="'.$bg1.'">'.mostcredits($laddID).'</td>
      </tr>
     </table> 
  </fieldset>'; 
  
  
//if standings not updated

    $laddID = $_GET['ladderID'];
    $partID = participantID($userID,$laddID);

    $query = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE ladID='$laddID' && (clan1='$partID' || clan2='$partID')");
        while($si=mysqli_fetch_array($query))
        {
        
            if(!$si['si'] && $si['confirmscore'] && ismatchparticipant($userID,$si['matchID'],$all=1)) 
            redirect('?site=cupactions&action=updatestandings&matchID='.$si['matchID'].'&clanID='.$partID.'&laddID='.$laddID.'', '<center><img src="images/cup/icons/loading_animation.gif"></center>', 0);
        
        }  

//get ladders

 $getladder = safe_query("SELECT * FROM ".PREFIX."cup_ladders WHERE ID='$laddID'");
  if(!mysqli_num_rows($getladder)) { die('Ladder does not exist.'); }

  
  if(!$hide_credits_column) {
      $cred_col = '<td bgcolor="'.$bg1.'" class="title2" align="center">CR</td>';
  }
  else{
      $cred_col = '';
  }

  if($lad['challallow']==1 || $lad['challallow']==2){
      $report_now = '<td bgcolor="'.$bg1.'" class="title2" align="center">Report</td>';
  }
  else{
      $report_now = '';
  }

//check for existing data

   
   $dis_unrank = ($display=='unranked' ? "checkin='0'" : "checkin='1'");

   $result = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='".$laddID."' && $dis_unrank");
   $are_participants = mysqli_num_rows($result);
   
   $result1 = safe_query("SELECT * FROM ".PREFIX."cup_challenges WHERE ladID='".$laddID."'");
   $are_challenges = mysqli_num_rows($result1);
   
   $result2 = safe_query("SELECT * FROM ".PREFIX."cup_deduction WHERE ladID='".$laddID."' AND credit <= ".$lad['deduct_credits']);
   $are_deductions = mysqli_num_rows($result2);
   
   $result3 = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE ladID='".$laddID."' && confirmscore='1' && $one_query");
   $are_matches = mysqli_num_rows($result3);

//standings table head

  $chk_unranked = safe_query("SELECT credit FROM ".PREFIX."cup_clans WHERE ladID='$laddID' && credit < 1");
  $chk_ranked = safe_query("SELECT credit FROM ".PREFIX."cup_clans WHERE ladID='$laddID' && credit > 0");
  
   if(getcredits(participantID($userID,$laddID),$laddID)<1) {
          $unranking_st = ' <a href="?site=standings&ladderID='.$laddID.'&display=unranked">of the unranked</a>';
		  $unranking_vl = 1;
   }
   else{
          $unranking_st = ''; 
		  $unranking_vl = 0;
   }
   
		//freeagent notification
		
		$qk_fch=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_ladders WHERE ID='$laddID'"));
		
		if(($qk_fch['sign'] && $qk_fch['status']==2) OR $qk_fch['status']==1) {
           $freeagents = safe_query("SELECT * FROM ".PREFIX."cup_agents WHERE ladID='$laddID' && cupID='0'");
		   if(mysqli_num_rows($freeagents) && isladparticipant($userID,$laddID))
		   echo "<div ".$error_box."> There are free-agents available for this league. Click <a href='?site=freeagents&action=view&laddID=".$laddID."'>here</a> to view.</div>";
		}
   
   if($views!= 'credit_statement' && $views != 'credit_statement_extended') $sh_txt = 'Matches/Challenges';
   else $sh_txt = 'Credit Statement';
   
   $credit_statement_np = isset($_GET['participantID']) ? '<a href="?site=standings&ladderID='.$laddID.'&view=credit_statement">Credit Statement</a> >>' : '';
   
   if(isset($_GET['participantID']) && $views=='credit_statement') 
   $user_only = '<a href="?site=standings&ladderID='.$laddID.'">Standings</a> >> '.$credit_statement_np.' '.$viewing_tm.' Credit Statement'; 
   
   elseif(isset($_GET['participantID']) && isset($_GET['view']) && $_GET['view']=='credit_statement_extended') 
   $user_only = '<a href="?site=standings&ladderID='.$laddID.'">Standings</a> >> '.$credit_statement_np.' '.$viewing_tm.' <a href="?site=standings&ladderID='.$laddID.'&view=credit_statement&participantID='.$_GET['participantID'].'">Credit Statement</a> >> Extended'; 
      
   elseif(isset($_GET['participantID'])) 
   $user_only = '<a href="?site=standings&ladderID='.$laddID.'">Standings</a> >> '.$viewing_tm.' Challenges & Matches'; 
   
   elseif($views=='credit_statement_extended') 
   $public_sh = '<a href="?site=standings&ladderID='.$laddID.'">Standings</a> >> '.$credit_statement_np.' '.$viewing_tm.'  <a href="?site=standings&ladderID='.$laddID.'&view=credit_statement">Credit Statement</a> >> Extended'; 
   
   elseif($views=='credit_statement') 
   $public_sh = '<a href="?site=standings&ladderID='.$laddID.'">Standings</a> >> '.$credit_statement_np.' '.$viewing_tm.' Credit Statement';
   
   if((getrank(participantID($userID,$laddID),$laddID,'now',$unranking_vl) > 20 || $unranking_st) && isladparticipant_memin($userID,$laddID,0) && $display!='unranked') {
          $info_sh1 = 'Your are rank <strong>'.getrank(participantID($userID,$laddID),$laddID,$type_rk='now',$unranking_vl).'</strong>'.$unranking_st;
   }
   elseif($_GET['display']!='unranked' && mysqli_num_rows($chk_unranked) && !$_GET['participantID'] && !mysqli_num_rows($chk_ranked) && $unranking==1) {
          $info_sh1 = 'No ranked participants >> <a href="?site=standings&ladderID='.$laddID.'&display=unranked"> View Unranked</a>'; 
   }
   else{
          $info_sh1 = '';
   }
   
   if(isset($user_only)) {
          $info_sh2 = $user_only; 
   }
   elseif(isset($public_sh)) {
          $info_sh2 = $public_sh; 
   }
   else{
          $info_sh2 = '';
   }
   
   $br = $info_sh1 && $info_sh2 ? '<br />' : '';
   
   if($info_sh1 OR $info_sh2)
   echo '<div class="infobox">'.$info_sh1.' '.$br.' '.$info_sh2.'</div>';
   
   if($are_participants) {
   
   $row_span = $are_participants+2;
   
   if($ap['number'] > 20) {
      $show_bars = '<td rowspan="'.$row_span.'" width="1">'.$bars.'</td>';
   }
   else{
      $show_bars = '';
   }
   
   $sort = isset($_GET['sort']) ? $_GET['sort'] : false;
   
   if($sort=='player') {
         $sort_img = ($_GET['order']=='desc' ? '<img src="images/icons/desc.gif">' : '<img src="images/icons/asc.gif">');
	     $sort_lnk = ($_GET['order']=='desc' ? '&order=asc' : '&order=desc');
   }
   else{
         $sort_img = '';
		 $sort_lnk = '';
   }
   
   if($sort=='rank' && $_GET['order']) {
         $sort_img2 = ($_GET['order']=='desc' ? '<img src="images/icons/desc.gif">' : '<img src="images/icons/asc.gif">');
	     $sort_lnk2 = ($_GET['order']=='desc' ? '&order=asc' : '&order=desc');
   }
   else{
         $sort_img2 = '';
		 $sort_lnk2 = '';
   }
   
   if($sort=='points') {
         $sort_img3 = ($_GET['order']=='desc' ? '<img src="images/icons/desc.gif">' : '<img src="images/icons/asc.gif">');
	     $sort_lnk3 = ($_GET['order']=='desc' ? '&order=asc' : '&order=desc');
   }
   else{
         $sort_img3 = '';
		 $sort_lnk3 = '';
   }
   
   if($sort=='win') {
         $sort_img4 = ($_GET['order']=='desc' ? '<img src="images/icons/desc.gif">' : '<img src="images/icons/asc.gif">');
	     $sort_lnk4 = ($_GET['order']=='desc' ? '&order=asc' : '&order=desc');
   }
   else{
         $sort_img4 = '';
		 $sort_lnk4 = '';
   }
   
   if($sort=='draw') {
         $sort_img5 = ($_GET['order']=='desc' ? '<img src="images/icons/desc.gif">' : '<img src="images/icons/asc.gif">');
	     $sort_lnk5 = ($_GET['order']=='desc' ? '&order=asc' : '&order=desc');
   }
   else{
         $sort_img5 = '';
		 $sort_lnk5 = '';
   }
   
   if($sort=='loss') {
         $sort_img6 = ($_GET['order']=='desc' ? '<img src="images/icons/desc.gif">' : '<img src="images/icons/asc.gif">');
	     $sort_lnk6 = ($_GET['order']=='desc' ? '&order=asc' : '&order=desc');
   }
   else{
         $sort_img6 = '';
		 $sort_lnk6 = '';
   }
   
   if($sort=='streak') {
         $sort_img7 = ($_GET['order']=='desc' ? '<img src="images/icons/desc.gif">' : '<img src="images/icons/asc.gif">');
	     $sort_lnk7 = ($_GET['order']=='desc' ? '&order=asc' : '&order=desc');
   }
   else{
         $sort_img7 = '';
		 $sort_lnk7 = '';
   }
   
   $sort_lnk2 = (isset($_GET['order']) && $_GET['order']=='desc' ? '&order=asc' : '&order=desc');
   
//del challenge

if(isset($_GET['action']) && $_GET['action']=='delchall') {
   if(isset($_GET['challID']) && iscupadmin($userID)) {
      if(safe_query("DELETE FROM ".PREFIX."cup_challenges WHERE chalID='".$_GET['challID']."'")) {
	         redirect('?site=standings&ladderID='.$laddID, '<div class="errorbox">Challenge delete successful <img src="images/cup/success.png"></div>', 2);
      }
      else{
             echo '<div class="errorbox">Critical error: Unable to delete challenge.</div>';
      }	  
   }
}
//end

if($view=='hof') {
   $hof_link = '<a href="?site=standings&ladderID='.$laddID.'"><img src="images/cup/icons/deduct.png" align="right"></a>';
}
else{
   $hof_link = '<a href="?site=standings&ladderID='.$laddID.'&view=hof#halloffame"><img src="images/cup/icons/add.png" align="right"></a>';
}

$show_prt_ext = ($participantID ? '&participantID='.$participantID : '');
$points_head = (ladder_ranksys($laddID) == "elo" ? "ELO" : "Points");


   echo '<frameset cols="25%,50%,25%"><table width="100%" cellpadding="'.$cellpadding.'" cellspacing="'.$cellspacing.'" bgcolor="'.$border.'">
	  <tr>
	    <td class="title2" align="center"><a href="?site=standings&ladderID='.$laddID.'&sort=rank'.$sort_lnk2.'" style="text-decoration:none; color: inherit;"><strong>Rank</strong></a> '.$sort_img2.'</td>
	    <td class="title2"><a href="?site=standings&ladderID='.$laddID.'&sort=player'.$sort_lnk.'" style="text-decoration:none; color: inherit;"><strong>'.(ladderis1on1($laddID) ? "Players" : "Teams").'</strong></a> '.$sort_img.'</td>
	    <td class="title2" align="center"><a href="?site=standings&ladderID='.$laddID.'&sort=points'.$sort_lnk3.'" style="text-decoration:none; color: inherit;"><strong>'.$points_head.'</strong></a> '.$sort_img3.'</td>
	    <td class="title2" align="center"><strong>DIFF.</td>
	    <td class="title2" align="center"><a href="?site=standings&ladderID='.$laddID.'&sort=win'.$sort_lnk4.'" style="text-decoration:none; color: inherit;"><strong>W</strong></a> '.$sort_img4.'</td>
	    <td class="title2" align="center"><a href="?site=standings&ladderID='.$laddID.'&sort=draw'.$sort_lnk5.'" style="text-decoration:none; color: inherit;"><strong>D</strong></a> '.$sort_img5.'</td>
	    <td class="title2" align="center"><a href="?site=standings&ladderID='.$laddID.'&sort=loss'.$sort_lnk6.'" style="text-decoration:none; color: inherit;"><strong>L</strong></a> '.$sort_img6.'</td>
	    <td class="title2" align="center"><a href="?site=standings&ladderID='.$laddID.'&sort=streak'.$sort_lnk7.'" style="text-decoration:none; color: inherit;"><strong>Streak</strong></a> '.$sort_img7.'</td>
	    <td class="title2" align="center">Rating</a></td>
	    <td class="title2" align="center">'.$hof_link.' <a href="?site=standings&ladderID='.$laddID.'&view=credit_statement'.$show_prt_ext.'"><img alt="View Credit-Statement" src="images/cup/icons/credits.png" align="right"></a</td>
	    '.$show_bars.'
	  </tr>';
				
				
  }
 

 $ld=mysqli_fetch_array($getladder);
 $laddID = $ld['ID'];
 
 $order_sort = (isset($_GET['order']) && $_GET['order']=='asc' ? "ASC" : "DESC");
 
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
   $display_unranked = ($display=='unranked' ? "0" : "1");
   $display_user_only= ($participantID!=0 ? 'AND clanID='.$participantID : "");
   $display_limit = (!$display_user_only ? $limit_by : '');
   $standings_rank = 1;
   
   if(ladderis1on1($_GET['ladderID']))  {  
      $participants = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='".$_GET['ladderID']."' AND 1on1='1' AND checkin = '$display_unranked' $display_user_only $rank_by $display_limit");
   }
   else{
      $participants = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='".$_GET['ladderID']."' AND 1on1='0' AND checkin = '$display_unranked' $display_user_only $rank_by $display_limit");
   }
   
   $table_num_rows = mysqli_num_rows($participants);
   $chk_unranked = safe_query("SELECT credit FROM ".PREFIX."cup_clans WHERE ladID='".$_GET['ladderID']."' && credit < 1");

   if(empty($table_num_rows) && !mysqli_num_rows($chk_unranked)) {
      echo '<div class="infobox">No participants found. Visit <a href="?site=quicknavi&type=ladders&cup='.getalphaladname($_GET['ladderID']).'">this link</a> for sign-ups.</div>';
   }
   
//check next button

   $qp1=mysqli_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE ladID='".$_GET['ladderID']."' ORDER BY rank_now DESC LIMIT 0,1"));
   
   if(!isset($show_rankings))
   $show_rankings = '';
   
   $query = safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE ladID='".$_GET['ladderID']."'  $show_rankings");
     while( $row = mysqli_fetch_assoc($query)) {
       $array[] = $row['clanID'];   	   
   }
   
   if(!isset($page_up))
   $page_up = '';
   

   if(($start==1 || empty($_GET['start'])) && !in_array($qp1['clanID'],$array)){ 
      $onclick = "?site=standings&ladderID=$_GET[ladderID]&start=$page_up$viewing_unranked";
   }
   else{
      $onclick = "?site=standings&ladderID=$_GET[ladderID]&start=$page_up$viewing_unranked";
   }
   
   if($table_num_rows < $num_per_page-1){ 
	   $button_next = '<img id="myImage" src="images/cup/icons/deduct.png">';
   }
   else{
	   $button_next = '<a href="'.$onclick.'"><img src="images/cup/icons/deduct.png"></a>';
   }
   
   //anas loop query 

   while($ds=mysqli_fetch_array($participants))
   { 
   
   $teamID = $ds['clanID']; 

   if(isset($_GET['display']) && $_GET['display']=='unranked') {
	         $rank = getrank($teamID,$_GET['ladderID'],'now',1);
   } else {
	         $rank = getrank($teamID,$_GET['ladderID'],'now',0);
   } 
   
   $getmatches = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE ladID='$laddID' AND (clan1='$teamID' || clan2='$teamID')");
   $dm = mysqli_fetch_array($getmatches);

//last activity

   $time_plus_inactivity = time()-$lad['inactivity'];
   
   $last_activity = 0;

   if($ds['registered'] && $ds['registered'] > $ds['lastact'] && $ds['registered'] > $ds['lastdeduct'] && $ds['registered'] < $time_plus_inactivity){
      $last_activity = number_format((float)returnTime($ds['registered']));
   }
   elseif($ds['lastdeduct'] && $ds['lastdeduct'] > $ds['lastact'] && $ds['lastdeduct'] > $ds['registered'] && $ds['lastdeduct'] < $time_plus_inactivity){
      $last_activity = number_format((float)returnTime($ds['lastdeduct']));
   }
   elseif($ds['lastact'] && $ds['lastact'] > $ds['registered'] && $ds['lastact'] > $ds['lastdeduct'] && $ds['lastact'] < $time_plus_inactivity){
      $last_activity = number_format((float)returnTime($ds['lastact']));
   }
   else{
      $last_activity = 0;
   }    
   
   $la_cd = false;

    if($ds['registered'] && $ds['registered'] > $ds['lastact']){
      $last_activity2 = returnTime2($ds['registered']);
      
      if($ds['registered'] <= $time_plus_inactivity) {
         $la_cd = true;
      } 
    }
    elseif($ds['lastact'] && $ds['lastact'] > $ds['registered']){
      $last_activity2 = returnTime2($ds['lastact']);
      
      if($ds['lastact'] <= $time_plus_inactivity) {
         $la_cd = true;
      } 
    }
    else{
      $last_activity2 = 'n/a';
      $la_cd = false;
    }

    if($ds['registered'] && $ds['registered'] > $ds['lastact']){
      $last_activity3 = returnTime3($ds['registered']);
    }
    elseif($ds['lastact'] && $ds['lastact'] > $ds['registered']){
      $last_activity3 = returnTime3($ds['lastact']);
    }

//get challenges


   $getchallenges = safe_query("SELECT * FROM ".PREFIX."cup_challenges WHERE ladID='$laddID' AND (challenger='".$teamID."' || challenged='".$teamID."')");
     while($ch=mysqli_fetch_array($getchallenges))
     {

     $challID = $ch['chalID'];
     $challstatus = $ch['status']; 
     $timetorespond = $ch['new_date']+$lad['timetorespond'];
     $timetofinalize = $ch['reply_date']+$lad['timetofinalize'];

     $day = date('d');
     $month = date('m');
     $year = date('Y');
     $hour = date('H');
     $min = date('i');
     $current_date = @mktime($hour, $min, 0, $month, $day, $year);

//creditibility

     $credits1 = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='".$ch['ladID']."' AND clanID='".$ch['challenger']."'");
     $credits2 = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='".$ch['ladID']."' AND clanID='".$ch['challenged']."'");

     $cd1 = mysqli_fetch_array($credits1);
     $cd2 = mysqli_fetch_array($credits2);

     $team1_forfeit_loss = $cd1['credit']-$forfeitloss;
     $team2_forfeit_loss = $cd2['credit']-$forfeitloss;
     $team1_forfeit_award = $cd1['credit']+$forfeitaward;
     $team2_forfeit_award = $cd2['credit']+$forfeitaward;
     
     $t1_totalp_loss = $cd1['credit']+$cd1['xp']-$forfeitloss;
     $t2_totalp_loss = $cd2['credit']+$cd2['xp']-$forfeitloss;  
     $t1_totalp_award = $cd1['credit']+$cd1['xp']+$forfeitaward;
     $t2_totalp_award = $cd2['credit']+$cd2['xp']+$forfeitaward;   

     $team1_loss = $cd1['lost']+1;
     $team2_loss = $cd2['lost']+1;
     $team1_won = $cd1['won']+1;
     $team2_won = $cd2['won']+1;

     $team1_streak_won = $cd1['streak']+1;
     $team2_streak_won = $cd2['streak']+1;

    if(($ch['status']==1 || $challstatus==1) && $current_date >= $timetorespond) 
    {
         safe_query("UPDATE ".PREFIX."cup_clans SET credit='$team2_forfeit_loss', lastpos='2', tp='$t2_totalp_loss' WHERE clanID='".$ch['challenged']."' && ladID='".$ch['ladID']."'");
         safe_query("UPDATE ".PREFIX."cup_clans SET credit='$team1_forfeit_award', lastpos='1', tp='$t1_totalp_award' WHERE clanID='".$ch['challenger']."' && ladID='".$ch['ladID']."'");
         safe_query("UPDATE ".PREFIX."cup_challenges SET chr_credit='".getcredits($ch['challenger'],$ch['ladID'])."', chd_credit='".getcredits($ch['challenged'],$ch['ladID'])."', status='4', forfeit='".$ch['challenged']."' WHERE chalID='$ID' || chalID='$challID'");
    }
    if(($ch['status']==2 || $challstatus==2)  && $current_date >= $timetofinalize) 
    {  
         safe_query("UPDATE ".PREFIX."cup_clans SET credit='$team1_forfeit_loss', lastpos='2', tp='$t1_totalp_losss' WHERE clanID='".$ch['challenger']."' && ladID='".$ch['ladID']."'");
         safe_query("UPDATE ".PREFIX."cup_clans SET credit='$team2_forfeit_award', lastpos='1', tp='$t2_totalp_award' WHERE clanID='".$ch['challenged']."' && ladID='".$ch['ladID']."'");
         safe_query("UPDATE ".PREFIX."cup_challenges SET chr_credit='".getcredits($ch['challenger'],$ch['ladID'])."', chd_credit='".getcredits($ch['challenged'],$ch['ladID'])."', status='4', forfeit='".$ch['challenger']."' WHERE chalID='$ID' || chalID='$challID'");
    }
}

/* MATCH STATS */

  if(ladderis1on1($laddID)) {
    $ads=mysqli_fetch_array(safe_query("SELECT won, draw, lost, xp FROM ".PREFIX."cup_clans WHERE clanID='$teamID' AND ladID='$laddID' AND 1on1='1'"));
	$ucp_team = 0;
  }
  else{
    $ads=mysqli_fetch_array(safe_query("SELECT won, draw, lost, xp FROM ".PREFIX."cup_clans WHERE clanID='$teamID' AND ladID='$laddID' AND 1on1='0'"));
	$ucp_team = 1;
  }

    $added_wonmatches = $ads['won'];
    $added_drawmatches = $ads['draw'];
    $added_lostmatches = $ads['lost'];
    $added_xp = $ads['xp'];

//ratio

  $man_stats = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='".$laddID."' AND clanID='$teamID'");
  $ms = mysqli_fetch_array($man_stats);

  if($ratio_determination) {
     $challenger_ratio=percent($ms['won'], $ms['won']+$ms['draw']+$ms['lost'], 2);
     $challenged_ratio=percent($ms['won'], $ms['won']+$ms['draw']+$ms['lost'], 2);
  }
  else{
     $challenger_ratio=percent(user_cup_points($dm['clan1'],$laddID,$ucp_team,1,0,'confirmed_p','ladder'), user_cup_points($dm['clan1'],$laddID,$ucp_team,0,0,'confirmed_p','ladder'), 2);
     $challenged_ratio=percent(user_cup_points($dm['clan2'],$laddID,$ucp_team,1,0,'confirmed_p','ladder'), user_cup_points($dm['clan2'],$laddID,$ucp_team,0,0,'confirmed_p','ladder'), 2);
  }

/* Calculate Stats */

     $won_matches = $ms['won'];
     $lost_matches = $ms['lost']; 
     $draw_matches = $ms['draw'];
     $xp_points = $ms['xp'];   
     
    if($dm['clan1']==$teamID) {
         $ratio = $challenger_ratio.'%';      
    }
    else{ 
         $ratio = $challenged_ratio.'%';;
    }
    
    if($ds['rank_now'] && $ds['rank_then'])
    {
       
       $rank_diff1 = $ds['rank_now']-$ds['rank_then'];
       $rank_diff2 = $ds['rank_then']-$ds['rank_now'];
    
       if($ds['rank_now'] > $ds['rank_then'])
       {
          $diff_rank = "-".$rank_diff1;
       }
       elseif($ds['rank_now'] < $ds['rank_then'])
       {
          $diff_rank = "+".$rank_diff2;
       }
       else
       {
          $diff_rank = "+0";
       }
    }
    else
    {
          $diff_rank = "n/a";
    }
	
	if(isset($_GET['display']) && $_GET['display']=='unranked') {
	   if( isset($_GET['participantID'])) {
	      $ext_sh = '&display=unranked';
	   } else {
	      $ext_sh = '&participantID='.$teamID.'&display=unranked';
	   }
	} else {
	   $ext_sh = '&participantID='.$teamID;
	}
	
    switch($ds['lastpos']) 
    {
      case 1: $position = '<a href="?site=standings&ladderID='.$laddID.$ext_sh.'"><img src="images/cup/icons/rank_up.gif" align="right"></a>'; 
      break;
      case 2: $position = '<a href="?site=standings&ladderID='.$laddID.$ext_sh.'"><img src="images/cup/icons/rank_down.gif" align="right"></a>'; 
      break;
      case 3: $position = '<a href="?site=standings&ladderID='.$laddID.$ext_sh.'"><img src="images/cup/icons/refresh.png" width="15" height="12" align="right"></a>'; 
      break;
    }
    
    if(empty($ds['lastpos']))
              $position = ""; 

    if(empty($xp_points)) $xp = 0;
    else $xp = $xp_points;
    
    if(empty($won_matches)) $won = 0;
    else $won = $won_matches;

    if(empty($draw_matches)) $draw = 0;
    else $draw = $draw_matches;
    
    if(empty($lost_matches)) $lost = 0;
    else $lost = $lost_matches;
    
 $cc=mysqli_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clan_members WHERE userID='$userID'"));

if(!$userID || !$cc['clanID'])
   $new_challenge = '<img id="myImage" src="images/cup/icons/challenge.gif" border="0">';
    
if(!$hide_credits_column) 
   $cred_col_cont = '<td bgcolor="'.$bg1.'" align="center">'.$ds['credit'].'</td>';
  
if($lad['challallow']==1 || $lad['challallow']==2)
{
   $report = ($lad['challallow']==2 ? '<strong>REP</strong>' : '<strong>Report</strong>');
 
   if(!ladderis1on1($laddID)) 
   {
     if(participantID($userID,$laddID)!=$teamID)   
     {
       $report_now3 = '<a href="?site=standings&action=report&laddID='.$laddID.'&challenged='.$teamID.'"><img src="images/cup/icons/report.png" width="24" height="24"></a>';
       $report_now = "<a title=\"Report\" href=\"?site=standings&action=report&laddID=$laddID&challenged=$teamID\">$report</a>";
       $report_now2 = '<input type="button" onclick="MM_goToURL(\'parent\',\'?site=standings&action=report&laddID='.$laddID.'&challenged='.$teamID.'\');return document.MM_returnValue" value="Report" />';
     }
     else
     {
       $report_now3 = '<img id="myImage" src="images/cup/icons/report.png" width="24" height="24">';
       $report_now = "N/A";
       $report_now2 = '<input type="button" onclick="MM_goToURL(\'parent\',\');return document.MM_returnValue" value="Report" />';
       
     }
  }
  else
  {

   if(participantID($userID,$laddID)!=$teamID)   
   {
     $report_now3 = '<a href="?site=standings&action=report&laddID='.$laddID.'&challenged='.$teamID.'"><img src="images/cup/icons/report.png" width="24" height="24"></a>';
     $report_now = "<a title=\"Report\" href=\"?site=standings&action=report&laddID=$laddID&challenged=$teamID\">$report</a>";
     $report_now2 = '<input type="button" onclick="MM_goToURL(\'parent\',\'?site=standings&action=report&laddID='.$laddID.'&challenged='.$teamID.'\');return document.MM_returnValue" value="Report" />';
     
   }
   else
   {
     $report_now3 = '<img id="myImage" src="images/cup/icons/report.png" width="24" height="24">';
     $report_now = "N/A";
     $report_now2 = '<input type="button" onclick="MM_goToURL(\'parent\',\');return document.MM_returnValue" value="Report" />';
   }
 }
}   

    $avg_points = round(ladder_points($laddID,$avg=1));
    $ranksys = ladder_ranksys($laddID);
    
	$average = getrating($teamID,$laddID,'average');
    $rating = getrating($teamID,$laddID,'rating');
	$level = getrating($teamID,$laddID,'level');
    
    $first=mysqli_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE ladID='".$ds['ladID']."' ORDER BY $ranksys DESC LIMIT 0,1"));
    $second=mysqli_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE ladID='".$ds['ladID']."' ORDER BY $ranksys DESC LIMIT 1,1"));
    $third=mysqli_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE ladID='".$ds['ladID']."' ORDER BY $ranksys DESC LIMIT 2,1"));
    
    if($first['clanID']==$teamID) {
	   $class = 'class="moveDown"';
	   $ranking_cell = 'ungerade';
	   $bg_color = $bg1;
    }
    elseif(is_odd($rank)){
	   $class = '';
	   $ranking_cell = 'ungerade';
	   $bg_color = $bg1;
    }
    else{
	   $class = '';
	   $ranking_cell = 'gerade';
	   $bg_color = $bg2;
    }
    
    if(participantID_memin($userID,$laddID)==$teamID && $loggedin){  
	   $my_position = 'myposition';
    }
    elseif($first['clanID']==$teamID && !participantID($userID,$laddID)==$teamID) { 
	   $my_position = 'firstposition';
    }
    else{
       $my_position = '';
    }

  if(ladderis1on1($ds['ladID'])) { 


    $site = mysqli_fetch_array(safe_query("SELECT hpurl FROM ".PREFIX."settings"));
    $img = 'http://'.$site['hpurl'].'/images/avatars/'.getavatar($teamID);
    $avatar = 'images/avatars/'.getavatar($teamID);

    if($userID==$ds['clanID'] || !$loggedin) { 
       $new_challenge = '<img id="myImage" src="images/cup/icons/challenge.gif" border="0" width="24" height="24">';
    }
    else{
       $new_challenge = '<a href="?site=standings&action=newchallenge&laddID='.$laddID.'&challenged='.$teamID.'"><img src="images/cup/icons/challenge.gif" border="0" width="24" height="24"></a>';
    }
    
  }
  else
  { 
       
     $cl = mysqli_fetch_array(safe_query("SELECT clanlogo FROM ".PREFIX."cup_all_clans WHERE ID='$teamID'"));
     
     $url = $cl['clanlogo'];     
     $avatar = (empty($cl['clanlogo']) || !is_array($url) ? 'images/avatars/noavatar.gif' : $cl['clanlogo']);   

     if($ds['clanID']==participantID($userID,$laddID)){
        $new_challenge = '<img id="myImage" src="images/cup/icons/challenge.gif" border="0" width="24" height="24">';
     }
     else{
        $new_challenge = '<a href="?site=standings&action=newchallenge&laddID='.$laddID.'&challenger='.participantID($userID,$laddID).'&challenged='.$teamID.'"><img src="images/cup/icons/challenge.gif" border="0" width="24" height="24"></a>';
     }
  }
				$lastmatch = mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE ladID='$laddID' && (clan1='$teamID' || clan2='$teamID') && (clan1 != '0' AND clan2 != '0') && (clan1 !='2147483647' AND clan2 !='2147483647') && $one_query && confirmscore='1' ORDER BY confirmed_date DESC LIMIT 0,1"));
				$lastchallenge = mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_challenges WHERE ladID='$laddID' && (challenger='$teamID' || challenged='$teamID') && forfeit!='0' ORDER BY chalID DESC LIMIT 0,1"));
				
				if($teamID==$lastmatch['clan1'] && $lastmatch['score1'] > $lastmatch['score2']){
				   $last_points = '<a href='.matchlink($lastmatch['matchID'],0,1,0).'><font color="'.$wincolor.'"><strong>+'.($differential ? $lastmatch['score1']-$lastmatch['score2'] : $lastmatch['score1']).'</strong></font></a>';
				   $last_points_ch = 1;
				}
				elseif($teamID==$lastmatch['clan1'] && $lastmatch['score1'] < $lastmatch['score2']){
				   $last_points = '<a href='.matchlink($lastmatch['matchID'],0,1,0).'><font color="'.$loosecolor.'"><strong>-'.($differential ? $lastmatch['score1']-$lastmatch['score2'] : $lastmatch['score1']).'</strong></font></a>';
				   $last_points_ch = 0;
				}
				elseif($teamID==$lastmatch['clan2'] && $lastmatch['score1'] > $lastmatch['score2']){
				   $last_points = '<a href='.matchlink($lastmatch['matchID'],0,1,0).'><font color="'.$loosecolor.'"><strong>-'.($differential ? $lastmatch['score2']-$lastmatch['score1'] : $lastmatch['score2']).'</strong></font></a>';
				   $last_points_ch = 0;
				}
				elseif($teamID==$lastmatch['clan2'] && $lastmatch['score1'] < $lastmatch['score2']){
				   $last_points = '<a href='.matchlink($lastmatch['matchID'],0,1,0).'><font color="'.$wincolor.'"><strong>+'.($differential ? $lastmatch['score2']-$lastmatch['score1'] : $lastmatch['score2']).'</strong></font></a>';
				   $last_points_ch = 1;
				}
				elseif(($teamID==$lastchallenge['challenger'] || $teamID==$lastchallenge['challenged']) && $teamID==$lastchallenge['forfeit']){
				   $last_points = '<a href="?site=standings&action=viewchallenge&laddID='.$lastchallenge['ladID'].'&challID='.$lastchallenge['chalID'].'" target="_blank"><font color="'.$loosecolor.'"><strong>-'.$forfeitloss.'</strong></font></a>';
				   $last_points_ch = 0;
				}
				elseif(($teamID==$lastchallenge['challenger'] || $teamID==$lastchallenge['challenged']) && $teamID!=$lastchallenge['forfeit']){
				   $last_points = '<a href="?site=standings&action=viewchallenge&laddID='.$lastchallenge['ladID'].'&challID='.$lastchallenge['chalID'].'" target="_blank"><font color="'.$wincolor.'"><strong>+'.$forfeitaward.'</strong></font></a>';
				   $last_points_ch = 1;
				}
				else{
				   $last_points = '0';
				   $last_points_ch = 0;
				}
				
				if(($teamID==$lastchallenge['challenger'] || $teamID==$lastchallenge['challenged']) && $teamID==$lastchallenge['forfeit']){
				   $forfeit = 1;
				}
				elseif(($teamID==$lastchallenge['challenger'] || $teamID==$lastchallenge['challenged']) && $teamID!=$lastchallenge['forfeit']){
				   $forfeit = 2;
				}
				else{
				   $forfeit = 0;
				}
				
				$checkdeduction = (checkdeduction($laddID,$teamID)==true && $la_cd==true ? '<img src="images/cup/icons/credits.png" width="16" height="16" border="0" align="right">' : '');				
                $challinfo = checkchallenge($laddID,$teamID);                
                $checkchallenge = ($challinfo['step']==7 || $challinfo['step']==8 ? '<blink><img src="images/cup/icons/warning.png" width="16" height="16" align="right"></blink>' : '');
                $ladd_type = (ladderis1on1($laddID) ? '&type=1' : '');  
                $matchstatus = match_status2($userID,$laddID,$teamID);
                $checkmatch = ($matchstatus['step']==3 || $matchstatus['step']==4 ? '<blink><img src="images/cup/icons/warning.png" width="16" height="16" align="right"></blink>' : '');
                $checkmatch.= ($matchstatus['step']==5 || $matchstatus['step']==6 ? '<blink><img src="images/cup/icons/contact_info.png" align="right"></blink>' : '');
                $checkstreak = ($ds['streak']==5 ? '<blink><img src="images/cup/icons/ok_32.png" width="16" height="16" align="right"></blink>' : '');
                //$checkloss = ($ds['lost']==5 && $ds['streak']==0 ? '<blink><img src="images/cup/icons/nok_32.png" width="16" height="16" align="right"></blink>' : '');
				$checkloss = '';
                $checkforfeit = ($forfeit==1 ? '<img src="images/cup/icons/credits.png" width="16" height="16" align="right"border="0">' : '');         
                $checkforfeit_award = ($forfeit==2 ? '<img src="images/cup/icons/credits.png" width="16" height="16" align="right" border="0">' : '');  
		        $checkinactivity = ($last_activity3 >= $days_inactive ? '<img src="images/cup/icons/inactive.png" align="right">' : '');
				$ismatch = (ismatch($teamID,$laddID,'ladID') ? '<img src="images/cup/icons/add_result.gif" width="16" height="16" align="right">' : '');		

                $fordern = (!$lad['challallow'] || $lad['challallow']==1 ? 'fordern2' : 'fordern');
                
                if($lad['challallow']==1){ 
				   $fight = $report_now2;
                }
                elseif(!$lad['challallow']){
				   $fight = (participantID($userID,$laddID)==$teamID && $loggedin ? '<input type="button" onclick="MM_goToURL(\'parent\',\');return document.MM_returnValue" value="Challenge" />' : '<input type="button" onclick="MM_goToURL(\'parent\',\'?site=standings&action=newchallenge&laddID='.$laddID.'&challenged='.$teamID.'\');return document.MM_returnValue" value="Challenge" />');
                }
                elseif($lad['challallow']==2){
				   $fight = (participantID($userID,$laddID)==$teamID && $loggedin ? '<input type="button" onclick="MM_goToURL(\'parent\',\');return document.MM_returnValue" value="Challenge" />&nbsp;'.$report_now2 : '<input type="button" onclick="MM_goToURL(\'parent\',\'?site=standings&action=newchallenge&laddID='.$laddID.'&challenged='.$teamID.'\');return document.MM_returnValue" value="Challenge" />&nbsp;'.$report_now2);
                }

        $link_ext = (ladderis1on1($laddID) ? '&laddID='.$laddID.'&display=cup#stats' : '&laddID='.$laddID.'&display=stats');       

if($lad['status']!=3) {
	
//check deduction	

if($checkdeduction==true && participantID($userID,$laddID)==$teamID) {
   
    if($checkforfeit_award=='' OR $checkforfeit=='') {
	
       echo '<div class="tooltip" id="hover_dd_'.$rank.'">
               '.deductionamount($laddID,$teamID).' - '.getdeduction($teamID,$laddID).'</strong> deducted due to inactivity
	     </div>';
	}       
       $extras = '<a href="?site=standings&ladderID='.$laddID.'&view=credit_statement&participantID='.$teamID.'" name="hover_dd_'.$rank.'" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'hover_dd_'.$rank.'\')" onmouseout="hideWMTT()">'.$checkdeduction.'</a>';
}
else{
       $extras = '';
}
//check challenges

if($checkchallenge==true && participantID($userID,$laddID)==$teamID) {
   
       echo '<div class="tooltip" id="hover_cc_'.$rank.'">
               <strong>Waiting for challenge confirmation, click to view</strong>
	     </div>';
	       
       $extras2 = '<a href="?site=standings&action=viewchallenge&laddID='.$laddID.'&challID='.$challinfo['ID'].'" name="hover_cc_'.$rank.'" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'hover_cc_'.$rank.'\')" onmouseout="hideWMTT()">'.$checkchallenge.'</a>';
}
else{
       $extras2 = '';
}

//check match action

if($checkmatch==true && participantID($userID,$laddID)==$teamID) {
   
       echo '<div class="tooltip" id="hover_ma_'.$rank.'">
               <strong>Waiting for match confirmation, click to view</strong>
	     </div>';
	       
       $extras3 = '<a href="?site=matches&action=viewmatches&clanID='.$teamID.'&laddID='.$laddID.$ladd_type.'" name="hover_ma_'.$rank.'" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'hover_ma_'.$rank.'\')" onmouseout="hideWMTT()">'.$checkmatch.'</a>';
}
else{
       $extras3 = '';
}

//check streak

if($checkstreak==true) {
   
       echo '<div class="tooltip" id="hover_cs_'.$rank.'">
               <strong>Participant has won 5 matches in a row!</strong>
	     </div>';
	       
       $extras4 = '<a name="hover_cs_'.$rank.'" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'hover_cs_'.$rank.'\')" onmouseout="hideWMTT()">'.$checkstreak.'</a>';
}
else{
       $extras4 = '';
}

//check loss

if($checkloss==true) {

       echo '<div class="tooltip" id="hover_lo_'.$rank.'">
               <strong>Participant has lost 5 matches in a row</strong>
	     </div>';
	       
       $extras5 = '<a name="hover_lo_'.$rank.'" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'hover_lo_'.$rank.'\')" onmouseout="hideWMTT()">'.$checkloss.'</a>';
}
else{
       $extras5 = '';
}

//forfeit award

if($checkforfeit_award==true && participantID($userID,$laddID)==$teamID) {
   
    if(!$checkdeduction)
	
       echo '<div class="tooltip" id="hover_fa_'.$rank.'">
               <strong>You have been involved in a forfeit award</strong>
	     </div>';
	       
       $extras6 = '<a href="?site=standings&ladderID='.$laddID.'&view=credit_statement&participantID='.$teamID.'" name="hover_fa_'.$rank.'" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'hover_fa_'.$rank.'\')" onmouseout="hideWMTT()">'.$checkforfeit_award.'</a>';
}
else{
       $extras6 = '';
}

//forfeit loss

if($checkforfeit==true && participantID($userID,$laddID)==$teamID) {
 
    if(!$checkdeduction)
 
       echo '<div class="tooltip" id="hover_fl_'.$rank.'">
               <strong>You have been involved in a forfeit loss</strong>
	     </div>';
	       
       $extras7 = '<a href="?site=standings&ladderID='.$laddID.'&view=credit_statement&participantID='.$teamID.'" name="hover_fl_'.$rank.'" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'hover_fl_'.$rank.'\')" onmouseout="hideWMTT()">'.$checkforfeit.'</a>';
}
else{
       $extras7 = '';
}

//check multi deduction

if($extras AND ($extras6 OR $extras7)) {
      
   if($extras6) {
      $extras6_txt = '<br>You have been involved in a forfeit award';
   }
   else{
       $extras6_txt = '';
   }
   
   if($extras7) {
      $extras7_txt = '<br>You have been involved in a forfeit loss';
   }
   else{
       $extras7_txt = '';
   }
   
   unset($extras);
   unset($extras6);
   unset($extras7);
   
         echo '<div class="tooltip" id="hover_dd_'.$rank.'">
               '.deductionamount($laddID,$teamID).' - '.getdeduction($teamID,$laddID).'</strong> deducted due to inactivity
			   '.$extras6_txt.$extras7_txt.'
	     </div>';
	       
       $extras  = '<a href="?site=standings&ladderID='.$laddID.'&view=credit_statement&participantID='.$teamID.'" name="hover_dd_'.$rank.'" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'hover_dd_'.$rank.'\')" onmouseout="hideWMTT()">'.$checkdeduction.'</a>';
}

//check activitiy

if($checkinactivity==true) {
   
       echo '<div class="tooltip" id="hover_ca_'.$rank.'">
               <strong>'.$last_activity2.' inactivity</strong>
	     </div>';
	       
       $extras8 = '<a name="hover_ca_'.$rank.'" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'hover_ca_'.$rank.'\')" onmouseout="hideWMTT()">'.$checkinactivity.'</a>';
}
else{
       $extras8 = '';
}
}
//check match exist

if($ismatch==true) {
   
       echo '<div class="tooltip" id="hover_im_'.$rank.'">
               <strong>View matches</strong>
	     </div>';
	       
       $extras1 = '<a href="?site=matches&action=viewmatches&clanID='.$teamID.'&laddID='.$laddID.(ladderis1on1($laddID) ? '&type=1' : '').'" name="hover_im_'.$rank.'" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'hover_im_'.$rank.'\')" onmouseout="hideWMTT()">'.$ismatch.'</a>';
}
else{
       $extras1 = '';
}

if($lad['1st'] && $lad['status']==3) {

   if($teamID==$lad['1st']) {
      $extras9 = '<img src="images/cup/icons/award_gold.png">';
   }
   else{
      $extras9 = '';
   }
   
   if($teamID==$lad['2nd']) {
      $extras10 = ($lad['2nd'] ? '<img src="images/cup/icons/award_silver.png">' : '');
   }
   else{
      $extras10 = '';
   }
   
   if($teamID==$lad['3rd']) {
      $extras11 = ($lad['3rd'] ? '<img src="images/cup/icons/award_bronze.png">' : '');
   }
   else{
      $extras11 = '';
   }
}

        $hover_color = $selected_match;

        if(participantID_memin($userID,$laddID)==$ds['clanID']) {
             $bg_color_dd = $hover_color;
        }
        elseif(is_odd($rank)) {
             $bg_color_dd = BG_1;
        }	
	else{
             $bg_color_dd = BG_2;
	}
	
				$gameacc_sql = safe_query("SELECT * FROM ".PREFIX."user_gameacc WHERE type='".$lad['gameaccID']."' AND userID='".$ds['clanID']."'");
				$gameacc_typ = safe_query("SELECT type FROM ".PREFIX."gameacc WHERE gameaccID='".$lad['gameaccID']."'");
				
				
				if(mysqli_num_rows($gameacc_sql)){
					  $dl=mysqli_fetch_array($gameacc_sql);
					  $dp=mysqli_fetch_array($gameacc_typ);
					  $dis_gacc = '<img src="images/cup/icons/edit.png">&nbsp;<strong>'.$dp['type'].'</strong>&nbsp;'.$dl['value'];
					  
				}
				else{
					  $dis_gacc = '<img src="images/cup/icons/edit.png">&nbsp;<strong>Gameaccount</strong>&nbsp; <font color="'.$loosecolor.'">Not entered</a></font>';
				}	

$points_cnt = ladder_ranksys($laddID) == "elo" ? $ds['elo'] : $ds['tp'];		

if(!isset($extras6))
$extras6 = '';

if(!isset($extras7))
$extras7 = '';
				
//main table

 echo '<div class="tooltip" id="hover_dt_'.$rank.'">
	<center>	
	  <img src="'.$avatar.'" width="100" height="100"><br>
	</center>
	  <img src="images/cup/icons/create_ticket_16.png">&nbsp;<strong>Registered:</strong>&nbsp;'.returnTime2($ds['registered']).' <br />
	  <img src="images/cup/icons/contact_info.png">&nbsp;<strong> Last Activity:</strong>&nbsp;'.$last_activity2.' <br />
	  <img src="images/cup/icons/arrow_up_blue.png">&nbsp;<strong>Level:</strong>&nbsp;'.$level.' <br/ >
          <img src="images/cup/icons/points.png">&nbsp;<strong>XP:</strong>&nbsp;'.$xp.' <br>
	  <img src="images/cup/icons/ratio.png">&nbsp;<strong>Ratio:</strong>&nbsp;'.$ratio.' <br>
	  <img src="images/cup/icons/credits.png" width="16" height="16"> <strong>Credits:</strong>&nbsp;'.$ds['credit'].'<br>
	  <img src="images/cup/icons/add_result.gif" width="16" height="16">&nbsp;<strong>Matches:</strong>&nbsp;'.$ds['ma'].'<br>
	  <img src="images/cup/icons/groups.png">&nbsp;<strong>Last Rank Diff.</strong>&nbsp;'.$diff_rank.'<br>
      '.$dis_gacc.' 	  
        </div>';
		
echo '<tr bgcolor="'.$bg_color_dd.'" onMouseOver="this.style.backgroundColor=\''.$hover_color.'\'" onMouseOut="this.style.backgroundColor=\''.$bg_color_dd.'\'">
       <td style="height:27px; width:7%;">'.$position.$rank.'.</td>
       <td style="height:27px; width:30%;"><a href="'.getname3($teamID,$ds['ladID'],$ac=0,$var="ladder",1).'" name="hover_dt_'.$rank.'" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'hover_dt_'.$rank.'\')" onmouseout="hideWMTT()">'.(ladderis1on1($ds['ladID']) ? getusercountry3($teamID,$ac=0) : '<img src="images/flags/'.getclancountry($teamID,$img=0).'.gif">').'&nbsp;<strong>'.getname2($teamID,$ds['ladID'],$ac=0,$var="ladder",1).'</strong></a>'.$extras.$extras1.$extras2.$extras3.$extras4.$extras5.$extras6.$extras7.$extras8.'</td>
       <td style="height:27px;" align="center"><strong>'.$points_cnt.'</td></strong>
       <td style="height:27px;" align="center"><strong>'.$last_points.'</td></strong>
       <td style="height:27px;" align="center"><strong><font color="'.$wincolor.'">'.$won.'</font></strong></td>
       <td style="height:27px;" align="center"><strong><font color="'.$drawcolor.'">'.$draw.'</font></strong></td>
       <td style="height:27px;" align="center"><strong><font color="'.$loosecolor.'">'.$lost.'</font></strong></td>
       <td style="height:27px;" align="center"><strong><font color="'.$wincolor.'">'.getstreak($teamID,$laddID).'</font></strong></td>
       <td style="height:27px;" align="center">'.$rating.'</td>
       <td style="height:27px;" align="center">'.$fight.'</td>
      </tr>'; 

      $standings_rank++;
   }
   
   $chk_unranked = safe_query("SELECT credit FROM ".PREFIX."cup_clans WHERE ladID='$laddID' && credit < 1");
   if(mysqli_num_rows($chk_unranked)) {
      if( isset($_GET['display']) && $_GET['display']=='unranked') {
	     $view_unrked = '<a href="?site=standings&ladderID='.$laddID.'"><img src="images/cup/icons/bullet.gif"> View Ranked</a>';
	  } elseif($unranking==1) {
          $view_unrked = '<a href="?site=standings&ladderID='.$laddID.'&display=unranked"><img src="images/cup/icons/bullet.gif"> View Unranked</a>';	  
	  }
   } else {
      $view_unrked = '';
   }
   

   if($are_participants) {
      echo '<tr>
              <td style="height:27px; padding-left:175px" bgcolor="'.$pagebg.'" align="center" colspan="9">'.$button_prev.$button_next.'</td>
			  <td style="height:27px;" bgcolor="'.$pagebg.'" align="right">'.$view_unrked.'</td>
            </tr>
            </table></frameset>';  
   }   

//(end loop)
/* RECENT CHALLENGES */

if($view != 'credit_statement' && $view != 'credit_statement_extended') {
  
  $chall_limit = $show_challenges_s;
    
  if($are_challenges) 
  {
     $lad_chal_head_type = "Recent Challenges";
     $ladd_abbrev = ladabbrev($laddID);
	 
	 $show_prt_ext = ($participantID ? '&participantID='.$participantID : '');
     
	 if(!isset($recent_activity))
	 $recent_activity = '';
	 
	 eval ("\$inc_temp = \"".gettemplate("ladder_challenges")."\";");
	 echo $inc_temp;
  }
  
  $chall_no = 1;
  
  if($participantID) $part_chal = "AND (challenger = '".$participantID."' || challenged = '".$participantID."')";
  else $part_chal = ""; 
   
  $getchallenges = safe_query("SELECT * FROM ".PREFIX."cup_challenges WHERE ladID='$laddID' ".$part_chal." ORDER BY chalID DESC LIMIT 0,$chall_limit");
      while($gc=mysqli_fetch_array($getchallenges))
      {

      if(ladderis1on1($laddID)) 
      {

           $name1 = getnickname($gc['challenger']);
           $name2 = getnickname($gc['challenged']);
           $s = '';

    $challenger = '<a href="index.php?site=profile&id='.$gc['challenger'].'"><b>'.$name1.'</b></a>';
    $challenged = '<a href="index.php?site=profile&id='.$gc['challenged'].'"><b>'.$name2.'</b></a>';

}
else
{

    $name1 = getclanname($gc['challenger']);
    $name2 = getclanname($gc['challenged']);
    $s = '';
 
  $challenger = '<a href="index.php?site=clans&action=show&clanID='.$gc['challenger'].'"><b>'.$name1.'</b></a>';
  $challenged = '<a href="index.php?site=clans&action=show&clanID='.$gc['challenged'].'"><b>'.$name2.'</b></a>';

}
  
    if($gc['forfeit']==$gc['challenger']) 
    {
       $step = '(did not accept with '.$challenged.$s.' finalized selections)';
    }
    elseif($gc['forfeit']==$gc['challenged']) 
    {
       $step = '(did not accept '.$challenger.$s.' challenge request)';
    }

    if($gc['status']==4 && $gc['forfeit']==$gc['challenger'])
    { 
       $status2 = $challenged.' won by forfeit';
    }   
    elseif($gc['status']==4 && $gc['forfeit']==$gc['challenged'])
    {
       $status2 = $challenger.' won by forfeit';
    }   
    elseif($gc['status']==5 && $gc['forfeit']==$gc['challenger'])
    {
       $status2 = '<font color="#DD0000"><b>Forfeited</b></font> by '.$challenger.' '.$step;
    }   
    elseif($gc['status']==5 && $gc['forfeit']==$gc['challenged'])
    { 
       $status2 = '<font color="#DD0000"><b>Forfeited</b></font> by '.$challenged;
    }   
    elseif($gc['status']==1)
    { 
       $status2 = 'Waiting for '.$challenged.$s;
    }   
    elseif($gc['status']==2)
    { 
       $status2 = 'Waiting for '.$challenger.$s;
    }   
    elseif($gc['status']==3) 
    {
       $status2 = 'Challenge Complete';
       $status3 = '<a href="index.php?site=cup_matches&match='.$gc['chalID'].'&laddID='.$gc['ladID'].'"><img border="0" src="images/cup/icons/add_result.gif"></a>';
   }
   if(ladderis1on1($laddID)) 
   {
      $flag1 = getusercountry($gc['challenger']);
      $flag2 = getusercountry2($gc['challenged']);
   }
   else
   {
      $flag1 = flags('[flag]'.getclancountry($gc['challenger']).'[/flag]').'';
      $flag2 = flags('[flag]'.getclancountry($gc['challenged']).'[/flag]').'';
  
   }
   if($gc['finalized_date']) 
   {
       $sort_date = $gc['finalized_date'];
   }    
    elseif($gc['reply_date']) 
   { 
       $sort_date = $gc['reply_date'];
   }    
    else
   { 
       $sort_date = $gc['new_date'];
   }    
       
    $max_idle1 = safe_query("SELECT MAX(new_date) as maxnew, MAX(finalized_date) as maxfinalized FROM ".PREFIX."cup_challenges WHERE chalID='".$gc['chalID']."' AND ladID='$laddID' && challenger='".$gc['challenger']."' && (new_date='".$gc['new_date']."' || finalized_date='".$gc['finalized_date']."')");
    $idle1 = mysqli_fetch_array($max_idle1);
    
    $max_idle2 = safe_query("SELECT MAX(reply_date) as maxreply FROM ".PREFIX."cup_challenges WHERE chalID='".$gc['chalID']."' AND ladID='$laddID' && challenged='".$gc['challenged']."' && reply_date='".$gc['reply_date']."'");
    $idle2 = mysqli_fetch_array($max_idle2);
    
    if(!$idle1['maxnew'] && !$idle1['maxfinalized'])
    {
        $challenger_idle = '';
    }
    else
    {
        $challenger_idle = returnTime(max($idle1['maxnew'],$idle1['maxfinalized']));
    }
    
    if(!$idle2['maxreply'])
    {
        $challenged_idle = '';
    }
    else
    {
        $challenged_idle = returnTime($idle2['maxreply']);
    }
    
    if($challenger_idle && !$challenged_idle) 
    {
       $return_challenger = $challenger_idle;
       $return_challenged = "..";
   }
   elseif($challenged_idle && !$challenger_idle) 
   {
       $return_challenged = $challenged_idle;
       $return_challenger = "..";
   }
   elseif($challenged_idle && $challenger_idle) 
   {
       $return_challenged = $challenged_idle;
       $return_challenger = $challenger_idle;
   }
   
       $name_challenger = getname1($gc['challenger'],$laddID,$ac=0,$var="ladder",1);
       $name_challenged = getname1($gc['challenged'],$laddID,$ac=0,$var="ladder",1);
       $challenge_date = date('D jS M \@\ g:i a', $sort_date);

/* FLAGS FOR CHALLENGES */

  if(ladderis1on1($laddID))
  {
     $avatar_challenger = 'images/avatars/'.getavatar($gc['challenger']);
     $avatar_challenged = 'images/avatars/'.getavatar($gc['challenged']);
  }
  else
  {

     $cl1 = mysqli_fetch_array(safe_query("SELECT clanlogo FROM ".PREFIX."cup_all_clans WHERE ID='".$gc['challenger']."'"));
     $cl2 = mysqli_fetch_array(safe_query("SELECT clanlogo FROM ".PREFIX."cup_all_clans WHERE ID='".$gc['challenged']."'"));

     $url1 = $cl1['clanlogo'];  
     $url2 = $cl2['clanlogo']; 
   
     $avatar_challenger = (empty($cl1['clanlogo']) || !is_array($url1) ? 'images/avatars/noavatar.gif' : $cl1['clanlogo']);
     $avatar_challenged = (empty($cl2['clanlogo']) || !is_array($url2) ? 'images/avatars/noavatar.gif' : $cl2['clanlogo']);

  }
   
     if($are_challenges) 
     {  
     
       $avatar_tiny_challenger = '<img class="userbild" src="'.$avatar_challenger.'" width="30" alt="" title="" border="0" height="24">';
       $avatar_small_challenger = '<img class="userbild" src="'.$avatar_challenger.'" width="41" alt="" title="" border="0" height="41">';

       $avatar_tiny_challenged = '<img src="'.$avatar_challenged.'" width="30" alt="" title="" border="0" height="24">';
       $avatar_small_challenged = '<img src="'.$avatar_challenged.'" width="41" alt="" title="" border="0" height="41">';
       
       if($chall_no==1)
       {
          $class = 'class="moveDown"';
       }
       else
       {
          $class = '';
       }
       
       if(is_odd($chall_no))
       {
          $ranking_cell = 'ungerade';
          $bg_color = $bg1;
       }
       else
       {
          $ranking_cell = 'gerade';
          $bg_color = $bg2;
       }
       
       $challenge_link = '?site=standings&action=viewchallenge&laddID='.$laddID.'&challID='.$gc['chalID'];
       $challengelink = "onclick=\"location.href='index.php".$challenge_link."';\"";
       
       if($gc['finalized_date'])
       {         
          $date = date("d.m", $gc['finalized_date']);
          $time = date("H:i", $gc['finalized_date']);
       }
       elseif($gc['reply_date'])
       {
          $date = date("d.m", $gc['reply_date']);
          $time = date("H:i", $gc['reply_date']);
       }
       else
       {
          $date = date("d.m", $gc['new_date']);
          $time = date("H:i", $gc['new_date']);
       }
       
       $challinfo2 = checkchallenge2($gc['chalID']);          
       
       switch($challinfo2['step']) {      
           case 1: $status = '<img src="images/cup/icons/opened_protest.gif" align="center">';
           break;
           case 2: $status = '<img src="images/cup/icons/opened_protest.gif" align="center">';
           break;
           case 3: $status = '<img src="images/cup/icons/opened_protest.gif" align="center">';
           break;
           case 4: $status = '<img src="images/cup/icons/opened_protest.gif" align="center">';
           break;
           case 5: $status = '<img src="images/cup/icons/opened_protest.gif" align="center">';
           break;
           case 6: $status = '<img src="images/cup/icons/opened_protest.gif" align="center">';
           break;
           case 7: $status = '<img src="images/cup/icons/pending.gif" align="center">';
           break;
           case 8: $status = '<img src="images/cup/icons/pending.gif" align="center">';
           break;
           case 9: $status = '<img src="images/icons/online.gif" align="center">';
           break;     
       }
      
       $checkchallenge = ($challinfo['step']==7 || $challinfo['step']==8 ? '<blink><img src="images/cup/icons/warning.png" align="right"></blink>' : '');
	   
	   if(iscupadmin($userID)) $del_chall = '<a href="?site=standings&ladderID='.$laddID.'&action=delchall&challID='.$gc['chalID'].'" onclick="return confirm(\'Admin: This will permanently delete this challenge. Continue?\');"><img src="images/cup/error.png" width="16" height="16" border="0"></a>';
       else $del_chall = '';
    
	   eval ("\$inc_temp_chall = \"".gettemplate("ladder_challenges_content")."\";");
	   echo $inc_temp_chall;	   
     }          
    $chall_no++;                  
  }
  
  if($are_challenges) { 
     echo '</table></div>';
  }
}
/* MATCHES TABLE */

if($view != 'credit_statement' && $view != 'credit_statement_extended') {

    if($are_matches)
    {    
	
	     $partID = isset($_GET['participantID']) ? $_GET['participantID'] : false;
		 
	     $show_prt_ext = ($partID ? '&participantID='.$partID : '');
		 $show_prt_qry = ($partID ? "&& (clan1='$partID' OR clan2='$partID')" : "");
	
	     eval ("\$inc_temp = \"".gettemplate("ladder_matches")."\";");
	     echo $inc_temp;
	     
	     $match_no = 1;
                     
	         $getmatches = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE ladID='$laddID' $show_prt_qry && (clan1 != '0' AND clan2 != '0') && (clan1 !='2147483647' AND clan2 !='2147483647') && $one_query && confirmscore='1' ORDER BY date DESC LIMIT 0,$show_matches_s");
	             while($dm = mysqli_fetch_array($getmatches))
	              {  		      
                       
                       $participant1 = getname1($dm['clan1'],$laddID,$ac=0,$var="ladder",1);
                       $participant2 = getname1($dm['clan2'],$laddID,$ac=0,$var="ladder",1);
		       
                       if(ladderis1on1($laddID)) {
                          $flag1 = getusercountry($dm['clan1']);
                          $flag2 = getusercountry2($dm['clan2']);
                       }
                       else{
                          $flag1 = flags('[flag]'.getclancountry($dm['clan1']).'[/flag]');
                          $flag2 = flags('[flag]'.getclancountry($dm['clan2']).'[/flag]');
                       }

		       $add_zero_s1 = ($dm['score1'] < 10 ? "0" : "");
		       $add_zero_s2 = ($dm['score2'] < 10 ? "0" : "");
                       
                       if($dm['score1'] > $dm['score2']) 
                       {
                          $score1 = '<span style="color:'.$wincolor.';">'.$add_zero_s1.$dm['score1'].'</span>';
                          $score2 = '<span style="color:'.$loosecolor.';">'.$add_zero_s2.$dm['score2'].'</span>';                          
                       }
                       elseif($dm['score1'] < $dm['score2']) 
                       {
                          $score1 = '<span style="color:'.$loosecolor.';">'.$add_zero_s1.$dm['score1'].'</span>';
                          $score2 = '<span style="color:'.$wincolor.';">'.$add_zero_s2.$dm['score2'].'</span>';
                       }
                       else
                       {
                          $score1 = '<span style="color:#FF6600;">'.$add_zero_s1.$dm['score1'].'</span>';
                          $score2 = '<span style="color:#FF6600;">'.$add_zero_s2.$dm['score2'].'</span>';
                       }  
                       
                       $class = ($match_no==1 ? 'class="moveDown"' : '');
       
                       if(is_odd($match_no))
                       {
                          $ranking_cell = 'ungerade';
                          $bg_color = $bg1;
                       }
                       else
                       {
                          $ranking_cell = 'gerade';
                          $bg_color = $bg2;
                       }
                       
                       $match_link = matchlink($dm['matchID'],$ac=0,$tg=0,$redirect=1);
                       $matchlink = "onclick=\"location.href='index.php".$match_link."';\"";
                       
                       $ds=mysqli_fetch_array(safe_query("SELECT count(*) AS comments FROM ".PREFIX."comments WHERE parentID='".$dm['matchID']."' && type='cm'"));
                       $comments = $ds['comments'];
                       
                       //$date = date("d.m", $dm['date']);
                       //$time = date("H:i", $dm['date']);
		       
		       $match_d = '<a href="'.$match_link.'"><img src="images/icons/foldericons/folder.gif"></a>';
		       $date = date('D jS M \@\ g:i a', $dm['date']);

/* FLAGS */

  if(ladderis1on1($laddID))
  {
     $avatar_challenger = 'images/avatars/'.getavatar($dm['clan1']);
     $avatar_challenged = 'images/avatars/'.getavatar($dm['clan2']);
  }
  else
  {

     $cl1 = mysqli_fetch_array(safe_query("SELECT clanlogo FROM ".PREFIX."cup_all_clans WHERE ID='".$dm['clan1']."'"));
     $cl2 = mysqli_fetch_array(safe_query("SELECT clanlogo FROM ".PREFIX."cup_all_clans WHERE ID='".$dm['clan2']."'"));

     $url1 = $cl1['clanlogo'];  
     $url2 = $cl2['clanlogo']; 
   
     $avatar_challenger = (empty($cl1['clanlogo']) || !is_array($url1) ? 'images/avatars/noavatar.gif' : $cl1['clanlogo']);
     $avatar_challenged = (empty($cl2['clanlogo']) || !is_array($url2) ? 'images/avatars/noavatar.gif' : $cl2['clanlogo']);

  }

                       $avatar_tiny_challenger = '<img class="userbild" src="'.$avatar_challenger.'" width="30" alt="" title="" border="0" height="24">';
                       $avatar_small_challenger = '<img class="userbild" src="'.$avatar_challenger.'" width="41" alt="" title="" border="0" height="41">';

                       $avatar_tiny_challenged = '<img src="'.$avatar_challenged.'" width="30" alt="" title="" border="0" height="24">';
                       $avatar_small_challenged = '<img src="'.$avatar_challenged.'" width="41" alt="" title="" border="0" height="41">';
	             
/* END FLAGS */
                                                               
	                   eval ("\$inc_temp = \"".gettemplate("ladder_matches_content")."\";");
	                   echo $inc_temp;
	                   
	                $match_no++;
		                  
	              }	
	   if($are_matches) {  
        
	      eval ("\$inc_temp = \"".gettemplate("ladder_footer")."\";");
	      echo $inc_temp.'</div>';	 
           }	      
     }    
} 

/* VIEW CREDIT STATEMENT (5207)*/
    
  if(isset($_GET['view']) && $_GET['view']=='credit_statement_extended') {
    
  $partID = (isset($_GET['participantID']) ? $_GET['participantID'] : 0);
  
  //deductions credit statement
  
  $sh_qry_part = (isset($_GET['participantID']) ? "&& clanID='$partID'" : '');
  $cs_display = (isset($_GET['participantID']) ? "all" : "participant");
  
  if($_GET['display']=='all')
  redirect('?site=standings&ladderID='.$laddID.'&view=credit_statement#creditstatement', '', 0);
  
  $deductions = safe_query("SELECT * FROM ".PREFIX."cup_deduction WHERE ladID='$laddID' $sh_qry_part ORDER BY time DESC");
      while($ds=mysqli_fetch_array($deductions))
      {
	  
		  $participant = getname1($ds['clanID'],$ds['ladID'],0,'ladder',1);
		  $change = 'Inactivity (-'.$ds['deducted'].')';
		  $remain = $ds['credit'];	  
		  $before = $ds['credit'] + $ds['deducted'];
		  $date = date('D jS M - H:i', $ds['time']);
		  $flag = (ladderis1on1($laddID) ? getusercountry($ds['clanID']) : flags('[flag]'.getclancountry($ds['clanID']).'[/flag]'));
		  $before = $ds['credit'] + $ds['deducted'];
		  $adjust = $ds['credit'];
		  
		  $deductions_tbl .= '
			 <tr>
			   <td bgcolor="'.$bg1.'">'.$flag.' '.$participant.'</td>
			   <td bgcolor="'.$bg1.'" align="center">'.$change.'</td>
			   <td bgcolor="'.$bg1.'" align="center">'.$adjust.' / '.$before.'</td>
			   <td bgcolor="'.$bg1.'" align="center">'.$date.' <a href="?site=standings&ladderID='.$laddID.'&view=credit_statement_extended&participantID='.$ds['clanID'].'&display='.$cs_display.'"><img src="images/cup/icons/credits.png" border="0" align="right"></a></td>
			 </tr>';
		  
	  }
	  
	//matches credit statement  
	
	$sh_qry_part = (isset($_GET['participantID']) ? "&& clan1='$partID'" : '');

	$getmatches = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE ladID='$laddID' && (clan1 != '0' AND clan2 != '0') && (clan1 !='2147483647' AND clan2 !='2147483647') && $one_query && confirmscore='1' $sh_qry_part ORDER BY date DESC");
      while($ds = mysqli_fetch_array($getmatches))
      {
	  
	    if($ds['clan1']) {
	  
	      if($ds['score1'] == $ds['score2']) {
		     $plus_minus = "+";
			 $plus_minus_score = $drawcredit;
			 $participant = getname1($ds['clan1'],$ds['ladID'],0,'ladder',1);
			 $before = $ds['clan1_credit']-$drawcredit;
			 
		  }
		  elseif($ds['score1'] > $ds['score2']) {
		     $plus_minus = "+";
			 $plus_minus_score = $woncredit;
			 $participant = getname1($ds['clan1'],$ds['ladID'],0,'ladder',1);
			 $before = $ds['clan1_credit']-$woncredit;
		  }
		  elseif($ds['score1'] < $ds['score2']) {
		     $plus_minus = "-";
			 $plus_minus_score = $lostcredit;
			 $participant = getname1($ds['clan1'],$ds['ladID'],0,'ladder',1);
			 $before = $ds['clan1_credit']+$lostcredit;
		  }
        }
		  $flag = (ladderis1on1($laddID) ? getusercountry($ds['clan1']) : flags('[flag]'.getclancountry($ds['clan1']).'[/flag]'));
		  $change = '<a href='.matchlink($ds['matchID'],0,0,0).'>Match</a> ('.$plus_minus.$plus_minus_score.')';
		  $date = date('D jS M - H:i', $ds['confirmed_date']);
		  $adjust = $ds['clan1_credit'];
		  $adjustment = (empty($adjust) ? '*' : $adjust.' / '.$before);
	  
		  $matches_tbl1 .= '
			 <tr>
			   <td bgcolor="'.$bg1.'">'.$flag.' '.$participant.'</td>
			   <td bgcolor="'.$bg1.'" align="center">'.$change.'</td>
			   <td bgcolor="'.$bg1.'" align="center">'.$adjustment.'</td>
			   <td bgcolor="'.$bg1.'" align="center">'.$date.' <a href="?site=standings&ladderID='.$laddID.'&view=credit_statement_extended&participantID='.$ds['clan1'].'&display='.$cs_display.'"><img src="images/cup/icons/credits.png" border="0" align="right"></a></td>
			 </tr>';
	  }
    
	$sh_qry_part = (isset($_GET['participantID']) ? "&& clan2='$partID'" : '');
	
	$getmatches = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE ladID='$laddID' && (clan1 != '0' AND clan2 != '0') && (clan1 !='2147483647' AND clan2 !='2147483647') && $one_query && confirmscore='1' $sh_qry_part ORDER BY date DESC");
      while($ds = mysqli_fetch_array($getmatches))
      {
	  
	    if($ds['clan2']) {
		
	      if($ds['score1'] == $ds['score2']) {
		     $plus_minus = "+";
			 $plus_minus_score = $drawcredit;
			 $participant = getname1($ds['clan2'],$ds['ladID'],0,'ladder',1);
			 $before = $ds['clan2_credit']-$drawcredit;
		  }
		  elseif($ds['score1'] < $ds['score2']) {
		     $plus_minus = "+";
			 $plus_minus_score = $woncredit;
			 $participant = getname1($ds['clan2'],$ds['ladID'],0,'ladder',1);
			 $before = $ds['clan2_credit']-$woncredit;
		  }
		  elseif($ds['score1'] > $ds['score2']) {
		     $plus_minus = "-";
			 $plus_minus_score = $lostcredit;
			 $participant = getname1($ds['clan2'],$ds['ladID'],0,'ladder',1);
			 $before = $ds['clan2_credit']+$lostcredit;
		  }
		}
	  
	      $flag = (ladderis1on1($laddID) ? getusercountry($ds['clan2']) : flags('[flag]'.getclancountry($ds['clan2']).'[/flag]'));
		  $change = '<a href='.matchlink($ds['matchID'],0,0,0).'>Match</a> ('.$plus_minus.$plus_minus_score.')';
		  $date = date('D jS M - H:i', $ds['confirmed_date']);
		  $adjust = $ds['clan2_credit'];
		  $adjustment = (empty($adjust) ? '*' : $adjust.' / '.$before);
	  
		  $matches_tbl2 .= '
			 <tr>
			   <td bgcolor="'.$bg1.'">'.$flag.' '.$participant.'</td>
			   <td bgcolor="'.$bg1.'" align="center">'.$change.'</td>
			   <td bgcolor="'.$bg1.'" align="center">'.$adjustment.'</td>
			   <td bgcolor="'.$bg1.'" align="center">'.$date.' <a href="?site=standings&ladderID='.$laddID.'&view=credit_statement_extended&participantID='.$ds['clan2'].'&display='.$cs_display.'"><img src="images/cup/icons/credits.png" border="0" align="right"></a></td>
			 </tr>';
	  }
	  
	//challenges credit statement 
	
    $sh_qry_part = (isset($_GET['participantID']) ? "&& (challenger='$partID' OR challenged='$partID')" : '');		
	
    $getchallenges = safe_query("SELECT * FROM ".PREFIX."cup_challenges WHERE ladID='$laddID' ".$part_chal." ".$sh_qry_part." ORDER BY chalID DESC");
      while($ds=mysqli_fetch_array($getchallenges))
      {
	
	    if($partID && $partID!=$ds['challenged'])
	    continue;
	  
	      if($ds['forfeit']==$ds['challenger']) {
		
	         $participant = getname1($ds['challenged'],$ds['ladID'],0,'ladder',1);
		     $change = 'Forfeit Award (+'.$forfeitaward.')';
			 $ch_date = ($ds['reply_date'] ? $ds['reply_date'] : $ds['new_date']);
		     $date = date('D jS M - H:i', $ch_date);	  
			 $flag = (ladderis1on1($laddID) ? getusercountry($ds['challenged']) : flags('[flag]'.getclancountry($ds['challenged']).'[/flag]'));
			 $adjust = $ds['chd_credit'];
			 $before = $ds['chd_credit']-$forfeitaward;
			 $adjustment = (empty($adjust) ? '*' : $adjust.' / '.$before);
			 
		  $challenges_tbl1 .= '
			 <tr>
			   <td bgcolor="'.$bg1.'">'.$flag.' '.$participant.'</td>
			   <td bgcolor="'.$bg1.'" align="center">'.$change.'</td>
			   <td bgcolor="'.$bg1.'" align="center">'.$adjustment.'</td>
			   <td bgcolor="'.$bg1.'" align="center">'.$date.' <a href="?site=standings&ladderID='.$laddID.'&view=credit_statement_extended&participantID='.$ds['challenged'].'&display='.$cs_display.'"><img src="images/cup/icons/credits.png" border="0" align="right"></a></td>
			 </tr>';
		  
	      }
		  elseif($ds['forfeit']==$ds['challenged']) {
		
	         $participant = getname1($ds['challenged'],$ds['ladID'],0,'ladder',1);
		     $change = 'Forfeit Loss (-'.$forfeitloss.')';
			 $ch_date = ($ds['reply_date'] ? $ds['reply_date'] : $ds['new_date']);
		     $date = date('D jS M - H:i', $ch_date);	
			 $flag = (ladderis1on1($laddID) ? getusercountry($ds['challenged']) : flags('[flag]'.getclancountry($ds['challenged']).'[/flag]'));
			 $adjust = $ds['chd_credit'];
			 $before = $ds['chd_credit']+$forfeitloss;
			 $adjustment = (empty($adjust) ? '*' : $adjust.' / '.$before);
			 
		  $challenges_tbl1 .= '
			 <tr>
			   <td bgcolor="'.$bg1.'">'.$flag.' '.$participant.'</td>
			   <td bgcolor="'.$bg1.'" align="center">'.$change.'</td>
			   <td bgcolor="'.$bg1.'" align="center">'.$adjustment.'</td>
			   <td bgcolor="'.$bg1.'" align="center">'.$date.' <a href="?site=standings&ladderID='.$laddID.'&view=credit_statement_extended&participantID='.$ds['challenged'].'&display='.$cs_display.'"><img src="images/cup/icons/credits.png" border="0" align="right"></a></td>
			 </tr>';
	   	  }
		  else{
	         $participant = false;
		     $change = false;
		     $date = false;	
		  }
	  }
	  
    $getchallenges = safe_query("SELECT * FROM ".PREFIX."cup_challenges WHERE ladID='$laddID' ".$part_chal." ".$sh_qry_part." ORDER BY chalID DESC");
      while($ds=mysqli_fetch_array($getchallenges))
      {

	    if($partID && $partID!=$ds['challenger'])
	    continue;
	  	  
	      if($ds['forfeit']==$ds['challenger']) {
		
	         $participant = getname1($ds['challenger'],$ds['ladID'],0,'ladder',1);
		     $change = 'Forfeit Loss (-'.$forfeitloss.')';
			 $ch_date = ($ds['reply_date'] ? $ds['reply_date'] : $ds['new_date']);
		     $date = date('D jS M - H:i', $ch_date);	 
             $flag = (ladderis1on1($laddID) ? getusercountry($ds['challenger']) : flags('[flag]'.getclancountry($ds['challenger']).'[/flag]'));
			 $adjust = $ds['chr_credit'];
			 $before = $ds['chr_credit']+$forfeitloss;
			 $adjustment = (empty($adjust) ? '*' : $adjust.' / '.$before);
			 
		  $challenges_tbl2 .= '
			 <tr>
			   <td bgcolor="'.$bg1.'">'.$flag.' '.$participant.'</td>
			   <td bgcolor="'.$bg1.'" align="center">'.$change.'</td>
			   <td bgcolor="'.$bg1.'" align="center">'.$adjustment.'</td>
			   <td bgcolor="'.$bg1.'" align="center">'.$date.' <a href="?site=standings&ladderID='.$laddID.'&view=credit_statement_extended&participantID='.$ds['challenger'].'&display='.$cs_display.'"><img src="images/cup/icons/credits.png" border="0" align="right"></a></td>
			 </tr>';
		  
	      }
		  elseif($ds['forfeit']==$ds['challenged']) {
		
	         $participant = getname1($ds['challenger'],$ds['ladID'],0,'ladder',1);
		     $change = 'Forfeit Award (+'.$forfeitaward.')';
			 $ch_date = ($ds['reply_date'] ? $ds['reply_date'] : $ds['new_date']);
		     $date = date('D jS M - H:i', $ch_date);	
			 $flag = (ladderis1on1($laddID) ? getusercountry($ds['challenger']) : flags('[flag]'.getclancountry($ds['challenger']).'[/flag]'));
			 $adjust = $ds['chr_credit'];
			 $before = $ds['chr_credit']-$forfeitaward;
			 $adjustment = (empty($adjust) ? '*' : $adjust.' / '.$before);
			 
		  $challenges_tbl2 .= '
			 <tr>
			   <td bgcolor="'.$bg1.'">'.$flag.' '.$participant.'</td>
			   <td bgcolor="'.$bg1.'" align="center">'.$change.'</td>
			   <td bgcolor="'.$bg1.'" align="center">'.$adjustment.'</td>
			   <td bgcolor="'.$bg1.'" align="center">'.$date.' <a href="?site=standings&ladderID='.$laddID.'&view=credit_statement&participantID='.$ds['challenger'].'&display='.$cs_display.'"><img src="images/cup/icons/credits.png" border="0" align="right"></a></td>
			 </tr>';
	   	  }
		  else{
	         $participant = false;
		     $change = false;
		     $date = false;	
		  }
	  }
	 
	 $show_prt_ext = ($_GET['participantID'] ? '&participantID='.$_GET['participantID'] : '');

     echo '<br />
           <table width="100%" bgcolor="'.$border.'" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'">
             <tr>
               <td class="title" colspan="4"><img src="images/cup/icons/credits.png"> <a name="creditstatement"></a>Credibility Statement <a href="?site=standings&ladderID='.$laddID.$show_prt_ext.'"><img src="images/cup/icons/start.png" width="16" height="16" align="right"></a></td>
             </tr>
			 <tr>
			   <td class="title2">'.(ladderis1on1($laddID) ? 'Player' : 'Team').'</td>
			   <td class="title2" align="center">Occurence (+/-)</td>
			   <td class="title2" align="center">Adjust (c/p)</td>
			   <td class="title2" align="center">Date</td>
			 </tr>
			 '.$deductions_tbl.$matches_tbl1.$matches_tbl2.$challenges_tbl1.$challenges_tbl2.'
           </table>';
  }
// SHORT CREDIT STATEMENT
  elseif(isset($_GET['view']) && $_GET['view']=='credit_statement') {
  
      $laddID = mysqli_real_escape_string($_GET['ladderID']);
	  $sh_qry_part = (isset($_GET['participantID']) ? "&& clanID='".$_GET['participantID']."'" : '');
      $participants = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='$laddID' AND 1on1='".(ladderis1on1($laddID) ? 1 : 0)."' $sh_qry_part");
	  
	  if(mysqli_num_rows($participants)) {
	  
           echo '<br />
           <table width="100%" bgcolor="'.$border.'" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'">
             <tr>
               <td class="title" colspan="5"><img src="images/cup/icons/credits.png"> <a name="creditstatement"></a>Credibility Statement <a href="?site=standings&ladderID='.$laddID.'&view=credit_statement_extended"><img src="images/cup/icons/start.png" width="16" height="16" align="right"></a></td>
             </tr>
			  <tr>
			   <td class="title2">'.(ladderis1on1($laddID) ? 'Player' : 'Team').'</td>
			   <td class="title2" align="center">Matches</td>
			   <td class="title2" align="center">Inactivity</td>
			   <td class="title2" align="center">Forfeit</td>
			   <td class="title2" align="center">Cred. (AD)</td>
			 </tr>';  
	  

	      while($ds = mysqli_fetch_assoc($participants)) {
		  
		    $teamID = $ds['clanID'];
			$participant = getname1($teamID,$laddID,0,'ladder',1);
			$flag = (ladderis1on1($laddID) ? getusercountry($teamID) : flags('[flag]'.getclancountry($teamID).'[/flag]'));
			$if_unranked = ($ds['checkin']==1 ? '' : '(UR)');
			
			$ac_matches = getactualcredits($teamID,$laddID,"matches");
			$ac_deducti = getactualcredits($teamID,$laddID,"deduction");
			$ac_forfeit = getactualcredits($teamID,$laddID,"forfeit");
			
			$ac_matches_s1 = ($ac_matches==1 ? '' : 's');
			$ac_matches_s2 = ($ac_matches==-1 ? '' : 's');
			$ac_deducti_s = ($ac_deducti==1 ? '' : 's');
			$ac_forfeit_s1 = ($ac_forfeit==1 ? '' : 's');
			$ac_forfeit_s2 = ($ac_forfeit==-1 ? '' : 's');
			
			
			if($ds['credit'] != getactualcredits($teamID,$laddID)) {
			    $ad_plus = $ds['credit'] - getactualcredits($teamID,$laddID);
				$ad_minus = getactualcredits($teamID,$laddID) - $ds['credit'];
			    $admin_adjust = ($ds['credit'] > getactualcredits($teamID,$laddID)  ? '(+'.$ad_plus.')' : '(-'.$ad_minus.')');
				
				$ac_plus = (getactualcredits($teamID,$laddID)) + $ad_plus;
				$ac_minus = (getactualcredits($teamID,$laddID)) + $ad_minus; 
				$ac_cred = ($ds['credit'] > getactualcredits($teamID,$laddID)  ? $ac_plus : $ac_minus);

			}
			else { $ad_plus = false; $ad_minus = false; $admin_adjust = false; $ac_cred = getcredits($teamID,$laddID); }
			
			if($ac_matches==0 && $ac_deducti==0 && $ac_forfeit==0)
			break;
		  
            echo '
			 <tr>
			   <td bgcolor="'.$bg1.'">'.$flag.' '.$participant.' '.$if_unranked.'</td>
			   <td bgcolor="'.$bg1.'" align="center">'.($ac_matches >= 0 ? "+$ac_matches Credit$ac_matches_s1" : "$ac_matches Credit$ac_matches_s2").'</td>
			   <td bgcolor="'.$bg1.'" align="center">-'.$ac_deducti.' Credit'.$ac_deducti_s.'</td>
			   <td bgcolor="'.$bg1.'" align="center">'.($ac_forfeit >= 0 ? "+$ac_forfeit Credit$ac_forfeit_s1" : "$ac_forfeit Credit$ac_forfeit_s2").'</td>
			   <td bgcolor="'.$bg1.'" align="center">'.$ac_cred.' '.$admin_adjust.' <a href="?site=standings&ladderID='.$laddID.'&view=credit_statement_extended&participantID='.$teamID.'"><img src="images/cup/icons/deduct.png" border="0" align="right"></a></td>
			 </tr>';
		  
		  }
		    echo '</table>';
	   } else {
            echo '<div class="error_box">Could not find participants</div>';
	   }
  }

}
      echo ($cpr ? '<table width="100%"><tr><td>'.ca_copyr().'</td></tr></table>' : die());
  }
 else echo 'All ladders for <strong>'.getplatname($_GET['ladderID'],$type=1).'</strong> has been disabled.';

?>

</div>
</body>

</div>