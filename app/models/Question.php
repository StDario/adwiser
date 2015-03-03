<?php

use Jenssegers\Mongodb\Model as Eloquent;

class Question extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

	protected $collection = "questions";
}
