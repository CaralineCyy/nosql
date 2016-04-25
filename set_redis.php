<?php
	//创建一个redis客户端
	$redis = new Redis();

	//连接到一个redis实例
	$redis->connect('127.0.0.1', 6379);


	//如果VALUE不存在于SET中，那么ADDED成功，返回TRUE，否则返回FALSE。
	$redis->sAdd('key13' , 'member1'); /* TRUE, 'key1' => {'member1'} */
	$redis->sAdd('key13' , 'member2'); /* TRUE, 'key1' => {'member1', 'member2'}*/
	$redis->sAdd('key13' , 'member2'); /* FALSE, 'key1' => {'member1', 'member2'}*/


	//sRem,sRomove从集合中移除指定的元素，成功则返回true,否则返回false
	$redis->sAdd('key1' , 'member1');
	$redis->sAdd('key1' , 'member2');
	$redis->sAdd('key1' , 'member3'); /* 'key1' => {'member1', 'member2', 'member3'}*/
	$redis->sRem('key1', 'member2'); /* 'key1' => {'member1', 'member3'} */


	//sMove把key1中的member13移动到key2中
	$redis->sAdd('key1' , 'member11');
	$redis->sAdd('key1' , 'member12');
	$redis->sAdd('key1' , 'member13'); /* 'key1' => {'member11', 'member12', 'member13'}*/
	$redis->sAdd('key2' , 'member21');
	$redis->sAdd('key2' , 'member22'); /* 'key2' => {'member21', 'member22'}*/
	$redis->sMove('key1', 'key2', 'member13'); /* 'key1' =>  {'member11', 'member12'} */
	                /* 'key2' =>  {'member21', 'member22', 'member13'} */


    //判断某一个值  是否是一个集合的元素
	$redis->sAdd('key1' , 'member1');
	$redis->sAdd('key1' , 'member2');
	$redis->sAdd('key1' , 'member3'); /* 'key1' => {'member1', 'member2', 'member3'}*/
	$redis->sIsMember('key1', 'member1'); /* TRUE */
	$redis->sIsMember('key1', 'memberX'); /* FALSE */


	//sCard,sSize返回SET容器的成员数
	$redis->sAdd('key1' , 'member1');
	$redis->sAdd('key1' , 'member2');
	$redis->sAdd('key1' , 'member3'); /* 'key1' => {'member1', 'member2', 'member3'}*/
	$redis->sCard('key1'); /* 3 */
	$redis->sCard('keyX'); /* 0 */


	//sPop随机返回一个元素，并且在SET容器中移除该元素
	$redis->sAdd('key1' , 'member1');
	$redis->sAdd('key1' , 'member2');
	$redis->sAdd('key1' , 'member3'); /* 'key1' => {'member3', 'member1', 'member2'}*/
	$redis->sPop('key1'); /* 'member1', 'key1' => {'member3', 'member2'} */
	$redis->sPop('key1'); /* 'member3', 'key1' => {'member2'} */

	//sRandMember取得指定SET容器中的一个随机元素，但不会在SET容器中移除它
	$redis->sAdd('key1' , 'member1');
	$redis->sAdd('key1' , 'member2');
	$redis->sAdd('key1' , 'member3'); /* 'key1' => {'member3', 'member1', 'member2'}*/
	$redis->sRandMember('key1'); /* 'member1', 'key1' => {'member3', 'member1', 'member2'} */
	$redis->sRandMember('key1'); /* 'member3', 'key1' => {'member3', 'member1', 'member2'} */


	//返回指定SETS集合的交集结果,下面的每一个key又都是一个集合
	$redis->sAdd('key1', 'val1');
	$redis->sAdd('key1', 'val2');
	$redis->sAdd('key1', 'val3');
	$redis->sAdd('key1', 'val4');
	$redis->sAdd('key2', 'val3');
	$redis->sAdd('key2', 'val4');
	$redis->sAdd('key3', 'val3');
	$redis->sAdd('key3', 'val4');
	var_dump($redis->sInter('key1', 'key2', 'key3'));
	echo '<br/>';


	//sInterStore取交集，并且把交集存到一个新的集合里
	$redis->sAdd('key1', 'val1');
	$redis->sAdd('key1', 'val2');
	$redis->sAdd('key1', 'val3');
	$redis->sAdd('key1', 'val4');
	$redis->sAdd('key2', 'val3');
	$redis->sAdd('key2', 'val4');
	$redis->sAdd('key3', 'val3');
	$redis->sAdd('key3', 'val4');
	var_dump($redis->sInterStore('output', 'key1', 'key2', 'key3'));
	var_dump($redis->sMembers('output'));
	echo '<br/>';


	//sUnion执行一个并集操作,返回一个新的集合
	$redis->delete('s0', 's1', 's2');
	$redis->sAdd('s0', '1');
	$redis->sAdd('s0', '2');
	$redis->sAdd('s1', '3');
	$redis->sAdd('s1', '1');
	$redis->sAdd('s2', '3');
	$redis->sAdd('s2', '4');
	var_dump($redis->sUnion('s0', 's1', 's2'));
	echo '<br/>';


	//sUnionStore返回并集，并且存到一个新的数组里面
	$redis->delete('s0', 's1', 's2');
	$redis->sAdd('s0', '1');
	$redis->sAdd('s0', '2');
	$redis->sAdd('s1', '3');
	$redis->sAdd('s1', '1');
	$redis->sAdd('s2', '3');
	$redis->sAdd('s2', '4');
	var_dump($redis->sUnionStore('dst', 's0', 's1', 's2'));
	var_dump($redis->sMembers('dst'));
	echo '<br/>';


	//sDiff返回的是存在于第一个集合中而不存在其他的集合中的元素
	$redis->delete('s0', 's1', 's2');
	$redis->sAdd('s0', '1');
	$redis->sAdd('s0', '2');
	$redis->sAdd('s0', '3');
	$redis->sAdd('s0', '4');
	$redis->sAdd('s1', '1');
	$redis->sAdd('s2', '3');
	var_dump($redis->sDiff('s0', 's1', 's2'));
	echo '<br/>';


	//差集，并用新的集合保存起来
	$redis->delete('s0', 's1', 's2');
	$redis->sAdd('s0', '1');
	$redis->sAdd('s0', '2');
	$redis->sAdd('s0', '3');
	$redis->sAdd('s0', '4');
	$redis->sAdd('s1', '1');
	$redis->sAdd('s2', '3');
	var_dump($redis->sDiffStore('dst', 's0', 's1', 's2'));
	var_dump($redis->sMembers('dst'));
	echo '<br/>';


	//返回集合中的所有的元素
	$redis->delete('s');
	$redis->sAdd('s', 'a');
	$redis->sAdd('s', 'b');
	$redis->sAdd('s', 'a');
	$redis->sAdd('s', 'c');
	var_dump($redis->sMembers('s'));












	













