<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20171202233256_NewFromPrinterProcess extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE ads MODIFY proof_from_printer BOOLEAN NOT NULL DEFAULT FALSE');
//        $this->addSql('ALTER TABLE ads ADD temp_proof_from_printer BOOLEAN NOT NULL DEFAULT FALSE');
//        $this->addSql('UPDATE ads SET temp_proof_from_printer = TRUE WHERE proof_from_printer IS NOT NULL');
//        $this->addSql('ALTER TABLE ads DROP proof_from_printer');
//        $this->addSql('ALTER TABLE ads CHANGE temp_proof_from_printer proof_from_printer BOOLEAN NOT NULL DEFAULT FALSE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE ads MODIFY proof_from_printer DATE');
    }
}
