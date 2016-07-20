<?php

namespace JDesrosiers\Silex\Provider;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Api\BootableProviderInterface;
use Silex\Application;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

/**
 * JMS Serializer integration for Silex.
 */
class JmsSerializerServiceProvider implements ServiceProviderInterface, BootableProviderInterface
{
    /**
     * Register the jms/serializer annotations
     *
     * @param Application $app
     */
    public function boot(Application $app)
    {
        if ($app->offsetExists("serializer.srcDir")) {
            AnnotationRegistry::registerAutoloadNamespace("JMS\Serializer\Annotation", $app["serializer.srcDir"]);
        }
    }

    /**
     * Register the serializer and serializer.builder services
     *
     * @param Container $app
     *
     * @throws ServiceUnavailableHttpException
     */
    public function register(Container $app)
    {
        $app["serializer.namingStrategy"] = "CamelCase";
        $app["serializer.namingStrategy.separator"] = "_";
        $app["serializer.namingStrategy.lowerCase"] = true;

        $app["serializer.propertyNamingStrategy"] = new PropertyNamingStrategyService();
        $app["serializer.builder"] = new BuilderService();
        $app["serializer"] = function (Container $app) {
            return $app["serializer.builder"]->build();
        };
    }
}
