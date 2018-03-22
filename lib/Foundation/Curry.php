<?php
namespace FN\FOUNDATION;
class Curry extends Partial
{
	public function __construct($f,...$args)
	{
		return parent::__construct($f,...$args);
	}

    public function close()
    {
        $param_cnt = 0;
        for ( $i = 0; $i< $this->args_cnt; $i++ ) {
            if ($this->args[$i]  === self::NOTSET ) {
                $param_cnt++;
            }
        }
        //$func = _callers($param_cnt);
        $func = function(...$args){
            return $this->call(func_get_args());
            
        };
        return \Closure::bind($func, $this);
    }

	public function call($args){
		$as = $this->the_args($args);
		$func = $this->func;
		/* if we have enough arguments to call our wrapped
		 * closure, then call it, otherwise
		 * return a new one that takes the
		 * remaining arguments
		 */
		if( count($as) < count($this->args) ){
			$cur_args = $as + $this->args ;
			return ( new Curry($func,$cur_args) )->close();
		} else {
			return  call_user_func_array($func,$as );
		}
	}


}


