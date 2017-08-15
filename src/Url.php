<?php

	namespace Inteve\Navigation;


	class Url
	{
		/** @var string */
		private $url;


		/**
		 * @param  string
		 */
		public function __construct($url)
		{
			$this->url = '/' . ltrim($url, '/');
		}


		/**
		 * @param  string|NULL
		 * @return string
		 */
		public function getUrl(array $parameters = NULL, $basePath = NULL)
		{
			if ($basePath !== NULL) {
				$basePath = rtrim($basePath, '/');
			}

			$params = (!empty($parameters) && strpos($this->url, '?') === FALSE) ? http_build_query($parameters) : '';
			return $basePath . $this->url . ($params !== '' ? "?$params" : '');
		}
	}
