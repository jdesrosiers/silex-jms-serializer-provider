<?php

namespace JDesrosiers\Tests\Silex\Provider;

use JDesrosiers\Silex\Provider\JmsSerializerServiceProvider;
use Silex\Application;

require_once __DIR__ . "/../vendor/autoload.php";

class JmsSerializerServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    protected $app;

    public function setUp()
    {
        $this->app = new Application();
        $this->app->register(new JmsSerializerServiceProvider(), array(
            "serializer.srcDir" => __DIR__ . "/../vendor/jms/serializer/src",
        ));
    }

    public function testBuilder()
    {
        // No tests yet, shame, shame, shame
    }
}
