<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109145025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE group_text_mapping (MappingId INT AUTO_INCREMENT NOT NULL, IsDeleted TINYINT(1) NOT NULL, GroupId INT DEFAULT NULL, TextEntryTextId INT NOT NULL, SurveyId INT NOT NULL, INDEX IDX_8101498C1ED2CD1C (TextEntryTextId), INDEX IDX_8101498CC1F6886 (SurveyId), PRIMARY KEY(MappingId)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE survey (SurveyId INT AUTO_INCREMENT NOT NULL, IsCompleted TINYINT(1) NOT NULL, CreatedDate DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', FinishedOnDate DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', VariantId INT NOT NULL, UserEmail VARCHAR(255) NOT NULL, INDEX IDX_AD5F9BFCE83B5CAB (VariantId), INDEX IDX_AD5F9BFC8306ED01 (UserEmail), PRIMARY KEY(SurveyId)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE textentry (TextID INT AUTO_INCREMENT NOT NULL, text LONGTEXT NOT NULL, author VARCHAR(255) NOT NULL, PRIMARY KEY(TextID)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (Email VARCHAR(255) NOT NULL, EnglishLevel SMALLINT DEFAULT NULL, NativeLanguage VARCHAR(255) NOT NULL, Gender SMALLINT DEFAULT NULL, Education VARCHAR(255) DEFAULT NULL, Country VARCHAR(255) DEFAULT NULL, IsInterestedInMore TINYINT(1) DEFAULT NULL, PRIMARY KEY(Email)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variant (VariantId INT AUTO_INCREMENT NOT NULL, Text1Id INT NOT NULL, Text2Id INT NOT NULL, Text3Id INT NOT NULL, Text4Id INT NOT NULL, Text5Id INT NOT NULL, Text6Id INT NOT NULL, Text7Id INT NOT NULL, Text8Id INT NOT NULL, INDEX IDX_F143BFAD71FDCE5C (Text1Id), INDEX IDX_F143BFAD73BB7005 (Text2Id), INDEX IDX_F143BFAD72791A32 (Text3Id), INDEX IDX_F143BFAD77360CB7 (Text4Id), INDEX IDX_F143BFAD76F46680 (Text5Id), INDEX IDX_F143BFAD74B2D8D9 (Text6Id), INDEX IDX_F143BFAD7570B2EE (Text7Id), INDEX IDX_F143BFAD7E2CF5D3 (Text8Id), PRIMARY KEY(VariantId)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE group_text_mapping ADD CONSTRAINT FK_8101498C1ED2CD1C FOREIGN KEY (TextEntryTextId) REFERENCES textentry (TextID)');
        $this->addSql('ALTER TABLE group_text_mapping ADD CONSTRAINT FK_8101498CC1F6886 FOREIGN KEY (SurveyId) REFERENCES survey (SurveyId)');
        $this->addSql('ALTER TABLE survey ADD CONSTRAINT FK_AD5F9BFCE83B5CAB FOREIGN KEY (VariantId) REFERENCES variant (VariantId)');
        $this->addSql('ALTER TABLE survey ADD CONSTRAINT FK_AD5F9BFC8306ED01 FOREIGN KEY (UserEmail) REFERENCES user (Email)');
        $this->addSql('ALTER TABLE variant ADD CONSTRAINT FK_F143BFAD71FDCE5C FOREIGN KEY (Text1Id) REFERENCES textentry (TextID)');
        $this->addSql('ALTER TABLE variant ADD CONSTRAINT FK_F143BFAD73BB7005 FOREIGN KEY (Text2Id) REFERENCES textentry (TextID)');
        $this->addSql('ALTER TABLE variant ADD CONSTRAINT FK_F143BFAD72791A32 FOREIGN KEY (Text3Id) REFERENCES textentry (TextID)');
        $this->addSql('ALTER TABLE variant ADD CONSTRAINT FK_F143BFAD77360CB7 FOREIGN KEY (Text4Id) REFERENCES textentry (TextID)');
        $this->addSql('ALTER TABLE variant ADD CONSTRAINT FK_F143BFAD76F46680 FOREIGN KEY (Text5Id) REFERENCES textentry (TextID)');
        $this->addSql('ALTER TABLE variant ADD CONSTRAINT FK_F143BFAD74B2D8D9 FOREIGN KEY (Text6Id) REFERENCES textentry (TextID)');
        $this->addSql('ALTER TABLE variant ADD CONSTRAINT FK_F143BFAD7570B2EE FOREIGN KEY (Text7Id) REFERENCES textentry (TextID)');
        $this->addSql('ALTER TABLE variant ADD CONSTRAINT FK_F143BFAD7E2CF5D3 FOREIGN KEY (Text8Id) REFERENCES textentry (TextID)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE group_text_mapping DROP FOREIGN KEY FK_8101498C1ED2CD1C');
        $this->addSql('ALTER TABLE group_text_mapping DROP FOREIGN KEY FK_8101498CC1F6886');
        $this->addSql('ALTER TABLE survey DROP FOREIGN KEY FK_AD5F9BFCE83B5CAB');
        $this->addSql('ALTER TABLE survey DROP FOREIGN KEY FK_AD5F9BFC8306ED01');
        $this->addSql('ALTER TABLE variant DROP FOREIGN KEY FK_F143BFAD71FDCE5C');
        $this->addSql('ALTER TABLE variant DROP FOREIGN KEY FK_F143BFAD73BB7005');
        $this->addSql('ALTER TABLE variant DROP FOREIGN KEY FK_F143BFAD72791A32');
        $this->addSql('ALTER TABLE variant DROP FOREIGN KEY FK_F143BFAD77360CB7');
        $this->addSql('ALTER TABLE variant DROP FOREIGN KEY FK_F143BFAD76F46680');
        $this->addSql('ALTER TABLE variant DROP FOREIGN KEY FK_F143BFAD74B2D8D9');
        $this->addSql('ALTER TABLE variant DROP FOREIGN KEY FK_F143BFAD7570B2EE');
        $this->addSql('ALTER TABLE variant DROP FOREIGN KEY FK_F143BFAD7E2CF5D3');
        $this->addSql('DROP TABLE group_text_mapping');
        $this->addSql('DROP TABLE survey');
        $this->addSql('DROP TABLE textentry');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE variant');
    }
}
