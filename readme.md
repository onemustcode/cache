# Cache
Cache is a simple to use library that caches objects.

## Installation
Require the Cache library trough composer.
```
composer require onemustcode/cache
```

## Usage
Simple example on how to use the cache.

```php
$driver = new MemcachedDriver();

$cache = new Cache($driver);

$item = new Item('some-key', ['some' => 'data']);

// The default ttl is 60 minutes for an item, we will change it for example to 120 minutes
$item->setTtl(120);

// Adding an tag
$item->addTag(
    new Tag('some-tag')
);

$cache->store($item);
```

## Drivers
Out of the box there are two drivers available, Memcached and Redis.

### Memcached
```php
$drivers = new MemcachedDriver([
    'prefix' => '', // Default empty, is for prefixing the keys
    'persistent_id' => null, // Default null
    'sals' => [], // Default empty array, is for authenticating; ['username', 'password']
    'options' => [], // Default empty array, is for passing Memcached options
    'servers' => [ // Default server settings for Memcached
        'host' => '127.0.0.1',
        'port' => 11211,
        'weight' => 100,
    ],
]);

$cache = new Cache($driver);
```

### Retrieve an item
Retrieving an item from the cache is really simple. Just pass an Item instance to the get method.
If the item exists it will return an Item instance, else it will return null.
```php
$item = $cache->get(
    new Item('name')
);
```

You can change what the default value will be when the item is does not exists in the cache.
```php
$item = $cache->get(
    new Item('name'),
    false
);
```

### Retrieve multiple items
If you want to retrieve multiple items at once, you van use the getMultiple method that accepts an collection of items.
```php
$collection = $cache->getMultiple(
    new Collection([
        new Item('item-1'),
        new Item('item-2'),
        new Item('item-3'),
    ])
);
```

### Storing an item
Storing an item is really simple. Just create an new Item instance and pass the key and data to it.
```php
$item = new Item('product.1', ['id' => 1, 'name' => 'Model X', 'brand' => 'Tesla']);

// Also add an tag so we can flush all products for later usage
$item->addTag(
    new Tag('products')
);

$cache->store($item);
```

### Storing multiple items
Sometimes it is handy to store multiple items at once. Then just create an collection with the items to cache.
The collection sets the ttl by default on 60 minutes. You can change this with the second argument when creating an collection or trough the **setTtl** method.

```php
$collection = new Collection([
    new Item('product.1', ['id' => 1, 'name' => 'Model S', 'brand' => 'Tesla']),
    new Item('product.2', ['id' => 1, 'name' => 'Model 3', 'brand' => 'Tesla']),
    new Item('product.3', ['id' => 1, 'name' => 'Model X', 'brand' => 'Tesla']),
    new Item('product.4', ['id' => 1, 'name' => 'Model Y', 'brand' => 'Tesla']),
]);

$this->storeMultiple($collection);
```

### Checking if items exists
Checks if the item exists in the cache. Returns true if it exists, else false when it doesn't.
```php
$bool = $cache->has(
    new Item('some-item')
);
```

### Deleting items
Delete's an item from the cache.
```php
$cache->delete(
    new Item('some-item')
);
```

### Flushing the cache
If you want to flush the entire cache then just call the following method;
```php
$cache->flush();
```

It's also possible to flush only specific items that belongs to one or more tags.
```php
$cache->flush([
    new Tag('tag-1'),
    new Tag('tag-5'),
]);
```

License
----

MIT