<?php

declare(strict_types=1);

class LatteFactory implements \Nette\Bridges\ApplicationLatte\ILatteFactory
{
	public function create(): \Latte\Engine
	{
		return new \Latte\Engine;
	}
}


class MockPresenter extends \Nette\Application\UI\Presenter
{
	public function __construct()
	{
		parent::__construct();
		$latteFactory = new LatteFactory;
		$templateFactory = new Nette\Bridges\ApplicationLatte\TemplateFactory($latteFactory);

		$url = new Nette\Http\UrlScript('http://localhost/index.php', '/index.php');
		$this->injectPrimary(
			NULL,
			NULL,
			NULL,
			new Nette\Http\Request($url),
			new Nette\Http\Response,
			NULL,
			NULL,
			$templateFactory
		);
	}


	public function link(string $destination, $args = []): string
	{
		if (!is_array($args)) {
			$args = array_slice(func_get_args(), 1);
		}

		return '#presenter=' . $destination . '?' . http_build_query($args);
	}
}
