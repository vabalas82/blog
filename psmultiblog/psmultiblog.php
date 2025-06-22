<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

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
            && $this->registerHook('displayHome')
            && $this->registerHook('moduleRoutes');
    }

    public function uninstall()
    {
        return parent::uninstall() && $this->uninstallDB();
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
