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


	class InvalidArgumentException extends NavigationException
	{
	}


	class NotImplementedException extends NavigationException
	{
	}



	class StaticClassException extends NavigationException
	{
	}
