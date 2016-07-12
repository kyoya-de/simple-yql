<?php
/**
 * This file is part of a marmalade GmbH project
 * It is not Open Source and may not be redistributed.
 * For contact information please visit http://www.marmalade.de
 *
 * @version    0.1
 * @author     Stefan Krenz <krenz@marmalade.de>
 * @link       http://www.marmalade.de
 */

namespace Kyoya\YQL;

use GuzzleHttp\ClientInterface;
use GuzzleHttp;

class YQL {

    /**
     * @var ApiConfiguration
     */
    private $apiConfiguration;

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * YQL constructor.
     *
     * @param ClientInterface       $client
     * @param ApiConfiguration|null $apiConfiguration
     */
    public function __construct(ClientInterface $client, ApiConfiguration $apiConfiguration = null) {
        if (null === $apiConfiguration) {
            $apiConfiguration = new ApiConfiguration();
        }

        $this->apiConfiguration = $apiConfiguration;

        $this->client = $client;
    }

    public function request(Query $query, $params = []) {
        $params['format'] = 'json';
        $params['q']      = $query->getQuery();

        $queryString = $this->buildHttpQueryString($params);

        $response = $this->client->get($this->buildBaseUrl() . '?' . $queryString);

        $rawContents = $response->json(['object' => true]);

        return $rawContents->query;
    }

    private function buildHttpQueryString($params) {
        $httpQueryString = '';
        foreach ($params as $key => $value) {
            $httpQueryString .= "&{$key}=" . urlencode($value);
        }

        return ltrim($httpQueryString, '&');
    }

    private function buildBaseUrl() {
        return sprintf(
            '%s/%s%s/yql',
            rtrim($this->apiConfiguration->getBaseUrl(), '/'),
            $this->apiConfiguration->getVersion(),
            $this->apiConfiguration->isPublic() ? '/public' : ''
        );
    }
}
