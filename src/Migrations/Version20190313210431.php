<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190313210431 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("insert into bank_type values ('DE66', 'Handelsbank', 2)");

        $this->addSql("update bank_type set id= '8980' where title='Bank of America'"); 
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("delete from bank_type where id = 'DE66'"); 
        $this->addSql("update bank_type set id = 'E012' where title='Bank of America'"); 

    }
}
