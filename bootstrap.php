<?php

// (c) Har01d

require_once('include.php');

$total_blocks     = daemon('getblockcount');
$last_known_block = pg_query('select max(height) as max_height from XTTestnetBlocks');

if (pg_num_rows($last_known_block) <= 0)
{
	$start_with = FIRST_BLOCK_TO_PROCESS - 1;
}
else
{
	$start_with = pg_fetch_assoc($last_known_block)['max_height'];
}

if (is_null($start_with))
	$start_with = FIRST_BLOCK_TO_PROCESS - 1;

for ($i = $start_with + 1; $i <= $total_blocks; $i++)
{
	$block_hash = daemon('getblockhash', [$i]);
	$block      = daemon('getblock', [$block_hash]);

	$query = "insert into XTTestnetBlocks values ({$block['height']}, {$block['version']}, {$block['size']})";
	pg_query($query);
}