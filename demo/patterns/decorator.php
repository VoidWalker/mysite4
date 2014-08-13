<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 24.07.14
 * Time: 13:52
 */
abstract class ACourse{
    abstract function action();

}
class Course extends ACourse{

    function action(){}
}
abstract class ACourseDecorator extends ACourse{
    private $_course;
    function __construct(ACourse $course){
        $this->_course = $course;
    }
    function action(){
        $this->_course->action();
    }
}
class CourseDecorator extends ACourseDecorator{
    function action(){
        //.....
        parent::action();
        //....
    }


}

$c = new CourseDecorator(new Course());
$c->action();