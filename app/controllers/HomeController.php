<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function index()
	{
		return $this->search(getenv('DEFAULT_ADDRESS'));
	}

	public function search($city)
	{

		$search = Search::with('tweets')->where('city', '=', strtolower($city))
					->where('created_at', '>', \Carbon\Carbon::now()->subDay())->first();

		$error = false;

		if(!$search)
		{
			if(!$coordinates = Search::getGeoLocation($city))
			{
				$error = "No city could be found by that name";
				return View::make('error')->withError($error);
			}

			if(!$tweets = Tweet::get($coordinates)) {
				$error = "Twitter is not responding, please try again later.";
				return View::make('error')->withError($error);
			}

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
		else {
			$coordinates['lat'] = $search->geo_lat;
			$coordinates['lng'] = $search->geo_lng;
			$tweets = $search->tweets->toArray();
		}

		return View::make('index')->with(array(
			'coordinates' => $coordinates,
			'contents' => $tweets,
			'error' => $error,
			'city' => $city,
		));
	}
}
