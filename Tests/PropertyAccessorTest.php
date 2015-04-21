<?php
namespace Azera\Core;

class PropertyAccessorTest extends Tests\TestCase
{
	
	function testAccessor()
	{

		$object = new Tests\Fixture\LazyObject;

		$this->assertEquals( 10 , $object->id );

		$object->name = 'Hello-World';

		$this->assertEquals( 'Hello_World' , $object->name );
		$this->assertTrue( $object->active );
		$this->assertTrue( $object->beforeRender );
		$this->assertTrue( isset( $object->beforeRender ) );
		unset( $object->beforeRender );
		$this->assertNull( $object->beforeRender );
		$this->assertFalse( isset( $object->beforeRender ) );

		$object->beforeRender = function(){ return "Hello"; };

		$this->assertEquals( 'Hello' , $object->beforeRender() );

		$this->assertEquals( 'Welcome' , $object->afterRender() );

		$this->assertExceptionRegExp( function() use ( $object ){

			$object->id = 20;

		} , '/readonly/' );

		$this->assertExceptionRegExp( function() use ( $object ){

			$object->author;

		} , '/not found/' );

		$this->assertExceptionRegExp( function() use ( $object ){

			$object->author = 20;

		} , '/not found/' );

		$this->assertExceptionRegExp( function() use ( $object ){

			$object->active = false;

		} , '/readonly/' );

		$this->assertExceptionRegExp( function() use ( $object ){

			$object->password;

		} , '/protected/' );

	}

}
?>