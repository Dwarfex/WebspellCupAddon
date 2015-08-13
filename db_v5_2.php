<?php
include("admin/cupversion.php");
include("config.php");

if($version_num==5208.3) 
$ver_notice = '<b>You are running '.$version_num.', click <a href="?site=db_v5_2&action=5209update"><b>here</b></a> to update to the next version.<br /><br /></b>';

$release_date = "29/12/2013";
//(V5.2 r3 8th Release: 17/08/2013)
//(V5.2 7th Release: 14/02/2013)
//(V5.2 6th Release: 31/12/2012)
//(V5.2 5th Release: 10/09/2012)

$db_query_type = ($run_without_admin==1 ? 'mysql_query' : 'safe_query');
$validation = 0;

if($run_without_admin == 1) {

   include ("_mysql.php");
   mysql_connect($host, $user, $pwd) or die ('ERROR: Can not connect to SQL.');
   mysql_select_db($db) or die ('ERROR: Could not connect to "'.$db.'", please check connection in _mysql.php!');
   
   $validation = 1;
}
else{
   $validation = true;
//   if(issuperadmin($userID)) $validation = true;
//   else $validation = 0;
}

 if($validation == true) {

   if(isset($_GET['action']) && $_GET['action']=="install") { 

		$db_query_type("CREATE TABLE `".PREFIX."cups` (
		  `ID` int(11) NOT NULL auto_increment,
		  `platID` int(11) NOT NULL default '0',
		  `gameaccID` int(11) NOT NULL,
		  `name` varchar(255) NOT NULL,
		  `desc` longtext NOT NULL,
		  `game` varchar(255) NOT NULL,
		  `typ` varchar(6) NOT NULL,
		  `maxclan` int(3) NOT NULL default '0',
		  `start` int(15) NOT NULL default '0',
		  `ende` int(15) NOT NULL default '0',		  
		  `gs_start` int(15) NOT NULL default '0',
		  `gs_end` int(15) NOT NULL default '0',		  
		  `gs_maxrounds` int(15) NOT NULL default '0',
		  `gs_staging` int(15) NOT NULL default '1',
		  `gs_regtype` int(15) NOT NULL default '0',
		  `gs_trans` int(15) NOT NULL default '1',	  
		  `gs_dxp` int(15) NOT NULL default '0',	
          `gs_mwe` int(11) NOT NULL default '1',		  
		  `status` int(1) NOT NULL default '0',
		  `gewinn1` varchar(255) NOT NULL,
		  `gewinn2` varchar(255) NOT NULL,
		  `gewinn3` varchar(255) NOT NULL,
		  `1on1` int(1) NOT NULL default '0',
		  `checkin` int(11) NOT NULL default '0',
		  `clanmembers` int(11) NOT NULL default '0',
          `cupgalimit` int(11) NOT NULL default '1', 
          `cupaclimit` int(11) NOT NULL default '0', 
          `gameacclimit` int(11) NOT NULL default '1', 
          `cgameacclimit` int(11) NOT NULL default '0',
          `ratio_low` int(11) NOT NULL default '0',
          `ratio_high` int(11) NOT NULL default '0',
          `timezone` varchar(255) NOT NULL,
          `discheck` int(1) NOT NULL default '0',  
          `agents` int(1) NOT NULL default '1', 		  
		  PRIMARY KEY  (`ID`)
		) AUTO_INCREMENT=1;");

		$db_query_type("CREATE TABLE `".PREFIX."cup_admins` (
		  `adminID` int(11) NOT NULL auto_increment,
		  `cupID` int(11) NOT NULL default '0',
		  `ladID` int(11) NOT NULL default '0',
		  `userID` int(11) NOT NULL default '0',
		  PRIMARY KEY  (`adminID`)
		) AUTO_INCREMENT=1;");
		
		$db_query_type("CREATE TABLE IF NOT EXISTS `".PREFIX."cup_agents` (
		  `ID` int(11) NOT NULL auto_increment,
		  `userID` int(11) NOT NULL,
		  `cupID` int(11) NOT NULL,
		  `ladID` int(11) NOT NULL,
		  `avail` int(1) NOT NULL,
		  `name` varchar(255) NOT NULL,
		  `play` varchar(255) NOT NULL,
		  `info` longtext NOT NULL,
                  `time` int(15) NOT NULL,          
		  PRIMARY KEY  (`ID`)
		) AUTO_INCREMENT=1;");
		
		$db_query_type("DROP TABLE IF EXISTS `".PREFIX."cup_all_clans`");
		$db_query_type("CREATE TABLE `".PREFIX."cup_all_clans` (
		  `ID` int(11) NOT NULL auto_increment,
		  `name` varchar(255) NOT NULL,
		  `country` varchar(255) NOT NULL,
		  `short` varchar(255) NOT NULL,
		  `clantag` varchar(255) NOT NULL,
		  `clanhp` varchar(255) NOT NULL,
		  `clanlogo` varchar(255) NOT NULL,
		  `leader` int(11) NOT NULL default '0',
		  `password` varchar(255) NOT NULL,
		  `server` varchar(255) NOT NULL,
		  `port` varchar(255) NOT NULL,
		  `chat` INT(11) NOT NULL default '1',
		  `comment` INT(11) NOT NULL default '1',
		  `reg` int(15) NOT NULL,
		  `status` int(1) NOT NULL default '0',
		  PRIMARY KEY  (`ID`)
		) AUTO_INCREMENT=1;");
		
		
		$db_query_type("CREATE TABLE `".PREFIX."cup_baum` (
		  `ID` int(11) NOT NULL auto_increment,
		  `cupID` int(11) NOT NULL default '0',
		  `wb_winner` int(11) NOT NULL,
		  `lb_winner` int(11) NOT NULL,
		  `second_winner` int(11) NOT NULL,
		  `third_winner` int(11) NOT NULL,
		  `map1` varchar(255) NOT NULL,
		  `map2` varchar(255) NOT NULL,
		  `map3` varchar(255) NOT NULL,
		  `map4` varchar(255) NOT NULL,
		  `map5` varchar(255) NOT NULL,
		  `map6` varchar(255) NOT NULL,
		  `map7` varchar(255) NOT NULL,
		  `map8` varchar(255) NOT NULL,
		  `map9` varchar(255) NOT NULL,
		  `map10` varchar(255) NOT NULL,
		  `map11` varchar(255) NOT NULL,
		  `map12` varchar(255) NOT NULL,
		  `map13` varchar(255) NOT NULL,
		  `map14` varchar(255) NOT NULL,
		  `map15` varchar(255) NOT NULL,
                  `map16` varchar(255) NOT NULL,
                  `map17` varchar(255) NOT NULL,
		  `borderbg` varchar(255) NOT NULL,
		  `bg1` varchar(255) NOT NULL,
		  `bg2` varchar(255) NOT NULL,
		  PRIMARY KEY  (`ID`)
		) AUTO_INCREMENT=1;");

		$db_query_type("CREATE TABLE `".PREFIX."cup_challenges` (
		  `chalID` int(11) NOT NULL auto_increment,
		  `ladID` int(11) NOT NULL default '0',
		  `challenger` int(11) NOT NULL,
		  `challenged` int(11) NOT NULL,
		  `map1` varchar(255) NOT NULL,
		  `map2` varchar(255) NOT NULL,
		  `map3` varchar(255) NOT NULL,
		  `map4` varchar(255) NOT NULL,
		  `map5` varchar(255) NOT NULL,
		  `map1_final` varchar(255) NOT NULL,
		  `map2_final` varchar(255) NOT NULL,
		  `map3_final` varchar(255) NOT NULL,
		  `map4_final` varchar(255) NOT NULL,
		  `new_date` int(15) NOT NULL,
		  `reply_date` int(15) NOT NULL,
		  `finalized_date` int(15) NOT NULL,
		  `game_date` int(15) NOT NULL,
		  `date1` int(15) NOT NULL,
		  `date2` int(15) NOT NULL,
		  `date3` int(15) NOT NULL,
          `date4` int(15) NOT NULL,
          `date5` int(15) NOT NULL,
		  `server` varchar(255) NOT NULL,
		  `port` int(5) NOT NULL,
		  `serverc` varchar(255) NOT NULL,
		  `challenger_info` longtext NOT NULL,
		  `challenged_info` longtext NOT NULL,
		  `forfeit` int(11) NOT NULL,
		  `status` int(11) NOT NULL,	
          `1on1` int(1) NOT NULL,
		  `chr_credit` int(11) NOT NULL default '0',
		  `chd_credit` int(11) NOT NULL default '0',
		  PRIMARY KEY (`chalID`)
		) AUTO_INCREMENT=1;");

		$db_query_type("CREATE TABLE `".PREFIX."cup_clans` (
		  `ID` int(11) NOT NULL auto_increment,
		  `cupID` varchar(11) NOT NULL default '0',
		  `platID` int(11) NOT NULL,
		  `ladID` varchar(11) NOT NULL default '0',
		  `groupID` int(11) NOT NULL,
		  `game` varchar(255) NOT NULL,
		  `credit` int(11) NOT NULL,
		  `registered` int(15) NOT NULL,
		  `clanID` int(11) NOT NULL,
		  `1on1` int(1) NOT NULL,
		  `checkin` int(1) NOT NULL,
		  `won` int(11) NOT NULL,
		  `draw` int(11) NOT NULL,
		  `lost` int(11) NOT NULL,
		  `streak` int(11) NOT NULL,
		  `elo` int(11) NOT NULL,
		  `xp` int(11) NOT NULL,
		  `tp` int(11) NOT NULL,
		  `rt` int(11) NOT NULL,
		  `wc` int(11) NOT NULL,
		  `ma` int(11) NOT NULL,
		  `lastpos` int(1) NOT NULL,
		  `lastact` int(15) NOT NULL,
          `lastdeduct` int(15) NOT NULL,
          `qual` int(1) NOT NULL,
          `pm` int(1) NOT NULL,	
          `rank_now` int(11) NOT NULL,
          `rank_then` int(11) NOT NULL,
          `type` varchar(255) NOT NULL, 		  
		  PRIMARY KEY  (`ID`)
		) AUTO_INCREMENT=1;");

		$db_query_type("CREATE TABLE `".PREFIX."cup_clan_lineup` (
		  `ID` int(11) NOT NULL auto_increment,
		  `cupID` int(11) NOT NULL default '0',
		  `ladID` int(11) NOT NULL default '0',
		  `clanID` int(11) NOT NULL default '0',
		  `userID` int(11) NOT NULL default '0',
		  PRIMARY KEY  (`ID`)
		) AUTO_INCREMENT=1 ;");		

		$db_query_type("CREATE TABLE `".PREFIX."cup_clan_members` (
		  `ID` int(11) NOT NULL auto_increment,
		  `cupID` int(11) NOT NULL default '0',
		  `ladID` int(11) NOT NULL default '0',
		  `clanID` int(11) NOT NULL default '0',
		  `userID` int(11) NOT NULL default '0',
		  `function` varchar(255) NOT NULL,
		  `reg` int(15) NOT NULL,
		  `agent` int(1) NOT NULL,
		  PRIMARY KEY  (`ID`)
		) AUTO_INCREMENT=1;");

		$db_query_type("CREATE TABLE `".PREFIX."cup_deduction` (
		  `ID` int(11) NOT NULL auto_increment,
		  `ladID` int(11) NOT NULL default '0',
		  `clanID` int(11) NOT NULL default '0',
		  `deducted` int(11) NOT NULL default '0',
		  `terminated` int(1) NOT NULL,
		  `credit` int(11) NOT NULL,
		  `time` int(15) NOT NULL,
		  PRIMARY KEY  (`ID`)
		) AUTO_INCREMENT=1;");

		$db_query_type("CREATE TABLE `".PREFIX."cup_departments` (
		  `ID` int(11) NOT NULL auto_increment,
		  `department` varchar(255) NOT NULL,
		  PRIMARY KEY  (`ID`)
		) AUTO_INCREMENT=1;");

		$db_query_type("CREATE TABLE `".PREFIX."cup_ladders` (
		  `ID` int(11) NOT NULL auto_increment,
		  `platID` int(11) NOT NULL default '0',
		  `mappack` varchar(255) NOT NULL,
		  `gameaccID` int(11) NOT NULL,
		  `name` varchar(255) NOT NULL,
		  `abbrev` varchar(255) NOT NULL,
		  `desc` longtext NOT NULL,
		  `game` varchar(255) NOT NULL,
		  `gametype` varchar(255) NOT NULL,
		  `maxclan` int(3) NOT NULL,
		  `start` int(15) NOT NULL,
		  `end` int(15) NOT NULL,
		  `gs_start` int(15) NOT NULL,
		  `gs_end` int(15) NOT NULL,
		  `gs_maxrounds` int(11) NOT NULL,
		  `gs_staging` int(1) NOT NULL,
		  `gs_regtype` int(1) NOT NULL,
		  `gs_trans` int(1) NOT NULL,
		  `gs_mwe` int(11) NOT NULL default '1',
		  `ratio_low` int(11) NOT NULL,
		  `ratio_high` int(11) NOT NULL,
          `type` varchar(6) NOT NULL,
          `mode` int(1) NOT NULL,
		  `ranksys` int(1) NOT NULL,
		  `select_map` int(11) NOT NULL,
		  `selected_map` int(11) NOT NULL,
		  `select_date` int(11) NOT NULL,
		  `timestart` varchar(255) NOT NULL,
		  `timeintervals` int(15) NOT NULL,			  
		  `timeend` varchar(255) NOT NULL,
		  `timetorespond` int(15) NOT NULL,
		  `timetofinalize` int(15) NOT NULL,
		  `challallow` int(11) NOT NULL,
		  `challquant` int(11) NOT NULL,
		  `inactivity` int(15) NOT NULL,
		  `deduct_credits` int(11) NOT NULL,
		  `remove_inactive` int(15) NOT NULL,
		  `playdays` int(15) NOT NULL,
		  `ad_report` int(1) NOT NULL,
		  `challup` int(11) NOT NULL,
		  `challdown` varchar(255) NOT NULL,
		  `status` int(11) NOT NULL,
		  `gewinn1` varchar(255) NOT NULL,
		  `gewinn2` varchar(255) NOT NULL,
		  `gewinn3` varchar(255) NOT NULL,
		  `1on1` int(1) NOT NULL,
		  `clanmembers` int(1) NOT NULL,
		  `gameacclimit` int(1) NOT NULL,
		  `cgameacclimit` int(1) NOT NULL,
		  `d_xp` int(1) NOT NULL,
          `timezone` varchar(255) NOT NULL, 
          `1st` int(11) NOT NULL,
          `2nd` int(11) NOT NULL,	
          `3rd` int(11) NOT NULL,  
          `sign` int(1) NOT NULL,
          `cupgalimit` int(11) NOT NULL default '1', 
          `cupaclimit` int(11) NOT NULL default '0',	
          `agents` int(1) NOT NULL default '1',		  
          `crechall` int(11) NOT NULL default '0',	
          `crerep` int(11) NOT NULL default '0',	 
		  `kfa_type` int(1) NOT NULL,
		  `kfa_fixed` int(11) NOT NULL default '32',
		  `kfa_bel` int(11) NOT NULL default '32',
		  `kfa_bet` int(11) NOT NULL default '24',
		  `kfa_abo` int(11) NOT NULL default '16',
		  `elo_bel` int(11) NOT NULL default '2100',
		  `elo_bet1` int(11) NOT NULL default '2100',
		  `elo_bet2` int(11) NOT NULL default '2400',
		  `elo_abo` int(11) NOT NULL default '2400',
		  PRIMARY KEY  (`ID`)
		) AUTO_INCREMENT=1;");

		$db_query_type("CREATE TABLE `".PREFIX."cup_maps` (
		  `mapID` int(11) NOT NULL auto_increment,
		  `mappack` varchar(255) NOT NULL,
		  `map` varchar(255) NOT NULL,
		  `pic` varchar(255) NOT NULL,
		  PRIMARY KEY  (`mapID`)
		) AUTO_INCREMENT=1;");

		$db_query_type("CREATE TABLE `".PREFIX."cup_matches` (
		  `matchID` int(11) NOT NULL auto_increment,
		  `cupID` varchar(11) NOT NULL,
		  `ladID` varchar(11) NOT NULL,
		  `platID` varchar(11) NOT NULL default '0',
		  `date` int(15) NOT NULL,
		  `date2` varchar(255) NOT NULL,
		  `added_date` int(15) NOT NULL,
		  `inscribed_date` int(15) NOT NULL,
		  `confirmed_date` int(15) NOT NULL,
		  `matchno` int(11) NOT NULL,
		  `clan1` int(11) NOT NULL,
		  `clan2` int(11) NOT NULL,
		  `score1` int(11) NOT NULL,
		  `score2` int(11) NOT NULL,		  
		  `map1_score1` int(11) NOT NULL,
		  `map1_score2` int(11) NOT NULL,
		  `map2_score1` int(11) NOT NULL,
		  `map2_score2` int(11) NOT NULL,
		  `map3_score1` int(11) NOT NULL,
		  `map3_score2` int(11) NOT NULL,
		  `map4_score1` int(11) NOT NULL,
		  `map4_score2` int(11) NOT NULL,		  
		  `server` varchar(255) NOT NULL,
		  `hltv` varchar(255) NOT NULL,
		  `screens` varchar(255) NOT NULL,
		  `screen_name` text NOT NULL,
		  `screen_upper` varchar(255) NOT NULL,
		  `report` varchar(255) NOT NULL,
		  `report_team1` text NOT NULL,
		  `report_team2` text NOT NULL,
		  `inscribed` int(1) NOT NULL,
		  `confirmscore` int(1) NOT NULL default '0',
		  `einspruch` int(1) NOT NULL default '0',
		  `comment` int(1) NOT NULL default '2',
		  `clan1_credit` int(11) NOT NULL default '0',
		  `clan2_credit` int(11) NOT NULL default '0',
		  `1on1` int(1) NOT NULL,
		  `si` int(1) NOT NULL,
          `type` varchar(255) NOT NULL,
		  PRIMARY KEY  (`matchID`)
		) AUTO_INCREMENT=1;");


		$db_query_type("CREATE TABLE `".PREFIX."cup_platforms` (
		  `ID` int(11) NOT NULL auto_increment,
		  `platform` varchar(255) NOT NULL,
		  `name` varchar(255) NOT NULL,
		  `abbrev` varchar(255) NOT NULL,
		  `descrip` longtext NOT NULL,
          `logo` varchar(255) NOT NULL,
          `status` int(11) NOT NULL default '1',
		  PRIMARY KEY  (`ID`)
		) AUTO_INCREMENT=1;");

		$db_query_type("CREATE TABLE `".PREFIX."cup_requests` (
		  `ID` int(11) NOT NULL auto_increment,
		  `matchID` int(11) NOT NULL,
		  `userID` int(11) NOT NULL,
		  `reason` varchar(255) NOT NULL,
		  `time` int(15) NOT NULL,
		  PRIMARY KEY  (`ID`)
		) AUTO_INCREMENT=1;");

		$db_query_type("CREATE TABLE `".PREFIX."cup_rules` (
		  `rulesID` int(11) NOT NULL auto_increment,
		  `cupID` int(11) NOT NULL,
		  `ladID` int(11) NOT NULL,
		  `value` longtext NOT NULL,
		  `lastedit` int(15) NOT NULL,
		  PRIMARY KEY  (`rulesID`)
		) AUTO_INCREMENT=1;");

		$db_query_type("CREATE TABLE `".PREFIX."cup_settings` (
		  `settingID` int(11) NOT NULL auto_increment,
		  `cupaclimit` INT(11) NOT NULL default '0',
	      `cupblockage` INT(11) NOT NULL default '10',
	      `cupteamlimit` INT(11) NOT NULL default '15',
	      `cupteamadd` INT(11) NOT NULL default '1',
          `cupteamjoin` INT(11) NOT NULL default '4',
          `cupsclimit` INT(11) NOT NULL default '3',
          `cupgalimit` INT(11) NOT NULL default '1',
          `cupgamelimit` INT(11) NOT NULL default '1',
          `ccupgamelimit` INT(11) NOT NULL default '0', 
          `gameacclimit` INT(11) NOT NULL default '0',
          `cgameacclimit` INT(11) NOT NULL default '1',
          `cupchathost` varchar(255) NOT NULL default 'irc.evolu.net',
          `cupinfo` INT(11) NOT NULL default '1',
          `maintenance` INT(11) NOT NULL default '0',
          `timezone` varchar(255) NOT NULL default 'Europe/London',
		  PRIMARY KEY  (`settingID`)
		) AUTO_INCREMENT=1;");

		$db_query_type("CREATE TABLE `".PREFIX."cup_tickets` (
		  `ticketID` int(11) NOT NULL auto_increment,
		  `department` int(11) NOT NULL,
	      `userID` int(11) NOT NULL,
	      `adminID` int(11) NOT NULL,
	      `cupID` int(11) NOT NULL,
          `ladID` int(11) NOT NULL,
          `matchID` int(11) NOT NULL,
          `subject` varchar(255) NOT NULL,
          `desc` longtext NOT NULL,
          `time` int(15) NOT NULL, 
          `updated` int(15) NOT NULL,
          `comment` int(1) NOT NULL,
          `status` int(11) NOT NULL default '1',
		  PRIMARY KEY (`ticketID`)
		) AUTO_INCREMENT=1;");

		$db_query_type("CREATE TABLE `".PREFIX."cup_warnings` (
		  `warnID` int(11) NOT NULL auto_increment,
		  `clanID` int(11) NOT NULL,
		  `adminID` int(11) NOT NULL,
		  `points` int(11) NOT NULL,
		  `title` varchar(255) NOT NULL,
		  `desc` varchar(255) NOT NULL,
		  `matchlink` varchar(255) NOT NULL,
		  `time` int(15) NOT NULL,
		  `deltime` int(15) NOT NULL,
		  `1on1` int(11) NOT NULL,
		  `expired` int(11) NOT NULL,
		  PRIMARY KEY  (`warnID`)
		) AUTO_INCREMENT=1;");
		
		$db_query_type("CREATE TABLE IF NOT EXISTS `".PREFIX."tchat` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `channelID` int(11) NOT NULL,
		  `pseudo` varchar(255) NOT NULL,
		  `message` varchar(255) NOT NULL,
		  `heure` varchar(255) NOT NULL,
		  `type` varchar(255) NOT NULL,
		  `sound` int(1) NOT NULL,
		  PRIMARY KEY (`ID`)
		) AUTO_INCREMENT=1;");

		$db_query_type("CREATE TABLE IF NOT EXISTS `".PREFIX."tchat_private` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `userID` varchar(255) NOT NULL,
		  `friend` varchar(255) NOT NULL,
		  `message` varchar(255) NOT NULL,
		  `heure` varchar(255) NOT NULL,
		  PRIMARY KEY (`ID`)
		) AUTO_INCREMENT=1;");
		
		$db_query_type("ALTER TABLE `".PREFIX."whoisonline` 
            ADD `channelID` int(11) NOT NULL AFTER `time`,
            ADD `url` varchar(255) NOT NULL, 
            ADD `type` varchar(255) NOT NULL, 		  
		    ADD `afk` int(1) NOT NULL,	  
            ADD `call` int(1) NOT NULL,
            ADD `calltimer` int(15) NOT NULL;");
		
		$db_query_type("ALTER TABLE `".PREFIX."whowasonline` 	  	  
		  ADD `url` varchar(255) NOT NULL;");
		
	$db_query_type("ALTER TABLE ".PREFIX."user 
	    ADD `msn` varchar(255) NOT NULL default 'n/a',
	    ADD `skype` varchar(255) NOT NULL default 'na',
	    ADD `yahoo` varchar(255) NOT NULL default 'n/a',
	    ADD `aim` varchar(255) NOT NULL default 'n/a',
	    ADD `xfirec` varchar(255) NOT NULL default 'n/a',
	    ADD `steam` varchar(255) NOT NULL default 'n/a',
	    ADD `sc_id` varchar(255) NOT NULL,
	    ADD `xfire` varchar(60) NOT NULL,
	    ADD `xfirestyle` varchar(255) NOT NULL,
	    ADD `xfiregroesse` int(10) NOT NULL,
	    ADD `clanesl` varchar(50) NOT NULL default 'n/a',
	    ADD `storage` varchar(50) NOT NULL default 'n/a',
	    ADD `headset` varchar(50) NOT NULL default 'n/a',
	    ADD `fgame` varchar(50) NOT NULL default 'n/a',
	    ADD `fclan` varchar(50) NOT NULL default 'n/a',
	    ADD `fmap` varchar(50) NOT NULL default 'n/a',
	    ADD `fweapon` varchar(50) NOT NULL default 'n/a',
	    ADD `ffood` varchar(50) NOT NULL default 'n/a',
	    ADD `fdrink` varchar(50) NOT NULL default 'n/a',
	    ADD `fmovie` varchar(50) NOT NULL default 'n/a',
	    ADD `fmusic` varchar(50) NOT NULL default 'n/a',
	    ADD `fsong` varchar(50) NOT NULL default 'n/a',
	    ADD `fbook` varchar(50) NOT NULL default 'n/a',
	    ADD `factor` varchar(50) NOT NULL default 'n/a',
	    ADD `fcar` varchar(50) NOT NULL default 'n/a',
	    ADD `fsport` varchar(50) NOT NULL default 'n/a',
		ADD `jgrowl` int(1) NOT NULL default '1',	
        ADD `timezone` varchar(255) NOT NULL default '0';");	

		$db_query_type("CREATE TABLE `".PREFIX."gameacc` (
		  `gameaccID` int(11) NOT NULL auto_increment,
		  `type` varchar(255) NOT NULL,
		  PRIMARY KEY  (`gameaccID`)
		) AUTO_INCREMENT=1;");

		$db_query_type("ALTER TABLE `".PREFIX."user_groups` ADD `cup` int(1) NOT NULL default '0'");
		
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (10, 'BF1942 CD-Hashkey');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (9, 'AoE3 ESO Nick');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (8, 'AAO PB GUID');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (11, 'BF2 PB_GUID');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (12, 'BF:V PB_GUID');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (13, 'BFME EA Login');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (14, 'BFME2 EA Login');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (15, 'Blitzkrieg 2');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (16, 'COD PB GUID');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (17, 'COD UO PB GUID');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (18, 'COD2 PB GUID');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (19, 'Carom3d Account Number');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (20, 'CoD GUID');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (21, 'CoD 2 GUID');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (22, 'Code Alienware');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (23, 'Counter-Strike Manager');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (24, 'Cyanide Chaosleague');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (25, 'Diablo 2 Battlenet(EU)');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (26, 'EA-Login');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (27, 'ET PB GUID');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (28, 'ETPro GUID');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (29, 'Fear PB GUID');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (30, 'FarCry PB GUID');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (31, 'FIFA 04 Matchmaker');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (32, 'FIFA 05 Matchmaker');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (33, 'FIFA 06 Matchmaker');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (34, 'FIFA WM 06 Matchmaker');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (35, 'GameSpy ID');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (36, 'Gunbound_ID');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (37, 'Gunz Nick');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (38, 'ICQ');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (39, 'Joint Operations GUID');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (40, 'LFS Ingame Nick');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (41, 'LFS-World Nick');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (42, 'Lanfield ID');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (43, 'MOH:AA DMW ID');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (44, 'MOH:PA PG GUID');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (45, 'Matchmaker FIFA UEFA');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (46, 'NBA 2005 Matchmaker');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (47, 'NBA 2006 Matchmaker');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (48, 'NFS Online User Name');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (49, 'NHL 2005 Matchmaker');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (50, 'NHL 2006 Matchmaker');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (51, 'OFP PlayerID');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (52, 'PES5 Lobbynick');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (53, 'Q3 PB GUID');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (54, 'Quake4 PB GUID');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (55, 'R6: Raven Shield GUID');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (56, 'RS: Lockdown PB GUID');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (57, 'SCBW Battlenet(EU)');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (58, 'SCBW Battlenet(ntc)');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (59, 'Schach.de Login');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (60, 'SoF2 PB GUID');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (61, 'Spellforce 2 Login');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (62, 'SteamID');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (63, 'SteamID CS:CZ');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (64, 'SteamID DoD:S');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (65, 'SteamID HL2/CSS');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (66, 'carom3d.com Login Name');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (67, 'SteamID RO');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (68, 'Trackmania Nations');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (69, 'UT2003 GUID');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (70, 'UT2004 GUID');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (71, 'Ubi Login');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (72, 'Vietcong ID');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (73, 'WC3 Battlenet(EU)');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (74, 'WC3 Battlenet for ENC');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (75, 'WonID (HL)');");
		$db_query_type("INSERT INTO `".PREFIX."gameacc` VALUES (76, 'carom3d.com Login Name');");
		$db_query_type("INSERT INTO `".PREFIX."cup_settings` VALUES (1, '0', '10', '15', '1', '4', '3', '1', '1', '0', '0', '1', 'irc.evolu.net', '1', '0', 'Europe/London');"); 

		$db_query_type("CREATE TABLE `".PREFIX."user_gameacc` (
		  `gameaccID` int(11) NOT NULL auto_increment,
		  `userID` int(11) NOT NULL default '0',
		  `type` int(11) NOT NULL default '0',
		  `value` varchar(255) NOT NULL,
		  `log` int(11) NOT NULL default '0',
		  PRIMARY KEY  (`gameaccID`)
		) AUTO_INCREMENT=1 ;");
		
	  $db_status = '<font color="red"><strong>The cup has been successfully installed! </strong></font>';
   
   }elseif(isset($_GET['action']) && $_GET['action']=="uninstall") {
   
    $db_query_type("ALTER TABLE `".PREFIX."user` 
    DROP `msn`,
    DROP `skype`,
    DROP `yahoo`,
    DROP `aim`,
    DROP `xfirec`,
    DROP `steam`,
    DROP `sc_id`,
    DROP `xfire`,
    DROP `xfirestyle`,
    DROP `xfiregroesse`,
    DROP `clanesl`,
    DROP `storage`,
    DROP `headset`,
    DROP `fgame`,
    DROP `fclan`,
    DROP `fmap`,
    DROP `fweapon`,
    DROP `ffood`,
    DROP `fdrink`,
    DROP `fmovie`,
    DROP `fmusic`,
    DROP `fsong`,
    DROP `fbook`,
    DROP `factor`,
    DROP `fcar`,
    DROP `fsport`");
	
	$db_query_type("DELETE FROM ".PREFIX."comments WHERE type='cm' OR type='tc' OR type='ts'");
    
    $db_query_type("ALTER TABLE `".PREFIX."whoisonline` 
    DROP `channelID`,
    DROP `url`,
    DROP `type`,
    DROP `afk`,
    DROP `call`,
    DROP `calltimer`");
    
    $db_query_type("ALTER TABLE `".PREFIX."whowasonline` DROP `url`");
    
    $db_query_type("DROP TABLE IF EXISTS `".PREFIX."cups`");
    $db_query_type("DROP TABLE IF EXISTS `".PREFIX."cup_clan_lineup`");
    $db_query_type("DROP TABLE IF EXISTS `".PREFIX."cup_settings`");
    $db_query_type("DROP TABLE IF EXISTS `".PREFIX."cup_tickets`");
    $db_query_type("DROP TABLE IF EXISTS `".PREFIX."cup_admins`");
    $db_query_type("DROP TABLE IF EXISTS `".PREFIX."cup_agents`");
    $db_query_type("DROP TABLE IF EXISTS `".PREFIX."cup_requests`");
    $db_query_type("DROP TABLE IF EXISTS `".PREFIX."cup_baum`");
    $db_query_type("DROP TABLE IF EXISTS `".PREFIX."cup_challenges`");
    $db_query_type("DROP TABLE IF EXISTS `".PREFIX."cup_clan_members`");
    $db_query_type("DROP TABLE IF EXISTS `".PREFIX."cup_deduction`");
    $db_query_type("DROP TABLE IF EXISTS `".PREFIX."cup_departments`");
    $db_query_type("DROP TABLE IF EXISTS `".PREFIX."cup_ladders`");
    $db_query_type("DROP TABLE IF EXISTS `".PREFIX."cup_maps`");
    $db_query_type("DROP TABLE IF EXISTS `".PREFIX."cup_clans`");
    $db_query_type("DROP TABLE IF EXISTS `".PREFIX."cup_all_clans`");
    $db_query_type("DROP TABLE IF EXISTS `".PREFIX."cup_matches`");
    $db_query_type("DROP TABLE IF EXISTS `".PREFIX."cup_platforms`");
    $db_query_type("DROP TABLE IF EXISTS `".PREFIX."cup_rules`");
    $db_query_type("DROP TABLE IF EXISTS `".PREFIX."cup_warnings`");
    $db_query_type("DROP TABLE IF EXISTS `".PREFIX."gameacc`");
    $db_query_type("DROP TABLE IF EXISTS `".PREFIX."user_gameacc`");
    $db_query_type("DROP TABLE IF EXISTS `".PREFIX."tchat`");
    $db_query_type("DROP TABLE IF EXISTS `".PREFIX."tchat_private`");
    $db_query_type("ALTER TABLE `".PREFIX."user_groups` DROP `cup`");
    
  if(isset($_GET['reinstall'])=="true") {
  
    if($run_without_admin == 1)
	      $db_status =  '<font color="red"><strong>Uninstall failed: Because you are running without admin access, you need to "Uninstall" then "Install".</strong></font>';  
    else{
          $db_status =  '<font color="red"><strong>Successfully uninstalled, now reinstalling...</strong></font>';  
          redirect('?site=db_v5_2&action=install', '', 2);   	   
    }
  }
  else{
    
    $db_status =  '<font color="red"><strong>The cup has been successfully uninstalled!</strong></font>';  
    
  }
	
 }elseif(isset($_GET['action']) && $_GET['action']=="update") {
 

/* THE UPDATE */

		$db_query_type("CREATE TABLE IF NOT EXISTS `".PREFIX."cup_agents` (
		  `ID` int(11) NOT NULL auto_increment,
		  `userID` int(11) NOT NULL,
		  `cupID` int(11) NOT NULL,
		  `ladID` int(11) NOT NULL,
		  `avail` int(1) NOT NULL,
		  `name` varchar(255) NOT NULL,
		  `play` varchar(255) NOT NULL,
		  `info` longtext NOT NULL,
                  `time` int(15) NOT NULL,          
		  PRIMARY KEY  (`ID`)
		) AUTO_INCREMENT=1;");
		
		$db_query_type("ALTER TABLE  `".PREFIX."cup_clan_lineup` DROP INDEX  `cupID`");
		
		$db_query_type("ALTER TABLE `".PREFIX."cup_baum` 	  	  
		  ADD `second_winner` int(11) NOT NULL AFTER `lb_winner`;");
		
		$db_query_type("ALTER TABLE `".PREFIX."cups` 	  	  
		  ADD `timezone` varchar(255) NOT NULL,
		  ADD `discheck` int(1) NOT NULL default '0',
		  ADD `agents` int(1) NOT NULL default '1';");
		
		$db_query_type("ALTER TABLE `".PREFIX."cup_clan_lineup` 	  	  
		  ADD `ladID` int(11) NOT NULL AFTER `cupID`;");
		
		$db_query_type("ALTER TABLE `".PREFIX."cup_ladders` 
                  ADD `1st` int(11) NOT NULL,
                  ADD `2nd` int(11) NOT NULL,	
                  ADD `3rd` int(11) NOT NULL,		  
		          ADD `timezone` varchar(255) NOT NULL,
                  ADD `sign` int(1) NOT NULL,
				  ADD `cupgalimit` int(11) NOT NULL default '1', 
                  ADD `cupaclimit` int(11) NOT NULL,
				  ADD `agents` int(1) NOT NULL default '1',
				  ADD `crechall` int(11) NOT NULL default '0',	
				  ADD `crerep` int(11) NOT NULL default '0';");	
		
		$db_query_type("ALTER TABLE `".PREFIX."cup_clans` 
                  ADD `rt` int(11) NOT NULL,
		  ADD `type` varchar(255) NOT NULL;");
		
		$db_query_type("ALTER TABLE `".PREFIX."cup_clan_members` 
          ADD `agent` int(1) NOT NULL, 	
          ADD `ladID` int(11) NOT NULL default '0' AFTER `cupID`, 		  
		  ADD `reg` int(15) NOT NULL;");
		
		$db_query_type("ALTER TABLE `".PREFIX."cup_matches` 	  	  
		  ADD `date2` varchar(255) NOT NULL AFTER `date`,
		  ADD `clan1_credit` int(11) NOT NULL default '0' AFTER `comment`,
		  ADD `clan2_credit` int(11) NOT NULL default '0' AFTER `clan1_credit`;");

		$db_query_type("ALTER TABLE `".PREFIX."cup_challenges` 
		  ADD `chr_credit` int(11) NOT NULL default '0',		
		  ADD `chd_credit` int(11) NOT NULL default '0';");
		
		$db_query_type("CREATE TABLE IF NOT EXISTS `".PREFIX."tchat` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `channelID` int(11) NOT NULL,
		  `pseudo` varchar(255) NOT NULL,
		  `message` varchar(255) NOT NULL,
		  `heure` varchar(255) NOT NULL,
		  `type` varchar(255) NOT NULL,
		  `sound` int(1) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");

		$db_query_type("CREATE TABLE IF NOT EXISTS `".PREFIX."tchat_private` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `userID` varchar(255) NOT NULL,
		  `friend` varchar(255) NOT NULL,
		  `message` varchar(255) NOT NULL,
		  `heure` varchar(255) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
		
		$db_query_type("ALTER TABLE `".PREFIX."whoisonline` 
                  ADD `channelID` int(11) NOT NULL AFTER `time`,
                  ADD `url` varchar(255) NOT NULL, 
                  ADD `type` varchar(255) NOT NULL, 		  
		  ADD `afk` int(1) NOT NULL,
                  ADD `call` int(1) NOT NULL,
                  ADD `calltimer` int(15) NOT NULL;");
		
		$db_query_type("ALTER TABLE `".PREFIX."whowasonline` 	  	  
		  ADD `url` varchar(255) NOT NULL;");
		
		$db_query_type("ALTER TABLE `".PREFIX."user` 	
		          ADD `jgrowl` int(1) NOT NULL default '1',	
                  ADD `timezone` varchar(255) NOT NULL default '0';");
		
	  $db_status = '<font color="red"><strong>The cup has been successfully updated! Proceed to overwriting part 2.</strong></font>';
	  
/* END UPDATE */         
 
 
 }
 elseif(isset($_GET['action']) && $_GET['action']=="5204update") {
 
		$db_query_type("ALTER TABLE `".PREFIX."cup_ladders` 
                  ADD `1st` int(11) NOT NULL,
                  ADD `2nd` int(11) NOT NULL,	
                  ADD `3rd` int(11) NOT NULL;");
		
		$db_query_type("ALTER TABLE `".PREFIX."whoisonline` 
                  ADD `call` int(1) NOT NULL,
                  ADD `calltimer` int(15) NOT NULL;");
		
		$db_status = '<font color="red"><strong>The cup has been successfully updated to V5204/5205!</strong></font>';
 
 } 
 elseif(isset($_GET['action']) && $_GET['action']=="5206update") {
 
		$db_query_type("ALTER TABLE `".PREFIX."tchat` 	
                  ADD `sound` int(1) NOT NULL;");
		
		$db_query_type("ALTER TABLE `".PREFIX."cup_clan_lineup` 	  	  
		          ADD `ladID` int(11) NOT NULL AFTER `cupID`;")			  ;
		
		$db_query_type("ALTER TABLE `".PREFIX."cup_clan_members` 
                  ADD `ladID` int(11) NOT NULL default '0' AFTER `cupID`;") 		           ;
		
		$db_query_type("ALTER TABLE `".PREFIX."cup_ladders` 
                  ADD `sign` int(1) NOT NULL,
				  ADD `cupgalimit` int(11) NOT NULL default '1', 
                  ADD `cupaclimit` int(11) NOT NULL,
				  ADD `agents` int(1) NOT NULL default '1';");			
		
		$db_query_type("ALTER TABLE ".PREFIX."cup_ladders MODIFY challdown varchar(255) NOT NULL");
		$db_query_type("ALTER TABLE  `".PREFIX."cup_clan_lineup` DROP INDEX  `cupID`");
		
		$db_query_type("ALTER TABLE `".PREFIX."cups` 	  	  
		          ADD `discheck` int(1) NOT NULL default '0',
		          ADD `agents` int(1) NOT NULL default '1';");
		
		$db_status = '<font color="red"><strong>The cup has been successfully updated to build 5206!<br>Proceed to uploading/overwritting part 2 now.</strong></font>';
 
 } elseif(isset($_GET['action']) && $_GET['action']=="5207update") {
 
		$db_query_type("ALTER TABLE `".PREFIX."user` 
                  ADD `jgrowl` int(1) NOT NULL default '1',		
                  ADD `timezone` varchar(255) NOT NULL default '0';");
		
		$db_query_type("ALTER TABLE `".PREFIX."cup_ladders` 
				  ADD `crechall` int(11) NOT NULL default '0',	
				  ADD `crerep` int(11) NOT NULL default '0';");
		
        $db_query_type("ALTER TABLE ".PREFIX."cup_ladders MODIFY challdown varchar(255) NOT NULL");
		
 		$db_query_type("ALTER TABLE `".PREFIX."cup_matches` 	  	  
		  ADD `clan1_credit` int(11) NOT NULL default '0' AFTER `comment`,		
		  ADD `clan2_credit` int(11) NOT NULL default '0' AFTER `clan1_credit`;");	
	
		$db_query_type("ALTER TABLE `".PREFIX."cup_challenges` 	  	  
		  ADD `chr_credit` int(11) NOT NULL default '0',		
		  ADD `chd_credit` int(11) NOT NULL default '0';");
		  
		$db_status = '<font color="red"><strong>The cup has been successfully updated to V5207/5208 r3!</strong></font>';
 
 } elseif(isset($_GET['action']) && $_GET['action']=="5209update") {
 
		$db_query_type("ALTER TABLE `".PREFIX."cups` 
                  ADD `platID` int(11) NOT NULL default '0' AFTER `ID`,
				  ADD `gs_mwe` int(11) NOT NULL default '1' AFTER `gs_dxp`;");
				  
		$db_query_type("ALTER TABLE `".PREFIX."cup_matches` 
                  ADD `platID` int(11) NOT NULL default '0' AFTER `ladID`;");
				  
		$db_query_type("ALTER TABLE `".PREFIX."cup_clans` 
                  ADD `game` varchar(255) NOT NULL AFTER `groupID`,
				  ADD `elo` int(11) NOT NULL AFTER `streak`;");
				  
		$db_query_type("ALTER TABLE `".PREFIX."cup_ladders` 
          ADD `gs_mwe` int(11) NOT NULL default '1' AFTER `gs_trans`,		
		  ADD `kfa_type` int(1) NOT NULL AFTER `crerep`,
          ADD `kfa_fixed` int(11) NOT NULL default '32',	
          ADD `kfa_bel` int(11) NOT NULL default '32',	
          ADD `kfa_bet` int(11) NOT NULL default '24',	
          ADD `kfa_abo` int(11) NOT NULL default '16',	
          ADD `elo_bel` int(11) NOT NULL default '2100',	
          ADD `elo_bet1` int(11) NOT NULL default '2100',	
          ADD `elo_bet2` int(11) NOT NULL default '2400',			  
		  ADD `elo_abo` int(11) NOT NULL default '2400';");

		$db_status = '<font color="red"><strong>The cup has been successfully updated to 5209!</strong></font>';
 
 }
 
 elseif(isset($_GET['action']) && $_GET['action']=="checkfixes") {
  
		$db_status = '<font color="red"><strong>No changes done!</strong></font>';
 
 }
 
   if($db_status) 
   {
      $db_show = $db_status; 
   }
   else                
   {
      $db_show = '<img src="images/cup/new_message.gif"> <a href="?site=db_v5_2&action=install" onclick="return confirm(\'To prevent installation problems you are strongly advised to read the readme file. You cannot have the following addons installed (profile, gameaccount, tchat and whoisonline monitor). After success do not forget to upload part 2!\');">New Install (Build 5209)</a><br>
   			   <img src="images/cup/new_message.gif"> <a href="?site=db_v5_2&action=uninstall" onclick="return confirm(\'Important: This will remove all associated cup tables including removal of the following addons (profile, gameaccount, tchat and whoisonline monitor. Caution: part 2 files must be removed/overwritted with webspells files (if exist) before proceeding. \');">Uninstall Cup Addon</a><br>
			   <img src="images/cup/new_message.gif"> <a href="?site=db_v5_2&action=uninstall&reinstall=true" onclick="return confirm(\'Important: This will remove all associated cup tables including removal of the following addons (profile, gameaccount, tchat and whoisonline monitor) then reinstate them as empty. Caution: part 2 files must be removed/overwritted with webspells files (if exist) before proceeding.\');">Reinstall Cup Addon</a><br><br>
			   <img src="images/cup/new_message.gif"> <a href="?site=db_v5_2&action=5209update" onclick="return confirm(\'This will update to V5.2 Build 5209 (9th release)\');">Update from Build 5207/5208 r3 to 5209</a><br>
			   <img src="images/cup/new_message.gif"> <a href="?site=db_v5_2&action=5207update" onclick="return confirm(\'This will update to V5.2 Build 5207/5208 r3 (8th release)\');">Update from Build 5206 to 5207/5208 r3</a><br>
			   <img src="images/cup/new_message.gif"> <a href="?site=db_v5_2&action=5206update" onclick="return confirm(\'This will update to V5.2 Build 5206 (6th release)\');">Update from Build 5204/5205 to 5206</a><br>
			   <img src="images/cup/new_message.gif"> <a href="?site=db_v5_2&action=update" onclick="return confirm(\'Backup your database and files to avoid any data loss. You are advised also to read the readme file.\');">Update from V5.1 to V5.2 (Build 5206)</a><br>
			   <img src="images/cup/new_message.gif"> <a href="?site=db_v5_2&action=5204update">Update from V5.2.x to Build 5204/5205</a>';
   }
   if(!isset($ver_notice))$ver_notice='';
	 if(!isset($border))$border='';
		echo '<br />
			<fieldset style="border: 1px solid '.$border.'"><legend style="font-size:13px;"><b>Cup Addon V5.2 BETA - Installation & Updater</b></legend>
				<br><center><img src="http://team-x1.co.uk/images/wave.gif"></a><br /><strong>Report bugs and download updates from <a href="http://teamx1.com" target="_blank">www.teamx1.com</a></strong><br />'.$ver_notice.'Query failed? <a href="http://teamx1.com/index.php?site=faq&action=faq&faqID=6&faqcatID=1" target="_blank">Have a read!</a><br><br />
				'.$db_show.'<br /><br />
				[ Developed by <a href="http://teamx1.com/" target="_blank">Team -X1-</a> & Creak | Release: '.$release_date.' | Website: <a href="http://teamx1.com/" target="_blank">Cupaddon.com</a> ] </center>
			</fieldset>';

}
?>