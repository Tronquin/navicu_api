<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190117180738 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
    	$this->addSql("update airport set city_name='NEW YORK', location_id=1325 where iata='JRB'or iata='NYC' or iata='JRE'"); 
		$this->addSql("update airport set city_name='WASHINGTON', location_id=1325 where iata='WTC' or iata='WAS' or iata='OCW'"); 
		$this->addSql("update airport set city_name='LONDON', location_id=1174 where iata='LCY'or iata='BQH'");
		$this->addSql("update airport set city_name='MADRID', location_id=1165 where iata='XOC'or iata='XTI'");	
		$this->addSql("update airport set visible=true");
		$this->addSql("update airport set visible=false where location_id=1200 or lower(city_name) like '%israel%'");


    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
