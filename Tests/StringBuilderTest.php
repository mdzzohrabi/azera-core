<?php
namespace Azera\Core;

class StringBuilderTest extends Tests\TestCase
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

		$str = new StringBuilder( 'Hello %s' );

		$this->assertEquals( 'Hello Masoud' , $str->format( 'Masoud' ) );

		$str = new StringBuilder( 'Hello' );

		$this->assertEquals(
				'Hel_lo',
				$str->insert( 3 , '_' )
			);

		$str = new StringBuilder;

		$this->assertEquals(
				'Dear, Masoud',
				$str->write( 'Dear, %s' , 'Masoud' )->toString()
			);

	}

}
?>