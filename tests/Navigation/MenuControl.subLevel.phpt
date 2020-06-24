<?php

use Inteve\Navigation\MenuControl;
use Inteve\Navigation\Navigation;
use Inteve\Navigation\NavigationItem;
use Inteve\Navigation\UrlLink;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


function createNavigation()
{
	$navigation = new Navigation;
	$navigation->addPage('/', 'Homepage');
	$navigation->addPage('news', 'News');
	$navigation->addPage('news/2014', 'News 2014');
	$navigation->addPage('news/2015', 'News 2015');
	$navigation->addPage('news/2016', 'News 2016');
	$navigation->addPage('news/2016/1', 'News 2016 - page 1');
	$navigation->addPage('news/2017', 'News 2017');
	$navigation->addPage('contact', 'Contact');

	return $navigation;
}


test(function () {

	$navigation = createNavigation();

	$presenter = new MockPresenter;
	$presenter['menu'] = new MenuControl($navigation);
	$presenter['menu']->setSubLevel(1);

	Assert::same('', renderControl($presenter['menu']));

});


test(function () {

	$navigation = createNavigation();
	$navigation->setCurrentPage('news');

	$presenter = new MockPresenter;
	$presenter['menu'] = new MenuControl($navigation);
	$presenter['menu']->setSubLevel(1);

	Assert::same(implode("\n", [
		'',
		'<div class="menu">',
		'	<div class="menu__inner">',
		'		<span class="menu__item">News 2014</span>',
		'		<span class="menu__item">News 2015</span>',
		'		<span class="menu__item">News 2016</span>',
		'		<span class="menu__item">News 2017</span>',
		'	</div>',
		'</div>',
		'',
	]), renderControl($presenter['menu']));

});


test(function () {

	$navigation = createNavigation();
	$navigation->setCurrentPage('news/2016/1');

	$presenter = new MockPresenter;
	$presenter['menu'] = new MenuControl($navigation);
	$presenter['menu']->setSubLevel(1);

	Assert::same(implode("\n", [
		'',
		'<div class="menu">',
		'	<div class="menu__inner">',
		'		<span class="menu__item">News 2014</span>',
		'		<span class="menu__item">News 2015</span>',
		'		<span class="menu__item menu__item--active">News 2016</span>',
		'		<span class="menu__item">News 2017</span>',
		'	</div>',
		'</div>',
		'',
	]), renderControl($presenter['menu']));

});


test(function () {

	$navigation = createNavigation();
	$navigation->setCurrentPage('contact');

	$presenter = new MockPresenter;
	$presenter['menu'] = new MenuControl($navigation);
	$presenter['menu']->setSubLevel(1);

	Assert::same(implode("\n", [
		'',
		'',
	]), renderControl($presenter['menu']));

});
