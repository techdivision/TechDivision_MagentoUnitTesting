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

class Mage_Core_Model_Design_PackageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Mage_Core_Model_Design_Package
     */
    protected $_model;

    protected static $_developerMode;

    public static function setUpBeforeClass()
    {
        $fixtureDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . '_files';
        Mage::app()->getConfig()->getOptions()->setDesignDir($fixtureDir . DIRECTORY_SEPARATOR . 'design');
        Varien_Io_File::rmdirRecursive(Mage::app()->getConfig()->getOptions()->getMediaDir() . '/skin');

        $ioAdapter = new Varien_Io_File();
        $ioAdapter->cp(
            Mage::app()->getConfig()->getOptions()->getJsDir() . '/prototype/prototype.js',
            Mage::app()->getConfig()->getOptions()->getJsDir() . '/prototype/prototype.min.js'
        );
        self::$_developerMode = Mage::getIsDeveloperMode();
    }

    public static function tearDownAfterClass()
    {
        $ioAdapter = new Varien_Io_File();
        $ioAdapter->rm(Mage::app()->getConfig()->getOptions()->getJsDir() . '/prototype/prototype.min.js');
        Mage::setIsDeveloperMode(self::$_developerMode);
    }

    protected function setUp()
    {
        $this->_model = new Mage_Core_Model_Design_Package();
        
        /*
         * Change infact of Magento 1.x compatibility
         * $this->_model->setDesignTheme('test/default/default', 'frontend');
         */
        $this->_model->setTheme('test/default/default', 'frontend');
    }

    public function testSetGetArea()
    {
        $this->assertEquals(Mage_Core_Model_Design_Package::DEFAULT_AREA, $this->_model->getArea());
        $this->_model->setArea('test');
        $this->assertEquals('test', $this->_model->getArea());
    }

    public function testGetPackageName()
    {

        $this->markTestSkipped('Skipped because fails in Magento 1.x.');

        /*
        $this->assertEquals('test', $this->_model->getPackageName());
        */
    }

    public function testGetTheme()
    {
        $this->assertEquals('default', $this->_model->getTheme());
    }

    public function testGetSkin()
    {

        $this->markTestSkipped('Skipped because of Magento 1.x incompatibility.');
        
        /*
        $this->assertEquals('default', $this->_model->getSkin());
        */
    }

    public function testSetDesignTheme()
    {
        /*
         * Change infact of Magento 1.x compatibility
         * $this->_model->setDesignTheme('test/test/test', 'test');
         */

        $this->markTestSkipped('Skipped because fails in Magento 1.x.');

        /*
        $this->_model->setTheme('test/test/test', 'test');
        $this->assertEquals('test', $this->_model->getArea());
        $this->assertEquals('test', $this->_model->getPackageName());
        */
        
        /*
         * TODO Removed because incompatible with Magento 1.x
         * 
         * $this->assertEquals('test', $this->_model->getSkin());
         * $this->assertEquals('test', $this->_model->getSkin());
         */
    }

    /**
     * @expectedException Mage_Core_Exception
     */
    public function testSetDesignThemeException()
    {
        
        /*
         * Change infact of Magento 1.x compatibility
         * $this->_model->setDesignTheme('test/test');
         */

        $this->markTestSkipped('Skipped because fails in Magento 1.x.');

        /*
        $this->_model->setTheme('test/test');
        */
    }

    public function testGetDesignTheme()
    {

        $this->markTestSkipped('Skipped because fails in Magento 1.x.');

        /*
        $this->assertEquals('test/default/default', $this->_model->getTheme());
        */
    }

    /**
     * @dataProvider getFilenameDataProvider
     */
    public function testGetFilename($file, $params)
    {

        $this->markTestSkipped('Skipped because fails in Magento 1.x.');

        /*
        $this->assertFileExists($this->_model->getFilename($file, $params));
        */
    }

    /**
     * @return array
     */
    public function getFilenameDataProvider()
    {
        return array(
            array('theme_file.txt', array('_module' => 'Mage_Catalog')),
            array('Mage_Catalog::theme_file.txt', array()),
            array('Mage_Catalog::theme_file_with_2_dots..txt', array()),
            array('Mage_Catalog::theme_file.txt', array('_module' => 'Overriden_Module')),
        );
    }

    /**
     * @param string $file
     * @expectedException Magento_Exception
     * @dataProvider extractScopeExceptionDataProvider
     */
    public function testExtractScopeException($file)
    {

        $this->markTestSkipped('Skipped because fails in Magento 1.x.');

        /*
        $this->_model->getFilename($file, array());
        */
    }

    public function extractScopeExceptionDataProvider()
    {
        return array(
            array('::no_scope.ext'),
            array('./file.ext'),
            array('../file.ext'),
            array('dir/./file.ext'),
            array('dir/../file.ext'),
        );
    }

    public function testGetOptimalCssUrls()
    {

        $this->markTestSkipped('Skipped because of Magento 1.x incompatibility.');
        
        /*
        $expected = array(
            'http://localhost/pub/media/skin/frontend/test/default/default/en_US/css/styles.css',
            'http://localhost/pub/js/calendar/calendar-blue.css',
        );
        $params = array(
            'css/styles.css',
            'calendar/calendar-blue.css',
        );
        $this->assertEquals($expected, $this->_model->getOptimalCssUrls($params));
        */
    }

    /*
     * @param array $files
     * @param array $expectedFiles
     * @dataProvider getOptimalCssUrlsMergedDataProvider
     * @magentoConfigFixture current_store dev/css/merge_css_files 1
     */
    public function testGetOptimalCssUrlsMerged($files, $expectedFiles)
    {

        $this->markTestSkipped('Skipped because of Magento 1.x incompatibility.');
        
        /*
        $this->assertEquals($expectedFiles, $this->_model->getOptimalCssUrls($files));
        */
    }

    public function getOptimalCssUrlsMergedDataProvider()
    {
        return array(
            array(
                array('css/styles.css', 'calendar/calendar-blue.css'),
                array('http://localhost/pub/media/skin/_merged/5594035976651f0a40d65ed577700fb5.css')
            ),
            array(
                array('css/styles.css'),
                array('http://localhost/pub/media/skin/frontend/test/default/default/en_US/css/styles.css',)
            ),
        );
    }


    public function testGetOptimalJsUrls()
    {

        $this->markTestSkipped('Skipped because of Magento 1.x incompatibility.');
        
        /*
        $expected = array(
            'http://localhost/pub/media/skin/frontend/test/default/default/en_US/js/tabs.js',
            'http://localhost/pub/js/calendar/calendar.js',
        );
        $params = array(
            'js/tabs.js',
            'calendar/calendar.js',
        );
        $this->assertEquals($expected, $this->_model->getOptimalJsUrls($params));
        */
    }

    /*
     * @param array $files
     * @param array $expectedFiles
     * @dataProvider getOptimalJsUrlsMergedDataProvider
     * @magentoConfigFixture current_store dev/js/merge_files 1
     */
    public function testGetOptimalJsUrlsMerged($files, $expectedFiles)
    {

        $this->markTestSkipped('Skipped because of Magento 1.x incompatibility.');
        
        /*
        $this->assertEquals($expectedFiles, $this->_model->getOptimalJsUrls($files));
        */
    }

    public function getOptimalJsUrlsMergedDataProvider()
    {
        return array(
            array(
                array('js/tabs.js', 'calendar/calendar.js'),
                array('http://localhost/pub/media/skin/_merged/c5a9f4afba4ff0ff979445892214fc8b.js',)
            ),
            array(
                array('calendar/calendar.js'),
                array('http://localhost/pub/js/calendar/calendar.js',)
            ),
        );
    }

    public function testGetDesignEntitiesStructure()
    {

        $this->markTestSkipped('Skipped because of Magento 1.x incompatibility.');
        
        /*
        $expectedResult = array(
            'package_one' => array(
                'theme_one' => array(
                    'skin_one' => true,
                    'skin_two' => true
                )
            )
        );
        $this->assertSame($expectedResult, $this->_model->getDesignEntitiesStructure('design_area'));
        */
    }

    public function testGetThemeConfig()
    {

        $this->markTestSkipped('Skipped because of Magento 1.x incompatibility.');
        
        /*
        $frontend = $this->_model->getThemeConfig('frontend');
        $this->assertInstanceOf('Magento_Config_Theme', $frontend);
        $this->assertSame($frontend, $this->_model->getThemeConfig('frontend'));
        */
    }

    public function testIsThemeCompatible()
    {

        $this->markTestSkipped('Skipped because of Magento 1.x incompatibility.');
        
        /*
        $this->assertFalse($this->_model->isThemeCompatible('frontend', 'package', 'custom_theme', '1.0.0.0'));
        $this->assertTrue($this->_model->isThemeCompatible('frontend', 'package', 'custom_theme', '2.0.0.0'));
        */
    }

    public function testGetViewConfig()
    {

        $this->markTestSkipped('Skipped because of Magento 1.x incompatibility.');
        
        /*
        $config = $this->_model->getViewConfig();
        $this->assertInstanceOf('Magento_Config_View', $config);
        $this->assertEquals(array('var1' => 'value1', 'var2' => 'value2'), $config->getVars('Namespace_Module'));
        */
    }
    
    /*
     * @covers Mage_Core_Model_Design_Package::getPublicSkinDir
     */
    public function testGetPublicSkinDir()
    {

        $this->markTestSkipped('Skipped because of Magento 1.x incompatibility.');
        
        /*
        $this->assertTrue(strpos(
                $this->_model->getPublicSkinDir(),
                DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'skin'
            ) !== false
        );
        */
    }

    /**
     * @param string $file
     * @param string $result
     * @covers Mage_Core_Model_Design_Package::getSkinUrl
     * @dataProvider getSkinUrlDataProvider
     */
    public function testGetSkinUrl($devMode, $file, $result)
    {

        $this->markTestSkipped('Skipped because fails in Magento 1.x.');

        /*
        Mage::setIsDeveloperMode($devMode);
        $this->assertEquals($this->_model->getSkinUrl($file), $result);
        */
    }

    /**
     * @return array
     */
    public function getSkinUrlDataProvider()
    {
        return array(
            array(
                false,
                'Mage_Page::favicon.ico',
                'http://localhost/pub/media/skin/frontend/test/default/default/en_US/Mage_Page/favicon.ico',
            ),
            array(
                true,
                'prototype/prototype.js',
                'http://localhost/pub/js/prototype/prototype.js'
            ),
            array(
                false,
                'prototype/prototype.js',
                'http://localhost/pub/js/prototype/prototype.min.js'
            ),
            array(
                true,
                'Mage_Page::menu.js',
                'http://localhost/pub/media/skin/frontend/test/default/default/en_US/Mage_Page/menu.js'
            ),
            array(
                false,
                'Mage_Page::menu.js',
                'http://localhost/pub/media/skin/frontend/test/default/default/en_US/Mage_Page/menu.js'
            ),
            array(
                false,
                'Mage_Catalog::widgets.css',
                'http://localhost/pub/media/skin/frontend/test/default/default/en_US/Mage_Catalog/widgets.css'
            ),
            array(
                true,
                'Mage_Catalog::widgets.css',
                'http://localhost/pub/media/skin/frontend/test/default/default/en_US/Mage_Catalog/widgets.css'
            ),
        );
    }
}
