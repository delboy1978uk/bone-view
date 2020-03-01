# view
View package for Bone Mvc Framework
## installation
Use Composer
```
composer require delboy1978uk/bone-view
```
## usage
Simply add to the `config/packages.php`
```php
<?php

// use statements here
use Bone\View\ViewPackage;

return [
    'packages' => [
        // packages here...,
        ViewPackage::class,
    ],
    // ...
];
```