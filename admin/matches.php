<?php if(isset($_GET['type'])=="protest") $tp = "&type=protest"; $redID = $_GET['cupID'];  if($redID && $_GET['match']) { ?>
<body onunload="opener.location=('admincenter.php?site=cups&action=baum&ID=<?php echo $redID.$tp; ?>')"><?php } ?>

<?php if(isset($_GET['matchID']) && isset($_GET['type'])=="protest" && isset($_GET['action'])=="saveedit") { ?>
<body onunload="opener.location=('admincenter.php?site=cuptickets')"><?php } ?>

<?php
$bg1 = BG_1;
$bg2 = BG_2;
$bg3 = BG_3;
$bg4 = BG_4;

$type2 = (isset($_GET['laddID']) ? "ladderis1on1" : "is1on1");
$t_name = $_GET['cupID'] ? 'cupID' : 'laddID';
$t_name1 = $_GET['laddID'] ? 'ladder' : 'cup';

if($_GET['action']=="saveedit") {
	include("../_mysql.php");
	include("../_settings.php");
	include("../_functions.php");
	include("../config.php");
	
	match_query_type();

	echo'<script src="../js/bbcode.js" language="jscript" type="text/javascript"></script><link href="_stylesheet.css" rel="stylesheet" type="text/css">';
	
	$matchID = $_GET['matchID'];
	$clan1 = $_POST['clan1'];
	$clan2 = $_POST['clan2'];
	$score1 = $_POST['score1'];
	$score2 = $_POST['score2'];
	$server = $_POST['server'];
	$hltv = $_POST['hltv'];
	$report = safe_sql_br($_POST['report']);
	$comments = $_POST['comments'];
	$month = $_POST['month'];
	$day = $_POST['day'];
	$year = $_POST['year'];
	$hour = $_POST['hour'];
	$min = $_POST['min'];
	$einspruch = (isset($_POST['einspruch']) ? $_POST['einspruch'] : 0);
	$gegenzeichnen = (isset($_POST['gegenzeichnen']) ? $_POST['gegenzeichnen'] : 0);
	
	if($_GET['laddID'] || $_GET['ladID'] || getleagueType($matchID)=="ladID") {
	   $type2 = "ladderis1on1";
	   $cupID = ($_GET['ladID'] ? $_GET['ladID'] : $_GET['laddID']);
	}else{
	   $type2 = "is1on1";
	   $cupID = $_GET['cupID'];
	}
	
	   $type = getleagueType($matchID);
	
	   $match = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchID='$matchID'");
	   $dd=mysql_fetch_array($match);
	   

//place winner

  if(getleagueType($matchID)=="cupID" && $gegenzeichnen == 1 && $einspruch == 0) {

		$matchinfo = getnextmatchnr($cupID, $dd['matchno']);		
		$looserswitch = looserautoswitch($dd['matchno'],$cupID,$p);

		if($matchinfo['winner']) {
			safe_query("UPDATE ".PREFIX."cup_baum SET wb_winner = '".($score1 > $score2 ? $clan1 : $clan2)."' WHERE $type = '".$cupID."'"); 
		}
		elseif($matchinfo['lb_winner']) { 
			safe_query("UPDATE ".PREFIX."cup_baum SET lb_winner = '".($score1 > $score2 ? $clan1 : $clan2)."', third_winner='".($score1 < $score2 ? $clan1 : $clan2)."' WHERE $type = '".$cupID."'"); 
                }
	        elseif($matchinfo['third_winner']) {
	               safe_query("UPDATE ".PREFIX."cup_baum SET third_winner = '".($score1 > $score2 ? $clan1 : $clan2)."' WHERE $type = '".$cupID."'"); 
		}
			
		if($matchinfo['matchno'] && !mysql_num_rows(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE $type='".$cupID."' && matchno='".$matchinfo['matchno']."'")))
			safe_query("INSERT INTO ".PREFIX."cup_matches (cupID, ladID, matchno, date, ".$matchinfo['place'].", comment) VALUES ('".$cupID."', '0', '".$matchinfo['matchno']."', '".time()."', '".($score1 > $score2 ? $clan1 : $clan2)."', '2')");
		elseif($matchinfo['matchno']) 
			safe_query("UPDATE ".PREFIX."cup_matches SET ".$matchinfo['place']." = '".($score1 > $score2 ? $clan1 : $clan2)."' WHERE $type = '".$cupID."' && matchno = '".$matchinfo['matchno']."'");

//tournament auto-close
	    
		if($auto_close_cup && $matchinfo['winner'])
			safe_query("UPDATE ".PREFIX."cups SET ende = '".time()."' WHERE ID='$cupID'");

//place looser

		if($looserswitch && !mysql_num_rows(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE $type='".$cupID."' && matchno='$looserswitch'"))) 
			safe_query("INSERT INTO ".PREFIX."cup_matches (cupID, ladID, matchno, date, ".$matchinfo['place'].", comment) VALUES ('".$cupID."', '0', '$looserswitch', '".time()."', '".($score1 < $score2 ? $clan1 : $clan2)."', '2')");
		elseif($looserswitch) 
			safe_query("UPDATE ".PREFIX."cup_matches SET ".$matchinfo['place']." = '".($score1 < $score2 ? $clan1 : $clan2)."' WHERE $type = '".$cupID."' && matchno = '$looserswitch'");
   
//roll-back match if protest   
   
   }elseif($einspruch) {
   
		$matchinfo = getnextmatchnr($cupID, $dd['matchno']);
		$looserswitch = looserautoswitch($dd['matchno'],$cupID,$p);	
		
		$nw=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE cupID='$cupID' && matchno='".$matchinfo['matchno']."'"));
		$nl=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE cupID='$cupID' && matchno='".$looserswitch."'"));
		
    //if 1st, 2nd or 3rd

		if($matchinfo['winner']) 
			safe_query("UPDATE ".PREFIX."cup_baum SET wb_winner = '0' WHERE $type = '".$cupID."'"); 
		elseif($matchinfo['lb_winner']) 
			safe_query("UPDATE ".PREFIX."cup_baum SET lb_winner = '0', third_winner='0' WHERE $type = '".$cupID."'"); 
        elseif($matchinfo['third_winner']) 
	        safe_query("UPDATE ".PREFIX."cup_baum SET third_winner = '0' WHERE $type = '".$cupID."'"); 			
		
	//if winner	
		
		if($matchinfo['matchno'] && $nw['clan1'] && $nw['clan2']) 
		   safe_query("UPDATE ".PREFIX."cup_matches SET ".$matchinfo['place']." = '0' WHERE cupID='$cupID' && matchno='".$matchinfo['matchno']."'");
		elseif($matchinfo['matchno']) 
           safe_query("DELETE FROM ".PREFIX."cup_matches WHERE cupID='$cupID' && matchno='".$matchinfo['matchno']."'");
           
    //if looser
           
        if($looserswitch && $nl['clan1'] && $nl['clan2']) 
		   safe_query("UPDATE ".PREFIX."cup_matches SET ".$matchinfo['place']." = '0' WHERE cupID='$cupID' && matchno='".$looserswitch."'");
		elseif($looserswitch) 
           safe_query("DELETE FROM ".PREFIX."cup_matches WHERE cupID='$cupID' && matchno='".$looserswitch."'");
   
   }
   	     	      
//Version 5

$ti=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_tickets WHERE matchID='$matchID'"));

 if($einspruch) $match_t_status = $match_protest_status;
 elseif($gegenzeichnen) $match_t_status = $match_confirmed_status;
    
 if($_GET['type']=="protest") {
    safe_query("UPDATE ".PREFIX."cup_tickets SET adminID = '$userID', updated = '".time()."', status = '$match_t_status' WHERE ticketID='".$ti['ticketID']."'");  	
 }
 
 if($ti['ladID']) {  
    $laddID = $ti['ladID'];
    $partID = participantID($ti['userID'],$laddID);
    
    $query = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE ladID='$laddID' && (clan1='$partID' || clan2='$partID')");
        while($si=mysql_fetch_array($query)) { 
        
            if(!$si['si'] && $gegenzeichnen && ismatchparticipant($ti['userID'],$si['matchID'],$all=1)) 
            redirect('../popup.php?site=cupactions&action=updatestandings&matchID='.$si['matchID'].'&clanID='.$partID.'&'.$t_name.'='.$laddID.'&type=protest', '<center><img src="../images/cup/icons/loading_animation.gif"></center>', 0);
        
        }  
  }
  
//end
		
	if($gegenzeichnen){
		$gegenzeichnen = 1;
		$einspruch = 0;
		$cd = ", confirmed_date='".time()."'";
	}elseif($einspruch){
		$gegenzeichnen=0;
		$einspruch=1;
		$reinstate="si='0',";
	}elseif(!$gegenzeichnen && !$einspruch){
		$gegenzeichnen=0;
		$einspruch=0;
	} 

	$date = @mktime($hour, $min, 0, $month, $day, $year);	  
	safe_query("UPDATE ".PREFIX."cup_matches SET $reinstate date='$date', clan1='$clan1', clan2='$clan2', score1='$score1', score2='$score2', server='$server', hltv='$hltv', report='".$report."', comment='$comments', einspruch='$einspruch', confirmscore='$gegenzeichnen', inscribed = '1' $cd WHERE ".getleagueType($matchID)."='".getleagueID($matchID)."' AND matchID='$matchID'");
	 
//ladder system V5

                if(getleagueType($matchID)=="ladID") {
                    
                        $db=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchID='$matchID'"));
		        $rk1=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='".$db['ladID']."' && clanID='".$db['clan1']."'"));
		        $rk2=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='".$db['ladID']."' && clanID='".$db['clan2']."'"));
                        $rs=mysql_fetch_array(safe_query("SELECT d_xp FROM ".PREFIX."cup_ladders WHERE ID='".$db['ladID']."'"));
                        
                        if(!$ti['userID'])
                        {
                            $clanID = $db[clan1];
                        }
                        else
                        {
                            $clanID = isset($_GET['clanID']) ? participantID($ti['userID'],$laddID) : $ti['userID'];
                        }

                        
                    if(!$db['si']) {
 
                        $team1_lost = $rk1['credit']-$lostcredit;
                        $team2_lost = $rk2['credit']-$lostcredit;
                        $team1_won = $rk1['credit']+$woncredit;
                        $team2_won = $rk2['credit']+$woncredit;
                        $team1_draw = $rk1['credit']+$drawcredit;
                        $team2_draw = $rk2['credit']+$drawcredit;
                        
                        $rank1 = $rk1['rank_now'];
                        $rank2 = $rk2['rank_now']; 
                        
                        $t1_totalp = $rk1['credit']+$rk1['xp'];
                        $t2_totalp = $rk2['credit']+$rk2['xp'];                        
                        $t1_wmc = $rk1['xp']+$rk1['won'];     
                        $t2_wmc = $rk2['xp']+$rk2['won'];                                             
                        $t1_addxp = $db['score1']+$rk1['xp'];
                        $t2_addxp = $db['score2']+$rk2['xp'];
                                              
                        $t1_addwon = $rk1['won']+1;
                        $t2_addwon = $rk2['won']+1;
                        $t1_addlost = $rk1['lost']+1;
                        $t2_addlost = $rk2['lost']+1;
                        $t1_addtie = $rk1['draw']+1;
                        $t2_addtie = $rk2['draw']+1;
                        $t1_addmatch = $rk1['ma']+1;
                        $t2_addmatch = $rk2['ma']+1;
                        
                        if($clanID==$db['clan1'])
                           $la1 = ", lastact = '".time()."'";
                           
                        if($clanID==$db['clan2'])
                           $la2 = ", lastact = '".time()."'";
                           
                        $c2_xp = (!$rs['d_xp'] ? "xp = '$t2_addxp'," : "");
                        $c1_xp = (!$rs['d_xp'] ? "xp = '$t1_addxp'," : "");

					    $current_elo_c1 = $rk1['elo'];
					    $current_elo_c2 = $rk2['elo'];
							
					    $elo = rating($db['score1'], $db['score2'], $current_elo_c1, $current_elo_c2, $db['ladID'], $db['clan1']);
					    $elo_clan1 = $current_elo_c1 + $elo['P1'];		
                        $elo_clan2 = $current_elo_c2 + $elo['P2'];	
						
                        if($db['score1']>$db['score2']) {      
                           safe_query("UPDATE ".PREFIX."cup_clans SET ma = '$t1_addmatch', credit = '$team1_won', elo = '$elo_clan1', xp = '$t1_addxp', won = '$t1_addwon', lastpos = '1', rank_then='$rank1' $la1 WHERE clanID = '".$db['clan1']."' && ladID = '".$db['ladID']."'");                                                  
                           safe_query("UPDATE ".PREFIX."cup_clans SET ma = '$t2_addmatch', credit = '$team2_lost', elo = '$elo_clan2', $c2_xp lost = '$t2_addlost', lastpos = '2', rank_then='$rank2' $la2 WHERE clanID = '".$db['clan2']."' && ladID = '".$db['ladID']."'");
                                                                                                                              
                          redirect('../popup.php?site=cupactions&action=updatestandings&matchID='.$db['matchID'].'&clanID='.$clanID.'&'.$t_name.'='.$db['ladID'].'&type=protest', '<center><img src="../images/cup/icons/loading_animation.gif"></center>', 0);
                                                                
                        }elseif($db['score1']<$db['score2']) {  
                           safe_query("UPDATE ".PREFIX."cup_clans SET ma = '$t1_addmatch', credit = '$team1_lost', elo = '$elo_clan1', $c1_xp lost = '$t1_addlost', lastpos = '2', rank_then='$rank1' $la1 WHERE clanID = '".$db['clan1']."' && ladID = '".$db['ladID']."'");                                        
                           safe_query("UPDATE ".PREFIX."cup_clans SET ma = '$t2_addmatch', credit = '$team2_won', elo = '$elo_clan2', xp = '$t2_addxp', won = '$t2_addwon', lastpos = '1', rank_then='$rank2' $la2  WHERE clanID = '".$db['clan2']."' && ladID = '".$db['ladID']."'");
                                                              
                          redirect('../popup.php?site=cupactions&action=updatestandings&matchID='.$db['matchID'].'&clanID='.$clanID.'&'.$t_name.'='.$db['ladID'].'&type=protest', '<center><img src="../images/cup/icons/loading_animation.gif"></center>', 0);
                                                                
                        }else{  
                           safe_query("UPDATE ".PREFIX."cup_clans SET ma = '$t1_addmatch', credit = '$team1_draw', elo = '$elo_clan1', xp = '$t1_addxp', draw = '$t1_addtie', lastpos = '3', rank_then='$rank1' $la1 WHERE clanID = '".$db['clan1']."' && ladID = '".$db['ladID']."'");                                   
                           safe_query("UPDATE ".PREFIX."cup_clans SET ma = '$t2_addmatch', credit = '$team2_draw', elo = '$elo_clan2', xp = '$t2_addxp', draw = '$t2_addtie', lastpos = '3', rank_then='$rank2' $la2 WHERE clanID = '".$db['clan2']."' && ladID = '".$db['ladID']."'");                                                                   
                                                                
                           redirect('../popup.php?site=cupactions&action=updatestandings&matchID='.$db['matchID'].'&clanID='.$clanID.'&'.$t_name.'='.$db['ladID'].'&type=protest', '<center><img src="../images/cup/icons/loading_animation.gif"></center>', 0);
                        } 
                         safe_query("UPDATE ".PREFIX."cup_matches SET clan1_credit='".getcredits($db['clan1'],$db['ladID'])."' WHERE matchID = '".$db['matchID']."'");
						 safe_query("UPDATE ".PREFIX."cup_matches SET clan2_credit='".getcredits($db['clan2'],$db['ladID'])."' WHERE matchID = '".$db['matchID']."'"); 						
                    }
                }

//end	 
	 
	if(isset($_GET['extern']))
		redirect('admincenter.php?site=cups&action=baum&ID='.$cupID, 'Match successfully edited!', 2);	
	else{
	
	 $ticket = safe_query("SELECT * FROM ".PREFIX."cup_tickets WHERE matchID='$matchID'");
	  $tt = mysql_fetch_array($ticket);
	   if(mysql_num_rows($ticket)) { $the_ticket = '<input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=cuptickets&action=view_ticket&tickID='.$tt['ticketID'].'\');return document.MM_returnValue" value="View Ticket">'; }
	
		echo'<center><br><br><br><br>
				<b>Match successfully edited.</b><br><br>
				<input type="button" class="button" onClick="MM_goToURL(\'parent\',\'../upload.php?matchID='.$matchID.'\');return document.MM_returnValue" value="Screenshots">
				<input type="button" class="button" onClick="javascript:self.close()" value="Close Window"> 
				'.$the_ticket.'</center>';
	}
}elseif($_GET['action']=="del") { 
	include("../_mysql.php");
	include("../_settings.php");
	include("../_functions.php");
	include("../config.php");

safe_query("DELETE FROM ".PREFIX."cup_matches WHERE matchID='".$_GET['matchID']."'");	
redirect('admincenter.php?site=matches&'.($_GET['laddID'] ? 'laddID' : 'cupID').'='.($_GET['laddID'] ? $_GET['laddID'] : $_GET['cupID']), '<font color="red"><strong>Match deleted sucessfully!</strong></font>', 2);
                          
	
}elseif($_GET['action']=="edit") { 
	include("../_mysql.php");
	include("../_settings.php");
	include("../_functions.php");
	include("../config.php");

//date and timezone

$timezone = safe_query("SELECT timezone FROM ".PREFIX."cup_settings");
$tz = mysql_fetch_array($timezone); $gmt = $tz['timezone'];
date_default_timezone_set($tz['timezone']);

	$cupID=($_GET['laddID'] ? $_GET['laddID'] : $_GET['cupID']);
	$matchno=$_GET['match'];
	$matchID=$_GET['matchID'];
	$type = getleagueType($matchID);
	
	if($_GET['laddID'] || getleagueType($matchID)=="ladID") {
	   $type = "laddID";
	   $type3 = "ladID";
	}else{
	   $type = "cupID";
	   $type3 = "cupID";
	}
	
	if($_GET['match'])
	   $match = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE $type3='$cupID' and matchno='$matchno'");
	else
	   $match = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchID='$matchID'");	  
	   
    $dd=mysql_fetch_array($match); 
    
	$clan1 = $dd['clan1'];
	$clan2 = $dd['clan2'];

	if($dd['inscribed'] && $dd['confirmscore'])
		$match_status='<font color="#00CC00"><b>Confirmed and Finalized</b></font>';
	elseif($dd['inscribed'] && (!$dd['confirmscore'] && !$dd['einspruch']))
		$match_status='<font color="#FF6600"><b>Waiting for confirmation</b></font><img src="../images/period_ani.gif">';
	elseif($dd['inscribed'] && $dd['einspruch'])
		$match_status='<font color="red"><b>PROTEST</b></font>';
	else
		$match_status='Not yet entered';

	if($dd['einspruch'] == '1') $einspruch = 'checked'; else $einspruch = '';
	if($dd['confirmscore'] == '1' || ($dd['inscribed'] && $dd['confirmscore'])) $gegen = 'checked'; else $gegen = '';

	$submit='<input name="post" id="post" type="submit" value="Save" style="color:#000000">';
	
	
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
			<head>
				<script src="../js/bbcode.js" language="jscript" type="text/javascript"></script>
				<link href="_stylesheet.css" rel="stylesheet" type="text/css">
			</head>
			<body>	
				<style>
					.disabled {color: #888888}
					.nodisabled {color: #000000}
				</style>
				<form action="matches.php?action=saveedit&matchID='.$dd['matchID'].'&'.getleagueType($dd['matchID']).'='.getleagueID($dd['matchID']).''.(isset($_GET['extern']) ? '&extern=1' : ''.($_GET['type']=="protest" ? '&type=protest' : '').'').'" method="post" name="post">
					<table width="100%" border="0" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'" bgcolor="'.$border.'">
						<tr> 
							<td align="center" class="title">Edit Cupmatch</td>
						</tr>
						<tr> 
							<td bgcolor="#eeeeee">
								<table width="100%" border="0" align="center" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'">
									<tr>
							            <td><h2>Status:</h2></td>
							            <td><h2>'.$match_status.'</h2></td>
							            <td>&nbsp;</td>
							            <td>&nbsp;</td>
									</tr>
									<tr>
										<td>Date</td>
										<td colspan="3"><input name="day" type="text" size="2" value="'.date('d', $dd['date']).'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">.
		                                <input name="month" type="text" size="2" value="'.date('m', $dd['date']).'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">. 
                                        <input name="year" type="text" size="4" value="'.date('Y', $dd['date']).'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> at 
		                                <input name="hour" type="text" size="2" value="'.date('H', $dd['date']).'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center">:
                                        <input name="min" type="text" size="2" value="'.date('i', $dd['date']).'" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" style="text-align:center"> <input name="clan1" type="hidden" id="clan1" value="'.$clan1.'"><input name="clan2" type="hidden" id="clan2" value="'.$clan2.'"></td>
									</tr>
									<tr> 
							            <td>&nbsp;</td>
							            <td>Team1: ('.getname1($dd['clan1'],getleagueID($dd['matchID']),$ac=1,league($dd['matchID'])).')</td>
							            <td>&nbsp;</td>
							            <td>Team2: ('.getname1($dd['clan2'],getleagueID($dd['matchID']),$ac=1,league($dd['matchID'])).')</td>
									</tr>		
									<tr> 
							            <td>Score:</td>
							            <td><input name="score1" type="text" class="form_off" id="score1" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" size="3" value="'.$dd['score1'].'"></td>
							            <td>Score:</td>
							            <td><input name="score2" type="text" class="form_off" id="score2" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" size="3" value="'.$dd['score2'].'"></td>
									</tr>
									<tr>
								        <td>Protest: *</td>
								        <td><label><input name="einspruch" type="checkbox" id="einspruch" value="1" '.$einspruch.' onclick="document.post.post.disabled = false; document.post.post.style.color = \'#FF0000\'; document.post.post.value = \'Protest Match\'; if( document.post.einspruch.checked ) { document.post.gegenzeichnen.checked = false; } else { document.post.gegenzeichnen.checked = true; }"></label></td>
							            <td>&nbsp;</td>
							            <td>&nbsp;</td>
									</tr>
									<tr>
							            <td>Confirm: *</td>
							            <td><label><input name="gegenzeichnen" type="checkbox" id="gegenzeichnen" value="1" '.$gegen.' onclick="document.post.post.disabled = false; document.post.post.style.color = \'#00CC00\'; document.post.post.value = \'Confirm Match\'; if( document.post.gegenzeichnen.checked ) { document.post.einspruch.checked = false; } else { document.post.einspruch.checked = true; }"></label></td>
							            <td>&nbsp;</td>
							            <td>&nbsp;</td>
									</tr>
									<tr> 
										<td colspan="4"><hr></td>
									</tr>
									<tr> 
							            <td>Server:</td>
							            <td><input name="server" type="text" size="35" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" value="'.$dd['server'].'"></td>
							            <td>HLTV-Server:</td>
							            <td><input name="hltv" type="text" size="35" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'" value="'.$dd['hltv'].'"></td>
									</tr>
									<tr> 
										<td colspan="4"><hr></td>
									</tr>
									<tr> 
							            <td valign="top">Report:</td>
							            <td colspan="3" valign="top"><textarea name="report" cols="100" rows="11" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'">'.$dd['report'].'</textarea></td>
									</tr>
									<tr> 
										<td colspan="4"><hr ></td>
							        </tr>
									<tr>
										<td colspan="4" align="right"><select name="comments"><option value="0">disable comments</option><option value="1">enable user comments</option><option value="2" selected>enable visitor comments</option></select>'.$submit.'</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</form>
			</body>
		</html>';
}

//ladder matches

include("../config.php");

   if(isset($_GET['laddID']) || isset($_GET['cupID']) && $_GET['action']!='saveedit') { 
   
    $laddID = ($_GET['laddID'] ? $_GET['laddID'] : $_GET['cupID']);
    $laddname = $_GET['cupID'] ? getcupname($laddID) : getladname($laddID);
    $type=($type2($laddID) ? "1on1='1'" : "1on1='0'");
    $type_opp = ($_GET['laddID'] ? 'cupID' : 'ladID');	
  
//title ladder

$ID = $laddID;
$participants = (ladderis1on1($ID) ? 'Players' : 'Teams');	

if($_GET['laddID'])

echo '

<table width="100%" cellpadding="2" cellspacing="1" bgcolor="'.$border.'">
	<tr>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=ladders&action=edit&ID='.$ID.'">Edit Ladder</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=teams&laddID='.$ID.'">'.$participants.'</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=ladders&action=standings&ID='.$ID.'">Standings</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=ladders&action=rules&ID='.$ID.'">Rules</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=ladders&action=admins&ID='.$ID.'">Admins</a></td>
        <td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;Matches</td>		
	</tr>
</table><br><br>';

elseif($_GET['cupID']) 

echo '<h2>'.getcupname($_GET['cupID']).'</h2>
<table width="100%" cellpadding="2" cellspacing="1" bgcolor="'.$border.'">
	<tr>
		<td class="title" bgcolor="'.$bghead.'" width="12%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=cups&action=edit&ID='.$ID.'">Edit Cup</td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=teams&cupID='.$ID.'">'.$participants.'</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="14%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=cups&action=baum&ID='.$ID.'">Brackets</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="12%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=cups&action=rules&ID='.$ID.'">Rules</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="14%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=cups&action=admins&ID='.$ID.'">Admins</a></td>
        <td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;Matches</a></td>		
	</tr>
</table><br><br>';
  
    $ds=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_ladders WHERE ID='".$laddID."'"));
    $all_ladders = '    
     <a href="../?site=ladders&platID='.$ds['platID'].'"><img border="0" width="16" height=16" src="../images/cup/icons/goback.png"> <b>Ladders</b></a> |
     <a href="../?site=standings&ladderID='.$laddID.'"><b>Standings</b> <img border="0" width="16" height=16" src="../images/cup/icons/goforward.png"></a></td>'; 
      
      if(isset($_GET['type']) && $_GET['type']=="gs") {
         $league = "matchno";
	     $ext_typ = "&& type='gs'";
		 $textl = "group";
      }
	  elseif(isset($_GET['laddID'])) {
         $league = "ladID";
		 $textl = "ladder";
      }
	  elseif(isset($_GET['cupID'])) {
         $league = "cupID";
		 $textl = "tournament";
      }
	  
	  $extlea = ($_GET['laddID'] ? 'laddID' : 'cupID');
	  
	  if(($ds['gs_start'] || $ds['gs_end']) && $_GET['type']!='gs') { 
	     $show_ext_match = '<br />Click <a href="admincenter.php?site=matches&'.$extlea.'='.$_GET[$extlea].'&type=gs">here</a> to view group matches.';
	  }
	  elseif($_GET['type']=='gs') {
	     $show_ext_match = '<br />Click <a href="admincenter.php?site=matches&'.$extlea.'='.$_GET[$extlea].'">here</a> to view '.($_GET['laddID'] ? 'ladder' : 'tournament').' matches.';
	  }
	  
      $getmatches = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE $league='$laddID' && $type $ext_typ && $type_opp='0'");
      if(!mysql_num_rows($getmatches)) echo '<div '.$error_box.'> No '.$textl.' matches in the <strong>'.$laddname.'</strong>. '.$show_ext_match.'</div>';
      
    else{
    
    $team1 = ($type2($laddID) ? "Player 1" : "Team 1");
    $team2 = ($type2($laddID) ? "Player 2" : "Team 2");
    $act = 'class="title"';
	
	if($_GET['type']=='gs') {
	       echo '<div '.$error_box.'> Viewing group matches<br> Click <a href="?site=matches&'.$t_name.'='.$laddID.'">here</a> to view '.($_GET['cupID'] ? 'tournament' : 'ladder').' matches.</div>';
    }
	else{
	       echo '<div '.$error_box.'> Viewing '.($_GET['cupID'] ? 'tournament' : 'ladder').' matches<br> Click <a href="?site=matches&'.$t_name.'='.$laddID.'&type=gs">here</a> to view group matches.</div>';
	}
	
	eval ("\$one_head = \"".gettemplate("cup_matches_head")."\";");
	echo $one_head;
    
      while($dm=mysql_fetch_array($getmatches)) {
      
	$details_link= matchlink($dm['matchID'],1,0,1); 
	        
	        $details='<a href="../popup.php'.$details_link.'"  onClick="MM_openBrWindow(this.href,\'View Match\',\'toolbar=no,status=no,scrollbars=yes,width=800,height=600\');return false"><img border="0" src="../images/icons/foldericons/folder.gif"></a>
	                  <a href="matches.php?action=edit&matchID='.$dm['matchID'].'&'.$t_name.'='.$laddID.'" onClick="MM_openBrWindow(this.href,\'Edit Match\',\'toolbar=no,status=no,scrollbars=yes,width=800,height=600\');return false"><img src="../images/cup/icons/server_edit.gif"></a>
					  <a href="matches.php?action=del&matchID='.$dm['matchID'].'&'.$t_name.'='.$laddID.'" onclick="return confirm(\'Remove match permanently?\');"><img src="../images/cup/error.png" width="16" height="16"></a>';
     
    if($t_name == 'laddID') {
           $ed=mysql_fetch_array(safe_query("SELECT game FROM ".PREFIX."cup_ladders WHERE ID='$laddID'"));
    }
	else{
           $ed=mysql_fetch_array(safe_query("SELECT game FROM ".PREFIX."cups WHERE ID='$laddID'"));
	}
    $game='<img src="../images/games/'.$ed['game'].'.gif" width="20" height="20" border="0">';
    $date = date('D, dS M Y', $dm['date']);
    $match = '<img src="../images/cup/icons/go.png" align="left"> <a href="matches.php?action=edit&matchID='.$dm['matchID'].'&'.$t_name.'='.$laddID.'" onClick="MM_openBrWindow(this.href,\'Edit Match\',\'toolbar=no,status=no,scrollbars=yes,width=800,height=600\');return false"><b>'.$dm['matchID'].'</b></a> ('.$dm['matchno'].')';
    $vs = '<a href="../'.$details_link.'" target="_blank"><b>vs.</b></a>';
	
    $clanname = getname1($dm['clan1'],getleagueID($dm['matchID']),$ac=1,league($dm['matchID']));
    $opponent = getname1($dm['clan2'],getleagueID($dm['matchID']),$ac=1,league($dm['matchID']));
    $score1 = ' ('.$dm['score1'].')';
    $score2 = ' ('.$dm['score2'].')';
    
	if($_GET['type']=='gs') {
	      $mt_lk1 = '../?site=groups&'.$t_name.'='.$laddID.'&match='.$dm['matchID'];
		  $mt_lk2 = '../?site=groups&'.$t_name.'='.$laddID.'&match='.$dm['matchID'];
	}
	else{
	      $mt_lk1 = '../?site=matches&action=viewmatches&clanID='.$dm['clan1'].'&'.$t_name.'='.$laddID;
	      $mt_lk2 = '../?site=matches&action=viewmatches&clanID='.$dm['clan2'].'&'.$t_name.'='.$laddID;
	}
	
	$teammatches = '<a href="'.$mt_lk1.'"><img border="0" src="../images/cup/icons/add_result.gif" align="right" width="16" height="16"></a>';
    $oppmatches = '<a href="'.$mt_lk2.'"><img border="0" src="../images/cup/icons/add_result.gif" align="left" width="16" height="16"></a>';  

	if($dm['confirmscore']==1 && $dm['einspruch']==0) {
	       $status_indi_bgcolor = $wincolor;	
	}
	elseif($dm['einspruch']==1) {
	       $status_indi_bgcolor = $loosecolor;
	}
	else{
	       $status_indi_bgcolor = $bg1;
	}
	
	    eval ("\$one_head = \"".gettemplate("all_cup_matches")."\";");
	    echo $one_head;
      
        }
        
          eval ("\$one_head = \"".gettemplate("1on1_foot")."\";");
	      echo $one_head;

    }echo '</table>';    
 }
?>