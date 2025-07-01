<?php

	declare(strict_types=1);

	namespace Inteve\Navigation;

	use Nette\Application\UI\Presenter;


	class DefaultLinkGenerator implements ILinkGenerator
	{
		/** @var Presenter */
		private $presenter;

		/** @var string|NULL */
		private $basePath;


		/**
		 * @param  string|NULL $basePath
		 */
		public function __construct(Presenter $presenter, $basePath)
		{
			if ($basePath !== NULL) {
				$basePath = rtrim($basePath, '/');
			}

			$this->presenter = $presenter;
			$this->basePath = $basePath;
		}


		/**
		 * @return string
		 */
		public function getUrl(ILink $link)
		{
			$destination = $link->getDestination();
			$parameters = $link->getParameters();

			if ($link instanceof UrlLink) {
				$params = (!empty($parameters) && strpos($destination, '?') === FALSE) ? http_build_query($parameters) : '';
				return $this->basePath . $destination . ($params !== '' ? "?$params" : '');
			}

			if ($link instanceof NetteLink) {
				return $this->presenter->link($destination, $parameters);
			}

			throw new NotImplementedException('Support for ' . get_class($link) . ' is not implemented.');
		}
	}
