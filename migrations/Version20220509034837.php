<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220509034837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE notifications (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, message VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_6000B0D3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE off_request (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, date_start DATETIME NOT NULL, date_end DATETIME NOT NULL, comments VARCHAR(100) DEFAULT NULL, status VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_71D6EE80A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE refresh_tokens (id INT AUTO_INCREMENT NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid DATETIME NOT NULL, UNIQUE INDEX UNIQ_9BACE7E1C74F2195 (refresh_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, slug VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_child (id INT AUTO_INCREMENT NOT NULL, tag_id INT NOT NULL, name VARCHAR(100) NOT NULL, slug VARCHAR(350) NOT NULL, description VARCHAR(255) DEFAULT NULL, max_balance DOUBLE PRECISION DEFAULT NULL, measure_unit VARCHAR(30) DEFAULT NULL, INDEX IDX_5F4D2FBAD26311 (tag_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teams (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, teams_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, date_entrance DATETIME NOT NULL, days_earned DOUBLE PRECISION DEFAULT NULL, days_taken DOUBLE PRECISION DEFAULT NULL, days_left DOUBLE PRECISION DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, job_title VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649D6365F12 (teams_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_tag_child (user_id INT NOT NULL, tag_child_id INT NOT NULL, INDEX IDX_BFC0CBA76ED395 (user_id), INDEX IDX_BFC0CBEB53B9C0 (tag_child_id), PRIMARY KEY(user_id, tag_child_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE validation_template (id INT AUTO_INCREMENT NOT NULL, team_id INT NOT NULL, main_validator_id INT NOT NULL, UNIQUE INDEX UNIQ_70C9B7D9296CD8AE (team_id), UNIQUE INDEX UNIQ_70C9B7D9A9DCFF55 (main_validator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE notifications ADD CONSTRAINT FK_6000B0D3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE off_request ADD CONSTRAINT FK_71D6EE80A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tag_child ADD CONSTRAINT FK_5F4D2FBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D6365F12 FOREIGN KEY (teams_id) REFERENCES teams (id)');
        $this->addSql('ALTER TABLE user_tag_child ADD CONSTRAINT FK_BFC0CBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_tag_child ADD CONSTRAINT FK_BFC0CBEB53B9C0 FOREIGN KEY (tag_child_id) REFERENCES tag_child (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE validation_template ADD CONSTRAINT FK_70C9B7D9296CD8AE FOREIGN KEY (team_id) REFERENCES teams (id)');
        $this->addSql('ALTER TABLE validation_template ADD CONSTRAINT FK_70C9B7D9A9DCFF55 FOREIGN KEY (main_validator_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tag_child DROP FOREIGN KEY FK_5F4D2FBAD26311');
        $this->addSql('ALTER TABLE user_tag_child DROP FOREIGN KEY FK_BFC0CBEB53B9C0');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D6365F12');
        $this->addSql('ALTER TABLE validation_template DROP FOREIGN KEY FK_70C9B7D9296CD8AE');
        $this->addSql('ALTER TABLE notifications DROP FOREIGN KEY FK_6000B0D3A76ED395');
        $this->addSql('ALTER TABLE off_request DROP FOREIGN KEY FK_71D6EE80A76ED395');
        $this->addSql('ALTER TABLE user_tag_child DROP FOREIGN KEY FK_BFC0CBA76ED395');
        $this->addSql('ALTER TABLE validation_template DROP FOREIGN KEY FK_70C9B7D9A9DCFF55');
        $this->addSql('DROP TABLE notifications');
        $this->addSql('DROP TABLE off_request');
        $this->addSql('DROP TABLE refresh_tokens');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_child');
        $this->addSql('DROP TABLE teams');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_tag_child');
        $this->addSql('DROP TABLE validation_template');
    }
}
