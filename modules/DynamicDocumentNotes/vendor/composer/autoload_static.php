<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit355d40d2940d42af0eb32c93a43656aa
{
    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit355d40d2940d42af0eb32c93a43656aa::$classMap;

        }, null, ClassLoader::class);
    }
}