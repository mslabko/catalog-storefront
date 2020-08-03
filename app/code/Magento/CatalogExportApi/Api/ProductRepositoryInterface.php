<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\CatalogExportApi\Api;

/**
 * Product entity repository
 */
interface ProductRepositoryInterface
{
    /**
     * Get products by ids
     *
     * @param string[] $ids
     * @return \Magento\CatalogExportApi\Api\Data\Product[]
     */
    public function get(array $ids);

    /**
     * Get deleted products by ids.
     *
     * @param string[] $ids
     * @return array
     */
    public function getDeleted(array $ids): array;
}
