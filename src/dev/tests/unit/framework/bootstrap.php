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

/*
 * Main
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

$baseIncludePath = getBaseIncludePath();
$includePaths    = array(
    __DIR__ . '/',
    __DIR__ . '/../testsuite',
    $baseIncludePath . '/lib',
    $baseIncludePath . '/app/code/local',
    $baseIncludePath . '/app/code/community',
    $baseIncludePath . '/app/code/core',
    $baseIncludePath . '/app/',
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

/*
 * Callbacks
 */

/**
 * Callback for SPL autoloader
 *
 * @param string $class The fully qualified name of the class that shall be loaded
 * @return bool Whether the class could be loaded
 */
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

/**
 * Callback for php shutdown.
 *
 * Removes all temporary files from temp folder.
 */
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

/*
 * Functions
 */

/**
 * Tries to guess the base path for includes such that files are included from magento root.
 *
 * @return string
 */
function getBaseIncludePath()
{
    $baseIncludePath  = __DIR__ . '/../../../..';
    $composerRoot     = getComposerRoot();
    $content          = file_get_contents($composerRoot . DS . 'composer.json');
    $data             = json_decode($content, true);

    if (isset($data['extra']['magento-root-dir'])) {
        $baseIncludePath = $composerRoot . $data['extra']['magento-root-dir'];
    }

    return getCanonicalPath($baseIncludePath);
}

/**
 * Returns the canonical path for <var>$path</var>.
 *
 * Instead of using PHPs relative path resolving mechanism which would return
 * the realpath and thus not be compliant with modmans symlink deployment, we
 * implement an algorithm that returns a canonical path no matter whether it 
 * includes symlinks.
 *
 * @param string $path
 * @return string
 */
function getCanonicalPath($path)
{
    $parts         = explode(DS, $path);
    $canonicalPath = array_shift($parts); //we assume that the very first part is absolute

    foreach ($parts as $part) {
        switch ($part) {
            case '.':
                //identity, no change required
                break;
            case '..':
                //parent, strip last part from path
                $canonicalPath = dirname($canonicalPath);
                break;
            default:
                //simply append to path
                $canonicalPath .= DS . $part;
        }
    }

    return $canonicalPath;
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

        //if we can't climb higher, we return null as we have reached fs root
        if ($newRoot == $composerRoot) {
            return null;
        }
        $composerRoot = $newRoot;
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
