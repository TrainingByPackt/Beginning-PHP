<?php namespace System;
/*
 * model - the base model
 *
 */
class BaseModel extends Controller
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
		//connect to PDO here.
		$this->db = App\Helpers\Database::get();
	}
}
