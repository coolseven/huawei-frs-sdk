# Huaweicloud-sdk-php-frs
Non-Official PHP sdk for Huawei's [Face Recognization Service](https://www.huaweicloud.com/product/face.html).

Important: This IS **NOT** AN OFFICIAL SDK. Use It At Your Own Risk.

# Requirements
- php >= 7.2 

# How to use
- Install Sdk
```bash
composer require coolseven/huaweicloud-sdk-php-frs
```

- Run Tests ( Optional ) 

  - copy `phpunit.xml.dist` to `phpunit.xml`

    ```bash
    cp phpunit.xml.dist phpunit.xml
    ```

  - set variable values in phpunit.xml accoording to your own huawei account

  - run test

    ```bash
    vender\bin\phpunit
    ```

    

- Use Sdk
```php
    // $endpoint , $ak,$sk can be found at Huawei's console panel
    $authInfo = new AuthInfo($endpoint,$ak,$sk);
    
    $frsClient = new FrsClient($authInfo,$projectId);
    
    // get face set list
    $response = $frsClient->getFaceSetService()->getAllFaceSets();
```

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

More usage demos can be found at `tests`



# TODO

- [x] Add unit tests for FaceSetService
- [x] Add unit tests for FaceService
- [x] Add unit tests for SearchService
- [ ] Add unit tests for DetectService
- [ ] Add unit tests for CompareService
- [ ] Add unit tests for LiveDetectService



# Huawei's Official Frs Sdks:
- java : https://github.com/huaweicloud/huaweicloud-sdk-java-frs 
- go : https://github.com/huaweicloud/huaweicloud-sdk-go-frs
- python : https://github.com/huaweicloud/huaweicloud-sdk-python-frs
- csharp : https://github.com/huaweicloud/huaweicloud-sdk-csharp-frs