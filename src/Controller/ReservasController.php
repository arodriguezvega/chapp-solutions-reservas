<?php

namespace App\Controller;

use App\Entity\Reservas;
use App\Form\ReservasType;
use App\Repository\HabitacionesRepository;
use App\Repository\ReservasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Ulid;

class ReservasController extends AbstractController
{

    /**
     * Página Inicial - Pantalla
     *
     * @Route("/reservas", name="app_reservas")
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('reservas/index.html.twig', [
            'controller_name' => 'ReservasController',
        ]);
    }

    /**
     * Listado de Reservas - Pantalla
     *
     * @Route("/reservas/listado", name="reservas_listado")
     *
     * @param ReservasRepository $reservas_repo
     * @return Response
     */
    public function listado(ReservasRepository $reservas_repo) {
        $listado_res = $reservas_repo->findAll();

        return $this->render('reservas/listadoReservas.html.twig', [
            'listado_reservas' => $listado_res,
        ]);
    }

    /**
     * Despliega el formulario de Reservas para buscar y mostrar habitaciones disponibles.
     *
     * @Route("/reservas/disponibles", name="reservas_disponibles")
     *
     * @param Request $request
     * @param HabitacionesRepository $habitaciones_repo
     * @return Response
     */
    public function disponibles(Request $request, HabitacionesRepository $habitaciones_repo) {
        $reserva = new Reservas();
        $form    = $this->createForm(ReservasType::class, $reserva, array(
            'uso' => "disponibles"
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $params =  array(
                'fecha_entrada' => $form->get('fecha_entrada')->getData(),
                'fecha_salida'  => $form->get('fecha_salida')->getData(),
                'num_huespedes' => $form->get('num_huespedes')->getData()
            );
            $hab_disponibles = $habitaciones_repo->findDisponibles($params);
            $num_hab_disp    = count($hab_disponibles);
            $num_dias        = date_create($params['fecha_salida'])->diff(date_create($params['fecha_entrada']))->days;

            $info_habs = [];
            foreach($hab_disponibles as $key => $hab) {
                array_push($info_habs, [
                    'fecha_entrada' => $params['fecha_entrada'],
                    'fecha_salida'  => $params['fecha_salida'],
                    'num_huespedes' => $params['num_huespedes'],
                    'tipo_hab'      => $hab->getTipoHabitacion()->getNombre(),
                    'numero_hab'    => $hab->getNumero(),
                    'num_dias'      => $num_dias,
                    'precio_total'  => $num_dias * $hab->getTipoHabitacion()->getPrecio()
                ]);
            }

            return $this->render('reservas/habitacionesDisponibles.html.twig', [
                'info_habs'    => $info_habs,
                'num_hab_disp' => $num_hab_disp
            ]);
        }

        return $this->render('reservas/crearReserva.html.twig', [
            'formulario' => $form->createView(),
        ]);
    }

    /**
     * Despliega el formulario de Reservas para crear nuevas reservas y mostrarlas.
     *
     * @Route("/reservas/crear", name="reservas_crear")
     *
     * @param Request $request
     * @param ReservasRepository $reservas_repo
     * @param HabitacionesRepository $habitaciones_repo
     * @return Response
     */
    public function crear(Request $request, ReservasRepository $reservas_repo, HabitacionesRepository $habitaciones_repo) {
        $reserva = new Reservas();
        $habitacion = $request->query->get('hab');

        /* Busca el objeto Habitaciones para agregarlo a Reservas */
        $hab = $habitaciones_repo->findOneBy(['numero' => $habitacion['numero_hab']]);
        $reserva->addHabitacion($hab);

        $form = $this->createForm(ReservasType::class, $reserva, array(
            'uso'        => "formar",
            'fecha_entrada' => $habitacion['fecha_entrada'],
            'fecha_salida'  => $habitacion['fecha_salida'],
            'num_huespedes' => $habitacion['num_huespedes'],
            'precio_total'  => $habitacion['precio_total'],
            'habitacion'    => $hab
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $localizador = new Ulid(); // Genera un identificador universalmente único
            $reserva->setLocalizador($localizador->toBase32());
            $reservas_repo->add($reserva, true);
            return $this->redirectToRoute('reservas_listado');
        }

        return $this->render('reservas/crearReserva.html.twig', [
            'formulario' => $form->createView(),
        ]);
    }
}
