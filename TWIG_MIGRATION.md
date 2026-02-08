# Twig Migration Guide

## Overview

This package is being prepared for a transition from League Plates to Symfony Twig template engine. The current implementation maintains **100% backward compatibility** while laying the groundwork for future Twig support.

## Current State (Preparation Phase)

### What's New

1. **Engine Adapter Layer**: A new abstraction layer has been introduced:
   - `EngineAdapterInterface`: Common interface for template engines
   - `PlatesAdapter`: Wraps the existing League Plates engine
   - `TwigAdapter`: New adapter for Symfony Twig engine
   - `AdapterFactory`: Factory for creating engine adapters

2. **Enhanced ViewFactory**: The `ViewFactory` class now supports:
   - Configuration of default engine type
   - Engine-specific options
   - Explicit methods for creating views with specific engines

### Backward Compatibility

**All existing code continues to work without any changes.** The `View` class still extends `League\Plates\Engine` and behaves exactly as before. The new adapter layer is created alongside existing functionality but doesn't interfere with it.

## Usage Examples

### Standard Usage (No Changes Required)

```php
// This continues to work exactly as before
$view = new \Nip\View\View('/path/to/templates');
$view->set('title', 'My Page');
$content = $view->render('template/name');
```

### Using ViewFactory (Preparation for Future)

```php
// Create with default engine (Plates)
$factory = new \Nip\View\ViewFactory();
$view = $factory->create('/path/to/templates');

// Explicitly create with Plates
$view = $factory->createWithPlates('/path/to/templates');

// Create with Twig (for new projects)
$view = $factory->createWithTwig('/path/to/twig_templates', [
    'cache' => '/path/to/cache',
    'debug' => true,
]);

// Configure default engine for all views
$factory->setDefaultEngine('twig');
$factory->setEngineOptions(['cache' => false]);
$view = $factory->create('/path/to/templates');
```

### Using Adapters Directly

```php
use Nip\View\Adapters\PlatesAdapter;
use Nip\View\Adapters\TwigAdapter;
use Nip\View\Adapters\AdapterFactory;

// Create Plates adapter
$adapter = AdapterFactory::create('plates', null, [
    'directory' => '/path/to/templates',
    'fileExtension' => 'php',
]);

// Create Twig adapter
$adapter = AdapterFactory::create('twig', null, [
    'directory' => '/path/to/templates',
    'twig' => [
        'cache' => '/path/to/cache',
        'debug' => false,
    ],
]);

// Render with adapter
$output = $adapter->render('template/name', ['var' => 'value']);
```

## Migration Path (Future)

The transition to Twig will happen in phases:

### Phase 1: Preparation (Current)
- ✅ Add Twig dependencies
- ✅ Create adapter abstraction layer
- ✅ Enhance ViewFactory
- ✅ Add comprehensive tests
- ✅ Documentation

### Phase 2: Integration (Future)
- Integrate adapters into View class
- Add configuration system for engine selection
- Support mixed Plates/Twig templates in same project
- Migration helpers and tools

### Phase 3: Transition (Future)
- Gradual deprecation of Plates-specific features
- Migration guides and examples
- Performance optimizations

### Phase 4: Completion (Future)
- Twig as default engine
- Plates adapter as optional dependency
- Full Twig feature support

## Dependencies

### Current Dependencies
- `league/plates: ^3.5` (required)
- `twig/twig: ^3.0` (dev only)
- `symfony/twig-bridge: ^6.0|^7.0` (dev only)

### PHP Version
- PHP ^7.0 || ^8.0

## Testing

Run tests to ensure everything works:

```bash
composer test
```

The test suite includes:
- Backward compatibility tests for existing View functionality
- Adapter layer tests (PlatesAdapter, TwigAdapter, AdapterFactory)
- ViewFactory tests

## Questions or Issues?

If you encounter any issues or have questions about the migration:

1. Check existing tests for usage examples
2. Review this migration guide
3. Open an issue on GitHub

## Important Notes

- **No breaking changes**: All existing code works without modification
- **Optional adoption**: New features are opt-in only
- **Performance**: No performance impact on existing code
- **Production ready**: The preparation phase is stable and tested
