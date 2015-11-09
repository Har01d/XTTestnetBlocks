<?php

// (c) Har01d

require_once('include.php');

$total_blocks   = daemon('getblockcount');
$truncate_table = pg_query('truncate table XTTestnetBlocks');

$start_with = $total_blocks - BLOCKS_TO_PROCESS;

for ($i = $start_with + 1; $i <= $total_blocks; $i++)
{
	$block_hash = daemon('getblockhash', [$i]);
	$block      = daemon('getblock', [$block_hash]);

	$query = "insert into XTTestnetBlocks values ({$block['height']}, {$block['version']}, {$block['size']})";
	pg_query($query);
}