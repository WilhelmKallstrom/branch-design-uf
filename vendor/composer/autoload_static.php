<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita089d5e0b2941930d21c0e71dbcd87aa
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita089d5e0b2941930d21c0e71dbcd87aa::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita089d5e0b2941930d21c0e71dbcd87aa::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
