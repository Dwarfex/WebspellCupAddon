<style>
fieldset, legend {
margin:4px;
padding:4px;
}
</style>

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

$_language->read_module('cups');

include("../config.php");
$show_updated = $a_show_updated;

if(!iscupadmin($userID) OR mb_substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php") die($_language->module['access_denied']);	

	if(function_exists('file_get_contents')){
	
		function file_get_contents_utf8($fn) {
			$content = file_get_contents($fn);
			return mb_convert_encoding($content, 'UTF-8', mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
		} 

		include "cupversion.php";
		
		if($version==5.2 && $version_num==5.2) {
		   $version_num = 5201;
		}

		$get_updates = file_get_contents_utf8($updateserver.'/getupdates.php?action=updatecheck&version='.$version.'&versionnum='.$version_num);
		$releases = explode("###",$get_updates);

		$get_version = file_get_contents_utf8($updateserver.'/getupdates.php?action=checkversion&version='.$version.'&versionnum='.$version_num);
		$chk_version = explode("###",$get_version);
		
		$new = '';
		if($chk_version[1] > $version_num)
			$new = ' <span style="color: red;">*new*</span>';
		echo '
		<fieldset style="border: 1px solid '.$border.'"><legend style="font: 15px bold;"><strong>Updates</strong>'.$new.'</legend>
			<table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="#DDDDDD">
			                <tr>
					        <td class="title" colspan="4"><b>You are running V'.$version.' (Build: '.$version_num.')</b></td>
					</td>
                                        <tr>
				                <td class="td1" colspan="4">'.$chk_version[0].'</td>
					</td>
			  		<tr>
				 		<td class="title" align="center" width="5%"><b>Build</b></td>
				   		<td class="title" width="30%" align="center"><b>Title</b></td>
					 	<td class="title" width="50%"><b>Information</b></td>					
					 	<td class="title" align="center" width="15%"><b>Update(d)</b></td>
				   	</tr>';
		if($releases[0]!='!'){
			$i = 1;
			foreach($releases as $release){
				if($i%2) { $td='td1'; }
				else { $td='td2'; }
				$release = explode("||",$release);


				if($release[0] > $version_num && $release[0]==$chk_version[1]) {			
				      $gt_update = '<input type="button" class="button" onClick="window.open(\''.$updateserver.'/getupdates.php?action=getupdate&update='.$release[0].'\');return document.MM_returnValue" value="Download" />';
				}
				elseif($chk_version[1] < $chk_version[2] && $chk_version[1] < $release[0]) {
				      $gt_update = '<img src="../images/cup/icons/nok_32.png" width="20" height="20">';
				}
				elseif($release[0] > $version_num && $version_num!=$chk_version[1]) {			
				      $gt_update = '<img src="../images/cup/icons/arrow_up_blue.png" title="Later Update Above ^">';
				}	
				elseif($show_updated==1) {
				      $gt_update = '<img src="../images/cup/icons/ok_32.png" width="20" height="20">';
				}
				else{
				      $gt_update = false;
				}
				
				if($gt_update != false) {
				
		                  echo '<tr>
				   		<td class="'.$td.'" align="center">'.$release[0].'</td>
				   		<td class="'.$td.'" align="center">'.$release[1].'</td>
				   		<td class="'.$td.'">'.$release[2].'</td>
						<td class="'.$td.'" align="center">'.$gt_update.'</td>
					</tr>';
				}	
			$i++;
			}
		}else
			echo '<tr bgcolor="#FFFFFF"><td colspan="4">'.$_language->module['no_new_updates'].'</td></tr>';
		echo '</table></fieldset>';
	}
	else{
	        echo '<strong>The function "file_get_contents" does not exist, please contact the server host to allow this function to enable updates.</strong>';
	}
	
	echo '<fieldset><legend><strong>Legend</strong></legend>
	          <img src="../images/cup/icons/arrow_up_blue.png" title="Later Update Above ^"> Later update available above <br />
			  <img src="../images/cup/icons/nok_32.png" width="20" height="20"> Update unavailable or in the works for later release <br />
			  <img src="../images/cup/icons/ok_32.png" width="20" height="20"> Update uploaded on your website
		  </fieldset>';
	
?>	
