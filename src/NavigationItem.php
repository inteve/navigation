<?php

	namespace Inteve\Navigation;


	class NavigationItem
	{
		/** @var string */
		private $label;

		/** @var string|NULL */
		private $destination;

		/** @var array */
		private $parameters;


		/**
		 * @param  string
		 * @param  string|NULL
		 * @param  array|NULL
		 */
		public function __construct($label, $destination = NULL, array $parameters = NULL)
		{
			$this->label = $label;
			$this->destination = $destination;
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
	}
