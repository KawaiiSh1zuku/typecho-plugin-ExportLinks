<?php
/**
 * 导出博客的友情链接为 Friend-Circle-Lite 的格式
 * 
 * @package     ExportLinks 
 * @author      Sh1zuku <https://omn.cc>
 * @link        https://omn.cc
 * @version     0.0.1
 * @copyright   Copyright (C) 2025, https://omn.cc
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class ExportLinks_Plugin implements Typecho_Plugin_Interface
{
    public static function activate()
    {
        // 初始化默认配置
        $config = [
            'dummy' => '1' // 添加虚拟配置项
        ];
        Helper::configPlugin('ExportLinks', $config);
        
        Helper::addAction('export-links', 'ExportLinks_Action');
        return _t('插件已激活，请进入设置页面使用导出功能');
    }

    public static function deactivate()
    {
        Helper::removeAction('export-links');
    }

    public static function config(Typecho_Widget_Helper_Form $form)
    {
        // 添加虚拟隐藏字段
        $dummy = new Typecho_Widget_Helper_Form_Element_Hidden('dummy', NULL, '1');
        $form->addInput($dummy);

        // 导出按钮
        $export = new Typecho_Widget_Helper_Form_Element_Submit();
        $export->value(_t('导出友链数据'));
        $export->description(_t('点击后将会下载包含所有友链数据的JSON文件'));
        $export->input->setAttribute('formaction', 
            Typecho_Common::url('/action/export-links', Helper::options()->index));
        $form->addItem($export);
    }

    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
    public static function render(){}
}
?>