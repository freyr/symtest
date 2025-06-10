<?php

declare(strict_types=1);

namespace App\Groceries\Core\Model\Resupply;

use App\Groceries\Core\Model\Product\ProductId;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ResupplyRequest
{
    readonly public UuidInterface $id;
    public ?DateTimeImmutable $executedAt {
        get => $this->executedAt;
    }

    public ResupplyRequestStatus $status {
        get => $this->status;
    }
    readonly public ProductId $productId;
    readonly public Quantity $quantity;

    public function __construct(
        ProductId $productId,
        Quantity $quantity,
    )
    {
        $this->id = UUid::uuid7();
        $this->status = ResupplyRequestStatus::New;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->executedAt = null;
    }

    public function markAsExecuted(): void
    {
        $this->executedAt = new DateTimeImmutable();
        $this->status = ResupplyRequestStatus::Executed;
    }

}
