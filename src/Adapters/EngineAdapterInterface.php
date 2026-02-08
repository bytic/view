<?php

declare(strict_types=1);

namespace Nip\View\Adapters;

/**
 * Interface for template engine adapters.
 * 
 * This interface abstracts the underlying template engine (Plates, Twig, etc.)
 * to allow for backward-compatible engine switching.
 */
interface EngineAdapterInterface
{
    /**
     * Render a template with data.
     *
     * @param string $name Template name
     * @param array $data Template data
     * @return string Rendered output
     */
    public function render(string $name, array $data = []): string;

    /**
     * Check if a template exists.
     *
     * @param string $name Template name
     * @return bool
     */
    public function exists(string $name): bool;

    /**
     * Add a folder/namespace for templates.
     *
     * @param string $name Namespace name
     * @param string $directory Directory path
     * @param bool $fallback Whether to use as fallback
     * @return void
     */
    public function addFolder(string $name, string $directory, bool $fallback = false): void;

    /**
     * Add a path for templates.
     *
     * @param string $directory Directory path
     * @param string|null $namespace Optional namespace
     * @return void
     */
    public function addPath(string $directory, ?string $namespace = null): void;

    /**
     * Get file extension for templates.
     *
     * @return string
     */
    public function getFileExtension(): string;

    /**
     * Set file extension for templates.
     *
     * @param string $extension File extension
     * @return void
     */
    public function setFileExtension(string $extension): void;

    /**
     * Register a function that can be called from templates.
     *
     * @param string $name Function name
     * @param callable $callback Function callback
     * @return void
     */
    public function registerFunction(string $name, callable $callback): void;

    /**
     * Get the underlying engine instance.
     *
     * @return mixed
     */
    public function getEngine();
}
