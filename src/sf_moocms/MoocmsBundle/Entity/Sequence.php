<?php

namespace sf_moocms\MoocmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Sequence
 *
 * @ORM\Table(name="sequence")
 * @ORM\Entity(repositoryClass="sf_moocms\MoocmsBundle\Repository\SequenceRepository")
 */
class Sequence
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
     * @Assert\NotBlank()
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var text
     * @Assert\NotBlank()
     * @ORM\Column(name="summary", type="text")
     */
    private $summary;

    /**
     * @var text
     *
     * @ORM\Column(name="goals", type="text", nullable=true)
     */
    private $goals;

    /**
     * @var enum
     *
     * @ORM\Column(name="pedagogical_method", type="string", nullable=true, columnDefinition="enum('expositive', 'demonstrative', 'experiential', 'interrogative', 'active')")
     */
    private $pedagogical_method;

    /**
     * @var text
     *
     * @ORM\Column(name="method_description", type="text", nullable=true)
     */
    private $method_description;
    

    /**
     * @var text
     * 
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;


    /** 
     * @ORM\ManyToOne(targetEntity="sf_moocms\MoocmsBundle\Entity\Lesson")
     * @ORM\JoinColumn(nullable=false, onDelete="cascade")
     */
    private $lesson;

     /**
    * @ORM\ManyToOne(targetEntity="sf_moocms\MoocmsBundle\Entity\Activity" )
    * @ORM\JoinColumn(nullable=true)
    */
    private $activity;

    
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
     * Set number
     *
     * @param integer $number
     * @return Sequence
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Sequence
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set summary
     *
     * @param string $summary
     * @return Sequence
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string 
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set lesson
     *
     * @param \sf_moocms\MoocmsBundle\Entity\Lesson $lesson
     * @return Sequence
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

    /**
     * Set content
     *
     * @param string $content
     * @return Sequence
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    
    /**
     * Set pedagogical_method
     *
     * @param string $pedagogicalMethod
     * @return Sequence
     */
    public function setPedagogicalMethod($pedagogicalMethod)
    {
        $this->pedagogical_method = $pedagogicalMethod;

        return $this;
    }

    /**
     * Get pedagogical_method
     *
     * @return string 
     */
    public function getPedagogicalMethod()
    {
        return $this->pedagogical_method;
    }

    /**
     * Set method_description
     *
     * @param string $methodDescription
     * @return Sequence
     */
    public function setMethodDescription($methodDescription)
    {
        $this->method_description = $methodDescription;

        return $this;
    }

    /**
     * Get method_description
     *
     * @return string 
     */
    public function getMethodDescription()
    {
        return $this->method_description;
    }

    /**
     * Set goals
     *
     * @param string $goals
     * @return Sequence
     */
    public function setGoals($goals)
    {
        $this->goals = $goals;

        return $this;
    }

    /**
     * Get goals
     *
     * @return string 
     */
    public function getGoals()
    {
        return $this->goals;
    }

    /**
     * Set activity
     *
     * @param \sf_moocms\MoocmsBundle\Entity\Activity $activity
     * @return Sequence
     */
    public function setActivity(\sf_moocms\MoocmsBundle\Entity\Activity $activity = null)
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * Get activity
     *
     * @return \sf_moocms\MoocmsBundle\Entity\Activity 
     */
    public function getActivity()
    {
        return $this->activity;
    }
}
