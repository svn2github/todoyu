<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 snowflake productions gmbh
*  All rights reserved
*
*  This script is part of the todoyu project.
*  The todoyu project is free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License, version 2,
*  (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html) as published by
*  the Free Software Foundation;
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * Various useful functions
 *
 * @package		Todoyu
 * @subpackage	Core
 */

class TodoyuDiv {
	
	/**
	 * Mcrypt instance
	 *
	 * @var	Object
	 */
	private static $mcrypt = null;
	
	

	/**
	 * Extract a single field from a array
	 *
	 * @param	Array		$array
	 * @param	String		$columnName
	 * @return	Array
	 */
	public static function getColumnFromArray(&$array, $columnName) {
		$column = array();

		foreach($array as $subArray) {
			$column[] = $subArray[$columnName];
		}

		return $column;
	}



	/**
	 * Convert all array values to integers. This means all 'non-integer' will be 0
	 * If $onlyPositive is true, all negative integers will be zero too
	 * If $onlyPositive and $removeZeros are true, new array will contain only positive integers
	 *
	 * @param	Array		$array			Dirty array
	 * @param	Boolean		$onlyPositive	Set negative values zero
	 * @param	Boolean		$removeZeros	Remove all zero values
	 * @return	Array		Integer array
	 */
	public static function intvalArray($array, $onlyPositive = false, $removeZeros = true) {
		if( ! is_array($array) ) {
			return array();
		}

			// Make integers
		foreach($array as $index => $value) {
			$array[$index] = intval($value);
		}

			// Set negative values zero
		if( $onlyPositive ) {
			foreach($array as $index => $value) {
				if( $value <= 0 ) {
					$array[$index] = 0;
				}
			}
		}

			// Remove zeros
		if( $removeZeros ) {
			$newArray = array();
			foreach($array as $value) {
				if( $value > 0 ) {
					$newArray[] = $value;
				}
			}
			$array = $newArray;
		}

		return $array;
	}



	/**
	 * Rename key of an array, defined by mapping array. Only mapped keys will be in the reformed array
	 *
	 * @param	Array		$array
	 * @param	Array		$reformConfig		[old=>new,old=>new]
	 * @return	Array
	 */
	public static function reformArray(array $array, array $reformConfig, $copyAllData = false) {
		$reformedArray	= array();

		foreach($array as $item) {
			$tempItem = $copyAllData ? $item : array();
			foreach($reformConfig as $oldKey => $newKey) {
				$tempItem[$newKey] = $item[$oldKey];
			}
			$reformedArray[] = $tempItem;
		}

		return $reformedArray;
	}



	/**
	 * Use logical AND conjunction upon (intersect) given sub arrays.
	 *
	 * @param	Array		$array
	 * @return	Array
	 */
	public static function intersectSubArrays(array $array) {
		if( sizeof($array) === 1 ) {
			return array_shift($array);
		} else {
			return call_user_func_array('array_intersect', $array);
		}
	}



	/**
	 * Use logical OR conjunction upon (merge) given sub array.
	 *
	 * @param	Array		$array
	 * @return	Array
	 */
	public static function mergeSubArrays(array $array) {
		if( sizeof($array) === 1 ) {
			return array_shift($array);
		} else {
			return call_user_func_array('array_merge', $array);
		}
	}



	/**
	 * Merge multiple arrays and return a unique array
	 * Combination of array_merge and array_unique
	 *
	 * @param	Array		Multiple array arguments like array_merge
	 * @return	Array
	 */
	public static function arrayMergeUnique() {
		$funcArgs	= func_get_args();
		$merged		= call_user_func_array('array_merge', $funcArgs);

		return array_unique($merged);
	}



	/**
	 * Stripslashes on all array values and subarrays
	 *
	 * @param	Array		$array
	 * @return	Array
	 */
	public static function arrayStripslashes(array $array) {
		foreach($array as $key => $value) {
			if( is_array($value) ) {
				$array[$key] = self::arrayStripslashes($value);
			} else {
				$array[$key] = stripslashes($value);
			}
		}

		return $array;
	}



	/**
	 * Remove array entries by their value
	 *
	 * @param	Array		$array
	 * @param	Array		$valuesToRemove
	 * @param	Boolean		$reindex
	 * @return	Array
	 */
	public static function arrayRemoveByValue(array $array, array $valuesToRemove, $reindex = true) {
		$array = array_diff($array, $valuesToRemove);

		if( $reindex ) {
			$array = array_merge($array);
		}

		return $array;
	}



