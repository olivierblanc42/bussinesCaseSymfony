<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220728103926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_picture DROP FOREIGN KEY FK_4ED6518382BA4DFD');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F8981CFDAE7');
        $this->addSql('DROP TABLE profil_relative_path');
        $this->addSql('DROP TABLE relative_path');
        $this->addSql('DROP INDEX IDX_16DB4F8981CFDAE7 ON picture');
        $this->addSql('ALTER TABLE picture ADD path VARCHAR(500) NOT NULL, DROP url_id');
        $this->addSql('DROP INDEX UNIQ_4ED6518382BA4DFD ON user_picture');
        $this->addSql('ALTER TABLE user_picture ADD url VARCHAR(255) NOT NULL, DROP profil_relative_path_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profil_relative_path (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE relative_path (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(500) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE picture ADD url_id INT DEFAULT NULL, DROP path');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F8981CFDAE7 FOREIGN KEY (url_id) REFERENCES relative_path (id)');
        $this->addSql('CREATE INDEX IDX_16DB4F8981CFDAE7 ON picture (url_id)');
        $this->addSql('ALTER TABLE user_picture ADD profil_relative_path_id INT DEFAULT NULL, DROP url');
        $this->addSql('ALTER TABLE user_picture ADD CONSTRAINT FK_4ED6518382BA4DFD FOREIGN KEY (profil_relative_path_id) REFERENCES profil_relative_path (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4ED6518382BA4DFD ON user_picture (profil_relative_path_id)');
    }
}
