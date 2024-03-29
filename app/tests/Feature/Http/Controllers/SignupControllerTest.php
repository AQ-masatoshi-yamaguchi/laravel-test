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

        $this->post('signup', $validData)->assertRedirect('mypage/posts');

        unset($validData['password']);

        $this->assertDatabaseHas('users', $validData);

        $user = User::firstWhere($validData);

        $this->assertTrue(Hash::check('password', $user->password));

        $this->assertAuthenticatedAs($user);
    }

    /**  @test */
    function 不正なデータではユーザ登録できない()
    {
        //$this->withoutExceptionHandling();
        $url = 'signup';

        User::factory()->create([
            'email' => 'aaa@bbb.net',
        ]);

        $this->from('signup')->post($url, [])->assertRedirect('signup');

        app()->setLocale('testing');

        $this->post($url, ['name' => ''])->assertInvalid([
            'name' => 'required',
        ]);
        $this->post($url, ['name' => str_repeat('あ', 21)])->assertInvalid([
            'name' => 'max',
        ]);
        $this->post($url, ['name' => str_repeat('あ', 20)])->assertvalid('name');

        $this->post($url, ['email' => ''])->assertInvalid([
            'email' => 'required',
        ]);
        $this->post($url, ['email' => 'aa@bb@cc'])->assertInvalid([
            'email' => 'email',
        ]);
        $this->post($url, ['email' => 'aa@ああ.net'])->assertInvalid([
            'email' => 'email',
        ]);
        $this->post($url, ['email' => 'aaa@bbb.net'])->assertInvalid([
            'email' => 'unique',
        ]);

        $this->post($url, ['password' => ''])->assertInvalid([
            'password' => 'required',
        ]);
        $this->post($url, ['password' => 'abcd123'])->assertInvalid([
            'password' => 'min',
        ]);
        $this->post($url, ['password' => 'abcd1234'])->assertvalid('password');
    }
}
