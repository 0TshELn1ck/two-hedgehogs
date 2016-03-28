<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Tests\TestBaseWeb;

class OrderControllerTest extends TestBaseWeb
{
    public function testGetCart()
    {
        $this->client->request('GET', '/order');
        $this->assertTrue($this->client->getResponse()->isRedirect());
    }
}
