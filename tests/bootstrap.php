<?php

require __DIR__ . '/../vendor/autoload.php';

Tester\Environment::setup();


function test($cb)
{
	$cb();
}


function extractItems(array $items)
{
	$data = [];

	foreach ($items as $item) {
		$data[] = extractItem($item);
	}

	return $data;
}


function extractItem(\Inteve\Navigation\NavigationItem $item)
{
	$link = $item->getLink();
	return [
		'label' => $item->getLabel(),
		'destination' => $link !== NULL ? $link->getDestination() : NULL,
		'parameters' => $link !== NULL ? $link->getParameters() : [],
	];
}


function renderControl(\Nette\Application\UI\Control $control)
{
	ob_start();
	$control->render();
	return ob_get_clean();
}


call_user_func(function () {
	$reflection = new ReflectionClass(\Nette\Bridges\ApplicationLatte\ILatteFactory::class);
	$methodReflection = $reflection->getMethod('create');

	if (method_exists($methodReflection, 'hasReturnType') && $methodReflection->hasReturnType()) {
		require __DIR__ . '/Nette3xMocks.php';

	} else {
		require __DIR__ . '/Nette2xMocks.php';
	}
});
