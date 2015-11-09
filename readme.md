# A tool to watch for BIP 101 blocks on the Bitcoin testnet

![ScreenShot](https://github.com/Har01d/XTTestnetBlocks/blob/master/screen.png?raw=true)

It's mostly untested and isn't my best code, so run it on your own risk :)

## How do I install and run it?

1. Set up a Bitcoin XT testnet full node using `testnet=1` in `bitcoin.conf`
2. You need to set up a postgresql database, then run a script from `sql.sql`
3. Update `config.php` with your settings
4. You need to run bootstrap.php to fill the database: `/usr/bin/php bootstrap.php`. That can take quite some time.
5. After this set up a cron service to run `bootstrap.php` every 10-20 minutes
6. You can see the results in `index.php`

If you want to analyze more than 1.000 blocks, you might want to change `FIRST_BLOCK_TO_PROCESS` constant in `config.php`