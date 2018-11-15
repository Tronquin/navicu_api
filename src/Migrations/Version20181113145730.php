<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181113145730 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
       
    	// this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('create table public.flight_type_schedule (
							id integer NOT NULL,
							name character varying(255) COLLATE pg_catalog."default" NOT NULL,
							description text,
							CONSTRAINT flight_type_schedule_pkey PRIMARY KEY (id)

					 )');

		$this->addSql("insert into flight_type_schedule values (1, 'oneWay', 'oneWay')");
		$this->addSql("insert into flight_type_schedule values (2, 'roundTrip', 'roundTrip')");
		$this->addSql("alter table flight_reservation rename to flight_reservation_v1");

		$this->addSql('create table public.flight_class (
							id integer NOT NULL,
							name character varying(255) COLLATE pg_catalog."default" NOT NULL,
							description text,
							CONSTRAINT flight_class_pkey PRIMARY KEY (id)
					)
		');

		$this->addSql("insert into flight_class values (1, 'undefined', 'no registrado')");
		$this->addSql("insert into flight_class values (2, 'Economica', 'Economica')");

		$this->addSql("
		CREATE TABLE public.flight_reservation
		(
		    id serial,
		    reservation_date timestamp(0) without time zone NOT NULL,    
		    public_id character varying(255) NOT NULL,
		    flight_class_id integer,
		    currency_type_id integer,
		    flight_type_schedule_id integer,
		    child_number integer,
		    adult_number integer,
		    inf_number integer,
			ins_number integer,    
			subtotal_no_extra_increment double precision NOT NULL DEFAULT 0,
			subtotal double precision NOT NULL DEFAULT 0,	
			tax double precision NOT NULL DEFAULT 0,	
			increment_expenses double precision NOT NULL DEFAULT 0,
		    increment_guarantee double precision NOT NULL DEFAULT 0,	    
		    discount double precision NOT NULL DEFAULT 0,
		    total double precision,
			dollar_rate_covertion double precision,
		    currency_rate_covertion double precision,
		    dollar_rate_sell_covertion double precision,
		    currency_rate_sell_covertion double precision,	    
			confirmation_status integer,
		    confirmation_log text ,		
		    type character varying(255) DEFAULT 'WEB'::character varying,
		    ip_address character varying(16) DEFAULT NULL::character varying,
		    origin character varying(255)  DEFAULT NULL::character varying,
		    status integer,
			CONSTRAINT flight_reservation_v2_pkey PRIMARY KEY (id),
		    CONSTRAINT fk_f73df7ae6956883f_v2 FOREIGN KEY (currency_type_id)
		        REFERENCES public.currency_type (id) MATCH SIMPLE
		        ON UPDATE NO ACTION
		        ON DELETE NO ACTION,
		        CONSTRAINT fk_flight_reservation_nav_type_schedule FOREIGN KEY (flight_type_schedule_id )
		        REFERENCES public.flight_type_schedule(id) MATCH SIMPLE
		        ON UPDATE NO ACTION
		        ON DELETE NO ACTION,
			CONSTRAINT fk_flight_reservation_class FOREIGN KEY (flight_class_id)
		        REFERENCES public.flight_class (id) MATCH SIMPLE
		        ON UPDATE NO ACTION
		        ON DELETE NO ACTION)	"
		    );



			$this->addSql("insert into public.flight_reservation (
			id,	
			reservation_date,        
			    public_id ,
				flight_class_id,   
				currency_type_id ,
				flight_type_schedule_id,
			    child_number,
			    adult_number,	
				inf_number, 
				ins_number,    
				subtotal_no_extra_increment ,
				subtotal,
				tax ,
				increment_expenses ,
			    increment_guarantee,	    
			    discount,
			    total,
				dollar_rate_covertion ,
			    currency_rate_covertion ,
			    dollar_rate_sell_covertion ,
			    currency_rate_sell_covertion,	    
				confirmation_status,
			    confirmation_log,	
			    type,
			    ip_address,
			    origin,
			    status
			) 
			select fr.id, 
				fr.reservation_date,   
			    fr.public_id ,
			    1,
			    fr.currency,
			    1,
			    fr.child_number,
			    fr.adult_number ,
				0,
				0,    
			    sum(f.subtotal_no_extra_increment),
				sum(price),
				fr.tax ,
				sum(f.increment_expenses), sum(f.increment_guarantee), sum(f.discount) ,
				fr.total_to_pay,
				fr.dollar_rate_covertion ,
			    fr.currency_rate_covertion ,
			    fr.dollar_rate_sell_covertion ,
			    fr.currency_rate_sell_covertion,	    
				fr.confirmation_status,
			    fr.confirmation_log,	
			    fr.type,
			    fr.ip_address,
			    fr.origin,
			    fr.state

			from public.flight_reservation_v1 fr join public.flight f on f.flight_reservation = fr.id group by fr.id");


			
			$this->addSql("alter table passenger drop constraint fk_3befe8ddf73df7ae");
			$this->addSql("alter table flight_payment drop constraint fk_eec4679bf73df7ae");

			$this->addSql("alter table passenger add 
			CONSTRAINT fk_3befe8ddf73df7ae FOREIGN KEY (flight_reservation)
			        REFERENCES public.flight_reservation (id) MATCH SIMPLE
			        ON UPDATE NO ACTION
			        ON DELETE NO ACTION	");
					
			$this->addSql("alter table flight_payment add 
			CONSTRAINT fk_eec4679bf73df7ae FOREIGN KEY (flight_reservation)
			        REFERENCES public.flight_reservation (id) MATCH SIMPLE
			        ON UPDATE NO ACTION
			        ON DELETE NO ACTION	");

			$this->addSql('
			create table public.gds (
				id integer NOT NULL,
				name character varying(255) COLLATE pg_catalog."default" NOT NULL,
				description text,
				CONSTRAINT gds_pkey PRIMARY KEY (id)
			)');

			$this->addSql("insert into gds values (1, 'KIU', 'KIU')");
			$this->addSql("insert into gds values (2, 'AMA', 'AMADEUS')");

			$this->addSql("
			CREATE TABLE public.flight_reservation_gds
			(
			    id serial,
			    currency_type_id integer,
			    flight_reservation_id integer,
			    flight_type_schedule_id integer,
			    gds_id integer,
			    book_code character varying(12),
			    reservation_date timestamp(0) without time zone NOT NULL,    
			    child_number integer,
			    adult_number integer,
			    inf_number integer,
				ins_number integer,    
				subtotal double precision NOT NULL DEFAULT 0,
				tax double precision NOT NULL DEFAULT 0,
				total double precision NOT NULL DEFAULT 0,
				taxes character varying(255) ,
				increment_consolidator double precision NOT NULL DEFAULT 0,
				markup_increment_amount double precision,
				markup_increment_type character varying(255) DEFAULT NULL::character varying,
				markup_currency character varying(255) DEFAULT NULL::character varying,	
				airline_provider integer,
				airline_commision double precision,
				is_refundable boolean,
				status integer,
				CONSTRAINT flight_reservation_gds_pkey PRIMARY KEY (id),
			    CONSTRAINT fk_f73df7ae6956883f_currency FOREIGN KEY (currency_type_id)
			        REFERENCES public.currency_type (id) MATCH SIMPLE
			        ON UPDATE NO ACTION
			        ON DELETE NO ACTION,
				CONSTRAINT fk_flight_reservation_gds FOREIGN KEY (gds_id)
			        REFERENCES public.gds (id) MATCH SIMPLE
			        ON UPDATE NO ACTION
			        ON DELETE NO ACTION,
				CONSTRAINT fk_flight_reservation_type_schedule FOREIGN KEY (flight_type_schedule_id )
			        REFERENCES public.flight_type_schedule(id) MATCH SIMPLE
			        ON UPDATE NO ACTION
			        ON DELETE NO ACTION,
			        CONSTRAINT fk_flight_reservation_airline FOREIGN KEY (airline_provider)
			        REFERENCES public.airline(id) MATCH SIMPLE
			        ON UPDATE NO ACTION
			        ON DELETE NO ACTION,
				CONSTRAINT fk_gds_flight_reservation FOREIGN KEY (flight_reservation_id)
			        REFERENCES public.flight_reservation (id) MATCH SIMPLE
			        ON UPDATE NO ACTION
			        ON DELETE NO ACTION)");


				$this->addSql("
				insert into public.flight_reservation_gds (
				id,
				    currency_type_id,
				    flight_reservation_id,
				    flight_type_schedule_id,
				    gds_id,
				    book_code,
				    reservation_date,    
				    child_number,
				    adult_number,
				    inf_number,
					ins_number,    
					subtotal,
					tax,
					total,
					taxes,
					increment_consolidator,
					markup_increment_amount,
					markup_increment_type,
					markup_currency,	
					airline_provider,
					airline_commision,
					is_refundable,
					status
				) 
				select nextval('flight_reservation_gds_id_seq'), 
				fr.currency,
				fr.id, 
				1, 
				case
						WHEN max(f.provider) = 'AMA' then 2
						else 1
					end as prov,
					fr.code,

					fr.reservation_date, 
				    fr.child_number,
				    fr.adult_number , 0, 0,
					sum(f.original_price_no_tax), 
					sum(f.original_price)-sum(f.original_price_no_tax),
					sum(f.original_price),
				    max(f.gds_taxes),	
				    CASE
				            WHEN (max(f.provider)) = 'AMA' THEN 10
				            ELSE 0
				        END as consolidator_amount,
					sum(f.type_rate_increment) ,
				  max(f.type_rate_increment_type),
				  max(f.type_rate_increment_currency) ,
				  max(f.airline),
				  max(f.airline_commission),
					false,
					1
					
				from public.flight_reservation_v1 fr join public.flight f on f.flight_reservation = fr.id group by fr.id");
				

				$this->addSql("alter table flight drop CONSTRAINT fk_c257e60ef73df7ae");

				$this->addSql("update flight set flight_reservation =
				(select frg.id from flight_reservation_gds frg, flight_reservation fr where frg.flight_reservation_id=fr.id
				and flight.flight_reservation = fr.id)");


				$this->addSql("alter table flight add constraint fk_c257e60ef73df7ae
				FOREIGN KEY (flight_reservation)
				        REFERENCES public.flight_reservation_gds (id) MATCH SIMPLE
				        ON UPDATE NO ACTION
				        ON DELETE NO ACTION");
		

				$this->addSql("alter table flight_ticket drop CONSTRAINT fk_a8c6fcb4c257e60e");
				$this->addSql("alter table flight_ticket drop CONSTRAINT fk_a8c6fcb4f73df7ae");
				$this->addSql("alter table flight_ticket add passenger_id integer");
				$this->addSql("alter table flight_ticket add constraint fk_flight_ticket_passenger
				FOREIGN KEY (passenger_id)
				        REFERENCES public.passenger (id) MATCH SIMPLE
				        ON UPDATE NO ACTION
				        ON DELETE NO ACTION");

				$this->addSql("
				update flight_ticket set flight_reservation =
				(select frg.id from flight_reservation_gds frg, flight_reservation fr where frg.flight_reservation_id=fr.id
				and flight_ticket.flight_reservation = fr.id)");
						
				$this->addSql("		
				create table public.flight_seat_reservation (
					id serial,
					passenger_id integer not null,
					flight_id integer not null,
					seat character varying(15),
					description text, -- (DC2Type:json_array)
					CONSTRAINT flight_seat_reservation_pkey PRIMARY KEY (id)
				)");

				$this->addSql("		
				alter table flight_seat_reservation add constraint fk_passenger_seat_flight
				FOREIGN KEY (passenger_id)
				        REFERENCES public.passenger (id) MATCH SIMPLE
				        ON UPDATE NO ACTION
				        ON DELETE NO ACTION");
						
				$this->addSql("				
				alter table flight_seat_reservation add constraint fk_flight_seat_flight
				FOREIGN KEY (flight_id)
				        REFERENCES public.flight (id) MATCH SIMPLE
				        ON UPDATE NO ACTION
				        ON DELETE NO ACTION");	
						
				$this->addSql("alter table passenger add padre_id integer");


				$this->addSql("
				create table flight_fare_family (
					id serial NOT NULL,
					flight_reservation_gds_id integer,
					name character varying(255),
					description text,
					itinerary text,-- (DC2Type:json_array)
					services text,-- (DC2Type:json_array)
					search_options text, -- (DC2Type:json_array)
					prices text, -- (DC2Type:json_array)
					selected boolean,
					status integer,
					
					CONSTRAINT pk_flight_fare_family PRIMARY KEY (id)
				)");

				$this->addSql("
				alter table flight_fare_family add constraint fk_flight_fare_family_reservation
				FOREIGN KEY (flight_reservation_gds_id)
				        REFERENCES public.flight_reservation_gds (id) MATCH SIMPLE
				        ON UPDATE NO ACTION
				        ON DELETE NO ACTION");	


				$this->addSql("alter table flight drop increment_expenses");
				$this->addSql("alter table flight drop   increment_guarantee");
				$this->addSql("alter table flight drop   discount");
				$this->addSql("alter table flight drop original_price");
				$this->addSql("alter table flight drop original_currency cascade");
				$this->addSql("alter table flight drop   type_rate_increment");
				$this->addSql("alter table flight drop   type_rate_increment_type");
				$this->addSql("alter table flight drop  type_rate_increment_currency");
				$this->addSql("alter table flight drop   type_rate_percentage");
				$this->addSql("alter table flight drop roundtrip");
				$this->addSql("alter table flight drop airline_commission");
				$this->addSql("alter table flight drop original_price_no_tax");
				$this->addSql("alter table flight drop gds_taxes");
				$this->addSql("alter table flight drop   price_no_tax");
				$this->addSql("alter table flight drop  converted_price");
				$this->addSql("alter table flight drop  provider");
				$this->addSql("alter table flight drop is_refundable");
				$this->addSql("alter table flight drop technical_stop");
				$this->addSql("alter table flight drop increment_consolidator");
				$this->addSql("alter table flight drop  subtotal_no_extra_increment");
				$this->addSql("alter table flight drop  tax_total");


				$this->addSql("
				create table public.flight_type (
				id integer NOT NULL,
				name character varying(20),
				description text, -- (DC2Type:json_array)
				CONSTRAINT flight_type_pkey PRIMARY KEY (id)
				)");

				$this->addSql("alter table flight add flight_type_id integer");

				$this->addSql("
				insert into flight_type values (1,'directo','vuelo directo')");

				$this->addSql("
				update flight set flight_type_id = 1");

				$this->addSql("
				alter table flight add constraint fk_flight_flight_type
				FOREIGN KEY (flight_type_id)
				        REFERENCES public.flight_type (id) MATCH SIMPLE
				        ON UPDATE NO ACTION
				        ON DELETE NO ACTION");


				$this->addSql("drop table currency_type_temporal");
				$this->addSql("drop table daily_pack_history_reconvertion");
				$this->addSql("drop table dependency_location_temp");
				$this->addSql("drop table exchange_rate_history_temporal");
				$this->addSql("drop table temporal.denied_reservation_marzo2017");
				$this->addSql("drop table temporal.document_marzo2017");
				$this->addSql("drop table  temporal.payment_info_property_marzo2017");
				$this->addSql("drop table temporal.reservation_07042017");
				$this->addSql("drop table temporal.role_permissions");
				$this->addSql("drop table temporal.tempowner");
				$this->addSql("alter table location drop constraint fk_5e9e89cb8bac62af");
				$this->addSql("alter table location drop language_id");
				$this->addSql("alter table location drop constraint fk_5e9e89cb2b099f37");
				$this->addSql("alter table location drop currency_id");
				$this->addSql("alter table flight rename flight_reservation to flight_reservation_id");
				$this->addSql("alter table flight drop constraint fk_c257e60ef73df7ae");
	


    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}