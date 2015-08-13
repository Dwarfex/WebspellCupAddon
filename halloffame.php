<?php
//include configuration and language
include ("config.php");
$_language->read_module('cup');
?>

<link href="cup.css" rel="stylesheet" type="text/css">

<style>
        span.link {
    	        position: relative;
        }

        span.link a span {
    	        display: none;
        }

        span.link a:hover {
    	        font-size: 99%;
    	        font-color: #000000;
        }

        span.link a:hover span { 
            display: block; 
    	    position: absolute; 
    	    margin-top: -100px; 
    	    margin-left: 90px; 
	    width: 165px; padding: 5px; 
    	    z-index: 100; 
    	    background: <?php echo $pagebg; ?>; 
    	    font: 12px "Arial", sans-serif;
    	    text-align: left; 
    	    text-decoration: none;   	
            border: 2px solid <?php echo $border; ?>;
            border-radius: 15px;

        }
	
	.show_hide_ts, .slidingDiv_dt  {
	        display:none;
        }
</style>

<script language="javascript">wmtt = null; document.onmousemove = updateWMTT; function updateWMTT(e) { x = (document.all) ? window.event.x + document.body.scrollLeft : e.pageX; y = (document.all) ? window.event.y + document.body.scrollTop  : e.pageY; if (wmtt != null) { wmtt.style.left=(x + 20) + "px"; wmtt.style.top=(y + 20) + "px"; } } function showWMTT(id) {	wmtt = document.getElementById(id);	wmtt.style.display = "block" } function hideWMTT() { wmtt.style.display = "none"; }</script>
<script type="text/javascript">
function SelectAll(id)
{
    document.getElementById(id).focus();
    document.getElementById(id).select();
}
</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js" type="text/javascript"></script>
<script type="text/javascript">

$(document).ready(function(){
	
        $(".slidingDiv_dt").show();
        $(".show_hide_dt").show();
	
	$('.show_hide_dt').click(function(){
	$(".slidingDiv_dt").slideToggle();
	});
	
        $(".slidingDiv_ts").hide();
        $(".show_hide_ts").show();
	
	$('.show_hide_ts').click(function(){
	$(".slidingDiv_ts").slideToggle();
	});

});

</script>

<div class="tooltip" id="unchecked" align="left"><?php echo $_language->module['unchecked']; ?></div>
<div class="tooltip" id="unchecked_notleader" align="left"><?php echo $_language->module['unchecked_notleader']; ?></div>
<div class="tooltip" id="inactive" align="left"><?php echo $_language->module['inactive']; ?></div>
<div class="tooltip" id="locked" align="left"><?php echo $_language->module['locked']; ?></div>
<div class="tooltip" id="inlog" align="left"><img src="images/cup/icons/warning.png"> <?php echo $_language->module['inlog']; ?></div>



<SCRIPT TYPE="text/javascript">
<!--
function dropdown(mySel)
{
var myWin, myVal;
myVal = mySel.options[mySel.selectedIndex].value;
if(myVal)
   {
   if(mySel.form.target)myWin = parent[mySel.form.target];
   else myWin = window;
   if (! myWin) return true;
   myWin.location = myVal;
   }
return false;
}
//-->
</SCRIPT>


<?php
$_language->read_module('halloffame');

include ("config.php");
check_winners();
match_query_type();

$bg1=BG_1;
$bg2=BG_1;
$bg3=BG_1;
$bg4=BG_1;
$cpr=ca_copyr();

//date and timezone

$timezone = safe_query("SELECT timezone FROM ".PREFIX."cup_settings");
$tz = mysqli_fetch_array($timezone); $gmt = $tz['timezone'];
date_default_timezone_set($tz['timezone']);

if(!$cpr || !ca_copyr()) die();

eval ("\$inctemp = \"".gettemplate("title_hof")."\";");
echo $inctemp;

$one = (isset($_GET['type']) && $_GET['type']=="one" ? 1 : 0);
$team = (isset($_GET['type']) && $_GET['type']=="one" ? 0 : 1);
$lad = (isset($_GET['cup']) && $_GET['cup']=="ladders" ? 1 : 0);
$headtitle = (!$one ? "Team" : "Player");

if(!isset($_GET['gameID'])) {
  if($one && !$lad)
      echo "<div class='infobox'>Viewing <strong>Tournaments - 1on1</strong></div>";
  elseif(!$one && !$lad)
      echo "<div class='infobox'>Viewing <strong>Tournaments - Teams</strong></div>";
  elseif($one && $lad)
      echo "<div class='infobox'>Viewing <strong>Ladders - 1on1</strong></div>";
  elseif(!$one && $lad)
      echo "<div class='infobox'>Viewing <strong>Ladders - Team</strong></div>";
} 

