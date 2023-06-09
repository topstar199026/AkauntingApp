<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitb7c57e09b328c0ff45b90820a64214a3
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

        spl_autoload_register(array('ComposerAutoloaderInitb7c57e09b328c0ff45b90820a64214a3', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitb7c57e09b328c0ff45b90820a64214a3', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitb7c57e09b328c0ff45b90820a64214a3::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
