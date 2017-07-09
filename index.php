<?php

echo phpinfo();
echo"<pre>";
echo"<pre>" ;
//var_dump($_GET);
echo "</pre>";

$data_url = parse_url($_GET['url']);
echo"<pre>" ;
var_dump($data_url);
echo "</pre>";

if(!$data_url['path'])
	$data_url['path']='/';

if($data_url['query'])
	$data_url['query']='?'.$data_url['query'];
else
	$data_url['query']='';

echo"<pre>" ;
//var_dump($data_url);
echo "</pre>";

if($data_url['scheme'] == 'http')
{
	$protocol = "tcp://";
	$port = 80;
}
else
{
	$protocol = "ssl://";
	$port = 443;
}
$protocol .= $data_url['host'];
//echo"$protocol";

$fp = fsockopen($protocol, $port);
echo"<pre>" ;
	//var_dump($_SERVER);
echo "</pre>";

if(!$fp)
{
	die("Сервер не отвечает");
}
$request = $_SERVER["REQUEST_METHOD"];
$server_protocol = $_SERVER["SERVER_PROTOCOL"];
$path = $data_url['path'];
$query = $data_url['query'];
$out = "$request $path$query $server_protocol" . PHP_EOL;
$out .= "Host: $data_url[host]" . PHP_EOL;
$out .= "User agent: $_SERVER[HTTP_USER_AGENT]" . PHP_EOL;
$out .= "Connection: close" . PHP_EOL . PHP_EOL;
//$out .= PHP_EOL;
echo "$out";
//echo"<hr>";
	//$out .= 
//$out ="";	
fwrite($fp, $out);
	
while (!feof($fp))
{
	$body .= fgets($fp, 128);
}	
fclose($fp);
list($header, $body) = explode(PHP_EOL . PHP_EOL, $body);

//$header = http_parse_headers($header);
echo "$header";
echo"<hr>";
echo "$body";

//var_dump($out);