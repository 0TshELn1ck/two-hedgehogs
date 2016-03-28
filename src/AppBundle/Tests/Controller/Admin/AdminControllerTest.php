<?php

namespace AppBundle\Tests\Controller\Admin;

use AppBundle\Tests\TestBaseWeb;

class AdminControllerTest extends TestBaseWeb
{
    public function testIndex()
    {
        $this->logIn();
        $this->client->request('GET', '/admin/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(),
            "Unexpected HTTP status code for GET /admin/".$this->client->getResponse()->getContent());
    }
}
