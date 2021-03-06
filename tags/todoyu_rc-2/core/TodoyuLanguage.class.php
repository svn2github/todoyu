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
 * Language management for todoyu
 *
 * @package		Todoyu
 * @subpackage	Core
 */
class TodoyuLanguage {

	/**
	 * Current locale key. Default is english
	 *
	 * @var	String
	 */
	private static $language = 'en';

	/**
	 * Locallang labels cache
	 *
	 * @var	Array
	 */
	public static $cache = array();

	/**
	 * Registered file references
	 *
	 * @var	Array
	 */
	private static $files = array();



	/**
	 * Set locale. All request for labels without a locale will use this locale.
	 * Default locale is en (english)
	 *
	 * @param	String		$language
	 */
	public static function setLanguage($language) {
		self::$language = $language;
	}



	/**
	 * Get current locale
	 *
	 * @return	String
	 */
	public static function getLanguage() {
		return self::$language;
	}



	/**
	 * Get translated label
	 *
	 * @param	String		$labelKey		Key to label. First part is the fileKey
	 * @param	String		$language		Force language. If not set, us defined language
	 * @return	String		Translated label
	 */
	public static function getLabel($labelKey, $language = null) {
		$label	= self::getLabelInternal($labelKey, $language);

		if( $label === '' && Todoyu::$CONFIG['DEBUG'] ) {
			Todoyu::log($label, LOG_LEVEL_NOTICE);
			$label	= 'Label not found: #' .$labelKey . '#';
		}

		return $label;
	}



	/**
	 * Get label which will be parsed with wildcards like printf()
	 *
	 * @param	String		$labelKey
	 * @param	Array		$wildcards
	 * @param	String		$language
	 * @return	String
	 */
	public static function getFormatLabel($labelKey, array $wildcards = array(), $language = null) {
		$label	= self::getLabel($labelKey, $language);

		return vsprintf($label, $wildcards);
	}



	/**
	 * Get label if it exists. If not existing, get empty string
	 *
	 * @param	String		$labelKey
	 * @param	String		$language
	 * @return	String
	 */
	public static function getLabelIfExists($labelKey, $language = null) {
		return trim(self::getLabelInternal($labelKey, $language));
	}



	/**
	 * Get label or null if not existing
	 *
	 * @param	String		$labelKey
	 * @param	String		$language
	 * @return	String		Or NULL
	 */
	private static function getLabelInternal($labelKey, $language = null) {
		$language	= is_null($language) ? self::$language : $language ;

			// Split path parts into fileKey and label index
		$keyParts	= explode('.', $labelKey, 2);
		$fileKey	=  substr($keyParts[0], 0, 4) == 'LLL:' ? substr($keyParts[0], 4) : $keyParts[0];
		$labelIndex	= $keyParts[1];

		return self::getCachedLabel($fileKey, $labelIndex, $language);
	}



	/**
	 * Checks if requested lable exists
	 *
	 * @param	String	$labelKey
	 * @param	String	$language
	 * @return	String
	 */
	public static function labelExists($labelKey, $language = null)	{
		$label	= self::getLabelInternal($labelKey, $language);

		return !is_null($label);
	}



	/**
	 * Get all file labels
	 *
	 * @param	String		$fileKey
	 * @param	String		$language
	 * @return	Array
	 */
	public static function getFileLabels($fileKey, $language = null) {
		$language	= is_null($language) ? self::$language : $language ;

		self::loadFileLabels($fileKey, $language);

		return self::getFileCache($fileKey, $language);
	}



	/**
	 * Register a file, so translations can be accessed over this key
	 * The $fileKey has to be unique in the system, else, it will override other translations
	 *
	 * @param	String		$fileKey			Filekey used as prefix of the labels
	 * @param	String		$absPathToFile		Absolute path to the locallang XML file
	 */
	public static function register($identifier, $absPathToFile) {
		$absPathToFile = TodoyuFileManager::pathAbsolute($absPathToFile);

		if( ! is_file($absPathToFile) ) {
			TodoyuDebug::printHtml($absPathToFile, 'Language file not found!', null, true);
		}

		self::$files[$identifier] = $absPathToFile;
	}



