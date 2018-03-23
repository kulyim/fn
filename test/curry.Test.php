<?php
use PHPUnit\Framework\TestCase;
use function FN\FOUNDATION\curry;

function defCurryVal($a, $b, $c="default")
{
	return "a:$a,b:$b,c:$c";
}
function go($a,$b,$c){
    return join("*",func_get_args());
}

class CurryTest extends TestCase
{
	public function testReturnsLambda()
	{
		$curried = curry('defCurryVal','theA');
		$this->assertInstanceOf(Closure::class,$curried);

	}

    public function testCanCurry()
    {
        $curried  = curry('defCurryVal');
        $curryA = $curried('theA');
        $res = $curryA('theB');
        $this->assertEquals($res,'a:theA,b:theB,c:default');

        $go = curry('go');
        $goa = $go('a');
        $gob = $goa('b');
        $result  = $gob('c');
        $this->assertEquals($result,'a*b*c');
        //another
        $this->assertEquals($gob('x'), 'a*b*x');
    }

	public function testCanCurryMissingArg()
	{
		$curried = curry('defCurryVal',NS,'theB');
		$res = $curried('theA');
		$this->assertEquals($res, 'a:theA,b:theB,c:default');
	}

	public function testCanCurryMissingAndSetDefaultArg()
	{
		$curried = curry('defCurryVal',NS,'theB','theC');
		$res = $curried('theA');
		$this->assertEquals($res, 'a:theA,b:theB,c:theC');
	}
}
