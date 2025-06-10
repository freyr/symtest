<?php

declare(strict_types=1);

namespace App\Tests\Groceries;

use App\Groceries\Core\Model\Product\CategoryId;
use App\Groceries\Core\Model\Product\Product;
use App\Groceries\Core\Model\Product\ProductCatalog;
use App\Groceries\Core\Model\Product\ProductId;
use App\Groceries\Core\Model\Resupply\FirstVendorPairingStrategy;
use App\Groceries\Core\Model\Resupply\Quantity;
use App\Groceries\Core\Model\Resupply\ResupplyRequest;
use App\Groceries\Core\Model\Resupply\ResupplyRequestStatus;
use App\Groceries\Core\Model\Resupply\Unit;
use App\Groceries\Core\Model\Vendor\Vendor;
use App\Groceries\Core\Model\Vendor\VendorCatalog;
use App\Groceries\Core\UseCase\CreateNewOrderForResupplyRequest;
use App\Groceries\Core\UseCase\ProcessNewResupplyRequestHandler;
use App\Tests\Fakes\MessageBusInMemory;
use App\Tests\Fakes\RequestResupplyInMemoryRepository;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ProcessNewResupplyRequestHandlerTest extends TestCase
{
    #[Test]
    public function shouldCreateOrderForMatchingVendorAndResupplyRequest(): void
    {
        $repository = new RequestResupplyInMemoryRepository();

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

        $vendorCollection = new VendorCatalog([
            new Vendor('vendor1', [
                $fruitCategory,
            ]),
            new Vendor('vendor2', [
                new CategoryId(Uuid::uuid7()),
            ]),
        ]);

        $vendorPairingStrategy = new FirstVendorPairingStrategy();
        $messageBus = new MessageBusInMemory();

        $handler = new ProcessNewResupplyRequestHandler(
            $repository,
            $productCatalog,
            $vendorCollection,
            $vendorPairingStrategy,
            $messageBus,
        );

        $resupplyRequest = new ResupplyRequest(
            $apple->id,
            new Quantity(10, Unit::KILOGRAM),
        );
        $repository->save($resupplyRequest);


        $handler(
            new ExampleProcessNewResupplyRequestCommand(
                $resupplyRequest->id
            )
        );

        self::assertEquals(
            ResupplyRequestStatus::Executed,
            $repository->get($resupplyRequest->id)->status
        );

        self::assertNotNull($repository->get($resupplyRequest->id)->executedAt);
        self::assertCount(1, $messageBus->messages);
        self::assertInstanceOf(CreateNewOrderForResupplyRequest::class, $messageBus->messages[0]);
    }
}
