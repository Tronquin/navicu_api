<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190531220154 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $this->addSql("
        update 	flight_reservation_gds 
        set 	subtotal = (increment_expenses * 100)/10
        where reservation_date < '2019-05-27:16:00:00'
            and currency_gds = 145 and currency_reservation = 151;");

            $this->addSql("
            update 	flight_reservation_gds 
            set 	subtotal_original = (subtotal_original * adult_number)  
            where reservation_date < '2019-05-27:16:00:00' and adult_number > 1;");

            $this->addSql("
            update 	flight_reservation_gds 
        set 	increment_guarantee = (increment_guarantee * adult_number)
        where reservation_date < '2019-05-27:16:00:00' and adult_number > 1;");
            
        $this->addSql("
        update 	flight_reservation_gds 
        set 	discount = (discount * adult_number)
        where reservation_date < '2019-05-27:16:00:00' and adult_number > 1;");

        $this->addSql("
        update 	flight_reservation_gds 
        set 	increment_expenses = (increment_expenses * adult_number)
        where reservation_date < '2019-05-27:16:00:00' and adult_number > 1;");

        $this->addSql("
        update 	flight_reservation_gds 
        set 	tax = (tax * adult_number)
        where reservation_date < '2019-05-27:16:00:00'  and adult_number > 1;");

        $this->addSql("
        update 	flight_reservation_gds 
        set 	subtotal = (subtotal * adult_number)
        where reservation_date < '2019-05-27:16:00:00' and adult_number > 1;");

        

       

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
