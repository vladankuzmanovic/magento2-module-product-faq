<?php
/**
 * @author  Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
namespace Kuzman\ProductFaq\Api\Data;

interface QuestionInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const QUESTION_ID   = 'question_id';
    const EMAIL         = 'email';
    const NICKNAME      = 'nickname';
    const QUESTION      = 'question';
    const ANSWER        = 'answer';
    const STATUS        = 'status';

    /**
     * Get question id
     *
     * @return int|null
     */
    public function getId();


    /**
     * Get Email
     *
     * @return string|null
     */
    public function getEmail();

    /**
     * Get Nickname
     *
     * @return string|null
     */
    public function getNickname();

    /**
     * Get Question
     *
     * @return string|null
     */
    public function getQuestion();

    /**
     * Get Answer
     *
     * @return string|null
     */
    public function getAnswer();

    /**
     * Get Status
     *
     * @return int|null
     */
    public function getStatus();

    /**
     * Set Question ID
     *
     * @param int $id
     * @return \Kuzman\ProductFaq\Api\Data\QuestionInterface
     */
    public function setId($id);

    /**
     * Set Email
     *
     * @param string $email
     * @return \Kuzman\ProductFaq\Api\Data\QuestionInterface
     */
    public function setEmail($email);

    /**
     * Set Nickname
     *
     * @param string $nickname
     * @return \Kuzman\ProductFaq\Api\Data\QuestionInterface
     */
    public function setNickname($nickname);

    /**
     * Set Question
     *
     * @param string $description
     * @return \Kuzman\ProductFaq\Api\Data\QuestionInterface
     */
    public function setQuestion($question);

    /**
     * Set Answer
     *
     * @param string $answer
     * @return \Kuzman\ProductFaq\Api\Data\QuestionInterface
     */
    public function setAnswer($answer);

    /**
     * Set status
     *
     * @param int $status
     * @return \Kuzman\ProductFaq\Api\Data\QuestionInterface
     */
    public function setStatus($status);
}