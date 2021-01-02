<?php

namespace sf_moocms\MoocmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Lesson
 *
 * @ORM\Table(name="lesson")
 * @ORM\Entity(repositoryClass="sf_moocms\MoocmsBundle\Repository\LessonRepository")
 */
class Lesson
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
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="summary", type="text")
     */
    private $summary;

    /**
     * @var text
     * 
     * @ORM\Column(name="prerequisite", type="text", nullable=true)
     */
    private $prerequisite;

    /**
     * @var text
     *
     * @ORM\Column(name="goals", type="text", nullable=true)
     */
    private $goals;

    /**
     * @var text
     *
     * @ORM\Column(name="behaviours", type="text", nullable=true)
     */
    private $behaviours;

    /**
     * @var text
     *
     * @ORM\Column(name="purposes", type="text", nullable=true)
     */
    private $purposes;

    /**
     * @var bool
     *
     * @ORM\Column(name="promote", type="boolean", options={"default"= 0})
     */
    private $promote;

    /**
     * @var bool
     *
     * @ORM\Column(name="published", type="boolean", options={"default"= 0})
     */
    private $published;

    /**
     * @ORM\OneToOne(targetEntity="sf_moocms\MoocmsBundle\Entity\Image", cascade={"persist"})
     */
    private $image;

    /**
    * @ORM\ManyToOne(targetEntity="sf_moocms\MoocmsBundle\Entity\Topic")
    * @ORM\JoinColumn(nullable=true)
    */
    private $topic;

    /**
    * 
    * @ORM\ManyToMany(targetEntity="sf_moocms\MoocmsBundle\Entity\Category", cascade={"persist"})
    * @ORM\JoinTable(name="lesson_category")
    */
    private $categories;

    /**
    * @var integer
    * 
    * @ORM\Column(name="level", type="integer", options={"default"= 0})
    */

    private $level;

    /**
    * @ORM\ManyToOne(targetEntity="sf_moocms\UserBundle\Entity\User")
    * @ORM\JoinColumn(nullable=true)
    */
    private $user;

    /**
    * @ORM\ManyToOne(targetEntity="sf_moocms\MoocmsBundle\Entity\Activity", cascade={"persist"})
    * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
    */
    private $activity;
  

  // Comme la propriété $categories doit être un ArrayCollection,
  // On doit la définir dans un constructeur :
  public function __construct()
  {
    $this->categories = new ArrayCollection();
  }

  // Notez le singulier, on ajoute une seule catégorie à la fois
  public function addCategory(Category $category)
  {
    // Ici, on utilise l'ArrayCollection vraiment comme un tableau
    $this->categories[] = $category;
  }

  public function removeCategory(Category $category)
  {
    // Ici on utilise une méthode de l'ArrayCollection, pour supprimer la catégorie en argument
    $this->categories->removeElement($category);
  }

  // // Notez le pluriel, on récupère une liste de catégories ici !
  public function getCategories()
  {
    return $this->categories;
  }



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
     * Set name
     *
     * @param string $name
     * @return t_lesson
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set summary
     *
     * @param string $summary
     * @return t_lesson
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
     * Set Topic
     *
     * @param \sf_moocms\MoocmsBundle\Entity\Topic $tTopic
     * @return t_lesson
     */
    public function setTopic(\sf_moocms\MoocmsBundle\Entity\topic $topic = null)
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * Get Topic
     *
     * @return \sf_moocms\MoocmsBundle\Entity\Topic 
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * Set user
     *
     * @param \sf_moocms\UserBundle\Entity\User $user
     * @return Lesson
     */
    public function setUser(\sf_moocms\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \sf_moocms\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set image
     *
     * @param \sf_moocms\MoocmsBundle\Entity\Image $image
     * @return Lesson
     */
    public function setImage(\sf_moocms\MoocmsBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \sf_moocms\MoocmsBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set published
     *
     * @param boolean $published
     * @return Lesson
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set promote
     *
     * @param boolean $promote
     * @return Lesson
     */
    public function setPromote($promote)
    {
        $this->promote = $promote;

        return $this;
    }

    /**
     * Get promote
     *
     * @return boolean 
     */
    public function getPromote()
    {
        return $this->promote;
    }

    /**
     * Set prerequisite
     *
     * @param string $prerequisite
     * @return Lesson
     */
    public function setPrerequisite($prerequisite)
    {
        $this->prerequisite = $prerequisite;

        return $this;
    }

    /**
     * Get prerequisite
     *
     * @return string 
     */
    public function getPrerequisite()
    {
        return $this->prerequisite;
    }

    /**
     * Set goals
     *
     * @param string $goals
     * @return Lesson
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
     * Set behaviours
     *
     * @param string $behaviours
     * @return Lesson
     */
    public function setBehaviours($behaviours)
    {
        $this->behaviours = $behaviours;

        return $this;
    }

    /**
     * Get behaviours
     *
     * @return string 
     */
    public function getBehaviours()
    {
        return $this->behaviours;
    }

    /**
     * Set purposes
     *
     * @param string $purposes
     * @return Lesson
     */
    public function setPurposes($purposes)
    {
        $this->purposes = $purposes;

        return $this;
    }

    /**
     * Get purposes
     *
     * @return string 
     */
    public function getPurposes()
    {
        return $this->purposes;
    }



    /**
     * Set activity
     *
     * @param \sf_moocms\MoocmsBundle\Entity\Activity $activity
     * @return Lesson
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

    /**
     * Set level
     *
     * @param integer $level
     * @return Lesson
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }
}
