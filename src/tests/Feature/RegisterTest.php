<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use App\Models\User;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    public function test_name_is_required()
    {
        $this->get('/register');

        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_email_is_required()
    {
        $this->get('/register');

        $response = $this->post('/register', [
            'name' => 'テスト太郎',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);

        $response->assertSessionHasErrors('email');
    }
    public function test_password_is_required()
    {
        $this->get('/register');

        $response = $this->post('/register', [
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => 'password123'
        ]);

        $response->assertSessionHasErrors('password');
    }
    public function test_password_must_be_8_characters_or_more()
    {
        $this->get('/register');

        $response = $this->post('/register', [
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => 'pass',
            'password_confirmation' => 'pass'
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_password_confirmation_must_match()
    {
        $this->get('/register');

        $response = $this->post('/register', [
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password456'
        ]);

        $response->assertSessionHasErrors('password');
    }
    public function test_user_can_register()
    {
        $this->get('/register');

        $response = $this->post('/register', [
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);


        $this->assertDatabaseHas('users', [
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
        ]);

        $response->assertRedirect('/mypage/profile');
    }


    public function test_verification_email_is_sent_after_registration()
    {
        Notification::fake();
        $registerData = [
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post('/register', $registerData);

        $response->assertRedirect('/mypage/profile');

        $user = User::where('email', 'test@example.com')->first();
        $this->assertNotNull($user);

        Notification::assertSentTo(
            [$user],
            VerifyEmail::class
        );
    }

    public function test_user_can_verify_email_from_the_verification_prompt_screen()
    {
        $user = User::factory()->create([
            'email_verified_at' => null, 
        ]);

        $response = $this->actingAs($user)->get('/email/verify');
        $response->assertStatus(200);

        $response->assertSee('href="https://mailtrap.io/"', false);
        $response->assertSee('認証');

    }


    public function test_user_is_redirected_to_profile_settings_after_successful_email_verification()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertRedirect('/mypage/profile?verified=1');

        $this->assertNotNull($user->fresh()->email_verified_at);
    }



}
