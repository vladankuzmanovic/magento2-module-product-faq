<?php
/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
namespace Kuzman\ProductFaq\Model\ResourceModel\QuestionId;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';
    
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Kuzman\ProductFaq\Model\QuestionId',
            'Kuzman\ProductFaq\Model\ResourceModel\QuestionId'
        );
    }
}