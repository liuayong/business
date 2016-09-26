<?php


// 下面注册了两个行为，分别是Home模块下的test和test1行为，类文件位于Home模块目录下的Behaviors目录，可以自定义目录
return array(
    'action_begin'=>array('Home\\Behaviors\\TestBehaviors','Home\\Behaviors\\Test1Behavior'), 
);