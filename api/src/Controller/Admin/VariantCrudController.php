<?php

namespace App\Controller\Admin;

use App\Entity\Variant;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class VariantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Variant::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['id' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            'ID',
            AssociationField::new('text1'),
            AssociationField::new('text2'),
            AssociationField::new('text3'),
            AssociationField::new('text4'),
            AssociationField::new('text5'),
            AssociationField::new('text6'),
            AssociationField::new('text7'),
            AssociationField::new('text8'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->disable(Action::NEW, Action::EDIT, Action::DELETE, Action::BATCH_DELETE, Action::SAVE_AND_ADD_ANOTHER, Action::SAVE_AND_CONTINUE, Action::SAVE_AND_RETURN)
            ;
    }
}
