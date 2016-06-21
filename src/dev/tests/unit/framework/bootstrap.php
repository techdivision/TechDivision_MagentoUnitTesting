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
 * @package     unit_tests
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

ini_set('error_reporting', E_ALL & ~E_NOTICE | E_STRICT);

define('TESTS_TEMP_DIR', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'tmp');
define('DS', DIRECTORY_SEPARATOR);

if (!file_exists(TESTS_TEMP_DIR)) {
    if (!mkdir(TESTS_TEMP_DIR, 0777)) {
        throw new Exception(sprintf('Unable to create temporary directory %s.', TESTS_TEMP_DIR));
    }
}

if (!is_dir(TESTS_TEMP_DIR)) {
    throw new Exception(sprintf('%s is not a directory.', TESTS_TEMP_DIR));
}

if (!is_writable(TESTS_TEMP_DIR)) {
    throw new Exception(TESTS_TEMP_DIR . ' must be writable.');
}

$includePaths = array(
    __DIR__ . "/",
    __DIR__ . '/../testsuite',
    __DIR__ . '/../../../../lib',
    __DIR__ . '/../../../../app/code/local',
    __DIR__ . '/../../../../app/code/community',
    __DIR__ . '/../../../../app/code/core',
    __DIR__ . '/../../../../app/',
    get_include_path()
);

set_include_path(implode(PATH_SEPARATOR, $includePaths));
spl_autoload_register('magentoAutoloadForUnitTests', true, true);

/*
 * Include composer autoloader.
 *
 * Since every project can define the location of its vendor dir and thus of 
 * its autoload.php, we have to ask composer where its vendor dir is located.
 * Our stategy is to seek upwards until we find a composer.json (the only 
 * actual constant in every setup) and then query composer from that directory.
 */
$vendorDir = getComposerVendorDir();
include_once $vendorDir . DS . 'autoload.php';

register_shutdown_function('magentoCleanTmpForUnitTests');

Magento_Test_Listener::registerObserver('Magento_Test_Listener_Annotation_Rewrite');

include_once "Mage/Core/functions.php";

function magentoAutoloadForUnitTests($class)
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

function magentoCleanTmpForUnitTests()
{
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(TESTS_TEMP_DIR),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($files as $file) {
        if (strpos($file->getFilename(), '.') === 0) {
            continue;
        }
        if ($file->isDir()) {
            rmdir($file->getRealPath());
        } else {
            unlink($file->getRealPath());
        }
    }
}

/**
 * Tries to find the root directory of a composer managed project.
 *
 * If the composer root cannot be found, returns <kbd>null</kbd>
 *
 * @return string|null
 */
function getComposerRoot()
{
    $composerRoot = realpath(__DIR__ . DS . '..');

    while (!is_file($composerRoot . DS . 'composer.json')) {
        $newRoot = realpath($composerRoot . DS . '..');

        //if we can climb higher, we return null as we have reached fs root
        if ($newRoot == $composerRoot) {
            return null;
        }
    }

    return $composerRoot;
}

/**
 * Tries to query composer about its vendor dir.
 *
 * @return string|null
 */
function getComposerVendorDir()
{
    $composerRoot = getComposerRoot();
    $out          = null;

    if ($composerRoot !== null) {
        $out = shell_exec('composer config --absolute vendor-dir');
        $out = trim($out);
    }

    return $out;
}
