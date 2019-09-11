# Huaweicloud-sdk-php-frs
Non-Official PHP sdk for Huawei's [Face Recognization Service](https://www.huaweicloud.com/product/face.html).

Important: This IS **NOT** AN OFFICIAL SDK. Use It At Your Own Risk.

# Requirements
- php >= 7.2 

# How to use
- Install Sdk
```bash
composer require coolseven/huawei-frs-sdk
```

- Use Sdk
```php
    // $endpoint , $ak,$sk can be found at Huawei's console panel
    $authInfo = new AuthInfo($endpoint,$ak,$sk);
    
    $frsClient = new FrsClient($authInfo,$projectId);
    
    // get face set list
    $response = $frsClient->getFaceSetService()->getAllFaceSets();
```

More usage demos can be found at `tests`

- Services & Api Cheat Sheet
  - CompareService
    - compareFaceByBase64
    - compareFaceByObsUrl
    - compareFaceByLocalFile
  - DetectService
    - detectFaceByBas464
    - detectFaceByObsUrl
    - detectFaceByLocalFile
  - FaceService
    - getFaces
    - getFace
    - addFaceByBase64
    - addFaceByObsUrl
    - addFaceByLocalFile
    - updateFaceByFaceId
    - deleteFaceByFaceId
    - deleteFaceByExternalImageId
    - deleteFaceByExternalField
    - batchDeleteFacesByFilter
  - FaceSetService
    - getAllFaceSets
    - getFaceSet
    - createFaceSet
    - deleteFaceSet
  - LiveDetectService
    - liveDetectByBase64
    - liveDetectByObsUrl
    - liveDetectByLocalFile
  - SearchService
    - searchFaceByBase64
    - searchFaceByFaceId
    - searchFaceByObsUrl




# TODO

- [x] Add unit tests for FaceSetService
- [x] Add unit tests for FaceService
- [x] Add unit tests for SearchService
- [ ] Add unit tests for DetectService
- [x] Add unit tests for CompareService
- [ ] Add unit tests for LiveDetectService
- [ ] Add parameter validation



# Huawei's Official Frs Sdks:
- java : https://github.com/huaweicloud/huaweicloud-sdk-java-frs 
- go : https://github.com/huaweicloud/huaweicloud-sdk-go-frs
- python : https://github.com/huaweicloud/huaweicloud-sdk-python-frs
- csharp : https://github.com/huaweicloud/huaweicloud-sdk-csharp-frs