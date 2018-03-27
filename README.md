# fn
YA FP in php

'partial','curry', 'compose' and 'sequence'

Implementations of the above in php


## partial
partial(callable, ...$args) //-> newFunc

Returns new function that takes remaining arguments

```php
function defVal($a, $b, $c="default")
{
  return "a:$a,b:$b,c:$c";
}
//Create new function with $a partially applied to 'defVal'
$partialA = partial('defVal','theA');
echo $partialA('theB');
//prints a:theA,b:theB,c:default

echo $partialA('theB','theC');
//prints a:theA,b:theB,c:theC

//NS is placeholder for missing argument

$partialB = partial('defVal',NS,'theB','newDefault');
echo $partialB('newA');
//prints a:newA,b:theB,c:newDefault
```

## curry
curry(callable) //-> newFunc

Returns new function that takes one argument (or more) until
argument list is exhausted, then returns value

```php
function go($a,$b,$c)
{
    return join("*",func_get_args());
}
//curry
$go = curry('go');
$goa = $go('a');
$gob = $goa('b');
$result  = $gob('c');
echo $result;
//prints a*b*c
```
## compose
compose(...callables) //-> newFunc
Right to left function composition

```php
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

$composed = compose('appendA','appendB');
echo $composed("X");
//prints XBA
```

## sequence
sequence(...callables) //-> newFunc
Left to right function composition

```php
$sequenced = sequence('appendA', 'appendB');
echo $sequenced('X');
//prints XAB
```

see /test for more examples




