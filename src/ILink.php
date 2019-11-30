<?php

	namespace Inteve\Navigation;


	interface ILink
	{
		/**
		 * @return string
		 */
		function getDestination();


		/**
		 * @return array
		 */
		function getParameters();
	}
