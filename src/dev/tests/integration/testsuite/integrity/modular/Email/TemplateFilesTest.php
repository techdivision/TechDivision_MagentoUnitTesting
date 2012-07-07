<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Magento
 * @package     Mage_Core
 * @subpackage  integration_tests
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * @group integrity
 */
class Integrity_Modular_Email_TemplateFilesTest extends PHPUnit_Framework_TestCase
{
    /**
     * Go through all declared templates and check if base files indeed exist in the respective module
     *
     * @param string $templateId
     * @dataProvider loadBaseContentsDataProvider
     */
    public function testLoadBaseContents($templateId)
    {
        $model = new Mage_Core_Model_Email_Template;
        $this->assertInstanceOf('Mage_Core_Model_Email_Template', $model->loadDefault($templateId));
    }

    public function loadBaseContentsDataProvider()
    {
        $data = array();
        $config = Mage::getConfig();
        foreach (Mage_Core_Model_Email_Template::getDefaultTemplates() as $templateId => $row) {
            $data[] = array($templateId);
        }
        return $data;
    }
}