<?php

class Search extends \Eloquent {
	protected $fillable = [];

    public function tweets()
    {
        return $this->hasMany('Tweet');
    }
}
