<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190117134922 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
     /*  

     $this->addSql("CREATE TABLE public.rule_room
					(
					    id SERIAL,
					    title varchar(255)DEFAULT NULL::character varying,
					    status integer
					)");

	$this->addSql("alter table public.rule_room add constraint pk_rule_room PRIMARY KEY (id)");

	$this->addSql("create table public.property_rule_room
					(
					  id SERIAL,
					  property_id integer,
					  rule_room_id integer,
					  CONSTRAINT property_rule_room_pkey PRIMARY KEY (id),
					    CONSTRAINT fk_property_rule_room_room FOREIGN KEY (rule_room_id)
					      REFERENCES public.rule_room (id) MATCH SIMPLE
					      ON UPDATE NO ACTION ON DELETE NO ACTION,   
					    CONSTRAINT fk_property_rule_room_property FOREIGN KEY (property_id)
					      REFERENCES public.property (id) MATCH SIMPLE
					      ON UPDATE NO ACTION ON DELETE NO ACTION     
					)");

	$this->addSql("CREATE TABLE public.tag
					(
					    id SERIAL    ,
					    title varchar(255)DEFAULT NULL::character varying,
					    description varchar(255)DEFAULT NULL::character varying,
					    route varchar(255)DEFAULT NULL::character varying,
					  status integer,
					    CONSTRAINT tag_pkey PRIMARY KEY (id)
					)");


	$this->addSql("CREATE TABLE public.channel
					(
					    id SERIAL,
					    name varchar(255)DEFAULT NULL::character varying,
					    description varchar(255)DEFAULT NULL::character varying,
					    status integer,
					    CONSTRAINT section_category_pkey PRIMARY KEY (id)
					)");

	$this->addSql("CREATE TABLE public.upselling
					(
					    id SERIAL,
					    property_id integer,
					    title varchar(255)DEFAULT NULL::character varying,
					    slug varchar(255)DEFAULT NULL::character varying,
					    description text ,
					    min integer,
					    max integer,  
					  	number integer,
					    type integer,
					    img_route varchar(255)DEFAULT NULL::character varying,
					    accumulated boolean,
					    prominent boolean,
					    status integer,
					    CONSTRAINT upselling_pkey PRIMARY KEY (id),
					    CONSTRAINT fk_upselling_property FOREIGN KEY (property_id)
					      REFERENCES public.property (id) MATCH SIMPLE
					      ON UPDATE NO ACTION ON DELETE NO ACTION
					)");

	$this->addSql("CREATE TABLE public.upselling_tag (
	    id SERIAL,
	    upselling_id integer,
	    tag_id integer,
	    CONSTRAINT upselling_tag_pkey PRIMARY KEY (id),
	    CONSTRAINT fk_upsellingtag_upselling FOREIGN KEY (upselling_id)
	      REFERENCES public.upselling (id) MATCH SIMPLE
	      ON UPDATE NO ACTION ON DELETE NO ACTION,   
	    CONSTRAINT fk_upsellingtag_tag FOREIGN KEY (tag_id)
	      REFERENCES public.tag (id) MATCH SIMPLE
	      ON UPDATE NO ACTION ON DELETE NO ACTION     
	)");

	$this->addSql("CREATE TABLE public.upselling_channel (
	    id SERIAL,
	    upselling_id integer,
	    channel_id integer,
	    CONSTRAINT upselling_section_pkey PRIMARY KEY (id),
	    CONSTRAINT fk_upsellingcategory_upselling FOREIGN KEY (upselling_id)
	      REFERENCES public.upselling (id) MATCH SIMPLE
	      ON UPDATE NO ACTION ON DELETE NO ACTION,   
	    CONSTRAINT fk_upselling_channel FOREIGN KEY (channel_id)
	      REFERENCES public.channel (id) MATCH SIMPLE
	      ON UPDATE NO ACTION ON DELETE NO ACTION     
	)");


	$this->addSql("CREATE TABLE public.daily_upselling
	(
	    id SERIAL,
	    date date,
	    number integer,
	    CONSTRAINT daily_upselling_pkey PRIMARY KEY (id) 
	)");


	$this->addSql("CREATE TABLE public.daily_price_upselling (
	    id SERIAL,
	    daily_upselling_id integer,
	    price float,
	    currency_type_id integer,
	  CONSTRAINT daily_price_upselling_pkey PRIMARY KEY (id),
	  CONSTRAINT fk_dailypriceupselling_currency FOREIGN KEY (currency_type_id)
	      REFERENCES public.currency_type (id) MATCH SIMPLE
	      ON UPDATE NO ACTION ON DELETE NO ACTION
	)");  


	$this->addSql("CREATE TABLE public.special_pack (
	    id SERIAL,
	    property_id integer,
	    title varchar(255)DEFAULT NULL::character varying,
	    slug varchar(255)DEFAULT NULL::character varying,
	    banner_route varchar(255)DEFAULT NULL::character varying,
	    description text,
	    min_night integer,
	    max_night integer,
	    valid_days text,
	    percentage float,
	    status integer , 
	  CONSTRAINT special_pack_pkey PRIMARY KEY (id),
	  CONSTRAINT fk_specialpack_property FOREIGN KEY (property_id)
	      REFERENCES public.property (id) MATCH SIMPLE
	      ON UPDATE NO ACTION ON DELETE NO ACTION
	)");


	$this->addSql("CREATE TABLE public.upselling_special_pack(
	      id SERIAL,
	    special_pack_id integer,
	    upselling_id integer,
	    number integer,
	    mandatory boolean,
	    percentage float,
	  CONSTRAINT upselling_pack_pkey PRIMARY KEY (id),
	  CONSTRAINT fk_upsellingpack_specialpack FOREIGN KEY (special_pack_id)
	      REFERENCES public.special_pack (id) MATCH SIMPLE
	      ON UPDATE NO ACTION ON DELETE NO ACTION,
	  CONSTRAINT fk_upsellingpack_upselling FOREIGN KEY (upselling_id)
	      REFERENCES public.upselling (id) MATCH SIMPLE
	      ON UPDATE NO ACTION ON DELETE NO ACTION
	)");


	$this->addSql("CREATE TABLE public.room_special_pack(
	      id SERIAL,
	    special_pack_id integer,
	    room_id integer,
	  CONSTRAINT room_pack_pkey PRIMARY KEY (id),
	  CONSTRAINT fk_roompack_specialpack FOREIGN KEY (special_pack_id)
	      REFERENCES public.special_pack (id) MATCH SIMPLE
	      ON UPDATE NO ACTION ON DELETE NO ACTION,
	  CONSTRAINT fk_roompack_room FOREIGN KEY (room_id)
	      REFERENCES public.room (id) MATCH SIMPLE
	      ON UPDATE NO ACTION ON DELETE NO ACTION
	)");


	$this->addSql("CREATE TABLE public.special_pack_flight(
	     id SERIAL,
	     special_pack_id integer,
	     origin integer,
	     destiny integer,
	     airline_id integer,
	     class char(1),
	  CONSTRAINT route_flight PRIMARY KEY (id),
	  CONSTRAINT fk_6b1c6697522fbar FOREIGN KEY (special_pack_id)
	      REFERENCES public.special_pack (id) MATCH SIMPLE
	      ON UPDATE NO ACTION ON DELETE NO ACTION,
	  CONSTRAINT fk_6b1c6697522fbab FOREIGN KEY (destiny)
	      REFERENCES public.airport (id) MATCH SIMPLE
	      ON UPDATE NO ACTION ON DELETE NO ACTION,
	  CONSTRAINT fk_6b1c669def1561e FOREIGN KEY (origin)
	      REFERENCES public.airport (id) MATCH SIMPLE
	    ON UPDATE NO ACTION ON DELETE NO ACTION,
	  CONSTRAINT fk_special_pack_flight_airline FOREIGN KEY (airline_id)
	      REFERENCES public.airline(id) MATCH SIMPLE
	    ON UPDATE NO ACTION ON DELETE NO ACTION
	)");

	$this->addSql("alter table reservation add special_pack_id integer");
	$this->addSql("alter table reservation add CONSTRAINT fk_reservation_special_pack FOREIGN KEY (special_pack_id)
      REFERENCES public.special_pack (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION");

	$this->addSql("alter table flight_reservation add special_pack_id integer");
	$this->addSql("alter table flight_reservation add CONSTRAINT fk_flight_reservation_special_pack FOREIGN KEY (special_pack_id)
	      REFERENCES public.special_pack (id) MATCH SIMPLE
	      ON UPDATE NO ACTION ON DELETE NO ACTION");
   
    
    
	$this->addSql("CREATE TABLE public.type_offer(
	  id SERIAL,
	  name varchar(255)DEFAULT NULL::character varying,
	  status integer,
	  CONSTRAINT pk_type_offer PRIMARY KEY (id) 
	)");    
    
	$this->addSql("CREATE TABLE public.special_offer(
	      id SERIAL,    
	    type_offer_id integer,
	    slug  varchar(255)DEFAULT NULL::character varying,
	    percentaje float,
	    promotional_code varchar(255)DEFAULT NULL::character varying,
	    min_nights integer,
	    max_nights integer,
	    free_nights integer,
	    ini_date date,
	    end_date date,
	    banner_route  varchar(255)DEFAULT NULL::character varying,
	    description text,
	    valid_days text ,
	    status integer,
	  CONSTRAINT upselling_special_offer PRIMARY KEY (id),
	  CONSTRAINT fk_special_offer_type FOREIGN KEY (type_offer_id)
	      REFERENCES public.type_offer (id) MATCH SIMPLE
	      ON UPDATE NO ACTION ON DELETE NO ACTION
	)");


	$this->addSql("CREATE TABLE public.special_offer_room(
	  id SERIAL,
	  room_id integer,
	  status integer,
	  CONSTRAINT pk_upselling_special_offer PRIMARY KEY (id),
	  CONSTRAINT fk_special_offer_room_room FOREIGN KEY (room_id)
	      REFERENCES public.room (id) MATCH SIMPLE
	      ON UPDATE NO ACTION ON DELETE NO ACTION   
	)");    

	$this->addSql("insert into rule_room values (1, 'breakfast')");
	$this->addSql("insert into rule_room values (2, 'media')");
	$this->addSql("insert into rule_room values (3, 'complete')");

	$this->addSql("alter table daily_pack drop constraint fk_d3d841b61919b217");
	$this->addSql("drop view admin_property_without_availability_view");

	$this->addSql("alter table daily_pack add rule_room_id integer");
	$this->addSql("alter table daily_pack add daily_room_id integer");

//-- migration de packs

	$this->addSql("alter table daily_pack drop pack_id");
	$this->addSql("update daily_pack set rule_room_id = 1");

	$this->addSql("alter table daily_pack add CONSTRAINT fk_d3d841b61919b217 FOREIGN KEY (rule_room_id)
	        REFERENCES public.rule_room (id) MATCH SIMPLE
	        ON UPDATE NO ACTION
	        ON DELETE NO ACTION");
	      
	$this->addSql("alter table daily_pack add CONSTRAINT fk_d3d841b61919b218 FOREIGN KEY (daily_room_id)
	        REFERENCES public.daily_room (id) MATCH SIMPLE
	        ON UPDATE NO ACTION
	        ON DELETE NO ACTION");      

	$this->addSql("alter table reservation_pack add room_id integer");
	$this->addSql("alter table reservation_pack add rule_room_id integer");    
	$this->addSql("update reservation_pack set room_id = (select room_id from pack where id = reservation_pack.pack_id)");
	  
	$this->addSql("alter table reservation_pack drop pack_id");
	$this->addSql("alter table reservation_pack add special_offer_id integer");

	$this->addSql("alter table reservation_pack add CONSTRAINT fk_reservation_pack_room FOREIGN KEY (room_id)
	      REFERENCES public.room (id) MATCH SIMPLE
	      ON UPDATE NO ACTION ON DELETE NO ACTION");  
	  
	$this->addSql("alter table reservation_pack add CONSTRAINT fk_reservation_pack_rule_room FOREIGN KEY (rule_room_id)
	      REFERENCES public.rule_room (id) MATCH SIMPLE
	      ON UPDATE NO ACTION ON DELETE NO ACTION");  
	  
	$this->addSql("alter table reservation_pack add CONSTRAINT fk_reservation_pack_rule_special_offer FOREIGN KEY (special_offer_id)
	      REFERENCES public.special_offer (id) MATCH SIMPLE
	      ON UPDATE NO ACTION ON DELETE NO ACTION");  
   

   */

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
