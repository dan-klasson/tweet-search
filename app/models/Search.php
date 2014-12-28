<?php

class Search extends \Eloquent {

	protected $fillable = [];

    public function tweets()
    {
        return $this->hasMany('Tweet');
    }

	/*
	 * getLatestSearchByCity
	 *
	 * Returns any search that exist for a given city within the last 1 hour
	 *
	 * @param array Coordinates to address or city
	 * @return object
	 */
	public static function getLatestSearchByCity($city)
	{
		return parent::with('tweets')->where('city', '=', strtolower($city))
					->where('created_at', '>', \Carbon\Carbon::now()->subHour())->first();
	}


	/*
	 * saveSearch
	 *
	 * Saves the city searched and the corresponding tweets
	 *
	 * @param string Address or city
	 * @param array Coordinates to address or city
	 * @param array Tweets about and from address or city
	 * @return object
	 */
	public static function saveSearch($city, $coordinates, $tweets)
	{
		$tweet_objects = [];
		foreach($tweets as $id => $tweet)
		{
			$tweet_objects[$id] = new Tweet(array(
				'username'		=> $tweet['username'],
				'tweet'			=> $tweet['tweet'],
				'profile_pic'	=> $tweet['profile_pic'],
				'geo_lat'		=> $tweet['geo_lat'],
				'geo_lng'		=> $tweet['geo_lng']
			));
		}
		$search = new Search;
		$search->city = $city;
		$search->geo_lat = $coordinates['lat'];
		$search->geo_lng = $coordinates['lng'];
		$search->save();
		$search->tweets()->saveMany($tweet_objects);
	}


	/*
	 * getGeoLocation
	 *
	 * Connects to Google and returns the geo location for a given address
	 *
	 * @param string Address or city
	 * @return array|false Geo Locations on success and false on no results
	*/
    public static function getGeoLocation($address)
    {
        try
        {
            $uri = sprintf(getenv('GOOGLE_GEO_API_URI'),
                    $address, getenv('GOOGLE_MAPS_API_KEY'));
        }
        catch(Exception $e)
        {
            Log::error('Google Maps environment variables not set');
            return false;
        }

        try
        {
            $client = new \Guzzle\Service\Client($uri);
        }
        catch(Exception $e)
        {
            Log::error('Could not connect to Google Maps: ' . $e);
            return false;
        }

        $response = $client->get()->send();
        $response = $response->json();

        if(!empty($response['results']))
        {
            return $response['results'][0]['geometry']['location'];
        }
        else
        {
            // No results for that address
            return false;
        }
    }
}
