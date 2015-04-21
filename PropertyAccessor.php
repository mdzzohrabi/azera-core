<?php
namespace Azera\Core;

trait PropertyAccessor
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

}
?>