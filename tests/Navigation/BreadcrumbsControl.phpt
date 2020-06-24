<?php

use Inteve\Navigation\BreadcrumbsControl;
use Inteve\Navigation\Navigation;
use Inteve\Navigation\NavigationItem;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


function createNavigation()
{
	$navigation = new Navigation;
	$navigation->addPage('/', 'Homepage', 'Homepage:default');
	$navigation->addPage('news', 'News');
	$navigation->addPage('news/2016', 'News 2016', '/news/2016/');
	$navigation->addPage('news/2016/1', 'News 2016 - page 1', '/news/2016/', ['page' => 1]);

	return $navigation;
}


test(function () {

	$navigation = createNavigation();
	$navigation->setCurrentPage('news/2016/1');

	$presenter = new MockPresenter;
	$presenter['breadcrumbs'] = new BreadcrumbsControl($navigation);

	Assert::same(implode("\n", [
		'<div class="breadcrumbs">',
		'	<div class="breadcrumbs__inner">',
		'		<span class="breadcrumbs__separator">/</span>',
		'',
		'			<a href="#presenter=:Homepage:default?" class="breadcrumbs__item">Homepage</a>',
		'',
		'		<span class="breadcrumbs__separator">/</span>',
		'',
		'			<span class="breadcrumbs__item">News</span>',
		'',
		'		<span class="breadcrumbs__separator">/</span>',
		'',
		'			<a href="/news/2016/" class="breadcrumbs__item">News 2016</a>',
		'',
		'		<span class="breadcrumbs__separator">/</span>',
		'',
		'			<span class="breadcrumbs__item breadcrumbs__item--active">News 2016 - page 1</span>',
		'	</div>',
		'</div>',
		'',
	]), renderControl($presenter['breadcrumbs']));

});
