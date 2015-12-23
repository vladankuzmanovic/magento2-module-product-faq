<?php
/**
 * @author  Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
namespace Kuzman\ProductFaq\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        // Get kuzman_product_faq table
        $tableName = $installer->getTable('kuzman_product_faq');
        // Check if the table already exists
        if ($installer->getConnection()->isTableExists($tableName) != true) {
            // Create kuzman_product_faq table
            $table = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'question_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'Question ID'
                )
                ->addColumn(
                    'email',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Email Address'
                )
                ->addColumn(
                    'nickname',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Nickname'
                )
                ->addColumn(
                    'question',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Question'
                )
                ->addColumn(
                    'answer',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Answer'
                )
                ->addColumn(
                    'status',
                    Table::TYPE_SMALLINT,
                    null,
                    ['nullable' => false, 'default' => false],
                    'Status'
                )
                ->addColumn(
                    'sort_order',
                    Table::TYPE_INTEGER,
                    null,
                    ['nullable' => false],
                    'Sort Order'
                )

                ->setComment('Product Faq')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
                $installer->getConnection()->createTable($table);
        }

        $tableName = $installer->getTable('kuzman_product_faq_id');
        if ($installer->getConnection()->isTableExists($tableName) != true) {
            // Create kuzman_product_faq_id table
            $table = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'question_id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'Question ID'
                )
                ->addColumn(
                    'question_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                    'Question Id'
                )
                ->addColumn(
                    'product_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true, 'nullable' => false, 'default' => '0'],
                    'Product Id'
                )
                ->addIndex($installer->getIdxName('kuzman_product_faq_id', ['question_id']), ['question_id'])
                ->addForeignKey(
                    $installer->getFkName(
                        'kuzman_product_faq_id',
                        'question_id',
                        'kuzman_product_faq',
                        'question_id'),
                    'question_id',
                    $installer->getTable('kuzman_product_faq'),
                    'question_id',
                    Table::ACTION_CASCADE)
                ->setComment('Product ID Faq')
                ->setOption('type', 'InnoDB')
                ->setOption('charset', 'utf8');
            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
}