# A simple package for generating repositories in Laravel

This is a simple package for generating repository files in Laravel

## Installation

You can install the package via composer:
``` bash
composer require aleksandro_del_piero/repository
```

Publish configuration file (required)*!. 
If you do not publish the configuration file, the files will be created in the directory App/.

``` bash
php artisan vendor:publish --provider=AleksandroDelPiero\Repository\RepositoryServiceProvider
```

## Documentation

```bash
// Create new repository for model User
php artisan make:repository UserRepository --model=User

// Or create new repository for model User
php artisan make:repository UserRepository

After this you will need to specify the model name:
Specify the name of the model:
 > User
```

By default, all files will be created along the path App/Repositories. 
But this can be changed in the configuration file config/repositories.php.

```php
return [
    'namespace' => '\\Repositories'
];
```
As an example, you can change the directory to Libs/Repsitories
```php
return [
    'namespace' => '\\Libs\\Repositories'
];
```

After changing the configuration file, 
it is advisable to run the command to clear the cache:

```bash
php artisan optimize:clear
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
