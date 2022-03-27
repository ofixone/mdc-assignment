<?php

use App\Model\Contract\Validation\Validator;
use App\Model\Entity\Store;
use App\Model\Validation\Rule;

class StoreTest extends TestCase
{
    private Validator $validator;
    private \Faker\Generator $faker;

    public function testCigarettesSuitableOnlyForCornerShop()
    {
        $cornerShop = new Store\CornerShop($this->faker->company());
        $otherTypeShop = new Store\Pharmacy($this->faker->company);
        $cigarettePosition = new Store\Assortment\Position(
            new Store\Assortment\Product(
                Store\Assortment\Product::TYPE_CIGARETTE, $this->faker->word
            ), random_int(1, 1000), random_int(0, 10)
        );
        $cornerShop->addPosition($cigarettePosition);
        $cornerValidateErrors = $this->validator->validate(
            [new Rule\UnsuitableProductTypesForStore($cornerShop, [])]
        );
        $this->assertEquals([], $cornerValidateErrors);

        $otherTypeShop->addPosition($cigarettePosition);
        $otherTypeShopErrors = $this->validator->validate(
            [
                new Rule\UnsuitableProductTypesForStore(
                    $cornerShop,
                    [Store\Assortment\Product::TYPE_CIGARETTE]
                )
            ]
        );
        $this->assertCount(1, $otherTypeShopErrors);
    }

    public function testMedicineSuitableOnlyForPharmacy()
    {
        $pharmacyShop = new Store\Pharmacy($this->faker->company());
        $otherTypeShop = new Store\CornerShop($this->faker->company);
        $medicinePosition = new Store\Assortment\Position(
            new Store\Assortment\Product(
                Store\Assortment\Product::TYPE_MEDICINE, $this->faker->word
            ), random_int(1, 1000), random_int(0, 10)
        );
        $pharmacyShop->addPosition($medicinePosition);
        $cornerValidateErrors = $this->validator->validate(
            [new Rule\UnsuitableProductTypesForStore($pharmacyShop, [])]
        );
        $this->assertEquals([], $cornerValidateErrors);

        $otherTypeShop->addPosition($medicinePosition);
        $otherTypeShopErrors = $this->validator->validate(
            [
                new Rule\UnsuitableProductTypesForStore(
                    $otherTypeShop,
                    [Store\Assortment\Product::TYPE_MEDICINE]
                )
            ]
        );
        $this->assertCount(1, $otherTypeShopErrors);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Faker\Factory::create();
        $this->validator = $this->app->make(Validator::class);
    }
}
