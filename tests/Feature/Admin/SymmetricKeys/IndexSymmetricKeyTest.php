<?php

namespace Tests\Feature\Admin\SymmetricKeys;

use App\Models\SymmetricKey;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class IndexSymmetricKeyTest extends TestCase
{
    use RefreshDatabase;

    private const ROUTE_NAME = 'admin.symmetrics.index';

    /** @test */
    public function guest_user_is_redirected_to_login_form(): void
    {
        $response = $this->get(route(self::ROUTE_NAME));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function user_has_access_to_symmetric_key_list(): void
    {
        $user = User::factory()->create();

        $key = SymmetricKey::factory()
            ->for($user)
            ->create();

        $response = $this->actingAs($user)
            ->get(route(self::ROUTE_NAME));

        $response->assertOk()
            ->assertViewIs('admin.symmetric_keys.index')
            ->assertViewHas('keys', function (LengthAwarePaginator $data) use ($key) {
                return $data->getCollection()->first()->is($key);
            })
            ->assertSeeText($key->description)
            ->assertSeeText($key->bits)
            ->assertSeeText($key->created_at);
    }
}
