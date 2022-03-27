<?php

use App\Model\Contract\Store as StoreContract;
use App\Model\Entity\Bill;
use App\Model\Entity\Store;
use App\Model\Exceptions\ValidationViolation;
use App\Model\Service\BillService;

class BillTest extends TestCase
{
    private \Faker\Generator $faker;
    private BillService $billService;

    /** @var StoreContract[] */
    private array $storeChain = [];

    public function testCreateBillSuccessfully()
    {
        $shop = $this->storeChain[Store\CornerShop::TYPE];
        $position = $shop->getPositionByName('Marlboro');

        $bill = $this->factoryBill($shop, new DateTimeImmutable(), [
            ['position' => $position, 'quantity' => 1]
        ]);

        $this->assertNotNull($bill);
    }

    /**
     * @param StoreContract $store
     * @param DateTimeInterface $date
     * @param array{position: Store\Assortment\Position, quantity: int} $positions
     * @return Bill\Bill|null
     */
    private function factoryBill(
        StoreContract $store, DateTimeInterface $date, array $positions
    ): ?Bill\Bill
    {
        $purchasePositions = [];
        foreach ($positions as $item) {
            $purchasePositions[] = new Bill\PurchasePosition(
                $item['position'],
                $item['quantity']
            );
        }

        return $this->billService->purchase(
            $store,
            $date,
            new Bill\Customer(
                $this->faker->firstName,
                $this->faker->lastName,
                $this->faker->phoneNumber
            ),
            $purchasePositions
        );
    }

    public function testCreateBillSuccessfullyInNextYear()
    {
        $shop = $this->storeChain[Store\CornerShop::TYPE];
        $position = $shop->getPositionByName('Marlboro');

        $bill = $this->factoryBill($shop, new DateTimeImmutable(), [
            ['position' => $position, 'quantity' => 1]
        ]);
        $currentYearNext = $this->factoryBill($shop, new DateTimeImmutable(), [
            ['position' => $position, 'quantity' => 1]
        ]);
        $nextYearBill = $this->factoryBill(
            $shop,
            new DateTimeImmutable('+1 year'),
            [
                ['position' => $position, 'quantity' => 1]
            ]
        );

        $this->assertNotNull($bill);
        $this->assertNotNull($nextYearBill);
        $this->assertEquals(1, $bill->getId());
        $this->assertEquals(2, $currentYearNext->getId());
        $this->assertEquals(1, $nextYearBill->getId());
    }

    public function testCreateBillUnsuccessfullyCauseQuantityOverOrLessThanNeeded(
    )
    {
        $shop = $this->storeChain[Store\CornerShop::TYPE];
        $position = $shop->getPositionByName('Marlboro');

        $position->setQuantity(0);

        $this->expectException(
            ValidationViolation::class
        );

        $this->factoryBill($shop, new DateTimeImmutable(), [
            ['position' => $position, 'quantity' => 1]
        ]);
    }

    public function testCreateBillUnsuccessfullyAfterSuccessWhenQuantityOver()
    {
        $shop = $this->storeChain[Store\CornerShop::TYPE];
        $position = $shop->getPositionByName('Marlboro');
        $position2 = $shop->getPositionByName('Tuna');

        $position->setQuantity(10);

        $this->factoryBill($shop, new DateTimeImmutable(), [
            ['position' => $position, 'quantity' => 10],
            ['position' => $position2, 'quantity' => 2],
        ]);
        $this->assertEquals(0, $position->getQuantity());
        $this->assertEquals(3, $position2->getQuantity());
        $this->expectException(
            ValidationViolation::class
        );
        $this->factoryBill($shop, new DateTimeImmutable(), [
            ['position' => $position, 'quantity' => 10]
        ]);
    }

    public function testValidateSerialNumberRequirement()
    {
        $shop = $this->storeChain[Store\Pharmacy::TYPE];
        $position = $shop->getPositionByName('Oxycodone');

        $this->expectException(
            ValidationViolation::class
        );

        $this->factoryBill($shop, new DateTimeImmutable(), [
            ['position' => $position, 'quantity' => 1]
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Faker\Factory::create();
        $this->billService = $this->app->make(BillService::class);

        $cornerShop = new Store\CornerShop($this->faker->company);
        $pharmacyShop = new Store\Pharmacy($this->faker->company);
        $supermarketShop = new Store\Supermarket($this->faker->company);
        $cornerAssortment = [
            'Marlboro' => new Store\Assortment\Position(
                new Store\Assortment\Product(
                    Store\Assortment\Product::TYPE_CIGARETTE,
                    'Marlboro'
                ), 250, 10
            ),
            'Tuna' => new Store\Assortment\Position(
                new Store\Assortment\Product(
                    Store\Assortment\Product::TYPE_FOOD,
                    'Tuna'
                ), 100, 5
            ),
            'Cola' => new Store\Assortment\Position(
                new Store\Assortment\Product(
                    Store\Assortment\Product::TYPE_FOOD,
                    'Cola'
                ), 20, 500
            ),
        ];
        $pharmacyAssortment = [
            'Oxycodone' => new Store\Assortment\Position(
                new Store\Assortment\Product(
                    Store\Assortment\Product::TYPE_MEDICINE,
                    'Oxycodone'
                ), 2000, 5
            ),
            'Oxytetracycline' => new Store\Assortment\Position(
                new Store\Assortment\Product(
                    Store\Assortment\Product::TYPE_FOOD,
                    'Oxytetracycline'
                ), 1000, 15
            ),
            'Gratty' => new Store\Assortment\Position(
                new Store\Assortment\Product(
                    Store\Assortment\Product::TYPE_TOY,
                    'Gratty'
                ), 1500, 10
            ),
        ];
        $supermarketAssortment = [
            'Aroma' => new Store\Assortment\Position(
                new Store\Assortment\Product(
                    Store\Assortment\Product::TYPE_CIGARETTE,
                    'Aroma'
                ), 300, 10
            ),
            'Aware ticket' => new Store\Assortment\Position(
                new Store\Assortment\Product(
                    Store\Assortment\Product::TYPE_PARKING_TICKET,
                    'Aware ticket'
                ), 10, 100
            ),
            'Barbie' => new Store\Assortment\Position(
                new Store\Assortment\Product(
                    Store\Assortment\Product::TYPE_TOY,
                    'Barbie'
                ), 1000, 10
            ),
        ];
        $cornerShop->setAssortment($cornerAssortment);
        $pharmacyShop->setAssortment($pharmacyAssortment);
        $supermarketShop->setAssortment($supermarketAssortment);
        $this->storeChain = [
            Store\CornerShop::TYPE => $cornerShop,
            Store\Pharmacy::TYPE => $pharmacyShop,
            Store\Supermarket::TYPE => $supermarketAssortment
        ];
    }
}
