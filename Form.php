<?php
/**
 *
 * LICENSE
 *
 * This source file is subject to the GNU LGPL 2.1 license that is bundled
 * with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://creativecommons.org/licenses/LGPL/2.1
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to annop@thaicyberpoint.com so we can send you a copy immediately.
 *
 * @package	   Hoffman
 * @author     Ford AntiTrust
 * @since	   Version 2008
 * @license    GNU LGPL 2.1 http://creativecommons.org/licenses/LGPL/2.1
 * @filesource
 */


/**
 * Hmf_Form
 *
 * @package     Hmf
 * @category    Cart
 * @author      Ford AntiTrust
 * @link        http://www.fordantitrust.com
 *
 * @method string text() text(string $name, array $attributes)
 * @method string password() password(string $name, array $attributes)
 * @method string checkbox() checkbox(string $name, array $attributes)
 * @method string radio() radio(string $name, array $attributes)
 * @method string file() file(string $name, array $attributes)
 * @method string hidden() hidden(string $name, array $attributes)
 * @method string image() image(string $name, array $attributes)
 * @method string submit() submit(string $name, string $type, array $attributes)
 * @method string reset() reset(string $name, string $type, array $attributes)
 * @method string button() button(string $name, string $type, array $attributes)
 */

/**
 * @see Zend_Date
 */
require_once 'Zend/Date.php';


class Hmf_Form {

    const HTTP_METHOD_POST = 'post';

    const HTTP_METHOD_GET = 'get';

    /**
     * Name of form for scripting
     *
     * @var string
     */
    private $name;

    /**
     * HTTP method used to submit the form
     *
     *
     * @var self::HTTP_METHOD_POST | self::HTTP_METHOD_GET
     */
    private $method = self::HTTP_METHOD_GET;

    /**
     * URL for server-side form handler
     *
     * @var string
     */
    private $action;

    /**
     * HTML form options for drop-down form
     *
     * @var array
     */
    private $options = array();

    /**
     * HTML form value for all input form
     *
     * @var array
     */
    private $value = array();

    /**
     * HTML form attributies for all input form
     *
     * @var array
     */
    private $attributes = array();

    /**
     * Configuration for uploaded file(s) to server-side form handler
     * with convert the HTTP method from any method to POST method
     * and use 'enctype' with "multipart/form-data" only.
     *
     * @var bool
     */
    private $useFile = false;

    /**
     * List of String for filter string set to HTML attributes id
     *
     * Replace [ or ] to empty String
     *
     * @var array
     */
    private $listStringForTagIdFilter = array("[", "]");

    /**
     * Not use NOW selected in 'selectDateTime'
     *
     * @var boolean
     */
    private $notUseNowInSelectDateTime;

    /**
     * Initialize the object with name of form, HTTP method and URL server-side form handler
     *
     * @param string $name
     * @param string( "post" | "get" ) | self::HTTP_METHOD_GET | self::HTTP_METHOD_POST $method
     * @param string $url
     */
    function __construct($name = 'form', $method = self::HTTP_METHOD_POST, $url = NULL) {

        $this->setFormName($name)->actionMethod($method)->actionTo($url);

    }

    /**
     * Getting the name of form
     *
     * @return string
     */
    public function getFormName() {

        return $this->name;
    }

    /**
     * Setting the name of form
     *
     * @param string $name
     * @return Components_Form Provides a fluent interface
     */
    public function setFormName($name) {

        $this->name = $name;

        return $this;
    }

    /**
     * Setting the action URL server-side form handler.
     *
     * @param @param string( "post" | "get" ) | self::HTTP_METHOD_GET | self::HTTP_METHOD_POST $method
     * @return Components_Form Provides a fluent interface
     */
    public function actionMethod($method) {

        $this->method = in_array($method, array(self::HTTP_METHOD_POST, self::HTTP_METHOD_GET)) ? $method : self::HTTP_METHOD_POST;

        return $this;
    }

    /**
     * Setting the URL for server-side form handler
     *
     * @param string $url
     * @return Components_Form Provides a fluent interface
     */
    public function actionTo($url) {

        $this->urlAction = $url;

        return $this;
    }

