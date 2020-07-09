<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\CatalogExportApi\Api\Data;

/**
 * Category entity
 *
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 */
class Category
{
    /**
     * @var ?int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var ?string
     */
    private $description;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $pathInStore;

    /**
     * @var string
     */
    private $urlKey;

    /**
     * @var string
     */
    private $urlPath;

    /**
     * @var string
     */
    private $canonicalUrl;

    /**
     * @var int
     */
    private $position;

    /**
     * @var int
     */
    private $level;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @var string
     */
    private $updatedAt;

    /**
     * @var string
     */
    private $storeViewCode;

    /**
     * @var ?int
     */
    private $productCount;

    /**
     * @var ?int
     */
    private $defaultSortBy;

    /**
     * @var ?string
     */
    private $breadcrumbs;

    /**
     * Get product ID
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set product ID
     *
     * @param string $id
     * @return void
     */
    public function setId(?string $id)
    {
        $this->id = $id;
    }

    /**
     * Get category description
     *
     * @return string
     */
    public function getDescription() : ?string
    {
        return $this->description;
    }

    /**
     * Set category description
     *
     * @param string $description
     * @return void
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * Get category name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set category name
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Get category path
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Set category path
     *
     * @param string $path
     * @return void
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * Get category path in store
     *
     * @return string
     */
    public function getPathInStore(): string
    {
        return $this->pathInStore;
    }

    /**
     * Set category path in store
     *
     * @param string $pathInStore
     * @return void
     */
    public function setPathInStore(string $pathInStore)
    {
        $this->pathInStore = $pathInStore;
    }

    /**
     * Get category url key
     *
     * @return string
     */
    public function getUrlKey(): string
    {
        return $this->urlKey;
    }

    /**
     * Set category path
     *
     * @param string $urlKey
     * @return void
     */
    public function setUrlKey(string $urlKey): void
    {
        $this->urlKey = $urlKey;
    }

    /**
     * Get category url key
     *
     * @return string
     */
    public function getUrlPath(): string
    {
        return $this->urlPath;
    }

    /**
     * Set category path
     *
     * @param string $urlPath
     * @return void
     */
    public function setUrlPath(string $urlPath): void
    {
        $this->urlPath = $urlPath;
    }

    /**
     * Get category canonical url
     *
     * @return string
     */
    public function getCanonicalUrl(): ?string
    {
        return $this->canonicalUrl;
    }

    /**
     * Set category path
     *
     * @param string $canonicalUrl
     * @return void
     */
    public function setCanonicalUrl(?string $canonicalUrl): void
    {
        $this->canonicalUrl = $canonicalUrl;
    }

    /**
     * Get category position
     *
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * Set category position
     *
     * @param int $position
     * @return void
     */
    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    /**
     * Get category level
     *
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * Set category level
     *
     * @param int $level
     * @return void
     */
    public function setLevel(int $level)
    {
        $this->level = $level;
    }

    /**
     * Retrieve category creation date and time.
     *
     * @return string|null
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * Set category creation date and time.
     *
     * @param string $createdAt
     * @return void
     */
    public function setCreatedAt(string $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Retrieve category last update date and time.
     *
     * @return string|null
     */
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    /**
     * Set category last update date and time.
     *
     * @param string $updatedAt
     * @return void
     */
    public function setUpdatedAt(string $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Set product count
     *
     * @param int $productCount
     * @return void
     */
    public function setProductCount(?int $productCount)
    {
        $this->productCount = $productCount;
    }

    /**
     * Get product count
     *
     * @return int
     */
    public function getProductCount(): ?int
    {
        return $this->productCount;
    }

    /**
     * Retrieve category default sort by
     *
     * @return string|null
     */
    public function getDefaultSortBy(): ?string
    {
        return $this->defaultSortBy;
    }

    /**
     * Set category default sort by
     *
     * @param string $defaultSortBy
     * @return void
     */
    public function setDefaultSortBy(string $defaultSortBy)
    {
        $this->defaultSortBy = $defaultSortBy;
    }

    /**
     * Retrieve category default sort by
     *
     * @return string|null
     */
    public function getBreadcrumbs(): ?string
    {
        return $this->breadcrumbs;
    }

    /**
     * Set category default sort by
     *
     * @param string $breadcrumbs
     * @return void
     */
    public function setBreadcrumbs(?string $breadcrumbs)
    {
        $this->breadcrumbs = $breadcrumbs;
    }

    /**
     * Get store view code
     *
     * @return string
     */
    public function getStoreViewCode(): string
    {
        return $this->storeViewCode;
    }

    /**
     * Set store view code
     * 
     * @param string $storeViewCode
     * @return void
     */
    public function setStoreViewCode(string $storeViewCode): void
    {
        $this->storeViewCode = $storeViewCode;
    }
}