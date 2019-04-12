<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190214175446 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('alter table fos_user alter salt drop not null');
        $this->addSql('ALTER TABLE flight_reservation ADD client_profile_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE flight_reservation ADD CONSTRAINT FK_F73DF7AE5CAE2FF9 FOREIGN KEY (client_profile_id) REFERENCES cliente_profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql('alter table fos_user alter salt set not null');
        $this->addSql('ALTER TABLE flight_reservation drop client_profile_id');
        $this->addSql('ALTER TABLE flight_reservation DROP CONSTRAINT FK_F73DF7AE5CAE2FF9');
    }
}