	/**
	 * Add translation of a file to the internal cache
	 *
	 * @param	String		$fileKey			Key of the file
	 * @param 	String		$language			Language of the translation
	 * @param	Array		$locallangArray		Translated labels
	 */
	private static function setFileCache($fileKey, $language, array $locallangArray) {
		self::$cache[$fileKey][$language] = $locallangArray;
	}



	/**
	 * Get translated labels from internal cache if available
	 *
	 * @param	String		$fileKey
	 * @param	String		$language
	 * @return	Array
	 */
	private static function getFileCache($fileKey, $language) {
		return !empty(self::$cache[$fileKey][$language]) ? self::$cache[$fileKey][$language] : array();
	}



	/**
	 * Get a label from internal cache. If the label is not available, load it
	 *
	 * @param	String		$fileKey		Filekey
	 * @param	String		$index			Index of the label in the file
	 * @param	String		$language		Language to load the label
	 * @return	String		The label with the key $index for $language
	 */
	private static function getCachedLabel($fileKey, $index, $language = 'en') {
		if( ! isset(self::$cache[$fileKey][$language][$index]) || is_null(self::$cache[$fileKey][$language][$index]) ) {
			self::loadFileLabels($fileKey, $language);
		}

		return self::$cache[$fileKey][$language][$index];
	}



	/**
	 * Get path of the file which is registered for a file key
	 *
	 * @param	String		$fileKey
	 * @return	String		Abs. path to file
	 */
	private static function getFilePath($fileKey) {
		return self::$files[$fileKey];
	}



	/**
	 * Load labels of a file for $language
	 * Load translated labels into internal cache.
	 * If necessary create a new uptodate cache file.
	 * The following files are checked (by their modification times)
	 * - Registered locallang file (english and the locale)
	 * - External locallang file in english
	 * - External locallang file in language
	 *
	 * @param	String		$fileKey		Filekey
	 * @param	String		$language		Requested language
	 */
	private static function loadFileLabels($fileKey, $language = null) {
		$language = is_null($language) ? self::$language : $language;

		if( empty(self::$cache[$fileKey][$language]) ) {
				// Get file paths (files don't need to exist!)
			$origFile	= self::getFilePath($fileKey);
			$cacheFile	= self::getCacheFileName($fileKey, $language);
			$extFile	= self::getExternalFileName($fileKey, $language);
			$extFileEn	= self::getExternalFileName($fileKey, 'en');

				// Get file modification times
			$mTimeOrig	= is_file($origFile) ? filemtime($origFile) : 0;
			$mTimeCache	= is_file($cacheFile) ? filemtime($cacheFile) : 0;
			$mTimeExt	= is_file($extFile) ? filemtime($extFile) : 0;
			$mTimeExtEn	= is_file($extFileEn) ? filemtime($extFileEn) : 0;

				// If a file is newer than the cache, regenerate the cache from locallang XML files
			if( $mTimeCache < $mTimeOrig || $mTimeCache < $mTimeExt || $mTimeCache < $mTimeExtEn ) {
				$labelsOrig	= self::readLocallangFile($origFile);
				$labelsExt	= self::readLocallangFile($extFile);
				$labelsExtEn= self::readLocallangFile($extFileEn);

					// Load english labels with custom changes from ext file and override it with current language
				$baseLabelsEn	= self::mergeLabelArray($labelsOrig['en'], $labelsExtEn['en']);
				$baseLabels		= self::mergeLabelArray($baseLabelsEn, $labelsOrig[$language]);
				$finalLabels	= self::mergeLabelArray($baseLabels, $labelsExt[$language]);

				self::cacheStore($fileKey, $finalLabels, $language);
				self::setFileCache($fileKey, $language, $finalLabels);
			} else {
				$cachedLabels = self::cacheLoad($cacheFile);
				self::setFileCache($fileKey, $language, $cachedLabels);
			}
		}
	}



	/**
	 * Read a locallang XML file using a XML parser.
	 * Transforms the parser result in an usful array
	 * Structure [de][INDEX] = Label
	 *
	 * @param	String		$absPathToLocallangFile		Absolute path to locallang file
	 * @return	Array
	 */
	private static function readLocallangFile($absPathToLocallangFile) {
		if( !is_file($absPathToLocallangFile) ) {
			return array();
		}

		$xmlString	= file_get_contents($absPathToLocallangFile);
		$parser		= xml_parser_create('UTF-8');

		$values	= $index = array();

		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    	xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    	xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, 'UTF-8');

