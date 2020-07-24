<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\CatalogStorefront\Model;

use Magento\CatalogStorefrontApi\Api\CatalogServerInterface;
use Magento\CatalogStorefrontApi\Api\Data\CategoriesGetResponseInterface;
use Magento\CatalogStorefrontApi\Api\Data\Category;
use Magento\CatalogStorefrontApi\Api\Data\CategoryInterface;
use Magento\CatalogStorefrontApi\Api\Data\Image;
use Magento\CatalogStorefrontApi\Api\Data\MediaGalleryItem;
use Magento\CatalogStorefrontApi\Api\Data\MediaGalleryItemInterface;
use Magento\CatalogStorefrontApi\Api\Data\ProductInterface;
use Magento\CatalogStorefrontApi\Api\Data\ProductsGetRequestInterface;
use Magento\CatalogStorefrontApi\Api\Data\ImportProductsRequestInterface;
use Magento\CatalogStorefrontApi\Api\Data\ProductsGetResult;
use Magento\CatalogStorefrontApi\Api\Data\ProductsGetResultInterface;
use Magento\CatalogStorefrontApi\Api\Data\ImportProductsResponseInterface;
use Magento\CatalogStorefront\DataProvider\ProductDataProvider;
use Magento\CatalogStorefrontApi\Api\Data\CategoriesGetResponse;
use Magento\CatalogStorefrontApi\Api\Data\UrlRewrite;
use Magento\CatalogStorefrontApi\Api\Data\UrlRewriteParameter;
use Magento\CatalogStorefrontApi\Api\Data\Video;
use Magento\Framework\Api\DataObjectHelper;
use Magento\CatalogStorefrontApi\Api\Data\CategoriesGetRequestInterface;
use Magento\CatalogStorefront\DataProvider\CategoryDataProvider;
use Magento\CatalogStorefrontApi\Api\Data\ImportCategoriesRequestInterface;
use Magento\CatalogStorefrontApi\Api\Data\ImportCategoriesResponseInterface;
use Magento\CatalogStorefrontApi\Api\Data\DynamicAttributeValueInterfaceFactory;

