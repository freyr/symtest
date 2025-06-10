<?php

declare(strict_types=1);

namespace App\Tests\Groceries;

use App\Groceries\Core\Model\Order\Supplier;
use App\Groceries\Core\Model\Order\SupplierId;
use App\Groceries\Core\Model\Product\ProductId;
use App\Groceries\Core\Model\Product\Vendor\VendorId;
use App\Groceries\Core\Model\Resupply\Quantity;
use App\Groceries\Core\Model\Resupply\ResupplyRequest;
use App\Groceries\Core\Model\Resupply\ResupplyRequestStatus;
use App\Groceries\Core\Model\Resupply\Unit;
use App\Groceries\Core\UseCase\CreateOrderHandler;
use App\Tests\Fakes\ExampleCreateOrdersCommand;
use App\Tests\Fakes\MessageBusInMemory;
use App\Tests\Fakes\OrderInMemoryRepository;
use App\Tests\Fakes\RequestResupplyInMemoryRepository;
use App\Tests\Fakes\SupplierInMemoryRepository;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateOrdersHandlerTest extends TestCase
{
    #[Test]
    public function shouldCreateOrderFromMultipleRequests()
    {
        $resupplyRepository = new RequestResupplyInMemoryRepository();
        $orderRepository = new OrderInMemoryRepository();
        $supplierRepository = new SupplierInMemoryRepository();
        $messageBus = new MessageBusInMemory();

        $handler = new CreateOrderHandler(
            $resupplyRepository,
            $orderRepository,
            $supplierRepository,
            $messageBus
        );


        // setup
        $supplier1 = new Supplier(new SupplierId(Uuid::uuid7()), 'supplier1');
        $supplier2 = new Supplier(new SupplierId(Uuid::uuid7()), 'supplier2');
        $supplierRepository->save($supplier1);
        $supplierRepository->save($supplier2);

        $product1 = new ProductId(Uuid::uuid7());
        $product2 = new ProductId(Uuid::uuid7());
        $product3 = new ProductId(Uuid::uuid7());
        $product4 = new ProductId(Uuid::uuid7());

        $resupplyRequest1 = new ResupplyRequest($product1, new Quantity(1, Unit::KILOGRAM));
        $resupplyRequest1->assignVendor(new VendorId($supplier1->id->id));
        $resupplyRepository->save($resupplyRequest1);

        $resupplyRequest2 = new ResupplyRequest($product2, new Quantity(1, Unit::KILOGRAM));
        $resupplyRequest2->assignVendor(new VendorId($supplier1->id->id));
        $resupplyRepository->save($resupplyRequest2);

        $resupplyRequest3 = new ResupplyRequest($product3, new Quantity(1, Unit::KILOGRAM));
        $resupplyRequest3->assignVendor(new VendorId($supplier2->id->id));
        $resupplyRepository->save($resupplyRequest3);

        $resupplyRequest4 = new ResupplyRequest($product4, new Quantity(1, Unit::KILOGRAM));
        $resupplyRequest4->assignVendor(new VendorId($supplier2->id->id));
        $resupplyRepository->save($resupplyRequest4);

        $handler(new ExampleCreateOrdersCommand());

        self::assertEquals(
            ResupplyRequestStatus::Executed,
            $resupplyRepository->get($resupplyRequest1->id)->status
        );

        self::assertEquals(
            ResupplyRequestStatus::Executed,
            $resupplyRepository->get($resupplyRequest2->id)->status
        );

        self::assertEquals(
            ResupplyRequestStatus::Executed,
            $resupplyRepository->get($resupplyRequest3->id)->status
        );

        self::assertEquals(
            ResupplyRequestStatus::Executed,
            $resupplyRepository->get($resupplyRequest4->id)->status
        );

        self::assertCount(2, $orderRepository->orders);
        self::assertCount(2, current($orderRepository->orders)->orderItems);

        next($orderRepository->orders);
        self::assertCount(2, current($orderRepository->orders)->orderItems);
    }
}