	/**
	 * Sort an array by a specified label. Allows advanced sorting configuration
	 *
	 * @param	Array		$unsortedArray			Original array
	 * @param	String		$sortByLabel			Labelkey to sort by
	 * @param	Boolean		$reversed				Reverse order
	 * @param	Boolean		$caseSensitive			Sort case sensitive. Lower case string are sorted as extra group at the end
	 * @param	Boolean		$useNaturalSorting		Sort as a human would do. Ex: Image1, Image2, Image 10, Image20
	 * @param	Integer		$sortingFlag			Flag for normal (not natural) sorting. Use constants: SORT_NUMERIC, SORT_STRING, SORT_LOCALE_STRING
	 * @return	Array		Sorted array
	 */
	public static function sortArrayByLabel($unsortedArray, $sortByLabel = 'position', $reversed = false, $caseSensitive = false, $useNaturalSorting = true, $sortingFlag = SORT_REGULAR, $avoidDuplicateFieldKey = '') {
			// Use the labels as key
			// Prevent overwriting double labels
		$labelKeyArray		= array();
		$conflictCounter	= 0;

		foreach($unsortedArray as $index => $item) {
			$label	= $caseSensitive ? $item[$sortByLabel] : strtolower($item[$sortByLabel]);
			$key 	= array_key_exists($label, $labelKeyArray) ? $label . '-' . $conflictCounter++ : $label;

			$labelKeyArray[$key] 	= $item;
		}

			// If no natural sorting is needed, we can take the built-in functions
		if( $useNaturalSorting === false ) {
			if( $reversed ) {
				krsort($labelKeyArray, $sortingFlag);
			} else {
				ksort($labelKeyArray, $sortingFlag);
			}

				// Filter for duplicate field contents,  if requested
			if ($avoidDuplicateFieldKey != '') {
				$labelKeyArray = self::array_remove_duplicates($labelKeyArray, $avoidDuplicateFieldKey);
			}

			$sortedArray = array_values($labelKeyArray);
		} else {
				// Natural sorting
			$labels	= array_keys($labelKeyArray);
			natsort($labels);

				// Reverse keys if requested
			if( $reversed ) {
				$labels = array_reverse($labels);
			}

				// Load items in the new order into a new array
			$sortedArray = array();
			foreach($labels as $label) {
				$sortedArray[] = $labelKeyArray[$label];
			}
		}

		return $sortedArray;
	}



	/**
	 * Remove duplicate entries in given field of array
	 *
	 * @param	Array	$array
	 * @param	String	$key
	 * @return	Array
	 */
	public static function array_remove_duplicates($array, $key) {
		$vals	 		= array();
		$cleanedArray	= array();

			// iterate all ass. sub arrays
		foreach($array as $entryID => $entryData) {
			$value		= $entryData[ $key ];

			if (! in_array($value, $vals)) {
				$cleanedArray[ $entryID ]	= $entryData;
			}

			$vals[]	= $value;
		}

		return $cleanedArray;
	}



	/**
	 * Get a new array which contains only elements that match
	 * the filter. The fieldvalue has to be in the list of the filter item
	 *
	 * @example
	 *
	 * Only keep items which have a uid between 1 and 9 und have 352, 80, 440 or 240 pages
	 *
	 * $products 	= $this->getArray('*', 'tx_sfpshop_products');
	 * $filter 		= array('uid' 	=> array(1,2,3,4,5,6,7,8,9),
	 * 						'pages'	=> array(352,80,440,240));
	 * $filteredProducts = tx_sfp::arrayFilter($prodcuts, $filter);
	 *
	 *
	 * @param	Array		$dataArray			Array with the element which are checked against the filter
	 * @param	Array		$filterArray		The filter. It's elements are the fieldnames with the allowed values
	 * @param	Boolean		$matching			Normaly you'll get the matching elements. FALSE gives you the elements which don't match
	 * @param	Boolean		$preserveKeys		Keep the array keys. Else they will be replaced by numeric keys
	 * @return	Array		The filtered array
	 */
	public static function arrayFilter(array $dataArray, array $filterArray, $matching = true, $preserveKeys = false ) {
		$passed = array();

			// Check each item
		foreach($dataArray as $key => $itemArray) {
			$match = true;

				// Check if all filters success. Stop if one fails
			foreach($filterArray as $fieldname => $allowedValues) {
				if( !in_array($itemArray[$fieldname], $allowedValues) ) {
					$match = false;
					break;
				}
			}

				// Add to result if the matching is the same as requested
			if( $match === $matching ) {
				$passed[$key] = $itemArray;
			}
		}

		return $preserveKeys ? $passed : array_values($passed);
	}



	/**
	 * Prefix array value with a string. Postfix is also available
	 *
	 * @param	Array		$array
	 * @param	String		$prefix
	 * @param	String		$postfix
	 * @return	Array
	 */
	public static function prefixArray(array $array, $prefix = '', $postfix = '') {
		foreach($array as $index => $value) {
			$array[$index] = $prefix . $value . $postfix;
		}

		return $array;
	}



