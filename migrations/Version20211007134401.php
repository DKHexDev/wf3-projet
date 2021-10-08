<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211007134401 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE message_recipe (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, message LONGTEXT NOT NULL, INDEX IDX_EDAF2C38F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipe_message_recipe (recipe_id INT NOT NULL, message_recipe_id INT NOT NULL, INDEX IDX_9F38BEAB59D8A214 (recipe_id), INDEX IDX_9F38BEAB3361A422 (message_recipe_id), PRIMARY KEY(recipe_id, message_recipe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message_recipe ADD CONSTRAINT FK_EDAF2C38F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE recipe_message_recipe ADD CONSTRAINT FK_9F38BEAB59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe_message_recipe ADD CONSTRAINT FK_9F38BEAB3361A422 FOREIGN KEY (message_recipe_id) REFERENCES message_recipe (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipe_message_recipe DROP FOREIGN KEY FK_9F38BEAB3361A422');
        $this->addSql('DROP TABLE message_recipe');
        $this->addSql('DROP TABLE recipe_message_recipe');
    }
}
