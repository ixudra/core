ixudra/core
================

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ixudra/core.svg?style=flat-square)](https://packagist.org/packages/ixudra/core)
[![license](https://img.shields.io/github/license/ixudra/core.svg)]()
[![StyleCI](https://styleci.io/repos/32549107/shield)](https://styleci.io/repos/32549107)
[![Total Downloads](https://img.shields.io/packagist/dt/ixudra/core.svg?style=flat-square)](https://packagist.org/packages/ixudra/core)

Custom PHP core library for the Laravel 5 framework - developed by [Ixudra](http://ixudra.be).

This package can be used by anyone at any given time, but keep in mind that it is optimized for my personal custom workflow. It may not suit your project perfectly and modifications may be in order.



## Installation

Pull this package in through Composer.

```js

    {
        "require": {
            "ixudra/core": "6.*"
        }
    }

```

Add the service provider to your `config/app.php` file

```php

    'providers'         => array(

        //...
        Ixudra\Core\CoreServiceProvider::class,

    )

```



## Usage

The package provides several base classes that can be used during the development of Laravel 5 applications. To use these classes, simply include the class definition in your PHP file and extend your class to inherit the base methods:

```php

    use Ixudra\Core\Http\Controllers\BaseController;
    
    class ProjectController extends BaseController {
    
        // ...
    
    }


```

Please review the specific source files for a full overview of the available features of the package. Every function has detailed comments and annotations.

That's all there is to it! Have fun!




## Support

Help me further develop and maintain this package by supporting me via [Patreon][https://www.patreon.com/ixudra]!!




## License

This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)




## Contact

For package questions, bug, suggestions and/or feature requests, please use the Github issue system and/or submit a pull request. When submitting an issue, always provide a detailed explanation of your problem, any response or feedback your get, log messages that might be relevant as well as a source code example that demonstrates the problem. If not, I will most likely not be able to help you with your problem.

For any other questions, feel free to use the credentials listed below: 

Jan Oris (developer)

- Email: jan.oris@ixudra.be
- Telephone: +32 496 94 20 57

