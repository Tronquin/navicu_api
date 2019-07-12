<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190712144253 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE service_response ADD parameters TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE service_response DROP parameter');
        $this->addSql('COMMENT ON COLUMN service_response.parameters IS \'(DC2Type:array)\'');
       
        $this->addSql('ALTER TABLE service_request ALTER parameters TYPE TEXT');
        $this->addSql('ALTER TABLE service_request ALTER parameters DROP DEFAULT');
        $this->addSql('ALTER TABLE service_request ALTER request TYPE TEXT');
        $this->addSql('ALTER TABLE service_request ALTER request DROP DEFAULT');
       
       
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

     
        $this->addSql('ALTER TABLE service_response ADD parameter TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE service_response DROP parameters');

        $this->addSql('ALTER TABLE service_request ALTER parameters TYPE TEXT');
        $this->addSql('ALTER TABLE service_request ALTER parameters DROP DEFAULT');
        $this->addSql('ALTER TABLE service_request ALTER request TYPE JSON');
        $this->addSql('ALTER TABLE service_request ALTER request DROP DEFAULT');

     
    }
}
