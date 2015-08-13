<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <script src="js/jquery-1.3.2.js"></script>
    <script src="js/jquery.jgrowl.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jquery.jgrowl.css"/>
		<style type="text/css">			
			div.jGrowl div.iphone {
				font-family: 			"Helvetica Neue", "Helvetica";
				font-size: 				12px;
				background: 			url(images/cup/iphone.png) no-repeat;
				-moz-border-radius: 	0px;
				-webkit-border-radius:	0px;
				opacity: 				.90;
				filter: 				alpha(opacity = 90);
				width: 					245px;
				height: 				137px;
				padding: 				0px;
				overflow: 				hidden;
				border-color: 			#5ab500;
				color: 					#fff;
			}

			div.jGrowl div.iphone div.message {
				padding-top: 			0px;
				padding-bottom: 		7px;
				padding-left: 			15px;
				padding-right: 			15px;
			}
			
			div.jGrowl div.iphone div.header {
				padding: 				7px;
				padding-left: 			15px;
				padding-right: 			15px;
				font-size: 				17px;
			}

			div.jGrowl div.iphone div.close {
				display: 				none;
			}
			
			div#random {
				width: 					1000px;
				background-color: 		red;
				line-height: 			60px;
			}

		</style>    
    
<?php
include("config.php"); 

$bg1 = BG_1;
$bg2 = BG_2;
$bg3 = BG_3;
$bg4 = BG_4;

$s = '';

 foreach($notification_status_admin as $status) {
    $s.="status = '$status' || ";
 }$for_query1 = "$s status=''";
 
