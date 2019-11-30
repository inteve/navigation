<?php

	namespace Inteve\Navigation;

	use Nette\Utils\Strings;


	class Navigation
	{
		/** @var array */
		private $pages = [];

		/** @var array */
		private $items = [];

		/** @var array */
		private $beforeItems = [];

		/** @var array */
		private $afterItems = [];

		/** @var string|NULL */
		private $currentPage;

		/** @var string|NULL */
		private $defaultPage;


		/**
		 * @param  string|NULL
		 * @return self
		 */
		public function setDefaultPage($defaultPage)
		{
			$this->defaultPage = $defaultPage !== NULL ? self::formatPageId($defaultPage) : NULL;
			return $this;
		}


		/**
		 * @param  string|NULL
		 * @return self
		 */
		public function setCurrentPage($currentPage)
		{
			$this->currentPage = $currentPage !== NULL ? self::formatPageId($currentPage) : NULL;
			return $this;
		}


		/**
		 * @return string|NULL
		 */
		public function getCurrentPage()
		{
			return isset($this->currentPage) ? $this->currentPage : $this->defaultPage;
		}


		/**
		 * @param  string
		 * @return bool
		 */
		public function isPageCurrent($page)
		{
			return self::formatPageId($page) === $this->getCurrentPage();
		}


		/**
		 * @param  string
		 * @return bool
		 */
		public function isPageActive($page)
		{
			$page = self::formatPageId($page);
			$currentPage = $this->getCurrentPage();

			if ($currentPage === NULL) {
				return FALSE;
			}

			if ($page === $currentPage || $page === '') {
				return TRUE;
			}

			return Strings::startsWith($currentPage, "$page/");
		}


		/**
		 * @param  string
		 * @param  string|NavigationItem
		 * @param  string|NULL
		 * @param  string|NULL
		 * @return self
		 * @throws DuplicateException
		 */
		public function addPage($id, $label, $link = NULL, array $parameters = NULL)
		{
			$id = self::formatPageId($id);

			if (isset($this->pages[$id])) {
				throw new DuplicateException("Page '$id' already exists.");
			}

			$this->pages[$id] = $this->createItem($label, $link, $parameters);
			return $this;
		}


		/**
		 * @param  string
		 * @param  string
		 * @return self
		 */
		public function setPageLabel($pageId, $label)
		{
			$page = $this->getPage($pageId);
			$page->setLabel($label);
			return $this;
		}


		/**
		 * @param  string
		 * @return NavigationItem
		 * @throws MissingException
		 */
		public function getPage($pageId)
		{
			$pageId = self::formatPageId($pageId);

			if (!isset($this->pages[$pageId])) {
				throw new MissingException("Page '$pageId' not found.");
			}

			return $this->pages[$pageId];
		}


		/**
		 * @return NavigationItem[]  [pageId => NavigationItem]
		 */
		public function getPages()
		{
			return $this->pages;
		}


		/**
		 * @param  string
		 * @return bool
		 */
		public function hasChildren($pageId)
		{
			$pageId = self::formatPageId($pageId);

			if ($pageId === '') {
				return TRUE;
			}

			$pageId .= '/';

			foreach ($this->pages as $childId => $item) {
				if (Strings::startsWith($childId, $pageId)) {
					return TRUE;
				}
			}

			return FALSE;
		}


		/**
		 * @param  string|NavigationItem
		 * @param  string|NULL
		 * @param  string|NULL
		 * @return self
		 */
		public function addItem($label, $link = NULL, array $parameters = NULL)
		{
			$this->items[] = $this->createItem($label, $link, $parameters);
			return $this;
		}


		/**
		 * @param  string
		 * @param  string|NavigationItem
		 * @param  string|NULL
		 * @param  string|NULL
		 * @return self
		 */
		public function addItemBefore($pageId, $label, $link = NULL, array $parameters = NULL)
		{
			$pageId = self::formatPageId($pageId);
			$this->beforeItems[$pageId][] = $this->createItem($label, $link, $parameters);
			return $this;
		}


		/**
		 * @param  string
		 * @param  string|NavigationItem
		 * @param  string|NULL
		 * @param  string|NULL
		 * @return self
		 */
		public function addItemAfter($pageId, $label, $link = NULL, array $parameters = NULL)
		{
			$pageId = self::formatPageId($pageId);
			$this->afterItems[$pageId][] = $this->createItem($label, $link, $parameters);
			return $this;
		}


		/**
		 * Returns breadcrumbs for current page.
		 * @return array
		 */
		public function getBreadcrumbs()
		{
			// ziskame aktualni stranku, postupne z jejiho ID urezavame casti, pridavame odpovidajici stranky a itemy
			$items = [];
			$currentPage = $this->getCurrentPage();

			if (isset($currentPage)) {
				do {
					if (isset($this->pages[$currentPage])) { // pokud stranka existuje
						if (isset($this->afterItems[$currentPage])) { // array_reverse
							$items = array_merge($items, array_reverse($this->afterItems[$currentPage]));
						}

						$items[] = $this->pages[$currentPage];

						if (isset($this->beforeItems[$currentPage])) { // array_reverse
							$items = array_merge($items, array_reverse($this->beforeItems[$currentPage]));
						}
					}

					// urizneme cast
					if ($currentPage === '') {
						break; // currentPage = FALSE
					}

					if (($pos = strrpos($currentPage, '/')) !== FALSE) {
						$currentPage = substr($currentPage, 0, $pos);

					} else {
						$currentPage = '';
					}

				} while ($currentPage !== FALSE);

				$items = array_reverse($items);
			}

			foreach ($this->items as $item) {
				$items[] = $item;
			}

			return $items;
		}


		/**
		 * @param  string|NavigationItem
		 * @param  string|NULL
		 * @param  string|NULL
		 * @return NavigationItem
		 */
		private function createItem($label, $link = NULL, array $parameters = NULL)
		{
			if ($label instanceof NavigationItem) {
				return $label;

			} else {
				return NavigationItem::create($label, $link, $parameters);
			}
		}


		/**
		 * @param  string
		 * @return string
		 */
		public static function formatPageId($pageId)
		{
			return trim($pageId, '/');
		}
	}
