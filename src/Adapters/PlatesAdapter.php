<?php

declare(strict_types=1);

namespace Nip\View\Adapters;

use League\Plates\Engine;

/**
 * Adapter for League Plates template engine.
 * 
 * This adapter wraps the League Plates Engine to implement the common
 * EngineAdapterInterface, enabling backward compatibility while preparing
 * for potential engine switching.
 */
class PlatesAdapter implements EngineAdapterInterface
{
    /**
     * @var Engine
     */
    protected $engine;

    /**
     * PlatesAdapter constructor.
     *
     * @param Engine $engine Plates engine instance
     */
    public function __construct(Engine $engine)
    {
        $this->engine = $engine;
    }

    /**
     * {@inheritdoc}
     */
    public function render(string $name, array $data = []): string
    {
        return $this->engine->render($name, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function exists(string $name): bool
    {
        return $this->engine->exists($name);
    }

    /**
     * {@inheritdoc}
     */
    public function addFolder(string $name, string $directory, bool $fallback = false): void
    {
        $this->engine->addFolder($name, $directory, $fallback);
    }

    /**
     * {@inheritdoc}
     */
    public function addPath(string $directory, ?string $namespace = null): void
    {
        if ($namespace !== null) {
            $this->engine->addFolder($namespace, $directory);
        } else {
            $this->engine->setDirectory($directory);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFileExtension(): string
    {
        return $this->engine->getFileExtension();
    }

    /**
     * {@inheritdoc}
     */
    public function setFileExtension(string $extension): void
    {
        $this->engine->setFileExtension($extension);
    }

    /**
     * {@inheritdoc}
     */
    public function registerFunction(string $name, callable $callback): void
    {
        $this->engine->registerFunction($name, $callback);
    }

    /**
     * {@inheritdoc}
     */
    public function getEngine()
    {
        return $this->engine;
    }
}
