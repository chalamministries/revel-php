<?php namespace Revel\Models;

use Revel\Models\Contracts\Sendable;

/**
 * @property string $phone
 * @property string $email
 * @property string $first
 * @property string $last
 */
class Customer extends Model implements Sendable {

	protected function fields() {
		return [
			'phone' => $this->raw('phone', null),
			'email' => $this->raw('email', null),
			'first' => $this->raw('first', null),
			'last' => $this->raw('last', null)
		];
	}

	public function bundle() {
		return [
			'phone' => $this->phone,
			'email' => $this->email,
			'first_name' => $this->first,
			'last_name' => $this->last
		];
	}

}