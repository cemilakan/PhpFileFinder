organikhaberlesme.com için PHP API Sınıfıdır.

### KURULUM
```php
// Include The Class (You have to download the files first)
include './src/Finder.php';
```

#### Definition
```php
$finder = new Finder('./controller/admin');
```

<hr>


#### Select files with extension
```php
$files = $finder->extension('php')->get();
```

#### Select files with last update time
```php
$files = $finder->date(strtotime("-1 day"), '<')->get();
```

#### Select files that contain any word
```php
$files = $finder->contain('throw')->get();
```

#### Select files with name
```php
$files = $finder->include('dashboard.php')->get();
```


#### Select files except hast the name
```php
$files = $finder->exclude('dashboard.php')->get();
```

#### Delete Files
just change get with delete
```php
$files = $finder->exclude('dashboard.php')->delete();
```


#### Print Files
```php
echo json_encode($files, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
```

