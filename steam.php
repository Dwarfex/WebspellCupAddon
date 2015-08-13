<?php
/**
*
* @package Steam Community API
* @copyright (c) 2010 ichimonai.com
* @license http://opensource.org/licenses/mit-license.php The MIT License
*
*/

class SteamSignIn
{
	const STEAM_LOGIN = 'https://steamcommunity.com/openid/login';

	/**
	* Get the URL to sign into steam
	*
	* @param mixed returnTo URI to tell steam where to return, MUST BE THE FULL URI WITH THE PROTOCOL
	* @param bool useAmp Use &amp; in the URL, true; or just &, false. 
	* @return string The string to go in the URL
	*/
	public static function genUrl($returnTo = false, $useAmp = true)
	{
		$returnTo = (!$returnTo) ? (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'] . '?' .pageURL() : $returnTo;
		
		$params = array(
			'openid.ns'			=> 'http://specs.openid.net/auth/2.0',
			'openid.mode'		=> 'checkid_setup',
			'openid.return_to'	=> $returnTo,
			'openid.realm'		=> (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'],
			'openid.identity'	=> 'http://specs.openid.net/auth/2.0/identifier_select',
			'openid.claimed_id'	=> 'http://specs.openid.net/auth/2.0/identifier_select',
		);
		
		$sep = ($useAmp) ? '&amp;' : '&';
		return self::STEAM_LOGIN . '?' . http_build_query($params, '', $sep);
	}
	
	/**
	* Validate the incoming data
	*
	* @return string Returns the SteamID64 if successful or empty string on failure
	*/
	public static function validate()
	{
		// Star off with some basic params
		$params = array(
			'openid.assoc_handle'	=> $_GET['openid_assoc_handle'],
			'openid.signed'			=> $_GET['openid_signed'],
			'openid.sig'			=> $_GET['openid_sig'],
			'openid.ns'				=> 'http://specs.openid.net/auth/2.0',
		);
		
		// Get all the params that were sent back and resend them for validation
		$signed = explode(',', $_GET['openid_signed']);
		foreach($signed as $item)
		{
			$val = $_GET['openid_' . str_replace('.', '_', $item)];
			$params['openid.' . $item] = get_magic_quotes_gpc() ? stripslashes($val) : $val; 
		}

		// Finally, add the all important mode. 
		$params['openid.mode'] = 'check_authentication';
		
		// Stored to send a Content-Length header
		$data =  http_build_query($params);
		$context = stream_context_create(array(
			'http' => array(
				'method'  => 'POST',
				'header'  => 
					"Accept-language: en\r\n".
					"Content-type: application/x-www-form-urlencoded\r\n" .
					"Content-Length: " . strlen($data) . "\r\n",
				'content' => $data,
			),
		));

		$result = file_get_contents(self::STEAM_LOGIN, false, $context);
		
		// Validate wheather it's true and if we have a good ID
		preg_match("#^http://steamcommunity.com/openid/id/([0-9]{17,25})#", $_GET['openid_claimed_id'], $matches);
		$steamID64 = is_numeric($matches[1]) ? $matches[1] : 0;

		// Return our final value
		return preg_match("#is_valid\s*:\s*true#i", $result) == 1 ? $steamID64 : '';
	}
}

//steam-URL= teamSignIn::genUrl();
//steam ID = SteamSignIn::validate();

/* PROFILE GET STEAM COMMUNITY ID */

$steam_login_verify = SteamSignIn::validate();
if(!empty($steam_login_verify))
{
$STEAM_VALIDE = true;
$GET_STEAM_ID = $steam_login_verify;
$GET_BY_STEAM = false;
}
else
{
$STEAM_VALIDE = false;
$GET_STEAM_ID = false;
$steam_sign_in_url = SteamSignIn::genUrl();
} 

$GET_BY_STEAM = "<a href=\"$steam_sign_in_url\"><img src='images/cup/icons/steam.png' /> Get yours via Steam</a>";

/* END PROFILE GET STEAM COMMUNITY ID */


if(isset($_GET['id'])) {

    $id = $_GET['id'];
    $key = '474189A348D9DFA6645943580F2A36E7';

/* PLAYER SUMMARIES */	
	
    $link = file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key='.$key.'&steamids='.$id.'&format=json');
    $arr_vars = json_decode($link, true);
	
	echo '<h1>'.$arr_vars['response']['players'][0]['personaname'].'</h1><hr><br><br>';
	
	//public data
	
	$steamid = $arr_vars['response']['players'][0]['steamid'];
    $personaname = $arr_vars['response']['players'][0]['personaname'];
	$profileurl = $arr_vars['response']['players'][0]['profileurl'];
	$avatarsmall = $arr_vars['response']['players'][0]['avatar'];
	$avatarmedium = $arr_vars['response']['players'][0]['avatarmedium'];
	$avatarfull = $arr_vars['response']['players'][0]['avatarfull'];
	$personastate = $arr_vars['response']['players'][0]['personastate'];
	$communityvisibilitystate = $arr_vars['response']['players'][0]['communityvisibilitystate'];
    $profilestate = $arr_vars['response']['players'][0]['profilestate'];
	$lastlogoff = $arr_vars['response']['players'][0]['lastlogoff'];
	
	//private data
	
	$realname = $arr_vars['response']['players'][0]['realname'];
	$primaryclanid = $arr_vars['response']['players'][0]['primaryclanid'];
	$timecreated = $arr_vars['response']['players'][0]['timecreated'];
	$gameid = $arr_vars['response']['players'][0]['gameid'];
	$gameserverip = $arr_vars['response']['players'][0]['gameserverip'];
	$gameextrainfo = $arr_vars['response']['players'][0]['gameextrainfo'];
	$loccountrycode = $arr_vars['response']['players'][0]['loccountrycode'];
	$locstatecode = $arr_vars['response']['players'][0]['locstatecode'];
	$loccityid = $arr_vars['response']['players'][0]['loccityid'];

/* PLAYER FRIENDLIST */	

	$link2 = file_get_contents('http://api.steampowered.com/ISteamUser/GetFriendList/v0001/?key='.$key.'&steamid='.$id.'&relationship=friend');
    $arr_vars2 = json_decode($link2, true);


echo '<table width="100%">
        <tr>
	      <td>Name</td>
		  <td>Relationship</td>
		  <td>Friends since</td>
		  <td>Steam ID</td>
	    </tr>';

for($i = 0; $i <= 5; $i++) {

    //$link3 = file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key='.$key.'&steamids='.$arr_vars2['friendslist']['friends'][$i]['steamid'].'&format=json');
    //$arr_vars3 = json_decode($link3, true);

	  echo '<tr>
			  <td>'.$arr_vars3['response']['players'][0]['personaname'].'</td>
			  <td>'.$arr_vars2['friendslist']['friends'][$i]['relationship'].'</td>
			  <td>'.$arr_vars2['friendslist']['friends'][$i]['friend_since'].'</td>
			  <td>'.$arr_vars2['friendslist']['friends'][$i]['steamid'].'</td>
			</tr>';
}

echo '</table';

}
?>