<?php

namespace App\Controller;

use App\Entity\Broker;
use App\Entity\Customer;
use App\Entity\Message;
use App\Entity\Product;
use App\Entity\Supplier;
use App\Form\BrokerType;
use App\Form\BrokersEmbeddedFormType;
use App\Form\CustomerType;
use App\Form\DataTransformer\BrokerArrayToStringTransformer;
use App\Form\MessageType;

use App\Form\SupplierType;
use App\Repository\BrokerRepository;
use App\Repository\CustomerRepository;
use App\Repository\MessageRepository;
use App\Repository\ProductRepository;
use App\Repository\SupplierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/message")
 */
class MessageController extends AbstractController
{
    /**
     * @Route("/", name="message_index", methods={"GET"})
     * @Route("/page/{page<[1-9]\d*>}", defaults={"page":"1", "_format"="html"}, methods="GET", name="message_index_paginated")
     */
    public function index(Request $_request, int $page = 1, string $_format="html", MessageRepository $repository): Response
    {
        $pageData = $repository->findLatest($page);

        return $this->render('message/index.'.$_format.'.twig', [            
            'paginator'=>$pageData,
            'broker'=>$this->getUser()->getBroker()
        ]);
    }

    /**
     * @Route("/new", name="message_new", methods={"GET","POST"})
     * @Route("/new", name="message_new_no_id", methods={"GET","POST"})
     */
    public function new(
        Request $request, 
        BrokerRepository $brokerRepo,
        CustomerRepository $customerRepo,        
        SupplierRepository $supplierRepo
        ): Response
        {

            $message = new Message();   
            $message->setSentBy($this->getUser()->getBroker()->getName());
            $message->setBrokerId($this->getUser()->getBroker()->getId());
    
            $this->getUser()->getBroker()->addMessage($message);
/*             $brokerSelection = $brokerRepo->findWithoutId($this->getUser()->getBroker()->getId());
            $customerSelection = $customerRepo->findAll();
            $supplierSelection = $supplierRepo->findAll();
            
            dump($brokerSelection); */

            $form = $this->createForm(MessageType::class,$message,
                array('brokerSelection'=>$brokerRepo->findWithoutId($this->getUser()->getBroker()->getId()),
                      'customerSelection'=>$customerRepo->findAll(),
                      'supplierSelection'=>$supplierRepo->findAll()));  
            
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()) {            
                
                $entityManager = $this->getDoctrine()->getManager();
                
                $message->setBrokers($form->brokerSelection);
                $message->setCustomers($form->customerSelection);
                $message->setSuppliers($form->supplierSelection);
                $entityManager->persist($this->getUser()->getBroker());   
                $entityManager->flush();
                return $this->redirectToRoute('broker_edit', array('id'=>$this->getUser()->getBroker()->getId()));
            }

