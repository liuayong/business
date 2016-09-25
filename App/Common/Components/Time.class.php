<?php

namespace  Common\Components ;

/**
 * $timeObj = new Time();
 * $timeObj->start('request');
 * $timeObj->runtime('request')
 */
class Time {
	private  $realStartTime ;
	private  $runtime = [] ;

	public function __construct() {
		$this->realStartTime = $this->getTime();
		$this->start();
	}

	// 获得当前时间
	private  function getTime() {
		$arr = explode(' ', microtime()) ;
		return  $arr[0] + $arr[1];
	}

	// 记录开始时间
	public  function start($name='oneRequest') {
		return $this->runtime[$name]['start'] = $this->getTime();
	}

	// 记录结尾的时间
	private  function end($name = 'oneRequest') {
		return $this->runtime[$name]['end'] = $this->getTime();
	}

	/**
	 * $name 记录时间的标识
	 */
	public  function runTime($name = 'oneRequest') {
		if($name) {
			if(!isset($this->runtime[$name]['end'])) {
				$this->runtime[$name]['end'] = $this->getTime();
			}
			return $this->runtime[$name]['end'] - $this->runtime[$name]['start'] ;
		} else if($name === null) {
			unset($this->runtime['oneRequest']);
			return  $this->getTime() - $this->realStartTime;
		}
	}
}
