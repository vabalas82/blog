<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

require_once __DIR__.'/classes/PsmultiblogPost.php';

class Psmultiblog extends Module
{
    public function __construct()
    {
        $this->name = 'psmultiblog';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'AI';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->l('Multi Blog');
        $this->description = $this->l('Multilanguage blog module with SEO features.');
    }

    public function install()
    {
        return parent::install()
            && $this->installDB()
            && $this->installTab()
            && $this->registerHook('displayHome')
            && $this->registerHook('moduleRoutes');
    }

    public function uninstall()
    {
        return parent::uninstall()
            && $this->uninstallDB()
            && $this->uninstallTab();
    }

    private function installDB()
    {
        include dirname(__FILE__).'/install.sql';
        foreach ($sql as $s) {
            if (!Db::getInstance()->execute($s)) {
                return false;
            }
        }
        return true;
    }

    private function installTab()
    {
        if (Tab::getIdFromClassName('AdminPsmultiblogPosts')) {
            return true;
        }
        $tab = new Tab();
        $tab->class_name = 'AdminPsmultiblogPosts';
        $tab->module = $this->name;
        $tab->id_parent = (int)Tab::getIdFromClassName('IMPROVE');
        foreach (Language::getLanguages(false) as $lang) {
            $tab->name[$lang['id_lang']] = $this->l('Blog Posts');
        }
        return $tab->add();
    }

    private function uninstallDB()
    {
        include dirname(__FILE__).'/uninstall.sql';
        foreach ($sql as $s) {
            if (!Db::getInstance()->execute($s)) {
                return false;
            }
        }
        return true;
    }

    private function uninstallTab()
    {
        $id_tab = (int)Tab::getIdFromClassName('AdminPsmultiblogPosts');
        if ($id_tab) {
            $tab = new Tab($id_tab);
            return $tab->delete();
        }
        return true;
    }

    public function hookDisplayHome()
    {
        $posts = PsmultiblogPost::getPosts($this->context->language->id, 0, 5);
        $this->context->smarty->assign('psmultiblog_posts', $posts);
        return $this->display(__FILE__, 'views/templates/front/displayPosts.tpl');
    }

    public function hookModuleRoutes()
    {
        return [
            'module-psmultiblog-post' => [
                'controller' => 'post',
                'rule' => 'blog/{rewrite}',
                'keywords' => [
                    'rewrite' => ['regexp' => '[_a-zA-Z0-9\-]+', 'param' => 'rewrite'],
                ],
                'params' => [
                    'fc' => 'module',
                    'module' => 'psmultiblog',
                ],
            ],
        ];
    }

    public function getContent()
    {
        $link = $this->context->link->getAdminLink('AdminPsmultiblogPosts');
        return '<a href="'.$link.'">'.$this->l('Manage Posts').'</a>';
    }
}