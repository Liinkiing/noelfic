<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class RegistrationController extends AbstractController
{

    private $tokenStorage;
    private $dispatcher;
    private $session;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        EventDispatcherInterface $dispatcher,
        SessionInterface $session
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->dispatcher = $dispatcher;
        $this->session = $session;
    }

    /**
     * @Route("/register", name="user_registration")
     */
    public function register(Request $request, EntityManagerInterface $entityManager)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($user);
            $entityManager->flush();
            $this->authenticateUser($request, $user);
            $this->addFlash('success', 'registration.successful');
            return $this->redirectToRoute('homepage');
        }

        return $this->render(
            'registration/register.html.twig', [
                'form' => $form->createView()
            ]
        );
    }

    protected function authenticateUser(Request $request, UserInterface $user, string $provider = 'main'): void
    {
        $token = new UsernamePasswordToken($user, null, $provider, $user->getRoles());
        $this->tokenStorage->setToken($token);
        $this->session->set("_security_$provider", \serialize($token));
        $this->dispatcher->dispatch('security.interactive_login', new InteractiveLoginEvent($request, $token));
    }


}