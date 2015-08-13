<link href="../cup.css" rel="stylesheet" type="text/css">

<script>
function countit(obj) {
    var n=0;
    for (var i=0;i<obj.options.length;i++) {
        if (obj.options[i].selected) n++;
    }
    alert("# of options you've selected: " + n};
    if (n>=8) {
        alert("warning: # of options selected shouldn't be more than 8.")
    }
}
</script>

<?php
/*
 ########################################################################
#                                                                        #
#           Version 4       /                        /   /               #
#          -----------__---/__---__------__----__---/---/-               #
#           | /| /  /___) /   ) (_ `   /   ) /___) /   /                 #
#          _|/_|/__(___ _(___/_(__)___/___/_(___ _/___/___               #
#                       Free Content / Management System                 #
#                                   /                                    #
#                                                                        #
#                                                                        #
#   Copyright 2005-2006 by webspell.org / webspell.info                  #
#                                                                        #
#   visit webSPELL.org, webspell.info to get webSPELL for free           #
#   - Script runs under the GNU GENERAL PUBLIC LICENCE                   #
#   - It's NOT allowed to remove this copyright-tag                      #
#   -- http://www.fsf.org/licensing/licenses/gpl.html                    #
#                                                                        #
#   Code based on WebSPELL Clanpackage (Michael Gruber - webspell.at),   #
#   Far Development by Development Team - webspell.org / webspell.info   #
#                                                                        #
#   visit webspell.org / webspell.info                                   #
#                                                                        #
 ########################################################################
*/
include("../config.php");

gettimezone();
match_query_type();

if($_GET['cupID'] && is1on1($_GET['cupID'])){
       $one_type = "1on1='1'";
}
elseif($_GET['laddID'] && ladderis1on1($_GET['laddID'])){
       $one_type = "1on1='1'";
}
else{
       $one_type = "1on1='0'";
}


$type_opp = ($_GET['cupID'] ? "ladID='0'" : "cupID='0'");
$type = 'ladID';
$alpha_groups = "type='gs'";

if(!$_GET['laddID']) 
{
    $cupID = $_GET['cupID'];
    $t_name2 = "cupID";
    $t_name3 = "cupID";
    $typename = "is1on1";
    $info = mysql_query("SELECT * FROM ".PREFIX."cups WHERE ID='$cupID'");
	qualifiersToLeague($cupID);
}
else
{
    $cupID = $_GET['laddID'];
    $t_name2 = "laddID";
    $t_name3 = "ladID";
    $typename = "ladderis1on1";
    $info = mysql_query("SELECT * FROM ".PREFIX."cup_ladders WHERE ID='$cupID'");
    $platID = '\''.getplatID($cupID).'\',';
    $plat = "`platID`,";
	qualifiersToLeague($cupID);
}

    $set = mysql_fetch_array($info);

if($_GET['type']=="gs") {
    $t_name = "groupID";
    $ext = "&type=gs";
}
elseif($_GET['cupID']){
    $t_name = "cupID";
}
else
    $t_name = "ladID";

