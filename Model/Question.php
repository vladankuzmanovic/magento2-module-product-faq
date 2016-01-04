<?php
/**
 * @author  Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
namespace Kuzman\ProductFaq\Model;

use Kuzman\ProductFaq\Api\Data\QuestionInterface;
use Magento\Framework\DataObject\IdentityInterface;

class Question extends \Magento\Framework\Model\AbstractModel implements QuestionInterface, IdentityInterface
{

    /**#@+
     * Post's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    /**#@-*/

    const CACHE_TAG = 'kuzman_productfaq';

    /**
     * @var string
     */
    protected $_cacheTag = 'kuzman_productfaq';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'kuzman_productfaq';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Kuzman\ProductFaq\Model\ResourceModel\Question');
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
     * Prepare statuses.
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::QUESTION_ID);
    }

    /**
     * Get Email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * Get Nickname
     *
     * @return string|null
     */
    public function getNickname()
    {
        return $this->getData(self::NICKNAME);
    }

    /**
     * Get Question
     *
     * @return string|null
     */
    public function getQuestion()
    {
        return $this->getData(self::QUESTION);
    }

    /**
     * Get Answer
     *
     * @return string|null
     */
    public function getAnswer()
    {
        return $this->getData(self::ANSWER);
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
     * Get Status
     *
     * @return string|null
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Set Question Id
     *
     * @param int $id
     * @return \Kuzman\ProductFaq\Api\Data\QuestionInterface
     */
    public function setId($id)
    {
        return $this->setData(self::QUESTION_ID, $id);
    }

    /**
     * Set Email
     *
     * @param string $email
     * @return \Kuzman\ProductFaq\Api\Data\QuestionInterface
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * Set Nickname
     *
     * @param string $nickname
     * @return \Kuzman\ProductFaq\Api\Data\QuestionInterface
     */
    public function setNickname($nickname)
    {
        return $this->setData(self::NICKNAME, $nickname);
    }

    /**
     * Set Question
     *
     * @param string $question
     * @return \Kuzman\ProductFaq\Api\Data\QuestionInterface
     */
    public function setQuestion($question)
    {
        return $this->setData(self::QUESTION, $question);
    }

    /**
     * Set Answer
     *
     * @param string $answer
     * @return \Kuzman\ProductFaq\Api\Data\QuestionInterface
     */
    public function setAnswer($answer)
    {
        return $this->setData(self::ANSWER, $answer);
    }

    /**
     * Set Product Id
     *
     * @param int $productId
     * @return \Kuzman\ProductFaq\Api\Data\QuestionInterface
     */
    public function setProductId($productId)
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

    /**
     * Set status
     *
     * @param int $status
     * @return \Kuzman\ProductFaq\Api\Data\QuestionInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }
}