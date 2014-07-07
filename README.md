# PHPUnit based testsuite for Magento 1
This project aims to bring the core tests and the important parts of the Magento 2 testsuite to Magento 1.

Please refer to the [blog post (German)](http://www.techdivision.com/blog/phpunit-tests-magento/) for further information.

With the TechDivision_MagentoUnitTesting framework located at src/dev/tests/unit/framework is it possible to
reach 100% unit test coverage for Magento 1.

# How to use

## Installation
Copy the whole content of the src directory to your Magento project.

    composer install
    cp -R src/* <YOUR_MAGENTO_ROOT_DIRECTORY>

## Configuration
We recommend to create an own phpunit xml file if you want write tests only for your own module.
You will find an example file (phpunit.xml.dev) in src/dev/tests/unit/ directory, which is a good beginning.
That example xml also includes the html coverage report which is a must-have while writing your tests.

## Execution
Execute your tests with the following command:

    cd <YOUR_MAGENTO_ROOT_DIRECTORY>
    php dev/tests/unit/phpunit-3.7.37.phar -c dev/tests/unit/phpunit.xml.dev

Replace dev/tests/unit/phpunit.xml.dev with your own xml file, if you create one.

To display the coverage report browse the following url:

    <YOUR-MAGENTO-HOST>/coverage/index.html

## Writing tests
To use the framework you have to extend your test classes from TechDivision_MagentoUnitTesting_TestCase_Abstract
or an other testcase class which is extended from the abstract class. All testcases are located at
src/dev/tests/unit/framework/TechDivision/MagentoUnitTesting/TestCase

# Documentation for testing framework
https://github.com/techdivision/TechDivision_MagentoUnitTesting/wiki

Feel free to open an issue.
