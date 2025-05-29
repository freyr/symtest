<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Message\OrderCreated;

class OrderController extends AbstractController
{
    #[Route('/orders', name: 'order_index')]
    public function index(OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->findAll();
        return $this->render('order/index.html.twig', [
            'orders' => $orders,
        ]);
    }

    #[Route('/orders/new', name: 'order_new')]
    public function new(Request $request, EntityManagerInterface $em, MessageBusInterface $bus): Response
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $order->setCreatedAt(new \DateTimeImmutable());
            $em->persist($order);
            $em->flush();
            // Dispatch OrderCreated message
            $bus->dispatch(new OrderCreated('Order ID: ' . $order->getId()));
            $this->addFlash('success', 'Order created successfully!');
            return $this->redirectToRoute('order_index');
        }
        return $this->render('order/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
