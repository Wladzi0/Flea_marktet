<?php

namespace App\Controller\Admin;

use App\Entity\Advertisement;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AdvertisementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Advertisement::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            'name',
            'description',
            'contactName',
            'telNumber',
            'price',
            DateTimeField::new('createdAt')->onlyOnIndex(),
            'updatedAt',
        ];
    }

}
