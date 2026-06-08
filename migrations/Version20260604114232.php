<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260604114232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etablissement ADD image_path VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ALTER etablissement_id DROP NOT NULL');
        $this->addSql(<<<'SQL'
            ALTER TABLE
              "user"
            ADD
              CONSTRAINT FK_8D93D649FF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              "user"
            ADD
              CONSTRAINT FK_8D93D649180AA129 FOREIGN KEY (filiere_id) REFERENCES filiere (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etablissement DROP image_path');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649FF631228');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649180AA129');
        $this->addSql('ALTER TABLE "user" ALTER etablissement_id SET NOT NULL');
    }
}
