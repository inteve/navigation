<?php

	namespace Inteve\Navigation;


	class UrlLink implements ILink
	{
		/** @var string */
		private $url;

		/** @var array */
		private $parameters;


		/**
		 * @param  string
		 */
		public function __construct($url, array $parameters = [])
		{
			$this->url = '/' . ltrim($url, '/');
			$this->parameters = $parameters;
		}


		/**
		 * @return string
		 */
		public function getDestination()
		{
			return $this->url;
		}


		/**
		 * @return array
		 */
		public function getParameters()
		{
			return $this->parameters;
		}
	}
