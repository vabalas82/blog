<?php
$sql = [];
$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'psmultiblog_post` (
    `id_post` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `active` TINYINT(1) NOT NULL DEFAULT 1,
    `date_add` DATETIME NOT NULL,
    `date_upd` DATETIME NOT NULL,
    PRIMARY KEY (`id_post`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8mb4';

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'psmultiblog_post_lang` (
    `id_post` INT UNSIGNED NOT NULL,
    `id_lang` INT UNSIGNED NOT NULL,
    `id_shop` INT UNSIGNED NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `content` LONGTEXT NULL,
    `meta_title` VARCHAR(255) NULL,
    `meta_description` VARCHAR(512) NULL,
    PRIMARY KEY (`id_post`, `id_lang`, `id_shop`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8mb4';
