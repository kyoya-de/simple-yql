Simple YQL
==========

This package provides a (more or less) simple OOP abstraction of the Yahoo Query Language.

Installation
============

```
composer require kyoya-de/simple-yql
```

Example
=======

```
use Kyoya\YQL;
use Kyoya\YQL\YQL as YQLClient;
use Kyoya\YQL\Expression;

$client = new GuzzleHttp\Client();
$yql = new YQLClient($client);
$query = new YQL\Query();
$query->select()
    ->from('geo.places')
    ->where(new Expression\Where\Equal('text', 'New York, USA'))
    ->where(new Expression\Where\Equal('lang', 'en-US'));

$response = $yql->request($query);
// $response contains the contents of "query" from Yahoo API response as a stdClass instance.
```