// view by game (5209)

    $if_tournament = "";
	
    if(isset($_GET['gameID'])) {
	       
		   $tag_gamename = get_gametag($_GET['gameID']);
		   $game_name = get_gamename($_GET['gameID']);
           echo '<br><img src="images/cup/icons/go.png"> Hall of Fame for <b>'.$game_name.'</b> - <a href="?site=halloffame"><b>Go Back</b></a>';
           $if_tournament = 'game=\''.$tag_gamename.'\'';
    }
	
    
       $league_ids = '';    
    
	   $query = safe_query("SELECT * FROM ".PREFIX."cups WHERE status='3'");
	   $rowsrt1 = mysqli_num_rows($query);
	   while($so=mysqli_fetch_array($query)) {
	   
	     if($so['1on1']==1) {
	       $tags_in_1on1.= 'tag=\''.$so['game'].'\' OR ';
	     }
		 else{
	       $tags_in_team.= 'tag=\''.$so['game'].'\' OR '; 
		 }
	   }
	   
	   $query = safe_query("SELECT * FROM ".PREFIX."cup_ladders WHERE 1st!='' AND status='3'");
	   $rowsrt2 = mysqli_num_rows($query);
	   while($so=mysqli_fetch_array($query)) {
	   
	     if($so['1on1']==1) {
	       $tags_in_1on1.= 'tag=\''.$so['game'].'\' OR ';
	     }
		 else{
	       $tags_in_team.= 'tag=\''.$so['game'].'\' OR '; 
		 }
	   }
	   
	   $tags_in_1on1.="tag = ''";
	   $tags_in_team.="tag = ''";
	   
       $leagueIDs = safe_query("SELECT gameID FROM ".PREFIX."games WHERE $tags_in_1on1"); 
           while($pID = mysqli_fetch_array($leagueIDs)) {
               $league_ids.='<option value="?site=halloffame&gameID='.$pID['gameID'].'&type=one">'.get_gamename($pID['gameID']).' - 1on1</option>';
           }
		   
       $leagueIDs = safe_query("SELECT gameID FROM ".PREFIX."games WHERE $tags_in_team"); 
           while($pID = mysqli_fetch_array($leagueIDs)) {
               $league_ids.='<option value="?site=halloffame&gameID='.$pID['gameID'].'">'.get_gamename($pID['gameID']).' - Team</option>';
           }
		   
		if(!$rowsrt1 AND !$rowsrt2) {
		    $league_ids = '<option value="0">-- No results found --</option>';
		}
		
		$showing_plat = '';
        if(isset($_GET['platID'])) {
            $showing_plat = '&platID='.$_GET['platID'];
        }		
		   
        echo '<FORM METHOD=POST onSubmit="return dropdown(this.gourl)">
		        <select name="gourl">
				<option value="?site=halloffame" selected>-- Select League --</option>
		        <optgroup label="Select Type">
                  <option value="?site=halloffame&type=one">Tournaments - 1on1</option>
                  <option value="?site=halloffame">Tournaments - Team</option>
	              <option value="?site=halloffame&type=one&cup=ladders">Ladders - 1on1</option>
	              <option value="?site=halloffame&cup=ladders">Ladders - Teams</option>
			      <optgroup label="Select Game">
			      '.$league_ids.'
			    </select>
				<INPUT TYPE=SUBMIT VALUE="View HoF">
			  </form>';
    

$tag_gamename = get_gametag($_GET['gameID']);
$tag_query = isset($_GET['gameID']) ? "AND game='$tag_gamename'" : "";
$all_teams=array();
$used_teams=array();
$n=1;

$ergebnis = safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE 1on1='$one' $tag_query ORDER BY rt DESC");	

