<?php
namespace Azera\Core\Tests\Fixture;

use Azera\Core\PropertyAccessor;

class LazyObject extends PropertyAccessor
{

	protected $name;
	protected $active = true;
	protected $password = 200;
	protected $beforeRender = true;

	protected $_protect = array( 'password' );

	protected function setBeforeRender( $closure )
	{
		$this->beforeRender = $closure;
	}

	protected function getId()
	{
		return 10;
	}

	protected function setName( $name )
	{
		$this->name = $name;
	}

	protected function getName()
	{
		return str_replace( '-' , '_' , $this->name );
	}

	protected function getAfterRender()
	{
		return function()
		{
			return 'Welcome';
		};
	}

}
?>