<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\GraphQl\ConfigurableProduct;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Pricing\Price\FinalPrice;
use Magento\Catalog\Pricing\Price\RegularPrice;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\TestFramework\ObjectManager;
use Magento\TestFramework\TestCase\GraphQlAbstract;

/**
 * Test products query for configurable products
 */
class ConfigurableProductViewTest extends GraphQlAbstract
{
    /**
     * @var array
     */
    private $configurableOptions = [];

    /**
     * @magentoApiDataFixture Magento/ConfigurableProduct/_files/product_configurable_with_category_and_weight.php
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function testQueryConfigurableProductLinks()
    {
        //TODO: remove skip after issue fix
        self::markTestSkipped('Unskip this test after MC-31037 issue completed');
        $productSku = 'configurable';

        $query
            = <<<QUERY
{
  products(filter: {sku: {eq: "{$productSku}"}}) {
    items {
      id
      attribute_set_id
      created_at
      name
      sku
      type_id
      updated_at
      ... on PhysicalProductInterface {
        weight
      }
      price {
        minimalPrice {
          amount {
            value
            currency
          }
          adjustments {
            amount {
              value
              currency
            }
            code
            description
          }
        }
        maximalPrice {
          amount {
            value
            currency
          }
          adjustments {
            amount {
              value
              currency
            }
            code
            description
          }
        }
        regularPrice {
          amount {
            value
            currency
          }
          adjustments {
            amount {
              value
              currency
            }
            code
            description
          }
        }
      }
      ... on ConfigurableProduct {
        configurable_options {
          id
          attribute_id
          label
          position
          use_default
          attribute_code
          values {
            value_index
            label
            store_label
            default_label
            use_default_value
          }
          product_id
        }
        variants {
          product {
            id
            name
            sku
            attribute_set_id
            ... on PhysicalProductInterface {
              weight
            }
            created_at
            updated_at
            price {
              minimalPrice {
                amount {
                  value
                  currency
                }
                adjustments {
                  amount {
                    value
                    currency
                  }
                  code
                  description
                }
              }
              maximalPrice {
                amount {
                  value
                  currency
                }
                adjustments {
                  amount {
                    value
                    currency
                  }
                  code
                  description
                }
              }
              regularPrice {
                amount {
                  value
                  currency
                }
                adjustments {
                  amount {
                    value
                    currency
                  }
                  code
                  description
                }
              }
            }
            categories {
              id
            }
            media_gallery_entries {
              disabled
              file
              id
              label
              media_type
              position
              types
              content {
                base64_encoded_data
                type
                name
              }
              video_content {
                media_type
                video_description
                video_metadata
                video_provider
                video_title
                video_url
              }
            }
          }
          attributes {
            label
            code
            value_index
          }
        }
      }
    }
  }
}
QUERY;

        $response = $this->graphQlQuery($query);

        /**
         * @var ProductRepositoryInterface $productRepository
         */
        $productRepository = ObjectManager::getInstance()->get(ProductRepositoryInterface::class);
        $product = $productRepository->get($productSku, false, null, true);

