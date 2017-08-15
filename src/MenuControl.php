<?php

	namespace Inteve\Navigation;

	use Nette\Utils\Strings;


	class MenuControl extends BaseControl
	{
		const TEMPLATE_DEFAULT = 'default';

		/** @var Navigation */
		private $navigation;

		/** @var string|NULL */
		private $parentPage;

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
		 * @param  string|NULL
		 */
		public function setParentPage($parentPage)
		{
			$this->parentPage = Navigation::formatPageId($parentPage);
			return $this;
		}


		/**
		 * @return void
		 */
		public function render()
		{
			$items = array();
			$parentPage = $this->parentPage . '/';
			$parentLevel = substr_count($parentPage, '/');

			foreach ($this->navigation->getPages() as $pageId => $page) {
				$pageLevel = substr_count($pageId, '/');

				if (Strings::startsWith($pageId, $parentPage) && $parentLevel === $pageLevel) {
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
