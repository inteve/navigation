<?php

	declare(strict_types=1);

	namespace Inteve\Navigation;


	class UrlLink implements ILink
	{
		/** @var string */
		private $url;

		/** @var array<string, mixed> */
		private $parameters;


		/**
		 * @param  string $url
		 * @param  array<string, mixed> $parameters
		 */
		public function __construct($url, array $parameters = [])
		{
			$this->url = '/' . ltrim($url, '/');
			$this->parameters = $parameters;
		}


		public function getDestination()
		{
			return $this->url;
		}


		public function getParameters()
		{
			return $this->parameters;
		}
	}
