﻿<?php
/* Пути по-умолчанию для поиска файлов */
set_include_path(get_include_path()
					.PATH_SEPARATOR.'application/controllers'
					.PATH_SEPARATOR.'application/models'
					.PATH_SEPARATOR.'application/views');

/* Имена файлов: views */
define('USER_DEFAULT_FILE', 'user_default.php');
define('USER_ROLE_FILE', 'user_role.php');
define('USER_LIST_FILE', 'user_list.php');
define('USER_ADD_FILE', 'user_add.php');

/* Текстовая база данных пользователей */
define('USER_DB', $_SERVER["DOCUMENT_ROOT"].'/data/users.txt');

/* Автозагрузчик классов */
function __autoload($class){
	require_once($class.'.php');
}

/* Инициализация и запуск FrontController */
$front = FrontController::getInstance();
$front->route();

/* Вывод данных */
echo $front->getBody();