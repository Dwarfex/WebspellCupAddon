<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
        $(".slidingDiv_wk").hide();
        $(".show_hide_wk").show();
	
	    $('.show_hide_wk').click(function(){
	    $(".slidingDiv_wk").slideToggle();
	    });
</script>

<?php include("config.php"); ?>
<head>
    <link href="cup.css" rel="stylesheet" type="text/css">
    <script language="javascript">wmtt = null; document.onmousemove = updateWMTT; function updateWMTT(e) { x = (document.all) ? window.event.x + document.body.scrollLeft : e.pageX; y = (document.all) ? window.event.y + document.body.scrollTop  : e.pageY; if (wmtt != null) { wmtt.style.left=(x + 20) + "px"; wmtt.style.top=(y + 20) + "px"; } } function showWMTT(id) {	wmtt = document.getElementById(id);	wmtt.style.display = "block" } function hideWMTT() { wmtt.style.display = "none"; }</script>
    <div class="tooltip" id="no_score" align="left"><img src="images/cup/icons/faq.png"> Neither participant has inscribed a result yet.</div>
    <div class="tooltip" id="waiting_confirmation" align="left"><img src="images/cup/icons/pending.gif"> Awaiting score confirmation</div>
    <div class="tooltip" id="waiting_player2" align="left"><img src="images/cup/icons/pending.gif"> Waiting for player 2 registration</div>
</head>

<?php
$bg1=BG_1;
$bg2=BG_1;
$bg3=BG_1;
$bg4=BG_1;
$cpr=ca_copyr();
match_query_type();

//language
$_language->read_module('groups');

