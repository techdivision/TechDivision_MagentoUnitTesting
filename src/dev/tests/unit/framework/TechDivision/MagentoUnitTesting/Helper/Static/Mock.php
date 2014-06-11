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
class TechDivision_MagentoUnitTesting_Helper_Static_Mock
{
    const TYPE_PUBLIC = 'public';
    const TYPE_STATIC_PUBLIC = 'public static';
    const TYPE_PROTECTED = 'protected';
    const TYPE_PRIVATE = 'private';

    /**
     * @var string
     */
    protected $_className = '';

    /**
     * @var array
     */
    protected $_methods = array();

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->_className = $name;
    }

    /**
     * @param string $name
     * @param mixed  $return
     * @param string $type
     *
     * @return TechDivision_MagentoUnitTesting_Helper_Static_Mock
     */
    public function method($name, $return, $type = self::TYPE_STATIC_PUBLIC)
    {
        $this->_methods[$name] = array(
            'return' => $return,
            'type' => $type
        );
        return $this;
    }

    /**
     * @throws TechDivision_MagentoUnitTesting_Exception_Helper_Static
     * @return TechDivision_MagentoUnitTesting_Helper_Static_Mock
     */
    public function init()
    {
        if (class_exists($this->_className, false)) {
            throw new TechDivision_MagentoUnitTesting_Exception_Helper_Static(
                sprintf('Class "%s" allready loaded! Cannot create Mock.', $this->_className)
            );
        }

        $code = $this->_getCode();
        eval($code);

        $class = $this->_className;
        $class::__setCallbackInstance($this);

        return $this;
    }

    /**
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     */
    public function handleCallback($method, array $args = null)
    {
        if (array_key_exists($method, $this->_methods)) {
            $methodData = $this->_methods[$method];
            $return = $methodData['return'];

            if (is_callable($return)) {
                return call_user_func_array($return, $args);
            }

            return $return;
        }

        return null;
    }

    /**
     * @return string
     */
    protected function _getCode()
    {
        $class = sprintf(
            "class %s \n { \n\n %s \n\n %s \n\n }",
            $this->_className,
            $this->_getInceptionMethods(),
            implode("\n\n", $this->_getMethodsCode())
        );
        return $class;
    }

    /**
     * @return array
     */
    protected function _getMethodsCode()
    {
        $methods = array();

        foreach($this->_methods as $methodName => $methodData)
        {
            $code = sprintf(
                '$args = func_get_args();' . "\n" .
                'if(method_exists(self::$_callbackInstance, "%1$s")) {' . "\n" .
                '  return call_user_func_array(array(self::$_callbackInstance, "%1$s"), $args);' . "\n" .
                '}' . "\n" .
                'return self::$_callbackInstance->handleCallback("%1$s", $args);',
                $methodName
            );
            $method = sprintf(
                "%s function %s() {\n%s\n}",
                $methodData['type'],
                $methodName,
                $code
            );
            $methods[] = $method;
        }

        return $methods;
    }

    /**
     * @return string
     */
    protected function _getInceptionMethods()
    {
        $interception = '';
        $interception .= 'static private $_callbackInstance;' . "\n" . "\n";

        $interception .= 'public static function __setCallbackInstance($instance) {' . "\n";
        $interception .= '     self::$_callbackInstance = $instance;' . "\n";
        $interception .= '}' . "\n";

        return $interception;
    }
}