	/**
	 * Generate a random password. Customizeable
	 *
	 * @param	Integer		$length
	 * @param	Boolean		$useLowerCase
	 * @param	Boolean		$useNumbers
	 * @param	Boolean		$useSpecialChars
	 * @param	Boolean		$useDoubleChars
	 * @return	String
	 */
	public static function generatePassword($length = 8, $useLowerCase = false, $useNumbers = true, $useSpecialChars = false, $useDoubleChars = true) {
		$length		= intval($length);
		$characters	= array_merge(range('a', 'z'), range('A', 'Z'));

		if( $useNumbers ) {
			$characters = array_merge($characters, range('0', '9'));
		}
		if( $useSpecialChars ) {
			$characters = array_merge($characters, array('#','&','@','$','_','%','?','+','-'));
		}
		if( $useDoubleChars ) {
			shuffle($characters);
			$characters = array_merge($characters, $characters);
		}

			// Shuffle array
		shuffle($characters);
		$password = substr(implode('', $characters), 0, $length);

		if( $useLowerCase ) {
			$password = strtolower($password);
		}

		return $password;
	}



	/**
	 * Send php array (or any other data) JSON encoded to the client
	 * The output is sent UTF8 encoded and script stops
	 * after the output has been sent
	 *
	 * @param	Array		$phpData		Data to send encoded
	 * @param	Boolean		$stopScript		Abort the script after sending the content
	 */
	public static function sendAsJson($phpData, $stopScript = true) {
		header("Content-Type: application/json, charset=utf-8");

		echo json_encode($phpData);

		if( $stopScript ) {
			exit();
		}
	}


	/**
	 * Check if a string is utf-8 encoded
	 *
	 * @param	String		$stringToCheck
	 * @return	Boolean
	 */
	public static function isUTF8($stringToCheck) {
		return mb_detect_encoding($stringToCheck, 'UTF-8, ISO-8859-1') === 'UTF-8';
	}



	/**
	 * Convert a string to UTF-8 if necessary
	 *
	 * @param	String		$stringToConvert
	 * @return	String
	 */
	public static function convertToUTF8($stringToConvert) {
		return self::isUTF8($stringToConvert) ? $stringToConvert : utf8_encode($stringToConvert);
	}



	/**
	 * Convert each element of an array to utf-8
	 *
	 * @param	Array		$arrayToConvert
	 * @return	Array
	 */
	public static function convertToUTF8Array(array $arrayToConvert) {
		$convertedArray = array();

		foreach( $arrayToConvert as $key => $value ) {
			$convertedArray[$key] = self::convertToUTF8($value);
		}

		return $convertedArray;
	}



	/**
	 * Remove data if key matches with one in $keysToRemove
	 *
	 * @param	Array		$array					The array with the data
	 * @param	Array		$keysToRemove			Array which contains the key to remove. Ex: [userFunc,config,useless]
	 * @return	Array		Array which doesn't contain the specified keys
	 */
	public static function arrayRemoveKey($array, array $keysToRemove) {
		foreach($keysToRemove as $keyToRemove) {
			unset($array[$keyToRemove]);
		}

		return $array;
	}



	/**
	 * Make sure an integer is in a range. If the integer is out of range,
	 * set it to one of the boundaries
	 *
	 * @param	Integer		$integer
	 * @param	Integer		$min
	 * @param	Integer		$max
	 * @return	Integer
	 */
	public static function intInRange($integer, $min = 0, $max = 2000000000)	{
		$integer = intval($integer);

		if( $integer < $min ) {
			$integer = $min;
		}

		if( $integer > $max ) {
			$integer = $max;
		}

		return $integer;
	}



	/**
	 * Get the integer integer of a value
	 *
	 * @param	String		$value		A string or integer value
	 * @return	Integer		Integer equal or greater than 0
	 */
	public static function intPositive($value) {
		$integer = intval($value);

		if( $integer < 0 ) {
			$integer = 0;
		}

		return $integer;
	}

	/**
	 * Calculate percent
	 *
	 * @param	Integer	$numberOf
	 * @param	Intger	$totalNumberOf
	 * @return	Intger
	 */
	function percent($percent, $value)	{
		return $percent * ($value / 100.0);
    }



    /**
	 *	Calculate fraction (how many percent is the given value of the given total?)
	 *	@param	Integer	$fraction
	 *	@param	Integer	$total
	 *	@return Integer
	 */
	function fraction($fraction = 75, $total = 300) {
		if ($total > 0) {
			$rc = intval (($fraction/ $total) * 100);
		} else {
			TodoyuDebug::printHtml('error in fraction(...) - division by 0!');
		}

		return $rc;
	}



