<?php

/*
 * This file is part of the overtrue/yaf-skeleton.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Http;

use Psr\Http\Message\StreamInterface;

/**
 * Trait implementing functionality common to requests and responses.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
trait MessageTrait
{
    /** @var array Map of all registered headers, as original name => array of values */
    protected $headers = [];

    /** @var array Map of lowercase header name => original name at registration */
    protected $headerNames = [];

    /** @var string */
    protected $protocol = '1.1';

    /** @var StreamInterface */
    protected $stream;

    /**
     * @return string
     */
    public function getProtocolVersion()
    {
        return $this->protocol;
    }

    /**
     * @param string $version
     *
     * @return $this|MessageTrait
     */
    public function withProtocolVersion($version)
    {
        if ($this->protocol === $version) {
            return $this;
        }

        $new = clone $this;
        $new->protocol = $version;

        return $new;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param string $header
     *
     * @return bool
     */
    public function hasHeader($header)
    {
        return isset($this->headerNames[strtolower($header)]);
    }

    /**
     * @param string $header
     *
     * @return array
     */
    public function getHeader($header)
    {
        $header = strtolower($header);

        if (!isset($this->headerNames[$header])) {
            return [];
        }

        $header = $this->headerNames[$header];

        return $this->headers[$header];
    }

    /**
     * @param string $header
     *
     * @return string
     */
    public function getHeaderLine($header)
    {
        return join(', ', $this->getHeader($header));
    }

    /**
     * @param string       $header
     * @param array|string $value
     *
     * @return MessageTrait
     */
    public function withHeader($header, $value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }

        $value = $this->trimHeaderValues($value);
        $normalized = strtolower($header);

        $new = clone $this;
        if (isset($new->headerNames[$normalized])) {
            unset($new->headers[$new->headerNames[$normalized]]);
        }
        $new->headerNames[$normalized] = $header;
        $new->headers[$header] = $value;

        return $new;
    }

    /**
     * @param string       $header
     * @param string|array $value
     *
     * @return MessageTrait
     */
    public function withAddedHeader($header, $value)
    {
        if (!is_array($value)) {
            $value = [$value];
        }

        $value = $this->trimHeaderValues($value);
        $normalized = strtolower($header);

        $new = clone $this;
        if (isset($new->headerNames[$normalized])) {
            $header = $this->headerNames[$normalized];
            $new->headers[$header] = array_merge($this->headers[$header], $value);
        } else {
            $new->headerNames[$normalized] = $header;
            $new->headers[$header] = $value;
        }

        return $new;
    }

    /**
     * @param string $header
     *
     * @return $this|MessageTrait
     */
    public function withoutHeader($header)
    {
        $normalized = strtolower($header);

        if (!isset($this->headerNames[$normalized])) {
            return $this;
        }

        $header = $this->headerNames[$normalized];

        $new = clone $this;
        unset($new->headers[$header], $new->headerNames[$normalized]);

        return $new;
    }

    /**
     * @return StreamInterface|string
     */
    public function getBody()
    {
        if (!$this->stream) {
            $this->stream = '';
        }

        return $this->stream;
    }

    /**
     * @param StreamInterface $body
     *
     * @return $this|MessageTrait
     */
    public function withBody(StreamInterface $body)
    {
        if ($body === $this->stream) {
            return $this;
        }

        $new = clone $this;
        $new->stream = $body;

        return $new;
    }

    /**
     * @param array $headers
     */
    private function setHeaders(array $headers)
    {
        $this->headerNames = $this->headers = [];
        foreach ($headers as $header => $value) {
            if (!is_array($value)) {
                $value = [$value];
            }

            $value = $this->trimHeaderValues($value);
            $normalized = strtolower($header);
            if (isset($this->headerNames[$normalized])) {
                $header = $this->headerNames[$normalized];
                $this->headers[$header] = array_merge($this->headers[$header], $value);
            } else {
                $this->headerNames[$normalized] = $header;
                $this->headers[$header] = $value;
            }
        }
    }

    /**
     * Trims whitespace from the header values.
     *
     * Spaces and tabs ought to be excluded by parsers when extracting the field value from a header field.
     *
     * header-field = field-name ":" OWS field-value OWS
     * OWS          = *( SP / HTAB )
     *
     * @param string[] $values Header values
     *
     * @return string[] Trimmed header values
     *
     * @see https://tools.ietf.org/html/rfc7230#section-3.2.4
     */
    private function trimHeaderValues(array $values)
    {
        return array_map(function ($value) {
            return trim($value, " \t");
        }, $values);
    }
}
