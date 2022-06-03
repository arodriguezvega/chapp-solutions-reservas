<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220601232320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE habitaciones (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, tipo_habitacion_id INTEGER NOT NULL, numero INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_E10783BB0BA7A53 ON habitaciones (tipo_habitacion_id)');
        $this->addSql('CREATE TABLE reservas (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, fecha_entrada DATE NOT NULL, fecha_salida DATE NOT NULL, num_huespedes INTEGER NOT NULL, titular VARCHAR(100) NOT NULL, email VARCHAR(50) NOT NULL, telefono INTEGER NOT NULL, precio_total DOUBLE PRECISION NOT NULL, localizador VARCHAR(150) NOT NULL)');
        $this->addSql('CREATE TABLE reservas_habitaciones (reservas_id INTEGER NOT NULL, habitaciones_id INTEGER NOT NULL, PRIMARY KEY(reservas_id, habitaciones_id))');
        $this->addSql('CREATE INDEX IDX_5BA1C0D54976A656 ON reservas_habitaciones (reservas_id)');
        $this->addSql('CREATE INDEX IDX_5BA1C0D5B42E2CD5 ON reservas_habitaciones (habitaciones_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE habitaciones');
        $this->addSql('DROP TABLE reservas');
        $this->addSql('DROP TABLE reservas_habitaciones');
    }
}
