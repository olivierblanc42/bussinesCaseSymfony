<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220727134929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE command_status (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_basket (product_id INT NOT NULL, basket_id INT NOT NULL, INDEX IDX_403A11DF4584665A (product_id), INDEX IDX_403A11DF1BE1FB52 (basket_id), PRIMARY KEY(product_id, basket_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_basket ADD CONSTRAINT FK_403A11DF4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_basket ADD CONSTRAINT FK_403A11DF1BE1FB52 FOREIGN KEY (basket_id) REFERENCES basket (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE status');
        $this->addSql('ALTER TABLE basket ADD user_id INT DEFAULT NULL, ADD adress_id INT DEFAULT NULL, ADD means_of_payment_id INT DEFAULT NULL, ADD command_status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE basket ADD CONSTRAINT FK_2246507BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE basket ADD CONSTRAINT FK_2246507B8486F9AC FOREIGN KEY (adress_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE basket ADD CONSTRAINT FK_2246507BEC4366A8 FOREIGN KEY (means_of_payment_id) REFERENCES means_of_payment (id)');
        $this->addSql('ALTER TABLE basket ADD CONSTRAINT FK_2246507BECC64FB6 FOREIGN KEY (command_status_id) REFERENCES command_status (id)');
        $this->addSql('CREATE INDEX IDX_2246507BA76ED395 ON basket (user_id)');
        $this->addSql('CREATE INDEX IDX_2246507B8486F9AC ON basket (adress_id)');
        $this->addSql('CREATE INDEX IDX_2246507BEC4366A8 ON basket (means_of_payment_id)');
        $this->addSql('CREATE INDEX IDX_2246507BECC64FB6 ON basket (command_status_id)');
        $this->addSql('ALTER TABLE category ADD parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_64C19C1727ACA70 ON category (parent_id)');
        $this->addSql('ALTER TABLE product ADD brand_id INT DEFAULT NULL, ADD species_id INT DEFAULT NULL, ADD category_id INT DEFAULT NULL, CHANGE price_ht price_ht NUMERIC(8, 2) NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADB2A1D860 FOREIGN KEY (species_id) REFERENCES species (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD44F5D008 ON product (brand_id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADB2A1D860 ON product (species_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
        $this->addSql('ALTER TABLE review ADD user_id INT DEFAULT NULL, ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C64584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_794381C6A76ED395 ON review (user_id)');
        $this->addSql('CREATE INDEX IDX_794381C64584665A ON review (product_id)');
        $this->addSql('ALTER TABLE user ADD adress_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498486F9AC FOREIGN KEY (adress_id) REFERENCES address (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6498486F9AC ON user (adress_id)');
        $this->addSql('ALTER TABLE user_picture ADD user_id INT DEFAULT NULL, ADD profil_relative_path_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_picture ADD CONSTRAINT FK_4ED65183A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_picture ADD CONSTRAINT FK_4ED6518382BA4DFD FOREIGN KEY (profil_relative_path_id) REFERENCES profil_relative_path (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4ED65183A76ED395 ON user_picture (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4ED6518382BA4DFD ON user_picture (profil_relative_path_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE basket DROP FOREIGN KEY FK_2246507BECC64FB6');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE command_status');
        $this->addSql('DROP TABLE product_basket');
        $this->addSql('ALTER TABLE basket DROP FOREIGN KEY FK_2246507BA76ED395');
        $this->addSql('ALTER TABLE basket DROP FOREIGN KEY FK_2246507B8486F9AC');
        $this->addSql('ALTER TABLE basket DROP FOREIGN KEY FK_2246507BEC4366A8');
        $this->addSql('DROP INDEX IDX_2246507BA76ED395 ON basket');
        $this->addSql('DROP INDEX IDX_2246507B8486F9AC ON basket');
        $this->addSql('DROP INDEX IDX_2246507BEC4366A8 ON basket');
        $this->addSql('DROP INDEX IDX_2246507BECC64FB6 ON basket');
        $this->addSql('ALTER TABLE basket DROP user_id, DROP adress_id, DROP means_of_payment_id, DROP command_status_id');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1727ACA70');
        $this->addSql('DROP INDEX IDX_64C19C1727ACA70 ON category');
        $this->addSql('ALTER TABLE category DROP parent_id');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD44F5D008');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADB2A1D860');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('DROP INDEX IDX_D34A04AD44F5D008 ON product');
        $this->addSql('DROP INDEX IDX_D34A04ADB2A1D860 ON product');
        $this->addSql('DROP INDEX IDX_D34A04AD12469DE2 ON product');
        $this->addSql('ALTER TABLE product DROP brand_id, DROP species_id, DROP category_id, CHANGE price_ht price_ht DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6A76ED395');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C64584665A');
        $this->addSql('DROP INDEX IDX_794381C6A76ED395 ON review');
        $this->addSql('DROP INDEX IDX_794381C64584665A ON review');
        $this->addSql('ALTER TABLE review DROP user_id, DROP product_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498486F9AC');
        $this->addSql('DROP INDEX IDX_8D93D6498486F9AC ON user');
        $this->addSql('ALTER TABLE user DROP adress_id');
        $this->addSql('ALTER TABLE user_picture DROP FOREIGN KEY FK_4ED65183A76ED395');
        $this->addSql('ALTER TABLE user_picture DROP FOREIGN KEY FK_4ED6518382BA4DFD');
        $this->addSql('DROP INDEX UNIQ_4ED65183A76ED395 ON user_picture');
        $this->addSql('DROP INDEX UNIQ_4ED6518382BA4DFD ON user_picture');
        $this->addSql('ALTER TABLE user_picture DROP user_id, DROP profil_relative_path_id');
    }
}