if(!iscupadmin($userID) OR substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php") die('Access denied.');

if($_GET['action']==uncheck) {
  $clanID = $_GET['clanID'];
  $cupID = $cupID;
	safe_query("UPDATE ".PREFIX."cup_clans SET `checkin`='0' WHERE clanID='$clanID' && $t_name='$cupID'");

}elseif($_GET['action']==checkin) {
  $clanID = $_GET['clanID'];
  $cupID = $cupID;
	safe_query("UPDATE ".PREFIX."cup_clans SET `checkin`='1' WHERE clanID='$clanID' && $t_name='$cupID'");

}elseif($_GET['action']=="status") {
  $clanID = $_GET['clanID'];
  $status = $_GET['status'];
  safe_query("UPDATE ".PREFIX."cup_all_clans SET `status`='".$status."' WHERE ID='".$clanID."'");

}if($_GET['delete']=='all' && ($_GET['cupID'] || $_GET['laddID'])) {

    if($_GET['cupID'] && is1on1($_GET['cupID']))
    {
       $one_type = "1on1='1'";
    }
    elseif($_GET['laddID'] && ladderis1on1($_GET['laddID']))
    {
       $one_type = "1on1='1'";
    }
    else
    {
       $one_type = "1on1='0'";
    }

    $type = $_GET['cupID'] ? "cupID" : "ladID";
    $type_opp = ($_GET['cupID'] ? "ladID='0'" : "cupID='0'");
    $alpha_groups = "type='gs'";
    $cupID = $_GET['cupID'] ? $_GET['cupID'] : $_GET['laddID'];

    safe_query("DELETE FROM ".PREFIX."cup_clans WHERE groupID='$cupID' && ($alpha_groups) && $type_opp && $one_type");
    safe_query("DELETE FROM ".PREFIX."cup_matches WHERE matchno='$cupID' && type='gs' && $type_opp && $one_type");

    redirect('admincenter.php?site=teams&'.$t_name2.'='.$cupID.'&type=gs', '<font color="red"><strong>Success!</strong></font>', 0);

}if($_GET['randomize']=='scores') {

    $gs_matches = safe_query("SELECT * FROM ".PREFIX."cup_matches  WHERE matchno='$cupID' && type='gs' && $type_opp && $one_type");
	    while($gm = mysql_fetch_array($gs_matches)) {
		
		    $score1 = rand(1,14);
			$score2 = rand(1,14);
			
			safe_query("UPDATE ".PREFIX."cup_matches SET score1='$score1', score2='$score2', confirmscore='1', einspruch='0' WHERE matchID='".$gm['matchID']."'");
		
		}
	    

redirect('admincenter.php?site=teams&'.$t_name2.'='.$cupID.'&type=gs', '<font color="red"><strong>Success!</strong></font>', 0);;

}if($_GET['action']=="leavecup") {

if($_GET['type']=="gs") {

$clanID = $_GET['clanID'];


    if($_GET['cupID'] && is1on1($_GET['cupID']))
    {
       $one_type = "1on1='1'";
    }
    elseif($_GET['laddID'] && ladderis1on1($_GET['laddID']))
    {
       $one_type = "1on1='1'";
    }
    else
    {
       $one_type = "1on1='0'";
    }

    $type_opp = ($_GET['cupID'] ? "ladID='0'" : "cupID='0'");
    $type = ($_GET['cupID'] ? "cupID" : "ladID");
    $alpha_groups = "type='gs'";

    safe_query("DELETE FROM ".PREFIX."cup_clans WHERE clanID='".$_GET['clanID']."' && groupID='$cupID' && ($alpha_groups) && $type_opp && $one_type");

    if(mysql_num_rows(mysql_query("SELECT * FROM ".PREFIX."cup_matches WHERE clan1='".$_GET['clanID']."' AND matchno='$cupID' AND clan1!='0' AND clan2!='0' && $one_type"))) 
    {	  
       safe_query("UPDATE ".PREFIX."cup_matches SET clan1='0' WHERE clan1='".$_GET['clanID']."' AND matchno='$cupID' AND clan2!='0'");  
    }
	else
    {
       safe_query("DELETE FROM ".PREFIX."cup_matches WHERE matchno='".$cupID."' && ($alpha_groups) && $type_opp='0' && (clan1='".$_GET['clanID']."' || clan2='".$_GET['clanID']."') && $one_type");		      
    }
    
    if(mysql_num_rows(mysql_query("SELECT * FROM ".PREFIX."cup_matches WHERE clan2='".$_GET['clanID']."' AND matchno='$cupID' AND clan1!='0' AND clan2!='0' && $one_type"))) 
    {	
       safe_query("UPDATE ".PREFIX."cup_matches SET clan2='0' WHERE clan2='".$_GET['clanID']."' AND matchno='$cupID' AND clan1!='0'");  
    }
	else
    {
       safe_query("DELETE FROM ".PREFIX."cup_matches WHERE matchno='".$cupID."' && ($alpha_groups) && $type_opp='0' && (clan1='".$_GET['clanID']."' || clan2='".$_GET['clanID']."') && $one_type");
    }

       redirect('admincenter.php?site=teams&'.$t_name2.'='.$cupID.'&type=gs', '', 0);
	   
    }
	else
    {

       safe_query("DELETE FROM ".PREFIX."cup_clans WHERE clanID='".$_GET['clanID']."' && $t_name='".$cupID."'");
       safe_query("UPDATE ".PREFIX."cup_clan_members SET cupID = '0' WHERE clanID='".$_GET['clanID']."'");
	   safe_query("DELETE FROM ".PREFIX."cup_clan_lineup WHERE $t_name='".$cupID."' && clanID='".$_GET['clanID']."'");

       redirect('admincenter.php?site=teams&'.$t_name2.'='.$cupID.'', '<center><b>Successfully Removed!</b><br>Redirecting<img src="../images/cup/period_ani.gif"></center>', 2);

    }

}elseif($_GET['action']=="deletematches") {

if($_GET['type']=="gs") {
    echo 'cannot delete group-stage matches if participant is already registered in a group. click on <img src="../images/cup/error.png" width="16" height="16"> instead.';
    redirect('admincenter.php?site=teams&'.$t_name2.'='.$cupID.$ext, '', 0);
}else{
    safe_query("DELETE FROM ".PREFIX."cup_matches WHERE $t_name='".$cupID."' && (clan1='".$_GET['clanID']."' || clan2='".$_GET['clanID']."')");
    redirect('admincenter.php?site=teams&'.$t_name2.'='.$cupID.$ext, '<center><b>Matches successfully removed!</b><br>Redirecting<img src="../images/cup/period_ani.gif"></center>', 2);
}


/* V4.1.5 LINEUP */

}elseif($_GET['action'] == 'lineup'){

$cupID = $cupID;
$clanID = $_GET['clanID'];
$type = ($_GET['cupID'] ? 'cupID' : 'ladID');

 //if checked, note to admin
 
    $checked = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE clanID='$clanID' && $t_name='$cupID' && 1on1='0' && checkin='1'");
	if(mysql_num_rows($checked)) echo '<div style="margin: 5px; padding: 6px; border: 4px solid #D6B4B4; text-align: center;"> <b>This team is already checked!</b> <br> Click <a href="../?site=clans&action=show&clanID='.$clanID.'&'.$t_name2.'='.$cupID.'#members" target="_blank">here</a> to view the lineup of this team in this cup.</div>';	

  //get members

      $query_lineup = safe_query("SELECT userID FROM ".PREFIX."cup_clan_lineup WHERE $type='$cupID' && clanID = '$clanID'");
        if(!mysql_num_rows($query_line))
        {
		    if($_GET['cupID'])
            $members=safe_query("SELECT userID FROM ".PREFIX."cup_clan_members WHERE cupID!='".$_GET['cupID']."'  && clanID = '$clanID'"); 
			else
			$members=safe_query("SELECT userID FROM ".PREFIX."cup_clan_members WHERE ladID!='".$_GET['laddID']."'  && clanID = '$clanID'"); 
        }
          while($ql = mysql_fetch_array($query_lineup))
          {
                $all_userIDs = $ql['userID'];
                $userIDs .= "userID != '$all_userIDs' && ";

	        if($_GET['cupID'])			  
		    $members=safe_query("SELECT userID FROM ".PREFIX."cup_clan_members WHERE $userIDs userID != '0' && cupID!='".$_GET['cupID']."' && clanID = '$clanID'");
            else
            $members=safe_query("SELECT userID FROM ".PREFIX."cup_clan_members WHERE $userIDs userID != '0' && ladID!='".$_GET['laddID']."' && clanID = '$clanID'"); 		
          }
		while($dv=mysql_fetch_array($members)) {
                    if($dv['userID']==$userID) { $nickname = '(You)'; }else{ $nickname = getnickname($dv['userID']); }
			        $member.='<option value="'.$dv['userID'].'">'.$nickname.'</option>';
		}			
  //dropdown		

		 $form = '<font color="#DD0000"><b>Not entered in the Cup:</b></font><br> Hold CTRL and left click to select/deselect members in your team.<br><br>
		           Who will participate in this cup?
		  <form method="post" action="admincenter.php?site=teams&action=lineup&'.$t_name2.'='.$cupID.'&clanID='.$clanID.'&do=insert">
                    <select multiple name="member[]" size="5">
                    '.$member.'
                    </select><br>
                   <input type="submit" value="Enter Selected" onclick="return confirm(\'Are you sure with your selection? \');">
		  </form>';
		  
  if(isset($_GET['do']) && $_GET['do'] == 'insert'){	

    $allIDs=$_POST['member'];
      foreach ($allIDs as $s) {
        //mysql_query("UPDATE ".PREFIX."cup_clan_members SET $t_name = '".$cupID."' WHERE userID = '".$s."' && clanID = '".$clanID."'");
        mysql_query("INSERT INTO ".PREFIX."cup_clan_lineup ($type, clanID, userID) VALUES ('$cupID', '".$clanID."', '".$s."')"); 
      redirect('admincenter.php?site=teams&action=lineup&'.$t_name2.'='.$cupID.'&clanID='.$_GET['clanID'], '', 0);
     }  
   }
 
  //get members

		$members=safe_query("SELECT userID FROM ".PREFIX."cup_clan_lineup WHERE $type='$cupID' && clanID = '$clanID'");
		while($dr=mysql_fetch_array($members)) {
                    if($dr['userID']==$userID) { $nickname = '(You)'; }else{ $nickname = getnickname($dr['userID']); }
			        $member2.='<option value="'.$dr['userID'].'">'.$nickname.'</option>';

  //dropdown		

		 $form2 = '<hr><font color="#00FF00"><b>Entered in the Cup:</b></font><br> Hold CTRL and left click to select/deselect members in your team.<br><br>
		            Who will not participate in this cup?
		  <form method="post" action="admincenter.php?site=teams&action=lineup&'.$t_name2.'='.$cupID.'&clanID='.$clanID.'&do=remove">
                    <select multiple name="member2[]" size="5">
                    '.$member2.'
                    </select><br>   
                   <input type="submit" value="Remove Selected" onclick="return confirm(\'Are you sure with your selection? \');">
		  </form>';   	

  if(isset($_GET['do']) && $_GET['do'] == 'remove'){	

    $allIDs=$_POST['member2'];
      foreach ($allIDs as $s) {
        safe_query("UPDATE ".PREFIX."cup_clan_members SET $t_name = '0' WHERE userID = '".$s."' && clanID = '".$clanID."'");
        safe_query("DELETE FROM ".PREFIX."cup_clan_lineup WHERE clanID='".$clanID."' && $t_name='$cupID' && userID='".$s."'");
      redirect('admincenter.php?site=teams&action=lineup&'.$t_name2.'='.$cupID.'&clanID='.$_GET['clanID'], '', 0); 
      
     }  
   }
 }echo $form.$form2; echo '<br><a href="?site=teams&'.$t_name2.'='.$cupID.'"><img border="0" src="../images/cup/icons/goback.png" width="16" height="16"> Go Back</a>';
   
/* END V4.1.5 */

}else{

	$cupID = $cupID;
	if($cupID){
	
	  if($_GET['type']=='gs') {
	         $l_link = ($_GET['cupID'] ? '../?site=groups&cupID='.$cupID.'" target="_blank"' : '../?site=groups&laddID='.$cupID.'" target="_blank"');
			 $l_image= '<img src="../images/cup/icons/groups.png" align="right">';
	  }
	  else{
	         $l_link = ($_GET['cupID'] ? '../?site=cups&action=details&cupID='.$cupID.'" target="_blank"' : '../?site=ladders&ID='.$cupID.'" target="_blank"');
			 $l_image= ($_GET['cupID'] ? '<img src="../images/cup/icons/tournament.png" align="right">' : '<img src="../images/cup/icons/ladder.png" align="right">');
	  }
		
	    if($_GET['cupID']) {	
		       $cupname = '<a href="'.$l_link.'><b>'.getcupname($cupID).'</b></a>'.$l_image;
		       $cupname1 = getcupname($cupID);
	 
	    }
	    else{
		       $cupname = '<a href="'.$l_link.'><b>'.getladname($cupID).'</b></a>'.$l_image;
		       $cupname1 = getladname($cupID);
        }
	 
//-- CHECK GROUPS --//

        $ID = $_GET[$t_name2];
        $name2 = $typename;
        $type = ($_GET['cupID'] ? "cupID" : "ladID");
        $type_opp = ($_GET['laddID'] ? "cupID" : "ladID");
        $alpha_groups = "type='gs'";
           
        $participant_ent = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND ($alpha_groups) AND $type_opp='0'");
        $ent_part = mysql_num_rows($participant_ent);
		
		//groups
		
		$rowsa = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='a'  AND $type_opp='0'");
		$rowsb = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='b'  AND $type_opp='0'");
		$rowsc = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='c'  AND $type_opp='0'");
		$rowsd = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='d'  AND $type_opp='0'");
		$rowse = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='e'  AND $type_opp='0'");
		$rowsf = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='f'  AND $type_opp='0'");
		$rowsg = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='g'  AND $type_opp='0'");
		$rowsh = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='h'  AND $type_opp='0'");
		$rowsi = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='i'  AND $type_opp='0'");
		$rowsj = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='j'  AND $type_opp='0'");
		$rowsk = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='k'  AND $type_opp='0'");
		$rowsl = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='l'  AND $type_opp='0'");
		$rowsm = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='m'  AND $type_opp='0'");
		$rowsn = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='n'  AND $type_opp='0'");
		$rowso = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='o'  AND $type_opp='0'");
		$rowsp = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='p'  AND $type_opp='0'");
		$rowsq = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='q'  AND $type_opp='0'");
		$rowsr = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='r'  AND $type_opp='0'");
		$rowss = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='s'  AND $type_opp='0'");
		$rowst = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='t'  AND $type_opp='0'");
		$rowsu = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='u'  AND $type_opp='0'");
		$rowsv = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='v'  AND $type_opp='0'");
		$rowsw = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='w'  AND $type_opp='0'");
		$rowsx = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='x'  AND $type_opp='0'");
		$rowsy = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='y'  AND $type_opp='0'");
		$rowsz = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='z'  AND $type_opp='0'");
		$rowsa2 = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='a2'  AND $type_opp='0'");
		$rowsb2 = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='b2'  AND $type_opp='0'");
		$rowsc2 = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='c2'  AND $type_opp='0'");
		$rowsd2 = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='d2'  AND $type_opp='0'");
		$rowse2 = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='e2'  AND $type_opp='0'");
		$rowsf2 = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='f2'  AND $type_opp='0'");
		
		$a_rows = mysql_num_rows($rowsa);
		$b_rows = mysql_num_rows($rowsb);
		$c_rows = mysql_num_rows($rowsc);
		$d_rows = mysql_num_rows($rowsd);
		$e_rows = mysql_num_rows($rowse);
		$f_rows = mysql_num_rows($rowsf);
		$g_rows = mysql_num_rows($rowsg);
		$h_rows = mysql_num_rows($rowsh);
		$i_rows = mysql_num_rows($rowsi);
		$j_rows = mysql_num_rows($rowsj);
		$k_rows = mysql_num_rows($rowsk);
		$l_rows = mysql_num_rows($rowsl);
		$m_rows = mysql_num_rows($rowsm);
		$n_rows = mysql_num_rows($rowsn);
		$o_rows = mysql_num_rows($rowso);
		$p_rows = mysql_num_rows($rowsp);
		$q_rows = mysql_num_rows($rowsq);
		$r_rows = mysql_num_rows($rowsr);
		$s_rows = mysql_num_rows($rowss);
		$t_rows = mysql_num_rows($rowst);
		$u_rows = mysql_num_rows($rowsu);
		$v_rows = mysql_num_rows($rowsv);
		$w_rows = mysql_num_rows($rowsw);
		$x_rows = mysql_num_rows($rowsx);
		$y_rows = mysql_num_rows($rowsy);
		$z_rows = mysql_num_rows($rowsz);
		$a2_rows = mysql_num_rows($rowsa2);
		$b2_rows = mysql_num_rows($rowsb2);
		$c2_rows = mysql_num_rows($rowsc2);
		$d2_rows = mysql_num_rows($rowsd2);
		$e2_rows = mysql_num_rows($rowse2);
		$f2_rows = mysql_num_rows($rowsf2);
		//end check

	    $day = date('d');
	    $month = date('m');
	    $year = date('Y');
        $hour = date('H');
	    $min = date('i');
     	$date = @mktime($hour, $min, 0, $month, $day, $year);
     	 
		$ergebnis2 = mysql_query("SELECT count(*) as anzahl FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type_opp='0' AND type='gs'");
		$dv=mysql_fetch_array($ergebnis2);

//check what group
		         
	    // DROPDOWN GROUPINGS
	  
	      $dd_groups = ($a_rows < 4 ? '<option value="a">Group A</option>' : '');
	      $dd_groups.= ($b_rows < 4 ? '<option value="b">Group B</option>' : '');
	      $dd_groups.= ($c_rows < 4 ? '<option value="c">Group C</option>' : '');
	      $dd_groups.= ($d_rows < 4 ? '<option value="d">Group D</option>' : '');
		  
		if($set['maxclan'] == 160 OR $set['maxclan'] == 16 OR $set['maxclan'] == 32 OR $set['maxclan']==320 OR $set['maxclan'] == 64 OR $set['maxclan']==640) {
		  
	      $dd_groups.= ($e_rows < 4 ? '<option value="e">Group E</option>' : '');
	      $dd_groups.= ($f_rows < 4 ? '<option value="f">Group F</option>' : '');
	      $dd_groups.= ($g_rows < 4 ? '<option value="g">Group G</option>' : '');
	      $dd_groups.= ($h_rows < 4 ? '<option value="h">Group H</option>' : '');
		}  
        if($set['maxclan'] == 32 OR $set['maxclan']==320 OR $set['maxclan'] == 64 OR $set['maxclan']==640) {
		  
	      $dd_groups.= ($i_rows < 4 ? '<option value="i">Group I</option>' : '');
	      $dd_groups.= ($j_rows < 4 ? '<option value="j">Group J</option>' : '');
	      $dd_groups.= ($k_rows < 4 ? '<option value="k">Group K</option>' : '');
	      $dd_groups.= ($l_rows < 4 ? '<option value="l">Group L</option>' : '');
	      $dd_groups.= ($m_rows < 4 ? '<option value="m">Group M</option>' : '');
	      $dd_groups.= ($n_rows < 4 ? '<option value="n">Group N</option>' : '');
	      $dd_groups.= ($o_rows < 4 ? '<option value="o">Group O</option>' : '');
	      $dd_groups.= ($p_rows < 4 ? '<option value="p">Group P</option>' : '');
		}  
		if($set['maxclan'] == 64 OR $set['maxclan']==640) {  
		  
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
		  
		if($set['maxclan'] == 160 OR $set['maxclan'] == 16 OR $set['maxclan'] == 32 OR $set['maxclan']==320 OR $set['maxclan'] == 64 OR $set['maxclan']==640) {		 
		 
	      if($e_rows < 4) $groups[] = 'e';
		  if($f_rows < 4) $groups[] = 'f';
		  if($g_rows < 4) $groups[] = 'g';
		  if($h_rows < 4) $groups[] = 'h';
		}  
        if($set['maxclan'] == 32 OR $set['maxclan']==320 OR $set['maxclan'] == 64 OR $set['maxclan']==640) {
		
	      if($i_rows < 4) $groups[] = 'i';
		  if($j_rows < 4) $groups[] = 'j';
		  if($k_rows < 4) $groups[] = 'k';
		  if($l_rows < 4) $groups[] = 'l';
		  if($m_rows < 4) $groups[] = 'm';
		  if($n_rows < 4) $groups[] = 'n';
		  if($o_rows < 4) $groups[] = 'o';
		  if($p_rows < 4) $groups[] = 'p';

		}  
		if($set['maxclan'] == 64 OR $set['maxclan']==640) {
		
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

	 
  $dd_groups .= '<option value="randomized" selected>Randomized Grouping</option>';	 
	 
  if($dv['anzahl'] >= $set['maxclan']+$set['maxclan'])
     $dd_groups_sel = '<option value="">(no spaces available)</option>'; 
  else 
     $dd_groups_sel = $dd_groups;

	 
//END GROUP CHECKING


		if($typename($cupID)){
		
//title cup

		  if($_GET['type']=="gs" && $_GET['cupID'])
		     echo 'Showing: <strong>Group-stages</strong> (<a href="admincenter.php?site=teams&cupID='.$_GET['cupID'].'"><strong>switch to tournament</strong></a>)';
		  elseif($_GET['cupID'])
		     echo 'Showing: <strong>Tournament</strong> (<a href="admincenter.php?site=teams&cupID='.$_GET['cupID'].'&type=gs"><strong>switch to group-stages</strong></a>)';
		  elseif($_GET['type']=="gs" && $_GET['laddID'])
		     echo 'Showing: <strong>Group-stages</strong> (<a href="admincenter.php?site=teams&laddID='.$_GET['laddID'].'"><strong>switch to ladder</strong></a>)';
		  elseif($_GET['laddID'])
		     echo 'Showing: <strong>Ladder</strong> (<a href="admincenter.php?site=teams&laddID='.$_GET['laddID'].'&type=gs"><strong>switch to group-stages</strong></a>)';
	
if($_GET['cupID']) {

$participants = (is1on1($_GET['cupID']) ? 'Players' : 'Teams');
	
echo '<h2>'.getcupname($_GET['cupID']).'</h2>

<table width="100%" cellpadding="2" cellspacing="1" bgcolor="'.$border.'">
	<tr>
		<td class="title" bgcolor="'.$bghead.'" width="12%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=cups&action=edit&ID='.$cupID.'">Edit Cup</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp; '.$participants.'</td>
		<td class="title" bgcolor="'.$bghead.'" width="14%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=cups&action=baum&ID='.$cupID.'">Brackets</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="12%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=cups&action=rules&ID='.$cupID.'">Rules</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="14%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=cups&action=admins&ID='.$cupID.'">Admins</a></td>
        <td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=matches&cupID='.$cupID.'">Matches</a></td>		
	</tr>
</table><br />';

}
elseif($_GET['laddID']) {

//title ladder

$ID = $_GET['laddID'];
$participants = (ladderis1on1($ID) ? 'Players' : 'Teams');	

echo '

<table width="100%" cellpadding="2" cellspacing="1" bgcolor="'.$border.'">
	<tr>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=ladders&action=edit&ID='.$ID.'">Edit Ladder</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;'.$participants.'</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=ladders&action=standings&ID='.$ID.'">Standings</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=ladders&action=rules&ID='.$ID.'">Rules</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=ladders&action=admins&ID='.$ID.'">Admins</a></td>
        <td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=matches&laddID='.$ID.'">Matches</a></td>		
	</tr>
</table><br><br>'; 

}
	
if($typename($cupID)) $participants = 'Manage Players';
else $participants = 'Manage Teams';
	
		  $participants = safe_query("SELECT count(*) as entered FROM ".PREFIX."cup_clans WHERE $t_name='$cupID' && 1on1='1'");
		  $checked = safe_query("SELECT count(*) as checked FROM ".PREFIX."cup_clans WHERE $t_name='$cupID' && 1on1='1' && checkin='1'");
		
		  $all=mysql_fetch_array($participants); 
		  $is=mysql_fetch_array($checked); 
		
		  if(isset($_GET['cupID'])) {
		         $info = safe_query("SELECT * FROM ".PREFIX."cups WHERE ID='$cupID'");
		  }
		  else{
		         $info = safe_query("SELECT * FROM ".PREFIX."cup_ladders WHERE ID='$cupID'");
		  }
		  
		  $type_opp = ($_GET['cupID'] ? 'ladID' : 'cupID');
		  
		  $sp=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchno='".$cupID."' && $type_opp='0' && type='gs' && si='0' && 1on1='1'"));		
		  $all_vs_all = (is_array($sp) ? true : false);

		  $lad = mysql_fetch_array($info);		  
          $dv=mysql_fetch_array(safe_query("SELECT count(*) as anzahl FROM ".PREFIX."cup_clans WHERE groupID='".$cupID."' && $type_opp='0' && 1on1='1' AND type='gs'"));  
		  
		  if($lad['maxclan'] == 80 || $lad['maxclan']== 8)
			  $max = 8;
		  elseif($lad['maxclan'] == 160 || $lad['maxclan']== 16)
			  $max = 16;
	  	  elseif($lad['maxclan'] == 320 || $lad['maxclan']== 32)
			  $max = 32;
		  elseif($lad['maxclan'] == 640 || $lad['maxclan']== 64) 
	  		  $max = 64; 
			  
		  $max_participants = $max+$max;	  
		  
          if($dv['anzahl'] == $max+$max || $all_vs_all==true) {
                $slots = "League Full";
                $slots_ext = '';
          }
          else{
                $slots = $max+$max-$dv['anzahl']." Slots Available";
                $slots_ext = '/'.$max_participants;      
          } 

		  $ergebnis = safe_query("SELECT count( ID ) as clans FROM ".PREFIX."cup_clans WHERE ".($_GET['cupID'] ? 'cupID' : 'ladID')." = '".$cupID."' && 1on1='1'");
		  $db = mysql_fetch_array($ergebnis);		  
		  
		  if($_GET['type']=='gs') {	 
		         $num = $slots.' ('.$dv['anzahl'].$slots_ext.')';
		  }
		  else{
		         $num = $db['clans'].' / '.$max;
		  }
		
          if($_GET['type']=="gs") {
		       
			   $tb_hd_ga = '';
			   $gs_group_head = '<td class="title2" align="center"><a href="admincenter.php?site=teams&'.$t_name2.'='.$cupID.'&type=gs'.($_GET['order']=="groups" ? "" : "&order=groups").'"><b>Group</b></a></td>';

               if($_GET['order']=="groups") {
                   $group_order = "ORDER BY $t_name3 DESC";
               }
			   else{
                   $group_order = "ORDER BY $t_name3 ASC";           
               }
		  }
		  else{      
               $group_order = "ORDER BY ID ASC";
			   $tb_hd_ga = '<td class="title2" align="center"><b>G-ACC</b></td>';
          }
		  
			if($_GET['cupID'] && $_GET['type']!='gs') {
                   $tb_hd_st = '<td class="title2" align="center"><b>Status</b></td>';
            }
            else{
                   $tb_hd_st = '';
            }

            $type_opp = ($_GET['cupID'] ? "ladID" : "cupID");	

			if($_GET['type']=='gs') {
			   $tb_typ = 'gs';
			   $add_ex = "&& $type_opp = '0'";
			}
			elseif($_GET['cupID']) {
			   $tb_typ = 'cup';
			   $add_ex = '';
			}
			elseif($_GET['laddID']) {
			   $tb_typ = 'ladder';
			   $add_ex = '';
			}
						
			$ergebnis = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE $t_name = '$cupID' $add_ex && 1on1='1' && type='$tb_typ' $group_order");
			
            if(mysql_num_rows($ergebnis)) {			
			 			eval ("\$one_head = \"".gettemplate("1on1_head")."\";");
			            echo $one_head;			
			}
			else{ 
			            echo '<div '.$error_box.'> No participants found</div>';
			}
			
			while($db=mysql_fetch_array($ergebnis)) {
				$ergebnis2 = safe_query("SELECT * FROM ".PREFIX."user WHERE userID='".$db['clanID']."'");
				$ds=mysql_fetch_array($ergebnis2);
				
				$nickname='<a href="../?site=profile&id='.$ds['userID'].'" target="_blank"><b>'.getnickname($ds['userID']).'</b></a>';
				$nickname1 = getnickname($ds['userID']);

              if($_GET['type']=="gs") 
                 $gs_group_content = '<td align="center"><b>'.strtoupper(returnGroup($db['clanID'],$cupID)).'</b></td>';	         
				
	          if(!$ds['country'] || $ds['country']==na || $ds['country']==is_numeric) {
	            $country = '<img src="../images/flags/na.gif" border="0" width="20" height="13">';
	          }else{ 
	            $country = '<img src="../images/flags/'.$ds[country].'.gif" width="20" height="13">'; 
	          }			
				
				if(!$_GET['laddID'])
				    $ergebnis2 = safe_query("SELECT * FROM ".PREFIX."cups WHERE ID = $cupID");		
				else
                    $ergebnis2 = safe_query("SELECT * FROM ".PREFIX."cup_ladders WHERE ID = $cupID");	
				    
			    $cup=mysql_fetch_array($ergebnis2);
					
				$gameacc_sql = safe_query("SELECT * FROM ".PREFIX."user_gameacc WHERE type='".$cup['gameaccID']."' AND userID='".$ds['userID']."'");
				
				if(mysql_num_rows($gameacc_sql)){
					  $dl=mysql_fetch_array($gameacc_sql);
					  $game_acc = $dl[value];
				}
				else{
					  $game_acc = '<font color="'.$loosecolor.'">Not entered</a>';
				}
				
				if($_GET['cupID'] && $_GET['type']!='gs') {
				
				    if($db['checkin']) {
					      $checkin = '<input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=teams&action=uncheck&clanID='.$ds['userID'].'&'.$t_name2.'='.$cupID.$ext.'\');return document.MM_returnValue" value="Uncheck">';
				 	      $nickname.= '<img src="../images/icons/online.gif" border="0" alt="Checked" title="Checked" align="right"/>';
				    }
				    else{
					      $checkin = '<input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=teams&action=checkin&clanID='.$ds['userID'].'&'.$t_name2.'='.$cupID.$ext.'\');return document.MM_returnValue" value="Checkin">';
					      $nickname.= '<img src="../images/icons/offline.gif" border="0" alt="Unchecked" title="Unchecked" align="right" />'; 
			        }
				    
					$tb_st_cnt = '<td align="center">'.$checkin.'</td>';
				}
				
				if($_GET['type']!='gs') {
					   $tb_cnt_ga = '<td align="center">'.$game_acc.'</td>';
				}
				else{
				       $tb_cnt_ga = '';
				}
						
			    //check if blocked
			    
					 $getpoints = safe_query("SELECT SUM(points) as totalpoints FROM ".PREFIX."cup_warnings WHERE clanID='".$ds['userID']."' && expired='0' && 1on1='1'");
					 $do=mysql_fetch_array($getpoints);
             
             	     $block = safe_query("SELECT cupblockage FROM ".PREFIX."cup_settings");	
	                 $dt=mysql_fetch_array($block); $cupblockage = $dt['cupblockage']-$do['totalpoints'];  

                     if($do['totalpoints'] >= $dt['cupblockage']) { 
					        $blockstatus = '<font color="#DD0000"><b>Locked</b></font>'; 
				     }
					 else{ 
					        $blockstatus = '<font color="#00FF00"><b>Unlocked</b></font>'; 
					 }
					
					 $part_pp = (empty($do['totalpoints']) ? '0' : $do['totalpoints']);
					
			    if($_GET['type']=='gs') {
                      $show_delete_cont = "<td align=\"center\"><a onClick=\"return confirm('Note: To delete matches you must also remove the team - click on the red X on your right.');\"><img border=\"0\" id=\"myImage\" alt=\"To delete matches you must also remove the team - click on the red X on your right.\" src=\"../images/cup/add_result.gif\" width=\"20\" height=\"20\"></td>";
                }	
                else{
                      $show_delete_cont = "<td align=\"center\"><a href=\"admincenter.php?site=teams&action=deletematches&clanID=$ds[userID]&$t_name2=$cupID$ext\" onClick=\"return confirm('WARNING: Are you sure you want to remove ALL $nickname1\'s matches from $cupname1?');\"><img border=\"0\" src=\"../images/cup/icons/add_result.gif\" width=\"20\" height=\"20\"></a></td>";
                }				
			   
				eval ("\$one_content = \"".gettemplate("1on1_content")."\";");
				echo $one_content;
			}
			
			if(mysql_num_rows($ergebnis)) {		
			
			    eval ("\$team_foot = \"".gettemplate("footer")."\";");
			    echo $team_foot;	
			}
			
			if($_GET['type']=='gs' && mysql_num_rows($ergebnis))
			
                        echo '<br /><a href="admincenter.php?site=teams&'.$t_name2.'='.$cupID.'&delete=all" onclick="return confirm(\'Do you really want to remove matches and participants for this group league? \');"><img src="../images/cup/icons/go.png"> <strong>Delete all group participants and matches</strong></a>
						      <br /><a href="admincenter.php?site=teams&'.$t_name2.'='.$cupID.'&randomize=scores" onclick="return confirm(\'Finish matches and randomize scores? (Testing purposes) \');"><img src="../images/cup/icons/go.png"> <strong>Randomize scores and finish matches</strong></a>';			
			
			 //dropdown - add users to cup
			 
			 if($_GET['type']=="gs") {			            
                               $gs_signup = '<br /><strong>Group:</strong> <select name="group">'.$dd_groups_sel.'</select>';   
			       $qry_type = "groupID = '$cupID' && type = 'gs' && $type_opp = '0'";			    
			 }
			 else{
			       $gs_signup = "";
			       $qry_type = "$t_name = '$cupID'";
			 }
			 
			 
                         $participants = safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE ".$qry_type." && 1on1='1'");
                            while($up=mysql_fetch_array($participants)) {  
				               $ent_IDs[]=$up['clanID'];
                         }
						 
			   $users = safe_query("SELECT userID FROM ".PREFIX."user");

			   echo '<br><br>
			         <form method="post" action="admincenter.php?site=teams&'.$t_name2.'='.$cupID.'">
			           <select name="users[]" multiple size="10" onblur="countit(this)">';
				   
				     while($dv=mysql_fetch_assoc($users)) {
				     
				       if(!in_array($dv['userID'],$ent_IDs)) {
				         echo '<option value="'.$dv['userID'].'">('.$dv['userID'].') '.getnickname($dv['userID']).'</option>';
			               }
				     }  
 
			   echo '</select>
                              <input type="hidden" name="cupID" value="'.$cupID.'">
                                    '.$gs_signup.'
	                          <br><input type="submit" name="enterusers" value="Enter Users">
		                 </form>';	      
			   
			 //dropdown - remove users from cup
			 
			   $type_opp = (isset($_GET['cupID']) ? 'ladID' : 'cupID');
			 
			   if(isset($_GET['type']) && $_GET['type']=='gs') 
			       $lg_type = 'gs';
			   elseif(isset($_GET['cupID'])) {
			       $lg_type = 'cup';
			   }
			   else{
			       $lg_type = 'ladder';
			   }
			 
			   $participants = safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE $t_name='".$cupID."' && $type_opp = '0' && 1on1='1' AND type='$lg_type'");
			   if(mysql_num_rows($participants)) {
			           
			   echo '<br><br><form method="post" action="admincenter.php?site=teams&'.$t_name2.'='.$cupID.'">
			                   <select name="users[]" multiple size="10">';
			                   
					while($dv=mysql_fetch_array($participants)) {
					           echo '<option value="'.$dv['clanID'].'">('.$dv['clanID'].') '.getnickname($dv['clanID']).'</option>';
		            }
		          
                    $gs_input = (isset($_GET['type'])==gs ? '<input type="hidden" name="groups_true" value="1">' : '');
		          
			        echo' </select>
                          <input type="hidden" name="cupID" value="'.$cupID.'">
                          '.$gs_input.' <br>
                          '.($_GET['type']!="gs" ? '<input type="checkbox" name="removematches" value="ON" checked> Also remove matches?' : '').'
	                      <br><br><input type="submit" name="removeusers" value="Remove Users">
		                  </form>';
		       
		            if($_GET['type']=="gs") echo "<br /><b>Important:</b> Removing users will also delete their pre-set match(es).";			  
			   }

//remove participants from group

if($_GET['type']=='gs' && mysql_num_rows($ergebnis)) {

			   echo '<br><br><form method="post" action="admincenter.php?site=teams&'.$t_name2.'='.$cupID.'&type=gs">
			                   <select name="group">
                                              <option value="a">Group A</option>
					      <option value="b">Group B</option>
					      <option value="c">Group C</option>
					      <option value="d">Group D</option>
					      <option value="e">Group E</option>
				              <option value="f">Group F</option>
					      <option value="g">Group G</option>
					      <option value="h">Group H</option>
                                             <br><br><input type="submit" name="removegroup" value="Remove Group Participants">
			                   </select>
                                         </form>';

}

if($_POST['removegroup']){
     safe_query("DELETE FROM ".PREFIX."cup_clans WHERE $type='".$_POST['group']."' && groupID='$cupID' && $type_opp='0' && type='gs' && $one_type");  
	 safe_query("DELETE FROM ".PREFIX."cup_matches WHERE matchno='$cupID' && type='gs' && $type_opp='0' && $one_type && type='gs' && $t_name3='".$_POST['group']."'");
     redirect('admincenter.php?site=teams&'.$t_name2.'='.$cupID.'&type=gs', '', 0);
}

//

		       
if($_POST['enterusers']) { 
	$cupID = $_POST['cupID'];
	$ID = $_POST['cupID'];
	$users = $_POST['users'];	
	
	if(is_array($users)) {
		foreach($users as $id) {
		
		if($_POST['group']) {
		 
                $participant_ent = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND ($alpha_groups) AND $type_opp='0'");
                $ent_part = mysql_num_rows($participant_ent);
		
		//groups
		
		$rowsa = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='a'  AND $type_opp='0'");
		$rowsb = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='b'  AND $type_opp='0'");
		$rowsc = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='c'  AND $type_opp='0'");
		$rowsd = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='d'  AND $type_opp='0'");
		$rowse = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='e'  AND $type_opp='0'");
		$rowsf = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='f'  AND $type_opp='0'");
		$rowsg = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='g'  AND $type_opp='0'");
		$rowsh = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='h'  AND $type_opp='0'");
		$rowsi = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='i'  AND $type_opp='0'");
		$rowsj = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='j'  AND $type_opp='0'");
		$rowsk = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='k'  AND $type_opp='0'");
		$rowsl = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='l'  AND $type_opp='0'");
		$rowsm = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='m'  AND $type_opp='0'");
		$rowsn = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='n'  AND $type_opp='0'");
		$rowso = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='o'  AND $type_opp='0'");
		$rowsp = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='p'  AND $type_opp='0'");
		$rowsq = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='q'  AND $type_opp='0'");
		$rowsr = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='r'  AND $type_opp='0'");
		$rowss = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='s'  AND $type_opp='0'");
		$rowst = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='t'  AND $type_opp='0'");
		$rowsu = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='u'  AND $type_opp='0'");
		$rowsv = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='v'  AND $type_opp='0'");
		$rowsw = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='w'  AND $type_opp='0'");
		$rowsx = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='x'  AND $type_opp='0'");
		$rowsy = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='y'  AND $type_opp='0'");
		$rowsz = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='z'  AND $type_opp='0'");
		$rowsa2 = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='a2'  AND $type_opp='0'");
		$rowsb2 = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='b2'  AND $type_opp='0'");
		$rowsc2 = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='c2'  AND $type_opp='0'");
		$rowsd2 = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='d2'  AND $type_opp='0'");
		$rowse2 = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='e2'  AND $type_opp='0'");
		$rowsf2 = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='f2'  AND $type_opp='0'");
		
		$a_rows = mysql_num_rows($rowsa);
		$b_rows = mysql_num_rows($rowsb);
		$c_rows = mysql_num_rows($rowsc);
		$d_rows = mysql_num_rows($rowsd);
		$e_rows = mysql_num_rows($rowse);
		$f_rows = mysql_num_rows($rowsf);
		$g_rows = mysql_num_rows($rowsg);
		$h_rows = mysql_num_rows($rowsh);
		$i_rows = mysql_num_rows($rowsi);
		$j_rows = mysql_num_rows($rowsj);
		$k_rows = mysql_num_rows($rowsk);
		$l_rows = mysql_num_rows($rowsl);
		$m_rows = mysql_num_rows($rowsm);
		$n_rows = mysql_num_rows($rowsn);
		$o_rows = mysql_num_rows($rowso);
		$p_rows = mysql_num_rows($rowsp);
		$q_rows = mysql_num_rows($rowsq);
		$r_rows = mysql_num_rows($rowsr);
		$s_rows = mysql_num_rows($rowss);
		$t_rows = mysql_num_rows($rowst);
		$u_rows = mysql_num_rows($rowsu);
		$v_rows = mysql_num_rows($rowsv);
		$w_rows = mysql_num_rows($rowsw);
		$x_rows = mysql_num_rows($rowsx);
		$y_rows = mysql_num_rows($rowsy);
		$z_rows = mysql_num_rows($rowsz);
		$a2_rows = mysql_num_rows($rowsa2);
		$b2_rows = mysql_num_rows($rowsb2);
		$c2_rows = mysql_num_rows($rowsc2);
		$d2_rows = mysql_num_rows($rowsd2);
		$e2_rows = mysql_num_rows($rowse2);
		$f2_rows = mysql_num_rows($rowsf2);
		//end check


            $day = date('d');
	        $month = date('m');
	        $year = date('Y');
            $hour = date('H');
	        $min = date('i');
     	    $date = @mktime($hour, $min, 0, $month, $day, $year);
     	
		$ergebnis2 = mysql_query("SELECT count(*) as anzahl FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type_opp='0' AND type='gs'");
		$dv=mysql_fetch_array($ergebnis2);

//check what group
 
	    // DROPDOWN GROUPINGS
	  
	      $dd_groups = ($a_rows < 4 ? '<option value="a">Group A</option>' : '');
	      $dd_groups.= ($b_rows < 4 ? '<option value="b">Group B</option>' : '');
	      $dd_groups.= ($c_rows < 4 ? '<option value="c">Group C</option>' : '');
	      $dd_groups.= ($d_rows < 4 ? '<option value="d">Group D</option>' : '');
		  
		if($set['maxclan'] == 160 OR $set['maxclan'] == 16 OR $set['maxclan'] == 32 OR $set['maxclan']==320 OR $set['maxclan'] == 64 OR $set['maxclan']==640) {
		  
	      $dd_groups.= ($e_rows < 4 ? '<option value="e">Group E</option>' : '');
	      $dd_groups.= ($f_rows < 4 ? '<option value="f">Group F</option>' : '');
	      $dd_groups.= ($g_rows < 4 ? '<option value="g">Group G</option>' : '');
	      $dd_groups.= ($h_rows < 4 ? '<option value="h">Group H</option>' : '');
		}  
        if($set['maxclan'] == 32 OR $set['maxclan']==320 OR $set['maxclan'] == 64 OR $set['maxclan']==640) {
		  
	      $dd_groups.= ($i_rows < 4 ? '<option value="i">Group I</option>' : '');
	      $dd_groups.= ($j_rows < 4 ? '<option value="j">Group J</option>' : '');
	      $dd_groups.= ($k_rows < 4 ? '<option value="k">Group K</option>' : '');
	      $dd_groups.= ($l_rows < 4 ? '<option value="l">Group L</option>' : '');
	      $dd_groups.= ($m_rows < 4 ? '<option value="m">Group M</option>' : '');
	      $dd_groups.= ($n_rows < 4 ? '<option value="n">Group N</option>' : '');
	      $dd_groups.= ($o_rows < 4 ? '<option value="o">Group O</option>' : '');
	      $dd_groups.= ($p_rows < 4 ? '<option value="p">Group P</option>' : '');
		}  
		if($set['maxclan'] == 64 OR $set['maxclan']==640) {  
		  
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
		  
		if($set['maxclan'] == 160 OR $set['maxclan'] == 16 OR $set['maxclan'] == 32 OR $set['maxclan']==320 OR $set['maxclan'] == 64 OR $set['maxclan']==640) {		 
		 
	      if($e_rows < 4) $groups[] = 'e';
		  if($f_rows < 4) $groups[] = 'f';
		  if($g_rows < 4) $groups[] = 'g';
		  if($h_rows < 4) $groups[] = 'h';
		}  
        if($set['maxclan'] == 32 OR $set['maxclan']==320 OR $set['maxclan'] == 64 OR $set['maxclan']==640) {
		
	      if($i_rows < 4) $groups[] = 'i';
		  if($j_rows < 4) $groups[] = 'j';
		  if($k_rows < 4) $groups[] = 'k';
		  if($l_rows < 4) $groups[] = 'l';
		  if($m_rows < 4) $groups[] = 'm';
		  if($n_rows < 4) $groups[] = 'n';
		  if($o_rows < 4) $groups[] = 'o';
		  if($p_rows < 4) $groups[] = 'p';

		}  
		if($set['maxclan'] == 64 OR $set['maxclan']==640) {
		
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
	 
  $dd_groups .= '<option value="randomized" selected>Randomized Grouping</option>';	 
	 
  if($dv['anzahl'] >= $set['maxclan']+$set['maxclan'])
     $dd_groups_sel = '<option value="">(no spaces available)</option>'; 
  else 
     $dd_groups_sel = $dd_groups;

		
//-- GROUP STAGES ONLY --//

        $rg = $random_group;

		  if(!iscupadmin($userID)) {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Access denied.</div>';    
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);
		  }
		  elseif($dv['anzahl'] >= $set['maxclan']+$set['maxclan']) {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Too much players</div>'; 
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);
		  }
		  elseif($a_rows == 4 && $_POST['group']=="a") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group A is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($b_rows == 4 && $_POST['group']=="b") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group B is already filled up.</div>';    
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($c_rows == 4 && $_POST['group']=="c") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group C is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($d_rows == 4 && $_POST['group']=="d") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group D is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($e_rows == 4 && $_POST['group']=="e") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group E is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($f_rows == 4 && $_POST['group']=="f") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group F is already filled up.</div>';    
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($g_rows == 4 && $_POST['group']=="g") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group G is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($h_rows == 4 && $_POST['group']=="h") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group H is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($i_rows == 4 && $_POST['group']=="i") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group I is already filled up.</div>';    
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($j_rows == 4 && $_POST['group']=="j") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group J is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($k_rows == 4 && $_POST['group']=="k") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group K is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($l_rows == 4 && $_POST['group']=="l") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group L is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($m_rows == 4 && $_POST['group']=="m") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group M is already filled up.</div>';    
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($n_rows == 4 && $_POST['group']=="n") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group N is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($o_rows == 4 && $_POST['group']=="o") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group O is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($p_rows == 4 && $_POST['group']=="p") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group P is already filled up.</div>';    
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($q_rows == 4 && $_POST['group']=="q") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group W is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($r_rows == 4 && $_POST['group']=="r") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group R is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($s_rows == 4 && $_POST['group']=="s") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group S is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($t_rows == 4 && $_POST['group']=="t") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group T is already filled up.</div>';    
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($u_rows == 4 && $_POST['group']=="u") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group U is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($v_rows == 4 && $_POST['group']=="v") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group V is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($w_rows == 4 && $_POST['group']=="w") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group W is already filled up.</div>';    
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($x_rows == 4 && $_POST['group']=="x") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group X is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($y_rows == 4 && $_POST['group']=="y") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group Y is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($z_rows == 4 && $_POST['group']=="z") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group Z is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($a2_rows == 4 && $_POST['group']=="a2") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group A2 is already filled up.</div>';    
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($b2_rows == 4 && $_POST['group']=="b2") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group B2 is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($c2_rows == 4 && $_POST['group']=="c2") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group C2 is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($d2_rows == 4 && $_POST['group']=="d2") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group D2 is already filled up.</div>';    
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($e2_rows == 4 && $_POST['group']=="e2") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group E2 is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($f2_rows == 4 && $_POST['group']=="f2") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group F2 is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);                
	} 
	else{
	
   if($name2($ID)) {
          
             if($_POST['group']!="randomized") {    
                mysql_query("INSERT INTO ".PREFIX."cup_clans (`$type`, $plat `groupID`, `clanID`, `1on1`, `type`) VALUES ('".$_POST['group']."', $platID '$ID', '$id', '1', 'gs')");
                  if(mysql_num_rows(mysql_query("SELECT * FROM ".PREFIX."cup_matches WHERE $type='".$_POST['group']."' AND matchno='$ID' AND clan1!='0' AND clan2='0'"))) {
                     mysql_query("UPDATE ".PREFIX."cup_matches SET clan2='$id' WHERE $type='".$_POST['group']."' AND matchno='$ID' AND clan2='0'"); 
                     redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 0);         
                  }else{ 
                     mysql_query("INSERT INTO ".PREFIX."cup_matches (`$type`, `$type_opp`, `date`, `matchno`, `clan1`, `comment`, `1on1`, `si`, `type`) VALUES ('".$_POST['group']."', '0', '$date', '$ID', '$id', '2', '1', '1', 'gs')");
                     redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 0);
                  }
             }else{               
             
                mysql_query("INSERT INTO ".PREFIX."cup_clans (`$type`, $plat `groupID`, `clanID`, `1on1`, `type`) VALUES ('$rg', $platID '$ID', '$id', '1', 'gs')");
                  if(mysql_num_rows(mysql_query("SELECT * FROM ".PREFIX."cup_matches WHERE $type='$rg' AND matchno='$ID' AND clan1!='0' AND clan2='0'"))) {
                     mysql_query("UPDATE ".PREFIX."cup_matches SET clan2='$id' WHERE $type='$rg' AND matchno='$ID' AND clan2='0'"); 
                     redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 0);
                  }else{
                     mysql_query("INSERT INTO ".PREFIX."cup_matches (`$type`, `$type_opp`, `date`, `matchno`, `clan1`, `comment`, `1on1`, `si`, `type`) VALUES ('$rg', '0', '$date', '$ID', '$id', '2', '1', '1', 'gs')"); 
                     redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 0);
                  }
             }
             
          }else{
                
            if($_POST['group']!="randomized") { 
                mysql_query("INSERT INTO ".PREFIX."cup_clans (`$type`, $plat `groupID`, `clanID`, `1on1`, `type`) VALUES ('".$_POST['group']."', $platID '$ID', '$id', '0', 'gs')");
                  if(mysql_num_rows(mysql_query("SELECT * FROM ".PREFIX."cup_matches WHERE $type='".$_POST['group']."' AND matchno='$ID' AND clan1!='0' AND clan2='0'"))) {
                     mysql_query("UPDATE ".PREFIX."cup_matches SET clan2='$id' WHERE $type='".$_POST['group']."' AND matchno='$ID' AND clan2='0'"); 
                     redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 0);         
                  }else{ 
                     mysql_query("INSERT INTO ".PREFIX."cup_matches (`$type`, `$type_opp`, `date`, `matchno`, `clan1`, `comment`, `1on1`, `si`, `type`) VALUES ('".$_POST['group']."', '0', '$date', '$ID', '$id', '2', '0', '1', 'gs')");
                     redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 0);
                  }
             }else{
             
                mysql_query("INSERT INTO ".PREFIX."cup_clans (`$type`, $plat `groupID`, `clanID`, `1on1`, `type`) VALUES ('$rg', $platID '$ID', '$id', '0', 'gs')");
                  if(mysql_num_rows(mysql_query("SELECT * FROM ".PREFIX."cup_matches WHERE $type='$rg' AND matchno='$ID' AND clan1!='0' AND clan2='0'"))) {
                     mysql_query("UPDATE ".PREFIX."cup_matches SET clan2='$id' WHERE $type='$rg' AND matchno='$ID' AND clan2='0'"); 
                     redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 0);
                  }else{
                     mysql_query("INSERT INTO ".PREFIX."cup_matches (`$type`, `$type_opp`, `date`, `matchno`, `clan1`, `comment`, `1on1`, `si`, `type`) VALUES ('$rg', '0', '$date', '$ID', '$id', '2', '0', '1', 'gs')"); 
                     redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 0);
                 }
               }
             }
           }
	 
       }else{
         
//-- END GROUP STAGES REGISTRATION --//		
		
		   if($_GET['laddID']) 
		   { 
		     safe_query("INSERT INTO ".PREFIX."cup_clans (`platID`, `ladID`, `credit`, `elo`, `registered`, `clanID`, `1on1`, `checkin`, `tp`) VALUES ($platID '$cupID', '$startupcredit', '$elo_rating_default', '".time()."', '$id', '1', '1', '$startupcredit')"); 
		   } 
		   else
		   {
	         safe_query("INSERT INTO ".PREFIX."cup_clans ($t_name, `clanID`, `registered`, `1on1`, `checkin`) VALUES ('$cupID', '$id', '".time()."', '1', '1')");
	       }
	         redirect('admincenter.php?site=teams&'.$t_name2.'='.$cupID, '', 0);
	     }
	  }
       }
}elseif($_POST['removeusers']) {
	$cupID = $_POST['cupID'];
	$ID = $_POST['cupID'];
	$users = $_POST['users'];

        if($_GET['cupID'] && is1on1($_GET['cupID']))
        {
           $one_type = "1on1='1'";
        }
        elseif($_GET['laddID'] && ladderis1on1($_GET['laddID']))
        {
           $one_type = "1on1='1'";
        }
        else
        {
           $one_type = "1on1='0'";
        }
	
	if(is_array($users)) {
		foreach($users as $id) {
		
		  $alpha_groups = "type='gs'";
		  
		  if($_POST['groups_true']==1) {
	  		  
                    if(mysql_num_rows(mysql_query("SELECT * FROM ".PREFIX."cup_matches WHERE clan1='$id' AND matchno='$cupID' AND clan1!='0' AND clan2!='0' && $one_type"))) 
                    {	  
                      safe_query("UPDATE ".PREFIX."cup_matches SET clan1='0' WHERE clan1='$id' AND matchno='$cupID' AND clan2!='0'");  
                    }
                    else
                    {
                      safe_query("DELETE FROM ".PREFIX."cup_matches WHERE matchno='".$cupID."' && ($alpha_groups) && $type_opp='0' && (clan1='$id' || clan2='$id') && $one_type");		      
                    }
    
                    if(mysql_num_rows(mysql_query("SELECT * FROM ".PREFIX."cup_matches WHERE clan2='$id' AND matchno='$cupID' AND clan1!='0' AND clan2!='0' && $one_type"))) 
                    {	
                      safe_query("UPDATE ".PREFIX."cup_matches SET clan2='0' WHERE clan2='$id' AND matchno='$cupID' AND clan1!='0'");  
                    }
                      else
                    {
                      safe_query("DELETE FROM ".PREFIX."cup_matches WHERE matchno='".$cupID."' && ($alpha_groups) && $type_opp='0' && (clan1='$id' || clan2='$id') && $one_type");
                    }


		      safe_query("DELETE FROM ".PREFIX."cup_clans WHERE groupID='".$cupID."' && ($alpha_groups) && $type_opp='0' && clanID='$id' && $one_type");
		      redirect('admincenter.php?site=teams&'.$t_name2.'='.$cupID.'&type=gs', '', 0);

		  }else{ 

	              safe_query("DELETE FROM ".PREFIX."cup_clans WHERE $t_name='$cupID' && clanID='$id' && $one_type");
	          
	            if($_POST['removematches'])
	              safe_query("DELETE FROM ".PREFIX."cup_matches WHERE $t_name3='$cupID' && (clan1='$id' || clan2='$id') && $one_type");
	              
	          redirect('admincenter.php?site=teams&'.$t_name2.'='.$cupID, '', 0);
	      }
	    }
	 }
  }	
}
else{
		
/* TEAM */

	
		  if($_GET['type']=="gs" && $_GET['cupID'])
		     echo 'Showing: <strong>Group-stages</strong> (<a href="admincenter.php?site=teams&cupID='.$_GET['cupID'].'"><strong>switch to tournament</strong></a>)';
		  elseif($_GET['cupID'])
		     echo 'Showing: <strong>Tournament</strong> (<a href="admincenter.php?site=teams&cupID='.$_GET['cupID'].'&type=gs"><strong>switch to group-stages</strong></a>)';
		  elseif($_GET['type']=="gs" && $_GET['laddID'])
		     echo 'Showing: <strong>Group-stages</strong> (<a href="admincenter.php?site=teams&laddID='.$_GET['laddID'].'"><strong>switch to ladder</strong></a>)';
		  elseif($_GET['laddID'])
		     echo 'Showing: <strong>Ladder</strong> (<a href="admincenter.php?site=teams&laddID='.$_GET['laddID'].'&type=gs"><strong>switch to group-stages</strong></a>)';

if($_GET['laddID']) {

//title ladder

$ID = $cupID;
$participants = (ladderis1on1($ID) ? 'Players' : 'Teams');	

echo '

<table width="100%" cellpadding="2" cellspacing="1" bgcolor="'.$border.'">
	<tr>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=ladders&action=edit&ID='.$ID.'">Edit Ladder</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;'.$participants.'</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=ladders&action=standings&ID='.$ID.'">Standings</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=ladders&action=rules&ID='.$ID.'">Rules</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=ladders&action=admins&ID='.$ID.'">Admins</a></td>
        <td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=matches&laddID='.$ID.'">Matches</a></td>		
	</tr>
</table><br><br>'; 

}
		
//title_cup
	
if($typename($cupID)) $participants = 'Manage Players';
else $participants = 'Manage Teams';

	
if($_GET['cupID']) {
	
echo '<h2>'.getcupname($_GET['cupID']).'</h2>

<table width="100%" cellpadding="2" cellspacing="1" bgcolor="'.$border.'">
	<tr>
		<td class="title" bgcolor="'.$bghead.'" width="12%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=cups&action=edit&ID='.$cupID.'">Edit Cup</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp; '.$participants.'</td>
		<td class="title" bgcolor="'.$bghead.'" width="14%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=cups&action=baum&ID='.$cupID.'">Brackets</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="12%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=cups&action=rules&ID='.$cupID.'">Rules</a></td>
		<td class="title" bgcolor="'.$bghead.'" width="14%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=cups&action=admins&ID='.$cupID.'">Admins</a></td>
        <td class="title" bgcolor="'.$bghead.'" width="16%">&nbsp;<img border="0" src="../images/cup/icons/go.png">&nbsp;<a class="titlelink" href="admincenter.php?site=matches&cupID='.$cupID.'">Matches</a></td>		
	</tr>
</table><br />';

}

		//count 
	
		  $participants = safe_query("SELECT count(*) as entered FROM ".PREFIX."cup_clans WHERE $t_name='$cupID' && 1on1='0'");
		  $checked = safe_query("SELECT count(*) as checked FROM ".PREFIX."cup_clans WHERE $t_name='$cupID' && 1on1='0' && checkin='1'");
		
		  $all=mysql_fetch_array($participants); 
		  $is=mysql_fetch_array($checked); 
		  
		  if(isset($_GET['cupID'])) {
		         $info = safe_query("SELECT * FROM ".PREFIX."cups WHERE ID='$cupID'");
		  }
		  else{
		         $info = safe_query("SELECT * FROM ".PREFIX."cup_ladders WHERE ID='$cupID'");
		  }
		  
		  $type_opp = ($_GET['cupID'] ? 'ladID' : 'cupID');
		  
		  $sp=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchno='".$cupID."' && $type_opp='0' && type='gs' && si='0' && 1on1='0'"));		
		  $all_vs_all = (is_array($sp) ? true : false);
		  
		  $lad = mysql_fetch_array($info);		  
          $dv=mysql_fetch_array(safe_query("SELECT count(*) as anzahl FROM ".PREFIX."cup_clans WHERE groupID='".$cupID."' && $type_opp='0' && 1on1='0' && type='gs'"));  
		  
		  if($lad['maxclan'] == 80 || $lad['maxclan']== 8)
			  $max = 8;
		  elseif($lad['maxclan'] == 160 || $lad['maxclan']== 16)
			  $max = 16;
	  	  elseif($lad['maxclan'] == 320 || $lad['maxclan']== 32)
			  $max = 32;
		  elseif($lad['maxclan'] == 640 || $lad['maxclan']== 64) 
	  		  $max = 64; 
			  
		  $max_participants = $max+$max;
		  
          if($dv['anzahl'] == $max+$max || $all_vs_all==true) {
                $slots = "League Full";
                $slots_ext = '';
          }
          else{
                $slots = $max+$max-$dv['anzahl']." Slots Available";
                $slots_ext = '/'.$max_participants;      
          }    
		  		  
		  $ergebnis = safe_query("SELECT count( ID ) as clans FROM ".PREFIX."cup_clans WHERE ".($_GET['cupID'] ? 'cupID' : 'ladID')." = '".$cupID."' && 1on1='0'");
		  $db = mysql_fetch_array($ergebnis);	
		  
		  if($_GET['type']=='gs') {	 
		         $num = $slots.' ('.$dv['anzahl'].$slots_ext.')';
		  }
		  else{
		         $num = $db['clans'].' / '.$max;
		  }
		  
		  
          if($_GET['type']=="gs") {
		     $gs_group_head = '<td class="title2" align="center"><a href="admincenter.php?site=teams&'.$t_name2.'='.$cupID.'&type=gs'.($_GET['order']=="groups" ? "" : "&order=groups").'"><b>Group</b></a></td>';

              if($_GET['order']=="groups") 
                  $group_order = "ORDER BY $t_name3 DESC";
              else
                  $group_order = "ORDER BY $t_name3 ASC";           
         }
		 else       
              $group_order = "ORDER BY ID ASC";
			  
			if($_GET['type']=='gs') {
			   $tb_typ = 'gs';
			   $add_ex = "&& $type_opp = '0'";
			}
			elseif($_GET['cupID']) {
			   $tb_typ = 'cup';
			   $add_ex = '';
			}
			elseif($_GET['laddID']) {
			   $tb_typ = 'ladder';
			   $add_ex = '';
			}
			
			if($_GET['type']!='gs'){
			   $tb_hd_ga = '<td class="title2" align="center"><b>G-ACC</b></td>';
			}
			  
			  $type_opp = ($_GET['cupID'] ? "ladID" : "cupID");				  
			  $ergebnis = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE $t_name = '$cupID' $add_ex &&  1on1 = '0' && type = '$tb_typ' $group_order");
			  
            if(mysql_num_rows($ergebnis)) {
			
			            if($_GET['type']!='gs') {
			                   $show_lineup_hd = '<td class="title2" align="center"><b>Lineup</b></td>';
							   $tb_hd_st = '<td class="title2" align="center"><b>Status</b></td>';
							   $a_cols = 3;
                        }
                        else{
						       $show_lineup_hd = '';
                               $tb_hd_st = '';
							   $a_cols = 1;
                        }
			
			 			eval ("\$teams_head = \"".gettemplate("teams_head")."\";");
			            echo $teams_head;			
			}
			else{ 
			            echo '<div '.$error_box.'> No participants found</div>';
			}
			
			$i = 1;
			while($db=mysql_fetch_array($ergebnis)) {
				$ergebnis2 = safe_query("SELECT ID, name, clantag, clanhp, leader, clanlogo, password, server, status FROM ".PREFIX."cup_all_clans WHERE ID = '".$db['clanID']."' ORDER BY name ASC");		
				$ds=mysql_fetch_array($ergebnis2);
				
				$getflag = safe_query("SELECT country FROM ".PREFIX."cup_all_clans WHERE ID='".$ds[ID]."'");
                $dp=mysql_fetch_array($getflag);
                
              if($_GET['type']=="gs") 
                 $gs_group_content = '<td align="center"><b>'.strtoupper($db[$t_name3]).'</b></td>';
	          
                
                if(!$dp['country'] || $dp['country']==na || $dp['country']==is_numeric) 
	            $country =  '<img src="../images/flags/na.gif" border="0">'; else
                $country = '<img src="../images/flags/'.$dp[country].'.gif" width="20" height="13">'; 

				//Variablen
				$clanname = '<a href="../?site=clans&action=show&clanID='.$ds['ID'].'&'.$t_name2.'='.$cupID.'" target="_blank">'.$ds['name'].'</a>';
				$clanname1= $ds['name'];
		        $clantag = $ds[clantag];
		        $server = $ds[server];
		        $password = $ds[password];
		        $clanhp = $ds[clanhp];

                $members=safe_query("SELECT userID FROM ".PREFIX."cup_clan_members WHERE clanID = '$clanID'");
		          while($dv=mysql_fetch_array($members)) { }
                  $sql_members = safe_query("SELECT * FROM ".PREFIX."cup_clan_members WHERE clanID = '".$db['clanID']."'");	
		        $members = mysql_num_rows($sql_members);


                $details = '<a href="../?site=clans&action=show&clanID='.$ds['ID'].'&'.$t_name2.'='.$cupID.'"><img border="0" src="../images/icons/foldericons/folder.gif"></a> href="../?site=clans&action=clanjoin&clanID='.$ds['ID'].'"><img border="0" src="../images/cup/icons/go.png" width="16" height="16"></a> href="../?site=clans&action=clanedit&clanID='.$ds['ID'].'"><img border="0" src="../images/icons/manage.gif"></a> href="../?site=clans&action=editpwd&clanID='.$ds['ID'].'"><img border="0" src="../images/icons/key.png"></a>';
		        $leader = '<a href="../?site=profile&id='.$ds[leader].'">'.getnickname($ds[leader]).'</a><iframe name="I1" src="popup.php?site=livecontact&id='.$ds[leader].'" width="100%" height="25" frameborder="0" scrolling="no"></iframe>';
		        
				if($ds['clanlogo'] && $ds['clanlogo'] != 'http://')
					$clanlogo = '<img src="'.$ds['clanlogo'].'" alt="n/a" border="0" height="100" vspace="3" width="100">';
				else
					$clanlogo = '<img src="../images/avatars/noavatar.gif" alt="n/a" border="0" height="100" vspace="5" width="100">';
				
				if($_GET['type']!='gs') {
				
				    if($db['checkin']) {
					      $clanname.= '<img src="../images/icons/online.gif" border="0" alt="Checked" title="Checked" align="right"/>';
					      $status = '<input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=teams&action=uncheck&clanID='.$ds['ID'].'&'.$t_name2.'='.$cupID.$ext.'\');return document.MM_returnValue" value="Uncheck">';
				    }
				    else{
					      $clanname.= '<img src="../images/icons/offline.gif" border="0" alt="Checked" title="Checked" align="right"/>';
					      $status = '<input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=teams&action=checkin&clanID='.$ds['ID'].'&'.$t_name2.'='.$cupID.$ext.'\');return document.MM_returnValue" value="Checkin">'; 
				    }
					
					 $tb_cnt_st = '<td align="center">'.$status.'</td>';
					 $chge_lineup_cnt = '<td align="center"><input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=teams&action=lineup&'.$t_name2.'='.$cupID.'&clanID='.$ds['ID'].'\');return document.MM_returnValue" value="Lineup"></td>';
				}
		
                //check members in lineup
    
					$lineup = safe_query("SELECT userID FROM ".PREFIX."cup_clan_lineup WHERE ".($_GET['cupID'] ? 'cupID' : 'ladID')." = '".($_GET['cupID'] ? $_GET['cupID'] : $_GET['laddID'])."' && clanID='".$ds['ID']."'");
					$checklineup = mysql_num_rows($lineup); 
					
			    //check if blocked
			    
					$getpoints = safe_query("SELECT SUM(points) as totalpoints FROM ".PREFIX."cup_warnings WHERE clanID='".$ds['ID']."' && expired='0' && 1on1='0'");
					$do=mysql_fetch_array($getpoints);
             
             	     $block = safe_query("SELECT cupblockage FROM ".PREFIX."cup_settings");	
	                 $dt=mysql_fetch_array($block); $cupblockage = $dt['cupblockage']-$do['totalpoints'];  

                     if($do['totalpoints'] >= $dt['cupblockage']) { 
					        $blockstatus = '<font color="#DD0000"><b>Locked</b></font>'; 
					 }
					 else{ 
					        $blockstatus = '<font color="#00FF00"><b>Unlocked</b></font>'; 
					 }
					 
					 $part_pp = (empty($do['totalpoints']) ? '0' : $do['totalpoints']);

//

        $sql_members = safe_query("SELECT * FROM ".PREFIX."cup_clan_members WHERE clanID = '".$ds['ID']."'");	
	    $members = mysql_num_rows($sql_members);
		
		$qk_tb = ($_GET['cupID'] ? 'cups' : 'cup_ladders');
		$qk_id = ($_GET['cupID'] ? $_GET['cupID'] : $_GET['laddID']);
        $qk_tp = ($_GET['cupID'] ? "typ" : "type");
        $qk_ty = ($_GET['cupID'] ? "cupID" : "laddID");		
		
		$dbl = mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX.$qk_tb." WHERE ID='$qk_id'"));	
        $membersin = $dbl['cupaclimit']; 
		
	    $membersin = ($dbl['cupaclimit'] <= 0 ? '' : $dbl['cupaclimit']);           
        $needed = $dbl[$qk_tp]-$members-$membersin;
					 
        $lineup = safe_query("SELECT * FROM ".PREFIX."cup_clan_lineup WHERE ".($_GET['cupID'] ? 'cupID' : 'ladID')." = '".($_GET['cupID'] ? $_GET['cupID'] : $_GET['laddID'])."' && clanID='".$ds[ID]."'");
        $checklineup = mysql_num_rows($lineup); $thelineup = mysql_num_rows($lineup)+$membersin+1;
  
        $linedmembers = '<a href="../popup.php?site=clans&action=show&clanID='.$ds['ID'].'&'.$qk_ty.'='.$qk_id.'#members" onClick="MM_openBrWindow(this.href,\'MEMBER LIST WINDOW\',\'toolbar=no,status=no,scrollbars=yes,width=800,height=600\');return false">'.$checklineup.'</a>';
		
		//prev = substr($dbl[$qk_tp], -1)
		
		if($_GET['type']!='gs') {
		       $show_lineup_cnt = '<td align="center">'.$linedmembers.' / '.(!substr($dbl[$qk_tp], -1) ? 0 : $dbl[$qk_tp]-$membersin).'</td>';
		}
		else{
			   $show_lineup_cnt = '';
		}
		
		$show_end_ga = $dbl[$qk_tp]-$membersin;
		
        $game_acc = '<a href="../popup.php?site=clans&action=show&clanID='.$ds['ID'].'&'.$t_name2.'='.$cupID.'#members" onClick="MM_openBrWindow(this.href,\'GAMEACC WINDOW\',\'toolbar=no,status=no,scrollbars=yes,width=800,height=600\');return false">'.countgameacc($ds['ID']).'</a> / '.$show_end_ga;
		
		if($_GET['type']!='gs') {
		       $tb_cnt_ga = '<td align="center">'.$game_acc.'</td>';
			   $show_delete_cont = "<td align=\"center\"><a href=\"admincenter.php?site=teams&action=deletematches&clanID=$ds[ID]&$t_name2=$cupID$ext\" onClick=\"return confirm('WARNING: Are you sure you want to remove ALL $clanname1\'s matches from $cupname1?');\"><img border=\"0\" src=\"../images/cup/icons/add_result.gif\" width=\"20\" height=\"20\"></a></td>";	       
		}
		else{
		       $show_delete_cont = "<td align=\"center\"><a onClick=\"return confirm('Note: To delete matches you must also remove the team - click on the red X on your right.');\"><img border=\"0\" id=\"myImage\" alt=\"To delete matches you must also remove the team - click on the red X on your right.\" src=\"../images/cup/add_result.gif\" width=\"20\" height=\"20\"></td>";
			   $tb_cnt_ga = "";
		}
			     		 
				eval ("\$teams_content = \"".gettemplate("teams_content")."\";");
				echo $teams_content;
			}
			
			if(mysql_num_rows($ergebnis)) {		
			
			    eval ("\$team_foot = \"".gettemplate("footer")."\";");
			    echo $team_foot;	
			}
			
			if($_GET['type']=='gs' && mysql_num_rows($ergebnis)) {		
                        echo '<br /><a href="admincenter.php?site=teams&'.$t_name2.'='.$cupID.'&delete=all" onclick="return confirm(\'Do you really want to remove matches and participants for this group league? \');"><img src="../images/cup/icons/go.png"> <strong>Delete all group participants and matches</strong></a>
						      <br /><a href="admincenter.php?site=teams&'.$t_name2.'='.$cupID.'&randomize=scores" onclick="return confirm(\'Finish matches and randomize scores? (Testing purposes) \');"><img src="../images/cup/icons/go.png"> <strong>Randomize scores and finish matches</strong></a>';
			}
			 
			 //dropdown - add teams to cup
			 
			 if($_GET['type']=="gs") {			            
                    $gs_signup = '<br /><strong>Group:</strong> <select name="group">'.$dd_groups_sel.'</select>';   
			        $qry_type = "groupID = '$cupID' && type = 'gs' && $type_opp = '0'";			    
			 }
			 else{
			        $gs_signup = "";
			        $qry_type = "$t_name = '$cupID'";
			 }
			 
			 
                         $participants = safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE ".$qry_type." && 1on1='0'");
                            while($up=mysql_fetch_array($participants)) {  
				               $ent_IDs[]=$up['clanID'];
                         }

			   $teams = safe_query("SELECT ID FROM ".PREFIX."cup_all_clans");
			   
			   echo '<br><br>
			         <form method="post" action="admincenter.php?site=teams&'.$t_name2.'='.$cupID.'">
			           <select name="ID[]" multiple size="10" onblur="countit(this)">';
				   
				     while($dv=mysql_fetch_assoc($teams)) {
				     
				       if(!in_array($dv['ID'],$ent_IDs)) {
				         echo '<option value="'.$dv['ID'].'">('.$dv['ID'].') '.getclanname2($dv['ID']).'</option>';
			           }
				     }  
 
			   echo '</select>
                     <input type="hidden" name="cupID" value="'.$cupID.'">
                     '.$gs_signup.'
	                 <br><input type="submit" name="enterteams" value="Enter Teams">
		             </form>';
 		      
			   
			 //dropdown - remove teams from cup
			 
			   $type_opp = (isset($_GET['cupID']) ? 'ladID' : 'cupID');
			   
			   if(isset($_GET['type']) && $_GET['type']=='gs') 
			       $lg_type = 'gs';
			   elseif(isset($_GET['cupID'])) {
			       $lg_type = 'cup';
			   }
			   else{
			       $lg_type = 'ladder';
			   }
			   
			 
			   $participants = safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE $t_name='".$cupID."' && $type_opp = '0' && 1on1='0' && type='$lg_type'");
               if(mysql_num_rows($participants)) {			   
			   
			    echo '<br><br><form method="post" action="admincenter.php?site=teams&'.$t_name2.'='.$cupID.'"><select name="clanID[]" multiple size="10">';
			                   
					 while($dv=mysql_fetch_array($participants)) {
					      echo '<option value="'.$dv['clanID'].'">('.$dv['clanID'].') '.getclanname2($dv['clanID']).'</option>';
		            }
		          
		        $gs_input = (isset($_GET['type'])=='gs' ? '<input type="hidden" name="groups_true" value="1">' : '');
		          
			    echo '</select>
                      <input type="hidden" name="cupID" value="'.$cupID.'">
                      '.$gs_input.'<br>
                      '.($_GET['type']!="gs" ? '<input type="checkbox" name="removematches" value="ON" checked> Also remove matches?' : '').'
	                  <br><br><input type="submit" name="removeteams" value="Remove Teams">
		              </form>';
		       
		        if($_GET['type']=="gs") echo "<br /><b>Important:</b> Removing teams will also delete their pre-set match(es).";
               }
