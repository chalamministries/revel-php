<?php namespace Revel\Models;

abstract class SendableModel extends Model {

	/**
	 * Bundle this model for send through the API.
	 *
	 * @return array
	 */
	public abstract function bundle();

}