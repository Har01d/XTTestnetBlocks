# A tool to watch for BIP 101 blocks on the Bitcoin testnet

![ScreenShot](https://github.com/Har01d/XTTestnetBlocks/blob/master/screen.png?raw=true)

It's mostly untested and isn't my best code, so run it on your own risk :)

## Requirements

* Bitcoin XT full node
* PHP 5.6+ with Curl
* PostgreSQL
* Any webserver in case you want to show the data

## How do I install and run it?

1. Set up a Bitcoin XT testnet full node, set `rpcuser`, `rpcpassword`, `rpcport`, `testnet=1` and `server=1` in `bitcoin.conf`
2. Connect to as many XT nodes as possible. See https://www.reddit.com/r/bitcoinxt/comments/3s08sl/bip101_on_testnet_is_coming_want_to_help/
3. You need to set up a PostgreSQL database, then run a script from `sql.sql`
4. Update `config.php` with your settings, "daemon" configuration (login, password and port) should correspond to the values from `bitcoin.conf` (rpcuser, rpcpassword, rpcport)
5. Set up a cron service to run `/usr/bin/php bootstrap.php` every 5-10 minutes. Each run will clean and refill the database). That can be done by pasting `*/5 * * * * /usr/bin/php /path/to/bootstrap.php` into `crontab -e` 
6. You can see the results in `index.php` (make `web` a public folder)

If you want to analyze more than 1,000 blocks, you might want to change `BLOCKS_TO_PROCESS` constant in `config.php`

## Live examples

by /u/hellobitcoinworld: http://xtnodes.com/#testnet
by /u/TeranNotTerran: http://23.253.174.52/xttestnetblocks.html