<?php
return array(
	//'配置项'=>'配置值'
	'APP_GROUP_LIST' => 'Home,Manager', //项目分组设定，注意','后面全完不要有空格！！
	'DEFAULT_GROUP'  => 'Home', //默认分组

	'URL_PATHINFO_DEPR' => '-',
	'VAR_URL_PARAMS'	=> '_URL_',
	'URL_MODEL' => 0,		//学校这个虚拟服务器好像不支持PATHINFO的URL模式，就只能舍易求繁了

    //数据库配置信息
	'DB_TYPE'   => 'mysql', // 数据库类型
	'DB_HOST'   => '121.193.130.58', // 服务器地址
	'DB_NAME'   => 'tjuxinmeiti', // 数据库名
	'DB_USER'   => 'tjuxinmeiti', // 用户名
	'DB_PWD'    => 'xinmeiti', // 密码
	'DB_PORT'   => 3306, // 端口
	'DB_PREFIX' => 'twwx_', // 数据库表前缀 

	'WXMP_USERNAME' => 'y02tju',//'suchang1111@126.com',	//'y02tju',
	'WXMP_PASSWORD' => 'tjuhast',//'9012224714sc',			//'tjuhast',
	'APP_ID'	=> 'wxdf06311d90eccb32',
	'APP_SECRET'	=> 'f46547f1cc27f76e93169461d74f523f'
);
?>