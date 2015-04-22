<?php
namespace Azera\Core;

class CollectionTest extends Tests\TestCase {
	
	function testCollection() {

		$arr = new Collection( array(

				'Users-1' => array( 'Alireza' , 'Masoud' ),
				'Users-2' => array( 'Navid' , 'Mohammad' )

			) );

		$this->assertEquals( array( 'Navid' , 'Mohammad' ) , $arr->get( 'Users-2' ) );

		$this->assertCount( 2 , $arr );

		$a = serialize( $arr );
		$b = unserialize( $a );

		$this->assertEquals( $b , $arr );
		$this->assertEquals( array( 'Navid' , 'Mohammad' ) , $b['Users-2'] );

		$b->set( 'Blog.name' , 'Personal' );
		$b->set( 'Blog.author' , 'Masoud Zohrabi' );

		$this->assertEquals( 'Personal' , $b->get( 'Blog.name' ) );
		$this->assertInternalType( 'array' , $b['Blog'] );
		$this->assertEquals( 'Masoud Zohrabi' , $b->get( 'Blog.author' ) );
		$this->assertEquals( array( 'name' => 'Personal' , 'author' => 'Masoud Zohrabi' ) , $b['Blog'] );
		$this->assertEquals( 'Navid' , $b->get('Users-2.0') );

		$this->assertEquals( array(
				
				'Users-1'	=> array( 'Alireza' , 'Masoud' )

			) , $arr->getItems( array( 'Users-1' ) ) );

		$c = new Collection( array( 'Hello' , 'Goodbye' ) );

		$this->assertTrue( $c->contains( 'Hello' ) );

		$this->assertTrue( $arr->contains( array( 'Alireza' , 'Masoud' ) ) );

		$this->assertTrue( $arr->has( 'Users-1' ) );

		$this->assertEquals( 'Users-1' , $arr->indexOf( array( 'Alireza' , 'Masoud' ) ) );

		$this->assertFalse( $arr->remove( array( 'Alireza' , 'Masoud' ) )->contains( array( 'Alireza' , 'Masoud' ) ) );

		$this->assertFalse( $arr->has( 'Users-1' ) );

		$this->assertCount( 1 , $arr );

		$this->assertCount( 3 , $arr->add( 'Masoud' )->add( 'Alireza' ) );

		$this->assertCount( 5 , $arr->add( 'Reza' , 'Mahmood' ) );

		$this->assertCount( 1 , $arr->remove( 'Masoud' , 'Reza' , 'Mahmood' , 'Alireza' ) );

		$this->assertFalse( $arr->removeKey( 'Users-2' )->has( 'Users-2' ) ); 

	}

}
?>