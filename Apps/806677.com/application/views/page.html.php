
					<div class="pagination">
						<ul>
						<?php if (Page::$page != 1) {?>
<li><a href="<?=Page::getPageUrl(1)?>">&laquo; 首页</a></li>&nbsp;
<li><a href="<?=Page::getPageUrl(Page::$page-1)?>" rel="prev">&laquo; 上一页</a></li>&nbsp;
						<?php }?>
						<?php
						if (Page::$page <= 5)
						{
							$startPage = 1;
							$endPage = (Page::$total>=8) ? 8 : Page::$total;
						} else if ((Page::$page + 3) > Page::$total) {
							$startPage = Page::$total - 7;
							$endPage = Page::$total;
							echo '<li><a>...</a></li>&nbsp;';
						} else {
							$startPage = Page::$page - 4;
							$endPage = Page::$page + 3;
							echo '<li><a>...</a></li>&nbsp;';
						}
						for ($i=$startPage; $i<=$endPage; $i++){
							if ($i==Page::$page)
							{
								 $active = ' class="active"';
								 $url = 'javascript:void();';
							} else {
								 $active = '';
								 $url = Page::getPageUrl($i);
							}
							echo <<<PAGE

						<li{$active}><a href="{$url}">$i</a></li>&nbsp;
PAGE;
						}
						if ($endPage < Page::$total)
						{
							echo '<li><a>...</a></li>&nbsp;';
						}
						?>
						<li class="inputpage">
							<a>
								<div><input type="text" name="custompage" size="3" title="输入页码，按回车快速跳转" value="<?=Page::$page?>" onkeydown="if(event.keyCode==13) {window.location='<?=Page::getPageUrl('')?>'+this.value;; doane(event);}" style="text-align:center"></div>
								<span title="共 <?=Page::$total?> 页">&nbsp;&nbsp;/&nbsp;<?=Page::$total?> 页</span>
							</a>
						</li>&nbsp;

						<?php if (Page::$page < Page::$total) {?>
<li><a href="<?=Page::getPageUrl(Page::$page+1)?>" rel="next">下一页  &raquo;</a></li>&nbsp;
<li><a href="<?=Page::getPageUrl(Page::$total)?>">&laquo; 末页</a></li>
						<?php }?>

						</ul>				
					</div>
					