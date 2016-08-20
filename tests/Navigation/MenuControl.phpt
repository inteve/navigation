<?php

use Inteve\Navigation\MenuControl;
use Inteve\Navigation\Navigation;
use Inteve\Navigation\NavigationItem;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


function createNavigation()
{
	$navigation = new Navigation;
	$navigation->addPage('/', 'Homepage', '/');
	$navigation->addPage('news', 'News');
	$navigation->addPage('news/2014', 'News 2014');
	$navigation->addPage('news/2015', 'News 2015', '/news/', array('year' => 2015));
	$navigation->addPage('news/2016', 'News 2016', '/news/', array('year' => 2016));
	$navigation->addPage('news/2016/1', 'News 2016 - page 1', '/news/', array('year' => 2016, 'page' => 1));

	return $navigation;
}


test(function () {

	$navigation = createNavigation();

	$presenter = new MockPresenter;
	$presenter['menu'] = new MenuControl($navigation);
	$presenter['menu']->setParentPage('news');

	Assert::same(implode("\n", array(
		'',
		'<div class="menu">',
		'	<div class="menu__inner">',
		'		<span class="menu__item">News 2014</span>',
		'		<a href="presenter:/news/?year=2015" class="menu__item">News 2015</a>',
		'		<a href="presenter:/news/?year=2016" class="menu__item">News 2016</a>',
		'	</div>',
		'</div>',
		'',
	)), renderControl($presenter['menu']));

});
