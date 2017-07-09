<?php

echo"<pre>";
echo"<pre>" ;
var_dump($_GET);
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
var_dump($data_url);
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
echo"$protocol";

$fp = fsockopen($protocol, $port);
echo"<pre>" ;
	var_dump($_SERVER);
echo "</pre>";

if(!$fp)
{
	die("Сервер не отвечает");
}
$request = $_SERVER["REQUEST_METHOD"];
$server_protocol = $_SERVER["SERVER_PROTOCOL"];
$out = "$request / $server_protocol" . PHP_EOL;
	//$out .= 
echo "$out";