//queries - enter/remove participants
		       
if($_POST['enterteams']) {
	$cupID = $_POST['cupID'];
	$teams = $_POST['ID'];
	
	if(is_array($teams)) {
		foreach($teams as $id) {
		
		if($_POST['group']) {
		
        $participant_ent = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND ($alpha_groups) AND $type_opp='0'");
        $ent_part = mysql_num_rows($participant_ent);
		
		//groups
		
		$rowsa = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='a'  AND $type_opp='0' AND type='gs'");
		$rowsb = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='b'  AND $type_opp='0' AND type='gs'");
		$rowsc = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='c'  AND $type_opp='0' AND type='gs'");
		$rowsd = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='d'  AND $type_opp='0' AND type='gs'");
		$rowse = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='e'  AND $type_opp='0' AND type='gs'");
		$rowsf = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='f'  AND $type_opp='0' AND type='gs'");
		$rowsg = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='g'  AND $type_opp='0' AND type='gs'");
		$rowsh = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='h'  AND $type_opp='0' AND type='gs'");
		$rowsi = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='i'  AND $type_opp='0' AND type='gs'");
		$rowsj = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='j'  AND $type_opp='0' AND type='gs'");
		$rowsk = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='k'  AND $type_opp='0' AND type='gs'");
		$rowsl = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='l'  AND $type_opp='0' AND type='gs'");
		$rowsm = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='m'  AND $type_opp='0' AND type='gs'");
		$rowsn = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='n'  AND $type_opp='0' AND type='gs'");
		$rowso = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='o'  AND $type_opp='0' AND type='gs'");
		$rowsp = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='p'  AND $type_opp='0' AND type='gs'");
		$rowsq = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='q'  AND $type_opp='0' AND type='gs'");
		$rowsr = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='r'  AND $type_opp='0' AND type='gs'");
		$rowss = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='s'  AND $type_opp='0' AND type='gs'");
		$rowst = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='t'  AND $type_opp='0' AND type='gs'");
		$rowsu = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='u'  AND $type_opp='0' AND type='gs'");
		$rowsv = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='v'  AND $type_opp='0' AND type='gs'");
		$rowsw = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='w'  AND $type_opp='0' AND type='gs'");
		$rowsx = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='x'  AND $type_opp='0' AND type='gs'");
		$rowsy = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='y'  AND $type_opp='0' AND type='gs'");
		$rowsz = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='z'  AND $type_opp='0' AND type='gs'");
		$rowsa2 = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='a2'  AND $type_opp='0' AND type='gs'");
		$rowsb2 = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='b2'  AND $type_opp='0' AND type='gs'");
		$rowsc2 = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='c2'  AND $type_opp='0' AND type='gs'");
		$rowsd2 = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='d2'  AND $type_opp='0' AND type='gs'");
		$rowse2 = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='e2'  AND $type_opp='0' AND type='gs'");
		$rowsf2 = mysql_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type='f2'  AND $type_opp='0' AND type='gs'");
		
		$a_rows = mysql_num_rows($rowsa);
		$b_rows = mysql_num_rows($rowsb);
		$c_rows = mysql_num_rows($rowsc);
		$d_rows = mysql_num_rows($rowsd);
		$e_rows = mysql_num_rows($rowse);
		$f_rows = mysql_num_rows($rowsf);
		$g_rows = mysql_num_rows($rowsg);
		$h_rows = mysql_num_rows($rowsh);
		$i_rows = mysql_num_rows($rowsi);
		$j_rows = mysql_num_rows($rowsj);
		$k_rows = mysql_num_rows($rowsk);
		$l_rows = mysql_num_rows($rowsl);
		$m_rows = mysql_num_rows($rowsm);
		$n_rows = mysql_num_rows($rowsn);
		$o_rows = mysql_num_rows($rowso);
		$p_rows = mysql_num_rows($rowsp);
		$q_rows = mysql_num_rows($rowsq);
		$r_rows = mysql_num_rows($rowsr);
		$s_rows = mysql_num_rows($rowss);
		$t_rows = mysql_num_rows($rowst);
		$u_rows = mysql_num_rows($rowsu);
		$v_rows = mysql_num_rows($rowsv);
		$w_rows = mysql_num_rows($rowsw);
		$x_rows = mysql_num_rows($rowsx);
		$y_rows = mysql_num_rows($rowsy);
		$z_rows = mysql_num_rows($rowsz);
		$a2_rows = mysql_num_rows($rowsa2);
		$b2_rows = mysql_num_rows($rowsb2);
		$c2_rows = mysql_num_rows($rowsc2);
		$d2_rows = mysql_num_rows($rowsd2);
		$e2_rows = mysql_num_rows($rowse2);
		$f2_rows = mysql_num_rows($rowsf2);
		//end check


	        $day = date('d');
	        $month = date('m');
	        $year = date('Y');
            $hour = date('H');
	        $min = date('i');
     	    $date = @mktime($hour, $min, 0, $month, $day, $year);
     	 
		$ergebnis2 = mysql_query("SELECT count(*) as anzahl FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' AND $type_opp='0' AND type='gs'");
		$dv=mysql_fetch_array($ergebnis2);

// check what group		
		         
	    // DROPDOWN GROUPINGS
	  
	      $dd_groups = ($a_rows < 4 ? '<option value="a">Group A</option>' : '');
	      $dd_groups.= ($b_rows < 4 ? '<option value="b">Group B</option>' : '');
	      $dd_groups.= ($c_rows < 4 ? '<option value="c">Group C</option>' : '');
	      $dd_groups.= ($d_rows < 4 ? '<option value="d">Group D</option>' : '');
		  
		if($set['maxclan'] == 160 OR $set['maxclan'] == 16 OR $set['maxclan'] == 32 OR $set['maxclan']==320 OR $set['maxclan'] == 64 OR $set['maxclan']==640) {
		  
	      $dd_groups.= ($e_rows < 4 ? '<option value="e">Group E</option>' : '');
	      $dd_groups.= ($f_rows < 4 ? '<option value="f">Group F</option>' : '');
	      $dd_groups.= ($g_rows < 4 ? '<option value="g">Group G</option>' : '');
	      $dd_groups.= ($h_rows < 4 ? '<option value="h">Group H</option>' : '');
		}  
        if($set['maxclan'] == 32 OR $set['maxclan']==320 OR $set['maxclan'] == 64 OR $set['maxclan']==640) {
		  
	      $dd_groups.= ($i_rows < 4 ? '<option value="i">Group I</option>' : '');
	      $dd_groups.= ($j_rows < 4 ? '<option value="j">Group J</option>' : '');
	      $dd_groups.= ($k_rows < 4 ? '<option value="k">Group K</option>' : '');
	      $dd_groups.= ($l_rows < 4 ? '<option value="l">Group L</option>' : '');
	      $dd_groups.= ($m_rows < 4 ? '<option value="m">Group M</option>' : '');
	      $dd_groups.= ($n_rows < 4 ? '<option value="n">Group N</option>' : '');
	      $dd_groups.= ($o_rows < 4 ? '<option value="o">Group O</option>' : '');
	      $dd_groups.= ($p_rows < 4 ? '<option value="p">Group P</option>' : '');
		}  
		if($set['maxclan'] == 64 OR $set['maxclan']==640) {  
		  
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
		  
		if($set['maxclan'] == 160 OR $set['maxclan'] == 16 OR $set['maxclan'] == 32 OR $set['maxclan']==320 OR $set['maxclan'] == 64 OR $set['maxclan']==640) {		 
		 
	      if($e_rows < 4) $groups[] = 'e';
		  if($f_rows < 4) $groups[] = 'f';
		  if($g_rows < 4) $groups[] = 'g';
		  if($h_rows < 4) $groups[] = 'h';
		}  
        if($set['maxclan'] == 32 OR $set['maxclan']==320 OR $set['maxclan'] == 64 OR $set['maxclan']==640) {
		
	      if($i_rows < 4) $groups[] = 'i';
		  if($j_rows < 4) $groups[] = 'j';
		  if($k_rows < 4) $groups[] = 'k';
		  if($l_rows < 4) $groups[] = 'l';
		  if($m_rows < 4) $groups[] = 'm';
		  if($n_rows < 4) $groups[] = 'n';
		  if($o_rows < 4) $groups[] = 'o';
		  if($p_rows < 4) $groups[] = 'p';

		}  
		if($set['maxclan'] == 64 OR $set['maxclan']==640) {
		
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
		
//end check
	 
  $dd_groups .= '<option value="randomized" selected>Randomized Grouping</option>';	 
	 
  if($dv['anzahl'] >= $set['maxclan']+$set['maxclan'])
     $dd_groups_sel = '<option value="">(no spaces available)</option>'; 
  else 
     $dd_groups_sel = $dd_groups;
	
//-- GROUP STAGES ONLY --//

    $var = ($_GET['cupID'] ? 'cup' : 'ladder');
	
		  if(!iscupadmin($userID)) {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Access denied.</div>';    
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($dv['anzahl'] >= $set['maxclan']+$set['maxclan']) {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Too much teams</div>'; 
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($a_rows == 4 && $_POST['group']=="a") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group A is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($b_rows == 4 && $_POST['group']=="b") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group B is already filled up.</div>';    
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($c_rows == 4 && $_POST['group']=="c") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group C is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($d_rows == 4 && $_POST['group']=="d") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group D is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($e_rows == 4 && $_POST['group']=="e") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group E is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($f_rows == 4 && $_POST['group']=="f") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group F is already filled up.</div>';    
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($g_rows == 4 && $_POST['group']=="g") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group G is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($h_rows == 4 && $_POST['group']=="h") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group H is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($i_rows == 4 && $_POST['group']=="i") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group I is already filled up.</div>';    
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($j_rows == 4 && $_POST['group']=="j") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group J is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($k_rows == 4 && $_POST['group']=="k") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group K is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($l_rows == 4 && $_POST['group']=="l") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group L is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($m_rows == 4 && $_POST['group']=="m") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group M is already filled up.</div>';    
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($n_rows == 4 && $_POST['group']=="n") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group N is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($o_rows == 4 && $_POST['group']=="o") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group O is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($p_rows == 4 && $_POST['group']=="p") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group P is already filled up.</div>';    
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($q_rows == 4 && $_POST['group']=="q") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group W is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($r_rows == 4 && $_POST['group']=="r") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group R is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($s_rows == 4 && $_POST['group']=="s") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group S is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($t_rows == 4 && $_POST['group']=="t") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group T is already filled up.</div>';    
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($u_rows == 4 && $_POST['group']=="u") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group U is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($v_rows == 4 && $_POST['group']=="v") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group V is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($w_rows == 4 && $_POST['group']=="w") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group W is already filled up.</div>';    
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($x_rows == 4 && $_POST['group']=="x") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group X is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($y_rows == 4 && $_POST['group']=="y") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group Y is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($z_rows == 4 && $_POST['group']=="z") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group Z is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($a2_rows == 4 && $_POST['group']=="a2") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group A2 is already filled up.</div>';    
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($b2_rows == 4 && $_POST['group']=="b2") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group B2 is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($c2_rows == 4 && $_POST['group']=="c2") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group C2 is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($d2_rows == 4 && $_POST['group']=="d2") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group D2 is already filled up.</div>';    
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($e2_rows == 4 && $_POST['group']=="e2") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group E2 is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);         
		  }
		  elseif($f2_rows == 4 && $_POST['group']=="f2") {
		     echo '<div '.$error_box.'><img src="../images/cup/icons/notification.png"> Sorry group F2 is already filled up.</div>';  
			 redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 3);                
	}
	else{
	
   if($name2($ID)) {
          
             if($_POST['group']!="randomized") { 
                mysql_query("INSERT INTO ".PREFIX."cup_clans (`$type`, $plat `groupID`, `clanID`, `1on1`, `type`) VALUES ('".$_POST['group']."', $platID '$ID', '$id', '1', 'gs')");
                  if(mysql_num_rows(mysql_query("SELECT * FROM ".PREFIX."cup_matches WHERE $type='".$_POST['group']."' AND matchno='$ID' AND clan1!='0' AND clan2='0'"))) {
                     mysql_query("UPDATE ".PREFIX."cup_matches SET clan2='$id' WHERE $type='".$_POST['group']."' AND matchno='$ID' AND clan2='0'"); 
                     redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 0);         
                  }else{ 
                     mysql_query("INSERT INTO ".PREFIX."cup_matches (`$type`, `$type_opp`, `date`, `matchno`, `clan1`, `comment`, `1on1`, `si`, `type`) VALUES ('".$_POST['group']."', '0', '$date', '$ID', '$id', '2', '1', '1', 'gs')");
                     redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 0);
                  }
             }else{
             
                mysql_query("INSERT INTO ".PREFIX."cup_clans (`$type`, $plat `groupID`, `clanID`, `1on1`, `type`) VALUES ('$random_group', $platID '$ID', '$id', '1', 'gs')");
                  if(mysql_num_rows(mysql_query("SELECT * FROM ".PREFIX."cup_matches WHERE $type='$random_group' AND matchno='$ID' AND clan1!='0' AND clan2='0'"))) {
                     mysql_query("UPDATE ".PREFIX."cup_matches SET clan2='$id' WHERE $type='$random_group' AND matchno='$ID' AND clan2='0'"); 
                     redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 0);
                  }else{
                     mysql_query("INSERT INTO ".PREFIX."cup_matches (`$type`, `$type_opp`, `date`, `matchno`, `clan1`, `comment`, `1on1`, `si`, `type`) VALUES ('$random_group', '0', '$date', '$ID', '$id', '2', '1', '1', 'gs')"); 
                     redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 0);
                  }
             }
             
          }else{
                
            if($_POST['group']!="randomized") { 
                mysql_query("INSERT INTO ".PREFIX."cup_clans (`$type`, $plat `groupID`, `clanID`, `1on1`, `type`) VALUES ('".$_POST['group']."', $platID '$ID', '$id', '0', 'gs')");
                  if(mysql_num_rows(mysql_query("SELECT * FROM ".PREFIX."cup_matches WHERE $type='".$_POST['group']."' AND matchno='$ID' AND clan1!='0' AND clan2='0'"))) {
                     mysql_query("UPDATE ".PREFIX."cup_matches SET clan2='$id' WHERE $type='".$_POST['group']."' AND matchno='$ID' AND clan2='0'"); 
                     redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 0);         
                  }else{ 
                     mysql_query("INSERT INTO ".PREFIX."cup_matches (`$type`, `$type_opp`, `date`, `matchno`, `clan1`, `comment`, `1on1`, `si`, `type`) VALUES ('".$_POST['group']."', '0', '$date', '$ID', '$id', '2', '0', '1', 'gs')");
                     redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 0);
                  }
             }else{
             
                mysql_query("INSERT INTO ".PREFIX."cup_clans (`$type`, $plat `groupID`, `clanID`, `1on1`, `type`) VALUES ('$random_group', $platID '$ID', '$id', '0', 'gs')");
                  if(mysql_num_rows(mysql_query("SELECT * FROM ".PREFIX."cup_matches WHERE $type='$random_group' AND matchno='$ID' AND clan1!='0' AND clan2='0'"))) {
                     mysql_query("UPDATE ".PREFIX."cup_matches SET clan2='$id' WHERE $type='$random_group' AND matchno='$ID' AND clan2='0'"); 
                     redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 0);
                  }else{

                     mysql_query("INSERT INTO ".PREFIX."cup_matches (`$type`, `$type_opp`, `date`, `matchno`, `clan1`, `comment`, `1on1`, `si`, `type`) VALUES ('$random_group', '0', '$date', '$ID', '$id', '2', '0', '1', 'gs')"); 
                     redirect('admincenter.php?site=teams&'.$t_name2.'='.$ID.'&type=gs', '', 0);
                 }
               }
             }
           }
         }else{
         
//-- END GROUP STAGES REGISTRATION --//		
		
		    if($_GET['laddID'])
		    {
		       mysql_query("INSERT INTO ".PREFIX."cup_clans (platID, ladID, credit, elo, registered, clanID, 1on1, checkin, tp) VALUES ($platID '$cupID', '$startupcredit', '$elo_rating_default', '".time()."', '$id', '0', '1', '$startupcredit')"); 
		    }
		    else
		    {
	           mysql_query("INSERT INTO ".PREFIX."cup_clans (cupID, clanID, 1on1, checkin) VALUES ('$cupID', '$id', '0', '1')");
	        }
	           redirect('admincenter.php?site=teams&'.$t_name2.'='.$cupID, '', 0);
	      }  
	    }	         
	  }  
}elseif($_POST['removeteams']) {
	$cupID = $_POST['cupID'];
	$teams = $_POST['clanID'];

        if($_GET['cupID'] && is1on1($_GET['cupID']))
        {
           $one_type = "1on1='1'";
        }
        elseif($_GET['laddID'] && ladderis1on1($_GET['laddID']))
        {
           $one_type = "1on1='1'";
        }
        else
        {
           $one_type = "1on1='0'";
        }
	
	if(is_array($teams)) {
		foreach($teams as $id) {
	        
	       $alpha_groups = "type='gs'";
	              	                
		   if($_POST['groups_true']==1) {
		  		  
                    if(mysql_num_rows(mysql_query("SELECT * FROM ".PREFIX."cup_matches WHERE clan1='$id' AND matchno='$cupID' AND clan1!='0' AND clan2!='0' && $one_type"))) 
                    {	  
                      safe_query("UPDATE ".PREFIX."cup_matches SET clan1='0' WHERE clan1='$id' AND matchno='$cupID' AND clan2!='0'");  
                    }
                    else
                    {
                      safe_query("DELETE FROM ".PREFIX."cup_matches WHERE matchno='".$cupID."' && ($alpha_groups) && $type_opp='0' && (clan1='$id' || clan2='$id') && $one_type");		      
                    }
    
                    if(mysql_num_rows(mysql_query("SELECT * FROM ".PREFIX."cup_matches WHERE clan2='$id' AND matchno='$cupID' AND clan1!='0' AND clan2!='0' && $one_type"))) 
                    {	
                      safe_query("UPDATE ".PREFIX."cup_matches SET clan2='0' WHERE clan2='$id' AND matchno='$cupID' AND clan1!='0'");  
                    }
                      else
                    {
                      safe_query("DELETE FROM ".PREFIX."cup_matches WHERE matchno='".$cupID."' && ($alpha_groups) && $type_opp='0' && (clan1='$id' || clan2='$id') && $one_type");
                    }
		      
		       safe_query("DELETE FROM ".PREFIX."cup_clans WHERE '".$cupID."' && ($alpha_groups) && $type_opp='0' && clanID='$id' && $one_type");
		       redirect('admincenter.php?site=teams&'.$t_name2.'='.$cupID.'&type=gs', '', 0);
		    }
			else{
			
	           safe_query("DELETE FROM ".PREFIX."cup_clans WHERE $t_name='$cupID' && clanID='$id' && $one_type");
			   safe_query("DELETE FROM ".PREFIX."cup_clan_lineup WHERE $t_name='$cupID' && clanID='$id'");
			   
	           
	             if($_POST['removematches'])
	               safe_query("DELETE FROM ".PREFIX."cup_matches WHERE $t_name3='$cupID' && (clan1='$id' || clan2='$id') && $one_type");
	               
	           redirect('admincenter.php?site=teams&'.$t_name2.'='.$cupID, '', 0);
		    }		  		
	      }
	    }	         
      }
	}  
  }
}
?>	