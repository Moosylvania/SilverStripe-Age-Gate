<?php
namespace Moosylvania\AgeGate\Controllers;

use PageController;
use SilverStripe\Control\Cookie;
use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\RequiredFields;

class AgeGateController extends PageController{
    /**
     * @config
     */
    private static $notOfAgeRedirect = 'https://google.com';

    /**
     * @config
     */
    private static $yearsOld = 21;

    /**
     * @config
     */
    private static $askForAge = false;

    /**
     * @config
     */
    private static $dateFormat = 'm/d/Y';

    /**
     * @config
     */
    private static $dateFieldFormat = 'MM/dd/yyyy';

    /**
     * @config
     */
    private static $customFormIntro = '';

    /**
     * @config
     */
    private static $customFieldLabel = '';

    private static $allowed_actions = [
        'AgeGateForm'
    ];

    protected function init()
    {
        parent::init();
        $age = Cookie::get('moosylvaniaAgeGateOfAge');
        $request = Injector::inst()->get(HTTPRequest::class);
        $session = $request->getSession();
        if($age || $session->get('isSearhEngine')){
            if($session->get('AgeGateBackURL') && strpos($session->get('AgeGateBackURL'), '/age-gate') !== 0){
                return $this->redirect($session->get('AgeGateBackURL'));
            } else {
                return $this->redirect('/');
            }
        }
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
        $timestring = "-".$this->config()->get('yearsOld')." years";
        $t = strtotime($timestring, time());
        $formIntro = '<h1>'._t('MoosylvaniaAgeGate.FORMINTRO', 'Born Before {date}', ['date'=>date($this->config()->get('dateFormat'), $t)]).'</h1>';
        if($this->config()->get('customFormIntro')){
            $formIntro = '<h1>'.$this->config()->get('customFormIntro').'</h1>';
        }
        $fields = new FieldList(
            LiteralField::create('OfAge', $formIntro)
        );

        $fieldLabel = _t('MoosylvaniaAgeGate.FIELDLABEL', 'Your Birthdate');
        if($this->config()->get('customFieldLabel')){
            $fieldLabel = $this->config()->get('customFieldLabel');
        }

        if($this->config()->get('askForAge')){
            $fields->push($dateField = DateField::create('birthdate', $fieldLabel)
                ->setMaxDate($timestring)
                ->setHTML5(false)
                ->setDateFormat($this->config()->get('dateFieldFormat'))
            );

            $dateField->setDescription(_t(
                'FormField.Example',
                'e.g. {format}',
                [ 'format' =>  $dateField->getDateFormat() ]
            ));

            $actions = new FieldList(
                FormAction::create('doAgeValidation', 'Submit')
            );

            $required = new RequiredFields('birthdate');

            $form = new Form($this, 'AgeGateForm', $fields, $actions, $required);
        } else {
            $actions = new FieldList(
                FormAction::create('doOfAge', 'Yes'),
                FormAction::create('doNotOfAge', 'No')
            );

            $form = new Form($this, 'AgeGateForm', $fields, $actions);

            $form->setValidationExemptActions(['doOfAge', 'doONotfAge']);
        }

        return $form;
    }

    protected function setOfAgeCookie(){
        Cookie::set('moosylvaniaAgeGateOfAge', true, 30);
        $request = Injector::inst()->get(HTTPRequest::class);
        $session = $request->getSession();
        if($session->get('AgeGateBackURL')){
            return $this->redirect($session->get('AgeGateBackURL'));
        } else {
            return $this->redirect('/');
        }
    }

    public function doOfAge($data, Form $form)
    {
        $this->setOfAgeCookie();
    }

    public function doAgeValidation($data, Form $form)
    {
        $this->setOfAgeCookie();
    }

    public function doNotOfAge($data, Form $form)
    {
        return $this->redirect($this->config()->get('notOfAgeRedirect'));
    }
}
