<?php

	namespace Inteve\Navigation;

	use Nette\Utils\Strings;


	class MenuControl extends BaseControl
	{
		const TEMPLATE_DEFAULT = 'default';

		/** @var Navigation */
		private $navigation;

		/** @var string|NULL */
		private $subTree;

		/** @var string */
		private $templateFile;

		/** @var array|NULL */
		private $ignoredPages;


		public function __construct(Navigation $navigation)
		{
			$this->navigation = $navigation;
			$this->setTemplateFile(self::TEMPLATE_DEFAULT);
		}


		/**
		 * @param  string  file path or template name
		 * @return self
		 */
		public function setTemplateFile($file)
		{
			if ($file === self::TEMPLATE_DEFAULT) {
				$file = __DIR__ . '/templates/menu/' . $file . '.latte';
			}
			$this->templateFile = $file;
			return $this;
		}


		/**
		 * @deprecated  use setSubTree()
		 */
		public function setParentPage($parentPage)
		{
			return $this->setSubTree($parentPage);
		}


		/**
		 * @param  string|NULL
		 */
		public function setSubTree($subTree)
		{
			$this->subTree = Helpers::normalizePageId($subTree);
			return $this;
		}


		/**
		 * @param  string[]|NULL
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
			$subTree = ltrim($this->subTree . '/', '/');
			$subTreeLevel = Helpers::getPageLevel($subTree);

			foreach ($this->navigation->getPages() as $pageId => $page) {
				if (isset($this->ignoredPages[$pageId])) {
					continue;
				}

				if (Strings::startsWith($pageId, $subTree) && $subTreeLevel === $page->getLevel()) {
					$active = FALSE;

					if ($pageId === '') { // homepage
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
			$template->items = $items;
			$template->linkGenerator = new DefaultLinkGenerator($this->getPresenter(), $template->basePath);
			$template->render($this->templateFile);
		}
	}
