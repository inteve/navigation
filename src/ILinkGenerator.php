<?php

	namespace Inteve\Navigation;


	interface ILinkGenerator
	{
		/**
		 * @return string
		 */
		function getUrl(ILink $link);
	}
