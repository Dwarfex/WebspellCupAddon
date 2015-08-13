<?php include("../config.php"); 

$_language->read_module('comments');

$bg1 = BG_1;
$bg2 = BG_2;
$bg3 = BG_3;
$bg4 = BG_4;

 if(iscupadmin($userID)) {
 
 echo '<LI><h1><a href="admincenter.php?site=cuptickets"><img src="../images/cup/icons/home_icon.gif" width="18" height="18"></a> Support & Protest Tickets<br></h1>';
 
/* QUERIES */

if($_POST['createdepartment']) {
   if(!$_POST['department']) die('You must name the department.');
   safe_query("INSERT INTO ".PREFIX."cup_departments (`department`) VALUES ('".$_POST['department']."')");
   redirect('?site=cuptickets', '<center><b>Department successfully created!</b></center>', 2); 
   
}elseif(isset($_GET['action']) && $_GET['action']=="showall") {
   $query = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE einspruch='1'");
     if(!mysql_num_rows($query)) $no_protests = "Oopz! Looks like there are no protest matches!";
       while($ds = mysql_fetch_array($query)) {
         safe_query("INSERT INTO ".PREFIX."cup_tickets (`cupID`,`ladID`,`matchID`,`subject`,`desc`) VALUES ('".$ds['cupID']."', '".$ds['ladID']."', '".$ds['matchID']."', '(unspecified subject)', '(unspecified message)')");                
    }    
}elseif($_GET['action']=="update" && $_GET['departmentID']) {
  safe_query("UPDATE ".PREFIX."cup_tickets SET department='".$_GET['departmentID']."', updated='".time()."' WHERE ticketID='".$_GET['ticketID']."'");
  redirect('?site=cuptickets', '<center><b>Ticket successfully assigned to department!</b></center>', 2); 
  
}elseif($_GET['action']=="update" && $_GET['status']) {
  safe_query("UPDATE ".PREFIX."cup_tickets SET status='".$_GET['status']."' WHERE ticketID='".$_GET['ticketID']."'");
  redirect('?site=cuptickets', '<center><b>Ticket status successfully changed!</b></center>', 2); 

}elseif($_GET['action']=="delete" && $_GET['ticketID']) {
  safe_query("DELETE FROM ".PREFIX."cup_tickets WHERE ticketID='".$_GET['ticketID']."'");
  safe_query("DELETE FROM ".PREFIX."comments WHERE parentID='".$_GET['ticketID']."' && type='ts'");
  redirect('?site=cuptickets', '<center><b>Ticket successfully deleted!</b></center>', 2); 

}elseif($_POST['editdepartment']) {
  safe_query("UPDATE ".PREFIX."cup_departments SET department = '".$_POST['department']."' WHERE ID='".$_POST['ID']."'");
  redirect('?site=cuptickets', '<center><b>Department successfully edited!</b></center>', 2); 

}elseif($_GET['action']=="delete" && $_GET['department']) {
  safe_query("DELETE FROM ".PREFIX."cup_departments WHERE ID='".$_GET['department']."'");
  safe_query("DELETE FROM ".PREFIX."cup_tickets WHERE department='".$_GET['department']."'");
  
  $query = safe_query("SELECT ticketID FROM ".PREFIX."cup_tickets WHERE department='".$_GET['department']."'");
    while($ds=mysql_fetch_array($query)) {    
       safe_query("DELETE FROM ".PREFIX."comments WHERE parentID='".$ds['ticketID']."' && type='ts'");
    }
  redirect('?site=cuptickets', '<center><b>Department and tickets assigned to department successfully deleted!</b></center>', 2); 

}

/* TICKET ORDERING */

$order_tickets = ($order_by ? "ORDER BY updated DESC" : "ORDER BY time DESC");
$hide_closed = ($hide_closed_tickets ? "AND status!='5'" : "");

/* DEPARTMENTS */

$departments = '<option value="" selected>-- Edit Department --</option>';
  $query = safe_query("SELECT ID, department FROM ".PREFIX."cup_departments");
    $num_departments = mysql_num_rows($query);
      while($pt = mysql_fetch_array($query)) {
         $departments .= '<option value="'.$pt['ID'].'">'.$pt['department'].'</option>';
         $departments_l.='<option value="'.$pt['ID'].'">'.$pt['department'].'</option>';
     }
     
if($_GET['department']) {
  echo '<form method="post" name="post" action="?site=cuptickets">
          <input type="text" name="department" value="'.departmentname($_GET['department']).'">
          <input type="hidden" name="ID" value="'.$_GET['department'].'">
          <input type="submit" name="editdepartment" value="Edit Department">
        </form>
         OR <a href="?site=cuptickets&action=delete&department='.$_GET['department'].'" onclick="return confirm(\'Deleting this department is non recoverable will also delete all tickets assigned to this department.\');"><b>Delete Department</b></a>';
}else{
  echo '<select name="department" onChange="MM_confirm(\'Edit Department?\', \'admincenter.php?site=cuptickets&department=\'+this.value)">'.$departments.'</select>';
}
     
     
   if(!$num_departments) 
       echo '<form method="post" name="post" action="?site=cuptickets">
                 <input type="text" name="department">
                 <input type="submit" name="createdepartment" value="Add Department">
               </form>';
   else
       echo '
               <form method="post" name="post" action="?site=cuptickets">
                 <input type="text" name="department">
                 <input type="submit" name="createdepartment" value="Add Department">
               </form>';

 if(isset($_GET['tickID']) && $_GET['action']=="view_ticket") {
    
    $ID = $_GET['tickID'];
 
    $query = safe_query("SELECT * FROM ".PREFIX."cup_tickets WHERE ticketID='$ID'");
    $ds = mysql_fetch_array($query);
    
    $update = safe_query("SELECT * FROM ".PREFIX."comments WHERE type='ts' && parentID='".$ds['ticketID']."' ORDER BY commentID DESC");
    $tic = mysql_fetch_array($update); $num_rows = mysql_num_rows($update);  
    
    $subject = getinput($ds['subject']);
    $date = date('l M dS Y \@\ g:i a', $ds['time']);
    $user = '<a href="../index.php?site=profile&id='.$ds['userID'].'"><b>'.getnickname($ds['userID']).'</b></a>';
    $staff = ($ds['adminID'] ? '<a href="../index.php?site=profile&id='.$ds['adminID'].'"><b>'.getnickname($ds['adminID']).'</b></a>' : "n/a");
    
    if($ds['matchID']) {
       $dm=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchID='".$ds['matchID']."'"));
       $desc = getname1($dm['clan1'],getleagueID($ds['matchID']),$ac=1,league($ds['matchID'])).' vs '.getname1($dm['clan2'],getleagueID($ds['matchID']),$ac=1,league($ds['matchID']));
    }else
       $desc = cleartext(stripslashes(str_replace(array('\r\n', '\n'),array("\n","\n" ), $ds['desc'])),$bbcode=true, $calledfrom='admin');
    
    if(!$num_rows)
        $updated_date = "(no update)";
    else{
        $updated_date = date('l M dS Y \@\ g:i a', $tic['date']);
        $updated_by = 'by '.(iscupadmin($userID) ? "admin" : "user").' <a href="../index.php?site=profile&id='.$tic['userID'].'"><b>'.getnickname($tic['userID']).'</b></a>';
   }
       
              $lc=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."comments WHERE parentID='".$ds['ticketID']."' && type='ts' ORDER BY date DESC LIMIT 0,1"));
              $autoclose = time()-$ticket_autoclose_time;
            
              if(!$lc['date'] && $ds['time'] <= $autoclose && in_array($ds['status'],$only_autoclose_ticket)) 
                 safe_query("UPDATE ".PREFIX."cup_tickets SET status = '$ticket_autoclose_status' WHERE ticketID='".$ds['ticketID']."'"); 
              elseif($lc['date'] && $lc['date'] <= $autoclose && in_array($ds['status'],$only_autoclose_ticket))
                 safe_query("UPDATE ".PREFIX."cup_tickets SET status = '$ticket_autoclose_status' WHERE ticketID='".$ds['ticketID']."'");  
              
       
    $updated_date = ($ds['time']>$ds['updated'] ? "(no update)" : date('l M dS Y \@\ g:i a', $ds['updated']));
   
            
      if($ds['matchID']) {
	  
            $db=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchID='".$ds['matchID']."'"));
            $type = '<font color="red"><b>Match Protest</b></font>';
			$type2 = ($ds['ladID'] ? "laddID" : "cupID"); 
			$cupID = ($ds['ladID'] ? $ds['ladID'] : $ds['cupID']);
			
			$ticket_departments = $type;
			
	        if($db['type']=='cup') {
	               $league = 'Brackets';
				   $cup_link = '<a href="admincenter.php?site=cups&action=baum&ID='.$ds['cupID'].'">'.$league.' #'.$ds['cupID'].'</a>';
				   $l_image = 'tournament';
	        }
	        elseif($db['type']=='ladder') {
	               $league = 'Ladder';
				   $cup_link = '<a href="../?site=standings&ladderID='.$ds['ladID'].'" target="_blank">'.$league.' #'.$ds['ladID'].'</a>';
				   $l_image = 'ladder';
	        }
	        elseif($db['type']=='gs') {
	              $league = "Groups";
                  $cup_link = '<a href="../?site=groups&'.$type2.'='.$cupID.'" target="_blank">'.$league.' #'.$cupID.'</a>';
				  $l_image = 'groups2';
	        }
	        else{
	              $league = '(unknown)';
	        }
			
		    if($db['type']=='gs') {
                  $admin_link = 'matches.php?action=edit&matchID='.$db['matchID'];
            }			
			elseif(!$db['matchno']) {
			      $admin_link = 'matches.php?action=edit&matchID='.$db['matchID'];
			}
			else{
			      $admin_link = 'matches.php?action=edit&match='.$db['matchno'].'&'.$type2.'='.$cupID;
			}
			
			$details_link = matchlink($ds['matchID'],1,1,0);
			
			$mmedia = '<tr> 
						<td class="td2" valign="top" width="11%"><b>Media</b></td>
						<td class="td1" colspan="2" valign="top" width="89%">'.($db['screens'] ? "Yes" : "No").'</td>
				       </tr>';	   
			
			    $ticket_options = '
                        <td class="td_head" align="center" width="20%"><img src="../images/cup/icons/'.$l_image.'.png" border="0"> <strong>'.$cup_link.'</strong></a></td>
						<td class="td_head" align="center" width="20%"><img src="../images/cup/icons/edit.png" border="0"> <a href="'.$admin_link.'&type=protest" onClick="MM_openBrWindow(this.href,\'View Match\',\'toolbar=no,status=no,scrollbars=yes,width=800,height=600\');return false"><strong>Edit #'.$ds['matchID'].'</strong></a></td>
						<td class="td_head" align="center" width="20%"><img src="../images/cup/icons/add_result.gif" border="0" width="16" height="16"> <a href='.$details_link.'><strong>View Match</strong></a></td>';
      }
	  else{
            $type = departmentname($ds['department']);
			
            $dp=mysql_fetch_array(safe_query("SELECT department FROM ".PREFIX."cup_departments WHERE ID='".$ds['department']."'"));
            $departments=str_replace(' selected', '', $departments_l);
	        $departments=str_replace('value="'.$ds['department'].'"', 'value="'.$ds['department'].'" selected', $departments_l);
			
			$ticket_departments = '<select name="department" onChange="MM_confirm(\'Change department?\', \'?site=cuptickets&action=update&ticketID='.$ds['ticketID'].'&departmentID=\'+this.value)">'.$departments.'</select>';
      }

            $irc = '<a href="javascript:void(0)" onclick="MM_openBrWindow(\'../popup.php?site=shout&id='.($ds['matchID'] ? $ds['matchID'] : $_GET['tickID']).'&type='.($ds['matchID'] ? 'matchID' : 'tickID').'\',\'Protest/Support Ticket\',\'toolbar=no,status=no,scrollbars=no,width=550,height=340\');"><strong>Live Chat</strong></a>';	  
	  
     	    $dd_status='<option value="1">'.$status_unreviewed.'</option><option value="2">'.$status_pending.'</option><option value="3">'.$status_onhold.'</option><option value="4">'.$status_waiting.'</option><option value="5">'.$status_resolved.'</option><option value="6">'.$status_custom1.'</option><option value="7">'.$status_custom2.'</option>';
 	        $dd_status=str_replace(' selected', '', $dd_status);
      	    $dd_status=str_replace('value="'.$ds['status'].'"', 'value="'.$ds['status'].'" selected', $dd_status);
	  
      $status = '<select name="status" onChange="MM_confirm(\'Note: If the ticket auto-closes, look at the config $ticket_autoclose_time variable setting.\', \'?site=cuptickets&action=update&ticketID='.$ds['ticketID'].'&status=\'+this.value)">'.$dd_status.'</select>';
	  
	  eval ("\$mytickets = \"".gettemplate("view_ticket")."\";");
	  echo $mytickets;
	  
		$parentID = $ds['ticketID'];
		$comments_allowed = 4;
		$type = "ts";
		$referer = "admincenter.php?site=cuptickets&action=view_ticket&tickID=$_GET[tickID]";
		
		include("comments.php");
 
 }
 else{

 /* Ticket Overview */
 
      $tickets_gp = safe_query("SELECT * FROM ".PREFIX."cup_tickets GROUP BY department"); 
	  $t_num_rows = mysql_num_rows($tickets_gp);
	  
	  if($_GET['show']=='all') echo '-- <a href="admincenter.php?site=cuptickets">hide closed</a> --';
      
        while($tgp=mysql_fetch_array($tickets_gp)) {
	
          echo '<table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="#DDDDDD">
                <tr>
                  <td class="title" align="center" colspan="4">Tickets for department '.departmentname($tgp['department']).'</td>
                </tr>
				<br>';
				
	  $show_all = ($_GET['show']!='all' ? "AND status!='5'" : "");
				
      $order_tickets = ($order_by ? "ORDER BY updated DESC" : "ORDER BY time DESC");
      $tickets = safe_query("SELECT * FROM ".PREFIX."cup_tickets WHERE department='".$tgp['department']."' $show_all $order_tickets");
	  
        if(!mysql_num_rows($tickets)) 
		    $no_rows = '<tr><td colspan="4" align="center" bgcolor="'.$bg1.'">-- No open tickets found --<br>-- <a href="admincenter.php?site=cuptickets&show=all">show all tickets</a> --</td></tr>'; 
		else
		    $no_rows = '';
        
          echo '
                <tr>
                  <td class="td_head" width="25%" align="center"><strong>Created</strong></td>
                  <td class="td_head" width="25%" align="center"><strong>Subject</strong></td>
                  <td class="td_head" width="25%" align="center"><strong>Status</strong></td>
                  <td class="td_head" width="5%" align="center"><strong>Details</strong></td>
                </tr>'.$no_rows;

          while($ds=mysql_fetch_array($tickets)) {
            
              $lc=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."comments WHERE parentID='".$ds['ticketID']."' && type='ts' ORDER BY date DESC LIMIT 0,1"));
              $autoclose = time()-$ticket_autoclose_time;
            
              if(!$lc['date'] && $ds['time'] <= $autoclose && in_array($ds['status'],$only_autoclose_ticket)) 
                 safe_query("UPDATE ".PREFIX."cup_tickets SET status = '$ticket_autoclose_status' WHERE ticketID='".$ds['ticketID']."'"); 
              elseif($lc['date'] && $lc['date'] <= $autoclose && in_array($ds['status'],$only_autoclose_ticket))
                 safe_query("UPDATE ".PREFIX."cup_tickets SET status = '$ticket_autoclose_status' WHERE ticketID='".$ds['ticketID']."'");  
              
              
              $date = date('D, dS M Y', $ds['time']);
              $department = departmentname($ds['department']);
                
              if($ds['status']==1)
                 $status = $status_unreviewed;
              elseif($ds['status']==2)
                 $status = $status_pending;
              elseif($ds['status']==3)
                 $status = $status_onhold;
              elseif($ds['status']==4)
                 $status = $status_waiting;
              elseif($ds['status']==5)
                 $status = $status_resolved;         
              elseif($ds['status']==6)
                 $status = $status_custom1;
              elseif($ds['status']==7)
                 $status = $status_custom2;
				 
      if($i%2) { $td='td1'; }
      else { $td='td2'; }
				
  echo '
  <tr>
    <td class="'.$td.'" align="center">'.$date.'</td>
    <td class="'.$td.'" align="center">'.$ds['subject'].'</td>
    <td class="'.$td.'" align="center">'.$status.'</td>
    <td class="'.$td.'" align="center"><a href="?site=cuptickets&action=view_ticket&tickID='.$ds['ticketID'].'"><img src="../images/icons/foldericons/folder.gif"></a></td>
  </tr>';
      
          }
     }    
	 
      if($t_num_rows) { echo '</table>'; }  
 
 }
 
} 
?>