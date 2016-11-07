ixudra/core
================

Custom PHP core library for the Laravel 5 framework - developed by [Ixudra](http://ixudra.be).

This package can be used by anyone at any given time, but keep in mind that it is optimized for my personal custom workflow. It may not suit your project perfectly and modifications may be in order.



## Installation

Pull this package in through Composer.

```js

    {
        "require": {
            "ixudra/core": "5.*"
        }
    }

```

Add the service provider to your `config/app.php` file

```php

    providers     => array(

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

That's all there is to it! Have fun!




## License

This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)




## Contact

Jan Oris (developer)

- Email: jan.oris@ixudra.be
- Telephone: +32 496 94 20 57