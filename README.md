# UserEngage.io PHP SDK

PHP 5.6 SDK for UserEngage Rest API

## Installation

Installation using composer:

```
composer require userengage-php
```

## Usage
```php
$client = new UserengageClient('REST_API_KEY');
$users = new UserengageUsers($client);
```

* Create User
```php
$user = $users->create([
    'first_name' => 'API',
    'last_name' => 'User',
    'email' => 'api.user@test.com'
]);
```

* Update User
```php
$user = $users->update($id, [
    'first_name' => 'API',
    'last_name' => 'Update',
]);
```

* Delete User
```php
$users->delete($id);
```

* Find User
```php
// By ID
$user = $users->find($id);

// By Key
$user = $users->findByKey($key);

// By Date
$users = $users->findByDate($minTimestamp, $maxTimestamp, $type);
```

* List User Details
```php
$results = $users->details();

// Pagination
$users = $client->nextPage($results));
$users = $client->previousPage($results));
```

## Documentation

[UserEngage API](https://userengage.io/en-us/api/introduction/)
