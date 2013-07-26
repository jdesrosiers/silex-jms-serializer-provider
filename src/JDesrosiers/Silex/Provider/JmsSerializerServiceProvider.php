<?php

namespace JDesrosiers\Silex\Provider;

use Doctrine\Common\Annotations\AnnotationRegistry;
use JMS\Serializer\Naming\CamelCaseNamingStrategy;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\SerializerBuilder;
use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * JMS Serializer integration for Silex.
 */
class JmsSerializerServiceProvider implements ServiceProviderInterface
{
    public function boot(Application $app)
    {
        AnnotationRegistry::registerAutoloadNamespace('JMS\Serializer\Annotation', $app['serializer.srcDir']);
    }

    public function register(Application $app)
    {
        $app['serializer.builder'] = $app->share(function () use ($app) {
            $serializerBuilder = SerializerBuilder::create()->setDebug($app['debug']);

            if ($app->offsetExists('serializer.annotationReader')) {
                $serializerBuilder->setAnnotationReader($app['serializer.annotationReader']);
            }

            if ($app->offsetExists('serializer.cacheDir')) {
                $serializerBuilder->setCacheDir($app['serializer.cacheDir']);
            }

            if ($app->offsetExists('serializer.configureHandlers')) {
                $serializerBuilder->configureHandlers($app['serializer.configureHandlers']);
            }

            if ($app->offsetExists('serializer.configureListeners')) {
                $serializerBuilder->configureListeners($app['serializer.configureListeners']);
            }

            if ($app->offsetExists('serializer.objectConstructor')) {
                $serializerBuilder->setObjectConstructor($app['serializer.objectConstructor']);
            }

            if ($app->offsetExists('serializer.namingStrategy')) {
                switch ($app['serializer.namingStrategy']) {
                    case 'IdenticalProperty':
                        $serializerBuilder->setPropertyNamingStrategy(new IdenticalPropertyNamingStrategy());
                        break;

                    case 'CamelCase':
                        $separator = $app->offsetExists('serializer.namingStrategy.separator') ? $app['serializer.namingStrategy.separator'] : null;
                        $lowerCase = $app->offsetExists('serializer.namingStrategy.lowerCase') ? $app['serializer.namingStrategy.lowerCase'] : null;
                        $serializerBuilder->setPropertyNamingStrategy(new CamelCaseNamingStrategy($separator, $lowerCase));
                        break;
                }
            }

            if ($app->offsetExists('serializer.includeInterfaceMetadata')) {
                $serializerBuilder->includeInterfaceMetadata($app['serializer.includeInterfaceMetadata']);
            }

            if ($app->offsetExists('serializer.metadataDirs')) {
                $serializerBuilder->setMetadataDirs($app['serializer.metadataDirs']);
            }

            return $serializerBuilder;
        });

        $app['serializer'] = $app->share(function () use ($app) {
            return $app['serializer.builder']->build();
        });
    }
}
