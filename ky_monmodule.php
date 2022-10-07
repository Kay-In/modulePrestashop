<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class Ky_MonModule extends Module
{
    public function __construct()
    {
        $this->name = 'ky_monmodule';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Kay_In';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.7',
            'max' => _PS_VERSION_
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Module Kay_In');
        $this->description = $this->l("Module de test");

        $this->confirmUninstall = $this->l('Etes vous sur de vouloir désinstaller ce module?');

        if (!Configuration::get('KY_MONMODULE_PAGENAME')) {
            $this->warning = $this->l('Aucun nom fourni');
        }
    }

    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        if (
            !parent::install() ||
            !$this->registerHook('header') ||
            !Configuration::updateValue('KY_MONMODULE_PAGENAME', 'La boutique JARDITOU:le coin des jardiniers en herbes  ')
        ) {
            return false;
        }
        return true;
    }

    public function uninstall()
    {
        if (
            !parent::uninstall() ||
            !Configuration::deleteByName('KY_MONMODULE_PAGENAME')
        ) {
            return false;
        }
        return true;
    }

    public function getContent()
    {
        $output = null;

        if (Tools::isSubmit('btnSubmit')) {
            $pageName = strval(Tools::getValue('KY_MONMODULE_PAGENAME'));

            if (
                !$pageName ||
                empty($pageName)
            ) {
                $output .= $this->displayError($this->l('Invalid Configuration Value'));
            } else {
                Configuration::updateValue('KY_MONMODULE_PAGENAME', $pageName);
                $output .= $this->displayConfirmation($this->l('Settings Updated'));
            }
        }

        return $output . $this->displayForm();
    }

    public function displayForm()
    {
        //Récupere la langue par défaut
        $defaultLang = (int)Configuration::get('PS_LANG_DEFAULT');

        //Initialise les champs du formulaire dans un tableau
        $form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Configuration value'),
                        'name' => 'KY_MONMODULE_PAGENAME',
                        'size' => 20,
                        'required' => true
                    )
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'name' => 'btnSubmit'
                )
            )
        );

        $helper = new HelperForm();

        //Module,token et currentIndex
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;

        //Langue
        $helper->default_form_language = $defaultLang;

        //Charge la valeur de KY_MONMODULE_PAGENAME depuis la base de données
        $helper->fields_value['KY_MONMODULE_PAGENAME'] = Configuration::get('KY_MONMODULE_PAGENAME');

        return $helper->generateForm(array($form));
    }


    public function hookDisplayHeader()
    {
        $this->context->smarty->assign([
            'ns_page_name' => Configuration::get('KY_MONMODULE_PAGENAME'),
        ]);

        return $this->display(__FILE__, 'ky_monmodule.tpl');

        $this->context->controller->registerStylesheet(
            'ky_monmodule',
            $this->_path . 'views/css/ky_monmodule.css',
            [
                'server' => 'remote',
                'position' => 'head',
                'priority' => 150
            ]
        );
    }
}
