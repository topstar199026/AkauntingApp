<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite85b859b41b17339e33597e81c5392e0
{
    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInite85b859b41b17339e33597e81c5392e0::$classMap;

        }, null, ClassLoader::class);
    }
}
