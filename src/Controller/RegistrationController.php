<?php


namespace App\Controller;


use App\Entity\User;
use App\Event\UserRegisteredEvent;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{

    private $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @Route("/register", name="user_registration")
     */
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (\is_object($this->getUser())) {
            return $this->redirectToRoute('homepage');
        }

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($user);
            $entityManager->flush();
            $this->dispatcher->dispatch(UserRegisteredEvent::NAME, new UserRegisteredEvent($request, $user));

            return $this->redirectToRoute('homepage');
        }

        return $this->render(
            'registration/register.html.twig', [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/email/confirm/{confirmationToken}", name="email.confirm")
     */
    public function confirmEmail(User $user, EntityManagerInterface $em): RedirectResponse
    {
        $user
            ->clearConfirmationToken()
            ->setConfirmedAt(new \DateTime());

        $em->flush();
        $this->addFlash('success', 'flash.user.email_confirmed');

        return $this->redirectToRoute('homepage');
    }


}