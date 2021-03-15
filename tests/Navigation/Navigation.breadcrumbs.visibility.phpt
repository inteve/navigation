<?php

use Inteve\Navigation\Navigation;
use Inteve\Navigation\NavigationItem;
use Inteve\Navigation\NavigationPage;
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
	$navigation->setPageVisibility('news/2016', NavigationPage::VISIBILITY_HIDDEN);
	$navigation->addPage('news/2016/1', 'News 2016 - page 1');
	$navigation->addPage('news/2016/2', 'News 2016 - page 2');

	$navigation->addItem('Detail', 'detail', ['show' => TRUE]);

	$navigation->addItemBefore('news/2016', 'By year', 'news-by-year');
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
			'parameters' => [],
		],
		[
			'label' => 'Listing',
			'destination' => NULL,
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
			'destination' => NULL,
			'parameters' => [],
		],
		[
			'label' => 'Detail',
			'destination' => 'detail',
			'parameters' => ['show' => TRUE],
		],
	], extractItems($navigation->getBreadcrumbs()));

});
