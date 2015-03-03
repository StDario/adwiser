<?php

use Jenssegers\Mongodb\Model as Eloquent;

class Review extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

	protected $collection = "reviews";
}
