<?php

use JetBrains\PhpStorm\ArrayShape;

class SignInTest extends TestCase
{

    public function test_sign_in_success()
    {
        $user = $this->getSeedUser();
        app('db')->table('users')->insert($user);

        $response = $this->call('POST', '/api/user/sign-in', [
            "email" => 'tom_and_jerry@gmail.com',
            "password" => '1234567'
        ]);

        $this->assertResponseOk();
        $this->assertEquals('bearer', $response->original['token_type']);
    }

    public function test_sign_in_error()
    {
        $user = $this->getSeedUser();
        app('db')->table('users')->insert($user);

        $response = $this->call('POST', '/api/user/sign-in', [
            "email" => '',
            "password" => '1234567'
        ]);

        $this->assertResponseStatus(422);
        $this->assertEquals('Unauthorized', $response->original['title']);
        $this->assertEquals('You must fill in the email field', $response->original['detail']);
    }

    public function test_sign_in_success_logout()
    {
        $user = $this->getSeedUser();
        app('db')->table('users')->insert($user);

        $this->call('POST', '/api/user/sign-in', [
            "email" => 'tom_and_jerry@gmail.com',
            "password" => '1234567'
        ]);

        $this->assertTrue(\Auth::check());

        $response = $this->call('POST', '/api/user/logout');

        $this->assertResponseOk();
        $this->assertEquals('Successfully logged out', $response->original['message']);

    }

    #[ArrayShape(['email' => "string", 'password' => "mixed"])]
    private function getSeedUser(): array
    {
        return [
            'email' => 'tom_and_jerry@gmail.com',
            'password' => app('hash')->make('1234567'),
        ];
    }

}
