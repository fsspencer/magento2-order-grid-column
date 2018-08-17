<?php
/**
 * Copyright © 2018 Codealist. All rights reserved.
 *
 * @category Class
 * @package  Codealist_OrderGridColumn
 * @author   Codealist <info@codealist.com>
 * @license  See LICENSE.txt for license details.
 * @link     https://www.codealist.com/
 */

namespace Codealist\OrderGridColumn\Ui\Component\Columns;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class OrderGrid extends Column
{
    /**
     * @var OrderRepositoryInterface
     */
    protected $_orderRepository;

    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param OrderRepositoryInterface $orderRepository
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        OrderRepositoryInterface $orderRepository,
        array $components = [],
        array $data = []
    )
    {
        $this->_orderRepository = $orderRepository;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $item[$this->getData('name')] =
                    $this->getAttributeValue($item['increment_id'], $this->getData('attributeCode'));
            }
        }
        return $dataSource;
    }

    public function getAttributeValue($orderId, $attributeCode)
    {
        $order = $this->_orderRepository->get($orderId);
        return $order->getData($attributeCode);
    }

}