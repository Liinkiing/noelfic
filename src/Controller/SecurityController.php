<?php


namespace App\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends BaseController
{

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if (\is_object($this->getUser())) {
            return $this->redirectToRoute('homepage');
        }

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(): void
    {

    }

    /**
     * @Route("/get_api_token", name="get_api_token")
     */
    public function getApiToken(AuthorizationCheckerInterface $checker, JWTTokenManagerInterface $manager): JsonResponse
    {
        if(!$checker->isGranted('ROLE_USER')) {
            return $this->json(['message' => 'You must be authenticated to get a valid token.'], 403);
        }

        $user = $this->getUser();
        $token = $manager->create($user);

        return $this->json(compact('token'));
    }


}