<?php
namespace Moosylvania\AgeGate\Controllers;

use PageController;
use SilverStripe\Control\Cookie;
use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\LiteralField;

class AgeGateController extends PageController{
    /**
     * @config
     */
    private static $notOfAgeRedirect = 'https://google.com';

    private static $allowed_actions = [
        'AgeGateForm'
    ];

    protected function init()
    {
        $age = Cookie::get('moosylvaniaAgeGateOfAge');
        $request = Injector::inst()->get(HTTPRequest::class);
        $session = $request->getSession();
        if($age || $session->get('isSearhEngine')){
            if($session->get('AgeGateBackURL')){
                return $this->redirect($session->get('AgeGateBackURL'));
            } else {
                return $this->redirect('/');
            }
        }
        parent::init();
    }

    public function Link($action=NULL){
        return Controller::join_links(BASE_URL, "age-gate", $action);
    }

    public function index()
    {
        return $this->render();
    }

    public function AgeGateForm()
    {
        $t = strtotime("-21 year", time());

        $fields = new FieldList(
            LiteralField::create('OfAge', '<h1>Born Before '.date('m/d/Y', $t).'</h1>')
        );

        $actions = new FieldList(
            FormAction::create('doOfAge', 'Yes'),
            FormAction::create('doNotOfAge', 'No')
        );

        $form = new Form($this, 'AgeGateForm', $fields, $actions);

        $form->setValidationExemptActions(['doOfAge', 'doONotfAge']);

        return $form;
    }

    public function doOfAge($data, Form $form)
    {
        Cookie::set('moosylvaniaAgeGateOfAge', true, 30);
        $request = Injector::inst()->get(HTTPRequest::class);
        $session = $request->getSession();
        if($session->get('AgeGateBackURL')){
            return $this->redirect($session->get('AgeGateBackURL'));
        } else {
            return $this->redirect('/');
        }
    }

    public function doNotOfAge($data, Form $form)
    {
        return $this->redirect($this->config()->get('notOfAgeRedirect'));
    }
}
