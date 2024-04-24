<?php

declare(strict_types=1);

namespace App\Tests\Utils;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Finder\Finder;

trait FixtureAwareCaseTrait
{
    public static function loadFixturesWithContainer(ContainerInterface $container, string $fixtureFolder = 'common'): void
    {
        $loader = $container->get('fidry_alice_data_fixtures.loader.doctrine');
        if (method_exists($loader, 'load')) {
            $finder = new Finder();
            $files = array_keys(iterator_to_array($finder->files()->in("tests/fixtures/$fixtureFolder")));
            $loader->load($files);
        }
    }

}