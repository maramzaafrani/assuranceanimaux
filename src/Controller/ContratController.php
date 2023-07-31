<?php

namespace App\Controller;
use App\Form\SearchCType;
use App\Entity\Contrat;
use App\Form\ContratType;
use App\Repository\ContratRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Options;
use Dompdf\Dompdf;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


#[Route('/contrat')]
class ContratController extends AbstractController
{

    #[Route('/stats',name:'app_contrat_stat')]
    public function stats(ContratRepository $repository,NormalizerInterface $Normalizer)
    {
        $contrats=$repository->countByDate();
        $dates=[];
        $contratsCount=[];
        foreach($contrats as $contrat){
            $dates[] = $contrat['datecontrat'];
            $contratsCount[] = $contrat['count'];
        }
        dump($contratsCount);
        return $this->render('contrat/stats.html.twig',[
            'dates' => json_encode($dates),
            'contratsCount' => json_encode($contratsCount),

        ]);
    }




    #[Route('/', name: 'app_contrat_index')]
    public function index(ContratRepository $contratRepository,Request $request,PaginatorInterface $paginator): Response
    {
        $query = $request->query->get('q');
        $contrats=$contratRepository->findAll(); 
        $pagination = $paginator->paginate($contrats,$request->query->getInt('page',1),2);
        $formSearch= $this->createForm(SearchCType::class); 
    $formSearch->handleRequest($request);
      if($formSearch->isSubmitted()){
        $nom= $formSearch->get('NomClient')->getData();
        $result= $contratRepository->search($nom);     // recherche
        return $this->renderForm('admin/Contrat.html.twig',
            array('contrats'=>$result,
              
                "searchForm"=>$formSearch));
                
    }
   
 return $this->renderForm('admin/Contrat.html.twig', [
     'contrats' => $pagination,  "searchForm"=>$formSearch,
 ]);

    
    {
        return $this->render('Admin/Contrat.html.twig', [
            'contrats' => $contratRepository->findAll(),
        ]);
    }
}

    #[Route('/new', name: 'app_contrat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ContratRepository $contratRepository): Response
    {
        $contrat = new Contrat();
        $form = $this->createForm(ContratType::class, $contrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $contratRepository->save($contrat, true);
            $contratRepository->sms();

            return $this->redirectToRoute('app_contrat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contrat/new.html.twig', [
            'contrat' => $contrat,
            'form' => $form,
        ]);
    }

    #[Route('/trie', name: 'trie')]
    public function trie(ContratRepository $contratRepository ,Request $request,PaginatorInterface $paginator)
    {
        $query = $request->query->get('q');
        $contrats=$contratRepository->Triepardate(); 
        $pagination = $paginator->paginate($contrats,$request->query->getInt('page',1),2);
        $formSearch= $this->createForm(SearchCType::class); 
    $formSearch->handleRequest($request);
      if($formSearch->isSubmitted()){
        $nom= $formSearch->get('NomClient')->getData();
        $result= $contratRepository->search($nom);     // recherche
        return $this->renderForm('admin/Contrat.html.twig',
            array('contrats'=>$result,
              
                "searchForm"=>$formSearch));
                
    }
   
 return $this->renderForm('admin/Contrat.html.twig', [
     'contrats' => $pagination,  "searchForm"=>$formSearch
 ]);

    
    {
        return $this->render('Admin/Contrat.html.twig', [
            'contrats' => $contratRepository->findAll(),
        ]);
    }
}
#[Route('/calendar', name: 'app_calendar')]
    public function index2(ContratRepository $repository): Response
    {
        $activiters= $repository->findAll();
        $emploit=[];
        foreach ($activiters as $activ){
            $emploit[]=[
                'id'=>$activ->getId(),
                'title'=> $activ->getNomClient(),
                'start'=> $activ->getDatededebut(),
                'end'=> $activ->getDatedefin(),
                'backgroundColor'=>$this->getRandomColor()
            ];
        }
        $data=json_encode($emploit);




        return $this->render('calendar/Calendar.html.twig',array("data"=>$data));
    }


    public function generateICalendarFile(ContratRepository $repository)
    {
        
        $activiters = $repository->findAll();

        $ics = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\n";
        $i=0;
        foreach ($activiters as $activ)
        {
            $i=$i+1;
            $id = $activ->getId();
            $titre = $activ->getNomClient();
            $dateDebut = $activ->getDatededebut();
            $dateFin = $activ->getDatedefin();
            $ics .= "Activiter num :".$i."\r\n";
            $ics .= "Date START:" . $dateDebut . "\r\n";
            $ics .= "Date END:" . $dateFin . "\r\n";
            $ics .= "UID:" . $id . "\r\n";
            $ics .= "SUMMARY:" . $titre . "\r\n";
            $ics .= "END:VEVENT\r\n";
        }


        $response = new Response($ics);
        $response->headers->set('bienvenue', 'Calendrier');


        return $response;
    }


    public function downloadCalendar(ContratRepository $repository)
    {
        $response = $this->generateICalendarFile($repository);

        return $response;
    }




    private function getRandomColor()
    {
        // Generate random values for the red, green, and blue components
        $r = mt_rand(100, 255);
        $g = mt_rand(100, 255);
        $b = mt_rand(100, 255);

        // Combine the red, green, and blue components into a hexadecimal color string
        $color = "#" . dechex($r) . dechex($g) . dechex($b);

        return $color;
    }
    #[Route('/{id}', name: 'app_contrat_show', methods: ['GET'])]
    public function show(Contrat $contrat): Response
    {
        return $this->render('contrat/show.html.twig', [
            'contrat' => $contrat,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contrat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contrat $contrat, ContratRepository $contratRepository): Response
    {
        $form = $this->createForm(ContratType::class, $contrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contratRepository->save($contrat, true);

            return $this->redirectToRoute('app_contrat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contrat/edit.html.twig', [
            'contrat' => $contrat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contrat_delete', methods: ['POST'])]
    public function delete(Request $request, Contrat $contrat, ContratRepository $contratRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contrat->getId(), $request->request->get('_token'))) {
            $contratRepository->remove($contrat, true);
        }

        return $this->redirectToRoute('app_contrat_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/contrat/data/download', name: 'users_data_download')]

    public function usersDataDownload(ContratRepository $contrat)
    {
        // On définit les options du PDF
        $pdfOptions = new Options();
        // Police par défaut
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);
    
        // On instancie Dompdf
        $dompdf = new Dompdf($pdfOptions);
        // $contrat= $contrat->findAll();
        $contrat = $contrat->findByidcontrat('3');
        // $classrooms= $this->getDoctrine()->getRepository(classroomRepository::class)->findAll();
    
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
        ]);
        $dompdf->setHttpContext($context);
    
        // On génère le html
        $html =$this->renderView('contrat/listp.html.twig',[
            'contrats'=>$contrat
        ]);
    
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        // On génère un nom de fichier
        $fichier = 'Liste-contrat' .'.pdf';
    
        // On envoie le PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => true
        ]);
    
        return new Response() ;
    }


   



   }

