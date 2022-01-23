<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RegisterTest extends TestCase
{

    public function test_register_success()
    {
        $user = $this->getSeedUser();
        $response = $this->call('POST', '/api/user/register', $user);

        $this->assertResponseOk();
        $this->assertEquals('bearer', $response['token_type']);
    }

    public function test_register_error_empty_field()
    {
        $user = $this->getSeedUser();
        $user['first_name'] = '';

        $response = $this->call('POST', '/api/user/register', $user);

        $this->assertResponseStatus(422);
        $this->assertEquals('Unauthorized', $response->original['title']);
        $this->assertEquals('You must fill in first name', $response->original['detail']);
    }

    public function test_register_error_invalid_email()
    {
        $user = $this->getSeedUser();
        $user['email'] = 'tom_and_jerry_gmail.com';

        $response = $this->call('POST', '/api/user/register', $user);

        $this->assertResponseStatus(422);
        $this->assertEquals('Unauthorized', $response->original['title']);
        $this->assertEquals('Email address tom_and_jerry_gmail.com is considered valid', $response->original['detail']);
    }

    public function test_register_error_invalid_password()
    {
        $user = $this->getSeedUser();
        $user['password'] = '12345';

        $response = $this->call('POST', '/api/user/register', $user);

        $this->assertResponseStatus(422);
        $this->assertEquals('Unauthorized', $response->original['title']);
        $this->assertEquals('Password must be at least 7 characters', $response->original['detail']);
    }

    public function test_register_error_unique_email()
    {

        $user = $this->getSeedUser();
        $user['password'] = app('hash')->make('1234567');
        app('db')->table('users')->insert($user);

        $response = $this->call('POST', '/api/user/register', $this->getSeedUser());

        $this->assertResponseStatus(422);
        $this->assertEquals('Unauthorized', $response->original['title']);
        $this->assertEquals('User already exists with this email', $response->original['detail']);
    }

    private function getSeedUser(): array
    {
        return [
            'first_name' => 'Nikola',
            'last_name' => 'Tesla',
            'email' => 'nikola_tesla@gmail.com',
            'password' => '1234567',
            'phone' => '+380 (50) 123-45-67'
        ];
    }
}
