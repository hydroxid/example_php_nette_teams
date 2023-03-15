<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;


final class PersonPresenter extends BasePresenter
{
    public const TYPES = [
        'Závodník' => 'Závodník',
        'Spolujezdec' => 'Spolujezdec',
        'Technik' => 'Technik',
        'Manažer' => 'Manažer',
        'Fotograf' => 'Fotograf',
    ];

    /**
    * default (index)
    *
    * @return void
    * @author hydroxid
    */
    public function renderDefault() : void
    {
        // find all persons
        $this->template->rows = $this->personsRepository->findAll();
    }

    /**
    * person form - builder
    *
    * @return Nette\Application\UI\Form
    * @author hydroxid
    */
    protected function createComponentPersonForm() : Nette\Application\UI\Form
    {
        $form = new Form;

        $id = $this->getParameter('u_id');

        $form->addText('p_name', 'Jméno')
        ->addRule(Form::MIN_LENGTH, 'Jméno musí mít alespoň %d znaků', 2)
        ->addRule(Form::MAX_LENGTH, 'Jméno musí mít max %d znaků', 50)
        ->addRule(Form::PATTERN, 'Jméno obsahuje nepovolené znaky.', '[a-zA-ZáčďéěíňóřšťůúýžÁČĎÉĚÍŇÓŘŠŤŮÚÝŽäöüÄÖÜ]+[ \-]?')
        ->setHtmlAttribute('class', 'form-control')
        ->setRequired('Jméno je povinné');

        $form->addText('p_surname', 'Příjmení')
        ->addRule(Form::MIN_LENGTH, 'Příjmení musí mít alespoň %d znaků', 2)
        ->addRule(Form::MAX_LENGTH, 'Příjmení musí mít max %d znaků', 50)
        ->addRule(Form::PATTERN, 'Příjmení obsahuje nepovolené znaky.', '[a-zA-ZáčďéěíňóřšťůúýžÁČĎÉĚÍŇÓŘŠŤŮÚÝŽäöüÄÖÜ]+[ \-]?')
        ->setHtmlAttribute('class', 'form-control')
        ->setRequired('Příjmení je povinné');

        $form->addSelect('p_type', 'Typ', self::TYPES)
        ->setHtmlAttribute('class', 'form-control')
        ->setPrompt('Zvolte')
        ->setRequired('Typ je povinný');

        $form->addProtection();

        $form->addSubmit('send', 'Uložit')
        ->setHtmlAttribute('class', 'btn btn-primary');

        $form->onSuccess[] = [$this, 'personFormSucceeded'];

        return $form;
    }

    /**
    * person form - process
    *
    * @param Form $form form data
    * @param array $values values from form
    * @return void
    * @author hydroxid
    */
    public function personFormSucceeded(Form $form, Nette\Utils\ArrayHash $values) : void
    {
        $r = $this->db->table('persons')->insert($values);
        $this->flashMessage('Záznam přidán', 'success');
        $this->redirect('Person:');
    }
}
