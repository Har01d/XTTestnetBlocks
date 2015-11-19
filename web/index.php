<?php
require_once('../include.php');
?>

<!DOCTYPE html>
<!-- (c) Har01d -->
<html lang="en">
<head>
	<title>Latest <?= BLOCKS_TO_PROCESS ?> Testnet Blocks</title>

	<style>
		* {
			font-family: 'Helvetica Neue', Helvetica, 'Segoe UI', Arial, freesans, sans-serif;
		}

		.tdw {
			height: 10px;
			width: 10px;
			margin: 0;
			border: 1px dotted black;
		}

		.bip101 {
			background-color: #ffe2e7;
		}

		.bip101plus {
			background-color: #ffa3a7;
		}

		.core {
			background-color: #d8e0ef;
		}

		.explorer-link {
			display: block;
			height: 10px;
			width: 10px;
		}
	</style>

</head>
<body>
<h1>Latest <?= BLOCKS_TO_PROCESS ?> Testnet Blocks</h1>
<table>

	<?php

	$q       = pg_query('SELECT * FROM XTTestnetBlocks ORDER BY height DESC LIMIT ' . BLOCKS_TO_PROCESS);
	$classes = $blocks = $sizes = [];

	$i = 0;

	while ($r = pg_fetch_array($q))
	{
		$classes[$i] = ($r['version'] == 536870919) ? 'bip101' : 'core';
		$blocks[$i]  = $r['height'];
		$sizes[$i]   = $r['size'];

		if ($r['size'] > 1000000)
			$classes[$i] = 'bip101plus';

		$i++;
	}

	$block = 0;

	for ($i = 0; $i < (BLOCKS_TO_PROCESS / 50); $i++)
	{
		echo '<tr>';
		for ($j = 0; $j < 50; $j++)
		{
			$class = $classes[($block)];
			$size  = number_format($sizes[($block)] / 1024 / 1024, 2);
			echo '<td class="tdw ' . $class . '"><a class="explorer-link" title="Block #' . $blocks[$block] . ', ' . $size .
				 ' MB" href="http://insight.xtnodes.com/block-index/' . $blocks[$block] . '"></a></td>';
			$block++;
		}
		echo '</tr>';
	}

	?>

</table>

<h2>Latest block: <?= $blocks[0] ?></h2>

<table>
	<tr>
		<td class="tdw bip101plus"></td>
		<td> - BIP 101 block with size > 1 MB</td>
	</tr>
	<tr>
		<td class="tdw bip101"></td>
		<td> - BIP 101 block with size <= 1 MB</td>
	</tr>
	<tr>
		<td class="tdw core"></td>
		<td>- standard block</td>
	</tr>
</table>

<br/>
<a target="_blank" href="https://github.com/Har01d/XTTestnetBlocks">GitHub</a>

</body>
</html>