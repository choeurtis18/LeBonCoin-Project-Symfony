<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221021201326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, tag_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_F65593E579F37AE5 (id_user_id), INDEX IDX_F65593E5BAD26311 (tag_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, id_question_id INT NOT NULL, id_user_id INT NOT NULL, answer VARCHAR(255) NOT NULL, INDEX IDX_DADD4A256353B48 (id_question_id), INDEX IDX_DADD4A2579F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, id_annonce_id INT NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_14B784182D8F2BF8 (id_annonce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, id_annonce_id INT NOT NULL, id_user_id INT NOT NULL, question VARCHAR(255) NOT NULL, INDEX IDX_B6F7494E2D8F2BF8 (id_annonce_id), INDEX IDX_B6F7494E79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, tag VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, vote TINYINT(1) NOT NULL, id_user_vote INT NOT NULL, INDEX IDX_5A10856479F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E579F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A256353B48 FOREIGN KEY (id_question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A2579F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784182D8F2BF8 FOREIGN KEY (id_annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E2D8F2BF8 FOREIGN KEY (id_annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A10856479F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E579F37AE5');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5BAD26311');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A256353B48');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A2579F37AE5');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784182D8F2BF8');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E2D8F2BF8');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E79F37AE5');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A10856479F37AE5');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vote');
    }
}
