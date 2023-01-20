<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230119104359 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE idea_like DROP FOREIGN KEY FK_6F2AF5185B6FEF7D');
        $this->addSql('ALTER TABLE idea_like CHANGE idea_id idea_id INT NOT NULL');
        $this->addSql('ALTER TABLE idea_like ADD CONSTRAINT FK_6F2AF5185B6FEF7D FOREIGN KEY (idea_id) REFERENCES idea (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE idea_like DROP FOREIGN KEY FK_6F2AF5185B6FEF7D');
        $this->addSql('ALTER TABLE idea_like CHANGE idea_id idea_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE idea_like ADD CONSTRAINT FK_6F2AF5185B6FEF7D FOREIGN KEY (idea_id) REFERENCES idea (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
