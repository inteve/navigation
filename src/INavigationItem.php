<?php

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
