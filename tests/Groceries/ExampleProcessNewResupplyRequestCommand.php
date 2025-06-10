<?php

declare(strict_types=1);

namespace App\Tests\Groceries;

use App\Groceries\Core\Port\Incoming\ProcessNewResupplyRequestCommand;
use Ramsey\Uuid\UuidInterface;

class ExampleProcessNewResupplyRequestCommand implements ProcessNewResupplyRequestCommand
{
    public UuidInterface $resupplyRequestId {
        get {
            return $this->resupplyRequestId;
        }
    }

    public function __construct(
        UuidInterface $resupplyRequestId
    ) {
        $this->resupplyRequestId = $resupplyRequestId;
    }
}
