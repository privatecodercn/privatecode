<?php
/**
 * 文章模型
 * Create     : 2013-11-28
 * Modified   : 2013-11-28
 * @link      : http://www.59c.net
 * @copyright : (C) 2013 59C.NET
 * @version   : 1.0.0
 * @author    : Joseph Chen <me@59.net>
 */
class ArticleModel
{
	/**
	 * 表名(不含前缀)
	 * @var string
	 */
	public $_tbl = 'article';
	/**
	 * 表名
	 * @var string
	 */
	public $tbl = 'article';
	/**
	 * 保存文章内容表
	 * @var string
	 */
	public $tbl_content = 'article_content';
	/**
	 * 文章内容保存方式:txt-文本文件内容保存，db-保存到数据库独立的表，空-与文章内容表一起保存
	 * @var string
	 */
	public $saveContentType = 'db';
	/**
	 * 文章内容以文本文件保存时的存储路径，相对于应用根路径
	 * @var string
	 */
	public $saveContentPath = 'article';
	/**
	 * 保存文章内容，静态页等相关文件路径的ID基数
	 * @var int
	 */
	public $pathRadix = 1000;
	/**
	 * 状态列表
	 * @var array
	 */
	public $statusList = array(
		-1	=> '删除',
		0	=> '待审核',
		1	=> '正常',
	);
	/**
	 * 验证字段及规则列表
	 * @var array
	 */
	public $validation = array(
		'title'	=> 'require'
	);
	/**
	 * 提示信息
	 * @var string
	 */
	public $msg = '';
	public $saveMore = true;
	
	/**
	 * 是否取全部内容还是只取分页
	 * @var int
	 */
	public $readContentPage = 0;
	/**
	 * 保存的tag关联类型
	 * @var int
	 */
	private $tagType = 2;
	
	/**
	 * 构造函数
	 * @param int $id
	*/
	public function __construct()
	{
	}

	/**
	 * 保存文章内容
	 * @param array $data
	 */
	public function save($data)
	{
		// 验证字段
		if (isset($data['title']) && $data['title'])
		{
			$title = $data['title'];
		} else {
			$this->msg = '文章标题不能为空！';
			return false;
		}
		if (isset($data['content']) && $data['content'])
		{
			$content = $data['content'];
		} else {
			$this->msg = '文章内容不能为空！';
			return false;
		}
		// 创建Db对象
		if (empty($data['id']))
		{
			$article = Db::table('article');
		} else {
			$article = Db::table('article')->findOne($data['id']);
			if (!$article->id)
			{
				return false;
			}
		}
		$article->is_copy = isset($data['is_copy']) ? (int)$data['is_copy'] : 0;
		$view = isset($data['views']) ? (int)$data['views'] : 0;
		if ($view && $article->views!=$view)
		{
			$article->views = $view;
		}
		$article->post_time = $data['post_time'];
		if ($article->isNew())
		{
			$article->create_time = time();
		}
		$article->comments = isset($data['comments']) ? (int)$data['comments'] : 1;
		$article->post_time = isset($data['post_time']) ? (int)$data['post_time'] : 1;
		$article->create_time = time();
		$cover_image_id = (int)$data['cover_image_id'];
		$article->status = isset($data['status']) ? (int)$data['status'] : 1;
		$article->orderid = isset($data['orderid']) ? (int)$data['orderid'] : 0;
		$article->title = $title;
		$article->cover_image_id = $cover_image_id;
		$article->cover_image = isset($data['cover_image']) ? $data['cover_image'] : '';
		$article->editor = isset($data['editor']) ? $data['editor'] : '';
		$article->author = isset($data['author']) ? $data['author'] : '';
		$article->redirect = isset($data['redirect']) ? $data['redirect'] : '';
		$article->source = isset($data['source']) ? $data['source'] : '';
		$article->source_url = isset($data['source_url']) ? $data['source_url'] : '';
		
		if ($article->isNew())
		{
			$isNew = true;
			$article->save();
		} else {
			$isNew = false;
		}
		
		/**
		 * 保存tag信息
		 */
		$tag = new TagModel();
		$tagData = array(
			'tags'		=> $data['tags'],
			'target_id'	=> $article->id,
			'type'		=> 1,
		);
		$result = $tag->save($tagData);
		if (!$result)
		{
			return false;
		}

		/**
		 * 保存图片关联信息
		 */
		if ($cover_image_id)
		{
			$result = Db::table('pics')
			             ->where('id', $cover_image_id)
			             ->update(['tid'=>$article->id]);
			if (!$result)
			{
				return false;
			}
		}
		
		// 更新文章表
		if ($tag->updateData)
		{
			$article->tag_ids = $tag->updateData['tag_ids'];
			$article->tags = $tag->updateData['tags'];
		}
		
		$result = $article->save();
		if (!$result)
		{
			return false;
		}
		if ($isNew)
		{
			$articleContent = Db::table('article_content');
			$articleContent->id = $article->id;
		} else {
			$articleContent = Db::table('article_content')->findOne($article->id);
			if (!$articleContent)
			{
				$articleContent = Db::table('article_content');
				$articleContent->id = $article->id;
			}
		}
		
		$articleContent->content = $content;
		return $articleContent->save();
	}

	/**
	 * 获取文章ID对应的HTML静态页路径
	 * @param int $id
	 * @param string $filename
	 * @return string
	 */
	public function getHtmlFile($id, $filename='')
	{
		if (!$filename)
		{
			$filename = String::idCrypt($id);
		}
		$subdir = substr($filename, 0, 3);
		return "a/{$subdir}/{$filename}.html";
	}

	/**
	 * 获取文章ID对应的HTML静态页URL
	 * @param int $id
	 * @param string $filename
	 * @return string
	 */
	public function getHtmlUrl($id, $filename='')
	{
		if (!$filename)
		{
			$filename = String::idCrypt($id);
		}
		$subdir = substr($filename, 0, 3);
		return "a-{$filename}.html";
	}

}