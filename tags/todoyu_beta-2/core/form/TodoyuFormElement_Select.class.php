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
 * Select form element
 *
 * @package		Todoyu
 * @subpackage	Form
 */

class TodoyuFormElement_Select extends TodoyuFormElement {


	/**
	 * Initialize
	 *
	 * @param	String		$name
	 * @param	TodoyuFieldset	$fieldset
	 * @param	Array		$config
	 */
	public function __construct($name, TodoyuFieldset $fieldset, array $config = array()) {
		parent::__construct('select', $name, $fieldset, $config);

		if( ! $this->isLazyInit() ) {
			$this->initSource();
		}

		$this->setValue($this->getValue());
	}



	/**
	 * Init
	 *
	 */
	protected function init() {

	}



	/**
	 * Detect if lazy init is defined (grab data when form is rendered)
	 *
	 * @return	Boolean
	 */
	protected function isLazyInit() {
		return isset($this->config['source']['lazyInit']);
	}



	/**
	 * Initalize config with dynamic data
	 *
	 */
	protected function initSource() {
			// Load options (type defined how)
		if( is_array($this->config['source']) ) {
			$type	= $this->config['source']['@attributes']['type'];
			$source	= $this->config['source'];

			switch( $type ) {
				case 'list':
					$this->initSourceList($source);
					break;


				case 'function':
					$this->initSourceFunction($source);
					break;


				case 'sql':
					$this->initSourceSql($source);
					break;


				default:
					die('Unknown source tpye');
					break;
			}
		}

		if( $this->hasAttribute('multiple') ) {
			$this->setAttribute('multiple', 1);
		}
	}



	/**
	 * Load select options from database
	 *
	 * @param	Array		$source
	 */
	protected function initSourceSql(array $source) {
		$data	= Todoyu::db()->getArray(
			$source['fields'],
			$source['tables'],
			$source['where'],
			$source['group'],
			$source['order'],
			$source['limit']
		);

			// Key for label and value
		$valueKey	= $source['value'];
		$labelKey	= $source['label'];

			// Set flag
		$useValueFunc = false;
		$useLabelFunc = false;

		if( strstr($valueKey, '::') !== false ) {
			$valueFunc = explode('::', $valueKey);
			if( method_exists($valueFunc[0], $valueFunc[1]) ) {
				$useValueFunc = true;
			}
		}

		if( strstr($labelKey, '::') !== false ) {
			$labelFunc = explode('::', $labelKey);
			if( method_exists($labelFunc[0], $labelFunc[1]) ) {
				$useLabelFunc = true;
			}
		}

		foreach( $data as $option ) {
			$value	= $useValueFunc ? call_user_func($valueFunc, $this, $option) : $option[$valueKey];
			$label	= $useLabelFunc ? call_user_func($labelFunc, $this, $option) : $option[$labelKey];

			$this->addOption($value, $label);
		}
	}



	/**
	 * Init options from an XML list
	 *
	 * @param	Array		$source
	 */
	protected function initSourceList(array $source) {
		if( is_array($source['option']) ) {
			foreach($source['option'] as $option) {
				$this->addOption($option['value'], Label($option['label']), $option['selected'], $option['disabled']);
			}
		}
	}



	/**
	 * Init source function (evoke options gathering per user_func)
	 *
	 * @param	Array	$source
	 */
	protected function initSourceFunction( array $source ) {
		$funcRef	= explode('::', $source['function']);

		switch( sizeof($funcRef) ) {
				// funcRef is built like class::function
			case 2:
				$options	= call_user_func($funcRef, $this);
				foreach($options as $option) {
					$this->addOption($option['value'], $option['label']);
				}
				break;
				// funcRef is built like class::function::param, param is e.g the field ID
			case 3:
				Todoyu::log('Non standard 3 parts select source function: ' . $source['function'], LOG_LEVEL_NOTICE);
				$funcParam	= $funcRef[2];
				array_pop($funcRef);
				$options	= call_user_func($funcRef, $this, $funcParam);
				foreach($options as $option) {
					$this->addOption($option['value'], $option['label'], $option['selected'], $option['disabled'], $option['class']);
				}
				break;
		}
	}



	/**
	 * Get the index of the option by its value
	 *
	 * @param	String		$value
	 * @return	Integer		Or false if not found
	 */
	protected function getOptionIndexByValue($value) {
		$optionIndex = false;

		foreach( $this->config['options'] as $index => $option ) {
			if( $option['value'] == $value ) {
				$optionIndex = $index;
				break;
			}
		}

		return $optionIndex;
	}



	/**
	 * Get all options
	 *
	 * @return	Array
	 */
	public function getOptions() {
		return $this->get('options');
	}



	/**
	 * Add a new option at the end of the list
	 *
	 * @param	String		$value
	 * @param	String		$label
	 */
	public function addOption($value, $label, $selected = false, $disabled = false) {
		$this->config['options'][] = array(
			'value'		=> $value,
			'label'		=> TodoyuDiv::getLabel($label),
			'disabled'	=> $disabled,
		);

		if( $selected ) {
			$this->addSelectedValue($value);
		}
	}



	/**
	 * Set an option. The (first) option with the same value will be replace.
	 * If no option with this value exists, a new options will be added
	 *
	 * @param	String		$value
	 * @param	String		$label
	 */
	public function setOption($value, $label, $selected = false, $disabled = false) {
		$index = $this->getOptionIndexByValue($value);

		if( $index === false ) {
			$this->addOption($value);
		} else {
			$this->config['options'][$index] =  array(	'value'		=> $value,
														'label'		=> $label,
														'selected'	=> $selected,
														'disabled'	=> $disabled);
		}
	}



	/**
	 * Set selected values
	 * Should be an array, but can also be a single value
	 *
	 * @param	Mixed		$value
	 */
	public function setValue($value) {
		if( ! is_array($value) ) {
			$value = array($value);
		}

		parent::setValue($value);
	}



	/**
	 * Get selected option values as array
	 *
	 * @return	Array
	 */
	public function getValue() {
		$value	= parent::getValue();

		if( ! is_array($value) ) {
			$value = array($value);
		}

		return $value;
	}




	/**
	 * Add value to selected-values list
	 *
	 * @param	String		$value
	 */
	public function addSelectedValue($value) {
		$selected	= $this->getValue();

		$selected	= array_unique(array_push($selected, $value));

		$this->setValue($selected);
	}



	/**
	 * Get data for template rendering
	 *
	 * @return	Array
	 */
	protected function getData() {
		if( $this->isLazyInit() ) {
			$this->initSource();
		}

		return parent::getData();
	}



	/**
	 * Storage data. Comma seperated list if multiple values are selected
	 *
	 * @return	String
	 */
	public function getStorageData() {
		return implode(',', $this->getValue());
	}

}
?>