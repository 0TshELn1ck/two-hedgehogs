<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Tests\TestBaseWeb;

class SurveyControllerTest extends TestBaseWeb
{
    public function testList()
    {
        $client = static::createClient();
        $client->request('GET', '/survey');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
