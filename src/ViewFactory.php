<?php

declare(strict_types=1);

namespace Nip\View;

use Nip\View\Adapters\AdapterFactory;
use Nip\View\Adapters\EngineAdapterInterface;

/**
 * Class ViewFactory.
 * 
 * Factory for creating View instances with configurable template engines.
 * Supports both Plates (default) and Twig engines while maintaining
 * backward compatibility.
 */
class ViewFactory
{
    /**
     * @var string Default engine type
     */
    protected $defaultEngine = 'plates';

    /**
     * @var array Engine configuration options
     */
    protected $engineOptions = [];

    /**
     * Set the default engine type.
     *
     * @param string $engine Engine type ('plates' or 'twig')
     * @return $this
     */
    public function setDefaultEngine(string $engine)
    {
        $this->defaultEngine = $engine;
        return $this;
    }

    /**
     * Get the default engine type.
     *
     * @return string
     */
    public function getDefaultEngine(): string
    {
        return $this->defaultEngine;
    }

    /**
     * Set engine configuration options.
     *
     * @param array $options Configuration options
     * @return $this
     */
    public function setEngineOptions(array $options)
    {
        $this->engineOptions = $options;
        return $this;
    }

    /**
     * Get engine configuration options.
     *
     * @return array
     */
    public function getEngineOptions(): array
    {
        return $this->engineOptions;
    }

    /**
     * Create a View instance.
     *
     * @param string|null $directory Base directory for templates
     * @param string|null $fileExtension File extension for templates
     * @param string|null $engineType Engine type override ('plates' or 'twig')
     * @return View
     */
    public function create(?string $directory = null, ?string $fileExtension = null, ?string $engineType = null): View
    {
        // Use default engine if not specified
        $engineType = $engineType ?? $this->defaultEngine;

        // Merge options
        $options = $this->engineOptions;
        if ($directory !== null) {
            $options['directory'] = $directory;
        }
        if ($fileExtension !== null) {
            $options['fileExtension'] = $fileExtension;
        }

        // For backward compatibility, always create the standard View instance
        // The adapter is created internally but not used yet - this is the preparation step
        $view = new View($directory, $fileExtension ?? 'php');
        
        // Store the adapter type as metadata for future use
        // This doesn't change behavior but prepares for future transition
        $view->engineAdapter = AdapterFactory::create($engineType, null, $options);

        return $view;
    }

    /**
     * Create a View instance with Twig engine.
     *
     * @param string|null $directory Base directory for templates
     * @param array $twigOptions Twig-specific options
     * @return View
     */
    public function createWithTwig(?string $directory = null, array $twigOptions = []): View
    {
        $options = array_merge($this->engineOptions, [
            'directory' => $directory,
            'twig' => $twigOptions,
        ]);

        return $this->create($directory, 'twig', 'twig');
    }

    /**
     * Create a View instance with Plates engine (default).
     *
     * @param string|null $directory Base directory for templates
     * @param string|null $fileExtension File extension for templates
     * @return View
     */
    public function createWithPlates(?string $directory = null, ?string $fileExtension = null): View
    {
        return $this->create($directory, $fileExtension ?? 'php', 'plates');
    }
}
