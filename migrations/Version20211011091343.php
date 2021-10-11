<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211011091343 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE message_recipe_user (message_recipe_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_92F7D26F3361A422 (message_recipe_id), INDEX IDX_92F7D26FA76ED395 (user_id), PRIMARY KEY(message_recipe_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message_recipe_user ADD CONSTRAINT FK_92F7D26F3361A422 FOREIGN KEY (message_recipe_id) REFERENCES message_recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message_recipe_user ADD CONSTRAINT FK_92F7D26FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE message_recipe_user');
    }
}
