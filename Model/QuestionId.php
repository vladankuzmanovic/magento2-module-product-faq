<?php
/**
 * @author  Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
namespace Kuzman\ProductFaq\Model;

use Kuzman\ProductFaq\Api\Data\QuestionIdInterface;
use Magento\Framework\DataObject\IdentityInterface;

class QuestionId extends \Magento\Framework\Model\AbstractModel implements QuestionIdInterface, IdentityInterface
{

    const CACHE_TAG = 'kuzman_productfaq_id';

    /**
     * @var string
     */
    protected $_cacheTag = 'kuzman_productfaq_id';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'kuzman_productfaq_id';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Kuzman\ProductFaq\Model\ResourceModel\QuestionId');
    }


    /**
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }


    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }
    /**
     * Get Question ID
     *
     * @return int|null
     */
    public function getQuestionId()
    {
        return $this->getData(self::QUESTION_ID);
    }

    /**
     * Get Product Id
     *
     * @return string|null
     */
    public function getProductId()
    {
        return $this->getData(self::PRODUCT_ID);
    }

    /**
     * Set  Id
     *
     * @param int $id
     * @return \Kuzman\ProductFaq\Api\Data\QuestionIdInterface
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }
    /**
     * Set Question Id
     *
     * @param int $questionId
     * @return \Kuzman\ProductFaq\Api\Data\QuestionIdInterface
     */
    public function setQuestionId($questionId)
    {
        return $this->setData(self::QUESTION_ID, $questionId);
    }

    /**
     * Set Product Id
     *
     * @param int $productId
     * @return \Kuzman\ProductFaq\Api\Data\QuestionIdInterface
     */
    public function setProductId($productId)
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }
}