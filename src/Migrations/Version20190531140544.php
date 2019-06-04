<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190531140544 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $this->addSql(" 
            update 	flight_reservation_gds 
            set 	subtotal_original = subtotal_original + tax_original 
            where 	reservation_date < '2019-05-27 16:00:00';
        ");

        $this->addSql("
            update 	flight_reservation_gds 
            set 	subtotal = (subtotal_original * dollar_rate_convertion) * 1.05 
            where 	currency_gds = 145 and subtotal_original is not null and dollar_rate_convertion is not null
                and reservation_date < '2019-05-27 16:00:00';

        ");

        $this->addSql("
            update 	flight_reservation_gds
            set 	subtotal = (subtotal_original) * 1.30 
            where 	currency_gds = 151
                and reservation_date < '2019-05-27 16:00:00';
        ");

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
