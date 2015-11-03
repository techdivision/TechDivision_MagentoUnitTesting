<?php

/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * Register basic autoloader that uses include path
 *
 * @category   TechDivision
 * @package    TechDivision_MagentoUnitTesting
 * @subpackage Bootstrap
 * @copyright  Copyright (c) 1996-2012 TechDivision GmbH (http://www.techdivision.com)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version    ${release.version}
 * @since      Class available since Release 0.1.0
 * @author     TechDivision Core Team <core@techdivision.com>
 */
require_once __DIR__ . '/../lib/Magento/Autoload/IncludePath.php';
if (class_exists('Magento\\Autoload\\IncludePath', false)) {
    spl_autoload_register('Magento\\Autoload\\IncludePath::load', true, true);
} else {
    spl_autoload_register('Magento_Autoload_IncludePath::load', true, true);
}
