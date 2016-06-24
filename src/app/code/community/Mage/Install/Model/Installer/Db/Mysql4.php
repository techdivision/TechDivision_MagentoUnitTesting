<?php

/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 */


/**
 * Mysql resource data model
 *
 * @category   Mage
 * @package    Mage_Install
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Install_Model_Installer_Db_Mysql4 extends Mage_Install_Model_Installer_Db_Abstract
{
    /**
     * Retrieve DB server version
     *
     * @return string (string version number | 'undefined')
     */
    public function getVersion()
    {
        $version  = $this->_getConnection()
            ->fetchOne('SELECT VERSION()');
        $version    = $version ? $version : 'undefined';
        $match = array();
        if (preg_match("#^([0-9\.]+)#", $version, $match)) {
            $version = $match[0];
        }
        return $version;
    }

    /**
     * Check InnoDB support
     *
     * @return bool
     */
    public function supportEngine()
    {
        $variables  = $this->_getConnection()
            ->fetchPairs('SHOW ENGINES');
        return isset($variables['InnoDB']) && ($variables['InnoDB'] == 'DEFAULT' || $variables['InnoDB'] == 'YES');
    }
    
    /**
     * Clean database
     *
     * @param SimpleXMLElement $config
     * @return Mage_Install_Model_Installer_Db_Abstract
     */
    public function cleanUpDatabase(SimpleXMLElement $config)
    {
    	$resourceModel = new Mage_Core_Model_Resource();
    	$connection = $resourceModel->getConnection(Mage_Core_Model_Resource::DEFAULT_SETUP_RESOURCE);
    	$dbName = $config->dbname;
    
    	$connection->query('DROP DATABASE IF EXISTS ' . $dbName);
    	$connection->query('CREATE DATABASE ' . $dbName);
    
    	return $this;
    }
}
