<?php 
function encode_resource($path)
{
	$data_url = parse_url($_GET['url']);
	var_dump($data_url);
	if( substr($path, 0, 4) != "http")
		$need = "$data_url['scheme']://$data_url['host'];
}