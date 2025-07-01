<?php

	declare(strict_types=1);

	namespace Inteve\Navigation;


	interface ILinkGenerator
	{
		/**
		 * @return string
		 */
		function getUrl(ILink $link);
	}