if($userID)			 
$user_DS=mysqli_fetch_array(safe_query("SELECT jgrowl FROM ".PREFIX."user WHERE userID='$userID'"));
 
 if(pageURL()=="site=sc_cupinstant") 
 {
 
     echo '<table width="100%" bgcolor="'.$border.'" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'">
             <tr>
               <td class="title" align="center">Created:</td>
               <td class="title" align="center">Type:</td>
               <td class="title" align="center">Status:</td>
               <td class="title" align="center">Party:</td>
               <td class="title" align="center">Details:</td>
             </tr>';
             
//-- Notify cupadmins of unresolved tickets  --//
             
  if(iscupadmin($userID)) {  
  
     $query=safe_query("SELECT * FROM ".PREFIX."cup_tickets WHERE $for_query1 ORDER BY ticketID DESC");
        while($cids=mysqli_fetch_array($query))
        {  
     
           echo '<tr>
                   <td bgcolor="'.$bg1.'" align="center">'.date("l M dS Y", $cids['time']).'</td>
                   <td bgcolor="'.$bg1.'" align="center">'.$unresolved_ticket_a.(mysqli_num_rows($query)>1 ? "s" : "").'</td>
                   <td bgcolor="'.$bg1.'" align="center">'.ticket_status($cids['ticketID']).'</td>
                   <td bgcolor="'.$bg1.'" align="center">'.getnickname($cids['userID']).'</td>
                   <td bgcolor="'.$bg1.'" align="center"><a href="admin/admincenter.php?site=cuptickets&action=view_ticket&tickID='.$cids['ticketID'].'" target="_blank"><img border="0" src="images/icons/foldericons/newhotfolder.gif"></a></td>
                 </tr>';
     }
  }
  
//-- --//  
             
     echo '</table>';
           
 
 }
 else{

//-- Notify new private messages --//

if($loggedin && ($user_DS['jgrowl']==1 OR $user_DS['jgrowl']==2 OR $user_DS['jgrowl']==4)) {
	$newmessages = getnewmessages($userID);
	
	if($newmessages==true) {
	   $cont_link = '<a href="?site=messenger"><strong>here</strong></a>';
       $ci_message = "$.jGrowl('<b>$newmessages Private Message".($newmessages>1 ? 's' : '')."</b><br><br> Click $cont_link to view your inbox.');";
       echo "<script type='text/javascript'>$ci_message</script>";
	} 
} 

//-- Notify cupadmins of unresolved tickets (JGrowl)--//
  
  $content0 = '';
  
  if(iscupadmin($userID)) 
  {   
     
     $query2=safe_query("SELECT * FROM ".PREFIX."cup_tickets WHERE $for_query1");
     
	 if(mysqli_num_rows($query2)>4) $more_rows0 = '(<a href="?site=sc_cupinstant"><b>View All</b></a>)';
	 else $more_rows0 = '';
     
     $query=safe_query("SELECT * FROM ".PREFIX."cup_tickets WHERE $for_query1 ORDER BY ticketID DESC LIMIT 0,4");
	 
     if(mysqli_num_rows($query)) $header0 = $unresolved_ticket_a.(mysqli_num_rows($query)>1 ? "s" : "");
	 else $header0 = '';
     
     while($cids=mysqli_fetch_array($query))
     {  
        if($cids['userID']) $s_nick = '('.getnickname($cids['userID']).')';
     
           $content0.=ticket_status($cids['ticketID']).' '.$s_nick.' <div style="margin-left: 220px; margin-top: -15px; position:absolute;"><a href="admin/admincenter.php?site=cuptickets&action=view_ticket&tickID='.$cids['ticketID'].'" target="_blank"><img border="0" src="images/icons/foldericons/newhotfolder.gif" align="right"></a></div><br>';
     }
  }  
    
  if($header0 && $content0) 
  {
     $ci_message = "$.jGrowl('<b>$header0</b> $more_rows0 <br><br> $content0');";
     echo "<script type='text/javascript'>$ci_message</script>";
  }
  
//-- Awaiting match action by participant (JGrowl)--//

  if($loggedin && ($user_DS['jgrowl']==1 OR $user_DS['jgrowl']==3 OR $user_DS['jgrowl']==4))
  { 
     $query_1on1=safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE (clan1='$userID' || clan2='$userID') && (clan1 != '0' AND clan2 != '0') && (clan1 !='2147483647' AND clan2 !='2147483647') AND 1on1='1' AND confirmscore='0'");
     
     if(participantTeamID($userID)) {
        $query_teams=safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE (clan1='".participantTeamID($userID)."' || clan2='".participantTeamID($userID)."') && (clan1 != '0' AND clan2 != '0') && (clan1 !='2147483647' AND clan2 !='2147483647') AND confirmscore='0' AND 1on1='0'");
     }

     $totalRows = mysqli_num_rows($query_1on1)+mysqli_num_rows($query_teams);

     if(mysqli_num_rows($query_1on1) || mysqli_num_rows($query_teams))
        $header1 = $unconfirmed_result.($totalRows>1 ? "s" : "");
	 else
	    $header1 = '';
     
     while($cids=mysqli_fetch_array($query_1on1)) {
     
       if($cids['type']=='gs') {
                $csID = $cids['matchno'];
		$csTB = ($cids['cupID'] && $cids['ladID']==0 ? 'cups' : 'cup_ladders');
       }
       elseif($cids['type']=='cup') {
                $csID = $cids['cupID'];
		$csTB = 'cups';
       }
       elseif($cids['type']=='ladder') {
                $csID = $cids['ladID'];
		$csTB = 'cup_ladders';
       }
       
       if($csID && $csTB) {
          $get_status_cs = safe_query("SELECT status FROM ".PREFIX.$csTB." WHERE ID='$csID' && status='2'");
       }
       
       if(mysqli_num_rows($get_status_cs)) {
          
        $league = league($cids['matchID']);  
        $type = getleagueType($cids['matchID']);
        $t_name = ($league=="cup" ? "cupID" : "laddID");
        
        if($league=="cup" && is1on1($cids[$type]))
        {
           $one_cup = "&type=1";
        }
        elseif($league=="ladder" && ladderis1on1($cids[$type]))
        {
           $one_cup = "&type=1";
        }
        else
        {
           $one_cup = '';           
        }
        
	if($type=="matchno") 
		     $report_link = '?site=groups&'.$t_name.'='.$cids[$type].'&match='.$cids['matchID'];
	else{		
		
          if($userID==$cids['clan1']) 
		     $report_link = '?site=matches&action=viewmatches&clanID='.$cids['clan1'].'&'.$t_name.'='.$cids[$type].$one_cup.'#'.$dd['matchno'].'';
	  else
	             $report_link = '?site=matches&action=viewmatches&clanID='.$cids['clan1'].'&'.$t_name.'='.$cids[$type].$one_cup.'#'.$dd['matchno'].'';
        }

        if($cids[clan1]	&& $cids[clan2]) {
        
           $content1_1on1.=getname1($cids['clan1'],$cids[$type],$ac=0,$league).' <a href='.matchlink($cids['matchID'],$ac=0,$tg=0,$redirect=0).'>vs</a> '.getname1($cids['clan2'],$cids[$type],$ac=0,$league).' <a href="'.$report_link.'"><img border="0" src="images/cup/icons/edit.png" align="right" width="14" height="14" /></a><br>';
        }
      }
     }
     while($cids1=mysqli_fetch_array($query_teams))
     {
     
       if($cids1['type']=='gs') {
                $csID = $cids1['matchno'];
		$csTB = ($cids1['cupID'] && $cids1['ladID']==0 ? 'cups' : 'cup_ladders');
       }
       elseif($cids1['type']=='cup') {
                $csID = $cids1['cupID'];
		$csTB = 'cups';
       }
       elseif($cids1['type']=='ladder') {
                $csID = $cids1['ladID'];
		$csTB = 'cup_ladders';
       }
       
       if($csID && $csTB) {
          $get_status_cs = safe_query("SELECT status FROM ".PREFIX.$csTB." WHERE ID='$csID' && status='2'");
       }
       
       if(mysqli_num_rows($get_status_cs)) {
     
        $league = league($cids1['matchID']);  
        $type = getleagueType($cids1['matchID']);
        $t_name = ($league=="cup" ? "cupID" : "laddID");
        
        if($league=="cup" && is1on1($cids1[$type]))
           $one_cup = "&type=1";
        elseif($league=="ladder" && ladderis1on1($cids1[$type]))
           $one_cup = "&type=1";
        else
           $one_cup = '';
        
	if($type=="matchno") {
		     $report_link = '?site=groups&'.$t_name.'='.$cids1[$type].'&match='.$cids1['matchID'].'';
	}
	else{		
		
          if(memin($userID,$cids1['clan1'])) 
		     $report_link = '?site=matches&action=viewmatches&clanID='.$cids1['clan1'].'&'.$t_name.'='.$cids1[$type].$one_cup.'#'.$dd['matchno'].'';
	  else
		     $report_link = '?site=matches&action=viewmatches&clanID='.$cids1['clan1'].'&'.$t_name.'='.$cids1[$type].$one_cup.'#'.$dd['matchno'].'';
        }

        if($cids1[clan1] && $cids1[clan2]) {
           $content1_teams.=getname1($cids1['clan1'],$cids1[$type],$ac=0,$league).' <a href='.matchlink($cids1['matchID'],$ac=0,$tg=0,$redirect=0).'>vs</a> '.getname1($cids1['clan2'],$cids1[$type],$ac=0,$league).' <a href="'.$report_link.'"><img border="0" src="images/cup/icons/edit.png" align="right"  width="14" height="14"/></a><br>';
        }
     }
   }  
 }
 
  if($header1 && ($content1_1on1 || $content1_teams)) 
  {
     echo "<script type='text/javascript'>$.jGrowl('<b>$header1</b> <br><br> $content1_1on1 $content1_teams');</script>";
  }
  
//-- Awaiting challenge action by participant (JGrowl)--//

  $content2 = '';

  if($loggedin && ($user_DS['jgrowl']==1 OR $user_DS['jgrowl']==3 OR $user_DS['jgrowl']==4)) { 
     $query1=safe_query("SELECT * FROM ".PREFIX."cup_challenges WHERE (status='1' || status='2') && (challenger='$userID' || challenged='$userID') && 1on1='1'");
     
     if(participantTeamID($userID)) {
        $query2=safe_query("SELECT * FROM ".PREFIX."cup_challenges WHERE (status='1' || status='2') && (challenger='".participantTeamID($userID)."' || challenged='".participantTeamID($userID)."') && 1on1='0'");     
     }

     $totalRows = mysqli_num_rows($query1)+mysqli_num_rows($query2);

     if(mysqli_num_rows($query1) || mysqli_num_rows($query2)) $header2 = 'Unfinalized Challenge'.($totalRows>1 ? "s" : "");
	 else $header2 = '';
     
     while($cids=mysqli_fetch_array($query1))
     {
        if($cids[challenger] && $cids[challenged])
        {
           $content2.=getname1($cids['challenger'],$cids['ladID'],$ac=0,$league="ladder").' vs '.getname1($cids['challenged'],$cids['ladID'],$ac=0,$league="ladder").' <a href="?site=standings&action=viewchallenge&laddID='.$cids['ladID'].'&challID='.$cids['chalID'].'"><img border="0" src="images/cup/icons/challenge.gif" align="right" width="14" height="14"></a><br>';
        }
     }
     while($cidst=mysqli_fetch_array($query2))
     {
        if($cidst[challenger] && $cidst[challenged])
        {
           $content2.=getname1($cidst['challenger'],$cidst['ladID'],$ac=0,$league="ladder").' vs '.getname1($cidst['challenged'],$cidst['ladID'],$ac=0,$league="ladder").' <a href="?site=standings&action=viewchallenge&laddID='.$cidst['ladID'].'&challID='.$cidst['chalID'].'"><img border="0" src="images/cup/icons/challenge.gif" align="right" width="14" height="14"></a><br>';
        }
     }
  }  
    
  if($header2 && $content2) {
     $ci_message = "$.jGrowl('<b>$header2</b> <br><br> $content2');";
     echo "<script type='text/javascript'>$ci_message</script>";
  }

//-- Notify users of unresolved tickets (JGrowl)--//

$s_u = '';
$content3 = '';

 foreach($notification_status_user as $status) {
    $s_u.="status = '$status' || ";
 }$for_query2 = "$s_u status=''";
 
  if($loggedin AND ($user_DS['jgrowl']==1 OR $user_DS['jgrowl']==2 OR $user_DS['jgrowl']==4)) 
  { 
     $query=safe_query("SELECT * FROM ".PREFIX."cup_tickets WHERE userID='$userID' && ($for_query2)");

     if(mysqli_num_rows($query)) $header3 = $unresolved_ticket_u.(mysqli_num_rows($query)>1 ? "s" : "");
	 else $header3 = '';
     
     while($cids=mysqli_fetch_array($query1))
     {  
           $content3.=ticket_status($cids['ticketID']).' ('.getnickname($cids['userID']).') <a href="?site=cupactions&action=mytickets&tickID='.$cids['ticketID'].'"><img border="0" src="images/icons/foldericons/newhotfolder.gif" align="right"></a><br>';
     }
  }  
    
  if($header3 && $content3) 
  {
     $ci_message = "$.jGrowl('<b>$header3</b> <br><br> $content3');";
     echo "<script type='text/javascript'>$ci_message</script>";
  }
  

//-- Notify users that are registered in cups and currently in-progress (started status - JGrowl) --//

    if($userID && ($user_DS['jgrowl']==1 OR $user_DS['jgrowl']==6 OR $user_DS['jgrowl']==7)) {

    $jg = false;
	$content4 = '';

    $query = safe_query("SELECT * FROM ".PREFIX."cups ORDER BY ID DESC");
      while($cids1=mysqli_fetch_array($query))
      {
	  
		$chk_fa=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_agents WHERE cupID='".$cids1['ID']."' && ladID='0'"));
      
        $game1='<img src="images/games/'.$cids1['game'].'.gif" width="14" height="14" border="0">';     
      
        if($cids1['status']==1 && $cids1['gs_start'] <= time() && $cids1['gs_end'] >= time() && isgroupparticipant2($userID,$cids1['ID'],'cup')) 
        {
	
	    $si_l_name = getcupname($cids1['ID']);
	    $length_scci = $sc_cupinstant_length; 
	    
	    $str_ct = strlen($si_l_name)-$length_scci;
	    
	    if(strlen($si_l_name) > $length_scci) {
		      $content4 .= $game1.' <a href="?site=groups&cupID='.$cids1['ID'].'">'.substr($si_l_name, 0, -$str_ct).'..'.'</a> <a href="?site=groups&cupID='.$cids1['ID'].'"><img src="images/cup/icons/groups.png" align="right"></a><br>';
	    }
	    else{
	          $content4 .= $game1.' <a href="?site=groups&cupID='.$cids1['ID'].'">'.$si_l_name.'</a> <a href="?site=groups&cupID='.$cids1['ID'].'"><img src="images/cup/icons/groups.png" align="right"></a><br>';
	    }
	    
	    $jg = true; 

        }   
        elseif($cids1['status']==2 && iscupparticipant($userID,$cids1['ID'],$checkin=0)) 
        {  

	    $si_l_name = getcupname($cids1['ID']);
	    $length_scci = $sc_cupinstant_length; 
	    
	    $str_ct = strlen($si_l_name)-$length_scci;
		
		if(is_array($chk_fa)) {
 		   $freea_lnk = 'Click <a href="?site=freeagents&action=view&cupID='.$chk_fa['cupID'].'">here</a> to view.';
		   echo "<script type='text/javascript'>$.jGrowl('<b>Free Agents Available</b> <br><br> $freea_lnk');</script>"; 
		}
	    
	    if(strlen($si_l_name) > $length_scci) {
		  $content4 .= $game1.' <a href="?site=brackets&action=tree&cupID='.$cids1['ID'].'">'.substr($si_l_name, 0, -$str_ct).'..'.'</a> <a href="?site=brackets&action=tree&cupID='.$cids1['ID'].'"><img src="images/cup/icons/tournament.png" align="right"></a><br>';
	    }
	    else{
	          $content4 .= $game1.' <a href="?site=brackets&action=tree&cupID='.$cids1['ID'].'">'.$si_l_name.'</a> <a href="?site=brackets&action=tree&cupID='.$cids1['ID'].'"><img src="images/cup/icons/tournament.png" align="right"></a><br>';
	    }
	    
	    $jg = true;  
        } 
      }

    $query = safe_query("SELECT * FROM ".PREFIX."cup_ladders ORDER BY ID DESC");
      while($cids2=mysqli_fetch_array($query))
      {
	  
		$chk_fa=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_agents WHERE ladID='".$cids2['ID']."' && cupID='0'"));
      
        $game2='<img src="images/games/'.$cids2['game'].'.gif" width="14" height="14" border="0">'; 
      
        if($cids2['status']==1 && $cids2['gs_start'] <= time() && $cids2['gs_end'] >= time() && isgroupparticipant($userID,$cids2['ID'],'ladder')) 
        {   
	    
	    $si_l_name = getladname($cids2['ID']);
	    $length_scci = $sc_cupinstant_length; 
	    
	    $str_ct = strlen($si_l_name)-$length_scci;
	    
	    if(strlen($si_l_name) > $length_scci) {
		  $content4 .= $game2.' <a href="?site=groups&laddID='.$cids2['ID'].'">'.substr($si_l_name, 0, -$str_ct).'..'.'</a> <a href="?site=groups&laddID='.$cids2['ID'].'"><img src="images/cup/icons/groups.png" align="right"></a><br>';
	    }
	    else{
	          $content4 .= $game2.' <a href="?site=groups&laddID='.$cids2['ID'].'">'.$si_l_name.'</a> <a href="?site=groups&laddID='.$cids2['ID'].'"><img src="images/cup/icons/groups.png" align="right"></a><br>';
	    }
	    
	    $jg = true;    
        }
        elseif($cids2['status']==2 && isladparticipant($userID,$cids2['ID'],$checkin=0)) 
        {   
	
	    $si_l_name = getladname($cids2['ID']);
	    $length_scci = $sc_cupinstant_length; 
	    
	    $str_ct = strlen($si_l_name)-$length_scci;
		
		if(is_array($chk_fa)) {
 		   $freea_lnk = 'Click <a href="?site=freeagents&action=view&laddID='.$chk_fa['ladID'].'">here</a> to view.';
		   echo "<script type='text/javascript'>$.jGrowl('<b>Free Agents Available</b> <br><br> $freea_lnk');</script>"; 
		}
	    
	    if(strlen($si_l_name) > $length_scci) {
		  $content4 .= $game2.' <a href="?site=standings&ladderID='.$cids2['ID'].'">'.substr($si_l_name, 0, -$str_ct).'..'.'</a> <a href="?site=standings&ladderID='.$cids2['ID'].'"><img src="images/cup/icons/ladder.png" align="right"></a><br>';
	    }
	    else{
	          $content4 .= $game2.' <a href="?site=standings&ladderID='.$cids2['ID'].'">'.$si_l_name.'</a> <a href="?site=standings&ladderID='.$cids2['ID'].'"><img src="images/cup/icons/ladder.png" align="right"></a><br>';
	    }
	    
	    $jg = true;
        }
      }

    if($jg ==true)
    {
        echo "<script type='text/javascript'>$.jGrowl('<b>Your Cups In-Progress</b> <br><br> $content4');</script>"; 
    }
	}
    
//-- Notify users of cups in sign-up phase if not registered --//

    if($userID && ($user_DS['jgrowl']==1 OR $user_DS['jgrowl']==5 OR $user_DS['jgrowl']==7)) {

    $ns = false;
	$content5 ='';

    $query = safe_query("SELECT * FROM ".PREFIX."cups ORDER BY ID DESC");
      while($cids1=mysqli_fetch_array($query))
      {
      
        $game1='<img src="images/games/'.$cids1['game'].'.gif" width="14" height="14" border="0">';
      
        if($cids1['status']==1 && $cids1['gs_start'] > time() && !isgroupparticipant2($userID,$cids1['ID'],'cup')) 
        {
	
	    $si_l_name = getcupname($cids1['ID']);
	    $length_scci = $sc_cupinstant_length; 
	    
	    $str_ct = strlen($si_l_name)-$length_scci;
	    
	    if(strlen($si_l_name) > $length_scci) {
		  $content5 .= $game1.' <a href="?site=groups&cupID='.$cids1['ID'].'">'.substr($si_l_name, 0, -$str_ct).'..'.'</a> <a href="?site=groups&cupID='.$cids1['ID'].'"><img src="images/cup/icons/groups.png" align="right"></a><br>';
	    }
	    else{
	          $content5 .= $game1.' <a href="?site=groups&cupID='.$cids1['ID'].'">'.getcupname($cids1['ID']).'</a> <a href="?site=groups&cupID='.$cids1['ID'].'"><img src="images/cup/icons/groups.png" align="right"></a><br>';
	    }
	    
	    $ns = true;
	    
        }   
        elseif($cids1['status']==1 && $cids1['gs_end'] < time() && !iscupparticipant($userID,$cids1['ID'],$checkin=0) && $cids2['gs_end'] < time())
        {   
	
	    $si_l_name = getcupname($cids1['ID']);
	    $length_scci = $sc_cupinstant_length; 
	    
	    $str_ct = strlen($si_l_name)-$length_scci;
	    
	    if(strlen($si_l_name) > $length_scci) {
		  $content5 .= $game1.' <a href="?site=quicknavi&cup='.getalphacupname($cids1['ID']).'">'.substr($si_l_name, 0, -$str_ct).'..'.'</a> <a href="?site=quicknavi&cup='.getalphacupname($cids1['ID']).'"><img src="images/cup/icons/tournament.png" align="right"></a><br>';
	    }
	    else{
	          $content5 .= $game1.' <a href="?site=quicknavi&cup='.getalphacupname($cids1['ID']).'">'.getcupname($cids1['ID']).'</a> <a href="?site=quicknavi&cup='.getalphacupname($cids1['ID']).'"><img src="images/cup/icons/tournament.png" align="right"></a><br>';
	    }

            $ns = true;
	    
        } 
      }

    $query = safe_query("SELECT * FROM ".PREFIX."cup_ladders ORDER BY ID DESC");
      while($cids2=mysqli_fetch_array($query))
      {
      
        $game2='<img src="images/games/'.$cids2['game'].'.gif" width="14" height="14" border="0">';
      
        if($cids2['status']==1 && $cids2['gs_start'] > time() && !isgroupparticipant($userID,$cids2['ID'],'ladder')) 
        {   
	
	    $si_l_name = getladname($cids2['ID']);
	    $length_scci = $sc_cupinstant_length; 
	    
	    $str_ct = strlen($si_l_name)-$length_scci;
	    
	    if(strlen($si_l_name) > $length_scci) {
		  $content5 .= $game2.' <a href="?site=groups&laddID='.$cids2['ID'].'">'.substr($si_l_name, 0, -$str_ct).'..'.'</a> <a href="?site=groups&laddID='.$cids2['ID'].'"><img src="images/cup/icons/groups.png" align="right"></a><br>';
	    }
	    else{
	          $content5 .= $game2.' <a href="?site=groups&laddID='.$cids2['ID'].'">'.$si_l_name.'</a> <a href="?site=groups&laddID='.$cids2['ID'].'"><img src="images/cup/icons/groups.png" align="right"></a><br>';
	    }

	    $ns = true;
	    
        }
        elseif(($cids2['status']==1 OR ($cids2['status']==2 && $cids2['sign']==1)) && ($cids2['gs_end'] < time() && !isladparticipant($userID,$cids2['ID'],$checkin=0) && $cids2['gs_end'] < time())) 
        {   

	    $si_l_name = getladname($cids2['ID']);
	    $length_scci = $sc_cupinstant_length; 
	    
	    $str_ct = strlen($si_l_name)-$length_scci;
	    
	    if(strlen($si_l_name) > $length_scci) {
		  $content5 .= $game2.' <a href="?site=quicknavi&type=ladders&cup='.getalphaladname($cids2['ID']).'">'.substr($si_l_name, 0, -$str_ct).'..'.'</a> <a href="?site=quicknavi&type=ladders&cup='.getalphaladname($cids2['ID']).'"><img src="images/cup/icons/ladder.png" align="right"></a><br>';
	    }
	    else{
	          $content5 .= $game2.' <a href="?site=quicknavi&type=ladders&cup='.getalphaladname($cids2['ID']).'">'.$si_l_name.'</a> <a href="?site=quicknavi&type=ladders&cup='.getalphaladname($cids2['ID']).'"><img src="images/cup/icons/ladder.png" align="right"></a><br>';
	    }

	    $ns = true;
        }
      }

      if($ns ==true){
        echo "<script type='text/javascript'>$.jGrowl('<b>Cup-Signups - Join Now!</b> <br><br> $content5');</script>"; 
      }
	}
//-- Freeagent notifcation (5207) --//

    

  }
?>    