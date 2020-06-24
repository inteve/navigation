<?php

	namespace Inteve\Navigation;

	use Nette\Utils\Strings;


	class Navigation
	{
		/** @var array<string, NavigationPage> */
		private $pages = [];

		/** @var INavigationItem[] */
		private $items = [];

		/** @var array<string, INavigationItem[]> */
		private $beforeItems = [];

		/** @var array<string, INavigationItem[]> */
		private $afterItems = [];

		/** @var string|NULL */
		private $currentPage;

		/** @var string|NULL */
		private $defaultPage;


		/**
		 * @param  string|NavigationPage|NULL
		 * @return self
		 */
		public function setDefaultPage($defaultPage)
		{
			$this->defaultPage = $defaultPage !== NULL ? Helpers::extractPageId($defaultPage) : NULL;
			return $this;
		}


		/**
		 * @param  string|NavigationPage|NULL
		 * @return self
		 */
		public function setCurrentPage($currentPage)
		{
			$this->currentPage = $currentPage !== NULL ? Helpers::extractPageId($currentPage) : NULL;
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
		 * @param  string|NavigationPage
		 * @return bool
		 */
		public function isPageCurrent($page)
		{
			return Helpers::extractPageId($page) === $this->getCurrentPage();
		}


		/**
		 * @param  string|NavigationPage
		 * @return bool
		 */
		public function isPageActive($page)
		{
			$page = Helpers::extractPageId($page);
			$currentPage = $this->getCurrentPage();

			if ($currentPage === NULL) {
				return FALSE;
			}

			if ($page === $currentPage || $page === '') {
				return TRUE;
			}

			return Helpers::isUnderPath($currentPage, $page);
		}


		/**
		 * @param  string
		 * @param  string|NavigationPage|INavigationItem
		 * @param  string|NULL
		 * @param  string|NULL
		 * @return self
		 * @throws DuplicateException
		 */
		public function addPage($id, $label, $link = NULL, array $parameters = NULL)
		{
			$page = NULL;

			if ($label instanceof INavigationItem) {
				$item = $label;
				$page = NavigationPage::create($id, $item->getLabel(), $item->getLink());

			} else {
				$page = NavigationPage::create($id, $label, $link, $parameters);
			}

			$this->addToPages($page);
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
		 * @return NavigationPage
		 * @throws MissingException
		 */
		public function getPage($pageId)
		{
			$pageId = Helpers::normalizePageId($pageId);

			if (!isset($this->pages[$pageId])) {
				throw new MissingException("Page '$pageId' not found.");
			}

			return $this->pages[$pageId];
		}


		/**
		 * @return array<string, NavigationPage>  [pageId => NavigationPage]
		 */
		public function getPages()
		{
			return $this->pages;
		}


		/**
		 * @param  string|NavigationPage
		 * @return bool
		 */
		public function hasChildren($pageId)
		{
			$pageId = Helpers::extractPageId($pageId);

			if ($pageId === '') {
				return TRUE;
			}

			foreach ($this->pages as $childId => $page) {
				if ($page->isDescendantOf($pageId)) {
					return TRUE;
				}
			}

			return FALSE;
		}


		/**
		 * @param  string|INavigationItem
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
		 * @param  string|NavigationPage
		 * @param  string|INavigationItem
		 * @param  string|NULL
		 * @param  string|NULL
		 * @return self
		 */
		public function addItemBefore($pageId, $label, $link = NULL, array $parameters = NULL)
		{
			$pageId = Helpers::extractPageId($pageId);
			$this->beforeItems[$pageId][] = $this->createItem($label, $link, $parameters);
			return $this;
		}


		/**
		 * @param  string|NavigationPage
		 * @param  string|INavigationItem
		 * @param  string|NULL
		 * @param  string|NULL
		 * @return self
		 */
		public function addItemAfter($pageId, $label, $link = NULL, array $parameters = NULL)
		{
			$pageId = Helpers::extractPageId($pageId);
			$this->afterItems[$pageId][] = $this->createItem($label, $link, $parameters);
			return $this;
		}


		/**
		 * Returns breadcrumbs for current page.
		 * @return INavigationItem[]
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
						break; // currentPage = NULL
					}

					$currentPage = Helpers::getParent($currentPage);

				} while ($currentPage !== NULL);

				$items = array_reverse($items);
			}

			foreach ($this->items as $item) {
				$items[] = $item;
			}

			return $items;
		}


		/**
		 * @return void
		 */
		private function addToPages(NavigationPage $page)
		{
			$id = $page->getId();

			if (isset($this->pages[$id])) {
				throw new DuplicateException("Page '$id' already exists.");
			}

			$this->pages[$id] = $page;
		}


		/**
		 * @param  string|INavigationItem
		 * @param  string|NULL
		 * @param  string|NULL
		 * @return INavigationItem
		 */
		private function createItem($label, $link = NULL, array $parameters = NULL)
		{
			if ($label instanceof INavigationItem) {
				return $label;

			} else {
				return NavigationItem::create($label, $link, $parameters);
			}
		}
	}