	/**
	 * Checking syntax of input email address
	 *
	 * @param	String		Input string to evaluate
	 * @return	Boolean		Returns true if the $email address (input string) is valid; Has a "@", domain name with at least one period and only allowed a-z characters.
	 */
	public static function validEmail($email)	{
		$email = trim ($email);
		if(strstr($email,' ')) {
			return false;
		}

		return ereg('^[A-Za-z0-9\._-]+[@][A-Za-z0-9\._-]+[\.].[A-Za-z0-9]+$', $email) ? true : false;
	}



	/**
	 * Explode a list of integers
	 *
	 * @param	String		$delimiter			Character to split the list
	 * @param	String		$string				The list
	 * @param	Boolean		$onlyPositive		Set negative values zero
	 * @param	Boolean		$removeZeros		Remove all zero values
	 * @return	Array
	 */
	public static function intExplode($delimiter, $string, $onlyPositive = false, $removeZeros = false) {
		$parts	= explode($delimiter, $string);

		return TodoyuDiv::intvalArray($parts, $onlyPositive, $removeZeros);
	}



	/**
	 * Explode a list and remove whitespaces around the values
	 *
	 * @param	String		$delimiter				Character to split the list
	 * @param	String		$string					The list
	 * @param	Boolean		$removeEmptyValues		Remove values which are empty afer trim()
	 * @return	Array
	 */
	public static function trimExplode($delimiter, $string, $removeEmptyValues = false) {
		$parts	= explode($delimiter, $string);
		$array	= array();

		foreach($parts as $value) {
			$value = trim($value);
			if( $value !== '' || $removeEmptyValues === false ) {
				$array[] = $value;
			}
		}

		return $array;
	}



	/**
	 * Implode array with given delimiter, force items to be integers
	 *
	 * @param	Array	$array
	 * @param	String	$delimiter
	 */
	public static function intImplode($array = array(), $delimiter = ',') {
		foreach($array as $id => $value) {
			$array[$id] = intval($value);
		}

		return implode($delimiter, $array);
	}



	/**
	 * Implode array wrap all entries into single quotes
	 *
	 * @param	Array	$array
	 * @param	String	$delimiter
	 * @return 	Array
	 */
	public static function implode_quoted( $array = array(), $delimiter = ',' ) {
		$items	= array();

		foreach($array as $item) {
			if ( $item[0] != '\'' && substr($item, -1, 1) != '\'' ) {
					// not single quoted yet, do it now
				$items[]	= '\'' . $item . '\'';
			} else {
				$items[] = $item;
			}
		}

		return implode($delimiter, $items);
	}



	/**
	 * Remove absolute site path from a path
	 *
	 * @param	String		$path
	 * @return	String
	 */
	public static function removeSitePath($path) {
		return str_replace(PATH, '', $path);
	}



	/**
	 * Insert an element into an associative array.
	 * The base array should have named keys. Insert position can be defined by $beforeItem.
	 * If an element with the specified key already exists, it will be replace, except if $replace is false.
	 *
	 * @param 	Array		$array			Base array to insert new item into
	 * @param	Mixed		$newArrayItem	New array item
	 * @param	String		$keyname		Keyname of the new array item
	 * @param	String		$beforeItem		Insert new item before this key. If no key specified, the new element will be appended
	 * @param	Boolean		$replace		Replace an existing element
	 * @return	Array		Array with new item inside
	 */

	public static function arrayInsertElement(array $array, $newArrayItem, $keyname, $beforeItem = false, $replace = true) {
		$arrayKeys	= array_flip(array_keys($array));
		$position	= $arrayKeys[$beforeItem];
		$exists		= array_key_exists($keyname, $array);

			// Stop here if key exists and replacing is disabled
		if( $exists === true && $replace === false ) {
			return $array;
		}

			// If no insert position defined or not found, append new item
		if( $beforeItem === false || $position === null ) {
			$array[$keyname] = $newArrayItem;
		} else {
				// Split array at insert position
			$itemsBefore= array_slice($array, 0, $position, true);
			$itemsAfter	= array_slice($array, $position, 1000, true);

				// Append new item to the first half
			$itemsBefore[$keyname] = $newArrayItem;

				// Concat both parts
			$array = array_merge($itemsBefore, $itemsAfter);
		}

		return $array;
	}



	/**
	 * Get keywords for autocomplete from a table
	 * Search all fields with like and key the full word parts
	 *
	 * @param	String		$searchWords		Space seperated keywords Ex: "snowflake productions zürich"
	 * @param	String		$table				Table name
	 * @param	String		$searchInFields		Comma seperated list of fields to search in
	 * @param	Integer		$numKeywords		Number of keywords in the result array
	 * @return	Array
	 * @todo	Move it to a database class or something else
	 */
	function getAutocompleteValues($searchWords, $table, $searchInFields, $numKeywords = 10) {
			// Get database result
		$elements	= $this->searchTable($table, $searchInFields, $searchWords, $searchInFields, '', '', '', '', 0, $numKeywords*5);

			// Make a big string
		$allWords	= '';
		foreach($elements as $element) {
			$allWords .= implode(' ', $element);
		}

			// Replace all whitespaces by single space
		$allWords = strtolower(preg_replace('|\W|', ' ', $allWords));

			// Search matching words
		$pattern	= '/([^ ]*' . $searchWords . '[^ ]*)/i';
		preg_match_all($pattern, $allWords, $matches);

			// Clean up
		$keywords	= array_map('trim', $matches[0]);
		$keywords	= array_unique($keywords);

		return array_slice($keywords, 0, $numKeywords);
	}