/**
 * Class for retrieving catalog data
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class CatalogService implements CatalogServerInterface
{
    /**
     * @var ProductDataProvider
     */
    private $dataProvider;

    /**
     * @var DataObjectHelper
     */
    private $dataObjectHelper;

    /**
     * @var CategoryDataProvider
     */
    private $categoryDataProvider;

    /**
     * @var DynamicAttributeValueInterfaceFactory
     */
    private $dynamicAttributeFactory;

    /**
     * @param ProductDataProvider $dataProvider
     * @param DataObjectHelper $dataObjectHelper
     * @param CategoryDataProvider $categoryDataProvider
     * @param DynamicAttributeValueInterfaceFactory $dynamicAttributeFactory
     */
    public function __construct(
        ProductDataProvider $dataProvider,
        DataObjectHelper $dataObjectHelper,
        CategoryDataProvider $categoryDataProvider,
        DynamicAttributeValueInterfaceFactory $dynamicAttributeFactory
    ) {
        $this->dataProvider = $dataProvider;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->categoryDataProvider = $categoryDataProvider;
        $this->dynamicAttributeFactory = $dynamicAttributeFactory;
    }

    /**
     * Get requested products
     *
     * @param ProductsGetRequestInterface $request
     * @return ProductsGetResultInterface
     * @throws \Throwable
     */
    public function getProducts(
        ProductsGetRequestInterface $request
    ): ProductsGetResultInterface {
        $result = new ProductsGetResult();

        if (empty($request->getStore()) || $request->getStore() === null) {
            throw new \InvalidArgumentException('Store id is not present in request.');
        }

        if (empty($request->getIds())) {
            return $result;
        }

        $rawItems = $this->dataProvider->fetch(
            $request->getIds(),
            $request->getAttributeCodes(),
            ['store' => $request->getStore()]
        );

        if (count($rawItems) !== count($request->getIds())) {
            throw new \InvalidArgumentException(
                'Products with the following ids are not found in catalog: %1',
                implode(', ', array_diff($request->getIds(), array_keys($rawItems)))
            );
        }

        $products = [];
        foreach ($rawItems as $item) {
            $products[] = $this->prepareProduct($item);
        }

        $result->setItems($products);

        return $result;
    }

    /**
     * Unset null values in provided array recursively
     *
     * @param array $array
     * @return array
     */
    private function cleanUpNullValues(array $array): array
    {
        $result = [];
        foreach ($array as $key => $value) {
            if ($value === null || $value === '') {
                continue;
            }

            $result[$key] = is_array($value) ? $this->cleanUpNullValues($value) : $value;
        }
        return $result;
    }

    /**
     * Set product image
     *
     * @param string $key
     * @param array $rawData
     * @param ProductInterface $product
     * @return ProductInterface
     */
    private function setImage(string $key, array $rawData, ProductInterface $product): ProductInterface
    {
        if (empty($rawData[$key])) {
            return $product;
        }

        $image = new Image();
        $image->setUrl($rawData[$key]['url'] ?? '');
        $image->setLabel($rawData[$key]['label'] ?? '');
        $parts = explode('_', $key);
        $parts = array_map("ucfirst", $parts);
        $methodName = 'set' . implode('', $parts);
        if (method_exists($product, $methodName)) {
            $product->$methodName($image);
        }
        return $product;
    }

    /**
     * Import requested products
     *
     * @param ImportProductsRequestInterface $request
     * @return ImportProductsResponseInterface
     * phpcs:disable Generic.CodeAnalysis.EmptyStatement
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function importProducts(
        ImportProductsRequestInterface $request
    ): ImportProductsResponseInterface {
        // TODO: Implement ImportProducts() method.

        return new \Magento\CatalogStorefrontApi\Api\Data\ImportProductsResponse();
    }

    /**
     * Import requested categories
     *
     * @param ImportCategoriesRequestInterface $request
     * @return ImportCategoriesResponseInterface
     * phpcs:disable Generic.CodeAnalysis.EmptyStatement
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function importCategories(ImportCategoriesRequestInterface $request): ImportCategoriesResponseInterface
    {
        // TODO: Implement ImportCategories() method.

        return new \Magento\CatalogStorefrontApi\Api\Data\ImportCategoriesResponse();
    }

    /**
     * Get requested categories
     *
     * @param CategoriesGetRequestInterface $request
     * @return CategoriesGetResponseInterface
     * @throws \Magento\Framework\Exception\FileSystemException
     * @throws \Magento\Framework\Exception\RuntimeException
     * @throws \Throwable
     */
    public function getCategories(
        CategoriesGetRequestInterface $request
    ): CategoriesGetResponseInterface {
        $result = new CategoriesGetResponse();

        $categories = $this->categoryDataProvider->fetch(
            $request->getIds(),
            \array_merge($request->getAttributeCodes(), ['is_active', 'position']),
            ['store' => $request->getStore()]
        );

        usort($categories, function($a, $b) {
            return $a['position'] <=> $b['position'];
        });

        $items = [];
        foreach ($categories as $category) {
            $item = new Category();
            $category = $this->cleanUpNullValues($category);

            $this->dataObjectHelper->populateWithArray($item, $category, CategoryInterface::class);

            $children = [];
            foreach ($category['children'] ?? [] as $categoryId) {
                $children[$categoryId] = $categoryId;
            }
            $item->setChildren($children);
            $items[] = $item;
        }
        $result->setItems($items);
        return $result;
    }

    /**
     * Get video content for media gallery
     *
     * @param array $mediaGalleryItemVideo
     * @return Video
     */
    private function getMediaGalleryVideo(array $mediaGalleryItemVideo): Video
    {
        $videoContent = new Video;
        $videoContent->setMediaType($mediaGalleryItemVideo['media_type'] ?? '');
        $videoContent->setVideoDescription(
            $mediaGalleryItemVideo['video_description'] ?? ''
        );
        $videoContent->setVideoMetadata(
            $mediaGalleryItemVideo['video_metadata'] ?? ''
        );
        $videoContent->setVideoProvider(
            $mediaGalleryItemVideo['video_provider'] ?? ''
        );
        $videoContent->setVideoTitle(
            $mediaGalleryItemVideo['video_title'] ?? ''
        );
        $videoContent->setVideoUrl(
            $mediaGalleryItemVideo['video_url'] ?? ''
        );

        return $videoContent;
    }

    /**
     * Prepare product from raw data
     *
     * @param array $item
     * @return ProductInterface
     */
    private function prepareProduct(array $item): ProductInterface
    {
        $item = $this->cleanUpNullValues($item);
        $variants = [];
        foreach ($item['variants'] ?? [] as $productId => $variantData) {
            $variant = [
                'product' => $productId,
                'attributes' => $variantData['attributes']
            ];
            $variants[] = $variant;
        }
        $item['variants'] = $variants;

        $item['description'] = $item['description']['html'] ?? '';
        $item['short_description'] = $item['short_description']['html'] ?? '';
        //Convert option values to unified array format
        if (!empty($item['options'])) {
            foreach ($item['options'] as &$option) {
                $firstValue = reset($option['value']);
                if (!is_array($firstValue)) {
                    $option['value'] = [0 => $option['value']];
                    continue;
                }
            }
        }

        $product = new \Magento\CatalogStorefrontApi\Api\Data\Product();
        $this->dataObjectHelper->populateWithArray($product, $item, ProductInterface::class);
        $product = $this->setImage('image', $item, $product);
        $product = $this->setImage('small_image', $item, $product);
        $product = $this->setImage('thumbnail', $item, $product);

        //PopulateWithArray doesn't work with non-array sub-objects which don't set properties using constructor
        $mediaGalleryData = $item['media_gallery'] ?? [];
        $mediaGallery = [];
        foreach ($mediaGalleryData as $mediaGalleryDataItem) {
            $mediaGalleryItem = new MediaGalleryItem;
            $this->dataObjectHelper->populateWithArray(
                $mediaGalleryItem,
                $mediaGalleryDataItem,
                MediaGalleryItemInterface::class
            );
            if (!empty($mediaGalleryDataItem['video_content'])) {
                $videoContent = $this->getMediaGalleryVideo($mediaGalleryDataItem['video_content']);
                $mediaGalleryItem->setVideoContent($videoContent);
            }

            $mediaGallery[] = $mediaGalleryItem;
        }
        $product->setMediaGallery($mediaGallery);

        $urlRewritesData = $item['url_rewrites'] ?? [];
        $urlRewrites = [];
        foreach ($urlRewritesData as $urlRewriteData) {
            $urlRewrites[] = $this->prepareUrlRewrite($urlRewriteData);
        }
        $product->setUrlRewrites($urlRewrites);

        /**
         * FIXME: Ugly way to populate child items for Grouped product.
         * It should be refactored to general approach how to work with variations. Probably, in scope of MC-31164.
         */
        if ($product->getTypeId() == 'grouped') {
            $this->setGroupedItems($product, $item);
        }

        $product = $this->setDynamicAttributes($item, $product);

        return $product;
    }

    /**
     * Set dynamic attributes (custom attributes created in admin) to product entity.
     *
     * @param array $item
     * @param \Magento\CatalogStorefrontApi\Api\Data\Product $product
     * @return \Magento\CatalogStorefrontApi\Api\Data\Product
     */
    private function setDynamicAttributes(
        array $item,
        \Magento\CatalogStorefrontApi\Api\Data\Product $product
    ): \Magento\CatalogStorefrontApi\Api\Data\Product {

        $dynamicAttributes = [];

        foreach ($item as $attributeCode => $value) {
            $parts = explode('_', $attributeCode);
            $parts = array_map("ucfirst", $parts);
            $getterMethodName = 'get' . implode('', $parts);
            if (\method_exists($product, $getterMethodName)) {
                continue;
            }
            /** @var \Magento\CatalogStorefrontApi\Api\Data\DynamicAttributeValueInterface $dynamicAttribute */
            $dynamicAttribute = $this->dynamicAttributeFactory->create();
            $dynamicAttribute->setCode((string)$attributeCode);
            $dynamicAttribute->setValue((string)$value);
            $dynamicAttributes[] = $dynamicAttribute;
        }

        $product->setDynamicAttributes($dynamicAttributes);

        return $product;
    }

    /**
     * Temporary fix for nested items of Grouped product.
     *
     * @param \Magento\CatalogStorefrontApi\Api\Data\Product $product
     * @param array $data
     */
    private function setGroupedItems(\Magento\CatalogStorefrontApi\Api\Data\Product $product, array $data)
    {
        if (!isset($data['items'])) {
            return;
        }
        $items = [];
        foreach ($data['items'] as $item) {
            $groupedItem = new \Magento\CatalogStorefrontApi\Api\Data\GroupedItem();
            $groupedItem->setPosition((int)$item['position']);
            $groupedItem->setQty((float)$item['qty']);
            $groupedItemInfo = new \Magento\CatalogStorefrontApi\Api\Data\GroupedItemProductInfo();
            $groupedItemInfo->setName($item['product']['name']);
            $groupedItemInfo->setSku($item['product']['sku']);
            $groupedItemInfo->setTypeId($item['product']['type_id']);
            $groupedItemInfo->setUrlKey($item['product']['url_key']);
            $groupedItem->setProduct($groupedItemInfo);
            $items[] = $groupedItem;
        }
        $product->setItems($items);
    }

    /**
     * Prepare Url Rewrite data
     *
     * @param array $urlRewriteData
     * @return UrlRewrite $urlRewriteData
     */
    private function prepareUrlRewrite(array $urlRewriteData): UrlRewrite
    {
        $rewrite = new UrlRewrite;
        $rewrite->setUrl($urlRewriteData['url'] ?? '');
        $parameters = [];
        foreach ($urlRewriteData['parameters'] ?? [] as $parameterData) {
            $parameter = new UrlRewriteParameter;
            $parameter->setName($parameterData['name'] ?? '');
            $parameter->setValue($parameterData['value'] ?? '');
            $parameters[] = $parameter;
        }
        $rewrite->setParameters($parameters);

        return $rewrite;
    }
}
