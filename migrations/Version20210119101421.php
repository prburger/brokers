<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210119101421 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE broker_supplier');
        $this->addSql('DROP INDEX UNIQ_F6AAF03BE7A1254A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__broker AS SELECT id, contact_id, name, date_added, date_edited FROM broker');
        $this->addSql('DROP TABLE broker');
        $this->addSql('CREATE TABLE broker (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contact_id INTEGER NOT NULL, name VARCHAR(120) NOT NULL COLLATE BINARY, date_added DATE NOT NULL, date_edited DATE NOT NULL, CONSTRAINT FK_F6AAF03BE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO broker (id, contact_id, name, date_added, date_edited) SELECT id, contact_id, name, date_added, date_edited FROM __temp__broker');
        $this->addSql('DROP TABLE __temp__broker');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6AAF03BE7A1254A ON broker (contact_id)');
        $this->addSql('DROP INDEX IDX_1DF33856CC064FC');
        $this->addSql('DROP INDEX IDX_1DF3385537A1329');
        $this->addSql('CREATE TEMPORARY TABLE __temp__broker_message AS SELECT broker_id, message_id FROM broker_message');
        $this->addSql('DROP TABLE broker_message');
        $this->addSql('CREATE TABLE broker_message (broker_id INTEGER NOT NULL, message_id INTEGER NOT NULL, PRIMARY KEY(broker_id, message_id), CONSTRAINT FK_1DF33856CC064FC FOREIGN KEY (broker_id) REFERENCES broker (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_1DF3385537A1329 FOREIGN KEY (message_id) REFERENCES message (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO broker_message (broker_id, message_id) SELECT broker_id, message_id FROM __temp__broker_message');
        $this->addSql('DROP TABLE __temp__broker_message');
        $this->addSql('CREATE INDEX IDX_1DF33856CC064FC ON broker_message (broker_id)');
        $this->addSql('CREATE INDEX IDX_1DF3385537A1329 ON broker_message (message_id)');
        $this->addSql('DROP INDEX IDX_DCE6F7086CC064FC');
        $this->addSql('DROP INDEX IDX_DCE6F7089395C3F3');
        $this->addSql('CREATE TEMPORARY TABLE __temp__broker_customer AS SELECT broker_id, customer_id FROM broker_customer');
        $this->addSql('DROP TABLE broker_customer');
        $this->addSql('CREATE TABLE broker_customer (broker_id INTEGER NOT NULL, customer_id INTEGER NOT NULL, PRIMARY KEY(broker_id, customer_id), CONSTRAINT FK_DCE6F7086CC064FC FOREIGN KEY (broker_id) REFERENCES broker (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_DCE6F7089395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO broker_customer (broker_id, customer_id) SELECT broker_id, customer_id FROM __temp__broker_customer');
        $this->addSql('DROP TABLE __temp__broker_customer');
        $this->addSql('CREATE INDEX IDX_DCE6F7086CC064FC ON broker_customer (broker_id)');
        $this->addSql('CREATE INDEX IDX_DCE6F7089395C3F3 ON broker_customer (customer_id)');
        $this->addSql('DROP INDEX IDX_54068BB26CC064FC');
        $this->addSql('DROP INDEX IDX_54068BB226ED0855');
        $this->addSql('CREATE TEMPORARY TABLE __temp__broker_note AS SELECT broker_id, note_id FROM broker_note');
        $this->addSql('DROP TABLE broker_note');
        $this->addSql('CREATE TABLE broker_note (broker_id INTEGER NOT NULL, note_id INTEGER NOT NULL, PRIMARY KEY(broker_id, note_id), CONSTRAINT FK_54068BB26CC064FC FOREIGN KEY (broker_id) REFERENCES broker (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_54068BB226ED0855 FOREIGN KEY (note_id) REFERENCES note (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO broker_note (broker_id, note_id) SELECT broker_id, note_id FROM __temp__broker_note');
        $this->addSql('DROP TABLE __temp__broker_note');
        $this->addSql('CREATE INDEX IDX_54068BB26CC064FC ON broker_note (broker_id)');
        $this->addSql('CREATE INDEX IDX_54068BB226ED0855 ON broker_note (note_id)');
        $this->addSql('DROP INDEX UNIQ_81398E09E7A1254A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__customer AS SELECT id, contact_id, name, date_added, date_edited FROM customer');
        $this->addSql('DROP TABLE customer');
        $this->addSql('CREATE TABLE customer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contact_id INTEGER DEFAULT NULL, name VARCHAR(120) NOT NULL COLLATE BINARY, date_added DATE NOT NULL, date_edited DATE NOT NULL, CONSTRAINT FK_81398E09E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO customer (id, contact_id, name, date_added, date_edited) SELECT id, contact_id, name, date_added, date_edited FROM __temp__customer');
        $this->addSql('DROP TABLE __temp__customer');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E09E7A1254A ON customer (contact_id)');
        $this->addSql('DROP INDEX IDX_AA6094C19395C3F3');
        $this->addSql('DROP INDEX IDX_AA6094C1537A1329');
        $this->addSql('CREATE TEMPORARY TABLE __temp__customer_message AS SELECT customer_id, message_id FROM customer_message');
        $this->addSql('DROP TABLE customer_message');
        $this->addSql('CREATE TABLE customer_message (customer_id INTEGER NOT NULL, message_id INTEGER NOT NULL, PRIMARY KEY(customer_id, message_id), CONSTRAINT FK_AA6094C19395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_AA6094C1537A1329 FOREIGN KEY (message_id) REFERENCES message (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO customer_message (customer_id, message_id) SELECT customer_id, message_id FROM __temp__customer_message');
        $this->addSql('DROP TABLE __temp__customer_message');
        $this->addSql('CREATE INDEX IDX_AA6094C19395C3F3 ON customer_message (customer_id)');
        $this->addSql('CREATE INDEX IDX_AA6094C1537A1329 ON customer_message (message_id)');
        $this->addSql('DROP INDEX IDX_9B2C5E639395C3F3');
        $this->addSql('DROP INDEX IDX_9B2C5E6326ED0855');
        $this->addSql('CREATE TEMPORARY TABLE __temp__customer_note AS SELECT customer_id, note_id FROM customer_note');
        $this->addSql('DROP TABLE customer_note');
        $this->addSql('CREATE TABLE customer_note (customer_id INTEGER NOT NULL, note_id INTEGER NOT NULL, PRIMARY KEY(customer_id, note_id), CONSTRAINT FK_9B2C5E639395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9B2C5E6326ED0855 FOREIGN KEY (note_id) REFERENCES note (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO customer_note (customer_id, note_id) SELECT customer_id, note_id FROM __temp__customer_note');
        $this->addSql('DROP TABLE __temp__customer_note');
        $this->addSql('CREATE INDEX IDX_9B2C5E639395C3F3 ON customer_note (customer_id)');
        $this->addSql('CREATE INDEX IDX_9B2C5E6326ED0855 ON customer_note (note_id)');
        $this->addSql('DROP INDEX IDX_B7EF2F519395C3F3');
        $this->addSql('DROP INDEX IDX_B7EF2F512ADD6D8C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__customer_supplier AS SELECT customer_id, supplier_id FROM customer_supplier');
        $this->addSql('DROP TABLE customer_supplier');
        $this->addSql('CREATE TABLE customer_supplier (customer_id INTEGER NOT NULL, supplier_id INTEGER NOT NULL, PRIMARY KEY(customer_id, supplier_id), CONSTRAINT FK_B7EF2F519395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B7EF2F512ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO customer_supplier (customer_id, supplier_id) SELECT customer_id, supplier_id FROM __temp__customer_supplier');
        $this->addSql('DROP TABLE __temp__customer_supplier');
        $this->addSql('CREATE INDEX IDX_B7EF2F519395C3F3 ON customer_supplier (customer_id)');
        $this->addSql('CREATE INDEX IDX_B7EF2F512ADD6D8C ON customer_supplier (supplier_id)');
        $this->addSql('DROP INDEX UNIQ_D34A04ADBDE4EC11');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, specifications_id, name, date_added, date_edited FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, specifications_id INTEGER NOT NULL, name VARCHAR(120) NOT NULL COLLATE BINARY, date_added DATE NOT NULL, date_edited DATE NOT NULL, CONSTRAINT FK_D34A04ADBDE4EC11 FOREIGN KEY (specifications_id) REFERENCES specification (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO product (id, specifications_id, name, date_added, date_edited) SELECT id, specifications_id, name, date_added, date_edited FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04ADBDE4EC11 ON product (specifications_id)');
        $this->addSql('DROP INDEX UNIQ_9B2A6C7EE7A1254A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__supplier AS SELECT id, contact_id, name, date_added, date_edited FROM supplier');
        $this->addSql('DROP TABLE supplier');
        $this->addSql('CREATE TABLE supplier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contact_id INTEGER DEFAULT NULL, name VARCHAR(120) NOT NULL COLLATE BINARY, date_added DATE NOT NULL, date_edited DATE NOT NULL, CONSTRAINT FK_9B2A6C7EE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO supplier (id, contact_id, name, date_added, date_edited) SELECT id, contact_id, name, date_added, date_edited FROM __temp__supplier');
        $this->addSql('DROP TABLE __temp__supplier');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9B2A6C7EE7A1254A ON supplier (contact_id)');
        $this->addSql('DROP INDEX IDX_522F70B24584665A');
        $this->addSql('DROP INDEX IDX_522F70B22ADD6D8C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__supplier_product AS SELECT supplier_id, product_id FROM supplier_product');
        $this->addSql('DROP TABLE supplier_product');
        $this->addSql('CREATE TABLE supplier_product (supplier_id INTEGER NOT NULL, product_id INTEGER NOT NULL, PRIMARY KEY(supplier_id, product_id), CONSTRAINT FK_522F70B22ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_522F70B24584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO supplier_product (supplier_id, product_id) SELECT supplier_id, product_id FROM __temp__supplier_product');
        $this->addSql('DROP TABLE __temp__supplier_product');
        $this->addSql('CREATE INDEX IDX_522F70B24584665A ON supplier_product (product_id)');
        $this->addSql('CREATE INDEX IDX_522F70B22ADD6D8C ON supplier_product (supplier_id)');
        $this->addSql('DROP INDEX IDX_37D844602ADD6D8C');
        $this->addSql('DROP INDEX IDX_37D84460537A1329');
        $this->addSql('CREATE TEMPORARY TABLE __temp__supplier_message AS SELECT supplier_id, message_id FROM supplier_message');
        $this->addSql('DROP TABLE supplier_message');
        $this->addSql('CREATE TABLE supplier_message (supplier_id INTEGER NOT NULL, message_id INTEGER NOT NULL, PRIMARY KEY(supplier_id, message_id), CONSTRAINT FK_37D844602ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_37D84460537A1329 FOREIGN KEY (message_id) REFERENCES message (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO supplier_message (supplier_id, message_id) SELECT supplier_id, message_id FROM __temp__supplier_message');
        $this->addSql('DROP TABLE __temp__supplier_message');
        $this->addSql('CREATE INDEX IDX_37D844602ADD6D8C ON supplier_message (supplier_id)');
        $this->addSql('CREATE INDEX IDX_37D84460537A1329 ON supplier_message (message_id)');
        $this->addSql('DROP INDEX IDX_2E50CFD26ED0855');
        $this->addSql('DROP INDEX IDX_2E50CFD2ADD6D8C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__supplier_note AS SELECT supplier_id, note_id FROM supplier_note');
        $this->addSql('DROP TABLE supplier_note');
        $this->addSql('CREATE TABLE supplier_note (supplier_id INTEGER NOT NULL, note_id INTEGER NOT NULL, PRIMARY KEY(supplier_id, note_id), CONSTRAINT FK_2E50CFD2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2E50CFD26ED0855 FOREIGN KEY (note_id) REFERENCES note (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO supplier_note (supplier_id, note_id) SELECT supplier_id, note_id FROM __temp__supplier_note');
        $this->addSql('DROP TABLE __temp__supplier_note');
        $this->addSql('CREATE INDEX IDX_2E50CFD26ED0855 ON supplier_note (note_id)');
        $this->addSql('CREATE INDEX IDX_2E50CFD2ADD6D8C ON supplier_note (supplier_id)');
        $this->addSql('DROP INDEX IDX_2DC822EF6CC064FC');
        $this->addSql('DROP INDEX IDX_2DC822EF2ADD6D8C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__supplier_broker AS SELECT supplier_id, broker_id FROM supplier_broker');
        $this->addSql('DROP TABLE supplier_broker');
        $this->addSql('CREATE TABLE supplier_broker (supplier_id INTEGER NOT NULL, broker_id INTEGER NOT NULL, PRIMARY KEY(supplier_id, broker_id), CONSTRAINT FK_2DC822EF2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2DC822EF6CC064FC FOREIGN KEY (broker_id) REFERENCES broker (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO supplier_broker (supplier_id, broker_id) SELECT supplier_id, broker_id FROM __temp__supplier_broker');
        $this->addSql('DROP TABLE __temp__supplier_broker');
        $this->addSql('CREATE INDEX IDX_2DC822EF6CC064FC ON supplier_broker (broker_id)');
        $this->addSql('CREATE INDEX IDX_2DC822EF2ADD6D8C ON supplier_broker (supplier_id)');
        $this->addSql('DROP INDEX IDX_CB0E6889395C3F3');
        $this->addSql('DROP INDEX IDX_CB0E6882ADD6D8C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__supplier_customer AS SELECT supplier_id, customer_id FROM supplier_customer');
        $this->addSql('DROP TABLE supplier_customer');
        $this->addSql('CREATE TABLE supplier_customer (supplier_id INTEGER NOT NULL, customer_id INTEGER NOT NULL, PRIMARY KEY(supplier_id, customer_id), CONSTRAINT FK_CB0E6882ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CB0E6889395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO supplier_customer (supplier_id, customer_id) SELECT supplier_id, customer_id FROM __temp__supplier_customer');
        $this->addSql('DROP TABLE __temp__supplier_customer');
        $this->addSql('CREATE INDEX IDX_CB0E6889395C3F3 ON supplier_customer (customer_id)');
        $this->addSql('CREATE INDEX IDX_CB0E6882ADD6D8C ON supplier_customer (supplier_id)');
        $this->addSql('DROP INDEX IDX_53AD8F834B89032C');
        $this->addSql('DROP INDEX IDX_53AD8F83F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__symfony_demo_comment AS SELECT id, post_id, author_id, content, published_at FROM symfony_demo_comment');
        $this->addSql('DROP TABLE symfony_demo_comment');
        $this->addSql('CREATE TABLE symfony_demo_comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, post_id INTEGER NOT NULL, author_id INTEGER NOT NULL, content CLOB NOT NULL COLLATE BINARY, published_at DATETIME NOT NULL, CONSTRAINT FK_53AD8F834B89032C FOREIGN KEY (post_id) REFERENCES symfony_demo_post (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_53AD8F83F675F31B FOREIGN KEY (author_id) REFERENCES symfony_demo_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO symfony_demo_comment (id, post_id, author_id, content, published_at) SELECT id, post_id, author_id, content, published_at FROM __temp__symfony_demo_comment');
        $this->addSql('DROP TABLE __temp__symfony_demo_comment');
        $this->addSql('CREATE INDEX IDX_53AD8F834B89032C ON symfony_demo_comment (post_id)');
        $this->addSql('CREATE INDEX IDX_53AD8F83F675F31B ON symfony_demo_comment (author_id)');
        $this->addSql('DROP INDEX IDX_58A92E65F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__symfony_demo_post AS SELECT id, author_id, title, slug, summary, content, published_at FROM symfony_demo_post');
        $this->addSql('DROP TABLE symfony_demo_post');
        $this->addSql('CREATE TABLE symfony_demo_post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, slug VARCHAR(255) NOT NULL COLLATE BINARY, summary VARCHAR(255) NOT NULL COLLATE BINARY, content CLOB NOT NULL COLLATE BINARY, published_at DATETIME NOT NULL, CONSTRAINT FK_58A92E65F675F31B FOREIGN KEY (author_id) REFERENCES symfony_demo_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO symfony_demo_post (id, author_id, title, slug, summary, content, published_at) SELECT id, author_id, title, slug, summary, content, published_at FROM __temp__symfony_demo_post');
        $this->addSql('DROP TABLE __temp__symfony_demo_post');
        $this->addSql('CREATE INDEX IDX_58A92E65F675F31B ON symfony_demo_post (author_id)');
        $this->addSql('DROP INDEX IDX_6ABC1CC44B89032C');
        $this->addSql('DROP INDEX IDX_6ABC1CC4BAD26311');
        $this->addSql('CREATE TEMPORARY TABLE __temp__symfony_demo_post_tag AS SELECT post_id, tag_id FROM symfony_demo_post_tag');
        $this->addSql('DROP TABLE symfony_demo_post_tag');
        $this->addSql('CREATE TABLE symfony_demo_post_tag (post_id INTEGER NOT NULL, tag_id INTEGER NOT NULL, PRIMARY KEY(post_id, tag_id), CONSTRAINT FK_6ABC1CC44B89032C FOREIGN KEY (post_id) REFERENCES symfony_demo_post (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6ABC1CC4BAD26311 FOREIGN KEY (tag_id) REFERENCES symfony_demo_tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO symfony_demo_post_tag (post_id, tag_id) SELECT post_id, tag_id FROM __temp__symfony_demo_post_tag');
        $this->addSql('DROP TABLE __temp__symfony_demo_post_tag');
        $this->addSql('CREATE INDEX IDX_6ABC1CC44B89032C ON symfony_demo_post_tag (post_id)');
        $this->addSql('CREATE INDEX IDX_6ABC1CC4BAD26311 ON symfony_demo_post_tag (tag_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE broker_supplier (broker_id INTEGER NOT NULL, supplier_id INTEGER NOT NULL, PRIMARY KEY(broker_id, supplier_id))');
        $this->addSql('CREATE INDEX IDX_C6F5157F6CC064FC ON broker_supplier (broker_id)');
        $this->addSql('CREATE INDEX IDX_C6F5157F2ADD6D8C ON broker_supplier (supplier_id)');
        $this->addSql('DROP INDEX UNIQ_F6AAF03BE7A1254A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__broker AS SELECT id, contact_id, name, date_added, date_edited FROM broker');
        $this->addSql('DROP TABLE broker');
        $this->addSql('CREATE TABLE broker (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contact_id INTEGER NOT NULL, name VARCHAR(120) NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL)');
        $this->addSql('INSERT INTO broker (id, contact_id, name, date_added, date_edited) SELECT id, contact_id, name, date_added, date_edited FROM __temp__broker');
        $this->addSql('DROP TABLE __temp__broker');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6AAF03BE7A1254A ON broker (contact_id)');
        $this->addSql('DROP INDEX IDX_DCE6F7086CC064FC');
        $this->addSql('DROP INDEX IDX_DCE6F7089395C3F3');
        $this->addSql('CREATE TEMPORARY TABLE __temp__broker_customer AS SELECT broker_id, customer_id FROM broker_customer');
        $this->addSql('DROP TABLE broker_customer');
        $this->addSql('CREATE TABLE broker_customer (broker_id INTEGER NOT NULL, customer_id INTEGER NOT NULL, PRIMARY KEY(broker_id, customer_id))');
        $this->addSql('INSERT INTO broker_customer (broker_id, customer_id) SELECT broker_id, customer_id FROM __temp__broker_customer');
        $this->addSql('DROP TABLE __temp__broker_customer');
        $this->addSql('CREATE INDEX IDX_DCE6F7086CC064FC ON broker_customer (broker_id)');
        $this->addSql('CREATE INDEX IDX_DCE6F7089395C3F3 ON broker_customer (customer_id)');
        $this->addSql('DROP INDEX IDX_1DF33856CC064FC');
        $this->addSql('DROP INDEX IDX_1DF3385537A1329');
        $this->addSql('CREATE TEMPORARY TABLE __temp__broker_message AS SELECT broker_id, message_id FROM broker_message');
        $this->addSql('DROP TABLE broker_message');
        $this->addSql('CREATE TABLE broker_message (broker_id INTEGER NOT NULL, message_id INTEGER NOT NULL, PRIMARY KEY(broker_id, message_id))');
        $this->addSql('INSERT INTO broker_message (broker_id, message_id) SELECT broker_id, message_id FROM __temp__broker_message');
        $this->addSql('DROP TABLE __temp__broker_message');
        $this->addSql('CREATE INDEX IDX_1DF33856CC064FC ON broker_message (broker_id)');
        $this->addSql('CREATE INDEX IDX_1DF3385537A1329 ON broker_message (message_id)');
        $this->addSql('DROP INDEX IDX_54068BB26CC064FC');
        $this->addSql('DROP INDEX IDX_54068BB226ED0855');
        $this->addSql('CREATE TEMPORARY TABLE __temp__broker_note AS SELECT broker_id, note_id FROM broker_note');
        $this->addSql('DROP TABLE broker_note');
        $this->addSql('CREATE TABLE broker_note (broker_id INTEGER NOT NULL, note_id INTEGER NOT NULL, PRIMARY KEY(broker_id, note_id))');
        $this->addSql('INSERT INTO broker_note (broker_id, note_id) SELECT broker_id, note_id FROM __temp__broker_note');
        $this->addSql('DROP TABLE __temp__broker_note');
        $this->addSql('CREATE INDEX IDX_54068BB26CC064FC ON broker_note (broker_id)');
        $this->addSql('CREATE INDEX IDX_54068BB226ED0855 ON broker_note (note_id)');
        $this->addSql('DROP INDEX UNIQ_81398E09E7A1254A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__customer AS SELECT id, contact_id, name, date_added, date_edited FROM customer');
        $this->addSql('DROP TABLE customer');
        $this->addSql('CREATE TABLE customer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contact_id INTEGER DEFAULT NULL, name VARCHAR(120) NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL)');
        $this->addSql('INSERT INTO customer (id, contact_id, name, date_added, date_edited) SELECT id, contact_id, name, date_added, date_edited FROM __temp__customer');
        $this->addSql('DROP TABLE __temp__customer');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E09E7A1254A ON customer (contact_id)');
        $this->addSql('DROP INDEX IDX_AA6094C19395C3F3');
        $this->addSql('DROP INDEX IDX_AA6094C1537A1329');
        $this->addSql('CREATE TEMPORARY TABLE __temp__customer_message AS SELECT customer_id, message_id FROM customer_message');
        $this->addSql('DROP TABLE customer_message');
        $this->addSql('CREATE TABLE customer_message (customer_id INTEGER NOT NULL, message_id INTEGER NOT NULL, PRIMARY KEY(customer_id, message_id))');
        $this->addSql('INSERT INTO customer_message (customer_id, message_id) SELECT customer_id, message_id FROM __temp__customer_message');
        $this->addSql('DROP TABLE __temp__customer_message');
        $this->addSql('CREATE INDEX IDX_AA6094C19395C3F3 ON customer_message (customer_id)');
        $this->addSql('CREATE INDEX IDX_AA6094C1537A1329 ON customer_message (message_id)');
        $this->addSql('DROP INDEX IDX_9B2C5E639395C3F3');
        $this->addSql('DROP INDEX IDX_9B2C5E6326ED0855');
        $this->addSql('CREATE TEMPORARY TABLE __temp__customer_note AS SELECT customer_id, note_id FROM customer_note');
        $this->addSql('DROP TABLE customer_note');
        $this->addSql('CREATE TABLE customer_note (customer_id INTEGER NOT NULL, note_id INTEGER NOT NULL, PRIMARY KEY(customer_id, note_id))');
        $this->addSql('INSERT INTO customer_note (customer_id, note_id) SELECT customer_id, note_id FROM __temp__customer_note');
        $this->addSql('DROP TABLE __temp__customer_note');
        $this->addSql('CREATE INDEX IDX_9B2C5E639395C3F3 ON customer_note (customer_id)');
        $this->addSql('CREATE INDEX IDX_9B2C5E6326ED0855 ON customer_note (note_id)');
        $this->addSql('DROP INDEX IDX_B7EF2F519395C3F3');
        $this->addSql('DROP INDEX IDX_B7EF2F512ADD6D8C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__customer_supplier AS SELECT customer_id, supplier_id FROM customer_supplier');
        $this->addSql('DROP TABLE customer_supplier');
        $this->addSql('CREATE TABLE customer_supplier (customer_id INTEGER NOT NULL, supplier_id INTEGER NOT NULL, PRIMARY KEY(customer_id, supplier_id))');
        $this->addSql('INSERT INTO customer_supplier (customer_id, supplier_id) SELECT customer_id, supplier_id FROM __temp__customer_supplier');
        $this->addSql('DROP TABLE __temp__customer_supplier');
        $this->addSql('CREATE INDEX IDX_B7EF2F519395C3F3 ON customer_supplier (customer_id)');
        $this->addSql('CREATE INDEX IDX_B7EF2F512ADD6D8C ON customer_supplier (supplier_id)');
        $this->addSql('DROP INDEX UNIQ_D34A04ADBDE4EC11');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, specifications_id, name, date_added, date_edited FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, specifications_id INTEGER NOT NULL, name VARCHAR(120) NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL)');
        $this->addSql('INSERT INTO product (id, specifications_id, name, date_added, date_edited) SELECT id, specifications_id, name, date_added, date_edited FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04ADBDE4EC11 ON product (specifications_id)');
        $this->addSql('DROP INDEX UNIQ_9B2A6C7EE7A1254A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__supplier AS SELECT id, contact_id, name, date_added, date_edited FROM supplier');
        $this->addSql('DROP TABLE supplier');
        $this->addSql('CREATE TABLE supplier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, contact_id INTEGER DEFAULT NULL, name VARCHAR(120) NOT NULL, date_added DATE NOT NULL, date_edited DATE NOT NULL)');
        $this->addSql('INSERT INTO supplier (id, contact_id, name, date_added, date_edited) SELECT id, contact_id, name, date_added, date_edited FROM __temp__supplier');
        $this->addSql('DROP TABLE __temp__supplier');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9B2A6C7EE7A1254A ON supplier (contact_id)');
        $this->addSql('DROP INDEX IDX_2DC822EF2ADD6D8C');
        $this->addSql('DROP INDEX IDX_2DC822EF6CC064FC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__supplier_broker AS SELECT supplier_id, broker_id FROM supplier_broker');
        $this->addSql('DROP TABLE supplier_broker');
        $this->addSql('CREATE TABLE supplier_broker (supplier_id INTEGER NOT NULL, broker_id INTEGER NOT NULL, PRIMARY KEY(supplier_id, broker_id))');
        $this->addSql('INSERT INTO supplier_broker (supplier_id, broker_id) SELECT supplier_id, broker_id FROM __temp__supplier_broker');
        $this->addSql('DROP TABLE __temp__supplier_broker');
        $this->addSql('CREATE INDEX IDX_2DC822EF2ADD6D8C ON supplier_broker (supplier_id)');
        $this->addSql('CREATE INDEX IDX_2DC822EF6CC064FC ON supplier_broker (broker_id)');
        $this->addSql('DROP INDEX IDX_CB0E6882ADD6D8C');
        $this->addSql('DROP INDEX IDX_CB0E6889395C3F3');
        $this->addSql('CREATE TEMPORARY TABLE __temp__supplier_customer AS SELECT supplier_id, customer_id FROM supplier_customer');
        $this->addSql('DROP TABLE supplier_customer');
        $this->addSql('CREATE TABLE supplier_customer (supplier_id INTEGER NOT NULL, customer_id INTEGER NOT NULL, PRIMARY KEY(supplier_id, customer_id))');
        $this->addSql('INSERT INTO supplier_customer (supplier_id, customer_id) SELECT supplier_id, customer_id FROM __temp__supplier_customer');
        $this->addSql('DROP TABLE __temp__supplier_customer');
        $this->addSql('CREATE INDEX IDX_CB0E6882ADD6D8C ON supplier_customer (supplier_id)');
        $this->addSql('CREATE INDEX IDX_CB0E6889395C3F3 ON supplier_customer (customer_id)');
        $this->addSql('DROP INDEX IDX_37D844602ADD6D8C');
        $this->addSql('DROP INDEX IDX_37D84460537A1329');
        $this->addSql('CREATE TEMPORARY TABLE __temp__supplier_message AS SELECT supplier_id, message_id FROM supplier_message');
        $this->addSql('DROP TABLE supplier_message');
        $this->addSql('CREATE TABLE supplier_message (supplier_id INTEGER NOT NULL, message_id INTEGER NOT NULL, PRIMARY KEY(supplier_id, message_id))');
        $this->addSql('INSERT INTO supplier_message (supplier_id, message_id) SELECT supplier_id, message_id FROM __temp__supplier_message');
        $this->addSql('DROP TABLE __temp__supplier_message');
        $this->addSql('CREATE INDEX IDX_37D844602ADD6D8C ON supplier_message (supplier_id)');
        $this->addSql('CREATE INDEX IDX_37D84460537A1329 ON supplier_message (message_id)');
        $this->addSql('DROP INDEX IDX_2E50CFD2ADD6D8C');
        $this->addSql('DROP INDEX IDX_2E50CFD26ED0855');
        $this->addSql('CREATE TEMPORARY TABLE __temp__supplier_note AS SELECT supplier_id, note_id FROM supplier_note');
        $this->addSql('DROP TABLE supplier_note');
        $this->addSql('CREATE TABLE supplier_note (supplier_id INTEGER NOT NULL, note_id INTEGER NOT NULL, PRIMARY KEY(supplier_id, note_id))');
        $this->addSql('INSERT INTO supplier_note (supplier_id, note_id) SELECT supplier_id, note_id FROM __temp__supplier_note');
        $this->addSql('DROP TABLE __temp__supplier_note');
        $this->addSql('CREATE INDEX IDX_2E50CFD2ADD6D8C ON supplier_note (supplier_id)');
        $this->addSql('CREATE INDEX IDX_2E50CFD26ED0855 ON supplier_note (note_id)');
        $this->addSql('DROP INDEX IDX_522F70B22ADD6D8C');
        $this->addSql('DROP INDEX IDX_522F70B24584665A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__supplier_product AS SELECT supplier_id, product_id FROM supplier_product');
        $this->addSql('DROP TABLE supplier_product');
        $this->addSql('CREATE TABLE supplier_product (supplier_id INTEGER NOT NULL, product_id INTEGER NOT NULL, PRIMARY KEY(supplier_id, product_id))');
        $this->addSql('INSERT INTO supplier_product (supplier_id, product_id) SELECT supplier_id, product_id FROM __temp__supplier_product');
        $this->addSql('DROP TABLE __temp__supplier_product');
        $this->addSql('CREATE INDEX IDX_522F70B22ADD6D8C ON supplier_product (supplier_id)');
        $this->addSql('CREATE INDEX IDX_522F70B24584665A ON supplier_product (product_id)');
        $this->addSql('DROP INDEX IDX_53AD8F834B89032C');
        $this->addSql('DROP INDEX IDX_53AD8F83F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__symfony_demo_comment AS SELECT id, post_id, author_id, content, published_at FROM symfony_demo_comment');
        $this->addSql('DROP TABLE symfony_demo_comment');
        $this->addSql('CREATE TABLE symfony_demo_comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, post_id INTEGER NOT NULL, author_id INTEGER NOT NULL, content CLOB NOT NULL, published_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO symfony_demo_comment (id, post_id, author_id, content, published_at) SELECT id, post_id, author_id, content, published_at FROM __temp__symfony_demo_comment');
        $this->addSql('DROP TABLE __temp__symfony_demo_comment');
        $this->addSql('CREATE INDEX IDX_53AD8F834B89032C ON symfony_demo_comment (post_id)');
        $this->addSql('CREATE INDEX IDX_53AD8F83F675F31B ON symfony_demo_comment (author_id)');
        $this->addSql('DROP INDEX IDX_58A92E65F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__symfony_demo_post AS SELECT id, author_id, title, slug, summary, content, published_at FROM symfony_demo_post');
        $this->addSql('DROP TABLE symfony_demo_post');
        $this->addSql('CREATE TABLE symfony_demo_post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, summary VARCHAR(255) NOT NULL, content CLOB NOT NULL, published_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO symfony_demo_post (id, author_id, title, slug, summary, content, published_at) SELECT id, author_id, title, slug, summary, content, published_at FROM __temp__symfony_demo_post');
        $this->addSql('DROP TABLE __temp__symfony_demo_post');
        $this->addSql('CREATE INDEX IDX_58A92E65F675F31B ON symfony_demo_post (author_id)');
        $this->addSql('DROP INDEX IDX_6ABC1CC44B89032C');
        $this->addSql('DROP INDEX IDX_6ABC1CC4BAD26311');
        $this->addSql('CREATE TEMPORARY TABLE __temp__symfony_demo_post_tag AS SELECT post_id, tag_id FROM symfony_demo_post_tag');
        $this->addSql('DROP TABLE symfony_demo_post_tag');
        $this->addSql('CREATE TABLE symfony_demo_post_tag (post_id INTEGER NOT NULL, tag_id INTEGER NOT NULL, PRIMARY KEY(post_id, tag_id))');
        $this->addSql('INSERT INTO symfony_demo_post_tag (post_id, tag_id) SELECT post_id, tag_id FROM __temp__symfony_demo_post_tag');
        $this->addSql('DROP TABLE __temp__symfony_demo_post_tag');
        $this->addSql('CREATE INDEX IDX_6ABC1CC44B89032C ON symfony_demo_post_tag (post_id)');
        $this->addSql('CREATE INDEX IDX_6ABC1CC4BAD26311 ON symfony_demo_post_tag (tag_id)');
    }
}
