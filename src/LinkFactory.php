<?php

	namespace Inteve\Navigation;


	class LinkFactory
	{
		public function __construct()
		{
			throw new StaticClassException('This is static class.');
		}


		/**
		 * @param  string|ILink|NULL $destination
		 * @param  array<string, mixed>|NULL $parameters
		 * @return ILink|NULL
		 */
		public static function create($destination, array $parameters = NULL)
		{
			if ($destination === NULL) {
				if ($parameters !== NULL) {
					throw new InvalidArgumentException('Destination is empty, passing of $parameters has no effect.');
				}

				return NULL;

			} elseif ($destination instanceof ILink) {
				if ($parameters !== NULL) {
					throw new InvalidArgumentException('Destination is already instance of ' . ILink::class . ', passing of $parameters has no effect.');
				}

				return $destination;

			} elseif (is_string($destination)) {
				$parameters = $parameters !== NULL ? $parameters : [];

				if (strpos($destination, '/') !== FALSE) { // detect URL
					return new UrlLink($destination, $parameters);

				} else { // Nette link - Presenter:action or action name or 'this'
					return new NetteLink($destination, $parameters);
				}
			}

			throw new InvalidArgumentException('Destination must be ' . ILink::class . ', string or NULL.');
		}
	}
