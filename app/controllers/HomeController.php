<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	*/


	/*
	 * index
	 *
	 * Index controller that displays the default address
	 * as specified in the environment file
	 *
	 * @return object
	 */
	public function index()
	{
		return $this->search(getenv('DEFAULT_ADDRESS'));
	}


	/*
	 * search
	 *
	 * Search controller that displays the address as
	 * specified by the user
	 *
	 * @param string Address or city
	 * @return object
	 */
	public function search($city)
	{

		$search = Search::getLatestSearchByCity($city);

		if(!$search)
		{
			if(!$coordinates = Search::getGeoLocation($city))
			{
				$error = "No city could be found by that name";
				return View::make('error')->withError($error);
			}

			if(!$tweets = Tweet::get($city, $coordinates)) {
				$error = "Twitter is not responding, please try again later.";
				return View::make('error')->withError($error);
			}

			Search::saveSearch($city, $coordinates, $tweets);
		}
		else {
			$coordinates['lat'] = $search->geo_lat;
			$coordinates['lng'] = $search->geo_lng;
			$tweets = $search->tweets->toArray();
		}

		return View::make('index')->with(array(
			'coordinates' => $coordinates,
			'contents' => $tweets,
			'city' => $city,
		));
	}
}
