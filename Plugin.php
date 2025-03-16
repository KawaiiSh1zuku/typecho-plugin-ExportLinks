<?php
/**
 * 导出博客的友情链接为 Friend-Circle-Lite 的格式
 * 
 * @package     ExportLinks 
 * @author      Sh1zuku <https://omn.cc>
 * @link        https://omn.cc
 * @version     0.0.2
 * @copyright   Copyright (C) 2025, https://omn.cc
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class ExportLinks_Plugin implements Typecho_Plugin_Interface
{
    public static function activate()
    {
        Helper::addAction('firends', 'ExportLinks_Action');
        return _t('插件已激活，访问 /action/firends 即可得到数据');
    }

    public static function deactivate()
    {
        Helper::removeAction('firends');
    }

    public static function config(Typecho_Widget_Helper_Form $form) {}

    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
    public static function render(){}
}
?>