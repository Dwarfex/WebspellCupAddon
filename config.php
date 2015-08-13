<?php

/* CONFIGURATION */

$debugging = 0;         // NOT USED
$run_without_admin = 0; // 1 = WARNING: anyone can run this script and manipulate the database. Use it when needed then set to 0 when finished.
                        // 0 = only super admins can run this file. If you receive query failed set this option to 1 temporarily after finished.
$enforce_timezone = 1;  // 1 = enforce user to set timezone (they can set their timezone to "Unset")
                        // 0 = do not enforce user to set timezone
$enforce_email = 1;     // 1 = enforce user to set email
                        // 0 = do not enforce user to set email
$lineup_overmax = 0;    // 0 = do not allow more in lineup (exact in lineup required)
                        // 1 = allow more in lineup than required

//side content include at index.php (other settings at admin - cupsettings)

$sc_clans = 5;               // how many last clans to display at sc_clans.php ?
$sc_cupmatches_order = 1;    // 1 = order by confirmed date
                             // 0 = order by match created date
$limit_upcoming_matches = 4; // how many upcoming matches to display at sc_upcomingmatches.php ?
$limit_recent_matches = 4;   // how many recent matches to display at sc_cupmatches.php ?

//string lengths

$sc_cupinstant_length = 25;     // show X characters followed by ".." in sc_cupinstant.php (only for league names)
$sc_cups_length = 30;           // show X characters followed by ".." in sc_cups.php
$sc_cupmatches_length = 6;      // show X characters (each clan) followed by ".." in sc_cupmatches.php
$sc_upcomingmatches_length = 8; // show X characters (each clan) followed by ".." in sc_upcomingmatches.php
$sc_clans_length = 30;          // show X characters followed by ".." in sc_clans.php
$quicknavi_length = 20;         // show X characters followed by ".." in quicknavi.php


//styling

$cellspacing = 2; 
$cellpadding = 2;
$error_box = "class='infobox'";
$selected_cup_quicknavi = "#e4f3ff"; // when cup is selected at quicknavi, make bgcolor ?
$period_dot = "";                    // 1 = white animated dots 
                                     // (BLANK) = black animated dots
$period_dot_tp = "";                 // 1 = white animated dots for tooltip 
                                     // (BLANK) = black animated dots for tooltip

//platform page

$show_inactive_platforms = 0; // 0 = show all platforms 
                              // 1 = hide closed platforms
$logo_width = '100';          // width of platform logo at platform page?
$logo_height = '100';         // height of platform logo at platform page?
$logo_width2 = '20';          // width of platform logo at matches page?
$logo_height2 = '20';         // height of platform logo at matches page?
$map_width = '100';           // width of map pic when submitting a result
$map_height = '100';          // height of map pic when submitting a result

/* GROUP-STAGES */

$selected_match = '#FF9966'; // clicking on match report at match details will show you background color of selected match.
$show_matchstats = 1;        // 1 = only show match-stats after all matches finish 
                             // 0 = show anytime
$league_begin = 0;           // If "Open cup registration after group stages finish" Then set end time for group stages after last match and start time for example plus "1" day ahead. (prior to 1 day is registration)
$league_end = 7;             // If "Open cup registration after group stages finish" Then set end time for league "3" days ahead of league start time.
$sm_qualified  =             "Congratulations! You are a qualified participant and your registration is reserved for the league.";
$sm_unqualified =            "Sorry! You did not have enough points to pass through to the qualifying league. We hope you better luck next time!";
$sm_fcfs =                   "You are a FCFS participant which means it will be first-come-first-serve after all qualifiers are registered.";
$sm_elig_subject =           "League Eligibility Notification";
$auto_checkin = 1;           // 1 = auto-check qualifiers only 
                             // 0 = only auto check at check-in phase.
$insert_qualifiers = 1;      // 1 = qualifiers automatically registered to next league 
                             // 0 = qualifiers must register manually to next league
$generate_all_vs_all = 1;    // 1 = automatically generate all vs. all participates as soon as all participants register
                             // 0 = do not automatically generate and generate manually
$starttime_gs_auto = 1;      // 1 = after all vs. all participates have generated set the start time of group stages to now

/* FREE AGENTS (B-5206) */

$recruitees_tourna = 1;     // 1 = Recruiters can recruit whether they are registered in the tournament or not, must be on sign-up phase
$recruitees_ladder = 1;     // 1 = Recruiters can recruit whether they are registered in the ladder or not, must be sign-up phase unless "Sign-ups until end?" is selected

/* CUP UPDATE (B-5206) */

$a_show_updated = 1;        // 1 = shows all updates 
                            // 0 = hides updates already included

/* LADDER & STANDINGS */

