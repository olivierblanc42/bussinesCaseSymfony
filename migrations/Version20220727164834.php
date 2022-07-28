<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220727164834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quantity_in_basket DROP FOREIGN KEY FK_A7E84BBA76ED395');
        $this->addSql('ALTER TABLE quantity_in_basket DROP FOREIGN KEY FK_A7E84BBF347EFB');
        $this->addSql('DROP INDEX IDX_A7E84BBA76ED395 ON quantity_in_basket');
        $this->addSql('DROP INDEX IDX_A7E84BBF347EFB ON quantity_in_basket');
        $this->addSql('ALTER TABLE quantity_in_basket ADD basket_id INT DEFAULT NULL, ADD product_id INT DEFAULT NULL, DROP produit_id, DROP user_id');
        $this->addSql('ALTER TABLE quantity_in_basket ADD CONSTRAINT FK_A7E84BB1BE1FB52 FOREIGN KEY (basket_id) REFERENCES basket (id)');
        $this->addSql('ALTER TABLE quantity_in_basket ADD CONSTRAINT FK_A7E84BB4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_A7E84BB1BE1FB52 ON quantity_in_basket (basket_id)');
        $this->addSql('CREATE INDEX IDX_A7E84BB4584665A ON quantity_in_basket (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quantity_in_basket DROP FOREIGN KEY FK_A7E84BB1BE1FB52');
        $this->addSql('ALTER TABLE quantity_in_basket DROP FOREIGN KEY FK_A7E84BB4584665A');
        $this->addSql('DROP INDEX IDX_A7E84BB1BE1FB52 ON quantity_in_basket');
        $this->addSql('DROP INDEX IDX_A7E84BB4584665A ON quantity_in_basket');
        $this->addSql('ALTER TABLE quantity_in_basket ADD produit_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL, DROP basket_id, DROP product_id');
        $this->addSql('ALTER TABLE quantity_in_basket ADD CONSTRAINT FK_A7E84BBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE quantity_in_basket ADD CONSTRAINT FK_A7E84BBF347EFB FOREIGN KEY (produit_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_A7E84BBA76ED395 ON quantity_in_basket (user_id)');
        $this->addSql('CREATE INDEX IDX_A7E84BBF347EFB ON quantity_in_basket (produit_id)');
    }
}
