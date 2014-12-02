<?php

class Tweet extends \Eloquent {
	protected $fillable = [];

    public function search()
    {
        return $this->belongsTo('Search');
    }
}