	/**
	 * Search a table for several keywords
	 *
	 * @param	String		$table
	 * @param	Array		$searchInFields
	 * @param	Array		$fulltextKeywords
	 * @param	String		$fieldsInResult
	 * @param	Array		$extraTables
	 * @param	String		$extraWhere
	 * @param	String		$groupBy
	 * @param	String		$orderBy
	 * @param	Integer		$limitOffset
	 * @param	Integer		$limitRows
	 * @return	Array
	 * @todo	Move it to a database class or something else
	 */
	public static function searchTable($table, array $searchInFields, array $searchWords, $fieldsInResult = '*', array $extraTables = array(), $extraWhere = '', $groupBy = '', $orderBy = '', $limitOffset = 0, $limitRows = 200) {

		// Compile selected fields
			// Prepend table name, if all fields are requested
		if( $fieldsInResult === '*' ) {
			$fieldsInResult = $table . '.*';
		} else {
				// Split fields and prepend table if not done yet
			$fields = TodoyuDiv::trimExplode(',', $fieldsInResult, true);
			foreach($fields as $key => $field) {
				if( strstr($field, '.') === false ) {
					$fields[$key] = $table . '.' . $field;
				}
			}
			$fieldsInResult = implode(', ', $fields);
		}

		$fields	= $fieldsInResult;
		$tables	= implode(', ', array_unique(array_merge($extraTables, array($table))));
		$where	= Todoyu::db()->buildLikeQuery($searchWords, $searchInFields);
		$limit	= TodoyuDiv::intPositive($limitOffset) . ',' . TodoyuDiv::intPositive($limitRows);


		if( $extraWhere != '' ) {
			$where .= ' ' . $extraWhere;
		}

		return Todoyu::db()->getArray($fields, $tables, $where, $groupBy, $orderBy, $limit);
	}



	/**
	 * Parse label if there is a label reference (LLL:)
	 * Else, just return the label
	 *
	 * @param	String		$label		Label or label reference
	 * @param	String		$locale		For output for this locale
	 * @return	String		Real label
	 */
	public static function getLabel($label, $locale = null) {
		if( ! is_string($label) ) {
			return '';
		} elseif( strncmp('LLL:', $label, 4) === 0 ) {
			$labelKey = substr($label, 4);
			return TodoyuLocale::getLabel($labelKey, $locale);
		} else {
			return $label;
		}
	}



	/**
	 * Convert a SimpleXmlElement structure to an associative array
	 * All objects are casted to array
	 *
	 * @param	SimpleXmlElement	$xml	XML object or array (which possibily contains XML objects)
	 * @return	Array
	 */
	public static function simpleXmlToArray($xml) {
		$array = (array)$xml;

		foreach($array as $index => $value) {
			if( $value instanceof SimpleXMLElement || is_array($value) ) {
				$array[$index] = TodoyuDiv::simpleXmlToArray($value);
			}
		}

		return $array;
	}



	/**
	 * Create multiple subdirectories to create a path structure in the filesystem
	 * The path will be a directory (don't give a file path as parameter!)
	 *
	 * @param	String		$directoryPath		Directory path to create
	 */
	public static function makeDirDeep($directoryPath) {
		TodoyuFileManager::makeDirDeep($directoryPath);
	}



	/**
	 * Get absolute file path
	 *
	 * @param	String	$path
	 * @return	String
	 */
	public static function pathAbsolute($path) {
		return TodoyuFileManager::pathAbsolute($path);
	}



	/**
	 * Get web path of a file
	 *
	 * @param	String		$absolutePath
	 * @return 	String
	 */

	public static function pathWeb($absolutePath) {
		return TodoyuFileManager::pathWeb($absolutePath);
	}
	
	
	public static function isAllowedTodoyuPath($path) {
		$path	= TodoyuFileManager::pathAbsolute($path);
		
		return stripos($path, PATH) === 0;
	}
	
	

	/**
	 * Crop a text to a specific length. If text is cropped, a postfix will be added (default: ...)
	 * Per default, words will not be splitted and the text will mostly be a little bit shorter
	 *
	 * @param	String		$text
	 * @param	Integer		$length
	 * @param	String		$postfix
	 * @param	Boolean		$dontSplitWords
	 * @return	String
	 */

