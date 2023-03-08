<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb3ac9c1ba35152f05f261e17c4b9d675
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SpotifyWebAPI\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SpotifyWebAPI\\' => 
        array (
            0 => __DIR__ . '/..' . '/jwilsson/spotify-web-api-php/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb3ac9c1ba35152f05f261e17c4b9d675::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb3ac9c1ba35152f05f261e17c4b9d675::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb3ac9c1ba35152f05f261e17c4b9d675::$classMap;

        }, null, ClassLoader::class);
    }
}
