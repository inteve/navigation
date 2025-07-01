<?php

	declare(strict_types=1);

	namespace Inteve\Navigation;


	interface INavigationItem
	{
		/**
		 * @return string
		 */
		function getLabel();


		/**
		 * @return ILink|NULL
		 */
		function getLink();


		/**
		 * @return bool
		 */
		function hasLink();
	}
