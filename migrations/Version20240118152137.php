<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240118152137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, raffle_notification_id INT DEFAULT NULL, text VARCHAR(255) DEFAULT NULL, date_time DATETIME NOT NULL, accepted SMALLINT NOT NULL, INDEX IDX_BF5476CAA76ED395 (user_id), UNIQUE INDEX UNIQ_BF5476CACED8AF90 (raffle_notification_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE raffle (id INT AUTO_INCREMENT NOT NULL, winner_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, date_time DATETIME NOT NULL, prize DOUBLE PRECISION NOT NULL, price_per_ticket DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_F5FDFDA55DFCD4B8 (winner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, buyer_id INT DEFAULT NULL, number_ticket INT NOT NULL, INDEX IDX_97A0ADA36C755722 (buyer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CACED8AF90 FOREIGN KEY (raffle_notification_id) REFERENCES raffle (id)');
        $this->addSql('ALTER TABLE raffle ADD CONSTRAINT FK_F5FDFDA55DFCD4B8 FOREIGN KEY (winner_id) REFERENCES ticket (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA36C755722 FOREIGN KEY (buyer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD money DOUBLE PRECISION DEFAULT NULL, ADD total_profit DOUBLE PRECISION DEFAULT NULL, ADD total_invested DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAA76ED395');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CACED8AF90');
        $this->addSql('ALTER TABLE raffle DROP FOREIGN KEY FK_F5FDFDA55DFCD4B8');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA36C755722');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE raffle');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('ALTER TABLE user DROP money, DROP total_profit, DROP total_invested');
    }
}
