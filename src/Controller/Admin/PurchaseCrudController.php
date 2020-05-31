<?php

namespace App\Controller\Admin;

use App\Entity\Purchase;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class PurchaseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Purchase::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Purchase')
            ->setEntityLabelInPlural('Purchase')
            ->setSearchFields(['id', 'guid', 'billingAddress']);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable('delete');
    }

    public function configureFields(string $pageName): iterable
    {
        $deliveryDate = DateField::new('deliveryDate');
        $deliveryHour = TimeField::new('deliveryHour')->setFormat('short');
        $billingAddress = TextareaField::new('billingAddress');
        $guid = TextField::new('guid');
        $buyer = AssociationField::new('buyer');
        $id = TextField::new('id', 'ID');
        $createdAt = DateTimeField::new('createdAt');
        $purchasedItems = AssociationField::new('purchasedItems');
        $total = NumberField::new('total')->setNumDecimals(2);

        if (Crud::PAGE_INDEX === $pageName) {
            return [$guid->setMaxLength(7), $buyer, $deliveryDate, $deliveryHour, $billingAddress, $purchasedItems, $total];
        }

        return [
            FormField::addPanel('Delivery Details'),
            $deliveryDate, $deliveryHour, $billingAddress,
            FormField::addPanel('Purchase Details'),
            $createdAt->onlyOnDetail(), $id->onlyOnDetail(), $guid, $buyer, $purchasedItems->onlyOnDetail()
        ];
    }
}
