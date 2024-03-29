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
#   Copyright 2005-2011 by webspell.org                                  #
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

//Options

$galleries_per_row = 2;
$pics_per_row = 2;

//Script

$bgcat = BGCAT;
$pagebg = PAGEBG;

if( isset( $_GET['action'] ) ) $action = $_GET['action'];
else $action = '';

if(isset($_POST['saveedit'])) {

	include('_mysql.php');
	include('_settings.php');
	include('_functions.php');

	$_language->read_module('gallery');

	$galclass = new Gallery;

	$ds = mysqli_fetch_array(safe_query("SELECT galleryID FROM ".PREFIX."gallery_pictures WHERE picID='".$_POST['picID']."'"));

	if((isgalleryadmin($userID) or $galclass->isgalleryowner($ds['galleryID'], $userID)) and $_POST['picID']) {

		safe_query("UPDATE ".PREFIX."gallery_pictures SET name='".$_POST['name']."', comment='".$_POST['comment']."', comments='".(int)$_POST['comments']."' WHERE picID='".$_POST['picID']."'");
		if(isset($_POST['reset'])) safe_query("UPDATE ".PREFIX."gallery_pictures SET views='0' WHERE picID='".$_POST['picID']."'");

	}
	else redirect('index.php?site=gallery', $_language->module['no_pic_set']);

	redirect('index.php?site=gallery&amp;picID='.$_POST['picID'], '', 0);

}
elseif($action == "edit") {

	$_language->read_module('gallery');

	if($_GET['id']) {

		$ds = mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."gallery_pictures WHERE picID='".$_GET['id']."'"));

		$picID = $_GET['id'];
		$bg1 = BG_1;
		$comments = '<option value="0">'.$_language->module['no_comments'].'</option><option value="1">'.$_language->module['user_comments'].'</option><option value="2">'.$_language->module['visitor_comments'].'</option>';
		$comments = str_replace('value="'.$ds['comments'].'"', 'value="'.$ds['comments'].'" selected="selected"', $comments);
		$name = str_replace('"', '&quot;', getinput($ds['name']));
		$comment = getinput($ds['comment']);
		eval ("\$gallery = \"".gettemplate("gallery_edit")."\";");
		echo $gallery;
	}
	else redirect('index.php?site=gallery', $_language->module['no_pic_set']);

}
elseif($action == "delete") {

	include('_mysql.php');
	include('_settings.php');
	include('_functions.php');

	$galclass = new Gallery;

	$ds=mysqli_fetch_array(safe_query("SELECT galleryID FROM ".PREFIX."gallery_pictures WHERE picID='".$_GET['id']."'"));

	if((isgalleryadmin($userID) or $galclass->isgalleryowner($ds['galleryID'], $userID)) and $_GET['id']) {

		$ds = mysqli_fetch_array(safe_query("SELECT galleryID FROM ".PREFIX."gallery_pictures WHERE picID='".$_GET['id']."'"));
		
		$dir='images/gallery/';
		
		//delete thumb

		@unlink($dir.'thumb/'.$_GET['id'].'.jpg');

		//delete original

		if(file_exists($dir.'large/'.$_GET['id'].'.jpg')) @unlink($dir.'large/'.$_GET['id'].'.jpg');
		else @unlink($dir.'large/'.$_GET['id'].'.gif');

		//delete database entry

		safe_query("DELETE FROM ".PREFIX."gallery_pictures WHERE picID='".$_GET['id']."'");
		safe_query("DELETE FROM ".PREFIX."comments WHERE parentID='".$_GET['id']."' AND type='ga'");
	}
	redirect('index.php?site=gallery&amp;galleryID='.$ds['galleryID'], '', 0);
}
elseif($action == "diashow" OR $action == "window") {

	include('_mysql.php');
	include('_settings.php');
	include('_functions.php');

	$_language->read_module('gallery');

	if(!isset($_GET['picID']))	{
		$result = mysqli_fetch_array(safe_query("SELECT picID FROM ".PREFIX."gallery_pictures WHERE galleryID='".(int)$_GET['galleryID']."' ORDER BY picID ASC LIMIT 0,1"));
		$picID = (int)$result['picID'];
	}
	else $picID = (int)$_GET['picID'];

	//get name+comment
	$ds = mysqli_fetch_array(safe_query("SELECT name, comment FROM ".PREFIX."gallery_pictures WHERE picID='".$picID."'"));

	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="description" content="Clanpage using webSPELL 4 CMS" />
<meta name="author" content="webspell.org" />
<meta name="keywords" content="webspell, webspell4, clan, cms" />
<meta name="copyright" content="Copyright &copy; 2005 - 2011 by webspell.org" />
<meta name="generator" content="webSPELL" />
<title>'.$_language->module['webs_diashow'].' '.$ds['name'].'</title>
<link href="_stylesheet.css" rel="stylesheet" type="text/css" />';

	//get next

	$browse = mysqli_fetch_array(safe_query("SELECT picID FROM ".PREFIX."gallery_pictures WHERE galleryID='".(int)$_GET['galleryID']."' AND picID>".$picID." ORDER BY picID ASC LIMIT 0,1"));
	
  if($browse['picID'] and $_GET['action'] == "diashow") echo '<meta http-equiv="refresh" content="2;URL=gallery.php?action=diashow&amp;galleryID='.(int)$_GET['galleryID'].'&amp;picID='.$browse['picID'].'" />';

	echo '</head><body><center>';

	if($_GET['action'] == "diashow") {
		if($browse['picID']) {
			echo '<a href="gallery.php?action=diashow&amp;galleryID='.$_GET['galleryID'].'&amp;picID='.$browse['picID'].'">';
			safe_query("UPDATE ".PREFIX."gallery_pictures SET views=views+1 WHERE picID='".$picID."'");
		}
	}
	else echo '<a href="javascript:close()">';

	//output image

	echo '<img src="picture.php?id='.$picID.'" border="0" alt="" /><br /><b>'.cleartext($ds['comment'], false).'</b>';

	if($browse['picID'] or $_GET['action'] == "window") echo '</a>';

	echo '</center></body></html>';

}
elseif(isset($_GET['picID'])) {

	$_language->read_module('gallery');

	$galclass = new Gallery;

	eval("\$gallery = \"".gettemplate("title_gallery")."\";");
	echo $gallery;

	$ergebnis = safe_query("SELECT * FROM ".PREFIX."gallery_pictures WHERE picID='".$_GET['picID']."'");
	if(mysqli_num_rows($ergebnis)){
	
		$ds = mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."gallery_pictures WHERE picID='".$_GET['picID']."'"));
		safe_query("UPDATE ".PREFIX."gallery_pictures SET views=views+1 WHERE picID='".$_GET['picID']."'");
	
		$picturename = clearfromtags($ds['name']);
		$picID = $ds['picID'];
	
		$picture=$galclass->getlargefile($picID);
	
		$picinfo = getimagesize($picture);
		$xsize = $picinfo[0];
		$ysize = $picinfo[1];
	
		$xwindowsize = $xsize+30;
		$ywindowsize = $ysize+30;
	
		$comment = cleartext($ds['comment'], false);
		$views = $ds['views'];
	
		if($xsize>$picsize_l) $width = 'width="'.$picsize_l.'"';
		else $width = 'width="'.$xsize.'"';
	
		$filesize = round(filesize($picture)/1024,1);
	
		//next picture
		$browse = mysqli_fetch_array(safe_query("SELECT picID FROM ".PREFIX."gallery_pictures WHERE galleryID='".$ds['galleryID']."' AND picID>".$ds['picID']." ORDER BY picID ASC LIMIT 0,1"));
		if($browse['picID']) $forward = '<a href="index.php?site=gallery&amp;picID='.$browse['picID'].'#picture">'.$_language->module['next'].' &raquo;</a>';
    else $forward='';
	
		$browse = mysqli_fetch_array(safe_query("SELECT picID FROM ".PREFIX."gallery_pictures WHERE galleryID='".$ds['galleryID']."' AND picID<".$ds['picID']." ORDER BY picID DESC LIMIT 0,1"));
		if($browse['picID']) $backward = '<a href="index.php?site=gallery&amp;picID='.$browse['picID'].'#picture">&laquo; '.$_language->module['back'].'</a>';
    else $backward='';
	
		//rateform
	
		if($loggedin) {
	
			$getgallery = safe_query("SELECT gallery_pictures FROM ".PREFIX."user WHERE userID='".$userID."'");
			$found = false;
			if(mysqli_num_rows($getgallery)) {
				$ga = mysqli_fetch_array($getgallery);
				if($ga['gallery_pictures'] != "") {
					$string = $ga['gallery_pictures'];
					$array = explode(":", $string);
					$anzarray = count($array);
					for($i = 0; $i < $anzarray; $i++) {
						if($array[$i] == $_GET['picID']) $found = true;
					}
				}
			}
	
			if($found) $rateform="<i>".$_language->module['you_have_already_rated']."</i>";
			else $rateform='<form method="post" name="rating_picture'.$_GET['picID'].'" action="rating.php">'.$_language->module['rate_now'].'
								<select name="rating">
								<option>0 - '.$_language->module['poor'].'</option>
								<option>1</option>
								<option>2</option>
								<option>3</option>
								<option>4</option>
								<option>5</option>
								<option>6</option>
								<option>7</option>
								<option>8</option>
								<option>9</option>
								<option>10 - '.$_language->module['perfect'].'</option>
								</select>
								<input type="hidden" name="userID" value="'.$userID.'" />
								<input type="hidden" name="type" value="ga" />
								<input type="hidden" name="id" value="'.$_GET['picID'].'" />
		 						<input type="submit" name="submit" value="'.$_language->module['rate'].'" /></form>';
	
		}
		else $rateform = '<i>'.$_language->module['rate_have_to_reg_login'].'</i>';
	
		$votes = $ds['votes'];
	
		unset($ratingpic);
		$ratings = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		for($i = 0; $i < $ds['rating']; $i++) {
			$ratings[$i] = 1;
		}
		$ratingpic = '<img src="images/icons/rating_'.$ratings[0].'_start.gif" width="1" height="5" alt="" />';
		foreach($ratings as $pic) {
			$ratingpic .= '<img src="images/icons/rating_'.$pic.'.gif" width="4" height="5" alt="" />';
		}
	
		//admin
	
		if((isgalleryadmin($userID) and $publicadmin) or $galclass->isgalleryowner($ds['galleryID'],$userID)) {
			$adminaction = '<input type="button" onclick="MM_goToURL(\'parent\',\'index.php?site=gallery&amp;action=edit&amp;id='.$_GET['picID'].'\');return document.MM_returnValue" value="'.$_language->module['edit'].'" /> <input type="button" onclick="MM_confirm(\''.$_language->module['really_del'].'\', \'gallery.php?action=delete&amp;id='.$_GET['picID'].'\')" value="'.$_language->module['delete'].'" />';
		}
		else $adminaction = "";
	
		//group+gallery
	
		$gallery = '<a href="index.php?site=gallery&amp;galleryID='.$ds['galleryID'].'" class="titlelink">'.$galclass->getgalleryname($_GET['picID']).'</a>';
		if($galclass->getgroupid_by_gallery($ds['galleryID'])) $group = '<a href="index.php?site=gallery&amp;groupID='.$galclass->getgroupid_by_gallery($ds['galleryID']).'" class="titlelink">'.$galclass->getgroupname($galclass->getgroupid_by_gallery($ds['galleryID'])).'</a>';
		else $group = '<a href="index.php?site=gallery&amp;groupID=0" class="titlelink">'.$_language->module['usergalleries'].'</a> &gt;&gt; <a href="index.php?site=profile&amp;action=galleries&amp;id='.$galclass->getgalleryowner($ds['galleryID']).'" class="titlelink">'.getnickname($galclass->getgalleryowner($ds['galleryID'])).'</a>';
	  
		eval("\$gallery = \"".gettemplate("gallery_comments")."\";");
		echo $gallery;
	
		//comments
	
		$comments_allowed = $ds['comments'];
		$parentID = $ds['picID'];
		$type = "ga";
		$referer = "index.php?site=gallery&amp;picID=".$ds['picID'];
	
		include("comments.php");
	}
}
elseif(isset($_GET['galleryID'])) {

	$_language->read_module('gallery');

	$galclass = new Gallery;

	eval("\$gallery = \"".gettemplate("title_gallery")."\";");
	echo $gallery;

	$ds = mysqli_fetch_array(safe_query("SELECT name FROM ".PREFIX."gallery WHERE galleryID='".$_GET['galleryID']."'"));
	$title = str_break(clearfromtags($ds['name']), 45);
	$pics = mysqli_num_rows(safe_query("SELECT picID FROM ".PREFIX."gallery_pictures WHERE galleryID='".$_GET['galleryID']."'"));
	$pages = ceil($pics/$gallerypictures);
	$galleryID = $_GET['galleryID'];
	if($galclass->getgroupid_by_gallery($_GET['galleryID'])) $group = '<a href="index.php?site=gallery&amp;groupID='.$galclass->getgroupid_by_gallery($_GET['galleryID']).'" class="titlelink">'.$galclass->getgroupname($galclass->getgroupid_by_gallery($_GET['galleryID'])).'</a>';
	else $group = '<a href="index.php?site=gallery&amp;groupID=0" class="titlelink">'.$_language->module['usergalleries'].'</a> &gt;&gt; <a href="index.php?site=profile&amp;action=galleries&amp;id='.$galclass->getgalleryowner($_GET['galleryID']).'" class="titlelink">'.getnickname($galclass->getgalleryowner($_GET['galleryID'])).'</a>';

	if(!isset($_GET['page'])) $page = 1;
	else $page = $_GET['page'];

	if($pages>1) $pagelink = makepagelink("index.php?site=gallery&amp;galleryID=".$_GET['galleryID'], $page, $pages);
	else $pagelink = '<img src="images/icons/multipage.gif" width="10" height="12" alt="" /> <small>'.$_language->module['pg_1_1'].'</small>';

	if($page == "1") {
		$ergebnis = safe_query("SELECT * FROM ".PREFIX."gallery_pictures WHERE galleryID='".$_GET['galleryID']."' ORDER BY picID LIMIT 0, ".$gallerypictures);
	}
	else {
		$start = $page * $gallerypictures - $gallerypictures;
		$ergebnis = safe_query("SELECT * FROM ".PREFIX."gallery_pictures WHERE galleryID='".$_GET['galleryID']."' ORDER BY picID LIMIT ".$start.", ".$gallerypictures);
	}
	if(mysqli_num_rows($ergebnis)){
		$diashow = "<strong>- <a href=\"javascript:MM_openBrWindow('gallery.php?action=diashow&amp;galleryID=$galleryID','webspell_diashow','toolbar=no,status=no,scrollbars=yes')\"><small>[".$_language->module['start_diashow']."]</small></a></strong>";
	}
	else {
		$diashow = "";
	}
	eval("\$gallery = \"".gettemplate("gallery_gallery_head")."\";");
	echo $gallery;
	echo '<tr>';
	$i = 1;

	$percent = 100 / $pics_per_row;

	while($pic = mysqli_fetch_array($ergebnis)) {

		if($i % 2) $bg = BG_2;
		else $bg = BG_1;
		
		$dir='images/gallery/';
		
		$pic['pic'] = $dir.'thumb/'.$pic['picID'].'.jpg';
		if(!file_exists($pic['pic'])) $pic['pic'] = 'images/nopic.gif';
		$pic['name'] = clearfromtags($pic['name']);
		$pic['comment'] = cleartext($pic['comment'], false);
		$pic['comments'] = mysqli_num_rows(safe_query("SELECT commentID FROM ".PREFIX."comments WHERE parentID='".$pic['picID']."' AND type='ga'"));

		eval("\$gallery = \"".gettemplate("gallery_showlist")."\";");
		echo $gallery;

		if($pics_per_row > 1) {
			if(($i - 1) % $pics_per_row==($pics_per_row-1)) echo '</tr><tr>';
		}
		else echo '</tr><tr>';
		$i++;
	}
	echo '<td bgcolor="'.$bgcat.'">&nbsp;</td></tr>';

	eval("\$gallery = \"".gettemplate("gallery_gallery_foot")."\";");
	echo $gallery;

}
elseif(isset($_GET['groupID'])) {

	$_language->read_module('gallery');

	$galclass = new Gallery;

	eval ("\$gallery = \"".gettemplate("title_gallery")."\";");
	echo $gallery;

	$galleries = mysqli_num_rows(safe_query("SELECT galleryID FROM ".PREFIX."gallery WHERE groupID='".$_GET['groupID']."'"));
	$pages = ceil($galleries/$gallerypictures);

	if(!isset($_GET['page'])) $page = 1;
	else $page = $_GET['page'];

	if($pages > 1) $pagelink = makepagelink("index.php?site=gallery&amp;groupID=".$_GET['groupID'], $page, $pages);
	else $pagelink = '<img src="images/icons/multipage.gif" width="10" height="12" alt="" /> <small>'.$_language->module['pg_1_1'].'</small>';

	$group = $galclass->getgroupname($_GET['groupID']);
	if($_GET['groupID'] == 0) $group = $_language->module['usergalleries'];

	eval ("\$gallery = \"".gettemplate("gallery_group_head")."\";");
	echo $gallery;

	if ($page == "1") {
		$ergebnis = safe_query("SELECT * FROM ".PREFIX."gallery WHERE groupID='".$_GET['groupID']."' ORDER BY galleryID DESC LIMIT 0, ".$gallerypictures);
	}
	else {
		$start=$page*$gallerypictures-$gallerypictures;
		$ergebnis = safe_query("SELECT * FROM ".PREFIX."gallery WHERE groupID='".$_GET['groupID']."' ORDER BY galleryID DESC LIMIT ".$start.", ".$gallerypictures);
	}

	echo '<tr>';
	$i = 1;

	while($gallery = mysqli_fetch_array($ergebnis)) {

		if($i % 2) $bg = BG_2;
		else $bg = BG_1;
		
		$dir='images/gallery/';
		
		$gallery['picID'] = $galclass->randompic($gallery['galleryID']);
		$gallery['pic'] = $dir.'thumb/'.$gallery['picID'].'.jpg';
		$gallery['pics'] = mysqli_num_rows(safe_query("SELECT picID FROM ".PREFIX."gallery_pictures WHERE galleryID='".$gallery['galleryID']."'"));
		$gallery['date'] = date("d.m.Y - H:i",$gallery['date']);
		if(!file_exists($gallery['pic'])) $gallery['pic'] = 'images/nopic.gif';

		eval ("\$gallery = \"".gettemplate("gallery_showlist_group")."\";");
		echo $gallery;
	
		if($galleries_per_row > 1) {
			if(($i - 1) % $galleries_per_row==($galleries_per_row-1)) echo '</tr><tr>';
		}
		else echo '</tr><tr>';

		$i++;
	}
	echo '<td>&nbsp;</td></tr>';

	eval("\$gallery = \"".gettemplate("gallery_group_foot")."\";");
	echo $gallery;

}
else {

	$_language->read_module('gallery');

	$galclass = new Gallery;

	eval("\$gallery = \"".gettemplate("title_gallery")."\";");
	echo $gallery;

	//latest gallery
	$ds = mysqli_fetch_array(safe_query("SELECT galleryID FROM ".PREFIX."gallery WHERE userID='0' ORDER BY galleryID DESC LIMIT 0, 1"));
	$latest = $galclass->showthumb($galclass->randompic($ds['galleryID']));
	
	//random
	$random = $galclass->showthumb($galclass->randompic());

	//top comments
	$ds = mysqli_fetch_array(safe_query("SELECT parentID, COUNT(parentID) as max FROM ".PREFIX."comments WHERE type='ga' GROUP BY parentID ORDER BY max DESC LIMIT 0, 1"));
	if(!$ds['parentID']) $ds['parentID'] = $galclass->randompic();
	$most_comments = $galclass->showthumb($ds['parentID']);
	$bg1 = BG_1;
	$bg2 = BG_2;
	
  eval("\$gallery = \"".gettemplate("gallery_content_head")."\";");
	echo $gallery;

	$ergebnis = safe_query("SELECT * FROM ".PREFIX."gallery_groups ORDER BY sort");

	while($ds = mysqli_fetch_array($ergebnis)) {

		$groupID = $ds['groupID'];
		$title = $ds['name'];
		$gallerys = mysqli_num_rows(safe_query("SELECT galleryID FROM ".PREFIX."gallery WHERE groupID='".$ds['groupID']."'"));
		$pics = mysqli_num_rows(safe_query("SELECT picID FROM ".PREFIX."gallery as gal, ".PREFIX."gallery_pictures as pic WHERE gal.groupID='".$ds['groupID']."' AND gal.galleryID=pic.galleryID"));

		eval ("\$gallery_groups = \"".gettemplate("gallery_content_categorys_head")."\";");
		echo $gallery_groups;

		$bg = BG_1;

    $gallery = mysqli_fetch_array(safe_query("SELECT * FROM ".PREFIX."gallery WHERE groupID='".$ds['groupID']."' ORDER BY galleryID DESC LIMIT 0,1"));
		$gallery['picture'] = $galclass->randompic($gallery['galleryID']);
		if(isset($gallery['date'])) $gallery['date'] = date('d.m.Y', $gallery['date']);
		if(isset($gallery['galleryID'])) $gallery['count'] = mysqli_num_rows(safe_query("SELECT picID FROM ".PREFIX."gallery_pictures WHERE galleryID='".$gallery['galleryID']."'"));

		if(isset($gallery['count'])) {
			$gallery['name']=$gallery['name'];
			eval ("\$gallery_groups = \"".gettemplate("gallery_content_showlist")."\";");
			echo $gallery_groups;
		}
		else echo '<tr bgcolor="'.$bg1.'"><td colspan="4">'.$_language->module['no_gallery_exists'].'</td></tr>';

		eval ("\$gallery_groups = \"".gettemplate("gallery_content_categorys_foot")."\";");
		echo $gallery_groups;
	}
}
?>