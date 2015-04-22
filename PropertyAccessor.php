<?php
namespace Azera\Core;

class PropertyAccessor
{

	private $setterMap = array();
	private $getterMap = array();

	function __get( $key )
	{
		if ( isset($this->_protect) && in_array( $key , (array)$this->_protect ) )
			throw new \RuntimeException( sprintf( 'Cannot access to protected property `%s`' , $key ) );
		if ( method_exists( $this , $getter = ( $this->getterMap[$key] ?: $this->getterMap[$key] = 'get' . String::humanize( $key ) ) ) )
			return $this->{$getter}();
		else if ( property_exists( $this , $key ) )
			return $this->{$key};
		else
			throw new \RuntimeException( sprintf( '`%s` property not found' , $key ) );
	}

	function __set( $key , $value )
	{
		if ( isset($this->_protect) && in_array( $key , (array)$this->_protect ) )
			throw new \RuntimeException( sprintf( 'Cannot access to protected property `%s`' , $key ) );
		if ( method_exists( $this, $setter = ( $this->setterMap[$key] ?: $this->setterMap[$key] = 'set' . String::humanize( $key ) ) ) )
			return $this->{$setter}( $value );
		elseif ( property_exists( $this , $key ) || method_exists( $this , $getter = ( $this->getterMap[$key] ?: $this->getterMap[$key] = 'get' . String::humanize( $key ) ) ) )
			throw new \RuntimeException( sprintf( '`%s` is readonly property' , $key ) );
		else
			throw new \RuntimeException( sprintf( '`%s` property not found' , $key ) );
	}

	function __isset( $key )
	{
		if ( isset($this->_protect) && in_array( $key , (array)$this->_protect ) )
			return false;
		return ( ( property_exists( $this , $key ) && isset( $this->{$key} ) ) || method_exists( $this , $this->getterMap[$key] ?: $this->getterMap[$key] = 'get' . String::humanize( $key ) ) );
	}

	function __unset( $key )
	{

		if ( isset($this->_protect) && in_array( $key , (array)$this->_protect ) )
			throw new \RuntimeException( sprintf( 'Cannot access to protected property `%s`' , $key ) );

		if ( property_exists( $this , $key ) ) {
			unset( $prop , $this->{$key} );
		}
		else
			throw new \RuntimeException( sprintf( '`%s` property not found' , $key ) );			

	}

	function __call( $method , $params )
	{

		if ( isset($this->_protect) && in_array( $method , (array)$this->_protect ) )
			throw new \RuntimeException( sprintf( 'Cannot access to protected property `%s`' , $method ) );

		if ( property_exists( $this , $method ) && is_callable( $this->{$method} ) )
			return call_user_func_array( $this->{$method} , $params );

		else if  ( method_exists( $this , $getter = ( $this->getterMap[$method] ?: $this->getterMap[$method] = 'get' . String::humanize( $method ) ) ) && ( is_callable( $call = call_user_func( array( $this , $getter ) ) ) ) )
			return call_user_func_array( $call , $params );

		throw new \BadMethodCallException( sprintf( '`%s` callable property not found in %s' , $method , get_class($this) ) );

	}

}
?>