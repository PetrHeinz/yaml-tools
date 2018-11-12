# YAML Tools

[![Build Status](https://travis-ci.org/PetrHeinz/yaml-tools.svg?branch=master)](https://travis-ci.org/PetrHeinz/yaml-tools)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat)](https://github.com/phpstan/phpstan)

Tool that will one day help developers with maintaining their YAML configs.

First, it will get your configs alphabetically sorted automatically.
To see why you would want to do that, you can read about [YAML file sort checker](https://github.com/mhujer/yaml-sort-checker) on [Martin Hujer's blog](https://blog.martinhujer.cz/yaml-sort-checker/).

## Installation
```
composer require --dev petr-heinz/yaml-tools
```

## Usage
```
vendor/bin/yaml-tools fix <path>
```
