<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220526135538 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, identifier CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5D9F75A1772E836A (identifier), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee_youwe_team (employee_id INT NOT NULL, youwe_team_id INT NOT NULL, INDEX IDX_387AF6248C03F15C (employee_id), INDEX IDX_387AF624DDC18196 (youwe_team_id), PRIMARY KEY(employee_id, youwe_team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE youwe_team (id INT AUTO_INCREMENT NOT NULL, identifier CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', team_name VARCHAR(255) NOT NULL, established_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_A0AD46F0772E836A (identifier), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE youwe_team_employee (youwe_team_id INT NOT NULL, employee_id INT NOT NULL, INDEX IDX_353B9B71DDC18196 (youwe_team_id), INDEX IDX_353B9B718C03F15C (employee_id), PRIMARY KEY(youwe_team_id, employee_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employee_youwe_team ADD CONSTRAINT FK_387AF6248C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employee_youwe_team ADD CONSTRAINT FK_387AF624DDC18196 FOREIGN KEY (youwe_team_id) REFERENCES youwe_team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE youwe_team_employee ADD CONSTRAINT FK_353B9B71DDC18196 FOREIGN KEY (youwe_team_id) REFERENCES youwe_team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE youwe_team_employee ADD CONSTRAINT FK_353B9B718C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee_youwe_team DROP FOREIGN KEY FK_387AF6248C03F15C');
        $this->addSql('ALTER TABLE youwe_team_employee DROP FOREIGN KEY FK_353B9B718C03F15C');
        $this->addSql('ALTER TABLE employee_youwe_team DROP FOREIGN KEY FK_387AF624DDC18196');
        $this->addSql('ALTER TABLE youwe_team_employee DROP FOREIGN KEY FK_353B9B71DDC18196');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE employee_youwe_team');
        $this->addSql('DROP TABLE youwe_team');
        $this->addSql('DROP TABLE youwe_team_employee');
    }
}
