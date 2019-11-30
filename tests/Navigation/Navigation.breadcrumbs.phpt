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
	$navigation->addPage('news/2016/1', 'News 2016 - page 1', '/news/2016/', array('page' => 1));
	$navigation->addPage('news/2016/2', 'News 2016 - page 2', '/news/2016/', array('page' => 2));
	$navigation->addPage('news/2015', 'News 2015', '/news/2015/');
	$navigation->addPage('news/2014', 'News 2014', '/news/2014/');

	$navigation->addItem('Detail', 'detail', array('show' => TRUE));

	$navigation->addItemBefore('news/2016', 'By year', 'news-by-year', array('year' => 2016));
	$navigation->addItemBefore('news/2016', 'Listing');
	$navigation->addItemAfter('news/2016', 'This year', 'this-year');
	$navigation->addItemAfter('news/2016', 'Edit');

	return $navigation;
}


test(function () {

	$navigation = createNavigation();

	Assert::same(array(
		array(
			'label' => 'Detail',
			'destination' => 'detail',
			'parameters' => array('show' => TRUE),
		),
	), extractItems($navigation->getBreadcrumbs()));

});


test(function () {

	$navigation = createNavigation();
	$navigation->setDefaultPage('/');

	Assert::same(array(
		array(
			'label' => 'Homepage',
			'destination' => '/',
			'parameters' => array(),
		),
		array(
			'label' => 'Detail',
			'destination' => 'detail',
			'parameters' => array('show' => TRUE),
		),
	), extractItems($navigation->getBreadcrumbs()));

});


test(function () {

	$navigation = createNavigation();
	$navigation->setCurrentPage('news/2016/1');

	Assert::same(array(
		array(
			'label' => 'Homepage',
			'destination' => '/',
			'parameters' => array(),
		),
		array(
			'label' => 'News',
			'destination' => '/news/',
			'parameters' => array(),
		),
		array(
			'label' => 'By year',
			'destination' => 'news-by-year',
			'parameters' => array('year' => 2016),
		),
		array(
			'label' => 'Listing',
			'destination' => NULL,
			'parameters' => array(),
		),
		array(
			'label' => 'News 2016',
			'destination' => '/news/2016/',
			'parameters' => array(),
		),
		array(
			'label' => 'This year',
			'destination' => 'this-year',
			'parameters' => array(),
		),
		array(
			'label' => 'Edit',
			'destination' => NULL,
			'parameters' => array(),
		),
		array(
			'label' => 'News 2016 - page 1',
			'destination' => '/news/2016/',
			'parameters' => array('page' => 1),
		),
		array(
			'label' => 'Detail',
			'destination' => 'detail',
			'parameters' => array('show' => TRUE),
		),
	), extractItems($navigation->getBreadcrumbs()));

});

