<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190325153439 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('DROP SEQUENCE package_temp_payment_id_seq CASCADE');
        $this->addSql('DROP TABLE package_temp_payment');
        $this->addSql('DROP SEQUENCE package_temp_id_seq CASCADE');
        $this->addSql('DROP TABLE package_temp');
        $this->addSql('CREATE SEQUENCE package_temp_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE package_temp (id INT NOT NULL, content TEXT NOT NULL, availability INT NOT NULL, PRIMARY KEY(id))');

        $packages = json_decode(
            '[{"title": "MARGARITA","subtitle": "Hesperia Playa El Agua","room": {"time": "5 d\u00edas y 4 noches","type": "Habitaci\u00f3n Villa ","details": ["Todo incluido"]},"flight": {"type": null,"departure": null},"symbol": "$","price": 377.50,"image": "assets\/images\/playa_elagua.jpg","width": 50,"footer": null,"allowDates": {"duration": 5,"start": "2019-03-21","end": "2019-04-26"},"haveFlight": false,"people": 3,"navicuSlug": "hesperia-playa-el-agua","navicuRoomId": 5,"navicuCategoryId": 89},{"title": "CHORON\u00cd","subtitle": "Posada Pipiolos","room": {"time": "4 d\u00edas y 3 noches","type": "Habitaci\u00f3n Doble + Desayuno incluido","details": []},"flight": {"type": null,"departure": null},"symbol": "$","price": 174,"image": "assets\/images\/choroni.png","width": 50,"footer": null,"allowDates": {"duration": 4,"start": "2019-03-19","end": "2019-04-27"},"haveFlight": false,"people": 2,"navicuSlug": "posada-pipiolos","navicuRoomId": 2541,"navicuCategoryId": 16},{"title": "AD\u00cdCORA","subtitle": "Aparta Hotel Hipocampo","room": {"time": "4 d\u00edas y 3 noches","type": "Apartamento vista al jard\u00EDn","details": ["Desayuno incluido"]},"flight": {"type": null,"departure": null},"symbol": "$","price": 214.29,"image": "assets\/images\/adicora.png","width": 50,"footer": null,"allowDates": {"duration": 4,"start": "2019-03-21","end": "2019-04-27"},"haveFlight": false,"people": 3,"navicuSlug": "apartahotel-hipocampo","navicuRoomId": 434,"navicuCategoryId": 16},{"title": "TUCACAS","subtitle": "Hotel Aventura Suites","room": {"time": "4 d\u00edas y 3 noches","type": "Habitaci\u00f3n Doble ","details": ["Desayuno incluido"]},"flight": {"type": null,"departure": null},"symbol": "$","price": 150,"image": "assets\/images\/tucacas.png","width": 50,"footer": null,"allowDates": {"duration": 4,"start": "2019-03-22","end": "2019-03-27"},"haveFlight": false,"people": 2,"navicuSlug": "hotel-aventura-suites","navicuRoomId": 758,"navicuCategoryId": 16},{"title": "GALIP\u00C1N","subtitle": "Posada de Norma","room": {"time": "4 d\u00edas y 3 noches","type": "Habitaci\u00f3n Deluxe","details": ["Media Pensi\u00F3n "]},"flight": {"type": null,"departure": null},"symbol": "$","price": 210,"image": "assets\/images\/galipan.png","width": 50,"footer": null,"allowDates": {"duration": 4,"start": "2019-03-22","end": "2019-04-27"},"haveFlight": false,"people": 2,"navicuSlug": "la-posada-de-norma","navicuRoomId": 2521,"navicuCategoryId": 90},{"title": "CHORON\u00cd","subtitle": "Posada Santa Barbara","room": {"time": "3 d\u00edas y 2 noches","type": "Habitaci\u00f3n Doble","details": ["Desayuno incluido"]},"flight": {"type": null,"departure": null},"symbol": "$","price": 68.58,"image": "assets\/images\/choroni_2.jpg","width": 50,"footer": null,"allowDates": {"duration": 2,"start": "2019-03-22","end": "2019-04-29"},"haveFlight": false,"people": 2,"navicuSlug": "posada-restaurante-santa-barbara","navicuRoomId": 2743,"navicuCategoryId": 16}]',
            true
        );

        foreach ($packages as $package) {
            $json = json_encode($package);

            if ($package['price'] === 302) {
                $availability = 10;
            } elseif ($package['price'] === 174) {
                $availability = 1;
            } elseif ($package['price'] === 214.29) {
                $availability = 1;
            } elseif ($package['price'] === 210) {
                $availability = 1;
            } elseif ($package['price'] === 150) {
                $availability = 3;
            } elseif ($package['price'] === 68.58) {
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
        $this->addSql('DROP SEQUENCE package_temp_payment_id_seq CASCADE');
        $this->addSql('DROP TABLE package_temp_payment');
        $this->addSql('DROP SEQUENCE package_temp_id_seq CASCADE');
        $this->addSql('DROP TABLE package_temp');
        $this->addSql('CREATE SEQUENCE package_temp_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE package_temp (id INT NOT NULL, content TEXT NOT NULL, availability INT NOT NULL, PRIMARY KEY(id))');

        $packages = json_decode(
            '[{"title":"MARGARITA","subtitle":"Hesperia Isla Margarita","room":{"time":"5 días y 4 noches","type":"Habitación Deluxe + Todo incluido","details":[]},"flight":{"type":null,"departure":null},"symbol":"$","price":456,"image":"assets/images/hesperia-isla-margarita.jpg","width":50,"footer":null,"allowDates":{"duration":5,"start":"2019-03-01","end":"2019-03-01"},"haveFlight":false,"people":3,"navicuSlug":"hesperia-isla-margarita","navicuRoomId":7},{"title":"MARGARITA","subtitle":"Sunsol Isla Caribe","room":{"time":"5 días y 4 noches","type":"Habitación Doble + Todo incluido","details":[]},"flight":{"type":null,"departure":null},"symbol":"$","price":297.37,"image":"assets/images/sunsol.jpg","width":50,"footer":null,"allowDates":{"duration":5,"start":"2019-03-01","end":"2019-03-01"},"haveFlight":false,"people":2,"navicuSlug":"sunsol-isla-caribe","navicuRoomId":771},{"title":"MARGARITA","subtitle":"Yaque Paradise","room":{"time":"5 días y 4 noches","type":"Habitación Doble","details":["Desayuno incluido","1 toldo","2 sillas de playa"]},"flight":{"type":null,"departure":null},"symbol":"$","price":212,"image":"assets/images/yaque-paradise.jpg","width":50,"footer":null,"allowDates":{"duration":5,"start":"2019-03-01","end":"2019-03-01"},"haveFlight":false,"people":2,"navicuSlug":"hotel-yaque-paradise","navicuRoomId":2566},{"title":"CHORONÍ","subtitle":"Posada El Ensueño","room":{"time":"5 días y 4 noches","type":"Habitación Doble","details":["Desayuno","Coffee Break","Cena"]},"flight":{"type":null,"departure":null},"symbol":"$","price":280,"image":"assets/images/el-ensueno.jpg","width":50,"footer":null,"allowDates":{"duration":5,"start":"2019-03-01","end":"2019-03-01"},"haveFlight":false,"people":2,"navicuSlug":"posada-el-ensueno","navicuRoomId":707},{"title":"COLONIA TOVAR","subtitle":"Hotel Bergland","room":{"time":null,"type":null,"details":[]},"flight":{"type":null,"departure":null},"symbol":"$","price":18.75,"image":"assets/images/bergland.jpg","width":100,"footer":{"text":"(precio por noche)","subtext":"Habitación Doble"},"allowDates":{"duration":1,"start":"2019-03-01","end":"2019-03-30"},"haveFlight":false,"people":2,"navicuSlug":"hotel-bergland","navicuRoomId":76}]',
            true
        );

        foreach ($packages as $package) {
            $json = json_encode($package);

            if ($package['price'] === 456) {
                $availability = 5;
            } elseif ($package['price'] === 297.37) {
                $availability = 3;
            } elseif ($package['price'] === 212) {
                $availability = 1;
            } elseif ($package['price'] === 18.75) {
                $availability = 1;
            } elseif ($package['price'] === 280) {
                $availability = 2;
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
}