$elo_rating_default = 1000; // As soon as a player is registered in the ladder, set the default ELO rating
$kfactor_fixed = 32;
$kfactor_below = 32;
$kfactor_between = 24;
$kfactor_above = 16;
$elo_below = 2100;
$elo_between_start = 2100;
$elo_between_end = 2400;
$elo_above = 2400;
$hide_credits_column = 0;   // 0 = show credits column //1 = hide credits column

$custom_bar_bg = 0;         // 0 = (as set in Admincenter -> Styles) bar_bg = BG_1; bar_border = PAGEBG; bar_hover = BGHEAD bar_active = BGHEAD;
                            // 1 = (as set below to your custom preference:)
                            $bar_bg =     ""; // If $custom_bar_bg is 1 -- background of bar, e.g. "red" or "#ff0000"
                            $bar_border = ""; // If $custom_bar_bg is 1 -- border of bar
                            $bar_hover =  ""; // If $custom_bar_bg is 1 -- colour of bar on hover
                            $bar_active = ""; // If $custom_bar_bg is 1 -- colour of bar on active

$legend = 0;                 // 1 = show legend at ladder details 
                             // 0 = hide legend at ladder details
$instant_play = 0;           // 0 = can challenge / report even if fewer participants than max signups 
                             // 1 = must wait for all participants to signup (required for group stages)
$differential = 0;           // 1 = score A minus score B to calculate XP 
                             // 0 = score A and score B to calculate XP
$startupcredit = 10;         // If credit reaches 0, participant is unranked
$woncredit = 3;              // Plus credibility (previous records will be inaccurate if changed from previous state) 
$lostcredit = 1;             // Minus credibility (previous records will be inaccurate if changed from previous state) 
$drawcredit  = 1;            // Plus credibility (previous records will be inaccurate if changed from previous state) 
$forfeitloss = 2;            // Minus credibility (previous records will be inaccurate if changed from previous state) 
$forfeitaward = 2;           // Plus credibility (previous records will be inaccurate if changed from previous state) 
$show_challenges_s = 8;      // Amount of challenges shown at standings
$show_matches_s = 8;         // Amount of matches shown at standings
$warning_remove_in = 1;      // (Value) = e.g. if user will be removed in 1 day, show warning
$warning_unranked_in = 1;    // (Value) = e.g. if user will be unranked in 1 day, show warning
$unranking = 1;              // 1 = unranked participants with 0 credits 
                             // 0 = do not unrank
$days_inactive = 3;          // If (Value) of days or greater of inactivity, show snooze image at standings
$ratio_determination = 0;    // 1 = ratio according to matches 
                             // 0 = ratio according to xp (do not use if "Win/Loss XP" selected)
/* TICKETING SYSTEM */

//status 1 = unreviewed
//status 2 = awaiting admin-reply
//status 3 = onhold
//status 4 = awaiting user-reply
//status 5 = closed
//status 6 = custom1
//status 7 = custom2

$status_resolved =      '<font color="#DD0000"><b>Closed</b></font>';
$status_unreviewed =    '<font color="#0066CC"><b>Not Reviewed</b></font>';
$status_pending =       '<font color="#FF6600"><b>Awaiting Admin-Reply</b>';
$status_onhold =        '<font color="#FF6600"><b>On-Hold</b>';
$status_waiting =       '<font color="#FF6600"><b>Awaiting User-Reply</b>';
$status_custom1 =       '<b>(custom-config.php)</b>';
$status_custom2 =       '<b>(custom-config.php)</b>';

$status_resolved_nc =   "<b>Closed</b>";
$status_unreviewed_nc = "<b>Not Reviewed</b>";
$status_pending_nc =    "<b>Awaiting Admin-Reply</b>";
$status_onhold_nc =     "<b>On-Hold</b>";
$status_waiting_nc =    "<b>Awaiting User-Reply</b>";
$status_custom1_nc =    "<b>(custom-config.php)</b>";
$status_custom2_nc =    "<b>(custom-config.php)</b>";

$notification_status_admin = array(1,2);     // Instant notification for admin if status is? (separated by commas, no comma if 1 value or after last value)
$notification_status_user = array(1,4);      // Instant notification for user if status is? (separated by commas, no comma if 1 value or after last value)
$unresolved_ticket_u = "Unresolved Ticket";  // If instant notification for ticket for user, call header?
$unresolved_ticket_a = "Unresolved Ticket";  // If instant notification for ticket for admin, call header?
$unconfirmed_result =  "Unconfirmed Result"; // If instant notification for match, call header?

$delete_confirmed_protests = 0;    // 0 = opened protests always remain as a ticket even if confirmed unless deleted 
                                   // 1 = confirmed protests automatically delete
$order_by = 1;                     // 0 = order tickets by "added date" by user 
                                   // 1 = order tickets by "updated date" by user or admin 
