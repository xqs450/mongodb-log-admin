<?php
/**
 * Created by PhpStorm.
 * User: Qson
 * Date: 2020/6/24
 * Time: 15:27
 */
use \MongodbLog\SearchLogApp;
require_once "./vendor/mongodb-log/tests/autoload.php";
if(isset($_GET["method"])){
    $method = $_GET["method"];
    switch ($method){
        case "login":
            login();
            break;
        case "logout":
            logout();
            break;
        case "search-log":
            searchLog();
            break;
        case "is-login":
            isLogin();
            break;
    }
}
function login(){
    $userName   = $_REQUEST["user_name"];
    $pwd        = $_REQUEST["pwd"];
    if($userName == "admin" && $pwd=="3565lkju786"){
        session_start();
        $_SESSION['admin_user'] = 'admin';
        $ret =  ["code"=>200,"message"=>"成功"];
        echo json_encode($ret);die();
    }
    $ret =  ["code"=>201,"message"=>"登入失败"];
    echo json_encode($ret);die();
}

function logout(){
    session_start();
    if(isset($_SESSION['admin_user'])){
        unset($_SESSION['admin_user']);
        $ret =  ["code"=>200,"message"=>"成功"];
        echo json_encode($ret);die();
    }
    $ret =  ["code"=>201,"message"=>"失败"];
    echo json_encode($ret);die();
}
function searchLog(){
    $config = [
        "base_log_path"=>"F:/www/html/data/",
        "db_name"=>"test2",
        'table'=>'mobile',
        'host'=>'mongodb://localhost:27017',
        'per_read_line_num'=>1000
    ];
    SearchLogApp::init($config);
    $pageInfo = ["pageSize"=>10,"currentPage"=>1];
    $data = SearchLogApp::search([],$pageInfo);
    $ret = ["code"=>0,"msg"=>"成功","data"=>$data['list'],"count"=>$data['pagination']['total']];
    echo   json_encode($ret);
}
function isLogin(){
    session_start();
    if(isset($_SESSION['admin_user'])){
        $ret =  ["code"=>200,"message"=>"成功"];
        echo json_encode($ret);die();
    }
    $ret =  ["code"=>201,"message"=>"没有登入"];
    echo json_encode($ret);die();
}
