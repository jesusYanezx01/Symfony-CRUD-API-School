<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/create', name: 'create_user', methods: 'POST')]
    public function createUser(UserRepository $userRepository,RoleRepository $roleRepository, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setName($data['name']);
        $user->setLastName($data['lastName']);
        $user->setPhone($data['phone']);
        $user->setPassword($data['password']);

        $role= $roleRepository->find($data['rolId']);

        if(!$role){
            return $this->json(['error' => 'El rol especificado no existe'], 400);
        }

        $user->setRole($role);

        try {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->json(['message' => 'Usuario creado correctamente'], 201);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Error al crear el usuario'], 400);
        }
    }

    #[Route('/user/get', name: 'get_users', methods: 'GET')]
    public function getUsers(UserRepository $userRepository, RoleRepository $roleRepository): JsonResponse
    {

        $users = $userRepository->findAll();

        $usersArray = [];
        foreach($users as $user){
            $roleName = null;

            if ($user->getRole() !== null) {
                $roleName = $user->getRole()->getName();
            }
            $usersArray[]= [
                'name' => $user->getName(),
                'lastName' => $user->getLastName(),
                'phone' => $user->getPhone(),
                'role' => $roleName
            ];
        }

        return $this->json($usersArray);
    }

    #[Route('/user/get/{id}', name: 'get_user_by_id', methods: 'GET')]
    public function getUserById(UserRepository $userRepository, int $id): JsonResponse
    {
        $user = $userRepository->find($id);
        if (!$user) {
            return $this->json(['error' => 'Usuario no encontrado'], 404);
        }

        $roleName = null;

        if ($user->getRole() !== null) {
            $roleName = $user->getRole()->getName();
        }

        $userData= [
            'name' => $user->getName(),
            'lastName' => $user->getLastName(),
            'phone' => $user->getPhone(),
            'rol' => $roleName
        ];


        return $this->json($userData);
    }

    #[Route('/user/delete/{id}', name: 'delete_user_by_id', methods: 'DELETE')]
    public function deleteUserById(UserRepository $userRepository, int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $userRepository->find($id);
        if (!$user) {
            return $this->json(['error' => 'Usuario no encontrado'], 404);
        }

        $entityManager->remove($user);
        $entityManager->flush();


        return $this->json(['message' => 'Usuario eliminado correctamente']);
    }
}
