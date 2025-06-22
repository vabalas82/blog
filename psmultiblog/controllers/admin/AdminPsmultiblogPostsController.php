<?php
require_once dirname(__FILE__).'/../../classes/PsmultiblogPost.php';

class AdminPsmultiblogPostsController extends ModuleAdminController
{
    /**
     * Compatibility wrapper for translation
     *
     * PrestaShop 9 removed the l() helper from controllers. This module
     * still uses the helper so we proxy calls to the module's translator.
     *
     * @param string $string
     * @return string
     */
    protected function l(string $string): string
    {
        return isset($this->module) ? $this->module->l($string, __CLASS__) : $string;
    }
    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = PsmultiblogPost::$definition['table'];
        $this->className = 'PsmultiblogPost';
        $this->lang = true;
        $this->identifier = PsmultiblogPost::$definition['primary'];

        parent::__construct();

        $this->fields_list = [
            'id_post' => ['title' => $this->l('ID'), 'width' => 20],
            'title' => ['title' => $this->l('Title')],
            'active' => ['title' => $this->l('Active'), 'active' => 'status', 'type' => 'bool'],
            'date_add' => ['title' => $this->l('Date Add')],
        ];
    }

    public function renderForm()
    {
        $this->fields_form = [
            'legend' => ['title' => $this->l('Post')],
            'input' => [
                ['type' => 'text', 'label' => $this->l('Title'), 'name' => 'title', 'lang' => true, 'required' => true],
                ['type' => 'text', 'label' => $this->l('Slug'), 'name' => 'slug', 'lang' => true],
                ['type' => 'textarea', 'autoload_rte' => true, 'label' => $this->l('Content'), 'name' => 'content', 'lang' => true],
                ['type' => 'text', 'label' => $this->l('Meta title'), 'name' => 'meta_title', 'lang' => true],
                ['type' => 'textarea', 'label' => $this->l('Meta description'), 'name' => 'meta_description', 'lang' => true],
                ['type' => 'switch', 'label' => $this->l('Enabled'), 'name' => 'active', 'values' => [
                    ['id' => 'active_on', 'value' => 1, 'label' => $this->l('Enabled')],
                    ['id' => 'active_off', 'value' => 0, 'label' => $this->l('Disabled')],
                ]],
            ],
            'submit' => ['title' => $this->l('Save')]
        ];

        return parent::renderForm();
    }
}