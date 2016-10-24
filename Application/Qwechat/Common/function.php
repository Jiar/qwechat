<?php

/**
 * 判断一个PHP数组是关联数组还是数字数组
 *
 * @param $arr  传入变量
 * @return bool 是否为关联数组
 */
function is_assoc($arr) {
    return array_keys($arr) !== range(0, count($arr) - 1);
}

/**
 * 构建错误信息并返回
 *
 * @param $error  错误信息
 * @return string 构建后的错误信息
 */
function structureErrorInfo($error) {
    if(!is_assoc($error)) {
        return $error;
    }
    $result = "Error:</br>";
    foreach($error as $key=>$value) {
        $result = $result .$key ."&nbsp:&nbsp" .$value ."</br>";
    }
    return $result;
}