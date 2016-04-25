<?php
	
	//创建一个redis客户端
   	$redis = new Redis();

   	//连接到一个redis实例
   	$redis->connect('127.0.0.1', 6379);


	//添加一个字符串值到LIST容器的顶部（左侧），如果KEY不存在，则创建一个LIST容器，如果KEY存在并且不是一个LIST容器，那么返回FLASE
	////返回的是添加之后list容器的最新的长度
	$redis->delete('key6');
	$redis->lPush('key6', 'C'); // returns 1
	$redis->lPush('key6', 'B'); // returns 2
	$redis->lPush('key6', 'A'); // returns 3
	/* key1 now points to the following list: [ 'A', 'B', 'C' ] */



	//添加一个字符串值到LIST容器的底部（右侧），如果KEY不存在，曾创建一个LIST容器，如果KEY存在并且不是一个LIST容器，那么返回FLASE。
	//返回的是添加之后list容器的最新的长度
	$redis->delete('key2');
	$redis->rPush('key2', 'A'); // returns 1
	$redis->rPush('key2', 'B'); // returns 2
	$redis->rPush('key2', 'C'); // returns 3
	/* key1 now points to the following list: [ 'A', 'B', 'C' ] */


	//返回LIST顶部（左侧）的VALUE，并且从LIST中把该VALUE弹出
	//取得VALUE成功，返回TURE。如果是一个空LIST则返回FLASE。
	$redis->delete('key3');
	$redis->rPush('key3', 'defwe');
	$redis->rPush('key3', '3243');
	$redis->rPush('key3', '3532'); /* key1 => [ 'A', 'B', 'C' ] */
	$redis->lPop('key3'); /* key1 => [ 'B', 'C' ] */


	//返回LIST底部（右侧）的VALUE，并且从LIST中把该VALUE弹出。
	//取得VALUE成功，返回TURE。如果是一个空LIST则返回FLASE。
	$redis->delete('key1');
	$redis->rPush('key1', 'A');
	$redis->rPush('key1', 'B');
	$redis->rPush('key1', 'C'); /* key1 => [ 'A', 'B', 'C' ] */
	$redis->rPop('key1'); /* key1 => [ 'A', 'B' ] */


	//lSize返回这个key代表的list的长度。如果 这个list不存在或者这个list为空，则返回0，如果这个key代表的不是list则返回false
	//使用它来判断list的长度的时候，要注意区分false和0的区别(即 ===和==的区别)
	$redis->rPush('key1', 'A');
	$redis->rPush('key1', 'B');
	$redis->rPush('key1', 'C'); /* key1 => [ 'A', 'B', 'C' ] */
	$redis->lSize('key1');/* 3 */
	$redis->rPop('key1'); 
	$redis->lSize('key1');/* 2 */


	//lGet,lIndex根据索引值返回指定KEY LIST中的元素。0为第一个元素，1为第二个元素。-1为倒数第一个元素，-2为倒数第二个元素。如果指定了一个不存在的索引值，则返回FLASE
	$redis->rPush('key1', 'A');
	$redis->rPush('key1', 'B');
	$redis->rPush('key1', 'C'); /* key1 => [ 'A', 'B', 'C' ] */
	$redis->lGet('key1', 0); /* 'A' */
	$redis->lGet('key1', -1); /* 'C' */
	$redis->lGet('key1', 10); /* `FALSE` */


	//lSet根据索引值设置新的value
	$redis->rPush('key1', 'A');
	$redis->rPush('key1', 'B');
	$redis->rPush('key1', 'C'); /* key1 => [ 'A', 'B', 'C' ] */
	$redis->lGet('key1', 0); /* 'A' */
	$redis->lSet('key1', 0, 'X');
	$redis->lGet('key1', 0); /* 'X' */ 


	//取得指定索引值范围内的所有元素
	$redis->rPush('key1', 'A');
	$redis->rPush('key1', 'B');
	$redis->rPush('key1', 'C');
	$redis->lRange('key1', 0, -1); /* array('A', 'B', 'C') */

	//lTrim, listTrim它将截取LIST中指定范围内的元素组成一个新的LIST并指向KEY。简短解说就是截取LIST
	$redis->rPush('key1', 'A');
	$redis->rPush('key1', 'B');
	$redis->rPush('key1', 'C');
	$redis->lRange('key1', 0, -1); /* array('A', 'B', 'C') */
	$redis->lTrim('key1', 0, 1);
	$redis->lRange('key1', 0, -1); /* array('A', 'B') */


	//IRem,IRemove函数，首先要去判断count参数，如果count参数为0，那么所有符合删除条件的元素都将被移除。如果count参数为整数,将从左至右删除count个符合条件的元素，如果为负数则从右至左删除count个符合条件的元素
	$redis->lPush('key1', 'A');
	$redis->lPush('key1', 'B');
	$redis->lPush('key1', 'C'); 
	$redis->lPush('key1', 'A'); 
	$redis->lPush('key1', 'A'); 
	$redis->lRange('key1', 0, -1); /* array('A', 'A', 'C', 'B', 'A') */
	$redis->lRem('key1', 'A', 2); /* 2 */
	$redis->lRange('key1', 0, -1); /* array('C', 'B', 'A') */


	//从源LIST的最后弹出一个元素，并且把这个元素从目标LIST的顶部（左侧）压入目标LIST
	$redis->delete('x', 'y');
	$redis->lPush('x', 'abc');
	$redis->lPush('x', 'def');
	$redis->lPush('y', '123');
	$redis->lPush('y', '456');
	// move the last of x to the front of y.
	var_dump($redis->rpoplpush('x', 'y'));
	var_dump($redis->lRange('x', 0, -1));
	var_dump($redis->lRange('y', 0, -1));


	