$style3 = '
    
    </td>
  </tr>
 </table>';

  if(isset($_GET['cupID']))
  {
  
    getcuptimezone();
  
    if(is1on1($_GET['cupID'])) $participants = 'Players';	
    else $participants = 'Teams';
  
    include("title_cup.php");
    eval ("\$t_cup = \"".gettemplate("title_cup")."\";");
    echo $t_cup;
  
    $ID = $_GET['cupID'];
    $info = safe_query("SELECT * FROM ".PREFIX."cups WHERE ID='$ID'");
    $type = "cupID";
    $type_opp = "ladID";
    $type2 = "cupID";
    $name = "Cup";
    $name2 = "is1on1";
    $name3 = getcupname($ID);
    $plat = false;
    $platID = false;
    $details_link = "?site=cups&action=details&cupID=$ID";
    $t_dxp = "gs_dxp";
    
  }
  else{
  
    getladtimezone();
  
    include("title_ladder.php");
  
    $ID = $_GET['laddID'];
    $info = safe_query("SELECT * FROM ".PREFIX."cup_ladders WHERE ID='$ID'");
    $type = "ladID";
    $type_opp = "cupID";
    $type2 = "laddID";
    $name = "Ladder";
    $name2 = "ladderis1on1";
    $name3 = getladname($ID);
    $plat = "`platID`,";
    $platID = '\''.getplatID($ID).'\',';
    $details_link = "?site=ladders&ID=$ID";
    $t_dxp = "d_xp";
  }
  

    $ds = mysqli_fetch_array($info);
    $start = date('l M dS Y \@\ g:i a', $ds['gs_start']);
	$group_show_only = (isset($_GET['group']) ? "AND $type='".$_GET['group']."'" : ""); 
	$oneleague = ($name2($ID) ? "1on1='1'" : "1on1='0'");

  if($ID) {
  
  pm_eligibility($ID);
  qualifiersToLeague($ID);
 
  if(!$cpr || !ca_copyr()) die();

        $alpha_groups = "type='gs'";
  
        $participant_ent = safe_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND ($alpha_groups) AND $type_opp='0'");
        $ent_part = mysqli_num_rows($participant_ent);
		
		$n_groups_array = (isset($_GET['group']) ? array($_GET['group']) : $groups_array);
		
		// count group participants

		$query = mysqli_query("SELECT COUNT(ID) as count, $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type_opp='0' AND type='gs' $group_show_only GROUP BY $type");
		$group_count = mysqli_fetch_array($query);

        foreach($n_groups_array as $i) {
           ${$i.'_rows'} = $group_count['count'];
        }

        // count group matches	
		
		$query = mysqli_query("SELECT COUNT(ID) as count, $type FROM ".PREFIX."cup_matches WHERE matchno='".$ID."' AND $type_opp='0' AND type='gs' $group_show_only GROUP BY $type");
		$match_count = mysqli_fetch_array($query);
		
        foreach($n_groups_array as $i) {
		   ${'rows_'.$i} = $match_count['count'];
        }
 
	    // DROPDOWN GROUPINGS
	  
	      $dd_groups = ($a_rows < 4 ? '<option value="a">Group A</option>' : '');
	      $dd_groups.= ($b_rows < 4 ? '<option value="b">Group B</option>' : '');
	      $dd_groups.= ($c_rows < 4 ? '<option value="c">Group C</option>' : '');
	      $dd_groups.= ($d_rows < 4 ? '<option value="d">Group D</option>' : '');
		  
		if($ds['maxclan'] == 160 OR $ds['maxclan'] == 16 OR $ds['maxclan'] == 32 OR $ds['maxclan']==320 OR $ds['maxclan'] == 64 OR $ds['maxclan']==640) {
		  
	      $dd_groups.= ($e_rows < 4 ? '<option value="e">Group E</option>' : '');
	      $dd_groups.= ($f_rows < 4 ? '<option value="f">Group F</option>' : '');
	      $dd_groups.= ($g_rows < 4 ? '<option value="g">Group G</option>' : '');
	      $dd_groups.= ($h_rows < 4 ? '<option value="h">Group H</option>' : '');
		}  
        if($ds['maxclan'] == 32 OR $ds['maxclan']==320 OR $ds['maxclan'] == 64 OR $ds['maxclan']==640) {
		  
	      $dd_groups.= ($i_rows < 4 ? '<option value="i">Group I</option>' : '');
	      $dd_groups.= ($j_rows < 4 ? '<option value="j">Group J</option>' : '');
	      $dd_groups.= ($k_rows < 4 ? '<option value="k">Group K</option>' : '');
	      $dd_groups.= ($l_rows < 4 ? '<option value="l">Group L</option>' : '');
	      $dd_groups.= ($m_rows < 4 ? '<option value="m">Group M</option>' : '');
	      $dd_groups.= ($n_rows < 4 ? '<option value="n">Group N</option>' : '');
	      $dd_groups.= ($o_rows < 4 ? '<option value="o">Group O</option>' : '');
	      $dd_groups.= ($p_rows < 4 ? '<option value="p">Group P</option>' : '');
		}  
		if($ds['maxclan'] == 64 OR $ds['maxclan']==640) {  
		  
	      $dd_groups.= ($q_rows < 4 ? '<option value="q">Group Q</option>' : '');
	      $dd_groups.= ($r_rows < 4 ? '<option value="r">Group R</option>' : '');
	      $dd_groups.= ($s_rows < 4 ? '<option value="s">Group S</option>' : '');
	      $dd_groups.= ($t_rows < 4 ? '<option value="t">Group T</option>' : '');
	      $dd_groups.= ($u_rows < 4 ? '<option value="u">Group U</option>' : '');
	      $dd_groups.= ($v_rows < 4 ? '<option value="v">Group V</option>' : '');
	      $dd_groups.= ($w_rows < 4 ? '<option value="w">Group W</option>' : '');
	      $dd_groups.= ($x_rows < 4 ? '<option value="x">Group X</option>' : '');
	      $dd_groups.= ($y_rows < 4 ? '<option value="y">Group Y</option>' : '');
	      $dd_groups.= ($z_rows < 4 ? '<option value="z">Group Z</option>' : '');
	      $dd_groups.= ($a2_rows < 4 ? '<option value="a2">Group A2</option>' : '');
	      $dd_groups.= ($b2_rows < 4 ? '<option value="b2">Group B2</option>' : '');
	      $dd_groups.= ($c2_rows < 4 ? '<option value="c2">Group C2</option>' : '');
	      $dd_groups.= ($d2_rows < 4 ? '<option value="d2">Group D2</option>' : '');
	      $dd_groups.= ($e2_rows < 4 ? '<option value="e2">Group E2</option>' : '');
	      $dd_groups.= ($f2_rows < 4 ? '<option value="f2">Group F2</option>' : '');
		  
	    }
	  
	  // PICKING RANDOM
	  
	      $groups = array();
		  
		  if($a_rows < 4) $groups[] = 'a';
		  if($b_rows < 4) $groups[] = 'b';
		  if($c_rows < 4) $groups[] = 'c';
		  if($d_rows < 4) $groups[] = 'd';
		  
		if($ds['maxclan'] == 160 OR $ds['maxclan'] == 16 OR $ds['maxclan'] == 32 OR $ds['maxclan']==320 OR $ds['maxclan'] == 64 OR $ds['maxclan']==640) {		 
		 
	      if($e_rows < 4) $groups[] = 'e';
		  if($f_rows < 4) $groups[] = 'f';
		  if($g_rows < 4) $groups[] = 'g';
		  if($h_rows < 4) $groups[] = 'h';
		}  
        if($ds['maxclan'] == 32 OR $ds['maxclan']==320 OR $ds['maxclan'] == 64 OR $ds['maxclan']==640) {
		
	      if($i_rows < 4) $groups[] = 'i';
		  if($j_rows < 4) $groups[] = 'j';
		  if($k_rows < 4) $groups[] = 'k';
		  if($l_rows < 4) $groups[] = 'l';
		  if($m_rows < 4) $groups[] = 'm';
		  if($n_rows < 4) $groups[] = 'n';
		  if($o_rows < 4) $groups[] = 'o';
		  if($p_rows < 4) $groups[] = 'p';

		}  
		if($ds['maxclan'] == 64 OR $ds['maxclan']==640) {
		
	      if($q_rows < 4) $groups[] = 'q';
		  if($r_rows < 4) $groups[] = 'r';
		  if($s_rows < 4) $groups[] = 's';
		  if($t_rows < 4) $groups[] = 't';
		  if($u_rows < 4) $groups[] = 'u';
		  if($v_rows < 4) $groups[] = 'v';
		  if($w_rows < 4) $groups[] = 'w';
		  if($x_rows < 4) $groups[] = 'x';
	      if($y_rows < 4) $groups[] = 'y';
		  if($z_rows < 4) $groups[] = 'z';
		  if($a2_rows < 4) $groups[] = 'a2';
		  if($b2_rows < 4) $groups[] = 'b2';
		  if($c2_rows < 4) $groups[] = 'c2';
		  if($d2_rows < 4) $groups[] = 'd2';
		  if($e2_rows < 4) $groups[] = 'e2';
		  if($f2_rows < 4) $groups[] = 'f2';
	    }
		
	    $group_count = count($groups) - 1;
	    $random_group = $groups[rand(0,$group_count)];

// end check
    
    if($ds['gs_regtype']) $reg_type = 'Your group selection';
    else $reg_type = 'Randomized group registration';
    
   $alpha_groups = "type='gs'";
   $dv=mysqli_fetch_array(safe_query("SELECT count(*) as anzahl FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' && $type_opp='0' && ($alpha_groups)"));
   $dt=mysqli_fetch_array(safe_query("SELECT count(*) as totalm FROM ".PREFIX."cup_matches WHERE matchno='$ID' && ($alpha_groups) && $type_opp='0' && confirmscore='1' && einspruch='0'"));
   $am=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchno='".$ID."' && $type_opp='0' && type='gs'"));
   
$chk_typ=(isset($_GET['laddID']) ? "cupID='0'" : "ladID='0'");
    $check_end = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchno='$ID' AND confirmscore='0' AND $chk_typ AND type='gs'"); 
        $ce = mysqli_fetch_array($check_end);

		if($ds['maxclan'] == 80 || $ds['maxclan']== 8)
			$max = 8;
		elseif($ds['maxclan'] == 160 || $ds['maxclan']== 16)
			$max = 16;
		elseif($ds['maxclan'] == 320 || $ds['maxclan']== 32)
			$max = 32;
		elseif($ds['maxclan'] == 640 || $ds['maxclan']== 64)
			$max = 64; 		
		
   $sp=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchno='".$ID."' && $type_opp='0' && type='gs' && si='0'"));
	
    if(is_array($sp)) {
          $all_vs_all = true;
    }
    else{ 
          $all_vs_all = false;
    }	
		
   if($ds['gs_staging']==1) {
   
      if($all_vs_all==true) {
      
            $spec_mc = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchno='$ID' && type='gs' && $type_opp='0'");
            $total_matches = mysqli_num_rows($spec_mc);
      }
      else{
            $total_matches = $max*3; 
      }
   }
   else{
            $total_matches = $max;
   }
   
   
    if(!$ent_part) {
          $finished = 0;
    }
    elseif(mysqli_num_rows($check_end)) {
          $finished = 0; 
    }
    elseif($dt['totalm'] == $total_matches) {
          $finished = 1; 
    }
	
//start registration
    
    if($ds['status']==1 && $ds['gs_start'] > time()) { 
     
            if($dv['anzahl'] >= $ds['maxclan']+$ds['maxclan']) {
                   $dd_groups_sel = '<option value="">(no spaces available)</option>'; 
            }
	    else{ 
                   $dd_groups_sel = $dd_groups;
            }
   
            if($finished) {
                   $gs_signup = '<font color="#FF6600"><b>Finished</b></font>';
            }
            elseif(!$name2($ID)) {
      

	                $ergebnis = safe_query("SELECT * FROM ".PREFIX."cup_clan_members WHERE userID = '".$userID."' AND function = 'Leader'");
	                if(!mysqli_num_rows($ergebnis) && !$name2($ID) && $userID) $no_team = '<a href="?site=clans&action=clanadd">(no team found - create a team)</a>';
                    else $no_team = '';
					
	                $clan = '<option value="" selected="selected"> - Select Team - </option>';	
	                while($dm=mysqli_fetch_array($ergebnis)) {
                        
	                $clan.= '<option name="clanID" value="'.$dm['clanID'].'">'.getclanname($dm['clanID']).'</option>'; }
	            
                if(!isset($gs_signup))
                $gs_signup = '';				
	    
                if($ds['gs_regtype']) {
             
                        $gs_signup = '<form action="index.php">
                                        <input type="hidden" name="site" value="groups">
                                        <input type="hidden" name="action" value="register">
                                        <input type="hidden" name="'.$type2.'" value="'.$_GET[$type2].'">
                                       <select name="group">
                                        '.$dd_groups_sel.'
                                       </select>
                                        <select name="clanID">'.$clan.'</select>
                                        <input type="submit" value="Signup" onclick="return confirm(\'League starts on '.$start.' '.$gmt.' \');">
                                       </form>';
	                
      
                }
		else{
      
                        $gs_signup.= '<form action="index.php">
                                        <input type="hidden" name="site" value="groups">
                                        <input type="hidden" name="action" value="register">
                                        <input type="hidden" name="'.$type2.'" value="'.$_GET[$type2].'">
                                      <select name="clanID">
				       '.$clan.'
				      </select>
                                        <input type="submit" value="Signup" onclick="return confirm(\'League starts on '.$start.' '.$gmt.' \');">
                                     </form>'; 
          }       
        }
	elseif($ds['gs_regtype']) {
        
        
                        $gs_signup = '<form action="index.php">
                                        <input type="hidden" name="site" value="groups">
                                        <input type="hidden" name="action" value="register">
                                        <input type="hidden" name="'.$type2.'" value="'.$_GET[$type2].'">
                                      <select name="group">
                                       '.$dd_groups_sel.'
                                      </select>
                                        <input type="submit" value="Signup" onclick="return confirm(\'League starts on '.$start.' '.$gmt.' \');">
                                      </form>';
                       
      }
      else{ 
      
                        $gs_signup = '<img border="0" src="images/cup/new_message.gif"> 
                                      <a href="?site=groups&action=register&'.$type2.'='.$ID.'" onclick="return confirm(\'League starts on '.$start.'GMT. \');">
                                      <strong>Signup</strong></a>';
      }                 
    }
    elseif($ds['gs_start'] <= time() && $ds['gs_end'] >= time() && is_array($am)) {
         
                        $gs_signup = '<font color="'.$drawcolor.'"><b>Started</b></font>';
    }
    else{
         
                        $gs_signup = '<font color="'.$loosecolor.'"><b>Closed</b></font>';
    }
     
//end registration
     
   
   if(isset($_GET['laddID'])) 
      $st=mysqli_fetch_array(safe_query("SELECT status FROM ".PREFIX."cup_ladders WHERE ID='".$_GET['laddID']."'"));
   else   
      $st=mysqli_fetch_array(safe_query("SELECT status FROM ".PREFIX."cups WHERE ID='".$_GET['cupID']."'"));
      
   if($st['status']==3)
      $status_m = 'Closed';
   elseif($st['status']==2)
      $status_m = 'Started';
   elseif($st['status']==1)
      $status_m = 'Sign-up Phase';
      
		if($ds['maxclan'] == 80 || $ds['maxclan']== 8)
			$max = 8;
		elseif($ds['maxclan'] == 160 || $ds['maxclan']== 16)
			$max = 16;
		elseif($ds['maxclan'] == 320 || $ds['maxclan']== 32)
			$max = 32;
		elseif($ds['maxclan'] == 640 || $ds['maxclan']== 64)
			$max = 64; 

   $dt2=mysqli_fetch_array(safe_query("SELECT count(*) as totalm FROM ".PREFIX."cup_matches WHERE matchno='$ID' && type='gs' && $type_opp='0' && confirmscore='1' && einspruch='0'"));
   $sp=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchno='".$ID."' && $type_opp='0' && type='gs' && si='0'"));
   $am=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchno='".$ID."' && $type_opp='0' && type='gs'"));
	
    if(is_array($sp)) {
          $all_vs_all = true;
    }
    else{ 
          $all_vs_all = false;
    }
	
    $max_participants = $max+$max;
   
   if($ds['gs_staging']==1) {
   
      if($all_vs_all==true) {
      
            $spec_mc = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchno='$ID' && type='gs' && $type_opp='0'");
            $total_matches = mysqli_num_rows($spec_mc);
      }
      else{
            $total_matches = $max*3; 
      }
   }
   else{
            $total_matches = $max;
   }
   
   if($dv['anzahl'] == $max+$max || $all_vs_all==true) {
      $slots = "League Full";
      $slots_ext = '';
   }
   else{
      $slots = $max+$max-$dv['anzahl']." Slots Available";
      $slots_ext = '/'.$max_participants;      
   }      
   
   if(iscupadmin($userID) && isset($_GET['rm']) && $_GET['rm']=='ava') {
           safe_query("DELETE FROM ".PREFIX."cup_matches WHERE matchno='$ID' && type='gs' && si='0' && $type_opp='0'");
		   safe_query("UPDATE ".PREFIX."cup_clans SET qual='0' WHERE groupID='$ID' && type='gs' && $type_opp='0'");
	       redirect('?site=groups&'.$type2.'='.$ID, '<font color="red"><strong>Matches removed...</strong></font>', 3);
   }
      

   if(iscupadmin($userID) && $ds['gs_staging']==1 && is_array($am)) {
   
     if($all_vs_all==true) { 
           $sh_tit = 'Remove All vs. All Matches';
           $sh_msg = 'Are you sure you want to remove All vs. All matches that were previously generated?'; 
	       $sh_lnk = '?site=groups&'.$type2.'='.$ID.'&rm=ava';
     }
     else{ 
           $sh_tit = 'Generate All vs. All Matches';
           $sh_msg = 'Note: All vs. All matches automatically generate after all '.$max_participants.' are registered. If this league did not reach max you can generate these matches manually. Manual match generation does not check for equalness, make sure equal amount of teams are registered in each group. No further sign-ups allowed - click OK to confirm.'; 
	       $sh_lnk = '?site=groups&'.$type2.'='.$ID.'&gm=ava';
     }

        $admin_options = '<tr>
	                        <td bgcolor="'.$bg1.'"><img src="images/cup/icons/admin.png"> <strong>Admin</strong></td>
			                <td bgcolor="'.$bg2.'"><a href="'.$sh_lnk.'" onclick="return confirm(\''.$sh_msg.'\');"><img src="images/cup/icons/go.png"> '.$sh_tit.'</a> <a href="?site=groups&'.$type2.'='.$ID.'&sync=qual" onclick="return confirm(\'This option will re-sync qualifiers. You should only run this after the league is finished. If you made a change to a match result after the league has finished or if qualifiers are not right, click OK. This will also re-send LEN private message.\');"><img src="images/cup/icons/go.png"> Re-Sync Qualifiers</a></td>
	                      </tr>';
   } else {
   
        $admin_options = '';
   
   }
   
   $ergebnis = safe_query("SELECT * FROM ".PREFIX."cup_clan_members WHERE userID = '".$userID."' AND function = 'Leader'");  
   if(!mysqli_num_rows($ergebnis) && !$name2($ID) && $userID) $no_team = '<a href="?site=clans&action=clanadd">(no team found - create a team)</a>';
   else $no_team = '';
      
   echo '<br />
         <table width="100%" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'" bgcolor="'.$border.'">
            <tr>
             <td class="title" colspan="2"><img src="images/cup/icons/groups.png"> <strong>Group Stages for '.$name3.'</strong></td>
           </tr>
           <tr>
             <td bgcolor="'.$bg1.'"><img src="images/cup/icons/yourteams.png" width="16" height="16"> <strong>Slots</strong></td>
             <td bgcolor="'.$bg2.'">'.$slots.' ('.$dv['anzahl'].$slots_ext.' Signups)</td>
           </tr>
            <tr>
             <td bgcolor="'.$bg1.'"><img src="images/cup/icons/add_result.gif" width="16" height="16"> <strong>Total</strong></td> 
             <td bgcolor="'.$bg2.'">'.$dt['totalm'].'/'.$total_matches.' Confirmed Matches</td>
           </tr>
	   '.$admin_options.'
            <tr>
             <td bgcolor="'.$bg1.'"><img src="images/cup/icons/checkin.png"> <strong>Signup</strong></td>
             <td bgcolor="'.$bg2.'"><b>'.$gs_signup.'</b> '.$no_team.'</td>
           </tr>
          </table>
         <br>';

        if($ds['maxclan']==8 || $ds['maxclan']==80)
           $limit = '4';
        elseif($ds['maxclan']==16 || $ds['maxclan']==160)
           $limit = '4';
        elseif($ds['maxclan']==32 || $ds['maxclan']==320)
           $limit = '4';
        elseif($ds['maxclan']==64 || $ds['maxclan']==640)
           $limit = '8';
	   
      if($name2($ID)) $participant = 'Player';
      else $participant = 'Team';
      
      if($ent_part) { 
      
         $stats_table = '<table width="100%" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'" bgcolor="'.$border.'">
                          <tr>
                            <td class="title" colspan="9" style="height:27px;"><img src="images/cup/icons/points.png"> Qualifiers & Match Stats</td>
                          </tr>
                           <tr>
						    <td style="height:27px;" class="title2" align="left">Pos.</td>
                            <td style="height:27px;" class="title2" align="left">'.$participant.'s</td>
                            <td style="height:27px;" class="title2" align="center">Played</td>
                            <td style="height:27px;" class="title2" align="center">W-D-L</td>
                            <td style="height:27px;" class="title2" align="center">Ratio</td>
                            <td style="height:27px;" class="title2" align="center">Points</td>
                            <td style="height:27px;" class="title2" align="center">Group</td>
                            <td style="height:27px;" class="title2" align="center">Eligible</td>
                          </tr>';
      }
	  
if(isset($_GET['sync']) && $_GET['sync']=='qual' && iscupadmin($userID)) {
     safe_query("UPDATE ".PREFIX."cup_clans SET qual='0', pm='0' WHERE groupID='$ID' AND $type_opp='0' AND $oneleague");
     redirect('?site=groups&'.$type2.'='.$ID, '<div class="infobox"><strong>Qualifiers re-synced. If previous qualifiers have already been snyced into the brackets, remove them manually from <a href="admin/admincenter.php?site=teams&'.$type2.'='.$ID.'" target="_blank">admin</a> and the new qualifiers will automatically be synced.</div>', 10);
}
      
//anas stats table

      if($name2($ID)) $var_1 = 1; ELSE $var_1 = 0;
	  if($name2($ID)) $var_2 = 0; ELSE $var_2 = 1;
	  $stats_content = '';
	  
	  $l = 1;
	             
      $participants = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE groupID='$ID' AND $type_opp='0' && 1on1='$var_1' && type='gs' $group_show_only ORDER BY tp DESC");
        while($gap=mysqli_fetch_array($participants)) {
        
        $alpha_groups = "type='gs'";

        if($name2($ID)) $flag = getusercountry($gap['clanID']);
        else $flag = getclancountry1($gap['clanID']);

		$a_matches = user_cup_points($gap['clanID'],$ID,$var_2,0,0,"confirmed","gs");
		$w_matches = user_cup_points($gap['clanID'],$ID,$var_2,1,0,"confirmed","gs");
		$d_matches = user_cup_points($gap['clanID'],$ID,$var_2,1,1,"confirmed","gs");
		$l_matches = user_cup_points($gap['clanID'],$ID,$var_2,0,1,"confirmed","gs");

        if(isset($_GET['laddID'])) { 
              $dxp=mysqli_fetch_array(safe_query("SELECT d_xp FROM ".PREFIX."cup_ladders WHERE ID='$ID'"));
              $t_dxp = "d_xp";
        }
		else{ 
              $dxp=mysqli_fetch_array(safe_query("SELECT gs_dxp FROM ".PREFIX."cups WHERE ID='$ID'"));
              $t_dxp = "gs_dxp";
        }  
		
        $ucp_team = ($ds['1on1']==1 ? 0 : 1);
	
        if($ratio_determination) {
            $ratio=percent($w_matches, $a_matches);
        }
        else{
            $ratio=percent(user_cup_points($gap['clanID'],$ID,$ucp_team,1,0,'confirmed_p','gs'), user_cup_points($gap['clanID'],$ID,$ucp_team,0,0,'confirmed_p','gs'));
        }
					
                $alpha_groups = "type='gs'";
				
				if(!$ds[$t_dxp]) {
				    $c_points = user_cup_points($gap['clanID'],$ID,$ucp_team,0,0,'confirmed_p','gs');
				}
				else{
				    $c_points = user_cup_points($gap['clanID'],$ID,$ucp_team,1,0,'confirmed_p','gs');
				}
				
				if($gap['tp']!=$c_points) {
				    safe_query("UPDATE ".PREFIX."cup_clans SET tp='$c_points' WHERE groupID='".$ID."' AND $type_opp='0' AND type='gs' AND clanID='".$gap['clanID']."'");
				}
		
/* CHECK QUALIFICATION */
   
 if($finished) {
 
    $check_qualifyers = safe_query("SELECT qual, pm FROM ".PREFIX."cup_clans WHERE groupID='$ID' AND qual='1' AND $type_opp='0' AND $oneleague");
    $is_qualifyers = mysqli_num_rows($check_qualifyers);
    $is_qualified = mysqli_fetch_array($check_qualifyers);
	
    $check_fcfs = safe_query("SELECT qual FROM ".PREFIX."cup_clans WHERE groupID='$ID' AND qual='2' AND $type_opp='0' AND $oneleague");
    $is_fcfs = mysqli_num_rows($check_fcfs);
	
    $check_all = safe_query("SELECT qual FROM ".PREFIX."cup_clans WHERE groupID='$ID' AND $type_opp='0' AND $oneleague");
    $is_all = mysqli_num_rows($check_all);
    
    $day_lb = date('d')+$league_begin;
    $month = date('m');
    $year = date('Y');
    $hour = date('H');
    $min = date('i');
    $date_begin_trans = @mktime($hour, $min, 0, $month, $day_lb, $year);
     	 
    $day_le = date('d')+$league_end;
    $month = date('m');
    $year = date('Y');
    $hour = date('H');
    $min = date('i');
    $date_end_trans = @mktime($hour, $min, 0, $month, $day_le, $year);
	
	$total_qual = $is_qualifyers;
	$total_qual_fcfs = $is_qualifyers + $is_fcfs;
	$total_total = $is_all / 2;
	
	if($is_qualifyers && (($total_qual_fcfs < $total_total) || ($total_qual > $total_total)) && iscupadmin($userID)) 
	$bug_qual = true; else $bug_qual = '';
	
	if($is_qualified['pm']==0) {
	
      if(($ds['gs_staging']==1 || $ds['gs_staging']==2)) {

		  if(in_array($c_points,is_qualified($ID,1))) {	 

					$fetchq = mysqli_fetch_array(safe_query("SELECT qual FROM ".PREFIX."cup_clans WHERE groupID='$ID' && clanID='".$gap['clanID']."' && $oneleague && $type_opp='0' && qual='1'"));
					
					if(!is_array($fetchq)) {
					    safe_query("UPDATE ".PREFIX."cup_clans SET qual='1' WHERE groupID='$ID' && clanID='".$gap['clanID']."' && $oneleague && $type_opp='0'");
					}
					   	  		  
		  }
		  elseif(in_array($c_points,is_qualified($ID,0))) {		
	
					$fetchq = mysqli_fetch_array(safe_query("SELECT qual FROM ".PREFIX."cup_clans WHERE groupID='$ID' && clanID='".$gap['clanID']."' && $oneleague && $type_opp='0' && qual='2'"));
					
					if(!is_array($fetchq)) {
					    safe_query("UPDATE ".PREFIX."cup_clans SET qual='2' WHERE groupID='$ID' && clanID='".$gap['clanID']."' && $oneleague && $type_opp='0'");
					}      
		  }  
      }
      else{
      
		  if($w_matches) {
				
					$fetchq = mysqli_fetch_array(safe_query("SELECT qual FROM ".PREFIX."cup_clans WHERE groupID='$ID' && clanID='".$gap['clanID']."' && $oneleague && $type_opp='0' && qual='1'"));
					
					if(!is_array($fetchq)) {
                        safe_query("UPDATE ".PREFIX."cup_clans SET qual='1' WHERE groupID='$ID' && clanID='".$gap['clanID']."' && $oneleague && $type_opp='0'");  
                    }
		  }
       }  
    }	  
      
        if(!$is_qualifyers && $ds['gs_trans']) {
        
           if(!$_GET['laddID'])
              safe_query("UPDATE ".PREFIX."cups SET start='".$date_begin_trans."', gs_end='".time()."', ende='".$date_end_trans."', status='1' WHERE ID='$ID'");
           else   
              safe_query("UPDATE ".PREFIX."cup_ladders SET start='".$date_begin_trans."', gs_end='".time()."', end='".$date_end_trans."', status='1' WHERE ID='$ID'");
        } 
      
    }

/* END CHECK QUALIFICATION */



if($ds['gs_staging']==1) {

  if($all_vs_all==true) {
  
        $spec_mc = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchno='$ID' && type='gs' && (clan1='".$gap['clanID']."' || clan2='".$gap['clanID']."') && $type_opp='0'");
        $max_matches = mysqli_num_rows($spec_mc);
	
	if(mysqli_num_rows(safe_query("SELECT ma FROM ".PREFIX."cup_clans WHERE groupID='$ID' && type='gs' && $type_opp='0' && ma='0'"))) {
	    safe_query("UPDATE ".PREFIX."cup_clans SET ma='$max_matches' WHERE groupID='$ID' && type='gs' && $type_opp='0' && ma='0' ");
	}  
  }
  else{
  

        if($ds['maxclan']==8 || $ds['maxclan']==80)
           $max_matches = 4;
        elseif($ds['maxclan']==16 || $ds['maxclan']==160)
           $max_matches = 7;
        elseif($ds['maxclan']==32 || $ds['maxclan']==320)
           $max_matches = 7;
        elseif($ds['maxclan']==64 || $ds['maxclan']==640)
           $max_matches = 7;
  }   
}else
           $max_matches = 1; 
  
    // check qualified
	 
    $check_qualifyers = safe_query("SELECT qual, pm FROM ".PREFIX."cup_clans WHERE groupID='$ID' AND qual='1' AND $type_opp='0' AND $oneleague");
	$cq_fetch = mysqli_fetch_array($check_qualifyers);
    $is_qualifyers = mysqli_num_rows($check_qualifyers);
	 
	if($is_qualifyers) {
	
	    if($gap['qual']==1) {
	        $qualified = '<font color="#00CC00"><b>Qualified</b></font> <img src="images/cup/success.png" align="right">';      	
	    }
	    elseif($gap['qual']==2) {
	        $qualified = '<font color="#FF6600"><b>FCFS</b></font> <img src="images/cup/icons/groups.png" width="16" height="16" align="right">';    
	    }
	    else{
	        $qualified = '<font color="#DD0000"><b>Unqualified</b></font> <img src="images/cup/error.png" width="16" height="16" align="right">';	
	    }
		
		$pos = $l;
		
    } else {
	        $qualified = '(Matches in Progress)';
			$pos = "#";
	}
	
	    $hover_color = $selected_match;
	
        if(participantID_memin_gs($userID,$ID,$type)==$gap['clanID']) {
             $bg_color_dd = $hover_color;
        }
        elseif(is_odd($l)) {
             $bg_color_dd = BG_1;
        }	
	    else{
             $bg_color_dd = BG_2;
	    }
    
      $stats_content.='<tr bgcolor="'.$bg_color_dd.'" onMouseOver="this.style.backgroundColor=\''.$hover_color.'\'" onMouseOut="this.style.backgroundColor=\''.$bg_color_dd.'\'">
	                     <td style="height:27px" align="left">'.$pos.'</td>
                         <td style="height:27px" align="left">'.$flag.'&nbsp;'.getname1($gap['clanID'],$ID,$ac=0,strtolower($name)).'</td>
                         <td style="height:27px" align="center">'.$a_matches.' / '.$max_matches.'</td>
                         <td style="height:27px" align="center"><b>'.$w_matches.'-'.$d_matches.'-'.$l_matches.'</b></td>
                         <td style="height:27px" align="center">'.$ratio.'%</td>
                         <td style="height:27px" align="center">'.$c_points.'</td>
                         <td style="height:27px" align="center">'.strtoupper($gap[$type]).'</td>
                         <td style="height:27px" align="center">'.$qualified.'</td>
                       </tr>';
               $l++;
			   }
		   
			   
    if($is_qualifyers && (($total_qual_fcfs < $total_total) || ($total_qual > $total_total)) && iscupadmin($userID)) 
    $bug_qual = true; else $bug_qual = '';
			   
    if($bug_qual AND $_GET['sync']!='qual') echo '<div class="warningbox"><strong>Admin Notice:</strong> There are too few or more qualifiers found in the database, click <a href="?'.pageURL().'&sync=qual">here</a> to re-sync.</div>';			   

//generate other matches
  
    $ergebnis2 = safe_query("SELECT count(*) as anzahl FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' && $type_opp='0' && type='gs'");
    $dv=mysqli_fetch_array($ergebnis2);
    
    $specchk = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchno='".$ID."' && $type_opp='0' && type='gs' && si='0'");
    $sp=mysqli_fetch_array($specchk);
    
//generate all vs all
	
     if(($ds['gs_staging']==1 && $dv['anzahl'] == $max_participants && $dt2['totalm'] != $total_matches && !is_array($sp) AND $generate_all_vs_all==1) || 
       ((iscupadmin($userID) && isset($_GET['gm']) && $_GET['gm']=='ava') && !is_array($sp)))  {
     
	     $day = date('d');
	     $month = date('m');
	     $year = date('Y');
       	 $hour = date('H');
	     $min = date('i');
     	 $date = @mktime($hour, $min, 0, $month, $day, $year);
		 
		foreach($groups_array as $a) {
		   
		    $var_alpha = ${'rows_'.$a};
			$let_alpha = "$a";

	        if($var_alpha != $max_participants) {
		
                   mysqli_query("INSERT INTO ".PREFIX."cup_matches ($type, $type_opp, matchno, clan1, clan2, comment, 1on1)
                   (SELECT a.$type,
                          a.$type_opp,
                          a.matchno,
                          a.clan1,
                          b.clan2 AS 'versus',
                          a.comment,
                          a.1on1
                   FROM ".PREFIX."cup_matches a
                        JOIN ws_bi2_cup_matches b ON a.$type = b.$type AND b.$type = '$let_alpha' 
                                                           AND b.matchno = '$ID' 
                                                           AND a.clan2 != b.clan2				
                                                           AND b.type = 'gs'
                   WHERE a.matchno = '$ID'
				     AND a.$type_opp = '0'
                     AND a.type = 'gs')
                   UNION
                   (SELECT a.$type,
                          a.$type_opp,
                          a.matchno,
                          a.clan1,
                          b.clan1 AS 'versus',
                          a.comment,
                          a.1on1
                   FROM ".PREFIX."cup_matches a
                        JOIN ws_bi2_cup_matches b ON a.$type = b.$type AND b.$type = '$let_alpha' 
                                                           AND b.matchno = '$ID' 
                                                           AND a.clan1 < b.clan1 
                                                           AND b.type = 'gs'
                   WHERE a.matchno = '$ID'
				     AND a.$type_opp = '0'
                     AND a.type = 'gs')		     
                   UNION
                   (SELECT a.$type,
                          a.$type_opp,
                          a.matchno,
                          a.clan2,
                          b.clan2 AS 'versus',
                          a.comment,
                          a.1on1
                   FROM ".PREFIX."cup_matches a
                        JOIN ws_bi2_cup_matches b ON a.$type = b.$type AND b.$type = '$let_alpha' 
                                                           AND b.matchno = '$ID' 
                                                           AND a.clan2 < b.clan2 
                                                           AND b.type = 'gs'
                   WHERE a.matchno = '$ID'
				     AND a.$type_opp = '0'
                     AND a.type = 'gs')	   
                   ORDER BY clan1 DESC, versus");
	     	}
	    }
		
        $day_le = date('d')+$league_end;
        $month = date('m');
        $year = date('Y');
        $hour = date('H');
        $min = date('i');
        $date_end_trans = @mktime($hour, $min, 0, $month, $day_le, $year);
		 
		if($starttime_gs_auto == 1) {
		 
           if(!$_GET['laddID'])
              safe_query("UPDATE ".PREFIX."cups SET gs_start='".time()."', gs_end='$date_end_trans' WHERE ID='$ID'");
           else   
              safe_query("UPDATE ".PREFIX."cup_ladders SET gs_start='".time()."', gs_end='$date_end_trans' WHERE ID='$ID'");
         }
		 
		 redirect('?site=groups&'.$type2.'='.$ID.'&set=dates', '<img src="images/cup/period_ani.gif">', 0);  
		          
 }
 
// Setting dates

if(isset($_GET['set']) AND $_GET['set']=='dates') {
	
	foreach($groups_array as $a) {
	
	    $sd1=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchno='$ID' AND $type_opp='0' AND type='gs' AND $type = '$a' ORDER BY clan1 ASC, matchID ASC LIMIT 0,1"));
		$sd2=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchno='$ID' AND $type_opp='0' AND type='gs' AND $type = '$a' ORDER BY clan1 ASC, matchID ASC LIMIT 1,1"));
		$sd3=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchno='$ID' AND $type_opp='0' AND type='gs' AND $type = '$a' ORDER BY clan1 ASC, matchID ASC LIMIT 2,1"));
		$sd4=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchno='$ID' AND $type_opp='0' AND type='gs' AND $type = '$a' ORDER BY clan1 ASC, matchID ASC LIMIT 3,1"));
		$sd5=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchno='$ID' AND $type_opp='0' AND type='gs' AND $type = '$a' ORDER BY clan1 ASC, matchID ASC LIMIT 4,1"));
		$sd6=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchno='$ID' AND $type_opp='0' AND type='gs' AND $type = '$a' ORDER BY clan1 ASC, matchID ASC LIMIT 5,1"));
		
		$firstmatch_start = $ds['gs_start'];
		$secondmatch_start = $ds['gs_start'] + (86400 * $ds['gs_mwe']);
		$lastmatch_start = $ds['gs_start'] + (172800 * $ds['gs_mwe']);
		
		safe_query("UPDATE ".PREFIX."cup_matches SET date='".$firstmatch_start."' WHERE matchID='".$sd1['matchID']."'");
		safe_query("UPDATE ".PREFIX."cup_matches SET date='".$secondmatch_start."' WHERE matchID='".$sd2['matchID']."'");
		safe_query("UPDATE ".PREFIX."cup_matches SET date='".$lastmatch_start."' WHERE matchID='".$sd3['matchID']."'");
		safe_query("UPDATE ".PREFIX."cup_matches SET date='".$secondmatch_start."' WHERE matchID='".$sd4['matchID']."'");
		safe_query("UPDATE ".PREFIX."cup_matches SET date='".$firstmatch_start."' WHERE matchID='".$sd5['matchID']."'");
		safe_query("UPDATE ".PREFIX."cup_matches SET date='".$lastmatch_start."' WHERE matchID='".$sd6['matchID']."'");
	
	}   
	redirect('?site=groups&'.$type2.'='.$ID, '<font color="red"><strong>Matches generated!</strong></font>', 3);
}

//registration to group stages
        
  if(isset($_GET['action']) && $_GET['action'] == 'register') {   
                 
	    $day = date('d');
	    $month = date('m');
	    $year = date('Y');
        $hour = date('H');
	    $min = date('i');
        $date = @mktime($hour, $min, 0, $month, $day, $year);
     	 
		$ergebnis2 = safe_query("SELECT count(*) as anzahl FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type_opp='0' AND type='gs'");
		$dv=mysqli_fetch_array($ergebnis2);
		
//register validations

        $get_group = isset($_GET['group']) ? $_GET['group'] : false;
 
		if(!$userID)
		    echo $_language->module['not_loggedin'];
		elseif(!$name2($ID) && !$_GET['clanID'])   
		    echo $_language->module['invalid_team'].$style3."</div>";
	    elseif($ds['status']!=1)
		    echo 'Group stages is not on sign-up phase.';	     
	    elseif(isgroupparticipant($userID,$ID))
		    echo $_language->module['already_participant'].' <b>'.strtoupper(returnGroup($userID,$ID)).'</b>.'.$style3.'</div>';
		elseif($dv['anzahl'] >= $ds['maxclan']+$ds['maxclan'])
		    echo $_language->module['too_much_teams']; 
		elseif($a_rows == 4 AND $get_group=="a")
		    echo 'Sorry group A is already filled up.';  
		elseif($b_rows == 4 AND $get_group=="b")
		    echo 'Sorry group B is already filled up.';  
		elseif($c_rows == 4 AND $get_group=="c")
		    echo 'Sorry group C is already filled up.';  
		elseif($d_rows == 4 AND $get_group=="d")
		    echo 'Sorry group D is already filled up.';  
		elseif($e_rows == 4 AND $get_group=="e")
		    echo 'Sorry group E is already filled up.';  
		elseif($f_rows == 4 AND $get_group=="f")
		    echo 'Sorry group F is already filled up.';  
		elseif($g_rows == 4 AND $get_group=="g")
		    echo 'Sorry group G is already filled up.';  
		elseif($h_rows == 4 AND $get_group=="h")
		    echo 'Sorry group H is already filled up.';  
		elseif($i_rows == 4 AND $get_group=="i")
		    echo 'Sorry group I is already filled up.';  
		elseif($j_rows == 4 AND $get_group=="j")
		    echo 'Sorry group J is already filled up.';  
		elseif($k_rows == 4 AND $get_group=="k")
		    echo 'Sorry group K is already filled up.';  
		elseif($l_rows == 4 AND $get_group=="l")
		    echo 'Sorry group L is already filled up.';  
		elseif($m_rows == 4 AND $get_group=="m")
		    echo 'Sorry group M is already filled up.';  
		elseif($n_rows == 4 AND $get_group=="n")
		    echo 'Sorry group N is already filled up.';  
		elseif($o_rows == 4 AND $get_group=="o")
		    echo 'Sorry group O is already filled up.';  
		elseif($p_rows == 4 AND $get_group=="p")
		    echo 'Sorry group P is already filled up.';  
		elseif($q_rows == 4 AND $get_group=="q")
		    echo 'Sorry group Q is already filled up.';  
		elseif($r_rows == 4 AND $get_group=="r")
		    echo 'Sorry group R is already filled up.';  
		elseif($s_rows == 4 AND $get_group=="s")
		    echo 'Sorry group S is already filled up.';  
		elseif($t_rows == 4 AND $get_group=="t")
		    echo 'Sorry group T is already filled up.';  
		elseif($u_rows == 4 AND $get_group=="u")
		    echo 'Sorry group U is already filled up.';  
		elseif($v_rows == 4 AND $get_group=="v")
		    echo 'Sorry group V is already filled up.';  
		elseif($w_rows == 4 AND $get_group=="w")
		    echo 'Sorry group W is already filled up.';  
		elseif($x_rows == 4 AND $get_group=="x")
		    echo 'Sorry group X is already filled up.';  
		elseif($y_rows == 4 AND $get_group=="y")
		    echo 'Sorry group Y is already filled up.';  
		elseif($z_rows == 4 AND $get_group=="z")
		    echo 'Sorry group Z is already filled up.';  
		elseif($a2_rows == 4 AND $get_group=="a2")
		    echo 'Sorry group A2 is already filled up.';  
		elseif($b2_rows == 4 AND $get_group=="b2")
		    echo 'Sorry group B2 is already filled up.';  
		elseif($c2_rows == 4 AND $get_group=="c2")
		    echo 'Sorry group C2 is already filled up.';  
		elseif($d2_rows == 4 AND $get_group=="d2")
		    echo 'Sorry group D2 is already filled up.';  
		elseif($e2_rows == 4 AND $get_group=="e2")
		    echo 'Sorry group E2 is already filled up.';  
		elseif($f2_rows == 4 AND $get_group=="f2")
		     echo 'Sorry group F2 is already filled up.';  
	elseif($ds['status']==1 && $ds['gs_start'] > time()) {
	
   if($name2($ID)) {
          
             if($ds['gs_regtype']) {
                safe_query("INSERT INTO ".PREFIX."cup_clans (`$type`, $plat `groupID`, `clanID`, `1on1`, `type`) VALUES ('".$_GET['group']."', $platID '$ID', '$userID', '1','gs')");
                  if(mysqli_num_rows(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE $type='".$_GET['group']."' AND matchno='$ID' AND clan1!='0' AND clan2='0'"))) {
                     safe_query("UPDATE ".PREFIX."cup_matches SET clan2='$userID' WHERE $type='".$_GET['group']."' AND matchno='$ID' AND clan2='0'"); 
                     redirect('?site=groups&'.$type2.'='.$ID.'', '<div class="successbox">Successfully registered in <b>Group '.strtoupper($_GET['group']).'</b>!</div>', 2);         
                  }else{ 
                     safe_query("INSERT INTO ".PREFIX."cup_matches (`$type`, `$type_opp`, `date`, `matchno`, `clan1`, `comment`, `1on1`, `si`, `type`) VALUES ('".$_GET['group']."', '0', '$date', '$ID', '$userID', '2', '1', '1','gs')");
                     redirect('?site=groups&'.$type2.'='.$ID.'', '<div class="successbox">Successfully registered in <b>Group '.strtoupper($_GET['group']).'</b>!</div>', 2);
                  }
             }else{
             
                safe_query("INSERT INTO ".PREFIX."cup_clans (`$type`, $plat `groupID`, `clanID`, `1on1`, `type`) VALUES ('$random_group', $platID '$ID', '$userID', '1','gs')");
                  if(mysqli_num_rows(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE $type='$random_group' AND matchno='$ID' AND clan1!='0' AND clan2='0'"))) {
                     safe_query("UPDATE ".PREFIX."cup_matches SET clan2='$userID' WHERE $type='$random_group' AND matchno='$ID' AND clan2='0'"); 
                     redirect('?site=groups&'.$type2.'='.$ID.'', '<div class="successbox">Successfully registered in  <b>Group '.strtoupper($random_group).'</b>!</div>', 2);
                  }else{
                     safe_query("INSERT INTO ".PREFIX."cup_matches (`$type`, `$type_opp`, `date`, `matchno`, `clan1`, `comment`, `1on1`, `si`, `type`) VALUES ('$random_group', '0', '$date', '$ID', '$userID', '2', '1', '1','gs')"); 
                     redirect('?site=groups&'.$type2.'='.$ID.'', '<div class="successbox">Successfully registered in  <b>Group '.strtoupper($random_group).'</b>!</div>', 2);
                  }
             }
             
          }else{
          
           $clanID = $_GET['clanID'];
          
             if(!isleader($userID,$clanID)) 
                echo 'You are not the leader';
                
             elseif($ds['gs_regtype']) {
                safe_query("INSERT INTO ".PREFIX."cup_clans (`$type`, $plat `groupID`, `clanID`, `1on1`, `type`) VALUES ('".$_GET['group']."', $platID '$ID', '$clanID', '0', 'gs')");
                  if(mysqli_num_rows(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE $type='".$_GET['group']."' AND matchno='$ID' AND clan1!='0' AND clan2='0'"))) {
                     safe_query("UPDATE ".PREFIX."cup_matches SET clan2='$clanID' WHERE $type='".$_GET['group']."' AND matchno='$ID' AND clan2='0'"); 
                     redirect('?site=groups&'.$type2.'='.$ID.'', '<div class="successbox">Successfully registered in <b>Group '.strtoupper($_GET['group']).'</b>!</div>', 2);         
                  }else{ 
                     safe_query("INSERT INTO ".PREFIX."cup_matches (`$type`, `$type_opp`, `date`, `matchno`, `clan1`, `comment`, `1on1`, `si`, `type`) VALUES ('".$_GET['group']."', '0', '$date', '$ID', '$clanID', '2', '0', '1','gs')");
                     redirect('?site=groups&'.$type2.'='.$ID.'', '<div class="successbox">Successfully registered in <b>Group '.strtoupper($_GET['group']).'</b>!</div>', 2);
                  }
             }else{
             
                safe_query("INSERT INTO ".PREFIX."cup_clans (`$type`, $plat `groupID`, `clanID`, `1on1`, `type`) VALUES ('$random_group', $platID '$ID', '$clanID', '0','gs')");
                  if(mysqli_num_rows(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE $type='$random_group' AND matchno='$ID' AND clan1!='0' AND clan2='0'"))) {
                     safe_query("UPDATE ".PREFIX."cup_matches SET clan2='$clanID' WHERE $type='$random_group' AND matchno='$ID' AND clan2='0'"); 
                     redirect('?site=groups&'.$type2.'='.$ID.'', '<div class="successbox">Successfully registered in  <b>Group '.strtoupper($random_group).'</b>!</div>', 2);
                  }else{
                     safe_query("INSERT INTO ".PREFIX."cup_matches (`$type`, `$type_opp`, `date`, `matchno`, `clan1`, `comment`, `1on1`, `si`,`type`) VALUES ('$random_group', '0', '$date', '$ID', '$clanID', '2', '0', '1','gs')"); 
                     redirect('?site=groups&'.$type2.'='.$ID.'', '<div class="successbox">Successfully registered in  <b>Group '.strtoupper($random_group).'</b>!</div>', 2);
                 }
               }
             }
           }else echo 'You can only register in between the start time and end time. (Times available in overview above)';
         } 
       
       $cup = safe_query("SELECT max(ID) as maxcupID FROM ".PREFIX."cups");
       $cID = mysqli_fetch_array($cup);

$action = isset($_GET['action']) ? $_GET['action'] : false;
	   
if(isset($_GET['clanID']) AND $action != "register") {
 
   echo '<div '.$error_box.'> Showing matches for '.getname1($_GET['clanID'],$ID,0,strtolower($name)).' (<a href="?site=groups&'.$type2.'='.$ID.'">Show All</a> | <a href="javascript:history.go(-1);">Go Back</a>)</div> ';
   $sh_cl_onl = "&& (clan1='".$_GET['clanID']."' || clan2='".$_GET['clanID']."')";
}
else{
   $sh_cl_onl = '';
}
    
	$no = 1;
	$groupa = '';
	$groupb = '';
	$groupc = '';
	$groupd = '';
	$groupe = '';
	$groupf = '';
	$groupg = '';
	$grouph = '';
	$groupi = '';
	$groupj = '';
	$groupk = '';
	$groupl = '';
	$groupm = '';
	$groupn = '';
	$groupo = '';
	$groupp = '';
	$groupq = '';
	$groupr = '';
	$groups = '';
	$groupt = '';
	$groupu = '';
	$groupv = '';
	$groupw = '';
	$groupx = '';
	$groupy = '';
	$groupz = '';
	$groupa2 = '';
	$groupb2 = '';
	$groupc2 = '';
	$groupd2 = '';
	$groupe2 = '';
	$groupf2 = '';	
	
    $participants = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchno='$ID' && type='gs' && $type_opp='0' $sh_cl_onl $group_show_only ORDER BY clan1 ASC, matchID ASC"); 
        while($dd=mysqli_fetch_array($participants)) {
		
        if(!$dd['clan2']) {
           $status3 = '<font color="#FF6600"><b>WAITING PLAYER 2</b></font>';
		   $wait = true;
           $clan2 = '<a style="text-decoration:none; cursor:help" onmouseover="showWMTT(\'waiting_player2\')" onmouseout="hideWMTT()">--</a>';
        }else{
           $clan2 = getname1($dd['clan2'],$ID,$ac=0,strtolower($name));
		   $wait = false;
        }
    if($dd['clan1'] && $dd['clan2'])
                $status3 = '<a href="?site=cup_matches&match='.$dd['matchID'].'&'.$type2.'='.$ID.'&type=gs"><img border="0" src="images/icons/foldericons/folder.gif" align="right"></a>';
   
    if($name2($ID)) {
            
        if(!$dd['score1'] && !$dd['score2'] && !$dd['einspruch'] && $loggedin && $userID == $dd['clan1'] && $dd['clan2'])
                $status2='&nbsp;<a href="?site=cupactions&amp;action=score&matchID='.$dd['matchID'].'&amp;clan1='.$dd['clan1'].'&amp;'.$type2.'='.$ID.'&one=1&type=group"><strong>Add Result</strong></a>';
            
        elseif(!$dd['score1'] && !$dd['score2'] && !$dd['einspruch'] && $loggedin && $userID == $dd['clan2'] && $dd['clan1']) 
                $status2='&nbsp;<a href="?site=cupactions&amp;action=score&matchID='.$dd['matchID'].'&amp;clan1='.$dd['clan2'].'&amp;'.$type2.'='.$ID.'&one=1&type=group"><strong>Add Result</strong></a>';
           
        elseif(($dd['score1'] || $dd['score2']) && $dd['inscribed']==$dd['clan2'] && !$dd['einspruch'] && $dd['confirmscore']==0 && $userID == $dd['clan1'])
                $status2='&nbsp;<a href="?site=cupactions&amp;action=confirmscore&amp;matchID='.$dd['matchID'].'&amp;clanID='.$dd['clan1'].'&amp;groupID='.$ID.'&one=1&type=group"><img border="0" src="images/cup/icons/agreed.gif" border="0" align="right"></a> 
                                <a href="?site=cupactions&amp;action=protest&amp;matchID='.$dd['matchID'].'&clanID=onecup&'.$type2.'='.$ID.'" onclick="return confirm(\'Are you sure there was something wrong with the match?\');"><img border="0" src="images/cup/icons/protest.gif" align="right"></a>';
                     
        elseif(($dd['score1'] || $dd['score2']) && $dd['inscribed']==$dd['clan1'] && !$dd['einspruch'] && $dd['confirmscore']==0 && $userID == $dd['clan2'])
                $status2='&nbsp;<a href="?site=cupactions&amp;action=confirmscore&amp;matchID='.$dd['matchID'].'&amp;clanID='.$dd['clan2'].'&amp;groupID='.$ID.'&one=1&type=group"><img border="0" src="images/cup/icons/agreed.gif" border="0" align="right"></a> 
                                <a href="?site=cupactions&amp;action=protest&amp;matchID='.$dd['matchID'].'&clanID=onecup&'.$type2.'='.$ID.'" onclick="return confirm(\'Are you sure there was something wrong with the match?\');"><img border="0" src="images/cup/icons/protest.gif" align="right"></a>';
       
        elseif($dd['confirmscore'] == '0' && $dd['inscribed']==$dd['clan1'] && !$dd['einspruch'] && $dd['clan1'] && $dd['clan2']) 
                $status2='<font color="'.$drawcolor.'"><strong>Result Pending</font>';      

        elseif($dd['confirmscore'] == '0' && $dd['inscribed']==$dd['clan2'] && !$dd['einspruch'] && $dd['clan1'] && $dd['clan2']) 
                $status2='<font color="'.$drawcolor.'"><strong>Result Pending</strong></font>';           
  
        elseif(!$dd['score1'] AND !$dd['score2']) 
                $status2='<font color="'.$drawcolor.'"><strong>Match Pending</strong></font>';
                
        elseif($dd['confirmscore']=='1' && $dd['einspruch']=='0')
                $status2='<strong>Match Finished</strong>';
                
        elseif($dd['einspruch'])
                $status2='<font color="'.$loosecolor.'"><strong>Match Protest</strong></font>';
        else
                $status2='<font color="'.$loosecolor.'"><strong>Match Closed</strong></font>';

    }else{
    
        if(!$dd['score1'] && !$dd['score2'] && !$dd['einspruch'] && isleader($userID,$dd['clan1']) && $dd['clan2'])
                $status2='&nbsp;<a href="?site=cupactions&amp;action=score&matchID='.$dd['matchID'].'&amp;clan1='.$dd['clan1'].'&amp;'.$type2.'='.$ID.'&type=group"><strong>Add Result</strong></a>';
            
        elseif(!$dd['score1'] && !$dd['score2'] && !$dd['einspruch'] && isleader($userID,$dd['clan2']) && $dd['clan1'])
                $status2='&nbsp;<a href="?site=cupactions&amp;action=score&matchID='.$dd['matchID'].'&amp;clan1='.$dd['clan2'].'&amp;'.$type2.'='.$ID.'&type=group"><strong>Add Result</strong></a>';
    
        elseif(($dd['score1'] || $dd['score2']) && $dd['inscribed']==$dd['clan2'] && !$dd['einspruch'] && $dd['confirmscore']==0 && isleader($userID,$dd['clan1']))
                $status2='&nbsp;<a href="?site=cupactions&amp;action=confirmscore&amp;matchID='.$dd['matchID'].'&amp;clanID='.$dd['clan1'].'&amp;groupID='.$ID.'&type=group"><img border="0" src="images/cup/icons/agreed.gif" border="0" align="right"></a> 
                                <a href="?site=cupactions&amp;action=protest&amp;matchID='.$dd['matchID'].'&clanID='.$dd['clan1'].'&'.$type2.'='.$ID.'" onclick="return confirm(\'Are you sure there was something wrong with the match?\');"><img border="0" src="images/cup/icons/protest.gif" align="right"></a>';
                     
        elseif(($dd['score1'] || $dd['score2']) && $dd['inscribed']==$dd['clan1'] && !$dd['einspruch'] && $dd['confirmscore']==0 && isleader($userID,$dd['clan2']))
                $status2='&nbsp;<a href="?site=cupactions&amp;action=confirmscore&amp;matchID='.$dd['matchID'].'&amp;clanID='.$dd['clan2'].'&amp;groupID='.$ID.'&type=group"><img border="0" src="images/cup/icons/agreed.gif" border="0" align="right"></a> 
                                <a href="?site=cupactions&amp;action=protest&amp;matchID='.$dd['matchID'].'&clanID='.$dd['clan2'].'&'.$type2.'='.$ID.'" onclick="return confirm(\'Are you sure there was something wrong with the match?\');"><img border="0" src="images/cup/icons/protest.gif" align="right"></a>';
                     
        elseif($dd['confirmscore'] == '0' && $dd['inscribed']==$dd['clan1'] && !$dd['einspruch'] && $dd['clan1'] && $dd['clan2']) 
                $status2='<font color="'.$drawcolor.'"><strong>Result Pending</font>';    
                
        elseif($dd['confirmscore'] == '0' && $dd['inscribed']==$dd['clan2'] && !$dd['einspruch'] && $dd['clan1'] && $dd['clan2']) 
                $status2='<font color="'.$drawcolor.'"><strong>Result Pending</strong></font>'; 
                
        elseif(!$dd['score1'] AND !$dd['score2']) 
                $status2='<font color="'.$drawcolor.'"><strong>Match Pending</strong></font>';
                
        elseif($dd['confirmscore']=='1' && $dd['einspruch']=='0')
                $status2='<strong>Match Finished</strong>';
                
        elseif($dd['einspruch'])
                $status2='<font color="'.$loosecolor.'"><strong>Match Protest</strong></font>';
        else
                $status2='<font color="'.$loosecolor.'"><strong>Match Closed</strong></font>';
		
		
		if($wait == true) {
		    $status2 = '';
		}
    
    }
        
    if($name2($ID) && ($userID == $dd['clan1'] || $userID == $dd['clan2'])) {
       $color = $border; 
    }elseif($name2($ID)) {
       $color = $bg1;
    }
       
    if(!$name2($ID) && (isleader($userID,$dd['clan1']) || isleader($userID,$dd['clan2']))) {
       $color = $border;
    }elseif(!$name2($ID)) {
       $color = $bg1;
    }
       
    if($name2($ID)) {
       $flag1 = getusercountry2($dd['clan1']);
       $flag2 = getusercountry($dd['clan2']);
    }else{
       $flag1 = getclancountry4($dd['clan1']);
       $flag2 = getclancountry1($dd['clan2']);
    } 
    
    $ds1=mysqli_fetch_array(safe_query("SELECT SUM(score1) as wonpoints FROM ".PREFIX."cup_matches WHERE matchno='$ID' && clan1='".$dd['clan1']."' && ($alpha_groups) && score1 > score2 ORDER BY score1 LIMIT 0,$limit"));
    $ds2=mysqli_fetch_array(safe_query("SELECT SUM(score2) as wonpoints FROM ".PREFIX."cup_matches WHERE matchno='$ID' && clan2='".$dd['clan2']."' && ($alpha_groups) && score1 < score2 ORDER BY score1 LIMIT 0,$limit"));

	if(isset($_GET['match']) && $_GET['match']==$dd['matchID'] && !isset($_GET['ID'])){
	redirect('?site=groups&'.$type2.'='.$ID.'&match='.$dd['matchID'].'&ID=#'.$dd['matchID'], '', 0); }
	 
    if($dd['confirmscore']) {
       $score_p1 = $dd['score1'];
       $score_p2 = $dd['score2'];
    }else{
       $score_p1 = 0;
       $score_p2 = 0;
    }
	
        $hover_color = $selected_match;

        if((participantID_memin_gs($userID,$ID,$type)==$dd['clan1'] OR participantID_memin_gs($userID,$ID,$type)==$dd['clan2']) OR (isset($_GET['match']) && $_GET['match']==$dd['matchID'])) {
             $bg_color_dd = $hover_color;
        }
        elseif(is_odd($no)) {
             $bg_color_dd = BG_1;
        }	
	    else{
             $bg_color_dd = BG_2;
	    }
		

      $data_table = '<tr bgcolor="'.$bg_color_dd.'" onMouseOver="this.style.backgroundColor=\''.$hover_color.'\'" onMouseOut="this.style.backgroundColor=\''.$bg_color_dd.'\'">
	                   <td style="height:27px;" width="15%" align="left"><Strong>'.date('d M, H:i', $dd['date']).'</strong></td>
                       <td style="height:27px;" width="20%" align="right"><a name="'.$dd['matchID'].'"></a>'.getname1($dd['clan1'],$ID,$ac=0,strtolower($name)).'</td>
                       <td style="height:27px;" width="20%" align="center">'.$flag1.' <strong>'.$score_p1.' - '.$score_p2.'</strong> '.$flag2.'</td>
                       <td style="height:27px;" width="20%" align="left">'.$clan2.'</td>
					   <td style="height:27px;" width="15%" align="center">'.$status2.'</td>
		               <td style="height:27px;" width="10%" align="right">'.$status3.'</td>
                     </tr>';        

        
        if($dd[$type]=='a') {  
           $groupa.= $data_table;    
        }if($dd[$type]=='b') {
           $groupb.= $data_table;                  
        }if($dd[$type]=='c') {  
           $groupc.= $data_table;                  
        }if($dd[$type]=='d') { 
           $groupd.= $data_table;                  
        }if($dd[$type]=='e') {
           $groupe.= $data_table;                  
        }if($dd[$type]=='f') { 
           $groupf.= $data_table;                  
        }if($dd[$type]=='g') {    
           $groupg.= $data_table;                  
        }if($dd[$type]=='h') {   
           $grouph.= $data_table;                  
        }if($dd[$type]=='i') {   
           $groupi.= $data_table;                  
        }if($dd[$type]=='j') {   
           $groupj.= $data_table;                  
        }if($dd[$type]=='k') {   
           $groupk.= $data_table;                  
        }if($dd[$type]=='l') {   
           $groupl.= $data_table;                  
        }if($dd[$type]=='m') {   
           $groupm.= $data_table;                  
        }if($dd[$type]=='n') {   
           $groupn.= $data_table;                  
        }if($dd[$type]=='o') {   
           $groupo.= $data_table;                  
        }if($dd[$type]=='p') {   
           $groupp.= $data_table;                  
        }if($dd[$type]=='q') {   
           $groupq.= $data_table;                  
        }if($dd[$type]=='r') {   
           $groupr.= $data_table;                  
        }if($dd[$type]=='s') {   
           $groups.= $data_table;                  
        }if($dd[$type]=='t') {   
           $groupt.= $data_table;                  
        }if($dd[$type]=='u') {   
           $groupu.= $data_table;                  
        }if($dd[$type]=='v') {   
           $groupv.= $data_table;                  
        }if($dd[$type]=='w') {   
           $groupw.= $data_table;                  
        }if($dd[$type]=='x') {   
           $groupx.= $data_table;                  
        }if($dd[$type]=='y') {   
           $groupy.= $data_table;                  
        }if($dd[$type]=='z') {   
           $groupz.= $data_table;                                    
        }if($dd[$type]=='a2') {   
           $groupa2.= $data_table;                  
        }if($dd[$type]=='b2') {   
           $groupb2.= $data_table;                  
        }if($dd[$type]=='c2') {   
           $groupc2.= $data_table;                  
        }if($dd[$type]=='d2') {   
           $groupd2.= $data_table;                  
        }if($dd[$type]=='e2') {   
           $groupe2.= $data_table;                  
        }if($dd[$type]=='f2') {   
           $groupf2.= $data_table;                  
        }
           
        $no++;      
      } 
      
      if($name2($ID)) $participant = 'Player';
      else $participant = 'Team';
	  
          $table = '<tr>
		              <td class="title2" align="left" style="height:27px;">Match Date</td>
                      <td class="title2" align="right" style="height:27px;">'.$participant.' 1</td>
					  <td class="title2" align="center" style="height:27px;"></td>
					  <td class="title2" align="left" style="height:27px;">'.$participant.' 2</td>
					  <td class="title2" align="center" style="height:27px;">Status</td>
					  <td class="title2" align="right" style="height:27px;"></td>
                    </tr>';	

      if(isset($_GET['group'])) {
          echo '<div class="infobox">Viewing Group '.strtoupper($_GET['group']).' - <a href="?site=groups&'.$type2.'='.$ID.'">View All</a></div>';
      }	  
					
      if($ent_part) { 
	  
		if($ds['maxclan']==8 || $ds['maxclan']==80) {

            echo '<table width="100%" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'" bgcolor="'.$border.'">
                    <tr>';
                    
		  if($a_rows) {
            echo ' 
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=a"><strong>Group A</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupa;
		  }if($b_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=b"><strong>Group B</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupb; 
		  }if($c_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=c"><strong>Group C</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupc; 
		  }if($d_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=d"><strong>Group D</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupd; 
                   
		  }if($show_matchstats || ($finished && !$show_matchstats))
		  
            echo $stats_table.$stats_content;
            echo '</table>';
            
		}elseif($ds['maxclan']==16 || $ds['maxclan']==160) {	
            echo '<table width="100%" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'" bgcolor="'.$border.'">
                    <tr>';
                    
		  if($a_rows) {
            echo ' 
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=a"><strong>Group A</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupa.'';
		  }if($b_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=b"><strong>Group B</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupb.''; 
		  }if($c_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=c"><strong>Group C</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupc.''; 
		  }if($d_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=d"><strong>Group D</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupd.''; 
		  }if($e_rows) {
            echo ' 
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=e"><strong>Group E</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupe.'';
		  }if($f_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=f"><strong>Group F</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupf.''; 
		  }if($g_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=g"><strong>Group G</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupg.''; 
		  }if($h_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=h"><strong>Group H</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$grouph.''; 
 
		  }if($show_matchstats || ($finished && !$show_matchstats))
		  
            echo $stats_table.$stats_content;
            echo '</table>';
      }elseif($ds['maxclan']==32 || $ds['maxclan']==320) {	
            echo '<table width="100%" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'" bgcolor="'.$border.'">
                    <tr>';
                    
		  if($a_rows) {
            echo ' 
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=a"><strong>Group A</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupa.'';
		  }if($b_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=b"><strong>Group B</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupb.''; 
		  }if($c_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=c"><strong>Group C</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupc.''; 
		  }if($d_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=d"><strong>Group D</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupd.''; 
		  }if($e_rows) {
            echo ' 
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=e"><strong>Group E</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupe.'';
		  }if($f_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=f"><strong>Group F</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupf.''; 
		  }if($g_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=g"><strong>Group G</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupg.''; 
		  }if($h_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=h"><strong>Group H</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$grouph.''; 
		  }if($i_rows) {
            echo ' 
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=i"><strong>Group I</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupi.'';
		  }if($j_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=j"><strong>Group J</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupj.''; 
		  }if($k_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=m"><strong>Group K</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupk.''; 
		  }if($l_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=l"><strong>Group L</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupl.''; 
		  }if($m_rows) {
            echo ' 
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=m"><strong>Group M</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupm.'';
		  }if($n_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=n>Group N</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupn.''; 
		  }if($o_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=o"><strong>Group O</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupo.''; 
		  }if($p_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=p"><strong>Group P</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupp.''; 
 
		  }if($show_matchstats || ($finished && !$show_matchstats))
		  
            echo $stats_table.$stats_content;
            echo '</table>';
      }elseif($ds['maxclan']==64 || $ds['maxclan']==640) {	
            echo '<table width="100%" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'" bgcolor="'.$border.'">
                    <tr>';
                    
		  if($a_rows) {
            echo ' 
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=a"><strong>Group A</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupa.'';
		  }if($b_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=b"><strong>Group B</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupb.''; 
		  }if($c_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=c"><strong>Group C</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupc.''; 
		  }if($d_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=d"><strong>Group D</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupd.''; 
		  }if($e_rows) {
            echo ' 
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=e"><strong>Group E</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupe.'';
		  }if($f_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=f"><strong>Group F</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupf.''; 
		  }if($g_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=g"><strong>Group G</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupg.''; 
		  }if($h_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=h"><strong>Group H</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$grouph.''; 
		  }if($i_rows) {
            echo ' 
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=i"><strong>Group I</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupi.'';
		  }if($j_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=j"><strong>Group J</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupj.''; 
		  }if($k_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=k"><strong>Group K</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupk.''; 
		  }if($l_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=l"><strong>Group L</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupl.''; 
		  }if($m_rows) {
            echo ' 
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=m"><strong>Group M</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupm.'';
		  }if($n_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=n"><strong>Group N</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupn.''; 
		  }if($o_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=o"><strong>Group O</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupo.''; 
		  }if($p_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=p"><strong>Group P</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupp.''; 
 
		  }
		  if($q_rows) {
            echo ' 
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=q"><strong>Group Q</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupq.'';
		  }if($r_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=r"><strong>Group R</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupr.''; 
		  }if($s_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=s"><strong>Group S</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groups.''; 
		  }if($t_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=t"><strong>Group T</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupt.''; 
		  }if($u_rows) {
            echo ' 
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=u"><strong>Group U</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupu.'';
		  }if($v_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=v"><strong>Group V</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupv.''; 
		  }if($w_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=w"><strong>Group W</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupw.''; 
		  }if($x_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=x"><strong>Group X</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupx.''; 
		  }if($y_rows) {
            echo ' 
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=y"><strong>Group Y</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupy.'';
		  }if($z_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=z"><strong>Group Z</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupz.''; 
		  }if($a2_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=a2"><strong>Group A2</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupa2.''; 
		  }if($b2_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=b2"><strong>Group B2</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupb2.''; 
		  }if($c2_rows) {
            echo ' 
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=c2"><strong>Group C2</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupc2.'';
		  }if($d2_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=d2"><strong>Group D2</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupd2.''; 
		  }if($e2_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=e2"><strong>Group E2</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupe2.''; 
		  }if($f2_rows) {
            echo ' 
                    <tr>
                      <td class="title" colspan="8"><img src="images/cup/icons/go.png"> <a href="?site=groups&'.$type2.'='.$ID.'&group=f2"><strong>Group F2</strong></a></td>
                    </tr>
                   '.$table.'
                   '.$groupf2.''; 
 
		  }if($show_matchstats || ($finished && !$show_matchstats))
		  
            echo $stats_table.$stats_content;
            echo '</table>';
      }    
	    
   }echo ($cpr ? ca_copyr() : die());
    
 }else //end if ID
     redirect('?site=cups', '', 0);

?>