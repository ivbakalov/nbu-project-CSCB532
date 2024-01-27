<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Survey;
use App\Entity\TextEntry;
use App\Entity\Variant;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(SurveyCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Surveys Dashboard');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToCrud('Surveys', 'fa fa-pencil', Survey::class),
            MenuItem::linkToCrud('Variants', 'fa fa-spinner', Variant::class),
            MenuItem::linkToCrud('Texts', 'fa fa-book', TextEntry::class),
            MenuItem::linkToCrud('Users', 'fa fa-user', User::class),
        ];
    }
}
