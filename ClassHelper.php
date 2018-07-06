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
}