    /**
     * Setting the HTTP method for uploaded the file to server-side form handler.
     *
     * @param bool $use
     * @return Components_Form Provides a fluent interface
     */
    public function useFile($use = true) {

        $this->useFile = is_bool($use) ? $use : true;

        return $this;
    }

    /**
     * Convert the PHP array to the HTML Attributes
     *
     * @param array $attributes
     */
    public function arrayToHtmlAttributes(array $attributes = array()) {

        $strOutput = null;

        foreach ($attributes as $key => $val)
            $strOutput .= $key . '="' . $val . '" ';

        return $strOutput;

    }

    /**
     * Assign the PHP array to HTML attributes "value" specified by associative key for input-name
     * and value of array for assign to data of HTML attributes "value".
     *
     * Example:
     *   Array (
     *       [input-name-1] => [HTML-attributes-value-1],
     *       ......
     *       [input-name-n] => [HTML-attributes-value-n]
     *   )
     *
     *
     * @param array $array input name and data of HTML attributes "value" pairs.
     * @return Components_Form Provides a fluent interface
     */
    public function assignValueFromArray(array $array) {

        foreach ($array as $key => $val)
            $this->assignValueTo($key, $val);

        return $this;
    }

    /**
     * Assign the HTML attributes "value" to specified input-name
     *
     * @param string $key input-name
     * @param string $val data of HTML attributes "value"
     * @return Components_Form Provides a fluent interface
     */
    public function assignValueTo($key, $val) {

        $this->value[$key] = $val;

        return $this;
    }

    /**
     * Getting the HTML attributes "value" from specified input-name
     *
     * @param string $key input-name
     * @return data of HTML attributes "value" or FALSE if input-name didn't set the data.
     */
    public function getAssignValueFrom($key) {

        if (array_key_exists($key, $this->value))
            return $this->value[$key];

        return null;
    }

    /**
     * Assign the 2 dimension array to all specified select-name with associative key
     * in the 1st dimension and the 2rd dimension is array for assign to "option" element
     * for append to "select" element specified by associative key for label and
     * value of array for assign to data of HTML attributes "value" in "option" element.
     *
     * Example:
     *   Array (
     *        [select-name-1] => Array ( [label] => [value], ... [label] => [value]),
     *        ......
     *        [select-name-n] => Array ( [label] => [value], ... [label] => [value])
     *   )
     *
     * @param array $options with 2 Dimension, assoc-key of 1st dim is select-name,
     * @return Components_Form Provides a fluent interface
     */
    public function assignOptionsFromArray(array $options) {

        foreach ($options as $key => $val)
            $this->assignItemsTo($key, $val);

        return $this;
    }

    /**
     * Assign the array to "option" element for append to "select" element
     * specified by select-name with associative key for label and value of array
     * for assign to data of HTML attributes "value" in "option" element.
     *
     * Example:
     *   Array (
     *        [label-1] => [value-1],
     *        ...
     *        [label-n] => [value-n]
     *   )
     *
     * @param string $key select-name
     * @param array $options assign to "option" elements and it matches with associative key for label and array value for attribute value pairs.
     * @return Components_Form Provides a fluent interface
     */
    public function assignOptionsTo($key, $options) {

        $this->options[$key] = $options;

        return $this;
    }

    /**
     * Getting the options from specified select-name
     *
     * @param string $key input-name
     * @return options or empty array if select-name didn't set the data.
     */
    public function getAssignOptionsFrom($key) {

        if (array_key_exists($key, $this->options))
            return $this->options[$key];

        return array();

    }

    /**
     * Assign the array contained the HTML attributes pairs to specified input-name
     *
     * $array attributes pairs example:
     *   Array (
     *       [html-attribute-name-1] => [attribute-value-1],
     *       ......
     *       [html-attribute-name-n] => [attribute-value-n]
     *   )
     *
     * @param stirng $key input-name
     * @param array $array attributes pairs
     * @return Components_Form Provides a fluent interface
     */
    public function assignAttrFromArray($key, array $array) {

        if (array_key_exists($key, $this->attributes))
            foreach ($array as $attr => $val)
                $this->assignAttrTo($key, $attr, $val);

        return $this;
    }

    /**
     * Assign the HTML attributes to specified input-name
     *
     * @param string $key input-name
     * @param string $attr attribute-name
     * @param string $val  attribute-value
     * @return Components_Form Provides a fluent interface
     */
    public function assignAttrTo($key, $attr, $val) {

        $this->attributes[$key][$attr] = $val;

        return $this;
    }

