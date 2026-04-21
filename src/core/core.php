<?php
namespace faqs;

class Core
{

    public static function load($path)
    {
        return require_once FAQS_PATH . 'src/' . $path;
    }
}
