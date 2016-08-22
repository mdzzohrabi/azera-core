<?php
namespace Azera\Core;

use PHPUnit_Framework_TestCase;

/**
 * Class StringTest
 * @package Azera\Core
 */
class StringTest extends PHPUnit_Framework_TestCase {
	
	function testCamelize() {

		$this->assertEquals( 'ActiveRecord' , StringUtil::camelize( 'active_record' ) );

		$this->assertEquals( 'activeRecord' , StringUtil::camelize( 'active_record' , false ) );

		$this->assertEquals( 'SslError' , StringUtil::camelize( StringUtil::underscore( 'SSLError' ) ) );

	}

	function testCapitalize() {

		$this->assertEquals( 'Ssl' , StringUtil::capitalize( 'ssl' ) );
		$this->assertEquals( 'Ssl' , StringUtil::capitalize( 'sSl' ) );

	}

	function testUnderscore() {

		$this->assertEquals( 'active_record' , StringUtil::underscore( 'ActiveRecord' ) );
		$this->assertEquals( 'ssl_error' , StringUtil::underscore( 'SSLError' ) );

	}

	function tetPluralize() {

		$this->assertEquals( 'houses' , StringUtil::pluralize( 'house' ) );
		$this->assertEquals( 'posts' , StringUtil::pluralize( 'post' ) );
		$this->assertEquals( 'rubies' , StringUtil::pluralize( 'ruby' ) );
		$this->assertEquals( 'people' , StringUtil::pluralize( 'person' ) );
		$this->assertEquals( 'categories' , StringUtil::pluralize( 'category' ) );
		$this->assertEquals( 'news' , StringUtil::pluralize( 'news' ) );

	}

	function testHumanize() {

		$this->assertEquals( 'Id' , StringUtil::humanize( '_id' ) );
		$this->assertEquals( 'Author' , StringUtil::humanize( 'author_id' ) );
		$this->assertEquals( 'Hello world' , StringUtil::humanize( 'hello_world' ) );

	}

	function testTableize() {

		$this->assertEquals( 'raw_scaled_scorers' , StringUtil::tableize( 'RawScaledScorer' ) );
		$this->assertEquals( 'egg_and_hams' , StringUtil::tableize( 'egg_and_ham' ) );
		$this->assertEquals( 'fancy_categories' , StringUtil::tableize( 'fancyCategory' )  );

	}

	function testDasherize() {

		$this->assertEquals( 'users-blog' , StringUtil::dasherize( 'users_blog' ) );

	}

	function testTitleize() {

		$this->assertEquals( 'X Men: The Last Stand' , StringUtil::titleize( "x-men: the last stand" ) );
		$this->assertEquals( 'Man From The Boondocks' , StringUtil::titleize( 'man from the boondocks' ) );
		$this->assertEquals( 'The Man Without A Past' , StringUtil::titleize( 'TheManWithoutAPast' ) );

	}

	function testForeignKey() {

		$this->assertEquals( 'post_id' , StringUtil::foreign_key( 'Post' ) );

	}

}
?>