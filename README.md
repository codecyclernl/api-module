# API module for October CMS
## Installation
### Require with composer
`composer require codecycler/api`

### Publish auth config
`php artisan vendor:publish --tag=october.api`

### Generate initial Passport keys 
`php artisan passport:install`

## Basics
### Registering resources
You can register resources for your plugin by using the `registerApiResources` method in your `Plugin.php` file.
```php
public function registerApiResources()
{
    return [
        'blogposts' => 'RainLab\Blog\Models\Post',
    ];
}
```

<i>Sponsored by Codecycler [(codecycler.com)](https://codecycler.com)</i>