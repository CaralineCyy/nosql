<?php
   //创建一个redis客户端
   $redis = new Redis();

   //连接到一个redis实例
   $redis->connect('127.0.0.1', 6379);
   echo "Connection to server sucessfully";

   //查看服务是否运行
   echo "Server is running: " . $redis->ping();
   echo '<br/>';
   
   //get/set操作
   $redis->set('cyy','123');
   echo '<br/>';
   
   //关闭连接
   //$redis->close();
   echo $redis->get('cyy');
   echo '<br/>';

   $key = $redis->randomKey();
   $surprise=$redis->get($key);
   echo $surprise;
   echo '<br/>';


   //数据在数据库之间的切换
   $redis->select(0);
   $redis->set('x','42');
   $redis->move('x',1);
   $redis->select(1);
   $val = $redis->get('x');
   echo $val.'<br/>';

   //数据重命名(引用)
   $redis->set('x','42');
   $redis->rename('x', 'y');
   $val1 = $redis->get('x');
   $val2 = $redis->get('y');
   echo $val1.'<br/>'.$val2.'<br/>';

   //数据重命名(复制了一份新的key-value键值对)
   $redis->set('xx','45');
   $redis->renameNx('xx','yy');
   $val3 = $redis->get('xx');
   $val4 = $redis->get('yy');
   $redis->set('xx','39');
   $val5 = $redis->get('xx');
   $val6 = $redis->get('yy');
   echo $val3.'<br/>'.$val4.'<br/>'.$val5.'<br/>'.$val6.'<br/>';


   //设置生命周期(单位秒)
   $redis->set('a','42');
   $redis->setTimeout('a', 3);
   //sleep(5);
   echo $redis->get('a').'<br/>';


   //设置生命周期(单位unix时间戳)
   $redis->set('b','des');
   $now = time(null);
   $redis->expireAt('b',$now+3);
   //sleep(5);
   echo $redis->get('b').'<br/>';

   //返回某种计算模式取得的keys
   $allKeys=$redis->keys('*');
   $keyWithUserPrefix=$redis->keys('*');
   print_r($keyWithUserPrefix);
   echo '<br/>';

   //返回数据库中有多少个key
   $count=$redis->dbSize();
   echo "Redis has $count keys\n";
   echo '<br/>';

   //使用密码验证链接
   //$redis->auth('foobared');

   //使用aof来进行数据库的持久化
   //$redis->bgrewriteaof();
   //同步写入到磁盘
   //$redis->save();
   //异步写入到磁盘
   //$redis->bgSave();

   //返回最后一次数据磁盘持久化的时间
   echo $redis->lastSave().'<br/>';

   //返回key所指向的VALUE的数据类型
   //$redis->type('key');


   //强制刷新当前DB
   //$redis->flushDB();

   //强制刷新所有DB
   //$redis->flushAll();


   //sort筛选
   $redis->delete('s');
   $redis->sadd('s', 5);
   $redis->sadd('s', 4);
   $redis->sadd('s', 2);
   $redis->sadd('s', 1);
   $redis->sadd('s', 3);
   var_dump($redis->sort('s')); // 1,2,3,4,5
   echo '<br/>';
   var_dump($redis->sort('s', array('sort' => 'desc'))); // 5,4,3,2,1
   echo '<br/>';
   var_dump($redis->sort('s', array('sort' => 'desc', 'store' => 'out'))); // (int)5
   echo '<br/>';


   //类似于php的phpinfo函数，返回redis系统的相关信息
   $info = $redis->info();
   echo '<pre>';
   print_r($info);


   //取得一个KEY已经存在的时间,以毫秒位单位，KEY不存在则返回FALSE
   echo  $redis->ttl('s');

   //删除一个key的生命周期，如果确实有生命周期，就成功的移除，如果key不存在或者没有生命周期，则返回false
   //$redis->persist('key');

   
   //获取或者设置系统配置系统配置keys   ????
   $redis->config("GET", "*max-*-entries*");
   // $redis->config("SET", "dir", "/var/run/redis/dumps/");



   










   






























   
   
   
   
   
    