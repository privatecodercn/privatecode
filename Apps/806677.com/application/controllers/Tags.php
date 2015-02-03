<?php
class TagsController extends Controller
{
	
	public function indexAction($tag)
	{
		
		$vars = [
			'tag' => $tag,
// 			'seoTitle' => $detail->title
		];

		$this->getView()->assign($vars);
		return false;
	}
	
}
