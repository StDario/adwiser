<?php

use Jenssegers\Mongodb\Model as Eloquent;

class Advice extends Eloquent {
	protected $guarded = array();

	public static $rules = array();
}
