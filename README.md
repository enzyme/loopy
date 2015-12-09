<img src="https://cloud.githubusercontent.com/assets/2805249/11684981/4d6de34c-9ec1-11e5-97a1-2aee3eb0ab3b.png" width="130">

[![Build Status](https://travis-ci.org/enzyme/loopy.svg)](https://travis-ci.org/enzyme/loopy)
[![Coverage Status](https://coveralls.io/repos/enzyme/loopy/badge.svg?branch=master&service=github)](https://coveralls.io/github/enzyme/loopy?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/enzyme/loopy/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/enzyme/loopy/?branch=master)

A loop library for PHP.

# Installation

Run the following command inside of your project directory.

```bash
composer require enzyme/loopy
```

# Usage

#### Simple

A simple loop over an array.

```php
use Enzyme\Loopy\Each;

$array = [1, 2, 3];

Each::shallow()->begin($array, function($bag) {
    echo $bag->value() . ', ';
});
```

The above will output `1, 2, 3, `

#### Deep

A deep loop over a multidimensional array.

```php
use Enzyme\Loopy\Each;

$array = [1, 2, 3, 4 => [4, 5, 6]];

Each::deep()->begin($array, function($bag) {
    echo $bag->value() . ', ';
});
```

The above will output `1, 2, 3, 4, 5, 6, `

#### Filtered

A loop over a filtered array.

```php
use Enzyme\Loopy\Each;
use Enzyme\Loopy\Filters\SkipNulls;

$array = [1, 2, null, 4, 5];

Each::deep(new SkipNulls)->begin($array, function($bag) {
    echo $bag->value() . ', ';
});
```

The above will output `1, 2, 4, 5, `

# Bags

The `$bag` object passed to the callback function generally contains the follow information.

Key | Value
----|------
key() | The key
value() | The value
cycle() | The current cycle (0 based)
depth() | The current depth (0 based)
index() | The current index (0 based)