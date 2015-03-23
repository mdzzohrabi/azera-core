<?php
namespace Azera\Core;

class StringTest extends \PHPUnit_Framework_TestCase {
	
	function testCamelize() {

		$this->assertEquals( 'ActiveRecord' , String::camelize( 'active_record' ) );

		$this->assertEquals( 'activeRecord' , String::camelize( 'active_record' , false ) );

		$this->assertEquals( 'SslError' , String::camelize( String::underscore( 'SSLError' ) ) );

	}

	function testCapitalize() {

		$this->assertEquals( 'Ssl' , String::capitalize( 'ssl' ) );
		$this->assertEquals( 'Ssl' , String::capitalize( 'sSl' ) );

	}

	function testUnderscore() {

		$this->assertEquals( 'active_record' , String::underscore( 'ActiveRecord' ) );
		$this->assertEquals( 'ssl_error' , String::underscore( 'SSLError' ) );

	}

	function tetPluralize() {

		$this->assertEquals( 'houses' , String::pluralize( 'house' ) );
		$this->assertEquals( 'posts' , String::pluralize( 'post' ) );
		$this->assertEquals( 'rubies' , String::pluralize( 'ruby' ) );
		$this->assertEquals( 'people' , String::pluralize( 'person' ) );
		$this->assertEquals( 'categories' , String::pluralize( 'category' ) );

	}

	function testHumanize() {

		$this->assertEquals( 'Id' , String::humanize( '_id' ) );
		$this->assertEquals( 'Author' , String::humanize( 'author_id' ) );
		$this->assertEquals( 'Hello world' , String::humanize( 'hello_world' ) );

	}

	function testTableize() {

		$this->assertEquals( 'raw_scaled_scorers' , String::tabelize( 'RawScaledScorer' ) );
		$this->assertEquals( 'egg_and_hams' , String::tabelize( 'egg_and_ham' ) );
		$this->assertEquals( 'fancy_categories' , String::tabelize( 'fancyCategory' )  );

	}

	function testDasherize() {

		$this->assertEquals( 'users-blog' , String::dasherize( 'users_blog' ) );

	}

	function testTitleize() {

		$this->assertEquals( 'X Men: The Last Stand' , String::titleize( "x-men: the last stand" ) );
		$this->assertEquals( 'Man From The Boondocks' , String::titleize( 'man from the boondocks' ) );

	}

	function testForeignKey() {

		$this->assertEquals( 'post_id' , String::foreign_key( 'Post' ) );

	}

}
?>