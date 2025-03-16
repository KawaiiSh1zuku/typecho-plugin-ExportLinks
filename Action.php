<?php
class ExportLinks_Action extends Typecho_Widget
{
    public function execute()
    {
        // 验证用户权限
        $user = Typecho_Widget::widget('Widget_User');
        if (!$user->pass('administrator')) {
            throw new Typecho_Exception(_t('权限不足'), 403);
        }

        // 检查links表是否存在
        $db = Typecho_Db::get();
        $adapterName = $db->getAdapterName();
        $prefix = $db->getPrefix();
        
        if (!in_array($adapterName, ['Mysql', 'Pdo_Mysql'])) {
            throw new Typecho_Exception(_t('当前仅支持MySQL数据库'));
        }

        try {
            $db->fetchRow($db->select()->from('table.links')->limit(1));
        } catch (Typecho_Db_Exception $e) {
            throw new Typecho_Exception(_t('友情链接表不存在，请确认Links插件已安装'));
        }

        // 获取友链数据
        $links = $db->fetchAll($db->select('name', 'url', 'image')->from('table.links'));

        // 构建JSON结构
        $output = ['friends' => []];
        foreach ($links as $link) {
            $output['friends'][] = [
                $link['name'],
                $link['url'],
                $link['image']
            ];
        }

        // 输出JSON文件
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="friends_export_' . date('YmdHis') . '.json"');
        echo json_encode($output, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        exit;
    }
}
?>