$user_reply_status = 2;            // When user replies after admin, automatically set status to? 
$admin_reply_status = 4;           // When admin replies, automatically set status to? 
$match_confirmed_status = 5;       // When admin confirms a match protest, set status to? 
$match_protest_status = 3;         // When admin sets the match status to protest, set status to?
$ticket_autoclose_time = 86400;    // If no reply, autoclose ticket by how many seconds? (86400 = 1 day)
$ticket_autoclose_status = 5;      // Set auto-closed tickets to status ? (see above)
$only_autoclose_ticket = array(4); // What status(es) can the autoclose ticket apply to? seperated by commas or no comma if 1 value
$hide_closed_tickets = 1;          // 1 = hide closed tickets at admin 
                                   // 0 = show closed
$user_close_ticket = 1;            // 1 = users can close tickets 
                                   // 0 = users can't close tickets.
$user_delete_ticket = 1;           // 1 = users can delete tickets 
                                   // 0 = users can't delete tickets.

/* SCORE RATIO */

$ratio = '1';          // 1 = show skill level 
                       // 0 = show ratio range
$none = 'N/A';         // Name ratio that has no ratio
$minimum_matches = 8; // If equal or lesser than X matches, then skill-level is not determined
$ned = 'N/A';          // Name it?

//low skill level:

$low = 'Low';           // name it?
$h1 = '0';              // equal to or greater than
$l1 = '33';             // equal to or lesser than

//med skill level:

$med = 'Med';          // name it?
$h2 = '34';            // equal to or greater than
$l2 = '66';            // equal to or lesser than

//low-med skill level:

$lowmed = 'Low-Med';   // name it?
$h3 = '0';             // equal to or greater than
$l3 = '66';            // equal to or lesser than

//high skill level:

$high = 'High';        // name it?
$h4 = '67';            // equal to or greater than
$l4 = '89';            // equal to or lesser than

//med-high skill level:

$medhigh = 'Med-High'; // name it?
$h5 = '33';            // equal to or greater than
$l5 = '89';            // equal to or lesser than

//high + skill level:

$high1 = 'High +';     // name it?
$h6 = '90';            // equal to or greater than
$l6 = '97';            // equal to or lesser than

//high ++ skill level:

$high2 = 'High ++';    // name it?
$h7 = '98';            // equal to or greater than
$l7 = '100';           // equal to or lesser than

/* TOURNAMENT CONFIGURATION */

$borderbg1='#e4f3ff';        // brackets border color
$background1='#e4f3ff';      // brackets background 1 color
$background2='#D9D9D9';      // brackets background 2 color
$shrink_tree = 0;            // 1 = automatically reduce the tree size if max participants does not register when cup starts // 0 = do not shrink
$team_list = 0;              // 0 = short team listing 
                             // 1 = detail team listing
$auto_close_cup = 1;         // if there is a 1st winner, close the cup and set times accordingly
                             // 0 = leave times the same.
$winner =       "Winner";
$third_winner = "3rd-Place";
$lower_winner = "LB Winner";

$round1 =       "Round 1";    // for upper-bracket
$round2 =       "Round 2";    // for upper-bracket
$round3 =       "Round 3";    // for upper-bracket
$round4 =       "Round 4";    // for upper-bracket 

$round1_lb =    "LB Round 1"; // for lower-bracket
$round2_lb =    "LB Round 2"; // for lower-bracket
$round3_lb =    "LB Round 3"; // for lower-bracket
$round4_lb =    "LB Round 4"; // for lower-bracket
$round5_lb =    "LB Round 5"; // for lower-bracket
$round6_lb =    "LB Round 6"; // for lower-bracket
$round7_lb =    "LB Round 7"; // for lower-bracket

$round_qf_ub =  "Quarterfinal";
$round_qf_lb =  "LB Quarterfinal";
$round_sf_ub =  "Semi-Final";
$round_sf_lb =  "LB Semi Final";
$round_gf_ub =  "Grand Final";
$round_gf_lb =  "LB Final";

$auto_randomize_brackets = 2; // 1 = when cup start-time is met and cup is full, auto randomize 
                              // 0 = randomize yourself from admin 
							  // 2 = when cup is full, auto set start time to now and randomize

if(mb_substr(basename($_SERVER['REQUEST_URI']),0,15)!="admincenter.php") { ?>

<!-- CUP STYLING - MODIFY/REMOVE BELOW IF NEEDED -->

<style>
tr, td, table
{
padding:4px;
border-collapse:separate;
border-spacing:0px 0px;
border-color:#ffffff;
}
fieldset, legend {
margin:10px;
padding:px;
}

.title
{
border-spacing:0px 0px;
margin-top: 25px;
}
</style>

<!-- CUP STYLING - MODIFY/REMOVE ABOVE IF NEEDED -->

<?php } 

/* DO NOT EDIT BELOW  */

$maxclan_array = array(8,16,32,64);
$groups_array = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','a2','b2','c2','d2','e2','f2');
$per_group_8 = 4; 
$per_group_16 = 4;
$per_group_32 = 4;       
$per_group_64 = 4;     

?>