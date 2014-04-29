<?php

/* /app/View/Helper/Common.php (using other helpers) */
App::uses('AppHelper', 'View/Helper');

App::uses('Sanitize', 'Utility');

class CommonHelper extends AppHelper
{

 
/**
 * Status type
 * @return type 
 */
    public function statusTypes()
    {

		$status = array ();
		$status[StatusTypes::Active] = _('Active');
		$status[StatusTypes::Inactive] = _('Inactive');

		return $status;
    }
	
/**
* Network options
* return options data
*/
	public function networksOptions()
	{
		$options = array();
		$options[Network::Facebook] = _('Facebook');
		$options[Network::Twitter] = _('Twitter');
		$options[Network::Foursquare] = _('Foursquare');
		$options[Network::Instagram] = _('Instagram');
		$options[Network::SolRepublic] = _('SolRepublic');
		$options[Network::TurntableFM] = _('Turntable FM');
		$options[Network::Spotify] = _('Spotify');
		$options[Network::YouTube] = _('YouTube');
		$options[Network::Tumblr] = _('Tumblr');
		$options[Network::Website] = _('Website or Hub');
		return $options;
	}

	
	

/**
 * User level
 * @return type 
 */
    public function usersTypes()
    {

		$usertypes = array ();
		$usertypes[ConstUserTypes::Admin] = _('Admin');
		$usertypes[ConstUserTypes::Customer] = _('Customer');
		return $usertypes;
    }

/**
 * Fetch Label corresponding to status type LIKE Active for 1
 * @param $status
 * @return text corresponding to status
 */
	 
	 public function status_label($status = 0)
	 {
		$status_text = array();
		$status_text[StatusTypes::Inactive] = 'Inactive';
		$status_text[StatusTypes::Active] = 'Active';
		return $status_text[$status];
	 }
	 
/**
 * get SOL user remaining point needed to move on next level
 * @param points $points, $level
 * @return 
 */
	function nextLevelPoint( $points = 0 , $level = 0 )
    {
		$level = $this->userLevel($level);
		
		 $userLevel = array();
		 $userLevel['Cadet'] = 2501;
		 $userLevel['Private'] = 7501;
		 $userLevel['Lieutenant'] = 501;
		 $userLevel['Captain'] = 11251;
		 $userLevel['Major'] = 16876;
		 $userLevel['Colonel'] = 20626;
		 
		/* $userLevel = array();
		 $userLevel['Cadet'] = 51;
		 $userLevel['Private'] = 201;
		 $userLevel['Lieutenant'] = 501;
		 $userLevel['Captain'] = 1001;
		 $userLevel['Major'] = 5001;
		 $userLevel['Colonel'] = 10001;*/
		 
		 $remainingPoint = $userLevel[$level] - $points;
		return  $remainingPoint; /// Point remaining to move to next level
    }
	
/**
 * get SOL next level text
 * @param level $level
 * @return 
 */
	function nextLevel( $level = 0 )
    {
		$level = $this->userLevel($level);
		switch ( $level )
			{
				case 'Cadet' :
						return "Private"; break;
				case 'Private' :
						return "Lieutenant"; break;
				case 'Lieutenant' :
						return "Captain"; break;
				case 'Captain' :
						return "Major"; break;
				case 'Major' :
						return "Colonel"; break;
				case 'Colonel' :
						return "General"; break;
				default :
					return "Cadet"; break;
			}
    }
/**
 * userLevel :- get SOL user level
 * @param :- $level(int)
 * @return boolean 
 */	
	
	function userLevel( $level = 0 )
	{
		$levelarray = array ();
		$levelarray[] = 'Cadet';
		$levelarray[] = 'Private';
		$levelarray[] = 'Lieutenant';
		$levelarray[] = 'Captain';
		$levelarray[] = 'Major';
		$levelarray[] = 'Colonel';
		$levelarray[] = 'General';

		if ($level < count($levelarray) && $level > 0)
		{
			return $levelarray[$level];
		}
		else
		{
			return $levelarray[0];
		}
	}
	
/**
 * usernameFormat :- get SOL username format
 * @param :- $first_name(int) , $last_name(int)
 * @return boolean 
 */	
	
	function usernameFormat( $first_name , $last_name )
	{
		return $first_name.' '. strtoupper( substr($last_name, 0 ,1) );
	}
	
}
