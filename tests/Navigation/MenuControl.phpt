<?php

use Inteve\Navigation\MenuControl;
use Inteve\Navigation\Navigation;
use Inteve\Navigation\NavigationItem;
use Inteve\Navigation\Url;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


function createNavigation()
{
	$navigation = new Navigation;
	$navigation->addPage('/', 'Homepage', '/');
	$navigation->addPage('news', 'News');
	$navigation->addPage('news/2014', 'News 2014');
	$navigation->addPage('news/2015', 'News 2015', new Url('/news/'), array('year' => 2015));
	$navigation->addPage('news/2016', 'News 2016', '/news/', array('year' => 2016));
	$navigation->addPage('news/2016/1', 'News 2016 - page 1', '/news/', array('year' => 2016, 'page' => 1));
	$navigation->addPage('news/2017', 'News 2017', 'presenterAction', array('year' => 2017));
	$navigation->addPage('news/2018', 'News 2018', 'News:default', array('year' => 2018));

	return $navigation;
}


test(function () {

	$navigation = createNavigation();

	$presenter = new MockPresenter;
	$presenter['menu'] = new MenuControl($navigation);
	$presenter['menu']->setSubTree('news');

	Assert::same(implode("\n", array(
		'',
		'<div class="menu">',
		'	<div class="menu__inner">',
		'		<span class="menu__item">News 2014</span>',
		'		<a href="/news/?year=2015" class="menu__item">News 2015</a>',
		'		<a href="/news/?year=2016" class="menu__item">News 2016</a>',
		'		<a href="#presenter=presenterAction?year=2017" class="menu__item">News 2017</a>',
		'		<a href="#presenter=:News:default?year=2018" class="menu__item">News 2018</a>',
		'	</div>',
		'</div>',
		'',
	)), renderControl($presenter['menu']));

});


test(function () {

	$navigation = createNavigation();

	$presenter = new MockPresenter;
	$presenter['menu'] = new MenuControl($navigation);

	Assert::same(implode("\n", array(
		'',
		'<div class="menu">',
		'	<div class="menu__inner">',
		'		<a href="/" class="menu__item">Homepage</a>',
		'		<span class="menu__item">News</span>',
		'	</div>',
		'</div>',
		'',
	)), renderControl($presenter['menu']));

});


test(function () {

	$navigation = createNavigation();
	$navigation->setCurrentPage('news/2017');

	$presenter = new MockPresenter;
	$presenter['menu'] = new MenuControl($navigation);

	Assert::same(implode("\n", array(
		'',
		'<div class="menu">',
		'	<div class="menu__inner">',
		'		<a href="/" class="menu__item">Homepage</a>',
		'		<span class="menu__item menu__item--active">News</span>',
		'	</div>',
		'</div>',
		'',
	)), renderControl($presenter['menu']));

});


test(function () {

	$navigation = createNavigation();

	$presenter = new MockPresenter;
	$presenter['menu'] = new MenuControl($navigation);
	$presenter['menu']->setIgnoredPages(array('/', 'news/'));

	Assert::same(implode("\n", array(
		'',
		'',
	)), renderControl($presenter['menu']));

});
