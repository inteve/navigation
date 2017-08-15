<?php

	namespace Inteve\Navigation;

	use Nette\Application\UI\Control;


	abstract class BaseControl extends Control
	{
		/**
		 * @param  NavigationItem
		 * @param  string|NULL
		 * @return string|NULL
		 */
		public function getItemUrl(NavigationItem $item, $basePath = NULL)
		{
			$destination = $item->getDestination();

			if ($destination === NULL) {
				return NULL;
			}

			if ($destination instanceof Url) {
				return $destination->getUrl($item->getParameters(), $basePath);
			}

			return $this->getPresenter()->link($destination, $item->getParameters());
		}
	}
