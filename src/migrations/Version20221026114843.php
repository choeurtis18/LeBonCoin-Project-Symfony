<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221026114843 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer DROP INDEX IDX_DADD4A256353B48, ADD UNIQUE INDEX UNIQ_DADD4A256353B48 (id_question_id)');
        $this->addSql('ALTER TABLE question ADD id_answer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E2A06F420 FOREIGN KEY (id_answer_id) REFERENCES answer (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B6F7494E2A06F420 ON question (id_answer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E2A06F420');
        $this->addSql('DROP INDEX UNIQ_B6F7494E2A06F420 ON question');
        $this->addSql('ALTER TABLE question DROP id_answer_id');
        $this->addSql('ALTER TABLE answer DROP INDEX UNIQ_DADD4A256353B48, ADD INDEX IDX_DADD4A256353B48 (id_question_id)');
    }
}
