<?php
/**
 * Magento_Test_Listener_Annotation_Rewrite
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * @category   Magento
 * @package    Magento_Test
 * @subpackage Model
 * @copyright  Copyright (c) 1996-2013 TechDivision GmbH (http://www.techdivision.com)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version    ${release.version}
 * @since      Class available since Release 0.1.0
 * @author     Jürgen Schuch <js@techdivision.com>
 */

/**
 * Implementation of the @magentoRewriteTestMethod doc comment directive
 */
class Magento_Test_Listener_Annotation_Rewrite
{
    /**
     * @var Magento_Test_Listener
     */
    protected $_listener;

    /**
     * List of rewrite Methods
     *
     * @var array
     */
    private $_rewriteMethods = array();

    /**
     * Constructor
     *
     * @param Magento_Test_Listener $listener
     */
    public function __construct(Magento_Test_Listener $listener)
    {
        $this->_listener = $listener;
    }

    /**
     * Handler for 'startTestSuite' event
     */
    public function startTestSuite()
    {
        $testSuite = $this->_listener->getCurrentTestSuite();
        foreach($testSuite->tests() as $tests) {
            if($tests instanceof PHPUnit_Framework_TestSuite) {
                foreach($tests->tests() as $test) {
                    if($test instanceof PHPUnit_Framework_TestSuite_DataProvider) {
                        continue;
                    }
                    $annotations = $test->getAnnotations();
                    if(!empty($annotations['method']['magentoRewriteTestMethod'][0])) {
                        $this->_rewriteMethods[$annotations['method']['magentoRewriteTestMethod'][0]] = true;
                    }
                }
            }
        }
    }

    /**
     * Handler for 'startTest' event
     */
    public function startTest()
    {
        $currentTest = $this->_listener->getCurrentTest();
        $fullName = get_class($currentTest).'::'.$currentTest->getName();
        if(!empty($this->_rewriteMethods[$fullName])) {
            $currentTest->setReplaced();
        }
    }

}
