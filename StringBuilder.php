<?php
namespace Azera\Core;

use ArrayAccess;
use Countable;
use Iterator;

/**
 * Class StringBuilder
 * @package Azera\Core
 */
class StringBuilder implements ArrayAccess, Iterator, Countable
{

    /** @var string  */
	protected $buffer = '';
	protected $cursor = 0;
	protected $indent = 0;

    /**
     * StringBuilder constructor.
     *
     * @param string $string
     */
	public function __construct( $string = null )
	{
		$this->buffer = $string;
	}

    public function inject() {
        $this->buffer = call_user_func_array( 'sprintf' , array_merge( [ $this->buffer ] , func_get_args() ) );
        return $this;
    }

    /** @return int */
    public function getLength()
    {
        return strlen( $this->buffer );
    }

	public function indent()
	{
		$this->indent++;
		return $this;
	}

	public function outdent()
	{
		$this->indent--;
		return $this;
	}

	protected function format()
	{
		return call_user_func_array( 'sprintf' , func_get_args() );
	}

    /**
     * @param array|string     $find
     * @param string           $replace
     *
     * @return $this
     */
	public function replace( $find , $replace = null )
	{
		if ( is_array( $find ) )
			$this->buffer = strtr( $this->buffer , $find );
		else
			$this->buffer = str_replace( $find , $replace , $this->buffer );

		return $this;
	}

    /**
     * @param int       $offset
     * @param string    $string
     *
     * @return $this
     */
	public function insert( $offset , $string )
	{
		$this->buffer = substr( $this->buffer , 0 , $offset ) . $string . substr( $this->buffer , $offset );
		return $this;
	}

    /**
     * @param string $str
     *
     * @return int
     */
	public function indexOf( $str )
	{
		return strpos( $this->buffer , $str );
	}

	public function append()
	{
		$this->buffer .= call_user_func_array( 'sprintf' , func_get_args() );
		return $this;
	}

	public function write()
	{
		$this->buffer .= call_user_func_array( 'sprintf' , func_get_args() );
		return $this;
	}

	public function writeln()
	{
		$this->buffer .= str_repeat( "\t" , $this->indent ) . call_user_func_array( 'sprintf' , func_get_args() ) . PHP_EOL;
		return $this;
	}

	public function line()
	{
		$this->buffer .= PHP_EOL;
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

    /** {@inheritdoc} */
	public function current()
	{
		return $this->buffer[ $this->cursor ];
	}

    /** {@inheritdoc} */
	public function key()
	{
		return $this->cursor;
	}

    /** {@inheritdoc} */
	public function next()
	{
		$this->cursor++;
	}

    /** {@inheritdoc} */
	public function rewind()
	{
		$this->cursor = 0;
	}

    /** {@inheritdoc} */
	public function valid()
	{
		return isset( $this->buffer[ $this->cursor ] );
	}

    /** {@inheritdoc} */
    public function count()
    {
        return strlen( $this->buffer );
    }

}
?>