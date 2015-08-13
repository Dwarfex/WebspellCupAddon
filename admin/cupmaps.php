<?php

include("../config.php");

$query = safe_query("SELECT mappack FROM ".PREFIX."cup_maps GROUP BY mappack");
    while($cm=mysql_fetch_array($query)) {
        $mp_exists[]=$cm['mappack'];   
    }

//run queries

if($_GET['editmp']=='true') 
{
   if(in_array($_POST['mappack'],$mp_exists)) die('<b>'.$_POST['mappack'].'</b> already exists!');
   safe_query("UPDATE ".PREFIX."cup_maps SET mappack = '".$_POST['mappack']."' WHERE mappack = '".$_GET['mappack']."'");
   redirect('admincenter.php?site=cupmaps&mappack='.$_POST['mappack'].'', '<b>'.$_POST['mappack'].'</b> successfully renamed!', 2);
}

if($_GET['mapID'] && $_GET['mappack'] && $_GET['edit']=='true' && $_GET['editmap']=='true') 
{
   safe_query("UPDATE ".PREFIX."cup_maps SET map='".$_POST['newmap']."', pic='".$_POST['newpic']."' WHERE mapID='".$_GET['mapID']."'");
   redirect('admincenter.php?site=cupmaps&mappack='.$_GET['mappack'].'', '<b>'.$_POST['newmap'].'</b> successfully edited!', 2);
}

if($_GET['newmap']=='true') 
{
   if(!$_POST['newmap']) die('You must type in a map name to add a new map to the '.$_GET['mappack'].' mappack.');
   safe_query("INSERT INTO ".PREFIX."cup_maps (mappack, map, pic) VALUES ('".$_GET['mappack']."', '".$_POST['newmap']."', '".$_POST['newpic']."')");
   redirect('admincenter.php?site=cupmaps&mappack='.$_GET['mappack'].'', '<b>'.$_POST['newmap'].'</b> successfully added to <b>'.$_GET['mappack'].'</b> mappack!', 2);
}

if(isset($_GET['action']) && $_GET['action']=="removemap") 
{
   safe_query("DELETE FROM ".PREFIX."cup_maps WHERE map='".$_GET['map']."' && mappack='".$_GET['pack']."'");
   redirect('admincenter.php?site=cupmaps&mappack='.$_GET['pack'].'', '<b>'.$_GET['map'].'</b> successfully deleted from <b>'.$_GET['pack'].'</b> mappack!', 2);
}

if(isset($_GET['delete']) && $_GET['delete']=="true") 
{
   safe_query("DELETE FROM ".PREFIX."cup_maps WHERE mappack='".$_GET['mappack']."'");
   redirect('admincenter.php?site=cupmaps', '<b>'.$_GET['mappack'].'</b> successfully deleted!', 2);
}

if($_POST['createmappack']) {

    $a = $_POST["i"];

    for ($i=1; $i<$a; $i++) {
        $arr[] = $_POST["map" . ($a-$i)] . "," . $_POST["pic" . ($a-$i)] ;
    }

    foreach ($arr as $val) {
        $anas[]= explode (",", $val);
    }

    if ($_POST['mappack'] == "" || $_POST['mappack'] == " " || in_array($_POST['mappack'],$mp_exists)) {
        echo "<font color='red'><b>You must enter a mappack name or enter a non-existing mappack.</b></font>";
        
    } else {

    for ($i=0; $i<($a-1); $i++) {
		if ($anas[$i][0] == "" || $anas[$i][0] == " ") {
		echo "<font color='red'><b>You MUST enter in all maps. Reduce quantity to enter less.</b></font>";
		break;
		
    } else {
		
		safe_query("INSERT INTO ".PREFIX."cup_maps (`mappack`, `map`, `pic`) VALUES ('".$_POST['mappack']."', '".$anas[$i][0]."', '".$anas[$i][1]."')");
		
      } redirect('admincenter.php?site=cupmaps', '', 0);  
    }
  }  
}

//end queries 

if($_GET['created']=="true")
   echo "<font color='red'><b>Mappack successfully created!</b></font>";

function getmappack($ID) {
    $ds=mysql_fetch_array(safe_query("SELECT mappack FROM ".PREFIX."cup_maps WHERE mappack='$ID'")); 
    return $ds['mappack'];
}

if(!isset($_GET['mappack']))
  echo '<h2>Ladder Mappacks</h2>';

 $maps = '<option value="">-- Edit Mappack -- </option>';

  $query = safe_query("SELECT * FROM ".PREFIX."cup_maps GROUP BY mappack");
      while($ds=mysql_fetch_array($query)) {
          $maps.='<option value="'.$ds['mappack'].'">'.$ds['mappack'].'</option>';
      }

      echo '<select name="mappack" onChange="MM_confirm(\'Edit Mappack?\', \'admincenter.php?site=cupmaps&mappack=\'+this.value)">'.$maps.'</select>
            OR <input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=cupmaps&action=create\');return document.MM_returnValue" value="Create Mappack">';

