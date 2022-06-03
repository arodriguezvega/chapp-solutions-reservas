<?php

namespace App\Entity;

use App\Repository\HabitacionesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HabitacionesRepository::class)]
class Habitaciones
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: TiposHabitacion::class, inversedBy: 'habitaciones_tipo')]
    #[ORM\JoinColumn(nullable: false)]
    private $tipo_habitacion;

    #[ORM\Column(type: 'integer')]
    private $numero;

    #[ORM\ManyToMany(targetEntity: Reservas::class, mappedBy: 'habitacion')]
    private $reservas_habitacion;

    public function __construct()
    {
        $this->reservas_habitacion = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipoHabitacion(): ?TiposHabitacion
    {
        return $this->tipo_habitacion;
    }

    public function setTipoHabitacion(?TiposHabitacion $tipo_habitacion): self
    {
        $this->tipo_habitacion = $tipo_habitacion;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * @return Collection<int, Reservas>
     */
    public function getReservasHabitacion(): Collection
    {
        return $this->reservas_habitacion;
    }

    public function addReservasHabitacion(Reservas $reservasHabitacion): self
    {
        if (!$this->reservas_habitacion->contains($reservasHabitacion)) {
            $this->reservas_habitacion[] = $reservasHabitacion;
            $reservasHabitacion->addHabitacion($this);
        }

        return $this;
    }

    public function removeReservasHabitacion(Reservas $reservasHabitacion): self
    {
        if ($this->reservas_habitacion->removeElement($reservasHabitacion)) {
            $reservasHabitacion->removeHabitacion($this);
        }

        return $this;
    }
}
