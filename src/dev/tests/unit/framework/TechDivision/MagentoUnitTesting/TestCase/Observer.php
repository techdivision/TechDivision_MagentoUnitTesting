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
class TechDivision_MagentoUnitTesting_TestCase_Observer
    extends TechDivision_MagentoUnitTesting_TestCase_Abstract
{

    /**
     * @var PHPUnit_Framework_MockObject_MockObject|Varien_Event_Observer
     */
    protected $_varienObserverMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject|Varien_Event
     */
    protected $_varienEventMock;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        parent::setUp();

        $this->_varienObserverMock = $this->buildMock('Varien_Event_Observer');
        $this->_varienEventMock = $this->buildMock('Varien_Event');

        $this->getVarienObserverMock()->expects($this->any())
            ->method('getEvent')
            ->will($this->returnValue($this->getVarienEventMock()));

        $this->getVarienEventMock()->expects($this->any())
            ->method('getData')
            ->will($this->returnCallback(array($this, '__callEventGetData')));

        $this->getVarienEventMock()->expects($this->any())
            ->method('__call')
            ->will($this->returnCallback(array($this, '__callEvent__call')));
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     */
    public function tearDown()
    {
        unset($this->_varienObserverMock);
        unset($this->_varienEventMock);

        parent::tearDown();
    }

    /**
     * @return mixed
     */
    public function __callEventGetData()
    {
        $args = func_get_args();
        return $this->__executeMagicCall('Event', 'data', $args);
    }

    /**
     * @return mixed|null
     */
    public function __callEvent__call()
    {
        $args = func_get_args();

        if(count($args)) {
            $method = $args[0];
            if(substr($method, 0, 3) == 'get') {
                $key = $this->decamelize(substr($method, 2));
                return $this->__executeMagicCall('Event', 'data', array($key));
            }
        }

        return null;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function addEventData($key, $value)
    {
        $this->__addData('Event', 'data', $key, $value);
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject|Varien_Event_Observer
     */
    public function getVarienObserverMock()
    {
        return $this->_varienObserverMock;
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject|Varien_Event
     */
    public function getVarienEventMock()
    {
        return $this->_varienEventMock;
    }

}