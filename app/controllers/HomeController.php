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

	public function showWelcome()
	{
        $coordinates = Search::getGeoLocation(getenv('DEFAULT_ADDRESS'));


        // Setup OAuth token and secret
        Twitter::setOAuthToken(getenv('TWITTER_ACCESS_TOKEN'));
        Twitter::setOAuthTokenSecret(getenv('TWITTER_TOKEN_SECRET'));

        $tweets = Twitter::searchTweets(null, $coordinates['lat'] . ',' . $coordinates['lng'] . ',50km');


        //var_dump($tweets);
        return View::make('index')->with(array(
            'coordinates' => $coordinates,
        ));
	}

}
