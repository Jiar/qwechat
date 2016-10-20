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