<?php namespace Revel\Models;

/**
 * @property int $amount
 * @property int $tip
 * @property int $type
 */
class PaymentInfo extends SendableModel {

	protected function fields() {
		return [
			'amount' => $this->raw('amount', 0),
			'tip' => $this->raw('tip', 0),
			'type' => $this->raw('type', 7)
		];
	}

	public function bundle() {
		return [
			'amount' => $this->amount,
			'tip' => $this->tip,
			'type' => $this->type
		];
	}

}