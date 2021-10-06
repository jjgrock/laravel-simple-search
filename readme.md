# Laravel Simple Search

A simple wildcard search on eloquent models.

## Installation

Via Composer

``` sh
composer require zesty-bus/laravel-simple-search
```

## Usage
### Preparing your models
Add a searchable property. These are the table columns you'll be searching on. If the model has a relationship, you can use dot notation to determine the path.
``` php
namespace App\Models;

class Post extends Model
{
    protected $searchable = [
        'name', 'body', 'category.name'
    ];
    
    public function category()
    {
        return $this->hasOne(Category::class);
    }
}
```

### Searching
To run a search use the search() method on your queries.
``` php
$posts = Post::search($request->query)->get();
```
You can override the default search columns by passing an array.
``` php
$posts = Post::search($request->query, ['name'])->get();
```
### Config
You may want to change the search method name or the search property name on your models. First, publish the config.
``` sh
php artisan vendor:publish --provider="ZestyBus\LaravelSimpleSearch\LaravelSimpleSearchServiceProvider" --tag="config"
```
Simply change the method name or property name to something that suits your requirements.
``` php
return [

    /**
     *  Name of the eloquent builder method.
     */
    'method' => 'filter',

    /**
     *  Name of the models public searchable property.
     */
    'property' => 'filterable'
];
```
``` php
$posts = Post::filter($request->query, ['name'])->get();
```
``` php
namespace App\Models;

class Post extends Model
{
    protected $filterable = [
        'name', 'body', 'category.name'
    ];
    
    public function category()
    {
        return $this->hasOne(Category::class);
    }
}
```

## License

license. Please see the [license file](license.md) for more information.

[link-author]: https://github.com/zesty-bus
