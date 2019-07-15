<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Service;
use App\Repository\ServiceRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\FloatType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\EmptityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\Entity\Employer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\EmployerRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use phpDocumentor\Reflection\Types\Null_;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;

class EmployersController extends AbstractController{
  
    /**
     * @Route("/", name="index")
     */
    public function index(){
        
        return $this->render('employers/index.html.twig', [
            'controller_name' => 'EmployersController',
        ]);
    }
    
      /**
     * @Route("/employers", name="employers")
     * @Route("/employers/{id}/edit", name="employers_edit")
     */
    public function employers(Employer $employer = Null, Request $request, ObjectManager $manager){
        if(!$employer){
             $employer= new Employer();
        }
        $form=$this->createFormBuilder($employer)
                    ->add('matricule',TextType::class,['attr'=> ['placeholder' => 'matricule']])
                    ->add('nom',TextType::class,['attr'=> ['placeholder' => 'nom complét']])
                    ->add('salaire',MoneyType::class,['attr'=> ['placeholder' => "Salaire de l'employer"]])
                    ->add('datenaiss',DateType::class,['widget'=>'single_text'])
                    ->add('service',EntityType::class, ['class' => Service::class,'choice_label' => 'libelle'])
                    ->getForm();
                $form->handleRequest($request);
                if($form->isSubmitted() && $form->isValid()){
                    $manager->persist($employer);
                    $manager->flush();
                }
         return $this->render('employers/employers.html.twig',[
             'formEmployer' =>$form->createView(),
             'modedit' =>$employer->getId()!== NULL
        ]);
       // return $this->redirectToRoute('lister_employers');
    }


    /**
     * @Route("/employers/lister_employers", name="lister_employers")
     */
    public function lister_employer()
    {
        $employers=$this->getDoctrine()->getRepository(Employer::class)->findAll();
      
        return $this->render('employers/lister_employers.html.twig', [
            
            'employers'=>$employers
        ]);

    }

    /**
     * @Route("/employers/lister_services", name="lister_services")
     */
    public function lister_service()
    {
        $services=$this->getDoctrine()->getRepository(Service::class)->findAll();
      
        return $this->render('employers/lister_service.html.twig', [
            
            'serives'=>$services
        ]);

    }

    /**
     *  @Route("/employers/{id}/supp", name="employers_supp")
     * @return Response
     */
    public function supp(Employer $employer)
    {
        $emp=$this->getDoctrine()->getManager();
        $emp->remove($employer);
        $emp->flush();
        //return  new Response("l'Employer a été supprimé");

        return $this->redirectToRoute('lister_employers');

    }
   



    /**
     * @Route("/employers/services", name="services")
     */
    public function services(Request $request, ObjectManager $manager){

        $service= new Service();
        $form=$this->createFormBuilder($service)
                    ->add('libelle',TextType::class,['attr'=> ['placeholder' => 'libellé service']])
                    ->getForm();
                $form->handleRequest($request);
                if($form->isSubmitted() && $form->isValid()){
                    $manager->persist($service);
                    $manager->flush();
                }
            return $this->render('employers/services.html.twig',['formService' =>$form->createView()]);
    }


}
