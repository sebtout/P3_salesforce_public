<?php

namespace App\Controller\Admin;

use App\Entity\Idea;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class IdeaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Idea::class;
    }

    public function configureCrud(Crud $crud): crud
    {
        return $crud
            ->setPageTitle("index", "Idea administration")
            ->setPaginatorPageSize(15);
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('title'),
            TextEditorField::new('content')
                ->setNumOfRows(5),
            ChoiceField::new('status')
                ->setChoices([
                    'in progress' => 'in progress',
                    'complete' => 'complete',
                ])
        ];
    }
}
