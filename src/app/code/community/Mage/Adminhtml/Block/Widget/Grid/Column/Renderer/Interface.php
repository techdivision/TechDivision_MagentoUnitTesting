<?php

/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * Adminhtml grid item renderer interface
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Magento Core Team <core@magentocommerce.com>
 */

interface Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Interface
{

    /**
     * Renders grid column
     *
     * @param Varien_Object $row
     */
    public function render(Varien_Object $row);
}
