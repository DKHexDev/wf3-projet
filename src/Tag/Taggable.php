<?php
namespace App\Tag;

use App\Entity\Tag;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
// use Symfony\Component\Validator\Constraints as Assert;

trait Taggable {

    /**
     * @var array|object
     * 
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="recipes", cascade={"persist"})
     * @Groups({"public_json"})
     */
    private $tags;

    /**
     * @return Collection|Tag[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
            $this->tags[] = $tag;

            return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

}