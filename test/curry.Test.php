<?php
use PHPUnit\Framework\TestCase;
use FN\FOUNDATION\Curry;
use function FN\FOUNDATION\curry;

function defCurryVal($a, $b, $c="default")
{
	return "a:$a,b:$b,c:$c";
}
class CurryTest extends TestCase
{
	public function testReturnsLambda()
	{
		$curried = curry('defCurryVal','theA');
		$this->assertInstanceOf(Closure::class,$curried);

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
