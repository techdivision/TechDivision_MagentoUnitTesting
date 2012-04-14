<?php

/**
 * License: GNU General Public License
 *
 * Copyright (c) 2011 TechDivision GmbH. All rights reserved.
 * Note: Original work copyright to respective authors
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @category   TechDivision
 * @package    TechDivision_MagentoUnitTesting
 * @subpackage Test
 * @copyright  Copyright (c) 1996-2011 TechDivision GmbH (http://www.techdivision.com)
 * @license	   http://www.gnu.org/licenses/gpl.html GPL, version 3
 * @version    ${release.version}
 * @link       http://www.techdivision.com
 * @since      File available since Release 0.1.0
 * @author     TechDivision Core Team <core@techdivision.com>
 */


// set the include path necessary for running the tests
set_include_path(
    get_include_path() . PATH_SEPARATOR
    . getcwd() . PATH_SEPARATOR
    . '${php-target.dir}/pear/php'
);

require_once 'TechDivision/XHProfPHPUnit/TestSuite.php';
require_once 'TechDivision/MagentoUnitTesting/DummyTest.php';

/**
 * Implements the PHPUnit Test Suite for TechDivision_MagentoUnitTesting.
 *
 * @category   TechDivision
 * @package    TechDivision_MagentoUnitTesting
 * @subpackage Test
 * @copyright  Copyright (c) 1996-2011 TechDivision GmbH (http://www.techdivision.com)
 * @license	   http://www.gnu.org/licenses/gpl.html GPL, version 3
 * @version	   ${release.version}
 * @since	   Class available since Release 0.1.0
 * @author     TechDivision Core Team <core@techdivision.com>
 */
class TechDivision_MagentoUnitTesting_AllTests
{

    /**
     * Initializes the TestSuite.
     *
     * @return TechDivision_XHProfPHPUnit_TestSuite The initialized TestSuite
     */
    public static function suite()
    {
        // initialize the TestSuite
        $suite = new TechDivision_XHProfPHPUnit_TestSuite(
        	'${ant.project.name}',
        	'',
            '${release.version}'
        );
        // add some tests
        $suite->addTestSuite('TechDivision_MagentoUnitTesting_DummyTest');
        // return the initialized suite
        return $suite;
    }
}