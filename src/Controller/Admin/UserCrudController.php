<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Customer')
            ->setEntityLabelInPlural('Customers')
            ->setSearchFields(['id', 'username', 'email', 'contract']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield FormField::addPanel('Account Information');
        yield IntegerField::new('id', 'ID')->onlyOnIndex();
        yield BooleanField::new('active');
        yield TextField::new('username');
        yield TextField::new('email');

        yield FormField::addPanel('Legal Information');
        yield TextField::new('contract')->setTemplatePath('admin/user/contract.html.twig');

        yield FormField::addPanel('Transactions History');
        yield AssociationField::new('purchases')->autocomplete();
    }
}
