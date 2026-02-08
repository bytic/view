<?php

declare(strict_types=1);

namespace Nip\View\Adapters;

use League\Plates\Engine as PlatesEngine;
use Twig\Environment as TwigEnvironment;
use Twig\Loader\FilesystemLoader;

/**
 * Factory for creating engine adapters.
 * 
 * This factory creates the appropriate adapter based on configuration
 * or detection of available dependencies.
 */
class AdapterFactory
{
    /**
     * Create an engine adapter.
     *
     * @param string|null $type Adapter type ('plates' or 'twig'), null for auto-detect
     * @param mixed|null $engine Existing engine instance to wrap
     * @param array $options Configuration options
     * @return EngineAdapterInterface
     */
    public static function create(?string $type = null, $engine = null, array $options = []): EngineAdapterInterface
    {
        // Auto-detect type if not specified
        if ($type === null) {
            $type = self::detectType($engine);
        }

        switch (strtolower($type)) {
            case 'twig':
                return self::createTwigAdapter($engine, $options);
            case 'plates':
            default:
                return self::createPlatesAdapter($engine, $options);
        }
    }

    /**
     * Create a Plates adapter.
     *
     * @param mixed|null $engine Existing Plates engine or null to create new
     * @param array $options Configuration options
     * @return PlatesAdapter
     */
    public static function createPlatesAdapter($engine = null, array $options = []): PlatesAdapter
    {
        if ($engine instanceof PlatesEngine) {
            return new PlatesAdapter($engine);
        }

        $directory = $options['directory'] ?? null;
        $fileExtension = $options['fileExtension'] ?? 'php';
        
        $platesEngine = new PlatesEngine($directory, $fileExtension);
        
        return new PlatesAdapter($platesEngine);
    }

    /**
     * Create a Twig adapter.
     *
     * @param mixed|null $engine Existing Twig environment or null to create new
     * @param array $options Configuration options
     * @return TwigAdapter
     */
    public static function createTwigAdapter($engine = null, array $options = []): TwigAdapter
    {
        if ($engine instanceof TwigEnvironment) {
            // Extract the loader if possible
            $loader = $engine->getLoader();
            if ($loader instanceof FilesystemLoader) {
                return new TwigAdapter($engine, $loader);
            }
            return new TwigAdapter($engine);
        }

        $loader = new FilesystemLoader();
        if (isset($options['directory'])) {
            $loader->addPath($options['directory']);
        }

        $twigOptions = $options['twig'] ?? [];
        $twigOptions = array_merge([
            'autoescape' => 'html',
            'strict_variables' => false,
        ], $twigOptions);

        $twig = new TwigEnvironment($loader, $twigOptions);
        
        return new TwigAdapter($twig, $loader);
    }

    /**
     * Detect adapter type from engine instance.
     *
     * @param mixed $engine Engine instance
     * @return string 'plates' or 'twig'
     */
    protected static function detectType($engine): string
    {
        if ($engine instanceof TwigEnvironment) {
            return 'twig';
        }
        
        if ($engine instanceof PlatesEngine) {
            return 'plates';
        }

        // Default to plates for backward compatibility
        return 'plates';
    }
}
