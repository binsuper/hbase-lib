<?php

if (!function_exists('millisecond')) {

    /**
     * 毫秒时间戳
     *
     * @return string
     */
    function millisecond(): string {
        return str_replace('.', '', microtime(true));
    }

}