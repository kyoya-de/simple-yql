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

class ApiConfiguration {
    private $public = true;
    private $version = 'v1';
    private $baseUrl = 'http://query.yahooapis.com/';

    public function __construct($version = null, $public = null, $baseUrl = null) {
        if (null !== $version) {
            $this->version = is_numeric($version) ? $version : "v{$version}";
        }

        if (null !== $public) {
            $this->public = (bool) $public;
        }

        if (null !== $baseUrl) {
            $this->baseUrl = $baseUrl;
        }
    }

    /**
     * @return string
     */
    public function getBaseUrl() {
        return $this->baseUrl;
    }

    /**
     * @return boolean
     */
    public function isPublic() {
        return $this->public;
    }

    /**
     * @return string
     */
    public function getVersion() {
        return $this->version;
    }
}
