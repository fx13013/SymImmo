<?php
namespace App\Controller\Admin;

use App\Entity\Picture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPictureController extends AbstractController
{
    /**
     * @Route("/admin/picture/delete/{id}", name="admin_picture_delete", methods="DELETE")
     */
    public function delete(Picture $picture, Request $request, EntityManagerInterface $manager)
    {
        $data = json_decode($request->getContent(), true);
        if($this->isCsrfTokenValid('delete' . $picture->getId(), $data['_token'])){
            $manager->remove($picture);
            $manager->flush();
            return new JsonResponse(['success' => 1]);
        }
        return new JsonResponse(['error' => 'Token invalid'], 400);
    }
}
