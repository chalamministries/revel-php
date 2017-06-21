<?php namespace Revel\Models;

use DateTime;
use Revel\Enums\DiningOptions;

/**
 * @property DateTime $created
 * @property int $diningOption
 * @property bool $asap
 * @property-read Customer $customer
 *
 * @see DiningOptions
 * @see Customer
 */
class OrderInfo extends SendableModel {

	protected function fields() {
		return [
			'created' => $this->raw('created', null),
			'diningOption' => $this->raw('diningOption', DiningOptions::ONLINE),
			'asap' => $this->raw('asap', false),
			'customer' => $this->raw('customer', null)
		];
	}

	public function bundle() {
		return array_filter([
			'created_date' => empty($this->created) ? null : $this->created->format('Y-m-d H:i:s'),
			'dining_option' => $this->diningOption,
			'asap' => $this->asap,
			'customer' => empty($this->customer) ? null : $this->customer->bundle()
		], function($value) {
			return !empty($value);
		});
	}

}