if(isset($_GET['mappack'])) 
{
  
if($_GET['edit']!='true') 
{
   echo '<h2>Mappack for '.getmappack($_GET['mappack']).'</h2>'; 
   $edit_false = '<input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=cupmaps&mappack='.$_GET['mappack'].'&edit=true\');return document.MM_returnValue" value="Open-Edit">
                  <input type="button" class="button" onClick="MM_confirm(\'Are you sure you want to delete the '.$_GET['mappack'].' mappack? All map information for matches will no longer be visible.\', \'admincenter.php?site=cupmaps&delete=true&mappack='.$_GET['mappack'].'\')" value="Delete Pack">';
   $show_reg = '<td class="title"></td>';

}
else
{

   echo '<h2>Mappack for 
             <form method="post" name="post" action="admincenter.php?site=cupmaps&mappack='.$_GET['mappack'].'&editmp=true&edit=true">
                 <input name="mappack" value="'.getmappack($_GET['mappack']).'" type="text" class="form_off" onfocus="this.className=\'form_on\'" onblur="this.className=\'form_off\'">
                 <input type="image" value="savemappack" src="../images/cup/icons/server_edit.gif" width="16" height="16" border="0" alt="Save Mappack" name="savemappack">
             </form></h2>'; 
   $edit_false = '<input type="button" class="button" onClick="MM_goToURL(\'parent\',\'admincenter.php?site=cupmaps&mappack='.$_GET['mappack'].'\');return document.MM_returnValue" value="Close-Edit & Discard Changes">
                  <input type="button" class="button" onClick="MM_confirm(\'Are you sure you want to delete the '.$_GET['mappack'].' mappack? All map information for matches will no longer be visible.\', \'admincenter.php?site=cupmaps&delete=true&mappack='.$_GET['mappack'].'\')" value="Delete Pack">';
   $show_action = '<td class="title">Action:</td>';
   
}
  
 echo '
        <table width="100%" cellpadding="2" cellspacing="1"">
         <tr bgcolor="#FFFFFF">
		    <td colspan="9">'.$edit_false.'</td>
          </tr>
          <tr>
		    <td class="title">Map:</td>
		    <td class="title">Pic:</td>
            '.$show_reg.'
            '.$show_action.'
	      </tr>';
  
 $query = safe_query("SELECT * FROM ".PREFIX."cup_maps WHERE mappack='".$_GET['mappack']."'");  
 while($ds=mysql_fetch_array($query)) 
 {
 
 if(!$ds['pic']) 
 {  
     $pic = '<img src="../images/nopic.gif" width="'.$map_width .'" height="'.$map_height.'">';
 }
 else
 { 
     $pic = '<img src="'.$ds['pic'].'" width="'.$map_width .'" height="'.$map_height.'">';
 }
     
  if($_GET['edit']!='true') 
  {
   
       echo '
		  <tr>
		    <td>('.$ds['mapID'].') '.$ds['map'].'</td>
		    <td>'.$pic.'</td>
		    <td></td>
		  </tr>
			<tr>
			  <td><hr></td>
			  <td><hr></td>
			  <td><hr></td>
		  </tr>';	
   
  }
  else
  {

        $mp = $_GET['mappack'];
        
		eval ("\$inctemp = \"".gettemplate("maps_content")."\";");
		echo $inctemp; 
		
		$add_map = '
           <form method="post" name="post" action="admincenter.php?site=cupmaps&mappack='.$mp.'&newmap=true&edit=true">
               <tr>
                <td><input name="newmap" value="" type="text" class="form_off" onfocus="this.className=\'form_on\'" onblur="this.className=\'form_off\'"></td>
                <td><input name="newpic" value="" type="text" class="form_off" onfocus="this.className=\'form_on\'" onblur="this.className=\'form_off\'" size="60"></td>
                <td><input type="image" value="savemap" src="../images/cup/icons/addresult.gif" width="16" height="16" border="0" alt="Save Map" name="savenew"></td>
              </tr>
			   <tr>
				<td><hr></td>
				<td><hr></td>
				<td><hr></td>
		      </tr>
           </table></form>';  
		
		

  }
 		
    }   echo $add_map.'
           </table></form>';   
 }
 
if(isset($_GET['action']) && $_GET['action']=="create") 
{

  $quantity = '<option value="">-- Select Quantity --</option>';
  
  for ($i = 1; $i <= 50; $i += 1) {
  $quantity.='<option value="'.$i.'">'.$i.' Map(s)</option>'; }

  echo '<br><br>How many maps to be included in pack? (more can be added later)<br>
        <select name="quantity" onChange="MM_confirm(\'Click OK to proceed to mappack creation.\', \'admincenter.php?site=cupmaps&action=create&maps=\'+this.value)">'.$quantity.'</select>';

if(isset($_GET['action']) && $_GET['action']=="create" && isset($_GET['maps'])) 
{
  
echo '<form method="post" name="post" action="">';
  
  for ($i = 1; $i <= $_GET['maps']; $i += 1) {
  $type_maps.='<br><b>Map #'.$i.':</b> <input name="map'.$i.'" value="'.$_POST['map'.$i].'" type="text" class="form_off" onfocus="this.className=\'form_on\'" onblur="this.className=\'form_off\'">
                                      <input name="pic'.$i.'" value="'.$_POST['pic'.$i].'" type="text" class="form_off" onfocus="this.className=\'form_on\'" onblur="this.className=\'form_off\'" size="60"><br>'; }
  
  
    echo '
            <table width="100%" cellpadding="2" cellspacing="1">
              <tr>
                <td class="title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Map Name</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Map URL (optional)</b></td>
              </tr>
              <tr>
                <tr><br><hr><br><b>Mappack:</b> <input name="mappack" value="'.$_POST['mappack'].'" type="text" class="form_off" onfocus="this.className=\'form_on\'" onblur="this.className=\'form_off\'"></td>
                <td>'.$type_maps.'</td>
              </tr>
              <tr>
				<td><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="createmappack" value="Add Mappack"></td>
				<td></td>
			  </tr>
            </table>
          <input value="'.$i.'" name="i" type="hidden" />
          </form>';
  
  }

}

?>