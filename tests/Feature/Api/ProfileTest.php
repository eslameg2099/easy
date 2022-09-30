<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Shop;
use App\Models\User;
use App\Models\ShopOwner;
use Laravel\Sanctum\Sanctum;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProfileTest extends TestCase
{
    /** @test */
    public function only_to_authenticated_user_can_display_his_profile()
    {
        $user = User::factory()->create();

        $this->getJson(route('api.profile.show'))
            ->assertStatus(401);

        Sanctum::actingAs($user, ['*']);

        $this->getJson(route('api.profile.show'))
            ->assertSuccessful();
    }

    /** @test */
    public function only_to_authenticated_user_can_update_his_profile()
    {
        $user = User::factory()->create([
            'name' => 'Ahmed',
            'email' => 'ahmed@demo.com',
            'phone' => '123456789',
        ]);

        $this->putJson(route('api.profile.update'))
            ->assertStatus(401);

        Sanctum::actingAs($user, ['*']);

        // test validation
        $this->putJson(route('api.profile.update'), [
            'name' => null,
            'email' => null,
            'phone' => null,
            'password' => 'password',
        ])
            ->assertJsonValidationErrors(['name', 'email', 'phone', 'old_password', 'password']);

        $this->putJson(route('api.profile.update'), [
            'name' => 'Mohamed',
            'email' => 'mohamed@demo.com',
            'phone' => '12345678',
        ])->assertSuccessful();
    }

    /** @test */
    public function only_to_authenticated_shop_owner_can_update_his_profile()
    {
        Storage::fake('public');

        $user = ShopOwner::factory()->create([
            'name' => 'Ahmed',
            'email' => 'ahmed@demo.com',
            'phone' => '123456789',
        ]);

        $shop = Shop::factory(['user_id' => $user])->create();

        $this->putJson(route('api.profile.update'))
            ->assertStatus(401);

        Sanctum::actingAs($user, ['*']);

        $this->putJson(route('api.profile.update'), [
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

        // test validation
        $this->putJson(route('api.profile.update'), [
            'name' => null,
            'email' => null,
            'phone' => null,
            'password' => 'password',
        ])
            ->assertJsonValidationErrors(['name', 'email', 'phone', 'old_password', 'password']);

        $this->putJson(route('api.profile.update'), [
            'name' => 'Mohamed',
            'email' => 'mohamed@demo.com',
            'phone' => '12345678',
            'shop_name' => 'Test Shop',
            'shop_description' => 'Something ...',
            'shop_logo' => UploadedFile::fake()->image('logo.jpg'),
            'shop_banner' => UploadedFile::fake()->image('logo.jpg'),
        ])->assertSuccessful();

        $this->assertEquals($shop->refresh()->name, 'Test Shop');
    }
}
