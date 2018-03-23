<?php
namespace FN\FOUNDATION;

/**
 * Guts of the partial() function below
 * uses reflection to allow partial function application
 */


class Partial
{

    public $args ;
    public $args_cnt;
    public $func;
    /* placeholder for missing function args */
    const  NOTSET =  '^_not_set_^';
    public function __construct($func, ...$rest)
    {
        $this->args = [];
        $this->args_cnt = 0;
        $this->func = null;
        $ok = is_callable($func);
        if (!$ok) {
            throw new \Exception('not callable'.":".print_r($func, true));
        }
        $this->func = $func;
        $cnt = $this->required_params_cnt($func);
        $this->args_cnt = $cnt;
        $pre_filled = array_fill(0,  $cnt, self::NOTSET);
        list($rest) = $rest;
        $this->args =  array_replace($pre_filled, is_array($rest) ? $rest: [$rest]);
    }

    /**
     * get number of required callable arguments
     * 
     * @param callable $func two element array or closure
     * @return numbern Number of required arguments
     */

    public function required_params_cnt($func)
    {
        $rf =  is_array($func) ? new \ReflectionMethod(...$func)
        : new \ReflectionFunction($func);
        return $rf->getNumberOfRequiredParameters();

    }

    /**
     * Manage arguments for closure we're wrapping.
     *
     * For example: if we're wrapping a closure that takes three
     * arguments with one argument already specified,
     * this method will fill in the remaining arguments with
     * the values provided in $args. Returns a new array
     * representing are the current argument list with placeholders
     * replaced with our new values.
     *
     * @param  array $args functions arguments
     *
     * @return array $ret  current argument list 
     */
    public function the_args($args)
    {
        $ret = [];
        //$inc = 0;
        $cnt = count($this->args);
        for ( $i = 0; $i< $cnt ; $i++ ) {
            if ($this->args[$i]  === self::NOTSET ) {
                if (count($args) > 0 ) {
                    //$inc++;
                    $ret[$i] = array_shift($args);
                }
            } else {
                $ret[$i] = $this->args[$i];
            }
        }
        return $ret;
    }

    /**
     * Create closure representing
     * new partially applied function
     *
     * @return Closure
     */
    public function close()
    {
        $param_cnt = 0;
        for ( $i = 0; $i< $this->args_cnt; $i++ ) {
            if ($this->args[$i]  === self::NOTSET ) {
                $param_cnt++;
            }
        }
        $func = _callers($param_cnt);
        return \Closure::bind($func, $this);
    }

    /**
     * Call function with args
     *
     * @return mixed whatever function returns
     */
    public function call($args)
    {
        $func = $this->func;
        return  call_user_func_array($func, $this->the_args($args));
    }
}


define('NS', Partial::NOTSET);



