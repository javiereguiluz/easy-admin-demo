<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductCrudController extends AbstractCrudController
{
    private $params;

    public function __construct(ParameterBagInterface $params) {
        $this->params = $params;
    }

    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Product')
            ->setEntityLabelInPlural('Products')
            ->setSearchFields(['id', 'tags', 'ean', 'image', 'features', 'price', 'name', 'description']);
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name');
        $description = TextareaField::new('description');
        $categories = AssociationField::new('categories');
        $ean = TextField::new('ean');
        $price = NumberField::new('price')->addCssClass('text-right');
        $enabled = BooleanField::new('enabled');
        $createdAt = DateTimeField::new('createdAt');
        $features = ArrayField::new('features');
        $tags = ArrayField::new('tags');
        $id = IntegerField::new('id', 'ID');
        $image = ImageField::new('image')->setBasePath('uploads/images/products')->setUploadDir($this->params->get('app.upload_dest'));
        $imageFile = Field::new('imageFile')->setFormType(VichImageType::class);

        if (Crud::PAGE_INDEX === $pageName) {
            return [$id, $enabled, $name, $price, $ean, $image, $createdAt->setFormat('short', 'short'), $tags];
        }

        return [
            FormField::addPanel('Basic information'),
            $name, $description, $categories->autocomplete(),
            FormField::addPanel('Product Details'),
            $ean, $price, $enabled, $createdAt,
            FormField::addPanel(),
            $features,
            FormField::addPanel(),
            $tags,
            FormField::addPanel('Attachments'),
            $imageFile,
        ];
    }
}
