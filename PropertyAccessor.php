<?php
namespace Azera\Core;

/**
 * Class PropertyAccessor
 * @package Azera\Core
 * @deprecated 
 */
trait PropertyAccessor
{

	private $setterMap = array();
	private $getterMap = array();

	function __get( $key )
	{
        if ( isset($this->_protect) && in_array( $key , (array)$this->_protect ) )
			throw new \RuntimeException( sprintf( 'Cannot access to protected property `%s`' , $key ) );
		if ( method_exists( $this , $getter = ( isset( $this->getterMap[$key] ) ? $this->getterMap[$key] : $this->getterMap[$key] = 'get' . StringUtil::humanize( $key ) ) ) )
			return $this->{$getter}();
		else
			throw new \RuntimeException( sprintf( '`%s` property not found' , $key ) );
	}

	function __set( $key , $value )
	{
		if ( isset($this->_protect) && in_array( $key , (array)$this->_protect ) )
			throw new \RuntimeException( sprintf( 'Cannot access to protected property `%s`' , $key ) );
		if ( method_exists( $this, $setter = ( isset( $this->setterMap[$key] ) ? $this->setterMap[$key] : $this->setterMap[$key] = 'set' . StringUtil::humanize( $key ) ) ) )
			return $this->{$setter}( $value );
		else if ( property_exists( $this , $key ) || method_exists( $this , $getter = ( isset( $this->getterMap[$key] ) ? $this->getterMap[$key] : $this->getterMap[$key] = 'get' . StringUtil::humanize( $key ) ) ) )
			throw new \RuntimeException( sprintf( '`%s` is readonly property' , $key ) );
		else
			throw new \RuntimeException( sprintf( '`%s` property not found' , $key ) );
	}

	function __isset( $key )
	{
		if ( isset($this->_protect) && in_array( $key , (array)$this->_protect ) )
			return false;
		return ( ( property_exists( $this , $key ) && isset( $this->{$key} ) ) || method_exists( $this , isset($this->getterMap[$key]) ? $this->getterMap[$key] : $this->getterMap[$key] = 'get' . StringUtil::humanize( $key ) ) );
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

		else if  ( method_exists( $this , $getter = ( isset($this->getterMap[$method]) ? $this->getterMap[$method] : $this->getterMap[$method] = 'get' . StringUtil::humanize( $method ) ) ) && ( is_callable( $call = call_user_func( [ $this , $getter ] ) ) ) )
			return call_user_func_array( $call , $params );

		throw new \BadMethodCallException( sprintf( '`%s` callable property not found in %s' , $method , get_class($this) ) );

	}

}
?>