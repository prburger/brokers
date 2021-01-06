<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\Column(type="date")
     */
    private $dateAdded;

    /**
     * @ORM\Column(type="date")
     */
    private $dateEdited;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     */
    private $sentBy;

    /**
     * @ORM\OneToMany(targetEntity=Broker::class, mappedBy="message")
     */
    private $brokers;

    /**
     * @ORM\OneToMany(targetEntity=Customer::class, mappedBy="message")
     */
    private $customers;

    /**
     * @ORM\OneToMany(targetEntity=Supplier::class, mappedBy="message")
     */
    private $suppliers;

    public function __construct()
    {
        $this->setDateAdded(new \DateTime());
        $this->setDateEdited(new \DateTime());
        $this->brokers = new ArrayCollection();
        $this->customers = new ArrayCollection();
        $this->suppliers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getDateAdded(): ?\DateTimeInterface
    {
        return $this->dateAdded;
    }

    public function setDateAdded(\DateTimeInterface $dateAdded): self
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }

    public function getDateEdited(): ?\DateTimeInterface
    {
        return $this->dateEdited;
    }

    public function setDateEdited(\DateTimeInterface $dateEdited): self
    {
        $this->dateEdited = $dateEdited;

        return $this;
    }

    public function getSentBy(): ?string
    {
        return $this->sentBy;
    }

    public function setSentBy(?string $sentBy): self
    {
        $this->sentBy = $sentBy;

        return $this;
    }

    public function setBrokers(Array $brokers )
    {
        $this->brokers = $brokers;
    }

    public function setCustomers(Array $customers )
    {
        $this->customers = $customers;
    }

    public function setSuppliers(Array $suppliers )
    {
        $this->suppliers = $suppliers;
    }

    /**
     * @return Collection|Broker[]
     */
    public function getBrokers(): Collection
    {
        return $this->brokers;
    }

    public function addBroker(Broker $broker): self
    {
        if (!$this->brokers->contains($broker)) {
            $this->brokers[] = $broker;
            $broker->setMessage($this);
        }

        return $this;
    }

    public function removeBroker(Broker $broker): self
    {
        if ($this->brokers->removeElement($broker)) {
            // set the owning side to null (unless already changed)
            if ($broker->getMessage() === $this) {
                $broker->setMessage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Customer[]
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(Customer $customer): self
    {
        if (!$this->customers->contains($customer)) {
            $this->customers[] = $customer;
            $customer->setMessage($this);
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): self
    {
        if ($this->customers->removeElement($customer)) {
            // set the owning side to null (unless already changed)
            if ($customer->getMessage() === $this) {
                $customer->setMessage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Supplier[]
     */
    public function getSuppliers(): Collection
    {
        return $this->suppliers;
    }

    public function addSupplier(Supplier $supplier): self
    {
        if (!$this->suppliers->contains($supplier)) {
            $this->suppliers[] = $supplier;
            $supplier->setMessage($this);
        }

        return $this;
    }

    public function removeSupplier(Supplier $supplier): self
    {
        if ($this->suppliers->removeElement($supplier)) {
            // set the owning side to null (unless already changed)
            if ($supplier->getMessage() === $this) {
                $supplier->setMessage(null);
            }
        }

        return $this;
    }
}
