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

        $this->addSql("alter table location add language_id integer");
       $this->addSql("alter table location add currency_id integer");

       

       $this->addSql("DROP VIEW public.admin_flight_reservation_list_view");

       $this->addSql("
            CREATE OR REPLACE VIEW public.admin_flight_reservation_list_view AS
            SELECT fr.id,
            fr.type as type,
            fr.public_id AS localizador,
            fres.book_code,
            ( SELECT string_agg(DISTINCT gds.name::text, ','::text) AS string_agg
                   FROM gds
                  WHERE fres.gds_id = gds.id) AS gds,
               cur.alfa3 AS gds_currency,
                CASE
                    WHEN fres.reservation_date IS NOT NULL THEN fres.reservation_date
                    ELSE NULL::timestamp without time zone
                END AS creacion,
                fts.name AS tipo_de_vuelo,
            ( SELECT
                        CASE
                            WHEN max(fp.type) = 1 THEN 'TDC Instapago'::text
                            WHEN max(fp.type) = 2 THEN 'Transferencia Nacional'::text
                            WHEN max(fp.type) = 3 THEN 'TDC Stripe'::text
                            WHEN max(fp.type) = 4 THEN 'Transferencia Internacional'::text
                            WHEN max(fp.type) = 5 THEN 'AAVV'::text
                            WHEN max(fp.type) = 6 THEN 'TDC Payeezy'::text
                            WHEN max(fp.type) = 8 THEN 'PYP PayPal'::text
                            ELSE NULL::text
                        END AS \"case\"
                   FROM flight_payment fp
                  WHERE fres.id = fp.flight_reservation) AS mp,
            ct.simbol AS moneda,
            ct.alfa3,
            fres.status AS estado,
            (subtotal + tax) AS importe,
            
            ((setweight(to_tsvector(COALESCE(fr.public_id, ''::character varying)::text), 'A'::\"char\") || ''::tsvector) || setweight(to_tsvector(COALESCE(fres.book_code, ''::character varying)::text), 'A'::\"char\")) || ''::tsvector AS search_vector
           
            FROM flight_reservation_gds fres
             LEFT JOIN currency_type ct ON fres.currency_reservation = ct.id
             Left join flight_reservation fr on fr.id = fres.flight_reservation_id
             Left join currency_type cur on cur.id = fres.currency_gds
             left join flight_type_schedule fts on fts.id = fr.flight_type_schedule_id ");      


    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
