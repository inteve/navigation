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
		 * @param  string
		 * @return string
		 */
		public static function normalizePageId($pageId)
		{
			return trim($pageId, '/');
		}


		/**
		 * @param  string|NavigationPage
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
		 * @param  string
		 * @return int
		 */
		public static function getPageLevel($pageId)
		{
			return substr_count($pageId, '/');
		}


		/**
		 * @param  string
		 * @param  string
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
		 * @param  string
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
