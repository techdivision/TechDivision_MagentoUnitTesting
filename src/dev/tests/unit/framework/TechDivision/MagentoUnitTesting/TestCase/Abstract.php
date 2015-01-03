<?php

/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * Abstract test case for Observer models
 *
 * @category   TechDivision
 * @package    TechDivision_MagentoUnitTesting
 * @subpackage TestCase
 * @copyright  Copyright (c) 1996-2014 TechDivision GmbH (http://www.techdivision.com)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version    ${release.version}
 * @since      Class available since Release 0.1.0
 * @author     Vadim Justus <v.justus@techdivision.com>
 */
class TechDivision_MagentoUnitTesting_TestCase_Abstract
    extends PHPUnit_Framework_TestCase
{

    /**
     * Key used for calling magic methods without args, such as e.g. Mage::app()->getRequest()->getParams()
     */
    const KEY_NOARGS = 'noargs';

    /**
     * Holds callback methods and return values for "magic" methods
     *
     * @var array
     */
    private $__data = array();

    /**
     * Holds all mock instances which were initiated with the buildMock method
     *
     * @var array
     */
    private $__mocks = array();

    /**
     * Holds mock of mage facade model
     *
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $_mageMock;

    /**
     * Holds mock of mage facade model
     *
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $_mageConfigMock;

    /**
     * Holds mock of mage facade model
     *
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $_mageAppMock;

    /**
     * Holds mock of mage facade model
     *
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $_mageStoreMock;

    /**
     * Holds mock of mage facade model
     *
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $_mageRequestMock;

    /**
     * Class name of mage facade model
     *
     * @var string
     */
    protected $_mageProxyClass = 'TechDivision_MagentoUnitTesting_MageProxy';

    /**
     * Disable/enable test class initiation
     *
     * @var bool
     */
    protected $_initInstanceInTestSetup = true;

    /**
     * Name of class you want to test. That class will be automaticaly init in the `$_instance` property for each test.
     * Unless the `$_initInstanceInTestSetup` property is set to `false`.
     *
     * @var string
     */
    protected $_testClassName = 'Varien_Object';

    /**
     * Array of arguments which should be passed to the constructor during the `$_instance` initiation.
     *
     * @var array
     */
    protected $_testClassInitArguments = array();

    /**
     * That property holds the instance of the class defined in `$_testClassName` property.
     *
     * @var Varien_Object
     */
    protected $_instance;

    /**
     * @var array
     */
    protected $_callInterceptorCallbacks = array();

    /**
     * @var array
     */
    protected $_callInterceptorInvocations = array();

    /**
     * That method generates the static Mage class, initiates a MageProxy mock and register several callback methods.
     * This method is called within the setUp method by default.
     *
     * @return void
     */
    protected function _initMageMock()
    {
        $this->_mageMock = $this->buildMock($this->_mageProxyClass);

        if (!class_exists('Mage', false)) {
            $this->buildStaticMock('Mage')
                ->method("getVersion", null)
                ->method("getVersionInfo", null)
                ->method("getEdition", null)
                ->method("setMockInstance", null)
                ->method("reset", null)
                ->method("register", null)
                ->method("unregister", null)
                ->method("registry", null)
                ->method("setRoot", null)
                ->method("getRoot", null)
                ->method("getEvents", null)
                ->method("objects", null)
                ->method("getBaseDir", null)
                ->method("getModuleDir", null)
                ->method("getStoreConfig", null)
                ->method("getStoreConfigFlag", null)
                ->method("getBaseUrl", null)
                ->method("getUrl", null)
                ->method("getDesign", null)
                ->method("getConfig", null)
                ->method("addObserver", null)
                ->method("dispatchEvent", null)
                ->method("getModel", null)
                ->method("getSingleton", null)
                ->method("getResourceModel", null)
                ->method("getControllerInstance", null)
                ->method("getResourceSingleton", null)
                ->method("getBlockSingleton", null)
                ->method("helper", null)
                ->method("getResourceHelper", null)
                ->method("exception", null)
                ->method("throwException", null)
                ->method("app", null)
                ->method("init", null)
                ->method("run", null)
                ->method("isInstalled", null)
                ->method("log", null)
                ->method("logException", null)
                ->method("setIsDeveloperMode", null)
                ->method("getIsDeveloperMode", null)
                ->method("setIsDownloader", null)
                ->init();
        }
        Mage::__setCallbackInstance($this->getMageMock());

        $this->getMageMock()->expects($this->any())
            ->method('throwException')
            ->will($this->returnCallback(array($this, '__callMageThrowException')));

        $this->getMageMock()->expects($this->any())
            ->method('exception')
            ->will($this->returnCallback(array($this, '__callMageException')));

        $this->getMageMock()->expects($this->any())
            ->method('getSingleton')
            ->will($this->returnCallback(array($this, '__callMageGetSingleton')));

        $this->getMageMock()->expects($this->any())
            ->method('getModel')
            ->will($this->returnCallback(array($this, '__callMageGetModel')));

        $this->getMageMock()->expects($this->any())
            ->method('helper')
            ->will($this->returnCallback(array($this, '__callMageGetHelper')));

        $this->getMageMock()->expects($this->any())
            ->method('getResourceModel')
            ->will($this->returnCallback(array($this, '__callMageGetResourceModel')));

        $this->getMageMock()->expects($this->any())
            ->method('getControllerInstance')
            ->will($this->returnCallback(array($this, '__callMageGetControllerInstance')));

        $this->getMageMock()->expects($this->any())
            ->method('getResourceSingleton')
            ->will($this->returnCallback(array($this, '__callMageGetResourceSingleton')));

        $this->getMageMock()->expects($this->any())
            ->method('getBlockSingleton')
            ->will($this->returnCallback(array($this, '__callMageGetBlockSingleton')));

        $this->getMageMock()->expects($this->any())
            ->method('getResourceHelper')
            ->will($this->returnCallback(array($this, '__callMageGetResourceHelper')));

        $this->getMageMock()->expects($this->any())
            ->method('getStoreConfig')
            ->will($this->returnCallback(array($this, '__callMageGetStoreConfig')));

        $this->getMageMock()->expects($this->any())
            ->method('getStoreConfigFlag')
            ->will($this->returnCallback(array($this, '__callMageGetStoreConfigFlag')));
    }

    /**
     * Initiates a mock of `Mage_Core_Model_Config`.
     * This method is called within the setUp method by default.
     *
     * @return void
     */
    protected function _initMageConfigMock()
    {
        $this->_mageConfigMock = $this->buildMock('Mage_Core_Model_Config');

        $this->getMageMock()->expects($this->any())
            ->method('getConfig')
            ->will($this->returnValue($this->getMageConfigMock()));
    }

    /**
     * Initiates a mock of `Mage_Core_Model_App`.
     * This method is called within the setUp method by default.
     *
     * @return void
     */
    protected function _initMageAppMock()
    {
        $this->_mageAppMock = $this->buildMock('Mage_Core_Model_App');

        $this->getMageMock()->expects($this->any())
            ->method('app')
            ->will($this->returnValue($this->getMageAppMock()));

        $this->getMageAppMock()->expects($this->any())
            ->method('getHelper')
            ->will($this->returnCallback(array($this, '__callMageGetHelper')));


        $this->getMageAppMock()->expects($this->any())
            ->method('getStore')
            ->will(
                $this->returnCallback(
                    function () {
                        return $this->getMageStoreMock();
                    }
                )
            );
    }

    /**
     * Initiates a mock of `Mage_Core_Controller_Request_Http`.
     * This method is called within the setUp method by default.
     *
     * @return void
     */
    protected function _initMageRequestMock()
    {
        $this->_mageRequestMock = $this->buildMock('Mage_Core_Controller_Request_Http');

        $this->getMageRequestMock()->expects($this->any())
            ->method('getParams')
            ->will($this->returnCallback(array($this, '__callMageRequestGetParams')));

        $this->getMageRequestMock()->expects($this->any())
            ->method('getParam')
            ->will($this->returnCallback(array($this, '__callMageRequestGetParam')));

        $this->getMageAppMock()->expects($this->any())
            ->method('getRequest')
            ->will($this->returnValue($this->getMageRequestMock()));

    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->_initMageMock();
        $this->_initMageConfigMock();
        $this->_initMageAppMock();
        $this->_initMageRequestMock();

        $desingModelMock = $this->buildMock('Mage_Core_Model_Design_Package', 'core-design-package');
        $this->getMageMock()->expects($this->any())
            ->method('getDesign')
            ->will($this->returnValue($desingModelMock));

        if ($this->_initInstanceInTestSetup) {
            $this->_beforeInitInstance();
            $this->_initInstance();
            $this->_afterInitInstance();
        }
    }

    /**
     * If the class defined in `$_testClassName` property need any speific environment preparations before it could be
     * initiated. Thats the place you should implement it.
     * This method is called within the setUp method by default.
     *
     * Override that method to define environment for instance construction
     * e.g. Mage::helper in __construct method of your class
     *
     * @return void
     */
    protected function _beforeInitInstance()
    {

    }

    /**
     * This method is called within the setUp method by default.
     *
     * @return void
     */
    protected function _afterInitInstance()
    {

    }


    /**
     * Initiates the class defined in `$_testClassName` property and set the `$_instance` property.
     * This method is called within the setUp method by default.
     *
     * Reflection is used for calling the constructur, so that it is
     * possible to use an array supplying the constructor arguments.
     *
     * @return void
     */
    protected function _initInstance()
    {
        $testClass = $this->_testClassName;
        $reflection = new ReflectionClass($testClass);
        $this->_instance = $reflection->newInstanceArgs($this->_testClassInitArguments);
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        unset($this->_mageMock);
        unset($this->_mageConfigMock);
        unset($this->_mageAppMock);
        unset($this->_mageRequestMock);
        unset($this->_mageStoreMock);
        unset($this->_instance);

        unset($this->__mocks);

        parent::tearDown();
    }

    /**
     * @param $exceptionMessage
     *
     * @throws Exception
     */
    public function __callMageThrowException($exceptionMessage)
    {
        throw new Mage_Core_Exception($exceptionMessage);
    }

    /**
     * @param string $module
     * @param string $message
     * @param int    $code
     *
     * @throws Mage_Core_Exception
     */
    public function __callMageException($module = 'Mage_Core', $message = '', $code = 0)
    {
        $className = $module . '_Exception';
        return new $className($message, $code);
    }

    /**
     * callback function for getSingleton method
     *
     * @return mixed
     */
    public function __callMageGetSingleton()
    {
        $args = func_get_args();
        return $this->__executeMagicCall('Mage', 'singleton', $args);
    }

    /**
     * callback function for getSingleton method
     *
     * @return mixed
     */
    public function __callMageGetModel()
    {
        $args = func_get_args();
        return $this->__executeMagicCall('Mage', 'model', $args);
    }

    /**
     * callback function for getSingleton method
     *
     * @return mixed
     */
    public function __callMageGetHelper()
    {
        $args = func_get_args();
        return $this->__executeMagicCall('Mage', 'helper', $args);
    }

    /**
     * callback function for Request::getParams() method
     *
     * @return mixed
     */
    public function __callMageRequestGetParams()
    {
        $args = func_get_args();
        return $this->__executeMagicCall('Request', 'params', $args, true);
    }

    /**
     * callback function for Request::getParams() method
     *
     * @param string $key
     *
     * @throws TechDivision_MagentoUnitTesting_Exception_TestCase
     * @return mixed
     */
    public function __callMageRequestGetParam($key)
    {
        $params = $this->__callMageRequestGetParams();

        if (array_key_exists($key, $params)) {
            return $params[$key];
        }

    }

    /**
     * callback function for getSingleton method
     *
     * @return mixed
     */
    public function __callMageGetResourceModel()
    {
        $args = func_get_args();
        return $this->__executeMagicCall('Mage', 'resourceModel', $args);
    }

    /**
     * callback function for getSingleton method
     *
     * @return mixed
     */
    public function __callMageGetControllerInstance()
    {
        $args = func_get_args();
        return $this->__executeMagicCall('Mage', 'controllerInstance', $args);
    }

    /**
     * callback function for getSingleton method
     *
     * @return mixed
     */
    public function __callMageGetResourceSingleton()
    {
        $args = func_get_args();
        return $this->__executeMagicCall('Mage', 'resourceSingleton', $args);
    }

    /**
     * callback function for getSingleton method
     *
     * @return mixed
     */
    public function __callMageGetBlockSingleton()
    {
        $args = func_get_args();
        return $this->__executeMagicCall('Mage', 'blockSingleton', $args);
    }

    /**
     * callback function for getSingleton method
     *
     * @return mixed
     */
    public function __callMageGetResourceHelper()
    {
        $args = func_get_args();
        return $this->__executeMagicCall('Mage', 'resourceHelper', $args);
    }

    /**
     * callback function for getSingleton method
     *
     * @return mixed
     */
    public function __callMageGetStoreConfig()
    {
        $args = func_get_args();
        try {
            return $this->__executeMagicCall('Mage', 'storeConfig', $args);
        } catch (TechDivision_MagentoUnitTesting_Exception_TestCase $exception) {
            return null;
        }
    }

    /**
     * callback function for getStoreConfigFlag method
     *
     * @return mixed
     */
    public function __callMageGetStoreConfigFlag()
    {
        $flag = call_user_func_array(
            array($this, '__callMageGetStoreConfig'),
            func_get_args()
        );

        if (!empty($flag) && 'false' !== $flag) {
            return true;
        }
        return false;
    }

    /**
     * Registers params within the request mock.
     * e.g. `Mage::app()->getRequest()->getParams();
     * e.g. `Mage::app()->getRequest()->getParam($key);
     *
     * @param mixed $value
     *
     * @return void
     */
    public function addRequestParams($value)
    {
        $this->__addData('Request', 'params', self::KEY_NOARGS, $value);
    }

    /**
     * Registers a `$value` which will be returned if
     * `Mage::getSingleton($key)` is called.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    public function addMageSingleton($key, $value)
    {
        $this->__addMageData('singleton', $key, $value);
    }

    /**
     * Registers a `$value` which will be returned if
     * `Mage::getModel($key)` is called.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    public function addMageModel($key, $value)
    {
        $this->__addMageData('model', $key, $value);
    }

    /**
     * Registers a `$value` which will be returned if
     * `Mage::helper($key)` is called.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    public function addMageHelper($key, $value)
    {
        $this->__addMageData('helper', $key, $value);
    }

    /**
     * Registers a `$value` which will be returned if
     * `Mage::getResourceModel($key)` is called.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    public function addMageResourceModel($key, $value)
    {
        $this->__addMageData('resourceModel', $key, $value);
    }

    /**
     * Registers a `$value` which will be returned if
     * `Mage::getControllerInstance($key)` is called.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    public function addMageControllerInstance($key, $value)
    {
        $this->__addMageData('controllerInstance', $key, $value);
    }

    /**
     * Registers a `$value` which will be returned if
     * `Mage::getResourceSingleton($key)` is called.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    public function addMageResourceSingleton($key, $value)
    {
        $this->__addMageData('resourceSingleton', $key, $value);
    }

    /**
     * Registers a `$value` which will be returned if
     * `Mage::getBlockSingleton($key)` is called.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    public function addMageBlockSingleton($key, $value)
    {
        $this->__addMageData('blockSingleton', $key, $value);
    }

    /**
     * Registers a `$value` which will be returned if
     * `Mage::getResourceHelper($key)` is called.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    public function addMageResourceHelper($key, $value)
    {
        $this->__addMageData('resourceHelper', $key, $value);
    }

    /**
     * Registers a `$value` which will be returned if
     * `Mage::getStoreConfig($key)` is called.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    public function addMageStoreConfig($key, $value)
    {
        $this->__addMageData('storeConfig', $key, $value);
    }

    /**
     * @param string $methodName
     * @param string $key
     * @param mixed  $value
     *
     * @throws Exception
     */
    private function __addMageData($methodName, $key, $value)
    {
        $this->__addData('Mage', $methodName, $key, $value);
    }

    /**
     * Convert camel case string to underscored
     *
     * @param string $string
     *
     * @return string
     */
    public function decamelize($string)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $string, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }

    /**
     * Convert underscored string to camel case
     *
     * @param string $string
     *
     * @return mixed
     */
    public function camelize($string)
    {
        return preg_replace('/(^|_)([a-z])/e', 'strtoupper("\\2")', $string);
    }

    /**
     * @param string $className
     * @param string $methodName
     * @param string $key
     * @param mixed  $value
     */
    protected function __addData($className, $methodName, $key, $value)
    {
        $dataKey = $className . '_' . $methodName;

        $data = array();
        if (array_key_exists($dataKey, $this->__data)) {
            $data = $this->__data[$dataKey];
        }
        $data[$key] = $value;
        $this->__data[$dataKey] = $data;
    }

    /**
     * callback function for getSingleton method
     *
     * @param string $className
     * @param string $methodName
     * @param array  $args
     * @param bool   $noArgs
     *
     * @throws Exception
     * @return mixed
     */
    protected function __executeMagicCall($className, $methodName, array $args, $noArgs = false)
    {
        $dataKey = $className . '_' . $methodName;

        $getMethod = 'get' . ucfirst($methodName);
        $addMethod = 'add' . ucfirst($className) . ucfirst($methodName);

        if ($noArgs) {
            $key = self::KEY_NOARGS;
        } elseif (count($args) == 0) {
            throw new TechDivision_MagentoUnitTesting_Exception_TestCase(
                sprintf("Call '%s' method without any parameters", $getMethod)
            );
        } else {
            $key = $args[0];
        }

        if (!array_key_exists($dataKey, $this->__data)) {
            throw new TechDivision_MagentoUnitTesting_Exception_TestCase(
                sprintf(
                    'The method "%1$s::%2$s" with key "%4$s" was called, but' . "\n" .
                    'there aren\'t any keys specified for that method!' . "\n" .
                    'Use %3$s() in your test to define key values.',
                    $className, $getMethod, $addMethod, $key
                )
            );
        }

        $data = $this->__data[$dataKey];

        if (!array_key_exists($key, $data)) {
            throw new TechDivision_MagentoUnitTesting_Exception_TestCase(
                sprintf(
                    "The key '%s' is not specified for method '%s::%s'!\n" .
                    "Use %s() in your test to define key values.",
                    $key, $className, $getMethod, $addMethod
                )
            );
        }

        return $data[$key];
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    public function getMageMock()
    {
        return $this->_mageMock;
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    public function getMageConfigMock()
    {
        return $this->_mageConfigMock;
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    public function getMageAppMock()
    {
        return $this->_mageAppMock;
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    public function getMageRequestMock()
    {
        return $this->_mageRequestMock;
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    public function getMageStoreMock()
    {
        if (is_null($this->_mageStoreMock)) {
            $this->_mageStoreMock = $this->buildMock('Mage_Core_Model_Store');
        }
        return $this->_mageStoreMock;
    }

    /**
     * Get value of private or protected property
     *
     * @param string $property
     * @param object $instance
     *
     * @return mixed
     */
    public function getPrivateProperty($property, $instance = null)
    {
        if (is_null($instance)) {
            $instance = $this->_instance;
        }

        $reflection = new ReflectionClass($instance);
        $reflectionProperty = $reflection->getProperty($property);
        $reflectionProperty->setAccessible(true);
        return $reflectionProperty->getValue($instance);
    }

    /**
     * Set value of private or protected property
     *
     * @param string $property
     * @param mixed  $value
     * @param object $instance
     *
     * @return mixed
     */
    public function setPrivateProperty($property, $value, $instance = null)
    {
        if (is_null($instance)) {
            $instance = $this->_instance;
        }

        $reflection = new ReflectionClass($instance);
        $reflectionProperty = $reflection->getProperty($property);
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($instance, $value);
    }

    /**
     * @param string      $class
     * @param string|null $key
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    public function buildMock($class, $key = null)
    {
        if (is_null($key)) {
            $key = uniqid();
        }

        $mock = $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->__mocks[$key] = $mock;

        return $mock;
    }

    /**
     * @param string      $class
     * @param string|null $key
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function buildMockForAbstractClass($class, $key = null)
    {
        if (is_null($key)) {
            $key = uniqid();
        }

        $mock = $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $this->__mocks[$key] = $mock;

        return $mock;
    }

    /**
     * @param string $key
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     * @throws TechDivision_MagentoUnitTesting_Exception_TestCase
     */
    public function getRegisteredMock($key)
    {
        if (!array_key_exists($key, $this->__mocks)) {
            throw new TechDivision_MagentoUnitTesting_Exception_TestCase(
                sprintf(
                    "There is no registered mock instance with key '%s'.\n" .
                    "Use buildMock() method in your test to create a new mock instance.",
                    $key
                )
            );
        }

        return $this->__mocks[$key];
    }

    /**
     * @param string|PHPUnit_Framework_MockObject_MockObject $mock
     *
     * @return TechDivision_MagentoUnitTesting_Helper_Proxy
     */
    public function buildProxy($mock)
    {
        if (is_string($mock)) {
            $mock = $this->buildMock($mock);
        }

        return new TechDivision_MagentoUnitTesting_Helper_Proxy(
            $this, $mock
        );
    }

    /**
     * @param       $methodName
     * @param array $args
     * @param null  $instance
     *
     * @return mixed;
     */
    public function callMethod($methodName, array $args = array(), $instance = null)
    {
        if (is_null($instance)) {
            $instance = $this->_instance;
        }

        $class = new \ReflectionClass($instance);
        $method = $class->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($instance, $args);
    }

    /**
     * @param PHPUnit_Framework_MockObject_MockObject $mockObject
     * @param string                                  $methodName
     * @param mixed                                   $return
     * @param string                                  $callInterceptionMethodName
     *
     * @return void
     */
    public function addCallInterceptorMethod(
        PHPUnit_Framework_MockObject_MockObject $mockObject,
        $methodName,
        $return,
        $callInterceptionMethodName = '__call'
    ) {
        $mockInstanceHash = $this->_getInstanceHash($mockObject);

        if (!array_key_exists($mockInstanceHash, $this->_callInterceptorCallbacks)) {
            $mockObject->expects($this->any())
                ->method($callInterceptionMethodName)
                ->will(
                    $this->returnCallback(
                        function ($method, $args) use ($mockInstanceHash) {
                            $this->_addCallInterceptorInvocation($mockInstanceHash, $method);

                            if (!array_key_exists($mockInstanceHash, $this->_callInterceptorCallbacks)) {
                                return null;
                            }

                            if (!array_key_exists($method, $this->_callInterceptorCallbacks[$mockInstanceHash])) {
                                return null;
                            }

                            $return = $this->_callInterceptorCallbacks[$mockInstanceHash][$method];

                            if (is_callable($return)) {
                                return call_user_func_array($return, $args);
                            }
                            return $return;
                        }
                    )
                );

            $this->_callInterceptorCallbacks[$mockInstanceHash] = array();
        }

        $this->_callInterceptorCallbacks[$mockInstanceHash][$methodName] = $return;
    }

    /**
     * @param PHPUnit_Framework_MockObject_MockObject $mockObject
     *
     * @return string
     */
    protected function _getInstanceHash(PHPUnit_Framework_MockObject_MockObject $mockObject)
    {
        return md5(spl_object_hash($mockObject));
    }

    /**
     * @param string $mockInstanceHash
     * @param string $methodName
     *
     * @return void
     */
    protected function _addCallInterceptorInvocation($mockInstanceHash, $methodName)
    {
        if (!array_key_exists($mockInstanceHash, $this->_callInterceptorInvocations)) {
            $this->_callInterceptorInvocations[$mockInstanceHash] = array();
        }

        $invocations = $this->_callInterceptorInvocations[$mockInstanceHash];
        if (!array_key_exists($methodName, $invocations)) {
            $invocations[$methodName] = 0;
        }

        $invocations[$methodName]++;
        $this->_callInterceptorInvocations[$mockInstanceHash] = $invocations;
    }

    /**
     * @param PHPUnit_Framework_MockObject_MockObject $mockObject
     * @param                                         $methodName
     *
     * @return int
     */
    public function getCallInterceptorInvocations(
        PHPUnit_Framework_MockObject_MockObject $mockObject,
        $methodName
    ) {
        $mockInstanceHash = $this->_getInstanceHash($mockObject);

        if (!array_key_exists($mockInstanceHash, $this->_callInterceptorInvocations)) {
            return 0;
        }

        $invocations = $this->_callInterceptorInvocations[$mockInstanceHash];
        if (!array_key_exists($methodName, $invocations)) {
            return 0;
        }

        return (int)$invocations[$methodName];
    }

    /**
     * @param string                                       $method
     * @param TechDivision_MagentoUnitTesting_Helper_Proxy $proxy
     * @param array                                        $arguments
     * @param null                                         $count
     *
     * @return void
     */
    public function assertMethodInvocationInProxy(
        $method,
        TechDivision_MagentoUnitTesting_Helper_Proxy $proxy,
        $count = null,
        array $arguments = null
    ) {
        $invocations = $proxy->getInvokationsCount($method, $arguments);

        if (is_null($count)) {
            $this->assertGreaterThan(
                0,
                $invocations,
                sprintf(
                    'Asserts that method "%s" was invoked in "%s"!',
                    $method, get_class($proxy->getObject())
                )
            );
        }

        $this->assertEquals(
            $count,
            $invocations,
            sprintf(
                'Asserts that method "%s" was invoked in "%s"!' . "\n" .
                'Method was expected to be called %s times, actually called %s times.',
                $method, get_class($proxy->getObject()), $count, $invocations
            )
        );
    }

    /**
     * @param PHPUnit_Framework_MockObject_MockObject $mockObject
     * @param string                                  $methodName
     * @param string                                  $expectedCount
     *
     * @return void
     */
    public function assertCallInterceptorInvocationCount(
        PHPUnit_Framework_MockObject_MockObject $mockObject,
        $methodName,
        $expectedCount
    ) {
        $currentCount = $this->getCallInterceptorInvocations($mockObject, $methodName);
        $this->assertSame(
            $expectedCount, $currentCount, sprintf(
                'Asserts that method "%s" will be invoked %c times, but currently invoked %c times!',
                $methodName, $expectedCount, $currentCount
            )
        );
    }

    /**
     * @param string $class
     *
     * @return TechDivision_MagentoUnitTesting_Helper_Static_Mock
     */
    public function buildStaticMock($class)
    {
        return new TechDivision_MagentoUnitTesting_Helper_Static_Mock($class);
    }

}