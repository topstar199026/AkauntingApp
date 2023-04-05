<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit1936024443f55ec0d0ec3e5d9f20b764
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit1936024443f55ec0d0ec3e5d9f20b764', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit1936024443f55ec0d0ec3e5d9f20b764', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit1936024443f55ec0d0ec3e5d9f20b764::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}