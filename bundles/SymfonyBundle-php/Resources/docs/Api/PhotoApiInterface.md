# Api\PhotoApiInterface

All URIs are relative to *http://localhost*

Method | HTTP request | Description
------------- | ------------- | -------------
[**publishPhoto**](PhotoApiInterface.md#publishPhoto) | **POST** /publish | Publish photo to slideshow directory


## Service Declaration
```yaml
# src/Acme/MyBundle/Resources/services.yml
services:
    # ...
    acme.my_bundle.api.photo:
        class: Acme\MyBundle\Api\PhotoApi
        tags:
            - { name: "api.api", api: "photo" }
    # ...
```

## **publishPhoto**
> publishPhoto($body)

Publish photo to slideshow directory

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/PhotoApiInterface.php

namespace Acme\MyBundle\Api;

use Api\PhotoApiInterface;

class PhotoApi implements PhotoApiInterface
{

    // ...

    /**
     * Implementation of PhotoApiInterface#publishPhoto
     */
    public function publishPhoto(PublishPhotoRequest $body)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**Api\Model\PublishPhotoRequest**](../Model/PublishPhotoRequest.md)|  |

### Return type

void (empty response body)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

