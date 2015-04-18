<?php
namespace Azera\Core;

class CollectionTest extends \PHPUnit_Framework_TestCase {
	
	function testCollection() {

		$arr = new Collection( [

				'Users-1' => [ 'Alireza' , 'Masoud' ],
				'Users-2' => [ 'Navid' , 'Mohammad' ]

			] );

		$this->assertEquals( [ 'Navid' , 'Mohammad' ] , $arr->get( 'Users-2' ) );

		$this->assertCount( 2 , $arr );

		$a = serialize( $arr );
		$b = unserialize( $a );

		$this->assertEquals( $b , $arr );
		$this->assertEquals( [ 'Navid' , 'Mohammad' ] , $b['Users-2'] );

		$b->set( 'Blog.name' , 'Personal' );
		$b->set( 'Blog.author' , 'Masoud Zohrabi' );

		$this->assertEquals( 'Personal' , $b->get( 'Blog.name' ) );
		$this->assertInternalType( 'array' , $b['Blog'] );
		$this->assertEquals( 'Masoud Zohrabi' , $b->get( 'Blog.author' ) );
		$this->assertEquals( [ 'name' => 'Personal' , 'author' => 'Masoud Zohrabi' ] , $b['Blog'] );
		$this->assertEquals( 'Navid' , $b->get('Users-2.0') );

		$this->assertEquals( [
				'Users-1'	=> [ 'Alireza' , 'Masoud' ]
			] , $arr->getItems( [ 'Users-1' ] ) );


	}

}
?>