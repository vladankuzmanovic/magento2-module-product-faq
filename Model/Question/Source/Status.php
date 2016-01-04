<?php
/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
namespace Kuzman\ProductFaq\Model\Question\Source;

class Status implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var \Kuzman\ProductFaq\Model\Question
     */
    protected $question;

    /**
     * Constructor
     *
     * @param \Kuzman\ProductFaq\Model\Question $question
     */
    public function __construct(\Kuzman\ProductFaq\Model\Question $question)
    {
        $this->question = $question;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->question->getAvailableStatuses();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}