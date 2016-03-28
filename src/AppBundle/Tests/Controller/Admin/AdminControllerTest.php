<?php

namespace AppBundle\Tests\Controller\Admin;

use AppBundle\Tests\TestBaseWeb;

class AdminControllerTest extends TestBaseWeb
{

    public function testIndex()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/admin');

        $this->assertTrue($this->client->getResponse()->isRedirect());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Admin Dashboard")')->count());
    }
}
