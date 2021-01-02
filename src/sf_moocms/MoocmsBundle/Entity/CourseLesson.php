<?php

namespace sf_moocms\MoocmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CourseLesson
 *
 * @ORM\Table(name="course_lesson")
 * @ORM\Entity(repositoryClass="sf_moocms\MoocmsBundle\Repository\CourseLessonRepository")
 */
class CourseLesson
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;


  /**
   * @ORM\ManyToOne(targetEntity="sf_moocms\MoocmsBundle\Entity\Course", inversedBy="course_lessons")
   * @ORM\JoinColumn(nullable=false)
   */
  private $course;

  /**
   * @ORM\ManyToOne(targetEntity="sf_moocms\MoocmsBundle\Entity\Lesson")
   * @ORM\JoinColumn(nullable=false)
   */
  private $lesson;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return CourseLesson
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set course
     *
     * @param \sf_moocms\MoocmsBundle\Entity\Course $course
     * @return CourseLesson
     */
    public function setCourse(\sf_moocms\MoocmsBundle\Entity\Course $course)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return \sf_moocms\MoocmsBundle\Entity\Course 
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set lesson
     *
     * @param \sf_moocms\MoocmsBundle\Entity\Lesson $lesson
     * @return CourseLesson
     */
    public function setLesson(\sf_moocms\MoocmsBundle\Entity\Lesson $lesson)
    {
        $this->lesson = $lesson;

        return $this;
    }

    /**
     * Get lesson
     *
     * @return \sf_moocms\MoocmsBundle\Entity\Lesson 
     */
    public function getLesson()
    {
        return $this->lesson;
    }
}
