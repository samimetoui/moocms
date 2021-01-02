<?php
namespace sf_moocms\MoocmsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * LessonSearch
 *
 */
class LessonSearch
{
    /**
     * @var int
     *
     */
    private $id;


    /**
     * @var string
     *
     */
    private $level;

    /**
     * @var string
     *
     */
    private $topic;

    /**
     * @var string
     *
     */
    private $categories;

    public function __construct() {
        $this->category = new ArrayCollection();
    }


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set level.
     * @param level
     * @return SearchLesson
     */
    public function setLevel($level)
    {
        $this->level = $level;
        return $this;
    }

    /**
     * Get level.
     * @return level
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set category.
     * @param ArrayCollection categories
     * @return SearchLesson
     */
    public function setCategories(ArrayCollection $categories)
    {
        $this->categories = $categories;
        return $this;
    }

    /**
     * Get category.
     * @return ArrayCollection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set topic.
     * @param topic
     * @return SearchLesson
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;
        return $this;
    }

    /**
     * Get topic.
     * @return ArrayCollection
     */
    public function getTopic()
    {
        return $this->topic;
    }
}
