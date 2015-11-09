<?php

// (c) Har01d

require_once('config.php');

$postgresql = pg_connect('host=' . POSTGRESQL_HOST . ' dbname=' . POSTGRESQL_DB . ' user=' . POSTGRESQL_LOGIN . ' password=' . POSTGRESQL_PASSWORD);

function daemon($method, $params = [])
{
	static $curl = null;

	if (is_null($curl))
	{
		$curl = curl_init();
	}

	$curl_address = DAEMON_PROTOCOL . '://' . DAEMON_LOGIN . ':' . DAEMON_PASSWORD . '@' . DAEMON_HOST . ':' . DAEMON_PORT . '/';

	static $id = 0;
	$request = json_encode(array('method' => $method, 'params' => $params, 'id' => $id));
	$options = array(CURLOPT_URL        => $curl_address, CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => true, CURLOPT_MAXREDIRS => 10,
					 CURLOPT_HTTPHEADER => array('Content-type: application/json'), CURLOPT_POST => true, CURLOPT_POSTFIELDS => $request);

	curl_setopt_array($curl, $options);
	$response = json_decode(curl_exec($curl), true);

	$id++;

	if (!$response)
	{
		die('Daemon: no connection');
	}

	if ($response['error'])
	{
		die('Daemon: no response: ' . print_r($response['error'], true));
	}

	return $response['result'];
}
