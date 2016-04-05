 <?php
	//创建一个redis客户端
   	$redis = new Redis();

   	//连接到一个redis实例
   	$redis->connect('127.0.0.1', 6379);
	
	$redis->set('key','123');
	$redis->set('key','456');
	$a_str = $redis->get('key');
	echo $a_str;

	//setex的单位是秒，psetex的单位是毫秒。都是用来设置变量的生命周期的
	// $redis->setex('key', 3600, 'value'); // sets key → value, with 1h TTL.
	// $redis->psetex('key', 100, 'value'); // sets key → value, with 0.1 sec TTL.

	//setnx这个函数用来设置变量，但设置之前它会先检查这个key是否存在，如果不存在就set,如果存在就返回false
	// $redis->setnx('key', 'value'); /* return TRUE */
	// $redis->setnx('key', 'value'); /* return FALSE */

	//用于删除已经存在的key,返回的是删除的key的数量
	// $redis->set('key1', 'val1');
	// $redis->set('key2', 'val2');
	// $redis->set('key3', 'val3');
	// $redis->set('key4', 'val4');
	// $redis->delete('key1', 'key2'); /* return 2 */
	// $redis->delete(array('key3', 'key4')); /* return 2 */


	//getSet函数先获取当前的value然后再设置valuecho 
	echo '<br/>';
	$redis->set('x', '42');
	$exValue = $redis->getSet('x', 'lol'); //返回42
	$newValue = $redis->get('x');
	echo $exValue.'<br/>'; //42
	echo $newValue.'<br/>'; //lol

	//redis中的事务处理
	$ret = $redis->multi()
				 ->set('key1','val1')
				 ->get('key1')
				 ->set('key2','val2')
				 ->get('key2')
				 ->exec();
	echo '<pre>';
	print_r($ret);


	//判断一个key值是否存在
	// $redis->set('key', 'value');
	// $redis->exists('key');   TRUE 
	// $redis->exists('NonExistingKey'); /* FALSE */

	//自增，如果指定了第二个参数，则把第二个参数增给key
	// $redis->incr('key1'); /* key1 didn't exists, set to 0 before the increment */
	//                       /* and now has the value 1  */
	// $redis->incr('key1'); /* 2 */
	// $redis->incr('key1'); /* 3 */
	// $redis->incr('key1'); /* 4 */
	// $redis->incrBy('key1', 10); /* 14 */

	//自增一个浮点型的值
	// $redis->incrByFloat('key1', 1.5); /* key1 didn't exist, so it will now be 1.5 */
	// $redis->incrByFloat('key1', 1.5); /* 3 */
	// $redis->incrByFloat('key1', -1.5); /* 1.5 */
	// $redis->incrByFloat('key1', 2.5); /* 3.5 */


	//对指定的key值自减
	// $redis->decr('key1'); /* key1 didn't exists, set to 0 before the increment */
	//                    and now has the value -1  
	// $redis->decr('key1'); /* -2 */
	// $redis->decr('key1'); /* -3 */
	// $redis->decrBy('key1', 10); /* -13 */


	//一次性的取得多个key的值，当相应的key不存在时，在相应的位置补上false
	// $redis->set('key1', 'value1');
	// $redis->set('key2', 'value2');
	// $redis->set('key3', 'value3');
	// $redis->mGet(array('key1', 'key2', 'key3')); // array('value1', 'value2', 'value3')
	// $redis->mGet(array('key0', 'key1', 'key5')); // array(`FALSE`, 'value2', `FALSE`)



	//append  把字符串追加到指定的key的后面,返回追加后的长度
	$redis->set('cyy', 'value1');
	$redis->append('cyy', 'value2'); /* 12 */
	$redis->get('cyy'); /* 'value1value2' */	


	//返回字符串的一部分
	$redis->set('key', 'string value');
	$redis->getRange('key', 0, 5); /* 'string' */
	$redis->getRange('key', -5, -1); /* 'value' */


	//修改字符串的一部分,返回的是，修改后的字符串的长度
	$redis->set('key', 'Hello world');
	$redis->setRange('key', 6, "redis"); /* returns 11 */
	$redis->get('key'); /* "Hello redis" */


	//strlen返回的是字符串的长度
	$redis->set('key', 'value');
	$redis->strlen('key'); /* 5 */


	//涉及到底层数据的存储
	// $redis->set('key', "\x7f"); // this is 0111 1111
	// $redis->getBit('key', 0); /* 0 */
	// $redis->getBit('key', 1); /* 1 */


	//设置底层数据库的存储
	// $redis->set('key', "*");    // ord("*") = 42 = 0x2f = "0010 1010"
	// $redis->setBit('key', 5, 1);  returns 0 
	// $redis->setBit('key', 7, 1); /* returns 0 */
	// $redis->get('key'); /* chr(0x2f) = "/" = b("0010 1111") */


	//批量设置多个KEY-VALUE。如果所有的KEYS都被设置成功，如果这些KEY-VALUE都SET成功,使用msetnx将仅仅返回一个TURE，而如果有一个是已经存在的KEY，则所有的操作都不被执行。
	$redis->mset(array('key0' => 'value0', 'key1' => 'value1'));
	var_dump($redis->get('key0'));
	var_dump($redis->get('key1'));


	






















