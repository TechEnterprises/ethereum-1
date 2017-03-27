Drupal Ethereum
===============

This module is in early development state. 

### Features

This module provides the base to connect Ethereum Blockchain with Drupal.

* Provides a PHP abstraction to the Ethereum JsonRPC interface. 
* Depends on PHP Library ... 

#Setup

* To get all required dependencies you need to run `composer install`  
* Make sure Drupal has a Ethereum Node to read from by configuring *Configure Ethereum connection* (/admin/config/ethereum/network)
* There are 3 different network settings provided. Default Ethereum node is set to Infura.io Testnet. You set up you own  Etehreum node and provide jSonRPC access.
 
 More below at "Drupal Ethereum Getting started"
 
# Running your own Ethereum node

If you want to use geth (go-ethereum client), here is how to <a href="https://github.com/ethereum/go-ethereum/wiki/Building-Ethereum">install geth on many OS</a>.
Then you start the geth server with rpc. On my mac like this. Keep in mind that the "*" allows connections from any host. 

``` 
 geth --testnet  --rpc --rpccorsdomain="*"
``` 


### Development environment for *smart contracts* using Testrpc

If you want to check out developing your own smart contract it is recommended to use testrpc, which provides a fast Ethereum node for local testing. 

You may modify the currently provided *Login Smart Contract* by cloning it https://github.com/digitaldonkey/register_drupal_ethereum. The repository contains a very little Truffle App which helps you to get started with test driven smart contract development. 
   
 SCREENSHOT

**Connecting with Testrpc**


``` 
# Start testrpc
testrpc

# Clone lign contract:
git clone https://github.com/digitaldonkey/register_drupal_ethereum
cd register_drupal_ethereum

# Deploy contract to testrpc
# This will provide you the smart contract address, which you might want to add Drupals settings. 
truffle migrate

# Start local development environement
truffle serve
``` 


### Dependencies 

Drupal core > 8.2

Composer is required in order to download the <a href="https://github.com/bluedroplet/ethereum-php-lib">ethereum-php-lib</a>. 

If you used composer to install drupal core and the ethereum module everything should work out of the box.

<a href="https://www.lullabot.com/articles/goodbye-drush-make-hello-composer">Don't know composer</a>? You should. 
 
You have to edit composer.json file in the drupal root folder and add the "bluedroplet/ethereum-php-lib" to the require section:
 
``` 
 "require": {

         ...         
         
         "bluedroplet/ethereum-php-lib": "dev-master"
  },
```


# Drupal Ethereum Getting started

[Drupal](https://www.drupal.org/) 8 is PHP based open source CMS and framework. Drupal Ethereum Module aims to integrate Drupal and Ethereum Blockchain technology. 

## Installing Drupal 

You will need PHP [Composer](https://getcomposer.org/) to and [drush](http://www.drush.org/en/master/) installed on your system in order to do things fast. There are also manual ways described in Drupal documentation. 

**Download latest Drupal **

```
composer create-project drupal-composer/drupal-project:~8.0 drupal --stability dev --no-interaction
```

**Create a Database**

```
mysql -uroot  --execute="CREATE DATABASE \`drupalEthereumTest.local\`;"
```

**Install Drupal **

```
# Create a configuration export directory. This is not required, but very usefull.
mkdir drupal/config
# Change to web root 

cd drupal/web/
# Scripted drupal installation. Revalidate the database. It will be overwritten.
drush site-install standard --db-url="mysql://root:root@localhost:3306/drupalEthereumTest.local" --account-name="tho" --account-pass="password" --site-name="drupalEthereum.local" --account-mail="email@donkeymedia.eu" --site-mail="email@donkeymedia.eu" --config-dir="../config" --notify="global"
```

_DON'T FORGET TO CHANGE YOUR PASSWORD AFTER FIRST LOGIN._

**Download some existential plugins**

[RestUI](https://www.drupal.org/project/restui) is a user interface for Drupal 8's REST module.

```
# Composer commands need to be run from the drupal directory
cd ..
composer require drupal/restui
composer require drupal/admin_toolbar
```

Enable the modules

```
cd web/
drush en admin_toolbar_tools -y
# If enabling REST API drops an error you may do it later in Drupal UI.
drush en restui -y
```

## Add Drupal Ethereum Module [Drupal.org](http://drupal.org/) version

```
# Composer commands need to be run from the drupal directory
cd ..
composer require drupal/ethereum
cd web/
drush en ethereum -y
# Currently testrpc is required (will fix very soon)
# Install see: https://github.com/ethereumjs/testrpc
# Start testrpc
testrpc
```

Go to /admin/config/ethereum/network and enable custom network settings 
Custom Ethereum Node → [http://localhost:8545](http://localhost:8545/)

Visit /admin/reports/ethereum and check status page.


## **Add Drupal Ethereum Module **(SANDBOX VERSION)


Till there is a dev release we need to manually add the dependencies to conposer.json file. 

Edit drupal/conposer.json and add the 3 module and the PHP library repositories. 

```
"repositories": [
    {
        "type": "composer",
        "url": "https://packages.drupal.org/8"
    },
    {
        "type": "git",
        "url": "https://github.com/digitaldonkey/ethereum.git"
    },
    {
        "type": "git",
        "url": "https://github.com/digitaldonkey/ethereum-php.git"
    }
```

