<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Tests\TestBaseWeb;

class DishControllerTest extends TestBaseWeb
{
    public function testList()
    {
        $client = static::createClient();
        $client->request('GET', '/menu/dish/list');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }

    public function testShowOne()
    {
        $client = static::createClient();
        $em = $client->getContainer()->get('doctrine.orm.entity_manager');
        $slug = $em
            ->getRepository('AppBundle:Dish')
            ->findOneBy([])->getSlug();
        $crawler = $client->request('GET', "/menu/dish/{$slug}");
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('h1')->count());
    }
}
