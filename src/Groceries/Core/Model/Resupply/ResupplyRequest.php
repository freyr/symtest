<?php

declare(strict_types=1);

namespace App\Groceries\Core\Model\Resupply;

use App\Groceries\Core\Model\Product\ProductId;
use App\Groceries\Core\Model\Product\Vendor\VendorId;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ResupplyRequest
{
    readonly public UuidInterface $id;
    public ?DateTimeImmutable $assignedAt {
        get => $this->assignedAt;
    }

    public ResupplyRequestStatus $status {
        get => $this->status;
    }
    readonly public ProductId $productId;
    readonly public Quantity $quantity;
    public DateTimeImmutable $executedAt {
        get => $this->executedAt;
    }
    public ?VendorId $vendorId;

    public function __construct(
        ProductId $productId,
        Quantity $quantity,
    )
    {
        $this->id = UUid::uuid7();
        $this->status = ResupplyRequestStatus::New;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->assignedAt = null;
    }

    public function assignVendor(VendorId $vendorId): void
    {
        $this->assignedAt = new DateTimeImmutable();
        $this->status = ResupplyRequestStatus::Assigned;
        $this->vendorId = $vendorId;
    }

    public function markAsExecuted(): void
    {
        $this->executedAt = new DateTimeImmutable();
        $this->status = ResupplyRequestStatus::Executed;
    }
}
