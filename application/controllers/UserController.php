<?php
/**
 * Created by PhpStorm.
 * User: Sasha
 * Date: 01.09.14
 * Time: 21:57
 */
class UserController implements IController{

    public function helloAction(){
        $frontController = FrontController::getInstance();
        $param = $frontController->getParams();
        $view = new FileModel();
        $view->name = $param['name'];
        $result = $view->render(USER_DEFAULT_FILE);
        $frontController->setBody($result);
    }

    public function listAction(){
        $frontController = FrontController::getInstance();
        $view = new FileModel();
        $view->list = unserialize(file_get_contents(USER_DB));
        $result = $view->render(USER_LIST_FILE);
        $frontController->setBody($result);
    }

    public function getAction(){
        $frontController = FrontController::getInstance();
        $param = $frontController->getParams();
        $view = new FileModel();
        $view->name = $param['name'];
        $view->list = unserialize(file_get_contents(USER_DB));
        $result = $view->render(USER_ROLE_FILE);
        $frontController->setBody($result);
    }

    public function addAction(){
        $frontController = FrontController::getInstance();
        $param = $frontController->getParams();
        $view = new FileModel();
        $view->name = $param['name'];
        $list = unserialize(file_get_contents(USER_DB));
        $list[$param['name']] = $param['role'];
        file_put_contents(USER_DB, serialize($list));
        $view->list = $list;
        $result = $view->render(USER_ADD_FILE);
        $frontController->setBody($result);
    }
}