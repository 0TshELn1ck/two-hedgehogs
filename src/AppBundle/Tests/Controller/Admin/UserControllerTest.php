<?php

namespace AppBundle\Tests\Controller\Admin;

use AppBundle\Tests\TestBaseWeb;

class UserControllerTest extends TestBaseWeb
{
    public function testIndex()
    {
        $this->logIn();
        $this->client->request('GET', '/admin/user/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(),
            "Unexpected HTTP status code for GET /admin/" . $this->client->getResponse()->getContent());
    }

    public function testShow()
    {
        $this->logIn();
        $this->client->request('GET', "/admin/user/show/1");
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
