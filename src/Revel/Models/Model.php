<?php namespace Revel\Models;

use Exception;
use JsonSerializable;
use Revel\Revel;

abstract class Model implements JsonSerializable {

	/**
	 * Create one instance of this Model from source data.
	 *
	 * @param Revel $revel The Revel instance that created this model.
	 * @param mixed $data The source data.
	 *
	 * @return static
	 */
	public static function one(Revel $revel, $data = null) {
		return new static($revel, $data);
	}

	/**
	 * Create multiple instance of this Model from a list of source data.
	 *
	 * @param Revel $revel The Revel instance that created these models.
	 * @param array|mixed $data The source data.
	 *
	 * @return static[]
	 */
	public static function many(Revel $revel, $data) {
		return array_map(function($instance) use ($revel) {
			return static::one($revel, $instance);
		}, $data);
	}

	/** @var Revel */
	protected $revel;

	/** @var mixed */
	protected $raw;

	/** @var array */
	protected $data;

	/**
	 * Model constructor.
	 *
	 * @see Model::one()
	 * @see Model::many()
	 *
	 * @param Revel $revel The Revel instance that created this model.
	 * @param mixed $data The data to populate this Model with.
	 */
	public function __construct($revel, $data) {
		$this->revel = $revel;
		$this->raw = empty($data) ? [] : $data;
		$this->data = $this->fields();
	}

	public function __get($prop) {
		if (array_key_exists($prop, $this->data)) {
			return $this->data[$prop];
		}

		return null;
	}

	public function __set($prop, $value) {
		if (array_key_exists($prop, $this->data)) {
			$this->data[$prop] = $value;
		} else {
			throw new Exception('Unknown field "' . $prop . '" cannot be set.');
		}
	}

	public function __isset($prop) {
		return array_key_exists($prop, $this->data);
	}

	/**
	 * Get raw field data as seen in the API response.
	 *
	 * @param string $field The field to get data for.
	 * @param mixed $fallback A fallback to use if the data does not exist.
	 *
	 * @return mixed
	 */
	public function raw($field = null, $fallback = null) {
		if (empty($field)) return $this->raw;

		if (is_array($this->raw) && array_key_exists($field, $this->raw)) return $this->raw[$field];
		else if (is_object($this->raw) && property_exists($this->raw, $field)) return $this->raw->{$field};

		return $fallback;
	}

	public function jsonSerialize() {
		return $this->data;
	}

	/** @return array */
	abstract protected function fields();

	/**
	 * @return array
	 */
	public function data() {
		return $this->data;
	}

}