<?php

use Inteve\Navigation\Navigation;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


function createNavigation()
{
	$navigation = new Navigation;
	$navigation->addPage('/', 'Homepage', '/');
	$navigation->addPage('about', 'About', '/about/');
	$navigation->addPage('contact', 'Contact', '/contact/');
	$navigation->addPage('news', 'News', '/news/');

	return $navigation;
}


test(function () {

	Assert::exception(function () {

		$navigation = createNavigation();
		$navigation->addPage('/about/', 'DUPLICATE ENTRY');

	}, 'Inteve\Navigation\DuplicateException', "Page 'about' already exists.");

});


test(function () {

	Assert::exception(function () {

		$navigation = createNavigation();
		$navigation->getPage('/non-exists/');

	}, 'Inteve\Navigation\MissingException', "Page 'non-exists' not found.");

});


test(function () {

	$navigation = createNavigation();
	$page = $navigation->getPage('/about/');

	Assert::same([
		'label' => 'About',
		'destination' => '/about/',
		'parameters' => [],
	], extractItem($page));

});


test(function () {

	$navigation = createNavigation();
	$navigation->setPageLabel('/about/', 'CHANGED NAME');

	Assert::same('CHANGED NAME', $navigation->getPage('about')->getLabel());

});


test(function () {

	$navigation = createNavigation();
	Assert::false($navigation->isPageCurrent('about'));

});


test(function () {

	$navigation = createNavigation();
	$navigation->setDefaultPage('about');
	Assert::true($navigation->isPageCurrent('about'));

});


test(function () {

	$navigation = createNavigation();
	$navigation->setCurrentPage('about');
	Assert::true($navigation->isPageCurrent('about'));

});


test(function () {

	$navigation = createNavigation();
	Assert::true($navigation->hasChildren('/'));
	Assert::false($navigation->hasChildren('about'));

});


test(function () {

	$navigation = createNavigation();
	Assert::true($navigation->hasPage('/'));
	Assert::true($navigation->hasPage('news'));
	Assert::false($navigation->hasPage('non-exists'));

});
