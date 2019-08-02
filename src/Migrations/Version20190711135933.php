<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190711135933 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');


        $this->addSql('CREATE SEQUENCE service_response_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE service_request_id_seq INCREMENT BY 1 MINVALUE 1 START 1');    
        $this->addSql('CREATE TABLE service_response (id INT NOT NULL, service_request_id INT NOT NULL, namespace VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, parameter TEXT DEFAULT NULL, create_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, update_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, type VARCHAR(40) DEFAULT NULL, response JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE service_request (id INT NOT NULL, namespace VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, parameters TEXT DEFAULT NULL, create_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, update_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, request JSON NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE service_response_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE service_request_id_seq CASCADE');
        $this->addSql('DROP TABLE service_response');
        $this->addSql('DROP TABLE service_request');
        
    }
}
