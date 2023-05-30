<?php

	namespace Inteve\Navigation;

	use Nette\Utils\Strings;


	class MenuControl extends BaseControl
	{
		const TEMPLATE_DEFAULT = 'default';
		const TEMPLATE_BOOTSTRAP2 = 'bootstrap2';
		const TEMPLATE_BOOTSTRAP2_TABS = 'bootstrap2-tabs';

		/** @var Navigation */
		private $navigation;

		/** @var string|NULL */
		private $subTree;

		/** @var int|NULL */
		private $subLevel;

		/** @var string */
		private $templateFile;

		/** @var array<string, mixed> */
		private $templateParameters;

		/** @var array<string, true>|NULL */
		private $ignoredPages;


		public function __construct(Navigation $navigation)
		{
			$this->navigation = $navigation;
			$this->setTemplateFile(self::TEMPLATE_DEFAULT);
		}


		/**
		 * @param  string $file  file path or template name
		 * @param  array<string, mixed> $parameters
		 * @return self
		 */
		public function setTemplateFile($file, array $parameters = [])
		{
			if ($file === self::TEMPLATE_DEFAULT
				|| $file === self::TEMPLATE_BOOTSTRAP2
				|| $file === self::TEMPLATE_BOOTSTRAP2_TABS) {
				$file = __DIR__ . '/templates/menu/' . $file . '.latte';
			}
			$this->templateFile = $file;
			$this->templateParameters = $parameters;
			return $this;
		}


		/**
		 * @deprecated  use setSubTree()
		 * @param  string|NULL $parentPage
		 * @return self
		 */
		public function setParentPage($parentPage)
		{
			return $this->setSubTree($parentPage);
		}


		/**
		 * @param  string|NULL $subTree
		 * @return self
		 */
		public function setSubTree($subTree)
		{
			$this->subTree = $subTree !== NULL ? Helpers::normalizePageId($subTree) : NULL;
			return $this;
		}


		/**
		 * @param  int|NULL $subLevel
		 * @return self
		 */
		public function setSubLevel($subLevel)
		{
			$this->subLevel = $subLevel > 0 ? $subLevel : NULL;
			return $this;
		}


		/**
		 * @param  string[]|NULL $ignoredPages
		 * @return self
		 */
		public function setIgnoredPages(array $ignoredPages = NULL)
		{
			if ($ignoredPages === NULL) {
				$this->ignoredPages = NULL;
				return $this;
			}

			$navigation = $this->navigation;

			foreach ($ignoredPages as $ignoredPage) {
				$ignoredPage = Helpers::normalizePageId($ignoredPage);
				$this->ignoredPages[$ignoredPage] = TRUE;
			}

			return $this;
		}


		/**
		 * @return void
		 */
		public function render()
		{
			$items = [];
			$subTree = $this->findSubTree();

			if ($subTree === NULL) { // no subtree => no items
				return;
			}

			foreach ($this->navigation->getMenuPages() as $pageId => $page) {
				if (isset($this->ignoredPages[$pageId])) {
					continue;
				}

				if ($page->isChildOf($subTree)) {
					$active = FALSE;

					if ($page->isHomepage()) {
						$active = $this->navigation->isPageCurrent($pageId);

					} else {
						$active = $this->navigation->isPageActive($pageId);
					}

					$items[] = [
						'page' => $page,
						'active' => $active,
						'level' => 0,
					];
				}
			}

			$template = $this->createTemplate();
			assert($template instanceof \Nette\Bridges\ApplicationLatte\DefaultTemplate);
			$template->setParameters($this->templateParameters);
			$template->items = $items;
			$template->linkGenerator = new DefaultLinkGenerator($this->getPresenter(), $template->basePath);
			$template->render($this->templateFile);
		}


		/**
		 * @return string|NULL
		 */
		private function findSubTree()
		{
			if ($this->subLevel === NULL) {
				return (string) $this->subTree;
			}

			$subTree = (string) $this->subTree;
			$currentPage = (string) $this->navigation->getCurrentPage();

			if ($currentPage === '' || !Helpers::isUnderPath($currentPage, $subTree)) {
				return NULL;
			}

			$requiredLevel = Helpers::getPageLevel($subTree) + $this->subLevel;

			if ($subTree !== '') {
				$requiredLevel++;
			}

			while (Helpers::getPageLevel($currentPage) >= $requiredLevel) {
				$currentPage = Helpers::getParent($currentPage);

				if ($currentPage === '' || $currentPage === NULL) {
					break;
				}
			}

			return $currentPage;
		}
	}
