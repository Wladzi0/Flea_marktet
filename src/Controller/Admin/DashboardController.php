<?php

namespace App\Controller\Admin;

use App\Entity\Advertisement;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @IsGranted ("ROLE_ADMIN")
 *
 */
class DashboardController extends AbstractDashboardController
{

    /**
     * @Route("/admin", name="administration")
     *
     */
    public function index():Response
    {   $em=$this->getDoctrine()->getManager();
        $categories=$em->getRepository(Category::class)->findAll();
        $advertisements=$em->getRepository(Advertisement::class)->findAll();
        $users=$em->getRepository(User::class)->findAll();
        return $this->render('easyAdminBundle/welcome.html.twig',[
            'users'=>$users,
            'categories'=>$categories,
            'advertisements'=>$advertisements
        ]);
    }
//    public function configureAssets(): Assets
//    {
//        return Assets::new()
//            ->addCssFile('bundles/easyadmin/css/style.css');
//
//    }
//
//    public function configureUserMenu(UserInterface $user): UserMenu
//    {
//        return parent::configureUserMenu($user)
//            ->setName($user->getUsername())
//            ->displayUserName(true)
//            //->setAvatarUrl('https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909_1280.png')
//            //->setAvatarUrl($user->getProfileImageUrl())
//            ->displayUserAvatar(true)
//            ->setGravatarEmail($user->getUsername())
//
//            ->addMenuItems([
//                //MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
//            ]);
//    }

    /**
     * @return iterable
     */
    public function configureMenuItems(): iterable
    {   return [
        MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

        MenuItem::section('Content'),
        MenuItem::linkToCrud('Categories', 'fa fa-list', Category::class),

        MenuItem::linkToCrud('Advertisements', 'fa fa-file-text', Advertisement::class),
        MenuItem::linkToCrud('Comments', 'fa fa-comment', Comment::class),

        MenuItem::section('Persons'),
        MenuItem::linkToCrud('Users', 'fa fa-user', User::class),
    ];
    }
    public function configureUserMenu(UserInterface $user): UserMenu
    {
        // Usually it's better to call the parent method because that gives you a
        // user menu with some menu items already created ("sign out", "exit impersonation", etc.)
        // if you prefer to create the user menu from scratch, use: return UserMenu::new()->...
        return parent::configureUserMenu($user)
            // use the given $user object to get the user name
            ->setName($user->getFirstName())
            // use this method if you don't want to display the name of the user
            ->displayUserName(true)


            // use this method if you don't want to display the user image
            ->displayUserAvatar(true)
            // you can also pass an email address to use gravatar's service

            // you can use any type of menu item, except submenus
            ->addMenuItems([
                MenuItem::linkToRoute('My Profile', 'fa fa-id-card', '...', ['...' => '...']),
                MenuItem::linkToRoute('Settings', 'fa fa-user-cog', '...', ['...' => '...']),
                MenuItem::section(),
            ]);
    }
}
