<?php

/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * Abstract test case for default models
 *
 * @category   TechDivision
 * @package    TechDivision_MagentoUnitTesting
 * @subpackage Helper
 * @copyright  Copyright (c) 1996-2014 TechDivision GmbH (http://www.techdivision.com)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version    ${release.version}
 * @since      Class available since Release 0.1.0
 * @author     Vadim Justus <v.justus@techdivision.com>
 */
class TechDivision_MagentoUnitTesting_Helper_Proxy
{
    /**
     * @var object
     */
    protected $_object;

    /**
     * @var PHPUnit_Framework_TestCase
     */
    protected $_testCase;

    /**
     * @var array
     */
    protected $_callbacks = array(
        'before' => array(),
        'after' => array(),
    );

    /**
     * @var array
     */
    protected $_methodBlacklist = array();

    /**
     * @var array
     */
    protected $_invocations = array();

    /**
     * @param PHPUnit_Framework_TestCase $testCase
     * @param                            $object
     * @throws TechDivision_MagentoUnitTesting_Exception_Helper_Proxy
     */
    public function __construct(PHPUnit_Framework_TestCase $testCase, $object)
    {
        if (!is_object($object)) {
            throw new TechDivision_MagentoUnitTesting_Exception_Helper_Proxy(
                "Object (second) constructor parameter must be an instance"
            );
        }

        $this->_object = $object;
        $this->_testCase = $testCase;
    }

    /**
     * @param string $name
     * @param array  $arguments
     * @throws TechDivision_MagentoUnitTesting_Exception_Helper_Proxy
     * @return mixed
     */
    public function __call($name, array $arguments)
    {
        $this->_addInvocation($name, $arguments);

        if (!method_exists($this->_object, $name) && !method_exists($this->_object, '__call')) {
            throw new TechDivision_MagentoUnitTesting_Exception_Helper_Proxy(
                sprintf(
                    'Method "%s" not found in "%s"',
                    $name, get_class($this->_object)
                )
            );
        }

        $return = $this->_executeCallbacks('before', $name, $arguments);

        if ($this->_isCallMethod($name)) {
            $return = call_user_func_array(array($this->_object, $name), $arguments);
        }

        $return = $this->_executeCallbacks('after', $name, $arguments, $return);

        return $return;
    }

    /**
     * @param string $type
     * @param string $name
     * @param array  $arguments
     * @param mixed  $result
     * @return mixed|null
     */
    protected function _executeCallbacks($type, $name, array $arguments, $result = null)
    {
        $callbacks = $this->_callbacks[$type];

        if (array_key_exists($name, $callbacks)) {
            $callback = $callbacks[$name];
            if (is_callable($callback)) {
                $result = call_user_func_array(
                    $callback,
                    array(
                        'arguments' => $arguments,
                        'testCase' => $this->_testCase,
                        'mockObject' => $this->_object,
                        'result' => $result,
                    )
                );
            }
            else {
                $result = $callback;
            }
        }

        return $result;
    }

    /**
     * @param string $name
     * @return bool
     */
    protected function _isCallMethod($name)
    {
        return !in_array($name, $this->_methodBlacklist);
    }

    /**
     * @param string $name
     * @return TechDivision_MagentoUnitTesting_Helper_Proxy
     */
    public function disableMethod($name)
    {
        $this->_methodBlacklist[] = $name;
        return $this;
    }

    /**
     * @param string $name
     * @param mixed  $callback
     * @return TechDivision_MagentoUnitTesting_Helper_Proxy
     */
    public function addBefore($name, $callback)
    {
        $this->_callbacks['before'][$name] = $callback;
        return $this;
    }

    /**
     * @param string $name
     * @param mixed  $callback
     * @return TechDivision_MagentoUnitTesting_Helper_Proxy
     */
    public function addAfter($name, $callback)
    {
        $this->_callbacks['after'][$name] = $callback;
        return $this;
    }

    /**
     * @param string $method
     * @param array  $arguments
     * @return bool
     */
    public function getInvokationsCount($method, array $arguments = null)
    {
        $invocationCount = 0;
        foreach ($this->_invocations as $invocation) {
            if ($invocation['method'] == $method) {
                if ($this->_argumentsMatch($arguments, $invocation['arguments'])) {
                    $invocationCount++;
                }
            }
        }

        return $invocationCount;
    }

    /**
     * @param array $expected
     * @param array $recieved
     * @return bool
     */
    public function _argumentsMatch(array $expected = null, array $recieved = null)
    {
        if(is_null($expected) || $expected === $recieved) {
            return true;
        }

        if (!is_array($recieved)) {
            return false;
        }

        foreach ($expected as $param) {
            if(!in_array($param, $recieved)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $name
     * @param array  $arguments
     * @return void
     */
    protected function _addInvocation($name, array $arguments = null)
    {
        $this->_invocations[] = array(
            'arguments' => $arguments,
            'method' => $name,
        );
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    public function getObject()
    {
        return $this->_object;
    }
}