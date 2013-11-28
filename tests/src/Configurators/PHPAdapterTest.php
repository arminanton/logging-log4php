<?php

/**
 * Licensed to the Apache Software Foundation (ASF) under one or more
 * contributor license agreements. See the NOTICE file distributed with
 * this work for additional information regarding copyright ownership.
 * The ASF licenses this file to You under the Apache License, Version 2.0
 * (the "License"); you may not use this file except in compliance with
 * the License. You may obtain a copy of the License at
 *
 *	   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @category   tests
 * @package	   log4php
 * @license	   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link       http://logging.apache.org/log4php
 */

namespace Apache\Log4php\Tests\Configuration;

use Apache\Log4php\Configuration\Adapters\PhpAdapter;

/**
 * @group configuration
 */
class PHPAdapterTest extends \PHPUnit_Framework_TestCase {

	private $expected1 = array(
		'rootLogger' => array(
			'level' => 'info',
			'appenders' => array('default')
		),
		'appenders' => array(
			'default' => array(
				'class' => 'EchoAppender',
				'layout' => array(
					'class' => 'SimpleLayout'
				 )
			)
		)
	);

	public function testConfig() {
		$url = PHPUNIT_CONFIG_DIR . '/adapters/php/config_valid.php';
		$adapter = new PhpAdapter();
		$actual = $adapter->convert($url);

		$this->assertSame($this->expected1, $actual);
	}

	/**
	 * Test exception is thrown when file cannot be found.
 	 * @expectedException Apache\Log4php\LoggerException
 	 * @expectedExceptionMessage File [you/will/never/find/me.conf] does not exist.
	 */
	public function testNonExistantFileWarning() {
		$adapter = new PhpAdapter();
		$adapter->convert('you/will/never/find/me.conf');
	}

	/**
	 * Test exception is thrown when file is not valid.
	 * @expectedException Apache\Log4php\LoggerException
	 * @expectedExceptionMessage Error parsing configuration: syntax error
	 */
	public function testInvalidFileWarning() {
		$url = PHPUNIT_CONFIG_DIR . '/adapters/php/config_invalid_syntax.php';
		$adapter = new PhpAdapter();
		$adapter->convert($url);
	}

	/**
	 * Test exception is thrown when the configuration is empty.
	 * @expectedException Apache\Log4php\LoggerException
	 * @expectedExceptionMessage Invalid configuration: empty configuration array.
	 */
	public function testEmptyConfigWarning() {
		$url = PHPUNIT_CONFIG_DIR . '/adapters/php/config_empty.php';
		$adapter = new PhpAdapter();
		$adapter->convert($url);
	}

	/**
	 * Test exception is thrown when the configuration does not contain an array.
	 * @expectedException Apache\Log4php\LoggerException
	 * @expectedExceptionMessage Invalid configuration: not an array.
	 */
	public function testInvalidConfigWarning() {
		$url = PHPUNIT_CONFIG_DIR . '/adapters/php/config_not_an_array.php';
		$adapter = new PhpAdapter();
		$adapter->convert($url);
	}
}

?>