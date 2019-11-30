<?php

	namespace Inteve\Navigation;


	class NetteLink implements ILink
	{
		/** @var string */
		private $destination;

		/** @var array */
		private $parameters;


		/**
		 * @param  string  absolute presenter path or action name or 'this'
		 */
		public function __construct($destination, array $parameters = array())
		{
			if (strpos($destination, ':') !== FALSE) { // Nette link - Presenter:action)
				$destination = ':' . ltrim($destination, ':');
			} // else -> this or action name

			$this->destination = $destination;
			$this->parameters = $parameters;
		}


		/**
		 * @return string
		 */
		public function getDestination()
		{
			return $this->destination;
		}


		/**
		 * @return array
		 */
		public function getParameters()
		{
			return $this->parameters;
		}
	}
