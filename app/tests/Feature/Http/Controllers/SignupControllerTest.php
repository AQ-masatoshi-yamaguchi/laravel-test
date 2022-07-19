<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SignupControllerTest extends TestCase
{
    /**  @test */
    function ユーザ登録画面が開ける()
    {
        $this->get('signup')->assertOk();
    }

    /**  @test */
    function ユーザ登録できる()
    {
        $validData = [
            'name' => '太郎',
            'email' => 'aaa@bbb.net',
            'password' => 'password',
        ];

        $validData = User::factory()->validData();

        $this->post('signup', $validData)->assertOk();

        unset($validData['password']);

        $this->assertDatabaseHas('users', $validData);

        $user = User::firstWhere($validData);

        $this->assertTrue(Hash::check('password', $user->password));
    }
}
