 <?php
//include configuration and language
include ("config.php");
$_language->read_module('cup');
?>

<link href="cup.css" rel="stylesheet" type="text/css">



<?php


	$sitesArray = array('brackets',
'clans',
'cup_matches',
'cup_navigation',
'cupactions',
'cups',
'db_v5_2',
'freeagents',
'groups',
'halloffame',
'lassers',
'livecontact',
'mail',
'matches',
'myprofile',
'myteams',
'platforms',
'popup',
'profile',
'quicknavi',
'shout',
'shout_all',
'shout_popup',
'shout_popup_guess',
'shout_user_private',
'some',
'standings',
'steam',
'teams');

	echo '
<ul>';
	foreach($sitesArray as $page){
		echo '<li><a href="index.php?site='.$page.'">'.$page.'</a></li>';
	}


echo '</ul>';

	/*
	 * sc_clans.php
	 * sc_cupinstant.php
	 * sc_cupmatches.php
	 * sc_cups.php
	 * sc_upcomingmatches.php
	 */

?>