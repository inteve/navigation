<?php

	namespace Inteve\Navigation;


	class BreadcrumbsControl extends BaseControl
	{
		const TEMPLATE_DEFAULT = 'default';

		/** @var Navigation */
		private $navigation;

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
				$file = __DIR__ . '/templates/breadcrumbs/' . $file . '.latte';
			}
			$this->templateFile = $file;
			return $this;
		}


		/**
		 * @return void
		 */
		public function render()
		{
			$template = $this->createTemplate();
			$template->items = $this->navigation->getBreadcrumbs();
			$template->render($this->templateFile);
		}
	}
