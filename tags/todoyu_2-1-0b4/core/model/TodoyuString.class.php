<?php
/****************************************************************************
* todoyu is published under the BSD License:
* http://www.opensource.org/licenses/bsd-license.php
*
* Copyright (c) 2011, snowflake productions GmbH, Switzerland
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
 * String helper functions
 *
 * @package		Todoyu
 * @subpackage	Core
 */
class TodoyuString {

	/**
	 * Check if a string is utf-8 encoded
	 *
	 * @param	String		$stringToCheck
	 * @return	Boolean
	 */
	public static function isUTF8($stringToCheck) {
		return mb_detect_encoding($stringToCheck, 'UTF-16, UTF-8, ISO-8859-15, ISO-8859-1, ASCII') === 'UTF-8';
	}



	/**
	 * Convert a string to UTF-8 if necessary
	 *
	 * @param	String		$stringToConvert
	 * @return	String
	 */
	public static function convertToUTF8($stringToConvert, $from = 'UTF-16') {
		return iconv($from, 'UTF-8', $stringToConvert);
	}



	/**
	 * Get string as UTF-8 if it's not already
	 *
	 * @param	String		$string
	 * @return	String
	 */
	public static function getAsUtf8($string) {
		return self::isUTF8($string) ? $string : self::convertToUTF8($string);
	}



	/**
	 * Checking syntax of input email address
	 *
	 * @param	String		Input string to evaluate
	 * @return	Boolean		Returns true if the $email address (input string) is valid; Has a "@", domain name with at least one period and only allowed a-z characters.
	 */
	public static function isValidEmail($email) {
		$email = trim ($email);
		if( strstr($email,' ') ) {
			return false;
		}

		$regexp	= '#^[A-Za-z0-9\._-]+[@][A-Za-z0-9\._-]+[\.].[A-Za-z0-9]+$#';

		return preg_match($regexp, $email) === 1;
	}



	/**
	 * Crop a text to a specific length. If text is cropped, a postfix will be added (default: ...)
	 * Per default, words will not be split and the text will mostly be a little bit shorter
	 *
	 * @param	String		$text
	 * @param	Integer		$length
	 * @param	String		$postFix
	 * @param	Boolean		$dontSplitWords
	 * @return	String
	 */
	public static function crop($text, $length, $postFix = '...', $dontSplitWords = true) {
		$length	= intval($length);

		if( mb_strlen($text, 'utf-8') > $length ) {
			$cropped	= mb_substr($text, 0, $length, 'utf-8');
			$nextChar	= mb_substr($text, $length, 1, 'utf-8');

				// Go back to last word ending
			if( $dontSplitWords === true && $nextChar !== ' ' && mb_stristr($cropped, ' ', null, 'utf-8') !== false ) {
				$spacePos	= mb_strrpos($cropped, ' ', 0, 'utf-8');
				$cropped	= mb_substr($cropped, 0, $spacePos, 'utf-8');
			}
			$cropped .= $postFix;
		} else {
			$cropped = $text;
		}

		return $cropped;
	}



	/**
	 * Wrap string with given pipe-separated wrapper string, e.g. HTML tags
	 *
	 * @param	String	$string
	 * @param	String	$wrap			<tag>|</tag>
	 * @return	String
	 */
	public static function wrap($string, $wrap) {
		return str_replace('|', $string, $wrap);
	}



	/**
	 * Wrap content with a HTML tag
	 *
	 * @param	String		$tag
	 * @param	String		$content
	 * @return	String
	 */
	public static function wrapWithTag($tag, $content) {
		return self::wrap($content, '<' . $tag . '>|</' . $tag . '>');
	}



