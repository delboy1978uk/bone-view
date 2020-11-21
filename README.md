# bone-view
[![Latest Stable Version](https://poser.pugx.org/delboy1978uk/bone-view/v/stable)](https://packagist.org/packages/delboy1978uk/bone-view) [![Total Downloads](https://poser.pugx.org/delboy1978uk/bone/downloads)](https://packagist.org/packages/delboy1978uk/bone) [![Latest Unstable Version](https://poser.pugx.org/delboy1978uk/bone-view/v/unstable)](https://packagist.org/packages/delboy1978uk/bone-view) [![License](https://poser.pugx.org/delboy1978uk/bone-view/license)](https://packagist.org/packages/delboy1978uk/bone-view)<br />
[![Build Status](https://travis-ci.org/delboy1978uk/bone-view.png?branch=master)](https://travis-ci.org/delboy1978uk/bone-view) [![Code Coverage](https://scrutinizer-ci.com/g/delboy1978uk/bone-view/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/delboy1978uk/bone-view/?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/delboy1978uk/bone-view/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/delboy1978uk/bone-view/?branch=master)<br />

View package for Bone Mvc Framework
## installation
Bone View is a core dependency of Bone Framework, you install Bone via the skeleton project `delboy1978uk/bonemvc`
## usage
bone-view uses `league/plates` as its view engine, see the docs for that. To get an instance of the view engine from
the dependency injection container, call `$container->get(ViewEngine::class)`. You can also simply extend `Bone\Controller\Controller`
and pass through `Init::controller($controller)` to get a ViewEngine injected in your class instance.
## layouts
Your app by default has layouts in `src/App/View/layouts`. You can switch layouts in your controller by adding a 
`layout` header to your response like so:
```php
return $response->withHeader('layout', 'layouts::your-template');
```
## view extensions
### alert box
From a view file, you can call 
```php
$this->alertBox($messages);
```
 where messages is an array of variable length, but the last 
is the bootstrap `alert-*` class, so a value like `info`, `danger`, `warning`, `success`, etc.
## view helpers
### alert box
The view extension just calls this class `Bone\View\Helper\AlertBox`, but you can instantiate it and call it yourself.
```php
$alert = new \Bone\View\Helper\AlertBox();
echo $alert->alertBox(['Great success!', 'success']);
```
### Paginator
This should be moved into its own package (imho), however this will render bootstrap compatible paginator nav HTML.
```php
<?php

$viewHelper = new \Bone\View\Helper\Paginator();
$viewHelper->setCurrentPage(3); // this number will come from the url
$viewHelper->setUrl('/some/page/:number'); // this is the url you are generating
$viewHelper->setUrlPart(':number'); // this is the part of the url you will replace with the page number
$viewHelper->setPageCount(10); // this is the total number of pages
$viewHelper->setPageCountByTotalRecords(50, 10); // Or pass in a row count and num per page to set page count
$viewHelper->setPagerSize(5);  // this is the number of pages directly clickable in the generated pager
$pagination = $viewHelper->render();
``` 
