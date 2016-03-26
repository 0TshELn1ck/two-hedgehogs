<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Tests\TestBaseWeb;

class DishControllerTest extends TestBaseWeb
{
    public function testShowOne()
    {
        $client = static::createClient();
        $client->request('GET', '/menu/dish/salad');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