	/**
	 * Split a camel case formatted string into its words
	 *
	 * @param	String		$string
	 * @return	Array
	 */
	public static function splitCamelCase($string) {
		return preg_split('/([A-Z][^A-Z]*)/', $string, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
	}



	/**
	 * Convert an HTML snippet into plain text. Removes html - tags from snippet
	 *
	 * @param	String		$html		HTML snippet
	 * @return	String		Text version
	 */
	public static function html2text($html, $br2Newline = false, $decodeChars = false) {
		$text	= htmlspecialchars_decode($html);

		$text	= $br2Newline ? self::br2nl($text) : $text;
		$text	= strip_tags($text);

		if( $decodeChars === true ) {
			$charSet= TodoyuString::isUTF8($text) ? 'UTF-8' : 'ISO-8859-1';
			$text	= html_entity_decode($text, ENT_COMPAT, $charSet);
		}

		return $text;
	}



	/**
	 * Converts an HTML snippet into plain text.
	 * 	- decodes html-entities & special chars
	 *
	 * @param	String		$string
	 * @param	Boolean		$closingPTagsToDoubleNewLine
	 * @return	String
	 */
	public static function strictHtml2text($string, $convertClosingPTagsToDoubleNewLine = true) {
		if( $convertClosingPTagsToDoubleNewLine === true ) {
			$string = str_replace('</p>', chr(10) . chr(10), $string);
		}

		return self::html2text(html_entity_decode(htmlspecialchars_decode(self::br2nl($string)), ENT_COMPAT, 'UTF-8'));
	}



	/**
	 * Replaces html-tag <br /> with newlines
	 *
	 * @param	String	$string
	 * @return	String
	 */
	public static function br2nl($string) {
		$breaks	= array(
			'<br />',
			'<br/>',
			'<br>',
			'<br >'
		);

		return str_ireplace($breaks, "\n", $string);
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
	public static function getSubstring($string, $keyword, $charsBefore = 20, $charsAfter = 20, $htmlEntities = true) {
		$charsBefore= intval($charsBefore);
		$charsAfter	= intval($charsAfter);
		$keyLen		= mb_strlen(trim($keyword));
		$pos		= mb_stripos($string, $keyword);
		$start		= TodoyuNumeric::intInRange($pos-$charsBefore, 0);
		$subLen		= $charsBefore + $keyLen + $charsAfter;

		if( $htmlEntities ) {
			$string	= html_entity_decode($string, ENT_QUOTES, 'UTF-8');
		}

		$string = mb_substr($string, $start, $subLen);

		if( $htmlEntities ) {
			$string = htmlentities($string, ENT_QUOTES, 'UTF-8', false);
		}

		return trim($string);
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
	 * Check if an element is in a separated list string (ex: comma separated)
	 *
	 * @param	String		$item				Element to check for
	 * @param	String		$listString			List with concatenated elements
	 * @param	String		$listSeparator		List element separating character
	 * @return	Boolean
	 */
	public static function isInList($item, $listString, $listSeparator = ',') {
		$list	= explode($listSeparator, $listString);

		return in_array($item, $list);
	}



	/**
	 * Remove duplicate entries from list
	 *
	 * @param	String	$listString
	 * @return	String
	 */
	public static function listUnique($listString, $listSeparator = ',') {
		$list = TodoyuArray::trimExplode($listSeparator, $listString);
		$list = array_unique($list);

		return implode($listSeparator, $list);
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
	public static function generatePassword($length = 8, $useUpperCase = true, $useNumbers = true, $useSpecialChars = true, $useDoubleChars = true) {
		$length		= intval($length);
		$characters	= range('a', 'z');

		if( $useUpperCase ) {
			$characters = array_merge($characters, range('A', 'Z'));
		}
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

		return $password;
	}



	/**
	 * @return String
	 */
	public static function generateGoodPassword() {
		$config		= Todoyu::$CONFIG['SETTINGS']['passwordStrength'];
		$validator	= new TodoyuPasswordValidator();

		do {
			$password = self::generatePassword( $config['minLength'],
												$config['hasUpperCase'],
												$config['hasNumbers'],
												$config['hasSpecialChars']);

		} while( $validator->validate($password) === false );

		return $password;
	}



	/**
	 * Format a file size in the GB/MB/KB/B and add label
	 *
	 * @param	Integer		$fileSize
	 * @param	Array		$labels			Custom label array (overrides the default labels
	 * @param	Boolean		$noLabel		Don't append label
	 * @return	String
	 */
	public static function formatSize($fileSize, array $labels = null, $noLabel = false) {
			// Have to use floatval instead of intval because of the max range of integer supports only for up to 2,5GB..
		$fileSize	= round(floatval($fileSize), 0);

		if( is_null($labels) ) {
			if( $noLabel === false ) {
				$labels = array(
					'gb'	=> Todoyu::Label('core.file.size.gb'),
					'mb'	=> Todoyu::Label('core.file.size.mb'),
					'kb'	=> Todoyu::Label('core.file.size.kb'),
					'b'		=> Todoyu::Label('core.file.size.b')
				);
			} else {
				$labels	= array();
			}
		}

			// Add applicable size label (GB / MB / KB / B)
		if( $fileSize > TodoyuNumeric::BYTES_GIGABYTE ) { 			// GB
			$size	= $fileSize / TodoyuNumeric::BYTES_GIGABYTE;
			$label	= $labels['gb'];
		} elseif( $fileSize > TodoyuNumeric::BYTES_MEGABYTE ) {		// MB
			$size	= $fileSize / TodoyuNumeric::BYTES_MEGABYTE;
			$label	= $labels['mb'];
		} elseif( $fileSize > TodoyuNumeric::BYTES_KILOBYTE ) {		// KB
			$size	= $fileSize / TodoyuNumeric::BYTES_KILOBYTE;
			$label	= $labels['kb'];
		} else {													// B
			$size	= $fileSize;
			$label	= $labels['b'];
		}

			// Show only a decimal when smaller then 10
		$dez	= $size >= 10 ? 0 : 1;
		$size	= round($size, $dez);

		return number_format($size, $dez, '.', '') . ( $noLabel ? '' : ' ' . $label);
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
	 * Build an URL with given parameters prefixed with todoyu path
	 *
	 * @param	Array		$params		Parameters as key=>value
	 * @param	String		$hash		Hash (#hash)
	 * @param	Boolean		$absolute	Absolute URL with host server
	 * @return	String
	 */
	public static function buildUrl(array $params = array(), $hash = '', $absolute = false) {
		$query		= rtrim(PATH_WEB, '/\\') . '/index.php';
		$queryParts	= array();

			// Add question mark if there are query parameters
		if( sizeof($params) > 0 ) {
			$query .= '?';
		}

			// Add all parameters encoded
		foreach($params as $name => $value) {
			$queryParts[] = $name . '=' . urlencode($value);
		}

			// Concatenate
		$query .= implode('&', $queryParts);

			// Add hash
		if( ! empty($hash) ) {
			$query .= '#' . $hash;
		}

			// Add absolute server URL
		if( $absolute ) {
			$query = SERVER_URL . $query;
		}

		return $query;
	}



	/**
	 * Get short md5 hash of a string
	 *
	 * @param	String		$string
	 * @return	String		10 characters MD5 hash value of the string
	 */
	public static function md5short($string) {
		return substr(md5($string), 0, 10);
	}



	/**
	 * Analyze version string and return array of contained sub versions and attributes
	 *
	 * @param	String		$versionString
	 * @return	Array		[major,minor,revision,status]
	 */
	public static function getVersionInfo($versionString) {
		$info			= array();

		if( strpos($versionString, '-') !== false ) {
			$temp	= explode('-', $versionString);
			$version= explode('.', $temp[0]);
			$status	= $temp[1];
		} else {
			$version= explode('.', $versionString);
			$status	= 'stable';
		}

		$info['full']		= $versionString;
		$info['major']		= intval($version[0]);
		$info['minor']		= intval($version[1]);
		$info['revision']	= intval($version[2]);
		$info['status']		= $status;

		return $info;
	}



	/**
	 * Explode string and trim the parts
	 * Alias of TodoyuArray::trimExplode()
	 *
	 * @see		TodoyuArray::trimExplode()
	 * @param	String		$delimiter
	 * @param	String		$string
	 * @param	Boolean		$removeEmptyValues
	 * @return	Array
	 */
	public static function trimExplode($delimiter, $string, $removeEmptyValues = false) {
		return TodoyuArray::trimExplode($delimiter, $string, $removeEmptyValues);
	}



	/**
	 * Extract the headers from a full HTTP response (including headers and content)
	 *
	 * @param	String		$responseContent
	 * @return	Array
	 */
	public static function extractHttpHeaders($responseContent) {
			// Split header and content
		list($headerString) = explode("\r\n\r\n", $responseContent);

		return self::extractHeadersFromString($headerString);
	}



	/**
	 * Extract header pairs from a HTTP header string
	 *
	 * @param	String		$headerString
	 * @return	Array		array
	 */
	public static function extractHeadersFromString($headerString) {
			// Split header pairs
		$headerPairs= explode("\r\n", $headerString);
		$headers	= array();

			// Add HTTP status as status key
		$headers['status']		= array_shift($headerPairs);
		$headers['statusCode']	= self::extractHttpStatusCode($headers['status']);

			// Add the rest of the header pairs
		foreach($headerPairs as $headerPair) {
			list($key, $value) = explode(':', $headerPair, 2);
			$headers[trim($key)] = trim($value);
		}

		return $headers;
	}



	/**
	 * Extract status code from http status header
	 *
	 * @param	String		$httpStatusHeader
	 * @return	Integer
	 */
	public static function extractHttpStatusCode($httpStatusHeader) {
		$parts	= explode(' ', $httpStatusHeader);

		return intval($parts[1]);
	}



	/**
	 * Find registered linkable elements in given text and substitutes them by HTML hyperlinks
	 *
	 * @param	String	$htmlContent
	 * @return	String
	 */
	public static function substituteLinkableElements($htmlContent) {
		$hooks	= TodoyuHookManager::getHooks('core', 'substituteLinkableElements');

		foreach($hooks as $funcRef) {
			if( TodoyuFunction::isFunctionReference($funcRef) ) {
				$htmlContent	= TodoyuFunction::callUserFunction($funcRef, $htmlContent);
			}
		}

		return $htmlContent;
	}



	/**
	 * Takes a clear text message, finds all URLs and substitutes them by HTML hyperlinks
	 *
	 * @param	String	$htmlContent	Message content
	 * @return	String
	 */
	public static function replaceUrlWithLink($htmlContent) {
				// Find full links with prefixed protocol
		$patternFull	= '/(^|[^"])((?:http|https|ftp|ftps):\/\/[-\w@:%+.~#?&;\/=\[\]]+)/';
		$replaceFull	= '\1<a href="\2" target="_blank">\2</a>';

			// Find links which are not prefixed with a protocol, use http
		$patternSimple	= '/(^|[> ])((?:[\w\.-]+)\.(?:[\w-]{2,})\.(?:[a-zA-Z-]{2,6})[-\w@:%+.~#?&;\/=\[\]]*)/';
		$replaceSimple	= '\1<a href="http://\2" target="_blank">\2</a>';

			// Find mailto links
		$patternEmail	= '/(^|["> ])((?:[\w-\.]+)@(?:[\w-\.]{2,})\.(?:\w{2,6}))/';
		$replaceEmail	= '\1<a href="mailto:\2">\2</a>';

			// Replace URLs
		$htmlContent	= preg_replace($patternFull, $replaceFull, $htmlContent);
		$htmlContent	= preg_replace($patternSimple, $replaceSimple, $htmlContent);
		$htmlContent	= preg_replace($patternEmail, $replaceEmail, $htmlContent);

		return $htmlContent;
	}



	/**
	 * Clean RTE text
	 *  - Remove empty paragraphs from the beginning
	 *  - Remove <pre> tags and add <br> tags for the newlines
	 *
	 * @param	String		$text
	 * @return	String
	 */
	public static function cleanRTEText($text) {
		if( substr($text, 0, 13) === '<p>&nbsp;</p>' ) {
			$text	= substr($text, 13);
		}

		if( strpos($text, '<pre>') !== false ) {
			$prePattern	= '/<pre>(.*?)<\/pre>/s';
			$text		= preg_replace_callback($prePattern, array(self,'callbackPreText'), $text);
			$text		= str_replace("\n", '', $text);
		}

		return trim($text);
	}



	/**
	 * Returns an HTML <a href="mailto:"> - tag
	 *
	 * @param	String	$emailAddress
	 * @param	String	$label
	 * @param	Boolean	$returnAsArray
	 * @param	String	$subject
	 * @param	String	$mailBody
	 * @param	String	$cc
	 * @param	String	$bcc
	 * @return	String
	 */
	public static function getMailtoTag($emailAddress, $label = '', $returnAsArray = false, $subject = '', $mailBody = '', $cc ='', $bcc = '') {
		$attributes	= array();
		$linkParts	= array();

		if( $subject ) {
			$linkParts[] = 'subject=' . urlencode($subject);
		}
		if( $mailBody ) {
			$linkParts[] = 'body=' . urlencode($mailBody);
		}
		if( $cc ) {
			$linkParts[] = 'cc=' . $cc;
		}
		if( $bcc ) {
			$linkParts[] = 'ccc=' . $bcc;
		}

		$attributes['href']	= 'mailto:' . $emailAddress . '?' . implode('&', $linkParts);

		if( $label === '' ) {
			$label = $emailAddress;
		}

		$aTag	= self::buildHtmlTag('a', $attributes, $label);

		if( $returnAsArray ) {
			return array(
				str_replace('</a>', '', $aTag),
				'</a>'
			);
		} else {
			return $aTag;
		}
	}



	/**
	 * Returns an HTML (anchor) link tag
	 *
	 * @param	String	$url
	 * @param	String	$label
	 * @return	String
	 */
	public static function getATag($url, $label, $target = '_blank') {
		$attributes	= array(
			'href'	=> $url,
			'target'=> $target
		);

		return self::buildHtmlTag('a', $attributes, $label);
	}



	/**
	 * Wrap given label with a todoyu-internal link if given ext is allowed to be used
	 *
	 * @param	String		$label
	 * @param	String		$extKey
	 * @param	Array		$params
	 * @param	String		$hash
	 * @param	String		$target
	 * @return	String
	 */
	public static function wrapTodoyuLink($label, $extKey, array $params, $hash = '', $target = '') {
		$allowed	= true;

			// Check extension's general right setting
		if( TodoyuRightsManager::checkIfRightExists($extKey, 'general:use') && ! Todoyu::allowed($extKey, 'general:use') ) {
			$allowed	= false;
		}

		if( $allowed ) {
			$params['ext']	= $extKey;
			$linkURL		= self::buildUrl($params, $hash);

			$label	= '<a href="' . $linkURL . '"' . ( $target != '' ? ' target="' . $target . '"' : '') . '>' . $label . '</a>';
		}

		return $label;
	}



	/**
	 * Returns an HTML - img tag
	 *
	 * @param	String		$src
	 * @param	Integer		width
	 * @param	Integer		$height
	 * @param	String		$altText
	 * @return	String
	 */
	public static function getImgTag($src, $width = 0, $height = 0, $altText = '') {
		$attributes	= array();
		$width		= intval($width);
		$height		= intval($height);
		$altText	= trim($altText);

		$attributes['src'] = $src;

		if( $width > 0 ) {
			$attributes['width']	= $width;
		}
		if( $height > 0 ) {
			$attributes['height']	= $height;
		}
		if( $altText !== '' ) {
			$attributes['alt']	= $altText;
		}

		return self::buildHtmlTag('img', $attributes);
	}



	/**
	 * Build a HTML tag with attributes
	 *
	 * @param	String		$tagName
	 * @param	Array		$attributes
	 * @return	String
	 */
	public static function buildHtmlTag($tagName, array $attributes = array(), $content = false) {
		$attr	= array();

		foreach($attributes as $name => $value) {
			$attr[]	= $name . '="' . $value . '"';
		}

		$attrList	= implode(' ', $attr);

		if( $content !== false ) {
			return '<' . $tagName . ' ' . $attrList . '>' . $content . '</' . $tagName . '>';
		} else {
			return '<' . $tagName . ' ' . $attrList . ' />';
		}
	}



	/**
	 * Callback for cleanRTEText
	 * Add <br> tags inside the <pre> tags
	 *
	 * @param	Array		$matches
	 * @return	String
	 */
	private static function callbackPreText(array $matches) {
		return nl2br(trim($matches[1]));
	}



	/**
	 * Replace quotes around string which contain a function
	 * Allows to add javascript functions in JSON encoded content
	 *
	 * Used code posted here:
	 * http://tipstank.com/2010/10/29/how-to-add-javascript-function-expression-and-php-json_encode/
	 *
	 * @param	String		$json
	 * @return	String
	 */
	public static function enableJsFunctionInJSON($json) {
		$pattern	= '/(?<=:)"function\((?:(?!}").)*}"/';
		$callback	= array('TodoyuString', 'escapeFunctionInJSON');

		return preg_replace_callback($pattern, $callback, $json);
	}



	/**
	 * Callback for enableJsFunctionInJSON to replace quotes around function expressions
	 *
	 * @param	String		$string
	 * @return	String
	 */
	private static function escapeFunctionInJSON($string) {
		return str_replace('\\"','\"',substr($string[0],1,-1));
	}



	/**
	 * Convert a variable to it's php string representation
	 *
	 * @param	Mixed		$var
	 * @return	String
	 */
	public static function toPhpCodeString($var) {
		if( is_bool($var) ) {
			return $var ? 'true' : 'false';
		} elseif( is_string($var) ) {
			return '\'' . $var . '\'';
		} elseif( is_numeric($var) ) {
			return $var;
		} elseif( is_array($var) ) {
			$tmp	= 'array(';
			$items	= array();
			foreach($var as $key => $value) {
				$items[$key] = self::toPhpCodeString($value);
			}
			foreach($items as $key => $preparedValue) {
				$items[$key] = self::toPhpCodeString($key) . '=>' . $preparedValue;
			}
			$tmp	.= implode(',', $items);
			$tmp	.= ')';

			return $tmp;
		} elseif( is_object($var) ) {
			return 'unserialize(stripslashes(\'' . addslashes(serialize($var))  . '\'))';
		} else {
			return '';
		}
	}



	/**
	 * Get duration as string
	 * Includes start and end date with hours
	 *
	 *
	 * @param	Array	$data
	 * @return	String
	 */
	public static function getRangeString($dateStart, $dateEnd, $withDuration = true) {
		$dateStart	= intval($dateStart);
		$dateEnd	= intval($dateEnd);
		$duration	= $dateEnd-$dateStart;
		$hours		= intval($duration/3600);
		$hoursMax	= 23;

			// Make day keys to detect multi day duration
		$dateKeyStart	= date('dmY', $dateStart);
		$dateKeyEnd		= date('dmY', $dateEnd);
		$isMultiDay		= $dateKeyStart !== $dateKeyEnd;

			// Set general data
		$data	= array(
			'dateStart'	=> $dateStart,
			'dateEnd'	=> $dateEnd,
			'multi'		=> $isMultiDay
		);

		if( $withDuration ) {
			$data['withDuration']	= $withDuration;
			$data['asDays']			= $hours >= $hoursMax;
			$data['hours']			= $hours;
			$data['duration']		= $duration;

						// Duration is over multiple days?
			if( $isMultiDay ) {
				$dayTimestamps	= TodoyuTime::getDayTimestampsInRange($dateStart, $dateEnd);

				$data['days']	= sizeof($dayTimestamps);
			}
		}

		$tmpl	= 'core/view/duration.tmpl';
		$string	= Todoyu::render($tmpl, $data);

		return str_replace(array("\n", "\t", "\r"), '', trim($string));
	}



	/**
	 * htmlentities with predefined config for todoyu
	 *
	 * @param	String		$string
	 * @return	String
	 */
	public static function htmlentities($string) {
		return htmlentities($string, ENT_QUOTES, 'UTF-8', false);
	}

}


?>