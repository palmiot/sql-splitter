# sql-splitter

Tool for split SQL databases from a file or a stream pipe.


## Install

``` bash
composer require palmiot/sql-splitter
```

## Usage

The basic are two classes, `SqlSplitter.php` and the extension `SqlSplitterCli.php`. The first do the hard work while second provide an interface for command line and allow read the output stream pipe directly from mysqldump.

### Methods of `SqlSplitter`

The class have setters and getters for each variable but the work are of the next methods;

``` php
$splitter->setFrom('test/fixtures/alldatabases.sql');           // Expect a path or directory of physical file..
$splitter->setTo('./databases');                                // Set the path or directory where save the splitted databases;
$splitter->setPrefix('test');                                   // Set a prefix name for all splitted databases when them save.
$splitter->setData('CREATE DATABASE ... CREATE DATABASE ...');  // Expect an string with all databases.
$splitter->setDatabase('dbname', 'CREATE DATABASE...');         // For add manualy a database.
$splitter->split();                                             // Split and localize action of databases.
$splitter->save();                                              // Save splitted databases on .sql files to output directory.
$splitter->saveJoin();                                          // Save on a single .sql file all databases localized (the result will be similar to source).
$splitter->getLog();                                            // List all exception messages if occurred.
```

##### example
``` php
include('vendor/autoload.php'); // Using composer

use Palmiot\SqlSplitter\SqlSplitter as Splitter;

$splitter = new Splitter();
$splitter->setFrom('test/fixtures/alldatabases.sql');
$splitter->setTo('databases');
$splitter->setPrefix('test');
$splitter->split();
$splitter->save();
$splitter->saveJoin();
foreach($splitter->getLog() as $entry){
    print($entry->getMessage());
}
```


### The class `SqlSplitterCli`

The job of this class is listen params or arguments and prepare them for pass to parent class (`SqlSplitter`) for finally request the work and return a result as string format.

The `__construct` can listen arguments (see bellow) as array format before pass to parent. The caller is the method `run()`. The basic usage is this;

##### cli.php

```php

include('src/SqlSplitter.php');
include('src/SqlSplitterCli.php');  // Including manually (if not use composer)

$work = (new Palmiot\SqlSplitter\SqlSplitterCli([]))->run();    // Listen and work

print($work);   // STDOUT
```

Once this file been written, we can send the next params from command line;


``` bash
****************************************************************************************************************
************************************************* SQL Splitter *************************************************
****************************************************************************************************************
*                                                                                                              *
*      -i :: File .sql with all databases                                                                      *
*      --input :: /path/alldatabases.sql                                                                       *
*                                                                                                              *
*      -s :: Stream of databases                                                                               *
*      --stream :: The output of mysqldump directly                                                            *
*                                                                                                              *
*      -o :: Folder where will save the splitted databases                                                     *
*      --output :: /save/here/                                                                                 *
*                                                                                                              *
*      -p :: Apply a generic prefix for all splitted databases                                                 *
*      --prefix :: test                                                                                        *
*                                                                                                              *
*      -j :: Save all dump                                                                                     *
*      --join :: Also save the all databases as a file                                                         *
*                                                                                                              *
*      -l :: Display logs                                                                                      *
*      --logs :: if something goes wrong                                                                       *
*                                                                                                              *
*      Usage:                                                                                                  *
*                                                                                                              *
*      // from input file                                                                                      *
*      $ php cli.php -i alldatabases.sql -o databases -p test -j -l                                            *
*                                                                                                              *
*      // from dump directly                                                                                   *
*      $ mysqldump -P port -h ip -u user -ppass --opt --all-databases | php cli.php -s -o databases -j -l      *
*                                                                                                              *
****************************************************************************************************************
```
