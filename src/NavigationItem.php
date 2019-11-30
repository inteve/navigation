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
			$link = NULL;

			if ($destination === NULL) {
				if ($parameters !== NULL) {
					throw new InvalidArgumentException('Destination is empty, passing of $parameters has no effect.');
				}

			} elseif ($destination instanceof ILink) {
				$link = $destination;

				if ($parameters !== NULL) {
					throw new InvalidArgumentException('Destination is already instance of ' . ILink::class . ', passing of $parameters has no effect.');
				}

			} elseif (is_string($destination)) {
				$parameters = $parameters !== NULL ? $parameters : array();

				if (strpos($destination, '/') !== FALSE) { // detect URL
					$link = new UrlLink($destination, $parameters);

				} else { // Nette link - Presenter:action or action name or 'this'
					$link = new NetteLink($destination, $parameters);
				}

			} else {
				throw new InvalidArgumentException('Destination must be ' . ILink::class . ', string or NULL.');
			}

			return new static($label, $link);
		}
	}
