<?php
require_once"lib\parse_headers.php";
//require_once"lib\encode.php";
//echo phpinfo();



<<<<<<< HEAD

function http_parse_headers( $header )
    {
        $retVal = array();
        $fields = explode("\r\n", preg_replace('/\x0D\x0A[\x09\x20]+/', ' ', $header));
        foreach( $fields as $field ) {
            if( preg_match('/([^:]+): (.+)/m', $field, $match) ) {
                $match[1] = preg_replace('/(?<=^|[\x09\x20\x2D])./e', 'strtoupper("\0")', strtolower(trim($match[1])));
                if( isset($retVal[$match[1]]) ) {
                    $retVal[$match[1]] = array($retVal[$match[1]], $match[2]);
                } else {
                    $retVal[$match[1]] = trim($match[2]);
                }
            }
        }
        return $retVal;
    }   

//echo phpinfo();
echo"<pre>";
echo"<pre>" ;
//var_dump($_GET);
echo "</pre>";

$data_url = parse_url($_GET['url']);

//	$data_url = parse_url("https://github.com/Timophet/anonymizer");

echo"<pre>" ;
var_dump($data_url);
echo "</pre>";
=======

$data_url = parse_url($_GET['url']);

if (count($data_url) < 2)
	die("Wrong url in request query");
>>>>>>> 77cd810744dd9f721871dbd9ce01e70c743727df



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
<<<<<<< HEAD
$body = "";
=======
$body='';	
>>>>>>> 77cd810744dd9f721871dbd9ce01e70c743727df
while (!feof($fp))
{
	$body .= fgets($fp, 128);
}	

//var_dump($body);

fclose($fp);
list($header, $body) = explode(PHP_EOL . PHP_EOL, $body);

<<<<<<< HEAD
$header = http_parse_headers($header);

list($content_type, $content_charset) = explode(";", $header['Content-Type']);



//var_dump($header);
echo"<hr>";
echo "$content_type, $content_charset";

if("$content_type" == "text/html")
{
	//echo"HTML";
	libxml_use_internal_errors(true);

	$html = new DOMDocument();
	$html->loadHTML($body);

	$html_resource = array(	'img' => 'src',
						 	'input' => 'src',
						 	'script' => 'src',
						 	'link' => 'href',
						 	'a' => 'href',
						 	'form' => 'action');
	foreach ($html_resource as $tag => $attr) 
	{
		foreach ($html->getElementsByTagName($tag) as $element) 
		{
			if($element->hasAttribute ($attr))
			{	
				$element->setAttribute ($attr, "php");
			//	var_dump($element->getAttribute ($attr));
			};
			//echo "<br>";
		}
	}

	$body = $html->saveHTML();
 	//var_dump($html);

	$body = str_replace("parent&&parent!=window&&(document.getElementsByTagName('body')[0].innerHTML='');", '', $body);
	
	$body = str_replace(",location.replace(location.toString())", '', $body);
	

	echo "$body";
}
elseif ($content_type == "text\css") 
{
	ECHO "CSS";
}
=======
>>>>>>> 77cd810744dd9f721871dbd9ce01e70c743727df

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
