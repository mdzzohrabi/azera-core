<?php
namespace Azera\Core;

/**
 * String utility
 * 
 * @package Azera\Core
 * @author 	Masoud Zohrabi <mdzzohrabi@gmail.com>
 * @license MIT
 */
class String {

	private static $plural = array(

			'person'	=> 'people',
			'life'		=> 'lives',
			'calf'		=> 'calves',
			'leaf'		=> 'leaves',
			'knife'		=> 'knives',
			'news'		=> 'news',
			'billiards'	=> 'billiards',
			'mathematics'	=> 'mathematics',
			'physics'	=> 'physics'

		);
	
	/**
	 * Camelize string
	 * 
	 * <pre>
	 * 		String::camelize( "active_record" ) 	# => ActiveRecord
	 * 		String::camelize( "SSLSecure" )			# => SslSecure
	 * </pre>
	 * 
	 * @param  string  $string 	String
	 * @param  boolean $upper 	Upper first letter
	 * @return string
	 */
	public static function camelize( $string , $upper = true ) {

		if ( $upper )
			$string = preg_replace_callback( '/^[a-z0-9]+/' , function( $find ){ return self::capitalize( $find[0] ); } , $string );
		else
			$string = preg_replace_callback( '/^[a-z0-9]+/' , function( $find ){ return strtolower( $find[0] ); } , $string );

		$string = preg_replace_callback( '/(_|\\/)([a-z0-9]+)/' , function( $find ){

			return self::capitalize( $find[2] );

		} , $string );

		$string = str_replace( '/' , '::' , $string );

		return $string;

	}

	/**
	 * Capitalize string
	 * 
	 * <pre>
	 * 		String::capitalize( "active" ) 		# => Active
	 * </pre>
	 * 
	 * @param  string $string String
	 * @return string
	 */
	public static function capitalize( $string ) {

		return strtoupper( $string[0] ) . strtolower( substr( $string , 1) );

	}

	/**
	 * Underscore string
	 * 
	 * @param  string $string 	String
	 * @return string
	 */
	public static function underscore( $string ) {

		if ( !preg_match( '/[A-Z-]|::/' , $string ) ) return $string;

		$string = strtr( $string , [ '::' => '/' , '-' => '_' ] );

		$string = preg_replace( '/([A-Z\d]+)([A-Z][a-z])/' , '$1_$2' , $string );

		$string = preg_replace( '/([a-z\d])([A-Z])/' , '$1_$2' , $string );

		return strtolower( $string );

	}

	public static function pluralize( $string ) {

		if ( isset( self::$plural[ $string ] ) )
			return self::$plural[ $string ];

		if ( substr( $string, -1 , 1 ) == 'y' )
			return substr( $string , 0 , strlen( $string ) - 1 ) . 'ies';
		elseif ( substr( $string , -1 , 1 ) != 's' )
			return $string . 's';

	}

	/**
	 * Humanize string
	 * 
	 * "employee_salary" 	=> "Employee salary"
	 * 
	 * @param string $string
	 * @return string
	 */
	public static function humanize( $string ) {

		$string = preg_replace( '/\A_+/' , '', $string );
		$string = preg_replace( '/_id\z/' , '' , $string );
		$string = str_replace( '_' , ' ' , $string );

		return strtoupper( $string[0] ) . strtolower( substr( $string , 1 ) );

	}

	/**
	 * Tableize string
	 * 
	 * "RawScaledScorer"	=> "raw_scaled_scorers"
	 * "egg_and_ham"		=> "egg_and_hams"
	 * "fancyCategory"		=> "fancy_categories"
	 * 
	 * @param  string $string String
	 * @return string
	 */
	public static function tableize( $string ) {

		return self::pluralize( self::underscore( $string ) );

	}

	/**
	 * Dasherize word
	 * 
	 * @param  string $underscored_word Underscored string
	 * @return string
	 */
	public static function dasherize( $underscored_word ) {

		return str_replace( '_' , '-' , $underscored_word );

	}

	/**
	 * Titleize string
	 * 
	 * <pre>
	 * 		String::titleize( "man from the boondocks" ) 	# => "Man From The Boondocks"
	 * 		String::titleize( "x-men: the last stand" ) 	# => "X Men: The Last Stand"
	 * </pre>
	 * 
	 * @param  string $string
	 * @return string
	 */
	public static function titleize( $string ) {

		return preg_replace_callback( "/\b(?<!['’`])[a-z]/" , function( $finds ){

			return strtoupper( $finds[0] );

		} , self::humanize( self::underscore( $string ) ) );

	}

	/**
	 * Truncate string
	 * 
	 * @param  string $string
	 * @return string
	 */
	public static function truncate( $string , $at ) {

		if ( strlen( $string ) <= $at ) return $string;

		return substr( $string , 0 , $at ) . '...';

	}

	/**
	 * Creates a foreign key name from a class name.
	 * 
	 * @param string 	$string
	 * @param boolean 	$separate_class_name_and_id_with_underscore
	 * @return string
	 */
	public static function foreign_key( $string , $separate_class_name_and_id_with_underscore = true ) {

		return self::underscore( $string ) . ( $separate_class_name_and_id_with_underscore ? '_id' : 'id' );

	}

	/**
	 * StringBuilder
	 * 
	 * @return Azera\Core\StringBuilder
	 */
	public static function builder( $string = null )
	{
		return new StringBuilder( $string );
	}

}
?>