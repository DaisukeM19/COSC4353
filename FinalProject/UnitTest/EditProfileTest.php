<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected function successfulEditProfileRoute()
    {
        return route('Edit Profile');
    }

    protected function DashboardRoute()
    {
        return route('Back To Dashboard');
    }

    protected function SubmitRoute()
    {
        return route('Submit');
    }

    protected function logoutRoute()
    {
        return route('logout');
    }

    protected function successfulLogoutRoute()
    {
        return '/';
    }

    

    public function testUserCanViewEditProfile()
    {
        $response = $this->get($this->EditProfileRoute());

        $response->assertSuccessful();
        $response->assertViewIs('Edit Profile');
    }

    
    public function testUserCanEnterInformation()
    {
        Event::fake();

        $response = $this->post($this->registerPostRoute(), [
            'Full Name' => 'John Doe',
            'Address1' => '123 Street',
            'City' => 'Houston',
            'State' => 'TX',
            'Zip Code' => '123456',
    
        ]);

        $response->assertRedirect($this->successfulRegistrationRoute());
        $this->assertCount(1, $users = User::all());
        $this->assertAuthenticatedAs($user = $users->first());
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->address);
        $this->assertEquals('john@example.com', $user->city);
        $this->assertEquals('john@example.com', $user->state);
        $this->assertEquals('john@example.com', $user->zipcode);
        Event::assertDispatched(EditProfile::class, function ($e) use ($user) {
            return $e->user->id === $user->id;
        });
    }

      
    public function testUserCanSubmit()
    {
        $this->be(factory(User::class)->create());

        $response = $this->post($this->SubmitRoute());

        $response->assertRedirect($this->successfulSubmitRoute());
        $this->assertGuest();
    }

    public function testUserCanDashboard()
    {
        $this->be(factory(User::class)->create());

        $response = $this->post($this->DashbaordRoute());

        $response->assertRedirect($this->successfulDashboardRoute());
        $this->assertGuest();
    }


    public function testUserCanLogout()
    {
        $this->be(factory(User::class)->create());

        $response = $this->post($this->logoutRoute());

        $response->assertRedirect($this->successfulLogoutRoute());
        $this->assertGuest();
    }

    public function testUserCannotLogoutWhenNotAuthenticated()
    {
        $response = $this->post($this->logoutRoute());

        $response->assertRedirect($this->successfulLogoutRoute());
        $this->assertGuest();
    }

    
}
