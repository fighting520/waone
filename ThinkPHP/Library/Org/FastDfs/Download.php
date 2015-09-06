<?php
header ( "Content-type:text/html;charset=utf-8" );
// $file_name="cookie.jpg";
$file_name = "圣诞狂欢.jpg";


$url = $_GET["url"];
echo $url;
// 用以解决中文不能显示出来的问题
$file_name = iconv ( "utf-8", "gb2312", $url );
//$file_sub_path = $_SERVER ['DOCUMENT_ROOT'] . "marcofly/phpstudy/down/down/";
$file_path = $url;
// 首先要判断给定的文件存在与否
// if (! file_exists ( $file_path )) {
// 	echo "没有该文件文件";
// 	return;
// }
$fp = fopen ( $file_path, "r" );
$arr =  get_headers("http://wawafm.jios.org:8888/group1/M00/00/79/wKjHx1Q3V7KAPOwoAFnU24UTwV4535.mp3",true);
foreach($arr as $x=>$x_value)
{
	echo "Key=" . $x . ", Value=" . $x_value;
	echo "<br>";
	
}
echo "=========<br>";

$local =  get_headers("http://192.168.199.228:8080/CmsSite/userfiles/3/files/cms/128/2014/09/20140930/2014093000010.mp3",true);
foreach($local as $x1=>$x_value1)
{
	echo "Key=" . $x1 . ", Value=" . $x_value1;
	echo "<br>";
}
//return ;

//echo $arr;
//return;
// 下载文件需要用到的头
Header ( "Content-type: audio/mpeg;charset=UTF-8" );
Header ("ETag:W/'3134330-1412041882105'");
Header ( "Accept-Ranges: bytes" );
Header ( "Date: Tue, 28 Oct 2014 00:56:27 GMT" );
Header ( "Last-Modified: Tue, 30 Sep 2014 01:51:22 GMT" );
Header ("0,HTTP/1.1 200 OK");
Header ("Server,Apache-Coyote/1.1");
//Header ( "Accept-Length:" . $arr['Content-Length'] );
Header ( "Content-Disposition: attachment; filename=" . $file_name );
$buffer = 1024;
$file_count = 0;
// 向浏览器返回数据
while ( ! feof ( $fp )) {
	$file_con = fread ( $fp, $buffer );
	$file_count += $buffer;
	echo $file_con;
}
fclose ( $fp );
?> 
