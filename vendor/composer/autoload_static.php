<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit089b710aef8497597dec4fe66ccc59fb
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Alura\\Leilao\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Alura\\Leilao\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit089b710aef8497597dec4fe66ccc59fb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit089b710aef8497597dec4fe66ccc59fb::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
