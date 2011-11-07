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
 * Hmf_Cart
 *
 * @package     Hmf
 * @category    Cart
 * @author      Ford AntiTrust
 * @link        http://www.fordantitrust.com
 *
 */

/**
 * @see Zend_Session
 */
require_once 'Zend/Session.php';

class Hmf_Cart {

	const DEFAULT_NAMESPACE = 'cart';

	private $storage;

    function Component_Cart() {

        try {

            $this->storage = new Zend_Session_Namespace(self::DEFAULT_NAMESPACE);

            if(!is_array($this->storage->cart)) {
            	$this->storage->cart = array();
            }
        } catch (Exception $e) {
            /**
             * Default Error Exception
             */
            print_r($e);
        }


    }

    function add($product_id, $qty) {

    	if(array_key_exists($product_id, $this->storage->cart)) {
    		$this->storage->cart[$product_id] += $qty;
    	} else {
    		$this->storage->cart[$product_id] = $qty;
    	}
    }

    function update($product_id, $qty) {

    	$this->storage->cart[$product_id] = $qty;
    }

    function deleteAll() {

    	$this->storage->cart = null;
    }
    function delete($product_id) {

    	unset($this->storage->cart[$product_id]);
    }
    function getItems() {

    	return $this->storage->cart;
    }
    function getSumQty() {

    	return array_sum($this->storage->cart);
    }
    function getQty($product_id) {

    	return (array_key_exists($product_id, $this->storage->cart) ? $this->storage->cart[$product_id] : 0 );
    }
    function numCart(){

        return count($this->storage->cart);
    }
}