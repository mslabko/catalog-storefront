<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: catalog.proto

namespace Magento\CatalogStorefrontApi\Proto;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>magento.catalogStorefrontApi.proto.GroupedItem</code>
 */
class GroupedItem extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>float qty = 1;</code>
     */
    protected $qty = 0.0;
    /**
     * Generated from protobuf field <code>int32 position = 2;</code>
     */
    protected $position = 0;
    /**
     * Generated from protobuf field <code>string product = 3;</code>
     */
    protected $product = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type float $qty
     *     @type int $position
     *     @type string $product
     * }
     */
    public function __construct($data = null)
    {
        \Magento\CatalogStorefrontApi\Metadata\Catalog::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>float qty = 1;</code>
     * @return float
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * Generated from protobuf field <code>float qty = 1;</code>
     * @param float $var
     * @return $this
     */
    public function setQty($var)
    {
        GPBUtil::checkFloat($var);
        $this->qty = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>int32 position = 2;</code>
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Generated from protobuf field <code>int32 position = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setPosition($var)
    {
        GPBUtil::checkInt32($var);
        $this->position = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string product = 3;</code>
     * @return string
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Generated from protobuf field <code>string product = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setProduct($var)
    {
        GPBUtil::checkString($var, true);
        $this->product = $var;

        return $this;
    }
}
