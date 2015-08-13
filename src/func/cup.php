<?php
function cupIsInstalled(){
    try{
        $result = @mysql_query("SELECT timezone FROM ".PREFIX."cup_settings");
    }catch (Exception $e){
        $result = false;
    }

    if(!$result){
        return false;
//        echo "Uninstalled";
    }else {
        return true;

//        echo "installed";
//	return false;
    }
}
function safe_sql_br($value) { 

     $value = nl2br($value); 
     $value = trim(strip_tags($value,'<br>'));     
         $value = str_replace('\r\n', "\n", $value);

    if (get_magic_quotes_gpc()) { 
        $value = stripslashes($value); 
    } 

    if (!is_numeric($value)) { 
        $value = mysql_real_escape_string($value); 
    }
    return $value;
} 

function gettimezone($val = null) {
    $ds=mysql_fetch_array(safe_query("SELECT timezone FROM ".PREFIX."cup_settings"));
    return ($val == null ? date_default_timezone_set($ds['timezone']) : $ds['timezone']);
}

function getlocaltimezone($val1,$val2,$userID) {

substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php" ? include("config.php") : include("../config.php");

	if($userID) {
	
       $ds1=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."user WHERE userID='$userID'"));
      	 
	   if(empty($ds1['timezone'])) {
	   
	         if($_GET['action']!='timezone' && $enforce_timezone==1) {
	            redirect('?site=myprofile&action=timezone&userID='.$userID.'&type=redir&url=?'.urlencode(pageURL()), '', 2);
		     }
			 return '(timezone unset)';
	   }
	   elseif($ds1['timezone']==1) { 
	         return '(timezone unset)';
	   }
	   elseif(empty($ds1['email'])) {
	   
	         if($_GET['action']!='editmail' && $enforce_email==1) {
	            redirect('?site=myprofile&action=editmail&type=redir', '', 2);
		     }
			 return '(timezone unavailable)';
       }
       else{	   
	         return ($val1==1 ? date_default_timezone_get($ds1['timezone']) : date_default_timezone_set($ds1['timezone']));
	   }
    }
    else{
             return '(login required)';
    }	
}

function getcuptimezone($value = null,$cupID = null) {

    $get_cupID = "";
	$get_ID = "";
	if(isset($_GET['cupID'])) $get_cupID = mysql_escape_string($_GET['cupID']);
	if(isset($_GET['ID'])) $get_ID = mysql_escape_string($_GET['ID']);

    $ds= mysql_fetch_array(safe_query("SELECT timezone FROM ".PREFIX."cups WHERE (ID='$get_cupID' || ID='$get_ID') AND timezone!=''"));
	$ds1=mysql_fetch_array(safe_query("SELECT timezone FROM ".PREFIX."cups WHERE ID='$cupID' AND timezone!=''"));
    $ds2=mysql_fetch_array(safe_query("SELECT timezone FROM ".PREFIX."cup_settings"));
    
    if($value && is_array($ds)) {
         return $ds['timezone'];
    }
    elseif($value && !is_array($ds)) {
         return $ds2['timezone'];
    }
    elseif(empty($value) && is_array($ds)) {
           return date_default_timezone_set($ds['timezone']);
    }
    elseif(empty($value) && is_array($ds1)) {
           return date_default_timezone_set($ds1['timezone']);
    }
    elseif(empty($value) && !is_array($ds)) {
           return date_default_timezone_set($ds2['timezone']); 
    }
    else{
           return gettimezone();
    }
}

function getladtimezone($value = null,$cupID = null) {

    $get_ladderID = "";
	$get_laddID = "";
	$get_ID = "";
	if(isset($_GET['ladderID'])) $get_ladderID = mysql_escape_string($_GET['ladderID']);
	if(isset($_GET['laddID'])) $get_laddID = mysql_escape_string($_GET['laddID']);
	if(isset($_GET['ID'])) $get_ID = mysql_escape_string($_GET['ID']);

    $ds= mysql_fetch_array(safe_query("SELECT timezone FROM ".PREFIX."cup_ladders WHERE (ID='$get_laddID' || ID='$get_ladderID' || ID='$get_ID') AND timezone!=''"));
    $ds1=mysql_fetch_array(safe_query("SELECT timezone FROM ".PREFIX."cup_ladders WHERE ID='$cupID' AND timezone!=''"));
	$ds2=mysql_fetch_array(safe_query("SELECT timezone FROM ".PREFIX."cup_settings"));
    
    if($value && is_array($ds)) {
         return $ds['timezone'];
    }
    elseif($value && !is_array($ds)) {
         return $ds2['timezone'];
    }
    elseif(empty($value) && is_array($ds)) {
           return date_default_timezone_set($ds['timezone']);
    }
    elseif(empty($value) && is_array($ds1)) {
           return date_default_timezone_set($ds1['timezone']);
    }
    elseif(empty($value) && !is_array($ds)) {
           return date_default_timezone_set($ds2['timezone']); 
    }
    else{
           return gettimezone();
    }
}


function isleader($userID,$clanID) {
	$anz=mysql_num_rows(safe_query("SELECT clanID FROM ".PREFIX."cup_clan_members WHERE userID = '".$userID."' AND clanID = '".$clanID."' AND function = 'Leader'"));
	return $anz;
}

function getusername($userID) {
	$ds=mysql_fetch_array(safe_query("SELECT username FROM ".PREFIX."user WHERE userID='".$userID."'"));
	return $ds['username'];
}

function getuserid2($username) {
	$ds=mysql_fetch_array(safe_query("SELECT userID FROM ".PREFIX."user WHERE username='".$username."'"));
	return $ds['userID'];
}

function ismember($userID,$clanID) {
	$anz=mysql_num_rows(safe_query("SELECT clanID  FROM ".PREFIX."cup_clan_members WHERE userID = '".$userID."' AND clanID = '".$clanID."' AND function = 'Member'"));
	return $anz;
}

function memin($userID,$clanID) {
	$anz=mysql_num_rows(safe_query("SELECT clanID FROM ".PREFIX."cup_clan_members WHERE userID = '".$userID."' AND clanID = '".$clanID."'"));
	return $anz;
}

function isfounder($userID,$clanID) {
	$anz=mysql_num_rows(safe_query("SELECT ID FROM ".PREFIX."cup_all_clans WHERE leader = '$userID' AND ID = '$clanID'"));
	return $anz;
}

function getclanname($clanID) {
	$ds = mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_all_clans WHERE ID='$clanID'"));

    if(empty($ds['ID'])){
        return '(wildcard)';
    }
    else{
	    return htmlspecialchars(($clanID == 2147483647 ? 'Wildcard' : $ds['short']));
    }
    
	    return htmlspecialchars(($clanID == 2147483647 ? 'Wildcard' : $ds['short']));
}

function clanlogo($clanID) {

    $ds=mysql_fetch_array(safe_query("SELECT clanlogo FROM ".PREFIX."cup_all_clans WHERE ID='$clanID'"));
	
    if($ds['clanlogo'] && $ds['clanlogo']!='http://' && $ds['clanlogo']!='http://google.com') {
	   return '<img src="'.$ds['clanlogo'].'" height="100" width="100">';
    }
    else{
	   return '<img src="images/avatars/noavatar.gif" height="100" width="100">';  
    }
}

function getclanname2($clanID) {
	$ds = mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_all_clans WHERE ID='$clanID'"));

    if(empty($ds['ID'])){
        return '(wildcard)';
    }
    else{
	    return htmlspecialchars(($clanID == 2147483647 ? 'Wildcard' : $ds['name']));
    }
    
	    return htmlspecialchars(($clanID == 2147483647 ? 'Wildcard' : $ds['name']));
}

function livecontact($uID,$type=0) {
     $id=$uID;
     include ("livecontact.php");
	 
	 if($type=0)
	    return '<a href="?site=profile&id='.$uID.'">'.$email.'</a> '.$pm .$buddy .$icq .$skype .$xfirec .$steam .$msn .$aim .$yahoo.' <a href="index.php?site=matches&action=viewmatches&memberID='.$uID.'" target="_top"><img border="0" src="images/cup/icons/add_result.gif" width="18" height="18"></a>';
	 else
	    return '<a href="?site=profile&id='.$uID.'">'.getnickname($uID).'</a><br><a href="?site=profile&id='.$uID.'">'.$email.'</a> '.$pm .$buddy .$icq .$skype .$xfirec .$steam .$msn .$aim .$yahoo.' <a href="index.php?site=matches&action=viewmatches&memberID='.$uID.'" target="_top"><img border="0" src="images/cup/icons/add_result.gif" width="18" height="18"></a>';
}

function irchost() {

  $ds=mysql_fetch_array(safe_query("SELECT cupchathost FROM ".PREFIX."cup_settings"));
  return $ds['cupchathost'];
  
}

function gamepic($cupID,$league) {

  $table = ($league=='cup' ? 'cups' : 'cup_ladders');

  $ds=mysql_fetch_array(safe_query("SELECT game FROM ".PREFIX."$table WHERE ID='$cupID'"));
  RETURN '<img src="images/games/'.$ds['game'].'.gif">';

}

function getalphanickname($userID) {

	$ds=mysql_fetch_array(safe_query("SELECT nickname FROM ".PREFIX."user WHERE userID='".$userID."'"));

        $name = $ds['nickname'];
        if (preg_match('/[^A-Za-z0-9]/', $name)) {
        $func = preg_replace ( '/[^A-Za-z0-9]/', '', $name);
        $name = $func;
	    return $name;

        }else{ return $ds['nickname']; }
}

function getround($cupID,$matchno) {

  substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php" ? include("config.php") : include("../config.php"); 
  $matchinfo = array('matchno' => 0,'round' => '','map' => '');
 
  $cup=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cups WHERE ID='$cupID'"));
  $map=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_baum WHERE cupID='$cupID'"));
  
  switch($cup['maxclan']) {
  
     case 64:

			if($matchno <= 32){
				$matchinfo['map'] = $map['map1'];
				$matchinfo['round'] = $round1;
			}elseif($matchno >= 33 && $matchno <= 48){
				$matchinfo['map'] = $map['map2'];
				$matchinfo['round'] = $round2;
			}elseif($matchno >= 49 && $matchno <= 56){
				$matchinfo['map'] = $map['map3'];
				$matchinfo['round'] = $round3;
			}elseif($matchno == 57 && $matchno == 60){
				$matchinfo['map'] = $map['map4'];
				$matchinfo['round'] = $round4;
			}elseif($matchno == 61 && $matchno == 62){
				$matchinfo['map'] = $map['map4'];
				$matchinfo['round'] = $round_qf_ub;
			}elseif($matchno == 63){
				$matchinfo['map'] = $map['map5'];
				$matchinfo['round'] = $round_sf_ub;
			}elseif($matchno == 64){
				$matchinfo['map'] = $map['map6'];
				$matchinfo['round'] = $round_gf_ub;
			}elseif($matchno >= 65 && $matchno <= 80){
				$matchinfo['map'] = $map['map7'];
				$matchinfo['round'] = $round_gf_ub;
			}elseif($matchno >= 81 && $matchno <= 96){
				$matchinfo['map'] = $map['map8'];
				$matchinfo['round'] = $round1_lb;
			}elseif($matchno >= 97 && $matchno <= 104){
				$matchinfo['map'] = $map['map9'];
				$matchinfo['round'] = $round2_lb;
			}elseif($matchno >= 105 && $matchno <= 112){
				$matchinfo['map'] = $map['map10'];
				$matchinfo['round'] = $round3_lb;
			}elseif($matchno >= 113 && $matchno <= 116){
				$matchinfo['map'] = $map['map11'];
				$matchinfo['round'] = $round4_lb;
			}elseif($matchno >= 117 && $matchno <= 120){
				$matchinfo['map'] = $map['map11'];
				$matchinfo['round'] = $round5_lb;
			}elseif($matchno == 121 || $matchno == 122){
				$matchinfo['map'] = $map['map12'];
				$matchinfo['round'] = $round6_lb;
			}elseif($matchno == 123 || $matchno == 124){
				$matchinfo['map'] = $map['map12'];
				$matchinfo['round'] = $round7_lb;
			}elseif($matchno == 125){
				$matchinfo['map'] = $map['map13'];
				$matchinfo['round'] = $round_sf_lb;
			}elseif($matchno == 126){
				$matchinfo['map'] = $map['map14'];
				$matchinfo['round'] = $round_gf_lb;
			}return $matchinfo;
	 break;
     case 640:
			if($matchno <= 32){
				$matchinfo['map'] = $map['map1'];	
				$matchinfo['round'] = $round1;
			}elseif($matchno >= 33 && $matchno <= 48){
				$matchinfo['map'] = $map['map2'];
				$matchinfo['round'] = $round2;
			}elseif($matchno >= 49 && $matchno <= 56){
				$matchinfo['map'] = $map['map3'];
				$matchinfo['round'] = $round3;
			}elseif($matchno >= 57 && $matchno <= 60){
				$matchinfo['map'] = $map['map4'];
				$matchinfo['round'] = $round_qf_ub;
			}elseif($matchno == 61 && $matchno == 62){
				$matchinfo['map'] = $map['map4'];
				$matchinfo['round'] = $round_sf_ub;
			}elseif($matchno == 63){
				$matchinfo['map'] = $map['map5'];
				$matchinfo['round'] = $round_gf_ub;
			}elseif($matchno == 64){
				$matchinfo['map'] = $map['map5'];
				$matchinfo['round'] = $third_winner;
			}return $matchinfo;
	 break;
     case 32:

			if($matchno <= 16){
				$matchinfo['map'] = $map['map1'];
				$matchinfo['round'] = $round1;
			}elseif($matchno >= 17 && $matchno <= 24){
				$matchinfo['map'] = $map['map2'];
				$matchinfo['round'] = $round2;
			}elseif($matchno >= 25 && $matchno <= 28){
				$matchinfo['map'] = $map['map3'];
				$matchinfo['round'] = $round3;
			}elseif($matchno == 29 && $matchno == 30){
				$matchinfo['map'] = $map['map4'];
				$matchinfo['round'] = $round4;
			}elseif($matchno == 31){
				$matchinfo['map'] = $map['map5'];
				$matchinfo['round'] = $round_sf_ub;
			}elseif($matchno == 32){
				$matchinfo['map'] = $map['map6'];
				$matchinfo['round'] = $round_gf_ub;
			}elseif($matchno >= 33 && $matchno <= 40){
				$matchinfo['map'] = $map['map7'];
				$matchinfo['round'] = $round1_lb;
			}elseif($matchno >= 41 && $matchno <= 48){
				$matchinfo['map'] = $map['map8'];
				$matchinfo['round'] = $round2_lb;
			}elseif($matchno >= 49 && $matchno <= 52){
				$matchinfo['map'] = $map['map9'];
				$matchinfo['round'] = $round3_lb;
			}elseif($matchno >= 53 && $matchno <= 56){
				$matchinfo['map'] = $map['map10'];
				$matchinfo['round'] = $round4_lb;
			}elseif($matchno == 57 || $matchno == 58){
				$matchinfo['map'] = $map['map11'];
				$matchinfo['round'] = $round5_lb;
			}elseif($matchno == 59 || $matchno == 50){
				$matchinfo['map'] = $map['map12'];
				$matchinfo['round'] = $round6_lb;
			}elseif($matchno == 61){
				$matchinfo['map'] = $map['map13'];
				$matchinfo['round'] = $round_sf_lb;
			}elseif($matchno == 62){
				$matchinfo['map'] = $map['map14'];
				$matchinfo['round'] = $round_gf_lb;
			}return $matchinfo;
	 break;
     case 320:
			if($matchno <= 16){
				$matchinfo['map'] = $map['map1'];	
				$matchinfo['round'] = $round1;
			}elseif($matchno >= 17 && $matchno <= 24){
				$matchinfo['map'] = $map['map2'];
				$matchinfo['round'] = $round2;
			}elseif($matchno >= 25 && $matchno <= 28){
				$matchinfo['map'] = $map['map3'];
				$matchinfo['round'] = $round3;
			}elseif($matchno >= 29 && $matchno <= 30){
				$matchinfo['map'] = $map['map4'];
				$matchinfo['round'] = $round_sf_ub;
			}elseif($matchno == 31){
				$matchinfo['map'] = $map['map5'];
				$matchinfo['round'] = $round_gf_ub;
			}elseif($matchno == 32){ 
				$matchinfo['map'] = $map['map5'];
				$matchinfo['round'] = $third_winner;
			}return $matchinfo;
	 break;
     case 16:
			if($matchno <= 8){
				$matchinfo['map'] = $map['map1'];	
				$matchinfo['round'] = $round1;
			}elseif($matchno >= 9 && $matchno <= 12){
				$matchinfo['map'] = $map['map2'];
				$matchinfo['round'] = $round2;
			}elseif($matchno >= 13 && $matchno <= 14){
				$matchinfo['map'] = $map['map3'];
				$matchinfo['round'] = $round3;
			}elseif($matchno == 15){
				$matchinfo['map'] = $map['map4'];
				$matchinfo['round'] = $round_sf_ub;
			}elseif($matchno == 16){
				$matchinfo['map'] = $map['map5'];
				$matchinfo['round'] = $round_gf_ub;
			}elseif($matchno >= 17 && $matchno <= 20){
				$matchinfo['map'] = $map['map6'];
				$matchinfo['round'] = $round1_lb;
			}elseif($matchno >= 21 && $matchno <= 24){
				$matchinfo['map'] = $map['map7'];
				$matchinfo['round'] = $round2_lb;
			}elseif($matchno == 25 || $matchno == 26){
				$matchinfo['map'] = $map['map8'];
				$matchinfo['round'] = $round3_lb;
			}elseif($matchno == 27 || $matchno == 28){
				$matchinfo['map'] = $map['map9'];
				$matchinfo['round'] = $round4_lb;
			}elseif($matchno == 29){
				$matchinfo['map'] = $map['map10'];
				$matchinfo['round'] = $round_sf_lb;
			}elseif($matchno == 30){
				$matchinfo['map'] = $map['map11'];
				$matchinfo['round'] = $round_gf_lb;
			}return $matchinfo;
	 break;			
     case 160:
			if($matchno <= 8){
				$matchinfo['map'] = $map['map1'];	
				$matchinfo['round'] = $round1;
			}elseif($matchno >= 9 && $matchno <= 12){
				$matchinfo['map'] = $map['map2'];
				$matchinfo['round'] = $round2;
			}elseif($matchno >= 13 && $matchno <= 14){
				$matchinfo['map'] = $map['map3'];
				$matchinfo['round'] = $round_sf_ub;
			}elseif($matchno == 15){
				$matchinfo['map'] = $map['map4'];
				$matchinfo['round'] = $round_gf_ub;
			}elseif($matchno == 16){
				$matchinfo['map'] = $map['map4'];
				$matchinfo['round'] = $third_winner;
			}return $matchinfo;
	 break;		
     case 8:   
			if($matchno <= 4){
				$matchinfo['map'] = $map['map1'];
				$matchinfo['round'] = $round1;
			}elseif($matchno == 5 || $matchno == 6){
				$matchinfo['map'] = $map['map2'];
				$matchinfo['round'] = $round2;
			}elseif($matchno == 7){
				$matchinfo['map'] = $map['map3'];
				$matchinfo['round'] = $round_sf_ub;
			}elseif($matchno == 8){
				$matchinfo['map'] = $map['map4'];
				$matchinfo['round'] = $round_gf_ub;
			}elseif($matchno == 9 || $matchno == 10){
				$matchinfo['map'] = $map['map5'];
				$matchinfo['round'] = $round1_lb;
			}elseif($matchno == 11 || $matchno == 12){
				$matchinfo['map'] = $map['map6'];
				$matchinfo['round'] = $round2_lb;
			}elseif($matchno == 13){
				$matchinfo['map'] = $map['map7'];
				$matchinfo['round'] = $round_sf_lb;
			}elseif($matchno == 14){
				$matchinfo['map'] = $map['map8'];
				$matchinfo['round'] = $round_gf_lb;
			}return $matchinfo;		
	 break;		
     case 80:   
			if($matchno <= 4){
				$matchinfo['map'] = $map['map1'];
				$matchinfo['round'] = $round1;
			}elseif($matchno == 5 || $matchno == 6){
				$matchinfo['map'] = $map['map2'];
				$matchinfo['round'] = $round2;
			}elseif($matchno == 7){
				$matchinfo['map'] = $map['map3'];
				$matchinfo['round'] = $round_gf_ub;
			}elseif($matchno == 8){
				$matchinfo['map'] = $map['map3'];
				$matchinfo['round'] = $third_winner;
			}return $matchinfo;  
      }
}

function clanwonpoints($clanID) {
     RETURN user_cup_points($clanID,$ID=0,$team=1,$won=1,$lost=0,$type="confirmed_p",0);
}
  
function clanlostpoints($clanID) {
     RETURN user_cup_points($clanID,$ID=0,$team=1,$won=0,$lost=1,$type="confirmed_p",0);
}
   
function clantotalpoints($clanID) {
     RETURN user_cup_points($clanID,$ID=0,$team=1,$won=0,$lost=0,$type="confirmed_p",0);
}

function clanscoreratio($userID) {
     RETURN percent(user_cup_points($userID,$ID=0,$team=1,$won=1,$lost=0,$type="confirmed_p",0), user_cup_points($userID,$ID,$team=1,$won=0,$lost=0,$type="confirmed_p",0), 0);
}

function userwonpoints($userID) {	   
    RETURN user_cup_points($userID,$ID=0,$team=0,$won=1,$lost=0,$type="confirmed_p",0);
}
  
function userlostpoints($userID) {
    RETURN user_cup_points($userID,$ID=0,$team=0,$won=0,$lost=1,$type="confirmed_p",0);
}
   
function usertotalpoints($userID) {
     RETURN user_cup_points($userID,$ID=0,$team=0,$won=0,$lost=0,$type="confirmed_p",0);
}

function userscoreratio($userID) {
     RETURN percent(user_cup_points($userID,$ID=0,$team=0,$won=1,$lost=0,$type="confirmed_p",0), user_cup_points($userID,$ID,$team=0,$won=0,$lost=0,$type="confirmed_p",0), 0);
}

function getalphaclanname($clanID) {

	$ds = mysql_fetch_array(safe_query("SELECT short FROM ".PREFIX."cup_all_clans WHERE ID='$clanID'"));
	
	    $name = htmlspecialchars(($clanID == 2147483647 ? 'Wildcard' : $ds['short']));
        if (preg_match('/[^A-Za-z0-9]/', $name)) {
        $func = preg_replace ( '/[^A-Za-z0-9]/', '', $name);
        $name = $func;
	    return $name;

        }else{ return htmlspecialchars(($clanID == 2147483647 ? 'Wildcard' : $ds['short'])); }
}

function getclantag($clanID) {
	$ds = mysql_fetch_array(safe_query("SELECT clantag FROM ".PREFIX."cup_all_clans WHERE ID = '".$clanID."'"));
	return $ds['clantag'];
}

function getalphaclantag($clanID) {

	$ds=mysql_fetch_array(safe_query("SELECT clantag FROM ".PREFIX."cup_all_clans WHERE ID = '".$clanID."'"));
	
        $name = $ds['clantag'];
        if (preg_match('/[^A-Za-z0-9]/', $name)) {
        $func = preg_replace ( '/[^A-Za-z0-9]/', '', $name);
        $name = $func;
	    return $name;

        }else{ return $ds['clantag']; }
}

function getclanID($name) {
	$ds = mysql_fetch_array(safe_query("SELECT ID FROM ".PREFIX."cup_all_clans WHERE name='$name'"));
	return $ds['ID'];
}

function getcupname($cupID) {
	$ds = mysql_fetch_array(safe_query("SELECT name FROM ".PREFIX."cups WHERE ID='$cupID'"));
	return htmlspecialchars($ds['name']);
}

function getladdername($cupID) {
	$ds = mysql_fetch_array(safe_query("SELECT name FROM ".PREFIX."cup_ladders WHERE ID='$cupID'"));
	return htmlspecialchars($ds['name']);
}

function getalphacupname($cupID) {

	$ds=mysql_fetch_array(safe_query("SELECT name FROM ".PREFIX."cups WHERE ID='$cupID'"));
	
        $name = htmlspecialchars($ds['name']);
        if (preg_match('/[^A-Za-z0-9]/', $name)) {
        $func = preg_replace ( '/[^A-Za-z0-9]/', '', $name);
        $name = $func;
	    return $name;

        }else{ return htmlspecialchars($ds['name']); }
}

function is1on1($cupID) {
	$ds = mysql_fetch_array(safe_query("SELECT 1on1 FROM ".PREFIX."cups WHERE ID='$cupID'"));
	return $ds['1on1'];
}

function validmembers($clanID, $cupID) {
	$ergebnis = safe_query("SELECT typ FROM ".PREFIX."cups WHERE ID = '".$cupID."'");
	$ds=mysql_fetch_array($ergebnis);	
	$min_anz = strstr($ds['typ'], 'on', true);
	
	$ergebnis2 = safe_query("SELECT clanID FROM ".PREFIX."cup_clan_members WHERE clanID = '".$clanID."'");
	$anz_mem = mysql_num_rows($ergebnis2);	
	
	if($anz_mem >= $min_anz)
		return true;
	else
		return false;
}

function validgameacc($clanID, $cupID) {
	$ergebnis = safe_query("SELECT gameaccID, gameacclimit FROM ".PREFIX."cups WHERE ID = '".$cupID."'");
	$ds=mysql_fetch_array($ergebnis);
    
    if(!$ds['gameacclimit']) 
    return true; 
	
	else{
	
	$return = true;
	$ergebnis2 = safe_query("SELECT userID FROM ".PREFIX."cup_clan_members WHERE clanID = '".$clanID."'");
	while($db = mysql_fetch_array($ergebnis2)) {
		$ergebnis3 = safe_query("SELECT value FROM ".PREFIX."user_gameacc WHERE userID = '".$db['userID']."' && type = '".$ds['gameaccID']."' && log='0'");
		$anz_mem = mysql_num_rows($ergebnis3);	
		if(!$anz_mem) $return = false;
	}	
	return $return;
  }
}


