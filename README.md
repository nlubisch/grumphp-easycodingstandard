# GrumPHP EasyCodingStandard Task

This package extends [GrumPHP](https://github.com/phpro/grumphp) with a task that runs [EasyCodingStandard](https://github.com/Symplify/EasyCodingStandard).

## Installation

The easiest way to install this package is through composer:
	
	composer require nlubisch/grumphp-easycodingstandard --dev

Add the extension loader to your `grumphp.yml`

```yaml
parameters:
    extensions:
        - NLubisch\GrumPHP\Extension
```

## Usage

```yaml
parameters:
    tasks:
        ecs:
            whitelist_patterns:
                - src
                - tests
            fix: true
```

**config**
*Default: `null`*

If the EasyCodingStandard config is in a different path you can specify it.

**whitelist_patterns**
*Default: `[]`*

This parameters is an array of directories/files to run EasyCodingStandard on.

**fix**
*Default: `false`*

If EasyCodingStandard finds any error `fix` defines if they should be fixed.