		xml_parse_into_struct($parser, $xmlString, $values, $index);

		xml_parser_free($parser);

		return self::transformXmlToLocallang($values);
	}



	/**
	 * Read external locallang file.
	 * External files are overriding changes on the original files stored in /l10n/
	 * under to specific langauge
	 *
	 * @param	String		$absPathToLocallangFile
	 * @param	String		$language
	 * @return	Array
	 */
	private static function readExternalLocallangFile($absPathToLocallangFile, $language) {
		$extFile	= self::getExternalFileName($absPathToLocallangFile, $language);

		return self::readLocallangFile($extFile);
	}



	/**
	 * Transform the output of the XML parser to an useful array
	 *
	 * @param	Array		$xmlValueArray
	 * @return	Array
	 */
	private static function transformXmlToLocallang(array $xmlValueArray) {
		$locallangArray = array();
		$languageKey	= 'none';

		foreach($xmlValueArray as $xmlTag) {
			switch($xmlTag['type']) {

				case 'open':
					if( $xmlTag['tag'] === 'labels' ) {
						$languageKey = $xmlTag['attributes']['lang'];
						$locallangArray[$languageKey] = array();
					}
					break;


				case 'close':
					// Nothing to do
					break;


				case 'complete':
					$index = $xmlTag['attributes']['index'];
					$locallangArray[$languageKey][$index] = $xmlTag['value'];
					break;
			}
		}

		return $locallangArray;
	}



	/**
	 * Save locallang array to cache
	 *
	 * @param	String		$absPathToLocallangFile
	 * @param	Array		$locallangArray
	 * @return	Boolean
	 */
	private static function cacheStore($fileKey, array $locallangArray, $language) {
		$cacheData	= serialize($locallangArray);
		$cacheFile	= self::getCacheFileName($fileKey, $language);

		TodoyuFileManager::makeDirDeep(dirname($cacheFile));

		return file_put_contents($cacheFile, $cacheData) !== false;
	}



	/**
	 * Load cache file and get back locallang array
	 *
	 * @param	String		$cacheFile
	 * @return	Array
	 */
	private static function cacheLoad($cacheFile) {
		if( is_file($cacheFile) ) {
			$cacheData	= file_get_contents($cacheFile);
			$locallang	= unserialize($cacheData);
		} else {
			$locallang	= array();
		}

		return $locallang;
	}



	/**
	 * Make cache file name. Based on the path to the XML file and its modification time
	 *
	 * @param	String		$absPathToLocallangFile
	 * @return	String
	 */
	private static function getCacheFileName($fileKey, $language) {
		return TodoyuFileManager::pathAbsolute(Todoyu::$CONFIG['LANGUAGE']['cacheDir'] . DIRECTORY_SEPARATOR . $fileKey . '-' . $language . '.' . Todoyu::$CONFIG['LANGUAGE']['cacheExt']);
	}



	/**
	 * Make the external file name. The external file doesn't need to exist
	 *
	 * @param	String		$fileKey
	 * @param	String		$language
	 * @return	String
	 */
	private static function getExternalFileName($fileKey, $language) {
		$absPath	= self::$files[$fileKey];
		$intPath	= str_replace(PATH . DIRECTORY_SEPARATOR, '', $absPath);
		$filename	= str_replace(DIRECTORY_SEPARATOR, '-', $intPath);

		return Todoyu::$CONFIG['LANGUAGE']['l10nDir'] . DIRECTORY_SEPARATOR . $language . DIRECTORY_SEPARATOR . $filename;
	}



	/**
	 * Merge label arrays. The second array will override the identical indexes
	 * of the first array if they exist
	 *
	 * @param	Array		$baseLabels
	 * @param	Array		$overrideLabels
	 * @return	Array
	 */
	private static function mergeLabelArray($baseLabels, $overrideLabels) {
		if( !is_array($baseLabels) ) {
			$baseLabels = array();
		}
		if( !is_array($overrideLabels) ) {
			$overrideLabels = array();
		}

		foreach($baseLabels as $index => $label) {
			if( array_key_exists($index, $overrideLabels) ) {
				$baseLabels[$index] = $overrideLabels[$index];
			}
		}

		return $baseLabels;
	}

}

?>