	public static function cropText($text, $length, $postfix = '...', $dontSplitWords = true) {
		$text	= trim($text);
		$length	= intval($length);

		if( mb_strlen($text) > $length ) {
			$cropped	= mb_substr($text, 0, $length);
			$nextChar	= mb_substr($text, $length, 1);

			if( $dontSplitWords === true && $nextChar !== ' ' ) {
				$spacePos	= mb_strpos($cropped, ' ');
				$cropped	= mb_substr($cropped, 0, $spacePos);
			}

			$cropped .= $postfix;
		} else {
			$cropped = $text;
		}

		return $cropped;
	}



	/**
	 * Add an element to a separated list (ex: coma separated)
	 *
	 * @param	String		$list
	 * @param	String		$value
	 * @param	String		$separator
	 * @param	Boolean		$unique
	 * @return	String
	 */

	public static function addToList($list, $value, $separator = ',', $unique = false) {
		$items	= explode($separator, $list);
		$items[]= $value;

		if( $unique ) {
			$items = array_unique($items);
		}

		return implode($separator, $items);
	}



	/**
	 * Check if a file exists. Works also with not absolute paths
	 *
	 * @param	String		$path
	 * @return	Boolean
	 */

	public static function isFile($path) {
		return is_file( TodoyuDiv::pathAbsolute($path) );
	}



	/**
	 * Replace all not allowed characters of a filename by "_"
	 *
	 * @param	String		$dirtyFilename		Filename (not path!)
	 * @return	String
	 */

	public static function makeCleanFilename($dirtyFilename) {
		return TodoyuFileManager::makeCleanFilename($dirtyFilename, '_');
	}



	/**
	 * Format a filesize in the gb/mb/kb/b and add label
	 *
	 * @param	Integer		$filesize
	 * @param	Array		$labels			Custom label array (overrides the default labels
	 * @param	Boolean		$noLabel		Don't append label
	 * @return	String
	 */

	public static function formatSize($filesize, array $labels = null, $noLabel = false) {
		$filesize	= intval($filesize);

		if( is_null($labels) ) {
			if( $noLabel === false ) {
				$labels = array(
					'gb'	=> Label('assets.filesize.gb'),
					'mb'	=> Label('assets.filesize.mb'),
					'kb'	=> Label('assets.filesize.kb'),
					'b'		=> Label('assets.filesize.b')
				);
			} else {
				$labels	= array();
			}
		}

		if( $filesize > 1000000000 ) { 		// GB
			$size	= $filesize / (1024 * 1024 * 1024);
			$label	= $labels['gb'];
		} elseif( $filesize > 1000000 ) {
			$size	= $filesize / (1024 * 1024);
			$label	= $labels['mb'];
		} elseif( $filesize > 1000 ) {
			$size	= $filesize / 1024;
			$label	= $labels['kb'];
		} else {
			$size	= $filesize;
			$label	= $labels['b'];
		}

		$dez	= $size >= 10 ? 0 : 1;

		return number_format($size, $dez, '.', '') . ( $noLabel ? '' : ' ' . $label);
	}



	/**
	 * Read a file from harddisk and send it to the browser (with echo)
	 * Reads file in small parts (1024 B)
	 *
	 * @param	String		$absoluteFilePath
	 * @return	Boolean		File was allowed to download and sent to browser
	 */

	public static function sendFile($absoluteFilePath) {
		$absoluteFilePath	= realpath($absoluteFilePath);

		if( $absoluteFilePath !== false ) {
			if( is_readable($absoluteFilePath) ) {
				if( self::isFileInAllowedDownloadPath($absoluteFilePath) ) {
					$fp	= fopen($absoluteFilePath, 'rb');

					while($data = fread($fp, 1024)) {
						echo $data;
					}

					fclose($fp);

					return true;
				} else {
					Todoyu::log('Tried to download a file from a not allowed path', LOG_LEVEL_SECURITY, $absoluteFilePath);
				}
			}
		}

		return false;
	}



	/**
	 * Check if a file is in allowed download paths
	 * By default, no download path is allowed (except PATH_FILES)
	 * You can allow paths in $CONFIG['sendFile']['allow'] or disallow paths in $CONFIG['sendFile']['disallow']
	 * Disallow tasks precedence before allow
	 *
	 * @param	String		$absoluteFilePath		Absolute path to file
	 * @return	Boolean
	 */
	public static function isFileInAllowedDownloadPath($absoluteFilePath) {
		$absoluteFilePath	= realpath($absoluteFilePath);
		$disallowedPaths	= $GLOBALS['CONFIG']['sendFile']['disallow'];
		$allowedPaths		= $GLOBALS['CONFIG']['sendFile']['allow'];

			// If file exists
		if( $absoluteFilePath !== false ) {

				// Check if file is in an explicitly disallowed path
			if( is_array($disallowedPaths) ) {
				foreach($disallowedPaths as $disallowedPath) {
					if( strpos($absoluteFilePath, $disallowedPath) !== false ) {
						return false;
					}
				}
			}
				// Check if file is in an allowed path
			if( is_array($allowedPaths) ) {
				foreach($allowedPaths as $allowedPath) {
					if( strpos($absoluteFilePath, $allowedPath) !== false ) {
						return true;
					}
				}
			}
		}

			// If file not found, or no allowing config available, disallow download
		return false;
	}


