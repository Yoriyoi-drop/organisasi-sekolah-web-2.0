<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class EmailOtpTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_receives_otp_after_registration(): void
    {
        Notification::fake();

        $response = $this->post(route('register.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'nik' => '1234567890123456',
            'nis' => '1234567890',
        ]);

        $response->assertRedirect(route('otp.show'));
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_can_verify_with_correct_otp(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'vrfy@example.com',
            'email_verified_at' => null,
        ]);

        $this->withSession(['otp_user_id' => $user->id]);
        $code = $user->generateEmailOtp('127.0.0.1', 'PHPUnit');

        $response = $this->post(route('otp.verify'), [
            'code' => $code,
        ]);

        $response->assertRedirect(route('login'));
        $this->assertNotNull($user->fresh()->email_verified_at);
    }
}
