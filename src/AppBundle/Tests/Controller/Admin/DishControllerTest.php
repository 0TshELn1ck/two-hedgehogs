<?php

namespace AppBundle\Tests\Controller\Admin;

use AppBundle\Tests\TestBaseWeb;

class DishControllerTest extends TestBaseWeb
{
    public function testIndex()
    {
        $this->logIn();
        $this->client->request('GET', '/admin/dish/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(),
            "Unexpected HTTP status code for GET /admin/dish/" . $this->client->getResponse()->getContent());
    }
}
