<?php namespace Revel\Models;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read bool $active
 * @property-read int $establishmentId
 */
class Category extends Model {

	protected function fields() {
		return [
			'id' => $this->raw('id'),
			'name' => $this->raw('name'),
			'active' => $this->raw('active'),
			'establishmentId' => $this->raw('establishment')
		];
	}

	/**
	 * @return Establishment
	 */
	public function establishment() {
		return $this->revel->establishments()->findById($this->establishmentId);
	}

	/**
	 * @return Category[]
	 */
	public function subcategories() {
		return Category::many($this->revel, $this->raw('subcategories'));
	}

	/**
	 * @return Product[]
	 */
	public function products() {
		return array_values(array_filter($this->revel->products()->all(), function(Product $product) {
			return $product->category()->id === $this->id;
		}));
	}

}