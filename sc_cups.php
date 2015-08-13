<?php

/* SC_CUPS RE-WRITE V5.2 */ 
check_db_admin($userID);

include ("config.php");
include ("cup_navigation.php"); echo '<br />';


$bg1=BG_1;
$bg2=BG_1;
$bg3=BG_1;
$bg4=BG_1;

   $set=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_settings"));
    
   $show_finished_cup = ($set['cupgamelimit']==1 ? "WHERE status != '3'" : "");
   $cupsclimit = ($set['cupsclimit']==0 ? 1 : $set['cupsclimit']);
   
   //tournaments
   
      $tournaments_sc = safe_query("SELECT * FROM ".PREFIX."cups $show_finished_cup ORDER BY ID DESC LIMIT 0,$cupsclimit");
         while($ds = mysql_fetch_array($tournaments_sc)) {
	 
	    $cupID_sc = mysql_real_escape_string($ds['ID']);
	    $game_sc = '<img src="images/games/'.$ds['game'].'.gif" width="20" height="20" border="0">';

	    $gs_true = ($ds['gs_start'] >= time() && time() < $ds['start'] ? true : false);   

	    $length = $sc_cups_length; 
	    $str_re = strlen(getcupname($cupID_sc))-$length;
	    
	    if(strlen(getcupname($cupID_sc)) > $length) {
	            $cupname_sc = substr(getcupname($cupID_sc), 0, -$str_re).'...';
	    }
	    else{
	            $cupname_sc = getcupname($cupID_sc);
	    }
	    
	    if(in_array($ds['maxclan'],array(8,16,32,64))) {
	            $out_of = $ds['maxclan'];
		    $out_of_gs = $ds['maxclan']+$ds['maxclan'];
	            $elimination_sc = 'Double Elimination';
	    }
	    else{
	            $out_of = substr($ds['maxclan'], 0, -1);
		    $out_of_gs = substr($ds['maxclan']+$ds['maxclan'], 0, -1);
	            $elimination_sc = 'Single Elimination';
	    }
	    
	    $dv= mysql_fetch_array(safe_query("SELECT count(*) as count FROM ".PREFIX."cup_clans WHERE cupID='$cupID_sc' && type='cup'"));
	    $db=mysql_fetch_array(safe_query("SELECT count(*) as count FROM ".PREFIX."cup_clans WHERE groupID='$cupID_sc' && ladID='0' && type='gs'"));
            
	    $count_sc = (!is_array($dv) ? '0' : $dv['count']);
	    $count_sc2= (!is_array($db) ? '0' : $db['count']);
	    
	    if($ds['status']==1) {
	            $signup_sc = '<a href="?site=quicknavi&cup='.getalphacupname($ds['ID']).'"><font color="'.$wincolor.'"><strong>Signups</strong></font></a>';
	    }
	    elseif($ds['status']==2) {
	            $signup_sc = '<font color="'.$drawcolor.'"><strong>Started</strong></font>';
	    }
	    else{
	            $signup_sc = '<font color="'.$loosecolor.'"><strong>Closed</strong></font>';
	    }
	    
	    if($ds['gs_start'] <= time() && $ds['gs_end'] >= time()) {	
                    $gs_true_st = true;	    
	            $signup_gs_sc = '<font color="'.$drawcolor.'"><strong>Started</strong></font>';
	    }
	    elseif($ds['status']==1 && $ds['gs_start'] > time()) {
                    $gs_true_st = true;		 
	            $signup_gs_sc = '<a href="?site=groups&cupID='.$cupID_sc.'"><font color="'.$wincolor.'"><strong>Signups</strong></font></a>';
	    }
	    else{
                    $gs_true_st = false;	 
	            $signup_gs_sc = '<a href="?site=groups&cupID='.$cupID_sc.'"><font color="'.$loosecolor.'"><strong>Closed</strong></font></a>';
	    }
	    
	    if($gs_true OR $gs_true_st) {
	    
	        echo '<table width="100%" cellpadding="'.$cellpadding.'" cellspacing="'.$cellspacing.'" bgcolor="">
	                <tr>
		          <td bgcolor="'.$bg1.'">'.$game_sc.' <a href="?site=cups&action=details&cupID='.$cupID_sc.'&display=gs#gs">'.$cupname_sc.'</a></td>
		        </tr>
		         <tr>
		          <td bgcolor="'.$bg1.'"><strong>Type:</strong> '.$ds['typ'].' Group Stages <a href="?site=groups&cupID='.$cupID_sc.'"><img src="images/cup/icons/groups.png" width="16" height="16" align="right"></a></td>
		        </tr>
		         <tr>
		          <td bgcolor="'.$bg1.'"><strong>Start:</strong> '.date('d/m/Y', $ds['gs_start']).'</td>
		        </tr>
		         <tr>
		          <td bgcolor="'.$bg1.'"><strong>Entered:</strong> '.$count_sc2.'/'.$out_of_gs.'</td>
		        </tr>
		         <tr>
		          <td bgcolor="'.$bg1.'"><strong>Timezone:</strong> '.($ds['timezone']!='' ? $ds['timezone'] : $set['timezone']).'</td>
		        </tr>
		         <tr>
		          <td bgcolor="'.$bg1.'"><strong>Status:</strong> '.$signup_gs_sc.' <span style="float:right"><img src="images/cup/icons/bullet.gif"> <a href="?site=cups&action=details&cupID='.$cupID_sc.'&display=gs#gs">Details</a></span></td>
		        </tr>
		      </table>';
	    
	    }
	    else{

	        echo '<table width="100%" cellpadding="'.$cellpadding.'" cellspacing="'.$cellspacing.'" bgcolor="">
	                <tr>
		          <td bgcolor="'.$bg1.'">'.$game_sc.' <a href="?site=cups&action=details&cupID='.$cupID_sc.'">'.$cupname_sc.'</a></td>
		        </tr>
		         <tr>
		          <td bgcolor="'.$bg1.'"><strong>Type:</strong> '.$ds['typ'].' '.$elimination_sc.' <a href="?site=brackets&action=tree&cupID='.$cupID_sc.'"><img src="images/cup/icons/tournament.png" width="16" height="16" align="right"></a></td>
		        </tr>
		         <tr>
		          <td bgcolor="'.$bg1.'"><strong>Start:</strong> '.date('d/m/Y', $ds['start']).'</td>
		        </tr>
		         <tr>
		          <td bgcolor="'.$bg1.'"><strong>Entered:</strong> '.$count_sc.'/'.$out_of.'</td>
		        </tr>
		         <tr>
		          <td bgcolor="'.$bg1.'"><strong>Timezone:</strong> '.($ds['timezone']!='' ? $ds['timezone'] : $set['timezone']).'</td>
		        </tr>
		         <tr>
		          <td bgcolor="'.$bg1.'"><strong>Status:</strong> '.$signup_sc.' <span style="float:right"><img src="images/cup/icons/bullet.gif"> <a href="?site=cups&action=details&cupID='.$cupID_sc.'">Details</a></span></td>
		        </tr>
		      </table>';
	    } 
	 }
	 
   //ladders
   
      $ladders_sc = safe_query("SELECT * FROM ".PREFIX."cup_ladders $show_finished_cup ORDER BY ID DESC LIMIT 0,$cupsclimit");
         while($ds = mysql_fetch_array($ladders_sc)) {
	 
	    $cupID_sc = mysql_real_escape_string($ds['ID']);
	    $game_sc = '<img src="images/games/'.$ds['game'].'.gif" width="20" height="20" border="0">';

	    $gs_true = ($ds['gs_start'] >= time() && time() < $ds['start'] ? true : false);

	    $length = $sc_cups_length; 
	    $str_re = strlen(getladname($cupID_sc))-$length;
	    
	    if(strlen(getladname($cupID_sc)) > $length) {
	            $cupname_sc = substr(getladname($cupID_sc), 0, -$str_re).'...';
	    }
	    else{
	            $cupname_sc = getladname($cupID_sc);
	    }
	    
	    if($gs_true==true || $ds['status']==1 && $ds['gs_start'] <= time() && $ds['gs_end'] >= time()) {
		    $out_of_gs = $ds['maxclan']+$ds['maxclan'];
	    }
	    else{
		    $out_of_gs = '';
	    }
	    
	    $dv= mysql_fetch_array(safe_query("SELECT count(*) as count FROM ".PREFIX."cup_clans WHERE ladID='$cupID_sc' && type='ladder'"));
	    $db=mysql_fetch_array(safe_query("SELECT count(*) as count FROM ".PREFIX."cup_clans WHERE groupID='$cupID_sc' && cupID='0' && type='gs'"));
            
	    $count_sc = (!is_array($dv) ? '0' : $dv['count']);
	    $count_sc2= (!is_array($db) ? '0' : $db['count']);
	    
	    if($ds['status']==1) {
	            $signup_sc = '<a href="?site=quicknavi&type=ladders&cup='.getalphaladname($ds['ID']).'"><font color="'.$wincolor.'"><strong>Signups</strong></font></a>';
	    }
	    elseif($ds['status']==2) {
	            $signup_sc = '<font color="'.$drawcolor.'"><strong>Started</strong></font>';
				
				if($ds['sign']==1) {
				   $signup_sc_sign = '<a href="?site=quicknavi&type=ladders&cup='.getalphaladname($ds['ID']).'"><font color="'.$wincolor.'">(<strong>Signups</strong>)</font></a>';
				}
	    }
	    else{
	            $signup_sc = '<font color="'.$loosecolor.'"><strong>Closed</strong></font>';
	    }	
	    
	    if($ds['gs_start'] <= time() && $ds['gs_end'] >= time()) {
                    $gs_true_st = true;	  
	                $signup_gs_sc = '<font color="'.$drawcolor.'"><strong>Started</strong></font>';
	    }
	    elseif($ds['status']==1 && $ds['gs_start'] > time()) {
                    $gs_true_st = true;		 
	                $signup_gs_sc = '<a href="?site=groups&laddID='.$cupID_sc.'"><font color="'.$wincolor.'"><strong>Signups</strong></font></a>';
	    }
	    else{
                    $gs_true_st = false;
	            $signup_gs_sc = '<a href="?site=groups&laddID='.$cupID_sc.'"><font color="'.$loosecolor.'"><strong>Closed</strong></font></a>';
	    }
	    
	    if($gs_true OR $gs_true_st) {
	    
	        echo '<table width="100%" cellpadding="'.$cellpadding.'" cellspacing="'.$cellspacing.'" bgcolor="">
	                <tr>
		          <td bgcolor="'.$bg1.'">'.$game_sc.' <a href="?site=ladders&ID='.$cupID_sc.'&display=gs#gs">'.$cupname_sc.'</a></td>
		        </tr>
		         <tr>
		          <td bgcolor="'.$bg1.'"><strong>Type:</strong> '.$ds['typ'].' Group Stages <a href="?site=groups&laddID='.$cupID_sc.'"><img src="images/cup/icons/groups.png" width="16" height="16" align="right"></a></td>
		        </tr>
		         <tr>
		          <td bgcolor="'.$bg1.'"><strong>Start:</strong> '.date('d/m/Y', $ds['gs_start']).'</td>
		        </tr>
		         <tr>
		          <td bgcolor="'.$bg1.'"><strong>Entered:</strong> '.$count_sc2.'/'.$out_of_gs.'</td>
		        </tr>
		         <tr>
		          <td bgcolor="'.$bg1.'"><strong>Timezone:</strong> '.($ds['timezone']!='' ? $ds['timezone'] : $set['timezone']).'</td>
		        </tr>
		         <tr>
		          <td bgcolor="'.$bg1.'"><strong>Status:</strong> '.$signup_gs_sc.' <span style="float:right"><img src="images/cup/icons/bullet.gif"> <a href="?site=ladders&ID='.$cupID_sc.'&display=gs#gs">Details</a></span></td>
		        </tr>
		      </table>';
	    
	    }
	    else{

	        echo '<table width="100%" cellpadding="'.$cellpadding.'" cellspacing="'.$cellspacing.'" bgcolor="">
	                <tr>
		          <td bgcolor="'.$bg1.'">'.$game_sc.' <a href="?site=ladders&ID='.$cupID_sc.'">'.$cupname_sc.'</a></td>
		        </tr>
		         <tr>
		          <td bgcolor="'.$bg1.'"><strong>Type:</strong> '.$ds['typ'].' Ladder <a href="?site=standings&ladderID='.$cupID_sc.'"><img src="images/cup/icons/ladder.png" width="16" height="16" align="right"></a></td>
		        </tr>
		         <tr>
		          <td bgcolor="'.$bg1.'"><strong>Start:</strong> '.date('d/m/Y', $ds['start']).'</td>
		        </tr>
		         <tr>
		          <td bgcolor="'.$bg1.'"><strong>Entered:</strong> '.$count_sc.'</td>
		        </tr>
		         <tr>
		          <td bgcolor="'.$bg1.'"><strong>Timezone:</strong> '.($ds['timezone']!='' ? $ds['timezone'] : $set['timezone']).'</td>
		        </tr>
		         <tr>
		          <td bgcolor="'.$bg1.'"><strong>Status:</strong> '.$signup_sc.' '.$signup_sc_sign.' <span style="float:right"><img src="images/cup/icons/bullet.gif"> <a href="?site=ladders&ID='.$cupID_sc.'">Details</a></span></td>
		        </tr>
		      </table>';
	    } 
	 }
?>