silex-jms-serializer-provider
============================

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
* **serializer.srcDir**:
* **serializer.builder**:
* **serializer.annotationReader**:
* **serializer.cacheDir**:
* **serializer.configureHandlers**:
* **serializer.configureListeners**:
* **serializer.objectConstructor**:
* **serializer.namingStrategy**:
* **serializer.namingStrategy.separator**:
* **serializer.namingStrategy.lowerCase**:
* **serializer.includeInterfaceMetadata**:
* **serializer.metadataDirs**:

Services
--------
* **serializer**:
* **serializer.builder**:

Registering
-----------
```php
$app->register(new JDesrosiers\Silex\Provider\JmsSerializerServiceProvider(), array(
    "serializer.srcDir" => __DIR__ . "/vendor/jms/serializer/src",
));
```
Usage
-----
