<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Cart;
use App\Models\Product;
use App\Support\Cart\CartServices;
use Illuminate\Validation\ValidationException;

class CartServicesTest extends TestCase
{
    /** @test */
    public function it_create_a_new_cart_if_doesnt_have_identifier()
    {
        $this->assertEquals(0, Cart::count());

        $cartServices = new CartServices();

        $cartServices
            ->setIdentifier(123)
            ->paymentMethod('visa')
            ->shippingCost(20);

        $cartServices->getCart();

        $this->assertEquals(1, Cart::count());
    }

    /** @test */
    public function it_display_existing_cart_of_identifier()
    {
        $cartServices = new CartServices();

        $cartServices
            ->setIdentifier(123)
            ->paymentMethod('visa')
            ->shippingCost(20);

        $cart = $cartServices->getCart();

        $this->assertEquals($cart->identifier, 123);

        $this->assertEquals($cartServices->getCart()->identifier, 123);

        $this->assertEquals(1, Cart::count());
    }

    /** @test */
    public function it_can_add_item_to_cart()
    {
        $project = Product::factory()->create([
            'quantity' => 2,
            'colors' => null,
            'sizes' => null,
        ]);

        $cartServices = new CartServices();

        $cartServices
            ->setIdentifier(123)
            ->paymentMethod('visa')
            ->shippingCost(20)
            ->getCart();

        $cartServices->addItem($project);

        $this->assertCount(1, $cartServices->getItems());

        $this->assertEquals(1, $cartServices->getItems()->last()->quantity);
    }

    /** @test */
    public function it_cannot_add_item_to_cart_if_quantity_is_not_available()
    {
        $this->expectException(ValidationException::class);

        $project = Product::factory()->create([
            'quantity' => 2,
            'colors' => null,
            'sizes' => null,
        ]);

        $cartServices = new CartServices();

        $cartServices
            ->setIdentifier(123)
            ->paymentMethod('visa')
            ->shippingCost(20)
            ->getCart();

        $cartServices->addItem($project, 3);

        $this->assertCount(0, $cartServices->getItems());
    }

    /** @test */
    public function it_cannot_add_item_to_cart_if_color_is_not_specified()
    {
        $this->expectException(ValidationException::class);

        $project = Product::factory()->create([
            'quantity' => 2,
            'colors' => [
                [
                    'name' => 'Black',
                    'hex' => '#000',
                ],
            ],
            'sizes' => null,
        ]);

        $cartServices = new CartServices();

        $cartServices
            ->setIdentifier(123)
            ->paymentMethod('visa')
            ->shippingCost(20)
            ->getCart();

        $cartServices->addItem($project, 2);
    }

    /** @test */
    public function it_cannot_add_item_to_cart_if_size_is_not_specified()
    {
        $this->expectException(ValidationException::class);

        $project = Product::factory()->create([
            'quantity' => 2,
            'colors' => null,
            'sizes' => [
                ['size' => 'LG'],
            ],
        ]);

        $cartServices = new CartServices();

        $cartServices->setIdentifier(123)
            ->paymentMethod('visa')
            ->shippingCost(20)
            ->getCart();

        $cartServices->addItem($project, 2);
    }

    /** @test */
    public function it_cannot_add_item_to_cart_if_color_is_not_available()
    {
        $this->expectException(ValidationException::class);

        $project = Product::factory()->create([
            'quantity' => 2,
            'colors' => [
                [
                    'name' => 'Black',
                    'hex' => '#000',
                ],
            ],
            'sizes' => null,
        ]);

        $cartServices = new CartServices();

        $cartServices->setIdentifier(123)
            ->paymentMethod('visa')
            ->shippingCost(20)
            ->getCart();

        $cartServices->addItem(
            $project,
            2,
            [
                'name' => 'Red',
                'hex' => '#000',
            ]
        );
    }

    /** @test */
    public function it_cannot_add_item_to_cart_if_size_is_not_available()
    {
        $this->expectException(ValidationException::class);

        $project = Product::factory()->create([
            'quantity' => 2,
            'colors' => [
                [
                    'name' => 'Black',
                    'hex' => '#000',
                ],
            ],
            'sizes' => [
                [
                    'name' => 'LG',
                ],
            ],
        ]);

        $cartServices = new CartServices();

        $cartServices->setIdentifier(123)
            ->paymentMethod('visa')
            ->shippingCost(20)
            ->getCart();

        $cartServices->addItem(
            $project,
            2,
            [
                'name' => 'Black',
                'hex' => '#000',
            ],
            [
                'name' => 'MD',
            ],
        );
    }

    /** @test */
    public function it_update_quantity_if_add_item_with_same_id_and_attributes()
    {
        $project = Product::factory()->create([
            'colors' => [
                [
                    'name' => 'Black',
                    'hex' => '#000',
                ],
                [
                    'name' => 'Blue',
                    'hex' => '#0747a6',
                ],
            ],
            'sizes' => [
                [
                    'name' => 'LG',
                ],
                [
                    'name' => 'MD',
                ],
            ],
        ]);

        $cartServices = new CartServices();

        $cartServices->setIdentifier(123)
            ->paymentMethod('visa')
            ->shippingCost(20)
            ->getCart();

        $cartServices->addItem($project, 1, [
            'name' => 'Black',
            'hex' => '#000',
        ], [
            'name' => 'LG',
        ]);

        $this->assertCount(1, $cartServices->getItems());
        $this->assertEquals(1, $cartServices->getItems()->last()->quantity);

        $cartServices->addItem($project, 2, [
            'name' => 'Black',
            'hex' => '#000',
        ], [
            'name' => 'LG',
        ]);

        $this->assertCount(1, $cartServices->getItems());
        $this->assertEquals(2, $cartServices->getItems()->last()->quantity);
    }

    /** @test */
    public function it_add_new_item_if_the_product_id_or_attributes_is_different()
    {
        $project = Product::factory()->create([
            'colors' => [
                [
                    'name' => 'Black',
                    'hex' => '#000',
                ],
                [
                    'name' => 'Blue',
                    'hex' => '#0747a6',
                ],
            ],
            'sizes' => [
                [
                    'name' => 'LG',
                ],
                [
                    'name' => 'MD',
                ],
            ],
        ]);

        $project2 = Product::factory()->create([
            'colors' => null,
            'sizes' => null,
        ]);

        $cartServices = new CartServices();

        $cartServices->setIdentifier(123)
            ->paymentMethod('visa')
            ->shippingCost(20)
            ->getCart();

        $cartServices->addItem($project, 1, [
            'name' => 'Black',
            'hex' => '#000',
        ], [
            'name' => 'LG',
        ]);

        $this->assertCount(1, $cartServices->getItems());
        $this->assertEquals(1, $cartServices->getItems()->last()->quantity);

        $cartServices->addItem($project, 2, [
            'name' => 'Blue',
            'hex' => '#0747a6',
        ], [
            'name' => 'LG',
        ]);

        $this->assertCount(2, $cartServices->getItems());
        $this->assertEquals(2, $cartServices->getItems()->last()->quantity);

        $cartServices->addItem($project2);

        $this->assertCount(3, $cartServices->getItems());
        $this->assertEquals(1, $cartServices->getItems()->last()->quantity);
    }
}
