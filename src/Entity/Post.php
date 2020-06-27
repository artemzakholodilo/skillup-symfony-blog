<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 * @ORM\Table(name="post")
 * @UniqueEntity("slug")
 */
class Post
{
    public const ITEMS_PER_PAGE = 8;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", length=8)
     */
    private int $id;

    /**
     * @ORM\Column(type="string", unique=true, options={"default": null})
     * @Assert\NotBlank(message="Слаг не может быть пустым")
     */
    private $slug;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min="10", max="60",
     *     minMessage="Поле должно содержать не менее {{ value }} символов",
     *     maxMessage="60 max"
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $body;

    /**
     * @var Category $categories
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="posts")
     */
    private $category;

    /**
     * @var $tags
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="posts")
     * @ORM\JoinTable(name="tag_posts")
     */
    private $tags;

    /**
     * @var ArrayCollection $images
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="post")
     */
    private $images;
//    private ArrayCollection $users;

    /**
     * @todo assert multiple images
     * @ORM\Column(type="string", nullable=true)
     * @Assert\File(mimeTypes={"image/jpg", "image/png"})
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $created;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $updated;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $published = false;

    /**
     * Post constructor
     */
    public function __construct()
    {
        $this->created = $this->updated = new \DateTime();
        $this->images = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     */
    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @param string|null $body
     */
    public function setBody(?string $body): void
    {
        $this->body = $body;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): ?\DateTime
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created): void
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated(): ?\DateTime
    {
        return $this->updated;
    }

    /**
     * @param \DateTime $updated
     */
    public function setUpdated(\DateTime $updated): void
    {
        $this->updated = $updated;
    }

    /**
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->published;
    }

    /**
     * @param bool $published
     */
    public function setPublished(bool $published): void
    {
        $this->published = $published;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     */
    public function setTags($tags): void
    {
        $this->tags = $tags;
    }

    public function addTag($tag)
    {
        $this->tags[] = $tag;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return ArrayCollection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param $image
     */
    public function addImage($image)
    {
        $this->images->add($image);
    }

    public function removeImage($image)
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
        }
    }

    public function removeImages()
    {
        foreach ($this->images as $image) {
            $this->images->removeElement($image);
        }
    }
}