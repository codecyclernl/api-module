# API module for October CMS
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