function checkinvalidgameacc($clanID, $cupID) {
	$ergebnis = safe_query("SELECT gameaccID FROM ".PREFIX."cups WHERE ID = '".$cupID."'");
	$ds=mysql_fetch_array($ergebnis);
    
    if(!$ds['cgameacclimit']) 
    return true; 
	
	else{
	
	$return = true;
	$ergebnis2 = safe_query("SELECT userID FROM ".PREFIX."cup_clan_members WHERE cupID = '".$cupID."' && clanID = '".$clanID."'");
	while($db = mysql_fetch_array($ergebnis2)) {
		$ergebnis3 = safe_query("SELECT value FROM ".PREFIX."user_gameacc WHERE userID = '".$db['userID']."' && type = '".$ds['gameaccID']."' && log='0'");
		$anz_mem = mysql_num_rows($ergebnis3);	
		if(!$anz_mem) $return = false;
	}	
	return $return;
  }
}

function getteampenaltypoints($clanID) {
	$ergebnis = safe_query("SELECT * FROM ".PREFIX."cup_warnings WHERE clanID = '$clanID' && expired='0' && 1on1='0'");	
	$all_points = 0;
	while($db = mysql_fetch_array($ergebnis)) {
		$all_points += $db['points'];
	}
	return $all_points;
}

function getuserpenaltypoints($userID) {
	$ergebnis = safe_query("SELECT * FROM ".PREFIX."cup_warnings WHERE clanID = '$userID' && expired='0' && 1on1='1'");	
	$all_points = 0;
	while($db = mysql_fetch_array($ergebnis)) {
		$all_points += $db['points'];
	}
	return $all_points;
}

function islocked($clanID) {
	$ergebnis = safe_query("SELECT cupblockage FROM ".PREFIX."cup_settings");	
      while($db = mysql_fetch_array($ergebnis)) {
        $teamblockage = $db['cupblockage'];

        }
	return (getteampenaltypoints($clanID) >= $teamblockage);
}

function isdisabled($clanID) {

	$ds=mysql_fetch_array(safe_query("SELECT status FROM ".PREFIX."cup_all_clans WHERE ID='$clanID'"));
	
	if($ds['status']==0) {
	    return true;
	}
	else{
	    return false;
	}
}

function userislocked($userID) {
	$ergebnis = safe_query("SELECT cupblockage FROM ".PREFIX."cup_settings");	
	while($db = mysql_fetch_array($ergebnis)) {
        $teamblockage = $db['cupblockage'];

        }
	return (getuserpenaltypoints($userID) >= $teamblockage);
}

function getclancountry($clanID,$img=0) {
	$ds=mysql_fetch_array(safe_query("SELECT country FROM ".PREFIX."cup_all_clans WHERE ID='$clanID'"));
	
	if(!$ds['country'] || $ds['country']=='na' || is_numeric($ds['country'])) {
	    return ($img ? '<img src="images/flags/na.gif">' : 'na');
	}
	else{
	    return $ds['country'];
	}	
}

function getclancountry3($clanID) {
	$ds=mysql_fetch_array(safe_query("SELECT country FROM ".PREFIX."cup_all_clans WHERE ID='$clanID'"));
	
	if(!$ds['country'] || $ds['country']=='na' || is_numeric($ds['country'])) {
	    return '<img src="images/flags/na.gif">';
	}
	else{
	    return '<img src="images/flags/'.$ds['country'].'.gif">';
	}	
}

function getusercountry($clanID,$ac = null) {

    $dir=($ac ? "../" : "");

	$ds=mysql_fetch_array(safe_query("SELECT country FROM ".PREFIX."user WHERE userID='$clanID'"));
	if(!$ds['country'] || $ds['country']=='na' || is_numeric($ds['country']) || $ds['country']=='<img src="'.$dir.'images/flags/na.gif" width="18" height="12" border="0" alt="not available" />') 
	return '<img src="'.$dir.'images/flags/na.gif" width="18" height="12" border="0" alt="not available" align="left">';
	else return '<img src="'.$dir.'images/flags/'.$ds['country'].'.gif" border="0" align="left">';
}

function getclancountry1($clanID) {
	$ds=mysql_fetch_array(safe_query("SELECT country FROM ".PREFIX."cup_all_clans WHERE ID='$clanID'"));
	if(!$ds['country'] || $ds['country']=='na' || is_numeric($ds['country']) || $ds['country']=='<img src="images/flags/na.gif" width="18" height="12" border="0" alt="not available" />') 
	return '<img src="images/flags/na.gif" width="18" height="12" border="0" alt="not available" align="left">';
	else return '<img src="images/flags/'.$ds['country'].'.gif" border="0" align="left">';
}

function getclancountry2($clanID) {
	$ds=mysql_fetch_array(safe_query("SELECT country FROM ".PREFIX."cup_all_clans WHERE ID='$clanID'"));
	if(!$ds['country'] || $ds['country']=='na' || is_numeric($ds['country'])) 
	return '<img src="images/flags/na.gif" border="0" align="right">';
	else return $ds['country'];
}

function getclancountry4($clanID) {
	$ds=mysql_fetch_array(safe_query("SELECT country FROM ".PREFIX."cup_all_clans WHERE ID='$clanID'"));
	if(!$ds['country'] || $ds['country']=='na' || is_numeric($ds['country']) || $ds['country']=='<img src="images/flags/na.gif" width="18" height="12" border="0" alt="not available" />') 
	return '<img src="images/flags/na.gif" width="18" height="12" border="0" alt="not available" align="right">';
	else return '<img src="images/flags/'.$ds['country'].'.gif" border="0" align="right">';
}

function getusercountry2($clanID) {
	$ds=mysql_fetch_array(safe_query("SELECT country FROM ".PREFIX."user WHERE userID='$clanID'"));
	if(!$ds['country'] || $ds['country']=='na' || is_numeric($ds['country']) || $ds['country']=='<img src="images/flags/na.gif" width="18" height="12" border="0" alt="not available" />') 
	return '<img src="images/flags/na.gif" width="18" height="12" border="0" alt="not available" align="right">';
	else return '<img src="images/flags/'.$ds['country'].'.gif" border="0" align="right">';
}

function getusercountry3($clanID) {
	$ds=mysql_fetch_array(safe_query("SELECT country FROM ".PREFIX."user WHERE userID='$clanID'"));
	if(!$ds['country'] || $ds['country']=='na' || is_numeric($ds['country']) || $ds['country']=='<img src="images/flags/na.gif" width="18" height="12" border="0" alt="not available" />') 
	return '<img src="images/flags/na.gif" width="18" height="12" border="0" alt="not available">';
	else return '<img src="images/flags/'.$ds['country'].'.gif" border="0">';
}

function getstreak($clan,$ladID) {

  $query = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE ladID='$ladID' && (clan1='$clan' || clan2='$clan') && confirmscore='1' && einspruch='0' ORDER BY added_date DESC");    
  $count = mysql_num_rows($query);

  for ($i=0; $i<$count; $i++) {	
      $ds = mysql_fetch_array($query);	
  		
      if ($ds["clan1"]!= $clan){
    	  $c = 0;
      }else{
	      $c = $ds["clan1"];	
      }		
  
	    $b = $c . "-" . $ds["score1"];	
	    $var1[] = $b;
	    unset($b);	
	
      if ($ds["clan2"]!= $clan){	
	      $c = 0;
      }else{	
	      $c = $ds["clan2"];	
      }		
  
	    $b = $c . "-" . $ds["score2"];	
	    $var2[] = $b;
  }			
	
	if(!isset($var1))
	$var1 = null;
	
	if(!isset($var2))
	$var2 = null;
	
	$count = count ($var1);	
	
	if($var1 != null) {
	  foreach ($var1 as $q) {		
	      $x = explode("-", $q);		
	      $k[] = $x;	
	  }
	}	
	
	if($var2 != null) {
	  foreach ($var2 as $q) {		
	      $x = explode("-", $q);		
	      $l[] = $x;	
	  }
	}	
   
  	  for ($i=0; $i<$count; $i++) {	
	      if ($k[$i][1]<$l[$i][1]) {	
	      $winner []= $l[$i][0];	
	      
	}else
	      if ($k[$i][1]>$l[$i][1]) {
          $winner []= $k[$i][0];	
    }	
 }        
 
    if(!isset($winner))
	$winner = 0;
 
    $count = count($winner);

    for ($i=0; $i<$count; $i++) {
        $pointer = $winner[$i];
    }
	
	$streak = 0;

    for ($i=0; $i<$count; $i++) {
        $pointer = $winner[$i];
        
      if ($pointer !=0) {
          $streak +=1;
      }else{
          $streak = 0;
    }
    $return_streak[] = $streak;
 }
    $streak = max($return_streak);
    return(!$streak ? "0" : $streak);
}

function is_odd($int) {
  return($int & 1);
}

