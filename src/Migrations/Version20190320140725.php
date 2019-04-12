<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190320140725 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $tags = file_get_contents('src/Migrations/airport_tags.json');
        $jsonTags = json_decode($tags, true);

        $this->addSql('ALTER TABLE airport ADD tags VARCHAR(255)');

        foreach ($jsonTags as $airports => $airport) {
            $this->addSql("UPDATE airport SET tags = ? WHERE iata = ? AND agency_type = 'airport'", [$airport['tags'],$airport['iata']]);
        }

        $this->addSql("DROP VIEW public.web_fligths_autocompleted_view");

        $this->addSql("CREATE OR REPLACE VIEW public.web_fligths_autocompleted_view AS
             SELECT a.id,
                a.iata,
                a.name,
                a.visible,
                l.title AS location_name,
                l.alfa3 AS location_code,
                a.city_name,
                a.tags,
                    CASE
                        WHEN rl.id IS NULL THEN l.title
                        ELSE rl.title
                    END AS country_name,
                    CASE
                        WHEN rl.id IS NULL THEN l.alfa2
                        ELSE rl.alfa2
                    END AS country_code,
                (((((((((setweight(to_tsvector(COALESCE(a.name, ''::character varying)::text), 'A'::\"char\") || ''::tsvector) || (setweight(to_tsvector(COALESCE(a.iata, ''::character varying)::text), 'A'::\"char\") || (setweight(to_tsvector(COALESCE(a.city_name, ''::character varying)::text), 'A'::\"char\")) || ''::tsvector)) || (setweight(to_tsvector(COALESCE(l.title, ''::character varying)::text), 'A'::\"char\") || ''::tsvector)) || (setweight(to_tsvector(COALESCE(l.alfa3, ''::character varying)::text), 'A'::\"char\") || ''::tsvector)) || (setweight(to_tsvector(COALESCE(pl.title, ''::character varying)::text), 'A'::\"char\") || ''::tsvector)) || (setweight(to_tsvector(COALESCE(pl.alfa3, ''::character varying)::text), 'A'::\"char\") || ''::tsvector)) || (setweight(to_tsvector(COALESCE(cl.title, ''::character varying)::text), 'A'::\"char\") || ''::tsvector)) || (setweight(to_tsvector(COALESCE(cl.alfa3, ''::character varying)::text), 'A'::\"char\") || ''::tsvector)) || (setweight(to_tsvector(COALESCE(rl.title, ''::character varying)::text), 'A'::\"char\") || ''::tsvector)) || (setweight(to_tsvector(COALESCE(rl.alfa3, ''::character varying)::text), 'A'::\"char\") || ''::tsvector) AS vector
               FROM airport a
                 LEFT JOIN location l ON a.location_id = l.id
                 LEFT JOIN location pl ON l.parent_id = pl.id
                 LEFT JOIN location cl ON l.city_id = cl.id
                 LEFT JOIN location rl ON l.root_id = rl.id
              WHERE a.agency_type = 'airport'
              ORDER BY (
        CASE
            WHEN rl.id IS NULL THEN l.alfa2
            ELSE rl.alfa2
        END);");

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE airport DROP tags');

        $this->addSql("DROP VIEW public.web_fligths_autocompleted_view");

        $this->addSql("CREATE OR REPLACE VIEW public.web_fligths_autocompleted_view AS
             SELECT a.id,
                a.iata,
                a.name,
                a.visible,
                l.title AS location_name,
                l.alfa3 AS location_code,
                a.city_name,
                    CASE
                        WHEN rl.id IS NULL THEN l.title
                        ELSE rl.title
                    END AS country_name,
                    CASE
                        WHEN rl.id IS NULL THEN l.alfa2
                        ELSE rl.alfa2
                    END AS country_code,
                (((((((((setweight(to_tsvector(COALESCE(a.name, ''::character varying)::text), 'A'::\"char\") || ''::tsvector) || (setweight(to_tsvector(COALESCE(a.iata, ''::character varying)::text), 'A'::\"char\") || (setweight(to_tsvector(COALESCE(a.city_name, ''::character varying)::text), 'A'::\"char\")) || ''::tsvector)) || (setweight(to_tsvector(COALESCE(l.title, ''::character varying)::text), 'A'::\"char\") || ''::tsvector)) || (setweight(to_tsvector(COALESCE(l.alfa3, ''::character varying)::text), 'A'::\"char\") || ''::tsvector)) || (setweight(to_tsvector(COALESCE(pl.title, ''::character varying)::text), 'A'::\"char\") || ''::tsvector)) || (setweight(to_tsvector(COALESCE(pl.alfa3, ''::character varying)::text), 'A'::\"char\") || ''::tsvector)) || (setweight(to_tsvector(COALESCE(cl.title, ''::character varying)::text), 'A'::\"char\") || ''::tsvector)) || (setweight(to_tsvector(COALESCE(cl.alfa3, ''::character varying)::text), 'A'::\"char\") || ''::tsvector)) || (setweight(to_tsvector(COALESCE(rl.title, ''::character varying)::text), 'A'::\"char\") || ''::tsvector)) || (setweight(to_tsvector(COALESCE(rl.alfa3, ''::character varying)::text), 'A'::\"char\") || ''::tsvector) AS vector
               FROM airport a
                 LEFT JOIN location l ON a.location_id = l.id
                 LEFT JOIN location pl ON l.parent_id = pl.id
                 LEFT JOIN location cl ON l.city_id = cl.id
                 LEFT JOIN location rl ON l.root_id = rl.id
              ORDER BY (
        CASE
            WHEN rl.id IS NULL THEN l.alfa2
            ELSE rl.alfa2
        END);");

    }
}
