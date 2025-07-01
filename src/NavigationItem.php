<?php

	declare(strict_types=1);

	namespace Inteve\Navigation;


	class NavigationItem implements INavigationItem
	{
		/** @var string */
		private $label;

		/** @var ILink|NULL */
		private $link;


		/**
		 * @param  string $label
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
		 * @param  string $label
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
		 * @param  string $label
		 * @param  string|ILink|NULL $destination
		 * @param  array<string, mixed>|NULL $parameters
		 * @return self
		 */
		public static function create($label, $destination = NULL, array $parameters = NULL)
		{
			return new self($label, LinkFactory::create($destination, $parameters));
		}
	}
