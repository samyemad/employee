<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\Interfaces\EntityInterface;
use Symfony\Component\Validator\Constraints as ValidationAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass=EmployeeRepository::class)
 * @UniqueEntity(
 *     fields={"email"},
 *     groups={"save"},
 *     errorPath="email",
 *     message="This email is already in use on that system."
 * )
 * @UniqueEntity(
 *     fields={"identifier"},
 *     groups={"save"},
 *     errorPath="identifier",
 *     message="This identifier is already in use on that system."
 * )
 */
class Employee implements EntityInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;
    /**
     * @ORM\Column(
     *     type="uuid",
     *     unique=true
     *     )
     *  @ValidationAssert\Uuid(groups={"save"})
     * @Groups({"save","details","list"})
     */
    private UuidInterface $identifier;
    /**
     * @ORM\Column(
     *     type="string",
     *     length=255
     * )
     * @Groups({"save","details","list"})
     * @ValidationAssert\NotBlank(groups={"save"})
     */
    private string $firstName;
    /**
     * @ORM\Column(
     *     type="string",
     *     length=255
     * )
     * @Groups({"save","details","list"})
     * @ValidationAssert\NotBlank(groups={"save"})
     */
    private string $lastName;
    /**
     * @ORM\Column(
     *     type="string",
     *     length=255
     * )
     * @Groups({"save","details","list"})
     * @ValidationAssert\NotBlank(groups={"save"})
     * @ValidationAssert\Email(groups={"save"})
     */
    private string $email;
    /**
     * @ORM\ManyToMany(
     *     targetEntity="App\Entity\YouweTeam",
     *     inversedBy="employees",
     * )
     * @Groups({"details"})
     * @ValidationAssert\Valid(groups={"save"})
     */
    private Collection $youweTeams;

    public function __construct(string $identifier,?string $firstName = '', ?string $lastName='', ?string $email='')
    {
        Assert::uuid($identifier, 'Argument $identifier is not a valid UUID: %s');
        Assert::email($email);
        $this->identifier = Uuid::fromString($identifier);
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->youweTeams = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentifier(): string
    {
        return $this->identifier->toString();
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
    /**
     * @return ArrayCollection|YouweTeam[]
     */
    public function getYouweTeams(): Collection
    {
        return $this->youweTeams;
    }

    public function setYouweTeams(Collection $youweTeams)
    {
       foreach($youweTeams as $youweTeam)
       {
           $this->addToYouweTeam($youweTeam);
       }
        $this->youweTeams=$youweTeams;
    }

    public function addToYouweTeam(YouweTeam $youweTeam): self
    {
        if (!$this->youweTeams->contains($youweTeam)) {
            $this->youweTeams[] = $youweTeam;
            $youweTeam->addEmployee($this);
        }
        return $this;
    }

    public function removeFromYouweTeam(YouweTeam $youweTeam): self
    {
        if ($this->youweTeams->contains($youweTeam)) {
            $this->youweTeams->removeElement($youweTeam);
            $youweTeam->removeEmployee($this);
        }
        return $this;
    }

    public function toArray(): array
    {
        return [
            'identifier' => $this->identifier,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
        ];
    }
}
