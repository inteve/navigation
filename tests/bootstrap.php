<?php

require __DIR__ . '/../vendor/autoload.php';

Tester\Environment::setup();


function test($cb)
{
	$cb();
}


function extractItems(array $items)
{
	$data = array();

	foreach ($items as $item) {
		$data[] = extractItem($item);
	}

	return $data;
}


function extractItem(\Inteve\Navigation\NavigationItem $item)
{
	return array(
		'label' => $item->getLabel(),
		'destination' => $item->getDestination(),
		'parameters' => $item->getParameters(),
	);
}


function renderControl(\Nette\Application\UI\Control $control)
{
	ob_start();
	$control->render();
	return ob_get_clean();
}


class LatteFactory implements \Nette\Bridges\ApplicationLatte\ILatteFactory
{
	public function create()
	{
		return new \Latte\Engine;
	}
}


class MockPresenter extends \Nette\Application\UI\Presenter
{
	public function link($destination, $args = array())
	{
		if (!is_array($args)) {
			$args = array_slice(func_get_args(), 1);
		}

		return 'presenter:' . $destination . '?' . http_build_query($args);
	}


	public function getTemplateFactory()
	{
		$latteFactory = new LatteFactory;
		return new Nette\Bridges\ApplicationLatte\TemplateFactory($latteFactory);
	}
}
