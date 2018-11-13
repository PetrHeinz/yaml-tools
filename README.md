# YAML Tools

[![Build Status](https://travis-ci.org/PetrHeinz/yaml-tools.svg?branch=master)](https://travis-ci.org/PetrHeinz/yaml-tools)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg)](https://github.com/phpstan/phpstan)
[![Latest Stable Version](https://poser.pugx.org/petr-heinz/yaml-tools/v/stable)](https://packagist.org/packages/petr-heinz/yaml-tools)
[![License](https://poser.pugx.org/petr-heinz/yaml-tools/license)](https://packagist.org/packages/petr-heinz/yaml-tools)

Tool that will one day help developers with maintaining their YAML configs.

First, it will get your configs alphabetically sorted automatically.
To see why you would want to do that, you can read about [YAML file sort checker](https://github.com/mhujer/yaml-sort-checker) on [Martin Hujer's blog](https://blog.martinhujer.cz/yaml-sort-checker/).

## Installation
```
composer require --dev petr-heinz/yaml-tools:@dev
```

## Usage
```
vendor/bin/yaml-tools fix <path>
```
