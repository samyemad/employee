<?php

namespace App\Entity;

use App\Repository\YouweTeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\Interfaces\EntityInterface;
/**
 * @ORM\Entity(repositoryClass=YouweTeamRepository::class)
 */
class YouweTeam implements EntityInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(
     *     type="uuid",
     *     unique=true
     *     )
     * @Groups({"details","list"})
     */
    private UuidInterface $identifier;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=255
     * )
     * @Groups({"details","list"})
     */
    private string $teamName;

    /**
     * @ORM\Column(
     *     type="datetime_immutable",
     *     length=255
     * )
     * @Groups({"details","list"})
     */
    private \DateTimeImmutable $establishedDate;

    /**
     * @ORM\ManyToMany(
     *     targetEntity="App\Entity\Employee",
     *     inversedBy="youweTeams"
     * )
     * @Groups({"details"})
     */
    private Collection $employees;

    public function __construct(string $identifier, string $teamName, \DateTimeImmutable $establishedDate)
    {
        Assert::uuid($identifier, 'Argument $identifier is not a valid UUID: %s');
        $this->identifier = Uuid::fromString($identifier);
        $this->teamName = $teamName;
        $this->establishedDate = $establishedDate;
        $this->employees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentifier(): string
    {
        return $this->identifier->toString();
    }

    public function getTeamName(): string
    {
        return $this->teamName;
    }

    public function getEstablishedDate(): \DateTimeImmutable
    {
        return $this->establishedDate;
    }

    /**
     * @return Employee[]
     */
    public function getEmployees(): Collection
    {
        return $this->employees;
    }

    public function addEmployee(Employee $employee): self
    {
        if (!$this->employees->contains($employee))
        {
            $this->employees->add($employee);
            $employee->addToYouweTeam($this);
        }
        return $this;
    }

    public function removeEmployee(Employee $employee): self
    {
        if ($this->employees->contains($employee)) {
            $this->employees->removeElement($employee);
            $employee->removeFromYouweTeam($this);
        }

        return $this;
    }

    public function toArray(): array
    {
        return [
            'identifier' => $this->identifier,
            'team_name' => $this->getTeamName(),
            'established_date' => $this->getEstablishedDate()->format('Y-m-d'),
            'employees' => array_map(function (Employee $employee): array {
                return $employee->toArray();
            }, $this->getEmployees()),
        ];
    }
}
