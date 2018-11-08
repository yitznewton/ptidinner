<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20181108143717_Flip2018 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE guests CHANGE pledge_current pledge_2017 FLOAT(8,2) DEFAULT \'0.00\' NOT NULL, DROP pledge_2006, DROP pledge_2014, ADD pledge_2018 FLOAT(8,2) DEFAULT \'0.00\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE guests CHANGE pledge_2017 pledge_current FLOAT(8,2) DEFAULT \'0.00\' NOT NULL, ADD pledge_2014 FLOAT(8,2) DEFAULT \'0.00\' NOT NULL, DROP pledge_2018');
    }
}
