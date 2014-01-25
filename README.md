silex-jms-serializer-provider
============================

[![Build Status](https://travis-ci.org/jdesrosiers/silex-jms-serializer-provider.png?branch=master)](https://travis-ci.org/jdesrosiers/silex-jms-serializer-provider)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/jdesrosiers/silex-jms-serializer-provider/badges/quality-score.png?s=30b8cd0e1f6a2cb5bd36e9593c86a4bf77fca905)](https://scrutinizer-ci.com/g/jdesrosiers/silex-jms-serializer-provider/)
[![Code Coverage](https://scrutinizer-ci.com/g/jdesrosiers/silex-jms-serializer-provider/badges/coverage.png?s=020eab2f4a91160daa47d31f56eb2c9031da2f51)](https://scrutinizer-ci.com/g/jdesrosiers/silex-jms-serializer-provider/)

[silex-jms-serializer-provider](https://github.com/jdesrosiers/silex-jms-serializer-provider) is a silex service provider
that integrates [JmsSerializer](https://github.com/schmittjoh/serializer) into [silex](https://github.com/fabpot/Silex).

Installation
------------
Install the silex-jms-serializer-provider using [composer](http://getcomposer.org/).  This project uses [sematic versioning](http://semver.org/).

```json
{
    "require": {
        "jdesrosiers/silex-jms-serializer-provider": "~0.1"
    }
}
```

Parameters
----------
* **serializer.srcDir**: (string) The path to the jms/serializer component.
* **serializer.annotationReader**: (AnnotationReader) Set a custom AnnotationReader.
* **serializer.cacheDir**: (string) Set a directory for caching annotations.
* **serializer.configureHandlers**: (Closure) Customize handlers.
* **serializer.configureListeners**: (Closure) Customize listeners.
* **serializer.objectConstructor**: (ObjectConstructorInterface) Set a custom ObjectConstructor.
* **serializer.namingStrategy**: (string) Set the PropertyNamingStrategy
* **serializer.namingStrategy.separator**: (string) If CamelCase is chosen as the NamingStrategy, you can override the default separator.
* **serializer.namingStrategy.lowerCase**: (boolean) If CamelCase is chosen as the NamingStrategy, you can override the lowerCase option.
* **serializer.serializationVisitors**: (array\<string:VisitorInterface\>) Override the default serialization visitors.
* **serializer.deserializationVisitors**: (array\<string:VisitorInterface\>) Override the default deserialization visitors.
* **serializer.includeInterfaceMetadata**: (boolean) Whether to include the metadata from the interfaces
* **serializer.metadataDirs**: (array<string:string>) Sets a map of namespace prefixes to directories.

Services
--------
* **serializer**: A Serializer object constructed with all of parameters given.
* **serializer.builder**: If all of the shortcuts provided are not sufficient, you can always get the SerializerBuilder
object and add additional customizations before the Serializer object is constructed.

Registering
-----------
```php
$app->register(new JDesrosiers\Silex\Provider\JmsSerializerServiceProvider(), array(
    "serializer.srcDir" => __DIR__ . "/vendor/jms/serializer/src",
));
```

Usage
-----
The Serializer documentation can be found at http://jmsyst.com/libs/serializer.

```php
$app->get("/foo", function () use ($app) {
    $foo = new Foo();
    return $app["serializer"]->serialize($foo, "json");
});
```

Using the Builder
-----------------
You can use the builder directly to add additional customizations

```php
$app->register(new JDesrosiers\Silex\Provider\JmsSerializerServiceProvider(), array(
    "serializer.srcDir" => __DIR__ . "/vendor/jms/serializer/src",
//    "serializer.namingStrategy" => "IdenticalProperty",
));
$app["serializer.builder"]->setPropertyNamingStrategy(new IdenticalPropertyNamingStrategy());
```

Adding Custom Handlers
----------------------
```php
$app->register(new JDesrosiers\Silex\Provider\JmsSerializerServiceProvider(), array(
    "serializer.srcDir" => __DIR__ . "/vendor/jms/serializer/src",
    "serializer.configureHandlers" => function(JMS\Serializer\Handler\HandlerRegistry $registry) {
        $registry->registerHandler('serialization', 'MyObject', 'json',
            function($visitor, MyObject $obj, array $type) {
                return $obj->getName();
            }
        );
    },
));
```
