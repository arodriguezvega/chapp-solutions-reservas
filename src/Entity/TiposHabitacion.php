<?php

namespace App\Entity;

use App\Repository\TiposHabitacionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TiposHabitacionRepository::class)]
class TiposHabitacion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 25)]
    private $nombre;

    #[ORM\Column(type: 'integer')]
    private $capacidad;

    #[ORM\Column(type: 'float')]
    private $precio;

    #[ORM\OneToMany(mappedBy: 'tipo_habitacion', targetEntity: Habitaciones::class, orphanRemoval: true)]
    private $habitaciones_tipo;

    public function __construct()
    {
        $this->habitaciones_tipo = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getCapacidad(): ?int
    {
        return $this->capacidad;
    }

    public function setCapacidad(int $capacidad): self
    {
        $this->capacidad = $capacidad;

        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * @return Collection<int, Habitaciones>
     */
    public function getHabitacionesTipo(): Collection
    {
        return $this->habitaciones_tipo;
    }

    public function addHabitacionesTipo(Habitaciones $habitacionesTipo): self
    {
        if (!$this->habitaciones_tipo->contains($habitacionesTipo)) {
            $this->habitaciones_tipo[] = $habitacionesTipo;
            $habitacionesTipo->setTipoHabitacion($this);
        }

        return $this;
    }

    public function removeHabitacionesTipo(Habitaciones $habitacionesTipo): self
    {
        if ($this->habitaciones_tipo->removeElement($habitacionesTipo)) {
            // set the owning side to null (unless already changed)
            if ($habitacionesTipo->getTipoHabitacion() === $this) {
                $habitacionesTipo->setTipoHabitacion(null);
            }
        }

        return $this;
    }
}
