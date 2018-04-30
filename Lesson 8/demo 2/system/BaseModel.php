<?php namespace System;
/*
 * model - the base model
 *
 */

use App\Config;
use App\Helpers\Database;

class BaseModel
{
	/**
	 * hold the database connection
	 * @var object
	 */
	protected $db;

	/**
	 * create a new instance of the database helper
	 */
	public function __construct() {

		//initiate config
		$config = Config::get();

		//connect to PDO here.
		$this->db = Database::get($config);
	}
}
