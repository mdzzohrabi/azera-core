<?php
namespace Azera\Core;

use ArrayAccess;
use Iterator;

class StringBuilder implements ArrayAccess, Iterator
{

	use PropertyAccessor;
	
	protected $buffer = '';
	protected $cursor = 0;

	protected function getLength()
	{
		return strlen( $this->buffer );
	}


	public function __construct( $string = null )
	{
		$this->buffer = $string;
	}

	public function format( ...$params )
	{
		return sprintf( $this->buffer , ...$params );
	}

	public function replace( $find , $replace = null )
	{
		if ( is_array( $find ) )
			$this->buffer = strtr( $this->buffer , $find );
		else
			$this->buffer = str_replace( $find , $replace , $this->buffer );

		return $this;
	}

	public function insert( $offset , $string )
	{
		$this->buffer = substr( $this->buffer , 0 , $offset ) . $string . substr( $this->buffer , $offset );
		return $this;
	}

	public function indexOf( $str )
	{
		return strpos( $this->buffer , $str );
	}

	public function append( $string )
	{
		$this->buffer .= $string;
		return $this;
	}

	public function write( $string )
	{
		$this->buffer .= $string;
		return $this;
	}

	public function writeln( $string )
	{
		$this->buffer .= $string . PHP_EOL;
		return $this;
	}

	public function sub( $start , $length = null )
	{
		if ( $length )
			return substr( $this->buffer , $start , $length );
		else
			return substr( $this->buffer , $start );
	}

	public function clean()
	{
		$this->buffer = '';
		return $this;
	}

	public function toString()
	{
		return $this->buffer;
	}

	public function __toString()
	{
		return $this->buffer;
	}

	public function offsetGet( $offset )
	{
		return $this->buffer[ $offset ];
	}

	public function offsetSet( $offset , $value )
	{
		$this->buffer[ $offset ] = $value;
	}

	public function offsetUnset( $offset )
	{
		$this->buffer = substr( $this->buffer , 0 , $offset ) . substr( $this->buffer , $offset );
	}

	public function offsetExists( $offset )
	{
		return isset( $this->buffer[ $offset ] );
	}

	public function current()
	{
		return $this->buffer[ $this->cursor ];
	}

	public function key()
	{
		return $this->cursor;
	}

	public function next()
	{
		$this->cursor++;
	}

	public function rewind()
	{
		$this->cursor = 0;
	}

	public function valid()
	{
		return $this->buffer[ $this->cursor ];
	}

}
?>