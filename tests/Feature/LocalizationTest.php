<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocalizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_is_redirected_to_preferred_locale_on_login()
    {
        $user = User::factory()->create(['locale' => 'fr']);

        $response = $this->post(localized_route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(localized_route('dashboard', [], 'fr'));
    }

    public function test_user_is_redirected_to_preferred_locale_when_editing_profile()
    {
        $user = User::factory()->create(['locale' => 'fr']);

        $response = $this->withCookie('locale', 'fr')->actingAs($user)->from(localized_route('users.edit'))->put(localized_route('user-profile-information.update'), [
            'name' => $user->name,
            'email' => $user->email,
            'locale' => 'en',
        ]);
        $response->assertRedirect(localized_route('users.edit', [], 'en'));
    }
}
