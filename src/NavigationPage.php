<?php

	namespace Inteve\Navigation;


	class NavigationPage implements INavigationItem
	{
		/** @var string */
		private $id;

		/** @var string */
		private $label;

		/** @var ILink|NULL */
		private $link;


		/**
		 * @param  string
		 * @param  string
		 */
		public function __construct($id, $label, ILink $link = NULL)
		{
			$this->id = Helpers::normalizePageId($id);
			$this->label = $label;
			$this->link = $link;
		}


		/**
		 * @return string
		 */
		public function getId()
		{
			return $this->id;
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
		 * @return int
		 */
		public function getLevel()
		{
			return Helpers::getPageLevel($this->id);
		}


		/**
		 * @param  string
		 * @param  string
		 * @param  string|ILink|NULL
		 * @param  array|NULL
		 * @return self
		 */
		public static function create($id, $label, $destination = NULL, array $parameters = NULL)
		{
			return new self($id, $label, LinkFactory::create($destination, $parameters));
		}
	}
