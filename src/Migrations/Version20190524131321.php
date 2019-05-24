<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190524131321 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $this->addSql("UPDATE currency_type SET Title = 'Bolívar' WHERE id = 151");

    }

    public function down(Schema $schema) : void
    {
        $this->addSql("UPDATE currency_type SET Title = 'Bolívar Soberano' WHERE id = 151");
        // this down() migration is auto-generated, please modify it to your needs

    }
}
