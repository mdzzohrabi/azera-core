<?php
namespace Azera\Core\Tests\Fixture;

use Azera\Core\PropertyAccessor;

class LazyObject
{
	
	use PropertyAccessor;

	protected $name;
	protected $active = true;
	protected $password = 200;
	protected $beforeRender = true;

	protected $_protect = [ 'password' ];

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

}
?>