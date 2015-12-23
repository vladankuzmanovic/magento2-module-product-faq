<?php
/**
 * @author  Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
namespace Kuzman\ProductFaq\Api\Data;

interface QuestionIdInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID            = 'id';
    const QUESTION_ID   = 'question_id';
    const PRODUCT_ID    = 'product_id';

    /**
     * Get id
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get question id
     *
     * @return int|null
     */
    public function getQuestionId();

    /**
     * Get Product Id
     *
     * @return int|null
     */
    public function getProductId();

    /**
     * Set ID
     *
     * @param int $id
     * @return \Kuzman\ProductFaq\Api\Data\QuestionIdInterface
     */
    public function setId($id);

    /**
     * Set Question ID
     *
     * @param int $questionId
     * @return \Kuzman\ProductFaq\Api\Data\QuestionIdInterface
     */
    public function setQuestionId($questionId);

    /**
     * Set Product Id
     *
     * @param int $productId
     * @return \Kuzman\ProductFaq\Api\Data\QuestionIdInterface
     */
    public function setProductId($productId);
}