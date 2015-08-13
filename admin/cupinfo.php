<?php

if(!iscupadmin($userID) OR substr(basename($_SERVER[REQUEST_URI]),0,15) != "admincenter.php") die('Access denied.');	

    include("cupversion.php");

	echo '<br><br><fieldset style="border: 1px solid '.$border.'"><legend style="font: 15px bold;"><b>Cup Information</b></legend>You are using <strong>V'.$version.'</strong> (Built: '.$version_num.'</strong>)</fieldset><br />';
	echo '<iframe src="http://teamx1.com/popup.php?site=bugtracker&catID='.$cat.'" width="100%" height="1050" frameborder="0"></iframe>';
  
?>