    /**
     * Getting the HTML attributes or HTML attributes pairs from specified input-name
     *
     * @param string $key input-name
     * @param string $attr attribute-name
     * @return array HTML attributes data or empty array if input-name didn't set the data.
     */
    public function getAssignAttrFrom($key, $attr = null) {

        if (is_null($attr)) {
            if (!(array_key_exists($key, $this->attributes) and is_array($this->attributes[$key])))
                return array();
            return $this->attributes[$key];
        } elseif (array_key_exists($key, $this->attributes) and array_key_exists($attr, $this->attributes[$key])) {
            return $this->attributes[$key][$attr];
        }

        return array();

    }

    /**
     * Begin FORM element
     *
     * @param array $attributes HTML attributes pairs
     */
    public function begin(array $attributes = array ( )) {

        $attributes = array_merge($attributes, array('name' => $this->getFormName(), 'id' => $this->_filterTextTagId($this->getFormName()), 'method' => $this->method, 'action' => $this->urlAction));

        if ($this->useFile)
            $attributes = array_merge($attributes, array('enctype' => "multipart/form-data", 'method' => self::HTTP_METHOD_POST));

        return '<form ' . $this->arrayToHtmlAttributes(array_merge($this->getAssignAttrFrom($this->getFormName()), $attributes)) . ">\r\n";

    }

    /**
     * End FROM element
     */
    public function end() {

        return "</form>\r\n";
    }

    /**
     * Handled the Magic Method text, password, checkbox, radio, file, hidden, image, submit, reset, button for created the HTML INPUT elements
     *
     * @method [input]($name, $type = "text", array $attributes = array ( ))
     * @method [button]($name, $text = null, $type = 'button', array $attributes = array ( ))
     *
     * @see Hmf_Components::__call()
     * @see Components_Form::_input($name, $type = "text", array $attributes = array ( ))
     * @see Components_Form::_button($name, $text = null, $type = 'button', array $attributes = array ( ))
     * @param string $method The method name being called
     * @param array $args The arguments passed to the call
     * @return string|call to parent method
     */
    public function __call($method, $args) {

        if (in_array($method, array("text", "password", "checkbox", "radio", "file", "hidden", "image"))) {

            if (!isset($args[1]))
                $args[1] = array();

            return $this->_input($args[0], $method, $args[1]);

        } elseif (in_array($method, array("submit", "reset", "button"))) {

            if (!isset($args[2]))
                $args[2] = array();

            return $this->_botton($args[0], $args[1], $method, $args[2]);

        }

        //return parent::__call($method, $args);
    }

    /**
     * Filter string set to HTML attributes id
     *
     * Replace [ or ] to empty String
     *
     * @param string $name
     * @return string
     */
    private function _filterTextTagId($name) {

        return $this->getFormName() . '-' . str_ireplace($this->listStringForTagIdFilter, "", $name);
    }

    /**
     * HTML INPUTE element with SUBMIT, RESET or BUTTON in TYPE attribute
     *
     * @param string $name botton-name
     * @param string $text HTML attributes "value"
     * @param string $type [submit|reset|button]
     * @param array $attributes HTML attributes pairs
     */
    private function _botton($name, $text = null, $type = 'button', array $attributes = array ( )) {

        $type = in_array($type, array('submit', 'reset', 'button')) ? $type : 'button';

        $this->assignValueTo($name, is_null($text) ? $type : $text);

        return $this->_input($name, $type, array_merge($this->getAssignAttrFrom($name), $attributes));

    }

