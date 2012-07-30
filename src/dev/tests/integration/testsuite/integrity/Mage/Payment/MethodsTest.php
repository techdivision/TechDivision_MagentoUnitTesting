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
 * @category    Mage
 * @package     Mage_Payment
 * @subpackage  integration_tests
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Locate all payment methods in the system and verify declaration of their blocks
 *
 * @group integrity
 */
class Integrity_Mage_Payment_MethodsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param string $methodClass
     * @dataProvider paymentMethodDataProvider
     */
    public function testFormInfoTemplates($methodClass)
    {
        $storeId = Mage::app()->getStore()->getId();

        $model = Mage::getModel($methodClass);
        
        $params = array(
        	'_package'  => 'default',
        	'_theme'    => 'default',
        	'_relative' =>	false
        );
        
        if (strstr(get_class($model), 'Enterprise_')) {
        	$params['_package'] = 'enterprise';
        }
        
        foreach (array($model->getFormBlockType(), $model->getInfoBlockType()) as $blockClass) {
            $message = "Block class: {$blockClass}";
            $block = Mage::app()->getLayout()->createBlock($blockClass);
            $block->setArea('frontend');
            $this->assertFileExists(Mage::getDesign()->getTemplateFilename($block->getTemplate(), $params), $message);
            if ($model->canUseInternal()) {
                try {
                    Mage::app()->getStore()->setId(Mage_Core_Model_App::ADMIN_STORE_ID);
                    $block->setArea('adminhtml');
                    $this->assertFileExists(Mage::getDesign()->getTemplateFilename($block->getTemplate(), $params), $message);
                    Mage::app()->getStore()->setId($storeId);
                } catch (Exception $e) {
                    Mage::app()->getStore()->setId($storeId);
                    throw $e;
                }
            }
        }
    }

    /**
     * @return array
     */
    public function paymentMethodDataProvider()
    {
        $helper = new Mage_Payment_Helper_Data;
        $result = array();
        foreach ($helper->getPaymentMethods() as $method) {
            $result[] = array($method['model']);
        }
        return $result;
    }
}