if(!mysqli_num_rows($ergebnis)) {
       echo '<div '.$error_box.'> No records found</div>'; 
}
else{
       eval ("\$inctemp = \"".gettemplate("hof_head")."\";");
       echo $inctemp;
	
while($db=mysqli_fetch_array($ergebnis)) {
	if(in_array($db['clanID'], $used_teams, true)) continue;
	
	if(!$one){
		$ergebnis2 = safe_query("SELECT * FROM ".PREFIX."cup_all_clans WHERE ID = '".$db['clanID']."' ORDER BY name ASC");		
		$ds=mysqli_fetch_array($ergebnis2);
	}
	
	$cup_type=($_GET['cup']=="ladders" ? "&& type='ladder'" : "&& type='cup'");
	$cup_name=($_GET['cup']=="ladders" ? " Ladder" : " Cup");
	
	$awards_sql=safe_query("SELECT * FROM ".PREFIX."cup_clans WHERE clanID = '".$db['clanID']."' &&  1on1='$one' $cup_type");
	
	$joincups=mysqli_num_rows($awards_sql);
	$joincups=($joincups==1 ? $joincups.$cup_name : $joincups.$cup_name.'s');
	
	$teamname=($one ? getnickname($db['clanID']) : $ds['name']);
	(isset($_GET['cup'])=="ladders" ? getclanawards_lad($db['clanID'], $one) : getclanawards($db['clanID'], $one));
	$sortpoint=($ar_awards[1]*3)+($ar_awards[2]*2)+($ar_awards[3]*1);
	
	$all_teams[$sortpoint][$n]['teamID']=$db['clanID'];
	$all_teams[$sortpoint][$n]['teamname']=$teamname;
	$all_teams[$sortpoint][$n]['joincups']=$joincups;
	$all_teams[$sortpoint][$n]['awards1']=$ar_awards[1];
	$all_teams[$sortpoint][$n]['awards2']=$ar_awards[2];
	$all_teams[$sortpoint][$n]['awards3']=$ar_awards[3];

	if(isset($ar1_name)){
		$a=1;
		foreach($ar1_name as $cup_names){
			$all_teams[$sortpoint][$n]['a1_cupname'][$a]=$cup_names;
			$a++;
		}
	}
	unset($ar1_name);
	if(isset($ar2_name)){
		$a=1;
		foreach($ar2_name as $cup_names){
			$all_teams[$sortpoint][$n]['a2_cupname'][$a]=$cup_names;
			$a++;
		}
	}
	unset($ar2_name);
	if(isset($ar3_name)){
		$a=1;
		foreach($ar3_name as $cup_names){
			$all_teams[$sortpoint][$n]['a3_cupname'][$a]=$cup_names;
			$a++;
		}
	}
	unset($ar3_name);
	
	$used_teams[]=$db['clanID'];
	$n++;
}
krsort($all_teams);

$n=1;

if(!isset($all_teams)) {
	echo '<div '.$error_box.'> No records found</div>'; 
}

foreach($all_teams as $all_teams_for){
	foreach($all_teams_for as $clan){
		if($n%2) $bg=BG_1;
		else $bg=BG_2;		
		
		$teamID=$clan['teamID'];
		$teamname='<a href="'.(!$one ? '?site=clans&action=show&clanID='.$teamID.'">'.$clan['teamname'] : '?site=profile&id='.$teamID.'">'.$clan['teamname']).'</a>';
		
		$joincups=$clan['joincups'];
			
		$award1 = '';
		if($clan['awards1']){
			for($i=1; $i<=$clan['awards1']; $i++)
				$award1.='<a href="'.(!$lad ? '?site=brackets&action=tree&cupID='.$clan['a1_cupname'][$i] : '?site=standings&ladderID='.$clan['a1_cupname'][$i]).'"><img src="images/cup/icons/award_gold.png" border="0" alt="'.$_language->module['gold'].'" title="'.($lad ? getladname($clan['a1_cupname'][$i]) : getcupname($clan['a1_cupname'][$i])).'" /></a>'; 
		}
		$award2 = '';
		if($clan['awards2']){
			for($i=1; $i<=$clan['awards2']; $i++)
				$award2.='<a href="'.(!$lad ? '?site=brackets&action=tree&cupID='.$clan['a2_cupname'][$i] : '?site=standings&ladderID='.$clan['a2_cupname'][$i]).'"><img src="images/cup/icons/award_silver.png" border="0" alt="'.$_language->module['silver'].'" title="'.($lad ? getladname($clan['a2_cupname'][$i]) : getcupname($clan['a2_cupname'][$i])).'" /></a>';
		}
		$award3 = '';
		if($clan['awards3']){
			for($i=1; $i<=$clan['awards3']; $i++)
				$award3.='<a href="'.(!$lad ? '?site=brackets&action=tree&cupID='.$clan['a3_cupname'][$i] : '?site=standings&ladderID='.$clan['a3_cupname'][$i]).'"><img src="images/cup/icons/award_bronze.png" border="0" alt="'.$_language->module['bronze'].'" title="'.($lad ? getladname($clan['a3_cupname'][$i]) : getcupname($clan['a3_cupname'][$i])).'" /></a>';
		}
		
		$awards=$award1.$award2.$award3;
		
		if(empty($awards)) 
			continue;

		$score_ratio = percent(user_cup_points($teamID,0,$team,$won=1,$lost=0,$type="confirmed_p",0), user_cup_points($teamID,0,$team,$won=0,$lost=0,$type="confirmed_p",0), 2);              
		$ratio_level = ratio_level($teamID,$one);   
		
		safe_query("UPDATE ".PREFIX."cup_clans SET rt = '$score_ratio' WHERE clanID='$teamID' && 1on1='$one'");
	
	        $cd=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_all_clans WHERE ID='$teamID'"));
		$md=mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."cup_matches WHERE (clan1='$teamID' || clan2='$teamID') && einspruch='0' && confirmscore='1' && 1on1='$one' ORDER BY matchID DESC LIMIT 0,1"));
	
	        if($_GET['type']=='one') {
		        $r_bgcolor = ($teamID==$userID ? $bg2 : $bg1);
		        $avatar = 'images/avatars/'.getavatar($teamID);  
                        $show_country = getusercountry2($teamID);
		        $show_matches = '<a href="?site=matches&action=viewmatches&memberID='.$teamID.'"><img border="0" src="images/cup/icons/add_result.gif" align="right"></a>';
			$link = '?site=profile&id='.$teamID;
		}
		else{
		        $r_bgcolor = (memin($userID,$teamID) ? $bg2 : $bg1);
		        $avatar = (empty($cd['clanlogo']) ? 'images/avatars/noavatar.gif' : $cd['clanlogo']);  
                        $show_country = getclancountry4($teamID);
		        $show_matches = '<a href="?site=matches&action=viewmatches&clanID='.$teamID.'"><img border="0" src="images/cup/icons/add_result.gif" align="right"></a>';
			$link = '?site=clans&action=show&clanID='.$teamID;
			
		}		
		
		if(($md[clan1] == $teamID && $md[score1] > $md[score2]) || ($md[clan2] == $teamID && $md[score1] < $md[score2])) {
		    $arrow = '<img src="images/cup/icons/rank_up.gif" alt="Last match win">';
		}
		elseif(($md[clan1] == $teamID && $md[score1] < $md[score2]) || ($md[clan2] == $teamID && $md[score1] > $md[score2])){
		    $arrow = '<img src="images/cup/icons/rank_down.gif" alt="Last match loss">';
		}
		else{
		    $arrow = '<img src="images/cup/icons/refresh.png" width="15" height="12" alt="Last match draw">';
		}
		
		$cl=mysqli_fetch_array(safe_query("SELECT count(*) as num FROM ".PREFIX."cup_clans WHERE clanID='$teamID' && 1on1='$one' && type='ladder'"));
		
                echo '<tr>
		         <td bgcolor="'.$r_bgcolor.'" align="center">'.$arrow.$n.'</td>
                         <td bgcolor="'.$r_bgcolor.'"><div style="margin-top: 5px; position: relative;">'.$show_country.'</div> <div style="margin-top: 0px; margin-right: 25px; position: relative;">'.$show_matches.'</div>
                            <img src="'.$avatar.'" width="24" height="24">
				  	<span class="link">
					  <a href="javascript: void(0)" onclick="location.href=\''.$link.'\';"><strong>'.$clan['teamname'].'</strong>
					    <span >  				  					
				  	       <center>	
						  <img src="'.$avatar.'" width="100" height="100"><br>
				  	       </center>	
					    </span>
					  </a>
				  	</span>
				('.$joincups.')
                         </td>
                         <td bgcolor="'.$r_bgcolor.'" align="center">'.$score_ratio.'%</td>
                         <td bgcolor="'.$r_bgcolor.'" align="center">'.$awards.'</td>
                         <td bgcolor="'.$r_bgcolor.'" align="center">'.$ratio_level.'</td>
                      </tr>';

	
		//eval ("\$inctemp = \"".gettemplate("hof_content")."\";");
		//echo $inctemp;
		
		unset($award1,$award2,$award3,$awards);
		$n++;
	}	
}
eval ("\$inctemp = \"".gettemplate("hof_foot")."\";");
}
echo $inctemp.($cpr ? ca_copyr() : die());
?>