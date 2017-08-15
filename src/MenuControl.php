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
			$this->subTree = Navigation::formatPageId($subTree);
			return $this;
		}


		/**
		 * @return void
		 */
		public function render()
		{
			$items = array();
			$subTree = $this->subTree . '/';
			$subTreeLevel = substr_count($subTree, '/');

			foreach ($this->navigation->getPages() as $pageId => $page) {
				$pageLevel = substr_count($pageId, '/');

				if (Strings::startsWith($pageId, $subTree) && $subTreeLevel === $pageLevel) {
					$items[] = array(
						'page' => $page,
						'level' => 0,
					);
				}
			}

			$template = $this->createTemplate();
			$template->items = $items;
			$template->render($this->templateFile);
		}
	}
