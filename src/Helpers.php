<?php

	namespace Inteve\Navigation;


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
		 * @param  string
		 * @return int
		 */
		public static function getPageLevel($pageId)
		{
			return substr_count($pageId, '/');
		}
	}
