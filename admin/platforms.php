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
#   Copyright 2005-2010 by webspell.org                                  #
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

$_language->read_module('games');

if(!iscupadmin($userID) OR mb_substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php") die($_language->module['access_denied']);

if(isset($_GET['action'])) $action = $_GET['action'];
else $action = '';

if(isset($_GET['type'])) $type = $_GET['type'];
else $type = '';

if(isset($_GET['platID'])) $id = $_GET['platID'];
else $id = '';

if($action=="edit") {
 
 
  $ds=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_platforms WHERE ID='$id'"));
  
    if($ds['status']) 
       $status = '<option value="1" selected>Enable Ladders</option>
                  <option value="0">Disable Ladders</option>';
    else 
       $status = '<option value="1">Enable Ladders</option>
                  <option value="0" selected>Disable Ladders</option>';
       
        $platforms = '<option value="'.$ds['platform'].'" selected>'.$ds['platform'].'</option>';

  $query = safe_query("SELECT platform FROM ".PREFIX."cup_platforms WHERE platform!='".$ds['platform']."' GROUP BY platform");
    $num_platforms = mysql_num_rows($query);
      while($pt = mysql_fetch_array($query)) {
         $platforms.='<option value="'.$pt['platform'].'">'.$pt['platform'].'</option>';
     }
     
  if($type=="custom") {
     $custom_platform = '<input type="text" name="platform" maxlength="255" />';
     $platform_type = '(<a href="admincenter.php?site=platforms&action=edit&platID='.$id.'">from dropdown</a>)';
  }else{
     $custom_platform = '<select name="platform">'.$platforms.'</select>';
     $platform_type = '(<a href="admincenter.php?site=platforms&action=edit&platID='.$id.'&type=custom">add custom</a>)';
  }
	
  echo'<h1>&curren; Edit Platform</h1>';
	
	echo'<form method="post" action="admincenter.php?site=platforms">
   <input type="hidden" name="ID" value="'.$ds['ID'].'" />
  <table width="100%" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td width="15%"><b>Platform:</b></td>
      <td width="85%">'.$custom_platform.' '.$platform_type.'</td>
    </tr>
    <tr>
      <td><b>Name:</b></td>
      <td><input type="text" name="name" maxlength="255" value="'.$ds['name'].'"/></td>
    </tr>
    <tr>
      <td><b>Logo URL:</b></td>
      <td><input type="text" name="logo" maxlength="255" value="'.$ds['logo'].'"/></td>
    </tr>
    <tr>
      <td><b>Abbreviation:</b></td>
      <td><input type="text" name="abbrev" size="10" maxlength="10" value="'.$ds['abbrev'].'"/></td>
    </tr>
    <tr>
      <td><b>Status:</b></td>
      <td><select name="status">'.$status.'</select></td>
    </tr>
    <tr>
      <td><b>Description:</b><br><br>(BBCode activated)</td>
      <td><textarea name="descrip" cols="50" rows="8" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'">'.$ds['descrip'].'</textarea></td>
    </tr>
    <tr>
      <td></td>
      <td><input type="submit" name="saveedit" value="Edit Platform" /></td>
    </tr>
  </table>
  </form>';
}

elseif($action=="add") {

        $platforms = '-- Select Platform --';

  $query = safe_query("SELECT platform FROM ".PREFIX."cup_platforms GROUP BY platform");
    $num_platforms = mysql_num_rows($query);
      while($ds = mysql_fetch_array($query)) {
         $platforms.='<option value="'.$ds['platform'].'">'.$ds['platform'].'</option>';
     }
     
 if($num_platforms) {
     
  if($type=="custom") {
     $custom_platform = '<input type="text" name="platform" maxlength="255" />';
     $platform_type = '(<a href="admincenter.php?site=platforms&action=add">from dropdown</a>)';
  }else{
     $custom_platform = '<select name="platform">'.$platforms.'</select>';
     $platform_type = '(<a href="admincenter.php?site=platforms&action=add&type=custom">add custom</a>)';
  }
 
 }else
     $custom_platform = '<input type="text" name="platform" maxlength="255" />';
	
	
  echo'<h1>&curren; Create Platform</h1>';
	
	echo'<form method="post" action="admincenter.php?site=platforms">
  <table width="100%" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td width="15%"><b>Platform:</b></td>
      <td width="85%">'.$custom_platform.' '.$platform_type.'</td>
    </tr>
    <tr>
      <td><b>Name:</b></td>
      <td><input type="text" name="name" maxlength="255" /></td>
    </tr>
    <tr>
      <td><b>Logo URL:</b></td>
      <td><input type="text" name="logo" maxlength="255" /></td>
    </tr>
    <tr>
      <td><b>Abbreviation:</b></td>
      <td><input type="text" name="abbrev" size="10" maxlength="10" /></td>
    </tr>
    <tr>
      <td><b>Status:</b></td>
      <td><select name="status"><option value="1">Enable Ladders</option><option value="0">Disable Ladders</option></select></td>
    </tr>
    <tr>
      <td><b>Description:</b><br><br>(BBCode activated)</td>
      <td><textarea name="descrip" cols="50" rows="8" class="form_off" onFocus="this.className=\'form_on\'" onBlur="this.className=\'form_off\'"></textarea></td>
    </tr>
    <tr>
      <td></td>
      <td><input type="submit" name="save" value="Create Platform" /></td>
    </tr>
  </table>
  </form>';
}

elseif(isset($_POST['save'])) {

    $platform = $_POST['platform'];
    $name = $_POST['name'];
    $abbrev = $_POST['abbrev'];
    $logo = $_POST['logo'];
    $descrip = $_POST['descrip'];
    $status = $_POST['status'];

    safe_query("INSERT INTO ".PREFIX."cup_platforms (`platform`, `name`, `abbrev`, `descrip`, `logo`, `status`) VALUES ('$platform', '$name', '$abbrev', '$descrip', '$logo', '$status')");
	redirect("admincenter.php?site=platforms","",0);
}

elseif(isset($_POST["saveedit"])) {

    $platform = $_POST['platform'];
    $name = $_POST['name'];
    $abbrev = $_POST['abbrev'];
    $logo = $_POST['logo'];
    $descrip = $_POST['descrip'];
    $status = $_POST['status'];

    safe_query("UPDATE ".PREFIX."cup_platforms SET platform='$platform', `name`='$name', abbrev='$abbrev', logo='$logo', descrip='$descrip', status='$status' WHERE ID='".$_POST['ID']."'");
	redirect("admincenter.php?site=platforms","",0);
}

elseif($action=="delete") {

$ladder_id = safe_query("SELECT ID FROM ".PREFIX."cup_ladders WHERE platID='".$_GET['platID']."'");
  if(!mysql_num_rows($ladder_id)) {
    safe_query("DELETE FROM ".PREFIX."cup_platforms WHERE ID='".$_GET['platID']."'");
    redirect("admincenter.php?site=platforms","",0);
  }  
  else{

    while($ds = mysql_fetch_array($ladder_id)) { 

       safe_query("DELETE FROM ".PREFIX."cup_platforms WHERE ID='".$_GET['platID']."'");
       safe_query("DELETE FROM ".PREFIX."cup_ladders WHERE platID='".$_GET['platID']."'");
       safe_query("DELETE FROM ".PREFIX."cup_challenges WHERE ladID='".$ds['ID']."'");
       safe_query("DELETE FROM ".PREFIX."cup_clans WHERE ladID='".$ds['ID']."'"); 
       safe_query("DELETE FROM ".PREFIX."cup_maps WHERE ladID='".$ds['ID']."'"); 
       safe_query("DELETE FROM ".PREFIX."cup_matches WHERE ladID='".$ds['ID']."'"); 
       safe_query("DELETE FROM ".PREFIX."cup_rules WHERE ladID='".$ds['ID']."'"); 
       safe_query("DELETE FROM ".PREFIX."cup_admins WHERE ladID='".$ds['ID']."'"); 
	  redirect("admincenter.php?site=platforms","",0);
	}
  }
}

else {
	
  echo'<h1>&curren; Manage Platforms</h1>';
  
  	echo'<input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=platforms&action=add\');return document.MM_returnValue" value="Add Platform">
  	     <input type="button" class="button" onClick="MM_goToURL(\'parent\',\'../?site=platforms\');return document.MM_returnValue" value="Front-End Platforms"><br><br>';
  
    $platforms = safe_query("SELECT platform FROM ".PREFIX."cup_platforms GROUP BY platform");
        while($pt=mysql_fetch_array($platforms)) {
        
        echo '
         <table width="50%" cellpadding="2" cellspacing="1" bgcolor="'.$border.'">
          <tr>
            <td colspan="5" height="20" align="center" class="title" bgcolor="'.$bghead.'"><b>'.$pt['platform'].'</b></td>
          </tr>';
          
  $getplatforms = safe_query("SELECT * FROM ".PREFIX."cup_platforms WHERE platform='".$pt['platform']."'"); 
    while($pl=mysql_fetch_array($getplatforms)) { $platID = $pl['ID'];
  
      $logo = getplatlogo($platID,$admin=1);
          
        echo '
           <tr>
            <td width="15%" align="center" rowspan="4" class="title" bgcolor="'.$bghead.'">'.$logo.'</td>
            <td width="65%" class="title" bgcolor="'.$bghead.'">'.$pl['name'].' ('.$pl['abbrev'].')</td>
          </tr>
           <tr>
            <td class="title" bgcolor="'.$bghead.'"><a href="admincenter.php?site=platforms&action=edit&platID='.$pl['ID'].'"><img src="../images/cup/icons/server_edit.gif"> Edit Platform</a></td>
          </tr>
           <tr>
            <td class="title" bgcolor="'.$bghead.'"><a href="admincenter.php?site=platforms&action=delete&platID='.$pl['ID'].'" onclick="return confirm(\'WARNING: This will delete ALL ladders/cups, associated matches/challenges/standings and stats/ladder maps, matches and rules etc. Are you sure?.\');"><img src="../images/cup/error.png" width="16" height="16"> Delete Platform</a></td>
          </tr>
           <tr>
            <td class="title" bgcolor="'.$bghead.'"><a href="../?site=ladders&platID='.$pl['ID'].'"><img src="../images/cup/icons/go.png"> View Ladders</a> <a href="../?site=cups&platID='.$pl['ID'].'"><img src="../images/cup/icons/go.png"> View Tournaments</a></td>
          </tr>
           <tr>
            <td></td>
          </tr>';
        
        }echo '</table><br><br>';
      }
    }
?>