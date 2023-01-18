<?php

namespace App\Controller\Admin;

use App\Entity\Idea;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class IdeaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Idea::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
