# Inteve\Navigation

[![Build Status](https://github.com/inteve/navigation/workflows/Build/badge.svg)](https://github.com/inteve/navigation/actions)
[![Downloads this Month](https://img.shields.io/packagist/dm/inteve/navigation.svg)](https://packagist.org/packages/inteve/navigation)
[![Latest Stable Version](https://poser.pugx.org/inteve/navigation/v/stable)](https://github.com/inteve/navigation/releases)
[![License](https://img.shields.io/badge/license-New%20BSD-blue.svg)](https://github.com/inteve/navigation/blob/master/license.md)

Navigation component for Nette Framework.

<a href="https://www.janpecha.cz/donate/"><img src="https://buymecoffee.intm.org/img/donate-banner.v1.svg" alt="Donate" height="100"></a>


## Installation

[Download a latest package](https://github.com/inteve/navigation/releases) or use [Composer](http://getcomposer.org/):

```
composer require inteve/navigation
```

`Inteve\Navigation` requires PHP 8.0 or later and Nette 2.2+ or 3.0+.


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

class NewsPresenter extends Nette\Application\UI\Presenter
{
	/** @var Navigation @inject */
	public $navigation;


	protected function createComponentNewsMenu()
	{
		// render items 'News 2016' & 'News 2015'
		$menu = new MenuControl($this->navigation);
		$menu->setSubTree('news');
		return $menu;
	}


	protected function createComponentSubMenu()
	{
		// Renders submenu by current page
		// for setCurrentPage('news') or setCurrentPage('news/any/thing') it renders items 'news/2016' & 'news/2015'
		// for setCurrentPage('contact') it renders nothing
		$menu = new MenuControl($this->navigation);
		$menu->setSubTree('/');
		$menu->setSubLevel(1);
		return $menu;
	}
}
```

In Latte template:

```latte
{control newsMenu}
```


### Render breadcrumbs

``` php
<?php

use Inteve\Navigation\Navigation;
use Inteve\Navigation\BreadcrumbsControl;

class Presenter extends Nette\Application\UI\Presenter
{
	/** @var Navigation @inject */
	public $navigation;


	protected function createComponentBreadcrumbs()
	{
		return new BreadcrumbsControl($this->navigation);
	}
}
```

In Latte template:

```latte
{control breadcrumbs}
```

------------------------------

License: [New BSD License](license.md)
<br>Author: Jan Pecha, https://www.janpecha.cz/
