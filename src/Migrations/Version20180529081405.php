<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180529081405 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expense (id INT AUTO_INCREMENT NOT NULL, category_id_id INT DEFAULT NULL, user_id_id INT DEFAULT NULL, amount DOUBLE PRECISION NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_2D3A8DA69777D11E (category_id_id), INDEX IDX_2D3A8DA69D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE expense ADD CONSTRAINT FK_2D3A8DA69777D11E FOREIGN KEY (category_id_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE expense ADD CONSTRAINT FK_2D3A8DA69D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE expense DROP FOREIGN KEY FK_2D3A8DA69777D11E');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE expense');
    }
}
