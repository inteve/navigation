<?php

	namespace Inteve\Navigation;


	class BreadcrumbsControl extends BaseControl
	{
		const TEMPLATE_DEFAULT = 'default';

		/** @var Navigation */
		private $navigation;

		/** @var string */
		private $templateFile;

		/** @var array */
		private $templateParameters;


		public function __construct(Navigation $navigation)
		{
			$this->navigation = $navigation;
			$this->setTemplateFile(self::TEMPLATE_DEFAULT);
		}


		/**
		 * @param  string  file path or template name
		 * @return self
		 */
		public function setTemplateFile($file, array $parameters = [])
		{
			if ($file === self::TEMPLATE_DEFAULT) {
				$file = __DIR__ . '/templates/breadcrumbs/' . $file . '.latte';
			}
			$this->templateFile = $file;
			$this->templateParameters = $parameters;
			return $this;
		}


		/**
		 * @return void
		 */
		public function render()
		{
			$template = $this->createTemplate();
			$template->setParameters($this->templateParameters);
			$template->items = $this->navigation->getBreadcrumbs();
			$template->linkGenerator = new DefaultLinkGenerator($this->getPresenter(), $template->basePath);
			$template->render($this->templateFile);
		}
	}
