# View
ByTIC View component

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bytic/view.svg?style=flat-square)](https://packagist.org/packages/bytic/view)
[![Latest Stable Version](https://poser.pugx.org/bytic/view/v/stable)](https://packagist.org/packages/bytic/view)
[![Latest Unstable Version](https://poser.pugx.org/bytic/view/v/unstable)](https://packagist.org/packages/bytic/view)

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/bytic/view/master.svg?style=flat-square)](https://travis-ci.org/bytic/framework)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/92329f47-7940-4b14-91e9-45330b887bdd/mini.png)](https://insight.sensiolabs.com/projects/92329f47-7940-4b14-91e9-45330b887bdd)
[![Quality Score](https://img.shields.io/scrutinizer/g/bytic/view.svg?style=flat-square)](https://scrutinizer-ci.com/g/bytic/view)
[![StyleCI](https://styleci.io/repos/118474281/shield?branch=master)](https://styleci.io/repos/118474281)
[![Total Downloads](https://img.shields.io/packagist/dt/bytic/view.svg?style=flat-square)](https://packagist.org/packages/bytic/view)

## Symfony Twig Migration

This package is being prepared for a transition to Symfony Twig. The current version maintains **100% backward compatibility** with existing League Plates templates while introducing an adapter layer for future Twig support.

For detailed migration information, see [TWIG_MIGRATION.md](TWIG_MIGRATION.md).

### What's New

- **Engine Adapter Layer**: Abstraction layer supporting both Plates and Twig
- **Enhanced ViewFactory**: Configure default engine and create views with specific engines
- **Backward Compatible**: All existing code continues to work without changes

### Quick Start

Existing code works without any changes:

```php
$view = new \Nip\View\View('/path/to/templates');
$view->set('title', 'My Page');
$content = $view->render('template/name');
```

New optional features for preparing Twig migration:

```php
use Nip\View\ViewFactory;

$factory = new ViewFactory();

// Create with default engine (Plates - backward compatible)
$view = $factory->createWithPlates('/path/to/templates');

// Or prepare for Twig (for new projects)
$view = $factory->createWithTwig('/path/to/twig_templates');
```
