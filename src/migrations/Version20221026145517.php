<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221026145517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY vote_ibfk_1');
        $this->addSql('DROP INDEX id_user_vote ON vote');
        $this->addSql('ALTER TABLE vote CHANGE vote vote INT NOT NULL, CHANGE id_user_vote id_user_vote_id INT NOT NULL');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564910B184 FOREIGN KEY (id_user_vote_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5A108564910B184 ON vote (id_user_vote_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564910B184');
        $this->addSql('DROP INDEX IDX_5A108564910B184 ON vote');
        $this->addSql('ALTER TABLE vote CHANGE vote vote SMALLINT DEFAULT 0, CHANGE id_user_vote_id id_user_vote INT NOT NULL');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT vote_ibfk_1 FOREIGN KEY (id_user_vote) REFERENCES user (id)');
        $this->addSql('CREATE INDEX id_user_vote ON vote (id_user_vote)');
    }
}
