<?php
namespace Azera\Core;

use Countable;
use Iterator,
	ArrayAccess,
	Serializable;

/**
 * Collection object
 * 
 * @package Azera\Core
 * @author 	Masoud Zohrabi <mdzzohrabi@gmail.com>
 * @license MIT
 */
class Collection implements Iterator, ArrayAccess, Serializable, Countable {

	/**
	 * @var array
	 */
	protected $items = array();

	/**
	 * @param array $items
	 */
	public function __construct( array $items = array() ) {
		$this->items = $items;
	}

	/**
	 * @param $key
	 * @return string
	 */
	private function nodelize( $key ) {
		return '["' . str_replace( '.' , '"]["' , $key ) . '"]';
	}

	/**
	 * Retrieve node value
	 * 
	 * ```php
	 * Collection->get( 'Post.Comment' );
	 * ```
	 * 
	 * @param string $key
	 * @return mixed
	 */
	public function get( $key ) {
		return eval('return $this->items' . $this->nodelize($key) . ';');
	}

	/**
	 * Set node
	 * 
	 * ```php
	 * Collection->set( 'Post.Comment' , 'Hello !' );
	 * ```
	 * 
	 * @param string $key
	 * @param mixed $value
	 */
	public function set( $key , $value ) {
		eval( '$this->items' . $this->nodelize( $key ) . ' = $value;' );
	}

	/**
	 * Set items repository by reference
	 *
	 * @param array $ref
	 * @return $this
	 */
	public function setReference( &$ref ) {
		$this->items = $ref;
		return $this;
	}

	/**
	 * Return indexOf an item
	 * 
	 * ```php
	 * Collection->indexOf( 'Apple' );	// Return 2
	 * ```
	 * 
	 * @param mixed $item
	 * @return int|string
	 */
	public function indexOf( $item )
	{
		return array_search( $item , $this->items );
	}

	/**
	 * Remove an item from list
	 *
	 * @param $items
	 * @return Collection
	 */
	public function remove( ...$items )
	{

		foreach ( $items as $item )
		if ( ( $index = $this->indexOf( $item ) ) !== null )
			unset( $this->items[ $index ] );

		return $this;
	}

	/**
	 * Remove key from collection
	 * 
	 * @param  array $keys Key
	 * @return Collection
	 */
	public function removeKey( ...$keys )
	{

		foreach ( $keys as $key )
			unset( $this->items[ $key ] );

		return $this;
	}

	/**
	 * Add an item to list
	 *
	 * @param $items
	 * @return Collection
	 */
	public function add( ...$items )
	{
		foreach ( $items as &$item ) $item = (array)$item;
		$this->items = array_merge( $this->items , ...$items );
		return $this;
	}

	/**
	 * Check if an item exists
	 * 
	 * @param mixed $item
	 * @return boolean
	 */
	public function contains( $item )
	{
		return in_array( $item , $this->items );
	}

	/**
	 * Check if a key exists
	 * 
	 * @param int|string $key
	 * @return boolean
	 */
	public function has( $key )
	{
		return eval( 'return isset( $this->items' . $this->nodelize($key) . ' );');
	}

	/**
	 * Retreive list as array
	 * 
	 * @return array
	 */
	public function toArray()
	{
		return $this->items;
	}

	/**
	 * Retreive list as array
	 * 
	 * @param array $keys
	 * @return array
	 */
	public function getItems( $keys = null )
	{
		if ( $keys )
			return array_intersect_key( $this->items , array_flip( $keys ) );
		return $this->items;
	}

	/**
	 * Get Queryable object
	 * @return \Azera\Component\Queryable\Queryable
	 */
	public function asQueryable() {
		/** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */
		return new \Azera\Component\Queryable\Queryable( $this->items );
	}

	public function current() {
		return current( $this->items );
	}

	public function next() {
		return next( $this->items );
	}

	public function key() {
		return key( $this->items );
	}

	public function rewind() {
		reset( $this->items );
	}

	public function valid() {
		return key( $this->items ) !== null;
	}

	public function offsetExists( $offset ) {
		return isset( $this->items[ $offset ] );
	}

	public function offsetGet( $offset ) {
		return $this->items[ $offset ];
	}

	public function offsetSet( $offset , $value ) {
		$this->items[ $offset ] = $value;
	}

	public function offsetUnset( $offset ) {
		unset( $this->items[ $offset ] );
	}

	public function serialize() {
		return serialize( $this->items );
	}

	public function unserialize( $serialized ) {
		$this->items = unserialize( $serialized );
	}

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Count elements of an object
	 *
	 * @link http://php.net/manual/en/countable.count.php
	 * @return int The custom count as an integer.
	 *       </p>
	 *       <p>
	 *       The return value is cast to an integer.
	 */
	public function count()
	{
		return count( $this->items );
	}

}
?>