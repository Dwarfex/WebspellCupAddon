<?php
include("config.php");

  $clans = safe_query("SELECT * FROM ".PREFIX."cup_all_clans ORDER BY reg DESC LIMIT 0,$sc_clans");
  
  if(mysql_num_rows($clans)) {
      echo '<table width="100%">';
  
    while($ds = mysql_fetch_array($clans)) {
	
	    $length_scc = $sc_clans_length; 
		$str_clan = strlen($ds['name'])-$length_scc;
		$sc_clan = (strlen($ds['name']) > $length_scc ? $ds['name'].'..' : $ds['name']);
		
		$clanlogo = ($ds['clanlogo'] && $ds['clanlogo']!='http://' ? '<img src="'.$ds['clanlogo'].'" height="16" width="16">' : '<img src="images/avatars/noavatar.gif" height="16" width="16">');
        $clanname = '<a href="?site=clans&action=show&clanID='.$ds['ID'].'">'.$sc_clan.'</a>';
	
        echo '<tr>
	            <td>
	              '.$clanlogo.' '.$clanname.' -
	              '.date('M dS Y', $ds['reg']).'
				</td>
              </tr>'; 

    }

    echo '</table>';

  }
  else{
        echo '';
  }
?>