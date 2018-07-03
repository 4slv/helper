<?php

namespace Slov\Helper;

use ReflectionClass;
use ReflectionException;

/** Хелпер для работы с классами */
class ClassHelper
{
    /** Получение комментария класса
     * @param mixed $classInstance экземпляр класса
     * @return string комментарий класса */
    public static function getClassComment($classInstance)
    {
        try {
            $reflectionClass = new ReflectionClass(get_class($classInstance));
            $accountComment = $reflectionClass->getDocComment();
            if(
                preg_match(
                    '/\/\*\*\s*(.+?)\s*\*\//msi',
                    $accountComment,
                    $commentMatch
                )
            ){
                return $commentMatch[1];
            }
        } catch (ReflectionException $exception) {}
    }

    /** Получение комментария метода
     * @param mixed $classInstance экземпляр класса
     * @return string комментарий класса */
    public static function getMethodComment($classInstance, $methodInstance)
    {
        try {
            $reflectionClass = new ReflectionClass(get_class($classInstance));
            $method = $reflectionClass->getMethod($methodInstance);
            $methodComment = $method->getDocComment();

            if(
            preg_match(
                '/\/\*\*\s*(.+?)\s*\*\//msi',
                $methodComment,
                $commentMatch
            )
            ){
                return $commentMatch[1];
            }

        } catch (ReflectionException $exception) {}
    }

    /** Получает массив с типами аргументов метода и возвращаемого значения
     * @param mixed $classInstance экземпляр класса
     * @param string $methodInstance имя метода
     * @return array массив с типами */
    public static function getParamsTypeFromMethodComment($classInstance, $methodInstance)
    {
        try {
            $reflectionClass = new ReflectionClass(get_class($classInstance));
            $method = $reflectionClass->getMethod($methodInstance);
            $methodComment = $method->getDocComment();

            $allParam = array();
            foreach(preg_split("/(\r?\n)/", $methodComment) as $line){
                if(preg_match('/(@param)(\s)+(\w)+/', $line, $match)){
                    $paramType = preg_split('/(\s)+/', $match[0]);
                    $allParam['param'][] = $paramType[1];
                } else if(preg_match('/(@return)(\s)+(\w)+/', $line, $match)){
                    $paramType = preg_split('/(\s)+/', $match[0]);
                    $allParam['return'][] = $paramType[1];
                }
            }

            return $allParam;

        } catch (ReflectionException $exception) {}
    }
}
