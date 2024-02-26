<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240226015753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE role DROP CONSTRAINT fk_57698a6a9d86650f');
        $this->addSql('DROP INDEX idx_57698a6a9d86650f');
        $this->addSql('ALTER TABLE role DROP user_id_id');
        $this->addSql('ALTER TABLE "user" ADD role_id INT NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8D93D649D60322AC ON "user" (role_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649D60322AC');
        $this->addSql('DROP INDEX IDX_8D93D649D60322AC');
        $this->addSql('ALTER TABLE "user" DROP role_id');
        $this->addSql('ALTER TABLE role ADD user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE role ADD CONSTRAINT fk_57698a6a9d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_57698a6a9d86650f ON role (user_id_id)');
    }
}
