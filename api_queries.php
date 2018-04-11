<?php

/* Weibo API Version 2 */
const WEIBO_API = 'https://api.weibo.com/2';

/* HTTP Status Code */
const HTTP_OK = 200;

/**
 * Home Time Line
 * http://open.weibo.com/wiki/2/statuses/home_timeline
 *
 * @param array $args
 * @return array
 * @throws Exception
 */
function fetchHomeTimeLine(array $args): array
{
    // $exampleArgs = [
    //     'access_token' => '[REQUIRED]<string>采用OAuth授权方式为必填参数，OAuth授权后获得。',
    //     'since_id' => '<int64>若指定此参数，则返回ID比since_id大的微博（即比since_id时间晚的微博），默认为0。',
    //     'max_id' => '<int64>若指定此参数，则返回ID小于或等于max_id的微博，默认为0。',
    //     'count' => '<int>单页返回的记录条数，最大不超过100，默认为20。',
    //     'page' => '<int>返回结果的页码，默认为1。',
    //     'base_app' => '<int>是否只获取当前应用的数据。0为否（所有数据），1为是（仅当前应用），默认为0。',
    //     'feature' => '<int>过滤类型ID，0：全部、1：原创、2：图片、3：视频、4：音乐，默认为0。',
    //     'trim_user' => '<int>返回值中user字段开关，0：返回完整user字段、1：user字段仅返回user_id，默认为0。'
    // ];

    /* access_token is required for accessing the api */
    if (!isset($args['access_token'])) {
        throw new Exception('Access token is not set, get one from http://open.weibo.com/tools/console');
    }

    /* Convert $args to uri string */
    $_args = '';
    foreach ($args as $key => $value) {
        $_args .= $key . '=' . $value . '&'; /* 'access_token=someAccessToken&' */
    }
    $_args = rtrim($_args, '&');

    /* Set URI */
    $uri = '/statuses/home_timeline.json?' . $_args;

    /* Request */
    list($response, $data) = request(WEIBO_API . $uri);

    /* Check if query success */
    if ($response['http_code'] == HTTP_OK) {
        $data = json_decode($data, true);
    } else {
        throw new Exception($response);
    }

    return $data;
}

/**
 * @param string $dest
 * @param array $resource
 */
function storeImages(string $dest, array $resource): void
{
    foreach ($resource as $name => $url) {
        if (!file_exists($dest . '/' . $name)) {
            copy($url, $dest . '/' . $name);
        }
    }
}

/**
 * Create folders & get storing destination + image links
 *
 * @param array $sources
 * @param string $id
 * @return array
 */
function resourcesGetter(array $sources, string $id): array
{
    /* Images Folder */
    $dest = rtrim(STORING_LOCATION, '/') . '/images/' . $id; /* dest: "./data/images/{id}" */
    if (!is_dir($dest)) mkdir($dest);

//    /* Retweeted images in separate folder */
//    if ($isRetweetedImages) {
//        $dest .= '/retweeted'; /* dest: "./data/images/{id}/retweeted" */
//        if (!is_dir($dest)) mkdir($dest);
//    }

    /* Image Quality */
    $dest .= '/' . IMAGE_QUALITY;
    if (!is_dir($dest)) mkdir($dest);

    /* URL Prefix strpos offset */
    $offset = 18;

    /* Image Sources */
    $imageLinks = [];
    foreach ($sources as $source) {
        if (isset($source['thumbnail_pic'])) { /* name: "/someimageid.jpg", urlPrefix: "http://wx1.sinaimg.cn" */
            $name = substr($source['thumbnail_pic'], strrpos($source['thumbnail_pic'],'/'));
            $urlPrefix = substr($source['thumbnail_pic'], 0, strpos($source['thumbnail_pic'],'/', $offset));
        } else {
            continue;
        }

        $url = $urlPrefix . '/' . IMAGE_QUALITY . $name; /* url: "http://wx2.sinaimg.cn/large/{name}" */

        /* Store Image Link */
        $imageLinks[ltrim($name, '/')] = $url;
    }

    return [$dest, $imageLinks];
}

/**
 * cURL requesting
 *
 * @param string $url
 * @return array
 */
function request(string $url): array
{
    $ch = curl_init();

    curl_setopt_array($ch,array(
        CURLOPT_URL => $url,
        CURLOPT_HEADER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_USERAGENT => 'curl',
        CURLOPT_FOLLOWLOCATION => 0,
        CURLOPT_ENCODING => 'gzip,deflate',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_CONNECTTIMEOUT => 60,
        CURLOPT_DNS_CACHE_TIMEOUT => 900,
        CURLOPT_LOW_SPEED_LIMIT => 1,
        CURLOPT_LOW_SPEED_TIME => 120,
        CURLOPT_TIMEOUT => 60,
    ));

    $data = curl_exec($ch);
    $response = curl_getinfo($ch);

    curl_close($ch);

    return [$response, $data];
}
