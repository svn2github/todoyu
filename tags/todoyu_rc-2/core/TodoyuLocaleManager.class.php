<?php
/****************************************************************************
* todoyu is published under the BSD License:
* http://www.opensource.org/licenses/bsd-license.php
*
* Copyright (c) 2010, snowflake productions gmbh
* All rights reserved.
*
* This script is part of the todoyu project.
* The todoyu project is free software; you can redistribute it and/or modify
* it under the terms of the BSD License.
*
* This script is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the BSD License
* for more details.
*
* This copyright notice MUST APPEAR in all copies of the script.
*****************************************************************************/

/**
 * Manager for locales
 *
 * @package		Todoyu
 * @subpackage	Core
 */
class TodoyuLocaleManager {

	/**
	 * Get locale definitions
	 *
	 * @return	Array
	 */
	public static function getLocales() {
		return TodoyuArray::assure(Todoyu::$CONFIG['LOCALES']);
	}



	/**
	 * Get all locale keys
	 *
	 * @return	Array
	 */
	public static function getLocaleKeys() {
		return array_keys(self::getLocales());
	}



	/**
	 * Check if locale exists in list
	 *
	 * @param	String		$locale
	 * @return	Boolean
	 */
	public static function hasLocale($locale) {
		return array_key_exists($locale, self::getLocales());
	}



	/**
	 * Convert language to locale key
	 *
	 * @param	String	$language	e.g. 'de' / 'en'
	 * @return	String
	 */
	public static function getLocaleFromLanguage($language) {
		$locale = $language . '_' . strtoupper($language);

		if ( TodoyuLocaleManager::hasLocale($locale) === false ) {
			$locale	= false;
		}
			// Check locale existence
		return $locale;
	}



	/**
	 * Get all names of a locale which may exists on a system
	 *
	 * @param	String		$locale
	 * @return	Array
	 */
	public static function getLocaleNames($locale) {
		$locales	= self::getLocales();

		return TodoyuArray::assure($locales[$locale]);
	}



	/**
	 * Set system locale
	 *
	 * @param	String					$locale
	 * @return	Boolean / String		FALSE or the new locale string
	 */
	public static function setLocale($locale) {
		$localeNames	= self::getLocaleNames($locale);

		return setlocale(LC_ALL, $localeNames);
	}



	/**
	 * Get currently on the system defined locale
	 *
	 * @return	String
	 */
	public static function getLocale() {
		return setlocale(LC_ALL, 0);
	}



	/**
	 * Get default fallback locale
	 *
	 * @return	String
	 */
	public static function getDefaultLocale() {
		return Todoyu::$CONFIG['defaultLocale'];
	}



	/**
	 * Get locale which is defined as default in browser
	 *
	 * @return	String
	 */
	public static function getBrowserLocale() {
		$languages	= explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
		$mainLang	= explode('-', $languages[0]);

		return strtolower($mainLang[0]) . '_' . strtoupper($mainLang[1]);
	}



	/**
	 * Get option array with locale key and label
	 *
	 * @return	Array
	 */
	public static function getLocaleOptions() {
		$locales	= self::getLocaleKeys();
		$options	= array();

		foreach($locales as $locale) {
			$options[] = array(
				'value'	=> $locale,
				'label'	=> Label('locale.' . $locale)
			);
		}

		return $options;
	}

}

?>