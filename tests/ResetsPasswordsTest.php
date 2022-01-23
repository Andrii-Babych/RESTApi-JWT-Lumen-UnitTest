<?php

class ResetsPasswordsTest extends TestCase
{

    public function test_recover_password_email_field()
    {
        $response = $this->call('POST', '/api/user/recover-password', ['email' => '']);

        $this->assertResponseStatus(422);
        $this->assertEquals('Unauthorized', $response->original['title']);
        $this->assertEquals('You must fill in the email field', $response->original['detail']);
    }

    public function test_recover_password_valid_email()
    {
        $response = $this->call('POST', '/api/user/recover-password', ['email' => 'tom_and_jerry_gmail.com']);

        $this->assertResponseStatus(422);
        $this->assertEquals('Unauthorized', $response->original['title']);
        $this->assertEquals('Email address tom_and_jerry_gmail.com is considered valid', $response->original['detail']);
    }

//    public function test_recover_password_success()
//    {
//        app('db')->table('users')->insert([
//            'email' => 'tom_and_jerry@gmail.com',
//            'password' => app('hash')->make('1234567')
//        ]);
//
//        $response = $this->call('POST', '/api/user/recover-password', ['email' => 'tom_and_jerry@gmail.com']);
//
//        $this->assertResponseOk();
//        $this->assertEquals('Successfully', $response->original['title']);
//        $this->assertEquals('The letter was sent to the email address', $response->original['detail']);
//    }
}