function auto_wildcard() {

	$matches = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE clan1='2147483647' || clan2='2147483647'");
	  while($ds=mysql_fetch_array($matches)) {
	  
	    $matchinfo = getnextmatchnr($ds['cupID'], $ds['matchno']);
	    $looserswitch = looserautoswitch($ds['matchno'],$ds['cupID']);	
	    $type_cup=(is1on1($ds['cupID']) ? 1 : 0);	
	    $cupID = $ds['cupID'];
	    
	    $dm1=mysql_fetch_array(safe_query("SELECT matchno FROM ".PREFIX."cup_matches WHERE cupID='".$ds['cupID']."' && matchno='".$matchinfo['matchno']."'"));
	    $dm2=mysql_fetch_array(safe_query("SELECT matchno FROM ".PREFIX."cup_matches WHERE cupID='".$ds['cupID']."' && matchno='".$looserswitch."'"));

	    
	    if($ds['clan1']==2147483647 && $ds['clan2']==2147483647)
	    {			
		    if($matchinfo['matchno'] && !mysql_num_rows(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE cupID='".$cupID."' && matchno='".$matchinfo['matchno']."'"))) 
		    { 
				   safe_query("INSERT INTO ".PREFIX."cup_matches (cupID, ladID, matchno, date, ".$matchinfo['place'].", comment, 1on1, type) VALUES ('".$cupID."', '0', '".$matchinfo['matchno']."', '".time()."', '2147483647', '2', '$type_cup', 'cup')");
			}
			elseif($matchinfo['matchno'])
			{
				   safe_query("UPDATE ".PREFIX."cup_matches SET ".$matchinfo['place']." = '2147483647' WHERE cupID = '".$cupID."' && matchno = '".$matchinfo['matchno']."'");
	        }
	    }
	    elseif(($ds['clan1']==2147483647 && $ds['clan2']) || ($ds['clan2']==2147483647 && $ds['clan1']))
	    {
	    
	        $clanID = ($ds['clan1']==2147483647 ? $ds['clan2'] : $ds['clan1']);
	    
		    if($matchinfo['matchno'] && !mysql_num_rows(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE cupID='".$cupID."' && matchno='".$matchinfo['matchno']."'"))) 
		    { 
				   safe_query("INSERT INTO ".PREFIX."cup_matches (cupID, ladID, matchno, date, ".$matchinfo['place'].", comment, 1on1, type) VALUES ('".$cupID."', '0', '".$matchinfo['matchno']."', '".time()."', '$clanID', '2', '$type_cup', 'cup')");
			}
			elseif($matchinfo['matchno'])
			{
				   safe_query("UPDATE ".PREFIX."cup_matches SET ".$matchinfo['place']." = '$clanID' WHERE cupID = '".$cupID."' && matchno = '".$matchinfo['matchno']."'");
	        }
        }
		    if($looserswitch && !mysql_num_rows(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE cupID='".$cupID."' && matchno='$looserswitch'"))) 
		    {
				   safe_query("INSERT INTO ".PREFIX."cup_matches (cupID, ladID, matchno, date, ".$matchinfo['place'].", comment, 1on1, type) VALUES ('".$cupID."', '0', '$looserswitch', '".time()."', '2147483647', '2', '$type_cup', 'cup')");
	        }
	        elseif($looserswitch)
	        {
				   safe_query("UPDATE ".PREFIX."cup_matches SET ".$matchinfo['place']." = '2147483647' WHERE cupID = '".$cupID."' && matchno = '$looserswitch'");
        }
		elseif($ds['clan1'] && $ds['clan1']!=2147483647 && $ds['clan2'] && $ds['clan2']!=2147483647) {

			if($matchinfo['matchno'] && mysql_num_rows(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE cupID='".$cupID."' && matchno='".$matchinfo['matchno']."'"))) { 
				   $qf=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE cupID='$cupID' && matchno='".$matchinfo['matchno']."'"));

				   $m_info_place = $matchinfo['place'];
				   
				   if($qf[$m_info_place]==2147483647) {
				      safe_query("UPDATE ".PREFIX."cup_matches SET ".$m_info_place."='0' WHERE cupID='$cupID' && matchno='".$matchinfo['matchno']."'");
				   }		  
			  }
		}
            if($ds['clan1']==2147483647 && $ds['clan2']==2147483647) {
			    $cup_winner = 2147483647;
			}
			elseif($ds['clan1']==2147483647 && $ds['clan2']) {
				$cup_winner = $ds['clan2'];
			}
			elseif($ds['clan2']==2147483647 && $ds['clan1']) {
	    	    $cup_winner = $ds['clan1'];
			}
		
		    if($matchinfo['winner']) {
				   safe_query("UPDATE ".PREFIX."cup_baum SET wb_winner='$cup_winner' WHERE cupID = '".$cupID."'");
			}
			elseif($matchinfo['lb_winner']) {
				   safe_query("UPDATE ".PREFIX."cup_baum SET lb_winner = '$cup_winner', third_winner='$cup_winner' WHERE cupID = '".$cupID."'");	
            }
            elseif($matchinfo['third_winner']) {
	               safe_query("UPDATE ".PREFIX."cup_baum SET third_winner = '$cup_winner' WHERE cupID = '".$cupID."'"); 
        }
    }
}

function getnextmatchnr($cupID, $matchno) {
	$matchinfo = array('matchno' => 0,'place' => '','special' => '','winner' => '','third_winner' => '','lb_winner' => '');
	$mi=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchno='$matchno' && cupID='$cupID'"));
    $ds=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cups WHERE ID = '".$cupID."'"));	
	$maxclan = $ds['maxclan'];

	switch($maxclan){
		case 8 : 
			$returnNO = 5;
			for($a = 1; $a<=5; $a++) {
				if($matchno == $a || $matchno == ($a+1)){
					$matchinfo['matchno'] = $returnNO;
					$matchinfo['place'] = ($matchno == $a ? 'clan1' : 'clan2');
					return $matchinfo;
				}
				$returnNO++;
				$a++;
			}
			if($matchno == 7){
				$matchinfo['matchno'] = 8;
				$matchinfo['place'] = 'clan1';
				return $matchinfo;
			}elseif($matchno == 8){
				$matchinfo['winner'] = true;
				return $matchinfo;
			}elseif($matchno == 9){
				$matchinfo['matchno'] = 11;
				$matchinfo['place'] = 'clan2';
				return $matchinfo;
			}elseif($matchno == 10){
				$matchinfo['matchno'] = 12;
				$matchinfo['place'] = 'clan1';
				return $matchinfo;
			}elseif($matchno == 11 || $matchno == 12){
				$matchinfo['matchno'] = 13;
				$matchinfo['place'] = ($matchno == 11 ? 'clan1' : 'clan2');
				return $matchinfo;
			}elseif($matchno == 13){
				$matchinfo['matchno'] = 14;
				$matchinfo['place'] = 'clan2';
				return $matchinfo;
			}elseif($matchno == 14){ 
			        $matchinfo['lb_winner'] = true;
				$matchinfo['matchno'] = 8;
				$matchinfo['place'] = 'clan2';
				return $matchinfo;
			}
		break;
		case 80 :
			$returnNO = 5;
			for($a = 1; $a<=5; $a++) {
				if($matchno == $a || $matchno == ($a+1)){
					$matchinfo['matchno'] = $returnNO;
					$matchinfo['place'] = ($matchno == $a ? 'clan1' : 'clan2');
					return $matchinfo;
				}
				$returnNO++;
				$a++;
			}
			if($matchno == 7){
				$matchinfo['winner'] = true;
				return $matchinfo;
			}elseif($matchno == 8){
				$matchinfo['third_winner'] = true;
				return $matchinfo;
			}
		break;
		case 16 :
			$returnNO = 9;
			for($a = 1; $a<=13; $a++) {
				if($matchno == $a || $matchno == ($a+1)){
					$matchinfo['matchno'] = $returnNO;
					$matchinfo['place'] = ($matchno == $a ? 'clan1' : 'clan2');
					return $matchinfo;
				}
				$returnNO++;
				$a++;
			}
			
			if($matchno == 15){
				$matchinfo['matchno'] = 16;
				$matchinfo['place'] = 'clan1';
				return $matchinfo;
			}elseif($matchno == 16){ 
				$matchinfo['winner'] = true;
				return $matchinfo;
			}elseif($matchno == 17){
				$matchinfo['matchno'] = 21;
				$matchinfo['place'] = 'clan2';
				return $matchinfo;
			}elseif($matchno == 18){
				$matchinfo['matchno'] = 22;
				$matchinfo['place'] = 'clan1';
				return $matchinfo;
			}elseif($matchno == 19){
				$matchinfo['matchno'] = 23;
				$matchinfo['place'] = 'clan2';
				return $matchinfo;
			}elseif($matchno == 20){
				$matchinfo['matchno'] = 24;
				$matchinfo['place'] = 'clan1';
				return $matchinfo;
			}elseif($matchno == 21 || $matchno == 22){
				$matchinfo['matchno'] = 25;
				$matchinfo['place'] = ($matchno == 21 ? 'clan1' : 'clan2');
				return $matchinfo;
			}elseif($matchno == 23 || $matchno == 24){
				$matchinfo['matchno'] = 26;
				$matchinfo['place'] = ($matchno == 23 ? 'clan1' : 'clan2');
				return $matchinfo;
			}elseif($matchno == 25){
				$matchinfo['matchno'] = 27;
				$matchinfo['place'] = 'clan2';
				return $matchinfo;
			}elseif($matchno == 26){
				$matchinfo['matchno'] = 28;
				$matchinfo['place'] = 'clan1';
				return $matchinfo;
			}elseif($matchno == 27 || $matchno == 28){
				$matchinfo['matchno'] = 29;
				$matchinfo['place'] = ($matchno == 27 ? 'clan1' : 'clan2');
				return $matchinfo;
			}elseif($matchno == 29){
				$matchinfo['matchno'] = 30;
				$matchinfo['place'] = 'clan2';
				return $matchinfo;	
			}elseif($matchno == 30){					   
				 $matchinfo['lb_winner'] = true;
				 $matchinfo['matchno'] = 16;
				 $matchinfo['place'] = 'clan2';
                 return $matchinfo;
			}			
		break;
		case 160 :
			$returnNO = 9;
			for($a = 1; $a<=13; $a++) {
				if($matchno == $a || $matchno == ($a+1)){
					$matchinfo['matchno'] = $returnNO;
					$matchinfo['place'] = ($matchno == $a ? 'clan1' : 'clan2');
					return $matchinfo;
				}
				$returnNO++;
				$a++;
			}
			if($matchno == 15){
				$matchinfo['winner'] = true;
				return $matchinfo;
			}elseif($matchno == 16){ 
				$matchinfo['third_winner'] = true;
				return $matchinfo;
			}
		break;
		case 32 :
			$returnNO = 17;
			for($a = 1; $a<=29; $a++) {
				if($matchno == $a || $matchno == ($a+1)){
					$matchinfo['matchno'] = $returnNO;
					$matchinfo['place'] = ($matchno == $a ? 'clan1' : 'clan2');
					return $matchinfo;
				}
				$returnNO++;
				$a++;
			}
			if($matchno == 31){
				$matchinfo['matchno'] = 32;
				$matchinfo['place'] = 'clan1';
				return $matchinfo;
			}elseif($matchno == 32){
				$matchinfo['winner'] = true;
				return $matchinfo;
			}elseif($matchno == 33){
				$matchinfo['matchno'] = 41;
				$matchinfo['place'] = 'clan2';
				return $matchinfo;
			}elseif($matchno == 34){
				$matchinfo['matchno'] = 42;
				$matchinfo['place'] = 'clan1';
				return $matchinfo;
			}elseif($matchno == 35){
				$matchinfo['matchno'] = 43;
				$matchinfo['place'] = 'clan2';
				return $matchinfo;
			}elseif($matchno == 36){
				$matchinfo['matchno'] = 44;
				$matchinfo['place'] = 'clan1';
				return $matchinfo;
			}elseif($matchno == 37){
				$matchinfo['matchno'] = 45;
				$matchinfo['place'] = 'clan2';
				return $matchinfo;
			}elseif($matchno == 38){
				$matchinfo['matchno'] = 46;
				$matchinfo['place'] = 'clan1';
				return $matchinfo;
			}elseif($matchno == 39){
				$matchinfo['matchno'] = 47;
				$matchinfo['place'] = 'clan2';
				return $matchinfo;
			}elseif($matchno == 40){
				$matchinfo['matchno'] = 48;
				$matchinfo['place'] = 'clan1';
				return $matchinfo;
			}elseif($matchno == 41 || $matchno == 42){
				$matchinfo['matchno'] = 49;
				$matchinfo['place'] = ($matchno == 41 ? 'clan1' : 'clan2');
				return $matchinfo;
			}elseif($matchno == 43 || $matchno == 44){
				$matchinfo['matchno'] = 50;
				$matchinfo['place'] = ($matchno == 43 ? 'clan1' : 'clan2');
				return $matchinfo;
			}elseif($matchno == 45 || $matchno == 46){
				$matchinfo['matchno'] = 51;
				$matchinfo['place'] = ($matchno == 45 ? 'clan1' : 'clan2');
				return $matchinfo;
			}elseif($matchno == 47 || $matchno == 48){
				$matchinfo['matchno'] = 52;
				$matchinfo['place'] = ($matchno == 47 ? 'clan1' : 'clan2');
				return $matchinfo;
			}elseif($matchno == 49){
				$matchinfo['matchno'] = 53;
				$matchinfo['place'] = 'clan2';
				return $matchinfo;
			}elseif($matchno == 50){
				$matchinfo['matchno'] = 54;
				$matchinfo['place'] = 'clan1';
				return $matchinfo;
			}elseif($matchno == 51){
				$matchinfo['matchno'] = 55;
				$matchinfo['place'] = 'clan2';
				return $matchinfo;
			}elseif($matchno == 52){
				$matchinfo['matchno'] = 56;
				$matchinfo['place'] = 'clan1';
				return $matchinfo;
			}elseif($matchno == 53 || $matchno == 54){
				$matchinfo['matchno'] = 57;
				$matchinfo['place'] = ($matchno == 53 ? 'clan1' : 'clan2');
				return $matchinfo;
			}elseif($matchno == 55 || $matchno == 56){
				$matchinfo['matchno'] = 58;
				$matchinfo['place'] = ($matchno == 55 ? 'clan1' : 'clan2');
				return $matchinfo;
			}elseif($matchno == 57){
				$matchinfo['matchno'] = 59;
				$matchinfo['place'] = 'clan2';
				return $matchinfo;
			}elseif($matchno == 58){
				$matchinfo['matchno'] = 60;
				$matchinfo['place'] = 'clan1';
				return $matchinfo;
			}elseif($matchno == 59 || $matchno == 60){
				$matchinfo['matchno'] = 61;
				$matchinfo['place'] = ($matchno == 59 ? 'clan1' : 'clan2');
				return $matchinfo;
			}elseif($matchno == 61){
				$matchinfo['matchno'] = 62;
				$matchinfo['place'] = 'clan2';
				return $matchinfo;
			}elseif($matchno == 62){
			    $matchinfo['lb_winner'] = true;
				$matchinfo['matchno'] = 32;
				$matchinfo['place'] = 'clan2';
				return $matchinfo;
			}
		break; 
		case 320 :  	  		
			$returnNO = 17;
			for($a = 1; $a<=29; $a++) {
				if($matchno == $a || $matchno == ($a+1)){
					$matchinfo['matchno'] = $returnNO;
					$matchinfo['place'] = ($matchno == $a ? 'clan1' : 'clan2');
					return $matchinfo;
				}
				$returnNO++;
				$a++;
			}	
			if($matchno == 31){
				$matchinfo['winner'] = true;
				return $matchinfo;
			}elseif($matchno == 32){
				$matchinfo['third_winner'] = true;
				return $matchinfo;
			}
		break;
		
/* Looserbracket 64 teams */
		case 64 :
			$returnNO = 33;
			for($a = 1; $a<=61; $a++) {
				if($matchno == $a || $matchno == ($a+1)){
					$matchinfo['matchno'] = $returnNO;
					$matchinfo['place'] = ($matchno == $a ? 'clan1' : 'clan2');
					return $matchinfo;
				}
				$returnNO++;
				$a++;
			}

   if($matchno >= 65 && $matchno <= 80) {
    
       for ($i=65; $i<81; $i++) { 
          if ($i = $matchno) {
          $matchinfo['matchno'] = $i+16;
          $matchinfo['place']=(is_odd($matchno) ? "clan2" : "clan1");
          return $matchinfo;
       }break; 
     }
   }elseif($matchno >= 97 && $matchno <= 104) {	
   
      for ($i=97; $i<105; $i++) {
          if ($i = $matchno) {
          $matchinfo['matchno'] = $i+8;
          $matchinfo['place']=(is_odd($matchno) ? "clan2" : "clan1");
          return $matchinfo;
       }break; 
     }  
   }elseif($matchno >= 113 && $matchno <= 116) {	
       
      for ($i=113; $i<117; $i++) {
          if ($i = $matchno) {
          $matchinfo['matchno'] = $i+4;
          $matchinfo['place']=(is_odd($matchno) ? "clan2" : "clan1");
          return $matchinfo;
       }break; 
     }
   }	
			if($matchno == 63){
				$matchinfo['matchno'] = 64;
				$matchinfo['place'] = 'clan1';
				return $matchinfo;
			}elseif($matchno == 64){
				$matchinfo['winner'] = true;
				return $matchinfo;
			}elseif($matchno == 81 || $matchno == 82){ 
				$matchinfo['matchno'] = 97;
   				$matchinfo['place'] = ($matchno == 81 ? 'clan1' : 'clan2');
				return $matchinfo;
		    }elseif($matchno == 83 || $matchno == 84){
				$matchinfo['matchno'] = 98;
   				$matchinfo['place'] = ($matchno == 83 ? 'clan1' : 'clan2');
				return $matchinfo;
		    }elseif($matchno == 85 || $matchno == 86){
				$matchinfo['matchno'] = 99;
   				$matchinfo['place'] = ($matchno == 85 ? 'clan1' : 'clan2');
				return $matchinfo;
		    }elseif($matchno == 87 || $matchno == 88){
				$matchinfo['matchno'] = 100;
   				$matchinfo['place'] = ($matchno == 87 ? 'clan1' : 'clan2');
				return $matchinfo;
		    }elseif($matchno == 89 || $matchno == 90){
				$matchinfo['matchno'] = 101;
   				$matchinfo['place'] = ($matchno == 89 ? 'clan1' : 'clan2');
				return $matchinfo;
		    }elseif($matchno == 91 || $matchno == 92){
				$matchinfo['matchno'] = 102;
   				$matchinfo['place'] = ($matchno == 91 ? 'clan1' : 'clan2');
				return $matchinfo;
		    }elseif($matchno == 93 || $matchno == 94){
				$matchinfo['matchno'] = 103;
   				$matchinfo['place'] = ($matchno == 93 ? 'clan1' : 'clan2');
				return $matchinfo;
		    }elseif($matchno == 95 || $matchno == 96){
				$matchinfo['matchno'] = 104;
   				$matchinfo['place'] = ($matchno == 95 ? 'clan1' : 'clan2');
				return $matchinfo;
		    }elseif($matchno == 105 || $matchno == 106){
				$matchinfo['matchno'] = 113;
   				$matchinfo['place'] = ($matchno == 105 ? 'clan1' : 'clan2');
				return $matchinfo;    
		    }elseif($matchno == 107 || $matchno == 108){
				$matchinfo['matchno'] = 114;
   				$matchinfo['place'] = ($matchno == 107 ? 'clan1' : 'clan2');
				return $matchinfo;
		    }elseif($matchno == 109 || $matchno == 110){
				$matchinfo['matchno'] = 115;
   				$matchinfo['place'] = ($matchno == 109 ? 'clan1' : 'clan2');
				return $matchinfo;
		    }elseif($matchno == 111 || $matchno == 112){
				$matchinfo['matchno'] = 116;
   				$matchinfo['place'] = ($matchno == 111 ? 'clan1' : 'clan2');
				return $matchinfo;
		    }elseif($matchno == 117 || $matchno == 118){
				$matchinfo['matchno'] = 121;
   				$matchinfo['place'] = ($matchno == 117 ? 'clan1' : 'clan2');
				return $matchinfo;
		    }elseif($matchno == 119 || $matchno == 120){
				$matchinfo['matchno'] = 122;
   				$matchinfo['place'] = ($matchno == 119 ? 'clan1' : 'clan2');
				return $matchinfo;	
		    }elseif($matchno == 121){
				$matchinfo['matchno'] = 123;
   				$matchinfo['place'] = 'clan2';
				return $matchinfo;	
            }elseif($matchno == 122){
				$matchinfo['matchno'] = 124;
   				$matchinfo['place'] = 'clan1';
				return $matchinfo;				
            }elseif($matchno == 123 || $matchno == 124){
				$matchinfo['matchno'] = 125;
   				$matchinfo['place'] = ($matchno == 123 ? 'clan1' : 'clan2');
				return $matchinfo;			
            }elseif($matchno == 125){
				$matchinfo['matchno'] = 126;
   				$matchinfo['place'] = 'clan2';
				return $matchinfo;	
		    }elseif($matchno == 126){ 
			    $matchinfo['lb_winner'] = true;
				$matchinfo['matchno'] = 64;
   				$matchinfo['place'] = 'clan2';
				return $matchinfo;		
		    }			
		break;
/*EXIT */	
		case 640 :  	  		
			$returnNO = 33;
			for($a = 1; $a<=61; $a++) {
				if($matchno == $a || $matchno == ($a+1)){
					$matchinfo['matchno'] = $returnNO;
					$matchinfo['place'] = ($matchno == $a ? 'clan1' : 'clan2');
					return $matchinfo;
				}
				$returnNO++;
				$a++;
			}	
			if($matchno == 63){
				$matchinfo['winner'] = true;
				return $matchinfo;
			}elseif($matchno == 64){
				$matchinfo['third_winner'] = true;
				return $matchinfo;
			}				
		break;
	}
}

function looserautoswitch($matchno,$cupID) {

  $ds=mysql_fetch_array(safe_query("SELECT maxclan FROM ".PREFIX."cups WHERE ID='$cupID'"));
  
  if(in_array($ds['maxclan'],array(80,160,320,640))) {
      return false;
      break;
  }
  
   switch($ds['maxclan']) {
    case 64 :
        $first_return = 65;
        $r1_l=17;
        $r2_s = 33;
        $r2_e = 48;
        $r2_l = 17;
        $r2_d = 48;  
        $r3_s = 49;
        $r3_e = 56;
        $r3_l = 9;
        $r3_d = 56;    
        $r4_s = 57;
        $r4_e = 60;
        $r4_l = 5;
        $r4_d = 60; 
    break;		
    case 32 :
        $first_return = 33;   
        $r1_l=9;        
        $r2_s = 17;
        $r2_e = 24;
        $r2_l = 9;
        $r2_d = 24;     
        $r3_s = 25;
        $r3_e = 28;
        $r3_l = 5;
        $r3_d = 28; 
        $r4_s = 28;
        $r4_e = 30;
        $r4_l = 3;
        $r4_d = 30;  
    break;
	case 16 :
        $first_return = 17;
        $r1_l=5; 
        $r2_s = 9;
        $r2_e = 12;
        $r2_l = 5;
        $r2_d = 12;  
        $r3_s = 13;
        $r3_e = 14;
        $r3_l = 3;
        $r3_d = 14; 
    break;
	case 8:
        $first_return = 9; //first loosermatch
        $r1_l = 3; //same as $r2_l
        $r2_s = 5; //first match in round2 is 5
        $r2_e = 6; //last match in round 2 is 6
        $r2_l = 3; // 2 matches in r2 (+1)
        $r2_d = 6; //lower r2 - upper r2 
   }
        $start=1;
        $inc = 0; 
        
//case1 - first round
        
      if($matchno <= $ds['maxclan']/2) {

        for ($i=1; $i<$r1_l; $i++) {
            $return[] = ($start+$i+$inc-1) . "." . ($start +$first_return-1);
            $return[] = ($start+$i+$inc) . "." . ($start +$first_return-1);

            $first_return++;
            $inc ++;

        }
        
        foreach ($return as $val) {
             if ($matchno == substr($val, 0, strrpos($val, "."))) {
             RETURN substr($val, (strrpos($val, ".")+1));
            }
        }
        
//case2 - between rounds
        
    }elseif($matchno >= $r2_s && $matchno <= $r2_e) {
       for ($i=1; $i<$r2_l; $i++) {
          if ($i = $matchno) {
          return $i+$r2_d;
        break;
       }
     }
   }elseif($matchno >= $r3_s && $matchno <= $r3_e) {
       for ($i=1; $i<$r3_l; $i++) {
          if ($i = $matchno) {
          return $i+$r3_d;
        break;
       }
     }
   }elseif($matchno >= $r4_s && $matchno <= $r4_e) {
       for ($i=1; $i<$r4_l; $i++) {
          if ($i = $matchno) {
          return $i+$r4_d;
        break;
       }
     }
   }
//case3 - last rounds or winners

 switch($ds['maxclan']) {
  case 64 :
 
   if($matchno == 61) {
          return 123;
   }elseif($matchno == 62) {
          return 124;
   }elseif($matchno == 63) {
          return 126;
   }   
   
  break;  
  case 32 :
 
   if($matchno == 31) {
          return 62;
   } 
   
  break;  
  case 16 :
 
   if($matchno == 15) {
          return 30;
   } 

  break;  
  case 8 :
 
   if($matchno == 7) {
          return 14;
   } 
   
  break;  
  case 80 :
 
   if($matchno == 5 || $matchno == 6) {
          return 8;
   }
   
 break;  
 case 160 :
 
   if($matchno == 13 || $matchno == 14) {
          return 16;
   }
   
  break;  
  case 320 :
 
   if($matchno == 29 || $matchno == 30) {
          return 32;
   }
   
  break;  
  case 640 :
 
   if($matchno == 61 || $matchno == 62) {
          return 64;
  }
  
  break; 
 }
// void drop if last match

  if(in_array($ds['maxclan'],array(8,16,32,64)) && $matchno==$ds['maxclan']) {
     return false;
  }

}

// Hall of Fame Function
function getclanawards($clanID, $one=0, $cupID = null){
	global $ar_awards,$ar1_name,$ar2_name,$ar3_name;
	$ar_awards = array(1=>0,2=>0,3=>0);
	$ar_names = array();
	$adj_qry = ($cupID ? "&& cupID='$cupID'" : "");
	$awards_sql=safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE clanID = '".$clanID."' ".$adj_qry." && 1on1 = '".(!$one ? '0' : '1')."'");
	while($dl = mysql_fetch_array($awards_sql)) {
		$ergebnis1 = safe_query("SELECT status, maxclan FROM ".PREFIX."cups WHERE ID = '".$dl['cupID']."'");		
		$ds = mysql_fetch_array($ergebnis1);
		if($ds['status'] == 3){
			$ergebnis3 = safe_query("SELECT wb_winner, third_winner FROM ".PREFIX."cup_baum WHERE cupID = '".$dl['cupID']."'");		
			$dr=mysql_fetch_array($ergebnis3);				
			if($clanID == $dr['third_winner']){
				$ar_awards[3]++;
				$ar3_name[] = $dl['cupID'];
				$ar_awards['cupID3'] = $dl['cupID'];
			}elseif($clanID == $dr['wb_winner']){
				$ar_awards[1]++;
				$ar1_name[] = $dl['cupID'];
				$ar_awards['cupID1'] = $dl['cupID'];
			}else{
				if($ds['maxclan'] == 80 || $ds['maxclan'] == 160 || $ds['maxclan'] == 320 || $ds['maxclan'] == 640){
					if($ds['maxclan'] == 80)
						$matchno = 7;
					elseif($ds['maxclan'] == 160)
						$matchno = 15;					
					elseif($ds['maxclan'] == 320)
						$matchno = 31;
				    else
				        $matchno = 63;
					$match = safe_query("SELECT clan1, clan2, confirmscore FROM ".PREFIX."cup_matches WHERE cupID='".$dl['cupID']."' and matchno='".$matchno." && gegen'");
					$dd = mysql_fetch_array($match);
					if($dd['confirmscore']){
						if($dd['clan1'] == $clanID || $dd['clan2'] == $clanID){
							$ar_awards[2]++;	
							$ar2_name[] = $dl['cupID'];
							$ar_awards['cupID2'] = $dl['cupID'];
						}
					}
				}else{
					$match = safe_query("SELECT clan1, clan2, confirmscore FROM ".PREFIX."cup_matches WHERE cupID='".$dl['cupID']."' and matchno='".$ds['maxclan']."'");
					$dd = mysql_fetch_array($match);
					if($dd['confirmscore']){
						if($dd['clan1'] == $clanID || $dd['clan2'] == $clanID){
							$ar_awards[2]++;	
							$ar2_name[] = $dl['cupID'];
 							$ar_awards['cupID2'] = $dl['cupID'];
						}
					}
				}				
			}
		}
	}
		return $ar_awards;
}

function cupawards($clanID,$one=0) {

        $awards = '';
        $one = (!$one ? '0' : '1');
        $ar_awards = getclanawards($clanID,$one);
	
		$award1 = '';
		$award2 = '';
		$award3 = '';
		if($ar_awards[1]){
			for($i=1; $i<=$ar_awards[1]; $i++)
				$award1.='<a href="?site=brackets&action=tree&cupID='.$ar_awards['cupID1'].'"><img src="images/cup/icons/award_gold.png" border="0" alt="Gold" title="'.getcupname($ar_awards['cupID1']).'" /></a>'; 
		}
		if($ar_awards[2]){
			for($i=1; $i<=$ar_awards[2]; $i++)
				$award2.='<a href="?site=brackets&action=tree&cupID='.$ar_awards['cupID2'].'"><img src="images/cup/icons/award_silver.png" border="0" alt="'.$_language->module['silver'].'" title="'.getcupname($ar_awards['cupID2']).'" /></a>';
		}
		if($ar_awards[3]){
			for($i=1; $i<=$ar_awards[3]; $i++)
				$award3.='<a href="?site=brackets&action=tree&cupID='.$ar_awards['cupID3'].'"><img src="images/cup/icons/award_bronze.png" border="0" alt="Bronze" title="'.getcupname($ar_awards['cupID3']).'" /></a>';
		}		
		$awards.=$award1.$award2.$award3;
	
	if(!empty($awards)) {	
	    return $awards;
	}
	else{
	    return '';
	}

}

function ladawards($clanID,$one=0) {

        $awards = '';
        $one = (!$one ? '0' : '1');
        $ar_awards = getclanawards_lad($clanID,$one);
	
		$award1 = '';
		$award2 = '';
		$award3 = '';
		if($ar_awards[1]){
			for($i=1; $i<=$ar_awards[1]; $i++)
				$award1.='<a href="?site=standings&ladderID='.$ar_awards['ladID1'].'"><img src="images/cup/icons/award_gold.png" border="0" alt="Gold" title="'.getladname($ar_awards['ladID1']).'" /></a>'; 
		}
		if($ar_awards[2]){
			for($i=1; $i<=$ar_awards[2]; $i++)
				$award2.='<a href="?site=standings&ladderID='.$ar_awards['ladID2'].'"><img src="images/cup/icons/award_silver.png" border="0" alt="'.$_language->module['silver'].'" title="'.getladname($ar_awards['ladID2']).'" /></a>';
		}
		if($ar_awards[3]){
			for($i=1; $i<=$ar_awards[3]; $i++)
				$award3.='<a href="?site=standings&ladderID='.$ar_awards['ladID3'].'"><img src="images/cup/icons/award_bronze.png" border="0" alt="Bronze" title="'.getladname($ar_awards['ladID3']).'" /></a>';
		}		
		$awards.=$award1.$award2.$award3;
	
	if(!empty($awards)) {	
	    return $awards;
	}
	else{
	    return '';
	}

}

/* LADDER EXTENSION */

// Hall of Fame Function - Ladders
function getclanawards_lad($clanID, $one=0){
	global $ar_awards,$ar1_name,$ar2_name,$ar3_name;
	$ar_awards = array(1=>0,2=>0,3=>0);
	$ar_names = array();
	$cupID = isset($_GET['cupID']) ? $_GET['cupID'] : 0;
	$adj_qry = ($cupID ? "&& cupID='$cupID'" : "");
	$awards_sql=safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE clanID = '".$clanID."' ".$adj_qry." && 1on1 = '".(!$one ? '0' : '1')."'");
	while($dl = mysql_fetch_array($awards_sql)) {
		$ergebnis1 = safe_query("SELECT status, maxclan FROM ".PREFIX."cup_ladders WHERE ID = '".$dl['ladID']."'");		
		$ds = mysql_fetch_array($ergebnis1);
		if($ds['status'] == 3){
			$ergebnis3 = safe_query("SELECT 1st, 2nd, 3rd FROM ".PREFIX."cup_ladders WHERE ID = '".$dl['ladID']."'");		
			$dr=mysql_fetch_array($ergebnis3);				
			if($clanID == $dr['3rd']){
				$ar_awards[3]++;
				$ar3_name[] = $dl['ladID'];
				$ar_awards['ladID3'] = $dl['ladID'];
			}elseif($clanID == $dr['1st']){
				$ar_awards[1]++;
				$ar1_name[] = $dl['ladID'];
				$ar_awards['ladID1'] = $dl['ladID'];
			}elseif($clanID == $dr['2nd']){
				$ar_awards[2]++;	
				$ar2_name[] = $dl['ladID'];
                                $ar_awards['ladID2'] = $dl['ladID'];				
			}
		}
	}
	return $ar_awards;
}

function ratio_level($teamID,$one) {

substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php" ? include("config.php") : include("../config.php");

 if($one) { 
    $ratio_type = "userscoreratio";
    $ratio = userscoreratio($teamID);
	$confirmed_match = user_cup_points($teamID,0,0,0,0,"confirmed",0);
 }
 else{
    $ratio_type = "clanscoreratio";
    $ratio = clanscoreratio($teamID);
	$confirmed_match = user_cup_points($teamID,0,1,0,0,"confirmed",0);
 }
 
 $skill_type = 0;
 
 if($skill_type == 1) {
    $low_t = '<img src="images/cup/icons/skill_low.gif">';
    $med_t = '<img src="images/cup/icons/skill_medium.gif">';
    $high_t = '<img src="images/cup/icons/skill_high.gif">';
 }
 else{
    $low_t = $low;
    $med_t = $med;
    $high_t = $high;
 }
 
 //echo "confirmed_match = $confirmed_match";
 
    if($confirmed_match <= $minimum_matches) {
               $ratio_level = '<div class="draw">'.$ned.'</span>';
    }
    elseif($ratio_type($teamID) >= $h1 && $ratio_type($teamID) <= $l1) {
               $ratio_level = '<div class="loss">'.$low_t.'</span>';        
    }
	elseif($ratio_type($teamID) >= $h2 && $ratio_type($teamID) <= $l2) {
               $ratio_level = '<div class="draw">'.$med_t.'</span>';
    }
	elseif($ratio_type($teamID) >= $h3 && $ratio_type($teamID) <= $l3) {
               $ratio_level = '<div class="draw">'.$lowmed.'</span>';      
    }
	elseif($ratio_type($teamID) >= $h4 && $ratio_type($teamID) <= $l4) {
               $ratio_level = '<div class="win">'.$high_t.'</span>'; 
    }
	elseif($ratio_type($teamID) >= $h5 && $ratio_type($teamID) <= $l5) { 
               $ratio_level = '<div class="draw">'.$medhigh.'</span>'; 
    }
	elseif($ratio_type($teamID) >= $h6 && $ratio_type($teamID) <= $l6) {  
               $ratio_level = '<div class="win">'.$high1.'</span>';  
    }
	elseif($ratio_type($teamID) >= $h7 && $ratio_type($teamID) <= $l7) {  
               $ratio_level = '<div class="win">'.$high2.'</span>';  
    }
	else{
               $ratio_level = "n/a";
	}
	
  return $ratio_level;
}

function check_winners() {
  $ladders = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE type='ladder'");
      while($ds=mysql_fetch_array($ladders))
       {
	   
         $query_m = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE ladID='".$ds['ladID']."' && confirmscore='1'");
		 $query_l = safe_query("SELECT * FROM ".PREFIX."cup_ladders WHERE ID='".$ds['ladID']."'");
         $matches = mysql_num_rows($query_m);
		 $laddinfo= mysql_fetch_array($query_l);
		 
		 if(getrank($ds['clanID'],$ds['ladID'],'now',0)==1) {
		     $first = $ds['clanID'];
		 }
		 if(getrank($ds['clanID'],$ds['ladID'],'now',0)==2) {
		     $second = $ds['clanID'];
		 }
		 if(getrank($ds['clanID'],$ds['ladID'],'now',0)==3) {
		     $third = $ds['clanID'];
		 }
		 
         if($laddinfo['status']==3 && $matches && time() >= $laddinfo['end'] && ($laddinfo['1st']!=$first || !$laddinfo['2nd']!=$second || !$laddinfo['3rd']!=$third)) 
         {
            safe_query("UPDATE ".PREFIX."cup_ladders SET 
               1st = '$first', 
               2nd = '$second', 
               3rd = '$third'
            WHERE ID = $ds[ladID]");
        }
    }
}

function tournament_winners($cupID) {
  substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php" ? include("config.php") : include("../config.php");
  
    $ds=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cups WHERE ID='$cupID'"));
        
    switch($ds['maxclan']) {   
        case 8: $matchno = 8; 
        break;
        case 80: $matchno = 7;
        break;
        case 16: $matchno = 16;
        break;
        case 160: $matchno = 15;
        break;
        case 32: $matchno = 32;
        break;
        case 320: $matchno = 31;
        break;
        case 64: $matchno = 64;
        break;
        case 640: $matchno = 63;
        break;   
    }

    $win=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE cupID='$cupID' && matchno='$matchno' && confirmscore='1' && einspruch='0'"));
    $winner =  ($win['score1'] > $win['score2'] ? $win['clan1'] : $win['clan2']);
    $second_winner = ($win['score1'] > $win['score2'] ? $win['clan2'] : $win['clan1']);
    
    $third_match = (in_array($ds['maxclan'],$maxclan_array) ? $ds['maxclan']*2-2 : substr($ds['maxclan'],0,-1));
    $third=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE cupID='$cupID' && matchno='$third_match' && confirmscore='1' && einspruch='0'"));
    
    if(in_array($ds['maxclan'],$maxclan_array))
       $third_winner =  ($third['score1'] > $third['score2'] ? $third['clan2'] : $third['clan1']);
    else
       $third_winner =  ($third['score1'] > $third['score2'] ? $third['clan1'] : $third['clan2']);
     
    $wi=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_baum WHERE cupID='$cupID'")); 
    
    $matchno2 = $matchno*2-2;
    
    $lb=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE cupID='$cupID' && matchno='$matchno2' && confirmscore='1' && einspruch='0'")); 
    $lb_winner = ($lb['score1'] > $lb['score2'] ? $lb['clan1'] : $lb['clan2']);
    
    if(in_array($ds['maxclan'],$maxclan_array) && $wi['lb_winner']!=$lb_winner) {
       safe_query("UPDATE ".PREFIX."cup_baum SET lb_winner='$lb_winner' WHERE cupID='$cupID'");
    }
    
    if(($wi['wb_winner']!=$winner || $wi['third_winner']!=$third_winner || $wi['second_winner']!=$second_winner) && is_array($win))
    {  
	   safe_query("UPDATE ".PREFIX."cups SET ende='".time()."' WHERE ID='$cupID'");
       safe_query("UPDATE ".PREFIX."cup_baum SET wb_winner='$winner', second_winner='$second_winner', third_winner='$third_winner' WHERE cupID='$cupID'");
  }

}

function ticket_checkin($ticketID,$userID,$ip) {
    if(valid_ticketer($ticketID,$userID) && isset($ticketID) && $ticketID) {
      if($userID) {
		if(mysql_num_rows(safe_query("SELECT userID FROM ".PREFIX."whoisonline WHERE userID='$userID'"))) {
			safe_query("UPDATE ".PREFIX."whoisonline SET time='".time()."', ip='$ip', site='".$_GET['site']."', url='?".$_SERVER['QUERY_STRING']."', tickID='$ticketID' WHERE userID='$userID'");
			safe_query("UPDATE ".PREFIX."user SET lastlogin='".time()."' WHERE userID='$userID'");
		}
		else safe_query("INSERT INTO ".PREFIX."whoisonline (time, userID, ip, site, url) VALUES ('".time()."', '$userID', '$ip', '".$_GET['site']."', '?".$_SERVER['QUERY_STRING']."', tickID='$ticketID')");

      }
   }elseif(mysql_num_rows(safe_query("SELECT userID FROM ".PREFIX."whoisonline WHERE userID='$userID'"))) {
			safe_query("UPDATE ".PREFIX."whoisonline tickID='0'");
  }else{
            safe_query("DELETE FROM ".PREFIX."whoisonline WHERE tickID='$tickID'");
 }
}

function getplatlogo($platID,$admin = null) {
  substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php" ? include("config.php") : include("../config.php");
  $ext = substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php" ? "" : "../";

	$ds=mysql_fetch_array(safe_query("SELECT logo FROM ".PREFIX."cup_platforms WHERE ID='$platID'"));

	if(!$ds['logo'] || $ds['logo']=='na') 
        {
	   return '<img src="'.$ext.'images/cup/no_avatar.gif" width="'.$logo_width.'" height="'.$logo_height.'" border="0">';
        }
	else 
        {
           return '<img src="'.$ds['logo'].'" width="'.$logo_width.'" height="'.$logo_height.'" border="0">';
        }
}

function getplatlogo2($ladID) {
  substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php" ? include("config.php") : include("../config.php");
  $ext = substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php" ? "" : "../";

	$dd=mysql_fetch_array(safe_query("SELECT platID FROM ".PREFIX."cup_ladders WHERE ID='$ladID'"));
	$ds=mysql_fetch_array(safe_query("SELECT logo FROM ".PREFIX."cup_platforms WHERE ID = '".$dd['platID']."'"));
	
	if(!$ds['logo'] || $ds['logo']=='na') 
        {
	    return '<img src="'.$ext.'images/cup/no_avatar.gif" width="'.$logo_width2.'" height="'.$logo_height2.'" border="0">';
	}
        else 
        {
            return '<img src="'.$ds['logo'].'" width="'.$logo_width2.'" height="'.$logo_height2.'" border="0">';
        }
}

function getplatlogo3($cupID) {
  substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php" ? include("config.php") : include("../config.php");
  $ext = substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php" ? "" : "../";

	$dd=mysql_fetch_array(safe_query("SELECT platID FROM ".PREFIX."cups WHERE ID='$cupID'"));
	$ds=mysql_fetch_array(safe_query("SELECT logo FROM ".PREFIX."cup_platforms WHERE ID = '".$dd['platID']."'"));
	
	if(!$ds['logo'] || $ds['logo']=='na') 
        {
	    return '<img src="'.$ext.'images/cup/no_avatar.gif" width="'.$logo_width2.'" height="'.$logo_height2.'" border="0">';
	}
        else 
        {
            return '<img src="'.$ds['logo'].'" width="'.$logo_width2.'" height="'.$logo_height2.'" border="0">';
        }
}

function getplatID($ladID) {
	$ds=mysql_fetch_array(safe_query("SELECT platID FROM ".PREFIX."cup_ladders WHERE ID='$ladID'"));
	return $ds['platID'];
}

function getplatID_cup($cupID) {
	$ds=mysql_fetch_array(safe_query("SELECT platID FROM ".PREFIX."cups WHERE ID='$cupID'"));
	return $ds['platID'];
}

function getplatname($platID,$type=0) {  	
    if($type) {
	
	   $ds=mysql_fetch_array(safe_query("SELECT platID FROM ".PREFIX."cup_ladders WHERE ID='$platID'"));
	   $db=mysql_fetch_array(safe_query("SELECT name FROM ".PREFIX."cup_platforms WHERE ID='".$ds['platID']."'"));	   
	   return $db['name'];
	   
   }else{
   
	$ds=mysql_fetch_array(safe_query("SELECT platform, name FROM ".PREFIX."cup_platforms WHERE ID='$platID'"));
	return $ds['platform'].' - '.$ds['name'];
   
   }
}

function getplatname_cup($platID,$type=0) {  	
    if($type) {
	
	   $ds=mysql_fetch_array(safe_query("SELECT platID FROM ".PREFIX."cups WHERE ID='$platID'"));
	   $db=mysql_fetch_array(safe_query("SELECT name FROM ".PREFIX."cup_platforms WHERE ID='".$ds['platID']."'"));	   
	   return $db['name'];
	   
   }else{
   
	$ds=mysql_fetch_array(safe_query("SELECT platform, name FROM ".PREFIX."cup_platforms WHERE ID='$platID'"));
	return $ds['platform'].' - '.$ds['name'];
   
   }
}

function getplatdesc($platID) {
	$ds=mysql_fetch_array(safe_query("SELECT descrip FROM ".PREFIX."cup_platforms WHERE ID='$platID'"));
	return $ds['descrip'];
}

function getladname($ladID) {
	$ds=mysql_fetch_array(safe_query("SELECT name FROM ".PREFIX."cup_ladders WHERE ID='$ladID'"));
	return $ds['name'];
}

function getladdesc($ladID) {
	$ds=mysql_fetch_array(safe_query("SELECT descrip FROM ".PREFIX."cup_ladders WHERE ID='$ladID'"));
	return $ds['descrip'];
}

function ladderis1on1($ladID) {
	$ds = mysql_fetch_array(safe_query("SELECT 1on1 FROM ".PREFIX."cup_ladders WHERE ID='$ladID'"));
	return $ds['1on1'];
}

function getladtype($ladID) {
	$ds = mysql_fetch_array(safe_query("SELECT type FROM ".PREFIX."cup_ladders WHERE ID='$ladID'"));
	return $ds['type'];
}

function getladmode($ladID) {
	$ds = mysql_fetch_array(safe_query("SELECT mode FROM ".PREFIX."cup_ladders WHERE ID='$ladID'"));
	return $ds['mode'];
}

function ladabbrev($ladID) {
    $ds = mysql_fetch_array(safe_query("SELECT abbrev FROM ".PREFIX."cup_ladders WHERE ID='$ladID'"));
    return $ds['abbrev'];
}

function getladgametype($ladID) {
	$ds = mysql_fetch_array(safe_query("SELECT gametype FROM ".PREFIX."cup_ladders WHERE ID='$ladID'"));
	return $ds['gametype'];
}

function getplatform($platID) {
	$ds = mysql_fetch_array(safe_query("SELECT platform FROM ".PREFIX."cup_platforms WHERE ID='$platID'"));
	return $ds['platform'];
}

function getname1($clan,$ID,$ac,$var,$brt_ext = null) {
   
   $laddID = "";
   $ladderID = "";
   if(isset($_GET['laddID'])) $laddID = $_GET['laddID'];
   if(isset($_GET['ladderID'])) $ladderID = $_GET['ladderID'];
   
   $type = ($ac ? "../" : "");
   $typee= ($laddID || $ladderID ? 'ladID' : 'cupID');
   $typer= ($laddID || $ladderID ? 'laddID': 'cupID');
   $exte = ($brt_ext ? "&$typer=$ID" : "");
   
        if($var=="cup" && is1on1($ID)) 
        {
           return '<a title="" href="'.$type.'?site=profile&id='.$clan.'"><b>'.getnickname($clan).'</b></a>';
        }
        elseif($var=="ladder" && ladderis1on1($ID))
        {
           return '<a title="" href="'.$type.'?site=profile&id='.$clan.'"><b>'.getnickname($clan).'</b></a>';
        }
        else
        {
           return '<a titlte="" href="'.$type.'?site=clans&action=show&clanID='.$clan.$exte.'"><b>'.getclanname2($clan).'</b></a>';
     }       
}

function getname2($clan,$ID,$ac,$var,$brt_ext = null) {
 
        if($var=="cup" && is1on1($ID)) 
        {
           return getnickname($clan);
        }
        elseif($var=="ladder" && ladderis1on1($ID))
        {
           return getnickname($clan);
        }
        else
        {
           return getclanname2($clan);
     }       
}

function getname3($clan,$ID,$ac,$var,$brt_ext = null) {
   
   $laddID = "";
   $ladderID = "";
   if(isset($_GET['laddID'])) $laddID = $_GET['laddID'];
   if(isset($_GET['ladderID'])) $ladderID = $_GET['ladderID'];
   
   $typee= ($laddID || $ladderID ? 'ladID' : 'cupID');
   $typer= ($laddID || $ladderID ? 'laddID': 'cupID');
   $exte = ($brt_ext ? "&$typer=$ID" : "");
   
        if($var=="cup" && is1on1($ID)) 
        {
           return "?site=profile&id=$clan";
        }
        elseif($var=="ladder" && ladderis1on1($ID))
        {
           return "?site=profile&id=$clan";
        }
        else
        {
           return "?site=clans&action=show&clanID=$clan$exte";
     }       
}

function mostactive($ladID) {

  $ds=mysql_fetch_array(safe_query("SELECT MAX(ma) as mostactive FROM ".PREFIX."cup_clans WHERE ladID='$ladID'"));
  $dm=mysql_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE ladID='$ladID' AND ma='".$ds['mostactive']."'"));
  RETURN (!$ds['mostactive'] ? "n/a" : getname1($dm['clanID'],$ladID,$ac=0,$var="ladder")." (".$ds['mostactive'].")");
   
}

function mostcompetitive($ladID) {

    $ds=mysql_fetch_array(safe_query("SELECT ranksys FROM ".PREFIX."cup_ladders WHERE ID='$ladID'"));
    $dm=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='$ladID'"));
    
    switch($ds['ranksys']) {
	
	  case 1 :
    
        $dm1=mysql_fetch_array(safe_query("SELECT MAX(credit) as maxcredit FROM ".PREFIX."cup_clans WHERE ladID='$ladID'"));
        $dm2=mysql_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE ladID='$ladID' && credit='".$dm1['maxcredit']."'"));
        $value = getname1($dm2['clanID'],$ladID,$ac=0,$var="ladder")." (".$dm1['maxcredit'].")";
        
	  break;
      case 2 :	  
    
        $dm1=mysql_fetch_array(safe_query("SELECT MAX(xp) as maxxp FROM ".PREFIX."cup_clans WHERE ladID='$ladID'"));
        $dm2=mysql_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE ladID='$ladID' && xp='".$dm1['maxxp']."'"));
        $value = getname1($dm2['clanID'],$ladID,$ac=0,$var="ladder")." (".$dm1['maxxp'].")";
        
	  break;
      case 3 :
    
        $dm1=mysql_fetch_array(safe_query("SELECT MAX(won) as maxwon FROM ".PREFIX."cup_clans WHERE ladID='$ladID'"));
        $dm2=mysql_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE ladID='$ladID' && won='".$dm1['maxwon']."'"));
        $value = getname1($dm2['clanID'],$ladID,$ac=0,$var="ladder")." (".$dm1['maxxp'].")";
        
	  break;
      case 4 :
    
        $dm1=mysql_fetch_array(safe_query("SELECT MAX(tp) as maxtp FROM ".PREFIX."cup_clans WHERE ladID='$ladID'"));
        $dm2=mysql_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE ladID='$ladID' && tp='".$dm1['maxtp']."'"));   
        $value = getname1($dm2['clanID'],$ladID,$ac=0,$var="ladder")." (".$dm1['maxtp'].")";
        
	  break;
      case 5 :
    
        $dm1=mysql_fetch_array(safe_query("SELECT MAX(wc) as maxwc FROM ".PREFIX."cup_clans WHERE ladID='$ladID'"));
        $dm2=mysql_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE ladID='$ladID' && wc='".$dm1['maxwc']."'"));   
        $value = getname1($dm2['clanID'],$ladID,$ac=0,$var="ladder")." (".$dm1['maxwc'].")";
        
	  break;
      case 6 :
    
        $dm1=mysql_fetch_array(safe_query("SELECT MAX(streak) as maxst FROM ".PREFIX."cup_clans WHERE ladID='$ladID'"));
        $dm2=mysql_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE ladID='$ladID' && wc='".$dm1['maxst']."'"));   
        $value = getname1($dm2['clanID'],$ladID,$ac=0,$var="ladder")." (".$dm1['maxst'].")";
      
      break;	  
      case 7 :	  
    
        $dm1=mysql_fetch_array(safe_query("SELECT MAX(elo) as maxelo FROM ".PREFIX."cup_clans WHERE ladID='$ladID'"));
        $dm2=mysql_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE ladID='$ladID' && elo='".$dm1['maxelo']."'"));
        $value = getname1($dm2['clanID'],$ladID,$ac=0,$var="ladder")." (".$dm1['maxelo'].")";
	  break;
		
    } if(empty($dm2['clanID']))
         RETURN "n/a";
      else
         RETURN $value;

}

function ca_copyr() {
//copyright removal or modification is prohibited
    include("admin/cupversion.php");
    return '<br><br><a href="http://www.teamx1.com/" title="Build '.$version_num.'" target="_blank"><hr><center><strong>Team -X1- &#169; Cup Addon V'.$version.'</strong></center><hr></a>';
}

function getcredits($teamID,$laddID) {
   
  $one = (ladderis1on1($laddID) ? "1" : "0"); 
  $ds=mysql_fetch_array(safe_query("SELECT credit FROM ".PREFIX."cup_clans WHERE clanID='$teamID' && ladID='$laddID' && 1on1='$one'"));
  
  return $ds['credit'];

}

function getdeduction($teamID,$laddID) {

  $deductions = safe_query("SELECT * FROM ".PREFIX."cup_deduction WHERE ladID='$laddID' && clanID='$teamID' ORDER BY time DESC");
   $num_rows = mysql_num_rows($deductions);
    while($ds=mysql_fetch_array($deductions)) 
    {       
       $cred_d_s=($ds['deducted']*$num_rows==1 ? "Credit" : "Credits");
       return (empty($ds['deducted']) ? "n/a" : $num_rows.'x'.array_sum(explode(".", $ds['deducted']))." $cred_d_s");
    }
}

function mostwon($ladID) {

    $ds=mysql_fetch_array(safe_query("SELECT MAX(won) as maxwon FROM ".PREFIX."cup_clans WHERE ladID='$ladID'"));
    $dm=mysql_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE ladID='$ladID' && won='".$ds['maxwon']."'"));
    
    if(empty($ds['maxwon'])) 
       RETURN "n/a";
    else
       RETURN getname1($dm['clanID'],$ladID,$ac=0,$var="ladder")." (".$ds['maxwon'].")";
      
}

function mostlost($ladID) {

    $ds=mysql_fetch_array(safe_query("SELECT MAX(lost) as maxlost FROM ".PREFIX."cup_clans WHERE ladID='$ladID'"));
    $dm=mysql_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE ladID='$ladID' && lost='".$ds['maxlost']."'"));
    
    if(empty($ds['maxlost'])) 
       RETURN "n/a";
    else
       RETURN getname1($dm['clanID'],$ladID,$ac=0,$var="ladder")." (".$ds['maxlost'].")";
}


function leadingxp($ladID,$team1,$team2) {

    $ds=mysql_fetch_array(safe_query("SELECT MAX(xp) as maxxp FROM ".PREFIX."cup_clans WHERE ladID='$ladID'"));
    $dm=mysql_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE ladID='$ladID' && xp='".$ds['maxxp']."'"));
    
    if(empty($ds['maxxp'])) 
       RETURN "n/a";
    else
       RETURN getname1($dm['clanID'],$ladID,$ac=0,$var="ladder")." (".$ds['maxxp'].")";
}

function mostcredits($ladID) {

   $credits = safe_query("SELECT MAX(credit) as maxcredit FROM ".PREFIX."cup_clans WHERE ladID='$ladID'");
   $ds=mysql_fetch_array($credits); if(!$ds['maxcredit']) return 'n/a';  
   
   $name = safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE ladID='$ladID' AND credit='".$ds['maxcredit']."'");
   $ns=mysql_fetch_array($name);
     
   return getname1($ns['clanID'],$ladID,$ac=0,$var="ladder").' ('.$ds['maxcredit'].')';  
}

function returnTime($value) {
  $timeDiff = time()-$value;  // Get the difference in time
  $fullYears = floor($timeDiff/365.2422/24/60/60);  // Set the amount of years since $value
  $fullDays = floor($timeDiff/24/60/60)-($fullYears*365);  // Set the amount of dayss since $value
  $fullHours = floor($timeDiff/60/60)-($fullDays*24)-($fullYears*365*24);  // Set the amount of hours since $value
  $fullMinutes = floor($timeDiff/60)-($fullHours*60)-($fullDays*24*60)-($fullYears*365*24*60); // Set the amount of minutes since $value
  $fullSeconds = floor($timeDiff)-($fullMinutes*60)-($fullHours*60*60)-($fullDays*24*60*60)-($fullYears*365*24*60*60); // Set the seconds of years since $value

  if($timeDiff >= '31536000') {
    return $fullYears.'y';
  } else if($timeDiff >= '86400' && $timeDiff < '31536000') {
    return $fullDays.'d';
  } else if ($timeDiff >= '3600' && $timeDiff < '86400') {
    return $fullHours.'h';
  } else if ($timeDiff >= '60' && $timeDiff < '3600') {
    return $fullMinutes.'m';
  } else if ($timeDiff < '60') {
    return $fullSeconds.'s';
  }
}

function returnTime2($value) {
  $timeDiff = time()-$value;  // Get the difference in time
  $fullYears = floor($timeDiff/365.2422/24/60/60);  // Set the amount of years since $value
  $fullDays = floor($timeDiff/24/60/60)-($fullYears*365);  // Set the amount of dayss since $value
  $fullHours = floor($timeDiff/60/60)-($fullDays*24)-($fullYears*365*24);  // Set the amount of hours since $value
  $fullMinutes = floor($timeDiff/60)-($fullHours*60)-($fullDays*24*60)-($fullYears*365*24*60); // Set the amount of minutes since $value
  $fullSeconds = floor($timeDiff)-($fullMinutes*60)-($fullHours*60*60)-($fullDays*24*60*60)-($fullYears*365*24*60*60); // Set the seconds of years since $value

  if($timeDiff >= '31556952') {
    $s = ($timeDiff < 63113904 ? '' : 's');
    return $fullYears.' year'.$s;
  } else if($timeDiff >= '86400' && $timeDiff < '31556952') {
    $s = ($timeDiff < 172800 ? '' : 's');
    return $fullDays.' day'.$s;
  } else if ($timeDiff >= '3600' && $timeDiff < '86400') {
    $s = ($timeDiff < 7200 ? '' : 's');
    return $fullHours.' hour'.$s;
  } else if ($timeDiff >= '60' && $timeDiff < '3600') {
    $s = ($timeDiff < 120 ? '' : 's');
    return $fullMinutes.' minute'.$s;
  } else if ($timeDiff < '60') {
    $s = ($timeDiff==1 ? '' : 's');
    return $fullSeconds.' second'.$s;
  }
}

function returnTime3($value) {
  $timeDiff = time()-$value;  // Get the difference in time
  $fullYears = floor($timeDiff/365.2422/24/60/60);  // Set the amount of years since $value
  $fullDays = floor($timeDiff/24/60/60)-($fullYears*365);  // Set the amount of dayss since $value
  $fullHours = floor($timeDiff/60/60)-($fullDays*24)-($fullYears*365*24);  // Set the amount of hours since $value
  $fullMinutes = floor($timeDiff/60)-($fullHours*60)-($fullDays*24*60)-($fullYears*365*24*60); // Set the amount of minutes since $value
  $fullSeconds = floor($timeDiff)-($fullMinutes*60)-($fullHours*60*60)-($fullDays*24*60*60)-($fullYears*365*24*60*60); // Set the seconds of years since $value

  if($timeDiff >= '31536000') {
    return $fullYears.' year(s)';
  } else if($timeDiff >= '86400' && $timeDiff < '31536000') {
    return $fullDays.' day(s)';
  } 
}

function returnTime4($value) {
  $timeDiff = time()-$value;  // Get the difference in time
  $fullYears = floor($timeDiff/365.2422/24/60/60);  // Set the amount of years since $value
  $fullDays = floor($timeDiff/24/60/60)-($fullYears*365);  // Set the amount of dayss since $value
  $fullHours = floor($timeDiff/60/60)-($fullDays*24)-($fullYears*365*24);  // Set the amount of hours since $value
  $fullMinutes = floor($timeDiff/60)-($fullHours*60)-($fullDays*24*60)-($fullYears*365*24*60); // Set the amount of minutes since $value
  $fullSeconds = floor($timeDiff)-($fullMinutes*60)-($fullHours*60*60)-($fullDays*24*60*60)-($fullYears*365*24*60*60); // Set the seconds of years since $value

  if($timeDiff >= '31536000') {
    return $fullYears;
  } else if($timeDiff >= '86400' && $timeDiff < '31536000') {
    return $fullDays;
  } else if ($timeDiff >= '3600' && $timeDiff < '86400') {
    return $fullHours;
  } else if ($timeDiff >= '60' && $timeDiff < '3600') {
    return $fullMinutes;
  } else if ($timeDiff < '60') {
    return $fullSeconds;
  }
}


function longestIdle($ladID) {

  $participants = safe_query("SELECT clanID, lastact, registered FROM ".PREFIX."cup_clans WHERE ladID='$ladID' AND checkin='1' ORDER BY lastact ASC");
    if(!mysql_num_rows($participants)) return 'n/a';  
      else{  
     $ds=mysql_fetch_array($participants); 
     
     if($ds['registered'] && $ds['registered'] > $ds['lastact'])
        return getname1($ds['clanID'],$ladID,$ac=0,$var="ladder").' ('.returnTime($ds['registered']).')';
     elseif($ds['lastact'] && $ds['lastact'] > $ds['registered'])
        return getname1($ds['clanID'],$ladID,$ac=0,$var="ladder").' ('.returnTime($ds['lastact']).')';
     else
        return "n/a";
    
   }
}

function lastActivity($ladID) {

  $participants = safe_query("SELECT clanID, lastact, registered FROM ".PREFIX."cup_clans WHERE ladID='$ladID' ORDER BY lastact DESC");
    if(!mysql_num_rows($participants)) return 'n/a';  
      else{  
     $ds=mysql_fetch_array($participants); 

     if($ds['registered'] && $ds['registered'] > $ds['lastact'])
        return getname1($ds['clanID'],$ladID,$ac=0,$var="ladder").' ('.returnTime($ds['registered']).')';
     elseif($ds['lastact'] && $ds['lastact'] > $ds['registered'])
        return getname1($ds['clanID'],$ladID,$ac=0,$var="ladder").' ('.returnTime($ds['lastact']).')';
     else
        return "n/a";
    
   }
}

function mapPic($name,$ladID) {
  substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php" ? include("config.php") : include("../config.php");
  
  $mp=mysql_fetch_array(safe_query("SELECT mappack FROM ".PREFIX."cup_ladders WHERE ID='$ladID'"));
  
    $map = safe_query("SELECT map, pic FROM ".PREFIX."cup_maps WHERE map='$name' AND mappack='".$mp['mappack']."'");
    $ds = mysql_fetch_array($map);
    
    if(!$ds['pic'])
        return '<img alt="'.$ds['name'].'" src="images/avatars/noavatar.gif"><br>'.$ds['map'].'';
    else
        return '<img alt="'.$ds['name'].'" src="'.$ds['pic'].'" width="'.$map_width.'" height="'.$map_height.'"><br>'.$ds['map'].'';
}

function getalphaladname($ladID) {

	$ds=mysql_fetch_array(safe_query("SELECT name FROM ".PREFIX."cup_ladders WHERE ID='$ladID'"));
    	
        $name = htmlspecialchars($ds['name']);
        if (preg_match('/[^A-Za-z0-9]/', $name)) {
        $func = preg_replace ( '/[^A-Za-z0-9]/', '', $name);
        $name = $func;
	    return $name;
    }else
        return htmlspecialchars($ds['name']); 
}

function Sec2Time($time){
    $value = array(
      "years" => 0, "days" => 0, "hours" => 0,
      "minutes" => 0, "seconds" => 0,
    );
    if($time >= 31556926){
      $s = ($time < 172800 ? '' : 's');
      RETURN $value["years"] = floor($time/31556926)." year".$s;
      $time = ($time%31556926);
    }
    if($time >= 86400){
      $s = ($time < 172800 ? '' : 's');
      RETURN $value["days"] = floor($time/86400)." day".$s;
      $time = ($time%86400);
    }
    if($time >= 3600){
      $s = ($time < 7200 ? '' : 's');
      RETURN $value["hours"] = floor($time/3600)." hour".$s;
      $time = ($time%3600);
    }
    if($time >= 60){
      $s = ($time < 120 ? '' : 's');
      RETURN $value["minutes"] = floor($time/60)." minute".$s;
      $time = ($time%60);
    }
    $s = ($time==1 ? '' : 's');
    RETURN $value["seconds"] = floor($time)." second".$s;
}

function average($team_ranks){
   return array_sum($team_ranks)/count($team_ranks);
}

function isladparticipant($userID,$ladID,$checkin) {

 if($checkin==1) {
    $checkin_status = "&& checkin='1'";
 }
 elseif($checkin==2) {
    $checkin_status = "&& checkin='0'";
 }
 else{
    $checkin_status = "";
 }
    
 if(!$userID) {
     return false;
 }

 if(ladderis1on1($ladID)) { 
 
   $pp=mysql_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE ladID='$ladID' AND clanID='$userID' AND 1on1='1' $checkin_status"));
   
          if($userID==$pp['clanID'] && $userID!=0 && $pp['clanID']!=0) 
             return true;
          else
             return false;

 }else{

  $query = safe_query("SELECT clanID FROM ".PREFIX."cup_clan_members WHERE userID='$userID'");
    if(!mysql_num_rows($query)) false;
      while($ds=mysql_fetch_array($query)) {
      
          $pp=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='$ladID' AND clanID='".$ds['clanID']."' AND 1on1='0' $checkin_status"));

          if(isleader($userID,$pp['clanID']) && $userID!=0 && $pp['clanID']!=0) 
             $var = 1;
          else
             $var = 0;
        }
    return ($var==1 ? true : false);		  
    }
}

function isladparticipant_memin($userID,$ladID,$checkin) {

 if($checkin==1) {
    $checkin_status = "&& checkin='1'";
 }
 elseif($checkin==2) {
    $checkin_status = "&& checkin='0'";
 }
 else{
    $checkin_status = "";
 }
    
 if(!$userID) {
     return false;
 }

 if(ladderis1on1($ladID)) { 
 
   $pp=mysql_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE ladID='$ladID' AND clanID='$userID' AND 1on1='1' $checkin_status"));

          if($userID==$pp['clanID'] && $userID!=0 && $pp['clanID']!=0) 
             return true;
          else
             return false;

 }else{

  $query = safe_query("SELECT clanID FROM ".PREFIX."cup_clan_members WHERE userID='$userID'");
    if(!mysql_num_rows($query)) false;
      while($ds=mysql_fetch_array($query)) {
      
          $pp=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='$ladID' AND clanID='".$ds['clanID']."' AND 1on1='0' $checkin_status"));

          if(memin($userID,$pp['clanID']) && $userID!=0 && $pp['clanID']!=0) 
             $var = 1;
          else
             $var = 0;
        }
    return ($var==1 ? true : false);  
    }
}

function participantID($userID,$ladID) {

 if(ladderis1on1($ladID)) { 

   $pp=mysql_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE ladID='$ladID' AND clanID='$userID' AND 1on1='1'"));

          if($userID==$pp['clanID']) 
             return $pp['clanID'];
          else
             return false;

 }else{

  $query = safe_query("SELECT clanID FROM ".PREFIX."cup_clan_members WHERE userID='$userID'");
    if(!mysql_num_rows($query)) return false;
      while($ds=mysql_fetch_array($query)) {
      
          $pp=mysql_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE ladID='$ladID' AND clanID='".$ds['clanID']."' AND 1on1='0'"));

          if(isleader($userID,$pp['clanID'])) 
             $var = $pp['clanID'];
          else
             $var = 0;
    }
   return ($var!=0 ? $var : false);     
  }
}

function getparticipantID($userID,$ladID) {

 if(ladderis1on1($ladID)) { 

   $pp=mysql_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE ladID='$ladID' AND clanID='$userID' AND 1on1='1'"));
   return $pp['clanID'];

 }else{

  $query = safe_query("SELECT clanID FROM ".PREFIX."cup_clan_members WHERE userID='$userID'");
    if(!mysql_num_rows($query)) return false;
      while($ds=mysql_fetch_array($query)) {
      
          $pp=mysql_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE ladID='$ladID' AND clanID='".$ds['clanID']."' AND 1on1='0'"));
          return $pp['clanID'];
    }    
  }
}

function participantID_memin($userID,$ladID) {

 if(ladderis1on1($ladID)) { 

   $pp=mysql_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE ladID='$ladID' AND clanID='$userID' AND 1on1='1'"));

          if($userID==$pp['clanID']) 
             return $pp['clanID'];
          else
             return false;

 }else{

  $query = safe_query("SELECT clanID FROM ".PREFIX."cup_clan_members WHERE userID='$userID'");
    if(!mysql_num_rows($query)) return false;
      while($ds=mysql_fetch_array($query)) {
      
          $pp=mysql_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE ladID='$ladID' AND clanID='".$ds['clanID']."' AND 1on1='0'"));
          
          if(memin($userID,$pp['clanID'])) 
             $var = $pp['clanID'];
          else
             $var = 0;
    }
   return ($var!=0 ? $var : false);    
  }
}

function participantID_memin_gs($userID,$cupID,$type) {

 if($type == "ladID") {
     $type2 = "ladderis1on1";
	 $type_opp = "cupID";
 } else {
     $type2 = "is1on1";
	 $type_opp = "ladID";
 }

 if($type2($cupID)) { 

   $pp=mysql_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE groupID='$cupID' AND clanID='$userID' AND 1on1='1' AND type='gs' AND $type_opp='0'"));

          if($userID==$pp['clanID']) 
             return $pp['clanID'];
          else
             return false;

 }else{

  $query = safe_query("SELECT clanID FROM ".PREFIX."cup_clan_members WHERE userID='$userID'");
    if(!mysql_num_rows($query)) return false;
      while($ds=mysql_fetch_array($query)) {
      
          $pp=mysql_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE groupID='$cupID' AND clanID='".$ds['clanID']."' AND 1on1='0' AND type='gs' AND $type_opp='0'"));
          
          if(memin($userID,$pp['clanID'])) 
             $var = $pp['clanID'];
          else
             $var = 0;
    }
   return ($var!=0 ? $var : false);    
  }
}

function cupParticipantID($userID,$cupID) {

 if(ladderis1on1($cupID)) { 

   $pp=mysql_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE cupID='$cupID' AND clanID='$userID' AND 1on1='1'"));

          if($userID==$pp['clanID']) 
             return $pp['clanID'];
          else
             return false;

 }else{

  $query = safe_query("SELECT clanID FROM ".PREFIX."cup_clan_members WHERE userID='$userID'");
    if(!mysql_num_rows($query)) return false;
      while($ds=mysql_fetch_array($query)) {
      
          $pp=mysql_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE cupID='$cupID' AND clanID='".$ds['clanID']."' AND 1on1='0'"));
          
          if(isleader($userID,$pp['clanID'])) 
             $var = $pp['clanID'];
          else
             $var = 0;
    }
   return ($var!=0 ? $var : false);      
  }
}

function participantTeamID($userID) {

  $query = safe_query("SELECT clanID FROM ".PREFIX."cup_clan_members WHERE userID='$userID'");
    if(!mysql_num_rows($query)) return false;
      while($ds=mysql_fetch_array($query)) {
      
          $pp=mysql_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE clanID='".$ds['clanID']."' AND 1on1='0'"));
          
          if(memin($userID,$pp['clanID'])) 
             $var = $pp['clanID'];
          else
             $var = 0;
    }
   return ($var!=0 ? $var : false);     
}

function iscupparticipant($userID,$cupID,$checkin = null) {

 if($checkin==1) {
    $checkin_status = "&& checkin='1'";
 }
 elseif($checkin==2) {
    $checkin_status = "&& checkin='0'";
 }
 else{
    $checkin_status = "";
 }
    
 if(!$userID) {
     return false;
 }

 if(is1on1($cupID)) { 
    $pp=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE cupID='$cupID' AND clanID='$userID' AND 1on1='1' $checkin_status")); 
 
          if($userID==$pp['clanID'] && $userID!=0 && $pp['clanID']!=0) 
             return true;
          else
             return false; 
 
 }else{

  $query = safe_query("SELECT clanID FROM ".PREFIX."cup_clan_members WHERE userID='$userID'");
    if(!mysql_num_rows($query)) false;
      while($ds=mysql_fetch_array($query)) {
      
          $pp=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE cupID='$cupID' AND clanID='".$ds['clanID']."' AND 1on1='0' $checkin_status"));
          
          if(isleader($userID,$pp['clanID']) && $userID!=0 && $pp['clanID']!=0) 
             $var = 1;
          else
             $var = 0;
        }
    return ($var==1 ? true : false);
   }
}

function iscupparticipant_memin($userID,$cupID,$checkin) {

 if($checkin==1) {
    $checkin_status = "&& checkin='1'";
 }
 elseif($checkin==2) {
    $checkin_status = "&& checkin='0'";
 }
 else{
    $checkin_status = "";
 }
    
 if(!$userID) {
     return false;
 }

 if(is1on1($cupID)) { 
    $pp=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE cupID='$cupID' AND clanID='$userID' AND 1on1='1' $checkin_status")); 
 
          if($userID==$pp['clanID'] && $userID!=0 && $pp['clanID']!=0) 
             return true;
          else
             return false; 
 
 }else{

  $query = safe_query("SELECT clanID FROM ".PREFIX."cup_clan_members WHERE userID='$userID'");
    if(!mysql_num_rows($query)) false;
      while($ds=mysql_fetch_array($query)) {
      
          $pp=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE cupID='$cupID' AND clanID='".$ds['clanID']."' AND 1on1='0' $checkin_status"));
          
          if(memin($userID,$pp['clanID']) && $userID!=0 && $pp['clanID']!=0) 
             $var = 1;
          else
             $var = 0;
        }
    return ($var==1 ? true : false);
   }
}

function ismatchparticipant($userID,$matchID,$all) {

  $ds=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchID='$matchID'"));
  $type=($ds['type']=='cup' || ($ds['type']=='gs' && $ds['cupID'] && $ds['ladID']==0) ? "is1on1" : "ladderis1on1"); 
    
       if($type(getleagueID($matchID))) {  
     
	   if(($userID==$ds['clan1'] || $userID==$ds['clan2']) && $userID!=0) {
	      return true;
	   } 
	   else
	   {
	      return false;
	   }	      
     }
     else{    
	 
       $mem_type = ($all ? "memin" : "isleader");
	      
	   if(($mem_type($userID,$ds['clan1']) || $mem_type($userID,$ds['clan2'])) && $userID!=0){
	      return true;
	   } 
	   else{
	      return false;
	   }
    }
}

function isgroupparticipant($userID,$ID) {

 $type=(isset($_GET['laddID']) ? "cupID='0'" : "ladID='0'");
 
 if((isset($_GET['cupID']) && is1on1($ID)) || (isset($_GET['laddID']) && ladderis1on1($ID))) { 
 
   $pp=mysql_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE groupID='$ID' AND clanID='$userID' AND 1on1='1' AND $type AND type='gs'"));

          if($userID==$pp['clanID'] && $userID!=0 && $pp['clanID']!=0) 
             return true;
          else
             return false;

 } else {
 
  $query = safe_query("SELECT clanID FROM ".PREFIX."cup_clan_members WHERE userID='$userID'");
    if(!mysql_num_rows($query)) false;
      while($ds=mysql_fetch_array($query)) {
      
          $pp=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE groupID='$ID' AND clanID='".$ds['clanID']."' AND 1on1='0' AND $type AND type='gs'"));
		  
          if(isleader($userID,$pp['clanID']) && $userID!=0 && $pp['clanID']!=0) 
             $var = 1;
          else
             $var = 0;
        }
    return ($var==1 ? true : false);   
    }
}

function isgroupparticipant2($userID,$ID,$var) {

 $type = ($var=='ladder' ? "cupID='0'" : "ladID='0'");
 
 if((isset($_GET['cupID']) && is1on1($ID)) || (isset($_GET['laddID']) && ladderis1on1($ID))) { 
 
   $pp=mysql_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE groupID='$ID' AND clanID='$userID' AND 1on1='1' AND $type AND type='gs'"));

          if($userID==$pp['clanID'] && $userID!=0 && $pp['clanID']!=0) 
             return true;
          else
             return false;

 } else {

  $query = safe_query("SELECT clanID FROM ".PREFIX."cup_clan_members WHERE userID='$userID'");
    if(!mysql_num_rows($query)) false;
      while($ds=mysql_fetch_array($query)) {
      
          $pp=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE groupID='$ID' AND clanID='".$ds['clanID']."' AND 1on1='0' AND $type AND type='gs'"));
          
          if(isleader($userID,$pp['clanID']) && $userID!=0 && $pp['clanID']!=0) 
             $var = 1;
          else
             $var = 0;
        }
    return ($var==1 ? true : false);  
    }
}

function isgroupparticipant3($userID,$ID,$var) {

 $type = ($var=='ladder' ? "cupID='0'" : "ladID='0'");
 
 if(($var=='cup' && is1on1($ID)) || ($var=='ladder' && ladderis1on1($ID))) { 
 
   $pp=mysql_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE groupID='$ID' AND clanID='$userID' AND 1on1='1' AND $type AND type='gs'"));

          if($userID==$pp['clanID'] && $userID!=0 && $pp['clanID']!=0) 
             return true;
          else
             return false;

 } else {

  $query = safe_query("SELECT clanID FROM ".PREFIX."cup_clan_members WHERE userID='$userID'");
    if(!mysql_num_rows($query)) false;
      while($ds=mysql_fetch_array($query)) {
      
          $pp=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE groupID='$ID' AND clanID='".$ds['clanID']."' AND 1on1='0' AND $type AND type='gs'"));
          
          if(isleader($userID,$pp['clanID']) && $userID!=0 && $pp['clanID']!=0) 
             $var = 1;
          else
             $var = 0;
        }
    return ($var==1 ? true : false);  
    }
}

function returnGroup($userID,$ID) {

 $type= (isset($_GET['laddID']) ? "cupID='0'" : "ladID='0'");
 $type2=(isset($_GET['laddID']) ? "ladID" : "cupID");
 $type_opp = (isset($_GET['laddID']) ? "cupID" : "ladID");

 if((isset($_GET['cupID']) && is1on1($ID)) || (isset($_GET['laddID']) && ladderis1on1($ID))) { 
 
   $pp=mysql_fetch_array(safe_query("SELECT $type2 FROM ".PREFIX."cup_clans WHERE groupID='$ID' AND clanID='$userID' AND 1on1='1' AND $type_opp = '0' AND type='gs'"));
   return $pp[$type2];

 } else { 

  $query = safe_query("SELECT clanID FROM ".PREFIX."cup_clan_members WHERE userID='$userID'");
    if(!mysql_num_rows($query)) return false;
      while($ds=mysql_fetch_array($query)) {
      
          $pp=mysql_fetch_array(safe_query("SELECT $type2 FROM ".PREFIX."cup_clans WHERE groupID='$ID' AND clanID='".$ds['clanID']."' AND 1on1='0' AND $type_opp = '0' AND type='gs'"));
          return $pp[$type2];
        }    
    }
}

function average_points($ID) {

 if($_GET['laddID']) {
        $type = "ladID"; 
        $ds=mysql_fetch_array(safe_query("SELECT d_xp FROM ".PREFIX."cup_ladders WHERE ID='$lD'"));
	    $type_opp = "cupID";
 }
 else{
        $type = "cupID";
        $ds=mysql_fetch_array(safe_query("SELECT d_xp FROM ".PREFIX."cups WHERE ID='$ID'"));
	    $type_opp = "ladID";
 }

 $alpha_groups = "type='gs'";

      $participants = safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE groupID='$ID' && $type_opp='0' AND type='gs'");
        while($gap=mysql_fetch_array($participants)) {
        
		  $group_a_rows = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchno='".$ID."' AND ($alpha_groups) AND (clan1='".$gap['clanID']."' || clan2='".$gap['clanID']."') AND confirmscore='1' AND einspruch='0'");
		  $gam = mysql_fetch_array($group_a_rows); 

		if($gap['clanID']==$gam['clan1']) {
		   $score1 = "score1";
		   $score2 = "score2";
		}
		else{
		   $score1 = "score2";
		   $score2 = "score1";
		}
	    	
     $xp_type = ($ds['d_xp'] ? "AND $score1 > $score2" : "");
		
  $query = safe_query("SELECT SUM($score1) as points FROM ".PREFIX."cup_matches WHERE matchno='".$ID."' $xp_type AND ($alpha_groups) AND (clan1='".$gap['clanID']."' || clan2='".$gap['clanID']."') AND confirmscore='1' AND einspruch='0'");
    while( $row = mysql_fetch_assoc($query) ) {
       $array[] = $row['points'];   
    }
  }    return round(array_sum($array)/count($array));
}

function average_cup_points($ID) {
      $participants = safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE cupID='$ID'");
        while($gap=mysql_fetch_array($participants)) {
        
		  $matches = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE cupID='".$ID."' AND (clan1='".$gap['clanID']."' || clan2='".$gap['clanID']."') AND confirmscore='1' AND einspruch='0'");
		  $mm = mysql_fetch_array($matches); 

		if($gap['clanID']==$mm['clan1']) {
		   $score1 = "score1";
		   $score2 = "score2";
		}else{
		   $score1 = "score2";
		   $score2 = "score1";
		}
		
  $query = safe_query("SELECT SUM($score1) as points FROM ".PREFIX."cup_matches WHERE cupID='".$ID."' AND (clan1='".$gap['clanID']."' || clan2='".$gap['clanID']."') AND confirmscore='1' AND einspruch='0'");
    while( $row = mysql_fetch_assoc($query)) {
       $array[] = $row['points'];   
    }
  }    return round(array_sum($array)/count($array));
}

function user_cup_points($clanID,$ID,$team,$won,$lost,$type,$league) {

  $one=($team ? "1on1='0'" : "1on1='1'");
  $type_opp = (isset($_GET['cupID']) ? 'ladID' : 'cupID');

   switch($league) {
       case "gs":     $is_cup = "matchno='$ID' && type='gs' && $type_opp='0' &&";
       break;
       case "cup":    $is_cup = "cupID='$ID' && type='cup' &&";
       break;
       case "ladder": $is_cup = "ladID='$ID' && type='ladder' &&";
       break;      
   }        
   switch($type) {
      case "confirmed":    $m_type = "confirmscore='1' && einspruch='0' &&"; $count = 1;
      break;
      case "confirmed_p":  $m_type = "confirmscore='1' && einspruch='0' &&"; $count = 0;
      break;
      case "protest":      $m_type = "einspruch='1' &&"; $count = 1;
      break;
      case "pending":      $m_type = "score1='0' && score2='0' &&"; $count = 1;
      break;
      case "open":         $m_type = "confirmscore='0' && inscribed!='0' &&"; $count = 1;
      break;
   }
   if(empty($clanID)) {
      return false; 
	  break;
   }
   if(empty($type)){
      $m_type = false;
      $count = 1;
   }
   if(empty($league)) {
      $is_cup = '';
   }
   
     $win =($won && !$lost ? "((score1 > score2 AND clan1 = '$clanID') || (score1 < score2 AND clan2 = '$clanID'))" : "");
     $loss=($lost && !$won ? "((score1 < score2 AND clan1 = '$clanID') || (score1 > score2 AND clan2 = '$clanID'))" : "");
	 $draw=($lost && $won  ? "((score1 = score2 AND clan1 = '$clanID') || (score1 = score2 AND clan2 = '$clanID'))" : "");

     if(empty($win) && empty($loss) && empty($draw)) {
        $win = "(clan1='$clanID' || clan2='$clanID')";
	    $loss = "";
     }
	 
  $query = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE $is_cup $win $draw $loss && (clan1!='0' && clan2!='0') && (clan1!='2147483647' OR clan2!='2147483647') && $m_type $one"); 
    $num_rows = mysql_num_rows($query);
      $points = 0;
        while( $row = mysql_fetch_assoc($query)) {
           
	   $rows[] = $num_rows;
	   
	     if($won) {

	       if($clanID==$row['clan1'] && $row['score1'] > $row['score2']) {	   
	          $points += $row['score1'];
           }	      
	       if($clanID==$row['clan2'] && $row['score1'] < $row['score2']) {	   
	          $points += $row['score2'];
           }
	    }
	    elseif($loss) {
		
	       if($clanID==$row['clan1'] && $row['score1'] < $row['score2']) {	   
	          $points += $row['score2'];	      
           }	      
	       if($clanID==$row['clan2'] && $row['score1'] > $row['score2']) {	   
	          $points += $row['score1'];
           }
	    }
	    else{
		   
	       if($clanID==$row['clan1'] && $row['score1'] > $row['score2']) {	   
	          $points += $row['score1'];
           }	      
	       if($clanID==$row['clan2'] && $row['score1'] < $row['score2']) {	   
	          $points += $row['score2'];
           }  
	       if($clanID==$row['clan1'] && $row['score1'] < $row['score2']) {	   
	          $points += $row['score2'];	      
           }	      
	       if($clanID==$row['clan2'] && $row['score1'] > $row['score2']) {	   
	          $points += $row['score1'];
           }
	       if($clanID==$row['clan1'] && $row['score1'] == $row['score2']) {	   
	          $points += $row['score1'];	      
           }	      
	       if($clanID==$row['clan2'] && $row['score1'] == $row['score2']) {	   
	          $points += $row['score2'];
           }	    
	    }
    }   	
    if($count) {
       return (empty($rows) ? "0" : max($rows));
    }
    else{
       return (empty($points) ? "0" : $points);
    } 
}    

function getactualcredits($teamID,$laddID,$type) {

  substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php" ? include("config.php") : include("../config.php");
  
  $team = (ladderis1on1($laddID) ? 0 : 1); 
  
  $matcheslost = user_cup_points($teamID,$laddID,$team,$won=0,$lost=1,"confirmed","ladder");
  $matcheswon = user_cup_points($teamID,$laddID,$team,$won=1,$lost=0,"confirmed","ladder");
  $matchesdraw = user_cup_points($teamID,$laddID,$team,$won=1,$lost=1,"confirmed","ladder");
  
  $ds1=mysql_fetch_array(safe_query("SELECT sum(deducted) as deductioncred FROM ".PREFIX."cup_deduction WHERE clanID='$teamID' && ladID='$laddID'"));
  $lad=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_ladders WHERE ID='$laddID'"));
  
  $ml = $matcheslost * $lostcredit;
  $mw = $matcheswon * $woncredit;
  $md = $matchesdraw * $drawcredit;
  $dc = $ds1['deductioncred'] * $lad['deduct_credits'];
  $fc = getactualcredits_forfeits($teamID,$laddID);
  
  $matches_won  = (empty($mw) ? 0 : $mw);
  $matches_lost = (empty($ml) ? 0 : $ml);
  $matches_draw = (empty($md) ? 0 : $md);
  $deduc_credit = (empty($dc) ? 0 : $dc);
  $forfe_credit = (empty($fc) ? 0 : $fc);
  
  $mt = ($matches_won - $matches_lost + $matches_draw);
  $matches_total = (empty($mt) ? 0 : $mt);
  
  if($type=="deduction") {
     $total_creds = $deduc_credit;
  }
  elseif($type=="forfeit") {
     $total_creds = $forfe_credit;
  }
  elseif($type=="matches") {
     $total_creds = $matches_total;
  }
  else{
     $total_creds = ($startupcredit + $matches_total - $deduc_credit + $forfe_credit);
  }
  return (empty($total_creds) ? 0 : $total_creds);
}

function getactualcredits_forfeits($teamID,$laddID) {
	
  substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php" ? include("config.php") : include("../config.php");
  
    $getchallenges = safe_query("SELECT * FROM ".PREFIX."cup_challenges WHERE ladID='$laddID' && (challenger='$teamID' OR challenged='$teamID')");
      while($ds=mysql_fetch_assoc($getchallenges)) 
      {
	  
	    $rgac = mysql_num_rows($getchallenges);
	
	    if($teamID && $teamID!=$ds['challenged'])
	    continue;
	  
	      if($ds['forfeit']==$ds['challenger']) { 
		     $rgac1 = mysql_fetch_array(safe_query("SELECT count(*) as rows FROM ".PREFIX."cup_challenges WHERE chalID='".$ds['chalID']."'"));
		     $change1 = $rgac1['rows'] * $forfeitaward;
			 
	      }
		  elseif($ds['forfeit']==$ds['challenged']) {
		     $rgac2 = mysql_fetch_array(safe_query("SELECT count(*) as rows FROM ".PREFIX."cup_challenges WHERE chalID='".$ds['chalID']."'"));
		     $change2 = $rgac2['rows'] * $forfeitloss;
	   	  }
		  else{
		     $change1 = '';
			 $change2 = '';
		  }
		  $calc_change1 = (empty($change1) ? 0 : $change1);
		  $calc_change2 = (empty($change2) ? 0 : $change2);
		  
		  $change[] = $calc_change1 - $calc_change2;
	  }
	  
    $getchallenges = safe_query("SELECT * FROM ".PREFIX."cup_challenges WHERE ladID='$laddID' && (challenger='$teamID' OR challenged='$teamID')");
      while($ds=mysql_fetch_assoc($getchallenges)) 
      {

	    if($teamID && $teamID!=$ds['challenger'])
	    continue;
	  	  
	      if($ds['forfeit']==$ds['challenger']) {
		     $rgac3 = mysql_fetch_array(safe_query("SELECT count(*) as rows FROM ".PREFIX."cup_challenges WHERE chalID='".$ds['chalID']."'"));
		     $change3 = $rgac3['rows'] * $forfeitloss;
	      }
		  elseif($ds['forfeit']==$ds['challenged']) {
		     $rgac4 = mysql_fetch_array(safe_query("SELECT count(*) as rows FROM ".PREFIX."cup_challenges WHERE chalID='".$ds['chalID']."'"));
		     $change4 = $rgac4['rows'] * $forfeitaward; 
	   	  }
		  else{
		     $change4 = '';
			 $change3 = '';
		  }
		  
		  $calc_change3 = (empty($change3) ? 0 : $change3);
		  $calc_change4 = (empty($change4) ? 0 : $change4);
		  
		  $change[] = $calc_change4 - $calc_change3;
	 }
	 return array_sum($change);
}

function ladder_ranksys($laddID) {

$lad=mysql_fetch_array(safe_query("SELECT ranksys FROM ".PREFIX."cup_ladders WHERE ID='$laddID'"));

 switch($lad['ranksys']) {
  case 1 :
     return "credit";
     break;	 
  case 2 :
     return "xp";
     break;	 
  case 3 :
     return "won";
     break;	 
  case 4 :
     return "tp";
     break;	 
  case 5 :
     return "wc";
     break;	 
  case 6 :
     return "streak";
	 break;
  case 7 :
     return "elo";
	 break; 
 }	 
}   

function ladder_points($laddID,$avg=0) {

 $ranksys = ladder_ranksys($laddID);
		
  $query = safe_query("SELECT $ranksys FROM ".PREFIX."cup_clans WHERE ladID='".$laddID."'");
    while( $row = mysql_fetch_assoc($query)) {
       $array[] = $row[$ranksys];   
    
  }    return ($avg ? round(array_sum($array)/count($array)) : descOrder($array));
}

function departmentname($ID) {
	$ds = mysql_fetch_array(safe_query("SELECT department FROM ".PREFIX."cup_departments WHERE ID='$ID'"));
	return ($ds['department'] ? $ds['department'] : 'Match Protest');
}

function descOrder($array=array(0, "No para input was made in function order")) {
    $count = count($array);
      for ($i=0; $i<$count; $i++) {
      $la = array_search(max ($array), $array);
      $order[] = $array[$la];
      array_splice($array, $la, 1);
    }
  return $order;
}

function ascendOrder($array=array(0, "No para input was made in function order")) {
    $count = count($array);
      for ($i=0; $i<$count; $i++) {
      $la = array_search(min($array), $array);
      $order[] = $array[$la];
      array_splice($array, $la, 1);
    }
  return $order;
}

function is_qualified($ID,$arr) {

    if(isset($_GET['laddID'])) { 
		$type_opp = "cupID";
        $ds=mysql_fetch_array(safe_query("SELECT d_xp, 1on1 FROM ".PREFIX."cup_ladders WHERE ID='$ID'")); 
        $t_dxp = "d_xp";
    }
    else{
		$type_opp = "ladID";
        $ds=mysql_fetch_array(safe_query("SELECT gs_dxp, 1on1 FROM ".PREFIX."cups WHERE ID='$ID'"));
        $t_dxp = "gs_dxp";
    }
	
	$ucp_team = ($ds['1on1']==1 ? 0 : 1);

      $participants = mysql_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE groupID='$ID' && $type_opp='0' && type='gs'");
        while($gap=mysql_fetch_array($participants)) {
        
			if(!$ds[$t_dxp]) {
				$p_array[] = user_cup_points($gap['clanID'],$ID,$ucp_team,0,0,'confirmed_p','gs');
		    }
			else{
				$p_array[] = user_cup_points($gap['clanID'],$ID,$ucp_team,1,0,'confirmed_p','gs');
			}		
		}

    $order = descOrder($p_array);
    $count = count($order);
  
    for ($i=0; $i<$count; $i++) {
      $a=1;   
      for ($i=0; $i<$count; $i++) {

      if ($order[$i+$a]==$order[$i]) {
          $duplicates[] = $order[$i];
          }
      }
      $a++;
    }

    $duplicates = array_unique($duplicates);
    $print_limit = ceil(($count/2));
    $n = 1;
    
    for ($i=0; $i<$count; $i++) {
      $n++;
    }
  
    if ($order[$print_limit] == $order[($print_limit-1)]) {
      $elim = $order[$print_limit];
    }
    
    for ($i=0; $i<$count; $i++) {
      if ($order[$i] == $elim){
      break;
    }elseif ($i == $print_limit) {
      break;
    }
      $array1[] = $order[$i];
    }
    
    foreach ($order as $val) {
      if ($val == $elim) {
      $array2[] = $val;
    }
    
  }   return ($arr ? $array1 : $array2);   
         
}

function pageURL() {
  return $_SERVER['QUERY_STRING'];
}

function platform_enabled($laddID) {   
   $ds=mysql_fetch_array(safe_query("SELECT platID FROM ".PREFIX."cup_ladders WHERE ID='$laddID'"));
   $st=mysql_fetch_array(safe_query("SELECT status FROM ".PREFIX."cup_platforms WHERE ID='".$ds['platID']."'"));

     if($st['status']) {
        return "true";
    }
}

function ticket_status($tickID) {
substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php" ? include("config.php") : include("../config.php");
  $ds=mysql_fetch_array(safe_query("SELECT status FROM ".PREFIX."cup_tickets WHERE ticketID='$tickID'"));
  
  switch($ds['status']) {
     
     case 1: return $status_unreviewed_nc;
     break;
     case 2: return $status_pending_nc;
     break;
     case 3: return $status_onhold_nc;
     break;
     case 4: return $status_waiting_nc;
     break;
     case 5: return $status_resolved_nc;
     break;
     case 6: return $status_custom1_nc;
     break;
     case 7: return $status_custom2_nc;
     break;
  
  }

}

function getleagueID($matchID) {

  $ds=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchID='$matchID'"));
     $array = array ('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','a2','b2','c2','d2','e2','f2');

     if(in_array($ds['cupID'],$array) || in_array($ds['ladID'],$array))
        return $ds['matchno'];
     elseif($ds['cupID'])
        return $ds['cupID'];
     elseif($ds['ladID'])
        return $ds['ladID'];
} 

function getleagueType($matchID) {

  $ds=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchID='$matchID'"));
     $array = array ('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','a2','b2','c2','d2','e2','f2');

     if(in_array($ds['cupID'],$array) || in_array($ds['ladID'],$array))
        return "matchno";
     elseif($ds['cupID'])
        return "cupID";
     elseif($ds['ladID'])
        return "ladID";
}

function league($matchID) {

  $ds=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchID='$matchID'"));
     $array = array ('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','a2','b2','c2','d2','e2','f2');
     
     if(in_array($ds['cupID'],$array))
     { 
        return "cup";   
     }
     elseif(in_array($ds['ladID'],$array))   
     {
        return "ladder";  
     } 
     elseif($ds['cupID'])
     {
        return "cup";
     }   
     elseif($ds['ladID'])
     {
        return "ladder";
     }
}

function match_query_type() {

//remove group participants if match non-exist
 
    $ID = (isset($_GET['cupID']) ? mysql_real_escape_string($_GET['cupID']) : mysql_real_escape_string(isset($_GET['laddID'])));
    $type_opp = (isset($_GET['cupID']) ? 'ladID' : 'cupID');

    $participants = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE groupID='$ID' && type='gs' && $type_opp='0'"); 
        while($dd=mysql_fetch_array($participants)) {

	    $matches = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchno='$ID' && type='gs' && $type_opp='0' && (clan1='".$dd['clanID']."' || clan2='".$dd['clanID']."')");
	
	    if(!mysql_num_rows($matches)) {
	        safe_query("DELETE FROM ".PREFIX."cup_clans WHERE groupID='$ID' && type='gs' && $type_opp='0' && clanID='".$dd['clanID']."'");
	    }
    }
	
//delete duplicated tournament matches

$query = safe_query("SELECT matchID, cupID, matchno FROM ".PREFIX."cup_matches GROUP BY cupID, matchno HAVING COUNT( 1 ) >1");
   while($ds=mysql_fetch_array($query)) {
   
      $qry2 = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE cupID='".$ds['cupID']."' && matchno='".$ds['matchno']."' && type='cup' LIMIT 1,2147483647");
	     while($ds2=mysql_fetch_array($qry2)) {
		    safe_query("DELETE FROM ".PREFIX."cup_matches WHERE matchID='".$ds2['matchID']."' && type='cup'");
		 }
   }
	
//status

  $ladders_q = safe_query("SELECT * FROM ".PREFIX."cup_ladders");
    while($lq=mysql_fetch_array($ladders_q)) {
  
      //close ladders
  
      if(time() >= $lq['end'] && $lq['status']!=3) {
         safe_query("UPDATE ".PREFIX."cup_ladders SET status='3' WHERE ID='".$lq['ID']."'");
      }
      
      //start ladders
      
      if(time() >= $lq['start'] && time() <= $lq['end'] && $lq['status']!=2) {
         safe_query("UPDATE ".PREFIX."cup_ladders SET status='2' WHERE ID='".$lq['ID']."'");
      }
	  
  }

//close cups after finish

  $cups_q = safe_query("SELECT * FROM ".PREFIX."cups");
    while($cq=mysql_fetch_array($cups_q)) {
	
      $wi=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_baum WHERE cupID='".$cq['ID']."'")); 
      $lm=mysql_fetch_array(safe_query("SELECT confirmed_date FROM ".PREFIX."cup_matches WHERE cupID='".$cq['ID']."' && type='cup' ORDER BY confirmed_date DESC LIMIT 0,1"));
   
      $end_time = (is_array($lm) ? $lm['confirmed_date'] : time());
	  //&& (($cq['ende'] > time()) || ($lm['confirmed_date'] && $cq['ende']!=$end_time))
	  
      if($wi['wb_winner'] && $wi['third_winner'] && $wi['second_winner'] && $lm['confirmed_date']) { 
         safe_query("UPDATE ".PREFIX."cups SET ende='$end_time', status='3' WHERE ID='".$cq['ID']."'");
      }
	  else{
         //start cups when start time is met
         safe_query("UPDATE ".PREFIX."cups SET status='2' WHERE start<='".time()."' && ID='".$cq['ID']."'");
	  }
  }
  
//set points expiry when expired time is met

safe_query("UPDATE ".PREFIX."cup_warnings SET expired='1' WHERE deltime<='".time()."'");
  
//set league type at clans table - check unchecked participants if checkin is disabled

  $now_cked_conf = "";

  $clans = safe_query("SELECT * FROM ".PREFIX."cup_clans");
    while($dp=mysql_fetch_array($clans)) 
    {   
	
	  // platform sync
	  
	  $cup_platID = $dp['type']=='cup' ? getplatID_cup($dp['cupID']) : false;
	  $lad_platID = $dp['type']=='ladder' ? getplatID($dp['ladID']) : false;
	  
	  if($dp['platID'] != $cup_platID AND $dp['type']=='cup') {
	      safe_query("UPDATE ".PREFIX."cup_clans SET platID='$cup_platID' WHERE ID='".$dp['ID']."'");
	  }
	  
	  if($dp['platID'] != $lad_platID AND $dp['type']=='ladder') {
	      safe_query("UPDATE ".PREFIX."cup_clans SET platID='$lad_platID' WHERE ID='".$dp['ID']."'");
	  }
	  
	  // game sync
	  
	  $cup_game = $dp['type']=='cup' ? get_gametag_cup($dp['cupID']) : false;
	  $lad_game = $dp['type']=='ladder' ? get_gametag_lad($dp['ladID']) : false; 
	  
	  if($dp['game'] != $cup_game AND $dp['type']=='cup') {
	      safe_query("UPDATE ".PREFIX."cup_clans SET game='$cup_game' WHERE ID='".$dp['ID']."'");
	  }
	  
	  if($dp['game'] != $lad_game AND $dp['type']=='ladder') {
	      safe_query("UPDATE ".PREFIX."cup_clans SET game='$lad_game' WHERE ID='".$dp['ID']."'");
	  }
	  
	  // 1on1 sync
	  
	  if($dp['1on1']==0 AND is1on1($dp['cupID']) AND $dp['type']=='cup') {
	      safe_query("UPDATE ".PREFIX."cup_clans SET 1on1='1' WHERE ID='".$dp['ID']."'");
	  }
	  
	  if($dp['1on1']==1 AND !is1on1($dp['cupID']) AND $dp['type']=='cup') {
	      safe_query("UPDATE ".PREFIX."cup_clans SET 1on1='0' WHERE ID='".$dp['ID']."'");
	  }
	  
	  if($dp['1on1']==0 AND ladderis1on1($dp['ladID']) AND $dp['type']=='ladder') {
	      safe_query("UPDATE ".PREFIX."cup_clans SET 1on1='1' WHERE ID='".$dp['ID']."'");
	  }
	  
	  if($dp['1on1']==1 AND !ladderis1on1($dp['ladID']) AND $dp['type']=='ladder') {
	      safe_query("UPDATE ".PREFIX."cup_clans SET 1on1='0' WHERE ID='".$dp['ID']."'");
	  }
	  
	  //check unchecked participants if checkin is disabled
	
	  $CD=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cups WHERE ID='".$dp['cupID']."' && discheck='1' && status='1'"));
	  
	  $take_to_lineup = ($CD['discheck']==1 && $CD['1on1']==0 ? 1 : 0);
	  
	  if($dp['checkin']==0 && $CD['discheck']==1) {
	  
	     $now_cked_conf = "<font color='red'><strong>Automatic checkin confirmed.</strong></font><br /><br />";
	     safe_query("UPDATE ".PREFIX."cup_clans SET checkin='1' WHERE checkin='0' && cupID='".$dp['cupID']."'");
		 
		 if($take_to_lineup==1) redirect('?site=clans&action=lineup&cupID='.$dp['cupID'].'&type=auto_check', '<font color="red"><strong>Redirecting to lineup...</strong></font>', 3);
	  }
	  //set league type at clans table
   
      $alpha_array = array ('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','a2','b2','c2','d2','e2','f2');

      if(((in_array($dp['ladID'],$alpha_array)) || (in_array($dp['cupID'],$alpha_array))) && ($dp['type']!='gs' && $dp['groupID']!=0)) {
      
         $type = (in_array($dp['ladID'],$alpha_array) ? 'ladID' : 'cupID');
         $alpha_groups = "$type='a' || $type='b' || $type='c' || $type='d' || $type='e' || $type='f' || $type='g' || $type='h' || $type='i' || $type='j' || $type='k' || $type='l' || $type='m' || $type='n' || $type='o' || $type='p' || $type='q' || $type='r' || $type='s' || $type='t' || $type='u' || $type='v' || $type='w' || $type='x' || $type='y' || $type='z' || $type='a2' || $type='b2' || $type='c2' || $type='d2' || $type='e2' || $type='f2'";
         safe_query("UPDATE ".PREFIX."cup_clans SET type='gs' WHERE $alpha_groups");
      }
      elseif($dp['ladID'] && !in_array($dp['ladID'],$alpha_array) && $dp['groupID']==0 && $dp['cupID']==0 && $dp['type']!='ladder') {
      
         safe_query("UPDATE ".PREFIX."cup_clans SET type='ladder' WHERE ladID='".$dp['ladID']."'");
      }
      elseif($dp['cupID'] && !in_array($dp['cupID'],$alpha_array) && $dp['groupID']==0 && $dp['ladID']==0 && $dp['type']!='cup') {
      
         safe_query("UPDATE ".PREFIX."cup_clans SET type='cup' WHERE cupID='".$dp['cupID']."'");
      }
  }
  
  echo $now_cked_conf;
  
//set whether 1on1 at challenges table

  $challenges = safe_query("SELECT * FROM ".PREFIX."cup_challenges");
    while($db=mysql_fetch_array($challenges)) 
    {   
      if(ladderis1on1($db['ladID']) && $db['1on1']==0)
      { 
         safe_query("UPDATE ".PREFIX."cup_challenges SET 1on1 ='1' WHERE ladID='".$db['ladID']."'");
      }
      elseif(!ladderis1on1($db['ladID']) && $db['1on1']==1)
      {
         safe_query("UPDATE ".PREFIX."cup_challenges SET 1on1 ='0' WHERE ladID='".$db['ladID']."'");
      }
  }
  
//matches db cleanup
  
      safe_query("UPDATE ".PREFIX."cup_clans SET cupID='0' WHERE cupID=''");
	  safe_query("UPDATE ".PREFIX."cup_clans SET ladID='0' WHERE ladID=''");
	  safe_query("UPDATE ".PREFIX."cup_matches SET cupID='0' WHERE cupID=''");
	  safe_query("UPDATE ".PREFIX."cup_matches SET ladID='0' WHERE ladID=''");
	  safe_query("DELETE FROM ".PREFIX."cup_matches WHERE ladID='0' AND cupID='0'");
	  safe_query("DELETE FROM ".PREFIX."cup_clans WHERE ladID='0' AND cupID='0'");
    
//set league type and whether 1on1 at matches table

  $matches = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE cupID!='0' || ladID!='0'");
    while($ds=mysql_fetch_array($matches)) {
    
      $matchID = $ds['matchID'];
      $ID = $ds['cupID'] ? 'cupID' : 'ladID';
      $type = league($ds['matchID'])=='ladder' ? 'ladderis1on1' : 'is1on1';
      
      $date_con =  date('d.m.Y', $ds['date']); 
	  
	  // platform sync
	  
	  $cup_platID = $ds['type']=='cup' ? getplatID_cup($ds['cupID']) : false;
	  $lad_platID = $ds['type']=='ladder' ? getplatID($ds['ladID']) : false;
	  
	  if($ds['platID'] != $cup_platID && $ds['type']=='cup') {
	      safe_query("UPDATE ".PREFIX."cup_matches SET platID='$cup_platID' WHERE matchID='$matchID'");
	  }
	  
	  if($ds['platID'] != $lad_platID && $ds['type']=='ladder') {
	      safe_query("UPDATE ".PREFIX."cup_matches SET platID='$lad_platID' WHERE matchID='$matchID'");
	  }
	  
	  // end platform sync
      
      if(empty($ds['date2'])) {
            safe_query("UPDATE ".PREFIX."cup_matches SET date2='$date_con' WHERE matchID='$matchID'");
      }
	  
      if(empty($ds['type'])) {         
        if(getleagueType($matchID)=="matchno")
        {
            safe_query("UPDATE ".PREFIX."cup_matches SET type='gs' WHERE matchID='$matchID'");
        }    
        elseif(getleagueType($matchID)=="cupID")
        {
            safe_query("UPDATE ".PREFIX."cup_matches SET type='cup' WHERE matchID='$matchID'");
        }
        elseif(getleagueType($matchID)=="ladID")
        {
            safe_query("UPDATE ".PREFIX."cup_matches SET type='ladder' WHERE matchID='$matchID'");
        }
      }   

      if($ds['type']=='gs')
      {
          if($type($ds['matchno']) && $ds['1on1']==0 && league($ds['matchID'])=='cup')
          {  
             safe_query("UPDATE ".PREFIX."cup_matches SET 1on1='1' WHERE matchno='".$ds['matchno']."'");
          }
          if($type($ds['matchno']) && $ds['1on1']==0 && league($ds['matchID'])=='ladder')
          {  
             safe_query("UPDATE ".PREFIX."cup_matches SET 1on1='1' WHERE matchno='".$ds['matchno']."'");
          }
          if(!$type($ds['matchno']) && $ds['1on1']==1 && league($ds['matchID'])=='cup')
          {  
             safe_query("UPDATE ".PREFIX."cup_matches SET 1on1='0' WHERE matchno='".$ds['matchno']."'");
          }
          if(!$type($ds['matchno']) && $ds['1on1']==1 && league($ds['matchID'])=='ladder')
          {  
             safe_query("UPDATE ".PREFIX."cup_matches SET 1on1='0' WHERE matchno='".$ds['matchno']."'");
        }
      }
      else
      {      
        if($type($ds[$ID]))
        { 
          if($ds['1on1']==0)      
          {  
             safe_query("UPDATE ".PREFIX."cup_matches SET 1on1='1' WHERE $ID='".$ds[$ID]."'");
          }
        }
        elseif(!$type($ds[$ID]))
        {
          if($ds['1on1']==1) 
          {
            safe_query("UPDATE ".PREFIX."cup_matches SET 1on1='0' WHERE $ID='".$ds[$ID]."'");
        }
      }     
    }
  }
	  // delete match if both clans are non-exist
	      safe_query("DELETE FROM ".PREFIX."cup_matches WHERE (clan1='' OR clan1='0') && (clan2='' OR clan2='0')");
}

function cuptype($matchID) {

  $ds=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchID='$matchID'"));
  return ($ds['cupID'] ? "is1on1" : "ladderis1on1");
  
}

function matchlink($matchID,$ac,$tg,$redirect) {

  $ds=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchID='$matchID'"));
     $array = array ('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','a2','b2','c2','d2','e2','f2');
     
  if($redirect) { 
   
     if(in_array($ds['cupID'],$array))
     {
        return '?site=cup_matches&match='.$ds['matchID'].'&cupID='.$ds['matchno'].'&type=gs';
     }   
     elseif(in_array($ds['ladID'],$array))
     { 
        return '?site=cup_matches&match='.$ds['matchID'].'&laddID='.$ds['matchno'].'&type=gs';
     }   
     elseif(!$ds['matchno'] && $ds['cupID'])
     {
        return '?site=cup_matches&matchID='.$ds['matchID'].'&cupID='.$ds['cupID'];
     }
     elseif(!$ds['matchno'] && $ds['ladID'])
     {
        return '?site=cup_matches&matchID='.$ds['matchID'].'&laddID='.$ds['ladID'];
     } 
     elseif(!in_array($ds['cupID'],$array) && $ds['cupID'])
     { 
        return '?site=cup_matches&match='.$ds['matchno'].'&cupID='.$ds['cupID'];        
     } 
     elseif(!in_array($ds['ladID'],$array) && $ds['ladID'])
     {
        return '?site=cup_matches&match='.$ds['matchno'].'&laddID='.$ds['ladID'];
     }
        
   }
  else
 {
  
     $lt = ($ac ? "../" : "");
     $tt = ($tg ? 'target="_blank"' : '');

     if(in_array($ds['cupID'],$array))
     {
        return '"'.$lt.'?site=cup_matches&match='.$ds['matchID'].'&cupID='.$ds['matchno'].'&type=gs" '.$tt;
     }   
     elseif(in_array($ds['ladID'],$array))
     {   
        return '"'.$lt.'?site=cup_matches&match='.$ds['matchID'].'&laddID='.$ds['matchno'].'&type=gs" '.$tt;
     } 
     elseif(!$ds['matchno'] && $ds['cupID'])
     {   
        return '"'.$lt.'?site=cup_matches&matchID='.$ds['matchID'].'&cupID='.$ds['cupID'].'" '.$tt;
     } 
     elseif(!$ds['matchno'] && $ds['ladID'])
     {   
        return '"'.$lt.'?site=cup_matches&matchID='.$ds['matchID'].'&laddID='.$ds['ladID'].'" '.$tt;
     }
     elseif(!in_array($ds['cupID'],$array) && $ds['cupID'])
     {   
        return '"'.$lt.'?site=cup_matches&match='.$ds['matchno'].'&cupID='.$ds['cupID'].'" '.$tt;        
     } 
     elseif(!in_array($ds['ladID'],$array) && $ds['ladID'])
     {   
        return '"'.$lt.'?site=cup_matches&match='.$ds['matchno'].'&laddID='.$ds['ladID'].'" '.$tt;
     }
   }
}        
   
function valid_ticketer($ticketID,$userID) { 

    $ds=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_tickets WHERE ticketID='$ticketID'"));
    $db=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchID='".$ds['matchID']."'"));

      if($userID==$ds['adminID'])
      return true;
           
      elseif(!$ds['matchID'] && $userID==$ds['userID'])
      return true;
  
      elseif($ds['matchID'] && $ds['cupID'] && is1on1($ds['cupID']) && ($userID==$db['clan1'] || $userID==$db['clan2'])) 
      return true;
    
      elseif($ds['matchID'] && $ds['ladID'] && ladderis1on1($ds['ladID']) && ($userID==$db['clan1'] || $userID==$db['clan2'])) 
      return true;
    
      elseif($ds['matchID'] && $ds['cupID'] && !is1on1($ds['cupID']) && (memin($userID,$db['clan1']) || memin($userID,$db['clan2']))) 
      return true;
    
      elseif($ds['matchID'] && $ds['ladID'] && !ladderis1on1($ds['ladID']) && (memin($userID,$db['clan1']) || memin($userID,$db['clan2']))) 
      return true;
      
      else return false;
             
}   
 
function randomize_brackets($cupID) {
 substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php" ? include("config.php") : include("../config.php");
 
  $ds=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cups WHERE ID='$cupID'"));	
  $matches = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE cupID='$cupID'");
  
  if(!mysql_num_rows($matches)) { 
	
	$max = $ds['maxclan'];
	
	if($max==8 || $max==80)
		$max = 8;
	elseif($max==16 || $max==160)
		$max = 16;
	elseif($max==32 || $max==320)
	    $max = 32;
	elseif($max==64 || $max==640)
		$max = 64;
  
	$ergebnis2 = safe_query("SELECT count(*) as anzahl FROM ".PREFIX."cup_clans WHERE cupID='".$cupID."' && checkin='1'");
    $co=mysql_fetch_array($ergebnis2);
    
    $check_qualifiers = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE qual='1' && groupID='$cupID' && ladID='0' AND type='gs'");
    if(mysql_num_rows($check_qualifiers) && $auto_checkin) {
      safe_query("UPDATE ".PREFIX."cup_clans SET checkin='1' WHERE cupID='".$cupID."'");
    }
    
  if(($auto_randomize_brackets == 1 && $ds['start'] >= time() && $co['anzahl'] >= $max) ||
     ($auto_randomize_brackets == 2 && $co['anzahl'] >= $max))  {  
	
  if ($auto_randomize_brackets == 2 && $co['anzahl'] >= $max)
     safe_query("UPDATE ".PREFIX."cups SET start = '".time()."' WHERE ID='$cupID'");      
	
	for($i = 1; $i <= $max; $i++){
		safe_query("DELETE FROM ".PREFIX."cup_matches WHERE cupID='$cupID' && matchno='$i'");
	}
	
	$clans=safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE cupID='$cupID' && checkin='1'");
	while($dv=mysql_fetch_array($clans)) {
		if($n < 1)
			$n=1;
		$clan[$n] = $dv['clanID'];
		$n++;
	}
	$count = count($clan);
	
	while($count < $max){
		$count++;
		$clan[$count] = 2147483647; 
	}
	
	shuffle($clan);	
	
	$i2=0;
	for ($i = 1; $i <= $max; $i++) {
		if($clan[$i2] || $clan[$i2+1])
			safe_query("INSERT INTO ".PREFIX."cup_matches (cupID, ladID, matchno, date, clan1, clan2, score1, score2, server, hltv, report, comment, type) VALUES ('$cupID', '0', '$i', '".time()."', '".$clan[$i2]."', '".$clan[$i2+1]."', '', '', '', '', '', '2', 'cup')");
		$i2 += 2;
   }
  }  
 }
}

function pm_eligibility($ID) {

    substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php" ? include("config.php") : include("../config.php");
	
	if(isset($_GET['cupID'])) {
	    $type = "ladID";
		$type2= "is1on1";
	} else {
	    $type = "cupID";
		$type2= "ladderis1on1";
	}
	
    $check_qualifiers = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE qual='1' && groupID='$ID' && $type='0' && type='gs'");
    $is_qualifiers = mysql_num_rows($check_qualifiers);
    
    $qual = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE groupID='$ID' && $type='0' && qual='1' && pm='0' && type='gs'");
      while($iq = mysql_fetch_assoc($qual)) {
	  
	  	if(!$type2($ID)) {
		    $members = safe_query("SELECT * FROM ".PREFIX."cup_clan_members WHERE clanID='".$iq['clanID']."'");
                while($iu=mysql_fetch_assoc($members)) {
                    $qualified_ID[]=$iu['userID'];
                }				
			
	    } else {
	  
            $qualified_ID[]=$iq['clanID'];
			
		}
		$qual_clanID[]=$iq['clanID'];
    }
    
    $unqual = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE groupID='$ID' && $type='0' && qual='0' && pm='0' && type='gs'");
      while($nq = mysql_fetch_assoc($unqual)) {
	  
	  	if(!$type2($ID)) {
		    $members = safe_query("SELECT * FROM ".PREFIX."cup_clan_members WHERE clanID='".$nq['clanID']."'");
                while($iu=mysql_fetch_assoc($members)) {
                    $unqualified_ID[]=$iu['userID'];
                }				
			
	    } else {
	  
            $unqualified_ID[]=$nq['clanID'];
			
		}
		$unqual_clanID[]=$nq['clanID'];
    }
    
    $fcfs = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE groupID='$ID' && $type='0' && qual='2' && pm='0' && type='gs'");
      while($fc = mysql_fetch_assoc($fcfs)) {
	  
	  	if(!$type2($ID)) {
		    $members = safe_query("SELECT * FROM ".PREFIX."cup_clan_members WHERE clanID='".$fc['clanID']."'");
                while($iu=mysql_fetch_assoc($members)) {
                    $fcfs_ID[]=$iu['userID'];
                }				
			
	    } else {
	  
            $fcfs_ID[]=$fc['clanID'];
			
		}
		$fcfs_clanID[]=$fc['clanID'];
    }

  if($is_qualifiers) {      
      
    foreach($qualified_ID as $v) {
         sendmessage($v, $sm_elig_subject, $sm_qualified);
    }
	foreach($unqualified_ID as $w) {
         sendmessage($w, $sm_elig_subject, $sm_unqualified);
    }
	foreach($fcfs_ID as $x) {
         sendmessage($x, $sm_elig_subject, $sm_fcfs);
    }    
	safe_query("UPDATE ".PREFIX."cup_clans SET pm='1' WHERE groupID='$ID' && $type='0' && type='gs'");     
  }      
}

function reset_actual_standings($laddID,$teamID) {

$chk_team = (ladderis1on1($laddID) ? 0 : 1);
$chk_plr = ($teamID ? "&& clanID='$teamID'" : ""); // if to only reset individual standings of participant

  $query = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='$laddID' && type='ladder' $chk_plr1");
      while($ds=mysql_fetch_array($query)) {
	  
	      $tt_matches = user_cup_points($ds['clanID'],$laddID,$chk_team,0,0,"","ladder");
		  $tt_points = user_cup_points($ds['clanID'],$laddID,$chk_team,0,0,"confirmed_p","ladder");
		  $tt_won = user_cup_points($ds['clanID'],$laddID,$chk_team,1,0,"confirmed","ladder");
		  $tt_lost = user_cup_points($ds['clanID'],$laddID,$chk_team,0,1,"confirmed","ladder");
		  $tt_draw = user_cup_points($ds['clanID'],$laddID,$chk_team,1,1,"confirmed","ladder");
		  $tt_credits = getactualcredits($ds['clanID'],$laddID);
		  $tt_streak = getstreak($ds['clanID'],$laddID);
		  $tt_ranknow = getrank($teamID,$laddID,'now');
		  $tt_rankthen = getrank($teamID,$laddID,'then');
		  
	      if ($ds['ma'] != $tt_matches) {
		     safe_query("UPDATE ".PREFIX."cup_clans SET ma='$tt_matches' WHERE ID='".$ds['ID']."'");
		  }
		  if ($ds['credit'] != $actua_cred) {
		     safe_query("UPDATE ".PREFIX."cup_clans SET credit='$tt_credits' WHERE ID='".$ds['ID']."'");
		  }
		  if( $ds['xp'] != $tt_points) {
		     safe_query("UPDATE ".PREFIX."cup_clans SET xp='$tt_points' WHERE ID='".$ds['ID']."'");
		  }
		  if( $ds['won'] != $tt_won) {
		     safe_query("UPDATE ".PREFIX."cup_clans SET won='$tt_won' WHERE ID='".$ds['ID']."'");
		  }
		  if( $ds['lost'] != $tt_lost) {
		     safe_query("UPDATE ".PREFIX."cup_clans SET lost='$tt_lost' WHERE ID='".$ds['ID']."'");
		  }
		  if( $ds['draw'] != $tt_draw) {
		     safe_query("UPDATE ".PREFIX."cup_clans SET draw='$tt_draw' WHERE ID='".$ds['ID']."'");
		  }
		  if( $ds['streak'] != $tt_streak) {
             safe_query("UPDATE ".PREFIX."cup_clans SET streak = '$tt_streak' WHERE ID='".$ds['ID']."'");	  
		  }
		  if( $ds['rank_now'] != $tt_ranknow) {
             safe_query("UPDATE ".PREFIX."cup_clans SET rank_now = '$tt_ranknow' WHERE ID='".$ds['ID']."'");	  
		  }
		  if( $ds['rank_then'] != $tt_rankthen) {
             safe_query("UPDATE ".PREFIX."cup_clans SET rank_then = '$tt_rankthen' WHERE ID='".$ds['ID']."'");	  
		  }
	  }
}

function check_standings($laddID) {

substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php" ? include("config.php") : include("../config.php");
$cs_one = (ladderis1on1($laddID) ? "&& 1on1='1'" : "&& 1on1='0'");

  $query = safe_query("SELECT * FROM ".PREFIX."cup_deduction WHERE ladID='$laddID'");
      while($ds=mysql_fetch_array($query)) {
           safe_query("DELETE FROM ".PREFIX."cup_deduction WHERE deducted='0'");
    }  

  $query = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='$laddID'");
      while($ds=mysql_fetch_array($query)) {
      
        $tp = $ds['credit']+$ds['xp'];
        $wc = $ds['xp']+$ds['won'];
        
        if($tp != $ds['tp'] || $wc != $ds['wc']) {
           safe_query("UPDATE ".PREFIX."cup_clans SET tp='$tp', wc='$wc' WHERE clanID='".$ds['clanID']."' && ladID='$laddID' $cs_one");       
       }	
    }	
}

function match_report_link($matchID,$clanID) {

  $type = getleagueType($matchID);
  $ds=mysql_fetch_array(safe_query("SELECT $type, 1on1 FROM ".PREFIX."cup_matches WHERE matchID='$matchID'"));
  $one = ($ds['1on1'] ? "&type=1" : "");

    if($type=="matchno")
    {
       return "?site=groups&cupID=$ds[$type]";
    }   
    elseif($type=="ladID")
    { 
       return "?site=matches&action=viewmatches&clanID=$clanID&laddID=$ds[$type]$one";
    }   
    else
    {
       return "?site=matches&action=viewmatches&clanID=$clanID&cupID=$ds[$type]$one";
    }
}


function global_mII() {
  require("config.php");
   
   if($mi_enable)
      return true;
}


function user_mII($userID) {
   $ds=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."user WHERE userID='$userID'"));
   if($userID) return (isset ($ds['u_MII']) ? true : false);     
}

function local_mII($userID) {
   $ds=mysql_fetch_array(safe_query("SELECT s_mII FROM ".PREFIX."user WHERE userID='$userID'"));
   if($userID) return (isset ($ds['u_MII']) ? false : true);
}

function num_matches($clanID,$cupID,$one,$league) {

    $team = ($one ? "1on1='1'" : "1on1='0'");
    //$is_cup = (empty($cupID) ? "" : "cupID='$cupID' &&");
    
    $ds=mysql_fetch_array(safe_query("SELECT count(*) as matches FROM ".PREFIX."cup_matches WHERE (clan1='$clanID' || clan2='$clanID') && (clan1 != '0' AND clan2 != '0') && (clan1 !='2147483647' AND clan2 !='2147483647') && $team && type='$league'"));
    return $ds['matches'];

}


function shrink_tree($cupID) {
  substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php" ? include("config.php") : include("../config.php"); 
  
    if($shrink_tree)
    {

		$participants = safe_query("SELECT count(*) as participants FROM ".PREFIX."cup_clans WHERE cupID='$cupID' && checkin='1'");
		$dv=mysql_fetch_array($participants);
		
		$ds=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cups WHERE ID='$cupID'"));
		
	    $max = $ds['maxclan'];
	    
	    if($max==8 || $max==80)
		    $max = 8;
	    elseif($max==16 || $max==160)
	    	$max = 16;
	    elseif($max==32 || $max==320)
	        $max = 32;
	    elseif($max==64 || $max==640)
	    	$max = 64;	    	

		if($ds['start'] <= time() && $dv['participants'] < $max && $ds['status']==2 && $max!=8)
		{

		   if($ds['maxclan']==16)
		   {		   
		      if($dv['participants'] >= 5 && $dv['participants'] <= 8)	   
		      safe_query("UPDATE ".PREFIX."cups SET maxclan='8'");
		   }
		   elseif($ds['maxclan']==160)
           {		   
		      if($dv['participants'] >= 5 && $dv['participants'] <= 8)	   
		      safe_query("UPDATE ".PREFIX."cups SET maxclan='80'");
           }
		   elseif($ds['maxclan']==32)
		   {
		      if($dv['participants'] >= 9 && $dv['participants'] <= 16)	   
		      safe_query("UPDATE ".PREFIX."cups SET maxclan='16'");
		   }
		   elseif($ds['maxclan']==320)
		   {
		      if($dv['participants'] >= 9 && $dv['participants'] <= 16)	   
		      safe_query("UPDATE ".PREFIX."cups SET maxclan='160'");
		   }
		   elseif($ds['maxclan']==64)
		   {
		      if($dv['participants'] >= 17 && $dv['participants'] <= 32)	   
		      safe_query("UPDATE ".PREFIX."cups SET maxclan='32'");
		   }
		   elseif($ds['maxclan']==640)
		   {
		      if($dv['participants'] >= 17 && $dv['participants'] <= 32)	   
		      safe_query("UPDATE ".PREFIX."cups SET maxclan='320'");
           }
		}
    }
}

function checkdeduction($laddID,$clanID) {

   $deductions = safe_query("SELECT * FROM ".PREFIX."cup_deduction WHERE ladID='$laddID' && clanID='$clanID' && `terminated`='0'");
   
   if(mysql_num_rows($deductions)){
      return true;
   }
   else{
      return false;
   }
}

function deductionamount($laddID,$clanID) {

   $ds=mysql_fetch_array(safe_query("SELECT SUM(deducted) AS totaldeduction FROM ".PREFIX."cup_deduction WHERE ladID='$laddID' && clanID='$clanID'"));  
   return $ds['totaldeduction'];
}

function deductioncount($laddID,$clanID) {

   $query = safe_query("SELECT * FROM ".PREFIX."cup_deduction WHERE ladID='$laddID' && clanID='$clanID'");  
   return mysql_num_rows($query);
}

function punish($laddID) {

if(!empty($_GET['ladderID']) && $_GET['ladderID']) {

 substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php" ? include("config.php") : include("../config.php");

   $ladder_settings = safe_query("SELECT * FROM ".PREFIX."cup_ladders WHERE ID='$laddID'");
   $lad = mysql_fetch_array($ladder_settings);
   
   $ergebnis2 = safe_query("SELECT count(*) as number FROM ".PREFIX."cup_clans WHERE ladID='".$laddID."'");
   $dv=mysql_fetch_array($ergebnis2);

   $one = (ladderis1on1($laddID) ? "1" : "0");
   $participants = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='$laddID' AND 1on1='$one' AND checkin = '1' AND type='ladder'");
   
   while($ds=mysql_fetch_array($participants)) 
   { 

//inactivity & credit deduction 

   $time_plus_inactivity = time()-$lad['inactivity'];

   if($ds['registered'] && $ds['registered'] > $ds['lastact'] && $ds['registered'] > $ds['lastdeduct'] && $ds['registered'] < $time_plus_inactivity){
      $last_activity = number_format(returnTime($ds['registered']));
   }
   elseif($ds['lastdeduct'] && $ds['lastdeduct'] > $ds['lastact'] && $ds['lastdeduct'] > $ds['registered'] && $ds['lastdeduct'] < $time_plus_inactivity){
      $last_activity = number_format(returnTime($ds['lastdeduct']));
   }
   elseif($ds['lastact'] && $ds['lastact'] > $ds['registered'] && $ds['lastact'] > $ds['lastdeduct'] && $ds['lastact'] < $time_plus_inactivity){
      $last_activity = number_format(returnTime($ds['lastact']));
   }
   else{
      $last_activity = 0;
   }    

    if($ds['registered'] && $ds['registered'] > $ds['lastact']){
      $last_activity2 = returnTime2($ds['registered']);
    }
    elseif($ds['lastact'] && $ds['lastact'] > $ds['registered']){
      $last_activity2 = returnTime2($ds['lastact']);
    }
    else{
      $last_activity2 = 'n/a';
    }

    if($ds['registered'] && $ds['registered'] > $ds['lastact']){
      $last_activity3 = returnTime3($ds['registered']);
    }
    elseif($ds['lastact'] && $ds['lastact'] > $ds['registered']){
      $last_activity3 = returnTime3($ds['lastact']);
    }

    session_start;
    $player_days = $last_activity;
    $days_limit = number_format(Sec2Time($lad['inactivity']));
    $init_points = $lad['deduct_credits'];

    if ($player_days>=$days_limit ) {
    $exceed = $calc = $player_days - $days_limit;
    $count =  ceil ($calc /$days_limit);
    $_SESSION["var"] = $player_days - $days_limit;


    for ($i=1; $i<=$count; $i++) {
    $anas = $_SESSION["var"] - $days_limit;
    $_SESSION["var"] = $anas;
    if ($_SESSION["var"]<0 )
    break;
 }


    $a = $i*$init_points;
    $deduction = $ds['credit']-$a;
    $tp = $deduction+$ds['xp']; 
    $lp=($a < $ds['credit'] ? "lastpos='2'," : "");
    
    $ti=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_deduction WHERE clanID='".$ds['clanID']."' AND ladID='$laddID' ORDER BY time DESC LIMIT 0,1"));
    
    if($ds['credit'] >= 1 && !$ti['terminated'] && $lad['inactivity'] && $a && $lad['inactivity']) {
      safe_query("UPDATE ".PREFIX."cup_clans SET credit = '".$deduction."', tp = '".$tp."', $lp lastdeduct='".time()."' WHERE ladID = '".$laddID."' AND clanID = '".$ds['clanID']."'");
      safe_query("INSERT INTO ".PREFIX."cup_deduction (ladID, clanID, deducted, credit, time) VALUES ('$laddID', '".$ds['clanID']."', '$a', '$deduction', '".time()."')");
    }
   }
   
//if unranked 

    if($unranking && $ds['credit'] <= 0) { 
       safe_query("UPDATE ".PREFIX."cup_clans SET checkin = '0' WHERE ladID = '".$laddID."' AND clanID = '".$ds['clanID']."' AND type='ladder'");
    }
    
//remove idlers

  $timeReturn = time()-$lad['remove_inactive'];
  $ti=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_deduction WHERE clanID='".$ds['clanID']."' AND ladID='$laddID' ORDER BY time DESC LIMIT 0,1"));

  if($dv['number'] < $lad['maxclan']) 
  {
    if($lad['remove_inactive'] && $ds['credit'] >= 1  && !$ds['lastact'] && $ds['registered'] <= $timeReturn && !$ti['terminated']) 
    { 
            safe_query("INSERT INTO ".PREFIX."cup_deduction (`ladID`, `clanID`, `terminated`, `credit`, `time`) VALUES ('$laddID', '".$ds['clanID']."', '1', '".$ds['credit']."', '".time()."')");
            safe_query("UPDATE ".PREFIX."cup_clans SET checkin = '0' WHERE ladID = '".$laddID."' AND clanID = '".$ds['clanID']."' AND type='ladder'");
    }
    if($lad['remove_inactive'] && $ds['credit'] >= 1  && $ds['lastact'] && $ds['lastact'] <= $timeReturn && !$ti['terminated']) 
    { 
            safe_query("INSERT INTO ".PREFIX."cup_deduction (`ladID`, `clanID`, `terminated`, `credit`, `time`) VALUES ('$laddID', '".$ds['clanID']."', '1', '".$ds['credit']."', '".time()."')");
            safe_query("UPDATE ".PREFIX."cup_clans SET checkin = '0' WHERE ladID = '".$laddID."' AND clanID = '".$ds['clanID']."' AND type='ladder'");
    }
   }
  }
 }
}

function checkchallenge($laddID,$clanID) {

  substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php" ? include("config.php") : include("../config.php");
  $challinfo = array('status' => '','step' => '0','ID' => '0');

  $getstatus = safe_query("SELECT * FROM ".PREFIX."cup_challenges WHERE ladID='$laddID' && (challenger='$clanID' || challenged='$clanID')");
  while($ch=mysql_fetch_array($getstatus))
  {  
    
    $challinfo['ID'] = $ch['chalID'];

    if($ch['forfeit']==$ch['challenger']) 
    {
       $challinfo['status'] = '(did not accept with '.getname1($ch['challenged'],$laddID,$ac=0,$var='ladder').'\'s finalized selections)';
       $challinfo['step'] = 1;
    }
    elseif($ch['forfeit']==$ch['challenged']) 
    {
       $challinfo['status'] = '(did not accept '.getname1($ch['challenger'],$laddID,$ac=0,$var='ladder').'\'s challenge request)';
       $challinfo['step'] = 2;
    }
    
    if($ch['status']==4 && $ch['forfeit']==$ch['challenger'])
    {
       $challinfo['status'] = getname1($ch['challenged'],$laddID,$ac=0,$var='ladder').' won by forfeit (<b>+'.$forfeitaward.'</b>)<br>(did not finalize in time)';
       $challinfo['step'] = 3;
    }
    elseif($ch['status']==4 && $ch['forfeit']==$ch['challenged'])
    {
       $challinfo['status'] = getname1($ch['challenger'],$laddID,$ac=0,$var='ladder').' won by forfeit (<b>+'.$forfeitaward.'</b>)<br>(did not respond in time)';
       $challinfo['step'] = 4;
    }
    elseif($ch['status']==5 && $ch['forfeit']==$ch['challenger'])
    {
       $challinfo['status'] = '<font color="#DD0000"><b>Forfeited</b></font> by '.getname1($ch['challenger'],$laddID,$ac=0,$var='ladder');
       $challinfo['step'] = 5;
    }   
    elseif($ch['status']==5 && $ch['forfeit']==$ch['challenged'])
    {
       $challinfo['status'] = '<font color="#DD0000"><b>Forfeited</b></font> by '.getname1($ch['challenged'],$laddID,$ac=0,$var='ladder');
       $challinfo['step'] = 6;
    }   
    elseif($ch['status']==1)
    { 
       $challinfo['status'] = '<font color="#FF6600"><b>Waiting</b></font> for '.getname1($ch['challenged'],$laddID,$ac=0,$var='ladder').'\'s response';
       $challinfo['step'] = 7;
    }   
    elseif($ch['status']==2)
    {
       $challinfo['status'] = '<font color="#FF6600"><b>Waiting</b></font> for '.getname1($ch['challenged'],$laddID,$ac=0,$var='ladder').'\'s response';
       $challinfo['step'] = 8;
    }   
    elseif($ch['status']==3) 
    {
       $challinfo['status'] = '<font color="#00FF00"><b>Challenge Complete</b></font><br><img border="0" src="images/cup/icons/add_result.gif"> <a href="index.php?site=cup_matches&match='.$ch['chalID'].'&laddID='.$ch['ladID'].'">View Match</a>';
       $challinfo['step'] = 9;
    }
  }    return $challinfo;  
}

function checkchallenge2($challID) {

  substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php" ? include("config.php") : include("../config.php");
  $challinfo = array('status' => '','step' => '0','ID' => '0');

  $getstatus = safe_query("SELECT * FROM ".PREFIX."cup_challenges WHERE chalID='$challID'");
  $ch=mysql_fetch_array($getstatus);
    
  $challinfo['ID'] = $ch['chalID'];
  $laddID = $ch['ladID'];

    if($ch['forfeit']==$ch['challenger']) 
    {
       $challinfo['status'] = '(did not accept with '.getname1($ch['challenged'],$laddID,$ac=0,$var='ladder').'\'s finalized selections)';
       $challinfo['step'] = 1;
    }
    elseif($ch['forfeit']==$ch['challenged']) 
    {
       $challinfo['status'] = '(did not accept '.getname1($ch['challenger'],$laddID,$ac=0,$var='ladder').'\'s challenge request)';
       $challinfo['step'] = 2;
    }
    
    if($ch['status']==4 && $ch['forfeit']==$ch['challenger'])
    {
       $challinfo['status'] = getname1($ch['challenged'],$laddID,$ac=0,$var='ladder').' won by forfeit (<b>+'.$forfeitaward.'</b>)<br>(did not finalize in time)';
       $challinfo['step'] = 3;
    }
    elseif($ch['status']==4 && $ch['forfeit']==$ch['challenged'])
    {
       $challinfo['status'] = getname1($ch['challenger'],$laddID,$ac=0,$var='ladder').' won by forfeit (<b>+'.$forfeitaward.'</b>)<br>(did not respond in time)';
       $challinfo['step'] = 4;
    }
    elseif($ch['status']==5 && $ch['forfeit']==$ch['challenger'])
    {
       $challinfo['status'] = '<font color="#DD0000"><b>Forfeited</b></font> by '.getname1($ch['challenger'],$laddID,$ac=0,$var='ladder');
       $challinfo['step'] = 5;
    }   
    elseif($ch['status']==5 && $ch['forfeit']==$ch['challenged'])
    {
       $challinfo['status'] = '<font color="#DD0000"><b>Forfeited</b></font> by '.getname1($ch['challenged'],$laddID,$ac=0,$var='ladder');
       $challinfo['step'] = 6;
    }   
    elseif($ch['status']==1)
    { 
       $challinfo['status'] = '<font color="#FF6600"><b>Waiting</b></font> for '.getname1($ch['challenged'],$laddID,$ac=0,$var='ladder').'\'s response';
       $challinfo['step'] = 7;
    }   
    elseif($ch['status']==2)
    {
       $challinfo['status'] = '<font color="#FF6600"><b>Waiting</b></font> for '.getname1($ch['challenged'],$laddID,$ac=0,$var='ladder').'\'s response';
       $challinfo['step'] = 8;
    }   
    elseif($ch['status']==3) 
    {
       $challinfo['status'] = '<font color="#00FF00"><b>Challenge Complete</b></font><br><img border="0" src="images/cup/icons/add_result.gif"> <a href="index.php?site=cup_matches&match='.$ch['chalID'].'&laddID='.$ch['ladID'].'">View Match</a>';
       $challinfo['step'] = 9;
    }
  return $challinfo;  
}

function ismatch($clanID,$ID,$type) {

    $one = ((($type=='ladID' && ladderis1on1($ID)) || ($type=='cupID' && is1on1($ID))) ? 1 : 0);
    $query = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE $type='$ID' && (clan1='$clanID' || clan2='$clanID') && einspruch='0' && confirmscore='1'");
  
    if(mysql_num_rows($query)) {
          return true;
    } 
    else{
          return false;
    }
}

function match_status($userID,$matchID) {

  $matchstatus = array('status' => '','step' => '0', 'report' => '', 'confirm' => '');
  
  $f_cuptype  = (isset($_GET['ladderID']) || isset($_GET['laddID']) ?  'ladID' : 'cupID');
  $f_cuptype2 = (isset($_GET['ladderID']) || isset($_GET['laddID']) ? 'laddID' : 'cupID');
      
    $dd=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchID='$matchID' && (clan1 != '0' AND clan2 != '0') && (clan1 !='2147483647' AND clan2 !='2147483647')"));
    
    $league = league($matchID);    
    $leaguetype = ($league=='cup' ? 'cupID' :  'ladID');
	$league_type =($league=='cup' ? 'cup' :  'ladder');
    $cupID = ($dd['cupID'] ? $dd['cupID'] : $dd['ladID']);
    $onechecking = ($dd['1on1'] ? '&one=1' : '');
   
    //-- REPORTING --//
    
      if(ismatchparticipant($userID,$dd['matchID'],$all=0) || ismatchparticipant($userID,$dd['matchID'],$all=0))        
      {     
        
        $clan1 = (($dd['1on1'] && $userID==$dd['clan1']) || (!$dd['1on1'] && isleader($userID,$dd['clan1'])) ? $dd['clan1'] : $dd['clan2']);
        $clan2 = ($dd['inscribed']==$dd['clan2'] ? $dd['clan1'] : $dd['clan2']);
        
        //Report score
        
        if(!$dd['score1'] && !$dd['score2'])
        {
           $matchstatus['report'] = '<a href="?site=cupactions&action=score&matchID='.$dd['matchID'].'&clan1='.$clan1.'&'.$f_cuptype2.'='.$cupID.$onechecking.'"><img border="0" src="images/cup/icons/addresult.gif" width="16" height="16"> <font color="#00FF00"><strong>Add Result</strong></a>';
        }
        
        //Confirm score
        
        elseif(($dd['score1'] || $dd['score2']) && !$dd['confirmscore'] && !$dd['einspruch'])
        {
        
          if($dd['1on1'] && $userID==$dd['clan1'] && $dd['inscribed']==$dd['clan2'])
          {
             $matchstatus['report'] = '<a href="?site=cupactions&action=confirmscore&amp;matchID='.$dd['matchID'].'&clanID='.$clan2.'&'.$f_cuptype2.'='.$cupID.$onechecking.'"><img border="0" src="images/cup/icons/agreed.gif"></a><a href="?site=cupactions&amp;action=protest&amp;matchID='.$dd['matchID'].'&clanID='.$clan2.'&'.$f_cuptype2.'='.$cupID.'" onclick="return confirm(\'Are you sure there was something wrong with the match?\');"><img border="0" src="images/cup/icons/protest.gif"></a>';
          }
          elseif($dd['1on1'] && $userID==$dd['clan2'] && $dd['inscribed']==$dd['clan1'])
          {
             $matchstatus['report'] = '<a href="?site=cupactions&action=confirmscore&amp;matchID='.$dd['matchID'].'&clanID='.$clan2.'&'.$f_cuptype2.'='.$cupID.$onechecking.'"><img border="0" src="images/cup/icons/agreed.gif"></a><a href="?site=cupactions&amp;action=protest&amp;matchID='.$dd['matchID'].'&clanID='.$clan2.'&'.$f_cuptype2.'='.$cupID.'" onclick="return confirm(\'Are you sure there was something wrong with the match?\');"><img border="0" src="images/cup/icons/protest.gif"></a>';
          }
          elseif(!$dd['1on1'] && isleader($userID,$dd['clan1']) && $dd['inscribed']==$dd['clan2'])
          {
             $matchstatus['report'] = '<a href="?site=cupactions&action=confirmscore&amp;matchID='.$dd['matchID'].'&clanID='.$clan2.'&'.$f_cuptype2.'='.$cupID.$onechecking.'"><img border="0" src="images/cup/icons/agreed.gif"></a><a href="?site=cupactions&amp;action=protest&amp;matchID='.$dd['matchID'].'&clanID='.$clan2.'&'.$f_cuptype2.'='.$cupID.'" onclick="return confirm(\'Are you sure there was something wrong with the match?\');"><img border="0" src="images/cup/icons/protest.gif"></a>';
          }
          elseif(!$dd['1on1'] && isleader($userID,$dd['clan2']) && $dd['inscribed']==$dd['clan1'])
          {
             $matchstatus['report'] = '<a href="?site=cupactions&action=confirmscore&amp;matchID='.$dd['matchID'].'&clanID='.$clan2.'&'.$f_cuptype2.'='.$cupID.$onechecking.'"><img border="0" src="images/cup/icons/agreed.gif"></a><a href="?site=cupactions&amp;action=protest&amp;matchID='.$dd['matchID'].'&clanID='.$clan2.'&'.$f_cuptype2.'='.$cupID.'" onclick="return confirm(\'Are you sure there was something wrong with the match?\');"><img border="0" src="images/cup/icons/protest.gif"></a>';
          }
          
        }   
          
      }
      else
      {
           $matchstatus['report'] = false;
      }
    
    //-- STATUS --//
        
		if($dd['einspruch']==1)
		{
			$matchstatus['status'] = '<font color="red"><strong>Protest</strong></font>';
			$matchstatus['step'] = 1;
		}	
		elseif($dd['confirmscore']==1 && $dd['einspruch']==0)
		{
			$matchstatus['status'] = '<font color="#00FF00"><strong>Confirmed</strong></font>';
			$matchstatus['step'] = 2;
		}	
	    elseif(($dd['score1'] || $dd['score2']) && $dd['inscribed']==$dd['clan1'])
	    {
			$matchstatus['status'] = '<font color="#FF6600">Waiting for <b>'.getname1($dd['clan2'],$dd[$f_cuptype ],$ac=0,$league_type).'</b></font>';
			$matchstatus['step'] = 3;
						
	    }       
	    elseif(($dd['score1'] || $dd['score2']) && $dd['inscribed']==$dd['clan2'])
	    {
			$matchstatus['status'] = '<font color="#FF6600">Waiting for <b>'.getname1($dd['clan1'],$dd[$f_cuptype ],$ac=0,$league_type).'</b></font>';
			$matchstatus['step'] = 4;					
	    }      
		elseif($dd['confirmscore']==0 && $dd['inscribed'] == 0)
	    {
			$matchstatus['status'] = '<font color="#FF6600"><strong>Pending</strong></font>';
			$matchstatus['step'] = 5;
	    }		
		else
	    {
			$match_status = '<font color="#FF6600"><strong>Pending</strong></font>';
			$matchstatus['step'] = 6;
        }        
    return $matchstatus;
}

function match_status2($userID,$cupID,$clanID) {

  $matchstatus = array('status' => '','step' => '0', 'report' => '', 'confirm' => '');
  
  $f_cuptype  = (isset($_GET['ladderID']) || isset($_GET['laddID']) ?  'ladID' : 'cupID');
  $f_cuptype2 = (isset($_GET['ladderID']) || isset($_GET['laddID']) ? 'laddID' : 'cupID');
    
    $dd=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE $f_cuptype='$cupID' && (clan1='$clanID' || clan2='$clanID') && (clan1 != '0' AND clan2 != '0') && (clan1 !='2147483647' AND clan2 !='2147483647') ORDER BY matchID DESC"));
    
    $league = league($dd['matchID']); 
	$league_type =($league=='cup' ? 'cup' :  'ladder');
    $onechecking = ($dd['1on1'] ? '&one=1' : '');
    
    //-- REPORTING --//
    
      if(ismatchparticipant($userID,$dd['matchID'],$all=0) || ismatchparticipant($userID,$dd['matchID'],$all=0))        
      {     
        
        $clan1 = (($dd['1on1'] && $userID==$dd['clan1']) || (!$dd['1on1'] && isleader($userID,$dd['clan1'])) ? $dd['clan1'] : $dd['clan2']);
        $clan2 = ($dd['inscribed']==$dd['clan2'] ? $dd['clan1'] : $dd['clan2']);
        
        //Report score
        
        if(!$dd['score1'] && !$dd['score2'])
        {
           $matchstatus['report'] = '<a href="?site=cupactions&action=score&matchID='.$dd['matchID'].'&clan1='.$clan1.'&'.$f_cuptype2.'='.$cupID.$onechecking.'"><img border="0" src="images/cup/icons/addresult.gif" width="16" height="16"> <font color="#00FF00"><strong>Add Result</strong></a>';
        }
        
        //Confirm score
        
        elseif(($dd['score1'] || $dd['score2']) && !$dd['confirmscore'] && !$dd['einspruch'])
        {
        
          if($dd['1on1'] && $userID==$dd['clan1'] && $dd['inscribed']==$dd['clan2'])
          {
             $matchstatus['report'] = '<a href="?site=cupactions&action=confirmscore&amp;matchID='.$dd['matchID'].'&clanID='.$clan2.'&'.$f_cuptype2.'='.$cupID.$onechecking.'"><img border="0" src="images/cup/icons/agreed.gif"></a><a href="?site=cupactions&amp;action=protest&amp;matchID='.$dd['matchID'].'&clanID='.$clan2.'&'.$f_cuptype2.'='.$cupID.'" onclick="return confirm(\'Are you sure there was something wrong with the match?\');"><img border="0" src="images/cup/icons/protest.gif"></a>';
          }
          elseif($dd['1on1'] && $userID==$dd['clan2'] && $dd['inscribed']==$dd['clan1'])
          {
             $matchstatus['report'] = '<a href="?site=cupactions&action=confirmscore&amp;matchID='.$dd['matchID'].'&clanID='.$clan2.'&'.$f_cuptype2.'='.$cupID.$onechecking.'"><img border="0" src="images/cup/icons/agreed.gif"></a><a href="?site=cupactions&amp;action=protest&amp;matchID='.$dd['matchID'].'&clanID='.$clan2.'&'.$f_cuptype2.'='.$cupID.'" onclick="return confirm(\'Are you sure there was something wrong with the match?\');"><img border="0" src="images/cup/icons/protest.gif"></a>';
          }
          elseif(!$dd['1on1'] && isleader($userID,$dd['clan1']) && $dd['inscribed']==$dd['clan2'])
          {
             $matchstatus['report'] = '<a href="?site=cupactions&action=confirmscore&amp;matchID='.$dd['matchID'].'&clanID='.$clan2.'&'.$f_cuptype2.'='.$cupID.$onechecking.'"><img border="0" src="images/cup/icons/agreed.gif"></a><a href="?site=cupactions&amp;action=protest&amp;matchID='.$dd['matchID'].'&clanID='.$clan2.'&'.$f_cuptype2.'='.$cupID.'" onclick="return confirm(\'Are you sure there was something wrong with the match?\');"><img border="0" src="images/cup/icons/protest.gif"></a>';
          }
          elseif(!$dd['1on1'] && isleader($userID,$dd['clan2']) && $dd['inscribed']==$dd['clan1'])
          {
             $matchstatus['report'] = '<a href="?site=cupactions&action=confirmscore&amp;matchID='.$dd['matchID'].'&clanID='.$clan2.'&'.$f_cuptype2.'='.$cupID.$onechecking.'"><img border="0" src="images/cup/icons/agreed.gif"></a><a href="?site=cupactions&amp;action=protest&amp;matchID='.$dd['matchID'].'&clanID='.$clan2.'&'.$f_cuptype2.'='.$cupID.'" onclick="return confirm(\'Are you sure there was something wrong with the match?\');"><img border="0" src="images/cup/icons/protest.gif"></a>';
          }        
        }$matchstatus['report'] = true;          
      }
      else
      {
           $matchstatus['report'] = false;
      }
        
    //-- STATUS --//
        
		if($dd['einspruch']==1)
		{
			$matchstatus['status'] = '<font color="red"><strong>Protest</strong></font>';
			$matchstatus['step'] = 1;
		}	
		elseif($dd['confirmscore']==1 && $dd['einspruch']==0)
		{
			$matchstatus['status'] = '<font color="#00FF00"><strong>Confirmed</strong></font>';
			$matchstatus['step'] = 2;
		}	
	    elseif(($dd['score1'] || $dd['score2']) && $dd['inscribed']==$dd['clan1'])
	    {
			$matchstatus['status'] = '<font color="#FF6600">Waiting for <b>'.getname1($dd['clan2'],$dd[$f_cuptype ],$ac=0,$league_type).'</b></font>';
			$matchstatus['step'] = 3;
					
	    }    
	    elseif(($dd['score1'] || $dd['score2']) && $dd['inscribed']==$dd['clan2'])
	    {
			$matchstatus['status'] = '<font color="#FF6600">Waiting for <b>'.getname1($dd['clan1'],$dd[$f_cuptype ],$ac=0,$league_type).'</b></font>';
			$matchstatus['step'] = 4;
						
	    }    
		elseif($dd['confirmscore']==0 && $dd['inscribed'] == 0 && $dd['matchID'])
	    { 
			$matchstatus['status'] = '<font color="#FF6600"><strong>Pending</strong></font>';
			$matchstatus['step'] = 5;
	    }		
		elseif(!$dd['score1'] && !$dd['score2'] && $dd['matchID'])
	    {
			$match_status = '<font color="#FF6600"><strong>Pending</strong></font>';
			$matchstatus['step'] = 6;
        }
    return $matchstatus;
}

function getrank($clanID,$laddID,$type,$unranked) {

  $ladd_ranksys = ladder_ranksys($laddID);
  $rank_type = ($type!='now' ? 'rank_then' : 'rank_now');
  $one = (ladderis1on1($laddID) ? "1on1='1'" : "1on1='0'");
  
  if($rank_type == 'rank_then') {
  
    $query = safe_query("SELECT rank_then FROM ".PREFIX."cup_clans WHERE clanID='$clanID' && ladID='$laddID' && $one");  
    $result = mysql_fetch_array($query);
  
    return $result['rank_then'];      
  
  }
  else{
   
      $query = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='$laddID' AND ".$one." AND checkin='".(!$unranked ? 1 : 0)."' ORDER BY ".$ladd_ranksys." DESC"); 
	  $query2= safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='$laddID' AND ".$one." AND checkin='1' ORDER BY ".$ladd_ranksys." DESC"); 
	  $ranked_participants = mysql_num_rows($query2);
	  
      $return_rank = 1;	  
      while($result = mysql_fetch_assoc($query)) {
           if($result['clanID'] == $clanID) {
	          return $unranked==1 ? $ranked_participants + $return_rank : $return_rank; 
	       }
      $return_rank++;
      }
   }
}

function getrating($clanID,$laddID,$type) {

    substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php" ? include("config.php") : include("../config.php");

    $avg_points = round(ladder_points($laddID,1));
    $ranksys = ladder_ranksys($laddID);
	$one = (ladderis1on1($laddID) ? "1on1='1'" : "1on1='0'");
    
    $query = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='$laddID' AND clanID='$clanID' AND ".$one." ORDER BY ".$ranksys." DESC"); 
    $ds = mysql_fetch_array($query);
	
        if($ranksys=="credit")
           $user_p = $ds['credit'];
        elseif($ranksys=="xp")
           $user_p = $xp;   
        elseif($ranksys=="won")
           $user_p = $won;
        elseif($ranksys=="tp")
           $user_p = $ds['tp'];
        elseif($ranksys=="wc")
          $user_p = $ds['wc'];
        elseif($ranksys=="streak")
           $user_p = $ds['streak'];
        elseif($ranksys=="elo")
           $user_p = $ds['elo'];
       
        if(empty($user_p) || ($ds['tp']==$startupcredit && $ds['credit']==$startupcredit)){
            $average = '<img src="images/cup/icons/na.png" width="16" height="16">';
            $rating = '<img src="images/cup/standings/level0.jpg">';
            $level = '0';
        }
        elseif($user_p == round($avg_points))  {
            $average = '<img src="images/cup/icons/na.png" width="16" height="16"><img src="images/cup/icons/na.png" width="16" height="16">';
            $rating = '<img src="images/cup/standings/level5.jpg">';
            $level = '5';
        }
        elseif($user_p <= round($avg_points/1.3))  {
            $average = '<img src="images/cup/icons/nok_32.png" width="16" height="16"><img src="images/cup/icons/nok_32.png" width="16" height="16">';
            $rating = '<img src="images/cup/standings/level3.jpg">';
            $level = '3';
        }
        elseif($user_p <= round($avg_points/1.4))  {
           $average = '<img src="images/cup/icons/nok_32.png" width="16" height="16"><img src="images/cup/icons/nok_32.png" width="16" height="16">';
            $rating = '<img src="images/cup/standings/level2.jpg">';
            $level = '2';
        }
        elseif($user_p <= round($avg_points/1.5))  {
            $average = '<img src="images/cup/icons/nok_32.png" width="16" height="16"><img src="images/cup/icons/nok_32.png" width="16" height="16">';
            $rating = '<img src="images/cup/standings/level1.jpg">';
            $level = '1';
        }
        elseif($user_p <= round($avg_points/1.1))  {
            $average = '<img src="images/cup/icons/nok_32.png" width="16" height="16"><img id="myImage" src="images/cup/icons/nok_32.png" width="16" height="16">';
            $rating = '<img src="images/cup/standings/level4.jpg">';
            $level = '4';
        }
        elseif($user_p >= round($avg_points*1.5)){
            $average = '<img src="images/cup/icons/ok_32.png" width="16" height="16"><img src="images/cup/icons/ok_32.png" width="16" height="16">';
            $rating = '<img src="images/cup/standings/level10.jpg">';
            $level = '10';
        }
        elseif($user_p >= round($avg_points*1.4)){
            $average = '<img src="images/cup/icons/ok_32.png" width="16" height="16"><img src="images/cup/icons/ok_32.png" width="16" height="16">';
            $rating = '<img src="images/cup/standings/level9.jpg">';
            $level = '9';
        }
        elseif($user_p >= round($avg_points*1.3)){
            $average = '<img src="images/cup/icons/ok_32.png" width="16" height="16"><img src="images/cup/icons/ok_32.png" width="16" height="16">';
            $rating = '<img src="images/cup/standings/level8.jpg">';
            $level = '8';
        }
        elseif($user_p >= round($avg_points*1.2)){
            $average = '<img src="images/cup/icons/ok_32.png" width="16" height="16"><img src="images/cup/icons/ok_32.png" width="16" height="16">';
            $rating = '<img src="images/cup/standings/level7.jpg">';
            $level = '7';
        }
        elseif($user_p > round($avg_points)){
            $average = '<img src="images/cup/icons/ok_32.png" width="16" height="16"><img id="myImage" src="images/cup/icons/ok_32.png" width="16" height="16">';
            $rating = '<img src="images/cup/standings/level6.jpg">';
            $level = '6';
        }
        else{
            $average = '<img src="images/cup/icons/na.png" width="16" height="16"><img id="myImage" src="images/cup/icons/na.png" width="16" height="16">';
			$rating = 0;
			$level = 0;
        } 
    if($type == 'average') {
          return $average;
    }
    elseif($type == 'rating') {
          return $rating;
    }
    elseif($type == 'level') {
          return $level;
    }
	else{
	      return 0;
	}
}

function rankagain($laddID) {

substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php" ? include("config.php") : include("../config.php");

  $one = (ladderis1on1($laddID) ? "1" : "0");

  $query = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='$laddID' && 1on1='$one'");
    while($ds = mysql_fetch_array($query)) {
    
      if($ds['checkin']==0 && (getcredits($ds['clanID'],$laddID)>0 OR !$unranking)) {
         safe_query("UPDATE ".PREFIX."cup_clans SET checkin = '1', lastact = '".time()."' WHERE ladID = '".$laddID."' AND clanID = '".$ds['clanID']."'");
      }
      if($ds['checkin']==1 && (getcredits($ds['clanID'],$laddID)<1)) {
         safe_query("UPDATE ".PREFIX."cup_clans SET checkin = '0', lastact = '".time()."' WHERE ladID = '".$laddID."' AND clanID = '".$ds['clanID']."'");
      }
   }
}

function allvsall($ID) {

   $type_opp = (isset($_GET['laddID']) || isset($_GET['ladderID']) ? "cupID" : "ladID");

   $sp=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchno='".$ID."' && $type_opp='0' && type='gs' && si='0'"));
   return (is_array($sp) ? true : false);
}

function qualifiersToLeague($ID) {

substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php" ? include("config.php") : include("../config.php");

  $laddID = "";
  $ladderID = "";
  if(isset($_GET['laddID'])) $laddID = $_GET['laddID'];
  if(isset($_GET['ladderID'])) $ladderID = $_GET['ladderID'];

  if($insert_qualifiers==1) {
  
    $type =  ($laddID || $ladderID ? "ladID" : "cupID");
	$chk_lty=($laddID || $ladderID ? "ladder" : "cup");
    $chk_typ=($laddID || $ladderID ? "cupID='0'" : "ladID='0'");
    $chk_tab=($laddID || $ladderID ? "cup_ladders" : "cups");
    $chk_prt=($laddID || $ladderID ? "isladparticipant" : "iscupparticipant");
    
    if(($laddID || $ladderID) && ladderis1on1($ID)) {
           $chk_1on1 = "1";
    }
    elseif(isset($_GET['cupID']) && is1on1($ID)) {
           $chk_1on1 = "1";
    }
    else{
           $chk_1on1 = "0";
    }

    $participant_ent = safe_query("SELECT $type FROM ".PREFIX."cup_clans WHERE groupID='$ID' AND type='gs' AND $chk_typ");
    $ent_part = mysql_num_rows($participant_ent);
	
    $check_end = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchno='$ID' AND confirmscore='0' AND $chk_typ AND type='gs'"); 
    $ce = mysql_fetch_array($check_end);   
	
    $dd=mysql_fetch_array(safe_query("SELECT count(*) as clans1 FROM ".PREFIX."cup_clans WHERE $type='$ID' && checkin = '1' && type='$chk_lty'"));
    $dp=mysql_fetch_array(safe_query("SELECT count(*) as clans2 FROM ".PREFIX."cup_clans WHERE groupID='".$ID."' && qual='1' && $chk_typ && type='gs'")); 
    $le=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX.$chk_tab." WHERE ID='$ID'"));
	$dt=mysql_fetch_array(safe_query("SELECT count(*) as totalm FROM ".PREFIX."cup_matches WHERE matchno='$ID' && type='gs' && $chk_typ && confirmscore='1' && einspruch='0' && type='gs'"));      

	if($le['maxclan'] == 80 || $le['maxclan']== 8)
		$max = 8;
	elseif($le['maxclan'] == 160 || $le['maxclan']== 16)
		$max = 16;
	elseif($le['maxclan'] == 320 || $le['maxclan']== 32)
		$max = 32;
	elseif($le['maxclan'] == 640 || $le['maxclan']== 64)
		$max = 64; 
		
    if($le['gs_staging']==1) {
   
       if(allvsall($ID)==true) {
      
             $spec_mc = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE matchno='$ID' && type='gs' && $chk_typ");
             $total_matches = mysql_num_rows($spec_mc);
       }
       else{
             $total_matches = $max*7; 
       }
    }
    else{
             $total_matches = $max;
    }
	
    if(!$ent_part) {
          $finished = 0;
    }
    elseif(mysql_num_rows($check_end)) {
          $finished = 0; 
    }
    elseif($dt['totalm'] == $total_matches) {
          $finished = 1; 
    }
	
    if($finished==1 && $dd['clans1'] <= $dp['clans2']) {
	
	$query = safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE groupID='$ID' && 1on1='$chk_1on1' && qual='1' && $chk_typ && type='gs'");
	  while($ql = mysql_fetch_assoc($query)) {	
	        $ql_array[] = $ql['clanID'];
	  }
	  
	$query = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE groupID='$ID' && 1on1='$chk_1on1' && $chk_typ && type='gs'");
	  while($ds = mysql_fetch_assoc($query)) {	
	  
	     $chk_entry = mysql_fetch_array(safe_query("SELECT clanID FROM ".PREFIX."cup_clans WHERE clanID='".$ds['clanID']."' && ladID='$ID' && type='ladder'"));
	     $chk_rows = mysql_num_rows($chk_entry);
		 
		    if(in_array($ds['clanID'],$ql_array) && !$dd['clans1'] && !$chk_rows){			
			   if($type=='ladID') {
			         safe_query("INSERT INTO ".PREFIX."cup_clans (platID, ladID, credit, registered, clanID, 1on1, checkin, tp) VALUES ('$platID', '$ID', '$startupcredit', '".time()."', '".$ds['clanID']."', '$chk_1on1', '1', '$startupcredit')");
			   }
			   else{
				     safe_query("INSERT INTO ".PREFIX."cup_clans (cupID, clanID, 1on1, checkin) VALUES ('$ID', '".$ds['clanID']."', '$chk_1on1', '1')");
			   }
            }
	     }
      }    
   }
}

function countgameacc($clanID) {

if(isset($_GET['cupID']) || isset($_GET['laddID'])) {
    $cupID = ($_GET['cupID'] ? mysql_real_escape_string($_GET['cupID']) : mysql_real_escape_string($_GET['laddID']));
}

$cnt_usergameacc = "";

if($cupID) {

  $dsz=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX.($_GET['cupID'] ? 'cups' : 'cup_ladders')." WHERE ID='$cupID'"));

    $members_qry = safe_query("SELECT * FROM ".PREFIX."cup_clan_members WHERE clanID='$clanID'");
        while($dv = mysql_fetch_assoc($members_qry)) {
		
	    $query = safe_query("SELECT * FROM ".PREFIX."user_gameacc WHERE userID='".$dv['userID']."' && log='0' && type='".$dsz['gameaccID']."'");
        $cnt_usergameacc += mysql_num_rows($query);
	
	}
    }return (empty($cnt_usergameacc) ? 0 : $cnt_usergameacc);
}

function cup_update($db,$column,$column_attr,$ver,$userID,$type){
    $exists = false;
    $columns = safe_query("show columns from $db");
    while($c = mysql_fetch_assoc($columns)){
        if($c['Field'] == $column){
            $exists = true;
            break;
        }
    }      
    if(!$exists && issuperadmin($userID) && $type==1){
	redirect('?site=db_v5_2&action=5204update', '<font color="red"><strong>Proceeding to update process...</strong></font>', 3);
    }
    elseif(!$exists && issuperadmin($userID) && !$type){
        safe_query("ALTER TABLE `$db` ADD `$column`  $column_attr");
    }
}

function check_database($userID) {

$cdprefix = PREFIX;
include("admin/cupversion.php");

  if(issuperadmin($userID)) {
  
    if($version_num==5204 && cup_update($cdprefix.'cup_ladders', '3rd', 'int(11) NOT NULL', '5204', $userID, 1)) 
    {
       return cup_update($cdprefix.'cup_ladders', '3rd', 'int(11) NOT NULL', '5204', $userID);  
    }
  }
}

function add_date() {
       safe_query("UPDATE ".PREFIX."cup_matches SET date='".time()."' WHERE date='' OR date='0'");
}

function check_db_admin($userID) {

substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php" ? include("config.php") : include("../config.php");

if($run_without_admin == 1 && issuperadmin($userID) && mb_substr(basename($_SERVER['REQUEST_URI']),0,15) != "admincenter.php") 
echo '<div class="errorbox"><img src="images/cup/icons/notification.png" width="16" height="16"> <b>WARNING FOR SUPERADMIN:</b> The db_v5_2.php file is publicly accessible. To prevent this, you must set $run_without_admin to 0 in config.php</div>';
}

function get_gamename($gameID) {
    $ds=mysql_fetch_array(safe_query("SELECT name FROM ".PREFIX."games WHERE gameID='$gameID'"));
    return getinput($ds['name']);
}

function get_gametag($gameID) {
    $ds=mysql_fetch_array(safe_query("SELECT tag FROM ".PREFIX."games WHERE gameID='$gameID'"));
    return getinput($ds['tag']);
}

function get_gametag_cup($cupID) {
    $ds=mysql_fetch_array(safe_query("SELECT game FROM ".PREFIX."cups WHERE ID='$cupID'"));
    return getinput($ds['game']);
}

function get_gametag_lad($laddID) {
    $ds=mysql_fetch_array(safe_query("SELECT game FROM ".PREFIX."cup_ladders WHERE ID='$laddID'"));
    return getinput($ds['game']);
}


function rating($S1, $S2, $R1, $R2, $ladderID, $clanID) {

    $ds=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_ladders WHERE ID='$ladderID'"));
	$rating=mysql_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE ladID='$ladderID' AND clanID='$clanID'"));
	
	if($ds['kfa_type']==0) {
	    $kfactor = $ds['kfa_fixed'];
	}
	elseif($ds['kfa_type']==1) {
	
	    if($rating['elo'] < $ds['elo_bel']) {
		    $kfactor = $ds['kfa_bel'];
		}
		elseif($rating['elo'] >= $ds['elo_bet1'] AND $rating['elo'] <= $ds['elo_bet2']) {
		    $kfactor = $ds['kfa_bet'];
		}
		elseif($rating['elo'] > $ds['elo_abo']) {
		    $kfactor = $ds['kfa_abo'];
		}
	}


        if($S1 != $S2) {
            if($S1 > $S2) {
                $E = $kfactor - round(1 / (1 + pow(10, (($R2 - $R1) / 400))) * $kfactor);
                $R['R3'] = $R1 + $E;
                $R['R4'] = $R2 - $E;
            } else {
                $E = $kfactor - round(1 / (1 + pow(10, (($R1 - $R2) / 400))) * $kfactor);
                $R['R3'] = $R1 - $E;
                $R['R4'] = $R2 + $E;
            }
        } else {
            if($R1 == $R2) {
                $R['R3'] = $R1;
                $R['R4'] = $R2;
            } else {
                if($R1 > $R2) {
                    $E = ($kfactor - round(1 / (1 + pow(10, (($R1 - $R2) / 400))) * $kfactor)) - ($kfactor - round(1 / (1 + pow(10, (($R2 - $R1) / 400))) * $kfactor));
                    $R['R3'] = $R1 - $E;
                    $R['R4'] = $R2 + $E;
                } else {
                    $E = ($kfactor - round(1 / (1 + pow(10, (($R2 - $R1) / 400))) * $kfactor)) - ($kfactor - round(1 / (1 + pow(10, (($R1 - $R2) / 400))) * $kfactor));
                    $R['R3'] = $R1 + $E;
                    $R['R4'] = $R2 - $E;
                }
            }
        }
        $R['S1'] = $S1;
        $R['S2'] = $S2;
        $R['R1'] = $R1;
        $R['R2'] = $R2;
        $R['P1'] = ((($R['R3'] - $R['R1']) > 0)?"+" . ($R['R3'] - $R['R1']) : ($R['R3'] - $R['R1']));
        $R['P2'] = ((($R['R4'] - $R['R2']) > 0)?"+" . ($R['R4'] - $R['R2']) : ($R['R4'] - $R['R2']));
        return $R;
}

//global call func
if(cupIsInstalled()){
	add_date();
}

?>