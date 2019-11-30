<?php

use Inteve\Navigation\Navigation;
use Inteve\Navigation\NavigationItem;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


function createNavigation()
{
	$navigation = new Navigation;
	$homepage = NavigationItem::create('Homepage', '/');
	$navigation->addPage('/', $homepage);
	$navigation->addPage('about', 'About', '/about/');
	$navigation->addPage('contact', 'Contact', '/contact/');
	$navigation->addPage('news', 'News', '/news/');
	$navigation->addPage('news/2016', 'News 2016', '/news/2016/');
	$navigation->addPage('news/2016/1', 'News 2016 - page 1', '/news/2016/', ['page' => 1]);
	$navigation->addPage('news/2016/2', 'News 2016 - page 2', '/news/2016/', ['page' => 2]);
	$navigation->addPage('news/2015', 'News 2015', '/news/2015/');
	$navigation->addPage('news/2014', 'News 2014', '/news/2014/');

	$navigation->addItem('Detail', 'detail', ['show' => TRUE]);

	$navigation->addItemBefore('news/2016', 'By year', 'news-by-year', ['year' => 2016]);
	$navigation->addItemBefore('news/2016', 'Listing');
	$navigation->addItemAfter('news/2016', 'This year', 'this-year');
	$navigation->addItemAfter('news/2016', 'Edit');

	return $navigation;
}


test(function () {

	$navigation = createNavigation();

	Assert::same([
		[
			'label' => 'Detail',
			'destination' => 'detail',
			'parameters' => ['show' => TRUE],
		],
	], extractItems($navigation->getBreadcrumbs()));

});


test(function () {

	$navigation = createNavigation();
	$navigation->setDefaultPage('/');

	Assert::same([
		[
			'label' => 'Homepage',
			'destination' => '/',
			'parameters' => [],
		],
		[
			'label' => 'Detail',
			'destination' => 'detail',
			'parameters' => ['show' => TRUE],
		],
	], extractItems($navigation->getBreadcrumbs()));

});


test(function () {

	$navigation = createNavigation();
	$navigation->setCurrentPage('news/2016/1');

	Assert::same([
		[
			'label' => 'Homepage',
			'destination' => '/',
			'parameters' => [],
		],
		[
			'label' => 'News',
			'destination' => '/news/',
			'parameters' => [],
		],
		[
			'label' => 'By year',
			'destination' => 'news-by-year',
			'parameters' => ['year' => 2016],
		],
		[
			'label' => 'Listing',
			'destination' => NULL,
			'parameters' => [],
		],
		[
			'label' => 'News 2016',
			'destination' => '/news/2016/',
			'parameters' => [],
		],
		[
			'label' => 'This year',
			'destination' => 'this-year',
			'parameters' => [],
		],
		[
			'label' => 'Edit',
			'destination' => NULL,
			'parameters' => [],
		],
		[
			'label' => 'News 2016 - page 1',
			'destination' => '/news/2016/',
			'parameters' => ['page' => 1],
		],
		[
			'label' => 'Detail',
			'destination' => 'detail',
			'parameters' => ['show' => TRUE],
		],
	], extractItems($navigation->getBreadcrumbs()));

});
