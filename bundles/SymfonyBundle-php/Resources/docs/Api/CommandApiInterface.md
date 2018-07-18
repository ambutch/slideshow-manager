# Api\CommandApiInterface

All URIs are relative to *http://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**update**](CommandApiInterface.md#update) | **POST** /update | Updates the database


## Service Declaration
```yaml
# src/Acme/MyBundle/Resources/services.yml
services:
    # ...
    acme.my_bundle.api.command:
        class: Acme\MyBundle\Api\CommandApi
        tags:
            - { name: "api.api", api: "command" }
    # ...
```

## **update**
> update()

Updates the database

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/CommandApiInterface.php

namespace Acme\MyBundle\Api;

use Api\CommandApiInterface;

class CommandApi implements CommandApiInterface
{

    // ...

    /**
     * Implementation of CommandApiInterface#update
     */
    public function update()
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters
This endpoint does not need any parameter.

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

