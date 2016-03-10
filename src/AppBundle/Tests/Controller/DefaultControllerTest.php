<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Tests\TestBaseWeb;

class DefaultControllerTest extends TestBaseWeb
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
