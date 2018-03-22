<?php

use PHPUnit\Framework\TestCase;
//require_once(__DIR__.'/../lib/fn.foundation.php');

use function FN\FOUNDATION\{compose,sequence};

function appendA($arg)
{
	return $arg .'A';
}

function appendB($arg)
{
	return $arg. 'B';
}

function appendC($arg)
{
	return $arg. 'C';
}

class ComposeTest extends TestCase
{
	public function testCompose2()
	{
		$composed = compose('appendA', 'appendB');
	 $this->assertEquals('BA' ,$composed(""));

	}
	public function testCompose3()
	{
		$composed = compose('appendA', 'appendC', 'appendB');
	 $this->assertEquals('BCA' ,$composed(""));

	}
}

class SequenceTest extends TestCase
{
	public function testSequence2()
	{
		$composed = sequence('appendA', 'appendB');
	 $this->assertEquals('XAB' ,$composed("X"));

	}
	public function testCompose3()
	{
		$composed = sequence('appendA', 'appendC', 'appendB');
	 $this->assertEquals('ACB' ,$composed(""));

	}
}
