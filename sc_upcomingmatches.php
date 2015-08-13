<?php include ("config.php");

$bg1=BG_1;
$bg2=BG_1;
$bg3=BG_1;
$bg4=BG_1;

$matches = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE confirmscore='0' && einspruch='0' && inscribed = '0' && (cupID != '0' || ladID != '0') && clan1 != '0' && clan2 != '0' && clan1 != '2147483647' && clan2 != '2147483647' ORDER BY matchID DESC LIMIT 0,$limit_upcoming_matches");
  if(mysqli_num_rows($matches)) {

		eval ("\$sc_upcomingmatches = \"".gettemplate("sc_upcomingmatches_head")."\";");
		echo $sc_upcomingmatches;   

    while($ds=mysqli_fetch_array($matches)) {
    
     $array = array('a','b','c','d','e','f','g','h');
     $t_name=($ds['ladID'] ? "laddID" : "cupID"); 
     $date = date("d/m/Y", $ds['date']);
     
     if(in_array($ds['cupID'],$array) || in_array($ds['ladID'],$array))
        $typename2 = 'groupID';
     elseif($ds['cupID'])
        $typename2 = 'cupID';
     elseif($ds['ladID'])
        $typename2 = 'laddID';

     if($ds['type']=='cup') {
        $cupID = $ds['cupID'];
        $game = $logo=mysqli_fetch_array(safe_query("SELECT game FROM ".PREFIX."cups WHERE ID='".$ds['cupID']."'"));
        $type = '<img src="images/cup/icons/cup.png" align="right">';
        $var = "cupID";
        $league = "cup";
        $details_link = '?site=cup_matches&match='.$ds['matchno'].'&'.$typename2.'='.$cupID;
	$cs=mysqli_fetch_array(safe_query("SELECT status FROM ".PREFIX."cups WHERE ID='$cupID'"));
     }
     elseif($ds['type']=='gs') {
        $cupID = $ds['matchno'];
        $league = (in_array($ds['cupID'],$array) ? "cup" : "ladder");
        $game = $logo=mysqli_fetch_array(safe_query("SELECT game FROM ".PREFIX.($league=='cup' ? 'cups' : 'cup_ladders')." WHERE ID='".$ds['matchno']."'"));
        $type = '<img src="images/cup/icons/groups.png" align="right">';
        $var = "matchno";
        $details_link = '?site=cup_matches&match='.$ds['matchID'].'&'.$t_name.'='.$cupID.'&type=gs';
	$cs=mysqli_fetch_array(safe_query("SELECT status FROM ".PREFIX.($league=='cup' ? 'cups' : 'cup_ladders')." WHERE ID='$cupID'"));
     }
     elseif($ds['type']=='ladder') {
        $cupID = $ds['ladID'];
        $game = $logo=mysqli_fetch_array(safe_query("SELECT game FROM ".PREFIX."cup_ladders WHERE ID='".$ds['ladID']."'"));
        $type = '<img src="images/cup/icons/ladder.png" align="right">';
        $var = "ladID";
        $league = "ladder";
        $details_link = (!$ds['matchno'] ? '?site=cup_matches&matchID='.$ds['matchID'].'&'.$typename2.'='.$cupID.'' : '?site=cup_matches&match='.$ds['matchno'].'&'.$typename2.'='.$cupID.'');
	$cs=mysqli_fetch_array(safe_query("SELECT status FROM ".PREFIX."cup_ladders WHERE ID='$cupID'"));
     }
     
    $length_sccm = $sc_upcomingmatches_length; 
	$str_re_c1 = strlen(getname2($ds['clan1'],$ds[$var],$ac=0,$league))-$length_sccm;
	$str_re_c2 = strlen(getname2($ds['clan2'],$ds[$var],$ac=0,$league))-$length_sccm;
                               
	if(strlen(getname2($ds['clan1'],$ds[$var],$ac=0,$league)) > $length_sccm) { 
	        $clan1 = '<a href="'.getname3($ds['clan1'],$ds[$var],$ac=0,$league).'"><strong>'.substr(getname2($ds['clan1'],$ds[$var],$ac=0,$league), 0, -$str_re_c1).'..</strong></a>';
	}
	else{
                $clan1 = getname1($ds['clan1'],$ds[$var],$ac=0,$league);
	}
	
	if(strlen(getname2($ds['clan2'],$ds[$var],$ac=0,$league)) > $length_sccm) {
	        $clan2 = '<a href="'.getname3($ds['clan2'],$ds[$var],$ac=0,$league).'"><strong>'.substr(getname2($ds['clan2'],$ds[$var],$ac=0,$league), 0, -$str_re_c2).'..</strong></a>';
	}    
	else{
                $clan2 = getname1($ds['clan2'],$ds[$var],$ac=0,$league);
	} 
	
	    if($cs['status']==2) {
    
		eval ("\$sc_upcomingmatches = \"".gettemplate("sc_upcomingmatches")."\";");
		echo $sc_upcomingmatches;  		
            }
    }echo '</table>';
  }else echo '';
?>