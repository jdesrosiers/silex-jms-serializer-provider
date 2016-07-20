<?php

namespace JDesrosiers\Silex\Provider;

use JMS\Serializer\Naming\CamelCaseNamingStrategy;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Naming\PropertyNamingStrategyInterface;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use Pimple\Container;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class PropertyNamingStrategyService
{
    /**
     * Set the serialization naming strategy
     *
     * @param Container $app
     * @return PropertyNamingStrategyInterface
     *
     * @throws ServiceUnavailableHttpException
     */
    public function __invoke(Container $app)
    {
        if ($app["serializer.namingStrategy"] instanceof PropertyNamingStrategyInterface) {
            $namingStrategy = $app["serializer.namingStrategy"];
        } else {
            switch ($app["serializer.namingStrategy"]) {
                case "IdenticalProperty":
                    $namingStrategy = new IdenticalPropertyNamingStrategy();
                    break;
                case "CamelCase":
                    $separator = $app["serializer.namingStrategy.separator"];
                    $lowerCase = $app["serializer.namingStrategy.lowerCase"];
                    $namingStrategy = new CamelCaseNamingStrategy($separator, $lowerCase);
                    break;
                default:
                    throw new ServiceUnavailableHttpException(
                        null,
                        "Unknown property naming strategy '{$app["serializer.namingStrategy"]}'.  " .
                        "Allowed values are 'IdenticalProperty' or 'CamelCase'"
                    );
            }

            $namingStrategy = new SerializedNameAnnotationStrategy($namingStrategy);
        }

        return $namingStrategy;
    }
}