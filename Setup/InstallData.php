<?php

namespace Codealist\OrderGridColumn\Setup;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Sales\Setup\SalesSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallData implements InstallDataInterface
{
    /**
     * @var SalesSetupFactory
     */
    private $salesSetupFactory;

    public function __construct(
        SalesSetupFactory $salesSetupFactory
    )
    {
        $this->salesSetupFactory = $salesSetupFactory;

    }

    /**
     * Function install
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        /** @var \Magento\Sales\Setup\SalesSetup $salesInstaller */
        $salesInstaller = $this->salesSetupFactory->create(['resourceName' => 'sales_setup', 'setup' => $setup]);

        $salesInstaller
            ->addAttribute('order', 'erp_code', [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length'=> 255,
                'visible' => false,
                'nullable' => true,
            ]);

        $salesInstaller
            ->addAttribute('order', 'erp_status', [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length'=> 255,
                'visible' => false,
                'nullable' => true,
            ]);

        $setup->endSetup();
    }
}