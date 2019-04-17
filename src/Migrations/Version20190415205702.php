<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190415205702 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE flight_search_register_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE flight_search_register (id INT NOT NULL, adults INT DEFAULT NULL, children INT DEFAULT NULL, baby INT DEFAULT NULL, country VARCHAR(255) NOT NULL, provider VARCHAR(255) NOT NULL, currency VARCHAR(255) NOT NULL, cabin VARCHAR(255) NOT NULL, scale INT NOT NULL, baggage INT NOT NULL, end_date DATE NOT NULL, search_type VARCHAR(255) NOT NULL, date DATE NOT NULL, user_currency VARCHAR(255) NOT NULL, source_search_type VARCHAR(255) NOT NULL, dest_search_type VARCHAR(255) NOT NULL, round_trip INT NOT NULL, itinerary JSON DEFAULT NULL, source VARCHAR(255) DEFAULT NULL, dest VARCHAR(255) DEFAULT NULL, star_date DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE flight_search_register ADD response JSON NOT NULL');
        $this->addSql("UPDATE nvc_bank
        SET routing_number = '063100277 / 026009593' , 
        billing_address = '10685 Hazelhurst Dr STE B, HOUSTON, TX 77043'
        WHERE id =4 or id = 5");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
        $this->addSql("UPDATE nvc_bank
        SET routing_number = '063000047' , 
        billing_address = 'NA 222 Broadway New York, New York 10038'
        WHERE id =4 or id = 5");
        $this->addSql('ALTER TABLE flight_search_register DROP response');
        $this->addSql('DROP SEQUENCE flight_search_register_id_seq CASCADE');
        $this->addSql('DROP TABLE flight_search_register');
    }
}
