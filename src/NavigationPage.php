<?php

	namespace Inteve\Navigation;


	class NavigationPage implements INavigationItem
	{
		const VISIBILITY_HIDDEN = 0;
		const VISIBILITY_ONLY_MENU = 1;
		const VISIBILITY_ONLY_BREADCRUMBS = 2;
		const VISIBILITY_MENU_AND_BREADCRUMBS = 3;

		/** @var string */
		private $id;

		/** @var string */
		private $label;

		/** @var ILink|NULL */
		private $link;

		/** @var self::VISIBILITY_* */
		private $visibility = self::VISIBILITY_MENU_AND_BREADCRUMBS;


		/**
		 * @param  string $id
		 * @param  string $label
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
		 * @return bool
		 */
		public function isVisibleInMenu()
		{
			return $this->visibility === self::VISIBILITY_MENU_AND_BREADCRUMBS
				|| $this->visibility === self::VISIBILITY_ONLY_MENU;
		}


		/**
		 * @return bool
		 */
		public function isVisibleInBreadcrumbs()
		{
			return $this->visibility === self::VISIBILITY_MENU_AND_BREADCRUMBS
				|| $this->visibility === self::VISIBILITY_ONLY_BREADCRUMBS;
		}


		/**
		 * @param  self::VISIBILITY_* $visibility
		 * @return self
		 */
		public function setVisibility($visibility)
		{
			$this->visibility = $visibility;
			return $this;
		}


		/**
		 * @return int
		 */
		public function getLevel()
		{
			return Helpers::getPageLevel($this->id);
		}


		/**
		 * @param  string $pageId
		 * @return bool
		 */
		public function isDescendantOf($pageId)
		{
			return Helpers::isUnderPath($this->id, $pageId);
		}


		/**
		 * @param  string $pageId
		 * @return bool
		 */
		public function isChildOf($pageId)
		{
			return $this->isDescendantOf($pageId) && $this->getLevel() === Helpers::getPageLevel(ltrim($pageId . '/', '/'));
		}


		/**
		 * @return bool
		 */
		public function isHomepage()
		{
			return $this->id === '';
		}


		/**
		 * @param  string $id
		 * @param  string $label
		 * @param  string|ILink|NULL $destination
		 * @param  array<string, mixed>|NULL $parameters
		 * @return self
		 */
		public static function create($id, $label, $destination = NULL, array $parameters = NULL)
		{
			return new self($id, $label, LinkFactory::create($destination, $parameters));
		}
	}
