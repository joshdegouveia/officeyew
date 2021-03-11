<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb50575eb81ca099dc0d2e77db777354e
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb50575eb81ca099dc0d2e77db777354e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb50575eb81ca099dc0d2e77db777354e::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
