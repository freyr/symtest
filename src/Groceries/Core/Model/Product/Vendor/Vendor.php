<?php

declare(strict_types=1);

namespace App\Groceries\Core\Model\Vendor;

use App\Groceries\Core\Model\Product\CategoryId;

class Vendor {

    /** @var array<string, CategoryId> */
    private array $categories;

    public function __construct(
        public string $name,
        /** @var $categories array<int, CategoryId> */
        array $categories
    )
    {
        foreach ($categories as $category) {
            $this->categories[(string)$category->id] = $category;
        }
    }
    public function provide(CategoryId $categoryId): bool
    {
        return array_key_exists((string)$categoryId->id, $this->categories);
    }

}
