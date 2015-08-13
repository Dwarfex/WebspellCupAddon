<?php

/* Cup Settings */

if(!issuperadmin($userID) && substr(basename($_SERVER[REQUEST_URI]),0,15) != "admincenter.php") die('Only super-admins are authorized to add/remove admins or change global cup settings.');
echo'<h1>&curren; Cup Settings & Information</h1>';

 if (($_POST['cupteamadd'] > $_POST['cupteamjoin']))
  { die('<div style="margin: 5px; padding: 6px; border: 4px solid #D6B4B4; text-align: center;"><a href="admincenter.php?site=cupsettings"><img border="0" src="../images/cup/icons/goback.png" width="16" height="16"></a> <b> You can not create more teams than be in additional teams </b> <img src="../images/cup/error.png" width="16" height="16"><br>Team creation includes being in additional teams. You must enter in an equal value or additional must be greater.</div>'); }

if(isset($_POST['submit'])) {
  safe_query("UPDATE ".PREFIX."cup_settings SET 
          cupaclimit='".$_POST['cupaclimit']."',
          cupgalimit='".$_POST['cupgalimit']."',
          cupblockage='".$_POST['cupblockage']."',
          cupteamlimit='".$_POST['cupteamlimit']."',
          cupteamadd='".$_POST['cupteamadd']."',
          cupteamjoin='".$_POST['cupteamjoin']."',
          cupsclimit='".$_POST['cupsclimit']."',
          cupchathost='".$_POST['cupchathost']."'");
  redirect('admincenter.php?site=cupsettings','<b>Success! <br>Redirecting<img src="../images/cup/period_ani.gif"></b>',0);

} 

$settings = safe_query("SELECT * FROM ".PREFIX."cup_settings");
$ds = mysql_fetch_array($settings);

if($ds['maintenance']==1) echo '<div style="margin: 5px; padding: 6px; border: 4px solid #D6B4B4; text-align: center;"> <b>Note: The cup addon is only accessible to superadmins</b></div>';
if($ds['maintenance']==2) echo '<div style="margin: 5px; padding: 6px; border: 4px solid #D6B4B4; text-align: center;"> <b>Note: The cup addon is only accessible to both superadmins and cupadmins!</b></div>';

//Show matches

		if($ds['ccupgamelimit']==0) { $match = 'Matches shown to logged-in only'; }
		if($ds['ccupgamelimit']==1) { $match = 'Matches shown to all'; }
		
	 $showmatches = '<option selected value="'.$ds['chat'].'">-- Select Access --</option>
			         <option value="0">Only to logged-in</option>
			         <option value="1">Show to All</option>'; 
			         
//sc_cups show closed

		if($ds['cupgamelimit']==0) { $cup = 'Show all cups'; }
		if($ds['cupgamelimit']==1) { $cup = 'Show all except closed cups'; }
		
	    $showcups = '<option selected value="'.$ds['chat'].'">-- Select Access --</option>
			         <option value="0">Show all Cups</option>
			         <option value="1">Hide Closed Cups</option>';
			         
//gameaccount validation 

  if($ds['gameacclimit'] ==0) { $gameacc  = 'Gameaccount Validation - <b>Disabled</b> (backup)'; }
  if($ds['gameacclimit'] ==1) { $gameacc  = 'Gameaccount Validation - <b>Enabled</b> (backup)'; }
  if($ds['cgameacclimit']==0) { $gameacc2 = 'Gameaccount Validation - <b>Disabled</b> (checkin)'; }
  if($ds['cgameacclimit']==1) { $gameacc2 = 'Gameaccount Validation - <b>Enabled</b> (checkin)'; }
		
  $gamevalidation = '<option selected>-- Select Access --</option>
			         <option value="0">Disable</option>
			         <option value="1">Enable</option>'; 
			         
//show cup help

		 if($ds['cupinfo']==0) { $cupinfo = 'Cup help info is hidden'; }
		 if($ds['cupinfo']==1) { $cupinfo = '<b>Cup Information:</b>'; }
		
	     $cuphelp = '<option selected value="'.$ds['cupinfo'].'">-- Select Access --</option>
			         <option value="0">Hide Info</option>
			         <option value="1">Show Info</option>';
			         
//maintenance modes

		 if($ds['maintenance']==0) { $cupstatus = 'Cup addon is active'; }
		 if($ds['maintenance']==1) { $cupstatus = 'Cup addon is only accessible for superadmins'; }
		 if($ds['maintenance']==2) { $cupstatus = 'Cup addon is only accessible for superadmins and cupadmins'; }
		
	       $modes = '<option selected value="'.$ds['maintenance'].'">-- Select Access --</option>
			         <option value="0">Enable Addon</option>
			         <option value="1">Only Superadmins</option>
			         <option value="2">Superadmins/Cupadmins</option>';	  
			         
//cupadmins

			 //add admins
			 
			           $users = '<option value="0" selected">-- Select User --</option>';
			       $admin = safe_query("SELECT * FROM ".PREFIX."user_groups WHERE cup='1' OR super='1'");
			        if(!mysql_num_rows($admin)) { $admins=safe_query("SELECT userID FROM ".PREFIX."user");
			          }else
			            while($up=mysql_fetch_array($admin)) { 
					  $admins=safe_query("SELECT userID FROM ".PREFIX."user WHERE userID != '".$up['userID']."'");
                   } while($dv=mysql_fetch_array($admins)) {
			           $users.='<option value="'.$dv['userID'].'">('.$dv['userID'].') '.getnickname($dv['userID']).'</option>';
			              }   
			              
			 //remove admins
			 
			           $isadmins = '<option value="0" selected">-- Select User --</option>';
			       $admins = safe_query("SELECT * FROM ".PREFIX."user_groups WHERE cup='1'");
			          while($dv=mysql_fetch_array($admins)) {
			         $isadmins.='<option value="'.$dv['userID'].'">('.$dv['userID'].') '.getnickname($dv['userID']).'</option>';
			        }             
//timezone 	  

  $timezones = '

<option selected value="'.$ds['timezone'].'">Current: '.$ds['timezone'].'</option>
<option value="Pacific/Midway">(GMT-11:00) Midway Island, Samoa</option>
<option value="America/Adak">(GMT-10:00) Hawaii-Aleutian</option>
<option value="Etc/GMT+10">(GMT-10:00) Hawaii</option>
<option value="Pacific/Marquesas">(GMT-09:30) Marquesas Islands</option>
<option value="Pacific/Gambier">(GMT-09:00) Gambier Islands</option>
<option value="America/Anchorage">(GMT-09:00) Alaska</option>
<option value="America/Ensenada">(GMT-08:00) Tijuana, Baja California</option>
<option value="Etc/GMT+8">(GMT-08:00) Pitcairn Islands</option>
<option value="America/Los_Angeles">(GMT-08:00) Pacific Time (US & Canada)</option>
<option value="America/Denver">(GMT-07:00) Mountain Time (US & Canada)</option>
<option value="America/Chihuahua">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
<option value="America/Dawson_Creek">(GMT-07:00) Arizona</option>
<option value="America/Belize">(GMT-06:00) Saskatchewan, Central America</option>
<option value="America/Cancun">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
<option value="Chile/EasterIsland">(GMT-06:00) Easter Island</option>
<option value="America/Chicago">(GMT-06:00) Central Time (US & Canada)</option>
<option value="America/New_York">(GMT-05:00) Eastern Time (US & Canada)</option>
<option value="America/Havana">(GMT-05:00) Cuba</option>
<option value="America/Bogota">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
<option value="America/Caracas">(GMT-04:30) Caracas</option>
<option value="America/Santiago">(GMT-04:00) Santiago</option>
<option value="America/La_Paz">(GMT-04:00) La Paz</option>
<option value="Atlantic/Stanley">(GMT-04:00) Faukland Islands</option>
<option value="America/Campo_Grande">(GMT-04:00) Brazil</option>
<option value="America/Goose_Bay">(GMT-04:00) Atlantic Time (Goose Bay)</option>
<option value="America/Glace_Bay">(GMT-04:00) Atlantic Time (Canada)</option>
<option value="America/St_Johns">(GMT-03:30) Newfoundland</option>
<option value="America/Araguaina">(GMT-03:00) UTC-3</option>
<option value="America/Montevideo">(GMT-03:00) Montevideo</option>
<option value="America/Miquelon">(GMT-03:00) Miquelon, St. Pierre</option>
<option value="America/Godthab">(GMT-03:00) Greenland</option>
<option value="America/Argentina/Buenos_Aires">(GMT-03:00) Buenos Aires</option>
<option value="America/Sao_Paulo">(GMT-03:00) Brasilia</option>
<option value="America/Noronha">(GMT-02:00) Mid-Atlantic</option>
<option value="Atlantic/Cape_Verde">(GMT-01:00) Cape Verde Is.</option>
<option value="Atlantic/Azores">(GMT-01:00) Azores</option>
<option value="Europe/Belfast">(GMT) Greenwich Mean Time : Belfast</option>
<option value="Europe/Dublin">(GMT) Greenwich Mean Time : Dublin</option>
<option value="Europe/Lisbon">(GMT) Greenwich Mean Time : Lisbon</option>
<option value="Europe/London">(GMT) Greenwich Mean Time : London</option>
<option value="Africa/Abidjan">(GMT) Monrovia, Reykjavik</option>
<option value="Europe/Amsterdam">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
<option value="Europe/Belgrade">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
<option value="Europe/Brussels">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
<option value="Africa/Algiers">(GMT+01:00) West Central Africa</option>
<option value="Africa/Windhoek">(GMT+01:00) Windhoek</option>
<option value="Asia/Beirut">(GMT+02:00) Beirut</option>
<option value="Africa/Cairo">(GMT+02:00) Cairo</option>
<option value="Asia/Gaza">(GMT+02:00) Gaza</option>
<option value="Africa/Blantyre">(GMT+02:00) Harare, Pretoria</option>
<option value="Asia/Jerusalem">(GMT+02:00) Jerusalem</option>
<option value="Europe/Minsk">(GMT+02:00) Minsk</option>
<option value="Asia/Damascus">(GMT+02:00) Syria</option>
<option value="Europe/Moscow">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
<option value="Africa/Addis_Ababa">(GMT+03:00) Nairobi</option>
<option value="Asia/Tehran">(GMT+03:30) Tehran</option>
<option value="Asia/Dubai">(GMT+04:00) Abu Dhabi, Muscat</option>
<option value="Asia/Yerevan">(GMT+04:00) Yerevan</option>
<option value="Asia/Kabul">(GMT+04:30) Kabul</option>
<option value="Asia/Yekaterinburg">(GMT+05:00) Ekaterinburg</option>
<option value="Asia/Tashkent">(GMT+05:00) Tashkent</option>
<option value="Asia/Kolkata">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
<option value="Asia/Katmandu">(GMT+05:45) Kathmandu</option>
<option value="Asia/Dhaka">(GMT+06:00) Astana, Dhaka</option>
<option value="Asia/Novosibirsk">(GMT+06:00) Novosibirsk</option>
<option value="Asia/Rangoon">(GMT+06:30) Yangon (Rangoon)</option>
<option value="Asia/Bangkok">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
<option value="Asia/Krasnoyarsk">(GMT+07:00) Krasnoyarsk</option>
<option value="Asia/Hong_Kong">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
<option value="Asia/Irkutsk">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
<option value="Australia/Perth">(GMT+08:00) Perth</option>
<option value="Australia/Eucla">(GMT+08:45) Eucla</option>
<option value="Asia/Tokyo">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
<option value="Asia/Seoul">(GMT+09:00) Seoul</option>
<option value="Asia/Yakutsk">(GMT+09:00) Yakutsk</option>
<option value="Australia/Adelaide">(GMT+09:30) Adelaide</option>
<option value="Australia/Darwin">(GMT+09:30) Darwin</option>
<option value="Australia/Brisbane">(GMT+10:00) Brisbane</option>
<option value="Australia/Hobart">(GMT+10:00) Hobart</option>
<option value="Asia/Vladivostok">(GMT+10:00) Vladivostok</option>
<option value="Australia/Lord_Howe">(GMT+10:30) Lord Howe Island</option>
<option value="Etc/GMT-11">(GMT+11:00) Solomon Is., New Caledonia</option>
<option value="Asia/Magadan">(GMT+11:00) Magadan</option>
<option value="Pacific/Norfolk">(GMT+11:30) Norfolk Island</option>
<option value="Asia/Anadyr">(GMT+12:00) Anadyr, Kamchatka</option>
<option value="Pacific/Auckland">(GMT+12:00) Auckland, Wellington</option>
<option value="Etc/GMT-12">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
<option value="Pacific/Chatham">(GMT+12:45) Chatham Islands</option>
<option value="Pacific/Tongatapu">(GMT+13:00) Nuku\'alofa</option>
<option value="Pacific/Kiritimati">(GMT+14:00) Kiritimati</option>';		        

//dropdown queries 
			         
		if(isset($_GET['query']) && $_GET['query'] == 'showmatches') {
	      safe_query("UPDATE ".PREFIX."cup_settings SET ccupgamelimit='".$_GET['matchaccess']."'");	
		  redirect('admincenter.php?site=cupsettings', '<center><b>Match accessibility successfully changed<img src="../images/cup/period_ani.gif"></center>', 1);		
			         
		}elseif(isset($_GET['query']) && $_GET['query'] == 'showclosed') {
	      safe_query("UPDATE ".PREFIX."cup_settings SET cupgamelimit='".$_GET['showcups']."'");	
		  redirect('admincenter.php?site=cupsettings', '<center><b>sc_cups successfully changed<img src="../images/cup/period_ani.gif"></center>', 1);		

		}elseif(isset($_GET['query']) && $_GET['query'] == 'gameaccbackup') {
	      safe_query("UPDATE ".PREFIX."cup_settings SET gameacclimit='".$_GET['backupvalidation']."'");	
		  redirect('admincenter.php?site=cupsettings', '<center><b>Gameaccount backup validation  successfully changed<img src="../images/cup/period_ani.gif"></center>', 1);		
		
		}elseif(isset($_GET['query']) && $_GET['query'] == 'gameacccheckin') {
	      safe_query("UPDATE ".PREFIX."cup_settings SET cgameacclimit='".$_GET['checkinvalidation']."'");	
		  redirect('admincenter.php?site=cupsettings', '<center><b>Gameaccount checkin validation successfully changed<img src="../images/cup/period_ani.gif"></center>', 1);		
		  
		}elseif(isset($_GET['query']) && $_GET['query'] == 'cuphelp') {
	      safe_query("UPDATE ".PREFIX."cup_settings SET cupinfo='".$_GET['cupinfo']."'");	
		  redirect('admincenter.php?site=cupsettings', '<center><b>Cup info successfully changed<img src="../images/cup/period_ani.gif"></center>', 0);		

		}elseif(isset($_GET['query']) && $_GET['query'] == 'maintenance') {
	      safe_query("UPDATE ".PREFIX."cup_settings SET maintenance='".$_GET['status']."'");	
		  redirect('admincenter.php?site=cupsettings', '<center><b>Maintenance mode successfully changed<img src="../images/cup/period_ani.gif"></center>', 1);		

		}elseif(isset($_GET['query']) && $_GET['query'] == 'timezone') {
	      safe_query("UPDATE ".PREFIX."cup_settings SET timezone='".$_GET['set']."'");	
		  redirect('admincenter.php?site=cupsettings', '<center><b>Timezone successfully changed<img src="../images/cup/period_ani.gif"></center>', 1);		

		}elseif(isset($_GET['query']) && $_GET['query'] == 'addadmin') {
	      safe_query("UPDATE ".PREFIX."user_groups SET cup='1' WHERE userID='".$_GET['userID']."'");	
		  redirect('admincenter.php?site=cupsettings', '<center><b>'.getnickname($_GET['userID']).' can now access the admin cup section</b><br>Now redirecting<img src="../images/cup/period_ani.gif"></center>', 1);
		  		
		}elseif(isset($_GET['query']) && $_GET['query'] == 'removeadmin') {
	      safe_query("UPDATE ".PREFIX."user_groups SET cup='0' WHERE userID='".$_GET['userID']."'");	
		  redirect('admincenter.php?site=cupsettings', '<center><b>'.getnickname($_GET['userID']).' cup admin access removed</b><br>Now redirecting<img src="../images/cup/period_ani.gif"></center>', 1);		
         }
?>

<form method="post" action="admincenter.php?site=cupsettings">

<div style="width: 45%;float: left;">
	<table width="100%" border="0" cellspacing="1" cellpadding="3">
	  <tr>
	    <td width="50%"><b>Cup Addon Settnigs:</b> <font color="red">(more settings and options at config.php)</font></td>
	    <td>&nbsp;</td>
	  </tr>
    <tr>
	    <td align="right"><input type="text" name="cupsclimit" value="<?php echo $ds['cupsclimit']; ?>" size="3" onmouseover="showWMTT('id56')" onmouseout="hideWMTT()" /></td>
	    <td>sc_cups limit</td>
	  </tr>
    <tr>
	    <td align="right"><input type="text" name="cupblockage" value="<?php echo $ds['cupblockage']; ?>" size="3" onmouseover="showWMTT('id52')" onmouseout="hideWMTT()" /></td>
	    <td>Block Points</td>
	  </tr>
    <tr>
	    <td align="right"><input type="text" name="cupteamlimit" value="<?php echo $ds['cupteamlimit']; ?>" size="3" onmouseover="showWMTT('id53')" onmouseout="hideWMTT()" /></td>
	    <td>Teams Page</td>
	  </tr>
    <tr>
	    <td align="right"><input type="text" name="cupteamadd" value="<?php echo $ds['cupteamadd']; ?>" size="3" onmouseover="showWMTT('id58')" onmouseout="hideWMTT()" /></td>
	    <td>Team Limit (creation)</td>
	  </tr>	  
    <tr>
	    <td align="right">
		<input type="text" name="cupteamjoin" value="<?php echo $ds['cupteamjoin']; ?>" size="3" onmouseover="showWMTT('id55')" onmouseout="hideWMTT()" /></td>
	    <td>Team Limit (additional-<?php echo $ds['cupteamadd']; ?>) Total max teams: <b><?php echo $ds['cupteamjoin']; ?></b></td> 
	  </tr>
	</table>
</div>	  

<b>Timezone:</b>
<select name="timezone" onChange="MM_confirm('Confirm?', 'admincenter.php?site=cupsettings&query=timezone&set='+this.value)"><?php echo $timezones; ?></select>
<br>

<div style="width: 45%;float: right;">
	<table width="100%" border="0" cellspacing="1" cellpadding="3">
	  <tr>
	    <td align="right"><select name="showclosed" onChange="MM_confirm('Confirm?', 'admincenter.php?site=cupsettings&query=showclosed&showcups='+this.value)"><?php echo $showcups; ?></select></td>
	    <td><?php echo $cup; ?></td>
	  </tr>	
    <tr>
	    <td align="right">
		<select name="showmatches" onChange="MM_confirm('Confirm?', 'admincenter.php?site=cupsettings&query=showmatches&matchaccess='+this.value)"><?php echo $showmatches; ?></select></td>
	    <td><?php echo $match; ?></td>
	  </tr>	  	  
	</table>
</div>

<div style="clear: both; text-align: center; padding-top: 20px;">
  <input type="submit" name="submit" value="Update Settings" />
</div>

<br><br>

<div style="width: 45%;float: left;">
 <table width="100%" border="0" cellspacing="1" cellpadding="3">
   <tr>
    <td align="left"><select name="admin" onChange="MM_confirm('Confirm?', 'admincenter.php?site=cupsettings&query=addadmin&userID='+this.value)"><?php echo $users; ?></select><br>Add Admin</td>
  </tr>
   <tr>
    <td align="left"><select name="admin" onChange="MM_confirm('Confirm?', 'admincenter.php?site=cupsettings&query=removeadmin&userID='+this.value)"><?php echo $isadmins; ?></select><br>Remove Admin</td>
  </tr>
 </table>	
</div> 

<br>
<?php

if($ds['cupinfo']==1) {

	if(function_exists('file_get_contents')){

		include "cupversion.php";
		$get_info = file_get_contents($updateserver.'info.php');
		$releases = explode("###",$get_info);
		
				if($releasesx[9]!='!'){
			foreach($releases as $release){
				$release = explode("||",$release);
		        echo $get_info;
			}
	     }
	  }  
   }  
?>