    /**
     * HTML INPUT element
     *
     * @param string $name input-name
     * @param string $type [text|password|checkbox|radio|submit|reset|file|hidden|image|button]
     * @param String $attributes HTML attributes pairs
     */
    private function _input($name, $type = "text", array $attributes = array ( )) {

        $type = in_array($type, array("text", "password", "checkbox", "radio", "submit", "reset", "file", "hidden", "image", "button")) ? $type : "text";

        if (mb_strlen($this->getAssignValueFrom($name)) > 0) {
            if (strcmp($type, 'checkbox') == 0 ) {
                $attributes = array_merge($attributes, array('checked' => 'checked'));
            } elseif (strcmp($type, 'radio') == 0) {
                if($this->getAssignValueFrom($name) == $attributes['value'])
                    $attributes = array_merge($attributes, array('checked' => 'checked'));
            } else {
                $attributes = array_merge($attributes, array('value' => $this->getAssignValueFrom($name)));
            }
        }

        if (strcmp($type, 'file') == 0) {
            $name = $name . "[]";
        }

		if (array_key_exists('id', $attributes)) {
			$id = $attributes['id'];
		} else {
			$id = $this->_filterTextTagId($name);
		}

        $attributes = array_merge($attributes, array('name' => $name, 'id' => $id, 'type' => $type));

        return '<input ' . $this->arrayToHtmlAttributes(array_merge($this->getAssignAttrFrom($name), $attributes)) . "/>".PHP_EOL;

    }

    /**
     * HTML TEXTAREA element
     *
     * @param string $name input-name
     * @param interger $rows
     * @param interger $cols
     * @param array $attributes HTML attributes pairs
     */
    public function textarea($name, $rows = 10, $cols = 20, array $attributes = array ( )) {

        if (array_key_exists('id', $attributes)) {
            $id = $attributes['id'];
        } else {
            $id = $this->_filterTextTagId($name);
        }

        $attributes = array_merge($attributes, array('name' => $name, 'id' => $id, 'rows' => $rows, 'cols' => $cols));

        return '<textarea ' . $this->arrayToHtmlAttributes(array_merge($this->getAssignAttrFrom($name), $attributes)) . '>' . $this->getAssignValueFrom($name) . "</textarea>\r\n";

    }

    /**
     * HTML OPTION with filter OPTGROUP element
     *
     * @param array $options matches with associative key for label and array value for attribute value pairs.
     * @param string $selected the value for selected in the options list
     */
    private function option(array $options = array(), $selected = null) {

        $strOutput = null;

        if (count($options) > 0) {
            foreach ($options as $optionKey => $optionVal) {
                if (is_array($optionVal)) {
                    $strOutput .= '<optgroup label="' . $optionKey . '">' . PHP_EOL;
                    foreach ($optionVal as $optionValKey => $optionValVal)
                        $strOutput .= $this->_option($optionValKey, $optionValVal, $selected);
                    $strOutput .= "</optgroup>".PHP_EOL;
                } else {
                    $strOutput .= $this->_option($optionKey, $optionVal, $selected);
                }
            }
        }

        return $strOutput;

    }

    /**
     * HTML OPTION element
     *
     * @param mixed $value
     * @param mixed $label
     * @param mixed $selected
     * @return string
     */
    private function _option($value, $label, $selected) {

        $attributes = array('value' => $value);

        if ($value == $selected)
            $attributes = array_merge($attributes, array('selected' => 'seleted'));

        return '<option ' . $this->arrayToHtmlAttributes($attributes) . '>' . $label . "</option>\r\n";

    }

    /**
     * HTML SELECT element
     *
     * @param string $name input-name
     * @param array $options assign to "option" elements and it matches with associative key for label and array value for attribute value pairs.
     * @param string $selected the value for selected in the options list
     * @param array $attributes HTML attributes pairs
     */
    public function select($name, array $options = array(), $selected = null, array $attributes = array()) {

        $strOutput = null;

        if (count($options) == 0)
            $options = $this->getAssignOptionsFrom($name);

		if (array_key_exists('id', $attributes)) {
			$id = $attributes['id'];
		} else {
			$id = $this->_filterTextTagId($name);
		}

        $attributes = array_merge($attributes, array('name' => $name, 'id' => $id));

        $strOutput .= '<select ' . $this->arrayToHtmlAttributes(array_merge($this->getAssignAttrFrom($name), $attributes)) . ">".PHP_EOL;

        if (mb_strlen($this->getAssignValueFrom($name)) > 0) {
            $selected = $this->getAssignValueFrom($name);
        } elseif (is_null($selected)) {
            $selected = '';
            $options = array('' => $this->_t('Selected')) + $options;
        }

        $strOutput .= $this->option($options, $selected);

        $strOutput .= "</select>".PHP_EOL;

        return $strOutput;

    }

