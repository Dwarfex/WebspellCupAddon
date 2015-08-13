<?php include("../config.php");

if(!issuperadmin($userID) OR substr(basename($_SERVER[REQUEST_URI]),0,15) != "admincenter.php") die('Even though this is part of the cup section, only superadmins can optomize the database.');

   echo '<h2>&#187; Database Menu & Useful Tools</h2> (looking for something to ease your cup experience? <a href="http://teamx1.com/?site=contact" target="_blank"><b>contact us</b></a>!)<br><br>';

/*
##########################################################################
# QUERIES                                                                #
##########################################################################
*/

  if($_GET['query']=="reset_standings" && $_GET['cupID']) {
   
    safe_query("UPDATE ".PREFIX."cup_clans SET registered='".time()."', checkin='1', credit='$startupcredit', elo='$elo_rating_default', won='0', draw='0', lost='0', streak='0', xp='0', tp='$startupcredit', wc='0', ma='0', lastpos='0', lastact='0', lastdeduct='0', rank_now='0', rank_then='0' WHERE ladID='".$_GET['cupID']."'");
    safe_query("DELETE FROM ".PREFIX."cup_matches WHERE ladID='".$_GET['cupID']."'");
    safe_query("DELETE FROM ".PREFIX."cup_deduction WHERE ladID='".$_GET['cupID']."'");
    safe_query("DELETE FROM ".PREFIX."cup_challenges WHERE ladID='".$_GET['cupID']."'");
	safe_query("DELETE FROM ".PREFIX."cup_clan_lineup WHERE ladID='".$_GET['cupID']."'");
	safe_query("DELETE FROM ".PREFIX."cup_tickets WHERE ladID='".$_GET['cupID']."'");
	safe_query("UPDATE ".PREFIX."cup_ladders SET 1st='0', 2nd='0', 3rd='0' WHERE ID='".$_GET['cupID']."'");
    redirect('admincenter.php?site=cuptools', '<font color="red"><strong>Standings updated and matches/deductions/challenges/tickets successfully removed from ladder</strong></font>', 2);
    
  }elseif($_GET['query']=="reset_standings") {
    safe_query("UPDATE ".PREFIX."cup_clans SET registered='".time()."', checkin='1', rank_now='0', rank_then='0', credit='$startupcredit', elo='$elo_rating_default', won='0', draw='0', lost='0', streak='0', xp='0', tp='$startupcredit', wc='0', ma='0', lastpos='0', lastact='0', lastdeduct='0', rank_now='0', rank_then='0' WHERE ladID='".$_GET['cupID']."'");
    safe_query("DELETE FROM ".PREFIX."cup_deduction");
    safe_query("DELETE FROM ".PREFIX."cup_challenges");
	safe_query("DELETE FROM ".PREFIX."cup_clan_lineup WHERE ladID!='0'");
    safe_query("DELETE FROM ".PREFIX."cup_matches WHERE cupID='0'");
	safe_query("DELETE FROM ".PREFIX."cup_tickets WHERE ladID=!='0'");
	safe_query("UPDATE ".PREFIX."cup_ladders SET 1st='0', 2nd='0', 3rd='0'");
	redirect('admincenter.php?site=cuptools', '<font color="red"><strong>Standings updated and matches/deductions/challenges/tickets successfully removed from all ladders</strong></font>', 2);
  }

    $cups = '<option selected value="">-- Select Tournament --</option>';
      $cups_query = safe_query("SELECT ID FROM ".PREFIX."cups WHERE maxclan='8' || maxclan='16' || maxclan='32'");
        while($ds=mysql_fetch_array($cups_query)) {
            $cups.='<option value="'.$ds['ID'].'">('.$ds['ID'].') '.getcupname($ds['ID']).'</option>';
        }
        
    $ladders = '<option selected value="">-- Select Ladder --</option>';
      $ladders_query = safe_query("SELECT ID FROM ".PREFIX."cup_ladders");
        while($ds=mysql_fetch_array($ladders_query)) {
            $ladders.='<option value="'.$ds['ID'].'">('.$ds['ID'].') '.getladname($ds['ID']).'</option>';
        }


/*
##########################################################################
# RESET LADDER STANDINGS                                                 #
##########################################################################
*/

echo '<h1>&#187; Reset Ladder</h1><br>';
echo '<select name="ladID" onChange="MM_confirm(\'By clicking OK, the query will reset standings - credits/won/draw/lost/streak/xp and will delete ladder - deductions/matches/challenges/protest tickets for particular ladder.\', \'?site=cuptools&query=reset_standings&cupID=\'+this.value)">'.$ladders.'</select> OR 
      <a onclick="return confirm(\'By clicking OK, the query will reset ALL standings - credits/won/draw/lost/streak/xp and will delete ALL ladder - deductions/matches/challenges/protest tickets for ALL ladders. DB backup advised!\');" href="?site=cuptools&query=reset_standings"><strong>All Ladders</strong></a><br><br>';

/*
##########################################################################
# OPTIMIZATION                                                           #
##########################################################################
*/

echo '<h1>&#187; Database Optimization</h1><br>';
echo '<input type="button" class="button" onClick="MM_goToURL(\'self\',\'admincenter.php?site=optimise\');return document.MM_returnValue" value="View Database Optimization &#187;"><br><br>';


/*
##########################################################################
# REINSTALL                                                              #
##########################################################################
*/

echo '<h1>&#187; Database Menu</h1><br>';
echo '<input type="button" class="button" onClick="MM_goToURL(\'self\',\'../?site=db_v5_2\');return document.MM_returnValue" value="View Database Menu &#187;"><br><br>';

?>