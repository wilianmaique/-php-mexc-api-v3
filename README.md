# DONATE PAYPAL
```shell
wilianmaique@gmail.com
```

# MEXC-API PHP
lib mexc api simple, for detail account, balance spot, withdraw
info token, etc...

# Installation

```shell
composer require wilianmaique/php-mexc-api-v3
```

# Use

add to your config
```shell
const MEXC_CONFIG = [
    'MEXC_URL_API' => 'https://api.mexc.com/api/v3',
    'MEXC_API_ACCESS_KEY' => 'xxxxxx',
    'MEXC_API_SECRET' => 'xxxxxxxxxxxxxxxxx'
];
```

Account::get()
```PHP
<?php
require __DIR__ . '/vendor/autoload.php';

use WilianMaique\Mexc\Mexc\Account;

// detail account
var_dump(Account::get());

//output

/*
array (size=11)
  'makerCommission' => int 0
  'takerCommission' => int 0
  'buyerCommission' => int 0
  'sellerCommission' => int 0
  'canTrade' => boolean true
  'canWithdraw' => boolean true
  'canDeposit' => boolean true
  'updateTime' => null
  'accountType' => string 'SPOT' (length=4)
  'balances' => 
    array (size=2)
      0 => 
        array (size=3)
          'asset' => string 'USDT' (length=4)
          'free' => string '0.000000006' (length=11)
          'locked' => string '0' (length=1)
      1 => 
        array (size=3)
          'asset' => string 'BNB' (length=3)
          'free' => string '0.000244271466267283' (length=20)
          'locked' => string '0' (length=1)
  'permissions' => 
    array (size=1)
      0 => string 'SPOT' (length=4)
*/
```

InfoToken::get('WEMIX')
```PHP
<?php
require __DIR__ . '/vendor/autoload.php';

use WilianMaique\Mexc\Mexc\InfoToken;

// get info by token name or all tokens
var_dump(InfoToken::get('WEMIX'));

//output

/*
array (size=3)
  'coin' => string 'WEMIX' (length=5)
  'name' => string 'WEMIX TOKEN' (length=11)
  'networkList' => 
    array (size=1)
      0 => 
        array (size=15)
          'coin' => string 'WEMIX' (length=5)
          'depositDesc' => null
          'depositEnable' => boolean true
          'minConfirm' => int 60
          'name' => string 'WEMIX TOKEN' (length=11)
          'network' => string 'WEMIX' (length=5)
          'withdrawEnable' => boolean true
          'withdrawFee' => string '0.100000000000000000' (length=20)
          'withdrawIntegerMultiple' => null
          'withdrawMax' => string '550000.000000000000000000' (length=25)
          'withdrawMin' => string '1.000000000000000000' (length=20)
          'sameAddress' => boolean false
          'contract' => string '' (length=0)
          'withdrawTips' => null
          'depositTips' => null
*/
```

#
# All functions....

```PHP
Account::get(); // get detail account
Account::getSpotBalance(); // get balance by asset, null to list all
InfoToken::get(); // get info token, null to list all
PriceTicker::get(); // get price by token, null to list all
Withdraw::withdraw('WEMIX', 'WEMIX', 'xxxxxxxx', '1.0'); // send crypto to any wallet, if ok [id] returns
Withdraw::history('WEMIX', 'c3bbe527692742cc95e64f999dfda324'); // get all history, if 'withdrawId' is not defined list all
```