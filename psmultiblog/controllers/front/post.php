<?php
require_once dirname(__FILE__).'/../../classes/PsmultiblogPost.php';

class PsmultiblogPostModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        $rewrite = Tools::getValue('rewrite');
        $post = PsmultiblogPost::getBySlug($rewrite, $this->context->language->id);
        if (!$post) {
            Tools::redirect('index.php');
        }
        $this->context->smarty->assign('post', $post);
        $this->setTemplate('module:psmultiblog/views/templates/front/post.tpl');
        if (!empty($post['meta_title'])) {
            $this->context->smarty->assign('meta_title', $post['meta_title']);
        }
        if (!empty($post['meta_description'])) {
            $this->context->smarty->assign('meta_description', $post['meta_description']);
        }
    }
}