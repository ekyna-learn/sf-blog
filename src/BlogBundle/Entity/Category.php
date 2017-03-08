<?php

namespace BlogBundle\Entity;

use Behat\Transliterator\Transliterator;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 */
class Category
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $slug;


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
     * Set title
     *
     * @param string $title
     * @return Category
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
     * Set description
     *
     * @param string $description
     * @return Category
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Category
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Pre persist (create only) event callback.
     */
    public function onPrePersist()
    {
        $this->updateSlug();
    }

    /**
     * Pre update event callback.
     *
     * @param PreUpdateEventArgs $event
     */
    public function onPreUpdate(PreUpdateEventArgs $event)
    {
        if ($event->hasChangedField('title')) {
            $this->updateSlug();
        }
    }

    /**
     * Updates the slug from the title.
     */
    private function updateSlug()
    {
        $slug = Transliterator::urlize($this->getTitle());

        $this->setSlug($slug);
    }
}
