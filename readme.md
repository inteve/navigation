
# Inteve\Navigation

Navigation component for Nette Framework.

## Usage

### Define pages

``` php
<?php

use Inteve\Navigation\Navigation;

$navigation = new Navigation;
$navigation->addPage('/', 'Homepage');
$navigation->addPage('contact', 'Contact');
$navigation->addPage('news', 'News');
$navigation->addPage('news/2016', 'News 2016');
$navigation->addPage('news/2015', 'News 2015');

$navigation->setDefaultPage('/');
$navigation->setCurrentPage('news/2016');
$navigation->isPageCurrent('news/2016'); // returns bool
$navigation->isPageActive('news'); // returns bool
```

### Breadcrumbs

``` php
<?php

$navigation->addItem('Detail');
$navigation->addItemBefore('/', 'My Website', ':Homepage:default');
$navigation->addItemAfter('news/2016', 'Page 1', ':News:default', array('page' => 1));
$breadcrumbs = $navigation->getBreadcrumbs();
```


### Render menu

``` php
<?php

use Inteve\Navigation\Navigation;
use Inteve\Navigation\MenuControl;

class NewsPresenter extends Nette\Application\UI\Form
{
	/** @var Navigation @inject */
	private $navigation;


	protected function createComponentNewsMenu()
	{
		// render items 'News 2016' & 'News 2015'
		$menu = new MenuControl($this->navigation);
		$menu->setParentPage('news');
		return $menu;
	}
}
```


### Render breadcrumbs

``` php
<?php

use Inteve\Navigation\Navigation;
use Inteve\Navigation\BreadcrumbsControl;

class Presenter extends Nette\Application\UI\Form
{
	/** @var Navigation @inject */
	private $navigation;


	protected function createComponentBreadcrumbs()
	{
		return new BreadcrumbsControl($this->navigation);
	}
}
```


Installation
------------

[Download a latest package](https://github.com/inteve/navigation/releases) or use [Composer](http://getcomposer.org/):

```
composer require [--dev] inteve/navigation
```

`Inteve\Navigation` requires PHP 5.3.0 or later and Nette 2.2.


------------------------------

License: [New BSD License](license.md)
<br>Author: Jan Pecha, https://www.janpecha.cz/
