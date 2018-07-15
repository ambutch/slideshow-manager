# Api\DirectoryApiInterface

All URIs are relative to *http://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**listDirectory**](DirectoryApiInterface.md#listDirectory) | **GET** /directory/{id} | Directory contents
[**listDirectoryTree**](DirectoryApiInterface.md#listDirectoryTree) | **GET** /directory_tree | Directory tree


## Service Declaration
```yaml
# src/Acme/MyBundle/Resources/services.yml
services:
    # ...
    acme.my_bundle.api.directory:
        class: Acme\MyBundle\Api\DirectoryApi
        tags:
            - { name: "api.api", api: "directory" }
    # ...
```

## **listDirectory**
> Api\Model\ListDirectoryInfoResponse listDirectory($id, $page, $limit, $sort, $dir)

Directory contents

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/DirectoryApiInterface.php

namespace Acme\MyBundle\Api;

use Api\DirectoryApiInterface;

class DirectoryApi implements DirectoryApiInterface
{

    // ...

    /**
     * Implementation of DirectoryApiInterface#listDirectory
     */
    public function listDirectory(string $id, int $page = null, int $limit = null, string $sort = null, string $dir = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | [**string**](../Model/.md)|  |
 **page** | **int**|  | [optional]
 **limit** | **int**|  | [optional]
 **sort** | **string**|  | [optional]
 **dir** | **string**|  | [optional]

### Return type

[**Api\Model\ListDirectoryInfoResponse**](../Model/ListDirectoryInfoResponse.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **listDirectoryTree**
> Api\Model\ListDirectoryTreeResponse listDirectoryTree()

Directory tree

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/DirectoryApiInterface.php

namespace Acme\MyBundle\Api;

use Api\DirectoryApiInterface;

class DirectoryApi implements DirectoryApiInterface
{

    // ...

    /**
     * Implementation of DirectoryApiInterface#listDirectoryTree
     */
    public function listDirectoryTree()
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters
This endpoint does not need any parameter.

### Return type

[**Api\Model\ListDirectoryTreeResponse**](../Model/ListDirectoryTreeResponse.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