	/**
	 * Wrap into JS tag
	 *
	 * @param	String	$jsCode
	 * @return	String
	 */
	public static function wrapScript($jsCode) {
		return '<script language="javascript" type="text/javascript">' . $jsCode . '</script>';
	}


	/**
	 * Short md5 hash of a string
	 *
	 * @param	String		$string
	 * @return	String		10 characters md5 hash value of the string
	 */
	public static function md5short($string) {
		return substr(md5($string), 0, 10);
	}



	/**
	 * Get a substring around a keyword
	 *
	 * @param	String		$string			The whole text
	 * @param	String		$keyword		Keyword to find in the text
	 * @param	Integer		$charsBefore	Characters included before the keyword
	 * @param	Integer		$charsAfter		Characters included after the keyword
	 * @return	String		Substring with keyword surrounded by the original text
	 */
	public static function getSubstring($string, $keyword, $charsBefore = 20, $charsAfter = 20) {
		$charsBefore= intval($charsBefore);
		$charsAfter	= intval($charsAfter);
		$keyLen		= strlen(trim($keyword));
		$pos		= stripos($string, $keyword);
		$start		= TodoyuDiv::intInRange($pos-$charsBefore, 0);
		$subLen		= $charsBefore + $keyLen + $charsAfter;

		return substr($string, $start, $subLen);
	}



	/**
	 * Call user function. Works the same as call_user_func(), but accepts also a
	 * string function reference like 'MyClass::myMethod'
	 * First argument is the function reference, all others are normal parameters passed to the function
	 *
	 * @param	String		$funcRef		Function reference
	 * @return	Mixed
	 */
	public static function callUserFunction($funcRef) {
		$funcArgs	= func_get_args();
		$funcRef	= array_shift($funcArgs);

		if( TodoyuDiv::isFunctionReference($funcRef) ) {
			$funcRef = explode('::', $funcRef);

			$result	= call_user_func_array($funcRef, $funcArgs);
		} else {
			$result = false;
		}

		return $result;
	}



	/**
	 * Call user function where parameters are stored in an array
	 * @see		callUserFunction()
	 * @see		call_user_func_array()
	 *
	 * @param	String		$funcRef
	 * @param	Array		$funcArgs
	 * @return	Mixed
	 */
	public static function callUserFunctionArray($funcRef, array $funcArgs) {
		if( TodoyuDiv::isFunctionReference($funcRef) ) {
			$funcRef = explode('::', $funcRef);

			$result	= call_user_func_array($funcRef, $funcArgs);
		} else {
			TodoyuDebug::printInFirebug($funcRef, 'Function not found');
			$result = false;
		}

		return $result;
	}



	/**
	 * Check if a function/method reference is valid
	 *
	 * @param	String		$funcRefString		Format: function or class::method
	 * @return	Boolean
	 */
	public static function isFunctionReference($funcRefString) {
		if( strpos($funcRefString, '::') === false ) {
			return function_exists($funcRefString);
		} else {
			$parts	= explode('::', $funcRefString);

			return method_exists($parts[0], $parts[1]);
		}
	}



	/**
	 * Checks if method exists, given as a string like the example below
	 *
	 * 	class::function
	 *
	 * (this is used in many defintion arrays)
	 *
	 * returns true if the class and the method exist. Else it returns false.
	 *
	 * @todo	Replace with isFunctionReference()
	 * @param	String	$theMethodString
	 * @return	Boolean
	 */
	public static function checkOnMethodString($theMethodString)	{
		list($class, $method) = explode('::', $theMethodString);

		if(class_exists($class))	{
			if(method_exists($class, $method))	{
				return true;
			}
		}

		return false;
	}



	/**
	 * Check if an element is in a seperated list string (ex: comma seperated)
	 *
	 * @param	String		$item				Element to check for
	 * @param	String		$listString			List with concatinated elements
	 * @param	String		$listSeperator		List element seperating character
	 * @return	Boolean
	 */
	public static function isInList($item, $listString, $listSeperator = ',')	{
		$list	= explode($listSeperator, $listString);

		return in_array($item, $list);
	}



