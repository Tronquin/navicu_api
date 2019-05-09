<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190313144045 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $fh = fopen('src/Migrations/airport.txt','r');
        while ($line = fgets($fh)) {
            $arrLine = explode(':', $line);

            if ($arrLine[1] !== 'N/A') {
                $this->addSql("UPDATE airport SET agency_type = 'airport' WHERE iata = ? AND agency_type = 'unknown'", array($arrLine[1]));
            }
        }
        fclose($fh);
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        /*$fh = fopen('src/Migrations/airport.txt','r');
        while ($line = fgets($fh)) {
            $arrLine = explode(':', $line);

            if ($arrLine[1] !== 'N/A') {
                $this->addSql("UPDATE airport SET agency_type = 'unknown' WHERE iata = ? AND agency_type = 'airport'", array($arrLine[1]));
            }
        }
        fclose($fh);*/

    }
}
