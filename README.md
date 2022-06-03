# chapp-solutions-reservas

El objetivo de la prueba es crear una aplicación web sencilla de creación de reservas.

![Image text](https://github.com/arodriguezvega/chapp-solutions-reservas/blob/main/Captura.JPG)

## Link de app web


## Tecnologías

● Symfony 5.4 (PHP 8.1.6)

● JQuery 3.6.0

● SQLite3 (La BD está en la raíz del proyecto 'CSreservas.db')

## Postulados

La pantalla principal será un listado de reservas. Una reserva consiste de:

● fecha entrada

● fecha salida

● tipo de habitación

● nº huéspedes

● datos de contacto (nombre, email, teléfono)

● precio total de la reserva

● localizador

● nº de habitación (opcional)

Habrá un botón para crear una reserva nueva. Este botón llevará a una pantalla que debe permitir introducir 2 fechas (entrada y salida), el número de huéspedes. Al buscar entre 2 fechas le mostrará como mínimo la siguiente información:

● Tipo de habitación

● Nº de habitaciones disponibles para este rango de fechas

● Precio total de la estancia

● Un botón para seleccionar esa habitación

Tras seleccionar la habitación deseada, le llevará a un formulario donde tendrá que introducir los datos de contacto para la reserva (nombre, email, teléfono). Al finalizar el formulario se creará la reserva (con un localizador alfanumérico único) y le llevará a la pantalla con el listado de reservas. Algunos detalles a tener en cuenta:

● Habrá 4 tipos de habitaciones: 10 individuales, 5 dobles, 4 triples, 6 cuádruples.

● El precio diario de cada tipo de habitación es: individual=20€/día, doble=30€/día, triple=40€/día, cuádruple=50€/día

● En una habitación individual solo cabe 1 persona (huésped). En una doble caben 1 o 2 personas. En una Triple caben 1, 2, o 3 personas. En una cuádruple caben 1, 2, 3 o 4 personas. Por lo tanto si el usuario hace una búsqueda para 3 personas, solo deberá mostrar habitaciones triples y cuádruples (siempre y cuando estén disponibles para esas fechas).

● A medida que se vayan creando reservas, debe descontarse del número de habitaciones disponibles de ese tipo para ese rango de fechas. Solo se podrán crear reservas desde la fecha actual hasta el 31/12/2022.
