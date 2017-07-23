<?php
require_once"lib\parse_headers.php";
//require_once"lib\encode.php";
//echo phpinfo();




$data_url = parse_url($_GET['url']);

if (count($data_url) < 2)
	die("Wrong url in request query");

if(!$data_url['path'])
	$data_url['path']='/';

if($data_url['query'])
	$data_url['query']='?'.$data_url['query'];
else
	$data_url['query']='';



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

//echo "$out";
//echo"<hr>";
	//$out .= 
//$out ="";	
fwrite($fp, $out);
$body='';	
while (!feof($fp))
{
	$body .= fgets($fp, 128);
}	
fclose($fp);
list($header, $body) = explode(PHP_EOL . PHP_EOL, $body);


$header = http_parse_headers($header);

list($content_type, $content_charset) = explode(";", $header['Content-Type']);
if($content_type == 'text/html')
{
	//echo "$body";


	libxml_use_internal_errors(true);
	$html = new DOMDocument();
	$html->loadHTML($body);
	$html_resource = array(
		"img" => "src",
		"input" => "src",
		"script" => "scr",
		"link" => "href",
		"a" => "href",
		"form" => "action"
	);


	foreach ($html_resource as $tag => $attr)
	{
		foreach($html->getElementsByTagName($tag) as $element)
		{
			if($element->hasAttribute($attr))
			{
				//var_dump($element->getAttribute($attr));
				//echo " - ";
				$element->setAttribute($attr,  encode_resource($element->getAttribute($attr)));
				//echo "<br>";
			}
		}
	}
	$body = $html->saveHTML();
	$body = str_replace("parent&&parent!=window&&(document.getElementsByTagName('body')[0].innerHTML='');", "", $body);
	$body = str_replace("location.replace(location.toString())", "", $body);
	
	echo "$body";
};

;
	
//if()
