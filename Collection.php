<?php
namespace Azera\Core;

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
class Collection implements Iterator, ArrayAccess, Serializable {

	private $items = array();
	
	public function __construct( array $items = array() ) {

		$this->items = $items;

	}

	private function nodelize( $key ) {
		return '["' . str_replace( '.' , '"]["' , $key ) . '"]';
	}

	public function get( $key ) {
		return eval('return $this->items' . $this->nodelize($key) . ';');
	}

	public function set( $key , $value ) {
		eval( '$this->items' . $this->nodelize( $key ) . ' = $value;' );
	}

	public function setReference( &$ref ) {
		$this->items = $ref;
	}

	public function indexOf( $item )
	{
		return array_search( $item , $this->items );
	}

	public function remove( $item )
	{
		if ( $this->contains( $item ) )
			unset( $this->items[ array_search( $item , $this->items ) ] );
	}

	public function add( $item )
	{
		$this->items[] = $item;
	}

	public function contains( $item )
	{
		return in_array( $this->items , $item );
	}

	public function asQueryable() {
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

}
?>