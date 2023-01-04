<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230104110454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE idea ADD author_id INT NOT NULL');
        $this->addSql('ALTER TABLE idea ADD CONSTRAINT FK_A8BCA45F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_A8BCA45F675F31B ON idea (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE idea DROP FOREIGN KEY FK_A8BCA45F675F31B');
        $this->addSql('DROP INDEX IDX_A8BCA45F675F31B ON idea');
        $this->addSql('ALTER TABLE idea DROP author_id');
    }
}
