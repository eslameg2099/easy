<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\City;
use App\Models\Shop;
use App\Models\User;
use App\Models\ShopOwner;
use Illuminate\Http\UploadedFile;
use App\Events\VerificationCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;

class RegisterTest extends TestCase
{
    public function test_customer_register_validation()
    {
        $this->postJson(route('api.sanctum.register'), [])
            ->assertJsonValidationErrors(['name', 'email', 'phone', 'password']);

        $this->postJson(route('api.sanctum.register'), [
            'name' => 'User',
            'email' => 'user.demo.com',
            'phone' => '123456',
            'type' => User::CUSTOMER_TYPE,
            'avatar' => UploadedFile::fake()->create('file.pdf'),
            'password' => 'password',
            'password_confirmation' => '123456',
        ])
            ->assertJsonValidationErrors(['email', 'password', 'avatar']);
    }

    public function test_customer_register()
    {
        Event::fake();

        Storage::fake('avatars');

        $response = $this->postJson(route('api.sanctum.register'), [
            'name' => 'User',
            'email' => 'user@demo.com',
            'phone' => '123456',
            'password' => 'password',
            'type' => User::CUSTOMER_TYPE,
            'password_confirmation' => 'password',
            'avatar' => UploadedFile::fake()->image('avatar.jpg'),
        ]);

        $response->assertSuccessful()
            ->assertJsonStructure(['token']);

        $user = User::all()->last();

        $this->assertEquals($user->name, 'User');

        $this->assertCount(1, $user->getMedia('avatars'));

        Event::assertDispatched(VerificationCreated::class);
    }

    public function test_delegate_register_validation()
    {
        $this->postJson(route('api.sanctum.register'), [])
            ->assertJsonValidationErrors(['name', 'email', 'phone', 'password']);

        $this->postJson(route('api.sanctum.register'), [
            'name' => 'User',
            'email' => 'user.demo.com',
            'phone' => '123456',
            'type' => User::DELEGATE_TYPE,
            'avatar' => UploadedFile::fake()->create('file.pdf'),
            'password' => 'password',
            'password_confirmation' => '123456',
        ])
            ->assertJsonValidationErrors(['email', 'password', 'identifier', 'avatar']);
    }

    public function test_shop_owner_register_validation()
    {
        $this->postJson(route('api.sanctum.register'), [])
            ->assertJsonValidationErrors(['name', 'email', 'phone', 'password']);

        $this->postJson(route('api.sanctum.register'), [
            'name' => 'User',
            'email' => 'user.demo.com',
            'phone' => '123456',
            'type' => User::SHOP_OWNER_TYPE,
            'avatar' => UploadedFile::fake()->create('file.pdf'),
            'password' => 'password',
            'password_confirmation' => '123456',
            'shop_banner' => UploadedFile::fake()->create('file.pdf'),
        ])
            ->assertJsonValidationErrors([
                'email',
                'password',
                'avatar',
                'shop_name',
                'shop_description',
                'shop_logo',
                'shop_banner',
            ]);
    }

    public function test_shop_owner_register()
    {
        Event::fake();

        Storage::fake('avatars');

        $response = $this->postJson(route('api.sanctum.register'), [
            'name' => 'User',
            'email' => 'user@demo.com',
            'phone' => '123456',
            'password' => 'password',
            'city_id' => City::factory()->create()->id,
            'type' => User::SHOP_OWNER_TYPE,
            'password_confirmation' => 'password',
            'avatar' => UploadedFile::fake()->image('avatar.jpg'),
            'shop_name' => 'Test Shop',
            'shop_description' => 'Something ...',
            'shop_logo' => UploadedFile::fake()->image('logo.jpg'),
            'shop_banner' => UploadedFile::fake()->image('logo.jpg'),
        ]);

        $response->assertSuccessful()
            ->assertJsonStructure(['token']);

        $user = ShopOwner::all()->last();

        $this->assertEquals($user->name, 'User');

        $this->assertCount(1, $user->getMedia('avatars'));
        $this->assertCount(1, $user->shop->getMedia('logo'));
        $this->assertCount(1, $user->shop->getMedia('banner'));

        Event::assertDispatched(VerificationCreated::class);
    }
}
