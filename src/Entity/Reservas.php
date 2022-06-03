<?php

namespace App\Entity;

use App\Repository\ReservasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

#[ORM\Entity(repositoryClass: ReservasRepository::class)]
class Reservas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 10)]
    private $fecha_entrada;

    #[ORM\Column(type: 'string', length: 10)]
    private $fecha_salida;

    #[ORM\ManyToMany(targetEntity: Habitaciones::class, inversedBy: 'reservas_habitacion')]
    private $habitacion;

    #[ORM\Column(type: 'integer')]
    private $num_huespedes;

    #[ORM\Column(type: 'string', length: 100)]
    private $titular;

    #[ORM\Column(type: 'string', length: 50)]
    private $email;

    #[ORM\Column(type: 'integer')]
    private $telefono;

    #[ORM\Column(type: 'float')]
    private $precio_total;

    #[ORM\Column(type: 'string', length: 150)]
    private $localizador;

    public function __construct()
    {
        $this->habitacion = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaEntrada(): ?string
    {
        return $this->fecha_entrada;
    }

    public function setFechaEntrada(string $fecha_entrada): self
    {
        $this->fecha_entrada = $fecha_entrada;

        return $this;
    }

    public function getFechaSalida(): ?string
    {
        return $this->fecha_salida;
    }

    public function setFechaSalida(string $fecha_salida): self
    {
        $this->fecha_salida = $fecha_salida;

        return $this;
    }

    /**
     * @return Collection<int, Habitaciones>
     */
    public function getHabitacion(): Collection
    {
        return $this->habitacion;
    }

    public function addHabitacion(Habitaciones $habitacion): self
    {
        if (!$this->habitacion->contains($habitacion)) {
            $this->habitacion[] = $habitacion;
        }

        return $this;
    }

    public function removeHabitacion(Habitaciones $habitacion): self
    {
        $this->habitacion->removeElement($habitacion);

        return $this;
    }

    public function getNumHuespedes(): ?int
    {
        return $this->num_huespedes;
    }

    public function setNumHuespedes(int $num_huespedes): self
    {
        $this->num_huespedes = $num_huespedes;

        return $this;
    }

    public function getTitular(): ?string
    {
        return $this->titular;
    }

    public function setTitular(string $titular): self
    {
        $this->titular = $titular;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelefono(): ?int
    {
        return $this->telefono;
    }

    public function setTelefono(int $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getPrecioTotal(): ?float
    {
        return $this->precio_total;
    }

    public function setPrecioTotal(float $precio_total): self
    {
        $this->precio_total = $precio_total;

        return $this;
    }

    public function getLocalizador(): ?string
    {
        return $this->localizador;
    }

    public function setLocalizador(string $localizador): self
    {
        $this->localizador = $localizador;

        return $this;
    }
}
