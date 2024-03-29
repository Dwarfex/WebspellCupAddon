<link href="cup.css" rel="stylesheet" type="text/css">
<style>
.show_hide_gs, .slidingDiv_dt  {
	display:none;
}
</style>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js" type="text/javascript"></script>
<script type="text/javascript">

$(document).ready(function(){
        $(".slidingDiv_gs").<?php echo $_GET['display']=='gs' ? 'show' : 'hide'; ?>();
        $(".show_hide_gs").show();
	
	$('.show_hide_gs').click(function(){
	$(".slidingDiv_gs").slideToggle();
	});
	
        $(".slidingDiv_dt").show();
        $(".show_hide_dt").show();
	
	$('.show_hide_dt').click(function(){
	$(".slidingDiv_dt").slideToggle();
	});
	
        $(".slidingDiv_dr").show();
        $(".show_hide_dr").show();
	
	$('.show_hide_dr').click(function(){
	$(".slidingDiv_dr").slideToggle();
	});
});

</script>


<?php

include ("config.php");

$bg1=BG_1;
$bg2=BG_1;
$bg3=BG_1;
$bg4=BG_1;
$cpr=ca_copyr();

$name_type = "Cup";
$typ_e = "typ";

//date and timezone

getlocaltimezone(0,0,$userID);
$gl_tz = getlocaltimezone(0,0,$userID);

if($gl_tz == 1) {
      $gmt_local = "<br /> <strong>Local Current Time:</strong> ".date("dS - H:i");
}
else{ 
      $gmt_local = "<br /> <strong>Local Current Time:</strong> ".$gl_tz;
}
getcuptimezone();
$gmt = getcuptimezone(1);
$gmt_now = "<strong>League Current Time:</strong> ".date("dS - H:i").$gmt_local;

echo '<div class="tooltip" id="timenow" align="left">'.$gmt_now.'</div>';

//automation functions

if(isset($_GET['cupID'])) {
randomize_brackets($_GET['cupID']);
tournament_winners($_GET['cupID']);
qualifiersToLeague($_GET['cupID']);
}
match_query_type();
check_db_admin($userID);

