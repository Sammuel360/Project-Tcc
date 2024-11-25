<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf7ced11f2ceb278664dad2b162b71891
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Source\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Source\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Source',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf7ced11f2ceb278664dad2b162b71891::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf7ced11f2ceb278664dad2b162b71891::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf7ced11f2ceb278664dad2b162b71891::$classMap;

        }, null, ClassLoader::class);
    }
}
