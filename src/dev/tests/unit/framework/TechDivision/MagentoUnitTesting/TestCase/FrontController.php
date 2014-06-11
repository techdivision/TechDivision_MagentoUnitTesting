<?php

/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * Abstract test case for default blocks
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
class TechDivision_MagentoUnitTesting_TestCase_FrontController
    extends TechDivision_MagentoUnitTesting_TestCase_Abstract
{

    /**
     * Constructor arguments
     *
     * @var array
     */
    protected $_testClassInitArguments = array();

    /**
     * Override that method to define environment for instance construction
     * e.g. Mage::helper in __construct method of your class
     *
     * @return void
     */
    protected function _beforeInitInstance()
    {
        parent::_beforeInitInstance();

        $this->buildMock('Mage_Core_Controller_Response_Http', 'response');

        $this->getMageRequestMock()->expects($this->any())
            ->method('getRequestedRouteName')
            ->will($this->returnValue(null));

        $this->buildMock('Mage_Core_Controller_Varien_Front', 'front_controller');

        $action = '';

        $this->getRegisteredMock('front_controller')->expects($this->any())
            ->method('setAction')
            ->will(
                $this->returnCallback(
                    function ($value) use (&$action) {
                        $action = $value;
                    }
                )
            );

        $this->getRegisteredMock('front_controller')->expects($this->any())
            ->method('getAction')
            ->will($this->returnValue($action));

        $this->getMageAppMock()->expects($this->any())
            ->method('getFrontController')
            ->will($this->returnValue($this->getRegisteredMock('front_controller')));

        $this->buildMock('Mage_Core_Model_Layout', 'layout');

        $this->addMageSingleton('core/layout', $this->getRegisteredMock('layout'));

        $this->buildMock('Mage_Core_Model_Layout_Update', 'layout_update');

        $this->getRegisteredMock('layout')->expects($this->any())
            ->method('getUpdate')
            ->will($this->returnValue($this->getRegisteredMock('layout_update')));

        $this->buildMock('Mage_Core_Model_Design_Package', 'design_package');

        $this->addMageSingleton('core/design_package', $this->getRegisteredMock('design_package'));

        $this->addMageSingleton('core/session', $this->buildMock('Mage_Core_Model_Session', 'core_session'));

        $this->getRegisteredMock('layout')->expects($this->any())
            ->method('__call')
            ->will($this->returnCallback(array($this, '__callLayout__call')));

        $this->getRegisteredMock('layout')->expects($this->any())
            ->method('getBlock')
            ->will($this->returnCallback(array($this, '__callLayoutGetBlock')));

        $this->buildMock('Mage_Core_Model_Translate_Inline', 'translate_inline');
        $this->addMageSingleton('core/translate_inline', $this->getRegisteredMock('translate_inline'));

        $this->_testClassInitArguments = array(
            $this->getMageRequestMock(),
            $this->getRegisteredMock('response')
        );
    }

    /**
     * @return mixed
     */
    public function __callLayoutGetBlock()
    {
        $args = func_get_args();
        return $this->__executeMagicCall('Layout', 'block', $args);
    }

    /**
     * @return mixed|null
     */
    public function __callLayout__call()
    {
        $args = func_get_args();

        if (count($args)) {
            $method = $args[0];
            if (substr($method, 0, 3) == 'get') {
                $key = $this->decamelize(substr($method, 2));
                return $this->__executeMagicCall('Layout', 'data', array($key));
            }
        }

        return null;
    }

    /**
     * Add mocked block instance to layout
     *
     * @param string $nameInLayout
     * @param string $blockClassName
     */
    public function addMockedBlockToLayout($nameInLayout, $blockClassName)
    {
        $this->__addData('Layout', 'block', $nameInLayout, $this->buildMock($blockClassName, $nameInLayout));
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     */
    public function tearDown()
    {
        parent::tearDown();
    }
}