    /**
     * Not use NOW selected in 'selectDateTime'
     *
     */
    public function notUseNowInSelectDateTime() {

        $this->notUseNowInSelectDateTime = true;
    }

    /**
     * Select DateTime
     *
     * @param string $name input-name
     * @param string $use [date|time, datetime]
     * @param array $yearStartAndEndFromNow array ('start'=> 75, 'end'=> 25)
     */
    public function selectDateTime($name = 'datetime', $use = 'date', array $yearStartAndEndFromNow = array('start'=> 75, 'end'=> 25)) {

        $strOutput = null;

        // $selected array ('day'=>31, 'month'=>12, 'year'=> 2008, 'hour' => 23, 'minute'=>59)
        $selected = $this->getAssignValueFrom($name);
        $hasSelected = array();
        if (!is_array($selected)) {
            $selected = array();
        }

        $locale = new Zend_Locale('en_US');

        $date = Zend_Date::now($locale);

        $selectedMappig = array(
            'day'    => 'setDay',
            'month'  => 'setMonth',
            'year'   => 'setYear',
            'hour'   => 'setHour',
            'minute' => 'setMinute'
        );

        foreach($selectedMappig as $key => $method) {
            if (array_key_exists($key, $selected)) {
                if(empty($selected[$key])) {
                    $hasSelected[$key] = false;
                } else {
                    $date->$method($selected[$key]);
                    $hasSelected[$key] = true;
                }
            }
        }


        $now = array('day' => null, 'month' => null, 'year' => null, 'hour' => null, 'minute' => null);
        // Show Date
        if (in_array($use, array('datetime', 'date', 'day-month', 'month-year', 'month', 'year', 'day'))) {

            $dayRange = $this->range(1 ,31 ,1 ,2);

            $year = $date->get(Zend_Date::YEAR);
            $yearRange = $this->range($year - $yearStartAndEndFromNow['start'], $year + $yearStartAndEndFromNow['end'], 1, 2);

            $useDay = in_array($use, array('day-month', 'day', 'datetime', 'date'));
            $useMonth = in_array($use, array('day-month', 'month', 'datetime', 'date'));
            $useYear = in_array($use, array('month-year', 'year', 'datetime', 'date'));

            if(!$this->notUseNowInSelectDateTime or $hasSelected['day']) {
                $now['day'] = $date->get(Zend_Date::DAY_SHORT);
            }
            if(!$this->notUseNowInSelectDateTime or $hasSelected['month']) {
                $now['month'] = $date->get(Zend_Date::MONTH_SHORT);
            }
            if(!$this->notUseNowInSelectDateTime or $hasSelected['year']) {
                $now['year'] = $year;
            }

            if($useDay) {
                $strOutput .= $this->select($name . '[day]', array_combine($dayRange, $dayRange), $now['day']);
                $hasDay = true;
            }

            if($useMonth) {
                if($hasDay)
                    $strOutput .= ' ';
                $strOutput .= $this->select($name . '[month]', $locale->getTranslationList('Month', $locale), $now['month']);
                $hasMonth = true;
            }

            if($useYear) {
                if($hasMonth)
                    $strOutput .= ' ';
                $strOutput .= $this->select($name . '[year]', array_combine($yearRange, $yearRange), $now['year']);
            }
        }

        // Show Time
        if (in_array($use, array('datetime', 'time'))) {

            if(!$this->notUseNowInSelectDateTime or $hasSelected['hour']) {
                $now['hour'] = $date->get(Zend_Date::HOUR_SHORT);
            }

            if(!$this->notUseNowInSelectDateTime or $hasSelected['minute']) {
                $now['minute'] = $date->get(Zend_Date::MINUTE_SHORT);
            }

            $strOutput .= "&nbsp;";
            $strOutput .= $this->select($name . '[hour]', $this->range(0, 23, 1 ,2), $now['hour']);
            $strOutput .= ' : ';
            $strOutput .= $this->select($name . '[minute]', $this->range(0, 59, 1, 2), $now['minute']);
        }

        return $strOutput;

    }

    function range($num1, $num2, $step=1, $leading_zero = 1) {

        for($i = $num1; $i <= $num2; $i += $step) {
            $temp[] = sprintf( '%0'.$leading_zero.'d', $i);
        }

        return $temp;
    }

    public function _t($text) {

        return ($text);
    }
}