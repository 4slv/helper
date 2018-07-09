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
    
    /** Получение комментария параметра класса
     * @param mixed $classInstance объект класса
     * @param string $parameterName название параметра
     * @return string комментарий параметра */
    public static function getClassParameterComment($classInstance, string $parameterName)
    {
        $reflection = new ReflectionClass($classInstance);
        preg_match(
            '/\/\*\*\s+@var\s+[^\s]*\s+([^\*]*)/',
            $reflection->getProperty($parameterName)->getDocComment(),
            $match
        );
        if (isset($match[1]) && !empty($match[1])) {
            return $match[1];
        }
        return null;
    }
}
