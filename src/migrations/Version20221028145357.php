<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221028145357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A256353B48');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A2579F37AE5');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A256353B48 FOREIGN KEY (id_question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A2579F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784182D8F2BF8');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784182D8F2BF8 FOREIGN KEY (id_annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E2A06F420');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E2D8F2BF8');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E79F37AE5');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E2A06F420 FOREIGN KEY (id_answer_id) REFERENCES answer (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E2D8F2BF8 FOREIGN KEY (id_annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A10856479F37AE5');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A10856479F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A256353B48');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A2579F37AE5');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A256353B48 FOREIGN KEY (id_question_id) REFERENCES question (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A2579F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784182D8F2BF8');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784182D8F2BF8 FOREIGN KEY (id_annonce_id) REFERENCES annonce (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E2D8F2BF8');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E79F37AE5');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E2A06F420');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E2D8F2BF8 FOREIGN KEY (id_annonce_id) REFERENCES annonce (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E2A06F420 FOREIGN KEY (id_answer_id) REFERENCES answer (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A10856479F37AE5');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A10856479F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
