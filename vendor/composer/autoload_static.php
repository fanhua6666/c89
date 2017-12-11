<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit603b0849cbafb3293e4dae2cd23b2abb
{
    public static $files = array (
        'ec392715e97d938df5bc60cde5a984c2' => __DIR__ . '/../..' . '/system/helper.php',
    );

    public static $prefixLengthsPsr4 = array (
        's' => 
        array (
            'system\\' => 7,
        ),
        'h' => 
        array (
            'houdunwang\\' => 11,
        ),
        'a' => 
        array (
            'app\\' => 4,
        ),
        'W' => 
        array (
            'Whoops\\' => 7,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'system\\' => 
        array (
            0 => __DIR__ . '/../..' . '/system',
        ),
        'houdunwang\\' => 
        array (
            0 => __DIR__ . '/../..' . '/houdunwang',
        ),
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
        'Whoops\\' => 
        array (
            0 => __DIR__ . '/..' . '/filp/whoops/src/Whoops',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit603b0849cbafb3293e4dae2cd23b2abb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit603b0849cbafb3293e4dae2cd23b2abb::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
