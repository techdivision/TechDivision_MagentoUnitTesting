<?php

/**
 * TechDivision_MagentoUnitTesting_MageProxy
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * Implements observer model functionality for extension.
 *
 * @category   TechDivision
 * @package    TechDivision_MagentoUnitTesting
 * @subpackage MageProxy
 * @copyright  Copyright (c) 1996-2014 TechDivision GmbH (http://www.techdivision.com)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version    ${release.version}
 * @since      Class available since Release 0.2.0beta
 * @author     Vadim Justus <v.justus@techdivision.com>
 */
class TechDivision_MagentoUnitTesting_MageProxy
{
    /**
     * Magento edition constants
     */
    const EDITION_COMMUNITY    = 'Community';
    const EDITION_ENTERPRISE   = 'Enterprise';
    const EDITION_PROFESSIONAL = 'Professional';
    const EDITION_GO           = 'Go';

    /**
     * @param string $key
     * @return Mage_Core_Model_Abstract
     */
    public function getSingleton($key)
    {
        return Mage::getSingleton($key);
    }

    /**
     * @return string
     */
    public function getEdition()
    {
        return Mage::getEdition();
    }

    /**
     * @param string $key
     * @return false|Mage_Core_Model_Abstract
     */
    public function getModel($key)
    {
        return Mage::getModel($key);
    }

    /**
     * @param mixed $message
     * @param null $level
     * @param string $file
     * @param bool $forceLog
     */
    public function log($message, $level = null, $file = '', $forceLog = false)
    {
        Mage::log($message, $level, $file, $forceLog);
    }

    /**
     * @param Exception $e
     */
    public function logException(Exception $e)
    {
        Mage::logException($e);
    }

    /**
     * @param string $name
     * @param array $data
     * @return \Mage_Core_Model_App
     */
    public function dispatchEvent($name, array $data = array())
    {
        return Mage::dispatchEvent($name, $data);
    }

    /**
     * @param string $name
     * @return Mage_Core_Helper_Abstract
     */
    public function helper($name)
    {
        return Mage::helper($name);
    }

    /**
     * Set all my static data to defaults
     *
     */
    public function reset()
    {
        Mage::reset();
    }

    /**
     * Register a new variable
     *
     * @param string $key
     * @param mixed $value
     * @param bool $graceful
     * @throws Mage_Core_Exception
     */
    public function register($key, $value, $graceful = false)
    {
        Mage::register($key, $value, $graceful);
    }

    /**
     * Unregister a variable from register by key
     *
     * @param string $key
     */
    public function unregister($key)
    {
        Mage::unregister($key);
    }

    /**
     * Retrieve a value from registry by a key
     *
     * @param string $key
     * @return mixed
     */
    public function registry($key)
    {
        return Mage::registry($key);
    }

    /**
     * Set application root absolute path
     *
     * @param string $appRoot
     * @throws Mage_Core_Exception
     */
    public function setRoot($appRoot = '')
    {
        Mage::setRoot($appRoot);
    }

    /**
     * Retrieve application root absolute path
     *
     * @return string
     */
    public function getRoot()
    {
        return Mage::getRoot();
    }

    /**
     * Retrieve Events Collection
     *
     * @return Varien_Event_Collection $collection
     */
    public function getEvents()
    {
        return Mage::getEvents();
    }

    /**
     * Varien Objects Cache
     *
     * @param string $key optional, if specified will load this key
     * @return Varien_Object_Cache
     */
    public function objects($key = null)
    {
        return Mage::objects($key);
    }

    /**
     * Retrieve application root absolute path
     *
     * @param string $type
     * @return string
     */
    public function getBaseDir($type = 'base')
    {
        return Mage::getBaseDir($type);
    }

    /**
     * Retrieve module absolute path by directory type
     *
     * @param string $type
     * @param string $moduleName
     * @return string
     */
    public function getModuleDir($type, $moduleName)
    {
        return Mage::getModuleDir($type, $moduleName);
    }

    /**
     * Retrieve config value for store by path
     *
     * @param string $path
     * @param mixed $store
     * @return mixed
     */
    public function getStoreConfig($path, $store = null)
    {
        return Mage::getStoreConfig($path, $store);
    }

    /**
     * Retrieve config flag for store by path
     *
     * @param string $path
     * @param mixed $store
     * @return bool
     */
    public function getStoreConfigFlag($path, $store = null)
    {
        return Mage::getStoreConfigFlag($path, $store);
    }

