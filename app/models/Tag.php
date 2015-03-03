<?php

use Jenssegers\Mongodb\Model as Eloquent;

class Tag extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

	protected $collection = "tags";
}
