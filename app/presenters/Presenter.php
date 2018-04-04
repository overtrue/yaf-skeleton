<?php

/*
 * This file is part of the overtrue/yaf-skeleton.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Presenters;

/**
 * Presenter 基类.
 */
abstract class Presenter implements PresenterInterface
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * Constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * 处理展示格式，去除不需要的字段.
     *
     * @return array
     */
    abstract public function present();

    /**
     * Return data to json serialize.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $this->present();

        return $this->data;
    }

    /**
     * 返回数组.
     *
     * @return array
     */
    public function toArray()
    {
        $this->present();

        return $this->data;
    }

    /**
     * Get a data by key.
     *
     * @param string $key The key data to retrieve
     *
     * @return mixed
     */
    public function &__get($key)
    {
        return $this->toArray()[$key];
    }

    /**
     * Assigns a value to the specified data.
     *
     * @param string $key   The data key to assign the value to
     * @param mixed  $value The value to set
     */
    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Whether or not an data exists by key.
     *
     * @param string $key An data key to check for
     *
     * @return bool
     */
    public function __isset($key)
    {
        return isset($this->toArray()[$key]);
    }

    /**
     * Unsets an data by key.
     *
     * @param string $key The key to unset
     */
    public function __unset($key)
    {
        unset($this->data[$key]);
    }

    /**
     * Assigns a value to the specified offset.
     *
     * @param string $offset The offset to assign the value to
     * @param mixed  $value  The value to set
     */
    public function offsetSet($offset, $value)
    {
        if (!is_null($offset)) {
            $this->data[$offset] = $value;
        }
    }

    /**
     * Whether or not an offset exists.
     *
     * @param string $offset An offset to check for
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * Unsets an offset.
     *
     * @param string $offset The offset to unset
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            unset($this->data[$offset]);
        }
    }

    /**
     * Returns the value at specified offset.
     *
     * @param string $offset The offset to retrieve
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->data[$offset] : null;
    }
}
