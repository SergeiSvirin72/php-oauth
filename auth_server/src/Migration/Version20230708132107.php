<?php

declare(strict_types=1);

namespace App\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230708132107 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE access_tokens (id VARCHAR(255) NOT NULL, client_id VARCHAR(255) DEFAULT NULL, user_id VARCHAR(255) NOT NULL, scopes CLOB NOT NULL --(DC2Type:json)
        , expiry_date_time DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , is_revoked BOOLEAN NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_58D184BC19EB6921 FOREIGN KEY (client_id) REFERENCES clients (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_58D184BC19EB6921 ON access_tokens (client_id)');
        $this->addSql('CREATE TABLE auth_codes (id VARCHAR(255) NOT NULL, client_id VARCHAR(255) DEFAULT NULL, user_id VARCHAR(255) NOT NULL, scopes CLOB NOT NULL --(DC2Type:json)
        , expiry_date_time DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , is_revoked BOOLEAN NOT NULL, redirect_uri VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_298F903819EB6921 FOREIGN KEY (client_id) REFERENCES clients (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_298F903819EB6921 ON auth_codes (client_id)');
        $this->addSql('CREATE TABLE clients (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, redirect_uri VARCHAR(255) NOT NULL, is_confidential BOOLEAN NOT NULL, secret VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C82E745E237E06 ON clients (name)');
        $this->addSql('CREATE TABLE refresh_tokens (id VARCHAR(255) NOT NULL, access_token_id VARCHAR(255) DEFAULT NULL, expiry_date_time DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , is_revoked BOOLEAN NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_9BACE7E12CCB2688 FOREIGN KEY (access_token_id) REFERENCES access_tokens (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9BACE7E12CCB2688 ON refresh_tokens (access_token_id)');
        $this->addSql('CREATE TABLE scopes (id VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE users (id VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE access_tokens');
        $this->addSql('DROP TABLE auth_codes');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE refresh_tokens');
        $this->addSql('DROP TABLE scopes');
        $this->addSql('DROP TABLE users');
    }
}
