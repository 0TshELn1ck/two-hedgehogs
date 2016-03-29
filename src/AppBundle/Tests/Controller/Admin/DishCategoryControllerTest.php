<?php

namespace AppBundle\Tests\Controller\Admin;

use AppBundle\Tests\TestBaseWeb;

class DishCategoryControllerTest extends TestBaseWeb
{
    public function testIndex()
    {
        $this->logIn();
        $this->client->request('GET', '/admin/dish/category/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(),
            "Unexpected HTTP status code for GET /admin/dish/category/" . $this->client->getResponse()->getContent());
    }
}
