<?php namespace Revel\Models;

/**
 * @property int $price
 * @property int $productId
 * @property int $quantity
 */
class OrderItem extends SendableModel {

	protected function fields() {
		return [
			'price' => $this->raw('price', 0),
			'productId' => $this->raw('productId', null),
			'quantity' => $this->raw('quantity', 1)
		];
	}

	public function bundle() {
		return [
			'price' => floatval($this->price),
			'product' => intval($this->productId),
			'quantity' => intval($this->quantity)
		];
	}

}