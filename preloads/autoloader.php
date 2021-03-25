<?php

/**
 * @see http://www.php-fig.org/psr/psr-4/examples/
 */
spl_autoload_register(static function ($class) {
    // var_dump('class:'.$class);
    // echo('<br>');

    // project-specific namespace prefix
    $prefix = 'XoopsModules\\' . ucfirst(basename(dirname(__DIR__)));
    // var_dump('$prefix:'.$prefix);
    // echo('<br>');
    // base directory for the namespace prefix
    $baseDir =  dirname(__DIR__) . '/class/';
    // var_dump('$baseDir:'.$baseDir);
    // echo('<br>');
    // does the class use the namespace prefix?
    $len = mb_strlen($prefix);
    // var_dump('$len:'.$len);
    // echo('<br>');
    // var_dump(0 !== strncmp($prefix, $class, $len));
    // echo('<br>');

    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    // get the relative class name
    $relativeClass = mb_substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    // var_dump('class:'.$class);
    // echo('<br>');
    // var_dump('$prefix:'.$prefix);
    // echo('<br>');
    // var_dump('$baseDir:'.$baseDir);
    // echo('<br>');
    // var_dump('$len:'.$len);
    // echo('<br>');
    // var_dump(strncmp($prefix, $class, $len));
    // echo('<br>');
    // var_dump('$relativeClass:'.$relativeClass);
    // echo('<br>');
    // var_dump('$file:'.$file);
    // echo('<br>');
    // die();

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});
