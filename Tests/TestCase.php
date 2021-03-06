<?php
namespace Azera\Core\Tests;

use PHPUnit_Framework_TestCase;

/**
 * Class TestCase
 * @package Azera\Core\Tests
 */
class TestCase extends PHPUnit_Framework_TestCase {
	
	protected function assertExceptionRegExp( $callable , $regexp )
	{
		try {

			call_user_func( $callable );

			$this->fail( 'Fail asserting exception' );

		} catch ( \Exception $e ) {
			if ( !preg_match( $regexp , $e->getMessage() ) )
				$this->assertRegExp( $regexp , $e->getMessage() );
		}
	}

}
?>