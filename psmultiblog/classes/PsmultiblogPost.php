<?php

class PsmultiblogPost extends ObjectModel
{
    public $id_post;
    public $active = 1;
    public $date_add;
    public $date_upd;

    // Multilang fields
    public $title;
    public $slug;
    public $content;
    public $meta_title;
    public $meta_description;

    public static $definition = [
        'table' => 'psmultiblog_post',
        'primary' => 'id_post',
        'multilang' => true,
        'fields' => [
            'active' => ['type' => self::TYPE_BOOL, 'validate' => 'isBool'],
            'date_add' => ['type' => self::TYPE_DATE],
            'date_upd' => ['type' => self::TYPE_DATE],
            // Lang fields
            'title' => ['type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 255],
            'slug' => ['type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isLinkRewrite', 'size' => 255],
            'content' => ['type' => self::TYPE_HTML, 'lang' => true, 'validate' => 'isCleanHtml'],
            'meta_title' => ['type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 255],
            'meta_description' => ['type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'size' => 512],
        ],
    ];

    public static function getPosts($id_lang, $start = 0, $limit = null)
    {
        $sql = 'SELECT p.*, pl.* FROM '._DB_PREFIX_.'psmultiblog_post p '
            .'JOIN '._DB_PREFIX_.'psmultiblog_post_lang pl ON p.id_post = pl.id_post '
            .'AND pl.id_lang = '.(int)$id_lang.' WHERE p.active = 1 '
            .'ORDER BY p.date_add DESC';
        if ($limit) {
            $sql .= ' LIMIT '.(int)$start.', '.(int)$limit;
        }
        return Db::getInstance()->executeS($sql);
    }

    public static function getBySlug($slug, $id_lang)
    {
        $sql = 'SELECT p.*, pl.* FROM '._DB_PREFIX_.'psmultiblog_post p '
            .'JOIN '._DB_PREFIX_.'psmultiblog_post_lang pl ON p.id_post = pl.id_post '
            .'AND pl.id_lang = '.(int)$id_lang.' WHERE pl.slug = "'.pSQL($slug).'"';
        return Db::getInstance()->getRow($sql);
    }
}