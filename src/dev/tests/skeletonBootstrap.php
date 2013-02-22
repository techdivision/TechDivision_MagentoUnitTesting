<?php

/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */

/**
 * Bootstrap for PHPUnit skeleton generator.
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

// path to the instance directory
$projectHome = realpath(__DIR__ . '/../../../instance-src');

// initialize the include path
$includePaths = array(
    get_include_path(),
    $projectHome . '/app/code/core',
    $projectHome . '/app/code/community',
    $projectHome . '/app/code/local',
    $projectHome . '/app',
    $projectHome . '/lib'
);
set_include_path(implode(PATH_SEPARATOR, $includePaths));
spl_autoload_register('magentoAutoloadForUnitTestSkeleton');

function magentoAutoloadForUnitTestSkeleton($class)
{
    $file = str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
    foreach (explode(PATH_SEPARATOR, get_include_path()) as $path) {
        $fileName = $path . DIRECTORY_SEPARATOR . $file;
        if (file_exists($fileName)) {
            include_once $file;
            if (class_exists($class, false)) {
                return true;
            }
        }

    }
    return false;
}
