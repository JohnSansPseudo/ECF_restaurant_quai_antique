<?php


class ParamException extends \Exception
{
    static public function getMessageParamError($e): string
    {
        return  $e->getMessage() . '<br/>File : ' . $e->getFile() . ' at line : ' . $e->getLine() . '<br/>' . $e->getCode(). '<br/><br/>';
    }
}