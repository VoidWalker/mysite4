<?php
// Тестирование операторов массива

$arr = array();
// $arr - должен быть пустой массив.

$arr[] = 'element';
// $arr - содержит один элемент.
?>

<?php
// Использование вывода на экран для проверки операторов массива

$arr = array();
print count($arr) . "\n";

$arr[] = 'element';
print count($arr) . "\n";
?>

<?php
//Тестирование операторов массива, сравнение ожидаемого результата и фактического значения
$arr = array();
print count($arr) == 0 ? "ok\n" : "not ok\n";

$arr[] = 'element';
print count($arr) == 1 ? "ok\n" : "not ok\n";
?>

<?php
// Использование функции утверждения для тестирования операторов массива

function assertTrue($condition){
	if(!$condition) {
		throw new Exception('Assertion failed.');
	}
}
$arr = array();
assertTrue(count($arr) == 0);

$arr[] = 'element';
assertTrue(count($arr) == 1);
?>