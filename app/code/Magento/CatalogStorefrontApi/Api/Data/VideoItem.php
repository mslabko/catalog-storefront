<?php
# Generated by the Magento PHP proto generator.  DO NOT EDIT!

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Magento\CatalogStorefrontApi\Api\Data;

/**
 * Autogenerated description for VideoItem class
 *
 * phpcs:disable Magento2.PHP.FinalImplementation
 * @SuppressWarnings(PHPMD)
 * @SuppressWarnings(PHPCPD)
 */
final class VideoItem implements VideoItemInterface
{

    /**
     * @var string
     */
    private $videoProvider;

    /**
     * @var string
     */
    private $videoUrl;

    /**
     * @var string
     */
    private $videoTitle;

    /**
     * @var string
     */
    private $videoDescription;

    /**
     * @var string
     */
    private $videoMetadata;

    /**
     * @var string
     */
    private $mediaType;
    
    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getVideoProvider(): string
    {
        return (string) $this->videoProvider;
    }
    
    /**
     * @inheritdoc
     *
     * @param string $value
     * @return void
     */
    public function setVideoProvider(string $value): void
    {
        $this->videoProvider = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getVideoUrl(): string
    {
        return (string) $this->videoUrl;
    }
    
    /**
     * @inheritdoc
     *
     * @param string $value
     * @return void
     */
    public function setVideoUrl(string $value): void
    {
        $this->videoUrl = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getVideoTitle(): string
    {
        return (string) $this->videoTitle;
    }
    
    /**
     * @inheritdoc
     *
     * @param string $value
     * @return void
     */
    public function setVideoTitle(string $value): void
    {
        $this->videoTitle = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getVideoDescription(): string
    {
        return (string) $this->videoDescription;
    }
    
    /**
     * @inheritdoc
     *
     * @param string $value
     * @return void
     */
    public function setVideoDescription(string $value): void
    {
        $this->videoDescription = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getVideoMetadata(): string
    {
        return (string) $this->videoMetadata;
    }
    
    /**
     * @inheritdoc
     *
     * @param string $value
     * @return void
     */
    public function setVideoMetadata(string $value): void
    {
        $this->videoMetadata = $value;
    }
    
    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getMediaType(): string
    {
        return (string) $this->mediaType;
    }
    
    /**
     * @inheritdoc
     *
     * @param string $value
     * @return void
     */
    public function setMediaType(string $value): void
    {
        $this->mediaType = $value;
    }
}
