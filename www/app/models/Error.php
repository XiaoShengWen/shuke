<?php
class Error
{
    const ERR_OK     = 0;
    const ERR_PARAMS = 1;

    public static $errMsg = [
        self::ERR_OK     => "操作成功",
        self::ERR_PARAMS => "参数错误",
    ];

    public static function getErrMsg($code)
    {  
        $ret = "错误信息不存在";
        if (isset(self::$errMsg[$code])) {
            $ret = self::$errMsg[$code];
        }
        return $ret;
    }
}
