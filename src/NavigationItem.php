<?php

	namespace Inteve\Navigation;


	class NavigationItem
	{
		/** @var string */
		private $label;

		/** @var ILink|NULL */
		private $link;


		/**
		 * @param  string
		 */
		public function __construct($label, ILink $link = NULL)
		{
			$this->label = $label;
			$this->link = $link;
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
		 * @return ILink|NULL
		 */
		public function getLink()
		{
			return $this->link;
		}


		/**
		 * @return bool
		 */
		public function hasLink()
		{
			return $this->link !== NULL;
		}


		/**
		 * @param  string
		 * @param  string|ILink|NULL
		 * @param  array|NULL
		 * @return static
		 */
		public static function create($label, $destination = NULL, array $parameters = NULL)
		{
			return new static($label, LinkFactory::create($destination, $parameters));
		}
	}
