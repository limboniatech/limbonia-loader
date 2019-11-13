# Limbonia loader library

## Installation

### Using composer:

1. Add the library to the project
```bash
> cd project-dir/
> composer require limboniatech/limbonia-loader
```

2 . Make sure the vendor autoload statement at the top of your file
```php
<?php
require 'vendor/autoload.php';
```

### Using a raw library:

1. Add the library to the project
```bash
> cd project-dir/
> git clone https://github.com/limboniatech/limbonia-loader.git

```

2 . Make sure the autoloader.php statement at the top of your file
```php
<?php
require $sPathToLimboniaTechLibs . '/limbonia-loader/autoloader.php';
```
## Usage

### Loader class method list
| Method | Description | Type | Parameters | Return |
| ------ | ----------- | ---- | ---------- | ------ |
| autoload | PSR-4 compatible autoload method<br> | public<br>static | string $sClassName - The name of the class to auto load |        |
| registerAutoloader | Register the PSR-4 autoloader | public<br>static |  |  |
| addLib | Add a new Limbonia library to the current list<br> | public<br>static | string $sLibDir - The root directory to the Limbonia library to add |  |
| getLibs | Return the list of Limbonia libraries | public<br>static |  | array |
| viewDirs | Return the list of Limbonia view directories | public<br>static |  | array |

### DriverList trait method list
| Method | Description | Type | Parameters | Return |
| ------ | ----------- | ---- | ---------- | ------ |
| classType | Return the full class type of this class | public<br>static |  | string |
| driverFactory | Generate and return an object of the specified type with specified parameters<br><br>throws \Exception | public<br>static | string $sType - the type of object to create<br>array $aParam (optional) - array of parameters to initialize the | self |  |
| driverClass | Generate and return the class name for the specified type returning an empty string if none is found | public<br>static | string $sType | string |
| driverList | Generate and cache the driver list for the current object type | public<br>static | | array |
| driver | Return the driver name for the specified name, if there is one | public<br>static | string $sName | string |
| getType | Get the subclass type for this object | public |  | string |

### Adding the DriverList trait in a class
1. Add the trait to a base class
```php
<?php
namespace Limbonia;

class Sample
{
  use \Limbonia\Traits\DriverList;
}
```
2. Extend that class into a group of sub-classes
```php
<?php
namespace Limbonia\Sample;

class Foo extends \Limbonia\Sample
{
}
```
```php
<?php
namespace Limbonia\Sample;

class Bar extends \Limbonia\Sample
{
}
```
```php
<?php
namespace Limbonia\Sample;

class Baz extends \Limbonia\Sample
{
}
```
3. Then use the features of the trait where ever you need them...
```php
<?php
namespace Limbonia\Test;
use \Limbonia\Sample;

print_r(Sample::driverList());

$sSampleFooDriverClass = Sample::driverClass('foo);
$oSample = new $sSampleFooDriverClass;
echo $oSample->getType() . "\n";

```
