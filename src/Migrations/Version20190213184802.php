<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190213184802 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE package_temp_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE package_temp (id INT NOT NULL, content TEXT NOT NULL, availability INT NOT NULL, PRIMARY KEY(id))');

        $packages = json_decode(
            '[{"title":"MARGARITA","subtitle":"Sunsol Isla Caribe","room":{"time":"5 días y 4 noches","type":"Habitación Doble + Todo incluido","details":[]},"flight":{"type":"Round trip","departure":"Salida desde Valencia"},"symbol":"$","price":420.35,"image":"/assets/images/sunsol.jpg","width":50,"footer":null,"allowDates":{"duration":5,"start":"2019-03-01","end":"2019-03-26"},"haveFlight":true},{"title":"MARGARITA","subtitle":"Yaque Paradise","room":{"time":"5 días y 4 noches","type":"Habitación Doble","details":["Desayuno incluido","1 toldo","2 sillas de playa"]},"flight":{"type":"Round trip","departure":"Salida desde Valencia"},"symbol":"$","price":353.66,"image":"/assets/images/yaque-paradise.jpg","width":50,"footer":null,"allowDates":{"duration":5,"start":"2019-03-01","end":"2019-03-01"},"haveFlight":true},{"title":"CHORONÍ","subtitle":"Posada El Ensueño","room":{"time":"5 días y 4 noches","type":"Habitación Doble","details":["Desayuno","Coffee Break","Cena"]},"flight":{"type":null,"departure":null},"symbol":"$","price":200,"image":"/assets/images/el-ensueno.jpg","width":50,"footer":null,"allowDates":{"duration":5,"start":"2019-03-01","end":"2019-03-26"},"haveFlight":false},{"title":"MÉRIDA","subtitle":"Hotel Convencion Boutique","room":{"time":"3 días y 2 noches","type":"Habitación Suite","details":["Desayuno incluido","Uso del sauna","Detalle en la habitación"]},"flight":{"type":null,"departure":null},"symbol":"$","price":80,"image":"/assets/images/convencion.jpg","width":50,"footer":null,"allowDates":{"duration":3,"start":"2019-03-01","end":"2019-03-03"},"haveFlight":false},{"title":"COLONIA TOVAR","subtitle":"Hotel Bergland","room":{"time":null,"type":null,"details":[]},"flight":{"type":null,"departure":null},"symbol":"$","price":18.75,"image":"/assets/images/bergland.jpg","width":100,"footer":{"text":"(precio por noche)","subtext":"Habitación Doble"},"allowDates":{"duration":1,"start":"2019-03-01","end":"2019-03-30"},"haveFlight":false}]',
            true
        );

        foreach ($packages as $package) {
            $json = json_encode($package);

            if ($package['price'] === 420.35) {
                $availability = 3;
            } elseif ($package['price'] === 353.66) {
                $availability = 1;
            } elseif ($package['price'] === 200) {
                $availability = 2;
            } elseif ($package['price'] === 80) {
                $availability = 5;
            } elseif ($package['price'] === 18.75) {
                $availability = 1;
            }


            $this->addSql("INSERT INTO package_temp VALUES (nextval('package_temp_id_seq'), :content, :availability)", [
                'content' => $json,
                'availability' => $availability
            ]);
        }

        $this->addSql('CREATE SEQUENCE package_temp_payment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE package_temp_payment (id INT NOT NULL, package_temp_id INT NOT NULL, content TEXT NOT NULL, status INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_71FEAFE5E5F8CAA3 ON package_temp_payment (package_temp_id)');
        $this->addSql('ALTER TABLE package_temp_payment ADD CONSTRAINT FK_71FEAFE5E5F8CAA3 FOREIGN KEY (package_temp_id) REFERENCES package_temp (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE package_temp_payment_id_seq CASCADE');
        $this->addSql('DROP TABLE package_temp_payment');
        $this->addSql('DROP SEQUENCE package_temp_id_seq CASCADE');
        $this->addSql('DROP TABLE package_temp');
    }
}
