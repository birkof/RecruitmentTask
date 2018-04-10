<?php

namespace AppBundle\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

/**
 * Class PlatformType
 *
 * @package App\DBAL\Types
 */
final class PlatformType extends AbstractEnumType
{
    public const PLATFORM_IOS = 'iOS';
    public const PLATFORM_ANDROID = 'Android';

    protected static $choices = [
        self::PLATFORM_IOS     => 'iOS',
        self::PLATFORM_ANDROID => 'Android',
    ];
}
