<?php

namespace Relike\ReParts;


class NamedGroup implements RePart
{
	protected $name;
	protected $sequence;

	public function __construct($name, array $sequence)
	{
		$this->name = $name;
		$this->sequence = $sequence;
	}
 
	public function getSequence()
	{
		return $this->sequence;
	}
 
 	public function getName()
 	{
 		return $this->name;
 	}
}

