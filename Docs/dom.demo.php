<?php
$doc = new DOMDocument();
$doc->loadXML($data);
$nodes = $doc->getElementsByTagName('ToUserName');
$toUserName = trim($nodes->item(0)->nodeValue);
$nodes = $doc->getElementsByTagName('FromUserName');
$fromUserName = trim($nodes->item(0)->nodeValue);
$nodes = $doc->getElementsByTagName('CreateTime');
$createTime = trim($nodes->item(0)->nodeValue);
$nodes = $doc->getElementsByTagName('MsgType');
$msgType = trim($nodes->item(0)->nodeValue);
$nodes = $doc->getElementsByTagName('Content');
$content = trim($nodes->item(0)->nodeValue);
$nodes = $doc->getElementsByTagName('MsgId');
$msgId = trim($nodes->item(0)->nodeValue);