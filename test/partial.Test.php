<?php

use PHPUnit\Framework\TestCase;
use function FN\FOUNDATION\partial;

function defVal($a, $b, $c="default")
{
	return "a:$a,b:$b,c:$c";
}

function takes2($a,$b)
{
    return "a:$a,b:$b";
}
function listVal($list,$sep,$c='x')
{
	return join($sep,$list) . $c;
}

class PartialTest extends TestCase
{
	public function testReturnsLambda()
	{
		$part_dfA = partial('defVal','theA');
		$this->assertInstanceOf(Closure::class,$part_dfA);

	}


	public function testCanUsePlaceHolder()
	{
		$part_dfA = partial('defVal','theA', NS, 'notDefault');
		$res = $part_dfA('newB');
		$this->assertEquals($res,'a:theA,b:newB,c:notDefault');

		$part_dfA = partial('defVal',NS, 'theB');
		$res = $part_dfA('newA');
		$this->assertEquals($res,'a:newA,b:theB,c:default');

		$part_dfA = partial('defVal',NS, NS,'newdef');
		$res = $part_dfA('newA', 'newB');
		$this->assertEquals($res,'a:newA,b:newB,c:newdef');
	}
	public function testCanApplyTwoArgs()
	{
		$part_dfA = partial('defVal','theA', 'theB');
		$res = $part_dfA();
		$this->assertEquals($res,'a:theA,b:theB,c:default');

	}

	public function testOverrideDefault()
	{
		$part_dfA = partial('defVal','theA', 'theB', 'notDefault');
		$res = $part_dfA();
		$this->assertEquals($res,'a:theA,b:theB,c:notDefault');

	}

	public function testWorksWithList()
	{
		$part_lv = partial('listVal',['a','b','c']);
		$res = $part_lv('-');
		$this->assertEquals($res,'a-b-cx');

	}
    /**
     * @expectedException ArgumentCountError
     */
    public function testArityIsPreserved()
    {
        $takes1 = partial('takes2','a');
        //throws argument error expects 1 arg
        $takes1();
    }

}
