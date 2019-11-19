<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20191108143717_Flip2019 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE guests DROP pledge_2015, DROP pledge_2018, ADD pledge_2019 FLOAT(8,2) DEFAULT \'0.00\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
    }
}
