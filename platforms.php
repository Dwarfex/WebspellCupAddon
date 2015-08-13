<link href="cup.css" rel="stylesheet" type="text/css">

<?php
/*
##########################################################################
#               CUP ADDON LADDER EXTENSION BY CUPADDON.COM               #                                                                                                                    #
##########################################################################
*/

$_language->read_module('platforms');

include ("config.php");

$bg1=BG_1;
$bg2=BG_1;
$bg3=BG_1;
$bg4=BG_1;
$cpr=ca_copyr();
if(!$cpr || !ca_copyr()) die();

//date and timezone

$timezone = safe_query("SELECT timezone FROM ".PREFIX."cup_settings");
$tz = mysqli_fetch_array($timezone); $gmt = $tz['timezone'];
date_default_timezone_set($tz['timezone']);
match_query_type();

//get platforms

$platforms = safe_query("SELECT platform FROM ".PREFIX."cup_platforms GROUP BY platform");

  if(iscupadmin($userID)) {
      echo '<input type="button" onclick="MM_openBrWindow(\'admin/admincenter.php?site=platforms\',\'Manage Platforms (via Admincenter)\',\'toolbar=no,status=no,scrollbars=yes,width=800,height=550\');" value="Manage Platforms (via Admincenter)" />';
  }

  if(!mysqli_num_rows($platforms)) {
      echo '<div '.$error_box.'> No platforms found</div>';
  }

    while($pt=mysqli_fetch_array($platforms)) { $platform = $pt['platform'];

	eval ("\$plat_head = \"".gettemplate("platforms_head")."\";");
	echo $plat_head;

if(!$show_inactive_platforms) $activity = "WHERE platform='$platform'";
else $activity = "WHERE platform='$platform' AND status='1'"; 

  $getplatforms = safe_query("SELECT * FROM ".PREFIX."cup_platforms $activity"); 
  while($pl=mysqli_fetch_array($getplatforms)) { $platID = $pl['ID'];

   $getcups2 = safe_query("SELECT * FROM ".PREFIX."cups WHERE platID='$platID'");
   $total_cup_rows = mysqli_num_rows($getcups2);

   $getladders2 = safe_query("SELECT * FROM ".PREFIX."cup_ladders WHERE platID='$platID'");
   $total_ladder_rows = mysqli_num_rows($getladders2);

   $getteams = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE platID='$platID' AND checkin='1'");
   $active_teams = mysqli_num_rows($getteams);

   $getteams2 = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE platID='$platID'");
   $all_teams = mysqli_num_rows($getteams2);
   
   $getmatches = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE platID='$platID'");
   $played_matches = mysqli_num_rows($getmatches);

   $logo = getplatlogo($platID);

	eval ("\$plat_content = \"".gettemplate("platforms_content")."\";");
	echo $plat_content;

   }echo '</table>';
}echo ($cpr ? ca_copyr() : die());
?>