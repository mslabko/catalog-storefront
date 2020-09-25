<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: catalog.proto

namespace Magento\CatalogStorefrontApi\Proto;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>magento.catalogStorefrontApi.proto.ProductShopperInputOption</code>
 */
class ProductShopperInputOption extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string id = 1;</code>
     */
    protected $id = '';
    /**
     * Generated from protobuf field <code>string label = 2;</code>
     */
    protected $label = '';
    /**
     * Generated from protobuf field <code>int32 sort_order = 3;</code>
     */
    protected $sort_order = 0;
    /**
     * Generated from protobuf field <code>bool required = 4;</code>
     */
    protected $required = false;
    /**
     * Generated from protobuf field <code>string render_type = 5;</code>
     */
    protected $render_type = '';
    /**
     * Generated from protobuf field <code>repeated .magento.catalogStorefrontApi.proto.Price price = 6;</code>
     */
    private $price;
    /**
     * Generated from protobuf field <code>repeated string file_extension = 7;</code>
     */
    private $file_extension;
    /**
     * Generated from protobuf field <code>.magento.catalogStorefrontApi.proto.ValueInterval interval = 8;</code>
     */
    protected $interval = null;
    /**
     * Generated from protobuf field <code>int32 image_size_x = 9;</code>
     */
    protected $image_size_x = 0;
    /**
     * Generated from protobuf field <code>int32 image_size_y = 10;</code>
     */
    protected $image_size_y = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $id
     *     @type string $label
     *     @type int $sort_order
     *     @type bool $required
     *     @type string $render_type
     *     @type \Magento\CatalogStorefrontApi\Proto\Price[]|\Google\Protobuf\Internal\RepeatedField $price
     *     @type string[]|\Google\Protobuf\Internal\RepeatedField $file_extension
     *     @type \Magento\CatalogStorefrontApi\Proto\ValueInterval $interval
     *     @type int $image_size_x
     *     @type int $image_size_y
     * }
     */
    public function __construct($data = null)
    {
        \Magento\CatalogStorefrontApi\Metadata\Catalog::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string id = 1;</code>
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Generated from protobuf field <code>string id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setId($var)
    {
        GPBUtil::checkString($var, true);
        $this->id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string label = 2;</code>
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Generated from protobuf field <code>string label = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setLabel($var)
    {
        GPBUtil::checkString($var, true);
        $this->label = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>int32 sort_order = 3;</code>
     * @return int
     */
    public function getSortOrder()
    {
        return $this->sort_order;
    }

    /**
     * Generated from protobuf field <code>int32 sort_order = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setSortOrder($var)
    {
        GPBUtil::checkInt32($var);
        $this->sort_order = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>bool required = 4;</code>
     * @return bool
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * Generated from protobuf field <code>bool required = 4;</code>
     * @param bool $var
     * @return $this
     */
    public function setRequired($var)
    {
        GPBUtil::checkBool($var);
        $this->required = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string render_type = 5;</code>
     * @return string
     */
    public function getRenderType()
    {
        return $this->render_type;
    }

    /**
     * Generated from protobuf field <code>string render_type = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setRenderType($var)
    {
        GPBUtil::checkString($var, true);
        $this->render_type = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated .magento.catalogStorefrontApi.proto.Price price = 6;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Generated from protobuf field <code>repeated .magento.catalogStorefrontApi.proto.Price price = 6;</code>
     * @param \Magento\CatalogStorefrontApi\Proto\Price[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setPrice($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Magento\CatalogStorefrontApi\Proto\Price::class);
        $this->price = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated string file_extension = 7;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getFileExtension()
    {
        return $this->file_extension;
    }

    /**
     * Generated from protobuf field <code>repeated string file_extension = 7;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setFileExtension($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->file_extension = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.magento.catalogStorefrontApi.proto.ValueInterval interval = 8;</code>
     * @return \Magento\CatalogStorefrontApi\Proto\ValueInterval
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * Generated from protobuf field <code>.magento.catalogStorefrontApi.proto.ValueInterval interval = 8;</code>
     * @param \Magento\CatalogStorefrontApi\Proto\ValueInterval $var
     * @return $this
     */
    public function setInterval($var)
    {
        GPBUtil::checkMessage($var, \Magento\CatalogStorefrontApi\Proto\ValueInterval::class);
        $this->interval = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>int32 image_size_x = 9;</code>
     * @return int
     */
    public function getImageSizeX()
    {
        return $this->image_size_x;
    }

    /**
     * Generated from protobuf field <code>int32 image_size_x = 9;</code>
     * @param int $var
     * @return $this
     */
    public function setImageSizeX($var)
    {
        GPBUtil::checkInt32($var);
        $this->image_size_x = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>int32 image_size_y = 10;</code>
     * @return int
     */
    public function getImageSizeY()
    {
        return $this->image_size_y;
    }

    /**
     * Generated from protobuf field <code>int32 image_size_y = 10;</code>
     * @param int $var
     * @return $this
     */
    public function setImageSizeY($var)
    {
        GPBUtil::checkInt32($var);
        $this->image_size_y = $var;

        return $this;
    }
}
