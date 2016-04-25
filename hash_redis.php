<?php

	//创建一个redis客户端
	$redis = new Redis();

	//连接到一个redis实例
	$redis->connect('127.0.0.1', 6379);

	// $redis->auth('111');


	//hGet，hSet
	$redis->delete('sm');
	$redis->hSet('sm', 'key1', 'hello'); /* 1, 'key1' => 'hello' in the hash at "h" */
	$val1 = $redis->hGet('sm', 'key1'); /* returns "hello" */
	var_dump($val1);
	echo '<br/>';
	$redis->hSet('sm', 'key1', 'plop'); /* 0, value was replaced. */
	$val2 = $redis->hGet('sm', 'key1'); /* returns "plop" */
	var_dump($val2);
	echo '<br/>';
    exit;

	//hSetNx添加一个key到哈希数据中，如果这个key存在则返回false,否则返回true
	$redis->delete('h');
	$redis->hSetNx('h', 'key1', 'hello'); /* TRUE, 'key1' => 'hello' in the hash at "h" */
	$redis->hSetNx('h', 'key1', 'world'); /* FALSE, 'key1' => 'hello' in the hash at "h". No change since the field wasn't replaced. */


	//hLen返回hash表的长度  hDel返回指定的项
	$redis->delete('h');
	$redis->hSet('h', 'key1', 'hello');
	$redis->hSet('h', 'key2', 'plop');
	$redis->hLen('h'); /* returns 2 */


	//hKeys返回hash表中的keys,以数组的形式返回
	$redis->delete('h');
	$redis->hSet('h', 'a', 'x');
	$redis->hSet('h', 'b', 'y');
	$redis->hSet('h', 'c', 'z');
	$redis->hSet('h', 'd', 't');
	echo '<pre>';
	var_dump($redis->hKeys('h'));


	//hVals返回hash表中的values,以数组的形式返回
	$redis->delete('h');
	$redis->hSet('h', 'a', 'x');
	$redis->hSet('h', 'b', 'y');
	$redis->hSet('h', 'c', 'z');
	$redis->hSet('h', 'd', 't');
	echo '<pre>';
	var_dump($redis->hVals('h'));


	//返回所有的包括key和ualue(key作为键值，value作为值)
	$redis->delete('h');
	$redis->hSet('h', 'a', 'x');
	$redis->hSet('h', 'b', 'y');
	$redis->hSet('h', 'c', 'z');
	$redis->hSet('h', 'd', 't');
	echo '<pre>';
	var_dump($redis->hGetAll('h'));


	//hExists判断hash表中是否存在某一个key，存在则返回true,不存在则返回false
	$redis->hSet('h', 'a', 'x');
	$redis->hExists('h', 'a'); /*  TRUE */
	$redis->hExists('h', 'NonExistingKey'); /* FALSE */


	//根据HASH表的KEY，为KEY对应的VALUE自增参数VALUE
	$redis->delete('h');
	$redis->hIncrBy('h', 'x', 2); /* returns 2: h[x] = 2 now. */
	$redis->hIncrBy('h', 'x', 1); /* h[x] ← 2 + 1. Returns 3 */


	//根据HASH表的KEY，为KEY对应的VALUE自增参数VALUE。浮点型
	$redis->delete('h');
	$redis->hIncrByFloat('h','x', 1.5); /* returns 1.5: h[x] = 1.5 now */
	$redis->hIncrByFLoat('h', 'x', 1.5); /* returns 3.0: h[x] = 3.0 now */
	$redis->hIncrByFloat('h', 'x', -3.0); /* returns 0.0: h[x] = 0.0 now */



	//批量填充HASH表。不是字符串类型的VALUE，自动转换成字符串类型。使用标准的值。NULL值将被储存为一个空的字符串
	$redis->delete('user:1');
	$redis->hMset('user:1', array('name' => 'Joe', 'salary' => 2000));
	$redis->hIncrBy('user:1', 'salary', 100); // Joe earns 100 more now.


	//批量取得HASH表中的VALUE
	$redis->delete('h');
	$redis->hSet('h', 'field1', 'value1');
	$redis->hSet('h', 'field2', 'value2');
	$redis->hmGet('h', array('field1', 'field2')); /* returns array('field1' => 'value1', 'field2' => 'value2') */
















