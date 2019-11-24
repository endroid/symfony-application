<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiLoginTest extends WebTestCase
{
    public function testApiLogin(): void
    {
        $client = static::createClient();
        $client->xmlHttpRequest('POST', '/api/login_check', [
            '_username' => 'admins',
            '_password' => 'admins',
        ]);

        $results = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('token', $results);
    }
}