	/**
	 * Get integer representation of version string
	 * Borrowed from typo3
	 *
	 * @param	String		$version
	 * @return	Integer
	 */
	public static function getIntVersion($version) {
	    if (!preg_match('/^(\d+)\.(\d+)\.(\d+)(?:(?:\.|-(rc|dev|beta|alpha))(\d+)?)?$/', $version, $matches)) {
	        return false;
	    }

	    	// Increase value for subversions
	    if( ! empty($matches[4]) ) {
			switch ($matches[4]) {
				case 'rc':
					$added = 30;
					break;


				case 'beta':
					$added = 20;
					break;


				case 'alpha':
					$added = 10;
					break;


				case 'dev':
					$added = 0;
					break;
			}
	    } else {
	    	$added = 50; // for final
	    }
	    	// Add version of subversion (ex: alpha3 = +3)
	    if( ! empty($matches[5]) ) {
	        $added = $added + $matches[5];
	    }

	    return $matches[1] * 1000000 + $matches[2] * 10000 + $matches[3] * 100 + $added;
	}



	/**
	 * Removes array entrie by its value
	 *
	 * @example
	 *
	 * $array = array(0 => 'foo', 1 => 'bar')
	 * $value = 'bar'
	 *
	 * $newArray = unsetArrayByValue($value, $array);
	 *
	 * $newArray -> array(0 => 'fo0')
	 *
	 *
	 * @param mixed $value
	 * @param array $array
	 * @return array
	 * @todo	review this function and its name!
	 */
	public static function unsetArrayEntrieByValue($value, array $array)	{
		if(in_array($value, $array))	{
			unset($array[array_search($value, $array)]);
		}

		return $array;
	}



	/**
	 * wraps string with given html tags
	 *
	 * <tag>|</tag>
	 *
	 * @param string $string
	 * @param string $wrap
	 * @return string
	 */
	public static function wrapString($string, $wrap)	{
		return str_replace('|', $string, $wrap);
	}
	
	
	
	/**
	 * Use a field value in an array as index of the array
	 *
	 * @param	Array		$array
	 * @param	String		$fieldname
	 * @return	Array
	 */
	public static function useFieldAsIndex(array $array, $fieldname) {
		$new = array();
		
		foreach($array as $index => $item) {
			$item['_oldIndex'] = $index;
			$new[$item[$fieldname]] = $item;
		}
		
		return $new;
	}
	
	
	
	/**
	 * Explode a string in camel case format
	 *
	 * @param	String		$camelCaseString
	 * @return	Array
	 */
	public static function explodeCamelCase($camelCaseString) {
		$spaced	= preg_replace( '/([a-z0-9])([A-Z])/', "$1 $2", $camelCaseString);
		
		return explode(' ', $spaced);	
	}
	
	
	
	/**
	 * Build an URL with given parameters prefixed with todoyu path
	 *
	 * @param	Array		$params
	 * @return	String
	 */
	public static function buildUrl(array $params) {
		$query		= PATH_WEB . '?';
		$queryParts	= array();
		
		foreach($params as $name => $value) {
			$queryParts[] = $name . '=' . urlencode($value);
		}

		$query .= implode('&', $queryParts);
		
		return $query;
	}
	
	
	
	/**
	 * Initialize mcypt
	 *
	 */
	private static function initMcrypt() {
		if( is_null(self::$mcrypt) ) {
				// Open module
			self::$mcrypt = mcrypt_module_open('tripledes', '', 'ecb', '');
				// Random seed
			$random = 596328;
				// Generate initialisation vector
			$vector	= mcrypt_create_iv(mcrypt_enc_get_iv_size(self::$mcrypt), $random);
				// Get the expected key size based on mode and cipher
			$expectedKeySize = mcrypt_enc_get_key_size(self::$mcrypt);
				// Get a key in the needed length (use typo3 key)
			$key = substr($GLOBALS['CONFIG']['SYSTEM']['encryptionKey'], 0, $expectedKeySize);
				// Initialize mcrypt library with mode/cipher, encryption key, and random initialization vector
			mcrypt_generic_init(self::$mcrypt, $key, $vector);
		}		
	}
	
	
	
	/**
	 * Encrypt element
	 *
	 * @param	Mixed		$input		String,Array,Object,... (will be serialized)
	 * @return	String
	 */
	public static function encrypt($input) {
		self::initMcrypt();
		
		$stringToEncrypt	= serialize($input);
		$encryptedString	= mcrypt_generic(self::$mcrypt, $stringToEncrypt);

		return base64_encode($encryptedString);
	}
	
	
	
	/**
	 * Decrypt string to element
	 *
	 * @param	String		$encryptedString
	 * @return	Mixed		With unserialize
	 */
	public static function decrypt($encryptedString) {
		self::initMcrypt();
		
		$encryptedString	= base64_decode($encryptedString);
		$decryptedString	= mdecrypt_generic(self::$mcrypt, $encryptedString);
		
		return unserialize($decryptedString);
	}
	
}


?>