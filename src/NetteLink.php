<?php

	namespace Inteve\Navigation;


	class NetteLink implements ILink
	{
		/** @var string */
		private $destination;

		/** @var array<string, mixed> */
		private $parameters;


		/**
		 * @param  string $destination  absolute presenter path or action name or 'this'
		 * @param  array<string, mixed> $parameters
		 */
		public function __construct($destination, array $parameters = [])
		{
			if (strpos($destination, ':') !== FALSE) { // Nette link - Presenter:action)
				$destination = ':' . ltrim($destination, ':');
			} // else -> this or action name

			$this->destination = $destination;
			$this->parameters = $parameters;
		}


		public function getDestination()
		{
			return $this->destination;
		}


		public function getParameters()
		{
			return $this->parameters;
		}
	}