if(!$cpr || !ca_copyr()) die();
if(isset($_GET['action'])){
	if($_GET['action'] == 'details'){
		$cupID = mysqli_escape_string($_GET['cupID']);
		$ergebnis = safe_query("SELECT * FROM ".PREFIX."cups WHERE ID = '".$cupID."'");
		$ds=mysqli_fetch_array($ergebnis);
		$wn=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_baum WHERE cupID='$cupID'"));
		
		if(in_array($ds['maxclan'],$maxclan_array))
		   $final_match = $ds['maxclan'];
		else 
		   $final_match = $ds['maxclan']-1;

		   $dm=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchno='$final_match' AND cupID='$cupID'"));
		   $second_place=($dm['score1'] > $dm['score2'] ? getname1($dm['clan2'],$cupID,$ac=0,$var='cup') : getname1($dm['clan1'],$cupID,$ac=0,$var='cup'));

		   getlocaltimezone(0,0,$userID);
		   
           if($gl_tz == 1) {
                $start_local = "<strong>Starting in Your Timezone</strong><hr> ".date('l M dS Y \@\ g:i a', $ds['start']);
           }
           else{ 
                $start_local = "<strong>Starting in Your Timezone</strong><hr> ".$gl_tz;
           }			   
		   
           echo '<div class="tooltip" align="center" id="start" align="left">'.$start_local.'</div>';	

           getcuptimezone();
		
		$start = '&nbsp;<a name="start" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'start\')" onmouseout="hideWMTT()">'.date('l M dS Y \@\ g:i a', $ds['start']).' <img src="images/cup/icons/contact_info.png" align="left"></a>';
		$ende = date('l M dS Y \@\ g:i a', $ds['ende']);	
		$start_gs = date('l M dS Y \@\ g:i a', $ds['gs_start']);
		$end_gs = date('l M dS Y \@\ g:i a', $ds['gs_end']); 
		$cupdesc = htmloutput(toggle($ds['desc'], 1));
		$status = $ds['status'];
		$checkin = $ds['checkin'];
		$checkintime = $ds['start']-($ds['checkin']*60);
		$checkindate = date('l M dS Y \@\ g:i a', $checkintime);
		
		if($wn['wb_winner'] && $wn['wb_winner']!=2147483647) {
		       $first_name = getname1($wn['wb_winner'],$cupID,0,'cup');
        }
        else{
               $first_name = 'n/a';
        }

		if($wn['second_winner'] && $wn['second_winner']!=2147483647) {
		       $second_name = getname1($wn['second_winner'],$cupID,0,'cup');
		}
		else{
		       $second_name = 'n/a';
		}
		
		if($wn['third_winner'] && $wn['third_winner']!=2147483647) {
		       $third_name = getname1($wn['third_winner'],$cupID,0,'cup');
		}
		else{
		       $third_name = 'n/a';
		}
		
		$winners = "";
		
		if(($ds['status']==3) && (($wn['wb_winner'] && $wn['wb_winner']!=2147483647) || ($wn['second_winner'] && $wn['second_winner']!=2147483647) || ($wn['third_winner'] && $wn['third_winner']!=2147483647))) 
		  $winners = '
  
            
            <table width="100%" cellspacing="'.cellspacing.'" cellpadding="'.$cellpadding.'" bgcolor="'.$border.'">
              <tr>
                <td bgcolor="'.$bghead.'" class="title" colspan="6"><img src="images/profile/awards.png"> Winners</td>
              </tr>
	           <tr>
		        <td bgcolor="'.$pagebg.'" colspan="6"></td>
	          </tr>
	           <tr>
		        <td bgcolor="'.$bg1.'" width="15%"><img src="images/cup/icons/award_gold.png"> <strong>1st Place</strong></td>
		        <td bgcolor="'.$bg1.'"><b>'.$first_name.'</b></td>
		      </tr>
	           <tr>
		        <td bgcolor="'.$bg1.'" width="15%"><img src="images/cup/icons/award_silver.png"> <strong>2nd Place</strong></td>
		        <td bgcolor="'.$bg1.'"><b>'.$second_name.'</b></td>
		      </tr>
	           <tr>
		        <td bgcolor="'.$bg1.'" width="15%"><img src="images/cup/icons/award_bronze.png"> <strong>3rd Place</strong></td>
		        <td bgcolor="'.$bg1.'"><b>'.$third_name.'</b></td>
		      </tr>
            </table>';
		
		   getlocaltimezone(0,0,$userID);
		   
  $ladder_platform = '
	<tr>
		<td bgcolor="'.$bg1.'" width="20%"><img src="images/cup/icons/category.png"><strong>Platform</strong></td>
		<td bgcolor="'.$bg1.'">'.getplatname($ds['platID']).'</td>
	</tr>';
		   
           if($gl_tz == 1) {
                $checkin_local = "<strong>Checkin-start in Your Timezone</strong><hr> ".date('l M dS Y \@\ g:i a', $ds['start']-($ds['checkin']*60));
           }
           else{ 
                $checkin_local = "<strong>Checkin-start in Your Timezone</strong><hr> ".$gl_tz;
           }		   
		   
           echo '<div class="tooltip" align="center" id="checkin" align="left">'.$checkin_local.'</div>';	

           getcuptimezone();
		   
		   if($ds['discheck']==1) {
		          $show_checkin_op = '<i>(automatic checkin enabled)</i>';
		   }
		   else{
		          $show_checkin_op = '<a name="checkin" style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'checkin\')" onmouseout="hideWMTT()">'.$checkindate.' <img src="images/cup/icons/contact_info.png" align="left"></a>';
		   }
		
	$rl_checkin_date = '	
	<tr>
		<td bgcolor="'.$bg1.'"><img src="images/cup/icons/status.png"> <strong>Checkin Begins</strong></td>
		<td bgcolor="'.$bg1.'">&nbsp;'.$show_checkin_op.'</td>
	</tr>';    
		
		if($status == 1){
			if(time() >= $checkintime)
				$status = 'Signup phase (Check-In)';
			else
				$status = 'Signup phase';
		}elseif($status == 2)
			$status = 'Started';
		elseif($status == 3)
			$status = 'Closed';
	
		$ergebnis = safe_query("SELECT count( ID ) as clans FROM ".PREFIX."cup_clans WHERE cupID = '".$cupID."'");
		$db = mysqli_fetch_array($ergebnis);
		
		$ergebnis2 = safe_query("SELECT count( ID ) as clans2 FROM ".PREFIX."cup_clans WHERE cupID = '".$cupID."' && checkin = '1'");
		$dd = mysqli_fetch_array($ergebnis2);
		
		$ergebnis2 = safe_query("SELECT count( ID ) as clans3 FROM ".PREFIX."cup_clans WHERE groupID = '".$cupID."' && ladID='0'");
		$dd3 = mysqli_fetch_array($ergebnis2);
	   
		$ergebnis2 = safe_query("SELECT count( ID ) as clans4 FROM ".PREFIX."cup_clans WHERE groupID = '".$cupID."' && checkin = '1' && ladID='0'");
		$dd4 = mysqli_fetch_array($ergebnis2);
		
		if($ds['maxclan'] == 80 || $ds['maxclan']== 8)
			$max = 8;
		elseif($ds['maxclan'] == 160 || $ds['maxclan']== 16)
			$max = 16;
		elseif($ds['maxclan'] == 320 || $ds['maxclan']== 32)
			$max = 32;
		elseif($ds['maxclan'] == 640 || $ds['maxclan']== 64)
			$max = 64;
		
		if(is1on1($cupID)) 
			$members = $db['clans'].' / '.$max.'  (<a href="?site=clans&cupID='.$cupID.'">All players</a>)';
			
		else 
			$members = $db['clans'].' / '.$max.'  (<a href="?site=clans&cupID='.$cupID.'">All Teams</a>)';
			
                $group_max = $max+$max;

		$members2 = $dd['clans2'].' / '.$max;
		$members3 = $dd3['clans3'].' / '.$group_max;
		$members4 = $dd4['clans4'].' / '.$group_max;	

        if(is1on1($cupID)) $participants = 'Players';
		else $participants = 'Teams';
		
		$members2 = $dd['clans2'].' / '.$max;
		
		$gameacc_sql = safe_query("SELECT * FROM ".PREFIX."gameacc WHERE gameaccID='".$ds['gameaccID']."'");
		$dv = mysqli_fetch_array($gameacc_sql);
		$gameacc = $dv['type'];
		
		$getname = safe_query("SELECT * FROM ".PREFIX."cups WHERE ID='$cupID'");
	    while($dd = mysqli_fetch_array($getname))
	    $cupname = getcupname($cupID);
	  	    
        include ("title_cup.php");
        
		eval ("\$title_cup = \"".gettemplate("title_cup")."\";");
		echo $title_cup;
		
		//freeagent notification
		
        $freeagents = safe_query("SELECT * FROM ".PREFIX."cup_agents WHERE cupID='$cupID' && ladID='0'");
		if(mysqli_num_rows($freeagents) && iscupparticipant($userID,$cupID))
		echo "<div ".$error_box."> There are free-agents available for this league. Click <a href='?site=freeagents&action=view&cupID=".$cupID."'>here</a> to view.</div>";
		
		//unchecked notification
		if(iscupparticipant($userID,$cupID,2)) 
		echo '<div '.$error_box.'>You are registerd but not checked. <a href="?site=quicknavi&cup='.getalphacupname($ds['ID']).'">Check-in now!</a></div>';
		
	$show_prts = "
	<tr>
		<td bgcolor='$bg1'><img id='myImage' src='images/cup/icons/yourteams.png' width='16' height='16'> <strong>Participants</strong></td>
	        <td bgcolor='$bg1'>$members</td>
	</tr>
	<tr>
		<td bgcolor='$bg1'><img src='images/cup/icons/yourteams.png' width='16' height='16'> <strong>Checked-In</strong></td>
		<td bgcolor='$bg1'>$members2</td>
	</tr>";	
	
  $rl_na = "";

  if(!$ds['ratio_low'] || !$ds['ratio_high']) {
   $ratio_level = $none;
   
  }else{
  
   if($skill_type) {
      $low_t = '<img src="images/cup/icons/skill_low.gif">';
      $med_t = '<img src="images/cup/icons/skill_medium.gif">';
      $high_t = '<img src="images/cup/icons/skill_high.gif">';
   }else{
      $low_t = $low;
      $med_t = $med;
      $high_t = $high;
   }
    
    if($ratio=='1') {
      if($ds['ratio_low'] || $ds['ratio_high']) {
		
            if($ds['ratio_low'] >= $h1 && $ds['ratio_high'] <= $l1) 
               $ratio_level = $low_t;        
        elseif($ds['ratio_low'] >= $h2 && $ds['ratio_high'] <= $l2)
               $ratio_level = $med_t;
        elseif($ds['ratio_low'] >= $h3 && $ds['ratio_high'] <= $l3)
               $ratio_level = $lowmed;      
        elseif($ds['ratio_low'] >= $h4 && $ds['ratio_high'] <= $l4)
               $ratio_level = $high_t; 
        elseif($ds['ratio_low'] >= $h5 && $ds['ratio_high'] <= $l5) 
               $ratio_level = $medhigh;  
        elseif($ds['ratio_low'] >= $h6 && $ds['ratio_high'] <= $l6)  
               $ratio_level = $high1; 
        elseif($ds['ratio_low'] >= $h7 && $ds['ratio_high'] <= $l7)  
               $ratio_level = $high2; 
        else{
           $ratio_level = 'Ratio: '.$ds['ratio_low'].'%-'.$ds['ratio_high'].'%'; 
	   $rl_na = 1;
	}
    }else{
      if($ds['ratio_low'] || $ds['ratio_high']) { 
           $ratio_level = 'Ratio: '.$ds['ratio_low'].'%-'.$ds['ratio_high'].'%'; 
        }else $ratio_level = $none; 
      }
    }
  }  
      
      if(in_array($ds['maxclan'],$maxclan_array)) {
           $elimination_type = "- Double Elimination";
      } else {
           $elimination_type = "- Single Elimination";
	  }
      $show_score_ratio = "";
	   
      if($ds['ratio_low'] || $ds['ratio_high']) {
      
        $show_score_ratio = '
	<tr>
		<td bgcolor="'.$bg1.'"><img src="images/cup/icons/ratio.png"> <strong>Required Ratio</strong></td>
		<td bgcolor="'.$bg1.'">'.$ds['ratio_low'].'%-'.$ds['ratio_high'].'%</td>
	</tr>';
      }
      
      if($ratio_level && $ratio_level!='n/a' && $rl_na==0) {
       
        $show_skill_level = '
      	<tr>
		<td bgcolor="'.$bg1.'"><img src="images/cup/icons/ratio.png"> <strong>Skill-level</strong></td>
		<td bgcolor="'.$bg1.'">'.$ratio_level.'</td>
	</tr>';
      }
	  
	  $show_desc = "";
      
      if($cupdesc OR $ds['gewinn1']  OR $ds['gewinn2']  OR $ds['gewinn3']) {
	  
	  if($cupdesc && ($ds['gewinn1'] OR $ds['gewinn2'] OR $ds['gewinn3'])) {
	        $disp_brhr = '<br><br><hr><br>'; 
			$disp_brhr2= ' Info & Awards';
      }
	  elseif(!$cupdesc && ($ds['gewinn1'] OR $ds['gewinn2'] OR $ds['gewinn3'])) {
	        $disp_brhr = ''; 
			$disp_brhr2= ' Awards';
      }
	  else{
     	    $disp_brhr = '';
			$disp_brhr2= ' Info';
      }
	  
     $show_desc = '<br><table width="100%" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'" bgcolor="'.$border.'">
	                <tr>
		          <td bgcolor="'.$bghead.'" class="title" colspan="2"><img src="images/icons/foldericons/folder.gif" width="13" height="13">'.$disp_brhr2.'<a href="#dr" name="dr" class="show_hide_dr"><img src="images/cup/icons/arrow_up_down.gif" align="right"></a></td>
	                </tr>
		      </table>';
      
$show_desc .= '<div class="slidingDiv_dr"> 
                  <table width="100%" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'" bgcolor="'.$border.'">
	            <tr>
		      <td bgcolor="'.$bg1.'" colspan="2" style="padding:3px;">'.$cupdesc.' '.$disp_brhr.' '.($ds['gewinn1'] ? '<img src="images/cup/icons/award_gold.png"> <b>1st Place Award:</b> '.$ds['gewinn1'].'<br>' : '').' '.($ds['gewinn2'] ? '<img src="images/cup/icons/award_silver.png"> <b>2nd Place Award:</b> '.$ds['gewinn2'].'<br>' : '').' '.($ds['gewinn3'] ? '<img src="images/cup/icons/award_bronze.png"> <b>3rd Place Award:</b> '.$ds['gewinn3'].'<br>' : '').'</td>
	            </tr>
                   </table>
		 </div>';

      }

//group stages table

   if($ds['gs_regtype']) {
      $reg_type = 'Your group selection';
   }
   else{
      $reg_type = 'Randomized group registration';
   }
   
   if(!$ds['gs_staging']) {
          $to_qualify = 'Win your single match to qualify';
   }   
   elseif($ds['gs_staging']==2) {
          $to_qualify = 'Gain most XP - from your single match';   
   }
   elseif($ds['gs_staging']==1){
          $to_qualify = 'Gain most XP from your matches against all '.(is1on1($cupID) ? "players" : "teams").' in your group';   
   } 
   
   $alpha_groups = "cupID='a' || cupID='b' || cupID='c' || cupID='d' || cupID='e' || cupID='f' || cupID='g' || cupID='h'";
   $dt=mysqli_fetch_array(safe_query("SELECT count(*) as totalm FROM ".PREFIX."cup_matches WHERE matchno='$cupID' && ($alpha_groups) && ladID='0' && confirmscore='1' && einspruch='0'"));

   if($ds['gs_staging']==1)
      $total_matches = $max*4;
   else
      $total_matches = $max;
	  
  $show_gs_info = "";
  $groups_table = "";
   
  if($ds['gs_start'] || $ds['gs_end']) {
  
      	$show_gs_info = '
			<tr>
			  <td class="title2" colspan="2"><img src="images/cup/icons/support.png" width="16" height="16"> Qualifying in <a href="?site=groups&cupID='.$ds['ID'].'">group league</a> will automatically place you in the play-off brackets.</td>
			</tr>
			<tr>
			  <td bgcolor="'.$pagebg.'" colspan="2"></td>
			</tr>';
  
     $groups_table = '<table width="100%" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'" bgcolor="'.$border.'">
	                <tr>
		          <td class="title" colspan="2"><a href="?site=groups&cupID='.$cupID.'"><img src="images/cup/icons/groups.png" border="0"></a> Group Stages <a href="#gs" name="gs" class="show_hide_gs"><img src="images/cup/icons/arrow_up_down.gif" align="right"></a></td>
	                </tr>
		      </table>';

  if($ds['status']==1 && $ds['gs_start'] > time()) {		    
       $gs_status = 'Signup-Phase';
  }
  elseif($ds['status']==1 && $ds['gs_start'] <= time() && $ds['gs_end'] >= time()) {
       $gs_status = 'Started';
  }
  else{
       $gs_status = 'Closed';
  }  
  
  $groups_table.= '
  
    <div class="slidingDiv_gs"> 
      <table width="100%" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'" bgcolor="'.$border.'">
        <tr>
             <td bgcolor="'.$bg1.'"><img src="images/cup/icons/type_size.png" width="16" height="16"> <strong>Total</strong></td> 
             <td bgcolor="'.$bg1.'"><b>'.$ds['gs_maxrounds'].'</b> Maxrounds & <b>'.$dt['totalm'].'/'.$total_matches.'</b> Totalmatches</td>
        </tr>	
	<tr>
	        <td bgcolor="'.$bg1.'"><img src="images/cup/icons/yourteams.png" width="16" height="16"> <strong>Participants</strong></td>
	        <td bgcolor="'.$bg1.'">'.$members3.'</td>
	</tr>
	<tr>
		<td bgcolor="'.$bg1.'"><img src="images/cup/icons/date.png"> <strong>Start</strong></td>
		<td bgcolor="'.$bg1.'">'.$start_gs.'</td>
	</tr>
        <tr>
             <td bgcolor="'.$bg1.'"><img src="images/cup/icons/random.png"> <strong>Type</strong></td>
             <td bgcolor="'.$bg1.'">'.$reg_type.'</td>
        </tr>
        <tr>
             <td bgcolor="'.$bg1.'"><img src="images/cup/icons/award_silver.png" width="16" height="16"> <strong>How to qualify</strong></td>
             <td bgcolor="'.$bg1.'">'.$to_qualify.'</td>
        </tr>
        <tr>
             <td bgcolor="'.$bg1.'"><img src="images/cup/icons/ratio.png" width="16" height="16"> <strong>Approved XP</strong></td>
             <td bgcolor="'.$bg1.'">'.($ds['gs_dxp'] ? "Matches won only will count towards your XP" : "Mathches won and lost will count towards your XP").'</td>
        </tr>
	<tr>
		<td bgcolor="'.$bg1.'"><img src="images/cup/icons/checkin.png"> <strong>Status</strong></td>
		<td bgcolor="'.$bg1.'">'.$gs_status.'</td>
	</tr>
	<tr>
	        <td bgcolor="'.$bg1.'"><img src="images/cup/icons/status.png"> <strong>Link</strong></td>
		<td bgcolor="'.$bg1.'"><input type="button" value="Group Stages" onClick="window.location=\'?site=groups&cupID='.$ds['ID'].'\'"></td>
	</tr>
      </table>
    </div>
    <br />';
  
  }
  
  $wi=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_baum WHERE cupID='$cupID'"));
  
  $l_ended = "";
  
  if($wi['wb_winner'] && $wi['second_winner'] && $wi['third_winner'] && $ds['status']==3) {
  
     $l_ended = '
	<tr>
		<td bgcolor="'.$bg1.'"><img src="images/cup/icons/date.png"> <strong>Ended</strong></td>
		<td bgcolor="'.$bg1.'">'.$ende.'</td>
	</tr>';
  }
  
  $c_admins = safe_query("SELECT * FROM ".PREFIX."cup_admins WHERE cupID='$cupID'");
  $admin_rows = mysqli_num_rows($c_admins);
  
  $cups_s_admins = "";
  
  if($admin_rows) {
   
     $cups_s_admins = '
  
        <tr>
		<td bgcolor="'.$bg1.'"><img src="images/cup/icons/admin.png"> <strong>Admins</strong></td>
		<td bgcolor="'.$bg1.'"><a href="?site=cups&action=admins&cupID='.$cupID.'">'.$admin_rows.' Admin'.($admin_rows==1 ? '' : 's').'</a></td>
	</tr>';
  }
  
  $ladder_abbrev = null;
  $ladder_details = null;
  $gametype = null;
  $credits_table = null;
  $challinfo_tabl = null;
  $challinfo_table = null;
  $awards_table = null;
  $tb_legend = null;
        	
		eval ("\$cup_details = \"".gettemplate("cup_details")."\";");
		echo $cup_details; 
		
}elseif($_GET['action'] == 'tree'){
		$cupID = mysqli_escape_string($_GET['cupID']);
		$ergebnis = safe_query("SELECT * FROM ".PREFIX."cups WHERE ID = '".$cupID."'");
		$ds = mysqli_fetch_array($ergebnis);

                redirect('?site=brackets&action=tree&cupID='.$cupID, '', 0);

}elseif($_GET['action'] == 'admins'){
		$cupID = mysqli_escape_string($_GET['cupID']);

		if(is1on1($cupID)) $participants = 'Players';
		else $participants = 'Teams';
		
                include ("title_cup.php");
		
		eval ("\$title_cup = \"".gettemplate("title_cup")."\";");
		echo $title_cup;
		
		$admin_sql=safe_query("SELECT * FROM ".PREFIX."cup_admins WHERE cupID='$cupID'");
		if(!mysqli_num_rows($admin_sql))
			echo '<br /><br /><center><b>There were no admins entered!</b></center><br /><br />Please try again later!<br /><br />';
		else{
			while($dv=mysqli_fetch_array($admin_sql)) {
				//Variablen
				$avatar = '<img src="images/avatars/'.getavatar($dv[userID]).'">';
				$nickname = '<a href="?site=profile&id='.$dv[userID].'">'.getnickname($dv[userID]).'</a>';
				
				$firstname = getfirstname($dv[userID]);
				if(empty($firstname))
				$firstname = 'n/a';
				
				$lastname = getlastname($dv[userID]);
				if(empty($lastname))
				$lastname = 'n/a';
				
				$res = mysqli_query("SELECT birthday, DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW()) - TO_DAYS(birthday)), '%y') 'age' FROM ".PREFIX."user WHERE userID = '$dv[userID]'");
				$cur = mysqli_fetch_array($res);
				$birthday= $cur['age'];
				if(empty($birthday))
				$birthday = 'n/a';
			
				$function = "Cup-Admin";
	
                                $id=$dv[userID];
                                include ("livecontact.php");

				eval ("\$cup_admins = \"".gettemplate("cup_admins")."\";");
				echo $cup_admins;
			}
		}
		echo $inctemp; 
}elseif($_GET['action'] == 'regeln'){
	$cupID = $_GET['cupID'];
	
	$getname = safe_query("SELECT * FROM ".PREFIX."cups WHERE ID='$cupID'");
	while($dd = mysqli_fetch_array($getname))
	$cupname = getcupname($cupID);
	
	if(is1on1($cupID)) $participants = 'Players';
	else $participants = 'Teams';
	
    include ("title_cup.php");
	
	eval ("\$title_cup = \"".gettemplate("title_cup")."\";");
	echo $title_cup;
	
	$ergebnis = safe_query("SELECT * FROM ".PREFIX."cup_rules WHERE cupID= '".$cupID."'");
	if(!mysqli_num_rows($ergebnis)){
		echo '<br /><br /><center><b>There were no rules yet registered!</b></center><br /><br />Please try again later!<br /><br />';
		echo $inctemp; 
	}else{
			$dd=mysqli_fetch_array($ergebnis);
			
			if(!isset($inctemp))
			$inctemp = '';
			
			if(empty($dd['value'])){
				echo '<br /><br /><center><b>There were no rules yet registered!</b></center><br /><br />Please try again later!<br /><br />';
				echo $inctemp; 
			}else{
			
				echo '<table width="100%" cellspacing="'.cellspacing.'" cellpadding="'.$cellpadding.'" bgcolor="'.$border.'">
				  <tr> 
					<td bgcolor="'.$bghead.'" class="title">Rules:</td>
				  </tr>
				  <tr>
				  <td bgcolor="'.$pagebg.'"></td>
				  </tr>
				  <tr> 
					<td bgcolor="'.BG_1.'">'.htmloutput(toggle($dd[value], 1)).'</td>
				  </tr> 
				  <tr> 
					<td bgcolor="'.BG_2.'">Last updated '.date("d.m.Y \a\t H:i", $dd['lastedit']).'</td>
				  </tr> 
				  </table>';
			      echo $inctemp;
			}
		}
	}
}else{

// show group

    $if_tournament = "";
	
    if(isset($_GET['gameID'])) {
	       
		   $tag_gamename = get_gametag($_GET['gameID']);
		   $game_name = get_gamename($_GET['gameID']);
           echo '<div class="infobox">Tournaments for <b>'.$game_name.'</b> - <a href="?site=cups"><b>All Tournaments</b></a></div>';
           $if_tournament = 'game=\''.$tag_gamename.'\'';
    }
	else{
    
       $tourn_ids = '<option selected>-- Select Game --</option>';    
    
	   $query = safe_query("SELECT * FROM ".PREFIX."cups");
	   while($so=mysqli_fetch_array($query)) {
	   $tags_in .= 'tag=\''.$so['game'].'\' OR ';
	   }
	   
	   $tags_in.="tag = ''";
       $tournIDs = safe_query("SELECT gameID FROM ".PREFIX."games WHERE $tags_in"); 
           while($pID = mysqli_fetch_array($tournIDs)) {
               $tourn_ids.='<option value="'.$pID['gameID'].'">'.get_gamename($pID['gameID']).'</option>';
           }
		
		$showing_plat = '';
        if(isset($_GET['platID'])) {
            $showing_plat = '&platID='.$_GET['platID'];
        }		
		   
        echo '<select name="gameID" onChange="MM_confirm(\'Show tournaments for selected game\', \'?site=cups'.$showing_plat.'&gameID=\'+this.value)">'.$tourn_ids.'</select>';
    }
	
    if(isset($_GET['platID'])) {
           echo '<div class="infobox">Tournaments for <b>'.getplatname_cup($_GET['platID']).'</b> - <a href="?site=cups"><b>All Tournaments</b></a></div>';
           $if_platform = 'platID='.$_GET['platID'].'';
    }
	else{
    
       $plat_ids = '<option selected>-- Select Platform --</option>';    
    
       $platIDs = safe_query("SELECT ID FROM ".PREFIX."cup_platforms");
           while($pID = mysqli_fetch_array($platIDs)) {
               $plat_ids.='<option value="'.$pID['ID'].'">'.getplatname($pID['ID']).'</option>';
           }
		   
		$showing_game = '';
        if(isset($_GET['gameID'])) {
            $showing_game = '&gameID='.$_GET['gameID'];
        }	
    
        echo ' <select name="platID" onChange="MM_confirm(\'Show tournaments for selected platform\', \'?site=cups'.$showing_game.'&platID=\'+this.value)">'.$plat_ids.'</select><br>';
       
    }
	    if(!isset($if_platform))
		$if_platform = "";
		
		$where = (($if_platform OR $if_tournament) ? "WHERE" : "");
		$and = (($if_platform AND $if_tournament) ? "AND" : "");
		
	
	$ergebnis = safe_query("SELECT * FROM ".PREFIX."cups $where $if_tournament $and $if_platform ORDER BY ID DESC");

//end
	
    if(!mysqli_num_rows($ergebnis)) {
	    echo '<div '.$error_box.'>No tournaments found</div>'; 
	}
	else{	
        eval ("\$cups_head = \"".gettemplate("cups_head")."\";");
	    echo $cups_head;
    }	
	
	$n=1;
	while($ds=mysqli_fetch_array($ergebnis)) {
		
		if($n%2){
			$bg1=BG_1;
			$bg2=BG_2;
		}else{
			$bg1=BG_3;
			$bg2=BG_4;
		}
		
		$fa=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_agents WHERE cupID='".$ds['ID']."' && ladID='0'"));
		$cm=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE cupID='".$ds['ID']."' && ladID='0'"));
		
		$free_agents = "";
		
		if(is_array($fa)) 
		   $free_agents = '<a href="?site=freeagents&action=view&cupID='.$ds['ID'].'"><img src="images/cup/icons/freeagents.png" align="right" width="16" height="16"></a>';
		else $free_agents = '';
		
		if(is_array($cm)) 
		   $matches_exist = '<a href="?site=matches&action=viewmatches&cupID='.$ds['ID'].'"><img src="images/cup/icons/add_result.gif" align="right" width="16" height="16"></a>';
        else $matches_exist = '';	    
		
		if($ds['gs_start'] || $ds['gs_end'])
		   $group_stages = '<a href="?site=groups&cupID='.$ds['ID'].'"><img src="images/cup/icons/groups.png" align="right" width="16" height="16"></a>';
		else $group_stages = '';		
				
		$game='<img src="images/games/'.$ds['game'].'.gif" width="20" height="20" border="0">';
		$name = '<a href="?site=cups&action=details&cupID='.$ds['ID'].'">'.$ds['name'].'</a>';
		$status = $ds['status'];
		$checkintime = $ds['start']-($ds['checkin']*60);

		    if($status == 1){
		    	if(time() >= $checkintime) {
		    		$status = 'Signup phase (Check-In)';
				    $signup = '<img src="images/cup/icons/go_sel.gif"> <a href="?site=quicknavi&cup='.getalphacupname($ds['ID']).'">Signup</a>';
		    	}
			    else{
		    		$status = 'Signup phase';
				    $signup = '<img src="images/cup/icons/go_sel.gif"> <a href="?site=quicknavi&cup='.getalphacupname($ds['ID']).'">Signup</a>';
			   }
		    }
		    elseif($status == 2) {
		     	$status = 'Started';
			    $signup = '<img src="images/cup/icons/go.png"> <s>Signup</s>';
		    }
		    elseif($status == 3) {
		    	$status = 'Closed';
			    $signup = '<img src="images/cup/icons/go.png"> <s>Signup</s>';
		    }
		
		$typ = $ds['typ'];
		$matches = '<a href="?site=matches&action=viewmatches&cupID='.$ds['ID'].'"><img src="images/cup/icons/add_result.gif" border="0"></a>';
		$detail = '<a href="?site=cups&action=details&cupID='.$ds['ID'].'"><img src="images/icons/foldericons/folder.gif" width="14" height="15" border="0"></a>';
		
		$desc = $ds['desc'];
		
		if(strlen($desc)>20) {
			$desc=substr($desc, 0, 20);
			$desc.='..';
		}	
		
// RATIO (V4.1.6)

  if(!$ds['ratio_low'] || !$ds['ratio_high']) {
   $ratio_level = $none;
   
  }else{
  
   if($skill_type) {
      $low_t = '<img src="images/cup/icons/skill_low.gif">';
      $med_t = '<img src="images/cup/icons/skill_medium.gif">';
      $high_t = '<img src="images/cup/icons/skill_high.gif">';
   }else{
      $low_t = $low;
      $med_t = $med;
      $high_t = $high;
   }
    
    if($ratio=='1') {
      if($ds['ratio_low'] || $ds['ratio_high']) {
		
            if($ds['ratio_low'] >= $h1 && $ds['ratio_high'] <= $l1) 
               $ratio_level = $low_t;        
        elseif($ds['ratio_low'] >= $h2 && $ds['ratio_high'] <= $l2)
               $ratio_level = $med_t;
        elseif($ds['ratio_low'] >= $h3 && $ds['ratio_high'] <= $l3)
               $ratio_level = $lowmed;      
        elseif($ds['ratio_low'] >= $h4 && $ds['ratio_high'] <= $l4)
               $ratio_level = $high_t; 
        elseif($ds['ratio_low'] >= $h5 && $ds['ratio_high'] <= $l5) 
               $ratio_level = $medhigh;  
        elseif($ds['ratio_low'] >= $h6 && $ds['ratio_high'] <= $l6)  
               $ratio_level = $high1; 
        elseif($ds['ratio_low'] >= $h7 && $ds['ratio_high'] <= $l7)  
               $ratio_level = $high2; 
        else
           $ratio_level = '<br>Ratio: '.$ds['ratio_low'].'%-'.$ds['ratio_high'].'%'; 
      }
    }else{
      if($ds['ratio_low'] || $ds['ratio_high']) { 
           $ratio_level = '<br>Ratio: '.$ds['ratio_low'].'%-'.$ds['ratio_high'].'%'; 
        }else $ratio_level = $none; 
      }
  }   
    
		eval ("\$cups_content = \"".gettemplate("cups_content")."\";");
		echo $cups_content;
		$n++;
	}
	eval ("\$inctemp = \"".gettemplate("cups_foot")."\";");

  }
  
  $inctemp = !(isset($inctemp)) ? "" : $inctemp; 
  echo $inctemp.($cpr ? ca_copyr() : die());
?>