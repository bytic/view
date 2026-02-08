<?php

declare(strict_types=1);

namespace Nip\View\Adapters;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

/**
 * Adapter for Symfony Twig template engine.
 * 
 * This adapter wraps the Twig Environment to implement the common
 * EngineAdapterInterface, enabling backward compatibility while providing
 * Twig functionality.
 */
class TwigAdapter implements EngineAdapterInterface
{
    /**
     * @var Environment
     */
    protected $twig;

    /**
     * @var FilesystemLoader
     */
    protected $loader;

    /**
     * @var string
     */
    protected $fileExtension = 'twig';

    /**
     * TwigAdapter constructor.
     *
     * @param Environment|null $twig Twig environment instance
     * @param FilesystemLoader|null $loader Filesystem loader
     */
    public function __construct(?Environment $twig = null, ?FilesystemLoader $loader = null)
    {
        $this->loader = $loader ?? new FilesystemLoader();
        $this->twig = $twig ?? new Environment($this->loader, [
            'autoescape' => 'html',
            'strict_variables' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function render(string $name, array $data = []): string
    {
        // Ensure the template name has the correct extension
        $extension = '.' . $this->fileExtension;
        if (substr($name, -strlen($extension)) !== $extension) {
            $name .= $extension;
        }
        
        return $this->twig->render($name, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function exists(string $name): bool
    {
        // Ensure the template name has the correct extension
        $extension = '.' . $this->fileExtension;
        if (substr($name, -strlen($extension)) !== $extension) {
            $name .= $extension;
        }
        
        return $this->loader->exists($name);
    }

    /**
     * {@inheritdoc}
     */
    public function addFolder(string $name, string $directory, bool $fallback = false): void
    {
        // In Twig, folders are namespaces
        $this->loader->addPath($directory, $name);
    }

    /**
     * {@inheritdoc}
     */
    public function addPath(string $directory, ?string $namespace = null): void
    {
        if ($namespace !== null) {
            $this->loader->addPath($directory, $namespace);
        } else {
            $this->loader->addPath($directory);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFileExtension(): string
    {
        return $this->fileExtension;
    }

    /**
     * {@inheritdoc}
     */
    public function setFileExtension(string $extension): void
    {
        $this->fileExtension = $extension;
    }

    /**
     * {@inheritdoc}
     */
    public function registerFunction(string $name, callable $callback): void
    {
        $function = new TwigFunction($name, $callback);
        $this->twig->addFunction($function);
    }

    /**
     * {@inheritdoc}
     */
    public function getEngine()
    {
        return $this->twig;
    }

    /**
     * Get the Twig loader.
     *
     * @return FilesystemLoader
     */
    public function getLoader(): FilesystemLoader
    {
        return $this->loader;
    }
}
