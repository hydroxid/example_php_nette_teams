<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;


final class TeamPresenter extends BasePresenter
{
    /**
    * default (index)
    *
    * @return void
    * @author hydroxid
    */
    public function renderDefault() : void
    {
        // find all teams
        $this->template->rows = $this->teamsRepository->findAll();
    }

    /**
    * show (detail)
    *
    * @param int $id team id
    * @return void
    * @author hydroxid
    */
    public function renderShow(int $id) : void
    {
        // find one team
        $this->template->r = $this->teamsRepository->findOne($id);
    }

    /**
    * team form - builder
    *
    * @return Nette\Application\UI\Form
    * @author hydroxid
    */
    protected function createComponentTeamForm() : Nette\Application\UI\Form
    {
        $form = new Form;

        $form->addText('t_name', 'Název')
        ->addRule(Form::MIN_LENGTH, 'Název musí mít alespoň %d znaků', 2)
        ->addRule(Form::MAX_LENGTH, 'Název musí mít max %d znaků', 200)
        ->setHtmlAttribute('class', 'form-control')
        ->setRequired('Název je povinný');

        $form->addMultiSelect('zavodnik', 'Závodník',
            $this->personsRepository->findAllByType('Závodník'))
        ->addRule(Form::MIN_LENGTH, 'Závodník: Min. je třeba zvolit %d osobu', 1)
        ->addRule(Form::MAX_LENGTH, 'Závodník: Max. je třeba zvolit %d osoby', 3)
        ->setHtmlAttribute('style', 'height: 9em')
        ->setHtmlAttribute('class', 'form-control')
        ->setRequired('Zvolte závodníka');

        $form->addMultiSelect('spolujezdec', 'Spolujezdec',
            $this->personsRepository->findAllByType('Spolujezdec'))
        ->addRule(Form::MIN_LENGTH, 'Spolujezdec: Min. je třeba zvolit %d osobu', 1)
        ->addRule(Form::MAX_LENGTH, 'Spolujezdec: Max. je třeba zvolit %d osoby', 3)
        ->setHtmlAttribute('style', 'height: 9em')
        ->setHtmlAttribute('class', 'form-control')
        ->setRequired('Zvolte spolujezdce');

        $form->addMultiSelect('technik', 'Technik',
            $this->personsRepository->findAllByType('Technik'))
        ->addRule(Form::MIN_LENGTH, 'Technik: Min. je třeba zvolit %d osobu', 1)
        ->addRule(Form::MAX_LENGTH, 'Technik: Max. je třeba zvolit %d osoby', 2)
        ->setHtmlAttribute('style', 'height: 9em')
        ->setHtmlAttribute('class', 'form-control')
        ->setRequired('Zvolte technika');

        $form->addMultiSelect('manazer', 'Manažer',
            $this->personsRepository->findAllByType('Manažer'))
        ->addRule(Form::MIN_LENGTH, 'Manažer: Min. je třeba zvolit %d osobu', 1)
        ->addRule(Form::MAX_LENGTH, 'Manažer: Max. je třeba zvolit %d osobu', 1)
        ->setHtmlAttribute('style', 'height: 9em')
        ->setHtmlAttribute('class', 'form-control')
        ->setRequired('Zvolte manažera');

        $form->addMultiSelect('fotograf', 'Fotograf',
            $this->personsRepository->findAllByType('Fotograf'))
        ->addRule(Form::MAX_LENGTH, 'Fotograf: Max. je třeba zvolit %d osobu', 1)
        ->setHtmlAttribute('style', 'height: 9em')
        ->setHtmlAttribute('class', 'form-control')
        ->setRequired(false);

        $form->addProtection();

        $form->addSubmit('send', 'Uložit')
        ->setHtmlAttribute('class', 'btn btn-primary');

        $form->onSuccess[] = [$this, 'teamFormSucceeded'];

        return $form;
    }

    /**
    * team form - process
    *
    * @param Form $form form data
    * @param array $values values from form
    * @return void
    * @author hydroxid
    */
    public function teamFormSucceeded(Form $form, Nette\Utils\ArrayHash $values) : void
    {
        // insert team
        $r = $this->db->table('teams')->insert(['t_name' => $values->t_name]);

        foreach ($values->zavodnik as $z) {
            $this->db->table('persons_teams')->insert([
                'pt_p_id'   => $z,
                'pt_t_id'   => $r->t_id,
            ]);
        }

        foreach ($values->spolujezdec as $z) {
            $this->db->table('persons_teams')->insert([
                'pt_p_id'   => $z,
                'pt_t_id'   => $r->t_id,
            ]);
        }

        foreach ($values->technik as $z) {
            $this->db->table('persons_teams')->insert([
                'pt_p_id'   => $z,
                'pt_t_id'   => $r->t_id,
            ]);
        }

        foreach ($values->manazer as $z) {
            $this->db->table('persons_teams')->insert([
                'pt_p_id'   => $z,
                'pt_t_id'   => $r->t_id,
            ]);
        }

        foreach ($values->fotograf as $z) {
            $this->db->table('persons_teams')->insert([
                'pt_p_id'   => $z,
                'pt_t_id'   => $r->t_id,
            ]);
        }

        $this->flashMessage('Záznam přidán', 'success');
        $this->redirect('Team:');
    }
}
