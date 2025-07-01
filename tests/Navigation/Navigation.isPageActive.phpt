<?php

declare(strict_types=1);

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
	$navigation->addPage('news/2015', 'News 2015', '/news/2015/');
	$navigation->addPage('news/2016', 'News 2016', '/news/2016/');
	$navigation->addPage('news/2016/01', 'News 2016/01', '/news/2016/01/');
	$navigation->addPage('news/2016/01/25', 'News 2016/01/25', '/news/2016/01/25/');
	$navigation->addPage('news/2016/01/27', 'News 2016/01/27', '/news/2016/01/27/');
	$navigation->addPage('news/2016/02', 'News 2016/02', '/news/2016/02/');

	return $navigation;
}


test(function () {

	$navigation = createNavigation();
	Assert::false($navigation->isPageActive('news/2015/01'));
	Assert::false($navigation->isPageActive('/'));

});


test(function () {

	$navigation = createNavigation();
	$navigation->setCurrentPage('news/2015/01');

	Assert::true($navigation->isPageActive('news/2015/01'));
	Assert::true($navigation->isPageActive('news/2015'));
	Assert::true($navigation->isPageActive('news'));
	Assert::true($navigation->isPageActive('/'));

	Assert::false($navigation->isPageActive('news/2015/01/25'));
	Assert::false($navigation->isPageActive('news/2015/01/27'));

	Assert::false($navigation->isPageActive('about'));
	Assert::false($navigation->isPageActive('contact'));

});
