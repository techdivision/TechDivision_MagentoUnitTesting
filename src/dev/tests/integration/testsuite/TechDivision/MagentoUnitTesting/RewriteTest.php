<?php
/**
 * TechDivision_MagentoUnitTesting_RewriteTest
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

class TechDivision_MagentoUnitTesting_RewriteTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var bool
     */
    protected $_rewriteDone = true;

    public function testOriginal()
    {
        $this->_rewriteDone = false;
        $this->assertEquals(1, 1);
    }

    /**
     * @magentoRewriteTestMethod TechDivision_MagentoUnitTesting_RewriteTest::testOriginal
     */
    public function testRewrite()
    {
        $this->assertEquals(true, $this->_rewriteDone);
    }
}
