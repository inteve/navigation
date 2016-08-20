<?php

	namespace Inteve\Navigation;


	class NavigationException extends \RuntimeException
	{
	}


	class MissingException extends NavigationException
	{
	}


	class DuplicateException extends NavigationException
	{
	}
