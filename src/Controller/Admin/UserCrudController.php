<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): crud
    {
        return $crud
            ->setPageTitle("index", "User administration")
            ->setPaginatorPageSize(25);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            EmailField::new('email'),
            ChoiceField::new('roles')
                ->setChoices([
                    'Admin' => "ROLE_ADMIN",
                    'User'  => "ROLE_USER",
                ])
                ->setRequired(isRequired: true)
                ->allowMultipleChoices(),
            TextField::new('password')
                ->hideWhenUpdating()
                ->hideOnIndex(),
            TextField::new('firstname'),
            TextField::new('Lastname'),
            TextField::new('profession'),
        ];
    }
}
