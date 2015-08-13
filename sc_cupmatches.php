<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js" type="text/javascript"></script>
<script type="text/javascript">

$(document).ready(function(){
	
        $(".slidingDiv_rm").hide();
        $(".show_hide_rm").show();
  	
	$('.show_hide_rm).click(function(){
	$(".slidingDiv_rm").slideToggle();
	});

});

</script>

<?php include ("config.php");

$bg1=BG_1;
$bg2=BG_1;
$bg3=BG_1;
$bg4=BG_1;

if($call_clanmatches){   

   $clanIDsc = $_GET['clanID'];
   $cupID = $_GET['cupID'];
   $clanSC = "&& (clan1='$clanIDsc' || clan2='$clanIDsc')";
   
   $style_ext_rm_tb = 'cellspacing="'.$cellspacing.'" cellpadding="'.$cellpadding.'" bgcolor="'.$border.'"';
   $style_ext_rm_td = 'bgcolor="'.$bg1.'"';
   
   $style_head = '<table width="100%" '.$style_ext_rm_tb.'>
                   <tr>
                    <td class="title">Recent Matches <a href="#rm" name="rm" class="show_hide_rm"><img src="images/cup/icons/arrow_up_down.gif" align="right"></a></td>
                   </tr>
		  </table>';
	
   $style_br = '<br />';
   $cupSC = ($_GET['cupID'] ? "&& cupID='$cupID'" : "");
   $teamSC = "&& 1on1='0'";
   
}

$order_sc=($sc_cupmatches_order ? "ORDER BY confirmed_date" : "ORDER BY date");
$matches = safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE confirmscore='1' && einspruch='0' $cupSC $clanSC && (clan1 != '0' && clan2 != '0') && (clan1 != '2147483647' && clan2 != '2147483647') $teamSC $order_sc DESC LIMIT 0,$limit_recent_matches");

    if(mysql_num_rows($matches)) { 

       eval ("\$sc_upcomingmatches = \"".gettemplate("sc_cupmatches_head")."\";");
       echo $sc_upcomingmatches;  

    while($ds=mysql_fetch_array($matches)) 
    { 
    
     $array = array('a','b','c','d','e','f','g','h');
     $t_name=($ds['ladID'] ? "laddID" : "cupID");
     $date = date("d/m/Y", $ds['date']);
     
     if($ds['type']=='gs') {
        $typename2 = 'groupID';
     }
     elseif($ds['type']=='cup'){
        $typename2 = 'cupID';
     }
     elseif($ds['type']=='ladder') {
        $typename2 = 'laddID';
     }

     if($ds['type']=='cup') {
        $cupID = $ds['cupID'];
        $game = $logo=mysql_fetch_array(safe_query("SELECT game FROM ".PREFIX."cups WHERE ID='".$ds['cupID']."'"));
        $type = '<img src="images/cup/icons/tournament.png" align="right">';
        $var = "cupID";
        $league = "cup";
        $details_link = '?site=cup_matches&match='.$ds['matchno'].'&'.$typename2.'='.$cupID.'';
     }
     elseif($ds['type']=='gs') {
        $cupID = $ds['matchno'];
        $league = (in_array($ds['cupID'],$array) ? "cup" : "ladder");
        $game = $logo=mysql_fetch_array(safe_query("SELECT game FROM ".PREFIX.($league=='cup' ? 'cups' : 'cup_ladders')." WHERE ID='".$ds['matchno']."'"));
        $type = '<img src="images/cup/icons/groups.png" align="right">';
        $var = "matchno";
        $details_link = '?site=cup_matches&match='.$ds['matchID'].'&'.$t_name.'='.$cupID.'&type=gs';
     }
     elseif($ds['type']=='ladder') {
        $cupID = $ds['ladID'];
        $game = $logo=mysql_fetch_array(safe_query("SELECT game FROM ".PREFIX."cup_ladders WHERE ID='".$ds['ladID']."'"));
        $type = '<img src="images/cup/icons/ladder.png" align="right">';
        $var = "ladID";
        $league = "ladder";
        $details_link = (!$ds['matchno'] ? '?site=cup_matches&matchID='.$ds['matchID'].'&'.$typename2.'='.$cupID.'' : '?site=cup_matches&match='.$ds['matchno'].'&'.$typename2.'='.$cupID.'');
     }
     
    $length_sccm = $sc_cupmatches_length; 
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

        if($ds['score1'] > $ds['score2']) {
           $score1_sc = '<font color="#03ff21">'.$ds['score1'].'</font>';
           $score2_sc = '<font color="#fd0101">'.$ds['score2'].'</font>';
        }
	elseif($ds['score1'] < $ds['score2']) {
           $score1_sc = '<font color="#fd0101">'.$ds['score1'].'</font>';
           $score2_sc = '<font color="#03ff21">'.$ds['score2'].'</font>';
        }
	else{
           $score1_sc = '<font color="#FF6600">'.$ds['score1'].'</font>';
           $score2_sc = '<font color="#FF6600">'.$ds['score2'].'</font>';
        }        
    
		eval ("\$sc_upcomingmatches = \"".gettemplate("sc_cupmatches")."\";");
		echo $sc_upcomingmatches;  
    }           echo '</table></div>'.$style_br;
  }else echo '';
?>