    /**
     * Get base URL path by type
     *
     * @param string $type
     * @param null|bool $secure
     * @return string
     */
    public function getBaseUrl($type = Mage_Core_Model_Store::URL_TYPE_LINK, $secure = null)
    {
        return Mage::getBaseUrl($type, $secure);
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = array())
    {
        return Mage::getUrl($route, $params);
    }

    /**
     * Get design package singleton
     *
     * @return Mage_Core_Model_Design_Package
     */
    public function getDesign()
    {
        return Mage::getDesign();
    }

    /**
     * Retrieve a config instance
     *
     * @return Mage_Core_Model_Config
     */
    public function getConfig()
    {
        return Mage::getConfig();
    }

    /**
     * Add observer to even object
     *
     * @param string $eventName
     * @param callback $callback
     * @param array $data
     * @param string $observerName
     * @param string $observerClass
     */
    public function addObserver($eventName, $callback, $data = array(), $observerName = '', $observerClass = '')
    {
        Mage::addObserver($eventName, $callback, $data, $observerName, $observerClass);
    }

    /**
     * Retrieve object of resource model
     *
     * @param   string $modelClass
     * @param   array $arguments
     * @return  Object
     */
    public function getResourceModel($modelClass, $arguments = array())
    {
        return Mage::getResourceModel($modelClass, $arguments);
    }

    /**
     * Retrieve Controller instance by ClassName
     *
     * @param string $class
     * @param Mage_Core_Controller_Request_Http $request
     * @param Mage_Core_Controller_Response_Http $response
     * @param array $invokeArgs
     * @return Mage_Core_Controller_Front_Action
     */
    public function getControllerInstance($class, $request, $response, array $invokeArgs = array())
    {
        return Mage::getControllerInstance($class, $request, $response, $invokeArgs);
    }

    /**
     * Retrieve resource vodel object singleton
     *
     * @param   string $modelClass
     * @param   array $arguments
     * @return  object
     */
    public function getResourceSingleton($modelClass = '', array $arguments = array())
    {
        return Mage::getResourceModel($modelClass, $arguments);
    }

    /**
     * Deprecated, use self::helper()
     *
     * @param string $type
     * @return object
     */
    public function getBlockSingleton($type)
    {
        return Mage::getBlockSingleton($type);
    }

    /**
     * Retrieve resource helper object
     *
     * @param string $moduleName
     * @return Mage_Core_Model_Resource_Helper_Abstract
     */
    public function getResourceHelper($moduleName)
    {
        return Mage::getResourceHelper($moduleName);
    }

    /**
     * Return new exception by module to be thrown
     *
     * @param string $module
     * @param string $message
     * @param integer $code
     * @return Mage_Core_Exception
     */
    public function exception($module = 'Mage_Core', $message = '', $code = 0)
    {
        return Mage::exception($module, $message, $code);
    }

    /**
     * Throw Exception
     *
     * @param string $message
     * @param string $messageStorage
     * @throws Mage_Core_Exception
     */
    public function throwException($message, $messageStorage = null)
    {
        return Mage::throwException($message, $messageStorage);
    }

    /**
     * Get initialized application object.
     *
     * @param string $code
     * @param string $type
     * @param string|array $options
     * @return Mage_Core_Model_App
     */
    public function app($code = '', $type = 'store', $options = array())
    {
        return Mage::app($code, $type, $options);
    }

    /**
     * @static
     * @param string $code
     * @param string $type
     * @param array $options
     * @param string|array $modules
     */
    public function init($code = '', $type = 'store', $options = array(), $modules = array())
    {
        Mage::init($code, $type, $options, $modules);
    }

    /**
     * Front end main entry point
     *
     * @param string $code
     * @param string $type
     * @param string|array $options
     */
    public function run($code = '', $type = 'store', $options = array())
    {
        Mage::run($code, $type, $options);
    }

    /**
     * Retrieve application installation flag
     *
     * @param string|array $options
     * @return bool
     */
    public function isInstalled($options = array())
    {
        return Mage::isInstalled($options);
    }

    /**
     * Set enabled developer mode
     *
     * @param bool $mode
     * @return bool
     */
    public function setIsDeveloperMode($mode)
    {
        return Mage::setIsDeveloperMode($mode);
    }

    /**
     * Retrieve enabled developer mode
     *
     * @return bool
     */
    public function getIsDeveloperMode()
    {
        return Mage::getIsDeveloperMode();
    }


    /**
     * Set is downloader flag
     *
     * @param bool $flag
     */
    public function setIsDownloader($flag = true)
    {
        return Mage::setIsDownloader($flag);
    }


}