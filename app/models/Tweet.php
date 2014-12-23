<?php

class Tweet extends \Eloquent {
	protected $fillable = ['username', 'tweet', 'profile_pic', 'geo_lat', 'geo_lng'];

    public function search()
    {
        return $this->belongsTo('Search');
    }

	private static function connect()
	{
        // Setup OAuth token and secret
		try
		{
			Twitter::setOAuthToken(getenv('TWITTER_ACCESS_TOKEN'));
	        Twitter::setOAuthTokenSecret(getenv('TWITTER_TOKEN_SECRET'));
		}
		catch(Exception $e)
		{
			Log::error('Could not connect to Twitter: ' . $e);
		}
	}

	public static function get($coordinates)
	{

		Tweet::connect();

		$coordinate_str = $coordinates['lat'] . ',' . $coordinates['lng'] . ',' 
				. getenv('TWITTER_RESULT_DISTANCE') . getenv('TWITTER_RESULT_UNIT');

		try
		{
		$tweets = Twitter::searchTweets(
			null, 
			$coordinate_str,
			null, 
			null, 
			getenv('TWITTER_RESULT_TYPE'),
			getenv('TWITTER_RESULT_AMOUNT')
		);
		}
		catch(Exception $e)
		{
			Log::info('Twitter did not respond: ' . $e);
			return false;
		}

		$content = [];
		foreach($tweets['statuses'] as $i => $tweet)
		{
			$content[$i]['tweet'] = $str = str_replace("\n", '', nl2br(htmlentities($tweet['text'], ENT_QUOTES, "UTF-8")));
			$content[$i]['username'] = $tweet['user']['screen_name'];
			$content[$i]['profile_pic'] = $tweet['user']['profile_image_url'];
			$content[$i]['geo_lat'] = $tweet['geo']['coordinates'][0];
			$content[$i]['geo_lng'] = $tweet['geo']['coordinates'][1];
			$content[$i]['created_at'] = $tweet['created_at'];
		}
		return $content;
	}
}
