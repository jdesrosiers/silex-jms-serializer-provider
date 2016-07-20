<?php

namespace JDesrosiers\Silex\Provider;

use JMS\Serializer\SerializerBuilder;
use Pimple\Container;

class BuilderService
{
    public function __invoke(Container $app) {
        $serializerBuilder = SerializerBuilder::create();

        if ($app->offsetExists("debug")) {
            $serializerBuilder->setDebug($app["debug"]);
        }

        if ($app->offsetExists("serializer.annotationReader")) {
            $serializerBuilder->setAnnotationReader($app["serializer.annotationReader"]);
        }

        if ($app->offsetExists("serializer.cacheDir")) {
            $serializerBuilder->setCacheDir($app["serializer.cacheDir"]);
        }

        if ($app->offsetExists("serializer.configureHandlers")) {
            $serializerBuilder->configureHandlers($app["serializer.configureHandlers"]);
        }

        if ($app->offsetExists("serializer.configureListeners")) {
            $serializerBuilder->configureListeners($app["serializer.configureListeners"]);
        }

        if ($app->offsetExists("serializer.objectConstructor")) {
            $serializerBuilder->setObjectConstructor($app["serializer.objectConstructor"]);
        }

        $serializerBuilder->setPropertyNamingStrategy($app["serializer.propertyNamingStrategy"]);

        if ($app->offsetExists("serializer.serializationVisitors")) {
            $this->setSerializationVisitors($app, $serializerBuilder);
        }

        if ($app->offsetExists("serializer.deserializationVisitors")) {
            $this->setDeserializationVisitors($app, $serializerBuilder);
        }

        if ($app->offsetExists("serializer.includeInterfaceMetadata")) {
            $serializerBuilder->includeInterfaceMetadata($app["serializer.includeInterfaceMetadata"]);
        }

        if ($app->offsetExists("serializer.metadataDirs")) {
            $serializerBuilder->setMetadataDirs($app["serializer.metadataDirs"]);
        }

        return $serializerBuilder;
    }

    /**
     * Override default serialization vistors
     *
     * @param Container $app
     * @param SerializerBuilder $serializerBuilder
     */
    protected function setSerializationVisitors(Container $app, SerializerBuilder $serializerBuilder)
    {
        $serializerBuilder->addDefaultSerializationVisitors();

        foreach ($app["serializer.serializationVisitors"] as $format => $visitor) {
            $serializerBuilder->setSerializationVisitor($format, $visitor);
        }
    }

    /**
     * Override default deserialization visitors
     *
     * @param Container $app
     * @param SerializerBuilder $serializerBuilder
     */
    protected function setDeserializationVisitors(Container $app, SerializerBuilder $serializerBuilder)
    {
        $serializerBuilder->addDefaultDeserializationVisitors();

        foreach ($app["serializer.deserializationVisitors"] as $format => $visitor) {
            $serializerBuilder->setDeserializationVisitor($format, $visitor);
        }
    }
}
