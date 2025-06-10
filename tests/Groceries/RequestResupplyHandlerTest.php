<?php

declare(strict_types=1);

namespace App\Tests\Groceries;

use App\Groceries\Core\Model\Product\CategoryId;
use App\Groceries\Core\Model\Product\Product;
use App\Groceries\Core\Model\Product\ProductCatalog;
use App\Groceries\Core\Model\Product\ProductId;
use App\Groceries\Core\Model\Resupply\ResupplyRequestedEvent;
use App\Groceries\Core\Model\Resupply\Unit;
use App\Groceries\Core\UseCase\RequestResupplyHandler;
use App\Tests\Fakes\ExampleRequestResupplyCommand;
use App\Tests\Fakes\MessageBusInMemory;
use App\Tests\Fakes\RequestResupplyInMemoryRepository;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use RuntimeException;

class RequestResupplyHandlerTest extends TestCase
{

    #[Test]
    public function shouldCreateResupplyRequestForProduct(): void
    {
        $repository = new RequestResupplyInMemoryRepository();
        $bus = new MessageBusInMemory();
        $fruitCategory = new CategoryId(Uuid::uuid7());
        $appleId = new ProductId(Uuid::uuid7());
        $apple = new Product(
            $appleId,
            'apples',
            Unit::KILOGRAM,
            $fruitCategory,
        );
        $productCatalog = new ProductCatalog(
            [
                $apple,
            ],
        );

        $handler = new RequestResupplyHandler(
            $repository,
            $bus,
            $productCatalog
        );

        $handler(new ExampleRequestResupplyCommand($appleId));
        self::assertCount(1, $repository->resupplyRequests);
        self::assertCount(1, $bus->messages);
        self::assertInstanceOf(
            ResupplyRequestedEvent::class,
            $bus->messages[0],
        );

    }


    #[Test]
    public function shouldFailIfProductDoNotExist(): void
    {
        $productId = new ProductId(Uuid::uuid7());
        $repository = new RequestResupplyInMemoryRepository();
        $bus = new MessageBusInMemory();
        $fruitCategory = new CategoryId(Uuid::uuid7());
        $appleId = new ProductId(Uuid::uuid7());
        $apple = new Product(
            $appleId,
            'apples',
            Unit::KILOGRAM,
            $fruitCategory,
        );
        $productCatalog = new ProductCatalog(
            [
                $apple,
            ],
        );

        $handler = new RequestResupplyHandler(
            $repository,
            $bus,
            $productCatalog
        );

        $this->expectException(RuntimeException::class);
        $handler(new ExampleRequestResupplyCommand($productId));

        self::assertCount(1, $repository->resupplyRequests);
        self::assertCount(1, $bus->messages);
        self::assertInstanceOf(
            ResupplyRequestedEvent::class,
            $bus->messages[0],
        );

    }
}
