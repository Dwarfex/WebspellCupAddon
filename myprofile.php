<?php
/*
##########################################################################
#                                                                        #
#           Version 4       /                        /   /               #
#          -----------__---/__---__------__----__---/---/-               #
#           | /| /  /___) /   ) (_ `   /   ) /___) /   /                 #
#          _|/_|/__(___ _(___/_(__)___/___/_(___ _/___/___               #
#                       Free Content / Management System                 #
#                                   /                                    #
#                                                                        #
#                                                                        #
#   Copyright 2005-2009 by webspell.org                                  #
#                                                                        #
#   visit webSPELL.org, webspell.info to get webSPELL for free           #
#   - Script runs under the GNU GENERAL PUBLIC LICENSE                   #
#   - It's NOT allowed to remove this copyright-tag                      #
#   -- http://www.fsf.org/licensing/licenses/gpl.html                    #
#                                                                        #
#   Code based on WebSPELL Clanpackage (Michael Gruber - webspell.at),   #
#   Far Development by Development Team - webspell.org                   #
#                                                                        #
#   visit webspell.org                                                   #
#                                                                        #
##########################################################################
*/

include ("config.php");
include ("steam.php");

$bg1=BG_1;
$bg2=BG_1;
$bg3=BG_1;
$bg4=BG_1;

$_language->read_module('myprofile');

if(!$userID) echo $_language->module['not_logged_in'];

