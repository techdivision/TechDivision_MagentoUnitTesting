<?php

/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * Bootstrap file for unit/integration tests.
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
if (version_compare(phpversion(), '5.2.0', '<')===true) {
    echo  '<div style="font:12px/1.35em arial, helvetica, sans-serif;"><div style="margin:0 0 25px 0; border-bottom:1px solid #ccc;"><h3 style="margin:0; font-size:1.7em; font-weight:normal; text-transform:none; text-align:left; color:#2f2f2f;">Whoops, it looks like you have an invalid PHP version.</h3></div><p>Magento supports PHP 5.2.0 or newer. <a href="http://www.magentocommerce.com/install" target="">Find out</a> how to install</a> Magento using PHP-CGI as a work-around.</p></div>';
    exit;
}

/**
 * Environment initialization
 */
error_reporting(E_ALL & ~E_NOTICE | E_STRICT);
#ini_set('display_errors', 1);
umask(0);

/**
 * Constants definition
 */
define('DS', DIRECTORY_SEPARATOR);
define('BP', dirname(__DIR__));

/**
 * Require necessary files
 */
require_once BP . '/app/code/core/Mage/Core/functions.php';
require_once BP . '/app/Mage.php';
require_once BP . '/app/autoload.php';