            return $this->render('message/new.html.twig' , [
                'form' => $form->createView(),
                'brokers'=>$message->getBrokers(),
                'customers'=>$message->getCustomers(),
                'suppliers'=>$message->getSuppliers(),
                'broker_id'=>$this->getUser()->getBroker()->getId(),
                'edit_state'=>true,
                'fresh_state'=>false,
                // 'broker_id'=>$this->getUser()->getBroker()->getId()
            ]);
    }

    /**
     * @Route("/{id}", name="message_show", methods={"GET"})
     */
    public function show(
        Message $message,
        BrokerRepository $brokerRepo,
        CustomerRepository $customerRepo,        
        SupplierRepository $supplierRepo): Response
    {

        $brokerSelection = $brokerRepo->findAll();
        $customerSelection = $customerRepo->findAll();
        $supplierSelection = $supplierRepo->findAll();
        
        $form = $this->createForm(MessageType::class,$message,
            array('brokerSelection'=>$brokerSelection,
                  'customerSelection'=>$customerSelection,
                  'supplierSelection'=>$supplierSelection));  

        return $this->render('message/show.html.twig' , [
            'message'=> $message,
            'form' => $form->createView(),
            'brokers'=>$message->getBrokers(),
            'customers'=>$message->getCustomers(),
            'suppliers'=>$message->getSuppliers()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="message_edit", methods={"GET","POST"})
     */
    public function edit(
        Request $request, 
        Message $message,  
        BrokerRepository $brokerRepo,        
        SupplierRepository $supplierRepo,
        CustomerRepository $customerRepo): Response
    {
        $broker_id = 0;
        $customer_id = 0;
        $supplier_id = 0;
        
        $broker = $brokerRepo->findOneBy(['name' => $message->getSentBy()]);
        if($broker){
            $broker_id = $broker->getId();
        }
        
        $customer = $customerRepo->findOneBy(['name' => $message->getSentBy()]);
        if($customer)
        {
            $customer_id = $customer->getId();
        }
              
        $supplier = $supplierRepo->findOneBy(['name' => $message->getSentBy()]);
        if($supplier)
        {
            $supplier_id = $supplier->getId();
        }   

        $brokerSelection = $brokerRepo->findWithoutName($message->getSentBy());     
        $len = count($brokerSelection);   
        for($i=0; $i<$len; $i++)
        {
           if($message->getBrokers()->contains($brokerSelection[$i]))
            {
                unset($brokerSelection[$i]);
            } 
        }

        $customerSelection = $customerRepo->findAll();
        $len = count($customerSelection); 
        for($i=0; $i<$len; $i++)
        {
            if($message->getCustomers()->contains($customerSelection[$i])){         
             unset($customerSelection[$i]);
            }
        }        

        $supplierSelection = $supplierRepo->findAll();
        $len = count($supplierSelection); 
        for($i=0; $i<$len; $i++)
        {
            if($message->getSuppliers()->contains($supplierSelection[$i])){
              unset($supplierSelection[$i]);
            }
        } 

        $form = $this->createForm(MessageType::class,$message,
                array('brokerSelection'=>$brokerSelection,
                      'customerSelection'=>$customerSelection,
                      'supplierSelection'=>$supplierSelection));  
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
      
            foreach($message->brokerSelection as $broker){
                $broker->addMessage($message);
                $message->addBroker($broker);
                $entityManager->persist($broker); 
            }          

            foreach($message->customerSelection as $customer){
                $customer->addMessage($message);
                $message->addCustomer($customer);
                $entityManager->persist($customer); 
            }
            foreach($message->supplierSelection as $supplier){
                $supplier->addMessage($message);
                $message->addSupplier($supplier);
                $entityManager->persist($supplier); 
            }
            
            $entityManager->persist($message);   
            $this->getDoctrine()->getManager()->flush();
            
            return $this->redirectToRoute('message_edit', array('id'=>$message->getId()));
        }

        return $this->render('message/edit.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
            'brokers'=> $message->getBrokers(),
            'suppliers'=> $message->getSuppliers(),
            'customers'=> $message->getCustomers(),
            'broker'=> $broker? $broker : null,
            'customer'=> $customer ? $customer : null,
            'supplier'=> $supplier ? $supplier : null,
            'edit_state'=>true,
            'fresh_state'=>false
        ]);
    }

    /**
     * @Route("/{message}/{customer}/edit", name="message_edit_customer", methods={"GET","POST"})
    */
    public function editCustomer(
        Request $request, 
        Message $message,  
        Customer $customer,
        BrokerRepository $brokerRepo,        
        SupplierRepository $supplierRepo,
        CustomerRepository $customerRepo): Response
    {
        $broker = $brokerRepo->findByName($message->getSentBy());        
        $brokerSelection = $brokerRepo->findWithoutName($message->getSentBy());                
        for($i=0; $i<count($brokerSelection); $i++)
        {
            if($message->getBrokers()->contains($brokerSelection[$i])){
              array_splice($brokerSelection, $i,1);
            }
        }
        
        $customerSelection = $customerRepo->findAll();
        for($i=0; $i<count($customerSelection); $i++)
        {
            if($message->getCustomers()->contains($customerSelection[$i])){         
             array_splice($customerSelection, $i,1);
            }
        }        

        $supplierSelection = $supplierRepo->findAll();
        for($i=0; $i<count($supplierSelection); $i++)
        {
            if($message->getSuppliers()->contains($supplierSelection[$i])){
              array_splice($supplierSelection, $i,1);
            }
        }

        $form = $this->createForm(MessageType::class,$message,
                array('brokerSelection'=>$brokerSelection,
                      'customerSelection'=>$customerSelection,
                      'supplierSelection'=>$supplierSelection));  
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $message = $form->getViewData();
                
            foreach($message->brokerSelection as $broker){
                $message->addBroker($broker);
            }
            foreach($message->customerSelection as $customer){
                $message->addCustomer($customer);
            }
            foreach($message->supplierSelection as $supplier){
                $message->addSupplier($supplier);
            }
                        
            $entityManager->persist($message);   
            $this->getDoctrine()->getManager()->flush();
            
            return $this->redirectToRoute('message_edit', array('id'=>$message->getId()));
        }

        return $this->render('message/edit.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
            'brokers'=> $message->getBrokers(),
            'suppliers'=> $message->getSuppliers(),
            'customers'=> $message->getCustomers(),
            'customer_id'=>$customer->getId()
        ]);
    }

    /**
     * @Route("/{message}/{supplier}/edit", name="message_edit_supplier", methods={"GET","POST"})
    */
    public function editSupplier(
        Request $request, 
        Message $message,  
        Supplier $supplier,
        BrokerRepository $brokerRepo,        
        SupplierRepository $supplierRepo,
        CustomerRepository $customerRepo): Response
    {
        $broker = $brokerRepo->findByName($message->getSentBy());        
        $brokerSelection = $brokerRepo->findWithoutName($message->getSentBy());                
        for($i=0; $i<count($brokerSelection); $i++)
        {
            if($message->getBrokers()->contains($brokerSelection[$i])){
              array_splice($brokerSelection, $i,1);
            }
        }
        
        $customerSelection = $customerRepo->findAll();
        for($i=0; $i<count($customerSelection); $i++)
        {
            if($message->getCustomers()->contains($customerSelection[$i])){         
             array_splice($customerSelection, $i,1);
            }
        }        

        $supplierSelection = $supplierRepo->findAll();
        for($i=0; $i<count($supplierSelection); $i++)
        {
            if($message->getSuppliers()->contains($supplierSelection[$i])){
              array_splice($supplierSelection, $i,1);
            }
        }

        $form = $this->createForm(MessageType::class,$message,
                array('brokerSelection'=>$brokerSelection,
                      'customerSelection'=>$customerSelection,
                      'supplierSelection'=>$supplierSelection));  
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $message = $form->getViewData();
                
            foreach($message->brokerSelection as $broker){
                $message->addBroker($broker);
            }
            foreach($message->customerSelection as $customer){
                $message->addCustomer($customer);
            }
            foreach($message->supplierSelection as $supplier){
                $message->addSupplier($supplier);
            }
                        
            $entityManager->persist($message);   
            $this->getDoctrine()->getManager()->flush();
            
            return $this->redirectToRoute('message_edit', array('id'=>$message->getId()));
        }

        return $this->render('message/edit.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
            'brokers'=> $message->getBrokers(),
            'suppliers'=> $message->getSuppliers(),
            'customers'=> $message->getCustomers(),
            'supplier_id'=>$supplier->getId()
        ]);
    }

    /**
     * @Route("/{id}", name="message_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Message $message): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('message_index');
    }

    /**
     * @Route("/{supplier}/edit", name="message_supplier", methods={"GET","POST"})
    */
    public function product( Request $request, Supplier $supplier)
    {
        $message = new Message();
        $message->setSentBy($customer->getName());
        $supplier->addMessage($message);

        $brokerSelection = $brokerRepo->findAll();
        $customerSelection = $customerRepo->findWithoutId($customer->getId());
        $supplierSelection = $supplierRepo->findAll();
            
        $form = $this->createForm(MessageType::class,$message,
            array('brokerSelection'=>$brokerSelection,
                    'customerSelection'=>$customerSelection,
                    'supplierSelection'=>$supplierSelection));  

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();           
            $entityManager->persist($supplier);
            $entityManager->flush();

            return $this->redirectToRoute('supplier_edit', array('id'=>$supplier->getId()));
        }

        return $this->render('message/new.html.twig' , [
            'message' => $message,
            'form' => $form->createView(),
            'brokers'=>$message->getBrokers(),
            'customers'=>$message->getCustomers(),
            'suppliers'=>$message->getSuppliers(),
            'supplier_id'=>$supplier->getId(),
            'fresh_state'=>true,
            'edit_state'=>true
        ]);
    }  

    /**
     * @Route("/remove/{message}/broker/{broker}", name="message_removeBroker", methods={"GET","POST"})
    */
    public function removeBroker(Message $message, Broker $broker): Response
    {
        $broker->removeMessage($message);        
        $message->removeBroker($broker);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($message);
        $entityManager->persist($broker);
        $entityManager->flush();
        return $this->redirectToRoute('message_edit', array('id'=>$message->getId()));
    }

    /**
     * @Route("/remove/{message}/customer/{customer}", name="message_removeCustomer", methods={"GET","POST"})
    */
    public function removeCustomer(Message $message, Customer $customer): Response
    {
        $message->removeCustomer($customer);        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($message);
        $entityManager->flush();
        return $this->redirectToRoute('customer_edit', array('id'=>$customer->getId()));
    }

    /**
     * @Route("/remove/{message}/supplier/{supplier}", name="message_removeSupplier", methods={"GET","POST"})
    */
    public function removeSupplier(Message $message, Supplier $supplier): Response
    {
        $message->removeSupplier($supplier);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($message);
        $entityManager->flush();
        return $this->redirectToRoute('supplier_edit', array('id'=>$supplier->getId()));
    }
}