else {

if(isset($uid)) {
   $myfbavatar = '<img src="http://graph.facebook.com/'.$uid.'/picture" alt="Facebook Image" />';
   $fbimg = '<div style="padding:10px 0 5px 0;">
    <a onclick="document.getElementById(\'avatarurl\').value=\'http://graph.facebook.com/'.$uid.'/picture\';" onmouseover="showWMTT(\'myavatar\')" onmouseout="hideWMTT()">Use my Facebook Image</a>
    <div class="tooltip" id="myavatar">'.$myfbavatar.'</div></div>';
} else $fbimg = '';

	$showerror = '';
	eval ("\$title_myprofile = \"".gettemplate("title_myprofile")."\";");
	echo $title_myprofile;

	if(isset($_POST['submit'])) {
		$nickname = htmlspecialchars(mb_substr(trim($_POST['nickname']), 0, 30));
		if(isset($_POST['mail'])) $mail = $_POST['mail'];
    	else $mail="";
		if(isset($_POST['mail_hide'])) $mail_hide = true;
		else $mail_hide = false;
		$usernamenew = mb_substr(trim($_POST['usernamenew']), 0, 30);
		$usertext = $_POST['usertext'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$b_day = $_POST['b_day'];
		$b_month = $_POST['b_month'];
		$b_year = $_POST['b_year'];
		$sex = $_POST['sex'];
		$flag = $_POST['flag'];
		$town = $_POST['town'];
		$icq = $_POST['icq'];
		$icq = str_replace('-','',$icq); // Replace - 

             // Start of: Steam-Community v2.1
		$sc_id = $_POST['sc_id'];
             // End of: Steam-Community v2.1
	        $xfire = $_POST['xfire'];
                 $xfirec = $_POST['xfirec'];
                 $xfirestyle = $_POST['xfirestyle'];
                 $xfiregroesse = $_POST['xfiregroesse'];
                 $steam = $_POST['steam'];
		$about = $_POST['messageabout'];
		$clantag = $_POST['clantag'];
		$clanname = $_POST['clanname'];
                $skype = $_POST['skype'];
	        $msn = $_POST['msn'];
	        $aim = $_POST['aim'];
	        $yahoo = $_POST['yahoo'];
		$clanhp = $_POST['clanhp'];
		$clanirc = $_POST['clanirc'];
		$clanhistory = $_POST['clanhistory'];
		$cpu = $_POST['cpu'];
		$storage = $_POST['storage'];
		$headset = $_POST['headset'];
		$mainboard = $_POST['mainboard'];
		$monitor = $_POST['monitor'];
		$ram = $_POST['ram'];
		$graphiccard = $_POST['graphiccard'];
		$soundcard = $_POST['soundcard'];
		$connection = $_POST['connection'];
		$keyboard = $_POST['keyboard'];
		$mouse = $_POST['mouse'];
		$mousepad = $_POST['mousepad'];
	    $fgame = $_POST['fgame'];
        $fclan = $_POST['fclan'];
        $fmap = $_POST['fmap'];
        $fweapon = $_POST['fweapon'];
        $ffood = $_POST['ffood'];
        $fdrink = $_POST['fdrink'];
        $fmovie = $_POST['fmovie'];
        $fmusic = $_POST['fmusic'];
        $fsong = $_POST['fsong'];
        $fbook = $_POST['fbook'];
        $factor = $_POST['factor'];
        $fcar = $_POST['fcar'];
        $fsport = $_POST['fsport'];
		$newsletter = $_POST['newsletter'];
		$jgrowl = $_POST['jgrowl'];
		$homepage = str_replace('http://', '', $_POST['homepage']);
		$pm_mail = $_POST['pm_mail'];
		$avatar = $_FILES['avatar'];
		$userpic = $_FILES['userpic'];
		$language = $_POST['language'];
                $clanesl = $_POST['clanesl'];
		$id = $userID;
		
		$error_array = array();
		
		if(isset($_POST['userID']) or isset($_GET['userID']) or $userID=="") die($_language->module['not_logged_in']);

		if(isset($_POST['delavatar'])) {
			$filepath = "./images/avatars/";
			if(file_exists($filepath.$id.'.gif')) @unlink($filepath.$id.'.gif');
			if(file_exists($filepath.$id.'.jpg')) @unlink($filepath.$id.'.jpg');
			if(file_exists($filepath.$id.'.png')) @unlink($filepath.$id.'.png');
			safe_query("UPDATE ".PREFIX."user SET avatar='' WHERE userID='".$id."'");
		}
		if(isset($_POST['deluserpic'])) {
			$filepath = "./images/userpics/";
			if(file_exists($filepath.$id.'.gif')) @unlink($filepath.$id.'.gif');
			if(file_exists($filepath.$id.'.jpg')) @unlink($filepath.$id.'.jpg');
			if(file_exists($filepath.$id.'.png')) @unlink($filepath.$id.'.png');
			safe_query("UPDATE ".PREFIX."user SET userpic='' WHERE userID='".$id."'");
		}

		//avatar
		$filepath = "./images/avatars/";
		if($avatar['name'] != "" or ($_POST['avatar_url'] != "" and $_POST['avatar_url'] != "http://")) {
			if($avatar['name'] != "") {
				move_uploaded_file($avatar['tmp_name'], $filepath.$avatar['name'].".tmp");
			}
			else {
				$avatar['name'] = strrchr($_POST['avatar_url'],"/");
				
				$content = file_get_contents($_POST['avatar_url']);
        //Store in the filesystem. 
        $fp = fopen($filepath.$avatar['name'].".tmp", "w");
        fwrite($fp, $content);
        fclose($fp); 
				
        /*$file = $_POST['avatar_url'];
        $current = file_get_contents($file);
        file_put_contents($file, $current);
				if(!copy($_POST['avatar_url'],$filepath.$avatar['name'].".tmp")) {
					$error_array['can_not_copy'] = $_language->module['can_not_copy'];
				}*/
				
			}
			if(!array_key_exists('can_not_copy', $error_array))
			{
				@chmod($filepath.$avatar['name'].".tmp", $new_chmod);
				$info = getimagesize($filepath.$avatar['name'].".tmp");
				if($info[0] < 91 && $info[1] < 91) {
					$pic = '';
					if($info[2] == 1) $pic=$id.'.gif';
					elseif($info[2] == 2) $pic=$id.'.jpg';
					elseif($info[2] == 3) $pic=$id.'.png';
					if($pic != "") {
						if(file_exists($filepath.$id.'.gif')) @unlink($filepath.$id.'.gif');
						if(file_exists($filepath.$id.'.jpg')) @unlink($filepath.$id.'.jpg');
						if(file_exists($filepath.$id.'.png')) @unlink($filepath.$id.'.png');
						rename($filepath.$avatar['name'].'.tmp', $filepath.$pic);
						safe_query("UPDATE ".PREFIX."user SET avatar='".$pic."' WHERE userID='".$id."'");
					}
					else {
						if(unlink($filepath.$avatar['name'].".tmp")) {
							$error_array[] = $_language->module['invalid_picture-format'];
						}
						else {
							$error_array[] = $_language->module['upload_failed'];
						}
					}
				}
				else {
					@unlink($filepath.$avatar['name'].".tmp");
					$error_array[] = $_language->module['picture_too_big_avatar'];
				}
			}
		}

		//userpic
		$filepath = "./images/userpics/";
		if($userpic['name'] != "" or ($_POST['userpic_url'] != "" and $_POST['userpic_url'] != "http://")) {
			if($userpic['name'] != "") {
				move_uploaded_file($userpic['tmp_name'], $filepath.$userpic['name'].".tmp");
			} else {
				$userpic['name'] = strrchr($_POST['userpic_url'],"/");
				if(!copy($_POST['userpic_url'],$filepath.$userpic['name'].".tmp")) {
					$error_array['can_not_copy'] = $_language->module['can_not_copy'];
				}
			}
			if(!array_key_exists('can_not_copy', $error_array))
			{
				@chmod($filepath.$userpic['name'].".tmp", $new_chmod);
				$info = getimagesize($filepath.$userpic['name'].".tmp");
				if($info[0] < 231 && $info[1] < 211) {
					$pic = '';
					if($info[2] == 1) $pic=$id.'.gif';
					elseif($info[2] == 2) $pic=$id.'.jpg';
					elseif($info[2] == 3) $pic=$id.'.png';
					if($pic != "") {
						if(file_exists($filepath.$id.'.gif')) @unlink($filepath.$id.'.gif');
						if(file_exists($filepath.$id.'.jpg')) @unlink($filepath.$id.'.jpg');
						if(file_exists($filepath.$id.'.png')) @unlink($filepath.$id.'.png');
						rename($filepath.$userpic['name'].".tmp", $filepath.$pic);
						safe_query("UPDATE ".PREFIX."user SET userpic='".$pic."' WHERE userID='".$id."'");
					}
					else {
						if(unlink($filepath.$userpic['name'].".tmp")) {
							$error_array[] = $_language->module['invalid_picture-format'];
						}
						else {
							$error_array[] = $_language->module['upload_failed'];
						}
					}
				}
				else {
					@unlink($filepath.$userpic['name'].".tmp");
					$error_array[] = $_language->module['picture_too_big_userpic'];
				}
			}
		}

		$birthday = $b_year.'-'.$b_month.'-'.$b_day;

		$qry = "SELECT userID FROM ".PREFIX."user WHERE username = '".$usernamenew."' AND userID != ".$userID." LIMIT 0,1";
		if(mysqli_num_rows(safe_query($qry))) {
			$error_array[] = $_language->module['username_aleady_in_use'];
		}
		
		$qry = "SELECT userID FROM ".PREFIX."user WHERE nickname = '".$nickname."' AND userID!=".$userID." LIMIT 0,1";
		if(mysqli_num_rows(safe_query($qry))) {
				$error_array[] = $_language->module['nickname_already_in_use'];
		}

		if(count($error_array)) 
		{
			$fehler=implode('<br />&#8226; ', $error_array);
			$showerror = '<div class="errorbox">
			  <b>'.$_language->module['errors_there'].':</b><br /><br />
			  &#8226; '.$fehler.'
			</div>';
		}
		else
		{
			safe_query("UPDATE `".PREFIX."user`
						SET 
							nickname='".$nickname."',
							username='".$usernamenew."',
							email_hide='".$mail_hide."',
							firstname='".$firstname."',
							lastname='".$lastname."',
							sex='".$sex."',
							country='".$flag."',
							town='".$town."',
							birthday='".$birthday."',
							icq='".$icq."',
                                                        sc_id='".$sc_id."',
						        xfire='".$xfire."',
                                                        xfirec='".$xfirec."',
                                                        steam='".$steam."',
					                xfirestyle='".mysqli_escape_string($xfirestyle)."',
						        xfiregroesse='".mysqli_escape_string($xfiregroesse)."',
							usertext='".$usertext."',
							clantag='".$clantag."',
							clanname='".$clanname."',
                                                        skype='".mysqli_escape_string($skype)."',
						        msn='".mysqli_escape_string($msn)."',
						        aim='".mysqli_escape_string($aim)."',
						        yahoo='".mysqli_escape_string($yahoo)."',
                                                        clanhp='".$clanhp."',
							clanirc='".$clanirc."',
							clanhistory='".$clanhistory."',
							storage='".$storage."',
							headset='".$headset."',
							cpu='".$cpu."',
							mainboard='".$mainboard."',
							ram='".$ram."',
							monitor='".$monitor."',
							graphiccard='".$graphiccard."',
							soundcard='".$soundcard."',
							verbindung='".$connection."',
							keyboard='".$keyboard."',
							mouse='".$mouse."',
							mousepad='".$mousepad."',
							fgame='".mysqli_escape_string($fgame)."',
 						    fclan='".mysqli_escape_string($fclan)."',
 						    fmap='".mysqli_escape_string($fmap)."',
 					        fweapon='".mysqli_escape_string($fweapon)."',
 				       	    ffood='".mysqli_escape_string($ffood)."',
 				      	    fdrink='".mysqli_escape_string($fdrink)."',
 						    fmovie='".mysqli_escape_string($fmovie)."',
 		    		        fmusic='".mysqli_escape_string($fmusic)."',
 					    	fsong='".mysqli_escape_string($fsong)."',
 					  	    fbook='".mysqli_escape_string($fbook)."',
 					   	    factor='".mysqli_escape_string($factor)."',
 					   		fcar='".mysqli_escape_string($fcar)."',
 						  	fsport='".mysqli_escape_string($fsport)."',
                            mailonpm='".$pm_mail."',
							newsletter='".$newsletter."',
							jgrowl='".$jgrowl."',
							homepage='".$homepage."',
							about='".$about."',
							language='".$language."',
                                                        clanesl='".$clanesl."'
						WHERE 
							userID='".$id."'");
	
			redirect("index.php?site=profile&amp;id=$id", $_language->module['profile_updated'],3);
		}
}elseif($_GET['action']=="timezone") {

if(!$_GET['userID']) echo '<meta http-equiv="refresh" content="0; URL=?site=myprofile&action=timezone&userID='.$userID.'">';

if($_GET['type']=='redir') echo '<div class="errorbox"><img src="images/cup/icons/contact_info.png"> You have been automatically redirected to set your timezone.<br> You can change your timezone in future by editing your profile.<br><br> <img src="images/cup/icons/contact_info.png"> To prevent redirection and void setting your timezone select "<b>Unset and do not ask again</b>" under User Options.</div>';

$DSZ=mysqli_fetch_array(safe_query("SELECT timezone FROM ".PREFIX."user WHERE userID='".$_GET['userID']."'"));

if(empty($DSZ['timezone']) OR $DSZ['timezone']==1) {
      $curr_tz = '(timezone unset)';
}
else{
      $curr_tz = $DSZ['timezone'];
}

 $timezones_sel = '
<optgroup label="User Options">
<option value="1">Unset and do not ask again</option>
<option value="0">Unset only</option>
<optgroup label="Timezones">
<option selected value="'.$DSZ['timezone'].'">Current: '.$curr_tz.'</option>
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

if(isset($_GET['url'])) $timezone_url_redirect = '&url='.urlencode($_GET['url']);
else $timezone_url_redirect = false;

if(isset($_GET['userID']))

echo '
			<form method="post" action="index.php?site=myprofile&action=timezone&userID='.$_GET['userID'].$timezone_url_redirect.'">
				<table width="100%" border="0" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'" bgcolor="'.BORDER.'">
				    <tr>
						<td class="title" colspan="2" align="center" bgcolor="'.$bghead.'">Set Timezone</td>
				    </tr>
					<tr> 
						<td colspan="2" bgcolor="'.$pagebg.'"></td>
					</tr>
				     <tr>
						<td bgcolor="'.BG_1.'" style="width:40%;" align="right">Timezone:</td>
						<td bgcolor="'.BG_2.'"><select name="timezone">'.$timezones_sel.'</select></td>
				    </tr>
					<tr>
						<td bgcolor="'.BG_1.'"><input type="hidden" name="id" value="'.$_GET['userID'].'"></td>
						<td bgcolor="'.BG_2.'"><input type="submit" name="savetz" value="Save"></td>
				     </tr>
				</table>
			</form>';
			
if($_POST['savetz']) {
   safe_query("UPDATE ".PREFIX."user SET timezone='".$_POST['timezone']."' WHERE userID='".$_POST['id']."'");
   
   if(isset($_GET['url'])) {
       redirect(urldecode($_GET['url']), '<font color="red"><strong>Timezone successfully set! Redirecting...</strong></font>', 2); 
   } else {
       redirect('?site=profile&id='.$_POST['id'], '<font color="red"><strong>Timezone successfully set!</strong></font>', 2);   
   }
}
	
}elseif($_GET['action']=="gameaccounts") {
  
			$gamesa=safe_query("SELECT gameaccID,type FROM ".PREFIX."gameacc ORDER BY type");
	 		while($dv=mysqli_fetch_array($gamesa)) {
			 $games.='<option value="'.$dv[gameaccID].'">'.$dv[type].'</option>';
			}

			$gamea=safe_query("SELECT gameaccID, type, value FROM ".PREFIX."user_gameacc WHERE userID='$userID' && log='0' ORDER BY type");
	 		while($dv=mysqli_fetch_array($gamea)) {
				$gamesa=safe_query("SELECT * FROM ".PREFIX."gameacc WHERE gameaccID='".$dv[type]."'");
				$db=mysqli_fetch_array($gamesa);
			 $game.='<option value="'.$dv[gameaccID].'">'.$db[type].'</option>';
			}	

	echo'
	<script>
	function menu_switch(first, second, third, fourth) {
		document.getElementById(first).style.display="block";
		document.getElementById(second).style.display="none";
		document.getElementById(third).style.display="none";
		document.getElementById(fourth).style.display="none";
	}
	</script>
	<fieldset style="border: 1px solid '.$border.'; padding:6px;"><legend><a href="javascript:menu_switch(\'addgacc\',\'editgacc\',\'delgacc\',\'eslgacc\');" style="font-size:13px;"><b>Add</b></a> | <a href="javascript:menu_switch(\'editgacc\',\'addgacc\',\'delgacc\',\'eslgacc\');" style="font-size:13px;"><b>Edit</b></a> | <a href="javascript:menu_switch(\'delgacc\',\'addgacc\',\'editgacc\',\'eslgacc\');" style="font-size:13px;"><b>Delete</b></a> | <a href="javascript:menu_switch(\'eslgacc\',\'addgacc\',\'editgacc\',\'delgacc\');" style="font-size:13px;"><b>ESL</b></a></legend>
		<div id="addgacc" style="display:block;">
			<form method="post" action="index.php?site=myprofile">
				<table width="100%" border="0" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'" bgcolor="'.BORDER.'">
				    <tr>
						<td class="title" colspan="2" align="center" bgcolor="'.$bghead.'">Add Gameaccount</td>
				    </tr>
					<tr> 
						<td colspan="2" bgcolor="'.$pagebg.'"></td>
					</tr>
				     <tr>
						<td bgcolor="'.BG_1.'" style="width:40%;" align="right">Type:</td>
						<td bgcolor="'.BG_2.'"><select name="type">'.$games.'</select></td>
				    </tr>
					<tr>
						<td bgcolor="'.BG_1.'" style="width:40%;" align="right">Value:</td>
						<td bgcolor="'.BG_2.'"><input name="value" type="text" size="30"></td>
				    </tr>
					<tr>
						<td bgcolor="'.BG_1.'"><input type="hidden" name="id" value="'.$userID.'"></td>
						<td bgcolor="'.BG_2.'"><input type="submit" name="save" value="Save"></td>
				     </tr>
				</table>
			</form>
		</div>
		<div id="editgacc" style="display:none;">
			<form method="post" action="index.php?site=myprofile">
				<table width="100%" border="0" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'" bgcolor="'.BORDER.'">
				    <tr>
						<td class="title" colspan="2" align="center" bgcolor="'.$bghead.'">Edit Gameaccount</td>
				    </tr>
					<tr> 
						<td colspan="2" bgcolor="'.$pagebg.'"></td>
					</tr>
				    <tr>
						<td bgcolor="'.BG_1.'" style="width:40%;" align="right">Type:</td>
						<td bgcolor="'.BG_2.'"><select name="type">'.$game.'</select></td>
				    </tr>
					<tr>
						<td bgcolor="'.BG_1.'" style="width:40%;" align="right">Value:</td>
						<td bgcolor="'.BG_2.'"><input name="value" type="text" size="30"  value="'.$dv[value].'"></td>
				    </tr>
					<tr>
						<td bgcolor="'.BG_1.'"><input type="hidden" name="id" value="'.$userID.'"></td>
						<td bgcolor="'.BG_2.'"><input type="submit" name="edit" value="save"></td>
				    </tr>
				</table>
			</form>
		</div>
		<div id="delgacc" style="display:none;">
			<form method="post" action="index.php?site=myprofile">
				<table width="100%" border="0" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'" bgcolor="'.BORDER.'">
				    <tr>
						<td class="title" colspan="2" align="center" bgcolor="'.$bghead.'">Delete Gameaccount</td>
				    </tr>
					<tr> 
						<td colspan="2" bgcolor="'.$pagebg.'"></td>
					</tr>
				    <tr>
						<td bgcolor="'.BG_1.'" style="width:40%;" align="right">Account:</td>
						<td bgcolor="'.BG_2.'"><select name="type">'.$game.'</select></td>
				    </tr>
					<tr>
						<td bgcolor="'.BG_1.'"><input type="hidden" name="id" value="'.$userID.'"></td>
						<td bgcolor="'.BG_2.'"><input type="submit" name="delete_acc" value="delete"></td>
				    </tr>
				</table>
			</form>
		</div>
		<div id="eslgacc" style="display:none;">
			<form method="post" action="index.php?site=myprofile">
				<table width="100%" border="0" cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'" bgcolor="'.BORDER.'">
				    <tr>
						<td class="title" colspan="2" align="center" bgcolor="'.$bghead.'">Get Gameaccount from ESL</td>
				    </tr>
					<tr> 
						<td colspan="2" bgcolor="'.$pagebg.'"></td>
					</tr>
				    <tr>
						<td bgcolor="'.BG_1.'" style="width:40%;" align="right">Your ESL Player ID:</td>
						<td bgcolor="'.BG_2.'"><input type="text" name="esl_id"></td>
				    </tr>
					<tr>
						<td bgcolor="'.BG_1.'"><input type="hidden" name="id" value="'.$userID.'"></td>
						<td bgcolor="'.BG_2.'"><input type="submit" name="esl" value="save"></td>
				    </tr>
				</table>
			</form>
		</div>
	</fieldset>';
	}
	elseif($_POST['esl']){
		$esl_player=$_POST['esl_id'];
		$id = $_POST['id'];
		$get=@file_get_contents("http://www.esl.eu/de/player/gameaccounts/".$esl_player."/");
		$game_accs=preg_match("/<table class=\"esl_compact_zebra\" width=\"550\">(.*?)<\\/table>/s",str_replace('&#65533;', '',$get),$erg);
		$erg[1] = str_replace(' valign="top"', '',$erg[1]);
		preg_match_all("/<td width=\"(200|280)\">(.*?)<\\/td>/s",$erg[1],$ergs);
		$j=0;
		for($i=0;$i<=count($ergs[0]);$i++){
			if(!isset($ergs[0][$i])) break; 
			$str = $ergs[0][$i];
			$str = trim($str);
			$str = str_replace('<td width="200">', '', $str);
			$str = str_replace('<td width="280">', '', $str);
			$str = str_replace('<img src="http://eslstatic.net/skins/v2007_base/content/active_y.gif" width="9" height="9" border="0" style="margin-right:3px;">', '', $str);
			$str = str_replace('<img src="http://eslstatic.net/skins/v2007_base/content/active_n.gif" width="9" height="9" border="0" style="margin-right:3px;">', '', $str);
			$str = str_replace('</td>', '', $str);
			$str = preg_replace('/<span class="TextSP">(.*?)<\\/span>/s', '', $str);
			$str = preg_replace('/<div class="TextSP">(.*?)<\\/div>/s', '', $str);		
			$str = str_replace("					", "", $str);
			$str = preg_replace("/\s+/", "", $str);
			$str = trim($str);		
			$logins[$j][] = $str;
			if($i%2) $j++;
		}
		
		if(is_array($logins)){
			foreach($logins as $data){
				$check_type=safe_query("SELECT * FROM ".PREFIX."gameacc WHERE type ='".$data[0]."'");
				if(!mysqli_num_rows($check_type)){
					safe_query("INSERT INTO ".PREFIX."gameacc (type) VALUES ('".$data[0]."')");
					$typeID=mysqli_insert_id();
				}else{
					$dl=mysqli_fetch_array($check_type);
					$typeID=$dl['gameaccID'];
				}			
				$get=safe_query("SELECT * FROM ".PREFIX."user_gameacc WHERE userID='$id' AND type='$typeID' && log='0'");
				$get2=safe_query("SELECT * FROM ".PREFIX."user_gameacc WHERE value='".$data[1]."' && log='0'");
				if(!mysqli_num_rows($get) && !mysqli_num_rows($get2)){
					safe_query("INSERT INTO ".PREFIX."user_gameacc (userID,value,type) VALUES ('$id','".$data[1]."','$typeID')");
				}
			}
			echo'Your Gameaccounts has been saved. Just wait a few seconds to be redirected!
	    	          <meta http-equiv="refresh" content="2; URL=index.php?site=profile&id='.$id.'">';
		}else
		echo'No Gameaccounts found. Just wait a few seconds to be redirected!
	    	          <meta http-equiv="refresh" content="2; URL=index.php?site=myprofile&action=gameaccounts">';
	}
	elseif($_POST['save']) {

	  $type = $_POST['type'];
	  $value = $_POST['value'];
	  $id = $_POST['id'];


		$ergebnis = safe_query("SELECT * FROM ".PREFIX."user_gameacc WHERE value = '$value' && type = '$type' && log='0'");
		$num = mysqli_num_rows($ergebnis);
		if($num) $error[]="The Gameaccount already exists!";

		if(!(strlen(trim($value)))) $error[]="You have to enter a Value!";

		if(is_array($error)) {
			echo'<b>There has been errors!</b><br><br>';  
			foreach($error as $err) {
				echo'<li>'.$err.'</li>';
			}
			echo'<br><br><input type="button" class="button" onClick="javascript:history.back()" value="Back">';
		}
		else{

		safe_query("INSERT INTO ".PREFIX."user_gameacc SET type='$type', value='$value', userID='$id'");

		echo'Your Gameaccount has been saved. Just wait a few seconds to be redirected!
	    	          <meta http-equiv="refresh" content="0; URL=?site=profile&id='.$id.'">';
		}
	}elseif($_POST['delete_acc']){
	  $type = $_POST['type'];
	  $id = $_POST['id'];
	  
	  safe_query("UPDATE ".PREFIX."user_gameacc SET log='1' WHERE userID='$id' AND gameaccID='$type'");
	  	echo'The Gameaccount is now in your log. Just wait a few seconds to be redirected!
	    	          <meta http-equiv="refresh" content="0; URL=?site=profile&id='.$id.'&gameacc=changelog#seegameaccounts">';
	    	          
	}elseif($_GET['delete']=='gameaccount'){
	  $type = $_GET['type'];
	  $id = $_GET['id'];
	  
	  safe_query("UPDATE ".PREFIX."user_gameacc SET log='1' WHERE userID='$id' AND gameaccID='$type'");
	  	echo'The Gameaccount is now in the log. Just wait a few seconds to be redirected!
	    	          <meta http-equiv="refresh" content="0; URL=?site=profile&id='.$id.'&gameacc=changelog#seegameaccounts">';    
	    	          
	}elseif($_POST['edit']) {

	  $type = $_POST['type'];
	  $value = $_POST['value'];
	  $id = $_POST['id'];

	  $ergebnis=safe_query("SELECT * FROM ".PREFIX."user_gameacc WHERE userID='$id'");
		$ds=mysqli_fetch_array($ergebnis);
		
	  $inlog=safe_query("SELECT * FROM ".PREFIX."user_gameacc WHERE userID='$id' AND gameaccID='$type'");
		$dd=mysqli_fetch_array($inlog);
		
	  $ergebnis2 = safe_query("SELECT value FROM ".PREFIX."user_gameacc WHERE value = '$value' && type = '".$dd['type']."' && log='0'");
		$num_gameacc = mysqli_num_rows($ergebnis2);
		
		if($num_gameacc)  {
		    $error="Already in-use!";
			die('<b>ERROR: '.$error.'</b><br><br><input type="button" class="button" onClick="javascript:history.back()" value="Back">');
		}

		if(!(strlen(trim($value)))) {
		    $error="You have to enter a Value!";
			die('<b>ERROR: '.$error.'</b><br><br><input type="button" class="button" onClick="javascript:history.back()" value="Back">');
		}
        safe_query("INSERT INTO ".PREFIX."user_gameacc (userID, type, value, log) VALUES ('".$userID."', '".$dd['type']."', '".$dd['value']."', '1')");
		safe_query("UPDATE ".PREFIX."user_gameacc SET value='$value' WHERE userID='$id' AND gameaccID='$type'");

		echo'Your Gameaccount has been saved with your previous one in your log. Just wait a few seconds to be redirected!
	    	          <meta http-equiv="refresh" content="0; URL=?site=profile&id='.$id.'&gameacc=changelog#seegameaccounts">';
	    	          
	}elseif(isset($_GET['action']) AND $_GET['action']=="editpwd") {
	
		$bg1 = BG_1;
		$bg2 = BG_2;
	  	$bg3 = BG_3;
		$bg4 = BG_4;
		$border = BORDER;
	
		eval("\$myprofile_editpwd = \"".gettemplate("myprofile_editpwd")."\";");
		echo $myprofile_editpwd;

	}	
	
	elseif(isset($_POST['savepwd'])) {

		$oldpwd = $_POST['oldpwd'];
		$pwd1 = $_POST['pwd1'];
		$pwd2 = $_POST['pwd2'];
		$id = $userID;

		$ergebnis = safe_query("SELECT password FROM ".PREFIX."user WHERE userID='".$id."'");
		$ds = mysqli_fetch_array($ergebnis);

		if(!(mb_strlen(trim($oldpwd)))) {
			$error = $_language->module['forgot_old_pw'];
			die('<b>ERROR: '.$error.'</b><br /><br /><input type="button" onclick="javascript:history.back()" value="'.$_language->module['back'].'" />');
		}
		$oldmd5pwd = md5($oldpwd);
		if($oldmd5pwd != $ds['password']) {
			$error = $_language->module['old_pw_not_valid'];
			die('<b>ERROR: '.$error.'</b><br /><br /><input type="button" onclick="javascript:history.back()" value="'.$_language->module['back'].'" />');
		}
		if($pwd1 == $pwd2) {
			if(!(mb_strlen(trim($pwd1)))) {
				$error = $_language->module['forgot_new_pw'];
				die('<b>ERROR: '.$error.'</b><br /><br /><input type="button" onclick="javascript:history.back()" value="'.$_language->module['back'].'" />');
			}
		}
		else {
			$error = $_language->module['repeated_pw_not_valid'];
			die('<b>ERROR: '.$error.'</b><br /><br /><input type="button" onclick="javascript:history.back()" value="'.$_language->module['back'].'" />');
		}
		$newmd5pwd = md5(stripslashes($pwd1));
		safe_query("UPDATE ".PREFIX."user SET password='".$newmd5pwd."' WHERE userID='".$userID."'");

		//logout
		unset($_SESSION['ws_auth']);
		unset($_SESSION['ws_lastlogin']);
		session_destroy();

    redirect('index.php?site=login', $_language->module['pw_changed'],3);

	}	
	
	elseif(isset($_GET['action']) AND $_GET['action']=="editmail") {

if($_GET['type']=='redir') echo '<div class="errorbox"><img src="images/cup/icons/contact_info.png"> You have been automatically redirected to set your email, this is a mandatory requirement. If you are still redirected here, follow these steps: <br><br><li>Activate the email, message will be sent. (check spam!) <li>Make sure the password is correct <li> Contact an admin </div>';
	
		$bg1 = BG_1;
		$bg2 = BG_2;
    $bg3 = BG_3;
		$bg4 = BG_4;
		$border = BORDER;

		eval("\$myprofile_editmail = \"".gettemplate("myprofile_editmail")."\";");
		echo $myprofile_editmail;

	}	
	
	elseif(isset($_POST['savemail'])){

		$activationkey = createkey(20);
		$activationlink = 'http://'.$hp_url.'/index.php?site=register&mailkey='.$activationkey;
		$pwd = $_POST['oldpwd'];
		$mail1 = $_POST['mail1'];
		$mail2 = $_POST['mail2'];

		$ergebnis = safe_query("SELECT password, username FROM ".PREFIX."user WHERE userID='".$userID."'");
		$ds = mysqli_fetch_array($ergebnis);
		$username = $ds['username'];
		if(!(mb_strlen(trim($pwd)))) {
			$error = $_language->module['forgot_old_pw'];
			die('<b>ERROR: '.$error.'</b><br /><br /><input type="button" onclick="javascript:history.back()" value="'.$_language->module['back'].'" />');
		}
		$md5pwd = md5(stripslashes($pwd));
		if($md5pwd != $ds['password']) {
			die('<b>ERROR: '.$error.'</b><br /><br /><input type="button" onclick="javascript:history.back()" value="'.$_language->module['back'].'" />');
		}
		if($mail1 == $mail2) {
			if(!(mb_strlen(trim($mail1)))) {
				$error = $_language->module['mail_not_valid'];
				die('<b>ERROR: '.$error.'</b><br /><br /><input type="button" onclick="javascript:history.back()" value="'.$_language->module['back'].'" />');
			}
		}
		else {
			$error = $_language->module['repeated_pw_not_valid'];
			die('<b>ERROR: '.$error.'</b><br /><br /><input type="button" onclick="javascript:history.back()" value="'.$_language->module['back'].'" />');
		}

		// check e-mail
		$sem = '^[a-z0-9_\.-]+@[a-z0-9_-]+\.[a-z0-9_\.-]+$';
		if(!(eregi($sem, $mail1))){ 
			$error=$_language->module['invalid_mail'];
			die('<b>ERROR: '.$error.'</b><br /><br /><input type="button" onclick="javascript:history.back()" value="'.$_language->module['back'].'" />');
		}
		
		safe_query("UPDATE ".PREFIX."user SET email_change = '".$mail1."', email_activate = '".$activationkey."' WHERE userID='".$userID."'");

		$ToEmail = $mail1;
		$ToName = $username;
		$header =  str_replace(Array('%homepage_url%'), Array($hp_url), $_language->module['mail_subject']);
		$Message = str_replace(Array('%username%', '%activationlink%', '%pagetitle%', '%homepage_url%'), Array($username, $activationlink, $hp_title, $hp_url), $_language->module['mail_text']);

		if(mail($ToEmail,$header, $Message, "From:".$admin_email."\nContent-type: text/plain; charset=utf-8\n")) echo $_language->module['mail_changed'];
		else echo $_language->module['mail_failed'];

	}	
	
	else {
		$ergebnis = safe_query("SELECT * FROM ".PREFIX."user WHERE userID='".$userID."'");
		$anz = mysqli_num_rows($ergebnis);
		if($anz) {
			$ds = mysqli_fetch_array($ergebnis);
			$flag = '[flag]'.$ds['country'].'[/flag]';
			$country = flags($flag);
			$country = str_replace("<img","<img id='county'",$country);
			$xlist = '<option value="bg">Default</option><option value="os">Fantasy</option><option value="co">Combat</option><option value="sf">Sci-Fi</option>';
		    $xlist = str_replace('value="'.$ds[xfirestyle].'"','value="'.$ds[xfirestyle].'" selected',$xlist);
		    $xflist = '<option value="0">Classic</option><option value="1">Compact</option><option value="2">Short and Wide</option><option value="3">Tiny</option>';
		    $xflist = str_replace('value="'.$ds[xfiregroesse].'"','value="'.$ds[xfiregroesse].'" selected',$xflist);
			$sex = '<option value="m">'.$_language->module['male'].'</option><option value="f">'.$_language->module['female'].'</option><option value="u">'.$_language->module['unknown'].'</option>';
			$sex = str_replace('value="'.$ds['sex'].'"','value="'.$ds['sex'].'" selected="selected"',$sex);
			if($ds['newsletter'] == "1") $newsletter = '<option value="1" selected="selected">'.$_language->module['yes'].'</option><option value="0">'.$_language->module['no'].'</option>';
			else $newsletter = '<option value="1">'.$_language->module['yes'].'</option><option value="0" selected="selected">'.$_language->module['no'].'</option>';

	         $jgrowl ='<option value="1">All notifications</option>
			           <option value="2">Message & ticket notification only</option>
					   <option value="3">Match & challenge notification only</option>
					   <option value="4">Message / ticket / match / challenge notifcation</option>
					   <option value="5">Cups in sign-up phase notifcation only</option>
					   <option value="6">Cups joined notifcation only</option>
					   <option value="7">Cups joined and in sign-up phase notifcation only</option>
					   <option value="0">No notifactions</option>';
	         $jgrowl=str_replace(' selected', '', $jgrowl);
	         $jgrowl=str_replace('value="'.$ds['jgrowl'].'"', 'value="'.$ds['jgrowl'].'" selected', $jgrowl);
			
			if($ds['mailonpm'] == "1") $pm_mail = '<option value="1" selected="selected">'.$_language->module['yes'].'</option><option value="0">'.$_language->module['no'].'</option>';
			else $pm_mail = '<option value="1">'.$_language->module['yes'].'</option><option value="0" selected="selected">'.$_language->module['no'].'</option>';
			if($ds['email_hide']) $email_hide = ' checked="checked"';
			else $email_hide = '';
			$b_day = mb_substr($ds['birthday'],8,2);
			$b_month = mb_substr($ds['birthday'],5,2);
			$b_year = mb_substr($ds['birthday'],0,4);
			$countries = str_replace(" selected=\"selected\"", "", $countries);
			$countries = str_replace('value="'.$ds['country'].'"', 'value="'.$ds['country'].'" selected="selected"', $countries);
			if($ds['avatar']) $viewavatar = '&#8226; <a href="javascript:MM_openBrWindow(\'images/avatars/'.$ds['avatar'].'\',\'avatar\',\'width=120,height=120\')">'.$_language->module['avatar'].'</a>';
			else $viewavatar = $_language->module['avatar'];
			if($ds['userpic']) $viewpic = '&#8226; <a href="javascript:MM_openBrWindow(\'images/userpics/'.$ds['userpic'].'\',\'userpic\',\'width=250,height=230\')">'.$_language->module['userpic'].'</a>';
			else $viewpic = $_language->module['userpic'];

			$usertext = getinput($ds['usertext']);
			$clanhistory = clearfromtags($ds['clanhistory']);
			$clanname = clearfromtags($ds['clanname']);
			$clantag = clearfromtags($ds['clantag']);
			$clanirc = clearfromtags($ds['clanirc']);
            $clanesl = ($ds['clanesl']=='n/a' ? '' : clearfromtags($ds['clanesl']));
			$firstname = clearfromtags($ds['firstname']);
			$lastname = clearfromtags($ds['lastname']);
			$town = clearfromtags($ds['town']);
			$cpu = clearfromtags($ds['cpu']);
			$storage = ($ds['storage']=='n/a' ? '' : clearfromtags($ds['storage']));
			$headset = ($ds['headset']=='n/a' ? '' : clearfromtags($ds['headset']));
			$mainboard = clearfromtags($ds['mainboard']);
			$ram = clearfromtags($ds['ram']);
			$monitor = clearfromtags($ds['monitor']);
			$graphiccard = clearfromtags($ds['graphiccard']);
			$soundcard = clearfromtags($ds['soundcard']);
			$connection = clearfromtags($ds['verbindung']);
			$keyboard = clearfromtags($ds['keyboard']);
			$mouse = clearfromtags($ds['mouse']);
			$mousepad = clearfromtags($ds['mousepad']);
			$skype=($ds[skype]=='na' ? '' : clearfromtags($ds[skype]));
			$msn=($ds[msn]=='n/a' ? '' : clearfromtags($ds[msn]));
			$aim=($ds[aim]=='n/a' ? '' : clearfromtags($ds[aim]));
			$yahoo=($ds[yahoo]=='n/a' ? '' : clearfromtags($ds[yahoo]));
			
			$fgame=($ds[fgame]=='n/a' ? '' : clearfromtags($ds[fgame]));
    		$fclan=($ds[fclan]=='n/a' ? '' : clearfromtags($ds[fclan]));
	    	$fmap=($ds[fmap]=='n/a' ? '' : clearfromtags($ds[fmap]));
    		$fweapon=($ds[fweapon]=='n/a' ? '' : clearfromtags($ds[fweapon]));
	    	$ffood=($ds[ffood]=='n/a' ? '' : clearfromtags($ds[ffood]));
     		$fdrink=($ds[fdrink]=='n/a' ? '' : clearfromtags($ds[fdrink]));
	    	$fmovie=($ds[fmovie]=='n/a' ? '' : clearfromtags($ds[fmovie]));
	    	$fmusic=($ds[fmusic]=='n/a' ? '' : clearfromtags($ds[fmusic]));
	    	$fsong=($ds[fsong]=='n/a' ? '' : clearfromtags($ds[fsong]));
    		$fbook=($ds[fbook]=='n/a' ? '' : clearfromtags($ds[fbook]));
	    	$factor=($ds[factor]=='n/a' ? '' : clearfromtags($ds[factor]));
	    	$fcar=($ds[fcar]=='n/a' ? '' : clearfromtags($ds[fcar]));
	    	$fsport=($ds[fsport]=='n/a' ? '' : clearfromtags($ds[fsport]));
			
			$clanhp = getinput($ds['clanhp']);
			$about = getinput($ds['about']);
			$nickname = $ds['nickname'];
			$username = getinput($ds['username']);
			$email = getinput($ds['email']);
			$icq = getinput($ds['icq']);
			$xfirec = getinput($ds['xfirec']);
			$steam = getinput($ds['steam']);
			$homepage = getinput($ds['homepage']);
			$langdirs = '';
			$filepath = "languages/";
			
			// Select all possible languages
			$mysqli_langs = array();
			$query = safe_query("SELECT lang, language FROM ".PREFIX."news_languages");
			while($dx = mysqli_fetch_assoc($query)){
				$mysqli_langs[$dx['lang']] = $dx['language'];
			}
			if($dh = opendir($filepath)) {
				while($file = mb_substr(readdir($dh), 0, 2)) {
					if($file != "." and $file!=".." and is_dir($filepath.$file)) {
						if(isset($mysqli_langs[$file])){
							$name = $mysqli_langs[$file];
							$name = ucfirst($name);
							$langdirs .= '<option value="'.$file.'">'.$name.'</option>';
						}
						else {
							$langdirs .= '<option value="'.$file.'">'.$file.'</option>';
						}
					}
				}
				closedir($dh);
			}
			$langdirs = str_replace('"'.$ds['language'].'"', '"'.$ds['language'].'" selected="selected"', $langdirs);

			$bg1 = BG_1;
			$bg2 = BG_2;
			$bg3 = BG_3;
			$bg4 = BG_4;

                        /* STEAM V5.2 (5206) API INTEGRATION */

                        $steam_comm_id = ($STEAM_VALIDE==true ? $GET_STEAM_ID : $ds[sc_id]);

                        /* STEAM V5.2 (5206) API INTEGRATION */

			eval("\$myprofile = \"".gettemplate("myprofile")."\";");
			echo $myprofile;

		}
		else echo $_language->module['not_logged_in'];
	}
}
?>