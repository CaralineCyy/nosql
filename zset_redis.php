<?php
	//创建一个redis客户端
	$redis = new Redis();

	//连接到一个redis实例
	$redis->connect('127.0.0.1', 6379);

	$redis->auth('111');

	//zAdd添加一个或者多个元素(且元素值不能重复)返回的false????
	$redis->zAdd('cyy123111', 1, 'val1');
	$redis->zAdd('cyy123111', 0, 'val0');
	$redis->zAdd('cyy123111', 5, 'val5');
	echo '<pre>';
	var_dump($redis->zRange('cyy123', 0, -1,true));
	echo '<pre>';
	var_dump($redis->keys('*'));

	//从有序集合中删除指定的成员。
	$redis->delete('key');
	$redis->zAdd('key', 0, 'val0');
	$redis->zAdd('key', 2, 'val2');
	$redis->zAdd('key', 10, 'val10');
	$redis->zDelete('key', 'val2');
	echo '<pre>';
	var_dump($redis->zRange('key', 0, -1)); /* array('val0', 'val10') */


	//返回key对应的有序集合中指定区间的所有元素。这些元素按照score从高到低的顺序进行排列。对于具有相同的score的元素而言，将会按照递减的字典顺序进行排列。该命令与ZRANGE类似，只是该命令中元素的排列顺序与前者不同
	$redis->zAdd('key', 0, 'val0');
	$redis->zAdd('key', 2, 'val2');
	$redis->zAdd('key', 10, 'val10');
	$redis->zRevRange('key', 0, -1); /* array('val10', 'val2', 'val0') */


	












