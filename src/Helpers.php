<?php

	namespace Inteve\Navigation;

	use Nette\Utils\Strings;


	class Helpers
	{
		public function __construct()
		{
			throw new StaticClassException('This is static class.');
		}


		/**
		 * @param  string $pageId
		 * @return string
		 */
		public static function normalizePageId($pageId)
		{
			return trim($pageId, '/');
		}


		/**
		 * @param  string|NavigationPage $pageId
		 * @return string
		 */
		public static function extractPageId($pageId)
		{
			if ($pageId instanceof NavigationPage) {
				return $pageId->getId();
			}

			return self::normalizePageId($pageId);
		}


		/**
		 * @param  string $pageId
		 * @return int
		 */
		public static function getPageLevel($pageId)
		{
			return substr_count($pageId, '/');
		}


		/**
		 * @param  string $child
		 * @param  string $parent
		 * @return bool
		 */
		public static function isUnderPath($child, $parent)
		{
			$child = self::normalizePageId($child);
			$parent = self::normalizePageId($parent) . '/';

			if ($parent === '/') {
				return TRUE;
			}

			return Strings::startsWith($child, $parent);
		}


		/**
		 * @param  string $pageId
		 * @return string|NULL
		 */
		public static function getParent($pageId)
		{
			$pageId = self::normalizePageId($pageId);

			if ($pageId === '') {
				return NULL;
			}

			if (($pos = strrpos($pageId, '/')) !== FALSE) {
				return substr($pageId, 0, $pos);
			}

			return '';
		}
	}
