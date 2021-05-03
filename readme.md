# Laravel Simple Search

A simple wildcard search on eloquent models.

## Installation

Via Composer

``` bash
$ composer require zesty-bus/laravel-simple-search
```

## Usage
### Preparing your models
First you'll need to add the SimpleSearch trait.
``` bash
namespace App\Models;

use ZestyBus\LaravelSimpleSearch\SimpleSearch;

class Post extends Model
{
    use SimpleSearch;
}
```
Next you'll need to add a searchable property. These are the table columns you'll be searching on. If the model has a relationship, you can use dot notation to determine the path.
``` bash
namespace App\Models;

use ZestyBus\LaravelSimpleSearch\SimpleSearch;

class Post extends Model
{
    use SimpleSearch;
    
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
To run a search use the simpleSearch() method on your queries.
``` bash
$posts = Post::simpleSearch($request->query)->get();
```
### Changing the searchable property
If you're already using a property named "searchable" you can use the getSimpleSearchColumns() method in your models to use a different property.
``` bash
protected $searchableColumns = [
    'name', 'body', 'category.name'
];

protected function getSimpleSearchColumns()
{
    return $this->searchableColumns;
}
```

## License

license. Please see the [license file](license.md) for more information.

[link-author]: https://github.com/zesty-bus
