<?php

if(isset($_GET['ladderID']) || isset($_GET['ID']) || isset($_GET['laddID']))
{

  $action = isset($_GET['action']) ? $_GET['action'] : false;

  if(isset($_GET['ladderID'])){
     $s_active = 'active" style="margin-left:0px;"';
     $id = $_GET['ladderID'];
  }
  elseif($action=='show'){
     $r_active = 'active" style="margin-left:0px;"';
     $id = $_GET['laddID'];
  }
  elseif($action=='rules'){
     $r_active = 'active" style="margin-left:0px;"';
     $id = $_GET['ID'];
  }
  elseif(isset($_GET['ID'])) {
     $d_active = 'active" style="margin-left:0px;"';
     $id = $_GET['ID'];
  }
  elseif($action=='newchallenge' || $action=='viewchallenge'){
     $c_active = 'active" style="margin-left:0px;"';
     $id = $_GET['laddID'];
  }
  elseif(($action=='viewmatches' && $_GET['clanID'] && $_GET['laddID']) || ($action=='report' || $action=='confirmscore')){
     $mr_active = 'active" style="margin-left:0px;"';
     $id = $_GET['laddID'];    
  }
  elseif($action=='viewmatches' || $_GET['site']=='cup_matches'){
     $ma_active = 'active" style="margin-left:0px;"';
     $id = $_GET['laddID'];
  }
  elseif($_GET['site']=='groups'){
     $g_active = 'active" style="margin-left:0px;"';
     $id = $_GET['laddID']; 
  }
  
  $title_cuptype = (ladderis1on1($id) ? '&type=1' : '');
  
  $stl=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_ladders WHERE ID='$id'"));
  
  if($stl['gs_start'] || $stl['gs_end'])  {
     $groups_tit = '<td class="title"><img border="0" src="images/cup/icons/groups.png"> <a class="titlelink" href="?site=groups&laddID='.$id.'">Groups</a></td>';
  } 
  
  if(isladparticipant($userID,$id,$checkin=0)){  
     $alt = '<a href="index.php?site=matches&action=viewmatches&clanID='.participantID($userID,$id).'&laddID='.$id.$title_cuptype.'">Reporting</a>';
  }
  else
  {
     //Ladder registration
     
     if(!$loggedin)
     {
         $signup = 'Login';
         $link = '?site=login';
     }
     else
     {
         $signup = 'Sign-Up';
         $link = '?site=quicknavi&type=ladders&cup='.getalphaladname($id);
     }
     
     $alt = '<a href="'.$link.'">'.$signup.'</a>';
  }
}
     if($stl['challallow']!=1 && isladparticipant($userID,$id,0)) {
        $chall_titl = '<td class="title">&nbsp;<img border="0" src="images/cup/icons/challenge.gif" width="16" height="16">&nbsp;<a class="titlelink" href="?site=standings&action=newchallenge&laddID='.$id.'">Challenge</a></td>';
     }
	 
	 $parti_clanID = getparticipantID($userID,$id);
	 if($parti_clanID) $sh_ext_id = "&clanID=$parti_clanID";

      $checked = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE clanID='$parti_clanID' && ladID='$id' && 1on1='0' && checkin='1'");
      $checkedinlined=mysql_num_rows($checked); 				  
	 
           if(!ladderis1on1($id)) 
           {
              
           $teams = safe_query("SELECT * FROM ".PREFIX."cup_clan_members WHERE userID='$userID'");
               while($te=mysql_fetch_array($teams))
                {             
                    if(mysql_num_rows(safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE clanID='".$te['clanID']."' && 1on1='0' && ladID='$id'")))
                    {
                       $mylineup = '<td class="title"><img border="0" src="images/cup/icons/random.png" width="16" height="16"> <a class="titlelink" href="?site=ladders&action=lineup&ID='.$id.$sh_ext_id.'">Lineup</a></td>';  
                 }
              }             
           }
		   
	if(!isset($groups_tit))
	$groups_tit = '';
	
	if(!isset($tit_gs))
	$tit_gs = '';
	
	if(!isset($mylineup))
	$mylineup = '';
          
     eval ("\$title_ladder = \"".gettemplate("title_ladder")."\";");
     echo $title_ladder;
?>