<?php

class Search extends \Eloquent {
	protected $fillable = [];

    public function tweets()
    {
        return $this->hasMany('Tweet');
    }

    public static function getGeoLocation($address)
    {
        try
        {
            $uri = sprintf(getenv('GOOGLE_GEO_API_URI'),
                    $address, getenv('GOOGLE_MAPS_API_KEY'));
        }
        catch(Exception $e)
        {
            Log::error('Environment variables not set');
            return false;
        }

        try
        {
            $client = new \Guzzle\Service\Client($uri);
        }
        catch(Exception $e)
        {
            Log::error($e);
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
