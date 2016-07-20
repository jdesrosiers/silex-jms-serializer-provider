<?php

namespace JDesrosiers\Silex\Provider;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

/**
 * JMS Serializer integration for Silex.
 */
class JmsSerializerServiceProvider implements ServiceProviderInterface
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
     * Registet the serializer and serializer.builder services
     *
     * @param Application $app
     *
     * @throws ServiceUnavailableHttpException
     */
    public function register(Application $app)
    {
        $app["serializer.namingStrategy"] = "CamelCase";
        $app["serializer.namingStrategy.separator"] = "_";
        $app["serializer.namingStrategy.lowerCase"] = true;

        $app["serializer.propertyNamingStrategy"] = $app->share(new PropertyNamingStrategyService());
        $app["serializer.builder"] = $app->share(new BuilderService());
        $app["serializer"] = $app->share(function (Application $app) {
            return $app["serializer.builder"]->build();
        });
    }
}
