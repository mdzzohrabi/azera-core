<?php
namespace Azera\Core;

class StringBuilderTest extends \PHPUnit_Framework_TestCase
{
	
	function testBuilder()
	{

		$str = new StringBuilder;

		$str->write('Hello World');

		$this->assertEquals( 'e' , $str[1] );
		$this->assertCount( strlen('Hello World') , $str );
		$this->assertFalse( isset( $str[11] ) );
		$this->assertTrue( isset( $str[10] ) );

		$str[5] = '_';

		$this->assertEquals( 'Hello_World' , (string)$str );
		
		$this->assertEquals( 11 , $str->length );

		$this->assertEquals( 5 , $str->indexOf( '_' ) );

		$this->assertEmpty( (string)$str->clean() );

		$this->assertEquals( 'Hello Masoud' , (new StringBuilder( 'Hello %s' ))->format( 'Masoud' ) );

		$this->assertEquals(
				'Hel_lo',
				( new StringBuilder( 'Hello' ) )->insert( 3 , '_' )
			);

	}

}
?>