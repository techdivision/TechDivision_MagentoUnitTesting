# PHPUnit based testsuite for Magento 1
This projects aims to bring the core tests and the important parts of the Magento 2 testsuite to Magento 1.

Please refer to the [blog post (German)](http://www.techdivision.com/blog/phpunit-tests-magento/) for further information.

# How to use
Copy the whole content of src directory to your Magento project.

    cp -R src/* <YOUR_MAGENTO_ROOT_DIRECTORY>

We recommend to create an own phpunit xml file if you want write tests only for your own module.
You find an example file (phpunit.xml.dev) in src/dev/tests/unit/ directory, which is a good beginning.
That example xml includes also the html coverage report which is an must have while you writing your tests.

Execute your tests with the following command:

    cd <YOUR_MAGENTO_ROOT_DIRECTORY>
    php dev/tests/unit/phpunit-3.7.37.phar -c dev/tests/unit/phpunit.xml.dev

Replace dev/tests/unit/phpunit.xml.dev with your own xml file, if you create one.

To display the coverage report browse the following url:

    <YOUR-MAGENTO-HOST>/coverage/index.html

# Documentation for testing framework
coming soon