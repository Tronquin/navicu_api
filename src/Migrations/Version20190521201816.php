<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190521201816 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
         // this up() migration is auto-generated, please modify it to your needs
        $data = json_decode('
        [{"id":1,"currency":151},
        {"id":1100,"currency":47},
        {"id":1104,"currency":150},
        {"id":1107,"currency":47},
        {"id":1110,"currency":7},
        {"id":1112,"currency":47},
        {"id":1113,"currency":149},
        {"id":1120,"currency":47},
        {"id":1126,"currency":47},
        {"id":1127,"currency":150},
        {"id":1130,"currency":21},
        {"id":1137,"currency":27},
        {"id":1138,"currency":149},
        {"id":1144,"currency":32},
        {"id":1146,"currency":33},
        {"id":1147,"currency":34},
        {"id":1151,"currency":149},
        {"id":1152,"currency":47},
        {"id":1154,"currency":47},
        {"id":1158,"currency":42},
        {"id":1160,"currency":145},
        {"id":1161,"currency":47},
        {"id":1165,"currency":47},
        {"id":1167,"currency":47},
        {"id":1169,"currency":150},
        {"id":1170,"currency":145},
        {"id":1172,"currency":47},
        {"id":1174,"currency":150},
        {"id":1177,"currency":47},
        {"id":1178,"currency":150},
        {"id":1180,"currency":150},
        {"id":1186,"currency":47},
        {"id":1187,"currency":150},
        {"id":1191,"currency":47},
        {"id":1193,"currency":149},
        {"id":1199,"currency":47},
        {"id":1201,"currency":150},
        {"id":1203,"currency":150},
        {"id":1206,"currency":47},
        {"id":1207,"currency":47},
        {"id":1208,"currency":150},
        {"id":1211,"currency":71},
        {"id":1215,"currency":149},
        {"id":1221,"currency":150},
        {"id":1230,"currency":47},
        {"id":1231,"currency":47},
        {"id":1232,"currency":47},
        {"id":1235,"currency":47},
        {"id":1237,"currency":47},
        {"id":1239,"currency":145},
        {"id":1245,"currency":47},
        {"id":1247,"currency":150},
        {"id":1248,"currency":47},
        {"id":1252,"currency":98},
        {"id":1258,"currency":149},
        {"id":1261,"currency":47},
        {"id":1264,"currency":149},
        {"id":1275,"currency":47},
        {"id":1276,"currency":150},
        {"id":1279,"currency":47},
        {"id":1280,"currency":145},
        {"id":1283,"currency":47},
        {"id":1286,"currency":118},
        {"id":1294,"currency":150},
        {"id":1295,"currency":47},
        {"id":1297,"currency":47},
        {"id":1299,"currency":47},
        {"id":1304,"currency":145},
        {"id":1307,"currency":150},
        {"id":1309,"currency":47},
        {"id":1315,"currency":145},
        {"id":1321,"currency":149},
        {"id":1325,"currency":145},
        {"id":1326,"currency":146},
        {"id":1328,"currency":47},
        {"id":1330,"currency":150},
        {"id":1337,"currency":47}]',true);
        
        foreach ($data as $column) {
        
            $this->addSql('UPDATE location SET currency_id = :currency_id where id = :id', [
                'id' =>  $column['id'],
                'currency_id' =>  $column['currency']
            ]);
        }

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
