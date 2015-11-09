<!DOCTYPE html>
<!-- (c) Har01d -->
<html lang="en">
<head>
	<title>Latest 1000 Testnet Blocks</title>

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

		.tdy {
			width: 10px;
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
	</style>

</head>
<body>
<h1>Latest 1000 Testnet Blocks</h1>
<table>

	<?php

	require_once('../include.php');

	$q       = pg_query('SELECT * FROM XTTestnetBlocks ORDER BY height DESC LIMIT 1000');
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

	for ($i = 0; $i < 20; $i++)
	{
		echo '<tr>';
		for ($j = 0; $j < 50; $j++)
		{
			$class = $classes[($block)];
			$size  = number_format($sizes[($block)] / 1024 / 1024, 2);
			echo '<td class="tdw ' . $class . '" title="Block #' . $blocks[$block] . ', ' . $size . ' MB"></td>';
			$block++;
		}
		echo '</tr>';
	}

	?>

</table>
<br/>

<h2>Latest block: <?= $blocks[999] ?></h2>

<br/>
<table>
	<tr>
		<td> - BIP 101 block with size > 1 Mb</td>
		<td class="tdy bip101plus"></td>
	</tr>
	<tr>
		<td> - BIP 101 block with size <= 1 Mb</td>
		<td class="tdy bip101"></td>
	</tr>
	<tr>
		<td>- standard block</td>
		<td class="tdy core"></td>
	</tr>
</table>

<br/>
<a href="https://github.com/Har01d/XTTestnetBlocks">GitHub</a>

</body>
</html>