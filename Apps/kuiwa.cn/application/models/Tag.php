<?php
/**
 * 文章模型
 * Create     : 2013-06-28
 * Modified   : 2014-07-26
 * @link      : http://www.59c.net
 * @copyright : (C) 2013 - 2014 59C.NET
 * @version   : 1.0.0
 * @author    : Joseph Chen <chenliq@gmail.com>
 */
class TagModel
{
    /**
     * 表名(不含前缀)
     * @var string
     */
    public $_tbl = 'tags';
    /**
     * 表名
     * @var string
     */
    public $tbl = 'tags';

    /**
     * 是否还有更多要保存的内容
     * @var boolean
     */
    public $saveMore = true;
    
    /**
     * 更新的tag相关字段内容
     * @var array
     */
    public $updateData = [];
    
    /**
     * 构造函数
     * @param int $id
    */
    public function __construct()
    {
        
    }

    /**
     * 保存更多字段信息
     * @param array $data
     */
    public function save($data=null)
    {
        if (empty($data['tags']))
        {
            return true;
        }
        $targetId = $data['target_id'];
        $type = $data['type'];
        // 保存TAGS
        if (is_array($data['tags']))
        {
            $tags = join(',', $data['tags']);
        } else {
            $tags = strtr($data['tags'], ['，'=>',', ' '=>',']);
            $tags = preg_replace('/[\s]*,[\s]*/', ',', $tags);
            $tags = trim($tags, ',');
            $tags = trim($tags);
        }
        $tags = mb_strtolower($tags);
        $this->updateData['tags'] = $tags;
        // 已有的TAG
        $arr = Db::table('tags')
                ->selectColumns('id, name')
                ->whereIn('name', explode(',', $tags))
                ->findArray();
        if ($arr)
        {
            $tagList = Arr::simple($arr);
        } else {
            $tagList = [];
        }
        // 转成数组
        $tags = explode(',', $tags);
        // 已存在的tagID列表
        $existTagIds = array_keys($tagList);
        // 添加新增的TAG
        $newTags = array_diff($tags, $tagList);
        $newTagIds = [];
        // 新增关联TAG
        $addTagData = [];
        foreach ($newTags as $tagName) 
        {
            $tagName = mb_strtolower(trim($tagName));
            if (empty($tagName))
            {
                continue;
            }
            $tagData = [
                'name'    => $tagName,
                'num'    => 1,
                'hot'    => 0
            ];
            $tagOrm = Db::table('tags');
            $tagOrm->set($tagData);
            $tagOrm->save();
            $tid = $tagOrm->id;
            $tagList[$tid] = $tagName;
            $newTagIds[] = $tid;
            // 新增关联
            $addTagData[] = [
                'tagid'            => $tid,
                'target_id'        => $targetId,
                'target_type'    => $type
            ];
        }
        $tagIds = array_keys($tagList);
        sort($tagIds);
        // 文章表待更新的tagid列表
        $this->updateData['tag_ids'] = join(',', $tagIds);
        // 获取已关联的tag
        $_arr = Db::table('tag_data')
                ->selectColumns('tagid')
                ->where('target_id', $targetId)
                ->findArray();
        $arr = [];
        if ($_arr)
        {
            foreach ($_arr as $v)
            {
                $arr[] = $v['tagid'];
            }
        }
        // 计算出新增的tagID关联
        $newRelateTagIds = array_diff($existTagIds, $arr);
        // 新增引用的TAGID引用数+1
        Db::table('tags')->whereIn('id', $newRelateTagIds)->plus('num', 1);
        
        foreach ($newRelateTagIds as $tid)
        {
            $addTagData[] = [
                'tagid'            => $tid,
                'target_id'        => $targetId,
                'target_type'    => $type,
            ];
        }
        foreach ($addTagData as $data) {
            Db::table('tag_data')->insert($data);
        }
        
        // 计算出不再引用的tagID
        $dropExistTagIds = array_diff($arr, $tagIds);
        if ($dropExistTagIds)
        {
            // 不再引用的TAGID引用数减 1
            Db::table('tags')->whereIn('id', $dropExistTagIds)->plus('num', -1);
            // 去除不再引用TAG关联
            Db::table('tag_data')
                ->where('target_id', $targetId)
                ->whereIn('tagid', $dropExistTagIds)
                ->delete($sql);
        }
        
        return true;
    }
    /**
     * 获取列表
     * @param array $options
     * @example [
     *     'cid'        => $cid,// 分类ID
     *     'keyword'    => $keyword,// 关键字
     *     'post_time'    => $post_time,// 发布日期
     *     'post_time2'=> $post_time2,// 发布日期截止时间
     *     'status'    => $status,// 状态
     *     'order'        => $order,// 排序字段
     *     'limit'        => $limit,// 获取记录数
     *     'has_page'    => $has_page,// 是否分页
     *  'fields'    => $fields//字段列表
     * ]
     */
    public function getList($options=[])
    {
        extract($options);
        if (!isset($fields)) {
            $fields = 'id,name,num,hot';
        }
        if (!isset($where)) {
            $where = null;
        }
        if (!isset($limit)) {
            $limit = $this->pageSize;
        }
        if (!isset($order)) {
            $order = 'hot desc, id desc';
        }
        if (!isset($params))
        {
            $params = null;
        }
        // 是否有分页
        if (isset($has_page) && $has_page) {
            $rows = $this->where($where)->params($params)->count();
            Page::init($limit, $rows);
            $this->pagePanel = Page::generateBarCode();
            $start = Page::$from;
        } else {
            $start = 0;
        }

        $list = $this->field($fields)->where($where)->params($params)
                    ->order($order)->limit($limit, $start)->select();
        if (!$list)
        {
            $list = [];
        }
        return $list;
    }

}