        $this->assertArrayHasKey('products', $response);
        $this->assertArrayHasKey('items', $response['products']);
        $this->assertEquals(1, count($response['products']['items']));
        $this->assertArrayHasKey(0, $response['products']['items']);
        $this->assertBaseFields($product, $response['products']['items'][0]);
        $this->assertConfigurableProductOptions($response['products']['items'][0]);
        $this->assertConfigurableVariants($response['products']['items'][0]);
    }

    /**
     * @param ProductInterface $product
     * @param array $actualResponse
     */
    private function assertBaseFields($product, $actualResponse)
    {
        /** @var \Magento\Framework\Pricing\PriceInfo\Factory $priceInfoFactory */
        $priceInfoFactory = ObjectManager::getInstance()->get(\Magento\Framework\Pricing\PriceInfo\Factory::class);
        $priceInfo = $priceInfoFactory->create($product);
        /** @var \Magento\Catalog\Pricing\Price\FinalPriceInterface $finalPrice */
        $finalPrice = $priceInfo->getPrice(FinalPrice::PRICE_CODE);
        $minimalPriceAmount = $finalPrice->getMinimalPrice();
        $maximalPriceAmount = $finalPrice->getMaximalPrice();
        $regularPriceAmount = $priceInfo->getPrice(RegularPrice::PRICE_CODE)->getAmount();
        /** @var MetadataPool $metadataPool */
        $assertionMap = [
            ['response_field' => 'attribute_set_id', 'expected_value' => $product->getAttributeSetId()],
            ['response_field' => 'created_at', 'expected_value' => $product->getCreatedAt()],
            [
                'response_field' => 'id',
                'expected_value' => $product->getId(),
            ],
            ['response_field' => 'name', 'expected_value' => $product->getName()],
            ['response_field' => 'sku', 'expected_value' => $product->getSku()],
            ['response_field' => 'type_id', 'expected_value' => $product->getTypeId()],
            ['response_field' => 'updated_at', 'expected_value' => $product->getUpdatedAt()],
            ['response_field' => 'weight', 'expected_value' => $product->getWeight()],
            [
                'response_field' => 'price',
                'expected_value' => [
                    'minimalPrice' => [
                        'amount' => [
                            'value' => $minimalPriceAmount->getValue(),
                            'currency' => 'USD'
                        ],
                        'adjustments' => []
                    ],
                    'regularPrice' => [
                        'amount' => [
                            'value' => $maximalPriceAmount->getValue(),
                            'currency' => 'USD'
                        ],
                        'adjustments' => []
                    ],
                    'maximalPrice' => [
                        'amount' => [
                            'value' => $regularPriceAmount->getValue(),
                            'currency' => 'USD'
                        ],
                        'adjustments' => []
                    ],
                ]
            ],
        ];

        $this->assertResponseFields($actualResponse, $assertionMap);
    }

    /**
     * Asserts various fields for child products for a configurable products
     *
     * @param $actualResponse
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    private function assertConfigurableVariants($actualResponse)
    {
        $this->assertNotEmpty(
            $actualResponse['variants'],
            "Precondition failed: 'variants' must not be empty"
        );
        foreach ($actualResponse['variants'] as $variantKey => $variantArray) {
            $this->assertNotEmpty($variantArray);
            $this->assertNotEmpty($variantArray['product']);
            $this->assertTrue(
                isset($variantArray['product']['id']),
                'variant product elements don\'t contain id key'
            );
            $variantProductId = $variantArray['product']['id'];
            $indexValue = $variantArray['product']['sku'];
            unset($variantArray['product']['id']);
            $this->assertTrue(
                isset($variantArray['product']['categories']),
                'variant product doesn\'t contain categories key'
            );
            $productRepository = ObjectManager::getInstance()->get(ProductRepositoryInterface::class);
            /** @var \Magento\Catalog\Model\Product $childProduct */
            $childProduct = $productRepository->get($indexValue);

            switch ($variantProductId) {
                case 10:
                    $this->assertEmpty(
                        $actualResponse['variants'][$variantKey]['product']['categories'],
                        'No category is expected for product, that not visible individually'
                    );
                    break;
                case 20:
                    $this->assertEquals(
                        $actualResponse['variants'][$variantKey]['product']['categories'][0],
                        ['id' => 333]
                    );
                    break;
            }

            unset($variantArray['product']['categories']);

            // assert media gallery
            $this->assertTrue(
                is_array(
                    $actualResponse['variants']
                    [$variantKey]
                    ['product']
                    ['media_gallery_entries']
                )
            );
            $this->assertCount(
                1,
                $actualResponse['variants'][$variantKey]['product']['media_gallery_entries'],
                'there must be 1 record in the media gallery'
            );
            $this->assertResponseFields(
                $actualResponse['variants']
                [$variantKey]
                ['product']
                ['media_gallery_entries'][0],
                [
                    'disabled' => false,
                    'label' => 'Video Label',
                    'media_type' => 'external-video',
                    'position' => 2
                ]
            );
            $this->assertResponseFields(
                $actualResponse['variants']
                [$variantKey]
                ['product']
                ['media_gallery_entries']
                [0]
                ['video_content'],
                [
                    'media_type' => 'external-video',
                    'video_description' => 'Video description',
                    'video_metadata' => 'Video Metadata',
                    'video_provider' => 'youtube',
                    'video_title' => 'Video title',
                    'video_url' => 'http://www.youtube.com/v/tH_2PFNmWoga'
                ]
            );
            unset($variantArray['product']['media_gallery_entries']);

            foreach ($variantArray['product'] as $key => $value) {
                if ($key !== 'price') {
                    $this->assertEquals($value, $childProduct->getData($key));
                }
            }

            //assert prices
            $this->assertEquals(
                [
                    'minimalPrice' => [
                        'amount' => [
                            'value' => $childProduct->getFinalPrice(),
                            'currency' => 'USD'
                        ],
                        'adjustments' => []
                    ],
                    'regularPrice' => [
                        'amount' => [
                            'value' => $childProduct->getFinalPrice(),
                            'currency' => 'USD'
                        ],
                        'adjustments' => []
                    ],
                    'maximalPrice' => [
                        'amount' => [
                            'value' => $childProduct->getFinalPrice(),
                            'currency' => 'USD'
                        ],
                        'adjustments' => []
                    ],
                ],
                $variantArray['product']['price']
            );

            $configurableOptions = $this->getConfigurableOptions();
            $this->assertEquals(1, count($variantArray['attributes']));
            foreach ($variantArray['attributes'] as $attribute) {
                $hasAssertion = false;
                foreach ($configurableOptions as $option) {
                    foreach ($option['options'] as $value) {
                        if ((int)$value['value_index'] === (int)$attribute['value_index']) {
                            $this->assertEquals((int)$attribute['value_index'], (int)$value['value_index']);
                            $this->assertEquals($attribute['label'], $value['label']);
                            $hasAssertion = true;
                        }
                    }
                    $this->assertEquals($attribute['code'], $option['attribute_code']);
                }
                if (!$hasAssertion) {
                    $this->fail('variant did not contain correct attributes');
                }
            }
        }
    }

    private function assertConfigurableProductOptions($actualResponse)
    {
        $this->assertNotEmpty(
            $actualResponse['configurable_options'],
            "Precondition failed: 'configurable_options' must not be empty"
        );
        $configurableAttributeOptions = $this->getConfigurableOptions();
        $configurableAttributeOption = array_shift($configurableAttributeOptions);

        $this->assertEquals(
            $actualResponse['configurable_options'][0]['id'],
            $configurableAttributeOption['id']
        );
        $this->assertEquals(
            $actualResponse['configurable_options'][0]['use_default'],
            (bool)$configurableAttributeOption['use_default']
        );
        $this->assertEquals(
            $actualResponse['configurable_options'][0]['attribute_id'],
            $configurableAttributeOption['attribute_id']
        );
        $this->assertEquals(
            $actualResponse['configurable_options'][0]['label'],
            $configurableAttributeOption['label']
        );
        $this->assertEquals(
            $actualResponse['configurable_options'][0]['position'],
            $configurableAttributeOption['position']
        );
        $this->assertEquals(
            $actualResponse['configurable_options'][0]['attribute_code'],
            $configurableAttributeOption['attribute_code']
        );
        $optionsCount = count($configurableAttributeOption['options']);
        self::assertCount(
            $optionsCount,
            $actualResponse['configurable_options'][0]['values'],
            'Product option values count in response is different with real option values'
        );
        foreach ($actualResponse['configurable_options'][0]['values'] as $key => $value) {
            $this->assertEquals(
                $value['label'],
                $configurableAttributeOption['options'][$key]['label']
            );
            $this->assertEquals(
                $value['store_label'],
                $configurableAttributeOption['options'][$key]['store_label']
            );
            $this->assertEquals(
                $value['default_label'],
                $configurableAttributeOption['options'][$key]['default_label']
            );
            $this->assertEquals(
                $value['use_default_value'],
                $configurableAttributeOption['options'][$key]['use_default_value']
            );
            $this->assertEquals(
                (int)$value['value_index'],
                (int)$configurableAttributeOption['options'][$key]['value_index']
            );
        }
    }

    private function getConfigurableOptions()
    {
        if (!empty($this->configurableOptions)) {
            return $this->configurableOptions;
        }
        $productSku = 'configurable';
        /** @var ProductRepositoryInterface $productRepo */
        $productRepo = ObjectManager::getInstance()->get(ProductRepositoryInterface::class);
        $product = $productRepo->get($productSku);
        $configurableAttributeOptions = $product->getExtensionAttributes()->getConfigurableProductOptions();
        $configurableAttributeOptionsData = [];
        foreach ($configurableAttributeOptions as $option) {
            $configurableAttributeOptionsData[$option->getId()] = $option->getData();
            // product_id is deprecated
            unset($configurableAttributeOptionsData[$option->getId()]['product_id']);
            $configurableAttributeOptionsData[$option->getId()]['id'] = $option->getId();
            $configurableAttributeOptionsData[$option->getId()]['attribute_code']
                = $option->getProductAttribute()->getAttributeCode();
            unset($configurableAttributeOptionsData[$option->getId()]['values']);
            foreach ($option->getValues() as $value) {
                $configurableAttributeOptionsData[$option->getId()]['values'][$value->getId()] = $value->getData();
                $configurableAttributeOptionsData[$option->getId()]['values'][$value->getId()]['label']
                    = $value->getLabel();
            }
        }

        return $this->configurableOptions = $configurableAttributeOptionsData;
    }
}
