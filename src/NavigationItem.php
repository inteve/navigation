<?php

	namespace Inteve\Navigation;


	class NavigationItem
	{
		/** @var string */
		private $label;

		/** @var string|Url|NULL */
		private $destination;

		/** @var array */
		private $parameters;


		/**
		 * @param  string
		 * @param  string|Url|NULL
		 * @param  array|NULL
		 */
		public function __construct($label, $destination = NULL, array $parameters = NULL)
		{
			$this->label = $label;
			$this->destination = $this->detectDestination($destination);
			$this->parameters = $parameters !== NULL ? $parameters : array();
		}


		/**
		 * @return string
		 */
		public function getLabel()
		{
			return $this->label;
		}


		/**
		 * @param  string
		 * @return self
		 */
		public function setLabel($label)
		{
			$this->label = $label;
			return $this;
		}


		/**
		 * @return string|NULL
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


		/**
		 * @param  string|NULL|Url
		 * @return string|NULL|Url
		 */
		protected function detectDestination($destination)
		{
			if ($destination === NULL) {
				return NULL;
			}

			if ($destination instanceof Url) {
				return $destination;
			}

			if (strpos($destination, '/') !== FALSE) { // detect URL
				return new Url($destination);
			}

			if (strpos($destination, ':') !== FALSE) { // Nette link - Presenter:action
				$destination = ':' . ltrim($destination, ':');
			} // else -> this or action name

			return $destination;
		}
	}
